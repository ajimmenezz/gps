<template>
  <div id="map-float-menu">

    <draggable
      :name="draggable.name"
      :top="draggable.top"
      :left="draggable.left"
      :width="draggable.width"
      :height="draggable.height"
      :zindex="draggable.index"
      :background="false"

    >
      <locker v-if="locked" :zIndex="draggable.index"/>
      <draggable-header v-if="draggable.showHeader">

        <div class="row justify-content-center">
          <div class="col-12" style="margin-bottom: -20px;">
            <ul class="nav nav-pills mb-3 sombraCard" id="pills-tab" role="tablist" style="padding: 8px; background: #3f4d67;">
              <li class="nav-item nav-item_maps_menu" style=" margin-left: 11px;">
                <a
                  class="nav-link itemPills"
                  id="pills-listDevice"
                  data-toggle="pill"
                  style="min-width: 0px;"
                  @click="loadListDevicesComponent()"
                >
                  <i
                    class="icon-lg icon universalicon-car cursor cssToolTip"
                    style="padding:0;"
                  >
                    <span>Dispositivos</span>
                  </i>
                </a>
              </li>
              <li class="nav-item nav-item_maps_menu"  v-if="this.$store.getters.permission(16)" >
                <a
                  class="nav-link itemPills"
                  id="pills-listGeofence"
                  data-toggle="pill"
                  style="min-width: 0px;"
                  @click="loadListGeofenceComponent()"
                >
                  <i
                    class="icon-lg icon universalicon-target cursor cssToolTip"
                    style="padding:0;"
                  >
                    <span>Geocercas</span>
                  </i>
                </a>
              </li>
               <li class="nav-item nav-item_maps_menu"  v-if="this.$store.getters.permission(16)" >
                <a
                  class="nav-link itemPills"
                  id="pills-listPuntoInteres"
                  data-toggle="pill"
                  style="min-width: 0px;"
                  @click="loadListPuntosIntComponent()"
                >
                  <i
                    class="icon-lg icon universalicon-marker cursor cssToolTip"
                    style="padding:0;"
                  >
                    <span>Puntos de interés</span>
                  </i>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </draggable-header>
      <draggable-content style="background:white; margin-top:15px;" v-if="draggable.showContent">
        <loader-small v-if="loader.show" :message="loader.message"/>
          <component :is='dynamicComponent.component' v-bind="dynamicComponent.properties" v-dynamic-events="dynamicComponent.events"></component>
      </draggable-content>
    </draggable>

  </div>
</template>

<script>
import locker from '@/components/locker/locker'
import { draggable, draggableHeader, draggableContent } from '@/components/draggable/'
/**
  * @vuese
   * @group MapModule
 * Panel menu flotante localización
 */
export default {
  name: 'menuFlotanteLocalizacion',
  components: {
    draggable,
    draggableHeader,
    draggableContent,
    locker,
    loaderSmall: () => import('@/components/loader/loader.small')
  },
  provide () {
    return {
      getDraggableProperties: this.getDraggableProperties,
      loadDynamicComponent: this.loadDynamicComponent,
      showMenuFloat: this.showMenuFloat
    }
  },
  inject: ['onDevicesSelected'],
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
      draggable: {
        name: 'FloatMenu',
        top: 70,
        left: 0,
        width: 300,
        height: 400,
        index: 99,
        showHeader: true,
        showContent: true
      },
      dynamicComponent: {
        component: null,
        properties: null,
        events: {
          lockDraggable: 'onLockDraggable'
        }
      },
      loader: {
        show: false
      },
      dynamicComponentName: null,
      map: null,
      locked: false
    }
  },
  created () {
    this.setDraggablePosition()
  },
  mounted () {
    this.$store.state.ws.locate = true

    $(window).resize(this.setDraggablePosition)
  },
  methods: {
    /**
   * @vuese
   * Se obtiene el alto y ancho de pantalla total y se estable la posicion del menu para panel de dispositivos.
   */
    setDraggablePosition () {
      var windowWidth = window.innerWidth
      var menuSmallMaxWidth = 891
      var menuSmallHeight = 70
      var fixWindowWidthCalculation = 100
      this.draggable.left = windowWidth - this.draggable.width - 30

      /**
       * NOTE: el calculo de @media-query en css difiere de window.innerWith
       * en mis pruebas realizadas encontre una diferencia de 67 por lo cual
       * proceso a hacer un ajuste para poder calcular 'correctamente'
       * el ancho de la pantalla
       * un mejor ejemplo de lo que me refiero puede ser consultado en
       * https://ryanve.com/lab/dimensions/
       *  */
      if (windowWidth - fixWindowWidthCalculation > menuSmallMaxWidth) {
        this.draggable.top = 10
      } else {
        this.draggable.top = menuSmallHeight + 10
      }

      this.$store.state.menu.topMenu = this.draggable.top
    },
    /**
   * @vuese
   * Obtiene los valores de las propiedades del componente padre
   */
    getDraggableProperties () {
      return this.draggable
    },
    showMenuFloat (showHeader, showContent) {
      this.draggable.showHeader = showHeader
      this.draggable.showContent = showContent
    },
    /**
   * @vuese
   * Cierran paneles secundarios
   */
    onLockDraggable (lock) {
      console.debug('lockDraggable map Float', lock)
      this.locked = lock
    },
    loadTestComponent () {
      this.dynamicComponentName = 'test'
      this.clearComponentsDinamic()

      // DeviceRoute:

      this.dynamicComponent.component = () => import('@/views/MapModule/MapFloatMenu/test/test')
    },
    /**
   * @vuese
   * Llena y muestra el componente de panel de listado de dispositivos
   */
    loadListDevicesComponent () {
      this.loader.show = true
      var route = this.dynamicComponentName

      this.clearComponentsDinamic()

      if (route !== 'devices') {
        // DeviceRoute:
        this.dynamicComponentName = 'devices'
        this.dynamicComponent.component = () => import('@/views/MapModule/MapFloatMenu/panelDevices/listDevices')
      }
      this.loader.show = false
    },
    /**
   * @vuese
   * Llena y muestra el componente de panel de listado de geocercas
   */
    loadListGeofenceComponent () {
      this.loader.show = true
      this.$store.dispatch('devices/CLEAR_FLEET')
      this.$store.dispatch('devices/CLEAR_DEVICES_SELECTED')
      this.onDevicesSelected([])

      var route = this.dynamicComponentName

      this.clearComponentsDinamic()

      if (route !== 'geofences') {
        this.dynamicComponentName = 'geofences'
        // DeviceRoute:

        this.dynamicComponent.component = () => import('@/views/MapModule/MapFloatMenu/panelGeofences/listGeofences')
      }
      this.loader.show = false
    },
    /**
   * @vuese
   * Llena y muestra el componente de panel de listado de puntos de interes
   */
    loadListPuntosIntComponent () {
      this.loader.show = true
      this.$store.dispatch('devices/CLEAR_FLEET')
      this.$store.dispatch('devices/CLEAR_DEVICES_SELECTED')
      this.onDevicesSelected([])

      var route = this.dynamicComponentName

      this.clearComponentsDinamic()

      if (route !== 'puntosI') {
        this.dynamicComponentName = 'puntosI'
        // DeviceRoute:

        this.dynamicComponent.component = () => import('@/views/MapModule/MapFloatMenu/panelPuntoInteres/listPuntoInteres')
      }

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
      // this.showAllDrawing(false)
      // this.showAllDrawing(false, 1)
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
