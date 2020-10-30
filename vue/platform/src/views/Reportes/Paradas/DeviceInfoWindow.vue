<template>
 <!-- margin:10px; -->
    <div class=" container"  style="padding-left:0px; width: 380px; height: 200px;">

              <div class="row">
                <div class="col-12 float-left" ><config-text-typography subtitle="Parada"></config-text-typography></div><hr style="margin: 0px;  margin-bottom: 7px; width:100%">
                <div class="col-1"></div>
                <div class="col-10">
                  <div class="row" >
                     <div class="big-text col-12"><config-data-label IDinput="ultReport" label="Unidad:" :value="this.device.device.alias"></config-data-label></div>
                      <div class="big-text col-12"><config-data-label IDinput="ultReport" label="Fecha y hora:" :value="this.fecha"></config-data-label></div>
                      <div class="big-text col-12 "><config-data-label IDinput="position" label="Posición:" :value="this.positions"></config-data-label></div>
                    <div class="big-text col-12 big-text"><config-data-label IDinput="addres" label="Dirección:" :value="this.device.position.address"></config-data-label></div>

                  </div>
                </div>
                <div class="col-1"></div>
              </div>

    </div>
</template>

<script>
import { API } from '@/mixins/API'
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
      fecha: null,
      positions: null,
      store

    }
  },

  created () {
    this.device = this.store.state.infoParadasIfowindows
    console.debug('created', this.store.state.infoParadasIfowindows)
    this.loadInfo()
  },
  mounted () {
    console.debug('munted')
    //   window.setInterval(function () {
    //   this.updateString()
    // }.bind(this), 1000)
  },
  methods: {
    /**
   * @vuese
   * Se obtiene la informacion del dispositivo a consultar
   */
    async loadInfo () {
      this.fecha = 'Del ' + this.device.from.date + ' al ' + this.device.to.date
      this.positions = 'Lat: ' + this.device.position.lat + ', Lng: ' + this.device.position.lng
      console.debug('INFO_WNDOWS_PARADAS', this.device)
    }

  },
  computed: {

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
