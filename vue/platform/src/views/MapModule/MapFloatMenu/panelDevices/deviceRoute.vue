<template>
  <div class="container-fluid" style="margin-top:15px; margin-bottom:10px;">
    <loader-small v-if="loader.show" :message="loader.message" />
    <!--Header y control de animacino-->
    <div class="row">
      <div class="col-4 text-left">
        <h5>Recorrido</h5>
      </div>
      <div class="col-8 text-right"  v-if="!showForm && !error">
          <span class="universalicon-play icon icon-md text-secondary cursor cssToolTipp"
          v-if="animationRoute.showPlayBtn"
          @click="playAnimationRoute(), setAnimationRouteButtons(false, true, true)">
          <p style="top: 25px !important; right: -70% !important;">Iniciar animación de recorrido</p></span>

          <span class="universalicon-play-stop icon icon-md text-secondary cursor cssToolTipp"
           v-if="animationRoute.showStopBtn"
          @click="stopAnimationRoute(),  setAnimationRouteButtons(false, false, false)">
            <p style="top: 25px !important; right: -70% !important;">Detener animación de recorrido</p></span>

          <span id="speedAnimationRouteBtn"
          class="universalicon-forward-x1 icon icon-md text-secondary cursor cssToolTipp"
          v-if="animationRoute.showSpeedBtn"
          @click="nextSpeedAnimationRoute()">
            <p style="top: 25px !important; right: -70% !important;">Cambiar a velocidad animacion {{animationRoute.speedBtnText}}</p>
          </span>

        <small v-if="animationRoute.timestamp!=null && animationRoute.showStopBtn" class="flashit"
        style="margin-left: 8px; position: relative; top: -5px;">
          <b>{{animationRoute.timestamp*1000 | moment('hh:mm:ss a')}}</b>
        </small>
      </div>
      <div class="col-12 text-left text-ellipsis" v-if="!showForm">
        Unidad: <b>{{device.alias}}</b>
      </div>
      <div class="col-12">
        <hr style="margin: 0.5rem;">
      </div>
    </div>

    <!--Form -->
    <div class="row text-left" style="max-height:180px; overflow-y:auto;" v-show="showForm">
      <div class="col-12">
        <label for="device">Dispositivo</label>
        <input
          type="text"
          id="device"
          class="form-control mb-3 cursor-not-allowed"
          disabled
          v-model="device.alias"
        />
      </div>
      <div class="col-12">
        <label for="date-report">Seleccione una fecha de inicio:</label>
         <input
          id="date-report"
          type="text"
          class="form-control mb-3 cursor"
          :value="fromTimestamp|moment('LLL a')"
        />
      </div>
      <div class="col-12">
        <label for="date-end-report">Seleccione una fecha de final:</label>
         <input
          id="date-end-report"
          type="text"
          class="form-control mb-3 cursor"
          :value="tillTimestamp|moment('LLL a')"
        />
      </div>

    </div>

    <!--Reports Table -->
    <div class="row" style="max-height:180px; overflow-y:auto;" v-if="!showForm && !error" id="divContainerDos">
      <ul class="list-unstyled" v-if="showReports" >
        <li
          class="text-left"
          v-for="(report, index) in reports"
          :key="index"
          style="margin-bottom:10px; "
        >

          <!-- <div class="row">
          <div class="col-12">-->
          <div class="row" style="margin-left:5px; margin-right:10px; " :id="`item${report.id}`">
            <div class="col-2 custom-control custom-radio" style="padding-left: 40px;" v-if="animationRoute.showPlayBtn">

              <input
                type="radio"
                :id="report.id"
                name="customRadio"
                class="custom-control-input"
                :value="report.id"
                @change="onViewRoute(report.id, report.event,report.reports[0].lat, report.reports[0].lng )"
                v-if="report.event=='PARKING'"
              />

              <input
                type="radio"
                :id="report.id"
                name="customRadio"
                class="custom-control-input"
                :value="report.id"
                @change="onViewRoute(report.id, report.event )"
                 v-if="report.event!='PARKING'"
              />
              <label class="custom-control-label" :for="report.id">&nbsp;</label>
            </div>
            <div class="col-8" style="padding-left: 0px;">
              <b>{{report.eventString}}</b>
            </div>
            <div class="col-12 text-left">Velocidad Promedio: <b>{{ Math.ceil(report.speed)}} Km/Hr.</b></div>
            <div class="col-12" style="margin-top:5px;">Desde: <b>{{report.timestampStart *1000 | moment('D/MMMM/YY HH:mm:ss')}}</b></div>
            <div class="col-12" style="margin-top:5px;">Hasta: <b>{{report.timestampEnd *1000 | moment('D/MMMM/YY HH:mm:ss')}}</b></div>
            <div
              class="col-12 text-justify"
              style="margin-top:5px;"
              v-if="report.address"
            >Direccion: {{report.address}}</div>
            <hr style="width: 100%; margin: 5px;"  v-if="animationRoute.showPlayBtn" />
          </div>
        </li>
      </ul>
    </div>

    <!--No reports Message-->
    <div class="row" v-if="error">
      <div class="col-12" style="padding: 20px 10px">El dispositivo no contiene reportes</div>
    </div>

    <!--Footer-->
    <div class="row">
      <div class="col-12">
        <hr style="margin: 0.5rem;" />
      </div>
      <div class="col-6 text-left">
        <button class="btn btn-secondary btn-sm" @click="close()">CERRAR</button>
      </div>
      <div class="col-6 text-right" v-if="!error && showForm">
        <button class="btn btn-primary btn-sm" @click="getRoute()">GENERAR</button>
      </div>
      <div class="col-6 text-right" v-if="!showForm && !error && showReports">
        <json-csv
          :data="reports"
          :fields="csv.fields"
          :labels="csv.labels"
          :name="csv.filename"
          >
            <span class="cssToolTip"><i class='universalicon-file-csv cursor icon-lg'></i>
            <span style="left: -120px !important; top: -10px;">Exportar csv</span></span>
        </json-csv>
      </div>
    </div>

  </div>
</template>

<script>
import { API } from '@/mixins/API'
import JsonCsv from 'vue-json-csv'
import EventBus from '@/EventBus'
/**
 * @group MapModule/MapFloatMenu/dispositivos
 * Paneles y formularios para geenerar y mostrar el recorrido del dia en curso de una unidad.
 */
export default {
  name: 'InfowindowsInfoDispositivo',
  mixins: [API],
  components: {
    loaderSmall: () => import('@/components/loader/loader.small'),
    JsonCsv
  },
  inject: [
    'getMap',
    'getDraggableProperties',
    'loadDynamicComponent',
    'showMenuFloat',
    'onDevicesSelected'
  ],
  props: {
    deviceID: {
      required: true
    },
    buscador: {
      required: true
    }
  },
  data () {
    return {
      map: null,
      showForm: true,
      fromTimestamp: null,
      tillTimestamp: null,
      day: null,
      device: {
        alias: '',
        id: '',
        imei: '',
        marker: ''
      },
      reports: [],
      positionsScroll: [],
      firstReport: null,
      lastReport: null,
      reportsReady: false,
      mapReady: false,
      showReports: false,
      setSpeedAnimationRouteValue: 0,
      scrollSpeed: 1000,
      animationRoute: {
        duration: 3000,
        timestamp: null,
        showPlayBtn: true,
        showStopBtn: false,
        showSpeedBtn: false,
        speedBtnText: 'x1',
        speedAnimationRouteBtnClass: 'universalicon-forward-x1'
      },
      error: false,
      loader: {
        show: false
      },
      markerParking: 'marker_tempParkig',
      polylines: [],
      markers: [],
      csv: {
        fields: ['eventString', 'timestampStartString', 'timestampEndString', 'addressStart', 'addressEnd', 'speed'],
        labels: {
          eventString: 'ESTADO',
          timestampStartString: 'HORA INICIAL',
          timestampEndString: 'HORA FINAL',
          addressStart: 'DIRECCION INICIAL',
          addressEnd: 'DIRECCION FINAL',
          speed: 'VELOCIDAD (km/hr)'
        },
        filename: 'report.csv'
      }
    }
  },
  mounted () {
    this.map = this.getMap()
    this.map.closeAllMarkerInfoWindow()
    this.map.showAllMarkers(false)

    this.map.$on(
      'onMarkerAnimationPositionChanged',
      this.onMarkerAnimationPositionChanged
    )
    this.$store.commit('mapModule/MAP_CLUSTER', false)
    this.showMenuFloat(false, true)

    var deviceSelected = this.deviceID
    this.device.alias = this.$store.state.devices.devices[deviceSelected].alias
    this.device.id = this.$store.state.devices.devices[deviceSelected].id
    this.device.imei = this.$store.state.devices.devices[deviceSelected].imei
    this.device.marker = this.$store.state.devices.devices[deviceSelected].marker.name

    this.fromTimestamp = this.$moment(new Date()).startOf('day')
    this.tillTimestamp = this.$moment(new Date()).endOf('day')

    $('#date-report')
      .bootstrapMaterialDatePicker({
        lang: 'es',
        currentDate: this.fromTimestamp,
        maxDate: this.$moment(this.fromTimestamp).endOf('day'),
        year: false,
        date: true,
        time: true,
        shortTime: true,
        format: 'LLL a'
      })
      .on('change', this.onDateChanged)

    $('#date-end-report')
      .bootstrapMaterialDatePicker({
        lang: 'es',
        currentDate: this.tillTimestamp,
        minDate: this.$moment(this.fromTimestamp).startOf('day'),
        maxDate: this.$moment(this.tillTimestamp).endOf('day'),
        year: false,
        date: true,
        time: true,
        shortTime: true,
        format: 'LLL a'
      })
      .on('change', this.onDateEndChanged)
  },
  beforeDestroy () {
    this.showMenuFloat(true, true)
    this.stopAnimationRoute()
    this.clearMarkers()
    this.clearPolylines()
    this.map.showAllMarkers(true)
    this.map.setBoundsAllMarkers()
    this.$store.commit('mapModule/MAP_CLUSTER', true)
    this.map.$off('onMarkerAnimationPositionChanged')
  },
  methods: {
    /**
   * @vuese
   * Bloquea los paneles principales cuando se abre panel de formularios
   */
    lockDraggable (lock) {
      this.$emit('lockDraggable', lock)
    },
    onDateChanged (sender, date) {
      this.fromTimestamp = this.$moment(date)
      this.tillTimestamp = this.$moment(date).add(24, 'hour')

      var maxDate = this.$moment(date).add(24, 'hours')
      var minDate = this.$moment(date).startOf('day')

      console.debug(maxDate, minDate)

      console.debug('onDateChanged', this.fromTimestamp.format('LLL a'), maxDate.format('LLL a'))
      $('#date-end-report').bootstrapMaterialDatePicker('setMinDate', minDate)
      $('#date-end-report').bootstrapMaterialDatePicker('setMaxDate', maxDate)
      $('#date-end-report').bootstrapMaterialDatePicker().currentDate = this.tillTimestamp

      // console.debug('onDateChanged', this.fromTimestamp.format('LLL'), this.tillTimestamp.format('LLL'))
    },
    /**
   * @vuese
   * Obtiene toda la informacion del reporte-recorrido a consultar en un rango de fechas
   */
    async getRoute () {
      try {
        console.debug('Get RouteReporte from ', this.fromTimestamp.format('LLL a'), ' to ', this.tillTimestamp.format('LLL a'))
        this.loader.show = true

        var requestParams = {
          deviceID: this.device.id,
          fromTimestamp: this.fromTimestamp.unix(),
          tillTimestamp: this.tillTimestamp.unix(),
          order: 'ASC',
          limit: 0
        }

        var result = await this.getRequest(
          'reports/routes/basic',
          requestParams
        )

        this.reports = result.data.reports

        if (this.reports.length > 0) {
          this.reportsReady = true
        } else {
          throw new Error('No reports were found')
        }
      } catch (err) {
        console.error(err)
        this.error = true
      } finally {
        this.showForm = false
        this.loader.show = false
      }
    },
    /**
   * @vuese
   * Cierra el panel de recorrido y actualiza la lista de dispositivo
   */
    close () {
      console.debug('STRING_BUSCADOR', this.buscador)

      EventBus.$emit('EventGetbuscador', this.buscador)
      var DevicePanel = () =>
        import('@/views/MapModule/MapFloatMenu/panelDevices/listDevices')
      this.loadDynamicComponent('DevicePanel', DevicePanel, this.buscador)
      // eventBus open Infowindows
      // EventBus.$emit('openInfowindowsDevicesROUTER', this.deviceID)
    },
    /**
   * @vuese
   * Dibuja lineas con google maps el resultado del recorrido de la unidad para mostrarlo en el mapa
   */
    drawLines () {
      try {
        this.clearPolylines()

        try {
          // Set Start and Finish Markers
          this.firstReport = this.reports[0].reports[0]

          var size = this.reports.length - 1
          this.lastReport = this.reports[size].reports[this.reports[size].reports.length - 1]

          this.map.addMarker(
            'deviceRouteStart',
            this.firstReport.lat,
            this.firstReport.lng,
            'FLAG_START'
          )
          this.map.addMarker(
            'deviceRouteEnd',
            this.lastReport.lat,
            this.lastReport.lng,
            'FLAG_STOP'
          )

          this.markers.push('deviceRouteStart')
          this.markers.push('deviceRouteEnd')
        } catch (err) {
          console.error(err)
        }

        var index = 0
        var lastParkingReport
        this.reports.forEach(row => {
          row.id = '' + index
          row.visible = true

          row.speed = Math.round(row.speed)

          row.address = row.reports[0].address
          row.addressStart = row.reports[0].address
          row.addressEnd = ''

          row.timestampStartString = this.$moment.unix(row.reports[0].timestamp).format('DD/MM/YY HH:mm:ss')
          row.timestampEndString = this.$moment.unix(row.reports[row.reports.length - 1].timestamp).format('DD/MM/YY HH:mm:ss')

          index++

          if (row.event == 'PARKING') {
            var report = row.reports[0]
            report.lat = parseFloat(report.lat)
            report.lng = parseFloat(report.lng)

            lastParkingReport = { lat: report.lat, lng: report.lng }
          } else if (row.event == 'MOVEMENT') {
            var points = []
            points.push(lastParkingReport)
            row.addressEnd = row.reports[row.reports.length - 1].address

            row.reports.forEach(report => {
              report.lat = parseFloat(report.lat)
              report.lng = parseFloat(report.lng)
              points.push({ lat: report.lat, lng: report.lng })
            })

            var routeColor = '#01579B'

            this.polylines.push('p' + row.id)
            this.map.addPolyline(
              points,
              'p' + row.id,
              routeColor,
              false,
              100,
              false,
              0.5,
              12
            )
          }
        })
        // this.map.setBoundsAllMarkers()

        this.boundsRoute()
        this.showReports = true
      } catch (err) {
        console.error(err)
        this.error = true
      }
    },
    getRandomColor () {
      var color = Math.floor(Math.random() * 3)
      switch (color) {
        case 1:
          color = '#01579B'
          break

        case 2:
          color = '#E65100'
          break

        case 3:
          color = '#263238'
          break

        default:
          color = '#1B5E20'
          break
      }

      return color
    },
    /**
   * @vuese
   * hace zoom y resalta ese trazo de recorrido o detenido de la unidad.
   */
    onViewRoute (id, type, lat = null, lng = null) {
      console.debug('onViewRoute', id, type, lat, lng)

      this.map.deleteMarker(this.markerParking)
      switch (type) {
        case 'PARKING':
          console.debug('maker', id)

          this.map.addMarker(this.markerParking, lat, lng, 'PARKING')
          this.map.centerMap(lat, lng, 17)

          break

        case 'MOVEMENT':
          var bounds = this.map.getPolylineBounds('p' + id)
          this.map.centerMapToBounds(bounds)
          break
      }
    },
    /**
   * @vuese
   * Centra el mapa en el trazo y resultados obtenidos
   */
    boundsRoute () {
      if (this.polylines.length > 0) {
        this.map.setBoundsAllPolylines()
      } else {
        var bounds = this.map.getMarkersBounds([
          'deviceRouteStart',
          'deviceRouteEnd'
        ])
        this.map.centerMapToBounds(bounds)
      }
    },
    /**
   * @vuese
   * Limpia el recorrido visualizado
   */
    clearPolylines () {
      this.polylines.forEach(id => {
        try {
          this.map.deletePolyline(id)
        } catch (err) {
          console.error(err)
        }
      })
    },
    /**
   * @vuese
   * Limpia los marcadores de representacion de recorrido
   */
    clearMarkers () {
      this.markers.forEach(id => {
        try {
          this.map.deleteMarker(id)
        } catch (err) {
          console.error(err)
        }
      })

      this.map.deleteMarker(this.markerParking)
      this.map.deleteMarker('deviceRoute' + this.device.imei)

      this.markers = []
    },

    // #AnimationRoute
    /**
   * @vuese
   * Inicia animacion simulando el recorrido
   */
    playAnimationRoute () {
      console.debug('START animation route')

      this.map.deleteMarker(this.markerParking)

      var report = this.reports[0]
      var marker = this.device.marker
      if (report.event == 'PARKING') {
        marker = 'PARKING'
      }
      this.map.centerMap(this.firstReport.lat, this.firstReport.lng, 17)
      this.map.addMarker(
        'deviceRoute' + this.device.imei,
        this.firstReport.lat,
        this.firstReport.lng,
        marker
      )
      this.map.moveMarker(
        'deviceRoute' + this.device.imei,
        this.firstReport.lat,
        this.firstReport.lng,
        false
      )
      this.nextSpeedAnimationRoute()
      this.AnimateRoute()
    },
    /**
   * @vuese
   * Detiene la animacion de recorrido en curso
   */
    stopAnimationRoute () {
      console.debug('STOP animation route')
      this.animationRoute.enabled = false
      this.setSpeedAnimationRouteValue = 0
    },
    nextSpeedAnimationRoute () {
      var zoom = 17

      switch (this.setSpeedAnimationRouteValue) {
        case 5000:
          this.setSpeedAnimationRouteValue = 3000
          this.animationRoute.duration = 3000
          this.scrollSpeed = 3000
          this.animationRoute.speedBtnText = 'x5'
          this.animationRoute.speedAnimationRouteBtnClass = 'universalicon-forward-x3'
          zoom = 13
          break

        case 3000:
          this.setSpeedAnimationRouteValue = 500
          this.animationRoute.duration = 500
          this.scrollSpeed = 500
          this.animationRoute.speedAnimationRouteBtnClass = 'universalicon-forward-x5'
          zoom = 9
          break

        case 500:
        default:
          this.setSpeedAnimationRouteValue = 5000
          this.animationRoute.duration = 5000
          this.scrollSpeed = 5000
          this.animationRoute.speedBtnText = 'x3'
          this.animationRoute.speedAnimationRouteBtnClass = 'universalicon-forward-x1'
          zoom = 17
          break
      }

      this.updateClassSpeedAnimationBtn()
      this.map.setZoom(zoom)

      console.debug('SET animation speed', zoom, this.setSpeedAnimationRouteValue)
    },
    updateClassSpeedAnimationBtn () {
      $('#speedAnimationRouteBtn').removeClass('universalicon-forward-x1')
      $('#speedAnimationRouteBtn').removeClass('universalicon-forward-x3')
      $('#speedAnimationRouteBtn').removeClass('universalicon-forward-x5')

      console.debug('updateClassSpeedAnimation', this.animationRoute.speedAnimationRouteBtnClass)
      $('#speedAnimationRouteBtn').addClass(this.animationRoute.speedAnimationRouteBtnClass)
    },

    timer (ms) {
      return new Promise(res => setTimeout(res, ms))
    },
    /**
   * @vuese
   * Procesa el arreglo de recorrido creado, para generar recorrido y  mostrarlo en mapa, con marcadores.
   */
    async AnimateRoute () {
      this.animationRoute.enabled = true
      console.debug('animationDuration', this.animationRoute.duration)

      this.viewElement(0)

      this.setPositionsItemRoute()
      for (var i = 0; i < this.reports.length; i++) {
        if (this.animationRoute.enabled) {
          // this.lockDraggable(true)
          console.debug('DIPAY:ANIMATE', i)

          var row = this.reports[i]

          // if (i == 0) {
          //   this.scrollTo(i)
          // } else {
          //   $('#' + i).prop('checked', true)
          // }
          if (i != 0) {
            $('#item' + (i - 1)).hide()
            console.debug('item', i - 1)
          }
          // $('#' + i).prop('checked', true)

          $('#item' + i).show()

          if (row.event == 'PARKING') {
            var report = row.reports[0]
            this.animationRoute.timestamp = report.timestamp
            this.map.moveMarker(
              'deviceRoute' + this.device.imei,
              report.lat,
              report.lng,
              true,
              this.animationRoute.duration
            )
            await this.timer(this.animationRoute.duration)
            this.map.setMarkerIcon('deviceRoute' + this.device.imei, 'PARKING')
            if (i + 1 < this.reports.length) {
              await this.timer(this.animationRoute.duration)
            }
          } else if (row.event == 'MOVEMENT') {
            this.map.setMarkerIcon(
              'deviceRoute' + this.device.imei,
              this.device.marker
            )

            for (var ii = 0; ii < row.reports.length; ii++) {
              report = row.reports[ii]
              if (this.animationRoute.enabled) {
                this.animationRoute.timestamp = report.timestamp
                this.map.moveMarker(
                  'deviceRoute' + this.device.imei,
                  report.lat,
                  report.lng,
                  true,
                  this.animationRoute.duration
                )
                await this.timer(this.animationRoute.duration)
              } else {
                break
              }
            }
          }
        } else {
          break
        }
      }
      // fin animacion
      // this.scrollTo(0)
      this.viewElement(1)
      // this.lockDraggable(false)
      this.map.moveMarker(
        'deviceRoute' + this.device.imei,
        this.firstReport.lat,
        this.firstReport.lng,
        false
      )
      this.map.deleteMarker('deviceRoute' + this.device.imei)
      this.boundsRoute()
      this.setAnimationRouteButtons(true, false, false, false)
    },
    /**
   * @vuese
   * Crea item para cada punto del arreglo y hacer referencia a ellos y manupularlos
   */
    setPositionsItemRoute () {
      this.positionsScroll = []
      for (let index = 0; index < this.reports.length; index++) {
        const element = this.reports[index]
        var coordenadas = $(`#item${element.id}`).position()
        this.positionsScroll.push({ id: parseInt(index + 1), positions: coordenadas.top })
      }
    },
    /**
   * @vuese
   * genera interactividad entre el recorrido y la tabla del listado de puntos.
    * @arg `index` item del arreglo
   */
    scrollTo (index) {
      if (index == 0) {
        $('#divContainerDos').animate(
          { scrollTop: 0 }, 2000
        )
      } else {
        var element = this.positionsScroll.find(x => x.id == index)

        $('#' + index).prop('checked', true)
        var positions = element.positions - 45

        $('#divContainerDos').animate(
          { scrollTop: positions }, this.scrollSpeed
        )
      }
    },
    viewElement (opc) {
      console.debug('DIspaly_CONDICIONS', opc)
      for (var i = 0; i < this.reports.length; i++) {
        if (opc == 0) {
          $('#item' + i).hide()
        }
        if (opc == 1) {
          $('#item' + i).show()
        }
      }
    },
    /**
   * @vuese
   * muestra y centra marcador
    * @arg `id` Id del marcador
    * @arg `Position` Posicion del marcador
   */
    onMarkerAnimationPositionChanged (id, position) {
      if (id == 'deviceRoute' + this.device.imei) {
        this.map.centerMap(position.lat, position.lng)
      }
    },
    /**
   * @vuese
   * muestra iconoces de animacion para el recorrido
    * @arg `play` Play de recorrido
    * @arg `stop` Stop de recorrido
    * @arg `speend` Velocidad del recorrido
   */
    setAnimationRouteButtons (play, stop, speed) {
      this.animationRoute.showPlayBtn = play
      this.animationRoute.showStopBtn = stop
      this.animationRoute.showSpeedBtn = speed
    }
  },
  watch: {
    /**
   * @vuese
   * Si se obtuvieron resulados de recorrido
    * @arg `value` Valor booleano
   */
    reportsReady (value) {
      this.drawLines()

      var date = this.fromTimestamp.format('LL')
      this.csv.filename = `Recorrido - ${this.device.alias} - ${date}.csv`
    }
  }
}
</script>

<style>
.flashit {
  -webkit-animation: flash linear 1s infinite;
  animation: flash linear 1s infinite;
}
@-webkit-keyframes flash {
  0% {
    opacity: 1;
  }
  50% {
    opacity: 0.1;
  }
  100% {
    opacity: 1;
  }
}
@keyframes flash {
  0% {
    opacity: 1;
  }
  50% {
    opacity: 0.1;
  }
  100% {
    opacity: 1;
  }
}
</style>
