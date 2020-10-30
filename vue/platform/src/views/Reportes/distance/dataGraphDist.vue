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
                                   <h5 class="float-left"  style="margin-left: 20px;">Distancia recorrida</h5>

                              </div>
                              <div class="row" style="margin-top: 5px; margin-bottom: 15px;">
                                   <div id="lineMes" class="col-3 cursor" @click="initChartLine(1)">Mensual</div>
                                  <div id="lineSem" class="col-3 cursor" @click="initChartLine(2)">Semanal</div>
                              </div>

                          <div id="chart-highchart-line" style="width: 100%; height: 350px;"></div>

                      </div>

                      <div class="col-12"  v-show="!isEmptyReports"><hr style="margin-top: 60px; margin-bottom: 60px;"></div>

                       <div class="col-12"  v-show="!isEmptyReports">

                              <div class="row">
                                <span style="  content: '';
                                  background-color: #04a9f5;
                                  position: absolute;
                                  width: 4px;
                                  height: 20px;"></span>
                               <h5 class="float-left" style="margin-left: 20px;">Promedio distancia recorrida</h5>
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

    this.$store.state.loader = false
  },
  methods: {

    async getDataGraph (filters) {
      this.$store.state.loader = true
      this.reports = this.dataGraph()
      console.debug('RESUTALDO_R', this.reports)

      //  $('.highcharts-credits').css('display', 'none')

      this.resultado = true
      this.$store.state.loader = false
    },
    initChartLine (opc) {
      var dataAll = [ ]
      var Setcategories = []
      var datoAll = []

      $('#lineMes').css({ 'font-weight': 'normal' })
      $('#lineSem').css({ 'font-weight': 'normal' })

      switch (opc) {
        case 1://  mes

          $('#lineMes').css({ 'font-weight': 'bold' })

          Object.entries(this.reports.monthPeriods).forEach(([key, val]) => {
            Setcategories.push(this.obtenerMesString(key) + ' ' + key.substr(3, 4))
            console.debug(key.substr(3, 4), '', key, 'ELEMT_sub', val)
          })

          Object.entries(this.reports.monthPeriods).forEach(([key, ele]) => {
            dataAll.push(ele.distanceTraveled)
          })

          datoAll.push({
            name: this.reports.device.alias,
            data: dataAll
          })
          console.debug('DATOS 1', datoAll, 'cat', Setcategories)

          break
        case 2: // semana
          $('#lineSem').css({ 'font-weight': 'bold' })
          Object.entries(this.reports.weekPeriods).forEach(([key, val]) => {
            Setcategories.push(val.from.date + ' al <br>' + val.to.date + '<br> (<b>Semana ' + key.substr(0, 2) + '</b>)')
            console.debug('Sem ' + key, 'ELEMT_sub', val)
          })

          Object.entries(this.reports.weekPeriods).forEach(([key, ele]) => {
            dataAll.push(ele.distanceTraveled)
          })

          datoAll.push({
            name: this.reports.device.alias,
            data: dataAll
          })
          console.debug('DATOS_sem 1', datoAll, 'cat', Setcategories)
          break
      }
      // {
      //     name: 'Installation',
      //     data: [5, 25, 15, 35, 25, 35, 45, 75, 25, 35, 45, 75]
      //   }

      // [ line-basic-chart ] Start
      Highcharts.chart('chart-highchart-line', {
        chart: {
          type: 'spline'
        },
        colors: ['#1de9b6', '#1dc4e9', '#A389D4'],
        title: {
          text: ''
        },
        subtitle: {
          text: ''
        },
        xAxis: {
          categories: Setcategories
        },
        yAxis: {
          title: {
            text: 'Distancia recorrida en kilometros'
          }
        },
        plotOptions: {
          // series: {
          //   label: {
          //     connectorAllowed: false
          //   },
          //   pointStart: 2010
          // }
          line: {
            dataLabels: {
              enabled: true
            },
            enableMouseTracking: false
          }
        },
        tooltip: {
          headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
          pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} km</b></td></tr>',
          footerFormat: '</table>',
          shared: true,
          useHTML: true
        },
        series: datoAll,
        responsive: {
          rules: [{
            condition: {
              maxWidth: 500
            },
            chartOptions: {
              legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom'
              }
            }
          }]
        }
      })
      $('.highcharts-credits').css('display', 'none')
      $('#modalLoaderReport').modal('hide')
      this.$store.commit('ADD_COMPONENT_DINAMIC_STATE_modaloader', false)
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
            dataAll.push(ele.distanceTraveledAverage)
            // dataAll2.push(ele.maxSpeedReached)
          })

          datoAll.push({
            name: this.reports.device.alias,
            data: dataAll
          })
          // datoAll.push({
          //   name: ' velocidad maxima',
          //   data: dataAll2
          // })
          console.debug('DATOS_BAR', datoAll, 'cat', Setcategories)

          break
        case 2: // semana

          $('#barSem').css({ 'font-weight': 'bold' })

          Object.entries(this.reports.weekPeriods).forEach(([key, val]) => {
            Setcategories.push(val.from.date + ' al <br>' + val.to.date + '<br> (<b>Semana ' + key.substr(0, 2) + '</b>)')
            console.debug('Sem ' + key, 'ELEMT_sub', val)
          })

          Object.entries(this.reports.weekPeriods).forEach(([key, ele]) => {
            //   dataAll.push({ name: 'Semana ' + key.substr(0, 2), y: ele.distanceTraveledAverage })
            dataAll.push(ele.distanceTraveledAverage)
            // dataAll2.push(ele.maxSpeedReached)
          })

          datoAll.push({
            name: this.reports.device.alias,
            data: dataAll
          })
          // datoAll.push({
          //   name: ' velocidad maxima',
          //   data: dataAll2
          // })
          console.debug('DATOS_sem_BAR', datoAll, 'cat', Setcategories)
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
            text: 'Promedio de distancia en kilometros'
          }
        },
        tooltip: {
          headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
          pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} km</b></td></tr>',
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
      $('#modalLoaderReport').modal('hide')
      this.$store.commit('ADD_COMPONENT_DINAMIC_STATE_modaloader', false)
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
