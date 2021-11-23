<template>
  <v-footer class="footer" absolute>
    <v-spacer></v-spacer>
    <v-col cols="auto">
      <v-img src="/img/isotipo.png" width="56px" class="my-2 mx-auto"></v-img>
      {{ new Date().getFullYear() }} — <strong>{{ $appName }}</strong>
    </v-col>
  </v-footer>
</template>

<script>
export default {
  computed: {
    currentRoute() {
      return this.$route.name
    }
  }
}
</script>
