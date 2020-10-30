<template>
  <div class=" row ">
    <div class="col-12"> <h5 class="float-left" style="font-size: 20px; padding-bottom: 10px;"><b>Configurar dispositivos - Editar dispositivo</b></h5></div>
      <div class=" col-12">

        <div class="card">
            <div class="card-header row">
              <div class="col-6">
              <h5 class=" float-left">Editar dispositivo</h5>
              </div>

            </div>
            <div class="card-body float-left">

              <div id="smartwizard" style=" z-index: 1 !important;">
                  <ul>
                      <li>
                        <a href="#step-1">
                            <h6>Paso 1</h6>
                            <p class="m-0">Datos</p>
                        </a>
                      </li>
                      <li>
                        <a href="#step-2">
                            <h6>Paso 2</h6>
                            <p class="m-0">Tiempo de reporte</p>
                        </a>
                      </li>

                  </ul>
                  <div>

                      <div id="step-1" class="mpConf" >
                        <div class="row">
                          <div class="col-12">  <p class="text-muted" style="text-align: justify; font-size: 12px; margin-top: 7px;">
             A continuación podrás consultar y modificar los datos de la unidad, vehiculo y conductor</p></div>

                          <div class="col-12 "><h5 >Datos del vehiculo</h5></div>
                          <hr>
                          <div class="col-6">
                             <config-input  id="alias" label="Alias con que se identificará a la unidad"  typeinput="text"  placeholder="Alias" v-model.trim="alias" required="true" :valor="alias" toLowerUperCase="uppercase"> </config-input>
                          </div>
                          <div class="col-6">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Flotilla a la que pertenece la unidad</label>
                                <select class="form-control" id="exampleFormControlSelect1" v-model="flotilla">
                                    <option v-for="fleet in listFleet" :key="fleet.id" :value="fleet.id">{{fleet.name}}</option>
                                </select>
                            </div>
                          </div>
                          <div class="col-12 col-sm-5">
                            <div class="form-group float-left">
                                <label for="exampleFormControlSelect2">Tipo marcador que representará a la unidad en el mapa</label>
                                <select class="form-control" id="exampleFormControlSelect2" v-model="marcador" @change="changeMarker()">

                                    <option v-for="marker in listMarker" :key="marker.id" :value="marker.id">
                                     {{marker.name}}

                                      </option>
                                </select>
                            </div>
                          </div>
                          <div class="col-1 float-left" id="imgMarker" style="padding:0px;"></div>

                          <div class="col-6">
                             <config-input  id="placas" label="Placas del vehiculo"  typeinput="text"  placeholder="Placas" v-model.trim="placas" required="true" :valor="placas" toLowerUperCase="uppercase"> </config-input>
                          </div>

                          <div class="col-6">
                             <config-input  id="marca" label="Marca del vehiculo"  typeinput="text"  placeholder="Marca" v-model.trim="marcaV" required="true" :valor="marcaV"> </config-input>
                          </div>
                          <div class="col-6">
                             <config-input  id="mod" label="Modelo del vehiculo"  typeinput="text"  placeholder="Modelo" v-model.trim="modeloV" required="true" :valor="modeloV"> </config-input>
                          </div>

                          <div class="col-6">
                             <config-input  id="vin" label="VIN del vehiculo (# serie del motor)"  typeinput="text"  placeholder="VIN" v-model.trim="vinV" required="true" :valor="vinV"> </config-input>
                          </div>
                          <div class="col-6">
                             <config-input  id="anio" label="Año del vehiculo"  typeinput="text"  placeholder="Año" v-model.trim="anioV" required="true" :valor="anioV"> </config-input>
                          </div>
                          <div class="col-6">
                             <config-input  id="color" label="Color del vehiculo"  typeinput="text"  placeholder="Color" v-model.trim="colorV" required="true" :valor="colorV"> </config-input>
                          </div>
                          <div class="col-6">
                             <config-input  id="pais" label="País del vehiculo"  typeinput="text"  placeholder="País" v-model.trim="paisV" required="true" :valor="paisV"> </config-input>
                          </div>
                          <div class="col-6">
                             <config-input  id="reg" label="Región del vehiculo"  typeinput="text"  placeholder="Región" v-model.trim="regionV" required="true" :valor="regionV"> </config-input>
                          </div>
                          <div class="col-6">
                             <config-input  id="nos" label="Aseguradora"  typeinput="text"  placeholder="Aseguradora" v-model.trim="seguroV" required="true" :valor="seguroV"> </config-input>
                          </div>
                          <div class="col-6">
                             <config-input  id="idS" label="# Seguro"  typeinput="text"  placeholder="# Seguro" v-model.trim="numSeguro" required="true" :valor="numSeguro"> </config-input>
                          </div>

                        </div>

                          <hr>
                          <div class="row"><div class="col-12 "><h5 >Datos del conductor</h5></div></div>

                         <div class="row">

                          <div class="col-6">
                             <config-input  id="conductor" label="Nombre del conductor"  typeinput="text"  placeholder="Conductor" v-model.trim="conductor" required="true" :valor="conductor"> </config-input>
                          </div>
                          <div class="col-6">
                             <config-input  id="telC" label="Teléfono del conductor"  typeinput="text"  placeholder="Teléfono" v-model.trim="telefono" required="true" :valor="telefono"> </config-input>
                          </div>
                         </div>

                          <div class="row">
                             <div class="col-12 float-left" style="margin-top: 30px;">
                              <button class="btn btn-secondary" @click="cancel()">CANCELAR</button>
                            </div>
                          </div>
                      </div>

                      <div id="step-2" class="mpConf">
                          <div class="row">
                             <div class="col-12">  <p class="text-muted" style="text-align: justify; font-size: 12px; margin-top: 7px;">
             A continuación podrás consultar y modificar el tiempo en segundos en que manda un reporte de localización una unidad en movimiento asi como el tiempo en segundos en que reportara la unidad en detenido.</p></div>
                            <div class="col-12 "><h5 >Tiempo reporte</h5></div>
                            <hr>
                          </div>
                          <div class="row justify-content-center">
                            <div class="col-8">
                             <config-input  id="report1" label="Tiempo de reporte cuando la unidad esta en movimiento (en segundos) "  typeinput="number"  placeholder="Tiempo de reporte en movimiento" v-model.trim="reportInterval" miNumber="0" required="true" :valor="reportInterval"> </config-input>
                            </div>
                            <div class="col-8">
                              <config-input  id="report2" label="Tiempo de reporte cuando la unidad esta en detenido (en segundos)"  typeinput="number"  placeholder="Tiempo de reporte en detenido" v-model.trim="reportIntervalParking" miNumber="0" required="true" :valor="reportIntervalParking"> </config-input>
                            </div>
                          </div>

                          <div class="row  justify-content-center">
                             <div class="col-6 " style="margin-top: 30px;     text-align: center;">
                              <button class="btn btn-secondary " @click="cancel()">CANCELAR</button>
                              <button class="btn btn-primary " @click="editar()">EDITAR</button>
                            </div>

                          </div>

                          <div class="row" style=" margin-top: 20px;">
                            <div class="col-12" id="alerts"></div>
                            <div class="col-12" id="alertsFleet"></div>
                          </div>

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
import EventBus from '@/EventBus'
/**
 * @group Dispositivos
 * formulario para editar datos de un dispositivo y tiempos de reporte
 */
export default {

  name: 'FormularioEditarDispositivo',
  mixins: [API],
  data () {
    return {
      alias: '',
      flotilla: null,
      marcador: 1,
      placas: null,
      conductor: null,
      telefono: '',
      password: '',
      confPassw: '',
      reportInterval: 0,
      reportIntervalParking: 0,
      accion: '',
      deviceID: 0,
      listFleet: [],
      listMarker: [],
      reportIntervalStore: 0,
      reportIntervalParkingStore: 0,
      marcaV: '',
      modeloV: '',
      vinV: 0,
      anioV: 0,
      colorV: '',
      paisV: '',
      regionV: '',
      seguroV: '',
      numSeguro: ''

    }
  },
  async created () {
    this.accion = this.$route.params.accion
    this.deviceID = this.$route.params.id
    this.getFleets()
    this.getMarkers()
    await this.getDevice()
  },
  async mounted () {
    this.$store.state.submenuActive = 'config'
    this.$store.state.itemSubmenuActive = 'itemDevice'
    await EventBus.$emit('NAVBAR_MenuOpciones', 'config', 'itemDevice')
    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })

    // await $('#smartwizard').smartWizard('theme', 'dots')
    $('#smartwizard').smartWizard({
      theme: 'dots',
      transitionEffect: 'fade',
      autoAdjustHeight: false,
      useURLhash: false,
      showStepURLhash: false
    })
    $('#smartwizard .sw-toolbar').appendTo($('#smartwizard .sw-container'))
    // $('.sw-btn-prev').css({ 'display': 'none' })
    // $('.sw-btn-next').css({ 'display': 'none' })
    // $('#smartwizard').addClass('sw-main sw-theme-dots')
    this.$store.state.loader = false

    $('.sw-btn-next').click(function () {
      window.scrollTo(0, 0)
    })
    $('.sw-btn-prev').click(function () {
      window.scrollTo(0, 0)
    })
  },
  methods: {
    changeMarker () {
      console.debug('MARQIER', this.marcador)
      var marker = this.listMarker.find(x => x.id == this.marcador)

      $('#imgMarker').html(" <img class='img-fluid' style='width: 35px;' src='img/map/markers/" + marker.name + ".png'>")
    },
    /**
   * @vuese
   * obtiene las flotillas
   */
    async getFleets () {
      var request = await this.getRequest('fleets')
      var data = request.data.fleets

      this.listFleet = data
      this.listFleet.push({ 'id': null, 'name': 'SIN ASIGNAR' })
    },
    /**
   * @vuese
   * obtiene catalogo de marcadores
   */
    async getMarkers () {
      var request = await this.getRequest('catalogs/markers')
      var data = request.data.markers

      this.listMarker = data
      // this.listMarker.push({ 'id': null, 'name': 'SIN ASIGNAR' })
    },
    /**
   * @vuese
   * obtiene toda informacion del dispositivo a consultar
   */
    async getDevice () {
      var dispositivos = Object.values(this.$store.state.devices.devices)
      var response = await this.getRequest(`devices/${this.deviceID}`)
      var deviceAllInfo = response.data.device

      // console.log('deviceSTORE', dispositivos)
      // console.log('deviceAPI', deviceAllInfo)

      this.conductor = deviceAllInfo.driver
      this.telefono = deviceAllInfo.driverPhone
      this.marcador = deviceAllInfo.markerType
      this.placas = deviceAllInfo.carplate
      this.marcaV = deviceAllInfo.vehicleBrand
      this.modeloV = deviceAllInfo.vehicleModel
      this.vinV = deviceAllInfo.vehicleVIN
      this.anioV = deviceAllInfo.vehicleYear
      this.colorV = deviceAllInfo.vehicleColor
      this.paisV = deviceAllInfo.country
      this.regionV = deviceAllInfo.region
      this.seguroV = deviceAllInfo.insurance
      this.numSeguro = deviceAllInfo.insuranceID

      dispositivos.forEach(disp => {
        if (disp.id == this.deviceID) {
          this.alias = disp.alias
          this.flotilla = disp.fleetID
          this.reportInterval = disp.reportInterval - disp.addTimeInterval
          this.reportIntervalParking = disp.reportIntervalOnParking - disp.addTimeInterval
          this.reportIntervalStore = disp.reportInterval - disp.addTimeInterval
          this.reportIntervalParkingStore = disp.reportIntervalOnParking - disp.addTimeInterval
        }
      })
      await this.changeMarker()
    },
    /**
   * @vuese
   * cancela el proceso y regresa una pagina anterior
   */
    cancel () {
      this.$router.push('/listDevice')
    },
    /**
   * @vuese
   * Guarda la informacion del dipositivo modificada, asi como cambia el tiempo de reporte en detenido/movimiento (el dispositivo necesita estar conectado a la plataforma)
   */
    async editar () {
      this.reportInterval = parseInt(this.reportInterval)
      this.reportIntervalParking = parseInt(this.reportIntervalParking)
      if (this.reportInterval >= this.reportIntervalParking) {
        $('#alerts').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>El tiempo de reporte en detenido debe ser mayor al tiempo de reporte en movimiento</div>")
        setTimeout(() => {
          $('#alerts').html('')
        }, 5000)
        return false
      }

      var datosDevicees = {
        'marker': this.marcador,
        'alias': this.alias.toUpperCase(this.alias)
        // 'notes': ''

      }

      var datosDriver = {
        'name': this.conductor,
        'phone': this.telefono

      }

      var datosVehicle = {
        'brand': this.marcaV,
        'model': this.modeloV,
        'year': this.anioV,
        'vin': this.vinV,
        'colour': this.colorV,
        'carPlate': this.placas.toUpperCase(this.placas),
        'country': this.paisV,
        'region': this.regionV,
        'insurance': this.seguroV,
        'insuranceID': this.numSeguro
        // 'notes': ''

      }

      var datos = {}

      datos['device'] = datosDevicees
      datos['driver'] = datosDriver
      datos['vehicle'] = datosVehicle

      this.$store.state.loader = true
      var request = await this.putRequest('devices/' + this.deviceID, datos)

      if (request.success === true) {
        var dispositivos = Object.values(this.$store.state.devices.devices)

        var imeiDevice
        var fleetOrigin

        // cambiar marcador
        var markerName
        this.listMarker.forEach(marker => {
          if (parseInt(marker.id) == parseInt(this.marcador)) {
            markerName = marker.name
          }
        })
        var params = { 'imei': imeiDevice, 'markerName': markerName }
        EventBus.$emit('SET_MARKER_ICON', params)

        dispositivos.forEach(disp => {
          if (disp.id == this.deviceID) {
            disp.alias = this.alias
            disp.fleetID = this.flotilla
            fleetOrigin = disp.fleetID
            disp.reportInterval = this.reportInterval + disp.addTimeInterval
            disp.reportIntervalOnParking = this.reportIntervalParking + disp.addTimeInterval
            imeiDevice = disp.imei
            disp.marker.id = this.marcador
            disp.marker.name = markerName
          }
        })

        // cambiar flotilla api
        var datos = {
          'fleetID': this.flotilla
        }

        var request = await this.putRequest('devices/' + this.deviceID + '/fleets', datos)
        var fleetResp
        if (request.success === true) {
          fleetResp = true
        } else {
          $('#alertsFleet').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se ha actualizado la flotilla</div>")

          dispositivos.forEach(disp => {
            if (disp.id == this.deviceID) {
              disp.fleetID = fleetOrigin
            }
          })
          setTimeout(() => {
            $('#alertsFleet').html('')
          }, 3000)
        }

        // intervalo de reporte cambio

        if (this.reportInterval != this.reportIntervalStore || this.reportIntervalParking != this.reportIntervalParkingStore) {
          if (this.$store.state.ws.connected) {
            this.WS_INTEVAL_REPORT(this.reportInterval, this.reportIntervalParking, imeiDevice)
          } else {
            $('#alerts').html(`<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>El servidor esta fuera de línea, por lo que no se puede cambiar el tiempo de reporte del dispositivo<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>`)
          }
        }

        this.$store.state.loader = false

        $('#alerts').html(`<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha actualizado el dispositivo<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>`)
        setTimeout(() => {
          $('#alerts').html('')
          this.cancel()
        }, 3000)
      } else {
        this.$store.state.loader = false
        $('#alerts').html(`<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se ha actualizado el dispositivo<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>`)
      }
    },
    /**
   * @vuese
   * Llamada al webSocket para cambiar los tiempos de reporte del dispositivo
   * @arg `interval` Tiempo en movimiento (en segundos)
  * @arg `intervalParking` Tiempo en detenido (en segundos)
   * @arg `imeiDevice` Imei del dispostivo
   */
    WS_INTEVAL_REPORT (interval, intervalParking, imeiDevice) {
      var payload = {
        'imei': imeiDevice,
        'onDrivingInterval': interval,
        'onParkingInterval': intervalParking

      }

      this.$store.dispatch('ws/SET_REPORT_INTERVAL', payload)
    }
  },
  computed: {
    getMarker () {
      return this.marcador
    }
  }
}
</script>

<style>
.mpConf{
  margin: 10px;
  padding-top: 10px;
}

@media (max-width: 655px) {
  #imgMarker{
    margin-top: 70px;
  }
}

@media (max-width: 767px) {
  #imgMarker{
    margin-top: 50px;
  }
}

@media  (min-width: 768px) {
  #imgMarker{
    margin-top: 50px;
  }

}

@media  (min-width: 1080px) {
  #imgMarker{
    margin-top: 30px;
  }

}

</style>
