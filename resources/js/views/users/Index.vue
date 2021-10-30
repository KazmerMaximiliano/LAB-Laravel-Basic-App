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
          to="users/nuevo"
        >
          <v-icon>fas fa-plus</v-icon>
        </v-btn>
      </template>
      <span>Nuevo usuario</span>
    </v-tooltip>

    <v-container>
      <v-row justify="center">
        <v-col cols="12" lg="10">
          <v-card shaped outlined :loading="$store.state.inProcess">
            <v-card-title>Usuarios</v-card-title>
            <v-divider></v-divider>
            <v-card-text class="px-0">
              <v-row justify="center" v-if="$store.state.inProcess">
                <div>
                  <v-progress-circular
                    indeterminate
                    color="primary"
                  ></v-progress-circular>
                </div>
              </v-row>
              <div v-else-if="$store.state.users.users">
                <UsersTable
                  v-if="$store.state.users.users.length > 0"
                  :users="$store.state.users.users"
                  @delete="getUsers()"
                ></UsersTable>
              </div>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import UsersTable from '../../components/users/UsersTable.vue'

export default {
  components: {
    UsersTable
  },

  mounted() {
    this.getUsers()
  },

  methods: {
    async getUsers() {
      await this.$store.dispatch('users/index')
    }
  }
}
</script>

<style></style>
