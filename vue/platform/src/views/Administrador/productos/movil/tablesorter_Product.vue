<template>
  <div class=" row " >
      <div class="col-12"> <h5 class="float-left" style="font-size: 20px; padding-bottom: 10px;"><b>Productos genéricos</b></h5></div>

      <div class=" col-12">
        <!-- <div class="card">
          <div class="card-header row">
              <div class="col-9">
              <h5 class=" float-left">Lista gps</h5>
              </div>

              <div class="col-3" style="height: 30px;">

                  <button  type="button" class="btn btn-primary float-right btn-sm" @click="modalFormGps()">NUEVO</button>

              </div>
            </div>
            <div class="card-body"> -->

              <div class="table-responsive scrollTable">
                  <table  class="table table-hover header_fijo">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th>Serial</th>
                              <th>Marca</th>
                              <th>Modelo</th>
                              <th>Fecha de creación</th>
                              <th>Acciones</th>
                          </tr>
                      </thead>
                      <tbody>
                            <tr v-for="(product,index) in listProduct" :key="product.id">
                                <td>{{index+1}}</td>
                                <td>{{product.serial}}</td>
                                <td>{{product.factoryName}}</td>
                                <td>{{product.modelName}}</td>
                                <td > {{product.creationTimestamp* 1000 | moment("DD MMMM YYYY") }}</td>
                                <td>
                                    <span class="cursor" >
                                      <i v-if="getClientID==0" class="icon icon-md universalicon-pencil cursor cssToolTipp" @click="modalFormProductEdit(product.id)"><p style="top: 25px !important; right: -70% !important;">Editar producto</p>
</i>
                                      <i v-if="getClientID!=0" class="icon icon-md universalicon-visible cursor cssToolTipp" @click="modalFormProductEdit(product.id)"><p style="top: 25px !important; right: -70% !important;">Consultar producto</p>
</i>
                                      </span>
                                    <span v-if="getClientID==0" @click="eliminar(product.id,product.serial)"><i class="cursor icon-small icon universalicon-trash-2 colorText-red cssToolTipp"><p style="top: 25px !important; right: -70% !important;">Eliminar producto</p>
</i></span>
                                </td>
                            </tr>

                      </tbody>
                      <!-- <tfoot>
                          <tr>
                              <th>Name</th>
                              <th>Position</th>
                              <th>Office</th>
                              <th>Age</th>
                              <th>Start date</th>
                              <th>Salary</th>
                          </tr>
                      </tfoot> -->
                  </table>
              </div>
<!--
            </div>
        </div> -->

      </div>

  </div>
</template>

<script>
import { API } from '@/mixins/API'
// import FormProduct from '@/views/Administrador/productos/formProduc'
import FormPrincipal from '@/views/Administrador/FormPrincipalRegister'
import cModalDelete from '@/views/Administrador/DeleteModal'
import EventBus from '@/EventBus'
/**
 * @vuese
 * @group Administrador/Distribuidor
 * Tabla de productos generico
 */
export default {
  name: 'tablaProductos',
  mixins: [API],
  data () {
    return {
      listProduct: null
    }
  },
  components: {
    cModalDelete
  },
  created () {
    this.$store.state.StoreCliente = this.$store.state.modal.datosDymanic.idCliente
    this.getProduct()
  },
  mounted () {
    this.$store.state.seccionMenu = 'adminGps'
    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })
    this.suscribeToDeviceEvents()
  },
  beforeDestroy () {
    this.unsuscribreToDeviceEvents()
  },
  methods: {
    /**
   * @vuese
   * obtiene la lista de gps en almacen
   */
    async getProduct () {
      if (this.$store.state.StoreCliente == 0) {
        var request = await this.getRequest('products/generic')

        if (request.success === true) {
          this.listProduct = request.data.products
        }
      } else {
        var dato = {
          'clientID': this.$store.state.StoreCliente
        }
        var request = await this.getRequest('products/generic', dato)

        if (request.success === true) {
          this.listProduct = request.data.products
        }
      }
    },

    /**
   * @vuese
   * Abre el modal para editar el gps
   * @arg `id` Id de gps
   */
    async modalFormProductEdit (id) {
      this.$store.state.loader = true
      this.$store.commit('CLEAR_MODAL_DINAMIC')

      var datos = {
        'component': FormPrincipal,
        'datos': {
          'seccion': 'product',
          'accion': 'editar',
          'id': id

        }
      }

      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)
      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
    },
    /**
   * @vuese
   * Abre el modal de confirmacion para eliminar el producto
   * @arg `id` Id de producto
  * @arg `name` Nombre de gps
   */
    async eliminar (id, name) {
      this.$store.commit('CLEAR_MODAL_DINAMIC')

      var datos = {
        'component': cModalDelete,
        'datos': {
          'ID': id,
          'name': name,
          'tipo': 'product'
        }
      }
      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)
      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
    },
    /**
   * @vuese
   * se suscribe a eventos eventBus para actulizar el listado de gps
   */
    suscribeToDeviceEvents () {
      EventBus.$on('GET_LIST_products', (tipo) => {
        this.getProduct()
      })
    },
    /**
   * @vuese
   * Se destruye la suscripcion al eventBus
   */
    unsuscribreToDeviceEvents () {
      EventBus.$off('GET_LIST_products')
    }
  },
  computed: {
    getClientID () {
      return this.$store.state.StoreCliente
    }

  }
}
</script>

<style>
.scrollTable{
  position: relative;
    overflow: auto;
    height: 293px;
    /* height: 480px; */
    width: 100%;
}
</style>
