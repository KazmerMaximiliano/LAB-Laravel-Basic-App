<template>
  <div class="d-flex justify-center" v-if="$store.state.auth.user">
    <div>
      <div class="account-edit-btn-container">
        <v-btn icon small color="primary" @click="edit()"
          ><v-icon size="small">fas fa-pen</v-icon></v-btn
        >
      </div>
      <div class="py-4 d-flex justify-center">
        <v-avatar
          v-on="on"
          size="90"
          color="primary"
          style="cursor: pointer"
          @click="fotoDialog = true"
        >
          <img
            v-if="$store.state.auth.user.user.foto != null"
            :src="$store.state.auth.user.user.foto"
            width="100%"
            height="auto"
          />
          <span
            v-else-if="$store.state.auth.user.user.name"
            class="white--text text-uppercase"
            style="font-size: 30px"
          >
            {{ $store.state.auth.user.user.name[0] }}
          </span>
          <div
            class="account-edit-photo-btn-container"
            @click="editPhotoDialog = true"
          >
            <v-icon color="white">fas fa-pen</v-icon>
          </div>
        </v-avatar>
      </div>
      <h2 class="text-center primary--text my-4">
        {{ $store.state.auth.user.user.name }}
      </h2>
      <v-divider></v-divider>
      <p class="mt-4">{{ $store.state.auth.user.user.email }}</p>
    </div>

    <v-dialog v-model="editPhotoDialog" max-width="450px">
      <v-card>
        <v-card-title>Editar foto</v-card-title>
        <v-divider></v-divider>
        <v-card-text class="py-8">
          <v-row justify="center">
            <div v-if="inProcess">
              <v-progress-circular
                :size="70"
                :width="7"
                color="primary"
                indeterminate
                style="margin-top: 50px"
              ></v-progress-circular>
            </div>
            <div class="edit-photo-croppa" v-else>
              <croppa
                v-model="foto"
                :width="250"
                :height="250"
                placeholder="Foto de perfil"
                placeholder-color="#000"
                :placeholder-font-size="25"
                canvas-color="transparent"
                :show-remove-button="false"
                :show-loading="true"
                :loading-size="25"
                :prevent-white-space="true"
                :zoom-speed="10"
                @file-choose="newFoto = true"
                :initial-image="
                  $store.state.auth.user.user.photo
                    ? $store.state.auth.user.user.photo
                    : ''
                "
              ></croppa>
            </div>
          </v-row>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="error"
            text
            @click="editPhotoDialog"
            :disabled="inProcess"
            >Cancelar</v-btn
          >
          <v-btn color="success" text @click="editPhoto()" :disabled="inProcess"
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
    foto: null,
    newFoto: false,
    editPhotoDialog: false
  }),
  methods: {
    async edit() {
      await this.$store.dispatch('usuarios/edit', {
        data: this.$store.state.auth.user.user
      })
      this.$router.push('usuarios/editar/1')
    },
    async editPhoto() {
      this.inProcess = true
      let profilePhoto = this.foto.generateDataUrl()
      let user = this.$store.state.auth.user.user
      user.foto = profilePhoto
      user.newFoto = this.newFoto
      await this.$store.commit('auth/fillForm', user)
      await this.$store.dispatch('auth/updateAccount', {
        id: this.$store.state.auth.user.user.id
      })
      await this.$store.dispatch('auth/user')
      this.inProcess = false
      this.editPhotoDialog = false
    }
  }
}
</script>

<style lang="scss">
.account-edit-btn-container {
  position: absolute;
  top: 12px;
  right: 12px;
}
.account-edit-photo-btn-container {
  height: 100%;
  width: 100%;
  position: absolute;
  top: 0;
  left: 0;
  background-color: rgba($color: #000, $alpha: 0.5);
  cursor: pointer;
  opacity: 0;
  &:hover {
    opacity: 1;
  }
}
.edit-photo-croppa {
  height: 250px;
  width: 250px;
  clip-path: circle(50% at 50% 50%);
}
</style>
