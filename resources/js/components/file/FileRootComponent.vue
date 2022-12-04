<template>
    <div id="file-root">
        <v-icon id="icon-caret" size="33" color="blue" @click="toggleDrawer()" :style="{ 'transform': drawer_detail ? 'rotate(0deg)' : 'rotate(180deg)' }">arrow_right_alt</v-icon>
        <v-layout row>
            <v-flex xs3>
                <fieldset :style="{ height: outerFieldHeight + 'px'}">
                    <legend>{{ $t('message.play_file.manage_file') }}</legend>
                    <v-text-field style="padding: 10px; padding-bottom: 0px;" v-model="searchTerm" solo single-line label="" prepend-inner-icon="search"></v-text-field>
                    <v-flex style="padding: 10px; padding-top: 0px; overflow-x:auto;">
                        <fieldset class='inner-field' id="inner-field-source">
                            <vue-drag-tree
                            id="tree"
                            :style="{ height: treeHeight + 'px', width: treeWidth + 'px'}"
                            :data='dataTree'
                            :allowDrag='allowDrag'
                            :allowDrop='allowDrop'
                            :disableDBClick='true'
                            @drag="dragHandler"
                            />
                        </fieldset>
                    </v-flex>
                </fieldset>
            </v-flex>
            <v-flex  :class="['micro_play_list', drawer_detail ? 'xs7' : 'xs9']">
                <div id="micro_play_list">
                    <microPC ref="setFile" :dataFile='fileSelected' :drawer="drawer_detail"/>
                </div>
            </v-flex>
            
            <v-flex v-if="drawer_detail" style="position: relative; top: 9px" xs2>
                    <detailFile/>
            </v-flex>
        </v-layout>
    </div>
</template>
<script>
    import microPC from "./MicroPcComponent.vue";
    import detailFile from "./DetailFileComponent.vue";
    import { getSourceTreeForPlayFile } from "../../api/playfile";
    import { mapState } from 'vuex';
    export default {
        components: {
            microPC,
            detailFile,
        },
        data() {
            return {
                fileSelected: {},
                drawer_detail: false,
                rawData: [],
                searchTerm :'',
                treeHeight:0,
                outerFieldHeight: 0,
                treeWidth: 0
            }
        },
        computed: {
            dataTree() {
                let filteredData = this.filterByFileName(this.rawData, this.searchTerm);
                let parseData = this.parseData(filteredData);
                return this.convertToTree(parseData);
            }
        },
        methods: {
            filterByFileName(iData, searchTerm) {
                if (searchTerm) {
                    searchTerm = searchTerm.toLowerCase();
                    let filteredArr = [];
                    for(let data of iData) {
                        if(data.fileName.toLowerCase().includes(searchTerm)) {
                            filteredArr.push(JSON.parse(JSON.stringify(data)));
                        }
                    }
                    return filteredArr;
                } else {
                    return JSON.parse(JSON.stringify(iData));
                }
            },
            parseData(iFiles) {
                let parseData = {};
                for (let file of iFiles) {
                    if (!parseData[file.customer]) {
                        parseData[file.customer] = {};
                    }
                    if (!parseData[file.customer][file.model]) {
                        parseData[file.customer][file.model] = {};
                    }
                    if (!parseData[file.customer][file.model][file.version]) {
                        parseData[file.customer][file.model][file.version] = {};
                    }
                    if (!parseData[file.customer][file.model][file.version]) {
                        parseData[file.customer][file.model][file.version] = {};
                    }
                    if (!parseData[file.customer][file.model][file.version][file.depCode]) {
                        parseData[file.customer][file.model][file.version][file.depCode] = [];
                    }
                    let fileObject = {
                        name: file.fileName,
                        pageNum: file.pageNum,
                        type: 'file',
                        id: file.id,
                        customer: file.customer,
                        depCode: file.depCode,
                        model: file.model,
                        size: file.size,
                    };
                    parseData[file.customer][file.model][file.version][file.depCode].push(fileObject);
                }
                return parseData;
            },
            convertToTree(parseData) {
                let tree = [];
                let idCnt = 0;
                let customerIdx = 0;
                for (let customer in parseData) {
                    if (parseData.hasOwnProperty(customer)) {
                        let customFolder = {
                            name: customer,
                            type: 'folder',
                            id: idCnt,
                            children:[]
                        };
                        tree.push(customFolder);
                        idCnt++;
                        let modelIdx = 0;
                        for (let model in parseData[customer]) {
                            if (parseData[customer].hasOwnProperty(model)) {
                                let modelFolder = {
                                    name: model,
                                    type: 'folder',
                                    id: idCnt,
                                    children:[]
                                };
                                tree[customerIdx].children.push(modelFolder);
                                idCnt++;
                                let verIdx = 0;
                                for (let version in parseData[customer][model]) {
                                    if (parseData[customer][model].hasOwnProperty(version)) {
                                        let verFolder = {
                                            name: version,
                                            type: 'folder',
                                            id: idCnt,
                                            children:[]
                                        };
                                        tree[customerIdx].children[modelIdx].children.push(verFolder);
                                        idCnt++;
                                        for (let depCode in parseData[customer][model][version]) {
                                            if (parseData[customer][model][version].hasOwnProperty(depCode)) {
                                                let depFolder = {
                                                    name: depCode,
                                                    type: 'folder',
                                                    id: idCnt,
                                                    children: parseData[customer][model][version][depCode]
                                                };
                                                tree[customerIdx].children[modelIdx].children[verIdx].children.push(depFolder);
                                                idCnt++;
                                            }
                                        }
                                        verIdx++;
                                    }
                                }
                                modelIdx++;
                            }
                        }
                        customerIdx++;
                    }
                }
                return tree;
            },
            toggleDrawer() {
                this.drawer_detail =! this.drawer_detail;
                this.$refs.setFile.disableBtnPage();
                setTimeout(()=> {
                    this.$refs.setFile.resizeEventHandler();
                }, 0)
            },
            allowDrag(model, component) {
                if(model.type == 'folder') {
                    return false
                }
                return true;
            },
            allowDrop(model, component) {
                return false
            },
            dragHandler(model, component, e) {
                this.fileSelected = model;
                this.$refs.setFile.setFile();
            },
            fetchTreeForPlayFile() {
                getSourceTreeForPlayFile()
                .then(response => {
                    this.rawData = response;
                }).catch( err => {
                    console.log(err);
                })
            },
            resizeEventHandler() {
                this.outerFieldHeight = window.innerHeight - 130;
                this.treeHeight = window.innerHeight - 165 - 65;
                const divInnerFieldSource = document.getElementById("inner-field-source");
                this.treeWidth = divInnerFieldSource.offsetWidth -5;

            }
        },
        created() {
            this.fetchTreeForPlayFile();
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
    #file-root{
      margin: 5px 10px;
    }
    #file-root legend {
      margin-left: 20px;
    }
    .sl-vue-tree-toggle {
        width: 38px !important;
    }
    #file-root  table thead {
        background: #ccc !important;
    }
    #file-root table.theme--light thead tr th{
        font-weight: bold;
        color: #000;
        border: 1px solid #000;
        width: auto;
    }
    #file-root .list-micropc td{
        border: 1px solid #000;
    }
    #file-root .v-text-field.v-text-field--solo .v-input__control {
        min-height: 30px;
        padding: 0;
    }
    #file-root .border_right,#body_microPC .border_right {
        border-right: 1px solid black;
    }
    #file-root .is-clicked {
        background: none;
    }
    #file-root .is-hover {
        background: #E5E9F2 !important;
    }
    #file-root div[draggable='true'] > div > div > span.text,#file-root div[draggable='false'] > div > div > span.text {
        text-transform: none;
        font-size: 11px;
    }
    #file-root div[draggable='true'] > div > div > span.text {
        /*white-space: nowrap;*/
        color: black;
        font-weight: bold;
    }

    #file-root div[draggable='true'] > div > div > span.vue-drag-node-icon {
        display: none !important;
    }
    #file-root .treeNodeText {
        cursor: pointer;
    }
    #file-root .v-text-field__details {
        margin-bottom: 0px !important;
    }
    #file-root #tree{
        overflow: auto;
        white-space: nowrap;
    }
    #file-root .dnd-container {
        background: #fafafa;
    }
    #file-root #icon-caret {
        position: absolute;
        right: -2px;
        top: -13px;
    }
    #file-root .v-overlay:before {
        background: none !important;
    }
</style>
