import Vue from 'vue'

export class RouteProtect {
  constructor(router) {
    this.router = router
    this.Vauth = new Vue({
      data: {
        user: null
      }
    })
  }

  get() {
    if (!this.Vauth.user) {
      throw new Error('Intente acceder al usuario antes de configurarlo')
    }
    return this.Vauth.user
  }

  set(user) {
    this.Vauth.user = user
    if (this.to) {
      const { access, redirect } = this._accessToRoute(this.to)
      if (!access) {
        this.router.push({ name: redirect })
      }
    }
  }

  _accessToRoute(route) {
    if (this.Vauth.user && route.meta.rol) {
      const rolMatch = route.meta.rol.find((rol) => rol === this.Vauth.user.rol)
      if (!rolMatch) {
        return { access: false, redirect: route.meta.redirect }
      }
    }

    return { access: true }
  }

  resolve(to, from, next) {
    this.to = to
    const { access, redirect } = this._accessToRoute(to)
    if (access) {
      next()
    } else {
      next({ name: redirect })
    }
  }
}
