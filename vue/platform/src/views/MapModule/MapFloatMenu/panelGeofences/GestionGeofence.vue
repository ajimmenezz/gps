<template>
  <div class="card-body card-body-conf">
     <loader-small v-if="loader.show" :message="loader.message"/>
      <div class="row " >

          <div class="col-12">

              <div class="col-12 float-right" style="padding:0px;" v-if="getDataDrawing.accion==='editar'">
                <span >
                  <!-- <i v-if="getDataDrawing.figureType==1" class=" icon-small icon universalicon-target"></i>
                  <i v-if="getDataDrawing.figureType==2" class="icon-small icon universalicon-polygon "></i> -->
                  <span @click="configuracion()"><i id="conf" class="icon-small icon universalicon-settings cursor cssToolTipp"><p style="top: 23px !important; right: -70% !important;">Configurar geocerca</p></i></span>
                </span>
              </div>

          </div>
           <div class="col-12 float-left" v-if="tipoAccion==='nueva'">
             <label style="padding-top:5px;">Selecciona tipo de geocerca: </label>
              <span @click="tipo('radial')"><i id="radial" class="cursor icon-small icon universalicon-target  float-right cssToolTipp"><p style="top: 23px !important; right: -70% !important;">Circular</p></i></span>
              <span @click="tipo('poligonal')"><i id="poligonal" class="icon-small icon universalicon-polygon  float-right cursor cssToolTipp"><p style="top: 23px !important; right: -70% !important;">Poligonal</p></i></span>
              <!-- <span @click="configuracion(this.geocercaIDRegister)" v-if="this.geocercaIDRegister!=null"><i id="conf" class="icon-small icon universalicon-settings cursor"></i></span> -->
            <br>
            </div>

          <div class="col-12 float-left" >
            <config-text-typography  texto="Nombre de geocerca: "></config-text-typography>
              <config-input  id="newGeofence" label="null"  typeinput="text"  placeholder="Nombre" v-model.trim="newGeofence" required="true" :valor="newGeofence"> </config-input>
          </div>
          <div class="col-12" v-if="showTipoGeocerca==='radial'">
            <div class="row float-left">
              <div class="col-9"  style=" padding-right: 0px;">
               <!-- v-model.number="radioGeofence"  -->
               <config-text-typography  texto="Radio de geocerca: "></config-text-typography>
                  <config-input  id="radioGeofencee" label="null"  typeinput="number"  placeholder="Radio"   @input="getRadioGeofence" required="true" miNumber="0"  :valor="radioGeofence"> </config-input>
              </div>
              <div class="col-3" style="padding: 0px; padding-top: 35px; padding-left:5px;">
                <config-text-typography  texto="Metros"></config-text-typography>
              </div>
            </div>
          </div>
          <div style="text-align: justify; background: #eeeeeed6; padding:1px; margin-bottom:10px;" class="row"  v-if="tipoAccion==='nueva'">
            <span  class="col-12" v-if="showTipoGeocerca==='radial'">Haz click en el mapa y empieza a dibujar la geocerca circular</span>
            <span  class="col-12" v-else>Haz varios click en el mapa y empieza a dibujar la geocerca poligonal</span>
          </div>
           <div class="col-12" id="alertasGeocercas"></div>
             <!-- <div class="col-12" id="alertConfigEmail"></div>
            <div class="col-12" id="alertConfigDevice"></div> -->

          <div class="col-6 ">
              <button class="btn  btn-secondary mb-2" @click="cancelFormGeofence()">CANCELAR</button>
          </div>
          <div class="col-6">
              <!-- aqui boton para editar -->
              <button class="btn btn-primary mb-2" @click="saveGeofence()" >GUARDAR</button>
          </div>

      </div>

  </div>
</template>

<script>
import { API } from '@/mixins/API'
import GeofenceConfig from '@/views/MapModule/MapFloatMenu/panelGeofences/modalConfig'
/**
 * @group MapModule/MapFloatMenu/Geocercas
 * Formulario de crear, editar y consultar geocercas
 */
export default {
  name: 'FormularioGeocerca',
  mixins: [API],
  data () {
    return {
      newGeofence: '',
      radioGeofence: 1,
      tipoGeocerca: 'radial',
      dataGeofence: {},
      geocercaIDRegister: null,
      loader: {
        show: false
      }
    }
  },
  components: {
    loaderSmall: () => import('@/components/loader/loader.small')
  },
  // Id de geocerca
  // `accion` puede ser: nueva o editar
  // arreglo con la informacion de la geocerca
  props:
  ['geofenceID', 'accion', 'dataDrawing'],
  created () {
    this.newGeofence = ''
    this.radioGeofence = 1
    this.tipoGeocerca = 'radial'
    this.geocercaIDRegister = null
    this.loader.show = true
  },
  mounted () {
    if (this.accion !== 'editar') {
      this.tipo('radial')
    }
    if (this.accion === 'editar') {
      $('#' + this.tipoGeocerca).addClass('active')
    }
    // this.dataDrawing.tipo
    this.loader.show = false
  },
  destroyed () {
    this.cancelFormGeofence()
    this.showAllDrawingGeo()
  },
  methods: {
    /**
   * @vuese
   * Limpia variables
   */
    limparAll () {
      this.newGeofence = ''
      this.radioGeofence = 1
      this.tipoGeocerca = ''
      this.geocercaIDRegister = null
    },
    /**
   * @vuese
   * Oculta dibujos de geocerca en mapa
   */
    showAllDrawingGeo () {
      /**
   * @arg booleano oculta dibujos de mapa
   */
      this.$emit('showAllDrawing', false)
    },
    /**
   * @vuese
   * Limpia variables
   */
    limpiarDatos () {
      // this.newGeofence = ''
      this.radioGeofence = 1
      this.tipoGeocerca = 'radial'
      return 1
    },
    /**
   * @vuese
   * Modifica el radio de geocerca
   * @arg `value` radio de geocerca
   */
    getRadioGeofence (value) {
      var valor = value
      if (valor == '' || valor == null) {
        valor = 1
      }

      this.radioGeofence = valor
      var datos
      if (this.accion === 'editar') {
        datos = {
          'tipo': this.accion,
          'radio': this.radioGeofence,
          'id': this.dataGeofence.id
        }
      }
      if (this.accion === 'nueva') {
        datos = {
          'tipo': this.tipoGeocerca,
          'radio': this.radioGeofence,
          'id': null
        }
      }

      this.$emit('setRadiusCircle', datos)
    },
    /**
   * @vuese
   * Manda a dibujar la geocerca en caso de nueva
   * @arg `tipoGeo` tipo de geocerca. 1: radial(circular), 2: poligonal
   */
    tipo (tipoGeo) {
      console.debug('ENTRA_TIPO', tipoGeo)
      $('#radial').removeClass('active')
      $('#poligonal').removeClass('active')
      var dataGeocerca = {}

      // this.limpiarDatos()

      var data
      this.tipoGeocerca = tipoGeo
      this.dataDrawing.tipo = tipoGeo
      if (this.tipoGeocerca === 'radial') {
        data = {}
        data = {
          'radio': this.radioGeofence,
          'tipo': this.tipoGeocerca
        }

        dataGeocerca.tipo = this.tipoGeocerca
        dataGeocerca.radio = this.radioGeofence
        this.tipoGeocerca = 'radial'
      }
      if (this.tipoGeocerca === 'poligonal') {
        data = {}
        data = {
          'tipo': this.tipoGeocerca
        }

        dataGeocerca = {}
        dataGeocerca.tipo = this.tipoGeocerca
        this.tipoGeocerca = 'poligonal'
      }

      $('#' + this.tipoGeocerca).addClass('active')
      this.$emit('DrawingGeocerca', dataGeocerca)
    },
    /**
   * @vuese
   * Guarda lso datos de una geocerca nueva
   */
    async saveGeofence () {
      console.debug('DATOS', this.dataDrawing, this.newGeofence, this.tipoGeocerca, this.dataDrawing.size)
      if (this.dataDrawing.size != 1 || this.dataDrawing.size == undefined) {
        console.debug('sin dibujo')
        $('#alertasGeocercas').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Por favor dibuja en el mapa</div>")
        setTimeout(() => {
          $('#alertasGeocercas').html('')
        }, 3000)
        return false
      }
      if (this.newGeofence == '' || this.newGeofence == null) {
        console.debug('sin name')
        $('#alertasGeocercas').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Por favor ingresa nombre</div>")
        setTimeout(() => {
          $('#alertasGeocercas').html('')
        }, 3000)
        return false
      }

      this.$store.state.loader = true

      if (this.tipoGeocerca === 'radial') {
        if (this.radioGeofence < 5) {
          $('#alertasGeocercas').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>El radio de la geocerca no puede ser menor a 5 metros.</div>")
          setTimeout(() => {
            $('#alertasGeocercas').html('')
          }, 3000)
          return false
        }
      }

      var datos = {}
      var datosGeocerca
      var datosVertice = []
      var vertice

      if (this.accion === 'nueva') {
        datosGeocerca = {
          'geofenceType': 1,
          'behavior': 3,
          'name': this.newGeofence,
          'radio': this.radioGeofence
        }

        if (this.tipoGeocerca === 'radial') {
          datosGeocerca.figureType = 1
          datosGeocerca.coords = [{ 'lat': this.dataDrawing.lat, 'lng': this.dataDrawing.lng }]
        }
        if (this.tipoGeocerca === 'poligonal') {
          datosGeocerca.figureType = 2

          datosGeocerca.coords = this.dataDrawing.vertices// this.dataDrawing
        }

        datos['geofence'] = datosGeocerca

        var request = await this.postRequest('geofences', datos)

        if (request.success === true) {
          this.geocercaIDRegister = request.data.geofenceID

          $('#alertasGeocercas').html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha guardado la geocerca<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
          setTimeout(() => {
            $('#alertasGeocercas').html('')
            this.cancelFormGeofence()
            this.configuracion()
          }, 2000)

          this.$store.state.loader = false
        } else {
          this.$store.state.loader = false
          $('#alertasGeocercas').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se ha creado la geocerca<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
        }
      }
      if (this.accion === 'editar') {
        datosGeocerca = {
          'behavior': this.dataGeofence.behavior,
          'name': this.newGeofence,
          'radio': this.radioGeofence

        }

        for (var i = 0; i < this.dataDrawing.coords.length; i++) {
          vertice = JSON.parse(JSON.stringify(this.dataDrawing.coords[i]))

          datosVertice.push({ 'lat': parseFloat(vertice.lat), 'lng': parseFloat(vertice.lng) })
        }

        datosGeocerca.coords = datosVertice// this.dataDrawing.coords

        datos['geofence'] = datosGeocerca

        var request = await this.putRequest('geofences/' + this.dataDrawing.id, datos)

        if (request.success === true) {
          $('#alertasGeocercas').html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha guardado la geocerca<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
          setTimeout(() => {
            $('#alertasGeocercas').html('')
            this.cancelFormGeofence()
          }, 3000)
          this.$store.state.loader = false
        } else {
          this.$store.state.loader = false
          $('#alertasGeocercas').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se ha creado la geocerca<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
        }
      }
    },
    /**
   * @vuese
   * Cierra o abre el panel
   */
    cancelFormGeofence () {
      // manda a cerrar o abrir el panel
      $('#radial').removeClass('active')
      $('#poligonal').removeClass('active')

      this.$emit('onClose')
    },
    /**
   * @vuese
   * Abre el modal de configuracion de geocerca
   */
    async configuracion () {
      this.$store.state.loader = true
      // $('#conf').addClass('active')
      this.$store.commit('CLEAR_MODAL_DINAMIC')

      var datos = {
        'component': GeofenceConfig,
        'datos': {
          'accion': this.accion,
          'idGeofence': this.geocercaIDRegister,
          'dataGeofence': this.dataGeofence

        }
      }

      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)
      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
    }

  },
  computed: {
    /**
   * @vuese
   * Obtiene tipo de geocerca
   */
    showTipoGeocerca () {
      return this.tipoGeocerca
    },
    /**
   * @vuese
   * Obtiene accion. puede ser: `nueva`, `editar`
   */
    tipoAccion () {
      return this.accion
    },
    /**
   * @vuese
   * Obtiene datos de geocerca y crea arreglos con la informacion correspondiente
   */
    getDataDrawing () {
      $('#radial').removeClass('active')
      $('#poligonal').removeClass('active')
      if (this.dataDrawing.size === 1) { // nueva sin datos de dibujo ni formulario
        if (this.dataDrawing.accion === 'editar') {
          this.dataGeofence = this.dataDrawing
          this.newGeofence = this.dataDrawing.name
          if (this.dataDrawing.figureType == 1) {
            this.tipoGeocerca = 'radial'
            this.radioGeofence = this.dataDrawing.radio
          }
          if (this.dataDrawing.figureType == 2) {
            this.tipoGeocerca = 'poligonal'
          }
        } else { // nueva
          this.tipoGeocerca = this.dataDrawing.tipo
          if (this.tipoGeocerca === 'radial') {
            this.radioGeofence = this.dataDrawing.radio
          } else {
            this.dataGeofence = this.dataDrawing
            this.tipoGeocerca = this.dataDrawing.tipo
          }
        }
        this.tipoGeocerca = this.dataDrawing.tipo
      }

      this.tipoGeocerca = this.dataDrawing.tipo
      $('#' + this.dataDrawing.tipo).addClass('active')

      return this.dataDrawing
    }
  }
}
</script>

<style>
.active{
  color:#04a9f5;
}
</style>
