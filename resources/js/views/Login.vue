<template>
  <div class="container">
    <div class="item">
      <img src="/img/imagotipo.png" width="300" height="auto" />
    </div>
    <div class="item">
      <h1>{{ hello }}</h1>
      <button @click="testWS()">PROBANDO WS</button>
    </div>
    <div class="item">
      <h1 class="title">LOGIN</h1>
    </div>
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

<style lang="scss" scoped>
.container {
  height: 85vh;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
  .item {
    flex: 0 1 auto;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .title {
    font-weight: bold;
    text-align: center;
    margin-top: 24px;
  }
}
</style>
