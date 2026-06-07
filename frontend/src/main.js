import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import router from './router'
import { vCan } from './directives/can'

const app = createApp(App)

app.use(createPinia())
app.use(router)

app.directive('can', vCan)

app.mount('#app')