<template>
    <div>
        <v-container class="user-root" id="user" fluid>
            <v-layout row>
                <v-flex xs8 id="users">
                    <v-layout row>
                        <v-flex xs10>
                            <div class="root-message noborder-message" v-if="successDelete">
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
                            <v-btn class="btnAdd" @click="addUser()">{{ $t('message.user.create') }}</v-btn>
                        </v-flex>
                    </v-layout>
                    <v-layout>
                        <v-flex xs12>
                            <v-data-table
                              :headers="headers"
                              :items="users"
                              class="list-user"
                              :pagination.sync="pagination"
                              :rows-per-page-items= '[10,25,{"text":"$vuetify.dataIterator.rowsPerPageAll","value":-1}]'
                              :rows-per-page-text="$t('message.paginate')"
                            >
                              <template  slot="headers" slot-scope="props">
                                <th :class="['column sortable', pagination.descending ? 'desc' : 'asc', 'userCode' == pagination.sortBy ? 'active' : '']" @click="changeSort('userCode')">
                                    <v-icon small>arrow_upward</v-icon>{{ $t('message.user.ma_nv') }}
                                </th>
                                <th :class="['column sortable', pagination.descending ? 'desc' : 'asc', 'department.depCode' == pagination.sortBy ? 'active' : '']" @click="changeSort('department.depCode')">
                                    <v-icon small>arrow_upward</v-icon>{{ $t('message.user.bo_phan') }}
                                </th>
                                <th :class="['column sortable', pagination.descending ? 'desc' : 'asc', 'subuser' == pagination.sortBy ? 'active' : '']" @click="changeSort('subuser')">
                                    <v-icon small>arrow_upward</v-icon>{{ $t('message.user.vai_tro') }}
                                </th>
                                <th>{{ $t('message.user.thao_tac') }}</th>
                              </template>
                              <template v-slot:items="drops">
                                <tr :id="'tr'+ drops.item.id">
                                    <td >{{ drops.item.userCode }}</td>
                                    <td v-if="drops.item.department">{{ drops.item.department.depCode }}</td>
                                    <td v-else></td>
                                    <td v-if="drops.item.subuser">{{ drops.item.subuser }}</td>
                                    <td v-else></td>
                                    <td align="center">
                                        <v-btn @click="editUser(drops.item.id)" class="btnEdit " small>{{ $t('message.user.edit') }}</v-btn>
                                        <v-btn color="error " class="btnDelete" small @click='removeConfirm(drops.item)' v-if="drops.item.id != currentUser.id">{{ $t('message.user.delete') }}</v-btn>
                                        <v-btn @click="editPassUsers(drops.item.id)" class="btnReset " small>{{ $t('message.user.reset_password') }}</v-btn>
                                    </td>
                                </tr>
                              </template>
                              <template v-slot:no-data>
                                    <td colspan="4" class="text-xs-center">{{ $t('message.no_data_table') }}</td>
                                </template>
                            </v-data-table>
                        </v-flex>
                    </v-layout>
                    <DialogConfirm v-if="showConfirmRemoveUser" @close="showConfirmRemoveUser = false" @agree="onDecided">
                        <span> <p> - {{ $t('message.user.ma_nv') }} : {{ dataUsers.userCode }} <br> - {{ $t('message.alert.role') }} : {{ dataUsers.subuser }} ? </p>  </span>
                    </DialogConfirm>
                </v-flex>
                <v-flex xs4>
                    <component ref='refAddOrEditUser' :is="'create-or-edit-user'" :dataEditUser='user' :statusUser="statusUser" @resetStatusUser="resetStatusUser"></component>
                    <component ref='refEditPassUser' :is="'reset-pass-user'" :editPassUser="editPassUser" @revertStatus="editPassUser = $event" :infoUser='infoUser'></component>
                </v-flex>
    </v-layout>
        </v-container>
    </div>
</template>

<script>

    import { getUser, getUsers, deleteUser, updateUser,getCurrentUser } from  '../../api/user'
    import DialogConfirm from '../DeleteConfirm.vue'
    import AddOrEditUser from "./AddOrEditUserComponent.vue";
    import ResetPassUserComponent from "./ResetPassUserComponent.vue";
    export default {
        name: "UserRootComponent",
        components: {
            DialogConfirm,
            'create-or-edit-user': AddOrEditUser,
            'reset-pass-user': ResetPassUserComponent,
        },
        data() {
            return {
                users: [],
                user: {},
                infoUser: {},
                userId: 0,
                dataUsers: {},
                errorDelete: '',
                successDelete:'',
                showConfirmRemoveUser: false,
                statusUser: '',
                headers: [],
                editPassUser: false,
                currentUser: {},
                pagination: {
                    sortBy: 'userCode'
                }
            }
        },
        methods:{
            changeSort (column) {
                if (this.pagination.sortBy == column) {
                    this.pagination.descending = !this.pagination.descending
                } else {
                    this.pagination.sortBy = column;
                    this.pagination.descending = false
                }
            },
            removeConfirm(value) {
                this.resetRootMessages();
                this.showConfirmRemoveUser = true;
                this.statusUser = '';
                this.editPassUser = false;
                this.$refs.refAddOrEditUser.revertStatusUser();
                this.$refs.refEditPassUser.initDataUser();
                this.userId = value.id;
                this.dataUsers = value;

            },
            onDecided (confirm) {
                this.showConfirmRemoveUser = false;
                this.resetRootMessages();
                if (confirm) {
                    let _this = this;
                    deleteUser(this.userId)
                        .then(response => {
                            _this.fetchData();
                            _this.successDelete = _this.$t('message.info_user.delete');
                        }).catch( err => {
                            this.errorDelete = err.error_code;
                            console.log(err);
                        })
                }
            },
            resetRootMessages() {
                this.errorDelete = '';
                this.successDelete = '';
            },
            fetchData(){
                let _this = this;
                getUsers()
                .then(response => {
                        for(const user of response)
                            {
                                if(user.roleName[0]) {
                                    user.subuser = _this.$t('message.info_user.' + user.roleName[0]);
                                }
                        }
                        _this.users = response;
                    }).catch( err => {
                        console.log(err);
                    })
            },
            addUser: function() {
                this.statusUser = 'create';
                this.resetRootMessages();
                this.$refs.refAddOrEditUser.initDataUser();
                this.$refs.refAddOrEditUser.resetMessages();
            },
            editUser: function(id) {
                this.statusUser = 'edit';
                this.resetRootMessages();
                this.$refs.refAddOrEditUser.setInitData();
                let _this = this;

                getUser(id)
                .then(response => {
                    _this.user = response;
                }).catch( err => {
                    console.log(err);
                })
            },
            editPassUsers: function(id) {
                this.editPassUser = true;
                this.resetRootMessages();
                this.$refs.refEditPassUser.resetMessages();
                let _this = this;
                getUser(id)
                .then(response => {
                    _this.infoUser = response;
                }).catch( err => {
                    console.log(err);
                })
            },
            resetStatusUser(value) {
                this.statusUser = value;
                this.fetchData();
            },
            getCurUser : function () {
                let _this = this;
                getCurrentUser()
                   .then(response => {
                       _this.currentUser = response;
                   })
                   .catch(err => {
                        console.log(err);
                    })
            },
        },
        created() {
            this.getCurUser();
        	this.fetchData();
            this.statusAddUser = 'edit';
        }
    }

</script>

<style >
    .theme--light.v-table thead tr:first-child {
        height: 45px !important;
    }

    #user .close {
        float: right;
    }

    #user {
        width: 100%;
    }

    #users {
        margin-right: 20px;
        margin-left: 15px;
    }

    #user  table thead {
        background: #ccc !important;
    }

    #user table.theme--light thead tr th {
        font-weight: bold;
        color: #000;
        border: 1px solid #000;
        font-size: 15px;
    }

    #user .list-user td {
        border: 1px solid #000;
    }

    #user .list-user tbody {
        background-color: #fafafa;
    }

    #user #error.errors .v-alert {
        height: 26px;
        padding: 0;
    }

    button.error {
        background-color: #ff5252 !important;
        border-color: #000 !important;
    }

</style>
