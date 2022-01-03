import Login from '../views/Login'
import Welcome from '../views/Welcome'
import NotFound from '../views/NotFound'
import AccessDenied from '../views/AccessDenied'

const routes = [
  {
    path: '*',
    name: 'NotFound',
    component: NotFound
  },
  {
    path: '/welcome',
    name: 'welcome',
    component: Welcome,
    meta: {
      rol: ['superadmin', 'admin', 'broker', 'customer'],
      redirect: 'login'
    }
  },
  {
    path: '/accessd_denied',
    name: 'accessd_denied',
    component: AccessDenied
  },
  {
    path: '/',
    name: 'login',
    component: Login,
    meta: {
      rol: ['not_authorized'],
      redirect: 'welcome'
    }
  }
]

export default routes
