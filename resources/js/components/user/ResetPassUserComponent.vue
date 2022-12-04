<template>
<div id="reset-pass">
    <fieldset :disabled="!editPassUser">
        <legend>{{ $t('message.reset_pass.title') }}</legend>
        <div class="noborder-message" v-if="success.length > 0">
            <v-alert value="true" color="success" icon="check_circle" outline transition="scale-transition" dismissible>
                {{ success }}
            </v-alert>
        </div>
        <div class="noborder-message" v-if="errors.password || errors.confirmPassword">
            <v-alert value="true" color="error" icon="warning" outline transition="scale-transition" dismissible>
                <span v-if="errors.password">
                    <ul v-for='(ps, i) in errors.password' :key="'password' + i">
                        <li>{{ ps }}</li>
                    </ul>
                </span>
                <span v-if="errors.confirmPassword">
                    <ul v-for='(us, i) in errors.confirmPassword' :key="'confirmPassword' + i">
                        <li>{{ us }}</li>
                    </ul>
                </span>
            </v-alert>
        </div>    
        <v-container fluid>
            <v-layout row id="input-user">
                <v-flex xs3 style="min-width: 100px;">
                    <v-card-title>{{ $t('message.info_user.employee_code') }}</v-card-title>
                </v-flex>
                <v-flex >
                    <v-text-field disabled label="" solo v-model="dataUser.userCode"></v-text-field>
                </v-flex>
            </v-layout>
            <v-layout row>
                <v-flex xs3 style="min-width: 100px;">
                    <v-card-title>{{ $t('message.info_user.password') }}</v-card-title>
                </v-flex>
                <v-text-field solo id="password-user" type="password" v-model="dataUser.password"></v-text-field>
            </v-layout>
            <v-layout row>
                <v-flex xs3 style="min-width: 100px;">
                    <v-card-title>{{ $t('message.info_user.confirmPassword') }}</v-card-title>
                </v-flex>
                <v-text-field solo id="confirm-password-user" type="password" v-model="dataUser.confirmPassword"></v-text-field>
            </v-layout>
            <v-layout row>
                <v-flex xs3 style="min-width: 100px;"></v-flex>
                <v-btn @click="savePassUser()" :disabled="!editPassUser">{{ $t('message.info_user.save') }}</v-btn>
                <v-btn @click="revertStatusUser()" :disabled="!editPassUser">{{ $t('message.info_user.cancel') }}</v-btn>
            </v-layout>
        </v-container>
    </fieldset>
</div>
</template>

<script>
import { updatePassUser } from '../../api/user';
export default {
    props: {
        editPassUser: {
            default: false
        },
        infoUser: {
            type: Object,
            default: () => {
                return {}
            }
        }
    },
    data() {
        return {
            addStatusUser: '',
            dataUser: {
                userCode: '',
                password: '',
                confirmPassword: '',
                id: 0,
            },
            errors: {},
            success: '',
            checkEditPassUser: this.editPassUser,
        }
    },
    watch: {
        infoUser: function () {
            this.dataUser.userCode = this.infoUser.userCode;
            this.dataUser.id = this.infoUser.id;
        }
    },
    methods: {
        initDataUser: function () {
            this.dataUser.userCode = '';
            this.dataUser.password = '';
            this.dataUser.confirmPassword = '';
            this.dataUser.id = 0;
        },
        setInitData() {
            this.dataUser = this.infoUser;
        },
        revertStatusUser: function () {
            this.initDataUser();
            this.resetMessages();
            this.checkEditPassUser = false;
            this.$emit('revertStatus', this.checkEditPassUser);
        },
        resetMessages: function () {
            this.errors = {};
            this.success = '';
        },
        savePassUser: function () {
            let _this = this;
            _this.resetMessages();
            updatePassUser(_this.dataUser)
                .then(response => {
                    _this.initDataUser();
                    _this.success = _this.$t('message.reset_pass.editPass');
                    _this.checkEditPassUser = false;
                    _this.$emit('revertStatus', this.checkEditPassUser);
                })
                .catch(error => {
                    _this.errors = error.errors;
                });
        },
    },
}
</script>

<style>
#reset-pass {
    width: 100%;
    margin-top: 20px;
}

#reset-pass legend {
    margin-left: 20px;
}

#reset-pass #input-user .v-input__slot {
    background-color: #ccc;

}

#reset-pass #container {
    width: 400px;
}

#reset-pass .v-text-field__details {
    display: none !important;
}

#reset-pass button {
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

#reset-pass a.close {
    float: right;
}
</style>
