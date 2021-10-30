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
        <v-card shaped outlined>
          <v-card-title>Editar usuario</v-card-title>
          <v-divider></v-divider>
          <v-card-text class="mt-6 mb-2">
            <v-row justify="center">
              <v-col cols="12" sm="10">
                <v-form ref="CreateUsers" @submit.prevent="saveUser()">
                  <UsersForm mode="edit"></UsersForm>
                  <v-row justify="center">
                    <v-btn
                      type="submit"
                      tile
                      class="elevation-0"
                      :disabled="$store.state.inProcess"
                      :loading="$store.state.inProcess"
                      color="secondary"
                      >Guardar</v-btn
                    >
                  </v-row>
                  <br />
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
    if (!this.$store.state.users.form.name) {
      this.$router.push('/users')
    }
  },

  methods: {
    saveUser: async function () {
      if (this.$refs.CreateUsers.validate()) {
        await this.$store.dispatch('users/update', {
          id: this.$store.state.users.form.id
        })
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
          this.process = false
        })
        .catch((error) => {
          this.process = false
        })
    }
  }
}
</script>

<style></style>
