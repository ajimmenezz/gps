<template>
  <div id="map-float-menu">
    <div  id="menu_moviles"
    style="position:fixed; zIndex:99; right:10px; bottom:20px;">
      <button type="button" class="btn btn-icon btn-movile-float btn-rounded btn-primary"
      @click="loadListDevicesComponent()" style="background: rgb(63, 77, 103); border:none;">

          <i class="icon-lg icon universalicon-traffic-jam cursor " style="padding:0;" ></i>

      </button>
    </div>

    <component id="contentMovile"  :is='dynamicComponent.component' v-bind="dynamicComponent.properties" v-dynamic-events="dynamicComponent.events"></component>

  </div>
</template>

<script>
import locker from '@/components/locker/locker'
import EventBus from '@/EventBus'
/**
  * @vuese
     * @group MapModule
 * Panel menu flotante localización movil
 */
export default {
  name: 'menuFlotanteLocalizacionMovil',
  components: {

    locker,
    loaderSmall: () => import('@/components/loader/loader.small')
  },
  provide () {
    return {
      getDraggableProperties: this.getDraggableProperties,
      loadDynamicComponent: this.loadDynamicComponent,
      showMenuFloat: this.showMenuFloat,
      getDraggablePropertiesDeviceInfo: this.getDraggablePropertiesDeviceInfo
    }
  },
  inject: ['getMap', 'onDevicesSelected', 'resizeMap'],
  directives: {
    DynamicEvents: {
      bind: (el, binding, vnode) => {
        const allEvents = binding.value
        Object.keys(allEvents).forEach((event) => {
          // register handler in the dynamic component
          vnode.componentInstance.$on(event, (eventData) => {
            const targetEvent = allEvents[event]
            vnode.context[targetEvent](eventData)
          })
        })
      },
      unbind: function (el, binding, vnode) {
        vnode.componentInstance.$off()
      }
    }
  },
  data () {
    return {
      map: null,
      contentData: {
        name: 'FloatListDevicesMobile',
        top: 70,
        height: 0,
        width: 0,
        index: 99,
        bottom: 0,
        left: 0
      },
      device: null,
      dynamicComponent: {
        component: null,
        properties: null,
        events: {
          lockDraggable: 'onLockDraggable',
          closeList: 'clearComponentsDinamic'

        }
      },
      loader: {
        show: false
      },
      dynamicComponentName: null,

      locked: false
    }
  },
  created () {
    // this.setDraggablePositionMenu()
    this.onWindowResize()
  },
  mounted () {
    $(window).resize(this.onWindowResize)

    this.map = this.getMap()
    this.$store.state.ws.locate = true
    // $(window).resize(this.setDraggablePositionMenu)
    this.suscribeToDeviceEvents()
  },
  beforeDestroy () {
    this.unsuscribreFromDeviceEvents()
  },
  methods: {
    /**
   * @vuese
   * Manda a llamar la funcion para calcular los tamaños de pantalla
   */
    onWindowResize () {
      this.resizeDraggable()
    },
    /**
   * @vuese
   * Se obtiene el alto y ancho de pantalla total y se estable la posicion del menu para panel de dispositivos.
   */
    async resizeDraggable () {
      var windowWidth = screen.width
      var windowHeight = screen.height

      var bottom = windowHeight - 80
      var right = windowWidth - 80
      this.contentData.left = right
      this.contentData.bottom = bottom
      // $('#menu_moviles').css({ left: right, top: bottom })
      // $('#menu_moviles').css({ left: right, top: bottom })
    },
    // TODO: evenbus
    /**
   * @vuese
   * se suscribe a eventos eventBus para:
   *  `MapModule_OpenInfowindowsDevicesMovil` Abre infowindows de un dispositivo
   * `'Ws_LOCATE_SELECT_movil` Inidcador dispositivo localizado
   */
    suscribeToDeviceEvents () {
      EventBus.$on('MapModule_OpenInfowindowsDevicesMovil', (id) => {
        this.openInfowindowsDevicesMovil(id)
      })
      EventBus.$on('Ws_LOCATE_SELECT_movil', (payload) => {
        var deviceImei = payload[0].deviceImei
        this.openInfowindowsDevicesMovil(deviceImei)
      })
    },
    /**
   * @vuese
   * Se destruye la suscripcion al eventBus
   */
    unsuscribreFromDeviceEvents () {
      EventBus.$off('MapModule_OpenInfowindowsDevicesMovil')
      EventBus.$off('Ws_LOCATE_SELECT_movil')
    },
    /**
   * @vuese
   * Obtiene los valores de las propiedades del componente padre
   */
    getDraggableProperties () {
      return this.contentData
    },
    /**
   * @vuese
   * Obtiene los valores de las propiedades de dispositivo del componente padre
   */
    getDraggablePropertiesDeviceInfo () {
      return this.device
    },
    /**
   * @vuese
   * Llena y muestra el componente de panel de listado de dispositivos
   */
    loadListDevicesComponent () {
      this.loader.show = true

      this.clearComponentsDinamic()

      this.dynamicComponentName = 'devices'
      this.dynamicComponent.component = () => import('@/views/MapModule/MapFloatMenuMovile/panelDevices/listDevices')

      this.loader.show = false
    },
    /**
   * @vuese
   * Asigna los valores de las variables del componente dinamico a mostrar
   */
    loadDynamicComponent (componentName, component, properties) {
      this.clearComponentsDinamic()
      this.dynamicComponentName = componentName
      this.dynamicComponent.component = component
      this.dynamicComponent.properties = properties
    },
    /**
   * @vuese
   * Limpia las variables del componenete dinamico
   */
    clearComponentsDinamic () {
      this.dynamicComponentName = null
      this.dynamicComponent.component = null
      this.dynamicComponent.properties = null

      this.resizeMap()
    },
    /**
   * @vuese
   * Centra el mapa y coloca marcador en la posicion del dispositivo a consultar asi como abre infowindows del mismo
   */
    async openInfowindowsDevicesMovil (id) {
      // this.clearComponentsDinamic()
      this.$store.commit('devices/SELECT_DEVICE', null)
      this.$store.state.devices.devicesLocateSELECT = null
      this.map.showAllMarkers(false)

      var device = this.$store.state.devices.devices[id]
      this.device = device

      this.map.centerMap(device.report.position.lat, device.report.position.lng, 16)

      // this.$store.commit('devices/SELECT_DEVICE', id)
      // this.$store.state.devices.devicesLocateSELECT = id

      this.map.setMarkerVisible(id, true)

      this.openDeviceDataInfo(id)
    },
    /**
   * @vuese
   * Llena y muestra el componente de infowindows de dispositivo
   */
    openDeviceDataInfo (id) {
      this.loader.show = true

      this.clearComponentsDinamic()

      this.dynamicComponentName = 'devicesInfo'
      this.dynamicComponent.component = () => import('@/views/MapModule/MapFloatMenuMovile/panelDevices/DeviceInfoWindow')

      this.loader.show = false
    }

  }
}
</script>

<style>
.cursor {
  cursor: pointer;
}

.card-body-conf {
  padding: 10px 25px !important;
}

.nav-item_maps_menu {
  width: 65px;
}

.itemPills:hover > .icon {
  /* color: #04a9f5; */
  color: #1dc4e9;
}

.itemPills > .icon {
  /* color: #04a9f5; */
  color: #ffff;
}

.itemPills.active > .nav-link {
  color: #1dc4e9;
}

.nav-link.active > .icon {
  color: #ffff;
}

.sombraCard {
  border-radius: 0;
  -webkit-box-shadow: 0 1px 20px 0 rgba(69, 90, 100, 0.08);
  box-shadow: 0 1px 20px 0 rgba(69, 90, 100, 0.08);
  border: none;
  -webkit-transition: all 0.5s ease-in-out;
  transition: all 0.5s ease-in-out;
}
</style>
