<template>
    <div>
        <v-container class="pc-root" id="pc" fluid>
            <v-layout row>
                <v-flex xs8 id="controlpc">
                    <v-layout row>
                        <v-flex xs10>
                            <div v-if="successDelete" class="root-message noborder-message">
                                <v-alert value="true" color="success" icon="check_circle" outline transition="scale-transition" dismissible>
                                {{ successDelete }}.
                                </v-alert>
                            </div>
                            <div v-if="errorDelete" class="root-message noborder-message">
                                <v-alert value="true" color="error" icon="warning" outline transition="scale-transition" dismissible>
                                    <span>
                                        <ul>
                                            <li>{{ errorDelete }}</li>
                                        </ul>
                                    </span>
                                </v-alert>
                            </div>
                        </v-flex>
                        <v-flex xs2>
                            <v-btn class="btnAdd" @click="addControlPc()">{{ $t('message.pc.add') }}</v-btn>
                        </v-flex>
                    </v-layout>
                    <v-layout row>
                        <v-flex xs12>
                            <v-data-table
                                    :rows-per-page-text="$t('message.paginate')"
                                    :headers="headers"
                                    :items="controlpcs"
                                    class="list-pc"
                                    :pagination.sync="pagination"
                                    :rows-per-page-items= '[10,25,{"text":"$vuetify.dataIterator.rowsPerPageAll","value":-1}]'
                            >
                                <template slot="headers" slot-scope="props">
                                    <th :class="['column sortable', pagination.descending ? 'desc' : 'asc', 'controlpcCode' == pagination.sortBy ? 'active' : '']" @click="changeSort('controlpcCode')">
                                        <v-icon small>arrow_upward</v-icon>{{ $t('message.pc.controlpcCode') }}
                                    </th>
                                    <th :class="['column sortable', pagination.descending ? 'desc' : 'asc', 'ipAddress' == pagination.sortBy ? 'active' : '']" @click="changeSort('ipAddress')">
                                        <v-icon small>arrow_upward</v-icon>{{ $t('message.pc.ip_address') }}
                                    </th>
                                    <th>{{ $t('message.pc.pc_action') }}</th>
                                </template>
                                <template v-slot:items="drops">
                                    <td>{{ drops.item.controlpcCode }}</td>
                                    <td>{{ drops.item.ipAddress }}</td>
                                    <td align="center"><v-btn @click="editControlPc(drops.item)" class="btnEdit" small>{{ $t('message.pc.edit') }}</v-btn>
                                        <v-btn @click='removeConfirm(drops.item)' color="error" class="btnDelete" small>{{ $t('message.pc.delete') }}</v-btn>
                                        <v-btn class="btnDetails" small @click="detailControlPc(drops.item)">{{ $t('message.pc.details') }}</v-btn>
                                    </td>
                                </template>
                                <template v-slot:no-data>
                                    <td colspan="3" class="text-xs-center">{{ $t('message.no_data_table') }}</td>
                                </template>
                            </v-data-table>
                            <DialogConfirm v-if="showConfirmRemoveControlPc" @close="showConfirmRemoveControlPc = false" @agree="onDecided">
                                <span>{{ dataDelete.controlpcCode }}</span>
                            </DialogConfirm>
                        </v-flex>
                    </v-layout>
                </v-flex>
                <v-flex xs4>
                    <component ref="refAddOrEditControlPc" :dataEditControlPc='controlpc' :is="'create-or-edit'" :statusControlPc="statusControlPc" @resetStatusControlPc="resetStatusControlPc"></component>
                </v-flex>
            </v-layout>
        </v-container>
    </div>
</template>

<script>
	import CreateOrEdit from '../pc/AddOrEditControlPcComponent.vue'
    import {getControlPcs , deleteControlPc} from  '../../api/pc'
    import DialogConfirm from '../DeleteConfirm.vue'
    export default {
        name: "PCRootComponent",
        components: {
          CreateOrEdit,
          DialogConfirm
        },
        data() {
            return {
                controlpcs: [],
                dataDelete: {},
                errorDelete: '',
                successDelete: '',
                showConfirmRemoveControlPc: false,
                controlpcId: 0,
                controlpc: {},
                headers: [],
                statusControlPc: '',
                pagination: {
                    sortBy: 'controlpcCode'
                }
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
            fetchControlPcs(){
                getControlPcs()
                .then(response => {
                    this.controlpcs = response;
                }).catch( err => {
                    console.log(err);
                })
            },
            resetRootMessages() {
                this.errorDelete = '';
                this.successDelete = '';
            },
            addControlPc() {
                this.resetRootMessages();
                this.statusControlPc = 'create';
                this.$refs.refAddOrEditControlPc.initDataControlPc();
                this.$refs.refAddOrEditControlPc.resetMessages();
            },
            removeConfirm(value) {
                this.resetRootMessages();
                this.statusControlPc = '';
                this.$refs.refAddOrEditControlPc.revertStatusControlPc();
                this.showConfirmRemoveControlPc = true;
                this.controlpcId = value.id;
                this.dataDelete = value
            },
            onDecided (confirm) {
                this.showConfirmRemoveControlPc = false;
                this.resetRootMessages();
                if (confirm) {
                    let _this = this;
                    deleteControlPc(this.controlpcId)
                        .then(response => {
                            _this.fetchControlPcs();
                            _this.successDelete = _this.$t('message.pc.delete_success');
                        }).catch( err => {
                            _this.errorDelete = err.error_code;
                            console.log(err);
                        })
                }
            },
            resetStatusControlPc(value)
            {
                this.statusControlPc = value;
                this.fetchControlPcs();
            },
            editControlPc(value)
            {
                this.resetRootMessages();
                this.statusControlPc = 'edit';
                this.$refs.refAddOrEditControlPc.setInitData();
                this.controlpc = value;
            },
            detailControlPc(value)
            {
                this.resetRootMessages();
                this.statusControlPc = 'detail';
                this.$refs.refAddOrEditControlPc.setInitData();
                this.controlpc = value;
            }

        },
        created(){
            this.fetchControlPcs();

        }
    }
</script>

<style>
    #pc {
        width: 98%;
        margin: 0 auto;
    }

    #pc  table thead {
        background: #ccc !important;
    }

    #pc table.theme--light thead tr th {
        font-weight: bold;
        color: #000;
        border: 1px solid #000;
        width: auto;
        font-size: 15px;
    }

    #pc .list-pc td {
        border: 1px solid #000;
    }

    #pc .list-pc tbody {
        background-color: #fafafa;
    }

    #pc a.close {
        float: right;
    }

    #pc #error.errors .v-alert {
        height: 26px;
        padding: 0;
    }
</style>
