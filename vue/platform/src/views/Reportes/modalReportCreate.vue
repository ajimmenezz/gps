<template>
          <!-- MODAL -->

    <div id="modalReportCreate" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
              <div class="modal-header row float-left" style="margin: 1px; padding: 5px; margin-top: 25px;  height: 50px;">
                  <div class="col-12"> <h5 class="modal-title" id="exampleModalCenterTitle" >Configurar reporte</h5></div>
                  <!-- <div class=col-1><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div> -->

                       <div class="col-12">  <p v-if="this.$store.state.modal.datosDymanic.id!=7"  class="text-muted" style="text-align: justify; font-size: 12px; margin-top: -3px;">
            Establecer los parámetros que requiera para generar el reporte</p>

            <p v-else  class="text-muted" style="text-align: justify; font-size: 12px; margin-top: -3px;">Indique el promedio de velocidad que requiera para generar el reporte</p>

             </div>

              </div>
              <div class="modal-body " style="margin-top: 15px;">
                 <component :is='dynamicComponent.component' v-if="visible" ></component>

              </div>

          </div>
      </div>
    </div>

    <!-- fin modal -->
</template>

<script>
import EventBus from '@/EventBus'
import { API } from '@/mixins/API'

// import Form1 from '@/views/Reportes/distancia'
// import Form2 from '@/views/Reportes/motor'
// import Form3 from '@/views/Reportes/sistema'
// import Form4 from '@/views/Reportes/relenti'
// import Form5 from '@/views/Reportes/paradas'
// import Form6 from '@/views/Reportes/unidad'
// import Form7 from '@/views/Reportes/velocidad'
// import Form8 from '@/views/Reportes/reporteLocalizacion'
// import Form9 from '@/views/Reportes/reporteGeofence'

/**
 * @group reportes
 * Modal para configurar reporte
 */
export default {
  name: 'ModalConfigReport',
  mixins: [API],
  data () {
    return {
      dynamicComponent: {
        component: null,
        properties: null,
        events: {

        }
      },
      visible: false
    }
  },
  created () {
    //   $('#modalReportCreate').modal('hide')
    $('#modalLoaderReport').modal('hide')
  },
  mounted () {
    $('#modalReportCreate').modal('show')
    this.$store.state.loader = false
    this.showContent()
  },
  destroyed () {

  },
  methods: {
    /**
   * @vuese
   * Limpia las variables del componenete dinamico
   */
    clearComponentsDinamic () {
      this.dynamicComponentName = null
      this.dynamicComponent.component = null
      this.dynamicComponent.properties = null
      // this.showAllDrawing(false)
      // this.showAllDrawing(false, 1)
    },
    /**
   * @vuese
   * Muestra contenido formulario de reportes
   */
    async showContent () {
      console.debug('SHOWCONTENT', this.$store.state.modal.datosDymanic)
      this.clearComponentsDinamic()

      var opc = parseFloat(this.$store.state.modal.datosDymanic.id)
      console.debug(opc)
      switch (opc) {
        case 1:
        case 2: // distancia //horas de motor
          console.debug('case1')
          this.dynamicComponentName = 'distancia'

          this.dynamicComponent.component = () => import('@/views/Reportes/distance/distancia')
          break
        case 3: // accesos
          console.debug('case3')
          this.dynamicComponentName = 'accesos sistema'

          this.dynamicComponent.component = () => import('@/views/Reportes/accesoSistem/accesos')
          break
        case 4: // ralenti
          console.debug('case4')
          this.dynamicComponentName = 'ralenti'

          this.dynamicComponent.component = () => import('@/views/Reportes/ralenti/ralenti')
          break
        case 5: // ralenti
          console.debug('case5')
          this.dynamicComponentName = 'ralenti'

          this.dynamicComponent.component = () => import('@/views/Reportes/Paradas/paradas')
          break
        case 6: // sin reportar
          console.debug('case6')
          this.dynamicComponentName = 'Sin reportar'

          this.dynamicComponent.component = () => import('@/views/Reportes/sinReportar/SinReportar')
          break
        case 7: // ralenti
          console.debug('case7')
          this.dynamicComponentName = 'velocidad'

          this.dynamicComponent.component = () => import('@/views/Reportes/velocidad/velocidad')
          break
        case 10: // ralenti
          console.debug('case10')
          this.dynamicComponentName = 'bateria'

          this.dynamicComponent.component = () => import('@/views/Reportes/bateria/bateria')
          break
      }
      this.visible = true
    }

  },
  computed: {
  }
}
</script>
