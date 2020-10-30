<template>

    <div class="col-12"   >

    <div class="col-12"  v-if="!isEmptyReports" style="position: absolute; top: 40px;"> <h5 class="float-left text-muted" style="font-size: 20px; padding-bottom: 10px;"><b>Ubicación</b></h5></div>

    <div class="row" v-show="!isEmptyReports" id="map-module">
        <div class="col-12">
           <google-maps name="map2" ref="map2"
        :lat="18.9240744" :lng ="-99.2252484" :zoom="5"
        :top="map.top"
        :height="map.height"
        :width="map.width"
        :left="map.left"
        :zoomControl="map.zoomControl"
        :trafficControl="map.traffic"

        markerSize="38"
        @onMapReady="onMapReady"
            @onMarkerClick="onMarkerClick"

        />

        </div>
    </div>

      <!-- <div class="col-12"  v-if="!isEmptyReports"> <h5 class="float-left text-muted" style="font-size: 20px; padding-bottom: 10px;"><b>Paradas</b></h5></div> -->

      <div class="col-12" style="margin-top:580px; "  v-show="!isEmptyReports">

          <div class="row" style="margin-top: 10px; margin-bottom: 20px;">

              <div class="col-8"  v-show="!isEmptyReports" style="    padding: 0px;"><hr ></div>

                <div class="col-4 float-right"   v-show="!isEmptyReports" style=" padding:0px; border-bottom: 1px solid rgba(0,0,0,.1); margin-top: -13px; height: 30px;" >
                                            <!-- <span v-if="this.loaderTable && seccion==2">
                                                  <i class="iconMenu icon-lg universalicon-print cursor"></i>
                                                </span> -->
                                              <span v-if="!isEmptyReports" > <!-- && this.$store.state.modal.datosDymanic.id==1 -->

                                                  <i class="iconMenu icon-lg universalicon-file-pdf cursor" @click="doDownloadFileRequest" ></i>
                                                </span>
                                                <!-- <span v-if="this.loaderTable && seccion==2">
                                                  <i class="iconMenu icon-lg universalicon-file-xls cursor"></i>
                                                </span> -->
                </div>

              </div>
          </div>

            <div class="table-responsive" v-if="showData && !isEmptyReports">
              <table id="zero-configuration" class="display table nowrap table-striped table-hover" style="width:100%">
                  <thead>
                      <tr>
                         <th>#</th>
                          <th>Unidad</th>
                          <th>Fecha inicial</th>
                          <th>Fecha final</th>
                            <th>Ubicación</th>
                          <th>Tiempo</th>

                      </tr>
                  </thead>
                  <tbody>
                      <tr v-for="(item,index) in gwtData" :key="index"  @click="onCLickTable(item,index)">
                          <td >{{index+1}}</td>
                          <td>{{item.device.alias}}</td>
                          <td>{{item.from.date }}</td>
                            <td>{{item.to.date}}</td>
                          <!-- <td>Lat:{{item.position.lat}}, {{item.position.lng}}</td> -->
                          <td>{{item.position.address}}</td>
                            <td>{{item.time.days}} días {{item.time.hours}} horas {{item.time.minutes}} minutos {{item.time.seconds}} segundos</td>
                      </tr>

                  </tbody>
                  <!-- <tfoot>
                      <tr>
                            <th>#</th>
                          <th>Fecha inicial</th>
                          <th>Fecha final</th>
                          <th>Kilometros recorridos</th>
                          <th>Velocidad promedio</th>
                          <th>Tiempo total</th>
                      </tr>
                  </tfoot> -->
              </table>
            </div>

      <div v-if="isEmptyReports" style="margin-bottom:30px;">No se encontraron resultados</div>
  </div>

</template>

<script>
import Vue from 'vue'
import { API } from '@/mixins/API'
import EventBus from '@/EventBus.js'
import googleMaps from '@/components/google/google.maps'
import DeviceInfoWindow from '@/views/Reportes/Paradas/DeviceInfoWindow.vue'
/**
 * @vuese
 * @group Reportes
 * resultado del reporte
 */
export default {
  name: 'ReportesTableDist',
  mixins: [API],
  components: {
    googleMaps
  },
  data () {
    return {
      data: null,
      reports: [],
      reportsData: [],
      resultado: false,
      // DataReports: null,
      map: {
        top: null,
        height: null,
        width: null,
        left: null,
        zoomControl: true,
        streetViewControl: false,
        clusters: true,
        clustersZoomOnClick: true,
        ready: false,
        traffic: false
      },
      streetview: {
        height: 350,
        width: 350,
        left: 150,
        top: 10
      },
      infoWindow: {
        deviceID: null,
        instance: null,
        intervalFecha: null
      }
    }
  },
  inject: ['getDraggableProperties', 'getDraggablePropertiesDevice'],
  provide () {
    return {
      getDraggablePropertiesInfowindows: this.getDraggablePropertiesTable

    }
  },
  created () {
    this.$store.state.loader = true
    this.onWindowResize()
    this.getDataTable(this.$store.state.modal.datosDymanic.filters)
    this.suscribeToDeviceEvents()
  },
  async mounted () {
    $(window).resize(this.onWindowResize)
    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })
    this.$store.state.seccionMenu = 'reportes'
    await EventBus.$emit('NAVBAR_MenuSimple', 'reportes')

    var table = $('#zero-configuration').DataTable({
      'scrollY': '550px',
      // dom: 'Bfrtip',
      // buttons: [
      //   'copyHtml5',
      //   'excelHtml5',
      //   'csvHtml5',
      //   'pdfHtml5'
      // ],
      'language': {
        'sLengthMenu': 'Mostrar _MENU_ registros',
        'emptyTable': 'No se encontraron datos',
        'info': 'Mostrando del _START_ al _END_ de _TOTAL_ resultados',
        'infoEmpty': 'Mostrando 0 al 0 de 0 resultados',
        'loadingRecords': 'Obteniendo datos...',
        'processing': 'Procesando datos...',
        'search': 'Buscar:',
        'zeroRecords': 'No se encontraron datos',
        'paginate': {
          'first': 'Primero',
          'last': 'Último',
          'next': 'Siguiente',
          'previous': 'Anterior'
        }
      }
    })

    // $('.dt-buttons .btn-group').addClass('float-left')
    this.$store.state.loader = false

    // $('#zero-configuration tbody').on('click', 'tr', function () {
    //   // var data = table.row(this).data()
    //   // var item = data[0] - 1
  // })
  },
  beforeDestroy () {
    this.unsuscribreToDeviceEvents()
  },
  methods: {

    onCLickTable (device, id) {
      console.debug('debug', device, id)
      this.onMarkerClick(id, device)
    },

    /**
   * @vuese
   * Obtiene los valores de las propiedades del componente padre
   */
    getDraggablePropertiesTable () {
      console.debug('HOLAAA')
      return this.reportsData
    },
    onMapReady () {
      this.map.ready = true
      this.loadMarkers()
      // this.suscribeToDeviceEvents()

      this.setMapStyle('default')

      // this.$refs.map2.setBoundsAllMarkers()
    },
    setMapStyle (style) {
      try {
        if (style == '') { this.$refs.map2.setAllMapStyle('[]') } else { this.$refs.map2.setAllMapStyle(require(`@/assets/map/styles/${style}.json`)) }
      } catch (err) {}
    },
    onWindowResize () {
      this.resizeMap()
    },
    resizeMap () {
      var navbarSmallHeight = 65
      var navbarSmallMaxWidth = 991

      var top = 0
      var left = 0
      var fix = 2

      if (this.$store.state.typeDevice.mobileOrTable) {
        top = navbarSmallHeight
        this.map.zoomControl = false
      } else {
        if ($(window).width() > navbarSmallMaxWidth) {
          // Large Screen
          $('#navPrincipal').hasClass('navbar-collapsed') ? left = 80 : left = 264
        } else {
          top = navbarSmallHeight
        }
      }

      this.map.left = 10

      this.map.top = 80

      this.map.height = 450
      // var widthMap = 0
      // if (left == 80) {

      // }
      this.map.width = $(window).width() - (left + 84)
    },
    async getDataTable () {
      this.$store.state.loader = true

      var data = this.getDraggableProperties()// Object.values(this.getDraggableProperties())
      console.debug('RESUTALDO_R_TABLE', data)
      Object.entries(data).forEach(([key, val]) => {
        val.device = this.getDraggablePropertiesDevice()
        console.debug(key, 'ELEMT', val)
      })

      this.reports = data

      this.resultado = true

      this.$store.state.loader = false
      $('#modalLoaderReport').modal('hide')
      this.$store.commit('ADD_COMPONENT_DINAMIC_STATE_modaloader', false)
    },
    async doDownloadFileRequest () {
      this.$store.state.loader = true

      console.debug('FILTERS', this.$store.state.modal.datosDymanic.filters)

      var params = {

        fromTimestamp: this.$store.state.modal.datosDymanic.filters.fromTimestamp,
        toTimestamp: this.$store.state.modal.datosDymanic.filters.toTimestamp,
        timezone: this.$store.state.modal.datosDymanic.filters.timezone,
        maxDistance: 10,
        maxSpeed: 1,
        timeStopped: this.$store.state.modal.datosDymanic.filters.time,
        timeTolerance: 0.2,
        format: 'pdf'
      }

      // indica el titulo del archivo y la extension que se mostraran en el dialogo de guardado
      var fileParams = {

        extension: 'pdf'
      }

      params.deviceID = this.$store.state.modal.datosDymanic.filters.deviceID
      fileParams.name = this.$store.state.modal.datosDymanic.tittle + '-' + this.reports[0].device.alias + ' del ' + this.$store.state.modal.datosDymanic.fechaIni + ' al ' + this.$store.state.modal.datosDymanic.fechaFin

      console.debug(this.$store.state.modal.datosDymanic.fechaFin, 'param', params, ' datos pdf', this.reports)
      await this.downloadFileRequest('reports/stops/export', params, fileParams)

      this.message = 'archivo descargado'

      this.$store.state.loader = false
    },
    /**
   * @vuese
   * Asigna y muestra el marcador del dipositivo correspondiente
   */
    loadMarkers () {
      // var index = 0
      // this.reports.forEach(device => {
      //   device.device.index = parseInt(index++)
      //   console.debug(index, 'MARKERS', device)
      //   this.$refs.map2.addMarker(device.device.index, device.position.lat, device.position.lng, 'PARKING', null, ``)
      // })

      Object.entries(this.reports).forEach(([key, device]) => {
        // device.device.key = parseInt(key)
        console.debug(key, 'ELEMT', device)

        this.$refs.map2.addMarker(key, device.position.lat, device.position.lng, 'PARKING', null, ``)
      })
    },
    /**
   * @vuese
   * Cuando da clic en un marcador manda a llamar a la funcon correspondiente para mostraar informacion del dispositivo
   */
    onMarkerClick (id, device = null) {
      console.debug('ONMARKER_CLICK_FUNCTIONS')
      // if (this.$store.state.typeDevice.mobileOrTable) {
      //   this.showDeviceInfoMovil(id)
      // } else {
      var opc = null
      if (device != null) {
        opc = 1
      }
      this.showDeviceInfo(id, opc, 1)
      // }
    },
    /**
   * @vuese
   * Carga y muestra el infowindows con la informacion del dispositivo
   */

    showDeviceInfo (id, seccion = null, accion = null) {
      var device = this.reports[id]
      console.debug('SHOWDEVICE_INFO_CLICK_FUNCTIONS', seccion, id, device)
      this.$store.state.infoParadasIfowindows = device
      this.$refs.map2.centerMap(device.position.lat, device.position.lng, 16)

      var DeviceInfoWindowComponent = Vue.extend(DeviceInfoWindow)
      var instance = new DeviceInfoWindowComponent({
        propsData: { deviceID: id, deviceImei: device.device.imei }
      })
      instance.$mount()

      this.infoWindow.instance = instance
      this.infoWindow.deviceID = id

      this.$refs.map2.closeAllMarkerInfoWindow()
      this.$refs.map2.setMarkerInfoWindow(id, instance.$el)
      this.$refs.map2.showMarkerInfoWindow(id)
      window.scrollTo(100, 380)
    },
    /**
   * @vuese
   * Obtiene referencia a las propiedades del componenete mapa
   */
    getMap () {
      return this.$refs.map2
    },
    /**
   * @vuese
   * se suscribe a eventos eventBus para actulizar el listado de gps
   */
    suscribeToDeviceEvents () {
      EventBus.$on('resizeMapBus', (id) => {
        this.resizeMap()
      })
    },
    /**
   * @vuese
   * Se destruye la suscripcion al eventBus
   */
    unsuscribreToDeviceEvents () {
      EventBus.$off('resizeMapBus')
    }

  },
  computed: {
    /**
   * @vuese
   * devuelve si se obtuvieron resultado o no
   */
    showData () {
      return this.resultado
    },
    gwtData () {
      return this.reports
    },
    isEmptyReports () {
      return $.isEmptyObject(this.reports)
    }
  }
}
</script>

<style>
div.dt-buttons.btn-group{
    float: left;
    text-align: left;
}
#zero-configuration_length{
   float: left;
    text-align: left;
}
</style>
