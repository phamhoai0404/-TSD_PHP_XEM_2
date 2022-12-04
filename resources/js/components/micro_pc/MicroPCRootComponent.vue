<template>
    <div>
        <v-container class="micro_pc-root" id="micro_pc" fluid>
            <v-layout row>
                <v-flex xs8 id="micro">
                    <v-layout row>
                        <div id="success" v-if="successDelete" class="root-message noborder-message">
                            <v-alert value="true" color="success" icon="check_circle" outline transition="scale-transition" dismissible>
                            {{ successDelete }}.
                            </v-alert>
                        </div>
                        <div id="error" v-if="errors" class="root-message noborder-message">
                            <v-alert value="true" color="error" icon="warning" outline transition="scale-transition" dismissible>
                                <ul>
                                    <li >{{ errors }}</li>
                                </ul>
                            </v-alert>
                        </div>
                    </v-layout>
                    <v-layout row>
                        <v-flex xs1 id="part" style="margin-left: -15px; min-width: 99px;">
                            <v-card-title>{{ $t('message.info_micro_pc.parts') }}</v-card-title>
                        </v-flex>
                        <v-flex xs3>
                            <v-select :disabled="isRoleLine" :items="dep" item-text="depCode" item-value="id" v-model="selectDepartment" :menu-props="{ nudgeTop: -8, offsetY: ''}"></v-select>
                        </v-flex>
                        <v-flex xs1></v-flex>
                        <v-flex xs1 id="line">
                            <v-card-title>{{ $t('message.info_micro_pc.line') }}</v-card-title>
                        </v-flex>
                        <v-flex xs3>
                            <v-select :items="lines" item-text="lineCode" item-value="id" v-model="selectLine" :menu-props="{ nudgeTop: -8, offsetY: ''}"></v-select>
                        </v-flex>
                        <v-spacer></v-spacer>
                        <v-btn v-if="$hasRole($constants.roles.admin)" class="btnAdd" @click="addMicroPC">{{ $t('message.micro_pc.add') }}</v-btn>
                    </v-layout>
                    <v-layout row>
                        <v-flex xs12>
                            <v-data-table
                                    :headers="headers"
                                    :items="filteredItems"
                                    class="list-micro_pc"
                                    :pagination.sync="pagination"
                                    :rows-per-page-items= '[10,25,{"text":"$vuetify.dataIterator.rowsPerPageAll","value":-1}]'
                                    :rows-per-page-text="$t('message.paginate')"
                            >
                                <template slot="headers" slot-scope="props">
                                    <th :class="['column sortable', pagination.descending ? 'desc' : 'asc', 'microCode' == pagination.sortBy ? 'active' : '']" @click="changeSort('microCode')">
                                        <v-icon small>arrow_upward</v-icon>{{ $t('message.micro_pc.micro_pc') }}
                                    </th>
                                    <th :class="['column sortable', pagination.descending ? 'desc' : 'asc', 'department.depCode' == pagination.sortBy ? 'active' : '']" @click="changeSort('department.depCode')">
                                        <v-icon small>arrow_upward</v-icon>{{ $t('message.micro_pc.department') }}
                                    </th>
                                    <th :class="['column sortable', pagination.descending ? 'desc' : 'asc', 'line.lineCode' == pagination.sortBy ? 'active' : '']" @click="changeSort('line.lineCode')">
                                        <v-icon small>arrow_upward</v-icon>{{ $t('message.micro_pc.line') }}
                                    </th>
                                    <th :class="['column sortable', pagination.descending ? 'desc' : 'asc', 'isRunning' == pagination.sortBy ? 'active' : '']" @click="changeSort('isRunning')">
                                        <v-icon small>arrow_upward</v-icon>{{ $t('message.micro_pc.status') }}
                                    </th>
                                    <th>{{ $t('message.micro_pc.manipulation') }}</th>
                                    <th><v-btn class="border orange" @click="action = $t('message.micro_pc.rebootall'); removeConfirmReboot(getMicroPCOnline)" :disabled="getMicroPCOnline.length == 0" small>{{ $t('message.micro_pc.rebootall') }}</v-btn></th>
                                    <th><v-btn class="border teal" @click="action = $t('message.micro_pc.shutdownall'); removeConfirmShutdown(getMicroPCOnline)" :disabled="getMicroPCOnline.length == 0" small>{{ $t('message.micro_pc.shutdownall') }}</v-btn></th>
                                </template>
                                <template v-slot:items="drops">
                                    <td>{{ drops.item.microCode }}</td>
                                    <td v-if="drops.item.department">{{ drops.item.department.depCode }}</td>
                                    <td v-else></td>
                                    <td v-if="drops.item.line">{{ drops.item.line.lineCode }}</td>
                                    <td v-else></td>
                                    <td v-if="drops.item.isRunning" style="color: green;" class="text-xs-center">{{ $t('message.micro_pc.isRunning') }}</td>
                                    <td v-else  class="text-xs-center">{{ $t('message.micro_pc.notRunning') }}</td>
                                    <td align="center">
                                        <v-btn v-if="$hasRole($constants.roles.admin)" class="btnEdit" small @click="editMicroPC(drops.item)">{{ $t('message.micro_pc.edit') }}</v-btn>
                                        <v-btn v-if="$hasRole($constants.roles.admin)" color="error" class="btnDelete" small @click='removeConfirm(drops.item)'>{{
                                            $t('message.micro_pc.delete') }}
                                        </v-btn>
                                        <v-btn class="btnDetails" small @click="detailMicroPC(drops.item)">{{ $t('message.micro_pc.details') }}</v-btn>
                                    </td>
                                    <td class="text-xs-center"><v-btn class="border orange" :disabled="!isOnline(drops.item.microCode)" @click="action = $t('message.micro_pc.reboot'); removeConfirmReboot([drops.item])" small>{{ $t('message.micro_pc.reboot') }}</v-btn></td>
                                    <td class="text-xs-center"><v-btn class="border teal" :disabled="!isOnline(drops.item.microCode)" @click="action = $t('message.micro_pc.shutdown'); removeConfirmShutdown([drops.item])" small>{{ $t('message.micro_pc.shutdown') }}</v-btn></td>
                                </template>
                                <template v-slot:no-data>
                                    <td colspan="7" class="text-xs-center">{{ $t('message.no_data_table') }}</td>
                                </template>
                            </v-data-table>
                        </v-flex>
                    </v-layout>
                    <dialog-confirm v-if="showConfirmRemoveUser" @close="showConfirmRemoveUser = false" @agree="onDecided">
                        <span>MicroPc {{ micro_pc.microCode }} ?</span>
                    </dialog-confirm>
                    <shutdown-restart-confirm v-if="showConfirmReboot" @close="showConfirmReboot = false" @agree="onDecidedReboot">
                        <p class="orange" style="border-radius: 5px; display: block; padding: 10px; margin: 20px 40px 0px 40px;">{{ action.toLocaleUpperCase() }}</p>
                    </shutdown-restart-confirm>
                    <shutdown-restart-confirm v-if="showConfirmShutdown" @close="showConfirmShutdown = false" @agree="onDecidedShutDown">
                        <p class="teal" style="border-radius: 5px; display: block; padding: 10px; margin: 20px 40px 0px 40px;">{{ action.toLocaleUpperCase() }}</p>
                    </shutdown-restart-confirm>
                </v-flex>
                <v-flex xs4>
                    <form-micro-pc :statusMicroPC="statusMicroPC" :selectedDep="selectDepartment" :selectedMicroPC="selectedMicroPC" @resetStatusMicroPC="resetStatusMicroPC" ref="form"></form-micro-pc>
                </v-flex>
            </v-layout>
        </v-container>
    </div>
</template>

<script>
    import FormMicroPC from "./FormMicroPCComponent.vue";
    import {getMicroPcs , deleteMicroPc, shutDownMicroPCById, rebootMicroPCById} from '../../api/micro_pc';
    import {getDepartments} from '../../api/department';
    import { getCurrentUser } from  '../../api/user'
    import DialogConfirm from '../DeleteConfirm.vue'
    import ShutdownRestartConfirm from './ShutdownRestartConfirmComponent.vue'
    import { getLines } from  '../../api/line'
    import {PAPERLESS_CONST} from '../../constant'
    export default {
        name: "MicroPCRootComponent",
        components: {
            'form-micro-pc': FormMicroPC,
            'shutdown-restart-confirm': ShutdownRestartConfirm,
            'dialog-confirm': DialogConfirm
        },
        data() {
            return {
                statusMicroPC: '',
                selectedMicroPC: {},
                micro_pcs: [],
                microId:0,
                micro_pc: {},
                headers: [],
                dep: [],
                selectDepartment: 0,
                showConfirmRemoveUser: false,
                showConfirmReboot: false,
                showConfirmShutdown: false,
                errors: '',
                successDelete: '',
                lines: [],
                selectLine: 0,
                arr_micro_pc: [],
                socket : io("ws://paperless.tvn:6969/admin"),
                microOnlines: [],
                pagination: {
                    sortBy: 'microCode'
                },
                action: '',
                isRoleLine: false
            }
        },
        watch: {
            micro_pcs() {
                this.getMicroPCOnline;
            }
        },
        methods: {
            changeSort (column) {
                if (this.pagination.sortBy == column) {
                    this.pagination.descending = !this.pagination.descending
                } else {
                    this.pagination.sortBy = column;
                    this.pagination.descending = false
                }
            },
            addMicroPC () {
                this.$refs.form.resetMessages();
                this.$refs.form.resetDataMicroPC();
                this.selectedMicroPC = {};
                this.statusMicroPC = 'add';
            },
            editMicroPC (selectedItem) {
                this.$refs.form.resetMessages();
                this.$refs.form.resetDataMicroPC();
                this.statusMicroPC = 'edit';
                this.selectedMicroPC = selectedItem;
                this.$refs.form.initDataMicroPC();
            },
            detailMicroPC (selectedItem) {
                this.$refs.form.resetMessages();
                this.$refs.form.resetDataMicroPC();
                this.statusMicroPC = 'detail';
                this.selectedMicroPC = selectedItem;
                this.$refs.form.initDataMicroPC();
            },
            removeConfirm(value) {
                this.statusMicroPC = '';
                this.resetRootMessages();
                this.$refs.form.resetDataMicroPC();
                this.$refs.form.resetMessages();
                this.$refs.form.resetStatusMicroPC();
                this.showConfirmRemoveUser = true;
                this.microId = value.id;
                this.micro_pc = value;
            },
            removeConfirmReboot(micros) {
                this.arr_micro_pc = micros;
                this.showConfirmReboot = true;
            },
            removeConfirmShutdown(micros) {
                this.arr_micro_pc = micros;
                this.showConfirmShutdown = true;
            },
            resetRootMessages () {
                this.errors = '';
                this.successDelete = '';
            },
            getListMicroPc () {
                let _this = this;
                getMicroPcs()
                    .then(response => {
                        _this.micro_pcs = response;
                    })
                    .catch(err => console.log(err));
            },
            resetStatusMicroPC (value) {
                this.statusMicroPC = value;
                this.getListMicroPc();
            },
            fetchSelectBoxData () {
                getCurrentUser()
                   .then(response => {
                       this.fetchDepartments(response.depId);
                       this.fetchLines(response.depId);
                   })
                   .catch(err => {
                        console.log(err);
                    })
            },
            fetchDepartments(depId) {
                let _this = this;
                getDepartments()
                    .then(response => {
                        response.unshift({
                            depCode: ' ',
                            id: 0
                        });
                        _this.dep = response;
                        if(Roles == PAPERLESS_CONST.roles.line) {
                            _this.isRoleLine = true;
                            _this.selectDepartment = depId;
                            console.log('selectDepartment' ,_this.selectDepartment);
                        }
                    }).catch(err => {
                    console.log(err);
                })
            },
            onDecided (confirm) {
                this.showConfirmRemoveUser = false;
                this.resetRootMessages();
                if (confirm) {
                    let _this = this;
                    deleteMicroPc(this.microId)
                    .then(response => {
                        _this.successDelete = _this.$t('message.micro_pc.delete_success');
                        _this.getListMicroPc();
                    })
                    .catch(err => {
                        _this.errors = err.error_code;
                    });
                }
            },
            onDecidedReboot(confirm) {
                this.showConfirmReboot = false;
                if (confirm) {
                    this.reboot(this.arr_micro_pc);
                }
            },
            onDecidedShutDown(confirm) {
                this.showConfirmShutdown = false;
                if (confirm) {
                    this.shutdown(this.arr_micro_pc);
                }
            },
            fetchLines(depId) {
                let _this = this;
                getLines()
                    .then(response => {
                        if(Roles == PAPERLESS_CONST.roles.line) {
                            response = response.filter(line => line.user && line.user.depId == depId);
                        }
                        response.unshift({
                            lineCode: ' ',
                            id: 0
                        });
                        _this.lines = response;
                    }).catch( err => {
                        console.log(err);
                    })
            },
            shutdown(micros) {
                let shutDownMicroPCByIds = micros.map(({ id }) =>  shutDownMicroPCById(id) );
                Promise.all(shutDownMicroPCByIds).then(values => {
                    console.log(values);
                }).catch(error => {
                    console.log(error);
                });
            },
            reboot(micros) {
                let rebootMicroPCByIds = micros.map(({ id }) =>  rebootMicroPCById(id) );
                Promise.all(rebootMicroPCByIds).then(values => {
                    console.log(values);
                }).catch(error => {
                    console.log(error);
                });
            },
            isOnline(microCode) {
                let i = 0;
                for (; i < this.getMicroPCOnline.length; i++) {
                    if (microCode ==  this.getMicroPCOnline[i].microCode) {
                        break;
                    }
                }
                return !(i == this.getMicroPCOnline.length);
            }
        },
        computed: {
            filteredItems() {
                return this.micro_pcs.filter((i) => {
                    if(this.selectDepartment == 0 && this.selectLine == 0) {
                        return this.micro_pcs;
                    }
                    if(this.selectDepartment == 0 && this.selectLine != 0) {
                        return (i.lineId == this.selectLine)
                    }
                    if(this.selectDepartment != 0 && this.selectLine == 0) {
                        return (i.depId == this.selectDepartment);
                    }
                    if(this.selectDepartment != 0 && this.selectLine != 0) {
                        return (i.depId == this.selectDepartment && i.lineId == this.selectLine);
                    }
                })
            },
            getMicroPCOnline() {
                let microPcOnline = [];
                let _this = this;
                for(let indexMicro = 0; indexMicro < this.microOnlines.length; indexMicro++) {
                    let micro = (this.filteredItems.filter(micros => micros.microCode == this.microOnlines[indexMicro].microCode))[0];
                    if(micro) {
                        microPcOnline.push(micro);
                    }
                }
                return microPcOnline;
            }
        },
        created () {
            this.getListMicroPc();
            this.fetchSelectBoxData();
        },
        mounted() {
            let _this = this;
            this.socket.on('update-sockets', function (microOnlines) {
                _this.microOnlines = microOnlines;
            });
        },
    }
</script>

<style>
    #micro_pc {
        width: 100%;
        padding-top: 0;
    }

    #micro {
        margin-left: 15px;
        margin-right: 20px;
        margin-top: 10px;
    }

    .border {
        border: 1px solid #ccc;
        border-color: #000 !important;
        border-radius: 5px;
    }

    #micro_pc .btnAdd {
        margin: 0 1px 15px 0  !important;
    }

    #micro_pc table thead {
        background: #ccc !important;
    }

    #micro_pc table.theme--light thead tr th {
        font-weight: bold;
        color: #000;
        border: 1px solid #000;
        width: auto;
        font-size: 15px;
    }

    #micro_pc .list-micro_pc td {
        border: 1px solid #000;
    }

    #micro_pc .list-micro_pc tbody
    {
        background-color: #fafafa;
    }

    #micro_pc .flex.xs8 > .container {
        padding-top: 11px;
    }

    #form-data {
        padding: 0;
    }

    #success.root-message {
        top: -4% !important;
        width: 50%;
    }

    #error.root-message {
        top: -4% !important;
        width: 50%;
    }

    #part > div {
        padding: 7px 16px;
    }

    #part + .flex.xs3>.v-input {
        padding-top: 0;
        margin-top: 0;
    }

    #line > div {
        padding: 7px 16px;
    }

    #line + .flex.xs3>.v-input {
        padding-top: 0;
        margin-top: 0;
    }
</style>


