import { RouteRecordRaw } from "vue-router"

const routes: Array<RouteRecordRaw> = [
    {
        name: 'index',
        path: '/',
        component: () => import('@/components/pages/IndexPage.vue'),
        meta: {
            needsAuth: false
        }
    }
]

export default routes
