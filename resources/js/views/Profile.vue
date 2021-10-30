<template>
  <div>
    <v-row justify="center">
      <v-col cols="12" lg="4">
        <v-card outlined flat min-height="390px">
          <v-card-text>
            <Account></Account>
          </v-card-text>
          <v-card-actions style="position: absolute; bottom: 0; width: 100%">
            <v-btn color="error" text block @click="exit()"
              >Cerrar sesión</v-btn
            >
          </v-card-actions>
        </v-card>
      </v-col>
      <v-col cols="12" lg="8">
        <Preferences></Preferences>
      </v-col>
      <v-col cols="12">
        <v-card outlined shaped>
          <v-card-text class="pa-0">
            <Backup></Backup>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import Account from '../components/auth/Account.vue'
import Preferences from '../components/auth/Preferences'
import Backup from '../components/admin/Backup.vue'

export default {
  components: {
    Account,
    Preferences,
    Backup
  },

  methods: {
    async exit() {
      await this.$store.dispatch('auth/logout')
    }
  }
}
</script>

<style></style>
