<template>
  <div v-if="$store.state.errors.errors.length > 0">
    <div v-for="(error, i) in $store.state.errors.errors" :key="i">
      <v-alert color="error" border="left" colored-border>
        <div v-if="error.data.message" class="ml-5">
          <p class="error--text">
            <b>Error {{ error.status }}:</b>
            {{ error.data.message }}
          </p>
          <div v-for="(messages, k) in error.data.errors" :key="k">
            <p v-for="(msg, j) in messages" :key="j">{{ msg }}</p>
          </div>
        </div>
        <div v-else class="ml-5">
          <p class="error--text">
            <b>Error {{ error.status }}:</b>
            {{ error.data }}
          </p>
        </div>
        <v-row justify="end">
          <v-btn
            tile
            text
            class="elevation-0 mt-2"
            color="error"
            @click="$store.commit('errors/deleteError', error, { root: true })"
            >Cerrar</v-btn
          >
          <br />
        </v-row>
      </v-alert>
    </div>
  </div>
</template>
