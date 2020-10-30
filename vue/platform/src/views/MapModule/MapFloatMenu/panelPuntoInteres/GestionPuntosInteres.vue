<template>
  <div class="card-body card-body-conf">
    <loader-small v-if="loader.show" :message="loader.message" />
    <div class="row" v-if="getDataDrawing.seccion==='PuntoInteres'">
      <div class="col-12 float-left">
        <config-text-typography texto="Nombre de punto de interés: "></config-text-typography>
        <config-input
          id="newPuntoInteres"
          label="null"
          typeinput="text"
          placeholder="Nombre"
          v-model.trim="newPuntoInteres"
          required="true"
          :valor="newPuntoInteres"
        ></config-input>
      </div>

      <div class="col-12">
        <div class="row">
          <div class="col-9 float-left" style=" padding-right: 0px;">
            <config-text-typography texto="Radio de punto de interés: "></config-text-typography>
            <config-input
              id="radioPuntoInteress"
              label="null"
              typeinput="number"
              placeholder="Radio"
              miNumber="0"
              :valor="radioPuntoInteres"
              @input="getradioPuntoInteres"
              required="true"
              disabled="true"
            ></config-input>
          </div>
          <div class="col-3 flot-left" style="padding: 0px; padding-top: 35px; padding-left:0px;">
            <config-text-typography texto="Metros"></config-text-typography>
          </div>
        </div>
      </div>

      <div class="col-12" id="alertasGeocercas"></div>

      <div class="col-6">
        <button class="btn btn-secondary mb-2" @click="cancelar()">CANCELAR</button>
      </div>
      <div class="col-6">
        <!-- aqui boton para editar -->
        <button class="btn btn-primary mb-2" @click="savePuntoInteres()">GUARDAR</button>
      </div>
    </div>

    <div class="row" v-if="getDataDrawing.seccion==='PuntoInteresCars'">
      <div class="col-12 float-left">
        <div class="row">
          <div class="col-9" style=" padding-right: 0px;">
            <config-text-typography texto="Distancia a consultar unidades del punto de interés: "></config-text-typography>
            <config-input
              id="distanciaCarsPuntoInteres"
              label="null"
              typeinput="number"
              placeholder="Distancia"
              miNumber="5"
              :valor="distanciaCarsPuntoInteres"
              v-model="distanciaCarsPuntoInteres"
              @input
              required="true"
            ></config-input>
          </div>
          <div class="col-3" style="padding: 0px; padding-top: 55px; padding-left:7px;">
            <config-text-typography texto="Metros"></config-text-typography>
          </div>
        </div>
      </div>
      <div class="col-12" id="alertasPuntos"></div>
      <div class="col-6">
        <button class="btn btn-secondary mb-2" @click="cancelar()">CERRAR</button>
      </div>
      <div class="col-6">
        <button class="btn btn-primary mb-2" @click="showCarsPuntoInteres()">MOSTRAR</button>
      </div>
    </div>
  </div>
</template>

<script>
import { API } from '@/mixins/API'
/**
 * @group MapModule/MapFloatMenu/PuntosInteres
 * Formulario de crear, editar y consultar puntos de interes
 */
export default {
  name: 'FormularioPuntosInteres',
  mixins: [API],
  data () {
    return {
      newPuntoInteres: '',
      radioPuntoInteres: 0,
      distanciaCarsPuntoInteres: 5,
      tipoGeocerca: 'radial',
      dataPuntoInteres: {},
      idViewSCars: null,
      loader: {
        show: false
      }
    }
  },
  components: {
    loaderSmall: () => import('@/components/loader/loader.small')
  },
  props: ['seccion', 'accion', 'dataDrawing', 'idPuntoCars'],
  created () {
    // this.showAllDrawingGeo()
    this.loader.show = true
  },
  mounted () {
    if (this.accion === 'nueva') {
      this.crearDrawing()
    }

    if (this.seccion === 'PuntoInteresCars') {
      this.idViewSCars = this.idPuntoCars
    }
    this.loader.show = false
  },
  destroyed () {
    this.cancelar()
    this.showAllDrawingGeo()
  },
  methods: {
    /**
     * @vuese
     * Oculta dibujos de puntos de interes en mapa
     */
    showAllDrawingGeo () {
      this.$emit('showAllDrawing', false)
    },
    /**
     * @vuese
     * Modifica el radio de putos de interes
     * @arg `value` radio de putos de interes
     */
    getradioPuntoInteres (value) {
      var valor = value
      if (valor == '' || valor == null) {
        valor = 1
      }

      this.radioPuntoInteres = valor
      var datos
      if (this.accion === 'editar') {
        datos = {
          tipo: this.accion,
          radio: this.radioPuntoInteres,
          id: this.dataGeofence.id
        }
      }
      if (this.accion === 'nueva') {
        datos = {
          tipo: this.tipoGeocerca,
          radio: this.radioPuntoInteres,
          id: null
        }
      }

      this.$emit('setRadioGeocerca', datos)
    },
    /**
     * @vuese
     * Manda a dibujar la punto de interes en caso de nueva
     * @arg `tipoGeo` tipo de punto de interes. 1: radial(circular), 2: poligonal
     */
    crearDrawing () {
      var data = {
        radio: this.radioPuntoInteres,
        tipo: this.tipoGeocerca,
        seccion: 'PuntoInteres'
      }

      this.$emit('DrawingGeocerca', data)
    },
    /**
     * @vuese
     * Guarda lso datos de una puntos de interes nuevo
     */
    async savePuntoInteres () {
      if (this.dataDrawing.size !== 1) {
        $('#alertasGeocercas').html(
          "<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Por favor dibuja en el mapa</div>"
        )
        setTimeout(() => {
          $('#alertasGeocercas').html('')
        }, 3000)
        return false
      }
      if (this.newPuntoInteres === '') {
        $('#alertasGeocercas').html(
          "<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Por favor ingresa nombre</div>"
        )
        setTimeout(() => {
          $('#alertasGeocercas').html('')
        }, 3000)
        return false
      }

      if (this.radioPuntoInteres < 5) {
        $('#alertasGeocercas').html(
          "<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>El radio del punto de interés no puede ser menor a 5 metros.</div>"
        )
        setTimeout(() => {
          $('#alertasGeocercas').html('')
        }, 3000)
        return false
      }

      var datos = {}
      var datosGeocerca
      var datosVertice = []
      var vertice

      datosGeocerca = {
        geofenceType: 2,
        figureType: 1,
        behavior: 3,
        name: this.newPuntoInteres,
        radio: this.radioPuntoInteres
      }
      if (this.accion === 'nueva') {
        datosGeocerca.coords = [
          { lat: this.dataPuntoInteres.lat, lng: this.dataPuntoInteres.lng }
        ]
      }
      if (this.accion === 'editar') {
        for (var i = 0; i < this.dataPuntoInteres.coords.length; i++) {
          vertice = JSON.parse(JSON.stringify(this.dataPuntoInteres.coords[i]))

          datosVertice.push({
            lat: parseFloat(vertice.lat),
            lng: parseFloat(vertice.lng)
          })
        }

        datosGeocerca.coords = datosVertice
      }

      datos['geofence'] = datosGeocerca

      var request
      if (this.accion === 'nueva') {
        request = await this.postRequest('geofences', datos)
      }
      if (this.accion === 'editar') {
        request = await this.putRequest(
          'geofences/' + this.dataPuntoInteres.id,
          datos
        )
      }

      if (request.success === true) {
        $('#alertasGeocercas').html(
          "<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha guardado el punto de interés<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>"
        )
        setTimeout(() => {
          $('#alertasGeocercas').html('')
          this.cancelar()
        }, 3000)
      } else {
        $('#alertasGeocercas').html(
          "<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se ha creado el punto de interés<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>"
        )
      }
    },
    /**
   * @vuese
   * Obtiene si se encuentran carros a una distancia dada, si si collca lso marcadores de los vehiculos
   `nota: `La distancia minima es de 5 metros
   */
    async showCarsPuntoInteres () {
      if (this.distanciaCarsPuntoInteres < 5) {
        this.distanciaCarsPuntoInteres = 5
        return 1
      }

      var devicesPuntoCars
      var datos = {
        maxDistance: this.distanciaCarsPuntoInteres
      }
      var request = await this.getRequest(
        'geofences/' + this.idViewSCars + '/devices/near',
        datos
      )
      console.debug('RESPONSE_VER_CARROS', request)

      if (request.success === true) {
        devicesPuntoCars = request.data.devices

        if (devicesPuntoCars.length > 0) {
          var devicesSelected = []
          var deviceListAll = Object.values(devicesPuntoCars)
          Object.entries(deviceListAll).forEach(([key, val]) => {
            devicesSelected.push({
              deviceID: val.id,
              deviceImei: val.imei
            })
          })

          var datos = {
            devicesSelected: devicesSelected,
            id: this.idViewSCars
          }

          this.$emit('onDevicesSelected', datos)
        } else {
          $('#alertasPuntos').html(
            "<div class='alert alert-info alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>aviso! </strong>No se encontraron carros en esa distancia</div>"
          )
          setTimeout(() => {
            $('#alertasPuntos').html('')
          }, 3000)
          notify(
            'Aviso!',
            'No se encontraron carros en esa distancia',
            'top',
            'right',
            'info',
            10,
            80
          )
        }
      } else {
        console.log('fail')
      }
    },
    /**
     * @vuese
     * Cierra o abre el panel
     */
    cancelar () {
      // manda a cerrar o abrir el panel
      this.$emit('onClose')
    }
  },
  computed: {
    /**
     * @vuese
     * Obtiene accion. puede ser: `nueva`, `editar`
     */
    getAccion () {
      return this.accion
    },
    /**
     * @vuese
     * Obtiene datos de geocerca y crea arreglos con la informacion correspondiente
     */
    getDataDrawing () {
      this.dataPuntoInteres = this.dataDrawing

      if (this.dataDrawing.size === 1) {
        // nueva con datos editados
        this.radioPuntoInteres = this.dataPuntoInteres.radio

        if (this.accion === 'editar') {
          this.newPuntoInteres = this.dataPuntoInteres.name
        }
      }

      return this.dataDrawing
    },
    /**
     * @vuese
     * Obtiene id de carros
     */
    getIDViewsCars () {
      if (this.seccion === 'PuntoInteresCars') {
        this.idViewSCars = this.idPuntoCars
      }
      return this.idViewSCars
    },
    /**
     * @vuese
     * Obtiene distacia da consultar carros
     */
    getDistanciaCars () {
      return this.distanciaCarsPuntoInteres
    }
  }
}
</script>
