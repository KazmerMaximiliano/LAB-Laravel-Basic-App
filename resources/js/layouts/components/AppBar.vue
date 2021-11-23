<template>
  <div v-if="$store.state.auth.user">
    <!-- APPBAR -->
    <v-app-bar color="transparent" class="appbar" flat>
      <v-app-bar-nav-icon
        class="hidden-sm-and-up"
        @click="drawer = true"
      ></v-app-bar-nav-icon>
      <v-spacer></v-spacer>
      <div
        style="cursor: pointer"
        @click="$router.push('/perfil')"
        class="mx-4"
      >
        {{ $store.state.auth.user.user.name }}
      </div>
      <v-avatar
        color="secondary"
        style="cursor: pointer"
        size="45"
        v-if="$store.state.auth.user.user != null"
        @click="$router.push('/perfil')"
      >
        <img
          v-if="$store.state.auth.user.user.foto != null"
          :src="$store.state.auth.user.user.foto"
          width="100%"
          height="auto"
        />
        <span
          v-else-if="$store.state.auth.user.user.name"
          class="text-uppercase white--text"
          >{{ $store.state.auth.user.user.name[0] }}</span
        >
      </v-avatar>
    </v-app-bar>

    <!-- SIDEBAR -->
    <div>
      <v-navigation-drawer
        v-model="drawer"
        :permanent="permanent"
        :temporary="temporary"
        stateless
        app
        hide-overlay
        floating
        class="sidebar"
      >
        <template v-slot:prepend>
          <div class="sidbar-header">
            <div class="sidebar-header-content">
              <v-list-item two-line>
                <v-list-item-avatar>
                  <img width="100" height="100" src="/img/isotipo.png" />
                </v-list-item-avatar>
                <v-list-item-content>
                  <v-list-item-title>{{ $appName }}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </div>
          </div>
        </template>
        <div class="sidebar-body">
          <v-list dense class="sidebar-route-list">
            <!-- SMARTZONE ROUTES -->
            <div v-for="(route, i) in routes" :key="i">
              <v-list-item
                :to="route.url"
                v-if="
                  route.roles.find((element) => {
                    return element == $store.state.auth.user.rol
                  })
                "
                @click="
                  $vuetify.breakpoint.xsOnly
                    ? (drawer = false)
                    : (drawer = true)
                "
                class="no-hover-item"
                exact-active-class="route-active"
                :ripple="false"
              >
                <div class="route-items">
                  <v-list-item-icon>
                    <v-icon>{{ route.icon }}</v-icon>
                  </v-list-item-icon>
                  <v-list-item-content>
                    <v-list-item-title>
                      {{ route.name }}
                    </v-list-item-title>
                  </v-list-item-content>
                </div>
              </v-list-item>
            </div>
          </v-list>
        </div>
      </v-navigation-drawer>
    </div>
  </div>
</template>

<script>
import menu from '../menu.json'

export default {
  data: () => ({
    drawer: false,
    permanent: false,
    temporary: true,
    routes: menu
  }),

  computed: {
    isMobile() {
      return this.$vuetify.breakpoint.xsOnly
    },

    currentRoute() {
      return this.$route.name
    }
  },

  watch: {
    isMobile() {
      this.drawerControl()
    }
  },

  mounted() {
    this.drawerControl()
  },

  methods: {
    drawerControl() {
      if (this.isMobile) {
        this.drawer = false
        this.permanet = false
        this.temporary = true
      } else {
        this.drawer = true
        this.permanet = true
        this.temporary = false
      }
    }
  }
}
</script>
