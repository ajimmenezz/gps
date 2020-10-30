import Vue from 'vue'
import Axios from 'axios'
import EventBus from '@/EventBus'

Axios.defaults.headers.get['Content-Type'] = 'application/json'

function newDeviceFormat () {
  var DeviceFormat = {
    clientID: '',
    id: '',
    imei: 0,
    alias: '',
    paroMotor: false,
    fleetID: null,
    marker: {
      type: '',
      name: '',
      visible: false,
      selected: false
    },
    report: {
      timestamp: 0,
      type: '',
      isHistoric: false,
      position: {
        lat: 0,
        lng: 0,
        address: '',
        valid: false
      },
      states: {
        connected: false,
        engineEnabled: true,
        ignition: false,
        battery: false,
        batteryLevel: false,
        batteryVolt: 0,
        powerSupply: false,
        powerSupplyVolt: 0,
        speed: 0,
        gsm: {
          strength: null
        }
      }
    }
  }
  return JSON.parse(JSON.stringify(DeviceFormat))
}

export default {
  namespaced: true,
  state: {
    deviceSelected: null,
    devicesLocateSELECTanterior: null,
    devicesLocateSELECT: null,
    devices: {},
    fleets: [],
    setIntervalFecha: null,
    buscador: null

  },
  mutations: {
    ADD_DEVICE (state, device) {
      Vue.set(state.devices, device.imei, device)
    },
    ADD_FLEETS (state, fleets) {
      state.fleets = fleets
      // Vue.set(state.fleets, fleets.id, fleets)
    },
    CLEAR_DEVICES (state) {
      Vue.set(state, 'devices', {})
      Vue.set(state, 'fleets', [])
      state.fleets = []
    },
    CLEAR_DEVICES_SELECTED (state) {
      Object.keys(state.devices).forEach(key => {
        state.devices[key].marker.selected = false
      })
    },
    DEV_CONN_STAT (state, payload) {
      Vue.set(state.devices[payload.imei].report.states, 'connected', payload.connected)
    },
    DEV_REPORT (state, payload) {
      Vue.set(state.devices[payload.imei], 'report', payload.report)
    },
    CLEAR_FLEET (state) {
      state.fleets.forEach(fleet => {
        fleet.selected = false
        fleet.iconCollapse = true
      })
    },
    SELECT_DEVICE (state, imei) {
      console.debug('Store.DeviceSelected', imei)
      Vue.set(state, 'deviceSelected', imei)
    }

  },
  actions: {
    SELECT_DEVICE (context, imei) {
      context.commit('SELECT_DEVICE', imei)
      EventBus.$emit('DEVICE_SELECTED', imei)
    },
    async CLEAR_STORE (context) {
      context.commit('CLEAR_DEVICES')
    },
    async LOAD_DEVICES (context, devices) {
      devices.forEach(device => {
        var lat = parseFloat(device.lat)
        var lng = parseFloat(device.lng)

        if (isNaN(lat)) {
          console.debug(`devices load_device/ ${device.imei} lat is NaN`)
          lat = 0
        }
        if (isNaN(lng)) {
          console.debug(`devices load_device/ ${device.imei} lng is NaN`)
          lng = 0
        }

        var deviceFormatted = newDeviceFormat()
        deviceFormatted.clientID = device.clientID
        deviceFormatted.id = device.id
        deviceFormatted.imei = device.imei
        deviceFormatted.alias = device.alias
        deviceFormatted.paroMotor = false

        try {
          deviceFormatted.fleetID = device.fleetID
        } catch {}

        /*  random para establecer location  */

        deviceFormatted.locationStatus = 1// Math.floor(Math.random() * 3) + 1

        // tiempo de tolerancia de respuesta
        deviceFormatted.addTimeInterval = 15

        // console.debug('DEVICES_INTERVAL', device.deviceDrivingInterval, device.deviceParkingInterval)
        if (device.deviceDrivingInterval !== null && device.deviceDrivingInterval !== 'null' && device.deviceDrivingInterval !== 0) {
          // console.debug('NOT_null_INTERVAL')
          deviceFormatted.reportInterval = parseInt(device.deviceDrivingInterval) + deviceFormatted.addTimeInterval // device.deviceDrivingInterval   1min + 15seg
        } else {
          // console.debug('null_INTERVAL')
          deviceFormatted.reportInterval = 60 + deviceFormatted.addTimeInterval // device.deviceDrivingInterval   1min + 15seg
        }

        if (device.deviceParkingInterval !== null && device.deviceParkingInterval !== 'null' && device.deviceParkingInterval !== 0) {
          // console.debug('NOTnull_INTERVALPARK')
          deviceFormatted.reportIntervalOnParking = parseInt(device.deviceParkingInterval) + deviceFormatted.addTimeInterval // device.deviceParkingInterval   5min + 15seg
        } else {
          // console.debug('null_INTERVALPARK')
          deviceFormatted.reportIntervalOnParking = 300 + deviceFormatted.addTimeInterval // device.reportIntervalOnParking   3min + 15seg
        }
        // deviceFormatted.reportInterval = parseInt(device.deviceDrivingInterval) + 15 // device.deviceDrivingInterval   1min + 15seg
        // deviceFormatted.reportIntervalOnParking = parseInt(device.deviceParkingInterval) + 15 // device.deviceParkingInterval   5min + 15seg
        /** ** */
        deviceFormatted.iconGestionDevices = true
        deviceFormatted.iconLocateDevices = true
        deviceFormatted.iconLocateDevicesTrue = true
        deviceFormatted.marker.type = device.markerType
        deviceFormatted.marker.name = device.markerName
        deviceFormatted.marker.visible = true
        deviceFormatted.marker.selected = false

        deviceFormatted.report.timestamp = parseInt(device.timestampReport)
        deviceFormatted.report.position.lat = lat
        deviceFormatted.report.position.lng = lng
        deviceFormatted.report.position.address = device.address
        deviceFormatted.creationTimestamp = device.creationTimestamp

        deviceFormatted.report.states.gsm.strength = device.gsmStrength
        context.commit('ADD_DEVICE', deviceFormatted)
      }) // End of Foreach
    },
    async LOAD_FLEETS (context, fleets) {
      fleets.forEach(fleet => {
        fleet.selected = false
        fleet.iconCollapse = true
      })
      context.commit('ADD_FLEETS', fleets)
    },
    async CLEAR_DEVICES_SELECTED (context) {
      context.commit('CLEAR_DEVICES_SELECTED')
    },
    async CLEAR_FLEET (context) {
      context.commit('CLEAR_FLEET')
    },
    DEV_CONN_STAT (context, payload) {
      context.commit('DEV_CONN_STAT', payload)
      EventBus.$emit('DEVICE_CONNECTION_STATUS_CHANGED', payload)
    },
    DEV_REPORT (context, payload) {
      // console.debug('DEVICES_REPORT123', payload)
      var device = context.state.devices[payload.imei]

      device.report.timestamp = payload.report.timestamp
      device.report.type = payload.report.reportType
      device.report.isHistoric = payload.report.historic
      device.report.position.lat = payload.position.lat
      device.report.position.lng = payload.position.lng
      device.report.position.address = payload.position.address
      device.report.position.valid = payload.position.valid
      device.report.states.ignition = payload.sensors.ignition
      device.report.states.battery = payload.deviceInfo.battery
      device.report.states.batteryLevel = payload.deviceInfo.batteryLevel
      device.report.states.batteryVolt = payload.deviceInfo.batteryVolt
      device.report.states.powerSupply = payload.deviceInfo.powerSupply
      device.report.states.powerSupplyVolt = payload.deviceInfo.powerSupplyVolt
      device.report.states.speed = payload.vehicleInfo.speed
      device.report.states.gsm.strength = payload.gsm.signalStrength

      var params = {
        id: device.id,
        imei: device.imei,
        lat: device.report.position.lat,
        lng: device.report.position.lng
      }

      context.commit('DEV_REPORT', device)

      console.debug('DEVICE_POSITION_CHANGED: ', params)
      EventBus.$emit('DEVICE_POSITION_CHANGED', params)
    }
  },
  getters: {
    DEVICE_CONNECTED_CLASS: (state) => (imei) => {
      try {
        if (state.devices[imei].connected) {
          return 'success'
        } else {
          return 'danger'
        }
      } catch {}
    },
    TOTAL_CONNECTED: function (state) {
      try {
        var devices = Object.values(state.devices)

        return devices.filter(function (device) {
          return device.connected == true
        }).length
      } catch (err) {
        return 0
      }
    },
    TOTAL_DISCONNECTED: function (state) {
      try {
        var devices = Object.values(state.devices)

        return devices.filter(function (device) {
          return device.connected == false
        }).length
      } catch {
        return 0
      }
    },
    DEVICE_TIMESTAMP: (state) => (imei) => {
      return state.devices[imei].report.timestamp
    },
    DEVICE_SELECTED: function (state) {
      return state.deviceSelected
    },
    DEVICE_LOCATE_CLASS: (state) => (imei) => {
      try {
        if (state.devices[imei].locationStatus != 3) {
          return true
        } else {
          return false
        }
      } catch {}
    },
    TOTAL_LOCATE: function (state) {
      try {
        var devices = Object.values(state.devices)

        return devices.filter(function (device) {
          return device.locationStatus < 3
        }).length
      } catch (err) {
        return 0
      }
    },
    TOTAL_DISLOCATE: function (state) { // TODO: TEXTO CORRECTO ES UNLOCATE
      try {
        var devices = Object.values(state.devices)

        return devices.filter(function (device) {
          return device.locationStatus == 3
        }).length
      } catch {
        return 0
      }
    }
  }
}

/*
EVENTS
DEVICE_ADDED
DEVICE_POSITION_CHANGED
DEVICE_CONNECTION_CHANGED

*/
