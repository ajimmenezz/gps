<template>
    <div class="col-12"  style="margin-top: 50px;">

      <div class="col-12" v-if="!isEmptyReports" > <h5 class="float-left text-muted" style="font-size: 20px; padding-bottom: 10px;"><b>Velocidad</b></h5></div>
      <div class="table-responsive" v-if="showData && !isEmptyReports">
                                                <table id="zero-configuration" class="display table nowrap table-striped table-hover" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Unidad</th>
                                                            <th>Fecha inicial</th>
                                                            <th>Fecha final</th>
                                                            <th>Exceso de velocidad</th>
                                                            <th>Velocidad maxima</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(item,index) in gwtData" :key="index">
                                                            <td>{{item.alias}}</td>
                                                            <td>{{item.from.date}}</td>
                                                            <td>{{item.to.date}}</td>
                                                            <td>{{item.infractions}} </td>
                                                            <td>{{item.maxSpeedReached}} km/hr</td>
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
import { API } from '@/mixins/API'
import EventBus from '@/EventBus.js'
/**
 * @vuese
 * @group Reportes
 * resultado del reporte
 */
export default {
  name: 'ReportesTableVel',
  mixins: [API],

  data () {
    return {
      data: null,
      reports: [],
      resultado: false
      // DataReports: null
    }
  },
  inject: ['getDraggableProperties'],
  created () {
    this.$store.state.loader = true
    this.getDataTable(this.$store.state.modal.datosDymanic.filters)
  },
  async mounted () {
    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })
    this.$store.state.seccionMenu = 'reportes'
    await EventBus.$emit('NAVBAR_MenuSimple', 'reportes')

    $('#zero-configuration').DataTable({
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
  },
  methods: {
    async getDataTable () {
      this.$store.state.loader = true

      var data = this.getDraggableProperties()// Object.values(this.getDraggableProperties())
      console.debug('RESUTALDO_R_TABLE', data)
      var datos = []
      var devicesAll = []
      Object.entries(data).forEach(([key, val]) => {
        console.debug(key, 'ELEMT', val)
        // val.devices[val.devices.alias].from = val.from
        // val.devices[val.devices.alias].to = val.to

        Object.entries(val.devices).forEach(([key, ele]) => {
          ele.from = val.from
          ele.to = val.to
          console.debug(val.from.date, val.to.date, 'ELEMENTO', ele)
          datos.push(ele)
        })

        // datos.push(val.devices)

        console.debug(key, 'ELEMT', val, datos)
      })

      this.reports = datos

      this.resultado = true
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
