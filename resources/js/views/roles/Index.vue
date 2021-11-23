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
          to="roles/nuevo"
        >
          <v-icon>fas fa-plus</v-icon>
        </v-btn>
      </template>
      <span>Nuevo rol</span>
    </v-tooltip>

    <v-container>
      <v-row justify="center">
        <v-col cols="12" lg="10">
          <v-card class="rounded-xl" outlined :loading="$store.state.inProcess">
            <v-card-title>Roles</v-card-title>
            <v-divider></v-divider>
            <v-card-text class="px-0">
              <v-row justify="center" v-if="$store.state.inProcess">
                <div>
                  <v-progress-circular
                    indeterminate
                    color="primary"
                    class="my-4"
                  ></v-progress-circular>
                </div>
              </v-row>
              <div v-else-if="$store.state.roles.roles">
                <div
                  v-for="(rol, i) in $store.state.roles.roles.roles"
                  :key="i"
                  @click="deploy($event, rol)"
                  @contextmenu="deploy($event, rol)"
                >
                  <v-list dense>
                    <v-list-item>
                      <v-list-item-content class="py-0">
                        <div class="d-flex justify-space-between">
                          <b>Rol: </b>
                          <p>{{ rol.role }}</p>
                        </div>
                      </v-list-item-content>
                    </v-list-item>
                    <v-list-item>
                      <v-list-item-content class="py-0">
                        <div class="d-flex justify-space-between">
                          <b>Permisos: </b>
                        </div>
                      </v-list-item-content>
                    </v-list-item>
                    <v-list-item>
                      <v-list-item-content class="py-0">
                        <div
                          class="d-flex justify-space-between"
                          v-for="(permiso, i) in rol.permission"
                          :key="i"
                        >
                          <b>{{ permiso }}</b>
                          <p>{{ rol.description[i] }}</p>
                        </div>
                      </v-list-item-content>
                    </v-list-item>
                  </v-list>
                  <v-divider></v-divider>
                </div>
              </div>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>

    <v-menu
      v-model="menu"
      :position-x="menuX"
      :position-y="menuY"
      absolute
      offset-y
    >
      <v-list v-if="selectedItem">
        <v-list-item @click="edit()">
          <v-list-item-title>Editar</v-list-item-title>
        </v-list-item>
        <v-list-item
          @click="deleteDialog = true"
          v-if="selectedItem.role != 'superAdmin'"
        >
          <v-list-item-title>Eliminar</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-menu>

    <v-dialog v-model="deleteDialog" persistent width="450px">
      <v-card v-if="inProcess">
        <v-row justify="center">
          <v-progress-circular
            :size="70"
            :width="7"
            color="primary"
            indeterminate
            style="margin: 32px 0 32px 0"
          ></v-progress-circular>
        </v-row>
      </v-card>
      <v-card v-else>
        <v-card-title class="headline">¿Estas seguro?</v-card-title>
        <v-card-text>
          Se eliminará el rol seleccionado, esta acción es irreversible.
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="error"
            text
            rounded
            @click="
              deleteDialog = false
              selectedItem = null
            "
            :disabled="inProcess"
            >Cancelar</v-btn
          >
          <v-btn
            color="success"
            text
            rounded
            @click="deleteRol()"
            :disabled="inProcess"
            >Aceptar</v-btn
          >
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  data: () => ({
    inProcess: false,
    deleteDialog: false,
    menu: false,
    menuX: 0,
    menuY: 0,
    selectedItem: null
  }),

  mounted() {
    this.getRoles()
  },

  methods: {
    test() {
      console.log('asdfasdf')
    },

    async getRoles() {
      await this.$store.dispatch('roles/index')
    },

    deploy(event, item) {
      event.preventDefault()
      this.menu = false
      this.selectedItem = item
      this.menuX = event.clientX
      this.menuY = event.clientY
      this.$nextTick(() => {
        this.menu = true
      })
    },

    edit() {
      this.$store.dispatch('roles/edit', { data: this.selectedItem })
      this.$router.push('/roles/editar')
    },

    async deleteRol() {
      this.inProcess = true
      await this.$store.dispatch('roles/destroy', { id: this.selectedItem.id })
      this.getRoles()
      this.inProcess = false
      this.deleteDialog = false
    }
  }
}
</script>
