<template>
  <div style="height: 100vh" class="d-flex justify-center align-center">
    <v-scroll-x-transition mode="out-in">
      <div v-if="!loginDialog" key="home">
        <v-row justify="center">
          <img src="/img/logo.png" width="300" height="auto" />
        </v-row>
        <v-row justify="center">
          <v-btn
            tile
            color="primary"
            class="elevation-0 my-10"
            @click="loginDialog = true"
            >Iniciar sesión</v-btn
          >
        </v-row>
      </div>

      <div v-if="loginDialog" key="login">
        <v-row justify="center" align="center">
          <v-card min-width="400px" max-width="400px" width="100%" outlined>
            <v-card-title primary-title>Iniciar Sesión</v-card-title>
            <v-divider></v-divider>
            <v-card-text>
              <v-row justify="center" align="center" style="height: 250px">
                <v-col cols="12" pa-3 v-if="$store.state.inProcess">
                  <v-row justify="center">
                    <v-progress-circular
                      :size="70"
                      :width="7"
                      color="primary"
                      indeterminate
                    ></v-progress-circular>
                  </v-row>
                </v-col>
                <v-col cols="12" v-else>
                  <v-form ref="loginForm" @submit.prevent="login()">
                    <v-row justify="center">
                      <v-col cols="12" class="py-0 px-5">
                        <v-text-field
                          v-model="$store.state.auth.form.email"
                          :rules="[rules.required]"
                          label="Email"
                          color="primary"
                          outlined
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" class="py-0 px-5">
                        <v-text-field
                          v-model="$store.state.auth.form.password"
                          :rules="[rules.required]"
                          :append-icon="
                            password_type ? 'fas fa-eye' : 'fas fa-eye-slash'
                          "
                          @click:append="password_type = !password_type"
                          :type="password_type ? 'text' : 'password'"
                          label="Contraseña"
                          color="primary"
                          outlined
                        ></v-text-field>
                      </v-col>
                    </v-row>
                    <v-row justify="end">
                      <v-btn
                        @click="loginDialog = false"
                        text
                        class="mr-5 elevation-0"
                        color="primary"
                        >Cancelar</v-btn
                      >
                      <v-btn
                        type="submit"
                        tile
                        class="mr-5 elevation-0"
                        color="primary"
                        >Iniciar sesión</v-btn
                      >
                    </v-row>
                  </v-form>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-row>
      </div>
    </v-scroll-x-transition>
  </div>
</template>

<script>
export default {
  data: () => ({
    loginDialog: false,
    password_type: false,
    rules: {
      required: (value) => !!value || 'Este campo es obligatorio'
    }
  }),

  methods: {
    login: async function () {
      if (this.$refs.loginForm.validate()) {
        await this.$store.dispatch('auth/login')
        let user = await this.$store.dispatch('auth/user')
        user.permissions.push('authenticated')
        this.$user.set({
          rol: user.rol,
          permissions: user.permissions
        })
      }
    }
  }
}
</script>
