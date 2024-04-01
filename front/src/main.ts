import './assets/scss/global.scss'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { createYmaps } from 'vue-yandex-maps'

import App from './app.vue'
import router from './router'
import vuetify from './plugins/vuetify'
import { initCustomDirectives } from './directives'

const pinia = createPinia()
const app = createApp(App)

initCustomDirectives(app)

app.use(router)
app.use(pinia)
app.use(vuetify)
app.use(createYmaps({
  apikey: '9811b22a-e004-49b4-ac9a-4103a26f10ee',
}))

router.isReady().then(() => app.mount('#app'))
