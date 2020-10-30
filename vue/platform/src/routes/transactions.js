export default
[
  {
    path: '/transactions',
    name: 'transactions',
    component: () => import('@/views/Administrador/Transactions/transactions.main.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/transactions/sales',
    name: 'sales',
    component: () => import('@/views/Administrador/Transactions/Sales/sales.main.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/transactions/sales/newSale',
    name: 'newSale',
    component: () => import('@/views/Administrador/Transactions/Sales/newSale.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/transactions/returns',
    name: 'returns',
    component: () => import('@/views/Administrador/Transactions/Returns/returns.main.vue'),
    meta: { requiresAuth: true }
  }

]
