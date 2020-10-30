<template>
    <draggable
      name="streetview"
      id="streetview"
      :top="container.top"
      :left="container.left"
      :width="container.width"
      :height="container.height"
      :zindex="100">

      <draggable-header>
          <!--Mobile-->
          <div class="container-fluid streetview-header">
            <div class="row" id="head" style="min-height: 50px;" v-if="this.$store.state.typeDevice.mobileOrTable">
              <div class="col-10 text-left cssToolTipp">
                <p style="top: 1px !important; left: 40% !important;">Arrastra para mover la ventana</p>
                <div style="margin-right:15px; margin-top:15px; display:inline-block">
                  <i class="icon icon-md universalicon-left cursor cssToolTipp"  @click="close()"><p style="top: 25px !important; right: -70% !important; position: initial;">cerrar</p></i>
                </div>
                <div style="display:inline-block; position: absolute; top: 15px;">
                   <b>STREET VIEW</b>
                </div>

              </div>
            </div>

            <div class="row" id="head"  v-if="!this.$store.state.typeDevice.mobileOrTable" >
              <div class="col-10 text-left cursor draggable--draggable cssToolTipp">
                <p style="top: 1px !important; left: 40% !important;">Arrastra para mover la ventana</p>
                <b>STREET VIEW</b>
              </div>
              <div class="col-2 text-right">
                <span ><i class="icon icon-md universalicon-cancel cursor cssToolTipp"  @click="close()"><p style="top: 25px !important; right: -70% !important; position: initial;">cerrar</p></i></span>
              </div>
            </div>
          </div>

      </draggable-header>

      <draggable-content>
        <div class="container-fluid">
          <div class="row text text-justify streetViewRow">
            <div class="col-9 streetViewCol">
              <b>{{streetView.id}}</b>
            </div>
            <div class="col-9 streetViewCol">
              <b>{{streetView.fechaString | moment('from', this.timestampNow)}}</b>
            </div>
            <div class="col-9 streetViewCol">
              <small>{{streetView.direccion}}</small>
            </div>
          </div>
        </div>

        <google-streetview
          name="StreetView"
          :lat="streetView.lat"
          :lng="streetView.lng"
          :course="0"
          :addressControl="false"
          :clickToGoControl="false"
          :linksControl="false"
          :zoomControl="streetView.zoomControl"
          ref="streetView"
          :height="container.height"
        />
      </draggable-content>
    </draggable>
</template>

<script>
import { draggable, draggableHeader, draggableContent } from '@/components/draggable/'
/**
  * @vuese
     * @group MapModule
 * StreetView de dirección de dispositivo
 */
export default {
  name: 'StreetviewDispositivo',
  components: {
    draggable,
    draggableHeader,
    draggableContent,
    googleStreetview: () => import('@/components/google/google.streetview')
  },
  props: {
    // valor del top del componente
    top: {
      type: Number,
      default: 0
    },
    // valor a la derecha
    left: {
      type: Number,
      default: 0
    },
    // valor de alto del componente
    height: {
      type: Number,
      required: true
    },
    // valor de ancho del componente
    width: {
      type: Number,
      required: true
    },
    // nombre del dipositivo
    deviceName: {
      type: String,
      default: ''
    },
    // Imei del dispositivo
    deviceImei: {
      type: String

    },
    // hora del dispositivo
    time: {
      type: Number,
      default: 0
    },
    // direccion del dispositivo
    address: {
      type: String,
      default: ''
    },
    // latitud de la direccion de dispositivo
    lat: {
      type: Number,
      required: true
    },
    // longitud de la direccion de dispositivo
    lng: {
      type: Number,
      required: true
    }
  },
  data: function () {
    return {
      toggle: false,
      container: {
        height: this.height,
        width: this.width,
        top: this.top,
        left: this.left
      },
      streetView: {
        id: this.deviceName,
        fechaString: this.time,
        direccion: this.address,
        lat: this.lat,
        lng: this.lng,
        zoomControl: true
      },
      timestampNow: Date.now()

    }
  },
  created () {
    this.setDraggablePosition()
    this.customize()
  },
  mounted () {
    $(window).resize(function () {
      this.customize()
      this.setDraggablePosition()
    }.bind(this))

    window.setInterval(function () {
      this.timestampNow = Date.now()
    }.bind(this), 1000)
  },
  methods: {
    /**
   * @vuese
   * Estable si se muestra o no el panel de control de zoom del mapa
   */
    customize () {
      if (this.$store.state.typeDevice.mobileOrTable) {
        this.streetView.zoomControl = false
      } else {
        this.streetView.zoomControl = true
      }
    },
    /**
   * @vuese
   * Se obtiene el alto y ancho de pantalla total y se estable la posicion del componente.
   */
    setDraggablePosition () {
      var windowWidth = window.innerWidth
      var menuSmallMaxWidth = 891
      var menuSmallHeight = 70
      var fixWindowWidthCalculation = 100

      if (this.$store.state.typeDevice.mobileOrTable) {
        this.container.top = 0
        this.container.left = 0
      } else {
        /**
       * NOTE: el calculo de @media-query en css difiere de window.innerWith
       * en mis pruebas realizadas encontre una diferencia de 67 por lo cual
       * proceso a hacer un ajuste para poder calcular 'correctamente'
       * el ancho de la pantalla
       * un mejor ejemplo de lo que me refiero puede ser consultado en
       * https://ryanve.com/lab/dimensions/
       *  */
        if ((windowWidth - fixWindowWidthCalculation) > menuSmallMaxWidth) {
          this.container.top = 10
          this.container.left = $('#navPrincipal').width() + 10
        } else {
          this.container.top = menuSmallHeight + 10
          this.container.left = 10
        }
      }

      $('#streetview').css('left', this.container.left)
    },
    /**
   * @vuese
   * Cierra el componente
   */
    close: function () {
      this.$emit('onClose')
    }
  },
  watch: {
    /**
   * @vuese
   * Establece el valor de alto
   */
    height: function (value) {
      this.container.height = value
    },
    /**
   * @vuese
   * Establece el valor de ancho
   */
    width: function (value) {
      this.container.width = value
    },
    /**
   * @vuese
   * Establece el valor de nombre de dispositivo
   */
    deviceName (value) {
      this.streetView.id = value
    },
    /**
   * @vuese
   * Establece el valor de nombre de hora
   */
    time (value) {
      this.streetView.fechaString = value
    },
    /**
   * @vuese
   * Establece el valor de nombre de direccion
   */
    address (value) {
      this.streetView.direccion = value
    },
    /**
   * @vuese
   * Establece el valor de latitud de dispositivo
   */
    lat (value) {
      this.streetView.lat = value
    },
    /**
   * @vuese
   * Establece el valor de longitud de dispositivo
   */
    lng (value) {
      this.streetView.lng = value
    }
  }

}
</script>

<style>
.streetview-header{
  background-color:#3f4d67; color:white;
}
.streetViewCol {
  background-color: black;
  opacity: 0.7;
  color: white;
  z-index: 5;
}
.streetViewRow {
  width: 100%;
  margin-top: 5px;
  position: absolute;
}
</style>
