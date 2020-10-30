export default
[
  {
    path: '/devices',
    name: 'confPrincipal',
    component: () => import('@/views/Configurations/devices/configPrincipal.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/passwEvent',
    name: 'config',
    component: () => import('@/views/Configurations/devices/panelEventPassw.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/listDevice',
    name: 'tableDevices',
    component: () => import('@/views/Configurations/devices/tablesorter_devices.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/devicesEdit',
    name: 'devicesEdit',
    component: () => import('@/views/Configurations/devices/editDevices.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/users',
    name: 'userPrincipal',
    component: () => import('@/views/Configurations/users/userPrincipal.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/listUser',
    name: 'tableUser',
    component: () => import('@/views/Configurations/users/tablesorter_user.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/listaUsers',
    name: 'listaUsers',
    component: () => import('@/views/Configurations/users/movil/tablesorter_user.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/userRegister',
    name: 'userRegister',
    component: () => import('@/views/Configurations/users/userRegister.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/userRegisterM',
    name: 'userRegisterM',
    component: () => import('@/views/Configurations/users/movil/userRegister.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/userUpdate',
    name: 'userUpdate',
    component: () => import('@/views/Configurations/users/movil/userUpdate.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/flotillas',
    name: 'flotillaMenu',
    component: () => import('@/views/Configurations/flotilla/tablesorter_flotilla.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/registerFlotilla',
    name: 'registerFlotilla',
    component: () => import('@/views/Configurations/flotilla/registerFlotilla.vue'),
    meta: { requiresAuth: true }
  }

]
