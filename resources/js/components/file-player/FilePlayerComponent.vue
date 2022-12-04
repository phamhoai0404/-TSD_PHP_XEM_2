<template>
<div id="root" class="home" :stopFile="stopFlag">
    <canvas ref="canvas" id="the-canvas"></canvas>
</div>
</template>

<script>
let arrPDF = [];
import pdfjsLib from "pdfjs-dist/webpack";
import { downloadFiles } from "../../api/file";

export default {
    name: "fileplayer",
    data: () => ({
        microCode: window.location.href.substring(
            window.location.href.lastIndexOf("/") + 1
        ),
        lineId: null,
        timeoutId: null,
        stopFlag: false,
        currFile: 0,
        currPage: 0,
        socket: null,
        scale: 1.5,
        downloaded: false,
        interval: null
    }),
    mounted() {},
    watch: {
      downloaded() {
        if(this.downloaded) {
          this.socket.emit("downloadedEvent", this.microCode);
        }
      }
    },
    methods: {
        clear: function () {
            this.currFile = 0;
            this.currPage = 0;

            if (this.timeoutId) {
                clearTimeout(this.timeoutId);
                this.timeoutId = null;
            }
        },
        emitState: function () {
            this.socket.emit("updateStateEvent", {
                microCode: this.microCode,
                record: {
                    lineId: this.lineId,
                    currFile: this.currFile,
                    currPage: this.currPage,
                }
            });
        },
        startToRun: async function (iCurrFile, iCurrPage) {
            const pdfDocs = [];
            for (let fileCnt = 0; fileCnt < arrPDF.length; fileCnt++) {
                const pdfFile = await this.getPDFDoc(arrPDF[fileCnt].data);
                pdfDocs.push(pdfFile);
            }
            console.log(arrPDF.length);
            if (arrPDF.length == 1 && pdfDocs[0].numPages == 1) {
                this.currFile = 0;
                this.currPage = 1;
                console.log("pdfDocs[0].numPages", pdfDocs[0].numPages);
                await this.renderPage(pdfDocs[0], 1);
                this.emitState();
            } else {
                while (true) {
                    if (this.stopFlag) break;
                    for (let fileCnt = iCurrFile; fileCnt < arrPDF.length; fileCnt++) {
                        if (this.stopFlag) break;
                        this.currFile = fileCnt;
                        const pdfFile = pdfDocs[fileCnt];

                        const numPages = pdfFile.numPages;
                        // Trong trường hợp tắt tab đi và bật lại, thì phải hiển thị page hiện tại ngay lập tức
                        if (iCurrPage > 0) {
                            await this.displayPage(pdfFile, iCurrPage, 0);
                        }
                        for (let pageCnt = iCurrPage; pageCnt <= numPages; pageCnt++) {
                            if (this.stopFlag) break;
                            if (pageCnt < numPages) {
                                await this.displayPage(pdfFile, pageCnt + 1, arrPDF[fileCnt].times[pageCnt]);
                                this.currPage = pageCnt + 1;
                                this.emitState();
                            } else {
                                await this.displayPage(pdfFile, 0, arrPDF[fileCnt].times[pageCnt]);
                            }
                            if (this.stopFlag) break;
                        }
                        if (this.stopFlag) break;
                        // Sau khi kết thúc vòng lặp đầu tiên, sang file tiếp theo phải hiển thị từ trang đầu tiên
                        iCurrPage = 0;
                    }
                    if (this.stopFlag) break;
                    // Sau khi kết thúc vòng lặp đầu tiên, phải hiển thị từ file đầu tiên
                    iCurrFile = 0;
                }
            }
        },
        renderPage: async function (pdfDoc, num) {
            if (num > 0) {
                const { canvas } = this.$refs;
                const ctx = canvas.getContext("2d");
                // Using promise to fetch the page
                const page = await pdfDoc.getPage(num);
                // let unscaledViewport = page.getViewport(1);
                // this.scale = Math.min(window.innerHeight / unscaledViewport.height), (window.innerWidth / unscaledViewport.width);
                const viewport = page.getViewport(1);
                canvas.height = viewport.height;
                canvas.width = viewport.width;
                // Render PDF page into canvas context
                let renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };
                await page.render(renderContext);
                document.getElementById('the-canvas').style.width = window.innerWidth + 38 + 'px';
                document.getElementById('the-canvas').style.height = window.innerHeight + 38 + 'px';
                this.$nextTick(function () {
                    window.addEventListener('resize', () => {
                        document.getElementById('the-canvas').style.width = window.innerWidth + 38 + 'px';
                        document.getElementById('the-canvas').style.height = window.innerHeight + 38 + 'px';
                    })
                })
            } else {}
        },
        getPDFDoc: async function (data) {
            const bData = atob(data);
            const doc = await pdfjsLib.getDocument({
                data: bData
            });
            return doc;
        },
        displayPage: function (pdfDoc, pageNum, timeout) {
            return new Promise((resolve, reject) => {
                this.timeoutId = setTimeout(async () => {
                    await this.renderPage(pdfDoc, pageNum);
                    resolve();
                }, timeout * 1000);
            });
        },
    },
    created() {
        this.socket = io("ws://paperless.tvn:6969/micro-pc", {
            query: {
                microCode: window.location.href.substring(window.location.href.lastIndexOf("/") + 1)
            }
        });
        let _this = this;

        this.socket.on('connect_error', function (err) {
            console.log('Error connecting to server', err);
            _this.stopFlag = true;
            _this.downloaded = false;
            _this.clear();
        });
        this.socket.on('connect', function () {
            console.log('Client has connected to the server!');
            if (_this.downloaded) {
                _this.socket.emit("downloadedEvent", _this.microCode);
            }
        });
        this.socket.on( 'disconnect', function () {
            console.log("Client has disconnected. Reconnect!");
            setTimeout(() => {
                window.location.reload();
            }, 2000 );
        } );
        this.socket.on('resetArrPdf', () => {
            console.log("Received resetArrPdf event when all micro-pc stopped");
            let { canvas } = _this.$refs;
            canvas.width = 0;
            canvas.height = 0;
            arrPDF = [];
        });
        this.socket.on("updateSettingEvent", async function (microSettingRecord) {
            console.log("Received updateSettingEvent");
            console.log("microSettingRecord", microSettingRecord);
            if (!microSettingRecord || microSettingRecord.setting.length == 0) {
                console.log("!microSettingRecord || microSettingRecord.setting.length == 0");
                let { canvas } = _this.$refs;
                canvas.width = 0;
                canvas.height = 0;
                arrPDF = [];
                _this.socket.emit("downSuccess", Object.assign(microSettingRecord, {
                    'currentMicroPCId': _this.microCode
                }));
            } else {
                console.log("microSettingRecord.setting.length", microSettingRecord.setting.length);
                _this.lineId = microSettingRecord.lineId;
                const downloadEntries = [];
                for (let indexMicro = 0; indexMicro < microSettingRecord.setting.length; indexMicro++) {
                    let settingFileId = microSettingRecord.setting[indexMicro].fileId;
                    let settingTimes = microSettingRecord.setting[indexMicro].times;
                    let index = arrPDF.findIndex(pdf => pdf.fileId == settingFileId);
                    if (index >= 0) {
                        arrPDF[index].times = [0].concat(settingTimes);
                    } else {
                        downloadEntries.push({
                            arrPDFIndex: indexMicro,
                            fileId: settingFileId,
                            times: settingTimes,
                        });
                    }
                }
                const downloadPromises = downloadEntries.map(entry => new Promise(async (resolve, reject) => {
                    const {
                        arrPDFIndex,
                        fileId,
                        times
                    } = entry;
                    try {
                        const datapdf = await downloadFiles(fileId);
                        arrPDF.push({
                            data: datapdf,
                            fileId: fileId,
                            times: [0].concat(times)
                        });
                        resolve();
                    } catch (error) {
                        console.log("Download Error", error);
                        let FileError = {
                            lineId: microSettingRecord.lineId,
                            fileId: microSettingRecord.setting[arrPDFIndex].fileId,
                            err: error
                        };
                        reject(FileError);
                    }
                }));
                Promise.all(downloadPromises).then(() => {
                    _this.socket.emit("downloadedEvent", _this.microCode);
                    _this.downloaded = true;
                    let arrPDFTemp = [];
                    for (let i = 0; i < microSettingRecord.setting.length; i++) {
                        for (let j = 0; j < arrPDF.length; j++) {
                            if (microSettingRecord.setting[i].fileId == arrPDF[j].fileId) {
                                arrPDFTemp.push(arrPDF[j]);
                                break;
                            }
                        }
                    }
                    arrPDF = arrPDFTemp;
                    _this.socket.emit("downSuccess", Object.assign(microSettingRecord, {
                        'currentMicroPCId': _this.microCode
                    }));
                    console.log("downloaded", _this.downloaded);
                }).catch((err) => _this.socket.emit("downFileFalse", err));
            }
        });

        this.socket.on("playFileEvent", async latestState => {
            console.log("Received playEvent!");
            console.log("latestState", latestState);
            if (arrPDF.length == 0) return;
            _this.stopFlag = false;
            // Trường hợp đang chạy sẵn thì lấy trạng thái chạy file mới nhất lưu trong db
            if (latestState) {
                console.log(latestState);
                _this.lineId = latestState.record.lineId;
                _this.currFile = latestState.record.currFile;
                _this.currPage = latestState.record.currPage;
            } else {
                _this.clear();
            }
            // Bắt đầu chạy file
            await _this.startToRun(_this.currFile, _this.currPage);
        });
        this.socket.on("stopEvent", () => {
            console.log("Received stopEvent");
            _this.stopFlag = true;
            _this.downloaded = false;
            _this.clear();
            let { canvas } = _this.$refs;
            canvas.width = 0;
            canvas.height = 0;
        });
    }
};
</script>

<style>
canvas {
    display: block;
}

#the-canvas {
    margin-left: -19px !important;
    margin-top: -19px !important;
}
</style>
