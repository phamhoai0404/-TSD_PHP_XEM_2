<template>
<div id="create-user">
    <fieldset :disabled="statusUser != 'create' && statusUser != 'edit'">
        <legend>{{ $t('message.info_user.user_infor') }}</legend>
        <div class="noborder-message" v-if="success.length > 0">
            <v-alert value="true" color="success" icon="check_circle" outline transition="scale-transition" dismissible>
                {{ success }}
            </v-alert>
        </div>
        <div class="noborder-message" v-if="errors.password || errors.userCode || errors.confirmPassword || errors.errorLine || errors.error_code || errors.depId || errors.roleId">
            <v-alert value="true" color="error" icon="warning" outline transition="scale-transition" dismissible>
                <span v-if="errors.password">
                    <ul v-for='(error, i) in errors.password' :key="'password' + i">
                        <li>{{ error }}</li>
                    </ul>
                </span>
                <span v-if="errors.userCode">
                    <ul v-for='(error, i) in errors.userCode' :key="'userCode' + i">
                        <li>{{ error }}</li>
                    </ul>
                </span>
                <span v-if="errors.depId">
                    <ul v-for='(error, i) in errors.depId' :key="'depId' + i">
                        <li>{{ error }}</li>
                    </ul>
                </span>
                <span v-if="errors.roleId">
                    <ul v-for='(error, i) in errors.roleId' :key="'roleId' + i">
                        <li>{{ error }}</li>
                    </ul>
                </span>
                <span v-if="errors.error_code">
                    <ul>
                        <li>{{ errors.error_code }}</li>
                    </ul>
                </span>
                <span v-if="errors.confirmPassword">
                    <ul v-for='(error, i) in errors.confirmPassword' :key="'confirmPassword' + i">
                        <li>{{ error }}</li>
                    </ul>
                </span>
                <span v-if="errors.errorLine">
                    <ul>
                        <li>{{ errors.errorLine }}</li>
                    </ul>
                </span>
            </v-alert>
        </div>
        <v-container fluid>
            <v-layout row>
                <v-flex xs3 style="min-width: 100px;">
                    <v-card-title>{{ $t('message.info_user.employee_code') }}</v-card-title>
                </v-flex>
                <v-flex >
                    <v-text-field :disabled="statusUser == 'edit'" solo id="input-user" v-model="dataUser.userCode"></v-text-field>
                </v-flex>
            </v-layout>
            <v-layout row>
                <v-flex xs3 style="min-width: 100px;">
                    <v-card-title>{{ $t('message.info_user.roles') }}</v-card-title>
                </v-flex>
                <v-select :disabled="statusUser != 'create' || statusUser == 'edit'" :items="selectRoles" item-value='id' item-text='sub_name' v-model="dataUser.roleId" :menu-props="{ nudgeTop: -8, offsetY: ''}"></v-select>
            </v-layout>
            <v-layout row>
                <v-flex xs3 style="min-width: 100px;">
                    <v-card-title>{{ $t('message.info_user.parts') }}</v-card-title>
                </v-flex>
                <v-select :items="selectParts" item-value='id' item-text='depCode' v-model="dataUser.depId" :menu-props="{ nudgeTop: -8, offsetY: ''}"></v-select>
            </v-layout>
            <v-layout row v-if="statusUser == 'create'" :disabled="statusUser != 'create'">
                <v-flex xs3 style="min-width: 100px;">
                    <v-card-title>{{ $t('message.info_user.password') }}</v-card-title>
                </v-flex>
                <v-text-field solo id="password-user" type="password" v-model="dataUser.password"></v-text-field>
            </v-layout>
            <v-layout row v-if="statusUser == 'create'" :disabled="statusUser != 'create'">
                <v-flex xs3 style="min-width: 100px;">
                    <v-card-title>{{ $t('message.info_user.confirmPassword') }}</v-card-title>
                </v-flex>
                <v-text-field solo id="confirm-password-user" type="password" v-model="dataUser.confirmPassword"></v-text-field>
            </v-layout>
            <v-layout row>
                <v-flex xs3 style="min-width: 100px;">
                    <v-card-title>{{ $t('message.info_user.note') }} </v-card-title>
                </v-flex>
                <v-textarea solo v-model="dataUser.note"></v-textarea>
            </v-layout>
            <v-layout row>
                <v-flex xs3 style="min-width: 100px;"></v-flex>
                <v-btn @click="saveDataUser(dataUser.id)" :disabled="statusUser != 'create'&& statusUser != 'edit'">{{ $t('message.info_user.save') }}</v-btn>
                <v-btn @click="revertStatusUser()" :disabled="statusUser != 'create'&& statusUser != 'edit'">{{ $t('message.info_user.cancel') }}</v-btn>
            </v-layout>
        </v-container>
    </fieldset>
</div>
</template>

<script>
import { map } from 'lodash';
import { PAPERLESS_CONST } from '../../constant';
import { createNewUser, updateUser } from '../../api/user';
import { getRoles } from '../../api/roles';
import { getDepartments } from  '../../api/department';
export default {
    props: {
        statusUser: {
            type: String,
            default: ''
        },
        dataEditUser: {
            type: Object,
            default: () => {
                return {}
            }
        }
    },
    watch: {
        dataEditUser() {
            this.setInitData();
        },
        errors(value) {
            this.errors = value;
        }
    },
    data() {
        return {
            selectRoles: [],
            selectParts: [],
            addStatusUser: '',
            dataUser: {
                userCode: '',
                roleId: 0,
                depId: 0,
                note: '',
                password: '',
                confirmPassword: ''
            },
            errors: {},
            success: '',
        }
    },
    methods: {
        initDataUser: function () {
            this.dataUser.userCode = '';
            this.dataUser.roleId = null;
            this.dataUser.depId = null;
            this.dataUser.note = '';
            this.dataUser.password = '';
            this.dataUser.confirmPassword = '';
        },
        setInitData() {
            this.resetMessages();
            this.addStatusUser = this.statusUser;
            this.dataUser = this.dataEditUser;
            for (let role in this.dataUser.roles) {
                if (role == 0) {
                    this.dataUser.roleId = this.dataUser.roles[0].id
                }
            }
        },
        revertStatusUser: function () {
            this.initDataUser();
            this.dataUser.roleId = 0;
            this.resetMessages();
            this.addStatusUser = '';
            this.$emit('resetStatusUser', this.addStatusUser);
        },
        resetMessages: function () {
            this.errors = {};
            this.success = '';
        },
        saveDataUser: function (id) {
            let _this = this;
            _this.resetMessages();
            if (_this.statusUser == 'create') {
                createNewUser(_this.dataUser)
                    .then(response => {
                        _this.success = _this.$t('message.info_user.create');
                        _this.initDataUser();
                        _this.dataUser.roleId = 0;
                        _this.addStatusUser = '';
                        _this.$emit('resetStatusUser', _this.addStatusUser);
                    })
                    .catch(error => {
                        if (error) {
                            _this.errors = (error.error_cod) ?  error : error.errors;
                        }
                    })
            }
            if (_this.statusUser == 'edit') {
                updateUser(_this.dataUser)
                    .then(response => {
                        _this.success = _this.$t('message.info_user.edit_user');
                        _this.initDataUser();
                        _this.addStatusUser = '';
                        _this.$emit('resetStatusUser', _this.addStatusUser);

                    }).catch(err => {
                        if (err) {
                            _this.errors.errorLine = err.error_code;
                            _this.initDataUser();
                            _this.addStatusUser = '';
                            _this.$emit('resetStatusUser', _this.addStatusUser);
                        }
                    })
            }
        },
        getRole: function () {
            let _this = this;
            getRoles()
                .then(response => {
                    for (const role of response) {
                        role.sub_name = _this.$t('message.info_user.' + role.name);
                        _this.selectRoles.push(role);
                    }
                })
                .catch(err => {
                    console.log(err);
                })
        },
        fetchDepartments(){
            getDepartments()
            .then(response => {
                this.selectParts = response;
            }).catch( err => {
                console.log(err);
            })
        },
    },
    created: function () {
        this.getRole();
        this.fetchDepartments();
    }
}
</script>

<style>
#create-user {
    width: 100%;
    margin-top: -23px;
}

#create-user legend {
    margin-left: 20px;
}

#error, #success {
    width: 90%;
    margin: 0 auto;
}

#create-user #container {
    width: 400px;
}

#create-user .v-text-field__details {
    display: none !important;
}

#create-user button {
    margin: 5px;
    border: 1px solid;
}

.alert-danger {
    color: #a94442;
    background-color: #f2dede;
    border-color: #ebccd1;
}

.alert {
    padding: 15px;
    border: 1px solid transparent;
}

.alert-danger .alert-link {
    color: #843534;
}

.alert .alert-link {
    font-weight: 700;
}

.alert-dismissable,
.alert-dismissible {
    padding-right: 35px;
}

.alert-success {
    color: #3c763d;
    background-color: #dff0d8;
    border-color: #d6e9c6;
}

#create-user a.close {
    float: right;
}
</style>
