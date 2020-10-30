<template>
  <div class=" row">

   <div class="col-12"> <h5 class="float-left" style="font-size: 20px; padding-bottom: 10px;"><b>graficas de resumen de almacén</b></h5></div>

           <div class=" col-12 col-md-6" v-if="this.$store.getters.permission(9) ">
              <div class="card">
                  <div class="card-header">
                      <h5>Resumen dispositivos</h5>
                  </div>
                  <div class="card-block">
                      <div><b>Total dispostivos: </b>{{this.totDevices}}</div>
                      <div id="chart-highchart-pie1" style="width: 100%; height: 350px;"></div>
                  </div>
              </div>
          </div>

          <div class=" col-12 col-md-6"  v-if="this.$store.getters.permission(10)">
              <div class="card">
                  <div class="card-header">
                      <h5>Resumen sims</h5>
                  </div>
                  <div class="card-block">
                    <div><b>Total sims: </b>{{this.totSims}}</div>
                      <div id="chart-highchart-pie2" style="width: 100%; height: 350px;"></div>
                  </div>
              </div>
          </div>

           <div class=" col-12 col-md-6" v-if="this.$store.getters.permission(17) ">
              <div class="card">
                  <div class="card-header">
                      <h5>Resumen productos genericos</h5>
                  </div>
                  <div class="card-block">
                    <div><b>Total productos: </b>{{this.totGenerico}}</div>
                      <div id="chart-highchart-pie3" style="width: 100%; height: 350px;"></div>
                  </div>
              </div>
          </div>

  </div>
</template>

<script>
import { API } from '@/mixins/API'
import EventBus from '@/EventBus'
/**
 * @vuese
 * @group Administrador/almacen/ resumen
 * Resumen de almacen
 */
export default {
  name: 'DashboardStoreChart',
  mixins: [API],
  data () {
    return {
      listSummary: [],
      totDevices: 0,
      totSims: 0,
      totGenerico: 0
    }
  },
  created () {
    this.$store.state.StoreCliente = this.$store.state.modal.datosDymanic.idCliente
    this.$store.state.StoreNameCliente = this.$store.state.modal.datosDymanic.nameClient
    this.getListSummary()
  },
  mounted () {
    // this.initChartDevice()
    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })
    this.suscribeToGrafEvents()
  },
  beforeDestroy () {
    this.unsuscribreToGrafvents()
  },
  methods: {
    /**
   * @vuese
   * se suscribe a eventos eventBus para actulizar el graficas
   */
    suscribeToGrafEvents () {
      EventBus.$on('GET_Graficas', (tipo) => {
        this.getListSummary()
        this.initChartDevice()
        this.initChartSims()
        this.initChartProducts()
      })
    },
    /**
   * @vuese
   * Se destruye la suscripcion al eventBus
   */
    unsuscribreToGrafvents () {
      EventBus.$off('GET_Graficas')
    },
    async getListSummary () {
      console.debug('ENTTRA SUMMARy')
      if (this.$store.state.StoreCliente == 0) {
        var request = await this.getRequest('store/summary')

        if (request.success === true) {
          this.listSummary = request.data.summary
          console.debug('LIST_SUMMARY', request.data.summary)
        }
      } else {
        var dato = {
          'clientID': this.$store.state.StoreCliente
        }
        var request = await this.getRequest('store/summary', dato)

        if (request.success === true) {
          this.listSummary = request.data.summary
          console.debug('LIST_SUMMARY', request.data.summary)
        }
      }
      await this.initChartDevice()
      await this.initChartSims()
      await this.initChartProducts()
      $('.highcharts-credits').css('display', 'none')
    },
    initChartDevice () {
      var datosDevice = []
      var cont = 0
      this.listSummary.forEach(element => {
        console.debug('device', element, element.productTypeID)
        if (element.productTypeID == 1) {
          cont = cont + parseFloat(element.quantity)
          datosDevice.push([ element.factory + '-' + element.model, parseFloat(element.quantity) ])
        }
      })

      this.totDevices = cont

      console.debug(cont, 'DATOS CHART', datosDevice)
      // datosDevice = [{
      //   name: 'Chrome',
      //   y: 61.41,
      //   sliced: true,
      //   selected: true
      // }, {
      //   name: 'Internet Explorer',
      //   y: 11.84
      // }, {
      //   name: 'Firefox',
      //   y: 10.85
      // }, {
      //   name: 'Edge',
      //   y: 4.67
      // }, {
      //   name: 'Safari',
      //   y: 4.18
      // }, {
      //   name: 'Other',
      //   y: 7.05
      // }]
      // [ besic-pie-chart ] Start
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

        // tooltip: { // point.percentage:.1f
        //   pointFormat: '{series.name}: <b>{point.}</b>'
        // },
        plotOptions: {
          pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            events: {
              click: function (event) {
                console.debug(event, event.point, 'CLICK', this.data, this, event.point.name, event.point.y, event.point.total)
                var datos = ''
                var i = 0
                this.data.forEach(element => {
                  i++
                  datos += i + ':   ' + element.name + ',   Total:  ' + element.y + '\n'
                })
                alert(
                  'Seleccionado:  ' + event.point.name + ',   Total:  ' + event.point.y + '\n' + 'lista: \n' + datos + '\n Total: ' + event.point.total
                )
              }
            },
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
          name: 'Dispositivos',
          colorByPoint: true,
          data: datosDevice
        }]
      })
    },
    initChartSims () {
      var datosDevice = []

      var cont = 0

      this.listSummary.forEach(element => {
        console.debug('sims', element, element.productTypeID)
        if (element.productTypeID == 2) {
          cont = cont + parseFloat(element.quantity)
          datosDevice.push([ element.factory, parseFloat(element.quantity) ])
        }
      })

      this.totSims = cont

      console.debug(cont, 'DATOS CHART_sims', datosDevice)

      // [ besic-pie-chart ] Start
      Highcharts.chart('chart-highchart-pie2', {
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
        // tooltip: { // point.percentage:.1f
        //   pointFormat: '{series.name}: <b>{point.}</b>'
        // },
        plotOptions: {
          pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            events: {
              click: function (event) {
                console.debug(event, event.point, 'CLICK', this.data, this, event.point.name, event.point.y, event.point.total)
                var datos = ''
                var i = 0
                this.data.forEach(element => {
                  i++
                  datos += i + ':   ' + element.name + ',   Total:  ' + element.y + '\n'
                })
                alert(
                  'Seleccionado:  ' + event.point.name + ',   Total:  ' + event.point.y + '\n' + 'lista: \n' + datos + '\n Total: ' + event.point.total
                )
              }
            },
            dataLabels: {
              enabled: false
            },
            showInLegend: true
          }
        },
        series: [{
          name: 'Sims',
          colorByPoint: true,
          data: datosDevice
        }]
      })
    },
    initChartProducts () {
      var datosDevice = []
      var cont = 0

      this.listSummary.forEach(element => {
        console.debug('genericp', element, element.productTypeID)
        if (element.productTypeID == 3) {
          cont = cont + parseFloat(element.quantity)
          datosDevice.push([ element.factory + '-' + element.model, parseFloat(element.quantity) ])
        }
      })

      this.totGenerico = cont
      console.debug(cont, 'DATOS CHART_generico', datosDevice)

      // [ besic-pie-chart ] Start
      Highcharts.chart('chart-highchart-pie3', {
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
        // tooltip: { // point.percentage:.1f
        //   pointFormat: '{series.name}: <b>{point.}</b>'
        // },
        plotOptions: {
          pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            events: {
              click: function (event) {
                console.debug(event, event.point, 'CLICK', this.data, this, event.point.name, event.point.y, event.point.total)
                var datos = ''
                var i = 0
                this.data.forEach(element => {
                  i++
                  datos += i + ':   ' + element.name + ',   Total:  ' + element.y + '\n'
                })
                alert(
                  'Seleccionado:  ' + event.point.name + ',   Total:  ' + event.point.y + '\n' + 'lista: \n' + datos + '\n Total: ' + event.point.total
                )
              }
            },
            dataLabels: {
              enabled: false
            },
            showInLegend: true
          }
        },
        series: [{
          name: 'Productos',
          colorByPoint: true,
          data: datosDevice
        }]
      })
    }

  },
  computed: {

  }
}
</script>

<style>

</style>
