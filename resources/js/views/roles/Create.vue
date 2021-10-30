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
          <v-card-title>Nuevo rol</v-card-title>
          <v-divider></v-divider>
          <v-card-text class="mt-6 mb-2">
            <v-row justify="center">
              <v-col cols="12" sm="10">
                <v-form ref="CreateRoles" @submit.prevent="saveRol()">
                  <v-row justify="center">
                    <v-col cols="12" class="py-0 px-5">
                      <v-text-field
                        v-model="$store.state.roles.form.role"
                        :rules="[rules.required]"
                        label="Rol"
                        outlined
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" class="py-0 px-5">
                      <v-select
                        v-model="permissions"
                        :items="permissionsArray"
                        :rules="[rules.required]"
                        item-text="description"
                        item-value="permission"
                        label="Permisos"
                        persistent-hint
                        multiple
                        outlined
                      ></v-select>
                    </v-col>
                  </v-row>
                  <v-row justify="center">
                    <v-btn
                      type="submit"
                      tile
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
export default {
  data: () => ({
    permissionsArray: [],
    permissions: null,
    rules: {
      required: (value) => !!value || 'Este campo es obligatorio'
    }
  }),

  mounted() {
    this.$refs.CreateRoles.reset()
    this.getPermissions()
  },

  methods: {
    async getPermissions() {
      let permissions = await this.$store.dispatch('roles/permissions')
      let permissionsArray = permissions.permissions.split(' ')
      let descriptionsArray = permissions.descriptions.split(', ')

      for (let i = 0; i < permissionsArray.length; i++) {
        if (permissionsArray[i] != '') {
          this.permissionsArray.push({
            permission: permissionsArray[i],
            description: descriptionsArray[i]
          })
        }
      }
    },

    async saveRol() {
      if (this.$refs.CreateRoles.validate()) {
        let permission = ''
        let description = ''
        for (let i = 0; i < this.permissions.length; i++) {
          let find = this.permissionsArray.find(
            (e) => e.permission === this.permissions[i]
          )

          if (find) {
            permission = `${find.permission} ${permission}`
            description = `${find.description}, ${description}`
          }
        }
        this.$store.state.roles.form.permission = permission
        this.$store.state.roles.form.description = description
        await this.$store.dispatch('roles/save')
        this.$router.push('/roles')
      }
    }
  }
}
</script>

<style></style>
