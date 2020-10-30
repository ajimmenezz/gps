<template>
    <div class="col-12"  style="margin-top: 50px;">

      <div class="row" style="margin-left: 10px; margin-right: 10px;">

                      <div class="col-12" v-show="!isEmptyReports">

                              <div class="row">
                                <span style="  content: '';
                                  background-color: #04a9f5;
                                  position: absolute;
                                  width: 4px;
                                  height: 20px;"></span>
                                   <h5 class="float-left"  style="margin-left: 20px;">Promedio de uso de motor</h5>

                              </div>
                              <!-- <div class="row" style="margin-top: 5px; margin-bottom: 15px;">
                                   <div id="lineMes" class="col-3 cursor" @click="initChartLine(1)">Mensual</div>
                                  <div id="lineSem" class="col-3 cursor" @click="initChartLine(2)">Semanal</div>
                              </div> -->

                           <div id="chart-highchart-pie1" style="width: 100%; height: 350px;"></div>

                      </div>

                      <div class="col-12"  v-show="!isEmptyReports"><hr style="margin-top: 60px; margin-bottom: 60px;"></div>

                       <div class="col-12"  v-show="!isEmptyReports">

                              <div class="row">
                                <span style="  content: '';
                                  background-color: #04a9f5;
                                  position: absolute;
                                  width: 4px;
                                  height: 20px;"></span>
                               <h5 class="float-left" style="margin-left: 20px;">Hora de uso de motor</h5>
                              </div>
                              <div class="row" style="margin-top: 5px; margin-bottom: 25px;">
                                   <div id="barMes" class="col-3 cursor" @click="initChartBar(1)">Mensual</div>
                                  <div id="barSem" class="col-3 cursor" @click="initChartBar(2)">Semanal</div>
                              </div>
                          <div id="chart-highchart-bar" style="width: 100%; height: 450px;"></div>
                      </div>

                      <div class="col-12" style="margin-bottom:30px;" v-show="isEmptyReports">No se encontraron resultados</div>
      </div>

                                    <!-- <div v-show="isEmptyReports" style="margin-bottom:30px;">No se encontraron resultados</div> -->
  </div>

</template>

<script>
import { API } from '@/mixins/API'
import { Functions } from '@/mixins/Functions'
import EventBus from '@/EventBus.js'
/**
 * @vuese
 * @group Reportes
 * resultado del reporte
 */
export default {
  name: 'ReportesGraphDist',
  mixins: [API, Functions],

  data () {
    return {
      data: null,
      reports: [],
      resultado: false
      // DataReports: null
    }
  },
  inject: ['dataGraph'],
  async created () {
    // await this.initChartProducts()
    this.$store.state.loader = true

    this.getDataGraph(this.$store.state.modal.datosDymanic.filters)
  },
  async mounted () {
    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })
    this.$store.state.seccionMenu = 'reportes'
    await EventBus.$emit('NAVBAR_MenuSimple', 'reportes')

    $('#lineMes').css({ 'font-weight': 'normal' })
    $('#lineSem').css({ 'font-weight': 'normal' })
    $('#barMes').css({ 'font-weight': 'normal' })
    $('#barSem').css({ 'font-weight': 'normal' })

    await this.initChartLine(1)
    await this.initChartBar(1)

    $('#modalLoaderReport').modal('hide')
    this.$store.commit('ADD_COMPONENT_DINAMIC_STATE_modaloader', false)
  },
  methods: {

    async getDataGraph (filters) {
      this.$store.state.loader = true
      this.reports = this.dataGraph()
      console.debug('RESUTALDO_R', this.reports)

      //  $('.highcharts-credits').css('display', 'none')

      this.resultado = true
    },
    initChartLine (opc) {
      var dataAll = [ ]
      var Setcategories = []
      var datoAll = []
      var dataAll2 = []

      // this.reports.engineRunningTime.totalSeconds
      // this.reports.engineOffTime.totalSeconds

      var totalTime = parseInt(this.reports.engineRunningTime.totalSeconds) + parseInt(this.reports.engineOffTime.totalSeconds)
      var totalEngine = (parseInt(this.reports.engineRunningTime.totalSeconds) * 100) / parseInt(totalTime)
      var totalEngineOff = (parseInt(this.reports.engineOffTime.totalSeconds) * 100) / parseInt(totalTime)
      dataAll.push(totalEngine)
      dataAll2.push(totalEngineOff)

      datoAll.push({
        name: this.reports.device.alias + ' - Encendido',
        y: totalEngine
      })
      datoAll.push({
        name: this.reports.device.alias + ' - Apagado',
        y: totalEngineOff
      })
      console.debug('DATOS_porcen motor', datoAll, 'cat', Setcategories)

      // {
      //     name: 'Installation',
      //     data: [5, 25, 15, 35, 25, 35, 45, 75, 25, 35, 45, 75]
      //   }

      // [ line-basic-chart ] Start
      Highcharts.chart('chart-highchart-pie1', {
        chart: {
          plotBackgroundColor: null,
          plotBorderWidth: null,
          plotShadow: false,
          type: 'pie'
        },
        colors: ['#1de9b6', '#1dc4e9', '#A389D4', '#899FD4', '#f44236', '#f4c22b'],
        title: {
          text: ''
        },
        tooltip: {
          pointFormat: '{data.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
          pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
              enabled: false
            },
            showInLegend: true
          }
        },
        legend: {
          layout: 'vertical',
          align: 'right',
          verticalAlign: 'middle'
        },
        series: [{

          colorByPoint: true,
          data: datoAll
        }]
      })
      $('.highcharts-credits').css('display', 'none')
      this.$store.state.loader = false
    },
    initChartBar (opc) {
      $('#barMes').css({ 'font-weight': 'normal' })
      $('#barSem').css({ 'font-weight': 'normal' })
      var dataAll = [ ]
      var dataAll2 = []
      var Setcategories = []
      var datoAll = []

      switch (opc) {
        case 1://  mes

          $('#barMes').css({ 'font-weight': 'bold' })

          Object.entries(this.reports.monthPeriods).forEach(([key, val]) => {
            Setcategories.push(this.obtenerMesString(key) + ' ' + key.substr(3, 4))
            console.debug(key.substr(3, 4), '', key, 'ELEMT_sub:BAR', val)
          })

          Object.entries(this.reports.monthPeriods).forEach(([key, ele]) => {
            dataAll.push(ele.engineRunningTime.hours)
            dataAll2.push(ele.engineOffTime.hours)

            // dataAll.push(ele.engineRunningTime.days + ' días ' + ele.engineRunningTime.hours + ' horas ' + ele.engineRunningTime.minutes + ' minutos ')
            // dataAll2.push(ele.engineOffTime.days + ' días ' + ele.engineOffTime.hours + ' horas ' + ele.engineOffTime.minutes + ' minutos ')
          })

          datoAll.push({
            name: this.reports.device.alias + ' - Encendido',
            data: dataAll
          })
          datoAll.push({
            name: this.reports.device.alias + ' - Apagado',
            data: dataAll2
          })
          console.debug('DATOS_BAR', datoAll, 'cat', Setcategories)

          break
        case 2: // semana
          $('#barSem').css({ 'font-weight': 'bold' })
          Object.entries(this.reports.weekPeriods).forEach(([key, val]) => {
            Setcategories.push(val.from.date + ' al <br>' + val.to.date + '<br> (<b>Semana ' + key.substr(0, 2) + '</b>)')
            console.debug('Sem ' + key, 'ELEMT_sub', val)
          })

          Object.entries(this.reports.weekPeriods).forEach(([key, ele]) => {
            // dataAll.push(ele.engineRunningTime.days + ' días ' + ele.engineRunningTime.hours + ' horas ' + ele.engineRunningTime.minutes + ' minutos ')
            // dataAll2.push(ele.engineOffTime.days + ' días ' + ele.engineOffTime.hours + ' horas ' + ele.engineOffTime.minutes + ' minutos ')
            dataAll.push(ele.engineRunningTime.hours)
            dataAll2.push(ele.engineOffTime.hours)

            var date = new Date(ele.engineRunningTime.totalSeconds * 1000)
            var from = this.$moment(date).fromNow()
            var fechaString = this.$moment(date).format(' MMMM DD YYYY, h:mm a')
            var FechaHora = `${fechaString} (${from})`

            var date2 = new Date(ele.engineOffTime.totalSeconds * 1000)
            var from2 = this.$moment(date2).fromNow()
            var fechaString2 = this.$moment(date2).format(' MMMM DD YYYY, h:mm a')
            var FechaHora2 = `${fechaString2} (${from2})`

            console.debug(FechaHora, 'HACE', FechaHora2)
          })

          datoAll.push({
            name: this.reports.device.alias + ' - Encendido',
            data: dataAll
          })
          datoAll.push({
            name: this.reports.device.alias + ' - Apagado',
            data: dataAll2
          })

          console.debug('DATOS_sem_BAR', datoAll, 'cat', Setcategories, 'array', dataAll, dataAll2)
          break
      }

      Highcharts.chart('chart-highchart-bar', {
        chart: {
          type: 'column'
        },
        colors: ['#1de9b6', '#1dc4e9', '#A389D4', '#899FD4'],
        title: {
          text: ''
        },
        subtitle: {
          text: ''
        },
        xAxis: {
          categories: Setcategories,
          crosshair: true
        },
        yAxis: {
          min: 0,
          title: {
            text: 'Horas uso de motor'
          }
        },
        tooltip: {
          headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
          pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} hrs</b></td></tr>',
          footerFormat: '</table>',
          shared: true,
          useHTML: true
        },
        plotOptions: {
          column: {
            pointPadding: 0.2,
            borderWidth: 0
          }
        },
        series: datoAll
      })
      $('.highcharts-credits').css('display', 'none')
      this.$store.state.loader = false
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
      return $.isEmptyObject(this.reports.monthPeriods)
    }
  }
}
</script>
