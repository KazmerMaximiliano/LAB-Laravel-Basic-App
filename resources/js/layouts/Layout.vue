<template>
  <v-app class="layout">
    <AppBar></AppBar>
    <v-main>
      <v-container>
        <v-row justify="center" v-if="inProcess">
          <v-progress-circular
            :size="70"
            :width="7"
            color="primary"
            indeterminate
            style="margin-top: 250px"
          ></v-progress-circular>
        </v-row>
        <div v-else>
          <Errors></Errors>
          <slot></slot>
        </div>
      </v-container>
    </v-main>
    <Footer></Footer>
  </v-app>
</template>

<script>
import AppBar from './components/AppBar.vue'
import Errors from './components/Errors'
import Footer from './components/Footer.vue'

export default {
  data: () => ({
    inProcess: false
  }),

  components: {
    AppBar,
    Errors,
    Footer
  },

  mounted() {
    if (JSON.parse(window.localStorage.getItem('logged'))) {
      this.recoverSession()
    }
  },

  methods: {
    recoverSession() {
      this.inProcess = true
      this.$store
        .dispatch('auth/user')
        .then((response) => {
          response.permissions.push('authenticated')
          this.$user.set({
            rol: response.rol,
            permissions: response.permissions
          })
          this.inProcess = false
        })
        .catch((error) => {
          this.inProcess = false
        })
    }
  }
}
</script>
