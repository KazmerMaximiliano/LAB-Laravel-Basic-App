<template>
  <v-app>
    <v-main>
      <AppBar></AppBar>
      <v-container :class="currentRoute == 'home' ? 'no-container' : ''">
        <v-row justify="center" v-if="process">
          <v-progress-circular
            :size="70"
            :width="7"
            color="primary"
            indeterminate
            style="margin-top: 250px"
          ></v-progress-circular>
        </v-row>
        <div v-else class="scroll-fix-height">
          <Errors></Errors>
          <router-view></router-view>
        </div>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import AppBar from './components/app/AppBar.vue'
import Errors from './components/app/Errors'

export default {
  data: () => ({
    process: false
  }),

  components: {
    AppBar,
    Errors
  },

  computed: {
    currentRoute() {
      return this.$route.name
    }
  },

  mounted() {
    if (JSON.parse(window.localStorage.getItem('logged'))) {
      this.recoverSession()
    }

    if (window.localStorage.getItem('isDark')) {
      let isDark = JSON.parse(window.localStorage.getItem('isDark'))
      this.$vuetify.theme.isDark = isDark
    }

    if (window.localStorage.getItem('customTheme')) {
      let customTheme = JSON.parse(window.localStorage.getItem('customTheme'))
      this.$vuetify.theme.themes.light = customTheme.light
      this.$vuetify.theme.themes.dark = customTheme.dark
    }
  },

  methods: {
    recoverSession() {
      this.process = true
      this.$store
        .dispatch('auth/user')
        .then((response) => {
          response.permissions.push('authenticated')
          this.$user.set({
            rol: response.rol,
            permissions: response.permissions
          })
          this.process = false
        })
        .catch((error) => {
          this.process = false
        })
    }
  }
}
</script>

<style lang="scss">
body::-webkit-scrollbar {
  width: 6px;
}

body::-webkit-scrollbar-thumb {
  background-color: #151515;
}

.scroll-fix-height {
  min-height: 101%;
}

.no-container {
  padding: 0px !important;
}

@media (min-width: 960px) {
  .no-container {
    max-width: 100% !important;
  }
}
</style>
