<template>
  <div class=" row " >
      <div class="col-12"> <h5 class="float-left" style="font-size: 20px; padding-bottom: 10px;"><b>Sims</b></h5></div>

      <div class=" col-12 float-left">
            <data-table ref="table"
                    @OnWatch="OnWatch"
                    @OnEdit="OnEdit"
                    @OnDelete="OnDelete"

                    :showEditButton="onEditVisible"
                    :showWatchButton="onVisible"
                    :showDeleteButton="ondeleteVisible"
                    :showActiveButton="false"
                      :showIndex="true"
                />

      </div>

  </div>
</template>

<script>
import { API } from '@/mixins/API'
// import FormSims from '@/views/Administrador/sims/FormSims'
import FormPrincipal from '@/views/Administrador/FormPrincipalRegister'
import cModalDelete from '@/views/Administrador/DeleteModal'
import EventBus from '@/EventBus'
import dataTable from '@/components/DataTable/DataTable'
/**
 * @vuese
 * @group Administrador/Distribuidor
 * Tabla de sims
 */
export default {
  name: 'tablaSims',
  mixins: [API],
  data () {
    return {
      listSims: null,
      ondeleteVisible: false,
      onEditVisible: false,
      onVisible: false
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
      this.onVisible = true
    }
    this.getSims()
  },
  mounted () {
    this.$store.state.seccionMenu = 'adminSims'
    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })
    this.suscribeToDeviceEvents()
  },
  beforeDestroy () {
    this.unsuscribreToDeviceEvents()
  },
  methods: {
    async getListSims () {
      if (this.$store.state.StoreCliente == 0) {
        var request = await this.getRequest('sims/store')

        if (request.success === true) {
          this.listSims = request.data.sims
        }
      } else {
        var dato = {
          'clientID': this.$store.state.StoreCliente
        }
        var request = await this.getRequest('sims/store', dato)

        if (request.success === true) {
          this.listSims = request.data.sims
        }
      }
    },
    /**
   * @vuese
   * Obtiene la lista de las sims que estan en almacen
   */
    async getSims () {
      if (this.$store.state.StoreCliente == 0) {
        var request = await this.getRequest('sims/store')

        if (request.success === true) {
          this.listSims = request.data.sims
        }
      } else {
        var dato = {
          'clientID': this.$store.state.StoreCliente
        }
        var request = await this.getRequest('sims/store', dato)

        if (request.success === true) {
          this.listSims = request.data.sims
        }
      }
      await this.changeHeaderTable()
    },
    changeHeaderTable () {
      this.headers = [
        {
          title: 'Teléfono',
          key: 'phone',
          default: ''

        },
        {
          title: 'Compañia teléfonica',
          key: 'carrierName',
          default: '-',
          priority: 1
        },
        {
          title: 'Fecha de creación',
          key: 'creationTime',
          default: '-',
          priority: 5
        }

      ]

      this.listSims.forEach(element => {
        if (element.creationTime) {
          element.creationTime = moment(element.creationTime * 1000).format('DD-MM-YYYY')
        }
      })

      console.debug(this.listSims, 'DATOS_list')
      this.rows = this.listSims
      console.debug('DATOS_ROWS', this.rows)
      this.$refs.table.Render(this.headers, this.rows)
      this.Refresh()
    },
    Refresh () {
      console.debug('data_REFRESH')
      this.$refs.table.Refresh()
    },
    OnWatch (item, sender) {
      console.debug(`WATCH: ${item.imei} ${item.alias}`)

      this.modalEdit(item)
    },
    OnEdit (item, sender) {
      console.debug(`onEdit: ${item.imei} ${item.alias}`)
      this.modalEdit(item, 2, sender)
    },
    OnDelete (item, sender) {
      console.debug(`DELETE: ${item.phone} ${item.id} `)
      console.debug('DELETE row', sender, item)

      this.eliminar(item, sender)
    },
    /**
   * @vuese
   * Abre el modal para registrar sims
   */
    async modalFormSims () {
      this.$store.state.loader = true
      this.$store.commit('CLEAR_MODAL_DINAMIC')

      var datos = {
        'component': FormSims,
        'datos': {
          'seccion': 'sims',
          'accion': 'nueva'

        }
      }

      console.debug(datos)

      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)
      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
    },
    /**
   * @vuese
   * Abre el modal para editar sims
   * @arg `id` Id de sims
   */
    async modalEdit (item, accion = 1, sender = null) {
      console.debug('MODALEDIT', item, accion, sender)
      this.$store.state.loader = true
      this.$store.commit('CLEAR_MODAL_DINAMIC')
      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', false)

      var datos = {
        'component': FormPrincipal,
        'datos': {
          'seccion': 'sims',
          'accion': 'editar',
          'id': item.id,
          'item': item

        }

      }

      if (accion == 2) {
        datos.datos.sender = sender
      }

      console.debug('MODAL_OPEN_EDIT', datos)
      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)
      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
    },
    async editarSims (data) {
      console.debug('DATOS', data.datos)

      var request = await this.putRequest('sims/' + data.item.id, data.datos)

      if (request.success === true) {
        this.$store.state.loader = false
        if (this.$store.state.StoreCliente == 0) {
          var request = await this.getRequest('sims/store')

          if (request.success === true) {
            this.listSims = request.data.sims
          }
        } else {
          var dato = {
            'clientID': this.$store.state.StoreCliente
          }
          var request = await this.getRequest('sims/store', dato)

          if (request.success === true) {
            this.listSims = request.data.sims
          }
        }

        var dat

        this.listSims.filter(function (dato, i) {
          console.debug('ITEM', dato, i)
          if (data.item.id == dato.id) {
            data.item = dato
          }
        })

        await this.$refs.table.RemoveRow(data.sender)
        console.debug('DATOS_FIn', data, dat)

        await this.$refs.table.AddRow(data.item)
        notify('Excelente!', 'Se ha editado la sims ', 'top', 'right', 'success', 10, 50)
      } else {
        this.$store.state.loader = false
        notify('Error!', 'No se ha editado la sims ', 'top', 'right', 'danger', 10, 50)
      }
    },
    /**
   * @vuese
   * Abre el modal de confirmacion para eliminar sims
   * @arg `id` Id de sims
  * @arg `tel` telefono sims
   */
    async eliminar (item, sender) {
      this.$store.commit('CLEAR_MODAL_DINAMIC')

      var datos = {
        'component': cModalDelete,
        'datos': {
          'ID': item.id,
          'name': item.phone,
          'tipo': 'sims',
          'item': item,
          'sender': sender
        }
      }
      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)
      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
    },
    async eliminarSims (data) {
      var simsID = data.id

      var request = await this.deleteRequest('sims/store/' + simsID)

      if (request.success === true) {
        this.$refs.table.RemoveRow(data.sender)
        this.getListSims()
        this.$store.state.loader = false
        notify('Excelente!', 'Se ha eliminado la sims ', 'top', 'right', 'success', 10, 50)
      } else {
        this.$store.state.loader = false
        notify('Error!', 'No se ha eliminado la sims ', 'top', 'right', 'danger', 10, 50)
      }
    },
    /**
   * @vuese
   * se suscribe a eventos eventBus para actulizar el listado de sims
   */
    suscribeToDeviceEvents () {
      EventBus.$on('editar_sims', (data) => {
        console.debug('EDITAR_SIMS', data)
        this.editarSims(data)
      })
      EventBus.$on('eliminar_sims', (data) => {
        console.debug('ELIMINAR_SIMS', data)
        this.eliminarSims(data)
      })
    },
    /**
   * @vuese
   * Se destruye la suscripcion al eventBus
   */
    unsuscribreToDeviceEvents () {
      EventBus.$off('editar_sims')
      EventBus.$off('eliminar_sims')
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
