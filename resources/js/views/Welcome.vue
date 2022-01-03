<template>
  <div class="container">
    <div class="item">
      <img src="/img/imagotipo.png" width="300" height="auto" />
    </div>
    <div class="item">
      <h1 class="title">WELCOME</h1>
    </div>
  </div>
</template>

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
