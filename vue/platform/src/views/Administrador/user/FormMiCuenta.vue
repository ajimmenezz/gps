<template>
    <div class="row m-r-10" >

        <div class="col-12" >

            <div class="row">
              <div class="col-12">
                <h5 class="float-left" style="font-size: 20px; padding-bottom: 10px;" >Mi cuenta</h5>

              </div>
              <div class="col-6" v-if="!this.$store.state.typeDevice.mobile">  <p  class="text-muted" style="text-align: justify; font-size: 12px; margin-top: -17px;">
                  A continuación podrás consultar y modificar tus datos legales</p>
              </div>
              <div v-if="!this.$store.state.typeDevice.mobile" class="col-6 float-right" style=" font-size: 12px; margin-top: -18px;">Nombre de la cuenta: <b >{{cuenta}}</b>
              </div>

               <div class="col-12" v-if="this.$store.state.typeDevice.mobile">  <p  class="text-muted" style="text-align: justify; font-size: 12px; margin-top: -10px;">
                  A continuación podrás consultar y modificar tus datos legales</p>
              </div>
              <div v-if="this.$store.state.typeDevice.mobile" class="col-12 float-right" style=" font-size: 12px; margin-top: -18px;"> <b >{{cuenta}}</b>
              </div>

             <!-- <hr v-if="!this.$store.state.typeDevice.mobile" style="margin-top: -10px; margin-bottom:20px; width:100%;">
              <hr v-if="this.$store.state.typeDevice.mobile" style="margin-top: 8px; margin-bottom:20px; width:100%;"> -->
            </div>
             <hr v-if="!this.$store.state.typeDevice.mobile" style="margin-top: -10px; margin-bottom:20px; width:100%;">
              <hr v-if="this.$store.state.typeDevice.mobile" style="margin-top: 8px; margin-bottom:20px; width:100%;">

        </div>

        <div class="col-12">

                   <!-- <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a  style=" box-shadow: none;" class="nav-link active text-uppercase" id="legales-tab" data-toggle="tab" href="#legales" role="tab" aria-controls="legales" aria-selected="true">Datos legales</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase" id="contactos-tab" data-toggle="tab" href="#contactos" role="tab" aria-controls="contactos" aria-selected="false">Contactos</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase" id="logotipo-tab" data-toggle="tab" href="#logotipo" role="tab" aria-controls="logotipo" aria-selected="false">Logotipo</a>
                                        </li>
                                    </ul> -->

                                       <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item cursor" @click="showOptionTab(1)">
                                            <a class="nav-link active text-uppercase" id="legales-tab" data-toggle="tab"  role="tab" aria-controls="legales" aria-selected="true">Datos legales</a>
                                        </li>
                                        <li class="nav-item cursor" @click="showOptionTab(2)">
                                            <a class="nav-link text-uppercase" id="contactos-tab" data-toggle="tab" role="tab" aria-controls="contactos" aria-selected="false">Contactos</a>
                                        </li>
                                        <li class="nav-item cursor"  v-if="getPermissionDistribuidor" @click="showOptionTab(3)">
                                            <a class="nav-link text-uppercase" id="logotipo-ta" data-toggle="tab"  role="tab" aria-controls="logotipo" aria-selected="false">Logotipo</a>
                                        </li>
                                    </ul>

                <div class="card float-left" style=" box-shadow: none; width: 100%;">
                    <!-- <form @submit.prevent > -->

                        <component :is='dynamicComponent.component'   v-if="visible" ></component>

                    <!-- </form> -->
                </div>

        </div>

    </div>
</template>

<script>
import { API } from '@/mixins/API'
import { Functions } from '@/mixins/Functions.js'
import EventBus from '@/EventBus.js'
/**
 * @vuese
 * @group Administrador/Distribuidor/Cliente
 * Formulario para crear distribuidor/Cliente
 */

export default {
  name: 'FormDistribuidorClientet',
  mixins: [API, Functions],
  components: {

  },
  data () {
    return {
      cuenta: null,
      email: null,
      statusLegal: '',
      labelLegal: null,
      labelRFC: null,
      nameLegal: null,
      rfc: null,
      pais: null,
      region: null,
      codep: null,
      notas: '',
      contactos: [],
      contactosFine: [],
      addres: null,
      catLegalStatus: [],
      catTipoContact: [],
      id: 0,
      seccion: this.$route.params.id,
      title: null,
      zonaH: 14,
      listZonaHoraria: [],
      visabled: true,
      accionT: this.$store.state.modal.datosDymanic.accion,
      active: null,
      setDisabled: true,
      idCliente: null,
      resultado: false,
      idInp: 'input',
      files: [],
      Getlogo: localStorage.getItem('imgLogo'),
      optionTab: 1,
      dynamicComponent: {
        component: null,
        properties: null,
        events: {

        }
      },
      visible: false

    }
  },
  provide () {
    return {
      // getDraggableProperties: this.getDraggablePropertiesTable,
      // dataGraph: this.getDataGraph,
      // getDraggablePropertiesDevice: this.getDraggablePropertiesDevice,
      // getDraggablePropertiesUser: this.getDraggablePropertiesUser

    }
  },
  async created () {
    this.$store.state.loader = true
  },
  async mounted () {
    // [ Responsive-table ] start
    var left = this.$store.state.widthMenu + 10
    $('#containerPrincipal').css({ 'margin-left': left })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })

    await EventBus.$emit('NAVBAR_MenuSimple', this.$store.state.seccionMenu)

    this.$store.state.submenuActive = 'config'
    this.$store.state.itemSubmenuActive = 'itemPerfil'
    await EventBus.$emit('NAVBAR_MenuOpciones', 'config', 'itemPerfil')

    this.title = ' Mi cuenta'

    this.showOptionTab(1)
    this.suscribeToDeviceEvents()
    this.$store.state.loader = false
  },
  destroyed () {
    this.unsuscribreToDeviceEvents()
  },
  methods: {
    /**
   * @vuese
   * se suscribe a eventos eventBus para actulizar el listado de sims
   */
    suscribeToDeviceEvents () {
      EventBus.$on('legales_getCuenta', (data) => {
        this.cuenta = data
      })
    },
    /**
   * @vuese
   * Se destruye la suscripcion al eventBus
   */
    unsuscribreToDeviceEvents () {
      EventBus.$off('legales_getCuenta')
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
    },
    /**
   * @vuese
   * Muestra contenido formulario de reportes
   */
    async showOptionTab (item) {
      console.debug('SHOWCONTENT', item)
      this.visible = false
      this.$store.state.loader = true
      this.clearComponentsDinamic()

      var opc = parseFloat(item)
      console.debug(opc)

      this.optionTab = opc
      switch (opc) {
        case 1: // legales
          console.debug('case1')
          this.dynamicComponentName = 'legales'
          this.dynamicComponent.component = () => import('@/views/Administrador/user/legales.vue')

          break
        case 2: // tabla

          console.debug('case2')
          this.dynamicComponentName = 'tabla'

          this.dynamicComponent.component = () => import('@/views/Administrador/user/dataTable.vue')

          break
        case 3: // logo
          console.debug('case3')
          this.dynamicComponentName = 'logo'
          this.dynamicComponent.component = () => import('@/views/Administrador/user/logoDistribuidor.vue')

          break
      }
      this.visible = true
    }

  },
  computed: {
    getPermissionDistribuidor () {
      var tipoUser = sessionStorage.UT
      var tipoClient = sessionStorage.TC

      if (tipoUser == 2) { // asociado
        if (tipoClient == 2) { // dist/asociado
          return true
        } else { // sub admin, dist, cliente
          return false
        }
      } else { // cliente, distribuidor, admin
        if (tipoUser == 3) { // dist
          return true
        } else {
          return false
        }
      }
    },
    Getdisabled () {
      return this.setDisabled
    },
    getShowTable () {
      return this.resultado
    },
    getContactos () {
      return this.contactos
    },
    isEmptyContacts () {
      return $.isEmptyObject(this.contactos)
    },
    logoGet () {
      return this.Getlogo
    }
  }
}

</script>

<style scoped>
.toupperCase{
  text-transform: uppercase;
}
.btn-file {
  position: relative;
  overflow: hidden;
}
.btn-file input[type=file] {
  position: absolute;
  top: 0;
  right: 0;
  min-width: 100%;
  min-height: 100%;
  font-size: 100px;
  text-align: right;
  filter: alpha(opacity=0);
  opacity: 0;
  outline: none;
  background: white;
  cursor: inherit;
  display: block;
}

div.dt-buttons.btn-group{
    float: left;
    text-align: left;
}

/* div.dataTables_scrollHeadInner:after {
    width: unset !important;
}

div.dataTables_scrollHeadInner table{
  width:100% !important;
} */

/* .nav-link{
  height: 70px;
}

.nav-link.active{
    box-shadow: none;
    border-bottom: solid 3px #04a9f5;
}

.nav-tabs{
  border-bottom: 1px solid #dee2e6;
} */
</style>
