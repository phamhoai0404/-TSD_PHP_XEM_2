<template>
    <div id="list-microPC">
        <v-layout xs12>
            <fieldset :style="{ height: outerFieldHeight + 'px'}">
                <legend>{{ $t('message.play_file.list_micro_pc') }}</legend>
                <div style="width: 98%; margin: 0 auto; margin-top: 10px;">
                    <v-layout row>
                        <span style="margin-right: 20px; padding-top: 15px">{{ $t('message.play_file.time_default') }}</span>
                        <v-flex xs1>
                            <v-text-field v-model="time_default" :disabled="btn_setting" height="1" id="number_time" solo style="width: 50px; margin-top: 10px;"></v-text-field>
                        </v-flex>
                        <v-btn  @click="settingTimeDefault(time_default, line.id)" color="success" small style="margin-top: 11px;" :disabled="btn_setting">{{ $t('message.play_file.setting') }}</v-btn>
                        <v-checkbox @change="changeSettingKey()" :disabled="!hasLineId" v-model="setting_key" :label="$t('message.play_file.setting_key')" style="margin-top: 6px"></v-checkbox>
                    </v-layout>
                    <v-layout row>
                        <v-flex xs5>
                            <v-layout row>
                                <v-flex xs3 style="margin-top: 6px;">
                                  {{ $t('message.play_file.department') }}
                                </v-flex>
                                <v-flex xs9>
                                    <v-select
                                    style="margin-top: 0px; padding-top: 0px;"
                                    :items="departments"
                                    item-value='id'
                                    item-text='depCode'
                                    :menu-props="{ nudgeTop: -8, offsetY: ''}"
                                    v-model="depId"
                                    @change="changeDepartment"
                                    :disabled="isRoleLine"
                                    ></v-select>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                        <v-flex xs5 style="margin-left: 30px;">
                            <v-layout row>
                                <v-flex xs2 style="margin-top: 6px;">
                                  {{ $t('message.play_file.line') }}
                                </v-flex>
                                <v-flex xs9>
                                    <v-select
                                    style="margin-top: 0px; padding-top: 0px;"
                                    :items="lines"
                                    item-value='id'
                                    v-model="line.id"
                                    item-text='lineCode'
                                    :menu-props="{ nudgeTop: -8, offsetY: ''}"
                                    @change="changeLine"
                                    :disabled="!depId"></v-select>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                    </v-layout>
                </div>
                <v-flex xs12 id="table_play_file" ref="table_play_file">
                    <v-data-table
                        :style="{ height: tableHeight + 'px', width: tableWidth + 'px'}"
                        :headers="headers"
                        :items="microPC"
                        class="list-micropc"
                        id="table-tree"
                        hide-actions>
                        <template slot="headers">
                            <th style="padding: 0px 5px; width: 50px;" v-if="!disableByLockSetting && !disableWhenMicroOnNull">
                                <v-btn @click="startAllMicroPC()" v-if="(!isRunningLine)" :disabled="!isRunningLine && !setting_key || !hasLineId" color="primary" small class='text-capitalize'>
                                    {{ $t('message.play_file.header_microPC.start_all') }}
                                </v-btn>
                                <v-btn @click="stopAllMicroPC()" :disabled="!setting_key" v-else color="primary" small class='text-capitalize'>
                                    {{ $t('message.play_file.header_microPC.stop_all') }}
                                </v-btn>
                            </th>
                            <th style="padding: 0px 5px; width: 50px;" v-else>
                                <v-btn v-if="(!isRunningLine)" disabled  small class='text-capitalize'>
                                    {{ $t('message.play_file.header_microPC.start_all') }}
                                </v-btn>
                                <v-btn disabled v-else small class='text-capitalize'>
                                    {{ $t('message.play_file.header_microPC.stop_all') }}
                                </v-btn>
                            </th>
                            <th style="padding:0px; width: 100px;">
                                {{ $t('message.play_file.header_microPC.microPC') }}
                            </th>
                            <th style="padding:0px !important; min-width: 470px;" id="fileHeader">
                                <sl-vue-tree
                                v-model="fileHeader"
                                style="padding: 10px 0px 0px 0px; position: relative;">
                                    <template slot="title" slot-scope="{ node }">
                                        <v-layout row class="file">
                                            <v-spacer></v-spacer>
                                            <v-layout row style="padding-left: 5px; position: relative;">
                                                <div style="margin: auto;">
                                                    <span style="margin-top: 5px;
                                                    font-size: 13px;
                                                    color: black;
                                                    text-align: center;">
                                                    {{ node.title }}
                                                    </span>
                                                </div>
                                            </v-layout>
                                            <v-spacer></v-spacer>
                                            <v-layout row v-if="node.isLeaf" style='border-left: 1px solid #000;'>
                                                <span class="page">
                                                    <p class="play">
                                                        <v-btn small disabled style="padding: 3px 6px; min-width: 50px; margin: 0px; height: 38px;">{{ $t('message.play_file.header_microPC.p') }}</v-btn>
                                                    </p>
                                                </span>
                                                <span class="stime">
                                                    <p class="play">
                                                        <v-btn small disabled style="padding: 3px 6px; min-width: 50px; margin: 0px; height: 38px;">{{ $t('message.play_file.header_microPC.s_time') }}</v-btn>
                                                    </p>
                                                </span>
                                            </v-layout>
                                        </v-layout>
                                    </template>
                                </sl-vue-tree>
                            </th>
                        </template>
                        <template v-slot:items="drops">
                            <td style="padding: 0px 5px;" v-if="!disableByLockSetting">
                                <v-btn
                                :class="drops.item.microCode"
                                @click="startMicroPc(drops.index)"
                                v-if="!microPC[drops.index].started"
                                :disabled="!setting_key || (!microPC[drops.index].online && !microPC[drops.index].isRunning) "
                                color="primary" small class='text-capitalize'>
                                    {{ $t('message.play_file.start') }}
                                </v-btn>
                                <v-btn
                                :disabled="!setting_key || (!microPC[drops.index].online && !microPC[drops.index].isRunning)"
                                @click="stopMicroPc(drops.index)"
                                v-else color="primary"
                                small class='text-capitalize'>
                                    {{ $t('message.play_file.stop') }}
                                </v-btn>
                            </td>
                            <td style="padding: 0px 5px;" v-else>
                                <v-btn v-if="!microPC[drops.index].started"  disabled small class='text-capitalize'> {{ $t('message.play_file.start') }} </v-btn>
                                <v-btn disabled small class='text-capitalize' v-else> {{ $t('message.play_file.stop') }} </v-btn>
                            </td>
                            <td :id="drops.item.microCode" :class="['microCode', drops.item.online ? 'green--text' : 'red--text']">{{ drops.item.microCode }}</td>
                            <td  style="padding:0px !important;" @dragover="dragOverHandler(drops.index)" :id="'microPc' + drops.item.microCode" class="fileOfMicro">
                                <sl-vue-tree
                                :ref="drops.index"
                                @select="nodeSelected"
                                @input="indexTree(drops.index)"
                                @externaldrop="onExternalDropHandler(indexMicro, line.id, fileSelected )"
                                style="padding: 10px 0px 0px 0px; position: relative;" v-model="drops.item.file">
                                    <template slot="draginfo">
                                        <span style="margin: auto">
                                            <span style="font-size: 16px;">{{ nodeDragged }}</span>
                                        </span>
                                    </template>
                                    <template slot="title" slot-scope="{ node }">
                                        <v-layout row @mousemove="onMousemoveHandler" :class=" checkFileRunning(drops.index, node.ind) ? 'orange lighten-3' : 'white'">
                                            <v-layout row style="padding-left: 5px; position: relative;">
                                                <icon v-if="node.title==''" style="color: #7B1F32; margin-top: 9px;" name="plus-square"></icon>
                                                <span v-if="node.title==''"
                                                style="margin-top: 5px;
                                                font-size: 14px;
                                                color: #7B1F32;
                                                padding-left: 3px;">
                                                    {{ $t('message.play_file.drag') }} !
                                                </span>
                                                <div style="margin: auto;">
                                                    <icon style="color: #689F38; margin-top: 9px; width: 11px; padding-top: 3px;" name="file" v-if="node.isLeaf && node.title"></icon>
                                                    <span style="margin-top: 5px;
                                                    font-size: 13px;
                                                    padding-left: 1px;">
                                                    {{ node.title }}
                                                    </span>
                                                </div>
                                            </v-layout>
                                            <v-spacer></v-spacer>
                                            <v-icon style="margin: auto 0;" v-if="node.title!=''" size="16" color="red" :disabled="microPC[drops.index].started || setting_key" @click="removeFile(drops.index, node, line.id)">close</v-icon>
                                            <v-layout row v-if="node.isLeaf && node.title" style='border-left: 1px solid #000;  background: #fff;'>
                                                <span class="page">
                                                    <p 
                                                    v-for="(p, index) in drops.item.file[node.ind].s_time" 
                                                    :key="'p'+index" 
                                                    :class="checkPageRunning(drops.index, node.ind, index) ? 'orange lighten-3' : 'white'">
                                                        <v-btn :disabled="!disable_page" @click="btnPageClick(microPC[drops.index].file[node.ind], (index+1))" small color="info" style="padding: 3px 6px; min-width: 50px; margin: 0px; height: 34px;">{{ index + 1 }}</v-btn>
                                                    </p>
                                                </span>
                                                <span class="stime">
                                                    <p 
                                                    v-for="(s, index) in drops.item.file[node.ind].s_time" 
                                                    :key="'s'+index" 
                                                    :class="checkPageRunning(drops.index, node.ind, index) ? 'orange lighten-3' : 'white'">
                                                        <v-text-field :disabled="btn_setting" v-model.number="microPC[drops.index].file[node.ind].s_time[index]" :value='s' solo style="width: 50px;  height:34px;"></v-text-field>
                                                    </p>
                                                </span>
                                            </v-layout>
                                        </v-layout>
                                    </template>
                                </sl-vue-tree>
                            </td>
                        </template>
                        <template v-slot:no-data>
                            <td colspan="3" class="text-xs-center">{{ $t('message.no_data_table') }}</td>
                        </template>
                    </v-data-table>
                </v-flex>
                <v-dialog v-model="dialogWarning" width="480" >
                    <v-card>
                        <v-card-title class="headline grey lighten-2" primary-title><span class="text-xs-center" style="margin: 0 auto;">{{ $t('message.play_file.warning') }}</span></v-card-title>
                        <v-card-text class="text-xs-center"> {{ line.lockByUser }}  {{ $t('message.play_file.disabledScreen') }} </v-card-text>
                        <v-divider></v-divider>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn  color="primary" flat @click="dialogWarning = false">
                                {{ $t('message.play_file.close') }}
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </fieldset>
        </v-layout>
        <download-file-error v-if="showFileError" @close="showFileError=false">
            <h3 slot="error" class="red--text">{{ error}}</h3>
            <p class="blue--text" slot="file">{{ fileError }}</p>
        </download-file-error>
    </div>
</template>
<script>
    import {PAPERLESS_CONST} from '../../constant'
    import { getLinesByUserId, getLinesByDepId, getInfoLine, getMicroByLineId, updateIsRunningForLine, updateCheckedForLine } from  '../../api/line'
    import { updateIsRunningForMicroPC } from "../../api/micro_pc";
    import { updateOrCreatePlaylists, deletePlaylists } from "../../api/playfile";
    import { getDepartments, getDepWidthRoleLine } from  '../../api/department'
    import { getCurrentUser } from  '../../api/user'
    import { mapState, mapActions } from 'vuex';
    import { getTimeDefault } from "../../api/setting";
    import DownloadFileError from "./DownloadFileErrorComponent";
    export default {
        components: {
            'download-file-error': DownloadFileError
        },
        data() {
            return {
                lines: [],
                line: { isRunning: 1 },
                user: {},
                departments: [],
                time_default: 0,
                depId: null,
                jsonFile: { filesId: []},
                setting_key: false,
                fileHeader: [{title: this.$t('message.play_file.header_microPC.file'), isLeaf: true}],
                indexMicro: '',
                indexMicroDrag: null,
                btn_setting: false,
                fileSelected: {},
                tableHeight: 0,
                tableWidth: 0,
                outerFieldHeight: 0,
                nodeDragged: '',
                isRoleLine: false,
                headers: [],
                microPC: [],
                socket : io("ws://paperless.tvn:6969/admin"),
                dialogWarning: false,
                disableByLockSetting: false,
                disableWhenMicroOnNull: false,
                downloadedMicroPCIds: [],
                microOnlineOnSystem: [],
                numberMicroOnLine: 0,
                fileError: null,
                showFileError: false,
                error: {},
                disable_page: false
            }
        },
        props: {
            dataFile: {
                type: Object,
                default: () => {
                    return {};
                }
            },
            drawer: {
                type: Boolean,
                dafault: false
            }
        },
        computed: {
            isRunningLine() {
                return this.line.isRunning == 1;
            },
            hasLineId() {
                return this.line.id ? true : false;
            }
        },
        watch: {
            dataFile() {
                this.fileSelected = this.dataFile;
            },
            microOnlineOnSystem() {
                this.getMicroPcOnlines();
            },
            drawer() {
                this.disableBtnPage();
            }
        },
        methods: {
            ...mapActions(['destroyinfoFile']),
            disableBtnPage() {
                this.disable_page = this.drawer;
            },
            checkFileRunning(indexMicro, indexFile) {
                return ((this.microPC[indexMicro].started
                            && this.microPC[indexMicro]['online'])
                        && (this.microPC[indexMicro].file[indexFile]['running']
                            || (this.microPC[indexMicro].file.length == 1
                                && this.microPC[indexMicro].file[0].s_time
                                && this.microPC[indexMicro].file[0].s_time.length == 1)))
            },
            checkPageRunning(indexMicro, indexFile, indexPage) {
                return ((this.microPC[indexMicro].started
                            && this.microPC[indexMicro]['online']) 
                        && ((this.microPC[indexMicro].file[indexFile].pageRunning[indexPage])
                            || (this.microPC[indexMicro].file.length == 1
                                && this.microPC[indexMicro].file[0].s_time
                                && this.microPC[indexMicro].file[0].s_time.length == 1)));
            },
            resizeEventHandler() {
                this.tableHeight = (window.innerHeight - 165- 115);
                const divInnerTable = document.getElementById("table_play_file");
                this.tableWidth = divInnerTable.offsetWidth - 5;
                document.querySelector('.v-table__overflow').style.height = this.tableHeight + 'px';
                this.outerFieldHeight = window.innerHeight - 130;
            },
            removeFile(index, node, lineId) {
                this.microPC[index].file.splice(node.ind, 1);
                let fileEmpty = [];
                if(this.microPC[index].file.length == 0) {
                    this.microPC[index].file.push(
                        {
                            title: '',
                            isLeaf: true
                        }
                    )
                }
                for( let i=0; i < this.microPC.length; i++) {
                    if(this.microPC[i].file[0].title =='') {
                        fileEmpty.push(this.microPC[i].file[0].title == '');
                    }
                }
                if(fileEmpty.length == this.microPC.length) {
                    this.btn_setting = true;
                }
            },
            dragOverHandler(index) {
                this.indexMicro = index;
            },
            onMousemoveHandler (event) {
                if((this.microPC[this.indexMicroDrag])
                && (this.microPC[this.indexMicroDrag].started
                    || this.setting_key
                    || this.microPC[this.indexMicroDrag].isRunning
                    || this.microPC[this.indexMicroDrag].file[0].title ==''))
                {
                    this.nodeDragged = '';
                    event.stopPropagation();
                }
            },
            indexTree(index) {
                this.indexMicroDrag = index;
            },
            setFile() {
                this.fileSelected = this.dataFile
            },
            nodeSelected (nodes, e) {
                this.nodeDragged = nodes[0].title
            },
            onExternalDropHandler(indexMicro, lineId, fileSelected) {
                if(this.microPC[indexMicro].started || this.setting_key || this.microPC[indexMicro].isRunning) {
                    return false;
                }
                for (let index=0; index < this.microPC[indexMicro].file.length; index++) {
                    if(this.microPC[indexMicro].file[index].title == fileSelected.name) {
                        return false;
                    }
                }
                let lastCursorPostition = {
                    node: {
                        ind: this.microPC[indexMicro].file.length - 1,
                        path: [this.microPC[indexMicro].file.length - 1]
                    },
                    placement: 'after'
                };
                let sTime = [];
                let pageRunning = [];
                for(let index = 0; index < fileSelected.pageNum; index++) {
                    sTime[index] = parseInt(this.time_default);
                    pageRunning.push(false);
                }
                this.$refs[indexMicro].insert(lastCursorPostition,
                                            {
                                                title: fileSelected.name,
                                                fileName: fileSelected.name,
                                                isLeaf: true,
                                                s_time: sTime,
                                                pageNum: fileSelected.pageNum,
                                                depCode: fileSelected.depCode,
                                                customer: fileSelected.customer,
                                                model: fileSelected.model,
                                                size: fileSelected.size,
                                                id: fileSelected.id,
                                                pageRunning: pageRunning
                                            });
                if(this.microPC[indexMicro].file.length > 0)
                {
                    if(this.microPC[indexMicro].file && this.microPC[indexMicro].file[0].title =='') {
                        this.microPC[indexMicro].file.splice(0, 1);
                    }
                    else if(this.microPC[indexMicro].file && this.microPC[indexMicro].file[1].title =='') {
                        this.microPC[indexMicro].file.splice(1, 1);
                    }
                }
                this.btn_setting = false;
            },
            fetchTimeDefault () {
                getTimeDefault()
                .then(response => {
                    this.time_default = response;
                }).catch( err => {
                    console.log(err);
                });
            },
            getDepartmentWidthRoleLine (depId) {
                getDepWidthRoleLine(depId)
                .then(response => {
                    this.departments.push(response);
                }).catch( err => {
                    console.log(err);
                }).finally(() => {
                    this.stopSpinner();
                });
            },
            getDepartmentsForAdmin () {
                getDepartments()
                .then(response => {
                    this.departments = response;
                }).catch( err => {
                    console.log(err);
                }).finally(() => {
                    this.stopSpinner();
                });
            },
            fetchDepartments(depId){
                if(Roles == PAPERLESS_CONST.roles.line) {
                    this.getDepartmentWidthRoleLine(depId);
                    this.isRoleLine = true;
                    this.depId = depId;
                }
                if(Roles == PAPERLESS_CONST.roles.admin) {
                    this.getDepartmentsForAdmin();
                }
            },
            fetchLinesByUserId(userId) {
                if(Roles == PAPERLESS_CONST.roles.line) {
                    getLinesByUserId(userId)
                    .then(response => {
                        this.lines = response;
                    }).catch( err => {
                        console.log(err);
                    })
                }
            },
            fetchLinesByDepId(depId) {
                if(Roles == PAPERLESS_CONST.roles.admin) {
                    getLinesByDepId(depId)
                    .then(response => {
                        for (let i = 0; i < response.length; i++){
                            let array = response[i];
                            for(let j = 0; j < array.length; j++) {
                                this.lines.push(array[j]);
                            }
                        }
                    }).catch( err => {
                        console.log(err);
                    }).finally(() => {
                        this.stopSpinner();
                    });
                }
            },
            getCurUser : function () {
                let _this = this;
                getCurrentUser()
                   .then(response => {
                       this.user = response;
                       this.fetchDepartments(response.depId);
                       this.fetchLinesByUserId(response.id);
                   })
                   .catch(err => {
                        console.log(err);
                    })
            },
            btnPageClick(dataFile, page) {
                this.startSpinner();
                dataFile['pageNumber'] = page;
                this.$store.state.enablePopupView = true;
                this.$store.state.infoFile = dataFile;
            },
            changeDepartment(depId) {
                this.destroyinfoFile();
                this.startSpinner();
                this.lines = [];
                this.line = {};
                this.microPC = [];
                this.fetchLinesByDepId(depId);
            },
            changeLine(value) {
                this.startSpinner();
                this.destroyinfoFile();
                getInfoLine(value)
                .then(response => {
                    this.line = response;
                    this.setting_key = response.isSetting;
                    response.isSetting ? this.btn_setting = true : this.btn_setting = false;
                    if(response.lockByUser && response.lockByUser != this.user.userCode) {
                        this.dialogWarning = true;
                        this.disableByLockSetting = true;
                    } else {
                        this.disableByLockSetting = false;
                    }
                }).catch( err => {
                    console.log(err);
                })

                this.getAllMicroByLineId(value);
            },
            getAllMicroByLineId(id) {
                getMicroByLineId(id)
                .then(response => {
                    this.microPC = response;
                    this.socket.emit('listMicro', this.listMicroPc());
                    this.getMicroPcOnlines();
                    for(let indexMicro= 0; indexMicro < this.microPC.length; indexMicro++) {
                        this.microPC[indexMicro]['started'] = this.microPC[indexMicro].isRunning;
                        if(this.microPC[indexMicro].file){
                            for(let indexFile = 0; indexFile < this.microPC[indexMicro].file.length; indexFile++) {
                                this.microPC[indexMicro].file[indexFile]["running"] = false;
                                this.microPC[indexMicro].file[indexFile]['isLeaf'] = true;
                                this.microPC[indexMicro].file[indexFile]['title'] = this.microPC[indexMicro].file[indexFile].fileName;
                                let setting = JSON.parse(this.microPC[indexMicro].playfile.setting);
                                this.microPC[indexMicro].file[indexFile]['s_time'] = setting[indexFile].config;
                                let pageRunning = [];
                                for(let indexStime = 0; indexStime < this.microPC[indexMicro].file[indexFile]['s_time'].length; indexStime++) {
                                    pageRunning.push(false);
                                }
                                this.microPC[indexMicro].file[indexFile]['pageRunning'] = pageRunning;
                            }
                        } else {
                            this.microPC[indexMicro]['file'] = [
                                {
                                    title: '',
                                    isLeaf: true
                                }
                            ]
                        }
                    }
                    this.$nextTick(() => {
                        this.getMicroPcOnlines();
                    })
                }).catch(err => {
                    console.log(err);
                }).finally(() => {
                    this.stopSpinner();
                });
            },
            listMicroPc() {
                let microCodes = [];
                for (let indexMicro = 0; indexMicro < this.microPC.length; indexMicro++){
                    if((this.microPC[indexMicro].file && this.microPC[indexMicro].file[0])
                        && (this.microPC[indexMicro].file.length > 1 
                        ||(this.microPC[indexMicro].file.length == 1 && this.microPC[indexMicro].file[0].pageNum > 1)))
                    {
                        microCodes.push(this.microPC[indexMicro].microCode);
                    }
                }
                return microCodes;
            },
            settingTimeDefault(time, lineId) {
                for(let indexMicro = 0; indexMicro < this.microPC.length; indexMicro++) {
                    this.microPC[indexMicro].file.map(file => {
                        if(file.s_time) {
                            file.s_time.fill(parseInt(time));
                        }
                    });
                    this.$set(this.microPC, indexMicro, this.microPC[indexMicro]);
                }
            },
            changeSettingKey() {
                this.btn_setting = this.setting_key;
                if(this.numberMicroOnLine > 0) {
                    this.startSpinner();
                }
                getInfoLine(this.line.id)
                .then(response => {
                    this.line = response;
                    let CheckOld = !this.setting_key;
                    let CheckDatabaseOld = this.line.isSetting;
                    if(CheckDatabaseOld && !CheckOld) {
                        this.stopSpinner();
                        this.dialogWarning = true;
                        this.disableByLockSetting = true;
                        this.getAllMicroByLineId(this.line.id);
                    } else if(!CheckDatabaseOld && !CheckOld) {
                        if(response.lockByUser == '' || response.lockByUser == null || response.lockByUser == this.user.userCode) {
                            this.socket.emit('listMicro', this.listMicroPc());
                            this.downloadedMicroPCIds = [];
                            this.disableByLockSetting = false;
                            this.updateLineChecked({ 'isChecked': true });
                            this.updateOrCreatePlaylistsCheckSetting();
                            let valueSettingEmit = [];
                            for(let indexMicro = 0; indexMicro < this.microPC.length; indexMicro++) {
                                let setting = [];
                                if(this.microPC[indexMicro].file) {
                                    for(let indexFile =0; indexFile < this.microPC[indexMicro].file.length; indexFile++) {
                                        if(this.microPC[indexMicro].file[0].title) {
                                            setting.push({'fileId': this.microPC[indexMicro].file[indexFile].id, 'times': this.microPC[indexMicro].file[indexFile].s_time })
                                        }
                                    }
                                    for(let indexMicroOnLine = 0; indexMicroOnLine < this.microOnlineOnSystem.length; indexMicroOnLine++ ) {
                                        if(this.microPC[indexMicro].microCode == this.microOnlineOnSystem[indexMicroOnLine].microCode) {
                                            valueSettingEmit.push({ "microCode": this.microPC[indexMicro].microCode, "record": {'lineId':this.line.id, 'setting':setting} } )
                                        }
                                    }
                                }
                            }
                            if(valueSettingEmit.length == 0) {
                                this.socket.emit("updateSettingEvent", { 'lineId': this.line.id });
                            } else {
                                this.socket.emit("updateSettingEvent", valueSettingEmit);
                            }
                        }
                    }
                    else if(CheckDatabaseOld && CheckOld) {
                        if(!response.lockByUser || response.lockByUser == this.user.userCode) {
                            this.updateLineChecked({ 'isChecked': false });
                            this.disableByLockSetting = false;
                        } else {
                            this.dialogWarning = true;
                            this.disableByLockSetting = true;
                            this.getAllMicroByLineId(this.line.id);
                        }
                        this.stopSpinner();
                    }
                }).catch( err => {
                    console.log(err);
                })
            },
            updateLineChecked(isChecked) {
                if(this.line.id) {
                    updateCheckedForLine(this.line.id, isChecked)
                    .catch(error => {
                        console.log(error)
                    })
                }
            },
            updateOrCreatePlaylistsCheckSetting() {
                if(this.microPC.length > 0) {
                    updateOrCreatePlaylists(this.microPC)
                    .catch(error => {
                        console.log(error)
                    })
                }
            },
            updateIsRunningMicro(data) {
                updateIsRunningForMicroPC(data)
                .catch(error => {
                    console.log(error)
                })
            },
            updateIsRunningLine(lineId, data) {
                updateIsRunningForLine(lineId, data)
                .catch(error => {
                    console.log(error)
                })
            },
            deletePlaylistsWhenStopMicroPC() {
                deletePlaylists(this.microPC)
                .catch(error => {
                    console.log(error)
                })
            },
            startAllMicroPC() {
                let microCodes = [];
                this.line.isRunning = 1;
                for (let indexMicro = 0; indexMicro < this.microPC.length; indexMicro++){
                    if(this.microPC[indexMicro].online  && !this.microPC[indexMicro].started) {
                        microCodes.push(this.microPC[indexMicro].microCode);
                        this.microPC[indexMicro].isRunning = 1;
                        this.microPC[indexMicro].started = true;
                        this.$set(this.microPC, indexMicro, this.microPC[indexMicro]);
                    }
                }
                this.socket.emit("startAll", microCodes);
                this.updateIsRunningMicro({ 'isRunning': true, 'microCodes': microCodes });
                this.updateIsRunningLine(this.line.id, { 'isRunning': true })
            },
            startMicroPc(index) {
                this.microPC[index].started = true;
                this.microPC[index].isRunning = 1;
                this.$set(this.microPC, index, this.microPC[index]);
                let numberStarted = 0;
                for(let indexMicro = 0; indexMicro < this.microPC.length; indexMicro++) {
                    if(this.microPC[indexMicro].started && (this.microPC[indexMicro].online)) {
                        numberStarted++;
                    }
                }
                if(numberStarted == this.numberMicroOnLine) {
                    this.line.isRunning = 1;
                }
                this.socket.emit("startEvent", this.microPC[index].microCode);
                let microCode= [this.microPC[index].microCode];
                this.updateIsRunningLine(this.line.id, { 'isRunning': true });
                this.updateIsRunningMicro({ 'isRunning': true, 'microCodes': microCode })
            },
            stopMicroPc(index) {
                let microCodes = [];
                this.microPC[index].started = false;
                this.microPC[index].isRunning = 0;
                this.microPC[index].file.map(file => {
                    file.running = false;
                    if (file.pageRunning) {
                        file.pageRunning.fill(false);
                    }
                });
                this.$set(this.microPC, index, this.microPC[index]);
                let numberMicroNotRun = 0;
                for(let indexMicro = 0; indexMicro < this.microPC.length; indexMicro++) {
                    if(!this.microPC[indexMicro].isRunning) {
                        numberMicroNotRun++;
                        microCodes.push(this.microPC[indexMicro].microCode);
                    }
                }
                let microCode= [this.microPC[index].microCode];
                this.socket.emit("stopEvent", this.microPC[index].microCode);
                if(this.microPC.length == numberMicroNotRun) {
                    this.line.isRunning = 0;
                    this.setting_key = this.btn_setting = false;
                    this.socket.emit("stoppedAllEvent", microCodes);
                    this.updateLineChecked({ 'isChecked': false });
                    this.updateIsRunningLine(this.line.id, { 'isRunning': false });
                    this.deletePlaylistsWhenStopMicroPC();
                }
                this.updateIsRunningMicro({ 'isRunning': false, 'microCodes': microCode });
            },
            stopAllMicroPC() {
                this.updateLineChecked({ 'isChecked': false });
                this.setting_key = this.btn_setting = false;
                let microCodes = [];
                for (let indexMicro = 0; indexMicro < this.microPC.length; indexMicro++){
                    if(this.microPC[indexMicro].started) {
                        if(this.microPC[indexMicro].file) {
                            this.microPC[indexMicro].file.map(file => {
                                file.running = false;
                                if(file.pageRunning) {
                                    file.pageRunning.fill(false);
                                }
                            });
                        }
                        this.microPC[indexMicro].isRunning = 0;
                        this.microPC[indexMicro].started = false;
                        this.$set(this.microPC, indexMicro, this.microPC[indexMicro]);
                        microCodes.push(this.microPC[indexMicro].microCode);
                    }
                }
                this.socket.emit("stopAll", microCodes);
                this.socket.emit("stoppedAllEvent", microCodes);
                this.line.isRunning = 0;
                this.updateIsRunningLine(this.line.id, { 'isRunning': false })
                this.deletePlaylistsWhenStopMicroPC();
                this.updateIsRunningMicro({ 'isRunning': false, 'microCodes': microCodes })
            },
            microPCRunning(runningData) {                
                for (let indexMicro = 0; indexMicro < this.microPC.length; indexMicro++) {
                    if ((runningData._id == this.microPC[indexMicro].microCode || runningData.microCode == this.microPC[indexMicro].microCode) 
                    && this.microPC[indexMicro].started) {
                        for (let indexFile = 0; indexFile < this.microPC[indexMicro].file.length; indexFile++) {
                            if (this.microPC[indexMicro].file[indexFile].s_time && runningData.record.currFile == indexFile) {
                                this.microPC[indexMicro].file[indexFile]["running"] = true;
                                for (let indexS = 0; indexS < this.microPC[indexMicro].file[indexFile].s_time.length; indexS++) {
                                    if (indexS == runningData.record.currPage - 1) {
                                        this.microPC[indexMicro].file[indexFile].pageRunning[indexS] = true;
                                    } else {
                                        this.microPC[indexMicro].file[indexFile].pageRunning[indexS] = false;
                                    }
                                }
                            } else {
                                this.microPC[indexMicro].file[indexFile]["running"] = false;
                                if(this.microPC[indexMicro].file[indexFile].pageRunning) {
                                    this.microPC[indexMicro].file[indexFile].pageRunning.fill(false);
                                }
                            }
                        }
                        let newMicroPcObject = Object.assign({},  this.microPC[indexMicro]);
                        this.$set(this.microPC, indexMicro, newMicroPcObject);
                    }
                }
            },
            getMicroPcOnlines() {
                if (this.microPC) {
                    let microInLine = this.microPC.map(({ microCode }) =>  microCode );
                    let microOnLineOnSystem = this.microOnlineOnSystem.map(({ microCode }) =>  microCode );
                    this.numberMicroOnLine = 0;
                    for (let indexMicro = 0; indexMicro < this.microPC.length; indexMicro++) {
                        if (microOnLineOnSystem.includes(this.microPC[indexMicro].microCode)) {
                            this.microPC[indexMicro]['online'] = true;
                            this.$set(this.microPC, indexMicro, this.microPC[indexMicro]);
                            this.numberMicroOnLine++;
                        } else {
                            this.microPC[indexMicro]['online'] = false;
                            this.$set(this.microPC, indexMicro, this.microPC[indexMicro]);
                        }
                    }
                    this.disableWhenMicroOnNull = (this.numberMicroOnLine == 0);
                }
            },
            downSuccess(microSettingRecord) {
                this.downloadedMicroPCIds.push(microSettingRecord.currentMicroPCId);
                if(microSettingRecord && microSettingRecord.lineId == this.line.id && this.downloadedMicroPCIds.length == this.numberMicroOnLine) {
                    this.stopSpinner();
                }
            },
            downError(infoFileError) {
                this.stopSpinner();
                for (const micro of this.microPC) {
                    if(micro.online && micro.file) {
                        for (const file of micro.file) {
                            if(file.id == infoFileError.fileId) {
                                this.fileError = file.fileName;
                                this.showFileError = true;
                                this.error = infoFileError.err.error_code;
                                this.setting_key = this.btn_setting = false;
                                this.updateLineChecked({ 'isChecked': false });
                                return false;
                            }
                        }
                    }
                }
            }
        },
        created(){
            let _this = this;
            _this.getCurUser();
            _this.fetchTimeDefault();
            _this.startSpinner();
            window.addEventListener("resize", _this.resizeEventHandler);
        },
        mounted() {
            let _this = this;

            this.socket.on('connect', function () {
                _this.socket.emit('listMicro', _this.listMicroPc());
            });

            this.socket.on('loadRealTime', function (loadRealTime) {
                if(_this.line.id == loadRealTime.record.lineId) {
                    _this.microPCRunning(loadRealTime);
                }
            });

            this.socket.on('update-sockets', function (microOnlineOnSystem) {
                _this.microOnlineOnSystem = microOnlineOnSystem;
            });

            this.socket.on('downSuccess', function (microSettingRecord) {
                if(_this.line.id == microSettingRecord.lineId) {
                    _this.downSuccess(microSettingRecord);
                }
            });
            
            this.socket.on('downError', function (infoFileError) {
                if(_this.line.id == infoFileError.lineId) {
                    _this.downError(infoFileError);
                }
            });
        },
        destroyed() {
            window.removeEventListener("resize", this.resizeEventHandler);
            this.destroyinfoFile();
        },
        updated() {
            this.resizeEventHandler();
        }
    }
</script>
<style>
    #list-microPC{
        margin: 0px 10px;
    }
    #list-microPC legend {
        margin-left: 20px;
    }
    #list-microPC .v-text-field.v-text-field--solo .v-input__control {
        min-height: 30px;
        padding: 0;
    }
    #head_microPC .border_right,#body_microPC .border_right {
        border-right: 1px solid black;
    }
    #list-microPC .treeMargin {
        display: block !important;
    }

    #list-microPC .page,.play .v-btn {
        border: 0px !important;
    }
    #file-root .list-micropc td[colspan="0"]{
        border: 0px solid !important;
    }
    #list-microPC .list-micropc {
       width: 98%;
       margin: 0 auto;
    }
    #list-microPC fieldset {
        width: 100% !important;
    }
    #list-microPC .microCode {
        color: red;
    }
    #list-microPC table.v-table tbody td {
        height: auto !important;
    }
    #fileHeader .play button {
        background: #ccc !important;
        color: black !important;
    }
    .sl-vue-tree-root {
        background: none !important;
        border: none !important;
        color: #324057 !important;
    }
    .sl-vue-tree-node-item:hover, .sl-vue-tree-node-item.sl-vue-tree-cursor-hover {
        color: #324057 !important;
    }
    .sl-vue-tree-root .sl-vue-tree-title {
        font-size: 16px !important;
        width: 100% !important;
    }
    .sl-vue-tree-selected > .sl-vue-tree-node-item {
        background: none !important;
        color: #324057 !important;
    }
    .sl-vue-tree-root .sl-vue-tree-cursor {
        border: 0px solid black !important;
    }
    .sl-vue-tree.sl-vue-tree-root {
        border-radius: 0px !important;
        padding-top: 0px !important;
    }
    .sl-vue-tree-root > .sl-vue-tree-nodes-list {
        padding-bottom: 0px !important;
    }
    .sl-vue-tree-node-item{
        border: none !important;
        border-top: 1px solid #000 !important;
        padding: 0px !important;
    }
    .sl-vue-tree-node-item[path="[0]"]{
        border: none !important;
    }
    .sl-vue-tree-title .layout {
        flex: none !important;
    }

</style>
<style scoped>
    #list-microPC .rtime,.stime{
        border-left: 1px solid;
    }
    #list-microPC .rtime{
        border-left: 1px solid !important;
    }
    #list-microPC .rtime p button{
        background-color: #F5F5F8 !important;
        padding: 3px 6px !important;
        font-weight: 400;
        min-width: 51px !important;
        margin: 0px !important;
        height: 34px !important;
        font-size: 15px !important;
        color: black !important;
    }
    #list-microPC .page p,.stime p{
        margin-bottom: 0px !important;
        padding: 3px;
        border-bottom: 0px solid;
    }
    #list-microPC .psr_file {
        border-left: 1px solid;
    }
    #list-microPC .psr_file p{
        padding: 3px;
        height: 38px;
        border-bottom: 0px solid;
    }
    #list-microPC .page{
        margin: auto !important;
    }
     #list-microPC .rtime p {
         padding-right: 2px;
     }
</style>
