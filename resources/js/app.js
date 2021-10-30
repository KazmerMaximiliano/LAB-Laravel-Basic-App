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
import './directives'
import './filters'

window.axios = require('axios')
window.axios.defaults.withCredentials = true

Vue.use(Croppa)

Vue.use(JsonViewer)

Vue.use(VueAuth, { router })
Vue.prototype.$user.set({
  rol: 'not_authorized',
  permissions: []
})

Vue.config.productionTip = false

new Vue({
  router,
  store,
  vuetify,
  render: function (h) {
    return h(App)
  }
}).$mount('#app')