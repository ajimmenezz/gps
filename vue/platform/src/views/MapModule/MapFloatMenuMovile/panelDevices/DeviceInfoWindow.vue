<template>
    <div  >
         <draggable
        :name="draggable.name"
        :top="draggable.top"
        :left="draggable.left"
        :width="draggable.width"
        :height="draggable.height"
        :zindex="draggable.index"
        v-if="draggable.show">
            <draggable-header>
                <div class="continer-fluid" style="padding-bottom: 25px;">
                    <div class="col-12 draggable--draggable move"
                    style="height:100px;">
                    <!-- contenido header -->
                      <div class="row" >
                        <div class="col-1 size-movile float-left" style="padding:0px; padding-top: 10px;" @click="closeList()">
                          <span >
                            <i class="icon icon-lg universalicon-arrow-left cursor" v-if="!this.$store.state.typeDevice.isHorizontal"></i>
                            <i class="icon icon-lg universalicon-arrow-left cursor" v-else></i>
                          </span>
                        </div>
                        <div class="col-11 float-right" style="padding-top: 10px;"> <config-text-typography :title="device.alias" dispTitle="false"></config-text-typography></div>
                      </div>

                      <div class="row">
                        <div class="col-12 " style="padding-right: 30px;">

                              <span class=" float-right"  v-if="device.report.states.ignition"><config-data-label  IDinput="estatus" label="Motor: " value="ENCENDIDO" ></config-data-label></span>
                          <span class=" float-right"  v-if="!device.report.states.ignition"><config-data-label  IDinput="estatus" label="Motor: " value="APAGADO"></config-data-label></span>

                        </div>
                        <div class="col-12 float-right" v-if="device.iconGestionDevices && device.iconLocateDevices && device.iconLocateDevicesTrue" style="padding-right:20px;">
                          <div class="row float-right">
                            <div class="col" style="width: 50px !important;">
                                <span @click="deviceParoMotor(device.id, device.imei,device.report.states.engineEnabled)" v-if="permission_paroMotor">
                                  <i class="cursor icon-md icon universalicon-shutdown colorText-green" v-if="device.report.states.engineEnabled" ></i>
                                  <i class="cursor icon-md icon universalicon-shutdown colorText-red" v-else></i>
                                </span>
                            </div>
                              <div class="col" style="width: 50px !important;">
                                <i class="icon icon-lg universalicon-target-fixed cursor colorText-green cssToolTip" @click="localizar(device.id,device.imei)" v-if="device.locationStatus!=3"><span style="width: 55px !important; left:-120% !important;">Localizado</span></i>
                                <i class="icon icon-lg universalicon-target-fixed cursor colorText-red cssToolTip" @click="localizar(device.id,device.imei)" v-if="device.locationStatus==3"><span style="width: 55px !important; left:-120% !important;">Sin localizar</span></i>
                              </div>

                              <div class="col" style="width: 50px !important;"><i class="icon icon-lg universalicon-streetview cursor" @click="showStreetView()"></i></div>

                              <div class="col" style="width: 50px !important;" v-if="device.report.states.gsm.strength!=null">

                                  <i class="icon icon-lg universalicon-signal-full cursor colorText-green cssToolTip" v-if="device.report.states.gsm.strength>75" ><span style="width: 55px !important; left:-120% !important;">Alta</span></i>
                                  <i class="icon icon-lg universalicon-signal-mid cursor colorText-green cssToolTip" v-if="device.report.states.gsm.strength>=51 && device.report.states.gsm.strength<=75"><span style="width: 55px !important; left:-120% !important;">Media</span></i>
                                  <i class="icon icon-lg universalicon-no-signal cursor colorText-green cssToolTip" v-if="device.report.states.gsm.strength>=1 && device.report.states.gsm.strength<=50"><span style="width: 55px !important; left:-120% !important;">Baja</span></i>
                                  <i class="icon icon-lg universalicon-no-signal cursor cssToolTip" v-if="device.report.states.gsm.strength==0"><span style="width: 55px !important; left:-120% !important;">Sin señal</span></i>

                              </div>

                          </div>
                        </div>

                        <div class="col-12 float-right" v-if="!device.iconLocateDevices">
                          <span class="badge badge-pill badge-warning" style="font-size: 11px;">Localizando</span>
                        </div>
                        <div class="col-12 float-right" v-if="!device.iconLocateDevicesTrue">
                          <span class="badge badge-pill badge-success" style="font-size: 11px;">Localizado</span>
                        </div>
                        <div class="col-12 float-right" v-if="!device.iconGestionDevices">
                          <span class="badge badge-pill badge-warning" style="font-size: 11px;">Realizando paro motor</span>
                        </div>

                        <!-- <div class=" col-6 float-left"><config-text-typography title=""></config-text-typography></div> -->
                        <!-- <div class="col-8 float-left" style="padding-left:30px;" v-if="device.report.states.ignition"><config-data-label  IDinput="estatus" label="Motor: " value="Encendido" ></config-data-label></div>
                        <div class="col-8 float-left" style="padding-left:30px;" v-if="!device.report.states.ignition"><config-data-label  IDinput="estatus" label="Motor: " value="Apagado"></config-data-label></div>
                        <div class="col-4 float-right colorText-green" v-if="device.locationStatus!=3" style="font-weight: bold;"><config-text-typography texto="Localizado" textAlign='right'></config-text-typography></div>
                        <div class="col-4 float-right colorText-red"><config-text-typography texto="Sin localizar"  v-if="device.locationStatus==3" style="font-weight: bold;" textAlign='right'></config-text-typography></div> -->

                        <!-- <hr style="margin: 0px;  margin-bottom: 5px; width:100%"> -->
                        </br>
                      </div>

                    <!-- fin contenido header -->

                    </div>

                </div>
            </draggable-header>
            <draggable-content>
                <div class="container-fluid">
                  <div id="ContentScroll" class="row" >
                    <div class="col-12" style="margin-bottom:30px;">

                      <div class="row" >
                        <div class="col-12 float-left" style="margin-bottom: 5px;" ><config-text-typography subtitle="LOCALIZACIÓN" color="#04a9f5 !important"></config-text-typography></div>

                        <div class="col-12" >
                          <div class="row" style="margin-left: 0px; margin-right: 0px;">
                            <hr style="margin: 0px;  margin-bottom: 7px; width:100%">
                              <div class="big-text col-12"><config-data-label IDinput="ultReport" label="Fecha y hora:" :value="FechaHora" ></config-data-label></div>

                              <div class="big-text col-12 ">   <!-- <hr style="margin: 0px;  margin-bottom: 7px; width:100%"> -->
                              <config-data-label IDinput="position" label="Posición:" :value="`${StringLat}, ${StringLng}`" ></config-data-label></div>
                              <!-- <hr style="margin: 0px;  margin-bottom: 7px; width:100%"> -->
                            <div class="big-text col-12 col-md-6"><config-data-label IDinput="TimePLace" label="Tiempo lugar:" value="0:20" ></config-data-label></div>
                            <!-- <hr style="margin: 0px;  margin-bottom: 7px; width:100%"> -->
                            <div class="big-text col-12 col-md-6"><config-data-label IDinput="Velociodad" label="Velocidad:" :value="stringSpeed" ></config-data-label></div>
                            <!-- <hr style="margin: 0px;  margin-bottom: 7px; width:100%"> -->
                            <div class="big-text col-11 big-text"><config-data-label IDinput="addres" label="Dirección:" :value="device.report.position.address" ></config-data-label></div>
                            <!-- <hr style="margin: 0px;  margin-bottom: 7px; width:100%"> -->

                          </div>
                        </div>

                      </div>

                      <div class="row">
                        <div class="col-12  float-left" style=" margin-top: 15px; margin-bottom: 5px;"><config-text-typography subtitle="VEHÍCULO" color="#04a9f5 !important"></config-text-typography></div>

                        <div class="col-12" >
                          <div class="row" style="margin-left: 0px; margin-right: 0px;">
                            <hr style="margin: 0px;  margin-bottom: 7px; width:100%">

                            <div class="big-text col-12 float-right"><config-data-label IDinput="conductor" label="Conductor:" :value="deviceAllInfo.driver"></config-data-label></div>
                            <!-- <hr style="margin: 0px;  margin-bottom: 7px; width:100%"> -->
                            <div class="big-text col-12 float-right"><config-data-label IDinput="telConductor" label="Teléfono:" :value="deviceAllInfo.driverPhone"></config-data-label></div>
                            <!-- <hr style="margin: 0px;  margin-bottom: 7px; width:100%"> -->
                            <div class="big-text col-12 col-md-6 float-right"><config-data-label IDinput="vehPlacas" label="Placas:" :value="deviceAllInfo.carplate"></config-data-label></div>
                            <!-- <hr style="margin: 0px;  margin-bottom: 7px; width:100%"> -->
                            <div class="big-text col-12 col-md-6 float-right"><config-data-label IDinput="imei" label="IMEI:" :value="device.imei"></config-data-label></div>
                            <!-- <hr style="margin: 0px;  margin-bottom: 7px; width:100%"> -->
                              <div class="big-text col-12 float-right"><config-data-label IDinput="vehSerie" label="No. Serie:" :value="deviceAllInfo.vehicleVIN"></config-data-label></div>
                              <!-- <hr style="margin: 0px;  margin-bottom: 7px; width:100%"> -->
                              <div class="big-text col-12 col-md-6 float-right"><config-data-label IDinput="vehMarca" label="Marca:" :value="deviceAllInfo.vehicleBrand"></config-data-label></div>
                              <!-- <hr style="margin: 0px;  margin-bottom: 7px; width:100%"> -->
                            <div class="big-text col-12 col-md-6 float-right"><config-data-label IDinput="vehModelo" label="Modelo:" :value="deviceAllInfo.vehicleModel"></config-data-label></div>
                            <!-- <hr style="margin: 0px;  margin-bottom: 7px; width:100%"> -->
                              <div class="big-text col-12 col-md-6 float-right"><config-data-label IDinput="vehAnio" label="Año:" :value="deviceAllInfo.vehicleYear"></config-data-label></div>
                              <!-- <hr style="margin: 0px;  margin-bottom: 7px; width:100%"> -->
                            <div class="big-text col-12 col-md-6 float-right"><config-data-label IDinput="vehColor" label="Color:" :value="deviceAllInfo.vehicleColor"></config-data-label></div>

                          </div>
                        </div>

                      </div>

                      <div class="row">
                        <div class="col-12 text-left" style="margin-top:15px; margin-bottom:5px;">
                          <config-text-typography subtitle="DISPOSITIVO GPS" color="#04a9f5 !important"></config-text-typography>
                          <hr>
                        </div>
                        <div class="col-12 text-left big-text" style="padding-left:30px">
                          <config-data-label IDinput="imei" label="IMEI:" :value="device.imei"></config-data-label>
                        </div>
                        <div class="col-12 text-left big-text" style="padding-left:30px">
                          <config-data-label IDinput="model" label="Modelo:" :value="deviceAllInfo.deviceModel"></config-data-label>
                        </div>
                        <div class="col-12 text-left big-text" v-if="deviceAllInfo.simNumber" style="padding-left:30px">
                          <config-data-label IDinput="sim" label="Telefono:" :value="deviceAllInfo.simNumber"></config-data-label>
                        </div>
                      </div>

                    </div>
                  </div>

                </div>
            </draggable-content>

        </draggable>

    </div>
</template>

<script>
import { API } from '@/mixins/API'
import { draggable, draggableHeader, draggableContent } from '@/components/draggable/'
import store from '@/store'
import modalParoMotor from '@/views/Modals/modalParoMotor'
/**
 * @group MapModule/MapFloatMenMovile/dispositivos
 * Deviceinfowindows de los datos de dipositivo
 */
export default {
  name: 'DeviceInfowindowsDispositivo',
  mixins: [API],
  inject: ['getMap', 'onDevicesSelected', 'getDraggablePropertiesDeviceInfo', 'getDraggableProperties', 'resizeMapManual', 'setZoomControl', 'resizeMap'],
  components: {
    draggable,
    draggableHeader,
    draggableContent

  },
  data () {
    return {
      device: null,
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
      deviceVelocidad: '',
      deviceID: null,
      deviceImei: null,
      draggable: {
        name: 'infoDevicesMobile',
        top: 0,
        height: 0,
        width: 0,
        left: 0,
        index: 99,
        maxHeightScroll: 0,
        show: true
      }

    }
  },
  created () {
    var deviceData = this.getDraggablePropertiesDeviceInfo()

    this.deviceID = deviceData.id
    this.deviceImei = deviceData.imei

    this.loadInfo()
    this.onWindowResizeInfo()
  },
  mounted () {
    $('#menu_moviles').css({ display: 'none' })
    this.map = this.getMap()

    $(window).resize(this.onWindowResizeInfo)
  },
  beforeDestroy () {
    this.setZoomControl(false)
  },
  destroyed () {
    this.draggable.show = false
    $('#menu_moviles').css({ display: 'block' })
  },
  methods: {
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
   * Manda a llamar la funcion para calcular los tamaños de pantalla
   */
    onWindowResizeInfo () {
      this.resizeDraggableInfo()
    },
    /**
   * @vuese
   * Se obtiene el alto y ancho de pantalla total y se estable el tamaño y posicion del panel de dispositivos restandole los valores de head y footer para establecer el scroll del contenido
   */
    resizeDraggableInfo () {
      if (this.draggable.show) {
        this.setZoomControl(true)
        this.$store.state.typeDevice.isHorizontal = false

        var windowWidth = $(window).width()
        var windowHeight = $(window).height()

        var draggableHeaderHeight = 100
        var navbarSmallHeight = 65

        if (windowHeight > windowWidth) {
          console.debug('portrait')
          // Portrait mode
          this.$store.state.typeDevice.isHorizontal = false
          var height = Math.floor((60 * windowHeight) / 100)

          this.draggable.height = height - draggableHeaderHeight
          this.draggable.width = windowWidth
          this.draggable.top = windowHeight - height
          this.draggable.left = 0

          height = windowHeight - (height + navbarSmallHeight)
          this.resizeMapManual(height, windowWidth)
        } else {
          console.debug('landscape')
          // Landscape mode
          this.$store.state.typeDevice.isHorizontal = true

          this.draggable.height = windowHeight - (navbarSmallHeight + draggableHeaderHeight)
          this.draggable.width = Math.floor((45 * windowWidth) / 100)
          this.draggable.top = navbarSmallHeight
          this.draggable.left = windowWidth - this.draggable.width

          this.resizeMapManual(windowHeight - navbarSmallHeight, this.draggable.left)
        }

        console.debug('DeviceInfo', 'size', this.draggable.height, this.draggable.width)
      }
    },
    /**
   * @vuese
   * Cierra el panel
   */
    closeList () {
      this.clearDevices()
      // manda a cerrar el panel
      this.$emit('closeList')
    },
    /**
   * @vuese
   * Limpia valores y store de dispositivos
   */
    clearDevices () {
      this.map.showAllMarkers(true)
      this.$store.dispatch('devices/CLEAR_DEVICES_SELECTED')
      this.$store.dispatch('devices/CLEAR_FLEET')
      this.onDevicesSelected([])
    },
    /**
   * @vuese
   * Se obtiene la informacion del dispositivo a consultar
   */
    async loadInfo () {
      this.device = this.store.state.devices.devices[this.deviceImei]

      var response = await this.getRequest(`devices/${this.deviceID}`)
      this.deviceAllInfo = response.data.device
      // console.log('DeviceInfo', this.device)
      // console.log('allInfo', this.deviceAllInfo)
      this.isLoading = true
      // this.latLng = 'Lat: ' + this.device.report.position.lat + ', Lng: ' + this.device.report.position.lng
      // this.deviceVelocidad = this.device.report.states.speed + ' km/h'
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
      var fechaString = this.$moment(date).format(' MMMM DD YYYY, h:mm a')
      this.FechaHora = `${fechaString} (${from})`
    },
    /**
   * @vuese
   * Manda a localizar dispositivo mediente webSocket
   */
    localizar (id, imei) {
      var payload = {
        'imei': imei

      }
      this.store.dispatch('ws/LOCATE', payload)
    },
    /**
   * @vuese
   * Manda a abrir street view de la posicion del dispositivo
   */
    showStreetView () {
      // this.$emit('onShowStreetView')
      this.store.commit('mapModule/SHOW_STREET_VIEW', this.deviceImei)
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

#infoDevicesMobile{
   background: #f4f7fa;
}

#infoDevicesMobile-header{
  margin: 25px;
  background: white !important;
  margin-bottom: 0px;
}

#infoDevicesMobile-content{
  margin: 25px;
  background: white !important;
  margin-top: 0px;
  width:auto !important;
   max-width: auto !important;
}

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
