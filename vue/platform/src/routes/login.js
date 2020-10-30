export default
[
  {
    path: '/',
    name: 'login',
    component: () => import('@/views/Login/Login.vue'),
    meta: { disabledOnLoggedUser: true }
    // meta: { requiresAuth: false } //si no se incluye por defualt es false
  },
  {
    path: '/platform/:user',
    name: 'login',
    component: () => import('@/views/Login/Login_personalizado.vue'),
    meta: { disabledOnLoggedUser: true }
    // meta: { requiresAuth: false } //si no se incluye por defualt es false
  },
  {
    path: '/login/recover',
    name: 'loginRecover',
    component: () => import('@/views/Login/Recovery_password_email.vue'),
    meta: { disabledOnLoggedUser: true }
  },
  {
    path: '/login/changePassword/:token',
    name: 'loginchangePassword',
    component: () => import('@/views/Login/Form_recovery_password.vue'),
    meta: { disabledOnLoggedUser: true }

  },
  {
    path: '/login/validate',
    name: 'errorValidate',
    component: () => import('@/views/ErrorValidate.vue'),
    meta: { disabledOnLoggedUser: true }
  }
]
