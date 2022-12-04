<template>
    <div id="line-root">
        <v-layout row>
            <v-flex xs8 id="line">
                <v-layout row>
                    <v-flex xs10>
                        <div v-if="successDelete" class="root-message noborder-message">
                                <v-alert value="true" color="success" icon="check_circle" outline transition="scale-transition" dismissible>
                                {{ successDelete }}.
                                </v-alert>
                            </div>
                        <div class="root-message noborder-message" v-if="errorDelete">
                            <v-alert value="true" color="error" icon="warning" outline transition="scale-transition" dismissible>
                                <ul>
                                    <li>{{ errorDelete }}</li>
                                </ul>
                            </v-alert>
                        </div>
                    </v-flex>
                    <v-flex xs2>
                        <v-btn @click="addLine()" class="btnAdd">{{ $t('message.line.add') }}</v-btn>
                    </v-flex>
                </v-layout>
                <v-layout row>
                    <v-flex xs12>
                        <v-data-table
                                :rows-per-page-text="$t('message.paginate')"
                                :headers="headers"
                                :items="lines"
                                class="list-line"
                                :pagination.sync="pagination"
                                :rows-per-page-items= '[10,25,{"text":"$vuetify.dataIterator.rowsPerPageAll","value":-1}]'
                        >
                            <template slot="headers" slot-scope="props">
                                <th :class="['column sortable', pagination.descending ? 'desc' : 'asc', 'lineCode' == pagination.sortBy ? 'active' : '']" @click="changeSort('lineCode')">
                                    <v-icon small>arrow_upward</v-icon>{{ $t('message.line.line_code') }}
                                </th>
                                <th :class="['column sortable', pagination.descending ? 'desc' : 'asc', 'user.department.depCode' == pagination.sortBy ? 'active' : '']" @click="changeSort('user.department.depCode')">
                                    <v-icon small>arrow_upward</v-icon>{{ $t('message.line.line_department') }}
                                </th>
                                <th :class="['column sortable', pagination.descending ? 'desc' : 'asc', 'user.userCode' == pagination.sortBy ? 'active' : '']" @click="changeSort('user.userCode')">
                                    <v-icon small>arrow_upward</v-icon>{{ $t('message.line.line_user') }}
                                </th>
                                <th :class="['column sortable', pagination.descending ? 'desc' : 'asc', 'isRunning' == pagination.sortBy ? 'active' : '']" @click="changeSort('isRunning')">
                                    <v-icon small>arrow_upward</v-icon>{{ $t('message.line.status') }}
                                </th>
                                <th>{{ $t('message.line.line_action') }}</th>
                            </template>
                            <template v-slot:items="props">
                                <td>{{ props.item.lineCode }}</td>
                                <td v-if='props.item.user && props.item.user.department'>{{ props.item.user.department.depCode }}</td>
                                <td v-else></td>
                                <td v-if='props.item.user'>{{ props.item.user.userCode }}</td>
                                <td v-else></td>
                                <td v-if="props.item.isRunning" style="color: green;" class="text-xs-center">{{ $t('message.line.isRunning') }}</td>
                                <td v-else  class="text-xs-center">{{ $t('message.line.notRunning') }}</td>
                                <td align="center">
                                    <v-btn @click="editLine(props.item)" class="btnEdit" small>{{ $t('message.line.edit') }}</v-btn>
                                    <v-btn @click='removeConfirm(props.item)' color="error" class="btnDelete" small>{{ $t('message.line.delete') }}</v-btn>
                                    <v-btn @click="detailLine(props.item)" class="btnDetails" small>{{ $t('message.line.details') }}</v-btn>
                                </td>
                            </template>
                            <template v-slot:no-data>
                                <td colspan="5" class="text-xs-center">{{ $t('message.no_data_table') }}</td>
                            </template>
                        </v-data-table>
                        <DialogConfirm v-if="showConfirmRemoveLine" @close="showConfirmRemoveLine = false" @agree="onDecided">
                            <span>{{ dataDelete.lineCode }} ?</span>
                        </DialogConfirm>
                    </v-flex>
                </v-layout>
            </v-flex>
            <v-spacer style="width:50px;"></v-spacer>
            <v-flex xs4 id='list-micropc'>
                <component ref="refAddOrEditLine" :is="'create-or-edit'" :statusLine="statusLine" :dataEditLine='line' @resetStatusLine="resetStatusLine"></component>
                <component ref="refAssignMicroPC" :is="'ListMicroPC'" :statusLine="statusLine" :dataDetailLine='line'></component>
            </v-flex>
        </v-layout>
    </div>
</template>

<script>
import  CreateOrEdit from "./AddOrEditLineComponent.vue";
import  ListMicroPC from "./MicroPcComponent.vue";
import { getLines, deleteLine } from  '../../api/line'
import DialogConfirm from '../DeleteConfirm.vue'
export default {
    name: "LineRootComponent",
    data() {
        return {
            lines: [],
            line:{},
            dataDelete: {},
            errorDelete: '',
            successDelete: '',
            lineId: 0,
            showConfirmRemoveLine: false,
            statusLine: '',
            headers: [],
            pagination: {
                sortBy: 'lineCode'
            }
        }
    },
    components: {
        CreateOrEdit,
        DialogConfirm,
        ListMicroPC
    },
    watch: {
        statusLine() {
            if(this.statusLine == '') {
                this.$refs.refAssignMicroPC.setInitData()
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
        fetchLines() {
            getLines()
            .then(response => {
                this.lines = response;
            }).catch( err => {
                console.log(err);
            })
        },
        resetStatusLine(value)
        {
            this.statusLine = value;
            this.fetchLines();
        },
        resetRootMessages() {
            this.errorDelete = '';
            this.successDelete = '';
        },
        addLine() {
            this.resetRootMessages();
            this.$refs.refAddOrEditLine.setInitData();
            this.$refs.refAddOrEditLine.initDataLine();
            this.statusLine = 'create';
            this.$store.state.microPcs = [];
            this.$store.state.departmentId = null;
            this.$refs.refAssignMicroPC.setInitData();
        },
        editLine(value) {
            this.statusLine = 'edit';
            this.line = value;
            this.resetRootMessages();
            this.$refs.refAddOrEditLine.setInitData();
            if(value.user) {
                this.$refs.refAddOrEditLine.fetchUserByDepartment(value.user.depId);
            }
            this.$refs.refAssignMicroPC.fetchMicrosByDepIdWidthLineIdCurrentOrNull(value.id, value.user.depId)
        },
        detailLine(value) {
            this.line = value;
            this.resetRootMessages();
            this.$refs.refAddOrEditLine.setInitData();
            if(value.user) {
                this.$refs.refAddOrEditLine.fetchUserByDepartment(value.user.depId);
            }
            this.$refs.refAssignMicroPC.setDataDetail();
            this.$refs.refAssignMicroPC.fetchMicroByLineId(value.id);
            this.statusLine = 'detail'
        },
        removeConfirm(value) {
            this.statusLine = '';
            this.resetRootMessages();
            this.$refs.refAddOrEditLine.resetStatusLine();
            this.showConfirmRemoveLine = true;
            this.lineId = value.id;
            this.dataDelete = value
        },
        onDecided (confirm) {
            this.showConfirmRemoveLine = false;
            this.resetRootMessages();
            if (confirm) {
                let _this = this;
                deleteLine(this.lineId)
                    .then(response => {
                        _this.successDelete = _this.$t('message.line.delete_success');
                        _this.fetchLines();
                    }).catch( err => {
                        console.log(err);
                        this.errorDelete = err.error_code
                    })
            }
        }
    },
    created() {
        this.fetchLines()
    }
}
</script>

<style>
#line-root {
    width: 96%;
    margin: 0 auto;
    margin-top: 20px;
}

#line {
    margin-left: 5px;
}

#line .btnAdd {
    margin: -17px 1px 20px -25px !important;
}

#line table thead {
    background: #ccc !important;
}

#line table.theme--light thead tr th {
    font-weight: bold;
    color: #000;
    border: 1px solid #000;
    width: auto;
    font-size: 15px;
}

#line .list-line td {
    border: 1px solid #000;
}

#line .list-line tbody {
    background-color: #fafafa;
}

#list-micropc {
    margin-top: -20px;
    margin-left: -30px;
    margin-right: -10px;
}
</style>
