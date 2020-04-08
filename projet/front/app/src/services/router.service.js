import Vue from 'vue'
import VueRouter from 'vue-router'
import StorageService from "./storage.service";

Vue.use(VueRouter);

const RouterService = {

    getRouter() {
        return this.router;
    },

    router : null,

    init(routes) {
        this.router = new VueRouter({
            mode: 'history',
            base: process.env.BASE_URL,
            routes
        });

        this.handleSecurity()
    },

    /**
     * https://router.vuejs.org/guide/advanced/navigation-guards.html
     */
    handleSecurity() {
        this.router.beforeEach((to, from, next) => {
            if (!StorageService.has("auth_user") && to.name !== "Login") {
                next({name: 'Login'});
            } else {
                next();
            }
        });
    },

};

export default RouterService;