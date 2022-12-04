
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router'
import Vuetify from 'vuetify'
import VueI18n from 'vue-i18n'

import Routes from './routes'
import store from './store';

import Permissions from './mixins/Permissions';
import Roles from './mixins/Roles';
import {PAPERLESS_CONST} from './constant'
import vnMessage from './lang/vi/message.js'
import enMessage from './lang/en/message.js'
import jaMessage from './lang/ja/message.js'
import slVueTree from 'sl-vue-tree';
import 'sl-vue-tree/dist/sl-vue-tree-dark.css';
import VueDragTree from 'vue-drag-tree'
import 'vue-drag-tree/dist/vue-drag-tree.min.css'
import Icon from 'vue-awesome/components/Icon';
import 'vue-awesome/icons';
import 'roboto-fontface/css/roboto/roboto-fontface.css';
import 'material-design-icons-iconfont/dist/material-design-icons.css';
import Paperless from './utils/plugin/paperless'
import VueZoomer from 'vue-zoomer'
import 'vue-zoomer/dist/vue-zoomer.css'


if (process.env.MIX_ENV_MODE == 'production') {
    Vue.config.devtools = false;
    Vue.config.debug = false;
    Vue.config.silent = true;
}

Vue.use(VueDragTree);
Vue.use(Paperless);

Vue.mixin(Roles);
Vue.mixin(Permissions);
Vue.use(VueRouter);
Vue.use(Vuetify);
Vue.use(VueI18n);
Vue.use(VueZoomer)

const messages = {
    vi: vnMessage,
    en: enMessage,
    ja: jaMessage
};

const i18n = new VueI18n({
    locale: 'vi', // set locale
    messages, // set locale messages
    fallbackLocale: 'vi'
});


const router = new VueRouter({
    routes: Routes,
    mode: 'history'
});

router.beforeEach((to, from, next) => {
    if (window.Roles && window.Roles.length > 0) {
        if (window.Roles.indexOf(PAPERLESS_CONST.roles.admin) != -1) {
            next();
        } else if (window.Roles.indexOf(PAPERLESS_CONST.roles.pe) != -1) {
            if (to.path != "/sync_file") {
                next("/sync_file");
            } else {
                next();
            }
        } else if (window.Roles.indexOf(PAPERLESS_CONST.roles.line) != -1) {
            if (to.path == "/play_file") {
                next();
            } else if (to.path == "/micro_pc") {
                next();
            } else {
                next("/play_file");
            }
        } else {
            next("/login");
        }
    } else {
        next();
    }
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
Vue.component('icon', Icon);
Vue.component('sl-vue-tree', slVueTree);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('root', require('./components/RootComponent.vue').default);
Vue.component('file-player', require('./components/file-player/FilePlayerComponent.vue').default);
Vue.prototype.$constants = PAPERLESS_CONST;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#root',
    router: router,
    store: store,
    i18n
});
