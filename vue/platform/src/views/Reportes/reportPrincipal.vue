<template>
  <div class="row m-r-5" >
      <div class="col-12">
        <div class="row">
          <div class="col-5" style="margin-top:60px;"> <h5 class="float-left" style="font-size: 20px; padding-bottom: 10px;"><b>Reportes</b></h5></div>
          <div class="col-7 float-right" style="margin-top:60px;">
            <div class="input-group input-group-sm mb-3 float-right" style="width: auto !important;">
                <div class="input-group-prepend float-right" style="height:35px; color: #fff; background-color: #04a9f5; border-color: #04a9f5;">
                  <i class=" icon-small universalicon-search " style="padding: 4px; padding-top: 5px;"></i>
                    <span class="input-group-text " id="inputGroup-sizing-sm" style="border: #04a9f5; padding-left:2px;  color: #ffff !important; background-color: #04a9f5; border-color: #04a9f5;">Buscar</span>
                </div>

                <config-input id="deviceSearcher" label="null" required="false"

                  typeinput="text" placeholder="Nombre de reporte"
                  @input="filterLista"
                  paddingConf="6px 12px" backgroundd="#ffff"></config-input>
            </div>

          </div>
        </div>
      </div>
      <div class="col-12"> <hr style="margin-bottom: 70px;  margin-top: -25px;"></div>

            <div class="col-12 col-sm-6 col-md-4" v-for="(rep,index) in listReport" :key="index">
                <div class="card " style=" height: 130px;">
                    <div class="card-body " style="padding:0px">
                                <div class="row row-Card" style=" align-content: center; ">
                                  <div class="col-4 col-content1" >
                                    <img class="float-left img-fluid img-report" :src="`img/reports/${rep.img}`" >
                                  </div>
                                  <div class="col-8 float-left col-content2" >
                                     <p style="font-weight: bold;">{{rep.name}}</p>
                                    <div  style="margin-top:10px;" >
                                      <span class="cursor" style="color:#1487EB !important; " @click="verReport(rep.id)">Ver reporte</span>
                                    </div>
                                  </div>
                                </div>

                    </div>

                </div>
            </div>

  </div>

</template>

<script>
import { API } from '@/mixins/API'
import { Functions } from '@/mixins/Functions.js'
import EventBus from '@/EventBus.js'
import modalReportCreated from '@/views/Reportes/modalReportCreate'
/**
 * @vuese
 * @group Reportes
 * pantalla principal, para crear reportes de localización y geocercas
 */
export default {
  name: 'MenuPrincipalReportes',
  mixins: [API, Functions],
  data () {
    return {
      tipoClient: null,
      listReport: [],
      listReportOrigin: []
    }
  },
  created () {
    this.tipoClient = sessionStorage.TC
    this.getListReport()
  },
  async mounted () {
    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })
    this.$store.state.seccionMenu = 'reportes'
    await EventBus.$emit('NAVBAR_MenuSimple', 'reportes')
  },
  methods: {
    getListReport () {
      this.listReport = [
        { 'id': 1, 'name': 'Reporte de distancia recorrida', 'img': 'report1.png' },
        { 'id': 2, 'name': 'Reporte de horas de uso de motor', 'img': 'report2.png' },
        { 'id': 3, 'name': 'Reporte de accesos al sistema', 'img': 'report3.png' },
        { 'id': 4, 'name': 'Reporte de encendido y sin movimiento', 'img': 'report4.png' },
        { 'id': 5, 'name': 'Reporte de paradas', 'img': 'report5.png' },
        { 'id': 6, 'name': 'Reporte sin reportar unidad', 'img': 'report6.png' },
        { 'id': 7, 'name': 'Reporte de velocidad', 'img': 'report7.png' },
        { 'id': 8, 'name': 'Reporte de localización', 'img': 'report8.png' },
        { 'id': 9, 'name': 'Reporte de geocercas', 'img': 'report9.png' },
        { 'id': 10, 'name': 'Reporte nivel de bateria', 'img': 'report10.png' }

      ]

      console.debug('REPORTES', this.listReport)
      this.listReportOrigin = this.listReport
      // this.listReport.push( {'name':  ,'img': })
    },
    /**
   * @vuese
   * Obtiene resultados de coincidencias del string con lista de reportes
   * @arg `searchTerm` String de filtro
   */
    filterLista (searchTerm) {
      var tipo = 'report'
      this.listReport = this.filterList(this.listReportOrigin, 'name', searchTerm, tipo)
    },
    /**
   * @vuese
   * Abre el modal para crear reporte
   * @arg `id` Id de reporte
   */
    async verReport (id) {
      // $('#modalLoaderReport').modal('hide')
      // $('#modalReportCreate').modal('hide')
      this.$store.commit('CLEAR_MODAL_DINAMIC')
      this.$store.state.loader = false

      if (id == 8 || id == 9) {
        if (id == 8) {
          this.$router.push('reportLocate')
        }
        if (id == 9) {
          this.$router.push('reportGeofence')
        }
      } else {
        var rep = this.listReportOrigin.find(x => x.id == id)

        var datos = {
          'component': modalReportCreated,
          'datos': {
            'seccion': 'reprote',
            'id': id,
            'tittle': rep.name

          }
        }

        await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)

        await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)

        //  $('#modalReportCreate').modal('show')
        console.debug('MODAL_EDITAR_prin', this.$store.state.modal)
      }
    }

  },
  computed: {

  }
}
</script>

<style >
/* extra small */
@media  (max-width: 576px) {
   .row-Card{
        height: 100%;

  }
  .img-report{
  width: 70%;
      margin-left: 30px;
      padding-top: 10px;

  }

  .col-content1{
  padding-right: 20px
  }

  .col-content2{
  border-left: 1px solid #a99d9df5;     padding-top: 20px; padding-right: 35px; padding-left: 20px;
  }
}
/* small */
@media  (min-width: 576px) and (max-width:768px){
  .row-Card{
        height: 100%;

  }
  .img-report{
  width: 95%;
      margin-left: 10px;
      padding-top: 10px;

  }

  .col-content1{
  /* padding-right: 20px; */
  }

  .col-content2{
  border-left: 1px solid #a99d9df5;
    padding-top: 10px;
   padding-right: 35px; padding-left: 20px;
  }
}

/* medium */
@media  (min-width: 768px) and (max-width: 992px) {
   .row-Card{
        height: 100%;

  }
  .img-report{
  width: 95%;
      margin-left: 10px;
      padding-top: 10px;

  }

  .col-content1{
  padding-right: 20px
  }

  .col-content2{
  border-left: 1px solid #a99d9df5;
    /* padding-top: 20px; */
   padding-right: 35px; padding-left: 20px;
  }
}
/* large */
@media  (min-width: 992px) and (max-width: 1200px){
  .row-Card{
        height: 100%;

  }
  .img-report{
  width: 95%;
      margin-left: 10px;
      padding-top: 10px;

  }

  .col-content1{
  padding-right: 20px
  }

  .col-content2{
  border-left: 1px solid #a99d9df5;
    /* padding-top: 20px; */
   padding-right: 35px; padding-left: 20px;
  }
}
/* extra large */
@media (min-width: 1200px) and ( max-width: 1600px){
  .row-Card{
        height: 100%;

  }
  .img-report{
  width: 89%;
      margin-left: 12px;
      padding-top: 10px;

  }

  .col-content1{
  padding-right: 20px
  }

  .col-content2{
  border-left: 1px solid #a99d9df5;
    padding-top: 10px;
   padding-right: 35px; padding-left: 20px;
  }
}

@media   (min-width: 1600px) and ( max-width: 1900px){
   .row-Card{
        height: 100%;

  }
  .img-report{
  width: 70%;
      margin-left: 35px;
      /* padding-top: 10px; */

  }

  .col-content1{
  padding-right: 20px
  }

  .col-content2{
  border-left: 1px solid #a99d9df5;
    padding-top: 10px;
   padding-right: 35px; padding-left: 20px;
  }
}

@media   (min-width: 1901px){
   .row-Card{
        height: 100%;

  }
  .img-report{
  width: 50%;
      margin-left: 35px;
      /* padding-top: 10px; */

  }

  .col-content1{
  padding-right: 20px
  }

  .col-content2{
  border-left: 1px solid #a99d9df5;
    padding-top: 10px;
   padding-right: 35px; padding-left: 20px;
  }
}

</style>
