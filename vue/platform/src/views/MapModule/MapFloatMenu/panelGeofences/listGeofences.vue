<template>
  <div class="container-fluid" style="margin-top:15px; margin-bottom:5px;">
    <loader-small v-if="loader.show" :message="loader.message" />
    <div class="row">
      <div class="col-8 text-left">
        <h5>Lista de geocercas</h5>
      </div>
      <div class="col-4">
        <i
          class="icon icon-small universalicon-help cursor test"
          data-toggle="tooltip"
          data-placement="bottom"
          data-delay='{"show":500, "hide":1000}'
          data-html="true"
          data-template='<div class="tooltip fluid" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
          title='<div class="alert-info text-left" style="padding:5px 10px;">
            El icono indica el tipo de geocerca:
            <br />
             <i class="icon-small icon color-light-gray universalicon-geofence"">&nbsp;</i> Geocerca Circular
            <br />
            <i class="icon-small icon color-light-gray universalicon-polygon"">&nbsp;</i> Geocerca Poligonal
            <br />
          </div>'
        >&nbsp;</i>
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
      </div>
      <div class="col-3 cssToolTipp" style="padding-left: 0px;">
        <button
          type="button"
          class="btn btn-icon btn-primary"
          @click="showNewGeofence()"
          style="height: 35px; padding-top:8px;"
        >
          <i class="feather icon-plus"></i>
        </button>
        <p style="top: 35px !important; right: 10% !important;">Nueva geocerca</p>
      </div>
      <hr style="margin: 0px; margin-bottom: 10px; width: 100%;" />
    </div>

    <!-- inicia content -->
    <div class="row" style="max-height:250px; overflow-y:auto;">
      <div class="col-12">
         <ul class="list-group list-group-flush">
          <li class="list-group-item"
          v-for="geofence in GeofenceList" :key="geofence.id">
            <div class="row">
              <div class="col-2 custom-control custom-checkbox">
                <input
                    v-if="geofence.selected"
                    type="checkbox"
                    class="custom-control-input cursor-pointer"
                    :id="`Check-${geofence.id}`"
                    @change="onGeofenceChecked($event, geofence.id)"
                    checked
                  />
                  <input
                    v-else
                    type="checkbox"
                    class="custom-control-input cursor-pointer"
                    :id="`Check-${geofence.id}`"
                    @change="onGeofenceChecked($event, geofence.id)"
                  />
                  <label class="custom-control-label" :for="`Check-${geofence.id}`"></label>

                  <span style="position:absolute">
                   <i class="icon-small icon color-light-gray cssToolTipp"
                   :class="GetGeofenceIconClass(geofence.figureType)"
                   data-toggle="tooltip"
                  data-placement="bottom"
                  data-delay="500"
                  :title="'Geocerca tipo ' + geofence.figureTypeName"></i>
                </span>
              </div>
              <div class="col-5 cursor-pointer text-left"
              style="padding: 0px 0px 0px 15px;"
              @click="onGeofenceChecked(true, geofence.id,2)">
                {{geofence.name}}
              </div>
              <div class="col-5 text-right" style="padding: 0px; padding-left: 5px;">
                <span @click="editarGeofence(geofence.id)">
                  <i class="cursor icon-small icon universalicon-pencil cssToolTipp">
                    <p style="top: 23px !important; right: 10% !important;">Editar geocerca</p>
                  </i>
                </span>
                <span @click="eliminarGeofence(geofence.id,geofence.name)">
                  <i class="cursor icon-small icon universalicon-trash-2 colorText-red cssToolTipp">
                    <p style="top: 23px !important; right: 10% !important;">Eliminar geocerca</p>
                  </i>
                </span>
              </div>
            </div>
          </li>
         </ul>
      </div>
    </div>

    <!-- termina content -->
    <!-- inicia row bottom -->
    <div class="row">
      <hr style="margin: 0px; margin-top: 10px;" />
      <div class="col-12 float-left">
        <span class="badge badge-pill badge-info">{{GeofenceList.length}}</span>
        <span>Total de geocercas</span>
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
      <div @click="onDraggableClose">
        <draggable-header class="cursor">
          <h5 style="margin-top: 5px;">{{titleContentForm}}</h5>
          <hr style="margin:0px" />
        </draggable-header>
      </div>
      <draggable-content>
        <gestion-geofence
          :geofenceID="fgeofenceID"
          :accion="faccion"
          :dataDrawing="fdataGeocerca"
          @onClose="onDraggableClose()"
          @DrawingGeocerca="DrawingGeocerca"
          @setRadiusCircle="setRadiusCircleGeo"
          @showAllDrawing="showAllDrawingGeo"
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
import gestionGeofence from '@/views/MapModule/MapFloatMenu/panelGeofences/GestionGeofence.vue'
import GeofenceDelete from '@/views/Modals/DeleteModal'
import { API } from '@/mixins/API'
import { Functions } from '@/mixins/Functions.js'
import { mapModuleDrawing } from '@/mixins/mapModuleDrawing'
import EventBus from '@/EventBus'
/**
 * @group MapModule/MapFloatMenu/Geocercas
 * Panel de geocercas
 */
export default {
  name: 'panelGeocercas',
  mixins: [API, Functions, mapModuleDrawing],
  components: {
    draggable,
    draggableHeader,
    draggableContent,
    gestionGeofence,
    GeofenceDelete,
    loaderSmall: () => import('@/components/loader/loader.small')
  },
  // 'showAllDrawing', 'createCircle', 'createPolygon', 'editSymbol', 'createDrawing', 'closeDrawing', 'setRadiusCircle', 'setVisible'
  inject: ['getMap', 'getDraggableProperties'],
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
      listGeocercas: [],
      geofenceFiltered: [],
      listGeocercasOrigin: null,
      primeraVez: true,
      accion: '',
      dataGeocerca: {},
      geofenceID: null,
      titleContentForm: '',
      loader: {
        show: false
      },
      filtro: ''
    }
  },
  created () {
    this.loader.show = true
  },
  async mounted () {
    this.map = this.getMap()

    this.map.$on('completeDrawing', this.completeDrawing)
    this.map.$on('completeDrawingPlygon', this.completeDrawingPlygon)
    this.map.$on('editDrawingCircle', this.editDrawingCircle)

    this.getlistGeofence()
    this.suscribeToGeofencesEvents()

    await this.unSelectedGeofences()
    this.loader.show = false

    this.RegisterTooltip()
  },
  beforeDestroy () {
    this.accion = ''
    this.dataGeocerca = {}
    this.geofenceID = null
    this.unsuscribreFromGeofencesEvents()
    this.showAllDrawingGeo(false)
  },
  methods: {
    RegisterTooltip () {
      jQuery(document).ready(function () {
        jQuery('[data-toggle="tooltip"]').tooltip()
      })
    },
    GetGeofenceIconClass (figureType) {
      switch (figureType) {
        case '1':
          return 'universalicon-geofence'
        case '2':
          return 'universalicon-polygon'
      }
    },
    /**
     * @vuese
     * limpia variables
     */
    limpiarVariables () {
      this.accion = ''
      this.dataGeocerca = {}
      this.geofenceID = null
      this.titleContentForm = ''
    },
    /**
     * @vuese
     * Obtiene resultados de coincidencias del string con lista de geocercas
     * @arg `searchTerm` String de filtro
     */
    filterLista (searchTerm) {
      var tipo = 'lista'

      this.listGeocercas = this.filterList(
        this.listGeocercasOrigin,
        'name',
        searchTerm,
        tipo
      )

      this.RegisterTooltip()
    },
    // TODO: evenbus
    /**
     * @vuese
     * se suscribe a eventos eventBus para:
     *  `MapModule_editDataDrawing` editar dibujo circular
     * `MapModule_editDataDrawingPolygon` editar dibujo poligonal
     * `Modal_GET_LIST_GEOFENCES` mostrar listado de geocercas
     */
    suscribeToGeofencesEvents () {
      EventBus.$on('MapModule_editDataDrawing', (payload) => {
        this.editDataDrawing(payload)
      })
      EventBus.$on('MapModule_editDataDrawingPolygon', (payload) => {
        this.editDataDrawingPolygon(payload)
      })
      EventBus.$on('Modal_GET_LIST_GEOFENCES', (payload) => {
        this.getlistGeofence()
      })
    },
    /**
     * @vuese
     * Se destruye la suscripcion al eventBus
     */
    unsuscribreFromGeofencesEvents () {
      EventBus.$off('MapModule_editDataDrawing')
      EventBus.$off('MapModule_editDataDrawingPolygon')
      EventBus.$off('Modal_GET_LIST_GEOFENCES')
    },
    getFigureTypeName (figureType) {
      switch (figureType) {
        case '1':
          return 'Circular'
        case '2':
          return 'Poligonal'
      }
    },
    /**
     * @vuese
     * Obtiene listado de geocercas
     */
    async getlistGeofence () {
      const datos = {
        geofenceType: 1
      }

      var request = await this.getRequest('geofences', datos)
      // return request.data.devices
      if (request.success === true) {
        // geocerca
        this.listGeocercas = request.data.geofences
        this.listGeocercasOrigin = request.data.geofences
        Object.entries(this.listGeocercas).forEach(([key, geofence]) => {
          geofence.selected = false
          geofence.figureTypeName = this.getFigureTypeName(geofence.figureType)
        })
      } else {
        console.log('fail')
      }

      this.RegisterTooltip()
    },
    /**
     * @vuese
     * Abre paneles secundarios segun sea el caso
     */
    showNewGeofence () {
      this.showAllDrawingGeo(false)
      this.dataGeocerca = {}
      this.accion = 'nueva'
      this.dataGeocerca.accion = this.accion
      this.titleContentForm = 'Nueva Geocerca'
      var menuFloat = this.getDraggableProperties()
      this.draggable.top = menuFloat.top + 110
      this.draggable.left = -(menuFloat.width + 10)

      this.draggable.show = true
    },
    /**
     * @vuese
     * Manda a activar el dibujo de geocerca en caso de nueva
     * @arg `payload` Datos de geocerca
     */
    DrawingGeocerca (payload) {
      console.debug('LISTGEO_ this.createDrawing(payload)', payload)
      this.createDrawing(payload)
      if (payload.tipo === 'radial') {
        this.titleContentForm = 'Nueva geocerca circular'
      }
      if (payload.tipo === 'poligonal') {
        this.titleContentForm = 'Nueva geocerca poligonal'
      }
    },
    /**
     * @vuese
     * Modifica el radio de geocerca
     * @arg `datos` radio de geocerca
     */
    setRadiusCircleGeo (datos) {
      this.setRadiusCircle(datos)
    },
    /**
     * @vuese
     * Deselecciona las geocercas
     */
    unSelectedGeofences () {
      for (var i = 0; i < this.listGeocercas.length; i++) {
        $('#Check-' + this.listGeocercas[i].id).prop('checked', false)
        this.listGeocercas[i].selected = false
        var payload = {
          id: this.listGeocercas[i].id,
          visible: false
        }
        this.setVisible(payload)
      }
      return true
    },
    /**
     * @vuese
     * Selecciona/deselecciona geocerca
     * @arg `e` Valor ingresado por checkBox
     * @arg `id` Id geocerca
     * @arg `opc` 1:valor ingresado por checkBox, 2:valor ingresado manual. Valor por defecto: 1
     */
    async onGeofenceChecked (e, id, opc = 1) {
      var checked
      if (opc == 1) {
        checked = e.target.checked
      }
      if (opc == 2) {
        checked = e
      }

      this.unSelectedGeofences()

      var geofence = this.listGeocercas.find((x) => x.id == id)
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
      }
      if (checked == false) {
        $('#Check-' + geofence.id).prop('checked', false)
      }
    },
    /**
     * @vuese
     * crea geocerca poligonal o circular, para cuando ya esta creada
     * @arg `payload` datos geocerca
     */
    consultarGeofences (payload) {
      this.showAllDrawingGeo(false)

      payload.accion = 'consultarEsp'

      if (payload.figureType == 1) {
        this.createCircle(payload)
      }
      if (payload.figureType == 2) {
        this.createPolygon(payload)
      }
    },
    /**
     * @vuese
     * muestra/oculta geocercas
     * @arg `visible` Booleano true/false
     * @arg `tipo` geocerca o punto de interes
     */
    showAllDrawingGeo (visible, tipo = null) {
      this.showAllDrawing(visible, tipo)
    },
    /**
     * @vuese
     * Obtiene datos de geocerca a editar
     * @arg `id` Id geocerca
     */
    async editarGeofence (id) {
      // tipo: 1=cicular, 2=poligonal

      this.unSelectedGeofences()

      for (var i = 0; i < this.listGeocercas.length; i++) {
        if (this.listGeocercas[i].id == id) {
          $('#Check-' + id).prop('checked', true)
          this.listGeocercas[i].selected = true
        }
      }

      var getgeocerca

      var request = await this.getRequest('geofences/' + id)

      if (request.success === true) {
        getgeocerca = request.data.geofence
      } else {
        console.log('fail')
      }

      this.editGeofence(getgeocerca)
    },
    /**
     * @vuese
     * Dibuja geocerca y manda datos a formulario de editar
     * @arg `payload` datos geocerca
     */
    editGeofence (payload) {
      this.dataGeocerca = {}
      this.titleContentForm = 'Editar Geocerca'
      this.accion = 'editar'
      this.dataGeocerca.accion = this.accion
      var menuFloat = this.getDraggableProperties()
      this.draggable.top = menuFloat.top + 110
      this.draggable.left = -(menuFloat.width + 10)
      this.draggable.show = true

      this.dataGeocerca = payload
      this.dataGeocerca.size = 1
      this.dataGeocerca.accion = this.accion

      // var geocerca = this.listGeocercas.find(x => x.id == payload.id)
      // geocerca.selected = true
      if (payload.figureType == 1) {
        this.createCircle(payload)

        this.titleContentForm = 'Editar geocerca circular'
      }
      if (payload.figureType == 2) {
        this.createPolygon(payload)
        this.dataGeocerca.tipo = 'poligonal'
        this.titleContentForm = 'Editar geocerca poligonal'
      }
      this.lockDraggable(true)
      this.editSymbol(payload.id, true)
    },
    /**
     * @vuese
     * Actualiza arreglo con los nuevos datos de la geocerca dibujada y modificada
     * @arg `payload` datos de geocerca
     */
    editDataDrawing (payload) {
      console.debug('LIST', payload)
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
      this.dataGeocerca.tipo = payload.tipo
    },
    /**
     * @vuese
     * Actualiza arreglo con los nuevos datos de la geocerca poligonal dibujada y modificada
     * @arg `payload` datos de geocerca
     */
    editDataDrawingPolygon (payload) {
      console.debug('llegada de evenbus complete', payload)
      var datosGet = this.dataGeocerca
      this.dataGeocerca = {}
      var datos = {}

      if (this.accion === 'nueva') {
        this.dataGeocerca.vertices = payload.vertices
        this.dataGeocerca.tipo = payload.tipo
        // datos = datosGet
        // this.accion = 'nueva'
        // datos.coords = payload.vertices
        // this.dataGeocerca = datos
      }
      if (this.accion === 'editar') {
        datos = datosGet
        this.accion = 'editar'
        datos.coords = payload.vertices
        this.dataGeocerca = datos
      }

      this.dataGeocerca.size = 1
      this.dataGeocerca.tipo = payload.tipo
    },
    /**
     * @vuese
     * Cierran paneles secundarios
     */
    onDraggableClose () {
      this.getlistGeofence()
      this.draggable.show = false
      this.lockDraggable(false)
      this.clearComponentsForm()
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
     * Abre el modal de confirmacion para eliminar el geocerca
     * @arg `id` Id de geocerca
     * @arg `name` nombre de geocerca
     */
    async eliminarGeofence (id, name) {
      this.$store.commit('CLEAR_MODAL_DINAMIC')

      var datos = {
        component: GeofenceDelete,
        datos: {
          tipo: 'geofence',
          GeofenceID: id,
          name: name
        }
      }
      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)
      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
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
     * Obtiene lista de geocercas
     */
    GeofenceList: function () {
      return this.listGeocercas
    },
    /**
     * @vuese
     * Obtiene id de geocerca
     */
    fgeofenceID () {
      return this.geofenceID
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
     * Obtiene datos de geocerca
     */
    fdataGeocerca () {
      return this.dataGeocerca
    }
  }
}
</script>

<style>
</style>
