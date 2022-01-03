import RouterFix from 'vue-router'

// Eliminar error  "Redirected when going from "/routeA" to "/routeB" via a navigation guard."
const originalPush = RouterFix.prototype.push
RouterFix.prototype.push = function push(location, onResolve, onReject) {
  if (onResolve || onReject)
    return originalPush.call(this, location, onResolve, onReject)
  return originalPush.call(this, location).catch((err) => err)
}
