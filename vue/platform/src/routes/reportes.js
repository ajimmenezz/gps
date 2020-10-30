export default
[
  {
    path: '/reports',
    name: 'reportPrincipal',
    component: () => import('@/views/Reportes/reportPrincipal.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/reportLocate',
    name: 'reportLocate',
    component: () => import('@/views/Reportes/Localizacion/reporteLocalizacion.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/reportGeofence',
    name: 'reportGeofence',
    component: () => import('@/views/Reportes/reporteGeofence.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/reportResults',
    name: 'reportResults',
    component: () => import('@/views/Reportes/reporteResult.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/dataTable',
    name: 'dataTable',
    component: () => import('@/views/Reportes/distance/dataTableDist.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/dataGraphReport',
    name: 'dataGraphReport',
    component: () => import('@/views/Reportes/distance/dataGraphDist.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/cancelReports',
    name: 'cancelReports',
    component: () => import('@/views/Reportes/cancelReports.vue'),
    meta: { requiresAuth: true }
  }

]
