import './bootstrap';
import { createApp } from 'vue'
import { createHead } from '@vueuse/head'
import { createPinia } from 'pinia'
import App from './App.vue'
import router from './router'
import { useDarkModeStore } from './stores/darkMode'

const app = createApp(App)
const head = createHead()
const pinia = createPinia()

app.use(router)
app.use(head)
app.use(pinia)

// Initialize dark mode
const darkModeStore = useDarkModeStore()
darkModeStore.initDarkMode()

app.mount('#app')
