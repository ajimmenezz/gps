<template>
    <div class=" container"  style="padding-left:0px; width: 560px; height: 290px;">
      <div class="row">
          <div class="col-8 float-left" > <config-text-typography :title="device.alias" dispTitle="false"></config-text-typography></div>
          <div class="col-4 float-right" v-if="device.iconGestionDevices && device.iconLocateDevices && device.iconLocateDevicesTrue">
            <span ><i class="icon icon-md universalicon-target-fixed cursor" @click="localizar(device.id,device.imei)"></i></span>

             <span @click="deviceParoMotor(device.id, device.imei,device.report.states.engineEnabled)" v-if="permission_paroMotor">
              <i class="cursor icon-md icon universalicon-shutdown colorText-green" v-if="device.report.states.engineEnabled" ></i>
              <i class="cursor icon-md icon universalicon-shutdown colorText-red" v-else></i>
            </span>
            <!-- <span class="badge badge-pill badge-danger" @click="deviceParoMotor(device.id, device.imei,device.report.states.engineEnabled)" v-if="device.report.states.engineEnabled">OFF</span>
            <span class="badge badge-pill badge-success" @click="deviceParoMotor(device.id, device.imei,device.report.states.engineEnabled)" v-else>ON</span> -->
                <span ><i class="icon icon-md universalicon-streetview cursor" @click="showStreetView()"></i></span>

                <span v-if="device.report.states.gsm.strength!=null">
                <span ><i class="icon icon-md universalicon-signal-full cursor colorText-green cssToolTip" v-if="device.report.states.gsm.strength>75" ><span style="width: 55px !important; left:0% !important;">Alta</span></i></span>
                <span ><i class="icon icon-md universalicon-signal-mid cursor colorText-green cssToolTip" v-if="device.report.states.gsm.strength>=51 && device.report.states.gsm.strength<=75"><span style="width: 55px !important; left:0% !important;">Media</span></i></span>
                <span ><i class="icon icon-md universalicon-no-signal cursor colorText-green cssToolTip" v-if="device.report.states.gsm.strength>=1 && device.report.states.gsm.strength<=50"><span style="width: 55px !important; left:0% !important;">Baja</span></i></span>
                <span ><i class="icon icon-md universalicon-no-signal cursor cssToolTip" v-if="device.report.states.gsm.strength==0"><span style="width: 55px !important; left:0% !important;">Sin señal</span></i></span>
                </span>
          </div>
          <div class="col-4 float-right" v-if="!device.iconGestionDevices">
            <span class="badge badge-pill badge-warning" style="font-size: 11px;">Realizando paro motor</span>
          </div>
          <div class="col-4 float-right" v-if="!device.iconLocateDevices">
            <span class="badge badge-pill badge-warning" style="font-size: 11px;">Localizando</span>
          </div>
          <div class="col-4 float-right" v-if="!device.iconLocateDevicesTrue">
            <span class="badge badge-pill badge-success" style="font-size: 11px;">Localizado</span>
          </div>

          <div class="col-8 float-left" style="padding-left:30px;" v-if="device.report.states.ignition"><config-data-label  IDinput="estatus" label="Motor: " value="Encendido" ></config-data-label></div>
          <div class="col-8 float-left" style="padding-left:30px;" v-if="!device.report.states.ignition"><config-data-label  IDinput="estatus" label="Motor: " value="Apagado"></config-data-label></div>
          <div class="col-4 float-right colorText-green" v-if="device.locationStatus!=3" style="font-weight: bold;"><config-text-typography texto="Localizado" ></config-text-typography></div>
          <div class="col-4 float-right colorText-red"><config-text-typography texto="Sin localizar"  v-if="device.locationStatus==3" style="font-weight: bold;"></config-text-typography></div>
      </div>
      <div class="row">
        <div class="col-12 float-left"  style="padding-left:30px;">
          <config-data-label  IDinput="fleetName" label="Flotilla: " :value="fleet.name" />
        </div>
      </div>

      <div class="row" style="margin-top:10px">
        <div class="col-12" >
          <!-- star slider -->
          <div class="sliderContainer ">
            <input class="inputSlider" type="radio" name="fancy" autofocus value="principal" id="principal" />
            <input class="inputSlider" type="radio" name="fancy"  value="datosGral" id="datosGral" />
            <input class="inputSlider" type="radio" name="fancy"  value="gpsInfo" id="gpsInfo" />

            <label class="labelSlider" for="principal">
              <div class="row">
                <div class="col-12" ><config-text-typography subtitle="Informacion de ubicacion"></config-text-typography></div><hr style="margin: 0px;  margin-bottom: 7px; width:100%">
                <div class="col-1"></div>
                <div class="col-10">
                  <div class="row" >
                    <div class="big-text col-12"><config-data-label IDinput="ultReport" label="Fecha:" :value="FechaHora"></config-data-label></div>
                    <div class="big-text col-12 "><config-data-label IDinput="position" label="Posición:" :value="`${device.report.position.lat}, ${device.report.position.lng}`"></config-data-label></div>
                    <div class="big-text col-6"><config-data-label IDinput="Velociodad" label="Velocidad:" :value="stringSpeed"></config-data-label></div>
                    <div class="big-text col-12 big-text"><config-data-label IDinput="addres" label="Dirección:" :value="device.report.position.address"></config-data-label></div>
                  </div>
                </div>
                <div class="col-1"></div>
              </div>
            </label>

            <label class="labelSlider" for="datosGral">
              <div class="row">
                <div class="col-12 "><config-text-typography subtitle="Informacion de vehiculo"></config-text-typography></div><hr style="margin: 0px;  margin-bottom: 7px; width:100%">
                <div class="col-2"></div>
                <div class="col-9">
                  <div class="row" >
                    <div class="big-text col-12 float-right"><config-data-label IDinput="conductor" label="Conductor:" :value="deviceAllInfo.driver"></config-data-label></div>
                    <div class="big-text col-12 float-right"><config-data-label IDinput="telConductor" label="Teléfono del conductor:" :value="deviceAllInfo.driverPhone"></config-data-label></div>
                    <div class="big-text col-6 float-right"><config-data-label IDinput="vehPlacas" label="Placas:" :value="deviceAllInfo.carplate"></config-data-label></div>
                    <div class="big-text col-12 float-right"><config-data-label IDinput="vehSerie" label="No. Serie:" :value="deviceAllInfo.vehicleVIN"></config-data-label></div>
                    <div class="big-text col-6 float-right"><config-data-label IDinput="vehMarca" label="Marca:" :value="deviceAllInfo.vehicleBrand"></config-data-label></div>
                    <div class="big-text col-6 float-right"><config-data-label IDinput="vehModelo" label="Modelo:" :value="deviceAllInfo.vehicleModel"></config-data-label></div>
                    <div class="big-text col-6 float-right"><config-data-label IDinput="vehAnio" label="Año:" :value="deviceAllInfo.vehicleYear"></config-data-label></div>
                    <div class="big-text col-6 float-right"><config-data-label IDinput="vehColor" label="Color:" :value="deviceAllInfo.vehicleColor"></config-data-label></div>
                  </div>
                </div>
                <div class="col-1"></div>
              </div>
            </label>

            <label class="labelSlider" for="gpsInfo">
              <div class="row">
                <div class="col-12" ><config-text-typography subtitle="Informacion de dispositivo GPS"></config-text-typography></div><hr style="margin: 0px;  margin-bottom: 7px; width:100%">
                <div class="col-1"></div>
                <div class="col-10">
                  <div class="row" >
                    <div class="big-text col-6 float-right"><config-data-label IDinput="model" label="Modelo:" :value="deviceAllInfo.deviceModel"></config-data-label></div>
                     <div class="big-text col-6 float-right"><config-data-label IDinput="imei" label="IMEI:" :value="device.imei"></config-data-label></div>
                    <div class="big-text col-12" v-if="deviceAllInfo.simNumber"><config-data-label IDinput="sim" label="Telefono:" :value="deviceAllInfo.simNumber"></config-data-label></div>
                  </div>
                </div>
                <div class="col-1"></div>
              </div>
            </label>
          </div>
          <!--end slider -->
        </div>
      </div>
    </div>
</template>

<script>
import { API } from '@/mixins/API'
import modalParoMotor from '@/views/Modals/modalParoMotor'
import store from '@/store'
/**
* @vuese
* @group componenets/
* infowindows con datos del dispositivo
 */
export default {
  name: 'infowindoswDispositivo',
  mixins: [API],
  props: ['deviceID', 'no', 'deviceImei'],
  data () {
    return {
      device: null,
      fleet: {},
      deviceAllInfo: '',
      latLng: '',
      page: 0,
      pageLimit: 3,
      isLoading: false,
      textComando: '',
      store,
      timestampNow: null,
      FechaHora: 0,
      timestampNowDevice: null,
      intervalFecha: null,
      deviceVelocidad: ''
    }
  },

  created () {
    console.log('created', this.device)
    this.loadInfo()
  },
  methods: {
    /**
   * @vuese
   * Se obtiene la informacion del dispositivo a consultar
   */
    async loadInfo () {
      this.device = this.store.state.devices.devices[this.deviceImei]

      this.fleet = this.store.state.devices.fleets.find(fleet => fleet.id === this.device.fleetID)

      var response = await this.getRequest(`devices/${this.deviceID}`)
      this.deviceAllInfo = response.data.device
      this.isLoading = true

      this.updateString()
      await this.interval()
    },
    /**
   * @vuese
   * Ejecuta la funcion `updateString` cada 10 segundos
   */
    interval () {
      this.store.state.devices.setIntervalFecha = setInterval(function () {
        this.updateString()
      }.bind(this), 10000)
    },
    /**
   * @vuese
   * Obtiene la fecha y tiempo transcurrido en que reporto el dispositivo
   */
    updateString () {
      this.timestampNowDevice = this.device.report.timestamp

      var date = new Date(this.timestampNowDevice * 1000)
      var from = this.$moment(date).fromNow()
      var fechaString = this.$moment(date).format('LL h:mm a')
      this.FechaHora = `${fechaString} (${from})`
    },
    /**
   * @vuese
   * Manda datos y abrir modal para realizar paro de motor
   */
    async deviceParoMotor (deviceID, deviceImei, stateParoMotor) {
      this.store.commit('CLEAR_MODAL_DINAMIC')

      var datos = {
        'component': modalParoMotor,
        'datos': {
          'deviceImei': deviceImei,
          'stateParoMotor': stateParoMotor
        }
      }
      await this.store.commit('ADD_COMPONENT_DINAMIC', datos)
      await this.store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
    },

    /**
   * @vuese
   * Manda a localizar dispositivo mediente webSocket
   */
    localizar (id, imei) {
      if (this.store.state.ws.connected) {
        var payload = {
          'imei': imei

        }
        this.$store.state.devices.devicesLocateSELECT = imei

        this.store.dispatch('ws/LOCATE', payload)
      } else {
        notify('Error!', 'El servidor se encuentra fuera de línea,<br>por lo que no se puede realizar la petición', 'top', 'right', 'danger', 340, this.store.state.menu.topMenu)
      }
    },

    /**
   * @vuese
   * Manda a abrir street view de la posicion del dispositivo
   */
    showStreetView () {
      this.$emit('onShowStreetView')
      // this.store.commit('mapModule/SHOW_STREET_VIEW', this.deviceImei)
    }

  },
  computed: {
    /**
   * @vuese
   * Obtiene si tiene permiso para realizar paro de motor
   */
    permission_paroMotor () {
      return this.store.getters.permission(4)
    },
    /**
   * @vuese
   * Crea string de latitud
   */
    StringLat () {
      var lat = `Lat: ${this.device.report.position.lat}`
      return lat
    },
    /**
   * @vuese
   * Crea string de longitud
   */
    StringLng () {
      var lng = `Lng: ${this.device.report.position.lng}`
      return lng
    },
    /**
   * @vuese
   * Crea string de velocidad
   */
    stringSpeed () {
      var deviceVelocidad = this.device.report.states.speed + ' km/h'
      return deviceVelocidad
    }
  }
}
</script>

<style>
.encabezado{
  background: #3f4d67;
    color: #fff;

}
.float-left{
   text-align:left;
   float:left;
}
.float-right{
  text-align:right;
  float:right;
}

.labelSlider {
	 background: #ffffff; /*#f1f5f8; */
	/* color: #fff; */
	transition: transform 400ms ease-out;
	display: inline-block;
  /* min-height: 100%; */
  /* width: 100vw; */
  width: 550px;
  /* height: 100vh; */
  height: 200px;
	position: relative;
	z-index: 1;
	text-align: center;
	/* line-height: 100vh; */
}

.sliderContainer {
   position: absolute;
   overflow: hidden;
       width: 550px;
/*	top: 0;
	left: 0;
	bottom: 0;
	right: 0; */
	white-space: nowrap;
}
input.inputSlider {
	position: absolute;
}

input:nth-of-type(1):checked ~ label.labelSlider:nth-of-type(1),
input:nth-of-type(2):checked ~ label.labelSlider:nth-of-type(2){
  z-index:0;
}
input:nth-of-type(3):checked ~ label.labelSlider:nth-of-type(3){
  z-index:0;
}
/* input:nth-of-type(3):checked ~ label.labelSlider:nth-of-type(3),
input:nth-of-type(4):checked ~ label.labelSlider:nth-of-type(4),
input:nth-of-type(5):checked ~ label.labelSlider:nth-of-type(5),
input:nth-of-type(6):checked ~ label.labelSlider:nth-of-type(6),
input:nth-of-type(7):checked ~ label.labelSlider:nth-of-type(7){
   z-index: 0;
} */

input:nth-of-type(1):checked ~ label.labelSlider {
	transform: translate3d(0, 0, 0);
}

input:nth-of-type(2):checked ~ label.labelSlider {
	transform: translate3d(-100%, 0, 0);
}

input:nth-of-type(3):checked ~ label.labelSlider {
	transform: translate3d(-200%, 0, 0);
}

input:nth-of-type(4):checked ~ label.labelSlider {
	transform: translate3d(-300%, 0, 0);
}

input:nth-of-type(5):checked ~ label.labelSlider {
	transform: translate3d(-400%, 0, 0);
}
input:nth-of-type(6):checked ~ label.labelSlider {
	transform: translate3d(-500%, 0, 0);
}
input:nth-of-type(7):checked ~ label.labelSlider {
	transform: translate3d(-600%, 0, 0);
}
.slider {
	background: #f1f5f8;
	background-size: cover;
	font-size: 3rem;
}

label.labelSlider:before,
label.labelSlider:after {
	/* color: white; */
	display: block;
	/* background: rgba(255,255,255,0.2); */
	position: absolute;
	padding: 1rem;
	font-size: 3rem;
	/* height: 10rem; */
	vertical-align: middle;
	line-height: 10rem;
	top: 50%;
	transform: translate3d(0, -50%, 0);
	cursor: pointer;
}

label.labelSlider:before {
	content: "\276D"; /* icono flecha */
	right: 100%;
	/* border-top-left-radius: 50%;
	border-bottom-left-radius: 50%; */
}

label.labelSlider:after {
	content: "\276C"; /* icono flecha */
	 left: 100%;
	/*border-top-right-radius: 50%;
	border-bottom-right-radius: 50%; */
}

.big-text{
  white-space: pre-wrap;      /* CSS3 */
   white-space: -moz-pre-wrap; /* Firefox */
   white-space: -pre-wrap;     /* Opera <7 */
   white-space: -o-pre-wrap;   /* Opera 7 */
   word-wrap: break-word;      /* IE */

}
/* .scroll-style::-webkit-scrollbar { width: 8px; height: 3px;}
.scroll-style::-webkit-scrollbar-button {  background-color: #E0E0E0; }
.scroll-style::-webkit-scrollbar-track {  background-color:yellow;}
.scroll-style::-webkit-scrollbar-track-piece { background-color:#E0E0E0;}
.scroll-style::-webkit-scrollbar-thumb { height: 50px; background-color: #757575; border-radius: 3px;}
.scroll-style::-webkit-scrollbar-corner { background-color: green;}
.scroll-style::-webkit-resizer { background-color: #666;} */

</style>
