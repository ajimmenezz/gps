<template>
  <div class=" row">

   <div class="col-12"> <h5 class="float-left" style="font-size: 20px; padding-bottom: 10px;"><b>Resumen almacenes</b></h5></div>

    <div class=" col-12">

      <div class="card ">
            <div class="card-header ">

                   <div class="row">
                     <div class="col-6 float-left" >
                       <h5 v-if="this.idCliente!=0">Almacén del cliente <b> {{this.nameCliente}}</b></h5>
                       <h5 v-else >Mi almacén </h5>
                     </div>

                     <div class="col-6 float-right">
                        <button id="1" class="btn btn-secondary shadow-2 mb-4 float-right" @click="cancel()" >REGRESAR</button>
                        <div class="btn-group mb-2 mr-2">
                            <!-- <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">NUEVO</button>
                            <div class="dropdown-menu">

                              <span class="dropdown-item" @click="registerModal(1)">Gps</span>
                              <span class="dropdown-item" @click="registerModal(2)">Sim</span>
                              <span class="dropdown-item" @click="registerModal(3)">Producto genérico</span>

                            </div> -->
                              <button  type="button" class="btn btn-primary float-right  shadow-2 mb-4 cssToolTipp" @click="registerModal()">NUEVO
                                <p style="top: 25px !important; right: 10% !important;">Registrar producto</p>

                              </button>
                        </div>
                     </div>

                    <div class="col-md-5 " v-if="!this.$store.state.typeDevice.mobile"></div>
                     <div class="col-3 col-md-2 float-right" style="margin-top:10px;" v-if="!this.$store.state.typeDevice.mobile">Filtrar por: </div>
                      <div class="col-5 col-md-3 form-group" v-if="!this.$store.state.typeDevice.mobile">
                        <select class="form-control" id="filtro" v-model="filtro" :valor="filtro"  required>
                          <option value=0 v-if="this.$store.getters.permission(9) || this.$store.getters.permission(10) || this.$store.getters.permission(17)">Ver todo</option>

                             <option value=1 v-if="this.$store.getters.permission(9)">Gps</option>
                                <option value=2  v-if="this.$store.getters.permission(10)">Sims</option>
                                <option value=3 v-if="this.$store.getters.permission(17)">Producto genéricos</option>
                        </select>
                      </div>
                      <div class="col-2 " style="padding:2px;" v-if="!this.$store.state.typeDevice.mobile">
                        <button class="btn btn-primary shadow-2 mb-4 float-left" @click="loadView()">FILTRAR</button>
                      </div>

                    <div class="col-4 float-left" style="margin-top:10px;" v-if="this.$store.state.typeDevice.mobile">Filtrar por: </div>
                      <div class="col-8 form-group " v-if="this.$store.state.typeDevice.mobile">
                        <select class="form-control flaot-right" id="filtro" v-model="filtro" :valor="filtro"  required>
                          <option value=0 v-if="this.$store.getters.permission(9) || this.$store.getters.permission(10) || this.$store.getters.permission(17)">Ver todo</option>

                             <option value=1 v-if="this.$store.getters.permission(9)">Gps</option>
                                <option value=2  v-if="this.$store.getters.permission(10)">Sims</option>
                                <option value=3 v-if="this.$store.getters.permission(17)">Producto genéricos</option>
                        </select>
                      </div>
                      <div class="col-12 float-right" style="padding:2px;" v-if="this.$store.state.typeDevice.mobile">
                        <button class="btn btn-primary float-right shadow-2 mb-4 float-left" @click="loadView()">FILTRAR</button>
                      </div>
                    </div>

            </div>
            <div class="card-body row">

              <div class="col-12" v-if="visible">
                  <component :is='dynamicComponent.component' ></component>
              </div>
            </div>

      </div>

    </div>

  </div>
</template>

<script>
import { API } from '@/mixins/API'
import { functions } from '@/mixins/Functions'
import FormPrincipal from '@/views/Administrador/FormPrincipalRegister'
import cModalDelete from '@/views/Administrador/DeleteModal'
import EventBus from '@/EventBus'
/**
 * @vuese
 * @group Administrador/almacen
 * pantalla principal, de almacen card
 */
export default {
  name: 'DashboardAlm',
  mixins: { functions, API },

  data () {
    return {
      idCliente: this.$route.params.id,
      nameCliente: this.$route.params.name,
      dynamicComponent: {
        component: null,
        properties: null,
        events: {

        }
      },
      dynamicComponentName: null,
      filtro: 0,
      visible: false

    }
  },
  components: {
    cModalDelete
  },
  created () {
    this.loadView()
    // this.loadDefault()
  },
  async mounted () {
    this.$store.state.seccionMenu = 'almacen'
    await EventBus.$emit('NAVBAR_MenuSimple', 'almacen')
    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })
  },
  methods: {
    /**
   * @vuese
   * Abre modal de formulario indicado
   */

    // funcion anterior
    // async registerModal (opc) {
    //   this.$store.state.loader = true

    //   var datos = {}

    //   if (opc == 2) {
    //     datos = {
    //       'component': FormSims,
    //       'datos': {
    //         'seccion': 'sims',
    //         'accion': 'nueva',
    //         'idCliente': this.idCliente,
    //         'nameClient': this.nameCliente

    //       }
    //     }
    //   }
    //   if (opc == 1) {
    //     datos = {
    //       'component': FormGPS,
    //       'datos': {
    //         'seccion': 'gps',
    //         'accion': 'nuevo',
    //         'idCliente': this.idCliente,
    //         'nameClient': this.nameCliente

    //       }
    //     }
    //   }
    //   if (opc == 3) {
    //     datos = {
    //       'component': FormProduct,
    //       'datos': {
    //         'seccion': 'product',
    //         'accion': 'nuevo',
    //         'idCliente': this.idCliente,
    //         'nameClient': this.nameCliente

    //       }
    //     }
    //   }

    //   console.debug(datos, this.idCliente)

    //   await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)
    //   await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
    // },
    // fin funcion anterior

    async registerModal () {
      this.$store.state.loader = true
      this.$store.commit('CLEAR_MODAL_DINAMIC')

      var datos = {}

      datos = {
        'component': FormPrincipal,
        'datos': {
          'accion': 'nuevo',
          'idCliente': this.idCliente,
          'nameClient': this.nameCliente
        }
      }

      console.debug(datos, this.idCliente)

      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)
      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
    },
    /**
   * @vuese
   * carga la vista de filtro indicado
   */
    loadView () {
      EventBus.$emit('funMenuSimple', 'almacen')
      this.clearComponentsDinamic()
      this.$store.state.StoreCliente = this.idCliente
      this.$store.state.StoreNameCliente = this.nameCliente
      this.$store.state.modal.datosDymanic.idCliente = this.idCliente
      this.$store.state.modal.datosDymanic.nameClient = this.nameCliente
      console.debug('loadView', this.filtro, this.idCliente)
      var opc = parseFloat(this.filtro)
      console.debug(opc)
      switch (opc) {
        case 0: // todo
          console.debug('case0')
          this.dynamicComponentName = 'todo'

          this.dynamicComponent.component = () => import('@/views/Administrador/dashboardAlmacenGraph.vue')
          console.debug('case000')
          break
        case 1: // gps
          console.debug('case1')
          this.dynamicComponentName = 'gps'
          this.dynamicComponent.component = () => import('@/views/Administrador/gps/tablesorter_Gps.vue')
          break
        case 2: // sims
          console.debug('case2')
          this.dynamicComponentName = 'sims'
          this.dynamicComponent.component = () => import('@/views/Administrador/sims/tablesorter_Sims.vue')
          break
        case 3: // productoG
          console.debug('case3')
          this.dynamicComponentName = 'productG'
          this.dynamicComponent.component = () => import('@/views/Administrador/productos/tablesorter_Product.vue')
          break
      }
      this.visible = true
    },
    loadDefault () {
      console.debug('loadDefault')
      this.clearComponentsDinamic()

      this.dynamicComponent.component = () => import('@/views/Administrador/dashboardAlmacenGraph.vue')
      this.visible = true
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
   * cancela el proceso y regresa una pagina anterior
   */
    cancel () {
      this.$router.push('/store')
    }

  },
  computed: {

  }
}
</script>

<style>

</style>
