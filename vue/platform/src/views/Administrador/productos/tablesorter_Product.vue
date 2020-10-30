<template>
  <div class="row" >
      <div class="col-12"> <h5 class="float-left" style="font-size: 20px; padding-bottom: 10px;"><b>Productos genéricos</b></h5></div>

      <div class=" col-12 float-left">
           <data-table ref="table"
                    @OnWatch="OnWatch"
                    @OnEdit="OnEdit"
                    @OnDelete="OnDelete"

                    :showEditButton="onEditVisible"
                    :showWatchButton="onWatchVisible"
                    :showDeleteButton="ondeleteVisible"
                    :showActiveButton="false"
                      :showIndex="true"
                />
      </div>

  </div>
</template>

<script>
import { API } from '@/mixins/API'
// import FormProduct from '@/views/Administrador/productos/formProduc'
import FormPrincipal from '@/views/Administrador/FormPrincipalRegister'
import cModalDelete from '@/views/Administrador/DeleteModal'
import EventBus from '@/EventBus'
import dataTable from '@/components/DataTable/DataTable'
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
      listProduct: null,
      onWatchVisible: false,
      onEditVisible: false,
      ondeleteVisible: false
    }
  },
  components: {
    cModalDelete,
    dataTable
  },
  created () {
    this.$store.state.StoreCliente = this.$store.state.modal.datosDymanic.idCliente
    if (this.getClientID == 0) {
      this.ondeleteVisible = true
      this.onEditVisible = true
    }
    if (this.getClientID != 0) {
      this.onWatchVisible = true
    }
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
    async getListProduct () {
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

      await this.changeHeaderTable()
    },
    changeHeaderTable () {
      this.headers = [
        // {
        //   title: '#',
        //   key: 'index',
        //   default: ''
        // },
        {
          title: 'Serial',
          key: 'serial',
          default: ''

        },
        {
          title: 'Marca',
          key: 'factoryName',
          default: '-',
          priority: 1
        },
        {
          title: 'Modelo',
          key: 'modelName',
          default: '-'

        },
        {
          title: 'Fecha de creación',
          key: 'creationTimestamp',
          default: '-',
          priority: 5
        }

      ]

      this.listProduct.forEach(element => {
        if (element.creationTimestamp) {
          element.creationTimestamp = moment(element.creationTimestamp * 1000).format('DD-MM-YYYY')
        }
      })

      console.debug(this.listProduct, 'DATOS_list')
      this.rows = this.listProduct
      console.debug('DATOS_ROWS', this.rows)
      this.$refs.table.Render(this.headers, this.rows)
      this.Refresh()
    },
    Refresh () {
      console.debug('data_REFRESH')
      this.$refs.table.Refresh()
    },
    OnWatch (item, sender) {
      console.debug(`WATCH: ${item.id} ${item.serial}`)
      this.modalFormProductEdit(item, sender)
    },
    OnEdit (item, sender) {
      console.debug(`onEdit: ${item.id} ${item.serial}`)
      this.modalFormProductEdit(item, sender)
    },
    OnDelete (item, sender) {
      console.debug(`DELETE: ${item.id} ${item.serial} `)
      console.debug('DELETE row', sender, item)
      this.eliminar(item, sender)
    },

    /**
   * @vuese
   * Abre el modal para editar el producto
   * @arg `id` Id de producto
   */
    async modalFormProductEdit (item, sender) {
      this.$store.state.loader = true
      this.$store.commit('CLEAR_MODAL_DINAMIC')

      var datos = {
        'component': FormPrincipal,
        'datos': {
          'seccion': 'product',
          'accion': 'editar',
          'id': item.id,
          'item': item,
          'sender': sender

        }
      }

      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)
      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
    },
    async editarProducto (data) {
      console.debug('DATOS EDIT', data.datos)

      var request = await this.putRequest('products/generic/' + data.item.id, data.datos)

      if (request.success === true) {
        this.$store.state.loader = false

        this.getListProduct()
        this.$refs.table.RemoveRow(data.sender)
        this.$refs.table.AddRow(data.item)
        notify('Excelente!', 'Se ha editado el producto ', 'top', 'right', 'success', 10, 50)
      } else {
        this.$store.state.loader = false

        var message = ''
        switch (request.error.title) {
          case 'SERIAL_EXISTS':
            message = 'El serial ya existe'
            break
          case 'UNAUTHORIZED':
            message = 'No cuenta con los permisos para realizar la accion'
            break
          default:
            message = 'No se ha actualizado el producto'
            break
        }
        notify('Error!', message, 'top', 'right', 'danger', 10, 50)
      }
    },
    /**
   * @vuese
   * Abre el modal de confirmacion para eliminar el producto
   * @arg `id` Id de producto
  * @arg `name` Nombre de gps
   */
    async eliminar (item, sender) {
      this.$store.commit('CLEAR_MODAL_DINAMIC')

      var datos = {
        'component': cModalDelete,
        'datos': {
          'ID': item.id,
          'name': item.serial,
          'tipo': 'product',
          'item': item,
          'sender': sender
        }
      }
      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)
      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
    },
    async eliminarProducto (data) {
      var productID = data.id

      var request = await this.deleteRequest('products/generic/' + data.id)

      if (request.success === true) {
        this.$store.state.loader = false
        this.$refs.table.RemoveRow(data.sender)
        this.getListProduct()
        notify('Excelente!', 'Se ha eliminado el producto ', 'top', 'right', 'success', 10, 50)
      } else {
        this.$store.state.loader = false
        notify('Error!', 'No se ha eliminado el producto ', 'top', 'right', 'danger', 10, 50)
      }
    },
    /**
   * @vuese
   * se suscribe a eventos eventBus para actulizar el listado de gps
   */
    suscribeToDeviceEvents () {
      EventBus.$on('editar_products', (data) => {
        console.debug('DATOS_EDITPRODUCT', data)
        this.editarProducto(data)
      })
      EventBus.$on('eliminar_products', (data) => {
        console.debug('DATOS_ELIMINARPRODUCT', data)
        this.eliminarProducto(data)
      })
    },
    /**
   * @vuese
   * Se destruye la suscripcion al eventBus
   */
    unsuscribreToDeviceEvents () {
      EventBus.$off('editar_products')
      EventBus.$off('eliminar_products')
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
