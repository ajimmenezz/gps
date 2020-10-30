<template>
  <div class=" row " >
      <div class="col-12"> <h5 class="float-left" style="font-size: 20px; padding-bottom: 10px;"><b>Dispositivos GPS</b></h5></div>

      <div class=" col-12">

                <data-table ref="table"
                                                @OnWatch="OnWatch"
                                                @OnEdit="OnEdit"
                                                @OnDelete="OnDelete"
                                                 @onActive="onActive"
                                                :showEditButton="true"
                                                :showWatchButton="true"
                                                :showDeleteButton="true"
                                                :showActiveButton="false"
                                                 :showIndex="true"
                                            />

<!--
            </div>
        </div> -->

      </div>

  </div>
</template>

<script>
import { API } from '@/mixins/API'
// import FormGPS from '@/views/Administrador/gps/FormGPS'
import FormPrincipal from '@/views/Administrador/FormPrincipalRegister'
import cModalDelete from '@/views/Administrador/DeleteModal'
import EventBus from '@/EventBus'
import FormConsulta from '@/views/Administrador/gps/formConsulta'
import dataTable from '@/components/DataTable/DataTable'
/**
 * @vuese
 * @group Administrador/Distribuidor
 * Tabla de dispositivos gps
 */
export default {
  name: 'tablaGps',
  mixins: [API],
  data () {
    return {
      listDevices: null

    }
  },
  components: {
    cModalDelete,
    dataTable
  },
  created () {
    this.$store.state.StoreCliente = this.$store.state.modal.datosDymanic.idCliente
    this.getDevices()
  },
  mounted () {
    this.$store.state.seccionMenu = 'almacen'
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
    async getDevices () {
      if (this.$store.state.StoreCliente == 0) {
        var request = await this.getRequest('devices/store')

        if (request.success === true) {
          this.listDevices = request.data.devices
        }
      } else {
        var dato = {
          'clientID': this.$store.state.StoreCliente
        }
        var request = await this.getRequest('devices/store', dato)

        if (request.success === true) {
          this.listDevices = request.data.devices
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
          title: 'Imei',
          key: 'imei',
          default: ''

        },
        {
          title: 'Alias',
          key: 'alias',
          default: '-',
          priority: 1
        },
        {
          title: 'Compañia teléfonica',
          key: 'carrier',
          default: '-'

        },
        {
          title: 'Teléfono',
          key: 'phone',
          default: '-',
          priority: 5
        },
        {
          title: 'Fecha de creación',
          key: 'fechaCreacion',
          default: '-',
          priority: 5
        }

      ]

      this.listDevices.forEach(element => {
        if (element.fechaCreacion) {
          element.fechaCreacion = moment(element.fechaCreacion * 1000).format('DD-MM-YYYY')
        }
      })

      console.debug(this.listDevices, 'DATOS_list')
      this.rows = this.listDevices
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
      this.consultar(item.id)
    },
    OnEdit (item, sender) {
      console.debug(`onEdit: ${item.imei} ${item.alias}`)
      this.editar(item.id)
    },
    OnDelete (item, sender) {
      console.debug(`DELETE: ${item.imei} ${item.alias} `)
      console.debug('DELETE row', sender, item)
      this.eliminarModal(item, sender)
    },
    /**
   * @vuese
   * Abre el modal para registrar el gps
   */
    async modalFormGps () {
      this.$store.state.loader = true
      var datos = {
        'component': FormGPS,
        'datos': {
          'seccion': 'gps',
          'accion': 'nuevo'

        }
      }
      this.$store.commit('CLEAR_MODAL_DINAMIC')

      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)
      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
    },
    /**
   * @vuese
   * Abre el modal para editar el gps
   * @arg `id` Id de gps
   */
    async modalFormGpsEdit (id) {
      this.$store.state.loader = true
      this.$store.commit('CLEAR_MODAL_DINAMIC')

      var datos = {
        'component': FormPrincipal,
        'datos': {
          'seccion': 'gps',
          'accion': 'editar',
          'id': id

        }
      }

      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)
      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
      console.debug('MODAL_EDITAR', this.$store.state.modal.datosDymanic.accion, this.$store.state.modal.datosDymanic.seccion)
    },
    /**
   * @vuese
   * Obtiene la informacion del gps
   * @arg `id` Id de usuario
   */
    async consultar (id) {
      this.$store.state.loader = true
      this.$store.commit('CLEAR_MODAL_DINAMIC')

      var datos = {
        'component': FormConsulta,
        'datos': {
          'id': id
        }
      }
      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)
      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
      // this.$router.push({ name: 'FormUsers', params: { id: 2 } })
    },
    /**
   * @vuese
   * Abre el modal de confirmacion para eliminar el gps
   * @arg `id` Id de gps
  * @arg `name` Nombre de gps
   */
    async eliminar (id, name) {
      this.$store.commit('CLEAR_MODAL_DINAMIC')

      var datos = {
        'component': cModalDelete,
        'datos': {
          'ID': id,
          'name': name,
          'tipo': 'gps'
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
      EventBus.$on('GET_LIST_devices', (tipo) => {
        this.getDevices()
      })
    },
    /**
   * @vuese
   * Se destruye la suscripcion al eventBus
   */
    unsuscribreToDeviceEvents () {
      EventBus.$off('GET_LIST_devices')
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
