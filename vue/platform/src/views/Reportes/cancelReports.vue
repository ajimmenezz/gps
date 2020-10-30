<template>
  <div class="row m-r-5" style="padding-left:10px;">

        <div class="col-12" style="margin-top:60px;">
          <div class="row">

            <div class="col-12"> <h5 class="float-left" style="font-size: 20px; padding-bottom: 10px;"><b>{{this.$store.state.modal.datosDymanic.tittle}}</b></h5></div>
            <div class="col-12" style="margin-top: -12px;">  <p v-if="subtittle" class="text-muted" style="text-align: justify; font-size: 12px; ">
              {{this.subtittle}}</p>
            </div>
          </div>
        </div>
      <div class="col-12"> <hr style="  margin-top: -10px;">
       <nav aria-label="breadcrumb" style="margin-top: -16px; margin-bottom: -15px;">
              <ol class="breadcrumb">
                  <li class="breadcrumb-item">   <router-link to="/reports" >Reportes </router-link></li>
                  <li class="breadcrumb-item active" aria-current="page" >reporte cancelado</li>
              </ol>
          </nav>
          </div>

        <div class="col-12" >
              <div class="card " >
                      <div class="card-body " style="padding:0px">
                                  <div class="row" style=" margin: 15px; ">

                                      <div class="col-12 float-left" style="  height: 100px; font-size:22px;">
                                       <b>Hemos Detectado</b>, que generaste un reporte y no se ha completado, da click en el botón para generar un <b>Nuevo Reporte</b>.
                                      </div>
                                      <div class="col-12 float-right">
                                            <button type="button" class="btn btn-primary btn-sm" @click="nuevoReport()" style="right: 15px; position: absolute;  bottom: 0px;">NUEVO REPORTE</button>
                                      </div>
                                  </div>

                      </div>

                  </div>
        </div>

  </div>

</template>

<script>
import { API } from '@/mixins/API'
import EventBus from '@/EventBus.js'
/**
 * @vuese
 * @group Reportes
 * cancelar  reporte
 */
export default {
  name: 'ReportesCancel',
  mixins: [API],
  data () {
    return {
      subtittle: ''
    }
  },
  created () {
    this.tipoClient = sessionStorage.TC

    this.$store.state.loader = true
  },
  async mounted () {
    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })
    this.$store.state.seccionMenu = 'reportes'
    await EventBus.$emit('NAVBAR_MenuSimple', 'reportes')

    if (this.$store.state.modal.datosDymanic.subtittle != undefined && this.$store.state.modal.datosDymanic.subtittle != '' && this.$store.state.modal.datosDymanic.subtittle != null) {
      this.subtittle = this.$store.state.modal.datosDymanic.subtittle
    } else {
      this.subtittle = 'Reporte de Distancia Recorrida permite diseñar desde el inicio la estructura de un reporte y el tipo de datos que va a incluir.'
    }

    this.$store.state.loader = false
  },
  methods: {

    async cancel () {
      this.$router.push('reports')
      await $('#modalReportCreate').modal('hide')
      this.$store.commit('CLEAR_MODAL_DINAMIC')
    },
    async nuevoReport () {
      this.$router.push('reports')
      await $('#modalReportCreate').modal('show')
      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
    }

  },
  computed: {

  }
}
</script>

<style>

</style>
