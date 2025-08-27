import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'
import api from './api'
import './assets/global.scss'
import { Quasar } from 'quasar'
import quasarIconSet from 'quasar/icon-set/material-icons'
import 'quasar/src/css/index.sass'
import '@quasar/extras/material-icons/material-icons.css'

const app = createApp(App)

app.config.globalProperties.$api = api

app.use(Quasar, {
  plugins: {},
  iconSet: quasarIconSet,
})

app.use(createPinia())
app.use(router)

app.mount('#app')
