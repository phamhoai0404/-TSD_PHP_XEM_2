<template>
    <div id="detailFile">
        <fieldset :style="{ height: outerFieldHeight + 'px'}">
            <div style="width: 98%; margin: 0 auto;">
                <v-btn :disabled='!infoFile.pageNum' @click="openPopup()" color="primary" style="width: 100%; text-transform: none; margin-left:0px;">
                    {{ $t('message.play_file.view_detail') }}
                </v-btn>
                <canvas id="canvas_sm" v-if="infoFile.pageNum" ref="canvas_sm"></canvas>
                <img id="img_canvas" v-else src="/img/model.png" style="width:100%" alt="avatar">
                <div class="infoFile">
                    <p>{{ $t('message.play_file.customer') }}: <span>{{ infoFile.customer }}</span> </p>
                    <p>{{ $t('message.play_file.model') }}: <span>{{ infoFile.model }}</span></p>
                    <p>{{ $t('message.play_file.department') }}: <span>{{ infoFile.depCode }}</span></p>
                    - - -
                    <p style="white-space: nowrap;">{{ $t('message.play_file.name') }}: <span style="white-space: nowrap;">{{ infoFile.fileName }}</span> </p>
                    <p>{{ $t('message.play_file.size') }}: <span>{{ infoFile.size }}</span></p>
                    <p>{{ $t('message.play_file.page_number') }}: <span>{{ infoFile.pageNumber }}/{{ infoFile.pageNum }}</span></p>
                </div>
            </div>
            <v-dialog
            v-model="dialogPopup"
            width="100%"
            >
                <v-zoomer style="width:1850px; height: 1200px; margin: 0 auto;">
                    <canvas style="width: 100%;" id="canvas" ref="canvas"></canvas>
                </v-zoomer>
            </v-dialog>
            <download-file-error v-if="dialogFileError.showFileError" @close="dialogFileError.showFileError=false">
                <h3 slot="error" class="red--text">{{ dialogFileError.error }}</h3>
                <p class="blue--text" slot="file">{{ dialogFileError.fileError }}</p>
            </download-file-error>
        </fieldset>
    </div>
</template>
<script>
import pdfjsLib from "pdfjs-dist/webpack";
import { DisplayFile } from "../../api/playfile";
import DownloadFileError from "./DownloadFileErrorComponent";
import { mapActions } from 'vuex';
export default {
    data() {
        return {
            dialogPopup: false,
            dataPDF: {},
            outerFieldHeight: 0,
            dialogFileError: {
                fileError: null,
                showFileError: false,
                error: {}
            }
        }
    },
    components: {
        'download-file-error': DownloadFileError
    },
    computed: {
        enablePopupView() {
            return this.$store.state.enablePopupView;
        },
        infoFile() {
            return this.$store.state.infoFile;
        },
    },
    watch: {
        infoFile() {
            if(this.infoFile.id) {
                this.DisplayFilePDF(this.infoFile.id);
            }
        }
    },
    methods: {
        ...mapActions(['destroyinfoFile']),
        openPopup () {
            this.dialogPopup = true;
        },
        async getPDFDoc(data) {
            const bData = await atob(data);
            const doc = await pdfjsLib.getDocument({ data: bData });
            return doc;
        },
        async renderPage(num) {
            const pdfFile = await this.getPDFDoc(this.dataPDF);
            const scale = 0.5;
            let canvas = this.$refs.canvas;
            let canvas_sm = this.$refs.canvas_sm;
            const context = canvas.getContext("2d");
            const context_sm = canvas_sm.getContext("2d");
            // Using promise to fetch the page
            const page = await pdfFile.getPage(num);
            const viewport = page.getViewport(2.3);
            canvas.height = viewport.height;
            canvas.width = viewport.width;
            canvas_sm.height = viewport.height;
            canvas_sm.width = viewport.width;
            // Render PDF page into canvas context
            var renderContext = {
                canvasContext: context,
                viewport: viewport
            };
            
            var renderContext_sm = {
                canvasContext: context_sm,
                viewport: viewport
            };
            Promise.all([page.render(renderContext), page.render(renderContext_sm)]).then(values => { 
                this.stopSpinner();
                document.getElementById('canvas').style.height = window.innerHeight - 60 + 'px';
            });
        },
        DisplayFilePDF (id) {
            DisplayFile(id)
            .then(response => {
                this.dataPDF = response;
                this.renderPage(this.$store.state.infoFile.pageNumber)
            }).catch( err => {
                console.log('error', err);
                this.downloadFileError(err);
            })
        },
        downloadFileError (error) {
            this.stopSpinner();
            this.dialogFileError.error = error.error_code;
            this.dialogFileError.fileError = this.infoFile.fileName;
            this.dialogFileError.showFileError = true;
            this.destroyinfoFile();
        },
        resizeEventHandler() {
            this.outerFieldHeight = window.innerHeight - 140;
        }
    },
    created() {
        this.resizeEventHandler();
        window.addEventListener("resize", this.resizeEventHandler);
    },
    destroyed() {
        window.removeEventListener("resize", this.resizeEventHandler);
    },
    updated() {
        this.resizeEventHandler();
    }
}
</script>
<style>
    #detailFile .infoFile {
        margin: 8px;
    }
    #detailFile .infoFile p{
        margin-bottom: 4px;
        font-size: 13px;
    }
    #detailFile .infoFile p span{
        font-size: 11px;
    }
    #canvas {
        width: 100% !important;
        margin-top: 50px !important;
    }
    #canvas_sm {
        width: 100% !important;
        height: 200px !important;
    }
    .v-dialog{
        box-shadow: 0px 0px !important;
        overflow-y: hidden !important;
    }
    .v-dialog:not(.v-dialog--fullscreen) {
        max-height: 100%;
    }
</style>