<template>
  <div class=" row " >
      <div class="col-12"> <h5 class="float-left" style="font-size: 20px; padding-bottom: 10px;"><b>Configurar dispositivos - Lista de dispositivos</b></h5></div>
      <div class=" col-12">

        <div class="card">
            <div class="card-header row">
              <div class="col-9">
              <h5 class=" float-left">Dispositivos</h5>
              </div>

               <div class="col-3" style="height: 30px;">
                <button class="btn btn-secondary float-right btn-sm" @click="cancel()">REGRESAR</button>
              </div>

            </div>
            <div class="card-body">

               <div class="table-responsive scrollTable">
                    <table class="table table-hover header_fijo">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Dispositivo</th>
                                <th>Fecha de creación</th>
                                <th>Reporte en movimiento</th>
                                <th>Reporte en detenido</th>
                                <th>Compañia teléfonica</th>
                                <th>Teléfono</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(device,index) in getdeviceList" :key="device.id">
                                <td>{{index+1}}</td>
                                <td>{{device.alias}}</td>
                                <td v-if="device.creationTimestamp!=0">{{ device.creationTimestamp* 1000 | moment("MMMM DD YYYY") }} </td>
                                 <td v-else>Sin fecha</td>
                                <td>{{device.onDrivingMode}} Seg.</td>
                                <td>{{device.onParkingMode}} Seg.</td>

                                  <td v-if="device.carrier!=null">{{device.carrier}}</td>
                                <td v-else> - </td>
                                 <td v-if="device.phone!=null">{{device.phone}}</td>
                                <td v-else> - </td>
                                <td v-else>Sin sim</td>
                                <td>
                                    <span class="cursor" ><i class="icon icon-md universalicon-pencil cursor cssToolTipp" @click="editar(device.id)"> <p style="top: 25px !important; right: -70% !important;">Editar dispositivo</p></i></span>
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
import EventBus from '@/EventBus'
/**
 * @group Dispositivos
 * tabla de dipositivos
 */
export default {
  name: 'tablaDispositivos',
  mixins: [API],
  data () {
    return {
      devicesList: []
    }
  },
  async created () {
    this.$store.state.loader = true
    await this.listDevices()
  },
  async mounted () {
    this.$store.state.submenuActive = 'config'
    this.$store.state.itemSubmenuActive = 'itemDevice'
    await EventBus.$emit('NAVBAR_MenuOpciones', 'config', 'itemDevice')
    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })
    // $('#zero-configuration').DataTable({ scrollY: 360 })

    // $('#zero-configuration_length').css({ 'float': 'left' })
    this.$store.state.loader = false
  },
  methods: {
  /**
   * @vuese
   * Listado de dispositivos
   */
    async listDevices () {
      // var dispositivos = Object.values(this.$store.state.devices.devices)
      var request = await this.getRequest('devices/store')

      if (request.success === true) {
        this.devicesList = request.data.devices
      }
      // this.devicesList = dispositivos
    },
    /**
   * @vuese
   * Manda a formulario para editar dispositivo
   * @arg `id` Id de dispositivo
   */
    editar (id) {
      this.$store.state.loader = true
      console.debug('EDITAR', id)
      this.$router.push({ name: 'devicesEdit', params: { accion: 'editar', id: id } })
    },
    /**
   * @vuese
   * Concela proceso y manda una pagina anterior
   */
    cancel () {
      this.$router.push('/devices')
    }
  },
  computed: {
    /**
   * @vuese
   * Computed con listado de dispositivos
   */
    getdeviceList () {
      return this.devicesList
    }
  }
}
</script>
