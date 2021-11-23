<template>
  <div>
    <v-row justify="center">
      <v-col cols="12" class="py-0 px-5">
        <v-text-field
          v-model="form.name"
          :rules="[rules.required]"
          label="Nombre"
          outlined
        ></v-text-field>
      </v-col>
      <v-col cols="12" class="py-0 px-5">
        <v-text-field
          v-model="form.email"
          :rules="[rules.required]"
          label="Email"
          outlined
        ></v-text-field>
      </v-col>
      <v-col cols="12" class="py-0 px-5">
        <v-text-field
          v-model="form.password"
          :rules="rulesPassword ? [rules.required, rules.max, rules.min] : []"
          :append-icon="password ? 'fas fa-eye' : 'fas fa-eye-slash'"
          @click:append="password = !password"
          :type="password ? 'text' : 'password'"
          label="Contraseña"
          outlined
        ></v-text-field>
      </v-col>
      <v-col cols="12" class="py-0 px-5">
        <v-text-field
          v-model="form.password_confirm"
          :rules="
            rulesPassword
              ? [rules.required, rules.max, rules.min, confirmpass]
              : [confirmpass]
          "
          :append-icon="confirm_password ? 'fas fa-eye' : 'fas fa-eye-slash'"
          @click:append="confirm_password = !confirm_password"
          :type="confirm_password ? 'text' : 'password'"
          label="Confirmar Contraseña"
          outlined
        ></v-text-field>
      </v-col>
      <v-col cols="12" class="py-0 px-5" v-if="$store.state.roles.roles">
        <v-select
          v-model="form.role_id"
          :items="$store.state.roles.roles.roles"
          item-text="role"
          item-value="id"
          label="Rol"
          outlined
        ></v-select>
      </v-col>
    </v-row>
  </div>
</template>

<script>
export default {
  data: () => ({
    form: {},
    password: false,
    confirm_password: false,
    rules: {
      required: (value) => !!value || 'Este campo es obligatorio',
      max: (value) =>
        (value && value.length <= 255) ||
        'Este campo no puede contener mas de 255 digitos',
      min: (value) =>
        (value && value.length >= 6) ||
        'Este campo debe contener al menos 6 digitos'
    }
  }),

  props: ['mode'],

  computed: {
    rulesPassword() {
      if (this.mode == 'create') {
        return true
      } else if (this.mode == 'edit') {
        if (this.form.password) {
          return true
        } else {
          return false
        }
      }
    }
  },

  mounted() {
    this.$store.dispatch('roles/index')
    if (this.mode == 'edit') {
      this.form = this.$store.state.users.form
    }
  },

  methods: {
    confirmpass() {
      if (this.form.password != this.form.password_confirm) {
        return 'Las contraseñas no coinciden'
      } else {
        return true
      }
    },

    fillForm() {
      this.$store.commit('users/fillForm', this.form)
    }
  }
}
</script>
