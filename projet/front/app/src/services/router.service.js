import Vue from 'vue'
import VueRouter from 'vue-router'

//import StorageService from './storage.service';

Vue.use(VueRouter);

const RouterService = {

    getRouter() {
        return this.router;
    },

    router : null,

    init() {
        const routes = [
            {
                path: '/',
                name: 'Dashboard',
                meta: {title: 'Reucopro'},
                components: {
                    default: () => import('../views/Dashboard.vue')
                },
            },
            {
                path: '/login',
                name: 'Login',
                meta: {title: 'Reucopro - login'},
                components: {
                    default: () => import('../views/Login.vue')
                },
            },
            /* {
              path: '/ogout',
              name: 'Logout',
              components: {
                default: () => import('../views/Login.vue')
              },
            },
            /* {
              path: '/utilisateur/:id', component: User,
              children: [
                {
                  path: 'profile',
                  component: UserProfile
                },
                {
                  path: 'posts',
                  component: UserPosts
                }
              ]
            }, */
        ];

        this.router = new VueRouter({
            mode: 'history',
            base: process.env.BASE_URL,
            routes
        });

        this.handleSecurity()
    },

    handleSecurity() {
        this.router.beforeEach((to, from, next) => {
            console.log(to)
            console.log(from)
            //console.log(next)
            next();
        })
    },

};

export default RouterService;