export default
[
  {
    path: '/adminHome',
    name: 'adminHome',
    component: () => import('@/views/Administrador/Home.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/Dashboard',
    name: 'Dashboard',
    component: () => import('@/views/Administrador/dashboard.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/FormUsers/:id',
    name: 'FormUsers',
    component: () => import('@/views/Administrador/user/FormDistribuidorClient.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/FormUsersM/:id',
    name: 'FormUsersM',
    component: () => import('@/views/Administrador/user/movil/FormDistribuidorClient.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/FormUsersMEdit/:id',
    name: 'FormUsersMEdit',
    component: () => import('@/views/Administrador/user/movil/FormDistribuidorClientEdit.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/miCuenta',
    name: 'miCuenta',
    component: () => import('@/views/Administrador/user/FormMiCuenta.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/miCuentaTablet',
    name: 'miCuentaTablet',
    component: () => import('@/views/Administrador/user/FormMiCuentaTablet.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/ListTableSubAdmin',
    name: 'ListTableSubAdmin',
    component: () => import('@/views/Administrador/user/tablesorter_SubAdmin.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/ListTableDistrobuitor',
    name: 'ListTableDistrobuitor',
    component: () => import('@/views/Administrador/user/tablesorter_Distribuitor.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/ListTableSubDistribuitor',
    name: 'ListTableSubDistribuitor',
    component: () => import('@/views/Administrador/user/tablesorter_SubDistribuitor.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/ListTableClient',
    name: 'ListTableClient',
    component: () => import('@/views/Administrador/user/tablesorter_Client.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/ListaCliente',
    name: 'ListaCliente',
    component: () => import('@/views/Administrador/user/movil/tablesorter_Client.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/FormSubUsers/:id',
    name: 'FormSubUsers',
    component: () => import('@/views/Administrador/user/FormSubAdminDistribuidor.vue'),
    meta: { requiresAuth: true }
  },

  {
    path: '/DeleteClient',
    name: 'DeleteClient',
    component: () => import('@/views/Administrador/user/eliminarCliente.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/DeleteClientM',
    name: 'DeleteClientM',
    component: () => import('@/views/Administrador/user/movil/eliminarCliente.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/ListTableGps',
    name: 'ListTableGps',
    component: () => import('@/views/Administrador/gps/tablesorter_Gps.vue'),
    meta: { requiresAuth: true }
  },

  {
    path: '/registerGps',
    name: 'registerGps',
    component: () => import('@/views/Administrador/gps/FormGPS.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/registerSim',
    name: 'registerSim',
    component: () => import('@/views/Administrador/sims/FormSims.vue'),
    meta: { requiresAuth: true }
  },

  {
    path: '/ListTableSims',
    name: 'ListTableSims',
    component: () => import('@/views/Administrador/sims/tablesorter_Sims.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/store',
    name: 'store',
    component: () => import('@/views/Administrador/almacenPrincipal.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/dashStore/:id/:name',
    name: 'dashStore',
    component: () => import('@/views/Administrador/dashboardAlmacen.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/ListTableProduct',
    name: 'ListTableProduct',
    component: () => import('@/views/Administrador/productos/tablesorter_Product.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/registerProduct',
    name: 'registerProduct',
    component: () => import('@/views/Administrador/productos/formProduc.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/catPrincipal',
    name: 'catPrincipal',
    component: () => import('@/views/Administrador/catalogos/catPrincipal.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/ListTableKits',
    name: 'ListTableKits',
    component: () => import('@/views/Administrador/catalogos/kits/tablesorter_kits.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/registerKit',
    name: 'registerKit',
    component: () => import('@/views/Administrador/catalogos/kits/FormKit.vue'),
    meta: { requiresAuth: true }
  },
  // transferencias
  {
    path: '/transactions/store',
    name: 'storet',
    component: () => import('@/views/Administrador/transferencias/tablesorter_transaccionAlm.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/transactions/new/:tipo',
    name: 'newTransaction',
    component: () => import('@/views/Administrador/transferencias/newTransacctions.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/transactions/agree',
    name: 'transactionComplet',
    component: () => import('@/views/Administrador/transferencias/transaccionPend.vue'),
    meta: { requiresAuth: true }
  },

  {
    path: '/transactions/view',
    name: 'viewTransaction',
    component: () => import('@/views/Administrador/transferencias/formConsulta.vue'),
    meta: { requiresAuth: true }
  }

]
