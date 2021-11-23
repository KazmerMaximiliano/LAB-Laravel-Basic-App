<template>
  <div>
    <v-tooltip left>
      <template v-slot:activator="{ on }">
        <v-btn
          color="secondary"
          dark
          fab
          fixed
          right
          bottom
          large
          v-on="on"
          @click="$router.go(-1)"
        >
          <v-icon>fas fa-chevron-left</v-icon>
        </v-btn>
      </template>
      <span>Volver</span>
    </v-tooltip>

    <v-row justify="center">
      <v-col cols="10" md="8" lg="6">
        <v-card class="rounded-xl" outlined>
          <v-card-title>Nuevo usuario</v-card-title>
          <v-divider></v-divider>
          <v-card-text class="mt-6 mb-2">
            <v-row justify="center">
              <v-col cols="12" sm="10">
                <v-form ref="CreateUsers" @submit.prevent="saveUser()">
                  <UsersForm mode="create" ref="UsersForm"></UsersForm>
                  <v-row justify="center">
                    <v-btn
                      type="submit"
                      rounded
                      class="elevation-0 mb-2"
                      :disabled="$store.state.inProcess"
                      :loading="$store.state.inProcess"
                      color="secondary"
                      >Guardar</v-btn
                    >
                  </v-row>
                </v-form>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import UsersForm from '../../components/users/UsersForm'

export default {
  data: () => ({
    inProcess: false
  }),

  components: {
    UsersForm
  },

  mounted() {
    this.$refs.CreateUsers.reset()
  },

  methods: {
    saveUser: async function () {
      if (this.$refs.CreateUsers.validate()) {
        this.$refs.UsersForm.fillForm()
        await this.$store.dispatch('users/save')
        this.updateSession()
        this.$router.push('/users')
      }
    },

    updateSession() {
      this.$store
        .dispatch('auth/user')
        .then((response) => {
          response.permissions.push('authenticated')
          this.$user.set({
            rol: response.rol,
            permissions: response.permissions
          })
        })
        .catch((error) => {
          dispatch('errorHandle', error.response, {
            root: true
          })
        })
    }
  }
}
</script>

<style></style>
