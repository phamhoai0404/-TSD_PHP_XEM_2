<template>
    <div id="sync-file-root">
        <v-container fluid id='container'>
            <v-layout>
                <v-flex xs3>
                    <div class="text-xs-center">
                        <v-btn id="step-1" flat @click="readSourceFolder()" :disabled="step != 1">
                            {{ $t('message.sync_file.read_source_folder') }}</v-btn>
                    </div>
                </v-flex>
                <v-flex xs6>
                    <div class="text-xs-center">
                        <v-btn id="step-2" flat @click="confirmSyncContent()" :disabled="step != 2">
                            {{ $t('message.sync_file.read_destination_folder') }}</v-btn>
                    </div>
                </v-flex>
                <v-flex xs3>
                    <div class="text-xs-center">
                        <v-btn id="step-3" flat @click="confirmSync()" :disabled="step != 3">
                            {{ $t('message.sync_file.start_sync') }}</v-btn>
                    </div>
                </v-flex>
            </v-layout>
            <v-layout id='content-layout'>
                <v-flex xs3 ref="sourceFileBox">
                    <fieldset class='outer-field' :style="{ height: outerFieldHeight + 'px'}">
                        <legend>{{ $t('message.sync_file.source_folder') }}</legend>
                        <v-container>
                            <v-layout>
                                <v-flex xs12>
                                    <p>{{ source_path }}</p>
                                </v-flex>
                            </v-layout>
                            <v-layout>
                                <v-flex xs12>
                                    <v-text-field solo single-line label="" prepend-inner-icon="search"
                                        v-model="searchSourceTerm"></v-text-field>
                                </v-flex>
                            </v-layout>
                            <v-layout>
                                <v-flex xs12>
                                    <fieldset class='inner-field' id="inner-field-source">
                                        <vue-drag-tree id="tree1" :style="{ height: treeHeight + 'px', width: treeWidth + 'px', 'padding-left' : '1px'}" :data='dataSourceTree' :allowDrag='allowDrag'
                                            :allowDrop='allowDrop' :disableDBClick='true' />
                                    </fieldset>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </fieldset>
                </v-flex>
                <v-flex xs6>
                    <fieldset class="outer-field inner-field" id="middle_files" :style="{ height: outerFieldHeight + 'px'}">
                        <legend>{{ $t('message.sync_file.mutations') }}</legend>
                        <v-container>
                            <v-layout>
                                <v-flex xs12>
                                    <div class="noborder-message" v-if="sync_success" ref="successMessage" style="margin-top: -10px;">
                                        <v-alert value="true" color="success" icon="check_circle" outline transition="scale-transition" dismissible>
                                            {{ sync_success }}
                                        </v-alert>
                                    </div>
                                    <div class="noborder-message" v-if="sync_error" ref="errorMessage" style="margin-top: -10px;">
                                        <v-alert value="true" color="error" icon="warning" outline transition="scale-transition" dismissible>
                                            <ul><li>{{ sync_error }}</li></ul>
                                        </v-alert>
                                    </div>
                                </v-flex>
                            </v-layout>
                            <v-layout>
                                <v-flex xs12>
                                    <p class='font-italic' style="color: green;">{{ $t('message.sync_file.synced_files') }}</p>
                                </v-flex>
                            </v-layout>
                            <v-layout>
                                <v-flex xs12 :style="{ height: tableHeight + 'px'}" id="copied-file-tbl" ref="copiedFileTbl">
                                    <v-data-table :headers="headersNew" :items="newFiles" hide-actions class="data-table">
                                        <template  slot="headers">
                                            <tr>
                                                <th align="left">{{ $t('message.sync_file.header_source') }}</th>
                                                <th align="left">{{ $t('message.sync_file.header_des') }}</th>
                                            </tr>
                                        </template>
                                        <template v-slot:items="props">
                                            <tr>
                                                <td>{{ props.item.source }}</td>
                                                <td>{{ props.item.destination }}</td>
                                            </tr>
                                        </template>
                                        <template v-slot:no-data>
                                            <tr>
                                                <td colspan="2" class="text-xs-center">{{ $t('message.no_data_table') }}</td>
                                            </tr>
                                        </template>
                                    </v-data-table>
                                </v-flex>
                            </v-layout>
                            <hr style="margin: 10px 0px;">
                            <v-layout>
                                <v-flex xs12>
                                    <p class='font-italic' style="color: red;">{{ $t('message.sync_file.deleted_files') }}</p>
                                </v-flex>
                            </v-layout>
                            <v-layout>
                                <v-flex xs12 :style="{ height: tableHeight + 'px'}" id="deleted-file-tbl" ref="deletedFileTbl">
                                    <v-data-table :headers="headersDel"
                                          :items="deletedFiles"
                                          hide-actions
                                          class="data-table"
                                          v-model="selected"
                                          select-all
                                          item-key="path"
                                    >
                                        <template v-slot:headers="props">
                                            <tr>
                                                <th>
                                                    <v-checkbox
                                                            :input-value="props.all"
                                                            :indeterminate="props.indeterminate"
                                                            primary
                                                            hide-details
                                                            :disabled="step != 2"
                                                            @click.stop="toggleAll"
                                                    ></v-checkbox>
                                                </th>
                                                <th align="left">{{ $t('message.sync_file.header_des') }}</th>
                                            </tr>
                                        </template>
                                        <template v-slot:items="props">
                                            <tr :active="props.selected" @click="props.selected = !props.selected">
                                                <td style="width: 10px;">
                                                    <v-checkbox
                                                        :input-value="props.selected"
                                                        primary
                                                        hide-details
                                                        :disabled="step != 2"
                                                    ></v-checkbox>
                                                </td>
                                                <td>{{ props.item.path }}</td>
                                            </tr>
                                        </template>
                                        <template v-slot:no-data>
                                            <td colspan="2" class="text-xs-center">{{ $t('message.no_data_table') }}</td>
                                        </template>
                                    </v-data-table>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </fieldset>
                </v-flex>
                <v-flex xs3>
                    <fieldset class='outer-field' :style="{ height: outerFieldHeight + 'px'}">
                        <legend>{{ $t('message.sync_file.destination_folder') }}</legend>
                        <v-container>
                            <v-layout>
                                <v-flex xs12>
                                    <p>{{ destination_path }}</p>
                                </v-flex>
                            </v-layout>
                            <v-layout>
                                <v-flex xs12>
                                    <v-text-field solo single-line label="" prepend-inner-icon="search"
                                        v-model="searchDesTerm"></v-text-field>
                                </v-flex>
                            </v-layout>
                            <v-layout>
                                <v-flex xs12>
                                    <fieldset class='inner-field' id="inner-field-destination">
                                        <vue-drag-tree id="tree2" :style="{ height: treeHeight + 'px', width: treeWidth + 'px', 'padding-left' : '1px'}" :data='dataDesTree' :allowDrag='allowDrag'
                                            :allowDrop='allowDrop' :disableDBClick='true' />
                                    </fieldset>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </fieldset>
                </v-flex>
            </v-layout>

            <confirm-sync v-if='isShow' @close='isShow = false' @agree='onDecided'></confirm-sync>

            <change-confirm v-if='isChangeShow' @close='isChangeShow = false' @agree='onChangeDecided'>
                <template #action-name>
                    <span style="font-weight: bold">【 {{ actionName }} 】</span>
                </template>
                <template #file-name>
                    <p style="margin-top: 30px; margin-bottom: 10px; display: block; padding: 5px; border-radius: 3px"
                       class="red lighten-4"
                    >
                        {{ changedItemPath }}
                    </p>
                </template>
            </change-confirm>

            <new-name v-if='isNewNameShow'
                      @close='isNewNameShow = false'
                      @save='onSaveNewName'
                      :oldItemName="oldItemName">
            </new-name>

            <skipped-files v-if='hasInvalidFiles' @close='hasInvalidFiles = false'>
                <ul style="list-style-type: none; margin-top: 20px; display: block; padding: 5px; border-radius: 3px" class="red lighten-4">
                    <li v-for="skippedFile in skippedFiles">{{ skippedFile }}</li>
                </ul>
            </skipped-files>

            <change-file-result v-if='isResultShow' @close='isResultShow = false'>
                <p style="list-style-type: none; margin-top: 20px; display: block; padding: 5px; border-radius: 3px"
                   :class="[ changeFileInTreeSuccess ? 'blue' : 'red', 'lighten-4']"
                >
                    {{ changeFileResult }}
                </p>
            </change-file-result>

            <vue-context ref="menu">
                <ul slot-scope="child">
                    <li @click="confirmDelete(child.data)">
                        <v-icon class="red--text v-context-icon">delete</v-icon>
                        <span>{{ $t('message.sync_file.delete') }}</span>
                    </li>
                    <li @click="confirmRename(child.data)">
                        <v-icon class="teal--text v-context-icon">edit</v-icon>
                        <span>{{ $t('message.sync_file.rename') }}</span>
                    </li>
                </ul>
            </vue-context>
        </v-container>
    </div>
</template>

<script>
    import {
        getAllDepCodes,
        getSourceTree,
        getDesTree,
        syncFiles,
        getSetting,
        deleteItemInTree,
        renameItemInTree
    } from "../../api/sync_file";
    import ChangeConfirm from './ChangeConfirmComponent';
    import NewName from './NewNameComponent';
    import ConfirmSync from "./ConfirmSyncFilesComponent";
    import SkippedFiles from "./SkippedFilesComponent";
    import ChangeFileResult from "./ChangeFileResultComponent";
    import { VueContext } from 'vue-context';
    import { mapState } from 'vuex';

    export default {
        name: 'SyncFileRootComponent',
        components: {
            'confirm-sync': ConfirmSync,
            'vue-context': VueContext,
            'change-confirm': ChangeConfirm,
            'new-name': NewName,
            'skipped-files': SkippedFiles,
            'change-file-result': ChangeFileResult
        },
        data() {
            return {
                actionName: '',
                departments: [],
                sync_error: '',
                sync_success: '',
                isShow: false,
                isChangeShow: false,
                hasInvalidFiles: false,
                isResultShow: false,
                isNewNameShow: false,
                source_path: '',
                destination_path: '',
                step: 0,
                searchSourceTerm: '',
                searchDesTerm: '',
                selected: [],
                headersNew: [],
                headersDel: [],
                source: [],
                parsedSource: {},
                des: [],
                parsedDes: {},
                deletedFiles: [],
                newFiles: [],
                tableHeight: 0,
                treeHeight:0,
                outerFieldHeight: 0,
                treeWidth: 0,
                changedItemPath: '',
                skippedFiles: [],
                changeFileResult: '',
                changeFileInTreeSuccess: false,
                ...mapState(['sidebarIconClicked']),
                prefix: '',
                oldItemName: '',
                sameLevelItems: []
            }
        },
        computed: {
            filteredSource() {
                return this.filterByFileName(this.source, this.searchSourceTerm);
            },
            filteredDes() {
                return this.filterByFileName(this.des, this.searchDesTerm);
            },
            dataSourceTree() {
                let tree = this.filteredSource;
                this.$nextTick(() => {
                    this.bindContextMenuHandler();
                });
                return tree;
            },
            dataDesTree() {
                let tree = this.filteredDes;
                this.$nextTick(() => {
                    this.bindContextMenuHandler();
                });
                return tree;
            },
            notifyHeight() {
                let height;
                if (this.sync_success) {
                    height = this.$refs.successMessage.clientHeight;
                } else if (this.sync_error) {
                    height = this.$refs.errorMessage.clientHeight;
                } else {
                    height = 0;
                }
                return height;
            }
        },
        watch: {
            sidebarIconClicked() {
                setTimeout(this.sidebarClickEventHandler, 250);
            },
        },
        methods: {
            findSameLevelItems(tree, itemId) {
                for (let i = 0; i < tree.length; i++) {
                    if (tree[i].id == itemId) return tree.map(node => node.id);
                    else {
                        const found = this.findSameLevelItems(tree[i].children, itemId);
                        if (found) return found;
                    }
                }
                return null;
            },
            splitOldItemPath() {
                const dirParts = this.changedItemPath.split('/');
                this.oldItemName = dirParts.pop();
                this.prefix = dirParts.join('/');
                const isInSource = this.changedItemPath.includes(this.source_path);
                const nodes = isInSource ? this.source : this.des;
                this.sameLevelItems = this.findSameLevelItems(nodes, this.changedItemPath);
            },
            fetchDepartments() {
                let _this = this;
                getAllDepCodes()
                    .then(response => {
                        _this.departments = response;
                    }).catch( err => {
                    console.log(err);
                })
            },
            toggleAll () {
                if (this.selected.length) {
                    this.selected = [];
                } else {
                    this.selected = this.deletedFiles.slice();
                }
            },
            filterByFileName(iNodes, searchTerm) {
                if (searchTerm) {
                    searchTerm = searchTerm.toLowerCase();
                    let filteredArr = [];
                    for(let i = 0; i < iNodes.length; i++) {
                        if (iNodes[i].type == 'file') {
                            if (iNodes[i].name.toLowerCase().includes(searchTerm)) {
                                let tmpNode = JSON.parse(JSON.stringify(iNodes[i]));
                                filteredArr.push(tmpNode);
                            }
                        } else {
                            let tmpFilteredResult = this.filterByFileName(iNodes[i].children, searchTerm);
                            if (tmpFilteredResult.length > 0) {
                                let tmpNode = JSON.parse(JSON.stringify(iNodes[i]));
                                tmpNode.children = tmpFilteredResult;
                                filteredArr.push(tmpNode);
                            }
                        }
                    }
                return filteredArr;
                } else {
                    return JSON.parse(JSON.stringify(iNodes));
                }
            },
            parseFileName(fileName) {
                // Syntax: MO-DEL-VER_DEPARTMENT_ORDER_PROCESS.pdf
                let dirParts = fileName.split(/[-_.]/);
                if (dirParts.length == 7 && this.departments.includes(dirParts[3])) {
                    return {
                        fileName: fileName,
                        customer: null,
                        model: dirParts[0] + '-' + dirParts[1],
                        version: dirParts[2],
                        depCode: dirParts[3],
                        order: dirParts[4],
                        process: dirParts[5]
                    }
                } else {
                    return null;
                }
            },
            allowDrag(model, component) {
                return model.type != 'folder';
            },
            allowDrop(model, component) {
                return false;
            },
            onDecided(confirm) {
                this.isShow = false;
                if (confirm) {
                    this.startSync();
                } else {
                    this.step = 2;
                }
            },
            onSaveNewName(output) {
                this.isNewNameShow = false;
                if (output.confirm) {
                    console.log(output.newName);
                    const newNamePath = this.prefix + '/' + output.newName;
                    if (!this.sameLevelItems.includes(newNamePath)) {
                        this.onRenameBtnClick(output.newName, newNamePath);
                    } else {
                        this.changeFileInTreeSuccess = false;
                        this.changeFileResult = this.$t('message.sync_file.rename_in_tree_duplicate');
                        this.isResultShow = true;
                    }
                } else {
                    this.sameLevelItems = [];
                    this.changedItemPath = '';
                }
            },
            onChangeDecided(confirm) {
                this.isChangeShow = false;
                if (confirm) {
                    if (this.actionName === this.$t('message.sync_file.rename')) {
                        this.splitOldItemPath();
                        this.isNewNameShow = true;
                        console.log(this.oldItemName);
                        console.log(this.prefix);
                    } else if (this.actionName === this.$t('message.sync_file.delete')) {
                        this.onDeleteBtnClick();
                    } else {
                        console.log('do nothing')
                    }
                } else {
                    this.changedItemPath = '';
                }
            },
            bindContextMenuHandler() {
                const containPathDivs = document.getElementsByClassName("dnd-container");
                for (let i = 0; i < containPathDivs.length; i++) {
                    containPathDivs[i].addEventListener("contextmenu", this.rightClick, true);
                }
            },
            onDeleteBtnClick() {
                this.startSpinner();
                deleteItemInTree(this.changedItemPath)
                    .then(res => {
                        this.changeFileInTreeSuccess = true;
                        this.changeFileResult = this.$t('message.sync_file.delete_in_tree_success');
                    })
                    .catch(err => {
                        console.log(err);
                        this.changeFileInTreeSuccess = false;
                        this.changeFileResult = err.error_code;
                    })
                    .finally(() => {
                        this.changedItemPath = '';
                        this.isResultShow = true;
                        this.getTrees()
                            .then(results => {
                                this.parseSourceTreeResult(results[0]);
                                this.parseDesTreeResult(results[1]);
                                // this.dataSourceTree();
                                // this.dataDesTree();
                            })
                            .catch(err => {
                                console.log(err);
                            })
                            .finally(() => {
                                this.stopSpinner();
                            });
                    })
            },
            onRenameBtnClick(newName, newNamePath) {
                this.startSpinner();
                renameItemInTree(this.changedItemPath, newName, newNamePath)
                    .then(res => {
                        this.changeFileInTreeSuccess = true;
                        this.changeFileResult = this.$t('message.sync_file.rename_in_tree_success');
                    })
                    .catch(err => {
                        console.log(err);
                        this.changeFileInTreeSuccess = false;
                        this.changeFileResult = err.error_code;
                    })
                    .finally(() => {
                        this.changedItemPath = '';
                        this.sameLevelItems = [];
                        this.isResultShow = true;
                        this.getTrees()
                            .then(results => {
                                this.parseSourceTreeResult(results[0]);
                                this.parseDesTreeResult(results[1]);
                                // this.dataSourceTree();
                                // this.dataDesTree();
                            })
                            .catch(err => {
                                console.log(err);
                            })
                            .finally(() => {
                                this.stopSpinner();
                            });
                    })
            },
            rightClick(event) {
                event.preventDefault();
                const path = event.currentTarget.firstChild.firstChild.id;
                this.$refs.menu.open(event, {path: path});
            },
            parseSourceTreeResult(result) {
                this.skippedFiles = [];
                this.source = result;
                this.parsedSource = {};
                this.source.forEach(customer => {
                    const customerObj = {};
                    customer.children.forEach(sourceFile => {
                        const parsedFileObj = this.parseFileName(sourceFile.name);
                        if (parsedFileObj) {
                            parsedFileObj.customer = customer.name;
                            if (!customerObj[parsedFileObj.model]) {
                                customerObj[parsedFileObj.model] = {};
                            }
                            if (!customerObj[parsedFileObj.model][parsedFileObj.version]) {
                                customerObj[parsedFileObj.model][parsedFileObj.version] = {};
                            }
                            if (!customerObj[parsedFileObj.model][parsedFileObj.version][parsedFileObj.depCode]) {
                                customerObj[parsedFileObj.model][parsedFileObj.version][parsedFileObj.depCode] = [];
                            }
                            customerObj[parsedFileObj.model][parsedFileObj.version][parsedFileObj.depCode].push(parsedFileObj);
                        } else {
                            this.skippedFiles.push(customer.name + '/' + sourceFile.name);
                        }
                    });
                    this.parsedSource[customer.name] = customerObj;
                });
            },
            parseDesTreeResult(result) {
                this.des = result;
                this.parsedDes = {};
                this.des.forEach(customer => {
                    const customerObj = {};
                    customer.children.forEach(desModel => {
                        if (!customerObj[desModel.name]) {
                            customerObj[desModel.name] = {};
                        }
                        desModel.children.forEach(desVersion => {
                            if (!customerObj[desModel.name][desVersion.name]) {
                                customerObj[desModel.name][desVersion.name] = {};
                            }
                            desVersion.children.forEach(desDepartment => {
                                if (!customerObj[desModel.name][desVersion.name][desDepartment.name]) {
                                    customerObj[desModel.name][desVersion.name][desDepartment.name] = [];
                                }
                                desDepartment.children.forEach(desFile => {
                                    const parsedFileObj = this.parseFileName(desFile.name);
                                    if (parsedFileObj) {
                                        parsedFileObj.customer = customer.name;
                                        customerObj[desModel.name][desVersion.name][desDepartment.name].push(parsedFileObj);
                                    }
                                });
                            });
                        });
                    });
                    this.parsedDes[customer.name] = customerObj;
                });
            },
            getTrees() {
                return Promise.all([getSourceTree(), getDesTree()]);
            },
            fillPath() {
                getSetting('source_path')
                    .then(res => {
                        this.source_path = res;
                    })
                    .catch(err => {
                        console.log(err);
                    });
                getSetting('destination_path')
                    .then(res => {
                        this.destination_path = res;
                    })
                    .catch(err => {
                        console.log(err);
                    });
            },
            readSourceFolder() {
                this.startSpinner();
                this.getTrees()
                    .then(results => {
                        this.parseSourceTreeResult(results[0]);
                        this.parseDesTreeResult(results[1]);
                        // this.dataSourceTree();
                        // this.dataDesTree();
                        // if (this.source.length == 0 || this.des.length == 0) {
                        if (this.source.length == 0) {
                            this.step = 0;
                        } else {
                            this.sync_error = '';
                            this.sync_success = '';
                            this.newFiles = [];
                            this.deletedFiles = [];
                            for (let customer in this.parsedSource) {
                                if (this.parsedSource.hasOwnProperty(customer)) {
                                    if (!this.parsedDes[customer]) {
                                        this.parsedDes[customer] = {};
                                    }
                                    for (let model in this.parsedSource[customer]) {
                                        if (this.parsedSource[customer].hasOwnProperty(model)) {
                                            // Get newFiles
                                            for (let version in this.parsedSource[customer][model]) {
                                                if (this.parsedSource[customer][model].hasOwnProperty(version)) {
                                                    for (let department in this.parsedSource[customer][model][version]) {
                                                        if (this.parsedSource[customer][model][version].hasOwnProperty(department)) {
                                                            for (let fileObj of this.parsedSource[customer][model][version][department]) {
                                                                this.newFiles.push({
                                                                    source: customer + '/' + fileObj.fileName,
                                                                    destination: customer + '/' + model + '/' + version + '/' + department + '/' + fileObj.fileName,
                                                                    fileObj: fileObj
                                                                });
                                                            }
                                                        }
                                                    }
                                                }
                                            }

                                            // Get deletedFiles
                                            if (this.parsedDes[customer][model]) {
                                                for (let version in this.parsedDes[customer][model]) {
                                                    if (this.parsedDes[customer][model].hasOwnProperty(version)) {
                                                        for (let department in this.parsedDes[customer][model][version]) {
                                                            if (this.parsedDes[customer][model][version].hasOwnProperty(department)) {
                                                                for (let fileObj of this.parsedDes[customer][model][version][department]) {
                                                                    this.deletedFiles.push({
                                                                        path: customer + '/' + model + '/' + version + '/' + department + '/' + fileObj.fileName,
                                                                        fileObj: fileObj
                                                                    });
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            this.selected = [];
                            if (this.skippedFiles.length > 0) {
                                this.hasInvalidFiles = true;
                                this.step = 1;
                            } else {
                                this.step = 2;
                            }
                        }
                    })
                    .catch(err => {
                        console.log(err);
                        this.step = 0;
                    })
                    .finally(() => {
                        this.stopSpinner();
                    });

            },
            confirmSyncContent() {
                console.log("this.selected", this.selected);
                this.step = 3;
            },
            confirmSync() {
                this.isShow = true;
            },
            confirmDelete(data) {
                if (this.step == 1) {
                    this.isChangeShow = true;
                    this.changedItemPath = data.path;
                    this.actionName = this.$t('message.sync_file.delete');
                } else {
                    this.isResultShow = true;
                    this.changeFileInTreeSuccess = false;
                    this.changeFileResult = this.$t('message.sync_file.change_in_tree_not_allow');
                }
            },
            confirmRename(data) {
                if (this.step == 1) {
                    this.isChangeShow = true;
                    this.changedItemPath = data.path;
                    this.actionName = this.$t('message.sync_file.rename');
                } else {
                    this.isResultShow = true;
                    this.changeFileInTreeSuccess = false;
                    this.changeFileResult = this.$t('message.sync_file.change_in_tree_not_allow');
                }
            },
            startSync() {
                this.startSpinner();
                syncFiles(this.newFiles, this.selected)
                .then(res => {
                    this.sync_success = this.$t('message.sync_file.success');
                    this.sync_error = '';
                    this.newFiles = res.copiedFiles;
                    this.deletedFiles = res.deletedFiles;
                })
                .catch(err => {
                    this.sync_success = '';
                    this.sync_error = err.error_code;
                    this.step = 0;
                })
                .finally(() => {
                    this.getTrees()
                        .then(results => {
                            this.parseSourceTreeResult(results[0]);
                            this.parseDesTreeResult(results[1]);
                            if (this.source.length > 0 && this.des.length > 0) {
                                this.step = 1;
                            } else {
                                this.step = 0;
                            }
                            const dismissIconLink = document.getElementsByClassName("v-alert__dismissible");
                            if (dismissIconLink.length == 1) {
                                document.addEventListener('click', this.dismissIconClickEventHandler)
                            }
                        })
                        .catch(err => {
                            console.log(err);
                            this.step = 0;
                        })
                        .finally(() => {
                            this.stopSpinner();
                        });
                });
            },
            resizeEventHandler() {
                this.outerFieldHeight = window.innerHeight - 165;
                this.treeHeight = window.innerHeight - 165 - 130;
                this.tableHeight = (window.innerHeight - 165 - 130 + 25)/2;

                const divInnerFieldSource = document.getElementById("inner-field-source");
                this.treeWidth = divInnerFieldSource.offsetWidth - 5;
            },
            sidebarClickEventHandler() {
                const btnStep1 = document.getElementById("step-1");
                this.treeWidth = btnStep1.offsetWidth - 20;
            },
            dismissIconClickEventHandler() {
                this.sync_success = '';
                this.sync_error = '';
            }
        },
        created() {
            this.startSpinner();
            this.fetchDepartments();
            this.fillPath();
            this.getTrees()
                .then(results => {
                    this.parseSourceTreeResult(results[0]);
                    this.parseDesTreeResult(results[1]);
                    // this.dataSourceTree();
                    // this.dataDesTree();
                    // if (this.source.length > 0 && this.des.length > 0) {
                    if (this.source.length > 0) {
                        this.step = 1;
                    } else {
                        this.step = 0;
                    }
                })
                .catch(err => {
                    console.log(err);
                    this.step = 0;
                })
                .finally(() => {
                    this.stopSpinner();
                });
            window.addEventListener("resize", this.resizeEventHandler);
        },
        mounted() {
            this.$watch('notifyHeight', (newHeight) => {
                this.$refs.copiedFileTbl.style.height = (this.tableHeight - newHeight/2) + 'px';
                this.$refs.deletedFileTbl.style.height = (this.tableHeight - newHeight/2) + 'px';
            });
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
    .v-context {
        background: #F4F4F4 !important;
        width: auto !important;
    }

    .v-context:focus {
        outline: none !important;
    }

    .v-context-icon {
        width: 20px !important;
        height: 20px !important;
        left: 3px !important;
        top: 3px !important;
        /*position: absolute !important;*/
        background: #F4F4F4 !important;

    }

    .v-context ul {
        padding: 2px 0 !important;
        font-size: 13px !important;
    }

    .v-context ul li {
        margin-left: 5px !important;
        padding: 3px !important;
        /*padding-left: 30px !important;*/
        padding-right: 10px !important;
    }

    .v-context ul li:hover {
        background: #F4F4F4 !important;
    }

    .v-context ul li:hover span {
        color: darkorange;
    }

    #sync-file-root {
        margin-top: -20px;
    }

    #sync-file-root #container {
        padding-top: 0px;
    }

    #sync-file-root .container {
        padding: 10px;
    }

    #sync-file-root #error {
        padding: 0px 0px 10px 0px;
        margin: 0;
    }

    #sync-file-root #success {
        padding: 0px 0px 10px 0px;
        margin: 0;
    }

    #sync-file-root .v-alert {
        padding: 0px;
    }

    #sync-file-root .v-btn {
        font-weight: bold;
        text-align: center;
        border: black 1px solid;
        border-radius: 5px;
        width: 95%;
    }

    #sync-file-root legend {
        margin-left: 20px;
    }
    #sync-file-root .v-table tbody td {
        font-size: 10px;
    }

    #sync-file-root .outer-field {
        width: 95%;
        margin: 0 auto;
        border-radius: 5px;
    }

    #sync-file-root .font-italic {
        font-weight: bold;
    }

    #sync-file-root .v-btn:enabled {
        background: #FFBC00;
    }

    #sync-file-root .v-btn:disabled {
        background: #FFFFFF;
    }

    #sync-file-root .v-input--selection-controls:not(.v-input--hide-details) .v-input__slot {
        margin-bottom: 0px;
    }

    #sync-file-root .v-messages {
        display: none;
    }

    #sync-file-root .is-clicked {
        background: none;
    }

    #sync-file-root .is-hover {
        background: #E5E9F2 !important;
    }

    #sync-file-root .dnd-container {
        background: #fafafa;
        -webkit-touch-callout: none; /* iOS Safari */
        -webkit-user-select: none; /* Safari */
        -khtml-user-select: none; /* Konqueror HTML */
        -moz-user-select: none; /* Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
        user-select: none; /* Non-prefixed version, currently */
        cursor: pointer;
    }

    #sync-file-root #tree1,
    #sync-file-root #tree2{
        overflow: auto;
        /*scrollbar-width: thin;*/
        white-space: nowrap;
    }

    #sync-file-root span.text {
        font-size: 12px !important;
        text-transform: none !important;
    }

    #sync-file-root .v-text-field.v-text-field--solo .v-input__control {
        min-height: 30px;
        padding: 0;
    }

    #sync-file-root .treeNodeText > span.text {
        text-transform: none;
    }

    #sync-file-root div[draggable='true']>div>div>span.text {
        color: green;
        font-weight: bold;
    }

    #sync-file-root div[draggable='true']>div>div>span.vue-drag-node-icon {
        display: none !important;
    }

    #sync-file-root #content-layout {
        margin-top: 10px;
    }

    #sync-file-root .theme--light {
        background-color: #FAFAFA;
    }

    #sync-file-root #copied-file-tbl,
    #sync-file-root #deleted-file-tbl {
        overflow: auto;
        margin-top: -15px;
    }

    /* ::-webkit-scrollbar {
       display: none;
    } */

</style>
