<template>
  <div class=" row ">
      <div class="col-12"> <h5 class="float-left" style="font-size: 20px; padding-bottom: 10px;"><b>Reportes - Reporte localización</b></h5></div>
      <div class=" col-12">

        <div class="card">
            <div class="card-header row">
              <div class="col-6">
                <h5 class=" float-left">Reporte localización</h5>
              </div>

            </div>
            <div class="card-body float-left">

                  <div class="row">
                      <div class="col-12 "><h5 >Generar reporte</h5></div>
                      <hr>
                      <div class="col-12 col-md-6">
                          <div class="form-group">
                            <label for="exampleFormControlSelect1">Dispositivo</label>
                            <select class="form-control" id="exampleFormControlSelect1" v-model="device">
                              <option value="0">Selecciona dispositivo</option>
                                <option v-for="device in listDEvice"  :key="device.id"  :value="device.id" >{{device.alias}}</option>
                            </select>
                        </div>
                      </div>
                       <div class="col-12 col-md-3">
                         <config-text-typography  texto="Fecha de inicio"></config-text-typography>
                        <input type="text" id="date-start1" class="form-control" placeholder="Fecha de inicio" >
                      </div>
                      <div class="col-12 col-md-3">
                        <config-text-typography  texto="Fecha final"></config-text-typography>
                        <input type="text" id="date-end1" class="form-control" placeholder="Fecha final" >
                      </div>
                  </div>

                    <div class="row">
                      <div class="col-6 float-left" style="margin-top: 30px;">
                          <button class="btn btn-secondary " @click="cancel()">CANCELAR</button>
                      </div>
                      <div class="col-6 float-right" style="margin-top: 30px;">
                        <button class="btn btn-primary " @click="createReport()">GENERAR</button> <!-- createReport -->

                      </div>
                    </div>

                    <div id="loader" v-if="ShowLoader!=null && !ShowLoader"></div>
                      <div class="row" style=" margin-top: 20px;">
                        <div class="col-12" id="alertReport"></div>
                      </div>

                    <div class="row" v-show="showResultado && this.reports.length>0" style="margin-top: 20px;">
                      <div class="col-12" id="wp-map">
                        <h5>Mapa</h5>
                        <hr>
                      </div>
                      <div id="map-container" class="col-12" :style="{height:map.height+'px'}" v-show="map.show">
                        <google-maps name="map" ref="map"
                        style="width:100% !important;"
                        :lat="map.position.lat" :lng ="map.position.lng" :zoom="5"
                        :height="map.height"
                        :zoomControl="true"
                        :streetViewControl="false"
                        markerSize="38"
                        @onMapReady="OnMapReady"
                        />
                      </div>
                      <div class="col-12 text-center" v-show="!map.show">
                        <div class="alert-dark">Seleccione un registro para mostrar su ubicacion en el mapa</div>
                      </div>
                    </div>

                    <div class="row" v-if="showResultado && this.reports.length>0" style="margin-top: 40px;">
                      <div class="col-8 "><h5 >Reportes</h5></div>
                      <hr>
                      <div class="col-12 text-left" style="margin-bottom: 10px;">
                         <button type="button"  class="btn btn-primary btn-sm" @click="first()">Primero</button>
                        <button @click="prev()" class="btn btn-primary btn-sm">Anterior</button>
                        <span style="padding-top:1em; margin-left:15px; margin-right:15px;"><b>Pagina {{pageNo}} de {{pages}}</b></span>
                        <button @click="next()" class="btn btn-primary btn-sm">Siguiente</button>
                        <button @click="last()" class="btn btn-primary btn-sm">Ultimo</button>

                        <json-csv
                            :data="reports"
                            :fields="csvFields"
                            :labels="csvLabels"
                            :name="csvFileName"
                            class="float-right"
                            >

                              <span class="cssToolTip cursor"><i class='icon universalicon-file-csv' style="font-size:30px;"></i><span style="top: 13px!important; left: -180%!important;">Exportar csv</span></span>

                          </json-csv>

                      </div>

                        <div class="table-responsive scrollTable">
                            <table class="table table-hover header_fijo">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Dispositivo</th>
                                        <th>Reporte</th>
                                        <th>Ubicacion</th>
                                        <th>Dirección</th>
                                        <th>Velocidad (km/hr)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(report,index) in reportsTable" :key="index">
                                         <td>{{report.timestamp* 1000 | moment("DD-MMM-YYYY HH:mm:ss") }}</td>
                                        <td>{{report.alias}}</td>
                                        <td>{{report.reportTypeString}}</td>
                                        <td>
                                          <span class="text-primary cursor-pointer"
                                          @click="ShowReportOnMap(report)">
                                            {{report.lat}},{{report.lng}}
                                          </span>
                                        </td>
                                        <td>{{report.address}}</td>
                                        <td>{{report.speed}}</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                      <div class="col-12 text-left" style="margin-top:15px;">
                         <button type="button"  class="btn btn-primary btn-sm" @click="first()">Primero</button>
                        <button @click="prev()" class="btn btn-primary btn-sm">Anterior</button>
                        <span style="padding-top:1em; margin-left:15px; margin-right:15px;"><b>Pagina {{pageNo}} de {{pages}}</b></span>
                        <button @click="next()" class="btn btn-primary btn-sm">Siguiente</button>
                        <button @click="last()" class="btn btn-primary btn-sm">Ultimo</button>
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
import Vue from 'vue'
import JsonCsv from 'vue-json-csv'
import { API } from '@/mixins/API'
import EventBus from '@/EventBus'
import { Functions } from '@/mixins/Functions'
import googleMaps from '@/components/google/google.maps'
import DeviceInfoWindow from '@/views/Reportes/Localizacion/InfoWindow'
/**
 * @group Reportes
 * Genera reportes de localizacion
 */
export default {
  name: 'reporteLocalizacion',
  mixins: [API, Functions],
  components: {
    JsonCsv,
    googleMaps
  },
  data () {
    return {
      placas: '',
      conductor: null,
      device: 0,
      resultado: false,
      ShowLoader: null,
      listDEvice: [],
      deviceImei: null,
      deviceAlias: '',
      reportsTable: [],
      reports: [],
      csvFields: ['fechaString', 'deviceImeiString', 'alias', 'reportTypeString', 'lat', 'lng', 'address', 'speed'],
      csvLabels: {
        fechaString: 'FECHA',
        deviceImeiString: 'IMEI',
        alias: 'ALIAS',
        reportTypeString: 'REPORTE',
        lat: 'LATITUD',
        lng: 'LONGITUD',
        address: 'DIRECCION',
        speed: 'VELOCIDAD (Km/Hr)'
      },
      csvFileName: '',
      pageNo: 1,
      pageSize: 100,
      pageCount: 0,
      pages: 0,
      fechaInicio: '',
      fechaFinal: '',
      map: {
        show: false,
        height: 270,
        position: {
          lat: 18.9240744,
          lng: -99.2252484
        },
        marker: {
          id: 'marker'
        }
      }
    }
  },
  created () {
    this.$store.state.loader = false
    this.listDEvice = Object.values(this.$store.state.devices.devices)
  },
  async mounted () {
    this.$store.state.seccionMenu = 'reportes'
    await EventBus.$emit('NAVBAR_MenuSimple', 'reportes')
    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })

    /* FECHA Y HORA */
    var f = new Date()
    var dia1 = f.getDate()
    var mes1 = f.getMonth()
    var anioActual = f.getFullYear()

    // var nuevaFECHA = f.setMonth(mes1 - 1)

    // var date = this.$moment(new Date())
    // var fromDate = date.format('MMMM DD, YYYY ')
    // var fechaIni = fromDate + ' 00:00:00'

    // nuevos
    $('#date-end1').bootstrapMaterialDatePicker({
      weekStart: 0,
      lang: 'es',
      // format: 'LLL',
      format: 'MMMM DD, YYYY HH:mm:ss',
      // Selecciona fecha por default,
      shortTime: true, // Permite mostrar la hora como AM/PM en vez de formato 24 HRS
      // maxDate: new Date(),
      //  minDate: f
      year: true, // Permitir seleccionar año
      date: true, // Permitir seleccionar fecha/mes
      time: false, // Permite seleccionar la hora
      maxDate: this.$moment(new Date()).endOf('day'),
      minDate: this.$moment(new Date()).startOf('day')
      // currentDate: this.$moment(new Date()) // Selecciona fecha por default,
    })
    $('#date-start1').bootstrapMaterialDatePicker({
      weekStart: 0,
      lang: 'es',
      // format: 'LLL',
      format: 'MMMM DD, YYYY HH:mm:ss',
      currentDate: this.$moment(new Date()).startOf('day'), // Selecciona fecha por default,
      maxDate: this.$moment(new Date()).endOf('day'),
      shortTime: true, // Permite mostrar la hora como AM/PM en vez de formato 24 HRS
      // minDate: f
      year: true, // Permitir seleccionar año
      date: true, // Permitir seleccionar fecha/mes
      time: false // Permite seleccionar la hora

    }).on('change', function (e, date) {
      // var fechaSelect = this.$moment(new Date(date))

      var fechaSelect = new Date(date)
      this.fechaInicio = date

      // var timeFin = fechaSelect.add(3, 'months')
      // console.debug(fechaSelect, fechaSelect.unix(), 'TIME-FIN', timeFin, timeFin.unix())

      var anio1 = fechaSelect.getFullYear()
      var dia2 = fechaSelect.getDate()
      console.debug(this.fechaInicio, 'fech sin formato', fechaSelect)
      var mesLimit = fechaSelect.getMonth()

      var nuevaFechaLimit = fechaSelect.setMonth(mesLimit + 3)

      var mesLimit2 = fechaSelect.getMonth()
      var anio2 = fechaSelect.getFullYear()
      console.debug('actual', mesLimit, anio1)
      console.debug(fechaSelect, 'fecha mas3', mesLimit2, anio2, 'nueva fecha', nuevaFechaLimit)
      if (anio2 > anioActual) {
        console.debug('año diferente', dia1, dia2)
        fechaSelect = new Date()
        // if (mesLimit2 > 0) {
        //   if (dia2 > dia1) {
        //     console.debug('dia mayor')
        //     fechaSelect = new Date()
        //   }
        // }
      } else {
        if (anio2 == anioActual) {
          console.debug('mismo año')
          if (mesLimit2 > mesLimit) {
            fechaSelect = new Date()
            //     console.debug('entra menos de 3 meses del actual')
            //     fechaSelect = new Date()
            //   }
          }
          if (mesLimit2 == mes1) {
            if (dia2 > dia1) {
              console.debug('dia mayor, mismo mes')
              fechaSelect = new Date()
            }
          }
          // if (anioActual == anio1) {
          //   if (mesLimit2 >= mesLimit) {
          //     console.debug('entra menos de 3 meses del actual')
          //     fechaSelect = new Date()
          //   }
          // }
        }
      }
      console.debug('fecha FINAL', fechaSelect)
      // $('#date-start1').bootstrapMaterialDatePicker('setMinDate', date)
      $('#date-end1').bootstrapMaterialDatePicker('setMinDate', date)
      // 3 meses
      $('#date-end1').bootstrapMaterialDatePicker('setMaxDate', fechaSelect)
      // date.setHours(23)
      // date.setMinutes(59)
      // date.setSeconds(59)
    }).on('change', function (e, date) {
      this.fechaFinal = date
      console.debug('FECHA_FIANL', this.fechaFinal)
    })
    // .bind(this)

    // $('#date-start1').bootstrapMaterialDatePicker('setMinDate', date)
    this.$store.state.loader = false
  },
  methods: {
    // #region Control del Mapa
    OnMapReady () {
      this.$refs.map.setAllMapStyle(require(`@/assets/map/styles/default.json`))
      this.$refs.map.addMarker(this.map.marker.id, this.map.position.lat, this.map.position.lng, 'default', null, '')
      this.$refs.map.setMarkerVisible(this.map.marker.id, false)
    },

    ShowReportOnMap (report) {
      this.map.show = true

      // Crear instancia de infowindow
      var DeviceInfoWindowComponent = Vue.extend(DeviceInfoWindow)
      var instance = new DeviceInfoWindowComponent({
        propsData: { report: report }
      })
      instance.$mount()

      // Actualizar marcador e infowindow
      this.$refs.map.setMarkerVisible(this.map.marker.id, true)
      this.$refs.map.moveMarker(this.map.marker.id, report.lat, report.lng)
      this.$refs.map.setMarkerInfoWindow(this.map.marker.id, instance.$el)
      this.$refs.map.showMarkerInfoWindow(this.map.marker.id)
      this.$refs.map.centerMap(report.lat, report.lng, 16)

      // Hacer scroll a la ubicacion del mapa y proceder a actualizar el marcador
      var hash = '#wp-map'
      $('html, body').animate({
        scrollTop: $(hash).offset().top - 20
      },
      1000
      )

      // GotoTo
    },
    // #endregion

    /**
   * @vuese
   * Para regresar a la pagina principal
   */
    cancel () {
      this.$router.push('/reports')
    },
    /**
   * @vuese
   * procesa, analiza y manda los filtros para generar el reporte
   */
    async createReport () {
      if (this.device == 0 || this.device == '0') {
        $('#alertReport').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Debe seleccionar un dispositivo<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
        setTimeout(() => {
          $('#alertReport').html('')
        }, 3000)
        return 0
      }

      // Filtros para el reporte
      var filters = {
        deviceID: parseInt(this.device),
        order: 'DESC'
      }

      var fecIni2 = $('#date-start1').val()
      var fecFin2 = $('#date-end1').val()

      var fecIni = this.fechaEsp(fecIni2)
      var fecFin = this.fechaEsp(fecFin2)

      console.debug(fecIni, 'DATOS_PRINC', fecFin)

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

      this.listDEvice.forEach(disp => {
        if (disp.id == this.device) {
          this.deviceImei = disp.imei
          this.deviceAlias = disp.alias
        }
      })

      // Configuramos la descarga por primera vez
      this.reports = []

      // Variables demo, para construir el nobre del archivo csv
      var name = 'ReporteLocalizacion'
      var from = parseInt(this.deviceImei)
      var to = '190807'

      // Nombre que tendra el archivo csv
      this.csvFileName = `${name} - ${from}.csv`

      this.ShowLoader = true // (mostrar un loader de cargando)
      this.$store.state.loader = true

      console.debug('FILTRO', filters)
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
      var response = await this.getRequest('reports/historical', filters)

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
        } catch (err) {
          console.warn('Error parsing timestamp')
          row.fechaString = day.format('No disponible')
        }
      })

      // CONCATENAMOS los resultados al arreglo final
      // NO hacemos un push porque esto no funcionaria
      this.reports = this.reports.concat(response.data.reports)

      // SI pagination next contiene token volvemos a llamar getReports para descargar mas datos
      // De lo contrario terminamos
      if (response.pagination.next) {
        console.debug('NEXT')
        filters = { paginationToken: response.pagination.next }
        this.getReports(filters)
      } else {
        console.debug('FINISH')
        // Buen lugar para por ejemplo showLoader = false
        this.init()
        this.ShowLoader = false // (mostrar un loader de cargando)
        this.$store.state.loader = false
        this.resultado = true
      }
    },
    /**
   * @vuese
   * funcion iniciar la paginacion
   */
    init: function () {
      this.pages = this.count({})
      this.pages = Math.ceil((this.pages / this.pageSize))

      this.virtualService({
        pageNo: this.pageNo,
        pageSize: this.pageSize
      })
    },
    /**
   * @vuese
   * funcion de paginacion
   */
    page: function (pageNo) {
      this.virtualService({
        pageNo: pageNo,
        pageSize: this.pageSize
      })
    },
    /**
   * @vuese
   * funcion de primero en paginacion
   */
    first: function () {
      this.pageNo = 1
      this.virtualService({
        pageNo: this.pageNo,
        pageSize: this.pageSize
      })
    },
    /**
   * @vuese
   * funcion de ultimo en paginacion
   */
    last: function () {
      this.pageNo = this.pageCount
      this.virtualService({
        pageNo: this.pageNo,
        pageSize: this.pageSize
      })
    },
    /**
   * @vuese
   * funcion de anterior en paginacion
   */
    prev: function () {
      if (this.pageNo > 1) {
        this.pageNo -= 1
        this.virtualService({
          pageNo: this.pageNo,
          pageSize: this.pageSize
        })
      }
    },
    /**
   * @vuese
   * funcion de siguiente en paginacion
   */
    next: function () {
      console.debug(`${this.pageNo} < ${this.pageCount}`)

      if (this.pageNo < this.pageCount) {
        this.pageNo += 1
        this.virtualService({
          pageNo: this.pageNo,
          pageSize: this.pageSize
        })
      }
    },
    /**
   * @vuese
   * Obtiene el numero de reportes
   */
    count: function (condition) {
      return this.reports.length
    },
    /**
   * @vuese
   * funciones de paginacion `queryFromVirtualDB`
   */
    queryFromVirtualDB: function (condition, startRow, endRow) {
      var result = []
      condition = {}
      var count = this.count(condition)

      console.debug(`GET REPORTS FROM ${startRow} AT ${endRow}`, condition)
      result = this.reports.slice(startRow, endRow)
      // for (var i = startRow - 1; i < endRow; i++) {
      //   if (i < count) {
      //     result.push(this.reports[i])
      //   }
      // }
      return result
    },
    /**
   * @vuese
   * funciones de paginacion `virtualService`
   */
    virtualService: function (params) {
      var result = []
      var condition = {}
      var pageNo = params.pageNo
      var pageSize = params.pageSize
      var pageCount = Math.ceil(this.count(condition) / pageSize)

      if (pageNo == 0) pageNo = 1
      if (pageNo < 0) pageNo = pageCount
      else if (pageNo > pageCount) pageNo = pageCount
      var startRow = (pageNo - 1) * pageSize + 1
		  var endRow = startRow + pageSize - 1
      var data = this.queryFromVirtualDB(condition, startRow, endRow)

      // set result
      this.reportsTable = data
      this.pageNo = pageNo
      this.pageCount = pageCount
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
