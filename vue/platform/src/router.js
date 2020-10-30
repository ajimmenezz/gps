import Vue from 'vue'
import Router from 'vue-router'
import loginRoutes from '@/routes/login'
import testRoutes from '@/routes/test'
import configRoutes from '@/routes/configuracion'
import reportes from '@/routes/reportes'
import alertas from '@/routes/alertas'
import administrador from '@/routes/administrador'
import transactions from '@/routes/transactions'
import store from '@/store'

Vue.use(Router)

var routes = []
routes = routes.concat(
  {
    path: '/Location',
    name: 'Location',
    component: () => import('@/views/MapModule/MapModule.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/ListDevices',
    name: 'ListDevices',
    component: () => import('@/views/MapModule/MapFloatMenu/panelDevices/listDevices'),
    meta: { requiresAuth: true }
  },
  {
    path: '/404',
    name: '404',
    component: () => import('@/views/404.vue'),
    meta: { requiresAuth: false }
  },
  {
    path: '/home',
    name: 'home',
    component: () => import('@/views/404.vue'),
    meta: { requiresAuth: true }
  },
  configRoutes,
  reportes,
  alertas,
  loginRoutes,
  testRoutes,
  administrador,
  transactions,
  // path '*' Always at the end of the concat
  {
    path: '*',
    redirect: { name: '404' }
  }
)

const router = new Router({
  mode: 'hash',
  routes: routes
})

// ---------- ROUTE GUARD ----------------------
function isLogged () {
  var secureSession = cryptio
  var secureSessionOptions = {
    storage: 'session',
    passphrase: process.env.VUE_APP_STORAGE_KEY
  }

  if (sessionStorage.logged !== undefined) {
    var result
    secureSession.get(secureSessionOptions, 'logged', function (err, value) {
      if (err) {
        console.log(err)
        result = false
      }
      result = value
    })
    return result
  }
  return false
}

function getRutaHome () {
  var tipoUser = sessionStorage.UT
  var tipoClient = sessionStorage.TC

  if (tipoUser == 2) { // asociado
    if (tipoClient == 1) { // cliente/asociado
      return 'Location'
    } else { // sub admin, dist
      return 'adminHome'
    }
  } else { // cliente, distribuidor, admin
    if (tipoUser == 1) { // cliente/asociado
      return 'Location'
    } else {
      return 'adminHome'
    }
  }
}

router.beforeEach((to, from, next) => {
  console.debug(`Router: ${from.name} -> ${to.name}`)
  // console.debug('Matchs:', to.matched)
  var isUserLogged = isLogged()

  if (isUserLogged && to.matched.some(route => route.meta.disabledOnLoggedUser)) {
    /* el usuario esta logeado y la ruta a la que se quiere acceder
     no funciona cuando el usuario esta logeado */
    // if (from.name == 'login' || from.name == 'null') {
    console.warn(`/${to.name} not works when user is logged`)
    //   next({ name: '404' })
    // } else {
    //   next()
    // }
    next(false)
  } else {
    /**
     * A) usuario logeado pero la ruta si funciona cuando usuario loggeado
     * B) usuario no logeado
     */
    if (to.matched.some(route => route.meta.requiresAuth)) {
      // Protected Route
      if (isUserLogged) {
        console.debug('isUserLogged', isUserLogged)
        if (to.name === 'home') {
          console.debug('home', to.name)
          var ruta = getRutaHome()

          next({ name: ruta })
        } else {
          console.debug('!NEXT', to.name)
          next()
        }
      } else {
        console.debug('User has not logged yet')
        next({ name: 'login' })
      }
    } else {
      console.debug('ELSE_MATCHED', to.name)
      // Public Route
      next()
    }
  }
})

export default router
