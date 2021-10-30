import Vue from 'vue';
import RouterFix from 'vue-router'

// Eliminar error  "Redirected when going from "/routeA" to "/routeB" via a navigation guard."
const originalPush = RouterFix.prototype.push
RouterFix.prototype.push = function push(location, onResolve, onReject) {
  if (onResolve || onReject) return originalPush.call(this, location, onResolve, onReject)
  return originalPush.call(this, location).catch(err => err)
}

// ELIMINAR ADVERTENCIA AL USAR V-CALENDAR
const ignoreWarnMessage =
    "The .native modifier for v-on is only valid on components but it was used on <div>.";
Vue.config.warnHandler = function(msg, vm, trace) {
    if (msg === ignoreWarnMessage) {
        msg = null;
        vm = null;
        trace = null;
    }
};