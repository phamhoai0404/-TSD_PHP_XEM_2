<template>
    <div id="create-line">
        <fieldset :disabled="changeStatusline != 'create' && changeStatusline != 'edit'">
            <legend>{{ $t('message.line.line_infor') }}</legend>
            <div class="noborder-message" v-if="success">
                <v-alert value="true" color="success" icon="check_circle" outline transition="scale-transition" dismissible>
                {{ success }}.
                </v-alert>
            </div>
            <div class="noborder-message" v-if="errors.lineCode || errors.userId || errors.error_code">
                <v-alert value="true" color="error" icon="warning" outline transition="scale-transition" dismissible>
                <span v-if="errors.lineCode">
                    <ul v-for='(errorLineCode, i) in errors.lineCode' :key="'lineCode' + i">
                        <li>{{ errorLineCode }}</li>
                    </ul>
                </span>
                <span v-if="errors.userId">
                    <ul v-if="!dataLine.depId">
                        <li>{{ $t('message.line.departmentError') }}</li>
                    </ul>
                    <ul v-for='(errorUser, i) in errors.userId' :key="'user' + i">
                        <li>{{ errorUser }}</li>
                    </ul>
                </span>
                <span v-if="errors.error_code">
                    <ul>
                        <li>{{ errors.error_code }}</li>
                    </ul>
                </span>
                </v-alert>
            </div>
            <v-container fluid>
                <v-layout row>
                    <v-flex xs3 style="min-width: 100px;">
                        <v-card-title >{{ $t('message.line.code') }}</v-card-title>
                    </v-flex>
                    <v-flex>
                        <v-text-field label="" solo v-model="dataLine.lineCode"></v-text-field>
                    </v-flex>
                </v-layout>
                <v-layout row>
                    <v-flex xs3 style="min-width: 100px;">
                        <v-card-title >{{ $t('message.line.line_department') }}</v-card-title>
                    </v-flex>
                    <v-flex>
                        <v-select :disabled="changeStatusline == '' || changeStatusline != 'create' && changeStatusline == 'edit' || changeStatusline == 'detail'"
                         @change="changDepartment" :items="selectDepartment" item-value='id' item-text='depCode' v-model="dataLine.depId" :menu-props="{ nudgeTop: -8, offsetY: ''}"></v-select>
                    </v-flex>
                </v-layout>
               <v-layout row>
                    <v-flex xs3 style="min-width: 100px;">
                        <v-card-title >{{ $t('message.line.line_user') }}</v-card-title>
                    </v-flex>
                    <v-flex>
                        <v-select :disabled="!dataLine.depId || changeStatusline == 'detail'" :items="selectUser" item-value='id' item-text='userCode' v-model="dataLine.userId" :menu-props="{ nudgeTop: -8, offsetY: ''}"></v-select>
                    </v-flex>
                </v-layout>
                <v-layout row>
                    <v-flex xs3 style="min-width: 100px;">
                        <v-card-title >{{ $t('message.line.note') }}</v-card-title>
                    </v-flex>
                    <v-flex>
                        <v-textarea label="" value="" solo v-model="dataLine.note"></v-textarea>
                    </v-flex>
                </v-layout>
                <v-layout row>
                    <v-flex xs3 style="min-width: 100px;">
                    </v-flex>
                    <v-flex>
                        <p>{{ $t('message.line.attention') }}</p>
                    </v-flex>
                </v-layout>
                <v-layout row>
                    <v-flex xs3></v-flex>
                    <v-btn v-if="changeStatusline != 'detail'" @click="saveDataline()" :disabled="changeStatusline != 'create'&& changeStatusline != 'edit'">{{ $t('message.line.save') }}</v-btn>
                    <v-btn v-if="changeStatusline != 'detail'" @click="resetStatusLine()" :disabled="changeStatusline != 'create'&& changeStatusline != 'edit'">{{ $t('message.line.cancel') }}</v-btn>
                </v-layout>
            </v-container>
        </fieldset>
    </div>
</template>
<script>
    import { createLine, updateLine } from '../../api/line';
    import { getDepartments, getUserByDepartmentId } from '../../api/department';
    export default {
        props: {
            statusLine: {
                type: String,
                default: ''
            },
            dataEditLine: {
                type: Object,
                default: () => {
                    return {}
                }
            },
        },
        watch: {
            dataEditLine() {
                this.setInitData()
            },
            statusLine() {
                this.changeStatusline = this.statusLine
                if(this.changeStatusline == '') {
                    this.initDataLine();
                }
            }
        },
        computed: {
            microPcs () {
                return this.$store.state.microPcs
            },
            microPcsWhenUpdate () {
                return this.$store.state.microPcsWhenUpdate
            },
            responMicroPcsBeforeUpdate () {
                return this.$store.state.responMicroPcsBeforeUpdate
            }
        },
        data() {
            return {
                changeStatusline:'',
                dataLine:
                {
                    lineCode: '',
                    userId: null,
                    depId: null,
                    note: '',
                    microPC: []
                },
                errors: {},
                success: '',
                selectUser:[],
                selectDepartment:[]
            }
        },
        methods: {
            resetMessages() {
                this.errors = {};
                this.success = '';
            },
            resetStatusLine () {
                this.initDataLine();
                this.changeStatusline = '';
                this.resetMessages();
                this.$emit('resetStatusLine', this.changeStatusline);
            },
            initDataLine () {
                this.dataLine.lineCode = '';
                this.dataLine.userId = '';
                this.dataLine.note = '';
                this.dataLine.depId = '';
                this.dataLine.microPC = [];
                this.changeStatusline = this.statusLine
            },
            setInitData () {
                this.resetMessages();
                let dataEditLine = { ...this.dataEditLine
                };
                this.dataLine = { ...this.dataLine,
                    ...dataEditLine
                };
                if(dataEditLine.user) {
                    this.dataLine.depId = dataEditLine.user.depId
                }
            },
            saveDataline () {
                let _this = this;
                this.resetMessages();
                if(_this.changeStatusline == 'create') {
                    if(_this.microPcs.length > 0) {
                        for (let index = 0; index < this.microPcs.length; index++) {
                            if(this.microPcs[index]) {
                                _this.dataLine.microPC[index] = this.microPcs[index].id
                            }
                        }
                    }
                    createLine(_this.dataLine)
                    .then(response => {
                        _this.success = _this.$t('message.line.add_line');
                        _this.changeStatusline = '';
                        _this.$emit('resetStatusLine', _this.changeStatusline);
                        _this.initDataLine()
                    })
                    .catch(error => {
                        if (error) {
                            console.log(error);
                            _this.errors = error.errors;
                        }
                    })
                }
                if(_this.changeStatusline == 'edit') {
                    let microPcSelected = this.$store.state.microPcSelected
                    let microPcsWhenUpdate = this.$store.state.microPcsWhenUpdate
                    if (microPcsWhenUpdate.length > 0) {
                        for (let index = 0; index < microPcsWhenUpdate.length; index++) {
                            if ((microPcSelected[index] == 'true' && this.responMicroPcsBeforeUpdate[index].lineId == null) || (microPcSelected[index] != 'true' && this.responMicroPcsBeforeUpdate[index].lineId != null)) {
                                _this.dataLine.microPC[index] = microPcsWhenUpdate[index].id
                            }
                        }
                    }
                    updateLine(_this.dataLine)
                    .then(response => {
                        _this.success = _this.$t('message.line.edit_line');
                        _this.changeStatusline = '';
                        _this.$emit('resetStatusLine', _this.changeStatusline);
                        this.$store.state.microPcSelected = [];
                        this.initDataLine()
                    })
                    .catch(error => {
                        if (error) {
                            console.log(error);
                            if(error) {
                                error.errors ? _this.errors = error.errors : _this.errors = error;
                            }
                        }
                    })
                }
            },
            changDepartment(value) {
                this.dataLine.userId = null;
                this.fetchUserByDepartment(value);
                this.$store.state.departmentId = value
            },
            fetchDepartments() {
                let _this = this;
                getDepartments()
                    .then(response => {
                        _this.selectDepartment = response;
                    }).catch(err => {
                    console.log(err);
                })
            },
            fetchUserByDepartment(depId) {
                let _this = this;
                getUserByDepartmentId(depId)
                    .then(response => {
                        _this.selectUser = response;
                    }).catch(err => {
                    console.log(err);
                })
            },
        },
        created() {
            this.fetchDepartments();
        }
    }
</script>

<style>
    #create-line legend {
        margin-left: 20px;
    }

    #create-line #container {
        width: 400px;
    }

    #create-line .v-text-field__details {
        display: none !important;
    }

    #create-line button {
        margin: 5px;
        border: 1px solid;
    }

    #create-line a.close {
        float: right;
    }
</style>
