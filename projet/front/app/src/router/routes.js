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
    {
        path: '/test',
        name: 'Test',
        meta: {title: 'Reucopro - test'},
        components: {
            default: () => import('../views/Test.vue')
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

export default routes;