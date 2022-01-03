<template>
  <div>
    <v-container>
      <h1>Event Test</h1>
      <h3>{{ hello }}</h3>
      <v-btn @click="testWS()">Test WS</v-btn>
    </v-container>
  </div>
</template>

<script>
export default {
  data: () => ({
    hello: null
  }),

  mounted() {
    window.Echo.channel('test_channel').listen('Hello', (e) => {
      console.log(e)
      this.hello = e.hello
    })
  },

  methods: {
    testWS() {
      axios.get('/api/websockets/test')
    }
  }
}
</script>

<style></style>
