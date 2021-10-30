import { RouteProtect } from "./RouteProtect";

function plugin(Vue, options) {
    if (!options.router) {
        throw new Error(
            "Debe proporcionar una instancia de 'Vue Router' en las opciones."
        );
    }
    const routeProtect = new RouteProtect(options.router);
    Vue.prototype.$user = routeProtect;
    options.router.beforeEach((to, from, next) =>
        routeProtect.resolve(to, from, next)
    );
}

export default plugin;

/**
 *
 * BASADO EN EL REPOSITORIO anthonygore/vue-router-user-roles
 * URL: https://github.com/anthonygore/vue-router-user-roles
 * 
 */