
    /* TODO: METODOS DE POLYGON */

    registerListenerPolygon (polygon, id) {
      polygon.addListener('mouseup', this.mouseup.bind(this, id))
    },

    mouseup (id) {
      var polygon = this.listDrawing.get(id)

      var path = polygon.getPath()
      var paths = polygon.getPaths()

      var vertices = []
      for (var i = 0; i < path.getLength(); i++) {
        var xy = path.getAt(i)
        vertices[i] = { 'lat': xy.lat(), 'lng': xy.lng() }
      }

      var data = {
        'path': path,
        'paths': paths,
        'vertices': vertices
      }

      this.$emit('editDrawingPolygon', data)
    },

    createpolygon (id, positions, color = '#77d2ff', opacidad = 0.3, border = 1) {
      var polygon = new google.maps.Polygon({
        paths: positions,
        strokeColor: '#656565',
        strokeWeight: border,
        fillColor: color,
        fillOpacity: opacidad,
        map: this.map
      })
      // agrega eventos
      this.registerListenerPolygon(polygon, id)
      this.listDrawing.set(id, polygon)
    },

    getPolygon (id) {
      var polygon = this.listDrawing.get(id)

      var path = polygon.getPath()
      var paths = polygon.getPaths()

      var vertices = []

      for (var i = 0; i < path.getLength(); i++) {
        var xy = path.getAt(i)
        vertices[i] = { 'lat': xy.lat(), 'lng': xy.lng() }
      }

      var data = {
        'path': path,
        'paths': paths,
        'vertices': vertices
      }
    },

    registerListenerDrawing () {
      this.drawingManager.addListener('circlecomplete', this.drawingCircleComplete)
      this.drawingManager.addListener('polygoncomplete', this.drawingPolygonComplete)
      this.drawingManager.addListener('markercomplete', this.drawingRutasComplete)
    },

    deshabilitarDrawingMode () {
      this.drawingManager.setDrawingMode(null)
    },

drawingPolygonComplete (polygon) {
      var id = 'temp_simbol'//  this.listDrawing.size

      this.listDrawing.set(id, polygon)

      // agrega eventos
      this.registerListenerPolygon(polygon, id)

      var path = polygon.getPath()
      var paths = polygon.getPaths()

      var vertices = []
      for (var i = 0; i < path.getLength(); i++) {
        var xy = path.getAt(i)
        vertices[i] = { 'lat': xy.lat(), 'lng': xy.lng() }
      }

      var data = {
        'path': path,
        'paths': paths,
        'vertices': vertices
      }
      console.debug('POLYGONO_CPMLETO', data)
      this.$emit('pruebaPolygono', 1)

      this.$emit('completeDrawingPlygon', data)
    },

    DrawingMap (tipo, radio = null, contRuta = null, color = '#77d2ff', opacidad = 0.3, editable = false, border = 1) {
      this.deleteDrawing()
      this.seccionPunto = null
      this.contRuta = contRuta

      this.radio = radio
      var drawingManagerOptions
      if (tipo === 'circle') {
        drawingManagerOptions = {
          drawingMode: tipo,
          circleOptions: {
            fillColor: color,
            fillOpacity: opacidad,
            strokeWeight: border,
            zIndex: 1,
            strokeColor: '#656565',
            clickable: true,
            draggable: true,
            editable: true
          }
        }
      }
      if (tipo === 'polygon') {
        drawingManagerOptions = {
          drawingMode: tipo,
          polygonOptions: {
            fillColor: color,
            fillOpacity: opacidad,
            strokeWeight: border,
            zIndex: 1,
            strokeColor: '#656565',
            clickable: true,
            draggable: true,
            editable: true

          }
        }
      }
      if (tipo === 'marker') {
        drawingManagerOptions = {
          drawingMode: tipo
          // markerOptions: { icon: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png' } // { icon: '@/img/map/markers/rutas.png' }
        }
      }

      this.drawingManager.setOptions(drawingManagerOptions)
      this.drawingManager.setMap(this.map)

      console.debug('googlemaps', drawingManagerOptions)
    },
        initDrawing () {
      this.drawingManager = new google.maps.drawing.DrawingManager()

      this.registerListenerDrawing()
    }
