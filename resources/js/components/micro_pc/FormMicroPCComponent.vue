<template>
    <div id="form-micro_pc">
        <fieldset :disabled='checkIfIsDisabled()'>
            <legend>{{ $t('message.info_micro_pc.micro_pc_infor') }}</legend>
            <v-container fluid :class="{pdtop : (errors.length > 0|| success == 1|| success == 3)}">
                <v-layout row>
                    <v-flex xs12>
                        <div v-if="success == 1" class="noborder-message">
                            <v-alert
                                    :value="true"
                                    color="success"
                                    icon="check_circle"
                                    outline
                                    transition="scale-transition"
                                    dismissible
                            >
                                {{$t('message.micro_pc.add_form.success')}}
                            </v-alert>
                        </div>
                        <div v-if="success == 3" class="noborder-message">
                            <v-alert
                                    :value="true"
                                    color="success"
                                    icon="check_circle"
                                    outline
                                    transition="scale-transition"
                                    dismissible
                            >
                                {{$t('message.micro_pc.edit_form.success')}}
                            </v-alert>
                        </div>
                        <div v-if="success == 2" class="noborder-message">
                            <v-alert
                                    :value="true"
                                    color="error"
                                    icon="warning"
                                    outline
                                    transition="scale-transition"
                                    dismissible
                            >
                                <ul>
                                    <li v-for="error in errors">{{error}}</li>
                                </ul>
                            </v-alert>
                        </div>
                    </v-flex>
                </v-layout>
                <v-layout row>
                    <v-flex xs3 style="min-width: 100px;">
                        <v-card-title>{{ $t('message.info_micro_pc.micro_pc_code') }}</v-card-title>
                    </v-flex>
                    <v-flex>
                        <v-text-field label="" solo v-model="microPC.microCode"></v-text-field>
                    </v-flex>
                </v-layout>
                <v-layout row>
                    <v-flex xs3 style="min-width: 100px;">
                        <v-card-title>{{ $t('message.info_micro_pc.ip_address') }}</v-card-title>
                    </v-flex>
                    <v-flex>
                        <v-text-field label="" solo v-model="microPC.ipAddress"></v-text-field>
                    </v-flex>
                </v-layout>
                <v-layout row>
                    <v-flex xs3 style="min-width: 100px;">
                        <v-card-title>{{ $t('message.info_micro_pc.parts') }}</v-card-title>
                    </v-flex>
                    <v-select :items="dep" item-text="depCode" item-value="id" v-model="microPC.depId" :menu-props="{ nudgeTop: -8, offsetY: ''}" :disabled="checkIfIsDisabled() || (selectedMicroPC.lineId != null)"></v-select>
                </v-layout>
                <v-layout row>
                    <v-flex xs3 style="min-width: 100px;">
                        <v-card-title>{{ $t('message.info_micro_pc.note') }}</v-card-title>
                    </v-flex>
                    <v-textarea solo label="" value="" v-model="microPC.note"></v-textarea>
                </v-layout>
                <v-layout row v-if="statusMicroPC != 'detail'">
                    <v-flex xs3 style="min-width: 100px;"></v-flex>
                    <v-btn @click="addOrEdit()" :disabled="checkIfIsDisabled()">
                        {{$t('message.info_micro_pc.save') }}
                    </v-btn>
                    <v-btn @click="resetMessages(); resetStatusMicroPC(); resetDataMicroPC()"
                           :disabled="checkIfIsDisabled()">{{$t('message.info_micro_pc.cancel') }}
                    </v-btn>
                </v-layout>
            </v-container>
        </fieldset>
    </div>
</template>

<script>
    import {addMicroPC, editMicroPC} from "../../api/micro_pc";
    import {getDepartments} from '../../api/department';
    export default {
        props: {
            statusMicroPC: {
                type: String,
                default: ''
            },
            selectedDep: {
                type: Number,
                default: 0
            },
            selectedMicroPC: {
                type: Object,
                default: {}
            }
        },
        data() {
            return {
                microPC: {
                    microCode: '',
                    ipAddress: '',
                    depId: null,
                    note: '',
                },
                dep: [],
                selectPart: 0,
                success: 0,
                errors: [],
            }
        },
        watch: {
            selectedMicroPC: function () {
                this.initDataMicroPC();
            }
        },
        methods: {
            resetDataMicroPC: function () {
                this.microPC.microCode = '';
                this.microPC.ipAddress = '';
                this.microPC.note = '';
                this.microPC.depId = null;
            },
            initDataMicroPC: function () {
                this.microPC.microCode = this.selectedMicroPC.microCode;
                this.microPC.ipAddress = this.selectedMicroPC.ipAddress;
                this.microPC.depId = this.selectedMicroPC.depId;
                this.microPC.note = this.selectedMicroPC.note;
                this.microPC.id = this.selectedMicroPC.id;
            },
            checkIfIsDisabled: function () {
                return (this.statusMicroPC == '' || this.statusMicroPC == 'detail') ? true : false;
            },
            resetStatusMicroPC: function () {
                this.$emit('resetStatusMicroPC', '');
                this.microPC.depId = '';
            },
            resetMessages: function () {
                this.errors = [];
                this.success = 0;
            },
            addMicro() {
                addMicroPC(this.microPC)
                    .then(response => {
                        this.success = 1;
                        this.resetStatusMicroPC();
                        this.resetDataMicroPC();
                    })
                    .catch(err => {
                        this.success = 2;
                        let errs = err.errors;
                        for (let key in errs) {
                            if (errs.hasOwnProperty(key)) {
                                let errorArr = errs[key];
                                errorArr.forEach(element => {
                                    this.errors.push(element);
                                });
                            }
                        }
                    })
            },
            editMicro() {
                editMicroPC(this.microPC)
                    .then(response => {
                        this.success = 3;
                        this.resetStatusMicroPC();
                        this.resetDataMicroPC();
                    })
                    .catch(err => {
                        this.success = 2;
                        let errs = err.errors;
                        for (let key in errs) {
                            if (errs.hasOwnProperty(key)) {
                                let errorArr = errs[key];
                                errorArr.forEach(element => {
                                    this.errors.push(element);
                                });
                            }
                        }
                        if(err.error_code) {
                            this.errors.push(err.error_code);
                        }
                    })
            },
            addOrEdit () {
                this.resetMessages();
                if(this.statusMicroPC == 'add') {
                    this.addMicro();
                }
                else if(this.statusMicroPC == 'edit') {
                    this.editMicro();
                }
            },
            fetchDepartments() {
                let _this = this;
                getDepartments()
                    .then(response => {
                        _this.dep = response;
                    }).catch(err => {
                    console.log(err);
                })
            },
        },
        created () {
            this.fetchDepartments();
        },
    }

</script>

<style>
    #form-micro_pc {
        width: 100%;
    }

    #form-micro_pc legend {
        margin-left: 20px;
    }

    .pdtop {
        padding-top: 0;
    }

    #form-micro_pc #container {
        width: 400px;
    }

    #form-micro_pc .v-text-field__details {
        display: none !important;
    }

    #form-micro_pc button {
        margin: 5px;
        border: 1px solid;
    }
</style>
