import Vue from 'vue';
import Vuex from 'vuex';
const DESTROY_INFO_FILE = 'DESTROY_INFO_FILE';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        departmentId: null,
        microPcs: [],
        microPcSelected: [],
        microPcsWhenUpdate: [],
        responMicroPcsBeforeUpdate: [],
        infoFile: {},
        displaySpinner: false,
        sidebarIconClicked: false
    },

    getters: {
    },

    mutations: {
        startSpinner: state => state.displaySpinner = true,
        stopSpinner: state => state.displaySpinner = false,
        clickSidebarIcon: (state) => {
            state.sidebarIconClicked = !state.sidebarIconClicked;
        },
        [DESTROY_INFO_FILE]: (state) => {
            state.infoFile = {}
        },
    },

    actions: {
        destroyinfoFile({ commit }) {
            commit(DESTROY_INFO_FILE)
        },
    }
});