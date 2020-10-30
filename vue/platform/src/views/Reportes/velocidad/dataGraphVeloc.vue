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
                                   <h5 class="float-left"  style="margin-left: 20px;">Exceso de velocidad</h5>

                              </div>
                               <div class="row" style="margin-top: 5px; margin-bottom: 15px;">
                                  <div class="co-12 text muted">Da click en el nonbre de las unidades que desees visualizar e interactuar con la grafica</div>
                              </div>
                              <div class="row" style="margin-top: 5px; margin-bottom: 15px;">
                                   <div id="lineMes" class="col-3 cursor" @click="initChartLine(1)">Mensual</div>
                                  <div id="lineSem" class="col-3 cursor" @click="initChartLine(2)">Semanal</div>
                              </div>

                          <div id="chart-highchart-line" style="width: 100%; height: 350px;"></div>

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
  name: 'ReportesGraphVel',
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
      var device = []

      $('#lineMes').css({ 'font-weight': 'normal' })
      $('#lineSem').css({ 'font-weight': 'normal' })

      switch (opc) {
        case 1://  mes
          datoAll = []

          $('#lineMes').css({ 'font-weight': 'bold' })

          Object.entries(this.reports.monthPeriods).forEach(([key, val]) => {
            Setcategories.push(this.obtenerMesString(key) + ' ' + key.substr(3, 4))
            console.debug(key.substr(3, 4), '', key, 'ELEMT_sub', val)
          })

          Object.entries(this.reports.monthPeriods).forEach(([key, ele1]) => {
            console.debug('PRIMER FOR', key, ele1)
            var device
            Object.entries(ele1.devices).forEach(([key, ele]) => {
              console.debug(datoAll, 'SEGUNDO FOR', key, ele)
              var devis = null
              device = ele.alias

              // datoAll.push({
              //   name: ele.alias,
              //   data: [ele.maxSpeedReached]
              // })

              //   datoAll.data.push(ele.maxSpeedReached)
              console.debug('DATOALL', datoAll)

              if (datoAll.length > 0) {
                console.debug(datoAll.name, 'DATOS')
                const devices = datoAll.filter(function (element) {
                  console.debug('ELEMENTO', element)
                  return element.name == ele.alias
                })

                console.debug(devices, 'REPETIDOS', ele.alias)
                if (devices.length > 0) {
                  console.debug('SI HAY REPETIDOS', devices)
                  devices[0].data.push(parseFloat(ele.maxSpeedReached))
                } else {
                  datoAll.push({
                    name: ele.alias,
                    data: [parseFloat(ele.maxSpeedReached)]
                  })
                  console.debug('NO HAY REPETIDOS')
                }
              } else {
                datoAll.push({
                  name: ele.alias,
                  data: [parseFloat(ele.maxSpeedReached)]
                })
              }
            })

            console.debug(device, 'DISPOSIT', ele1.alias)
          })

          console.debug('DATOS 1', datoAll, 'cat', Setcategories)

          break
        case 2: // semana
          $('#lineSem').css({ 'font-weight': 'bold' })
          Object.entries(this.reports.weekPeriods).forEach(([key, val]) => {
            Setcategories.push(val.from.date + ' al <br>' + val.to.date + '<br> (<b>Semana ' + key.substr(0, 2) + '</b>)')
            console.debug('Sem ' + key, 'ELEMT_sub', val)
          })
          Object.entries(this.reports.weekPeriods).forEach(([key, ele1]) => {
            console.debug('PRIMER FOR', key, ele1)
            var device
            Object.entries(ele1.devices).forEach(([key, ele]) => {
              console.debug(datoAll, 'SEGUNDO FOR', key, ele)
              var devis = null
              device = ele.alias

              // datoAll.push({
              //   name: ele.alias,
              //   data: [ele.maxSpeedReached]
              // })

              //   datoAll.data.push(ele.maxSpeedReached)
              console.debug('DATOALL', datoAll)

              if (datoAll.length > 0) {
                console.debug(datoAll.name, 'DATOS')
                const devices = datoAll.filter(function (element) {
                  console.debug('ELEMENTO', element)
                  return element.name == ele.alias
                })

                console.debug(devices, 'REPETIDOS', ele.alias)
                if (devices.length > 0) {
                  console.debug('SI HAY REPETIDOS', devices)
                  devices[0].data.push(parseFloat(ele.maxSpeedReached))
                } else {
                  datoAll.push({
                    name: ele.alias,
                    data: [parseFloat(ele.maxSpeedReached)]
                  })
                  console.debug('NO HAY REPETIDOS')
                }
              } else {
                datoAll.push({
                  name: ele.alias,
                  data: [parseFloat(ele.maxSpeedReached)]
                })
              }
            })

            console.debug(device, 'DISPOSIT', ele1.alias)
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
        colors: ['#1de9b6', '#1dc4e9', '#A389D4', '#ffc107', '#dc3545', '#28a745'],
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
            text: 'Velocidad maxima en kilometros'
          }
        },
        legend: {
          layout: 'vertical',
          align: 'right',
          verticalAlign: 'middle'
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
              // legend: {
              //   layout: 'horizontal',
              //   align: 'center',
              //   verticalAlign: 'bottom'
              // }
              legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
              }
            }
          }]
        }
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
