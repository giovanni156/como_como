import '../sass/app.sass'
import 'vue3-toastify/dist/index.css'

import { createPinia } from 'pinia'
import { createApp } from 'vue'
import Vue3Toastify, { type ToastContainerOptions } from 'vue3-toastify'

import TheApp from '@/components/layouts/MainLayout.vue'
import router from '@/router/index'

export const pinia = createPinia()

const app = createApp(TheApp)
    .use(pinia)
    .use(router)
    .use(Vue3Toastify, {
        autoClose: 5000,
        theme: 'colored',
    } as ToastContainerOptions)

app.mount("#app")
