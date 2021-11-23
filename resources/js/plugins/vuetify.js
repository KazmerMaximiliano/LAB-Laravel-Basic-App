import '@fortawesome/fontawesome-free/css/all.css'
import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import es from 'vuetify/es5/locale/es'

Vue.use(Vuetify)

export default new Vuetify({
  theme: {
    dark: false,
    themes: {
      light: {
        primary: '#5E00FF',
        secondary: '#A169FF',
        accent: '#5E00FF',
        error: '#F44336',
        info: '#00BCD4',
        success: '#4CAF50',
        warning: '#FFC107',
        disabled: '#787878'
      }
    }
  },
  options: {
    customProperties: true
  },
  icons: {
    iconfont: 'fa'
  },
  lang: {
    locales: { es },
    current: 'es'
  }
})
