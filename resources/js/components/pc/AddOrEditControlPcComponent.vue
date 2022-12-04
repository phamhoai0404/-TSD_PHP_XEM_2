<template>
<div id="create-controlpc">
    <fieldset :disabled="statusControlPc != 'create' && statusControlPc != 'edit'">
        <legend>{{ $t('message.pc.controlpc_infor') }}</legend>
        <div class="noborder-message" v-if="success.length > 0">
            <v-alert value="true" color="success" icon="check_circle" outline transition="scale-transition" dismissible>
                {{ success }}
            </v-alert>
        </div>
        <div class="noborder-message" v-if="errors.controlpcCode || errors.ipAddress">
            <v-alert value="true" color="error" icon="warning" outline transition="scale-transition" dismissible>
                <span v-if="errors.controlpcCode">
                    <ul v-for='(pcCode, i) in errors.controlpcCode' :key="'controlpcCode' + i">
                        <li>{{ pcCode }}</li>
                    </ul>
                </span>
                <span v-if="errors.ipAddress">
                    <ul v-for='(ip, i) in errors.ipAddress' :key="'ipAddress' + i">
                        <li>{{ ip }}</li>
                    </ul>
                </span>
            </v-alert>
        </div>
        <v-container fluid>
            <v-layout row>
                <v-flex xs3 style="min-width: 100px;">
                    <v-card-title>{{ $t('message.pc.controlpc_code') }}</v-card-title>
                </v-flex>
                <v-flex>
                    <v-text-field label="" solo v-model="dataControlPc.controlpcCode"></v-text-field>
                </v-flex>
            </v-layout>
            <v-layout row>
                <v-flex xs3 style="min-width: 100px;">
                    <v-card-title>{{ $t('message.pc.ip_address') }}</v-card-title>
                </v-flex>
                <v-flex>
                    <v-text-field label="" solo v-model="dataControlPc.ipAddress"></v-text-field>
                </v-flex>
            </v-layout>
            <v-layout row>
                <v-flex xs3 style="min-width: 100px;">
                    <v-card-title>{{ $t('message.pc.note') }}</v-card-title>
                </v-flex>
                <v-textarea label="" value="" solo v-model="dataControlPc.note"></v-textarea>
            </v-layout>
            <v-layout row>
                <v-flex xs3 style="min-width: 100px;"></v-flex>
                <v-btn v-if="statusControlPc != 'detail'" @click="saveDataControlPC()" :disabled="statusControlPc != 'create'&& statusControlPc != 'edit'">{{ $t('message.pc.save') }}</v-btn>
                <v-btn v-if="statusControlPc != 'detail'" @click="revertStatusControlPc()" :disabled="statusControlPc != 'create'&& statusControlPc != 'edit'">{{ $t('message.pc.cancel') }}</v-btn>
            </v-layout>
        </v-container>
    </fieldset>
</div>
</template>

<script>
import {
    createNewControlPc,
    updateControlPc
} from '../../api/pc'
export default {
    props: {
        statusControlPc: {
            type: String,
            default: ''
        },
        dataEditControlPc: {
            type: Object,
            default: () => {
                return {}
            }
        },
    },
    watch: {
        dataEditControlPc() {
            this.setInitData()
        }
    },
    data() {
        return {
            addStatusControlPc: '',
            dataControlPc: {
                controlpcCode: '',
                ipAddress: '',
                note: ''
            },
            errors: {},
            success: '',
        }
    },
    methods: {
        revertStatusControlPc: function () {
            this.initDataControlPc();
            this.addStatusControlPc = '';
            this.resetMessages();
            this.$emit('resetStatusControlPc', this.addStatusControlPc);
        },
        initDataControlPc: function () {
            this.dataControlPc.controlpcCode = '';
            this.dataControlPc.ipAddress = '';
            this.dataControlPc.note = '';
        },
        setInitData() {
            this.resetMessages();
            this.addStatusControlPc = this.statusControlPc;
            let dataEditControlPc = { ...this.dataEditControlPc
            };
            this.dataControlPc = { ...this.dataControlPc,
                ...dataEditControlPc
            }
        },
        resetMessages: function () {
            this.errors = {};
            this.success = '';
        },
        saveDataControlPC: function () {
            let _this = this;
            _this.resetMessages();
            if (_this.statusControlPc == 'create') {
                createNewControlPc(_this.dataControlPc)
                    .then(response => {
                        _this.success = _this.$t('message.pc.create_controlpc ');
                        _this.initDataControlPc();
                        _this.addStatusControlPc = '';
                        _this.$emit('resetStatusControlPc', _this.addStatusControlPc);
                    })
                    .catch(error => {
                        if (error) {
                            console.log(error);
                            _this.errors = error.errors;
                        }
                    })
            }
            if (_this.statusControlPc == 'edit') {
                updateControlPc(_this.dataControlPc)
                    .then(response => {
                        _this.success = _this.$t('message.pc.edit_controlpc ');
                        _this.initDataControlPc();
                        _this.addStatusControlPc = '';
                        _this.$emit('resetStatusControlPc', _this.addStatusControlPc);

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
#create-controlpc {
    width: 100%;
    margin-left: 20px;
    margin-top: -23px;
}

#create-controlpc legend {
    margin-left: 20px;
}

#create-controlpc #container {
    width: 400px;
}

#create-controlpc .v-text-field__details {
    display: none !important;
}

#create-controlpc button {
    margin: 5px;
    border: 1px solid;
}

#create-controlpc a.close {
    float: right;
}
</style>
