<template>
          <!-- MODAL -->

    <div class="row">

               <form @submit.prevent >
              <div class="col-12" >

                <p v-if="this.$store.state.modal.datosDymanic.idCliente != 0 && this.accion=='nuevo'" class="text-muted">El gps se agregará en el almacén del cliente: <b>{{this.$store.state.modal.datosDymanic.nameClient}}</b></p>
                <p  v-if="this.$store.state.modal.datosDymanic.idCliente == 0 && this.accion=='nuevo'">El gps se agregará en tú almacén</p>

                  <div class="row">

                    <div class="col-12" id="alertAdminImeiNotas" style="margin-top: 10px;">
                      <div class='alert alert-info alert-dismissible fade show' role='alert' style='text-align: initial;' v-if="getMarca==3"> <!-- v-if="getMarca!=null && getMarca!=''" -->
                        <strong style="font-weight: 800;">Nota! </strong>
                          {{messageInfo}} </br>
                          <strong v-if="this.exampleImei!=null" style="font-weight: 800;">Ejemplo: </strong> {{exampleImei}}
                          <!-- <button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'>
                            <span aria-hidden='true'>&times;</span>
                          </button> -->
                      </div>
                    </div>

                    <div class="col-12 col-md-4">
                      <div class="form-group">
                        <label for="marca">Marca</label>
                        <select class="form-control" id="marca" v-model="marca" :valor="marca"  @change="modelGPS()" required>
                            <option value="">Selecciona</option>
                            <option v-for="factory in listFactories" :value="factory.id" :key="factory.id">{{factory.factory}}</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-12 col-md-4">
                      <div class="form-group">
                        <label for="model">Modelo</label>
                        <select class="form-control" id="model" v-model="model" :valor="model" required>
                            <option value="">Selecciona</option>
                            <option v-for="model in listmodels" :value="model.id" :key="model.id">{{model.model}}</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <config-input  id="imei" label="IMEI"  typeinput="text"  placeholder="IMEI" v-model.trim="imei" required="true" :valor="imei" v-if="this.accion=='nuevo'" :minlength="valuePattern" :maxlength="valuePattern" :onkeypress="onkeypress" ></config-input>
                        <config-input  id="imei" label="IMEI"  typeinput="text"  placeholder="IMEI" v-model.trim="imei" required="false"  disabled="true" :valor="imei" v-if="this.accion=='editar'"></config-input>
                    </div>

                    <div class="col-12 col-md-4" v-if="this.comportamiento==2">
                        <config-input  id="alias" label="Alias"  typeinput="text"  placeholder="Alias" v-model.trim="alias" required="false" :valor="alias"></config-input>
                    </div>
                    <div class="col-12 ">
                        <config-input  id="notes" label="Notas"  typeinput="text"  placeholder="Notas" v-model.trim="notas" required="false" :valor="notas"></config-input>
                    </div>

                  </div>

                   <div class="row" v-if="this.comportamiento==2">
                      <div class="col-12">
                        <h5 class="float-left">Cliente</h5>
                        <hr style="margin-top: 2rem;">
                      </div>

                      <div class="col-12 col-md-4">
                        <div class="form-group">
                          <label for="cliente">Cliente</label>
                          <select class="form-control" id="cliente" v-model="cliente" :valor="cliente" required>
                              <option value=''>Selecciona</option>
                              <option v-for="model in listmodels" :value="model.id" :key="model.id">{{model.model}}</option>
                          </select>
                        </div>
                      </div>
                  </div>

                  <div class="row" v-if="this.comportamiento==2">
                      <div class="col-12">
                        <h5 class="float-left">Conductor</h5>
                        <hr style="margin-top: 2rem;">
                      </div>
                     <div class="col-12 col-md-6">
                        <config-input  id="nameDriver" label="Conductor"  typeinput="text"  placeholder="Conductor" v-model.trim="nameDriver" required="false" :valor="nameDriver"></config-input>
                    </div>
                    <div class="col-12 col-md-6">
                        <config-input  id="phoneDriver" label="Teléfono"  typeinput="text"  placeholder="Teléfono" v-model.trim="phoneDriver" required="false" :valor="phoneDriver"></config-input>
                    </div>
                  </div>

                  <div class="row" v-if="this.comportamiento==2">
                      <div class="col-12">
                        <h5 class="float-left">Vehículo</h5>
                        <hr style="margin-top: 2rem;">
                      </div>
                     <div class="col-12 col-md-4">
                        <config-input  id="vehMarca" label="Marca"  typeinput="text"  placeholder="Marca" v-model.trim="vehMarca" required="false" :valor="vehMarca"></config-input>
                    </div>
                    <div class="col-12 col-md-4">
                        <config-input  id="vehModel" label="Modelo"  typeinput="text"  placeholder="Modelo" v-model.trim="vehModel" required="false" :valor="vehModel"></config-input>
                    </div>
                    <div class="col-12 col-md-4">
                        <config-input  id="vehVin" label="Vin"  typeinput="text"  placeholder="Vin" v-model.trim="vehVin" required="false" :valor="vehVin"></config-input>
                    </div>

                    <div class="col-12 col-md-4">
                        <config-input  id="vehAnio" label="Año"  typeinput="text"  placeholder="Año" v-model.trim="vehAnio" required="false" :valor="vehAnio"></config-input>
                    </div>
                    <div class="col-12 col-md-4">
                        <config-input  id="vehPlacas" label="Placas"  typeinput="text"  placeholder="Placas" v-model.trim="vehPlacas" required="false" :valor="vehPlacas"></config-input>
                    </div>
                    <div class="col-12 col-md-4">
                        <config-input  id="vehColor" label="Color"  typeinput="text"  placeholder="Color" v-model.trim="vehColor" required="false" :valor="vehColor"></config-input>
                    </div>

                    <div class="col-12 col-md-4">
                        <config-input  id="vehPais" label="País"  typeinput="text"  placeholder="País" v-model.trim="vehPais" required="false" :valor="vehPais"></config-input>
                    </div>
                    <div class="col-12 col-md-4">
                        <config-input  id="vehRegion" label="Estado/Región"  typeinput="text"  placeholder="Estado/Región" v-model.trim="vehRegion" required="false" :valor="vehRegion"></config-input>
                    </div>
                    <div class="col-12 col-md-4">
                        <config-input  id="vehSeguro" label="Seguro"  typeinput="text"  placeholder="Seguro" v-model.trim="vehSeguro" required="false" :valor="vehSeguro"></config-input>
                    </div>

                    <div class="col-12 col-md-4">
                        <config-input  id="vehNumSeguro" label="# seguro"  typeinput="text"  placeholder="# seguro" v-model.trim="vehNumSeguro" required="false" :valor="vehNumSeguro"></config-input>
                    </div>
                    <div class="col-12">
                        <config-input  id="vehNotas" label="Notas"  typeinput="text"  placeholder="Notas" v-model.trim="vehNotas" required="false" :valor="vehNotas"></config-input>
                    </div>
                  </div>

                  <div class="row"><div class="col-12" id="alertAdminGps"></div></div>

              </div> <!-- fin card body -->
              <div class="col-12 float-right">
                   <button class="btn btn-secondary shadow-2 mb-4 float-left" @click="cancel()" >CANCELAR</button>
                    <button id="btnRegistrar" class="btn btn-primary shadow-2 mb-4 float-right" @click="SendForm()" type="submit" v-if="this.$store.state.modal.datosDymanic.accion === 'nuevo'" >REGISTRAR</button>

                    <button id="btnEnditar" class="btn btn-primary shadow-2 mb-4 float-right" @click="SendForm()" type="submit" v-if="this.$store.state.modal.datosDymanic.accion === 'editar' && this.$store.state.StoreCliente==0" >EDITAR</button>

              </div>
              </form>

          </div>

    <!-- fin modal -->
</template>

<script>
import { API } from '@/mixins/API'
import EventBus from '@/EventBus'
/**
* @vuese
 * @group Administrador/Distribuidor
 * Modal para registrar GPS
 */
export default {
  name: 'ModalFormGps',
  mixins: [API],
  data () {
    return {
      messageInfoImei: null,
      exampleImei: null,
      marca: '',
      model: '',
      imei: null,
      notas: null,
      listFactories: [],
      listmodels: [],
      alias: null,
      cliente: '',
      nameDriver: null,
      phoneDriver: null,
      vehMarca: null,
      vehModel: null,
      vehVin: null,
      vehAnio: 0,
      vehPlacas: null,
      vehColor: null,
      vehPais: null,
      vehRegion: null,
      vehSeguro: null,
      vehNumSeguro: null,
      vehNotas: null,
      comportamiento: 1,
      model2: null,
      accion: this.$store.state.modal.datosDymanic.accion,
      sims: null,
      valuePattern: null,
      onkeypress: null

    }
  },
  async created () {
    this.$store.state.loader = true
    this.factories()
    console.debug('ACCION', this.accion)
    if (this.accion == 'editar') {
      this.getDeviceInfo()
    }
  },
  async mounted () {
    this.$store.state.loader = false
    // $('#modalAdminGPS').modal('show')
    if (this.marca != null) {
      this.modelGPS()
    }
  },
  destroyed () {

  },
  methods: {
    /**
   * @vuese
   * Obtiene catalogo de marcas dispositivos
   */
    async factories () {
      var request = await this.getRequest('catalogs/devices/factories')

      if (request.success === true) {
        this.listFactories = request.data.deviceFactories
      }
    },
    /**
   * @vuese
   * Obtiene catalogo de modelos segun la marca
   */
    async modelGPS () {
      this.listmodels = []
      this.model = ''
      this.imei = null
      this.messageInfoImei = null
      this.exampleImei = null
      if (this.marca == null) {
        this.marca = null
      }

      if (this.model2 != null) {
        console.debug('MODEL2', this.model2, this.marca)
        if (this.model2 != this.marca) {
          this.model = ''
        }
      }

      if (this.marca == 3) {
        this.messageInfoImei = 'El imei de los GPS SUNTECH se compone por 15 o 16 dígitos, de los cuales solo se ingresan los últimos 9 dígitos, menos el último.'
        this.exampleImei = 'xxxxx1-23-456789-x'
        this.onkeypress = 'return event.charCode >= 48 && event.charCode <= 57'
        this.valuePattern = '9'
      } else {
        this.messageInfoImei = ''
        this.exampleImei = ''
        this.onkeypress = null
        this.valuePattern = null
      }

      console.debug('entra modelo', this.marca)
      var request = await this.getRequest('catalogs/devices/factories/' + this.marca + '/models')
      console.debug('RESP', request)
      if (request.success === true) {
        this.listmodels = request.data.deviceModels
      }
    },
    /**
   * @vuese
   * obtiene datos de gps
   */
    async getDeviceInfo () {
      var response = await this.getRequest(`devices/${this.$store.state.modal.datosDymanic.id}`)
      var deviceAllInfo = response.data.device
      console.debug(deviceAllInfo)
      this.marca = deviceAllInfo.deviceBrandID
      this.modelGPS()

      this.imei = deviceAllInfo.imei
      this.notas = deviceAllInfo.notas
      this.alias = deviceAllInfo.alias
      this.cliente = deviceAllInfo.clientID
      this.nameDriver = deviceAllInfo.driver
      this.phoneDriver = deviceAllInfo.driverPhone
      this.vehMarca = deviceAllInfo.vehicleBrand
      this.vehModel = deviceAllInfo.vehicleModel
      this.vehVin = deviceAllInfo.vehicleVIN
      this.vehAnio = deviceAllInfo.vehicleYear
      this.vehPlacas = deviceAllInfo.carplate
      this.vehColor = deviceAllInfo.vehicleColor
      this.vehPais = deviceAllInfo.country
      this.vehRegion = deviceAllInfo.region
      this.vehSeguro = deviceAllInfo.insurance
      this.vehNumSeguro = deviceAllInfo.insuranceID
      this.vehNotas = deviceAllInfo.vehicleNotes
      this.simID = deviceAllInfo.simID
      this.model = deviceAllInfo.deviceModelID
      this.model2 = deviceAllInfo.deviceBrandID
    },
    /**
   * @vuese
   * Envia datos y registra un gps
   */
    async SendForm () {
      if (this.marca != '' && this.model != '' && this.imei != null) {
        this.$store.state.loader = true

        if (this.accion == 'nuevo') {
          var device = {
            'modelID': this.model,
            'clientID': this.cliente,
            'markerTypeID': 1,
            'imei': this.imei,
            'alias': '',
            'notes': this.notas
          }
          console.debug('this.$store.state.modal.datosDymanic.idCliente', this.$store.state.modal.datosDymanic.idCliente)
          if (this.$store.state.modal.datosDymanic.idCliente != 0) {
            device.clientID = this.$store.state.modal.datosDymanic.idCliente
          }
          var vehicle = {
            'brand': this.vehMarca,
            'model': this.vehModel,
            'year': this.vehAnio,
            'vin': this.vehVin,
            'colour': this.vehColor,
            'carPlate': this.vehPlacas,
            'country': this.vehPais,
            'region': this.vehRegion,
            'insurance': this.vehSeguro,
            'insuranceID': this.vehNumSeguro,
            'notes': this.vehNotas
          }

          var driver = {
            'name': this.nameDriver,
            'phone': this.phoneDriver
          }

          var datos = {}

          datos['device'] = device
          datos['vehicle'] = vehicle
          datos['driver'] = driver

          console.debug('DATOS', datos)

          var request = await this.postRequest('devices', datos)

          if (request.success === true) {
            this.$store.state.loader = false
            $('#btnRegistrar').attr('disabled', 'disabled')
            $('#alertAdminGps').html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha registrado el dispositivo<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
            setTimeout(() => {
              $('#alertAdminGps').html('')
              // this.cancel()
              EventBus.$emit('GET_LIST_devices', 1)
              EventBus.$emit('GET_Graficas', 1)
              $('#btnRegistrar').removeAttr('disabled')
            }, 3000)
            this.imei = null
            this.notas = null
          } else {
            $('#btnRegistrar').removeAttr('disabled')
            this.$store.state.loader = false
            var message = ''
            switch (request.error.title) {
              case 'IMEI_EXISTS':
                message = 'El IMEI ya existe'
                break
              case 'VIN_EXISTS':
                message = 'El VIN ya existe'
                break
              case 'UNAUTHORIZED':
                message = 'No cuenta con los permisos para realizar la accion'
                break
              default:
                message = 'No se ha registrado el dispositivo'
                break
            }

            $('#alertAdminGps').html(`<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>${message}<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>`)
          }

          // this.model = ''
          // this.marca = ''
          // this.imei = null
        }
        if (this.accion == 'editar') {
          var datosDevicees = {
            'modelo': this.model,
            'notes': this.notas

          }

          var datos = {}

          datos['device'] = datosDevicees
          datos['driver'] = []
          datos['vehicle'] = []

          this.$store.state.loader = true
          console.debug('DATOS EDIT', datos)
          var request = await this.putRequest('devices/' + this.$store.state.modal.datosDymanic.id, datos)

          if (request.success === true) {
            this.$store.state.loader = false
            $('#btnEnditar').attr('disabled', 'disabled')
            $('#alertAdminGps').html(`<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha actualizado el dispositivo<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>`)
            setTimeout(() => {
              $('#alertAdminGps').html('')

              this.cancel()
            }, 3000)
            this.imei = null
            this.notas = null
          } else {
            this.$store.state.loader = false
            $('#btnEnditar').removeAttr('disabled')
            $('#alertAdminGps').html(`<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se ha actualizado el dispositivo<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>`)
          }
        }
      }
    },
    cancel () {
      this.$store.commit('CLEAR_MODAL_DINAMIC')
      EventBus.$emit('GET_LIST_devices', 1)
      EventBus.$emit('GET_Graficas', 1)
      this.$router.push('/dashStore/' + this.$store.state.StoreCliente + '/' + this.$store.state.StoreNameCliente)

      $('#modalAdminForm').modal('hide')
    }

  },
  computed: {
    messageInfo () {
      return this.messageInfoImei
    },
    getMarca () {
      return this.marca
    }
  }
}
</script>
