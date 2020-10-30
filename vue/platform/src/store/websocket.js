import Vue from 'vue'
import EventBus from '@/EventBus'
import store from '@/store'

import moment from 'moment-timezone'
import VueMoment from 'vue-moment'
import { createNamespacedHelpers } from 'vuex'

export default {
  namespaced: true,
  state: {
    connected: false,
    locate: false,
    message: '',
    reconnectError: false,
    logged: false,
    locateImei: [],
    countLocateImei: 0,
    reportTypes: []
  },
  getters: {
  },
  mutations: {
    SOCKET_ONOPEN (state, event) {
      console.debug('WS:', 'CONNECTED')
      Vue.prototype.$socket = event.currentTarget
      Vue.set(state, 'connected', true)
    },
    SOCKET_ONCLOSE (state, event) {
      console.debug('WS:', 'DISCONNECTED')
      Vue.set(state, 'connected', false)
    },
    SOCKET_ONERROR (state, event) {
      console.error('WS:', 'ERROR', state, event)
      Vue.set(state, 'connected', false)
    },
    // default handler called for all methods
    SOCKET_ONMESSAGE (state, request) {
      console.debug('WS:', 'RECEIVED', JSON.stringify(request))
      state.message = request
    },
    // mutations for reconnect methods
    SOCKET_RECONNECT (state, count) {
      console.debug('WS:', 'RECONNECT')
      console.info(state, count)
    },
    SOCKET_RECONNECT_ERROR (state) {
      console.error('WS:', 'RECONNECT_ERROR')
      Vue.set(state, 'reconnectError', true)
    },
    LOCATE_LIST_ADD (state, payload) {
      // state.fleets = fleets
      // agregar imei
      state.locateImei.push({ 'imei': payload })
      console.debug('LOCATE_LIST_ADD', payload, 'arr', state.locateImei)
    },
    async LOCATE_LIST_DEVREPORT (state, payload) {
      var topMenu = store.state.menu.topMenu
      var leftMenu = 340 // store.state.modal.datosDymanic.leftMenu - 13
      // state.fleets = fleets
      // recorrer ver si esta el imei, si si, eliminar, y poner localizado
      // store.state.devices.devices[payload].iconLocateDevicesTrue = true

      state.locateImei.forEach(disp => {
        if (disp.imei == payload) {
          console.debug('si esta imei en arreglo', disp.imei, payload)
          store.state.devices.devices[payload].iconLocateDevicesTrue = false
          var alias = store.state.devices.devices[payload].alias

          if (store.state.typeDevice.mobileOrTable) {
            notify('Excelente!', 'Se ha localizado al dispositivo <b>' + alias + '</b>', 'top', 'right', 'success', 10, 80)
          } else {
            notify('Excelente!', 'Se ha localizado al dispositivo <b>' + alias + '</b>', 'top', 'right', 'success', leftMenu, topMenu)
          }

          setTimeout(() => {
            if (store.state.devices.devices[payload].iconLocateDevicesTrue !== true) {
              store.state.devices.devices[payload].iconLocateDevicesTrue = true
            }
          }, 20000)

          // elimina imei de arreglo
          var search
          state.locateImei.filter(function (dato, i) {
            if (dato.imei == payload) {
              search = i
              console.debug(search, 'SEARCH', payload)
              return true
            }
          })

          state.locateImei.splice(search, 1)
        }
      })

      console.debug('DEVICE_ANTERIOR', store.state.devices.devicesLocateSELECT)

      if (store.state.devices.devicesLocateSELECT != null) {
        var payload1 = [{
          'deviceImei': store.state.devices.devicesLocateSELECT,
          'state': true
        }]

        console.debug('BUS_LOCATE_INFOEINDOWS', payload1)
        if (store.state.typeDevice.web) {
          EventBus.$emit('Ws_LOCATE_SELECT', payload1)
        } else {
          EventBus.$emit('Ws_LOCATE_SELECT_movil', payload1)
        }
        // EventBus.$emit('LOCATE_SELECT_MARKER', 1)
      }
      console.debug('LOCATE_LIST_DEVREPORT', payload, 'arr', state.locateImei)
    },
    LOCATE_LIST_DEVREPORT_DELETE (state, payload) {
      // recorrer ver si esta el imei, y eliminar fallo

      state.locateImei.forEach(disp => {
        if (disp.imei == payload) {
          console.debug('si esta imei en arreglo', disp.imei, payload)
          store.state.devices.devices[payload].iconLocateDevicesTrue = true

          // elimina imei de arreglo
          var search
          state.locateImei.filter(function (dato, i) {
            if (dato.imei == payload) {
              search = i
              console.debug(search, 'SEARCH', payload)
              return true
            }
          })

          state.locateImei.splice(search, 1)
        }
      })

      console.debug('LOCATE_LIST_DEVREPORT_DLETE', payload, 'arr', state.locateImei)
    },
    CATALOG_REPORT_TYPES (state, payload) {
      console.debug('CATALOG REPORT TYPES', payload)
      Vue.set(state, 'reportTypes', payload)
    }
  },
  actions: {
    // RECEIVE EVENTS
    SERVER_LOGIN (context, request) {
      console.debug('WS: <<<', 'SERVER_LOGIN')
      var token = getToken()

      var req = {
        requestType: 'request',
        action: 'login',
        token: token
      } // Get Token

      context.dispatch('SEND_MESSAGE', JSON.stringify(req))
    },
    DEV_CONN_STAT (context, request) {
      console.debug('WS:', 'DEV_CONN_STAT')
      try {
        var device = request.data
        context.dispatch('devices/DEV_CONN_STAT', { imei: device.imei, connected: device.connected }, { root: true })
      } catch (err) {
        console.error(err)
      }
    },
    ALL_DEV_CONN_STAT (context, request) {
      console.debug('WS:', 'ALL_DEV_CONN_STAT')
      request.data.forEach(device => {
        try {
          context.dispatch('devices/DEV_CONN_STAT', { imei: device.imei, connected: device.connected }, { root: true })
        } catch (err) { }
      })
    },
    DEV_REPORT (context, request) {
      console.debug('WS:', 'DEV_REPORT', request.data)
      store.state.devices.devices[request.data.imei].iconLocateDevices = true
      // store.state.devices.devices[request.data.imei].locationStatus = 1
      // request = request.data
      if (request.data.report.typeID >= 2000) {
        HandleNotification(request.data)
      }

      context.commit('LOCATE_LIST_DEVREPORT', request.data.imei)
      context.dispatch('devices/DEV_REPORT', request.data, { root: true })
    },
    DEV_EVENT (context, request) {
      console.debug('WS:', 'DEV_EVENT ', request)

      // poner iconos
      try {
        store.state.devices.devices[request.data.imei].iconGestionDevices = true
        store.commit('CLEAR_MODAL_DINAMIC')
        var markerName
        var params
      } catch (err) {}

      if (request.data.report.typeID >= 2000) {
        HandleNotification(request.data)
      }
    },
    LOCATE (context, payload) {
      console.debug('WS:', 'LOCATE', payload)

      if (isResponse(payload)) {
        var topMenu = store.state.menu.topMenu
        var leftMenu = 340 // store.state.modal.datosDymanic.leftMenu - 13

        if (payload.statusCode == '200') {
          context.commit('LOCATE_LIST_ADD', payload.data.imei)

          // ocultar iconos y poner leyenda
          store.state.devices.devices[payload.data.imei].iconLocateDevices = false

          store.state.loader = false
          setTimeout(() => {
            if (store.state.devices.devices[payload.data.imei].iconLocateDevices !== true) {
              context.commit('LOCATE_LIST_DEVREPORT_DELETE', payload.data.imei)
              store.state.devices.devices[payload.data.imei].iconLocateDevices = true

              store.state.devices.devices[payload.data.imei].report.states.gsm.strength = 0

              if (store.state.typeDevice.mobileOrTable) {
                notify('ERROR!', 'No se ha podido localizar el dispositivo', 'top', 'right', 'danger', 10, 80)
              } else {
                notify('ERROR!', 'No se ha podido localizar el dispositivo', 'top', 'right', 'danger', leftMenu, topMenu)
              }
            }
          }, 60000)
        } else {
          console.log('Error')
          store.state.loader = false
          store.state.devices.devices[payload.data.imei].report.states.gsm.strength = 0

          if (store.state.typeDevice.mobileOrTable) {
            notify('ERROR!', 'No se ha podido localizar el dispositivo', 'top', 'right', 'danger', 10, 80)
          } else {
            notify('ERROR!', 'No se ha podido localizar el dispositivo', 'top', 'right', 'danger', leftMenu, topMenu)
          }
        }
      } else {
        var token = getToken()
        var request = {
          requestType: 'request',
          action: 'LOCATE',
          token: token,
          data: payload
        }
        console.log('REQUEST', request)
        context.dispatch('SEND_MESSAGE', JSON.stringify(request))
      }
    },
    SET_ENGINE (context, payload) {
      if (isResponse(payload)) {
        store.state.loader = false
        console.log('RESPONSE_SERVER', payload)

        var topMenu = store.state.menu.topMenu
        var leftMenu = 340 // store.state.modal.datosDymanic.leftMenu - 13

        if (payload.statusCode == '200') {
          // ocultar iconos y poner realizando paro
          store.state.devices.devices[payload.data.imei].iconGestionDevices = false

          setTimeout(() => {
            if (store.state.devices.devices[payload.data.imei].paroMotor !== false) {
              store.state.devices.devices[payload.data.imei].iconGestionDevices = true

              if (store.state.typeDevice.mobileOrTable) {
                if (!store.state.typeDevice.isHorizontal) {
                  // notify('ERROR!', 'No se ha podido realizar el paro de motor', 'top', 'right', 'danger', 10, 80)
                } else {
                  // notify('ERROR!', 'No se ha podido realizar el paro de motor', 'top', 'right', 'danger', leftMenu - 130, topMenu)
                }
              } else {
                // notify('ERROR!', 'No se ha podido realizar el paro de motor', 'top', 'right', 'danger', leftMenu - 130, topMenu)
              }

              store.commit('CLEAR_MODAL_DINAMIC')
            }
          }, 60000)
        }
        if (payload.statusCode == '400') { // contra incorrecta
          console.debug('ErrorContraseña')
          if (store.state.typeDevice.mobileOrTable) {
            if (!store.state.typeDevice.isHorizontal) {
              notify('ERROR!', 'El dispositivo no se encuentra conectado', 'top', 'right', 'danger', 10, 80)
            } else {
              notify('ERROR!', 'El dispositivo no se encuentra conectado', 'top', 'right', 'danger', leftMenu - 130, topMenu)
            }
          } else {
            notify('ERROR!', 'El dispositivo no se encuentra conectado', 'top', 'right', 'danger', leftMenu - 130, topMenu)
          }
        }
        if (payload.statusCode == '401') { // contra incorrecta
          console.debug('ErrorContraseña')
          if (store.state.typeDevice.mobileOrTable) {
            if (!store.state.typeDevice.isHorizontal) {
              notify('ERROR!', 'Contraseña incorrecta', 'top', 'right', 'danger', 10, 80)
            } else {
              notify('ERROR!', 'Contraseña incorrecta', 'top', 'right', 'danger', leftMenu - 130, topMenu)
            }
          } else {
            notify('ERROR!', 'Contraseña incorrecta', 'top', 'right', 'danger', leftMenu - 130, topMenu)
          }
        }
      } else {
        var token = getToken()

        var request = {
          requestType: 'request',
          action: 'SET_ENGINE',
          token: token,
          data: payload
        }
        console.log('REQUEST', request)
        context.dispatch('SEND_MESSAGE', JSON.stringify(request))
      }
    },
    SET_REPORT_INTERVAL (context, payload) {
      if (isResponse(payload)) {
        store.state.loader = false
        console.log('RESPONSE_SERVER', payload)

        var topMenu = store.state.menu.topMenu
        var leftMenu = 340 // store.state.modal.datosDymanic.leftMenu - 13

        if (payload.statusCode == '200') {
          // actulizar los intervalos en el store
          var addTime = store.state.devices.devices[payload.data.imei].addTimeInterval
          var data = payload.data
          store.state.devices.devices[payload.data.imei].reportInterval = data.onDrivingInterval + addTime
          store.state.devices.devices[payload.data.imei].reportIntervalOnParking = data.onParkingInterval + addTime
        }
        if (payload.statusCode == '400') { // contra incorrecta
          console.log('ErrorContraseña')
          notify('ERROR!', 'El dispositivo no esta conectado', 'top', 'right', 'danger')
        }
        if (payload.statusCode == '401') { // contra incorrecta
          console.log('ErrorContraseña')
          notify('ERROR!', 'No tiene los privilegios para realizar la acción', 'top', 'right', 'danger')
        }
      } else {
        var token = getToken()

        var request = {
          requestType: 'request',
          action: 'SET_REPORT_INTERVAL',
          requestID: 0,
          token: token,
          data: payload
        }
        console.log('REQUEST', request)
        context.dispatch('SEND_MESSAGE', JSON.stringify(request))
      }
    },
    SW_OUTPUT (context, request) {
      console.debug('WS:', 'SW_OUTPUT')
    },
    ERROR (context, request) {
      console.debug('WS:', 'REQUEST_ERROR', request)
    },

    // SEND ACTION
    LOGIN (context, request) {
      if (request.statusCode == '200') {
        console.debug('WS:', 'LOGGED')
        Vue.set(context.state, 'logged', true)
      } else {
        // SI ERROR DE LOGIN ?
      }
    },
    SEND_MESSAGE (context, message) {
      console.debug('WS: >>>', 'SEND', message)
      Vue.prototype.$socket.send(message)
    }
  }
}

function getToken () {
  var token = ''
  var secureSession = cryptio
  var secureSessionOptions = {
    storage: 'session',
    passphrase: process.env.VUE_APP_STORAGE_KEY
  }

  if (sessionStorage.token !== undefined) {
    secureSession.get(secureSessionOptions, 'token', function (err, results) {
      if (err) throw err
      token = results
    })
  }

  return token
}

function isRequest (payload) {
  if (payload.requestType == 'REQUEST') {
    return true
  }
  return false
}

function isResponse (payload) {
  if (payload.requestType == 'RESPONSE') {
    return true
  }
  return false
}

function isEvent (payload) {
  // pasar en mayuscula
  // requestType=upercase(payload.requestType)
  if (payload.requestType == 'EVENT') {
    return true
  }
  return false
}

function HandleNotification (request) {
  try {
    console.debug('HandleNotification', request)

    var alias = store.state.devices.devices[request.imei].alias
    var title = GetReportName(request.report.typeID)
    var notification = {
      title: `<b>${title}</b>`,
      alias: alias,
      date: moment(request.report.timestamp * 1000).format('ddd, LL h:mm a'),
      message: '',
      class: ''
    }

    var topMenu = store.state.menu.topMenu
    var leftMenu = 340 // store.state.modal.datosDymanic.leftMenu - 13

    if (request.report.typeID >= 2000 && request.report.typeID <= 2999) {
      notification = HandleNotificationReport(notification, request)
    } else if (request.report.typeID >= 3000 && request.report.typeID <= 3999) {
      notification = HandleAlertReport(notification, request)
    } else if (request.report.typeID >= 4000 && request.report.typeID <= 4999) {
      notification = HandleEmergencyReport(notification, request)
    }

    notification.body = `<hr style="background: #8888; width: 100%; margin: 7px; margin-left: 0px;">
    <div class="row" style="width: 300px; font-size: 12px;">
        ${notification.message}
    </div>`

    leftMenu = leftMenu - 130
    if (store.state.typeDevice.mobileOrTable) {
      // Pantalla Mobile o Tablet
      if (!store.state.typeDevice.isHorizontal) {
        // portrait
        topMenu = 10
        leftMenu = 80
      }
    }

    notify(notification.title.toUpperCase(), notification.body, 'top', 'right', notification.class, leftMenu - 130, topMenu, 15000)
  } catch (err) {
    console.error(err)
  }
}

function HandleNotificationReport (notification, request) {
  var markerName = ''
  var params = ''

  notification.class = 'dark'
  notification.message = `
      <div class="col-12 float-left">
        Dispositivo: <b>${notification.alias}</b><br>
        Fecha: <b>${notification.date}</b><br>
        Ubicacion: <b>${request.position.address}</b>
      </div>`

  switch (request.report.typeID) {
    case 2014: // Engine disabled
      markerName = store.state.devices.devices[request.imei].marker.name
      store.state.devices.devices[request.imei].paroMotor = true
      store.state.devices.devices[request.imei].report.states.engineEnabled = true
      params = { 'imei': request.imei, 'markerName': markerName }
      EventBus.$emit('SET_MARKER_ICON', params)
      store.state.devices.devices[request.imei].iconGestionDevices = true
      break

    case 2015: // Engine Enabled
      markerName = 'MARKER_CANCEL_RED'
      store.state.devices.devices[request.imei].paroMotor = true
      store.state.devices.devices[request.imei].report.states.engineEnabled = false
      params = { 'imei': request.imei, 'markerName': markerName }
      EventBus.$emit('SET_MARKER_ICON', params)
      store.state.devices.devices[request.imei].iconGestionDevices = true
  }

  return notification
}

function HandleAlertReport (notification, request) {
  notification.class = 'primary'
  notification.message = `
      <div class="col-12 float-left">
        Dispositivo: <b>${notification.alias}</b><br>
        Fecha: <b>${notification.date}</b><br>
        Ubicacion: <b>${request.position.address}</b>
      </div>`

  switch (request.report.typeID) {
    case 3017: // GEOFENCE IN
    case 3018: // GEOFENCE OUT
      notification.message = `
      <div class="col-12 float-left">
        Geocerca: <b>${request.geofence.name}</b><br>
        Dispositivo: <b>${notification.alias}</b><br>
        Fecha: <b>${notification.date}</b><br>
        Ubicacion: <b>${request.position.address}</b>
      </div>`
      break
  }

  return notification
}

function HandleEmergencyReport (notification, request) {
  notification.class = 'danger'
  notification.message = `
      <div class="col-12 float-left">
        Dispositivo: <b>${notification.alias}</b><br>
        Fecha: <b>${notification.date}</b><br>
        Ubicacion: <b>${request.position.address}</b>
      </div>`

  return notification
}

function GetReportName (id) {
  try {
    var reportType = store.state.ws.reportTypes.find(e => e.id == `${id}`)

    console.debug('GetReportName', id, reportType)
    return reportType.name
  } catch (err) {
    console.error('Error getReportName', err)
    if (id <= 2999) { return 'NOTIFICACION' } else if (id <= 3999) { return 'ALERTA' } else if (id <= 4999) { return 'EMERGENCIA' } else { return 'NOTIFICACION' }
  }
}
