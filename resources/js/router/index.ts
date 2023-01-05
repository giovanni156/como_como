import { createRouter, createWebHistory, RouteLocationNormalized, RouteRecordRaw } from "vue-router"
import routes from '@/router/routes'

const router = createRouter({
    history: createWebHistory(),
    routes: routes as RouteRecordRaw[],
    linkActiveClass: 'nav-link-active'
})

export default router
