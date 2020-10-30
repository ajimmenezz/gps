<template>

<div id="map-module">
        <google-maps name="map" ref="map"
        :lat="18.9240744" :lng ="-99.2252484" :zoom="5"
        :top="map.top"
        :height="map.height"
        :width="map.width"
        :left="map.left"
        :zoomControl="map.zoomControl"
        :trafficControl="map.traffic"
        :streetViewControl="map.streetViewControl"
        :clusters="this.$store.getters['mapModule/MAP_CLUSTER']"
        :clustersZoomOnClick="map.clustersZoomOnClick"
        :followDevice="this.$store.getters['devices/DEVICE_SELECTED']"
        markerSize="38"
        @onMapReady="onMapReady"
        @onMarkerClick="onMarkerClick"
        @onMarkerInfoWindowsClose="onMarkerInfoWindowsClose"

/>

<!--
  TODO: Estilos de mapa y  Satelite.
   <div style="position:fixed; width:300px; top:50px; left:200px;">
  <button class="btn btn-primary btn-sm" @click="setMapType('hybrid'), setMapStyle('')">Hybrid</button>
  <button class="btn btn-primary btn-sm" @click="setMapType('roadmap'), setMapStyle('default')">RoadMap</button>
  <br>
  <button class="btn btn-primary btn-sm" @click="setMapStyle('dark')">Dark</button>
  <button class="btn btn-dark btn-sm" @click="setMapStyle('default')">Default</button>
  <button class="btn btn-secondary btn-sm" @click="setMapStyle('')">None</button>
  <br>
  <button class="btn btn-primary btn-sm" @click="map.traffic = !map.traffic">Traffic</button>
</div> -->
          <!-- @completeRuta="completeRuta" @dataCreateRuta="dataCreateRuta" -->

        <map-float-menu v-if="map.ready && !this.$store.state.typeDevice.mobileOrTable"/>
        <map-float-menu-mobile v-if="map.ready && this.$store.state.typeDevice.mobileOrTable"/>

<!-- @onCloseInfoWindows="closeInfoWindows"
        @showInfoWondows="showInfoWondows" -->
        <streetview-controller
        v-if="this.$store.state.mapModule.streetview.show"
        @onClose="onCloseStreetView()"
        :height="streetview.height"
        :width="streetview.width"
        :left="streetview.left"
        :top="streetview.top"
        :deviceName="this.$store.state.devices.devices[this.$store.state.mapModule.streetview.device].alias"
        :deviceImei="this.$store.state.mapModule.streetview.device"
        :time="this.$store.state.devices.devices[this.$store.state.mapModule.streetview.device].report.timestamp"
        :address="this.$store.state.devices.devices[this.$store.state.mapModule.streetview.device].report.position.address"
        :lat="this.$store.state.devices.devices[this.$store.state.mapModule.streetview.device].report.position.lat"
        :lng="this.$store.state.devices.devices[this.$store.state.mapModule.streetview.device].report.position.lng"></streetview-controller>
</div>
</template>

<script>
import googleMaps from '@/components/google/google.maps'
import Vue from 'vue'
import EventBus from '@/EventBus.js'
import MapFloatMenu from '@/views/MapModule/MapFloatMenu.vue'
import DeviceInfoWindow from '@/components/DeviceInfoWindow.vue'

import mapFloatMenuMobile from '@/views/MapModule/MapFloatMenuMovil.vue'
/**
  * @vuese
     * @group MapModule
 * Contenedor de los componentes:
 * Mapa de google Maps
 * menu flotante
  * menu flotante para movil
   * street view de direccion de dispositivo
 */
export default {
  name: 'MapModule',
  components: {
    googleMaps,
    MapFloatMenu,
    mapFloatMenuMobile,
    StreetviewController: () => import('@/views/MapModule/streetview.controller')
  },
  provide () {
    return {
      getMap: this.getMap,
      loadMarkers: this.loadMarkers,
      showDeviceInfo: this.showDeviceInfo,
      closeDeviceInfo: this.closeDeviceInfo,
      onDevicesSelected: this.onDevicesSelected,
      resizeMapManual: this.resizeMapManual,
      resizeMap: this.resizeMap,
      showDeviceInfoMovil: this.showDeviceInfoMovil,
      setZoomControl: this.setZoomControl
    }
  },
  data () {
    return {
      map: {
        top: null,
        height: null,
        width: null,
        left: null,
        zoomControl: true,
        streetViewControl: false,
        clusters: true,
        clustersZoomOnClick: true,
        ready: false,
        traffic: false
      },
      streetview: {
        height: 350,
        width: 350,
        left: 150,
        top: 10
      },
      infoWindow: {
        deviceID: null,
        instance: null,
        intervalFecha: null
      }

    }
  },
  async created () {
    this.$store.state.seccionMenu = 'localizacion'
    Vue.prototype.$connect()
    this.onWindowResize()

    await EventBus.$emit('NAVBAR_MenuSimple', 'localizacion')
  },
  mounted () {
    $(window).resize(this.onWindowResize)
  },
  beforeDestroy () {
    this.unsuscribreFromDeviceEvents()
  },
  methods: {
    setMapType (type) {
      this.$refs.map.setMapType(type)
    },
    setMapStyle (style) {
      try {
        if (style == '') { this.$refs.map.setAllMapStyle('[]') } else { this.$refs.map.setAllMapStyle(require(`@/assets/map/styles/${style}.json`)) }
      } catch (err) {}
    },
    /**
   * @vuese
   * Estable si se muestra o no el panel de control de zoom del mapa
   */
    setZoomControl (state) {
      this.map.zoomControl = state
    },
    /**
   * @vuese
   * Estable si ya se crgo correctamente el mapa y estable los estilos de vista del mismo
   */
    onMapReady () {
      this.map.ready = true
      this.loadMarkers()
      this.suscribeToDeviceEvents()

      this.setMapStyle('default')

      this.$refs.map.setBoundsAllMarkers()
    },
    /**
   * @vuese
   * Manda a llamar las funciones para calcular los tamaños de pantalla y componentes
   */
    onWindowResize () {
      this.resizeMap()
      this.resizeStreetView()
    },
    /**
   * @vuese
   * Se obtiene el alto y ancho de pantalla total y se estable el tamaño y posicion del mapa
   */
    resizeMap () {
      var navbarSmallHeight = 65
      var navbarSmallMaxWidth = 991

      var top = 0
      var left = 0
      var fix = 2

      if (this.$store.state.typeDevice.mobileOrTable) {
        top = navbarSmallHeight
        this.map.zoomControl = false
      } else {
        if ($(window).width() > navbarSmallMaxWidth) {
          // Large Screen
          $('#navPrincipal').hasClass('navbar-collapsed') ? left = 80 : left = 264
        } else {
          top = navbarSmallHeight
        }
      }

      this.map.left = left
      this.map.top = top
      this.map.height = $(window).height() - top - fix
      this.map.width = $(window).width() - left
    },
    /**
   * @vuese
   * Se obtiene el alto y ancho del mapa
   */
    resizeMapManual (height, width) {
      this.map.height = height
      this.map.width = width
    },
    /**
   * @vuese
   * Se obtiene el alto y ancho del stret view
   */
    resizeStreetView () {
      if (this.$store.state.typeDevice.mobileOrTable) {
        this.streetview.height = $(window).height() - 50
        this.streetview.width = $(window).width()
      } else {
        this.streetview.height = 350
        this.streetview.width = 350
      }
    },
    /**
   * @vuese
   * Asigna y muestra el marcador del dipositivo correspondiente
   */
    loadMarkers () {
      Object.keys(this.$store.state.devices.devices).forEach(key => {
        const device = this.$store.state.devices.devices[key]
        var markerName
        if (!device.report.states.engineEnabled) {
          markerName = 'MARKER_CANCEL_RED'
        } else {
          markerName = device.marker.name
        }

        this.$refs.map.addMarker(device.imei, device.report.position.lat, device.report.position.lng, markerName, null, ``)
      })
    },
    /**
   * @vuese
   * se suscribe a eventos eventBus para:
   *  `DEVICE_POSITION_CHANGED` Cuando cambia la posicion de un dipositivo
   * `'SET_MARKER_ICON` Cambia el marcador de un dipositivo
      * `'App_resizeMap` Cambia valores de tamaño del mapa
   */
    suscribeToDeviceEvents () {
      EventBus.$on('DEVICE_POSITION_CHANGED', (device) => {
        this.$refs.map.moveMarker(device.imei, device.lat, device.lng, true)
      })

      EventBus.$on('SET_MARKER_ICON', (device) => {
        this.$refs.map.setMarkerIcon(device.imei, device.markerName)
      })

      EventBus.$on('App_resizeMap', (device) => {
        this.resizeMap()
      })

      EventBus.$on('MAP_closeMarker_infowindows', (device) => {
        this.$refs.map.moveMarker(device.imei, device.lat, device.lng, true)
      })
    },
    /**
   * @vuese
   * Se destruye la suscripcion al eventBus
   */
    unsuscribreFromDeviceEvents () {
      EventBus.$off('DEVICE_POSITION_CHANGED')
      EventBus.$off('SET_MARKER_ICON')
      EventBus.$off('App_resizeMap')
      EventBus.$off('MAP_closeMarker_infowindows')
      this.$store.state.ws.locate = false
    },
    /**
   * @vuese
   * Obtiene referencia a las propiedades del componenete mapa
   */
    getMap () {
      return this.$refs.map
    },
    /**
   * @vuese
   * Cuando da clic en un marcador manda a llamar a la funcon correspondiente para mostraar informacion del dispositivo
   */
    onMarkerClick (id) {
      if (this.$store.state.typeDevice.mobileOrTable) {
        this.showDeviceInfoMovil(id)
      } else {
        this.showDeviceInfo(id, null, 1)
      }
    },
    /**
   * @vuese
   * Carga y muestra el infowindows con la informacion del dispositivo
   */
    showDeviceInfo (id, seccion = null, accion = null) {
      var device = this.$store.state.devices.devices[id]
      // if (seccion !== 'loadComponent') {
      this.$refs.map.centerMap(device.report.position.lat, device.report.position.lng, 16)
      // }

      // eventBus open Infowindows
      if (accion != null) {
        EventBus.$emit('MapModule_OpenInfowindowsDevices', id)
      }

      var DeviceInfoWindowComponent = Vue.extend(DeviceInfoWindow)
      var instance = new DeviceInfoWindowComponent({
        propsData: { deviceID: device.id, deviceImei: device.imei }
      })
      instance.$mount()

      this.infoWindow.instance = instance
      this.infoWindow.deviceID = id
      instance.$on('onShowStreetView', this.onShowStreetView)
      this.$refs.map.closeAllMarkerInfoWindow()
      this.$refs.map.setMarkerInfoWindow(device.imei, instance.$el)
      this.$refs.map.showMarkerInfoWindow(device.imei)
    },
    /**
   * @vuese
   * Cierran infowindows
   */
    closeDeviceInfo () {
      console.debug('CIERRE_closeDeviceInfo')
      this.infoWindow.instance = null
      this.infoWindow.deviceID = null
      this.$refs.map.closeAllMarkerInfoWindow()
    },
    /**
   * @vuese
   * Cierra infowindow
   */
    onMarkerInfoWindowsClose (id, seccion = null) {
      this.infoWindow.instance = null
      this.infoWindow.deviceID = null

      console.debug('CIERRA_onMarkerInfoWindowsClose', seccion)

      if (seccion != null) {
      // eventBus close Infowindows
        EventBus.$emit('MapModule_CloseInfowindowsDevices', id)
      }
    },
    /**
   * @vuese
   * Carga y muestra el infowindows con la informacion del dispositivo version movil
   */
    showDeviceInfoMovil (id) {
      // eventBus open Infowindows
      EventBus.$emit('MapModule_OpenInfowindowsDevicesMovil', id)
    },
    /**
   * @vuese
   * Cierran street view
   */
    onCloseStreetView () {
      if (this.$store.state.typeDevice.web) {
        this.showDeviceInfo(this.$store.state.mapModule.streetview.device)
      }
      this.$store.commit('mapModule/CLOSE_STREET_VIEW')
    },
    /**
   * @vuese
   * Cierra infowindows y abre stree view de dispositivo
   */
    onShowStreetView () {
      this.$store.commit('mapModule/SHOW_STREET_VIEW', this.infoWindow.deviceID)
      this.$refs.map.closeAllMarkerInfoWindow()
      this.closeDeviceInfo()
    },
    /**
   * @vuese
   * recibe dispositivos seleccionado y abre infowindows o muestra marcadores segun sea le caso
      * @arg `payload` Arreglo de dispositivos
   */
    onDevicesSelected (payload, status = 0) {
      console.debug('MAP_onDevicesSelected', payload)
      this.$refs.map.closeAllMarkerInfoWindow()
      this.$refs.map.showAllMarkers(false)
      this.closeDeviceInfo()
      this.$store.commit('devices/SELECT_DEVICE', null)
      this.$store.state.devices.devicesLocateSELECT = null

      if (payload.length === 1) {
        this.$store.commit('devices/SELECT_DEVICE', payload[0].deviceImei)
        this.$store.state.devices.devicesLocateSELECT = payload[0].deviceImei

        this.$refs.map.setMarkerVisible(payload[0].deviceImei, true)
        var seccion = payload.seccion
        this.showDeviceInfo(payload[0].deviceImei, seccion)
      } else if (payload.length > 1) {
        var markersSelected = []
        payload.forEach(marker => {
          markersSelected.push(marker.deviceImei)
          this.$refs.map.setMarkerVisible(marker.deviceImei, true)
        })

        var bounds = this.$refs.map.getMarkersBounds(markersSelected)
        this.$refs.map.centerMapToBounds(bounds)
      } else {
        this.$refs.map.showAllMarkers(true)
      }

      // ReDibujar - Recrear clusters (limpiar cluster y agregar solo los marcadores establecidos en visible true)
    }

  },
  watch: {

  }
}
</script>

<style>

</style>
