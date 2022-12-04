<template>
    <div class="pl-root">
        <div id="spinner" v-show="displaySpinner"><vue-spinner size="huge"></vue-spinner></div>
        <v-app id="inspire">
            <v-navigation-drawer
                    fixed
                    v-model="drawer"
                    left
                    app
                    width='220'
            >
                <div class="app-logo">

                    <v-flex
                            md12
                            align-center
                            justify-center
                            layout
                            text-xs-center
                    >
                        <v-avatar
                                :size="160"
                                color="grey lighten-4"
                        >
                            <img src="/img/logobig.png" alt="avatar">
                        </v-avatar>
                    </v-flex>
                </div>
                <v-list dense>
                    <router-link v-if="$can($constants.permissions.sync_file)" :to="{ name: 'syncFileRoot'}">
                        <v-list-tile @click="" exact>
                            <v-list-tile-action>
                                <v-icon>sync</v-icon>
                            </v-list-tile-action>
                            <v-list-tile-content>
                                <v-list-tile-title class='text'>
                                    {{ $t('message.menu.sync_file') }}
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </router-link>
                    <router-link v-if="$can($constants.permissions.play_file)" :to="{ name: 'playFileRoot'}">
                        <v-list-tile @click="">
                            <v-list-tile-action>
                                <v-icon>file_copy</v-icon>
                            </v-list-tile-action>
                            <v-list-tile-content>
                                <v-list-tile-title class='text'>
                                    {{ $t('message.menu.file') }}
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </router-link> 
                    <router-link v-if="$can($constants.permissions.manage_line)" :to="{ name: 'lineRoot'}">
                        <v-list-tile @click="">
                            <v-list-tile-action>
                                <v-icon>timeline</v-icon>
                            </v-list-tile-action>
                            <v-list-tile-content>
                                <v-list-tile-title class='text'>
                                    {{ $t('message.menu.line') }}
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </router-link>            
                    <router-link v-if="$can($constants.permissions.manage_micro_pc) || $can($constants.permissions.play_file)" :to="{ name: 'microPCRoot'}">
                        <v-list-tile @click="">
                            <v-list-tile-action>
                                <v-icon>laptop_windows</v-icon>
                            </v-list-tile-action>
                            <v-list-tile-content>
                                <v-list-tile-title class='text'>
                                    {{ $t('message.menu.micro_pc') }}
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </router-link>
                    <router-link v-if="$can($constants.permissions.manage_pc)" :to="{ name: 'pcRoot'}">
                        <v-list-tile @click="">
                            <v-list-tile-action>
                                <v-icon>desktop_windows</v-icon>
                            </v-list-tile-action>
                            <v-list-tile-content>
                                <v-list-tile-title class='text'>
                                    {{ $t('message.menu.manager_pc') }}
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </router-link>
                    <router-link v-if="$can($constants.permissions.manage_deparment)" :to="{ name: 'departmentRoot'}">
                        <v-list-tile @click="">
                            <v-list-tile-action>
                                <v-icon>meeting_room</v-icon>
                            </v-list-tile-action>
                            <v-list-tile-content>
                                <v-list-tile-title class='text'>
                                    {{ $t('message.menu.department') }}
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </router-link>
                    <router-link v-if="$can($constants.permissions.manage_user)" :to="{ name: 'userRoot'}">
                        <v-list-tile @click="">
                            <v-list-tile-action>
                                <v-icon>people</v-icon>
                            </v-list-tile-action>
                            <v-list-tile-content>
                                <v-list-tile-title class='text'>
                                    {{ $t('message.menu.user') }}
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </router-link>
                    <router-link v-if="$can($constants.permissions.setting)" :to="{ name: 'settingRoot'}">
                        <v-list-tile @click="">
                            <v-list-tile-action>
                                <v-icon>settings</v-icon>
                            </v-list-tile-action>
                            <v-list-tile-content>
                                <v-list-tile-title class='text'>
                                    {{ $t('message.menu.setting') }}
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </router-link> 
                </v-list>
            </v-navigation-drawer>
            <v-toolbar height='47' color="black" dark fixed app>
                <v-toolbar-side-icon @click.stop="menuClickEventHandler()"></v-toolbar-side-icon>
                <v-spacer></v-spacer>
                <v-toolbar-items class="hidden-sm-and-down">
                    <div v-for="(lang,index) in optionLanguages" :key="index" @click="changeLocale(lang.value)" :class="['lang',lang.value] ">
                        <v-btn flat style="padding-bottom: 18px;" @click="e => activeBtn(e)">
                            <img :src="lang.link" width="30" class="language">
                        </v-btn>
                    </div>
                    <v-btn flat>{{ currentUser.userCode }}</v-btn>
                    <v-btn href="/logout" flat>{{ $t('message.toolbar.logout') }}</v-btn>
                </v-toolbar-items>
            </v-toolbar>
            <v-content style="margin-top: 30px;">
                <router-view></router-view>
            </v-content>
            <v-footer color="black" app>
                <v-spacer></v-spacer>
                <span class="white--text">{{ $t('message.footer')}} &copy; {{ year }}</span>
                <v-spacer></v-spacer>
            </v-footer>
        </v-app>
    </div>
</template>

<script>
    import { getCurrentUser } from  '../api/user';
    import { i18n } from '../app';
    import { changeLanguage } from '../api/user';
    import Spinner from 'vue-simple-spinner';

    export default {
        name: "root",
        data: () => ({
            drawer: null,
            currentUser: '',
            optionLanguages: [
                { link: '/img/vi.png', value: 'vi' },
                { link: '/img/en.png', value: 'en' },
                { link: '/img/ja.png', value: 'ja' },
            ],
            dataUser: { language: '' },
            year: null,
        }),
        props: {
            source: String
        },
        components: {
            'vue-spinner' : Spinner
        },
        created () {
            this.getCurUser();
            this.getYear();
        },
        computed: {
            displaySpinner: function() {
                return this.$store.state.displaySpinner;
            }
        },
        methods: {
            getCurUser : function () {
                let _this = this;
                getCurrentUser()
                   .then(response => {
                       _this.currentUser = response;
                       _this.$i18n.locale = _this.currentUser.language;
                       document.querySelector('.lang.'+_this.currentUser.language).classList.add("focusBtn");
                   })
                   .catch(err => {
                        console.log(err);
                    })
            },
            changeLocale(locale) {
                let _this = this;
                
                _this.dataUser.language = locale;
                changeLanguage(_this.dataUser)
                    .then(response => {   
                        _this.$i18n.locale = locale;
                    }).catch( err => {
                        console.log(err);
                    })
            },
            activeBtn: function(e) {
                let parent = e.target.parentNode;
                while (parent && !parent.classList.contains('lang')) { parent = parent.parentNode; }
                document.querySelectorAll('.lang').forEach(element => {
                    element.classList.remove('focusBtn');
                });
                parent.classList.add("focusBtn");
            },
            getYear: function () {
                let _this = this;
                let getYear = new Date();
                _this.year = getYear.getFullYear();
            },
            menuClickEventHandler() {
                this.drawer = !this.drawer;
                this.clickSideBarIcon();
            }
        },
    }
</script>
<style >
    #inspire a.router-link-active {
        color: red;
    }

    #spinner {
        position: absolute;
        z-index: 111;
        background-color: gainsboro;
        opacity: 0.7;
        width: 100%;
        height: 100%;
        display: flex;
        -ms-flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .vue-simple-spinner-text {
        font-family: sans-serif !important;
        color: black;
    }

    #inspire .v-list--dense a.v-list__tile {
        border: 1px #ccc solid;
        margin-bottom: 10px;
        height: 50px;
    }
    #inspire .text {
        font-size: 16px;
        text-transform: uppercase;
    }
    #inspire img.language {
        margin-top: 14px;
    }
    #inspire div.lang:hover {
        background: #ccc;
    }
    #inspire div.lang button:focus {
        background: #ccc;
    }
    .focusBtn {
        background: #ccc;
    }
    .noborder-message .v-alert.v-alert--outline {
        border:  none !important;
    }
    .root-message {
        width: 50%;
        margin: 0;
        position: absolute;
        top: -3%;
        border:  none !important;
    }
    .v-btn {
        border: 1px solid #ccc;
        border-color: #000 !important;
        border-radius: 5px;
    }
    .v-datatable__actions__range-controls .v-btn{
        border: 0px !important;
    }
    .lang .v-btn{
        border: 0px !important;
    }
    .btnAdd {
        float: right;
        margin: -13px 1px 15px 0;
        border: 1px solid;
        border-radius: 5px;
    }
    .v-datatable__actions {
        background-color: #fafafa !important;
    }

    .v-list__tile__action {
        min-width: 40px !important;
    }

    .v-table__overflow {
        overflow-y: auto !important;
    }
    fieldset {
        border-radius: 5px;
    }
    #confirm div.v-card__text {
        text-align: center;
    }
    #confirm div.v-card__title {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .v-dialog {
        margin-top: -100px;
    }
    .v-card__actions .v-btn {
        display: inline-block !important;
    }
    .v-card__actions {
        display: block !important;
        text-align: center;
    }

    table.v-table thead th {
        text-align: center;
        padding: 0 3px !important;
    }
    table.v-table td {
        text-align: center;
        padding: 0 3px !important;
    }

    .v-btn--small {
        padding: 0 3px !important;
    }

    html {
        overflow-y: hidden !important;
    }
</style>
