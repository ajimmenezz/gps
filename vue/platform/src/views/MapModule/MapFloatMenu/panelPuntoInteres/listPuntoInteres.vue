<template>
  <div class="container-fluid" style="margin-top:15px; margin-bottom:5px;">
    <loader-small v-if="loader.show" :message="loader.message" />
    <div class="row">
      <div class="col-12 text-left">
        <h5>Lista puntos de interés</h5>
      </div>
      <div class="col-9">
        <config-input
          id="deviceSearcher"
          label="null"
          required="false"
          typeinput="text"
          placeholder="Buscar"
          @input="filterLista"
          paddingConf="6px 12px"
        ></config-input>
        <!-- @input="filterLista" :valor="filtro" -->
      </div>
      <div class="col-3 cssToolTipp" style="padding-left: 0px;">
        <p style="top: 35px !important; right: 10% !important;">Nuevo punto de interés</p>
        <button
          type="button"
          class="btn btn-icon btn-primary"
          @click="showNewPuntoInteres()"
          style="height: 35px; padding-top:8px;"
        >
          <i class="feather icon-plus"></i>
        </button>
      </div>
      <hr style="margin: 0px; margin-bottom: 10px; width: 100%;" />
    </div>

    <!-- inicia content -->
    <div class="row" style="max-height:265px; overflow-y:auto;">
      <div v-if="fPuntosIList.length!=0"
      class="col-12"
      style="margin-bottom:50px;">
        <ul class="list-group list-group-flush">
            <li v-for="puntos in fPuntosIList"
            :key="puntos.id"
            class="list-group-item">
              <div class="row">
              <div class="col-2 custom-control custom-checkbox">
                <input
                  v-if="puntos.selected"
                  type="checkbox"
                  class="custom-control-input"
                  :id="`Check-${puntos.id}`"
                  @change="onGeofenceChecked($event,puntos.id)"
                  checked
                />
                <input
                  v-else
                  type="checkbox"
                  class="custom-control-input"
                  :id="`Check-${puntos.id}`"
                  @change="onGeofenceChecked($event,puntos.id)"
                />

                <label class="custom-control-label" :for="`Check-${puntos.id}`"></label>
              </div>
              <div
                class="col-5 float-left"
                style="padding:0px;"
                @click="onGeofenceChecked(true,puntos.id,2)"
              >{{puntos.name}}
              </div>
              <div class="col-5" style="padding: 0px; padding-left: 5px;">
                <span @click="editarPuntoInteres(puntos.id)">
                  <i class="cursor icon-small icon universalicon-pencil cssToolTipp">
                    <p style="top: 23px !important; right: -40% !important;">Editar punto de interés</p>
                  </i>
                </span>
                <span @click="verCarPuntoInteres(puntos.id)">
                  <i class="cursor icon-small icon universalicon-car cssToolTipp">
                    <p
                      style="top: 23px !important; right: -40% !important;"
                    >Dispositivos cerca</p>
                  </i>
                </span>
                <span @click="eliminarPuntoInteres(puntos.id,puntos.name)">
                  <i class="cursor icon-small icon universalicon-trash-2 colorText-red cssToolTipp">
                    <p
                      style="top: 23px !important; right: -40% !important;"
                    >Eliminar punto de interés</p>
                  </i>
                </span>
              </div>
            </div>
            </li>
          </ul>

      </div>
      <div class="col-12 text-center" v-else>
        No tiene puntos creados
      </div>
    </div>
    <!-- termina content -->
    <!-- inicia row bottom -->
    <div class="row">
      <hr style="margin: 0px; margin-top: 10px;" />
      <div class="col-12 float-left">
        <span class="badge badge-pill badge-info">{{fPuntosIList.length}}</span>
        <span>Total de puntos de interés</span>
      </div>
    </div>
    <!-- termina row bottom -->

    <draggable
      name="test"
      :top="draggable.top"
      :left="draggable.left"
      :width="draggable.width"
      :height="draggable.height"
      :zindex="draggable.index"
      v-if="draggable.show"
    >
      <!-- class="draggable--draggable" -->
      <div class="draggable--draggable">
        <draggable-header class="cursor-move">
          <h5 style="margin-top: 5px;">{{titleContentForm}}</h5>
          <hr style="margin:0px" />
        </draggable-header>
      </div>
      <draggable-content>
        <gestion-puntos-i
          :seccion="fseccion"
          :accion="faccion"
          :dataDrawing="fdataGeocerca"
          :idPuntoCars="fidPuntoCars"
          @onClose="onDraggableClose()"
          @DrawingGeocerca="DrawingGeocerca"
          @setRadiusCircle="setRadiusCircleGeo"
          @showAllDrawing="showAllDrawingGeo"
          @onDevicesSelected="onDevicesSelectedPoi"
        />
      </draggable-content>
    </draggable>
  </div>
</template>

<script>
import {
  draggable,
  draggableHeader,
  draggableContent
} from '@/components/draggable/'
import gestionPuntosI from '@/views/MapModule/MapFloatMenu/panelPuntoInteres/GestionPuntosInteres.vue'
import GeofenceDelete from '@/views/Modals/DeleteModal'
import { API } from '@/mixins/API'
import { Functions } from '@/mixins/Functions.js'
import { mapModuleDrawing } from '@/mixins/mapModuleDrawing'
import EventBus from '@/EventBus'
/**
 * @group MapModule/MapFloatMenu/PuntosInteres
 * Panel de punto de interes
 */
export default {
  name: 'panelPuntosInteres',
  mixins: [API, Functions, mapModuleDrawing],
  components: {
    draggable,
    draggableHeader,
    draggableContent,
    gestionPuntosI,
    GeofenceDelete,
    loaderSmall: () => import('@/components/loader/loader.small')
  },
  //, 'showAllDrawing', 'createCircle', 'editSymbol', 'createDrawing', 'closeDrawing', 'setRadiusCircle', 'setVisible', 'editDrawingCircle', 'onDevicesSelected'
  inject: ['getMap', 'getDraggableProperties', 'closeDeviceInfo'],
  data () {
    return {
      draggable: {
        name: 'test',
        top: 0,
        left: 0,
        width: 300,
        height: 300,
        index: 100,
        show: false
      },
      position: null,
      primeraVez: true,
      accion: '',
      titleContentForm: '',
      puntosList: [],
      puntosListOrigin: [],
      puntoInteresFiltered: [],
      idPuntoCars: null,
      isCarsPuntoInteres: null,
      seccion: '',
      dataGeocerca: {},
      map: null,
      puntoInteresID: null,
      idPuntoInteres: null,
      seccionDrawing: null,
      loader: {
        show: false
      }
    }
  },
  created () {
    this.loader.show = true
  },
  async mounted () {
    this.map = this.getMap()
    this.suscribeToMapEvents()

    this.getlistGeofence()
    this.suscribeToGeofencesEvents()

    await this.unSelectedPuntos()
    this.loader.show = false
  },
  beforeDestroy () {
    this.accion = ''
    this.dataGeocerca = {}
    this.unsuscribreFromGeofencesEvents()
    this.showAllDrawingGeo(false)
  },
  methods: {
    suscribeToMapEvents () {
      this.map.$on('onMapClick', this.onMapClickCreatePunto)

      this.map.$on('completeDrawing', this.completeDrawing)
      this.map.$on('editDrawingCircle', this.editDrawingCircle)

      this.map.$on('completeDrawingPlygon', this.completeDrawingPlygon)
      this.map.$on('editDrawingPolygon', this.editDrawingPolygon)

      this.map.$on('closeAllMarkerInfoWindow', this.closeAllInfo)

      this.map.$on('showAllMarkers', this.closeAllMarker)
    },
    /**
     * @vuese
     * limpia variables
     */
    limpiarVariables () {
      this.idPuntoCars = null
      this.isCarsPuntoInteres = null
      this.seccion = ''
      this.dataGeocerca = {}
      this.puntoInteresID = null
      this.idPuntoInteres = null
      this.seccionDrawing = null

      this.accion = ''
      this.titleContentForm = ''
      this.puntosList = []
      this.puntosListOrigin = []
      this.puntoInteresFiltered = []
    },
    /**
     * @vuese
     * Obtiene resultados de coincidencias del string con lista de puntos de interes
     * @arg `searchTerm` String de filtro
     */
    filterLista (searchTerm) {
      var tipo = 'lista'
      this.puntosList = this.filterList(
        this.puntosListOrigin,
        'name',
        searchTerm,
        tipo
      )
    },
    // TODO: evenbus
    /**
     * @vuese
     * se suscribe a eventos eventBus para:
     *  `Modal_GET_LIST_GEOFENCES` obtiene lista de puntos de interes
     * `MapModule_editDataDrawing` editar dibujo poligonal
     */
    suscribeToGeofencesEvents () {
      EventBus.$on('Modal_GET_LIST_GEOFENCES', payload => {
        this.getlistGeofence()
      })
      EventBus.$on('MapModule_editDataDrawing', payload => {
        this.editDataDrawing(payload)
      })
    },
    /**
     * @vuese
     * Se destruye la suscripcion al eventBus
     */
    unsuscribreFromGeofencesEvents () {
      EventBus.$off('Modal_GET_LIST_GEOFENCES')
      EventBus.$off('MapModule_editDataDrawing')
    },
    /**
     * @vuese
     * Obtiene listado de puntos de interes
     */
    async getlistGeofence () {
      const datos = {
        geofenceType: 2
      }

      var request = await this.getRequest('geofences', datos)
      // return request.data.devices
      if (request.success === true) {
        // geocerca

        this.puntosList = request.data.geofences

        this.puntosListOrigin = request.data.geofences
        Object.entries(this.puntosList).forEach(([key, val]) => {
          val.selected = false
        })
      } else {
        console.log('fail')
      }
    },
    /**
     * @vuese
     * Abre paneles secundarios segun sea el caso
     */
    showNewPuntoInteres () {
      this.showAllDrawingGeo(false)
      this.titleContentForm = 'Nuevo punto de interés'
      this.seccion = 'PuntoInteres'
      this.dataGeocerca.seccion = this.seccion
      this.accion = 'nueva'
      this.dataGeocerca.accion = this.accion
      var menuFloat = this.getDraggableProperties()
      this.draggable.top = menuFloat.top + 110
      this.draggable.left = -(menuFloat.width + 10)
      this.draggable.show = true
      this.lockDraggable(true)
    },
    /**
     * @vuese
     * Manda a activar el dibujo de puntos de interes en caso de nueva
     * @arg `payload` Datos de puntos de interes
     */
    DrawingGeocerca (payload) {
      // this.createDrawing(payload)
      this.seccionDrawing = 'PuntoInteres'
    },
    /**
     * @vuese
     * Manda a dibujar puntos de interes en caso de nueva, cuando da click en mapa
     * @arg `position` latitud y longitud de donde se pintara el punto de interes
     */
    onMapClickCreatePunto (position) {
      if (this.seccionDrawing != null) {
        if (this.seccionDrawing == 'PuntoInteres') {
          var radio = 50
          var id = 'temp_simbol'
          var seccion = 'PuntoInteres_new'

          // this.$refs.map.createCircle(id, position.lat, position.lng, radio, seccion)
          var payload = {
            id: id,
            radio: radio,
            seccion: seccion,
            coords: [{ lat: position.lat, lng: position.lng }]
          }

          this.createCircle(payload)
          this.editSymbol(id, true)

          var data = {
            lat: position.lat,
            lng: position.lng,
            radio: 50
          }
          this.editDrawingCircle(data)
          this.seccionDrawing = null
        }
      }
    },
    /**
     * @vuese
     * Modifica el radio de putos de interes
     * @arg `datos` radio de putos de interes
     */
    setRadiusCircleGeo (datos) {
      this.setRadiusCircle(datos)
    },
    /**
     * @vuese
     * Deselecciona los puntos de interes
     */
    unSelectedPuntos () {
      for (var i = 0; i < this.puntosList.length; i++) {
        $('#Check-' + this.puntosList[i].id).prop('checked', false)
        this.puntosList[i].selected = false
        var payload = {
          id: this.puntosList[i].id,
          visible: false
        }

        this.setVisible(payload)
      }
    },
    /**
     * @vuese
     * Selecciona/deselecciona punto de interes
     * @arg `e` Valor ingresado por checkBox
     * @arg `id` Id punto de interes
     * @arg `opc` 1:valor ingresado por checkBox, 2:valor ingresado manual. Valor por defecto: 1
     */
    async onGeofenceChecked (e, id, opc = 1) {
      var checked
      if (opc == 1) { checked = e.target.checked }
      if (opc == 2) { checked = e }

      this.unSelectedPuntos()

      var geofence = this.puntosList.find(x => x.id == id)
      geofence.selected = checked

      if (checked == true) {
        $('#Check-' + geofence.id).prop('checked', true)
        var getgeocerca

        var request = await this.getRequest('geofences/' + geofence.id)

        if (request.success === true) {
          getgeocerca = request.data.geofence
        } else {
          console.log('fail')
        }

        this.consultarGeofences(getgeocerca)
        // this.$emit('onGeofencesSelected', getgeocerca)
      }
      if (checked == false) {
        $('#Check-' + geofence.id).prop('checked', false)
      }
    },
    /**
     * @vuese
     * crea punto de interes, para cuando ya esta creada
     * @arg `payload` datos punto de interes
     */
    consultarGeofences (payload) {
      this.showAllDrawingGeo(false)

      payload.accion = 'consultarEsp'

      if (payload.figureType == 1) {
        this.createCircle(payload)
      }
    },
    /**
     * @vuese
     * muestra/oculta punto de interes
     * @arg `visible` Booleano true/false
     * @arg `tipo` geocerca o punto de interes
     */
    showAllDrawingGeo (visible, tipo = null) {
      this.showAllDrawing(visible, tipo)
    },
    /**
     * @vuese
     * Obtiene datos de punto de interes a editar
     * @arg `PuntoInteresID` Id de punto de interes
     */
    async editarPuntoInteres (PuntoInteresID) {
      this.unSelectedPuntos()

      for (var i = 0; i < this.puntosList.length; i++) {
        if (this.puntosList[i].id == PuntoInteresID) {
          $('#Check-' + PuntoInteresID).prop('checked', true)
          this.puntosList[i].selected = true
        }
      }

      var getgeocerca

      var request = await this.getRequest('geofences/' + PuntoInteresID)

      if (request.success === true) {
        getgeocerca = request.data.geofence
      } else {
        console.log('fail')
      }

      // this.$emit('editarPuntoInteres', getgeocerca)
      this.editPuntoInteres(getgeocerca)
    },
    /**
     * @vuese
     * Dibuja punto de interes y manda datos a formulario de editar
     * @arg `payload` datos punto de interes
     */
    editPuntoInteres (payload) {
      this.puntoInteresID = payload.id
      this.dataGeocerca = {}
      this.titleContentForm = 'Editar punto de interés'
      this.seccion = 'PuntoInteres'
      this.accion = 'editar'
      this.idPuntoInteres = payload.id

      var menuFloat = this.getDraggableProperties()
      this.draggable.top = menuFloat.top + 110
      this.draggable.left = -(menuFloat.width + 10)
      this.draggable.show = true

      this.dataGeocerca = payload
      this.dataGeocerca.size = 1
      this.dataGeocerca.accion = this.accion
      this.dataGeocerca.seccion = this.seccion

      if (payload.figureType == 1) {
        this.createCircle(payload)
      }
      this.lockDraggable(true)
      this.editSymbol(payload.id, true)
    },
    /**
     * @vuese
     * Actualiza arreglo con los nuevos datos de la punto de interes dibujada y modificada
     * @arg `payload` datos de punto de interes
     */
    editDataDrawing (payload) {
      var datosGet = this.dataGeocerca
      this.dataGeocerca = {}

      if (this.accion === 'nueva') {
        this.dataGeocerca = payload
      }
      if (this.accion === 'editar') {
        this.dataGeocerca = datosGet
        this.dataGeocerca.coords[0].lat = payload.lat
        this.dataGeocerca.coords[0].lng = payload.lng
        this.dataGeocerca.radio = payload.radio
      }
      this.dataGeocerca.seccion = this.seccion
      this.dataGeocerca.size = 1
    },
    /**
     * @vuese
     * guarda id de punto y manda a mostrar panel
     * @arg `id` id de punto de interes
     */
    verCarPuntoInteres (id) {
      this.idPuntoCars = id
      this.onGeofenceChecked(true, id, 2)
      this.onDevicesSelected_POI([])
      this.verCarrosPuntoInteres(id)
    },
    /**
     * @vuese
     * Manda datos a formulario de editar
     * @arg `payload` datos de punto de interes
     */
    verCarrosPuntoInteres (payload) {
      // this.clearComponentsForm()
      this.titleContentForm = 'Ver vehículos'
      this.seccion = 'PuntoInteresCars'
      this.idPuntoInteres = payload
      this.dataGeocerca.seccion = this.seccion

      var menuFloat = this.getDraggableProperties()
      this.draggable.top = menuFloat.top + 110
      this.draggable.left = -(menuFloat.width + 10)
      this.draggable.show = true
      this.lockDraggable(true)
    },
    /**
     * @vuese
     * muestra marcadores cerca de punto de interes
     * @arg `payload` datos de punto
     */
    onDevicesSelectedPoi (payload) {
      payload.seccionPi = true
      console.debug('onDevicesSelectedPoi', payload)
      this.onDevicesSelected(payload)
      this.draggable.show = false
      this.lockDraggable(false)
    },
    /**
     * @vuese
     * recibe dispositivos seleccionado y muestra marcadores segun sea le caso
     * @arg `payload` Arreglo de dispositivos
     */
    async onDevicesSelected (payload) {
      console.debug('MAP_onDevicesSelected_PI', payload)

      await this.onGeofenceChecked(true, payload.id, 2)
      this.closeDeviceInfo()
      this.onDevicesSelected_POI(payload.devicesSelected)
    },
    /**
     * @vuese
     * Abre el modal de confirmacion para eliminar el punto de interes
     * @arg `id` Id de punto de interes
     * @arg `name` nombre de punto de interes
     */
    async eliminarPuntoInteres (puntoInteresID, name) {
      this.$store.commit('CLEAR_MODAL_DINAMIC')

      var datos = {
        component: GeofenceDelete,
        datos: {
          tipo: 'puntoInteres',
          puntoInteresID: puntoInteresID,
          name: name
        }
      }
      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)
      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
    },
    /**
     * @vuese
     * Cierran paneles secundarios
     */
    onDraggableClose () {
      console.debug('onDraggableClose')
      this.getlistGeofence()
      this.draggable.show = false
      this.lockDraggable(false)
      this.clearComponentsForm()
      this.unSelectedPuntos()
    },
    /**
     * @vuese
     * Bloquea/Desbloquea paneles secundarios
     * @arg `lock` booleano indicativo
     */
    lockDraggable (lock) {
      this.$emit('lockDraggable', lock)
    },
    /**
     * @vuese
     * Limpiar paneles y variables de paneles
     */
    clearComponentsForm () {
      var idDelete
      if (this.accion === 'editar') {
        idDelete = this.dataGeocerca.id
      }
      if (this.accion === 'nueva') {
        idDelete = null
      }

      this.accion = ''
      this.dataGeocerca = {}

      this.closeDrawing(idDelete)
    }
  },
  computed: {
    /**
     * @vuese
     * Obtiene lista de puntos de interes
     */
    fPuntosIList: function () {
      return this.puntosList
    },
    /**
     * @vuese
     * Obtiene accion. puede ser: `nueva`, `editar`
     */
    faccion () {
      return this.accion
    },
    /**
     * @vuese
     * Obtiene seccion. puede ser: `puntoInteres`, `puntoInteresCarros`
     */
    fseccion () {
      return this.seccion
    },
    /**
     * @vuese
     * Obtiene id de carros
     */
    fidPuntoCars () {
      return this.idPuntoCars
    },
    /**
     * @vuese
     * Obtiene datos de punto de interes
     */
    fdataGeocerca () {
      return this.dataGeocerca
    }
  }
}
</script>

<style>
</style>
