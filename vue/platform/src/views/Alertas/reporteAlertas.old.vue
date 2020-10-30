<template>
  <div class=" row ">
      <div class="col-12"> <h5 class="float-left" style="font-size: 20px; padding-bottom: 10px;"><b>Alertas</b></h5></div>
      <div class=" col-12">

        <div class="card">
            <div class="card-header row">
              <div class="col-12">
                <h5 class=" float-left">Alertas desde {{this.fechaDateString}} hasta {{this.fechaNow | moment('MMMM DD, YYYY hh:mm:ss a')}}</h5>
              </div>

            </div>
            <div class="card-body float-left">

                    <div id="loader" v-if="ShowLoader!=null && !ShowLoader"></div>
                      <div class="row" style=" margin-top: 20px;">
                        <div class="col-12" id="alertReport"></div>
                      </div>

                    <div class="row" v-if="showResultado && this.reports.length>0">

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
                                        <td>{{report.eventoString}}</td>
                                        <td>{{report.address}}</td>
                                    </tr>

                                </tbody>

                            </table>
                        </div>

                    </div>
                    <div class="row" v-if="showResultado && this.reports.length<=0" >
                      <div class="col-12">No se obtuvieron resultados</div>
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
 * @group Reportes
 * Genera alertas del día en curso
 */
export default {
  name: 'reporteAlertas',
  mixins: [API],
  /**
   * @vuese
   * data
   */
  data () {
    return {
      timesIni: 0,
      timeFin: 0,
      resultado: false,
      ShowLoader: null,
      fechaNow: '',
      reports: [],
      fechaDateString: ''

    }
  },
  created () {
    this.createReport()
  },
  async mounted () {
    this.$store.state.seccionMenu = 'alertas'
    await EventBus.$emit('NAVBAR_MenuSimple', 'alertas')
    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })
  },
  methods: {

    /**
   * @vuese
   * Para regresar a la pagina principal
   */
    cancel () {
      this.$router.push('/reports')
    },
    /**
   * @vuese
   * obtener la fecha actual
   */
    getToday () {
      var date = this.$moment(new Date())
      return date.format('MMMM DD, YYYY ')
    },
    /**
   * @vuese
   * procesa, analiza y manda los filtros para generar el reporte
   */
    async createReport () {
      // Filtros para el reporte
      var filters = {}

      var fromDate = this.getToday()

      this.fechaDateString = fromDate

      console.debug('FROMDATE', fromDate)

      fromDate = fromDate.replace('enero', 'January')
      fromDate = fromDate.replace('febrero', 'February')
      fromDate = fromDate.replace('marzo', 'March')
      fromDate = fromDate.replace('abril', 'April')
      fromDate = fromDate.replace('mayo', 'May')
      fromDate = fromDate.replace('junio', 'June')
      fromDate = fromDate.replace('julio', 'July')
      fromDate = fromDate.replace('agosto', 'August')
      fromDate = fromDate.replace('septiembre', 'September')
      fromDate = fromDate.replace('octubre', 'October')
      fromDate = fromDate.replace('noviembre', 'November')
      fromDate = fromDate.replace('diciembre', 'December')

      this.fechaNow = Date.now()
      var date = fromDate + ' 00:00:00'
      // alert(date)
      console.debug('FROMDATE2', fromDate, ' FECHANOW ', this.fechaNow, ' DATE ', date, 'PARSE ', Date.parse('December 04, 2019  00:00:00'))

      var timestampFromDate = Date.parse(date) / 1000
      this.timesIni = timestampFromDate

      date = fromDate + ' 23:59:59'
      var timestampTillDate = Date.parse(date) / 1000
      this.timeFin = timestampTillDate

      filters.fromTimestamp = this.timesIni
      filters.tillTimestamp = this.timeFin

      console.debug(fromDate, 'FECHA1 ', this.timesIni, ' FECHA2', this.timeFin)

      this.ShowLoader = true // (mostrar un loader de cargando)
      this.$store.state.loader = true
      // Configuramos la descarga por primera vez
      this.reports = []
      console.debug('FILTER', filters)
      // Obtener reportes
      this.getReports(filters)
    },

    /**
   * @vuese
   * genera el reporte con los filtros
   * @arg `filters` es un arreglo con los filtros a generar el reporte
   */
    async getReports (filters) {
      // Decargar datos
      var response = await this.getRequest('reports/alerts', filters)

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

          var aOrd = ''
          if (row.geofenceTypeString == 'GEOFENCE') {
            row.geofenceTypeString = 'geocerca'
          } else if (row.geofenceTypeString == 'POINT_OF_INTEREST') {
            row.geofenceTypeString = 'punto de interes'
          }

          if (row.behaviorString == 'IN') {
            row.behaviorString = 'Entrando'
            aOrd = 'a'
          } else if (row.behaviorString == 'OUT') {
            row.behaviorString = 'Saliendo'
            aOrd = 'de'
          }

          row.eventoString = `${row.behaviorString} ${aOrd} ${row.geofenceTypeString}, ${row.geofenceName}`
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
    /**
   * @vuese
   * devuelve si se obtuvieron resultado o no
   */
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
