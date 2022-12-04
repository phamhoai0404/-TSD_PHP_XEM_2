<template>
<div id="create-department">
    <fieldset :disabled="statusDepartment != 'create' && statusDepartment != 'edit'">
        <legend>{{ $t('message.department.department_infor') }}</legend>
        <div class="noborder-message" v-if="success.length > 0">
            <v-alert value="true" color="success" icon="check_circle" outline transition="scale-transition" dismissible>
                {{ success }}
            </v-alert>
        </div>
        <div class="noborder-message" v-if="errors.depCode || errors.depName">
            <v-alert value="true" color="error" icon="warning" outline transition="scale-transition" dismissible>
                <span v-if="errors.depCode">
                    <ul v-for='(depC, i) in errors.depCode' :key="'depCode' + i">
                        <li>{{ depC }}</li>
                    </ul>
                </span>
                <span v-if="errors.depName">
                    <ul v-for='(depN, i) in errors.depName' :key="'depName' + i">
                        <li>{{ depN }}</li>
                    </ul>
                </span>
            </v-alert>
        </div>
        <v-container fluid>
            <v-layout row>
                <v-flex xs3 style="min-width: 100px;">
                    <v-card-title>{{ $t('message.department.department_code') }}</v-card-title>
                </v-flex>
                <v-flex >
                    <v-text-field label="" solo v-model="dataDepartment.depCode" :disabled="statusDepartment == 'edit'"></v-text-field>
                </v-flex>
            </v-layout>
            <v-layout row>
                <v-flex xs3 style="min-width: 100px;">
                    <v-card-title>{{ $t('message.department.department_name') }}</v-card-title>
                </v-flex>
                <v-flex>
                    <v-text-field label="" solo v-model="dataDepartment.depName"></v-text-field>
                </v-flex>
            </v-layout>
            <v-layout row>
                <v-flex xs3 style="min-width: 100px;">
                    <v-card-title>{{ $t('message.department.note') }}</v-card-title>
                </v-flex>
                <v-textarea label="" value="" solo v-model="dataDepartment.note"></v-textarea>
            </v-layout>
            <v-layout row>
                <v-flex xs3 style="min-width: 100px;"></v-flex>
                <v-btn v-if="statusDepartment != 'detail'" @click="saveDataDepartment()" :disabled="statusDepartment != 'create'&& statusDepartment != 'edit'">{{ $t('message.department.save') }}</v-btn>
                <v-btn v-if="statusDepartment != 'detail'" @click="revertStatusDepartment()" :disabled="statusDepartment != 'create'&& statusDepartment != 'edit'">{{ $t('message.department.cancel') }}</v-btn>
            </v-layout>
        </v-container>
    </fieldset>
</div>
</template>

<script>
import {
    createNewDepartment,
    updateDepartment
} from '../../api/department'
export default {
    props: {
        statusDepartment: {
            type: String,
            default: ''
        },
        dataEditDepartment: {
            type: Object,
            default: () => {
                return {}
            }
        },
    },
    watch: {
        dataEditDepartment() {
            this.setInitData()
        }
    },
    data() {
        return {
            addStatusDepartment: '',
            dataDepartment: {
                depCode: '',
                depName: '',
                note: ''
            },
            errors: {},
            success: '',
        }
    },
    methods: {
        revertStatusDepartment: function () {
            this.initDataDepartment();
            this.addStatusDepartment = '';
            this.resetMessages();
            this.$emit('resetStatusDepartment', this.addStatusDepartment);
        },
        initDataDepartment: function () {
            this.dataDepartment.depCode = '';
            this.dataDepartment.depName = '';
            this.dataDepartment.note = '';
        },
        setInitData() {
            this.resetMessages();
            this.addStatusDepartment = this.statusDepartment;
            let dataEditDepartment = { ...this.dataEditDepartment
            };
            this.dataDepartment = { ...this.dataDepartment,
                ...dataEditDepartment
            }
        },
        resetMessages: function () {
            this.errors = {};
            this.success = '';
        },
        saveDataDepartment: function () {
            let _this = this;
            _this.resetMessages();
            if (_this.statusDepartment == 'create') {
                createNewDepartment(_this.dataDepartment)
                    .then(response => {
                        _this.success = _this.$t('message.department.create_department');
                        _this.initDataDepartment();
                        _this.addStatusDepartment = '';
                        _this.$emit('resetStatusDepartment', _this.addStatusDepartment);
                    })
                    .catch(error => {
                        if (error) {
                            console.log(error);
                            _this.errors = error.errors;
                        }
                    })
            }
            if (_this.statusDepartment == 'edit') {
                updateDepartment(_this.dataDepartment)
                    .then(response => {
                        _this.success = _this.$t('message.department.edit_department');
                        _this.initDataDepartment();
                        _this.addStatusDepartment = '';
                        _this.$emit('resetStatusDepartment', _this.addStatusDepartment);

                    }).catch(error => {
                        if (error) {
                            console.log(error);
                            _this.errors = error.errors;
                        }
                    })
            }
        }
    },
}
</script>

<style>
#create-department {
    width: 100%;
    margin-top: -23px;
    margin-left: 20px;
}

#create-department legend {
    margin-left: 20px;
}

#create-department #container {
    width: 400px;
}

#create-department .v-text-field__details {
    display: none !important;
}

#create-department button {
    margin: 5px;
    border: 1px solid;
}

#create-department a.close {
    float: right;
}
</style>
