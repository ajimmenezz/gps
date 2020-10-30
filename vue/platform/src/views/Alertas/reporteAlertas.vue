<template>
<div class="row-content">
  <loader v-if="loader.visible" message="Obteniendo datos, espere porfavor."/>
  <div class="col-8 text-left">
      <h5 class="text--title">Alertas</h5>
      <small class="">Consulta las notificaciones y alertas de tu dispositivos</small>
  </div>
   <div class="col-4 text-right">
    <button id="date-report" class="btn btn-primary btn-sm" style="margin-top:15px;">Nueva consulta</button>
  </div>
  <div class="col-12"><hr/></div>

  <div class="col-12 text-left" style="margin-top:15px;">
        Mostrando alertas desde las <b>{{alertsTable.params.fromTimestamp|moment('h:mm:ss a')}}</b>
        hasta las <b>{{alertsTable.params.toTimestamp|moment('h:mm:ss a')}}</b>
  </div>

  <div class="col-12" style="margin-top:40px;">
    <data-table
        ref="alertsTable"
        :showIndex="false"
        :paging="true"
        :responsive="true"
        :showEditButton="false"
        :showWatchButton="false"
        :showDeleteButton="false"/>
  </div>
</div>
</template>

<script>
import { API } from '@/mixins/API'
import EventBus from '@/EventBus'
import loader from '@/components/loader/loader.vue'
import dataTable from '@/components/DataTable/DataTable.vue'

export default {
  name: 'Alertas',
  mixins: [API],
  components: {
    loader,
    dataTable
  },
  data () {
    return {
      loader: {
        visible: false
      },
      alertsTable: {
        params: {
          fromTimestamp: 0,
          toTimestamp: 0
        },
        headers: [
          {
            title: 'Fecha',
            key: 'date',
            orderable: true,
            searchable: true
          },
          {
            title: 'Evento',
            key: 'reportType',
            orderable: true,
            searchable: true
          },
          {
            title: 'Unidad',
            key: 'alias',
            orderable: true,
            searchable: true
          },
          {
            title: 'Direccion',
            key: 'adress',
            orderable: true,
            searchable: true,
            default: '<span style="font-style: italic">No disponible</span>',
            width: 150
          },
          {
            title: 'Geocerca',
            key: 'geofenceName',
            orderable: true,
            searchable: true,
            default: '<span style="font-style: italic">No aplica</span>'
          }
        ],
        rows: []
      }
    }
  },
  async mounted () {
    this.$store.state.seccionMenu = 'alertas'
    await EventBus.$emit('NAVBAR_MenuSimple', 'alertas')

    this.$refs.alertsTable.Render(this.alertsTable.headers, this.alertsTable.rows)

    this.alertsTable.params.fromTimestamp = this.$moment().subtract(3, 'hours').unix()
    this.alertsTable.params.toTimestamp = this.$moment().unix()

    this.initializeDatePicker()

    EventBus.$on('refresh_dataTable', this.OnMenuSizeChanged)
    await this.GetAlerts(this.alertsTable.params.fromTimestamp, this.alertsTable.params.toTimestamp)
  },
  methods: {
    OnMenuSizeChanged () {
      console.debug('Refresh Table alerts')
      this.$refs.alertsTable.Refresh()
    },
    initializeDatePicker () {
      $('#date-report')
        .bootstrapMaterialDatePicker({
          lang: 'es',
          currentDate: this.fromTimestamp,
          // minDate: this.$moment(this.fromTimestamp).startOf('day'),
          maxDate: this.$moment(this.fromTimestamp).endOf('day'),
          year: false,
          date: true,
          time: true,
          shortTime: true,
          format: 'LLL a'
        })
        .on('change', this.onDateChanged)
    },
    async GetAlerts (fromTimestamp, toTimestamp) {
      this.loader.visible = true

      var params = {
        fromTimestamp: fromTimestamp,
        toTimestamp: toTimestamp
      }
      var response = await this.getRequest('reports/alerts', params)

      this.alertsTable.rows = response.data.reports
      this.alertsTable.rows.forEach(row => {
        row.date = this.$moment(row.timestamp * 1000).format('LL h:mm:ss a')
      })

      this.$refs.alertsTable.SetRows(this.alertsTable.rows)
      this.loader.visible = false
    },
    async onDateChanged (sender, date) {
      this.alertsTable.params.fromTimestamp = this.$moment(date).unix()
      this.alertsTable.params.toTimestamp = this.$moment(date).add(3, 'hour').unix()

      await this.GetAlerts(this.alertsTable.params.fromTimestamp, this.alertsTable.params.toTimestamp)
    }

  }
}
</script>

<style scoped>
.dt-adress{
  max-width: 300px !important;
  word-wrap: break-word !important;
}

</style>
