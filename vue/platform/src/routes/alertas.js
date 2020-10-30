export default
[

  {
    path: '/Alertas',
    name: 'Alertas',
    component: () => import('@/views/Alertas/reporteAlertas.vue'),
    meta: { requiresAuth: true }
  }

]
