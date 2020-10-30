<template>
  <div id="app" v-if="storeReady" style="overflow-x: hidden;">
    <div
      id="contenedor"
      style="z-index: 1080; position: fixed; width: 50%; height: 50%; top: 0; left: 30%;"
      v-if="this.$store.state.loader"
    >

      <div
        class="fondo_loader"
        style="z-index: 1080; position: fixed; width: 100%; height: 100%; top: 0; left: 0; background: #0000001f;"
      ></div>
      <div class="loader" id="loader" style="z-index: 1080;">Loading...</div>
    </div>

    <!-- <div id="bloquea" style="display:none; width:100%; height:100%; overflow:hidden; z-index:10000; background-color: #969696; position: absolute; opacity: 0.3;"></div> -->
    <div id="modal" >
      <component :is="nameComponent" v-if="isVisible"></component>
    </div>

     <!-- <div id="bloquea" style="display:none; width:100%; height:100%; overflow:hidden; z-index:10000; background-color: #969696; position: absolute; opacity: 0.3;"></div> -->
    <div id="modalLoader" >
      <component :is="nameComponentLoader" v-if="isVisibleLoader"></component>
    </div>

    <nav id="navPrincipal" class="pcoded-navbar" v-if="showMenu && !this.$store.state.typeDevice.mobileOrTable">
      <able-navbar />
    </nav>

     <nav id="navPrincipal" class="pcoded-navbar" v-if="showMenu && this.$store.state.typeDevice.mobileOrTable && !getPermissionCliente">
      <able-navbar />
    </nav>

    <able-header id="header_menu" v-if="showMenu && !this.$store.state.typeDevice.mobileOrTable " style="position: absolute; " />

      <able-header id="header_menu" v-if="showMenu && this.$store.state.typeDevice.mobileOrTable && !getPermissionCliente" style="position: absolute; " />

    <able-header-movil id="header_menuMovil" v-if="showMenu && this.$store.state.typeDevice.mobileOrTable && getPermissionCliente"  style="margin:0; padding: 15px 0px 0px 10px;"/>

    <router-view id="containerPrincipal"/>

    <div
      id="webConection"
      class="row"
      style="position:fixed; z-index:1, bottom:0px; width: 100%; height: 3%; left:20px; text-align: center; bottom: 0px;
    background-color: #f4c22b;
    color: #000;"
      v-if="this.$store.state.ws.locate && !this.$store.state.ws.connected "
    >
      <div class="col">El servidor se encuentra fuera de línea</div>
    </div>
  </div>
</template>

<script>
import ableNavbar from '@/components/menu/AbleNavbar'
import ableHeader from '@/components/menu/AbleHeader'
import ableHeaderMovil from '@/components/menu/AbleHeaderMovil'
import Vue from 'vue'

import EventBus from '@/EventBus'

import { SecureStorage } from '@/mixins/SecureStorage'
import { API } from '@/mixins/API'
/**
* @vuese
* @group App
* Cotenedor principal de todos los conponentes:
* `cargando`, `bloqueo`, `modal`, `contenedor principal`, `menu y menu movil`, `mensaje de servidor fuera de linea`
 */
export default {
  components: {
    ableNavbar,
    ableHeader,
    ableHeaderMovil
  },
  mixins: [SecureStorage, API],
  data () {
    return {
      lastTime: 0,
      maxTimeInactive: 900000,
      timeInterval: 300000,

      storeReady: false,
      locate: false
    }
  },
  beforeMount () {
    this.loadStore()
  },
  created () {
    if (this.$store.getters.isMenuVisible) {
      if (!this.$store.state.typeDevice.mobileOrTable) {
        this.setDraggablePositionMenu()

        $(window).resize(
          function () {
            this.setDraggablePositionMenu()
          }.bind(this)
        )
      }
    }
  },
  mounted () {
    $(document).mousemove(this.updateInactiveTime)
    setInterval(this.checkInactiveTime, this.timeInterval)

    $('#containerPrincipal').css({
      'margin-left': this.$store.state.widthMenu,
      'margin-top': this.$store.state.topMenu
    })
  },
  methods: {
    /**
   * @vuese
   * Obtiene tamaño de la pantalla para establecer el tamaño del contenedor del contenido
   */
    setDraggablePositionMenu () {
      /**
       * NOTE: el calculo de @media-query en css difiere de window.innerWith
       * en mis pruebas realizadas encontre una diferencia de 67 por lo cual
       * proceso a hacer un ajuste para poder calcular 'correctamente'
       * el ancho de la pantalla
       * un mejor ejemplo de lo que me refiero puede ser consultado en
       * https://ryanve.com/lab/dimensions/
       *
       *  */

      var windowWidth = $(window).width()
      var menuSmallMaxWidth = 991
      var menuSmallHeight = 70
      var fixWindowWidthCalculation = 100
      var top
      var left
      var zIndex

      if (windowWidth > menuSmallMaxWidth) {
        top = 10

        if ($('#navPrincipal').hasClass('navbar-collapsed')) {
          left = 80
        } else {
          left = 264
        }

        //  left = $('#navPrincipal').width()
        zIndex = -1
      } else {
        top = 80
        left = 0
        zIndex = 1
      }

      if ($(`#localizacion`).hasClass('active')) {
        top = 0
      }
      this.$store.state.widthMenu = left
      this.$store.state.topMenu = top

      if (this.$store.state.islogged) {
        console.debug('APP_left', left, 'top', top, 'zindex', zIndex)

        if (!this.$store.state.typeDevice.mobileOrTable) {
          $('#containerPrincipal').css({ 'margin-left': left })
          $('#containerPrincipal').css({ 'margin-top': top })
        }

        // event bus dimenciones mapa
        // EventBus.$emit('App_resizeMap', 1)

        $('#header_menu').css({ 'z-index': zIndex })
        if ($('#navPrincipal').hasClass('navbar-collapsed')) {
          $(`#textSession`).addClass('session-collapsee')
          $(`#aSession`).addClass('session-collapsea')
          $('#tipoClientMenu').addClass('session-collapsee')
          $('#tipoClientMenu').css('opacity', '0')
        } else {
          $(`#textSession`).removeClass('session-collapsee')
          $(`#aSession`).addClass('session-nocollapsea')
          $('#tipoClientMenu').removeClass('session-collapsee')
          $('#tipoClientMenu').css('opacity', '1')
        }
      }
    },
    /**
   * @vuese
   * Cuando se recarga la pagina vuelve a inicializar el store
   */
    async loadStore () {
      if (sessionStorage.logged !== undefined) {
        if (
          this.sessionGet('logged') === true &&
          this.$store.state.isLogged === undefined
        ) {
          // console.log(this.sessionGet('firstLogin'))
          if (sessionStorage.loginFist !== undefined) {
            var FirstTimeLogin = sessionStorage.loginFist
          }

          var data = {
            devices: await this.getDevices(),
            fleets: await this.getFleets(),
            permissions: await this.getPermissions(),
            session: {
              isFirstTimeLogin: FirstTimeLogin,
              userType: sessionStorage.UT,
              clientType: sessionStorage.TC
            },
            reportTypes: await this.getCatalogReportType()
          }

          // console.debug('LOGIN_devices', data.devices)
          await this.$store.dispatch('devices/LOAD_DEVICES', data.devices)
          /* carga array flotillas */

          await this.$store.commit('menuOptions', data.permissions)

          await this.$store.dispatch('devices/LOAD_FLEETS', data.fleets)
          this.$store.state.devices.fleets.push({
            id: null,
            name: 'SIN ASIGNAR',
            selected: false,
            iconCollapse: true
          })

          await this.$store.dispatch('SuccessLogin', data)

          this.$store.dispatch('showMenu', true)
          await this.$store.dispatch('loginFirstTime', false)

          this.$moment.tz.setDefault(this.sessionGet('timezone'))

          await this.$store.commit('ws/CATALOG_REPORT_TYPES', data.reportTypes)

          this.storeReady = true
        }
      } else {
        this.storeReady = true
      }
    },
    /**
   * @vuese
   * Obtiene lista de dispositivos
   */
    async getDevices () {
      var request = await this.getRequest('devices')
      return request.data.devices
    },
    async getCatalogReportType () {
      var request = await this.getRequest('catalogs/devices/reports/types')
      return request.data.reportTypes
    },
    /**
   * @vuese
   * Obtiene lista de flotilla
   */
    async getFleets () {
      var request = await this.getRequest('fleets')
      return request.data.fleets
    },
    /**
   * @vuese
   * Obtiene lista de permisos
   */
    async getPermissions () {
      var request = await this.getRequest('permissions')
      return request.data.permissions
    },
    /**
   * @vuese
   * Actualiza ultima inactividad
   */
    updateInactiveTime () {
      this.lastTime = $.now()
    },
    /**
   * @vuese
   * Checa cuanto tiempo tiene inactivo el cliente sin hacer nada en el sistema y procede a las acciones correspondientes
   */
    async  checkInactiveTime () {
      console.debug('Check Inactive Time')
      if (sessionStorage.logged !== undefined) {
        if (this.sessionGet('logged') === true) {
          if (this.lastTime !== 0) {
            var timeNow = $.now()
            var timeDifference = timeNow - this.lastTime
            console.debug(timeDifference, ' checkInactiveTime ', this.maxTimeInactive)
            if (timeDifference > this.maxTimeInactive) {
              console.debug('Inactive user, close session')
              Vue.prototype.$disconnect()
              await this.$store.dispatch('LogOut')
              await this.$router.push('/')
            }
          }
        }
      }
    }

  },
  computed: {
    /**
   * @vuese
   * Obtiene si se muestra el menu o no
   */
    showMenu () {
      if (this.$store.getters.isMenuVisible) {
        if (!this.$store.state.typeDevice.mobileOrTable) {
          this.setDraggablePositionMenu()

          $(window).resize(
            function () {
              this.setDraggablePositionMenu()
            }.bind(this)
          )
        }
      }
      return this.$store.getters.isMenuVisible
    },
    /**
   * @vuese
   * Obtiene si es la primera vez que ingresa al sistema
   */
    loginFirst () {
      return this.$store.getters.getloginFirstTime
    },
    /**
   * @vuese
   * Obtiene si se muestra o no el modal
   */
    isVisible () {
      return this.$store.state.modal.isVisible
    },
    /**
   * @vuese
   * Obtiene componente modal
   */
    nameComponent () {
      return this.$store.state.modal.component
    },
    /**
   * @vuese
   * Obtiene si se muestra o no el modal
   */
    isVisibleLoader () {
      return this.$store.state.modaloader.isVisible
    },
    /**
   * @vuese
   * Obtiene componente modal
   */
    nameComponentLoader () {
      return this.$store.state.modaloader.component
    },
    getPermissionCliente () {
      var tipoUser = sessionStorage.UT
      var tipoClient = sessionStorage.TC

      if (tipoUser == 2) { // asociado
        if (tipoClient == 1) { // cliente/asociado
          return true
        } else { // sub admin, dist
          return false
        }
      } else { // cliente, distribuidor, admin
        if (tipoUser == 1) { // cliente/asociado
          return true
        } else {
          return false
        }
      }
    }
  }
}
</script>

<style>
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  /* height: 100vh; */
}

::-webkit-scrollbar { width: 12px; height: 12px;}
/* ::-webkit-scrollbar-button {  background-color: #E0E0E0; } espacio superior e inferior barras*/
::-webkit-scrollbar-track {  background-color:yellow;}
::-webkit-scrollbar-track-piece { background-color:#E0E0E0;}
::-webkit-scrollbar-thumb { height: 50px; background-color: #757575; border-radius: 3px;}
/* ::-webkit-scrollbar-corner { background-color: green;} union */
::-webkit-resizer { background-color: #666;}

.card .card-header h5:after {
  width: 0px;
}

.big-text {
  white-space: pre-wrap; /* CSS3 */
  white-space: -moz-pre-wrap; /* Firefox */
  white-space: -pre-wrap; /* Opera <7 */
  white-space: -o-pre-wrap; /* Opera 7 */
  word-wrap: break-word; /* IE */
}

.text-ellipsis {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
</style>
