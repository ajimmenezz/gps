import EventBus from '@/EventBus'

export const mapModuleDrawing = {
  data () {
    return {
      map: null
    }
  },
  mounted () {
    // this.map = this.getMap()
    // this.map.$on('completeDrawing', this.completeDrawing)
    // this.map.$on('editDrawingCircle', this.editDrawingCircle)

    // this.map.$on('completeDrawingPlygon', this.completeDrawingPlygon)
    // this.map.$on('editDrawingPolygon', this.editDrawingPolygon)
  },
  methods: {
    /* TODO: METODOS DRAWING MAPS Y SIMBOLOS */
    createDrawing (payload) {
      console.debug('MIXIN', payload)
      var color = '#77d2ff'
      var opacidad = 0.3
      var editable = true
      var tipo

      this.map.SetControlDrawingVisible(false)

      if (payload.tipo === 'radial') {
        // if (payload.seccion === 'PuntoInteres') {
        //   this.seccionDrawing = 'PuntoInteres'
        // } else {
        // this.seccionDrawing = null
        tipo = 'circle'
        this.map.DrawingMap(tipo, payload.radio)
        // }
      }
      if (payload.tipo === 'poligonal') {
        tipo = 'polygon'
        this.map.DrawingMap(tipo)
      }
      if (payload.tipo === 'marker') {
        tipo = 'marker'
        this.rutaOrigen = {}
        this.rutaDestino = {}
        this.ContRutas = 0
        this.map.DrawingMap(tipo)
      }
    },
    createCircle (payload) {
      var id = payload.id
      var lat = payload.coords[0].lat
      var lng = payload.coords[0].lng
      var radio = payload.radio

      var seccion = null
      // this.seccionDrawing = null
      if (payload.seccion === 'PuntoInteres') {
        seccion = 'PuntoInteresEdit'
      }
      if (payload.seccion === 'PuntoInteres_new') {
        seccion = 'PuntoInteres_new'
      }

      this.map.createCircle(id, lat, lng, radio, seccion)

      /* NOTE:
       Si queremos obtener el bounds de muchos circulos usar getCirclesBounds( arrID )
       donde arrID es un arreglo con los id´s de los circulos
       */
      var bounds = this.map.getCircleBounds(id)
      this.map.centerMapToBounds(bounds)
    },
    setRadiusCircle (payload) {
      if (payload.tipo === 'editar') {
        this.map.setRadius(payload.radio, payload.id)
      } else {
        this.map.setRadius(payload.radio)
      }
    },
    editSymbol (id, isedit) {
      this.map.setEditDrawing(id, isedit)
    },
    completeDrawing (data) {
      console.debug('completeDrawingrecive-emit', data)
      this.map.deshabilitarDrawingMode()
      this.editDrawingCircle(data)
    },
    editDrawingCircle (data) {
      var dataCircle = {
        'lat': data.lat,
        'lng': data.lng,
        'radio': Math.round(data.radio),
        'tipo': 'radial'
      }

      // eventBus o
      EventBus.$emit('MapModule_editDataDrawing', dataCircle)
      // this.$refs.menu.editDataDrawing(dataCircle)
    },

    completeDrawingPlygon (data) {
      console.debug('completeDrawingPlygonrecive-emit', data)
      this.map.deshabilitarDrawingMode()
      this.editDrawingPolygon(data)
    },
    editDrawingPolygon (data) {
      console.debug('edit_mixin-event', data)
      this.map.deshabilitarDrawingMode()
      data.tipo = 'poligonal'

      EventBus.$emit('MapModule_editDataDrawingPolygon', data)
      // this.$refs.menu.editDataDrawingPolygon(data)
    },
    createPolygon (payload) {
      var id = payload.id

      var positions = []
      for (var i = 0; i < payload.coords.length; i++) {
        var datosVertice = JSON.parse(JSON.stringify(payload.coords[i]))

        positions.push({ 'lat': parseFloat(datosVertice.lat), 'lng': parseFloat(datosVertice.lng) })
      }

      this.map.createpolygon(id, positions)

      var bounds = this.map.getPolygonBounds(id)
      this.map.centerMapToBounds(bounds)
    },
    setVisible (payload) {
      this.map.isVisibleDrawing(payload.id, payload.visible)
    },
    showAllDrawing (visible, tipo) {
      this.map.deshabilitarDrawingMode()
      if (tipo !== null) {
        this.map.showAllPolyline(visible)
      } else {
        this.map.showAllDrawing(visible)
      }
    },
    closeDrawing (payload) {
      this.map.deshabilitarDrawingMode()
      if (payload !== null) {
        this.map.deleteDrawing(payload)
      } else {
        this.map.deleteDrawing()
      }
    },
    onDevicesSelected_POI (payload) {
      console.debug('MAP_onDevicesSelected_POI', payload)
      this.map.closeAllMarkerInfoWindow()
      this.map.showAllMarkers(false)

      this.$store.commit('devices/SELECT_DEVICE', null)
      this.$store.state.devices.devicesLocateSELECT = null

      if (payload.length >= 1) {
        console.debug('MARKERS_LISIT')
        var markersSelected = []
        payload.forEach(marker => {
          markersSelected.push(marker.deviceImei)
          this.map.setMarkerVisible(marker.deviceImei, true)
        })

        var bounds = this.map.getMarkersBounds(markersSelected)
        this.map.centerMapToBounds(bounds)
      } else {
        console.debug('TODOS_MAKER')
        this.map.showAllMarkers(true)
      }

      // ReDibujar - Recrear clusters (limpiar cluster y agregar solo los marcadores establecidos en visible true)
    }
  }
}
