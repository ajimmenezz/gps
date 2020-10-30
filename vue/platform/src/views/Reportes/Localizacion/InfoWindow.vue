<template>
    <div class=" container">
      <div class="row">
        <div class="col-12 col-fluid">
          <h5>{{report.alias}}</h5>
        </div>
        <div class="col-6">
          <config-data-label IDinput="date" label="Fecha:" :value="GetTimeString(report.timestamp)"></config-data-label>
        </div>
        <div class="col-6">
          <config-data-label IDinput="reportType" label="Reporte:" :value="report.reportTypeString"></config-data-label>
        </div>
        <div class="col-12">
          <config-data-label IDinput="address" label="Direccion:" :value="report.address"></config-data-label>
        </div>
      </div>
    </div>
</template>

<script>
export default {
  name: 'infowindoswDispositivo',
  props: ['report'],
  data () {
    return {
    }
  },

  created () {
    // this.loadInfo()
  },
  methods: {
    GetTimeString (timestamp) {
      return this.$moment(timestamp * 1000).format('LL HH:mm:ss a')
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

</style>
