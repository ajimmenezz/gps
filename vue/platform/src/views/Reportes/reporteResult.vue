<template>
  <div class="row m-r-10" style="padding-left:10px;">
    <!-- <div class="col-1" style="margin-top:60px; padding-right:0px;" @click="cancel()">
            <span> <i class=" icon-small universalicon-left cursor" style="padding: 4px; padding-top: 5px;"></i></span>
    </div>-->
    <div class="col-12" style="margin-top:60px; ">
      <div class="row">
        <div class="col-12">
          <h5 class="float-left" style="font-size: 20px; padding-bottom: 10px;">
            <b>{{this.$store.state.modal.datosDymanic.tittle}}</b>
          </h5>
        </div>
        <div class="col-12" style="margin-top: -12px;">
          <p
            class="text-muted"
            style="text-align: justify; font-size: 12px; "
          >{{this.$store.state.modal.datosDymanic.subtittle}}</p>
        </div>
      </div>
    </div>
    <div class="col-12">
      <hr style="  margin-top: -10px;" />
      <nav aria-label="breadcrumb" style="margin-top: -16px; margin-bottom: -15px;">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <router-link to="/reports">Reportes</router-link>
          </li>
          <li
            class="breadcrumb-item active"
            aria-current="page"
          >{{this.$store.state.modal.datosDymanic.tittle}}</li>
        </ol>
      </nav>
    </div>

    <div class="col-12">
      <div class="card" style>
        <div class="card-body" style="padding: 27px 30px;">
          <div class="row" style=" align-content: center;">
            <div class="col-10">
              <div
                class="row report float-left"
                v-if="show && this.$store.state.modal.datosDymanic.id==1"
              >
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Unidad (es):</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label class="float-left">{{getData.device.alias}}</label>
                </div>

                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Fecha inicial:</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label class="float-left">{{this.$store.state.modal.datosDymanic.fechaIni}}</label>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Distancia total:</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label class="float-left">{{getData.distanceTraveled}} km/h</label>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Fecha final:</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label class="float-left">{{this.$store.state.modal.datosDymanic.fechaFin}}</label>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Promedio de distancia por día:</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label class="float-left">{{getData.distanceTraveledAverage}} km</label>
                </div>
              </div>

              <div
                class="row report float-left"
                v-if="show && this.$store.state.modal.datosDymanic.id==2"
              >
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Unidad (es):</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label class="float-left">{{getData.device.alias}}</label>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Fecha inicial:</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label class="float-left">{{this.$store.state.modal.datosDymanic.fechaIni}}</label>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Tiempo total encendido:</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label
                    class="float-left"
                  >{{getData.engineRunningTime.days}} días {{getData.engineRunningTime.hours}} horas {{getData.engineRunningTime.minutes}} minutos</label>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Fecha final:</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label class="float-left">{{this.$store.state.modal.datosDymanic.fechaFin}}</label>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Tiempo total apagado:</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label
                    class="float-left"
                  >{{getData.engineOffTime.days}} días {{getData.engineOffTime.hours}} horas {{getData.engineOffTime.minutes}} minutos</label>
                </div>
              </div>

              <div
                class="row report float-left"
                v-if="show && this.$store.state.modal.datosDymanic.id==3"
              >
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Nombre de usuario:</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label class="float-left">{{getData.user.alias}}</label>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Fecha inicial:</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label class="float-left">{{this.$store.state.modal.datosDymanic.fechaIni}}</label>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Total de accesos:</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label class="float-left">{{getData.totalAccess}}</label>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Fecha final:</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label class="float-left">{{this.$store.state.modal.datosDymanic.fechaFin}}</label>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Promedio de accesos por día:</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label class="float-left">pend</label>
                </div>
              </div>

              <div
                class="row report float-left"
                v-if="show && this.$store.state.modal.datosDymanic.id==4"
              >
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Unidad (es):</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label class="float-left">{{getData.device.alias}}</label>
                </div>

                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Fecha inicial:</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label class="float-left">{{this.$store.state.modal.datosDymanic.fechaIni}}</label>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Tiempo total:</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label
                    class="float-left"
                  >
                  <template v-if="getData.ralentiTime.days">{{getData.ralentiTime.days}} días </template><template v-if="getData.ralentiTime.hours">{{getData.ralentiTime.hours}} horas </template>{{getData.ralentiTime.minutes}} minutos</label>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Fecha final:</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label class="float-left">{{this.$store.state.modal.datosDymanic.fechaFin}}</label>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Tiempo maximo (continuo):</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label
                    class="float-left"
                  >
                  <template v-if="getData.maxRalentiTime.days">{{getData.maxRalentiTime.days}} días </template><template v-if="getData.maxRalentiTime.hours">{{getData.maxRalentiTime.hours}} horas </template> {{getData.maxRalentiTime.minutes}} minutos</label>
                </div>
              </div>

              <div
                class="row report float-left"
                v-if="show && this.$store.state.modal.datosDymanic.id==5"
              >
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Unidad (es):</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label class="float-left">{{getData.device.alias}}</label>
                </div>

                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Fecha inicial:</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label class="float-left">{{this.$store.state.modal.datosDymanic.fechaIni}}</label>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Total de paradas realizadas:</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label class="float-left">{{getData.reports.length}}</label>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Fecha final:</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label class="float-left">{{this.$store.state.modal.datosDymanic.fechaFin}}</label>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Tiempo de unidad parada:</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label
                    class="float-left"
                  >{{this.$store.state.modal.datosDymanic.filters.time}} minutos</label>
                </div>
              </div>
              <div
                class="row report float-left"
                v-if="show && this.$store.state.modal.datosDymanic.id==6"
              >
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Unidad (es):</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label class="float-left">{{getData.device.alias}}</label>
                </div>

                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Fecha inicial:</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label class="float-left">{{this.$store.state.modal.datosDymanic.fechaIni}}</label>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Tiempo total sin reportar:</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label
                    class="float-left"
                  >{{getData.resume.totalTime.days}} días {{getData.resume.totalTime.hours}} horas {{getData.resume.totalTime.minutes}} minutos</label>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Fecha final:</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label class="float-left">{{this.$store.state.modal.datosDymanic.fechaFin}}</label>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Promedio de tiempo sin reportar:</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label
                    class="float-left"
                  >{{getData.resume.maxTime.days}} días {{getData.resume.maxTime.hours}} horas {{getData.resume.maxTime.minutes}} minutos</label>
                </div>
              </div>

              <div
                class="row report float-left"
                v-if="show && this.$store.state.modal.datosDymanic.id==7"
              >
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <!-- <strong class="reportResult">Unidad (es): </strong> -->
                  <strong class="reportResult">Limite de exceso de velocidad:</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label
                    class="float-left"
                  >{{this.$store.state.modal.datosDymanic.filters.speed}} km/hr</label>
                </div>

                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Fecha inicial:</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label class="float-left">{{this.$store.state.modal.datosDymanic.fechaIni}}</label>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Velocidad promedio:</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label class="float-left">{{getData.resume.speedAverage}} km/hr</label>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Fecha final:</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label class="float-left">{{this.$store.state.modal.datosDymanic.fechaFin}}</label>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Velocidad maxima alcanzada:</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label class="float-left">{{getData.resume.maxSpeedReached}} km/hr</label>
                </div>
              </div>

              <div
                class="row report float-left"
                v-if="show && this.$store.state.modal.datosDymanic.id==10"
              >
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Unidad (es):</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label class="float-left">{{getData.device.alias}}</label>
                </div>

                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Fecha inicial:</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label class="float-left">{{this.$store.state.modal.datosDymanic.fechaIni}}</label>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Promedio de voltaje de bateria interna:</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label class="float-left">{{getData.resume.batteryAverage}} V</label>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Fecha final:</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label class="float-left">{{this.$store.state.modal.datosDymanic.fechaFin}}</label>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <strong class="reportResult">Promedio de voltaje de corriente externa:</strong>
                </div>
                <div class="big-text col-12 col-sm-6 col-md-3">
                  <label class="float-left">{{getData.resume.powerSupplyAverage}} V</label>
                </div>
              </div>
            </div>
            <div class="col-2">
              <button
                type="button"
                class="btn btn-primary btn-sm"
                @click="cancel()"
                style="right: -1px; position: absolute;  bottom: 0px;"
              >NUEVO REPORTE</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12">
      <div class="card">
        <div class="card-body" style="padding:0px">
          <div
            class="row"
            style=" align-content: center; margin: 0px 15px;"
            v-if="this.$store.state.modal.datosDymanic.id !=5"
          >
            <div class="col-6" style="margin-top:50px; padding:0px;">
              <ul
                class="nav nav-tabs"
                id="myTab"
                role="tablist"
                style="border-bottom: solid 1px #b7b7b7de;"
              >
                <li class="nav-item cursor">
                  <a
                    id="dash"
                    class="nav-link h-blue active text-uppercase cursor btn-outline-primary"
                    data-toggle="tab"
                    role="tab"
                    @click="showContentOpction(1)"
                    style="border: 1px solid #04a9f5; color: #04a9f5;"
                  >Dashboard</a>
                </li>
                <li class="nav-item cursor">
                  <a
                    id="table"
                    class="nav-link h-blue text-uppercase cursor btn-outline-primary"
                    data-toggle="tab"
                    role="tab"
                    @click="showContentOpction(2)"
                    style="border: 1px solid #04a9f5; color: #04a9f5;"
                  >Reporte</a>
                </li>
              </ul>
            </div>
            <div
              class="col-6 float-right"
              style="border-bottom: solid 1px #b7b7b7de; padding:0px; margin-top:55px;"
            >
              <!-- <span v-if="this.loaderTable && seccion==2">
                                              <i class="iconMenu icon-lg universalicon-print cursor"></i>
              </span>-->
              <span v-if="this.loaderTable && seccion==2 && !isEmptyReports">
                <!-- && this.$store.state.modal.datosDymanic.id==1 -->

                <i
                  class="iconMenu icon-lg universalicon-file-pdf cursor"
                  @click="doDownloadFileRequest"
                ></i>
              </span>
              <!-- <span v-if="this.loaderTable && seccion==2">
                                              <i class="iconMenu icon-lg universalicon-file-xls cursor"></i>
              </span>-->
            </div>
          </div>

          <component :is="dynamicComponent.component" v-if="visible"></component>
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
 * resultado del reporte
 */
export default {
  name: 'ReportesResultado',
  mixins: [API],
  data () {
    return {
      tipoClient: null,

      resultado: false,
      ShowLoader: null,

      reports: [],
      dynamicComponent: {
        component: null,
        properties: null,
        events: {}
      },
      visible: false,
      dataReports: [],
      show: false,
      loaderTable: false,
      seccion: 1
    }
  },
  provide () {
    return {
      getDraggableProperties: this.getDraggablePropertiesTable,
      dataGraph: this.getDataGraph,
      getDraggablePropertiesDevice: this.getDraggablePropertiesDevice,
      getDraggablePropertiesUser: this.getDraggablePropertiesUser
    }
  },
  created () {
    this.tipoClient = sessionStorage.TC

    this.$store.state.loader = true
    this.getReports(this.$store.state.modal.datosDymanic.filters)
  },
  async mounted () {
    $('#containerPrincipal').css({
      'margin-left': this.$store.state.widthMenu
    })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })
    this.$store.state.seccionMenu = 'reportes'
    await EventBus.$emit('NAVBAR_MenuSimple', 'reportes')
    this.$store.state.loader = false
    //  this.showContentOpction(1)
  },
  methods: {
    /**
     * @vuese
     * Obtiene los valores de las propiedades del componente padre
     */
    getDraggablePropertiesTable () {
      console.debug('HOLAAATABLE')
      return this.dataReports
    },
    getDraggablePropertiesDevice () {
      console.debug('HOLAAADEVICE')
      return this.reports.device
    },
    getDraggablePropertiesUser () {
      return this.reports.user
    },
    /**
     * @vuese
     * Asigna los valores de las variables del componente dinamico a mostrar
     */
    getDataGraph () {
      console.debug('HOLAAA2')
      return this.reports
    },
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
    async showContentOpction (opc) {
      console.debug('SHOWCONTENT', this.$store.state.modal.datosDymanic)
      this.clearComponentsDinamic()

      var opc = parseFloat(opc)
      console.debug(opc)

      this.seccion = opc
      switch (opc) {
        case 1: // graph
          console.debug('case1')
          $('#table').removeClass('active')
          $('#dash').addClass('active')
          this.dynamicComponentName = this.$store.state.modal.datosDymanic.tittle

          if (this.$store.state.modal.datosDymanic.id == 1) {
            this.dynamicComponent.component = () =>
              import('@/views/Reportes/distance/dataGraphDist')
          }
          if (this.$store.state.modal.datosDymanic.id == 2) {
            this.dynamicComponent.component = () =>
              import('@/views/Reportes/horasMotor/dataGraphMotor')
          }
          if (this.$store.state.modal.datosDymanic.id == 3) {
            this.dynamicComponent.component = () =>
              import('@/views/Reportes/accesoSistem/dataGraphAcces')
          }
          if (this.$store.state.modal.datosDymanic.id == 4) {
            this.dynamicComponent.component = () =>
              import('@/views/Reportes/ralenti/dataGraphRalenti')
          }
          if (this.$store.state.modal.datosDymanic.id == 6) {
            this.dynamicComponent.component = () =>
              import('@/views/Reportes/sinReportar/dataGraphSinReportar')
          }
          if (this.$store.state.modal.datosDymanic.id == 7) {
            this.dynamicComponent.component = () =>
              import('@/views/Reportes/velocidad/dataGraphVeloc')
          }
          if (this.$store.state.modal.datosDymanic.id == 10) {
            this.dynamicComponent.component = () =>
              import('@/views/Reportes/bateria/dataGraphBateria')
          }
          break
        case 2: // tabla
          console.debug('case2')
          $('#dash').removeClass('active')
          $('#table').addClass('active')
          this.dynamicComponentName = this.$store.state.modal.datosDymanic.tittle
          if (this.loaderTable) {
            if (this.$store.state.modal.datosDymanic.id == 1) {
              this.dynamicComponent.component = () =>
                import('@/views/Reportes/distance/dataTableDist.vue')
            }
            if (this.$store.state.modal.datosDymanic.id == 2) {
              this.dynamicComponent.component = () =>
                import('@/views/Reportes/horasMotor/dataTableMotor.vue')
            }
            if (this.$store.state.modal.datosDymanic.id == 3) {
              this.dynamicComponent.component = () =>
                import('@/views/Reportes/accesoSistem/dataTableAcces.vue')
            }
            if (this.$store.state.modal.datosDymanic.id == 4) {
              this.dynamicComponent.component = () =>
                import('@/views/Reportes/ralenti/dataTableRalenti.vue')
            }
            if (this.$store.state.modal.datosDymanic.id == 6) {
              this.dynamicComponent.component = () =>
                import('@/views/Reportes/sinReportar/dataTableSinReportar.vue')
            }
            if (this.$store.state.modal.datosDymanic.id == 7) {
              this.dynamicComponent.component = () =>
                import('@/views/Reportes/velocidad/dataTableVeloc.vue')
            }
            if (this.$store.state.modal.datosDymanic.id == 10) {
              this.$store.state.loader = true
              this.dynamicComponent.component = () =>
                import('@/views/Reportes/bateria/dataTableBateria.vue')
            }
          } else {
            this.dynamicComponent.component = () =>
              import('@/views/Reportes/distance/dataTableDistLoader.vue')
          }
          break
        case 3: // tabla
          console.debug('case3')

          this.dynamicComponentName = this.$store.state.modal.datosDymanic.tittle
          if (this.loaderTable) {
            this.dynamicComponent.component = () =>
              import('@/views/Reportes/Paradas/dataTableParadas.vue')
          } else {
            this.dynamicComponent.component = () =>
              import('@/views/Reportes/distance/dataTableDistLoader.vue')
          }
          break
      }
      this.visible = true
    },
    /**
     * @vuese
     * genera el reporte con los filtros
     * @arg `filters` es un arreglo con los filtros a generar el reporte
     */
    async getReports (filters) {
      // Decargar datos
      this.loaderTable = false
      var response
      if (this.$store.state.modal.datosDymanic.id == 1) {
        response = await this.getRequest('reports/distance', filters)
      }
      if (this.$store.state.modal.datosDymanic.id == 2) {
        response = await this.getRequest('reports/enginehours', filters)
      }
      if (this.$store.state.modal.datosDymanic.id == 3) {
        var filters2 = {
          userID: filters.deviceID,
          fromTimestamp: filters.fromTimestamp,
          toTimestamp: filters.toTimestamp,
          timezone: filters.timezone
        }
        response = await this.getRequest('reports/users/login', filters2)
      }
      if (this.$store.state.modal.datosDymanic.id == 4) {
        filters.speedUmbral = 0.6
        response = await this.getRequest('reports/ralenti', filters)
      }
      if (this.$store.state.modal.datosDymanic.id == 5) {
        var filters3 = {
          deviceID: filters.deviceID,
          fromTimestamp: filters.fromTimestamp,
          toTimestamp: filters.toTimestamp,
          timezone: filters.timezone,
          maxDistance: 10,
          maxSpeed: 1,
          timeStopped: filters.time,
          timeTolerance: 0.2
        }
        response = await this.getRequest('reports/stops', filters3)
      }
      if (this.$store.state.modal.datosDymanic.id == 6) {
        filters.minTimestamp = 2700
        var filters6 = {
          deviceID: filters.deviceID,
          fromTimestamp: filters.fromTimestamp,
          toTimestamp: filters.toTimestamp,
          timezone: filters.timezone,
          minTimestamp: filters.minTimestamp
        }
        response = await this.getRequest('reports/noreports', filters6)
        console.debug('RESULT_REPORT_SIN_REPORT', response)
      }
      if (this.$store.state.modal.datosDymanic.id == 7) {
        var filters4 = {
          fromTimestamp: filters.fromTimestamp,
          toTimestamp: filters.toTimestamp,
          timezone: filters.timezone,
          maxSpeed: filters.speed
        }
        response = await this.getRequest('reports/speed', filters4)
      }
      if (this.$store.state.modal.datosDymanic.id == 10) {
        var filters5 = {
          deviceID: filters.deviceID,
          fromTimestamp: filters.fromTimestamp,
          toTimestamp: filters.toTimestamp,
          timezone: filters.timezone
        }
        response = await this.getRequest('reports/battery', filters5)
      }

      if (response.success === true) {
        this.reports = response.data
        this.show = true

        this.getDataTable()
      } else {
        this.$store.state.loader = false

        var message = ''
        switch (response.error.title) {
          case 'UNAUTHORIZED':
            message = 'No cuenta con los permisos para realizar la petición.'
            break
          default:
            message = 'No se puedo realizar la petición.'
            break
        }
        // $('#alertas').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>" + message + "<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
        notify('', message, 'top', 'right', 'danger')
        $('#modalReportCreate').modal('hide')
        this.$store.commit('CLEAR_MODAL_DINAMIC')
        this.$router.push('reports')
      }

      console.debug(
        this.$store.state.modal.datosDymanic.id,
        'REPORTES',
        this.reports,
        $.isEmptyObject(this.reports)
      )
    },
    async getDataTable () {
      // this.dataReports = this.getDraggableProperties()
      console.debug('RESUTALDO_R', this.dataReports)

      if (this.$store.state.modal.datosDymanic.id != 3) {
        if (
          this.$store.state.modal.datosDymanic.id == 5 ||
          this.$store.state.modal.datosDymanic.id == 10
        ) {
          this.dataReports = this.reports.reports
        } else {
          this.dataReports = this.reports.weekPeriods

          // this.dataReports = this.reports.weekPeriods
        }
      } else {
        this.dataReports = this.reports.reports
      }
      this.loaderTable = true
      console.debug('RESUTALDO_R_FINAL_RESULT', this.dataReports)

      if (this.$store.state.modal.datosDymanic.id == 5) {
        this.showContentOpction(3)
      } else {
        this.showContentOpction(1)
      }
    },
    async cancel () {
      this.$router.push('reports')
      await $('#modalReportCreate').modal('show')
      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
    },
    async doDownloadFileRequest () {
      this.$store.state.loader = true

      console.debug(
        'FILTERS_RESULT',
        this.$store.state.modal.datosDymanic.filters
      )

      var params = {
        fromTimestamp: this.$store.state.modal.datosDymanic.filters
          .fromTimestamp,
        toTimestamp: this.$store.state.modal.datosDymanic.filters.toTimestamp,
        timezone: this.$store.state.modal.datosDymanic.filters.timezone,
        format: 'pdf'
      }

      if (this.$store.state.modal.datosDymanic.id == 10) {
        params.maxSpeed = 80
      }

      // indica el titulo del archivo y la extension que se mostraran en el dialogo de guardado
      var fileParams = {
        extension: 'pdf'
      }

      if (this.$store.state.modal.datosDymanic.id != 3) {
        if (this.$store.state.modal.datosDymanic.id == 7) {
          params.maxSpeed = this.$store.state.modal.datosDymanic.filters.speed
          fileParams.name =
            this.$store.state.modal.datosDymanic.tittle +
            ' del ' +
            this.reports.from.date +
            ' al ' +
            this.reports.to.date
        } else {
          params.deviceID = this.$store.state.modal.datosDymanic.filters.deviceID

          fileParams.name =
            this.$store.state.modal.datosDymanic.tittle +
            '-' +
            this.reports.device.alias +
            ' del ' +
            this.reports.from.date +
            ' al ' +
            this.reports.to.date
        }
      } else {
        params.userID = this.$store.state.modal.datosDymanic.filters.deviceID
        fileParams.name =
          this.$store.state.modal.datosDymanic.tittle +
          '-' +
          this.reports.user.alias +
          ' del ' +
          this.reports.from.date +
          ' al ' +
          this.reports.to.date
      }

      if (this.$store.state.modal.datosDymanic.id == 1) {
        await this.downloadFileRequest(
          'reports/distance/export',
          params,
          fileParams
        )
      }
      if (this.$store.state.modal.datosDymanic.id == 2) {
        await this.downloadFileRequest(
          'reports/enginehours/export',
          params,
          fileParams
        )
      }
      if (this.$store.state.modal.datosDymanic.id == 3) {
        await this.downloadFileRequest(
          'reports/users/login/export',
          params,
          fileParams
        )
      }
      if (this.$store.state.modal.datosDymanic.id == 4) {
        await this.downloadFileRequest(
          'reports/ralenti/export',
          params,
          fileParams
        )
      }

      if (this.$store.state.modal.datosDymanic.id == 7) {
        await this.downloadFileRequest(
          'reports/speed/export',
          params,
          fileParams
        )
      }
      if (this.$store.state.modal.datosDymanic.id == 10) {
        await this.downloadFileRequest(
          'reports/battery/export',
          params,
          fileParams
        )
      }

      this.message = 'archivo descargado'

      this.$store.state.loader = false
    }
  },
  computed: {
    /**
     * @vuese
     * devuelve si se obtuvieron resultado o no
     */
    showResultado () {
      return this.resultado
    },
    getData () {
      return this.reports
    },
    isEmptyReports () {
      return $.isEmptyObject(this.reports.monthPeriods)
    }
  }
}
</script>

<style>
.big-text {
  white-space: pre-wrap; /* CSS3 */
  white-space: -moz-pre-wrap; /* Firefox */
  white-space: -pre-wrap; /* Opera <7 */
  white-space: -o-pre-wrap; /* Opera 7 */
  word-wrap: break-word; /* IE */
}

.reportResult {
  font-weight: bold;
}

.nav-item .active {
  color: #ffff !important;
}

.nav-item :hover {
  color: #ffff !important;
}
</style>
