<template>
  <div class=" row " >
      <div class="col-12"> <h5 class="float-left" style="font-size: 20px; padding-bottom: 10px;"><b>Dispositivos GPS</b></h5></div>

      <div class=" col-12">
      <div class="card">
           <div class="card-header row">
              <div class="col-9">
              <h5 class=" float-left">Lista gps</h5>
              </div>

              <div class="col-3" style="height: 30px;">

                  <button  type="button" class="btn btn-primary float-right btn-sm" @click="modalFormGps()">NUEVO</button>

              </div>
            </div>
            <div class="card-body">

              <div class="table-responsive scrollTable">
                  <table  class="table table-hover header_fijo">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th>IMEI</th>
                              <th>Alias</th>
                              <th>Fecha de creación</th>
                              <th>Acciones</th>
                          </tr>
                      </thead>
                      <tbody>
                            <tr v-for="(device,index) in listDevices" :key="device.id">
                                <td>{{index+1}}</td>
                                <td>{{device.imei}}</td>
                                <td>{{device.alias}}</td>
                                <td > {{device.fechaCreacion* 1000 | moment("DD MMMM YYYY") }}</td>
                                <td>
                                    <span class="cursor" ><i class="icon icon-md universalicon-pencil cursor" @click="modalFormGpsEdit(device.id)"></i></span>
                                    <span @click="eliminar(device.id,device.imei)"><i class="cursor icon-small icon universalicon-trash-2 colorText-red"></i></span>
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

            </div>
        </div>

      </div>

  </div>
</template>

<script>
import { API } from '@/mixins/API'
import FormGPS from '@/views/Administrador/FormGPS'
import cModalDelete from '@/views/Administrador/DeleteModal'
import EventBus from '@/EventBus'
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
    cModalDelete
  },
  created () {
    this.getDevices()
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
    async getDevices () {
      var request = await this.getRequest('devices/store')

      if (request.success === true) {
        this.listDevices = request.data.devices
      }
    },
    /**
   * @vuese
   * Abre el modal para registrar el gps
   */
    async modalFormGps () {
      this.$store.state.loader = true
      this.$store.commit('CLEAR_MODAL_DINAMIC')

      var datos = {
        'component': FormGPS,
        'datos': {
          'seccion': 'gps',
          'accion': 'nuevo'

        }
      }

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
        'component': FormGPS,
        'datos': {
          'seccion': 'gps',
          'accion': 'editar',
          'id': id

        }
      }

      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)
      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
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

  }
}
</script>

<style>
.scrollTable{
  position: relative;
    overflow: auto;
    height: 480px;
    width: 100%;
}
</style>
