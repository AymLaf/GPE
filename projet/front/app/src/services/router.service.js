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

    handleSecurity() {
        this.router.beforeEach((to, from, next) => {
            console.log(to);
            console.log(from);
            if (!StorageService.has("auth_user") && to.name !== "Login") {
                console.log("oui");
                next({name: 'Login'});
            } else {
                next();
            }

            //console.log(next)
            //next();
        });
    },

};

export default RouterService;