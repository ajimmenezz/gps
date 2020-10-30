<template>
  <div class=" row ">
      <div class="col-12"> <h5 class="float-left" style="font-size: 20px; padding-bottom: 10px;"><b>Alertas</b></h5></div>
      <div class=" col-12">

        <div class="card">
            <div class="card-header row">
              <div class="col-6">
                <h5 class=" float-left">Alertas del día</h5>
              </div>

            </div>
            <div class="card-body float-left">

                    <div id="loader" v-if="ShowLoader!=null && !ShowLoader"></div>
                      <div class="row" style=" margin-top: 20px;">
                        <div class="col-12" id="alertReport"></div>
                      </div>

                    <div class="row" v-if="showResultado && this.reports.length>0" style="margin-top: 20px;">
                      <div class="col-8 "><h5 >Reporte</h5></div>
                        <div class="col-4 float-right">
                          <!--
                            Ejemplo de generar reporte
                            json-csv es el componente que sirve para descargar el excel
                            puedes poner cualquier contenido dentro una imagen, un font-icon un div- etc
                          -->

                        </div>
                      <hr>

                        <div class="table-responsive scrollTable">
                            <table class="table table-hover header_fijo">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Fecha</th>
                                        <th>Dispositivo</th>
                                        <th>Evento</th>
                                        <th>Direccion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(report,index) in reports" :key="index">
                                        <td>{{index+1}}</td>
                                        <td>{{report.timestamp* 1000 | moment("DD-MMM-YYYY HH:mm:ss") }}</td>
                                        <td>{{report.deviceAlias}}</td>
                                        <td>{{report.behaviorString}}</td>
                                        <td>{{report.geofenceTypeString}}</td>
                                        <td>{{report.geofenceName}}</td>
                                        <td>{{report.lat}},{{report.lng}}</td>
                                        <td>{{report.address}}</td>
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
                    <div class="row" v-if="showResultado && this.reports.length<=0" style="margin-top: 20px;">
                      <div class="col-12">No se obtuvieron resultados</div>
                    </div>

            </div>

        </div>

      </div>

  </div>
</template>

<script>
import JsonCsv from 'vue-json-csv'
import { API } from '@/mixins/API'
import EventBus from '@/EventBus'
export default {
  name: 'reporteGeo',
  mixins: [API],
  components: {
    JsonCsv
  },
  data () {
    return {
      comport: 0,
      geocerca: 0,
      device: 0,
      resultado: false,
      listDevice: [],
      listGeofences: [],
      ShowLoader: null,

      reports: []

    }
  },
  created () {
    this.listDevice = Object.values(this.$store.state.devices.devices)
    this.getlistGeofence()
  },
  async mounted () {
    this.$store.state.seccionMenu = 'alertas'
    await EventBus.$emit('NAVBAR_MenuSimple', 'alertas')
    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })
  },
  methods: {

    cancel () {
      this.$router.push('/reports')
    },
    async createReport () {
      // Filtros para el reporte
      var filters = {
        deviceID: parseInt(this.device)
      }
      // ingresa comportamiento
      if (this.comport != 0 && this.comport != 3) {
        filters.behavior = this.comport
      }

      // ingresa geocerca
      if (this.geocerca != 0 && this.geocerca != '0') {
        filters.geofenceID = this.geocerca
      }

      // this.comport
      // this.geocerca

      var fecIni = $('#date-start1').val()
      var fecFin = $('#date-end1').val()

      var timesIni
      var timeFin

      if (fecIni == '' && fecFin == '') {
        // filtro no se manda y consulta los de hoy
        // timesIni = new Date() / 1000

        // timeFin = new Date() / 1000
      } else {
        if (fecIni != '' && fecFin != '') {
          timesIni = Date.parse(fecIni) / 1000

          timeFin = Date.parse(fecFin) / 1000

          filters.fromTimestamp = timesIni
          filters.tillTimestamp = timeFin
        } else {
          // debe llenar las 2 fechas
          $('#alertReport').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Debe ingresar las 2 fechas<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
          setTimeout(() => {
            $('#alertReport').html('')
          }, 3000)
          return 0
        }
      }

      this.listDevice.forEach(disp => {
        if (disp.id == this.device) {
          this.deviceImei = disp.imei
          this.deviceAlias = disp.alias
        }
      })

      this.ShowLoader = true // (mostrar un loader de cargando)
      this.$store.state.loader = true
      // Configuramos la descarga por primera vez
      this.reports = []

      // Variables demo, para construir el nobre del archivo csv
      var name = 'ReporteGeocercas'
      var from = parseInt(this.deviceImei)
      var to = '190807'

      // Nombre que tendra el archivo csv
      this.csvFileName = `${name}.csv`

      // Obtener reportes
      this.getReports(filters)
    },
    async getReports (filters) {
      // Decargar datos
      var response = await this.getRequest('reports/geofences', filters)

      /**
       * La fecha en los datos descargados vienen en timestsamp
       * iterar cada resultado y agregarle una propiedad fechaString (convertir timestamp to date con moment)
       * ademas agregamos una ' en el imei para que el archivo csv no convierta el imei a numero y se pierdan digitos
       */
      response.data.reports.forEach(row => {
        try {
          var day = this.$moment.unix(parseInt(row.timestamp))
          row.deviceImeiString = "'" + row.deviceImei
          row.fechaString = day.format('DD-MMM-YYYY HH:mm:ss')

          if (row.geofenceTypeString == 'GEOFENCE') {
            row.geofenceTypeString = 'GEOCERCA'
          } else if (row.geofenceTypeString == 'POINT_OF_INTEREST') {
            row.geofenceTypeString = 'PUNTO DE INTERES'
          }

          if (row.behaviorString == 'IN') {
            row.behaviorString = 'ENTRANDO'
          } else if (row.behaviorString == 'OUT') {
            row.behaviorString = 'SALIENDO'
          }
        } catch (err) {
          console.warn('Error parsing timestamp')
          row.fechaString = day.format('No disponible')
        }
      })

      // CONCATENAMOS los resultados al arreglo final
      // NO hacemos un push porque esto no funcionaria
      this.reports = this.reports.concat(this.reports, response.data.reports)

      // SI pagination next contiene token volvemos a llamar getReports para descargar mas datos
      // De lo contrario terminamos
      if (response.pagination.next) {
        console.debug('SI')
        filters = { paginationToken: response.pagination.next }
        this.getReports(filters)
      } else {
        console.debug('FINISH')
        // Buen lugar para por ejemplo showLoader = false

        this.ShowLoader = false // (mostrar un loader de cargando)
        this.$store.state.loader = false
        this.resultado = true
      }
    }
  },
  computed: {
    showResultado () {
      return this.resultado
    }
  }
}
</script>

<style>
.mpConf{
  margin: 10px;
  padding-top: 10px;
}

.scrollTable{
  position: relative;
    overflow: auto;
    height: 480px;
    width: 100%;
}
</style>
