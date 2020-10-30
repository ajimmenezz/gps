<template>
    <div>
        <div :id="mapID" v-if="showMap"></div>
        <div :id="id"></div>
    </div>
</template>

<script>
/**
* @vuese
 * @group components/google
 * componente google street view
 */
export default {
  name: 'google-streetvew',
  props: {
    // nombre
    name: {
      type: String,
      required: true
    },
    // alto
    height: {
      type: Number,
      default: 300
    },
    // latitud
    lat: {
      type: Number,
      required: true
    },
    // longitud
    lng: {
      type: Number,
      required: true
    },
    // titulo
    heading: {
      type: Number,
      default: 0
    },
    // tono
    pitch: {
      type: Number,
      default: 0
    },
    // control de direccion
    addressControl: {
      type: Boolean,
      default: true
    },
    // click al control
    clickToGoControl: {
      type: Boolean,
      default: true
    },
    // boton de cerrar de control
    closeButtonControl: {
      type: Boolean,
      default: false
    },
    // control de pantalla completa
    fullScreenControl: {
      type: Boolean,
      default: true
    },
    // control de link
    linksControl: {
      type: Boolean,
      default: true
    },
    // control de rotacion
    rotateControl: { // PanControl
      type: Boolean,
      default: true
    },
    // control de etiquetas
    roadLabelsControl: {
      type: Boolean,
      default: true
    },
    // control de zoom
    zoomControl: {
      type: Boolean,
      default: true
    }
  },
  data: function () {
    return {
      id: this.name + '-streetview',
      mapID: this.name + '-streetview-map',
      showMap: true,
      panorama: null,
      map: null
    }
  },
  mounted: function () {
    var position = { lat: this.lat, lng: this.lng }

    this.map = new google.maps.Map(document.getElementById(this.mapID), {
      center: position,
      zoom: 14
    })

    var el = document.getElementById(this.id)
    el.style.minHeight = this.height + 'px'

    var options = {
      position: position,
      pov: {
        heading: this.heading,
        pitch: this.pitch
      },
      addressControl: this.addressControl,
      clickToGo: this.clickToGoControl,
      enableCloseButton: this.closeButtonControl,
      fullscreenControl: this.fullScreenControl,
      linksControl: this.linksControl,
      panControl: this.rotateControl,
      showRoadLabels: this.roadLabelsControl,
      zoomControl: this.zoomControl
    }
    this.panorama = new google.maps.StreetViewPanorama(el, options)
    this.map.setStreetView(this.panorama)

    this.showMap = false

    this.panorama.addListener('position_changed', this.onPositionChanged)
  },
  methods: {
    /**
   * @vuese
   * Cambio de posicion
   * @arg `e` evento
   */
    onPositionChanged: function (e) {
      var position = this.panorama.getPosition()
      console.log(`StreetviewPositionChanged: ${position.lat()}, ${position.lng()}`)
      this.$emit('onPositionChanged', position.lat(), position.lng())
    },
    /**
   * @vuese
   * Centrar
   * @arg `lat` latitud
   * @arg `lng` longitud
   */
    center (lat, lng) {
      this.panorama.setOptions({
        position: {
          lat: Number(lat),
          lng: Number(lng)
        }
      })
    }
  },
  watch: {
    /**
   * @vuese
   * Establece el alto
   * @arg `value` valor
   */
    height (value) {
      var el = document.getElementById(this.id)
      el.style.minHeight = this.height + 'px'
    },
    /**
   * @vuese
   * Establece la latitud
   * @arg `value` valor
   */
    lat: function (value) {
      this.panorama.setOptions({
        position: {
          lat: Number(value),
          lng: Number(this.lng)
        }
      })
    },
    /**
   * @vuese
   * Establece longitud
   * @arg `value` valor
   */
    lng: function (value) {
      this.panorama.setOptions({
        position: {
          lat: Number(this.lat),
          lng: Number(value)
        }
      })
    },
    /**
   * @vuese
   * Establece titulo
   * @arg `value` valor
   */
    heading: function (value) {
      console.log(`HEADING heading: ${this.heading}| pith: ${this.pitch}`)
      this.panorama.setOptions({
        pov: {
          pitch: Number(this.pitch),
          heading: Number(value)
        }
      })
    },
    /**
   * @vuese
   * Establece tono
   * @arg `value` valor
   */
    pitch: function (value) {
      console.log(`PITCH heading: ${this.heading}| pith: ${this.pitch}`)
      this.panorama.setOptions({
        pov: {
          pitch: Number(value),
          heading: Number(this.heading)
        }
      })
    },
    /**
   * @vuese
   * Establece control de direccion
   * @arg `enabled` valor
   */
    addressControl: function (enabled) {
      this.panorama.setOptions({
        addressControl: enabled
      })
    },
    /**
   * @vuese
   * Establece click control
   * @arg `enabled` valor
   */
    clickToGoControl: function (enabled) {
      this.panorama.setOptions({
        clickToGo: enabled
      })
    },
    /**
   * @vuese
   * Establece control de cerrar
   * @arg `enabled` valor
   */
    closeButtonControl: function (enabled) {
      this.panorama.setOptions({
        enableCloseButton: enabled
      })
    },
    /**
   * @vuese
   * Establece control pantalla completa
   * @arg `enabled` valor
   */
    fullScreenControl: function (enabled) {
      this.panorama.setOptions({
        fullscreenControl: enabled
      })
    },
    /**
   * @vuese
   * Establece control de link
   * @arg `enabled` valor
   */
    linksControl: function (enabled) {
      this.panorama.setOptions({
        linksControl: enabled
      })
    },
    /**
   * @vuese
   * Establece control de rotacion
   * @arg `enabled` valor
   */
    rotateControl: function (enabled) {
      this.panorama.setOptions({
        panControl: enabled
      })
    },
    /**
   * @vuese
   * Establece control de etiquetas
   * @arg `enabled` valor
   */
    roadLabelsControl: function (enabled) {
      this.panorama.setOptions({
        showRoadLabels: enabled
      })
    },
    /**
   * @vuese
   * Establece control de zoom
   * @arg `enabled` valor
   */
    zoomControl: function (enabled) {
      this.panorama.setOptions({
        zoomControl: enabled
      })
    }
  }
}
</script>

<style>

</style>
