<template>
  <div>
    <v-row justify="center">
      <v-col cols="12" md="10">
        <Account></Account>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import Account from '../components/auth/Account.vue'

export default {
  components: {
    Account
  }
}
</script>
