import Login from '../views/Login'
import Welcome from '../views/Welcome'
import NotFound from '../views/NotFound'
import AccessDenied from '../views/AccessDenied'
import Profile from '../views/Profile'
import Dev from '../views/Dev'

// Roles
import Roles from '../views/roles/Index'
import RolesCreate from '../views/roles/Create'
import RolesEdit from '../views/roles/Edit'

// Users
import Users from '../views/users/Index'
import UsersCreate from '../views/users/Create'
import UsersEdit from '../views/users/Edit'

const routes = [
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
  },
  {
    path: '/welcome',
    name: 'welcome',
    component: Welcome,
    meta: {
      permission: 'authenticated',
      redirect: 'login'
    }
  },
  {
    path: '/perfil',
    name: 'perfil',
    component: Profile,
    meta: {
      permission: 'authenticated',
      redirect: 'login'
    }
  },
  {
    path: '/dev',
    name: 'dev',
    component: Dev,
    meta: {
      rol: ['superAdmin'],
      redirect: 'welcome'
    }
  },

  // Roles
  {
    path: '/roles',
    name: 'roles',
    component: Roles,
    meta: {
      rol: ['superAdmin'],
      redirect: 'welcome'
    }
  },
  {
    path: '/roles/nuevo',
    name: 'roles_create',
    component: RolesCreate,
    meta: {
      rol: ['superAdmin'],
      redirect: 'welcome'
    }
  },
  {
    path: '/roles/editar',
    name: 'roles_edit',
    component: RolesEdit,
    meta: {
      rol: ['superAdmin'],
      redirect: 'welcome'
    }
  },

  // Users
  {
    path: '/users',
    name: 'users',
    component: Users,
    meta: {
      rol: ['superAdmin', 'administrador'],
      redirect: 'welcome'
    }
  },
  {
    path: '/users/nuevo',
    name: 'users_create',
    component: UsersCreate,
    meta: {
      rol: ['superAdmin', 'administrador'],
      redirect: 'welcome'
    }
  },
  {
    path: '/users/editar',
    name: 'users_edit',
    component: UsersEdit,
    meta: {
      rol: ['superAdmin', 'administrador'],
      redirect: 'welcome'
    }
  }
]

export default routes
