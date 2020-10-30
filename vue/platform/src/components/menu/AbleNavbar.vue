<template>
  <div class="navbar-wrapper">
    <div class="navbar-brand header-logo" style="margin-bottom: 20px;">
      <router-link to="/Location" class="b-brand" style="margin-top:10px;" >

        <div class="row"   @click="selectMenuSimple('localizacion')">
        <div class="b-bg col-2" style="background:linear-gradient(-135deg, #ffffff 0%, #ffffff 100%); padding: 5px !important;" >
          <!-- <i class="feather icon-trending-up"></i> -->
           <img class="img-fluid" id="img_menu"    :src="`${logoGet}isotipo.png`" >
         <!-- <span>
                      <i class="text-muted cursor icon-small universalicon-user"></i>
                    </span> -->
        </div>
        <div class="col-9 " style="padding:0px;">

          <span class="b-title float-left  text-ellipsis cssToolTipp" style="width: 150px;">{{this.sessionGet('user')}}
             <p style="top: 20px; left: 260px; position:fixed; width: 250px;" >Usuario: {{this.sessionGet('user')}}  <br> Cuenta: {{this.sessionGet('client')}} <br>Tipo: {{this.$store.state.typeUserMenu}}</p>

          </span>
          <span class="b-title float-left text-ellipsis cssToolTipp" style="font-size: 13px; width: 150px;">{{this.sessionGet('client')}}
             <p style="top: 20px; left: 260px; position:fixed; width: 250px;" >Usuario: {{this.sessionGet('user')}}  <br> Cuenta: {{this.sessionGet('client')}} <br>Tipo: {{this.$store.state.typeUserMenu}}</p>
            </span>

        </div>
        </div>
      </router-link>
      <a class="mobile-menu" id="mobile-collapse" @click="toggleCollapseMenu('navPrincipal')">
        <span></span>
      </a>
    </div>
    <div class="navbar-content scroll-div" id="CONTENT_ALL" style="overflow-y: auto; overflow-x: hidden; height: 80%">
      <ul class="nav pcoded-inner-navbar" id="menuContent">

           <li
            id="adminHome"
            data-username="adminHome"
            class="nav-item"
            @click="selectMenuSimple('adminHome')"
            v-if="showDasboard"
            >
            <router-link to="/adminHome" class="nav-link" >
              <span>
                <i class="iconMenu icon-small universalicon-home cursor"></i>
              </span>
              <span class="pcoded-mtext">Inicio</span>
            </router-link>
          </li>
          <!-- <li
            id="Dashboard"
            data-username="Dashboard"
            class="nav-item"
            @click="selectMenuSimple('Dashboard')"
            v-if="showDasboard"
            >
            <router-link to="/Dashboard" class="nav-link" >
              <span>
                <i class="iconMenu icon-small universalicon-monitor cursor"></i>
              </span>
              <span class="pcoded-mtext">Dashboard</span>
            </router-link>
          </li> -->

          <li
            id="localizacion"
            data-username="Localizacion"
            class="nav-item"
            @click="selectMenuSimple('localizacion')"
            v-if="this.$store.getters.permission(1)"

            >
            <!-- <div class="tooltip">Hover over me
              <span class="tooltiptext">Tooltip text</span>
            </div> -->

            <router-link to="/Location" class="nav-link" >
              <span>
                <i class="iconMenu icon-small universalicon-world cursor"></i>
              </span>
              <span class="pcoded-mtext">Localización</span>
            </router-link>
          </li>

          <li
            id="reportes"
            data-username="Reportes"
            class="nav-item"
            @click="selectMenuSimple('reportes')"
            v-if="this.$store.getters.permission(2)"
            >
            <router-link to="/reports" class="nav-link">
              <span>
                <i class="iconMenu icon-small universalicon-chart-combo cursor"></i>
              </span>
              <span class="pcoded-mtext">Reportes</span>
            </router-link>
          </li>

          <li
            id="alertas"
            data-username="Alertas"
            class="nav-item"
            @click="selectMenuSimple('alertas')"
            v-if="this.$store.getters.permission(3)"

            >
            <router-link to="/Alertas" class="nav-link">
              <span>
                <i class="iconMenu icon-small feather icon-bell cursor"></i>
              </span>
              <span class="pcoded-mtext">Alertas</span>
            </router-link>
          </li>

          <li
            id="Distribuidores"
            data-username="Distribuidores"
            class="nav-item"
            @click="selectMenuSimple('Distribuidores')"
            v-if="this.$store.getters.permission(13)"
            >
            <router-link to="/ListTableDistrobuitor" class="nav-link">
              <span>
                <i class="iconMenu icon-small universalicon-card-id cursor"></i>
              </span>
              <span class="pcoded-mtext">Distribuidores</span>
            </router-link>
          </li>

          <li
            id="Clientes"
            data-username="Clientes"
            class="nav-item"
            @click="selectMenuSimple('Clientes')"
            v-if="this.$store.getters.permission(14)"
            >
            <router-link to="/ListaCliente" class="nav-link">
              <span>
                <i class="iconMenu icon-small universalicon-card-id cursor"></i>
              </span>
              <span class="pcoded-mtext">Clientes</span>
            </router-link>
          </li>

          <!-- <li
            id="adminUsers"
            data-username="adminUsers"
            class="nav-item pcoded-hasmenu"
            @click="toggleSubmenu('adminUsers')"
            v-if=" this.$store.getters.permission(11) || this.$store.getters.permission(12) || this.$store.getters.permission(13) || this.$store.getters.permission(14)"

            >
            <router-link to="" class="nav-link">
              <span>
                <i class="iconMenu icon-small feather icon-settings cursor"></i>
              </span>
              <span class="pcoded-mtext">Usuarios</span>
            </router-link>

            <ul class="pcoded-submenu">
              <li @click="activeSubmenu('adminUsers','itemSubAdmin')" id="itemSubAdmin" class="item-submenu" v-if="this.$store.getters.permission(11)">
                <router-link to="/ListTableSubAdmin" class="nav-link">
                  <span  class="pcoded-mtext ">Sub administradores</span>
                </router-link>
              </li>
              <li @click="activeSubmenu('adminUsers','itemDistribuidor')" id="itemDistribuidor" class="item-submenu" v-if="this.$store.getters.permission(13)">
                <router-link to='/ListTableDistrobuitor' class="nav-link">
                  <span  class="pcoded-mtext ">Distribuidores</span>
                </router-link>
              </li>
              <li @click="activeSubmenu('adminUsers','itemSubDist')" id="itemSubDist" class="item-submenu" v-if="this.$store.getters.permission(12)">
                <router-link to='/ListTableSubDistribuitor' class="nav-link">
                  <span  class="pcoded-mtext ">sub distribuidores</span>
                </router-link>
              </li>
              <li @click="activeSubmenu('adminUsers','itemClientes')" id="itemClientes" class="item-submenu" v-if="this.$store.getters.permission(14)">
                <router-link to='/ListTableClient' class="nav-link">
                  <span  class="pcoded-mtext ">Clientes</span>
                </router-link>
              </li>
            </ul>
          </li> -->

          <!-- <li
            id="adminGps"
            data-username="adminGps"
            class="nav-item"
            @click="selectMenuSimple('adminGps')"
            v-if="this.$store.getters.permission(9)"
            >
            <router-link to="/ListTableGps" class="nav-link">
              <span>
                <i class="iconMenu icon-small universalicon-car cursor"></i>
              </span>
              <span class="pcoded-mtext">GPS</span>
            </router-link>
          </li>

          <li
            id="adminSims"
            data-username="adminSims"
            class="nav-item"
            @click="selectMenuSimple('adminSims')"
            v-if="this.$store.getters.permission(10)"

            >
            <router-link to="/ListTableSims" class="nav-link">
              <span>
                <i class="iconMenu icon-small universalicon-sim-card cursor"></i>
              </span>
              <span class="pcoded-mtext">SIMS</span>
            </router-link>
          </li> -->

            <li
            id="almacen"
            data-username="almacen"
            class="nav-item"
            @click="selectMenuSimple('almacen')"
           v-if="this.$store.getters.permission(20) || this.$store.getters.permission(17) || this.$store.getters.permission(9) || this.$store.getters.permission(10)"
            > <!--v-if="this.$store.state.clientType==2"-->
            <router-link to="/store" class="nav-link">
              <span>
                <i class="iconMenu icon-small universalicon-depto cursor"></i>
              </span>
              <span class="pcoded-mtext">Almacenes</span>
            </router-link>
          </li>

             <!-- <li
            id="catalogos"
            data-username="catalogos"
            class="nav-item"
            @click="selectMenuSimple('catalogos')"
            v-if="this.$store.getters.permission(18)"
            >
            <router-link to="/catPrincipal" class="nav-link">
              <span>
                <i class="iconMenu icon-small universalicon-layers cursor"></i>
              </span>
              <span class="pcoded-mtext">Catálogos</span>
            </router-link>
          </li>

            <li
            id="operacion"
            data-username="operacion"
            class="nav-item"
            @click="selectMenuSimple('operacion')"
            v-if="this.$store.getters.permission(19)"
            >
            <router-link to="/transactions" class="nav-link">
              <span>
                <i class="iconMenu icon-small universalicon-shopping-cart cursor"></i>
              </span>
              <span class="pcoded-mtext">Operaciones</span>
            </router-link>
          </li> -->

          <li
            id="config"
            data-username="configuración"
            class="nav-item pcoded-hasmenu"
            @click="toggleSubmenu('config')"

            >
            <!-- v-if=" this.$store.getters.permission(5) || this.$store.getters.permission(6) || this.$store.getters.permission(7) || this.$store.getters.permission(8)" -->
            <router-link to="" class="nav-link">
              <span>
                <i class="iconMenu icon-small feather icon-settings cursor"></i>
              </span>
              <span class="pcoded-mtext">Configuración</span>
            </router-link>

            <ul class="pcoded-submenu">
               <li @click="activeSubmenu('config','itemPerfil')" id="itemPerfil" class="item-submenu" >
                <router-link to="/miCuenta" class="nav-link" >
                  <span  class="pcoded-mtext ">Mi cuenta</span>
                </router-link>

                 <!-- <router-link to="/miCuentaTablet" class="nav-link" v-if="this.$store.state.typeDevice.mobileOrTable">
                  <span  class="pcoded-mtext ">Mi cuenta</span>
                </router-link> -->

              </li>
              <li @click="activeSubmenu('config','itemDevice')" id="itemDevice" class="item-submenu" v-if=" this.$store.getters.permission(5) || this.$store.getters.permission(6)">
                <router-link to="/devices" class="nav-link">
                  <span  class="pcoded-mtext ">Dispositivos</span>
                </router-link>

              </li>
              <li @click="activeSubmenu('config','itemFlotilla')" id="itemFlotilla" class="item-submenu" v-if="this.$store.getters.permission(7)"> <!-- v-if="this.$store.getters.permission(7)" -->
                <router-link to="/flotillas" class="nav-link " >
                  <span  class="pcoded-mtext " >Flotillas</span>
                </router-link>
              </li>
              <li @click="activeSubmenu('config','itemUser')" id="itemUser" class="item-submenu" v-if="this.$store.getters.permission(8)" > <!-- v-if="this.$store.getters.permission(8)" -->
                <router-link to="/listaUsers" class="nav-link " >
                  <span  class="pcoded-mtext " >Usuarios</span>
                </router-link>
              </li>

            </ul>
          </li>

        <!-- <li data-username="Cerrar Sesion" class="nav-item" style="position: absolute; bottom: 0px;">
          <a class="nav-link cursor" @click="logout()">
            <span>
              <i class="iconMenu icon-small universalicon-log-out cursor"></i>
            </span>
            <span class="pcoded-mtext">Salir</span>
          </a>
        </li> -->
      </ul>

    </div>
      <div id="Classession" data-username="Cerrar Sesion" class="" style="position: absolute; bottom: 0px;">
          <a id="aSession" class="nav-link cursor" @click="logout()" style="padding-left:15px;    margin-bottom: 7px;">
            <span>
              <i class="iconMenu icon-small universalicon-log-out cursor"></i>
            </span>
            <span id="textSession" class="pcoded-mtext">Salir</span>

          </a>

        </div>
        <div class="row" ><div id="tipoClientMenu" class="col-12 float-right" style="position: absolute; bottom: 0px; padding: 0px;"><span  classs="float-right " style="margin-left: 40px; font-size:12px;">{{this.$store.state.typeUserMenu}}</span></div></div>
  </div>
</template>

<script>
import Vue from 'vue'
import EventBus from '@/EventBus'
import { Functions } from '@/mixins/Functions.js'
import { SecureStorage } from '@/mixins/SecureStorage.js'
/**
* @vuese
* @group componenets/menu
* menu izquierdo (modulos)
 */
export default {
  name: 'ableNavbar',
  mixins: [SecureStorage, Functions],
  data () {
    return {
      menuString: '',
      permision: null,
      menuOptions: null,
      opc: null,
      submenuActive: null,
      itemSubmenuActive: null,
      toogleSubmenuStatus: 0,
      Getlogo: localStorage.getItem('imgLogo')
    }
  },
  created () {
    this.getRutaHome()
    this.suscribeToDeviceEvents()
  },
  async mounted () {
    // $('#CONTENT_ALL').html(this.menuString)
    // $('#menuContent').append(this.menuString)
    console.debug('MENU_STORE', this.$store.state.seccionMenu, this.$store.state.submenuActive, this.$store.state.itemSubmenuActive)
    this.selectMenuSimple(this.$store.state.seccionMenu)
    if (this.$store.state.itemSubmenuActive != null && this.$store.state.submenuActive != null) {
      this.toogleSubmenuStatus(this.$store.state.submenuActive)
      this.activeSubmenu(this.$store.state.submenuActive, this.$store.state.itemSubmenuActive)
    }
    this.$store.state.widthMenu = $('#navPrincipal').width()
  },
  beforeDestroy () {
    this.unsuscribreToDeviceEvents()
  },
  methods: {

    /**
   * @vuese
   * Obtiene la ruta principal
   */
    getRutaHome () {
      var tipoUser = sessionStorage.UT
      var tipoClient = sessionStorage.TC
      var ruta = ''

      if (tipoUser == 2) { // asociado
        if (tipoClient == 1) { // cliente/asociado
          ruta = 'localizacion'
          this.$store.state.showDasboard = false
        } else { // sub admin
          ruta = 'adminHome'
          this.$store.state.showDasboard = true
        }
      } else { // cliente, distribuidor, admin
        if (tipoUser == 1) { // cliente
          ruta = 'localizacion'
          this.$store.state.showDasboard = false
        } else {
          ruta = 'adminHome'
          this.$store.state.showDasboard = true
        }
      }

      if (tipoUser == 1) { // cliente
        this.$store.state.typeUserMenu = 'Cliente'
      }
      if (tipoUser == 3) { // cliente
        this.$store.state.typeUserMenu = 'Distribuidor'
      }
      if (tipoUser == 4) { // cliente
        this.$store.state.typeUserMenu = 'Administrador'
      }

      if (tipoUser == 2) { // asociado
        if (tipoClient == 1) { // cliente
          this.$store.state.typeUserMenu = 'Asociado'
        }
        if (tipoClient == 2) { // dist
          this.$store.state.typeUserMenu = 'Asociado distribuidor'
        }
        if (tipoClient == 3) { // admin
          this.$store.state.typeUserMenu = 'Asociado administrador'
        }
      }

      // this.$store.state.seccionMenu = ruta
      console.debug(ruta, 'MENU_RUTA', this.$store.state.apiUrl, this.$store.state.seccionMenu)
    },
    /**
   * @vuese
   * Cuando collapsa o no  menu
   * @arg `elementID` id de elemento padre
   */
    toggleCollapseMenu (elementID) {
      var left
      // this.$store.state.topMenu = 10
      $(`#${elementID}`).toggleClass('navbar-collapsed')

      $(`#aSession`).removeClass('session-collapsea')
      $(`#aSession`).removeClass('session-nocollapsea')
      $(`#textSession`).removeClass('session-collapsee')

      if ($(`#${elementID}`).hasClass('navbar-collapsed')) {
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

      $('#streetview').css('left', this.$store.state.widthMenu)

      EventBus.$emit('refresh_dataTable', 1)

      this.widthWindows()
    },
    /**
   * @vuese
   * Remueve todas las clases de interacion menu
   */
    removerClassAll () {
      $('.pcoded-hasmenu').removeClass('active pcoded-trigger')
      $('.nav-item').removeClass('active ')
      $('.item-submenu').removeClass('active ')
      $('.nav-item').removeClass('pcoded-trigger ')
    },
    /**
   * @vuese
   * Cuando da clic en opcion de menu que no tiene submenu
   * @arg `elementID` id de elemento
   */
    selectMenuSimple (elementID) {
      console.debug('FUNCION SELECTMENUSIMPLE', elementID)
      this.$store.state.itemSubmenuActive = null
      this.removerClassAll()
      $(`#${elementID}`).addClass('active pcoded-trigger')

      this.widthWindows()
    },
    /**
   * @vuese
   * Cierra todos los submenu y abre el actual
   * @arg `elementID` id de elemento
   */
    closeSubmenuAll (elementID) {
      var activeElement = 0
      if ($(`#${elementID}`).hasClass('active pcoded-trigger')) {
        activeElement = 1
      }

      this.removerClassAll()

      if (activeElement == 1) {
        $(`#${elementID}`).addClass(' active pcoded-trigger')
      }
    },
    /**
   * @vuese
   * Muestra u oculta, cuando da clic en opcion de menu que tiene submenu
   * @arg `elementID` id de elemento
   */
    toggleSubmenu (elementID) {
      console.debug('FUNCION TOOGLESUBMENU', elementID)
      this.closeSubmenuAll(elementID)

      if (this.$store.state.toogleSubmenuStatus == 1) {
        $(`#${this.$store.state.submenuActive}`).addClass(' active pcoded-trigger')
        $(`#${this.$store.state.itemSubmenuActive}`).addClass(' active')
        this.$store.state.toogleSubmenuStatus = 0
        return true
      }
      if (this.$store.state.toogleSubmenuStatus == 0) {
        $(`#${elementID}`).toggleClass(' active pcoded-trigger')
        return true
      }
    },
    /**
   * @vuese
   * Activa submenu
   * @arg `elementPabre` id de elemento padre
   * @arg `elementID` id de elemento
   */
    activeSubmenu (elementPadre, elementID) {
      console.debug('FUNCION ACTIVESUBMENU', elementPadre, elementID)
      this.$store.state.toogleSubmenuStatus = 1

      this.$store.state.submenuActive = elementPadre
      this.$store.state.itemSubmenuActive = elementID
      $(`#${elementPadre}`).addClass(' active pcoded-trigger')
      $(`#${elementID}`).addClass(' active')

      // this.$store.state.topMenu = 10
      this.widthWindows()
    },
    /**
   * @vuese
   * Obtiene tamaño de la pantalla para establecer el tamaño del contenedor del contenido
   */
    widthWindows () {
      var windowWidth = $(window).width()
      var menuSmallMaxWidth = 991
      var menuSmallHeight = 70
      var fixWindowWidthCalculation = 100
      var top
      var left
      var zIndex
      console.debug($(window).width(), $(window).height(), 'windowWidth', windowWidth, 'fixWindowWidthCalculation', fixWindowWidthCalculation, 'menuSmallMaxWidth', menuSmallMaxWidth)
      if (windowWidth > menuSmallMaxWidth) {
        console.debug('pantalla grande menu')
        top = 10

        if ($('#navPrincipal').hasClass('navbar-collapsed')) {
          left = 80
        } else {
          left = 264
        }

        //  left = $('#navPrincipal').width()
        zIndex = -1
      } else {
        console.debug('pantalla chica menu')
        top = 80
        left = 0
        zIndex = 1
      }

      if ($(`#localizacion`).hasClass('active')) {
        top = 0
      }
      this.$store.state.widthMenu = left
      this.$store.state.topMenu = top

      console.debug('NAVBAR_left', left, 'top', top, 'zindex', zIndex)

      $('#header_menu').css({ 'z-index': zIndex })
      $('#containerPrincipal').css({ 'margin-left': left })
      $('#containerPrincipal').css({ 'margin-top': top })

      // event bus dimenciones mapa
      EventBus.$emit('App_resizeMap', 1)

      window.scrollTo(0, 0)

      // $('#containerPrincipal').animate({ scrollTop: $('#containerPrincipal').prop('scrollHeight') }, 1000)
      // $('#containerPrincipal').scrollTop($('#containerPrincipal')[0].scrollHeight)

      EventBus.$emit('resizeMapBus', 1)
    },

    /**
   * @vuese
   * se suscribe a eventos eventBus para actulizar el listado de gps
   */
    suscribeToDeviceEvents () {
      EventBus.$on('NAVBAR_MenuSimple', (id) => {
        this.selectMenuSimple(id)
      })
      EventBus.$on('NAVBAR_MenuOpciones', (id, subm) => {
        this.toggleSubmenu(id)
        this.activeSubmenu(id, subm)
      })
      EventBus.$on('cambioLogo_navbar', (data) => {
        this.Getlogo = data
      })
    },
    /**
   * @vuese
   * Se destruye la suscripcion al eventBus
   */
    unsuscribreToDeviceEvents () {
      EventBus.$off('NAVBAR_MenuSimple')
      EventBus.$off('NAVBAR_MenuOpciones')
      EventBus.$off('cambioLogo_navbar')
    },
    /**
   * @vuese
   * Cierra sesion de la plataforma
   */
    async logout () {
      Vue.prototype.$disconnect()
      await this.$store.dispatch('LogOut')
      var user = localStorage.getItem('StringName')
      console.debug('LOGIN_OUT', user)
      if (user == 'gps infinity') {
        await this.$router.push('/')
      } else {
        await this.$router.push('/platform/' + user)
      }
    }
  },
  computed: {
    sizeWindows () {
      return $(window)[0].innerWidth
    },
    showDasboard () {
      return this.$store.state.showDasboard
    },
    logoGet () {
      return this.Getlogo
    }

  }
}
</script>

<style>

/*NOTE: 29-Jul-19 by Noe Aviles
A pesar de que estas clases (.pcoded) estan definidas
en el css del css/template cuando se compila el proyecto para distribucion
parece no funcionar, es por ello que es requerido ponerlas tambien aqui para
que funcionen*/
.pcoded-navbar.navbar-collapsed .active.pcoded-trigger {
  width: 80px !important;
}
.pcoded-navbar.navbar-collapsed:hover .active.pcoded-trigger {
  width: 264px !important;
}
.pcoded-navbar.navbar-collapsed .active {
  width: 80px;
  height: 100%;
  -webkit-transition: all 0.3s ease-in-out;
  transition: all 0.3s ease-in-out;

}
.pcoded-navbar.navbar-collapsed:hover .active {
  width: 264px;
  height: 100%;
  -webkit-transition: all 0.3s ease-in-out;
  transition: all 0.3s ease-in-out;

}

#Classession:hover{
  color: #1dc4e9
}

#textSession:hover{
  /* quitar style de texto */
}

.session-collapsee {
  display:none;
}

.session-collapsea{
  padding-left:25px !important;
}

.session-nocollapsea{
  padding-left:15px !important;
}
</style>
