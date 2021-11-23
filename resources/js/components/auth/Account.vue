<template>
  <div v-if="$store.state.auth.user">
    <div class="d-flex flex-nowrap flex-row">
      <div>
        <v-avatar
          v-on="on"
          :size="$vuetify.breakpoint.smAndDown ? '90' : '150'"
          color="primary"
          class="profile-avatar"
          @click="editPhotoDialog = true"
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
          <div class="account-edit-photo-btn-container">
            <v-icon color="white">fas fa-pen</v-icon>
          </div>
        </v-avatar>
      </div>
      <div class="mx-6 mt-2 d-flex flex-column">
        <h2 class="primary--text">
          {{ $store.state.auth.user.user.name }}
        </h2>
        <v-divider class="my-1"></v-divider>
        <p>{{ $store.state.auth.user.user.email }}</p>
        <v-row>
          <v-col cols="auto">
            <v-btn
              rounded
              outlined
              color="error"
              :icon="$vuetify.breakpoint.smAndDown"
              @click="exit()"
            >
              <v-icon v-if="$vuetify.breakpoint.smAndDown" size="medium">
                fas fa-sign-out-alt
              </v-icon>
              <div v-else>Cerrar Sesión</div>
            </v-btn>
          </v-col>
          <v-col cols="auto">
            <v-btn
              rounded
              outlined
              color="blue"
              :icon="$vuetify.breakpoint.smAndDown"
              @click="edit()"
            >
              <v-icon v-if="$vuetify.breakpoint.smAndDown" size="medium">
                fas fa-pen
              </v-icon>
              <div v-else>Editar Cuenta</div>
            </v-btn>
          </v-col>
        </v-row>
      </div>
    </div>

    <v-dialog v-model="editPhotoDialog" max-width="450px">
      <v-card>
        <v-card-title>Editar foto</v-card-title>
        <v-divider></v-divider>
        <v-card-text class="py-8">
          <v-row justify="center">
            <v-col cols="auto">
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
            </v-col>
            <v-col cols="12" v-if="foto" class="my-2">
              <v-row justify="center">
                <v-btn
                  v-if="foto.hasImage()"
                  @click="foto.remove()"
                  text
                  rounded
                  color="error"
                  >Eliminar</v-btn
                >
              </v-row>
            </v-col>
          </v-row>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="error"
            text
            @click="editPhotoDialog = false"
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
      await this.$store.dispatch('users/edit', {
        data: this.$store.state.auth.user.user
      })
      this.$router.push('users/editar/1')
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
    },

    async exit() {
      await this.$store.dispatch('auth/logout')
    }
  }
}
</script>

<style lang="scss">
.profile-avatar {
  cursor: pointer;
  border: 4px solid rgb(249, 121, 33);
}

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
