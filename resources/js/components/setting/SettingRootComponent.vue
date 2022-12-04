<template>
    <div id="setting">
        <v-container fluid v-if="success || errors.error_code" style="padding: 0px 24px;">
        	<div class="message_success_setting noborder-message" v-if="success">
                <v-alert value="true" color="success" icon="check_circle" outline transition="scale-transition" dismissible>
                    {{ success }}
                </v-alert>
            </div>
            <div class="message_error_setting noborder-message" v-if="errors.error_code">
                <v-alert value="true" color="error" icon="warning" outline transition="scale-transition" dismissible>
                    <span v-if="errors">
                        <ul v-for='(error,i) in errors.error_code' :key="'error_setting' + i">
                            <li>{{ error }}</li>
                        </ul>
                    </span>
                </v-alert>
            </div>
        </v-container>
        <v-container fluid >
            <v-layout row>
                <v-flex xs2>
                    <v-card-title>{{ $t('message.setting.source_path') }}</v-card-title>
                </v-flex>
                <v-flex xs6>
                    <v-text-field label="" solo v-model="setting.source_path"></v-text-field>
                </v-flex>
            </v-layout>
            <v-layout row>
                <v-flex xs2>
                    <v-card-title>{{ $t('message.setting.destination_path') }}</v-card-title>
                </v-flex>
                <v-flex xs6>
                    <v-text-field label="" solo v-model="setting.destination_path"></v-text-field>
                </v-flex>
            </v-layout>
            <v-layout row>
                <v-flex xs2>
                    <v-card-title>{{ $t('message.setting.time_default') }}</v-card-title>
                </v-flex>
                <v-flex xs1>
                    <v-text-field label="" solo v-model.number="setting.default_time" type="number"></v-text-field>
                </v-flex>
                <v-flex xs1>
                    <v-card-title>{{ $t('message.setting.second') }}</v-card-title>
                </v-flex>
            </v-layout>
            <v-layout row>
                <v-flex xs3>
                	<v-btn  @click="saveData()" class="save">{{ $t('message.setting.save') }}</v-btn>
                </v-flex>
            </v-layout>
        </v-container>
    </div>
</template>

<script>
	import { getAllSettings, updateDataSetting } from '../../api/setting.js'
export default {
    data() {
        return {  
            success: '',
            errors: {},
            setting: {
                default_time: '',
                destination_path: '',
                source_path: ''
            },
        }
    },
    methods: {
    	fetchDataSetting() {
            getAllSettings()
                .then(response => {
                    this.setting.default_time = response.default_time;
                    this.setting.destination_path = response.destination_path;
                    this.setting.source_path = response.source_path;
                }).catch( err => {
                    console.log(err);
                })
        },
        saveData() {
            let objectSetting = this.setting;
            let arraySetting = {
                name: [],
                value: []
            };
            Object.keys(objectSetting).forEach(function(key) {
                arraySetting['name'].push(key);
                arraySetting['value'].push(objectSetting[key]);
            });
            this.errors = {};
            this.success = '';
        	updateDataSetting(arraySetting)
        	.then(() => {
                    this.success = this.$t('message.setting.success');
                }).catch( errs => {
                    console.log(errs);
                    this.errors = errs;
                 })
        }
    },
    created() {
        this.fetchDataSetting();
    }
}
</script>

<style>
    #setting button.save {
        border: 1px solid #000;
    }
    #setting .message_error_setting,.message_success_setting {
        width: 65%;
        margin: 0;
        border:  none !important;
    }
    #setting .v-alert--outline {
        padding: 0px 16px !important;
    }
</style>
