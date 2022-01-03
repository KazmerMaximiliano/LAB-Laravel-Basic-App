import Vue from 'vue'
import Router from 'vue-router'
import routes from './routes'

const originalPush = Router.prototype.push
Router.prototype.push = function push(location) {
  return originalPush.call(this, location).catch((err) => {
    if (err.name !== 'NavigationDuplicated') throw err
  })
}

Vue.use(Router)

export default new Router({
  mode: 'history',
  routes: [...routes],

  scrollBehavior(to, from, savedPosition) {
    return { x: 0, y: 0 }
  }
})
