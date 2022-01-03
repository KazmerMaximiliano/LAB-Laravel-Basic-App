import Vue from 'vue'
import App from './App.vue'
import router from './routes'
import store from './store'
import VueAuth from './plugins/vue-auth'
import './config'

window.axios = require('axios')
window.axios.defaults.withCredentials = true

Vue.use(VueAuth, { router })
Vue.prototype.$user.set({
  rol: JSON.parse(localStorage.getItem('rol')) || 'not_authorized'
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

Vue.config.productionTip = false

new Vue({
  router,
  store,
  render: function (h) {
    return h(App)
  }
}).$mount('#app')
