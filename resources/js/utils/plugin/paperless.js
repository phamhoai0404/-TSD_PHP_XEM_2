const Paperless = {
    install(Vue, options) {
        Vue.mixin({
            methods: {
                startSpinner() {
                    this.$store.commit('startSpinner');
                },
                stopSpinner() {
                    this.$store.commit('stopSpinner');
                },
                clickSideBarIcon() {
                    this.$store.commit('clickSidebarIcon');
                }
            }
        })
    }
};

export default Paperless;