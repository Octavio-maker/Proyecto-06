import 'bootstrap/dist/css/bootstrap.min.css' // Importamos Bootstrap
import 'bootstrap/dist/js/bootstrap.bundle.min.js' // Importamos JS de Bootstrap

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import router from './router'

const app = createApp(App)

app.use(createPinia())
app.use(router)

app.mount('#app')