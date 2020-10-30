import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios'
import VueAxios from 'vue-axios'

import configInput from '@/components/basico/Input.vue'
import configDataLabel from '@/components/basico/DataLabel.vue'
import configTextTypography from '@/components/basico/TextTypography.vue'
import VueNativeSocket from 'vue-native-websocket'
import { isMobile, isTablet, isMobileOnly, isBrowser } from 'mobile-device-detect'

import moment from 'moment-timezone'
import VueMoment from 'vue-moment'

import '@/assets/css/style.base.css'
import '@/assets/css/style.base.mobile.css'
import '@/assets/css/colors.css'

Vue.config.productionTip = false

const momentConfig = require('moment')
momentConfig.tz.setDefault('UTC')
require('moment/locale/es')

Vue.use(VueMoment, {
  moment,
  momentConfig
})

Vue.use(VueAxios, axios)

Vue.component('configInput', configInput)
Vue.component('configDataLabel', configDataLabel)
Vue.component('configTextTypography', configTextTypography)

Vue.use(VueNativeSocket, process.env.VUE_APP_WEBSOCKET_URL, {
  store: store,
  format: 'json',
  reconnection: true,
  reconnectionAttempts: 0,
  reconnectionDelay: 30000,
  connectManually: true,
  // Redirigir las peticiones hacia el store deseado
  passToStoreHandler: function (eventName, event) {
    let method = 'commit'
    let target = eventName.toUpperCase()
    let msg = event
    let storeName = 'ws'
    // Esto determina que funcion ejecutar mutation/action
    if (this.format === 'json' && event.data) {
      msg = JSON.parse(event.data)
      // Buscar en el json por la propiedad .mutation o .action para saber a donde dirigirse
      // tomara el valor de dicha propiedad y ese sera el target
      if (msg.mutation) {
        target = [msg.namespace || '', msg.mutation].filter((e) => !!e).join('/')
      } else if (msg.action) {
        method = 'dispatch'
        target = [msg.namespace || '', msg.action].filter((e) => !!e).join('/')
      }
    }
    // ejecutamos el metodo del store 'storeName'
    this.store[method](storeName + '/' + target, msg)
  }
})

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
