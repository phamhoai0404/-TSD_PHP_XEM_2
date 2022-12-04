<template>
    <div>
        <v-container class="department-root" id="department" fluid>
            <v-layout row>
                <v-flex xs8 id="depart">
                    <v-layout row>
                        <v-flex xs10>
                            <div v-if="successDelete" class="root-message noborder-message" >
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
                            <v-btn class="btnAdd" @click="addDepartment()">{{ $t('message.department.add') }}</v-btn>
                        </v-flex>
                    </v-layout>
                    <v-layout row>
                        <v-flex xs12>
                            <v-data-table
                                :rows-per-page-text="$t('message.paginate')"
                                :headers="headers"
                                :items="departments"
                                class="list-department"
                                :pagination.sync="pagination"
                                :rows-per-page-items= '[10,25,{"text":"$vuetify.dataIterator.rowsPerPageAll","value":-1}]' fix-header
                            >
                                <template v-slot:headers="props">
                                    <tr>
                                        <th :class="['column sortable', pagination.descending ? 'desc' : 'asc', 'depCode' == pagination.sortBy ? 'active' : '']"
                                            @click="changeSort('depCode')"
                                        ><v-icon small>arrow_upward</v-icon>{{ $t('message.department.department_code') }}</th>
                                        <th :class="['column sortable', pagination.descending ? 'desc' : 'asc', 'depName' == pagination.sortBy ? 'active' : '']"
                                            @click="changeSort('depName')"
                                        ><v-icon small>arrow_upward</v-icon>{{ $t('message.department.department_name') }}</th>
                                        <th>{{ $t('message.department.department_action') }}</th>
                                    </tr>
                                </template>
                                <template v-slot:items="props">
                                    <tr>
                                        <td>{{ props.item.depCode }}</td>
                                        <td>{{ props.item.depName }}</td>
                                        <td style="text-align: center"><v-btn @click="editDepartment(props.item)" class="btnEdit" small>{{ $t('message.department.edit') }}</v-btn>
                                            <v-btn @click='removeConfirm(props.item)' color="error" class="btnDelete" small>{{ $t('message.department.delete') }}</v-btn>
                                            <v-btn class="btnDetails" small @click="detailDepartment(props.item)">{{ $t('message.department.details') }}</v-btn>
                                        </td>
                                    </tr>
                                </template>
                                <template v-slot:no-data>
                                    <tr>
                                        <td colspan="3" class="text-xs-center">{{ $t('message.no_data_table') }}</td>
                                    </tr>
                                </template>
                            </v-data-table>
                            <DialogConfirm v-if="showConfirmRemoveDepartment" @close="showConfirmRemoveDepartment = false" @agree="onDecided">
                                <span>{{ dataDelete.depCode }} - {{ dataDelete.depName }} ?</span>
                            </DialogConfirm>
                        </v-flex>
                    </v-layout>
                </v-flex>
                <v-flex xs4>
                    <component ref="refAddOrEditDepartment" :dataEditDepartment='department' :is="'create-or-edit'" :statusDepartment="statusDepartment" @resetStatusDepartment="resetStatusDepartment"></component>
                </v-flex>
            </v-layout>
        </v-container>
    </div>
</template>

<script>
    import  CreateOrEdit from "./AddOrEditDepartmentComponent.vue";
    import {getDepartments, deleteDepartment} from  '../../api/department'
    import DialogConfirm from '../DeleteConfirm.vue'
    export default {
        name: "DepartmentRootComponent",
        components: {
            CreateOrEdit,
            DialogConfirm
        },
        data() {
            return {
                departments: [],
                dataDelete: {},
                errorDelete: '',
                successDelete: '',
                showConfirmRemoveDepartment: false,
                departmentId: 0,
                department: {},
                headers: [],
                statusDepartment: '',
                pagination: {
                    sortBy: 'depCode'
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
            fetchDepartments(){
                getDepartments()
                    .then(response => {
                        this.departments = response;
                    }).catch( err => {
                    console.log(err);
                })
            },
            resetRootMessages() {
                this.errorDelete = '';
                this.successDelete = '';
            },
            addDepartment() {
                this.resetRootMessages();
                this.statusDepartment = 'create';
                this.$refs.refAddOrEditDepartment.initDataDepartment();
                this.$refs.refAddOrEditDepartment.resetMessages();
            },
            removeConfirm(value) {
                this.resetRootMessages();
                this.statusDepartment = '';
                this.$refs.refAddOrEditDepartment.revertStatusDepartment();
                this.showConfirmRemoveDepartment = true;
                this.departmentId = value.id;
                this.dataDelete = value
            },
            onDecided (confirm) {
                this.showConfirmRemoveDepartment = false;
                this.resetRootMessages();
                if (confirm) {
                    let _this = this;
                    deleteDepartment(this.departmentId)
                        .then(response => {
                            _this.fetchDepartments();
                            _this.successDelete = _this.$t('message.department.delete_success');
                        }).catch( err => {
                        _this.errorDelete = err.error_code;
                        console.log(err);
                    })
                }
            },
            resetStatusDepartment(value)
            {
                this.statusDepartment = value;
                this.fetchDepartments();
            },
            editDepartment(value)
            {
                this.resetRootMessages();
                this.statusDepartment = 'edit';
                this.$refs.refAddOrEditDepartment.setInitData();
                this.department = value
            },
            detailDepartment(value)
            {
                this.resetRootMessages();
                this.statusDepartment = 'detail';
                this.$refs.refAddOrEditDepartment.setInitData();
                this.department = value
            }

        },
        created(){
            this.fetchDepartments()
        }
    }
</script>

<style>
    .list-department .v-table__overflow table.v-table thead tr:first-child {
        height: 45px !important;
    }

    #department {
        width: 98%;
        margin: 0 auto;
    }

    #department  table thead {
        background: #ccc !important;
        height: 45px !important;
    }

    #department table.theme--light thead tr th {
        font-weight: bold;
        color: #000;
        border: 1px solid #000;
        width: auto;
        font-size: 15px;
    }

    #department .list-department td {
        border: 1px solid #000;
    }

    #department .list-department tbody {
        background-color: #fafafa;

    }

    #department a.close {
        float: right;
    }
</style>
