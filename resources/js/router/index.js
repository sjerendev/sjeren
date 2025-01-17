import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            name: 'home',
            component: () => import('../pages/Home.vue')
        },
        {
            path: '/blog',
            name: 'blog',
            component: () => import('../pages/Blog.vue')
        },
        {
            path: '/blog/:slug',
            name: 'post',
            component: () => import('../pages/Post.vue')
        },
        {
            path: '/:slug',
            name: 'page',
            component: () => import('../pages/Page.vue')
        },
        {
            path: '/:pathMatch(.*)*',
            name: 'not-found',
            component: () => import('../pages/NotFound.vue')
        }
    ]
})

export default router
