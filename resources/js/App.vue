<template>
  <div>
    <Layout>
      <router-view></router-view>
    </Layout>
  </div>
</template>

<script>
import Layout from './layouts/Layout.vue'
export default {
  components: {
    Layout
  }
}
</script>
