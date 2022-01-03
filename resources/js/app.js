import Vue from 'vue'
import App from './App.vue'
import router from './routes'
import store from './store'
import vuetify from './plugins/vuetify'
import Croppa from 'vue-croppa'
import VueAuth from './plugins/vue-auth'
import JsonViewer from 'vue-json-viewer'
import 'vue-croppa/dist/vue-croppa.css'
import './config'

Vue.prototype.$appName = 'Laravel Basic App'

window.axios = require('axios')
window.axios.defaults.withCredentials = true

Vue.use(Croppa)

Vue.use(JsonViewer)

Vue.use(VueAuth, { router })
Vue.prototype.$user.set({
  rol: JSON.parse(localStorage.getItem('rol')) || 'not_authorized',
  permissions: JSON.parse(localStorage.getItem('rol')) ? ['authenticated'] : []
})

// WEBSOCKETS
import Echo from 'laravel-echo'
window.pusher = require('pusher-js')

window.Echo = new Echo({
  broadcaster: 'pusher',
  key: 'local',
  wsHost: '127.0.0.1',
  wsPort: 6001,
  forceTLS: false,
  disableStats: true
})

//

Vue.config.productionTip = false

new Vue({
  router,
  store,
  vuetify,
  render: function (h) {
    return h(App)
  }
}).$mount('#app')
