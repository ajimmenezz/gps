<template>
    <div class="google-maps" :id="mapName" v-bind:style="{position:'absolute', minHeight: height +'px', width: width +'px', top:top+'px', left:left+'px'}">
    </div>
</template>

<script>
/**
* @vuese
 * @group components/google
 * componente google maps
 */
export default {
  name: 'google-maps',
  props: {
    // nombre
    name: {
      type: String,
      required: true
    },
    // latitud
    lat: {
      type: Number,
      default: 0
    },
    // longitud
    lng: {
      type: Number,
      default: 0
    },
    // zoom mapa
    zoom: {
      type: Number,
      default: 5
    },
    // alto de mapa
    height: {
      type: Number,
      default: 600
    },
    // ancho de mapa
    width: {
      type: Number,
      default: 600
    },
    // top
    top: {
      type: Number,
      default: 0
    },
    // derecha
    left: {
      type: Number,
      default: 0
    },
    // panel de zoom de mapa
    zoomControl: {
      type: Boolean,
      default: false
    },
    // panel de stree view
    streetViewControl: {
      type: Boolean,
      default: false
    },
    // panel de pantalla completa
    fullScreenControl: {
      type: Boolean,
      default: false
    },
    // panel de rotacion
    rotateControl: {
      type: Boolean,
      default: false
    },
    // control de escala
    scaleControl: {
      type: Boolean,
      default: false
    },
    // tipo de mapa
    mapTypeControl: {
      type: Boolean,
      default: false
    },
    // panel de trafico de mapa
    trafficControl: {
      type: Boolean,
      default: false
    },
    // clusters
    clusters: {
      type: Boolean,
      default: false
    },
    // maximo zoom de clusters
    clustersMaxZoom: {
      type: Number,
      default: 15
    },
    // control de zoom en clusters
    clustersZoomOnClick: {
      type: Boolean,
      default: true
    },
    // seguir dispositivo
    followDevice: {
      type: String,
      default: null
    }
  },
  data: function () {
    return {
      mapName: this.name + '-map',
      map: null,
      markers: new Map(), // NOTE: Map Object not GoogleMaps object
      markerSize: 36,
      labelMaxCharters: 6,
      trafficLayer: new google.maps.TrafficLayer(),
      mapZoom: this.zoom,
      mapLat: this.lat,
      mapLng: this.lng,
      mapStyles: new Map(),
      clusterManager: null,
      drawingManager: null,
      listDrawing: new Map(),
      radio: null,
      directionsService: null,
      directionsDisplay: null,
      polylines: new Map(),
      contRuta: 0,
      seccionPunto: null
    }
  },
  beforeCreate: function () {
    SlidingMarker.initializeGlobally()
  },
  mounted: function () {
    // Intialize the map
    this.initializeMap()
  },
  watch: {
    /**
   * @vuese
   * panel de zoom
   */
    zoomControl: function (enabled) {
      this.map.setOptions({ zoomControl: enabled })
    },
    /**
   * @vuese
   * panel de street view
   */
    streetViewControl: function (enabled) {
      this.map.setOptions({ streetViewControl: enabled })
    },
    /**
   * @vuese
   * panel de pantalla completa
   */
    fullScreenControl: function (enabled) {
      this.map.setOptions({ fullscreenControl: enabled })
    },
    /**
   * @vuese
   * panel de rotacion
   */
    rotateControl: function (enabled) {
      this.map.setOptions({ rotateControl: enabled })
    },
    /**
   * @vuese
   * panel de escala
   */
    scaleControl: function (enabled) {
      this.map.setOptions({ scaleControl: enabled })
    },
    /**
   * @vuese
   * tipo de mapa
   */
    mapTypeControl: function (enabled) {
      this.map.setOptions({ mapTypeControl: enabled })
    },
    /**
   * @vuese
   * panel de trafico
   */
    trafficControl: function (visible) {
      console.debug('TRAFFIC', visible)

      if (visible) {
        this.trafficLayer.setMap(this.map)
      } else {
        this.trafficLayer.setMap(null)
      }
    },
    /**
   * @vuese
   * mostrar cluster
   */
    clusters: function (enable) {
      // console.debug('Use Clusters', enable)
      if (enable === true) {
        this.clusterManager.setMap(this.map)
        this.addAllMarkersToCluster()
      } else {
        this.clusterManager.clearMarkers()
        this.redrawCluster()

        var markersArr = Array.from(this.markers.values())
        markersArr.forEach(marker => {
          marker.setMap(this.map)
        })
      }
    },
    /**
   * @vuese
   * zoom maximo de cluster
   */
    clustersMaxZoom: function (value) {
      this.clusterManager.setMaxZoom(value)
    },
    /**
   * @vuese
   * control de zoom de cluster
   */
    clustersZoomOnClick: function (enabled) {

    }
  },
  methods: {
    /**
   * @vuese
   * Obtiene puntos de poligono
   */
    extendsPolygonBounds () {
      google.maps.Polygon.prototype.getBounds = function () {
        var bounds = new google.maps.LatLngBounds()
        var paths = this.getPaths()
        var path
        for (var i = 0; i < paths.getLength(); i++) {
          path = paths.getAt(i)
          for (var ii = 0; ii < path.getLength(); ii++) {
            bounds.extend(path.getAt(ii))
          }
        }
        return bounds
      }
    },
    /**
   * @vuese
   * Obtiene puntos de polilinea
   */
    extendsPolylineBounds () {
      google.maps.Polyline.prototype.getBounds = function () {
        var bounds = new google.maps.LatLngBounds()
        this.getPath().forEach(function (item, index) {
          bounds.extend(new google.maps.LatLng(item.lat(), item.lng()))
        })
        return bounds
      }
    },
    haversine: function (xPosition, yPosition, earthMeanRadius = 6371) {
      var deltaLatitude = this.deg2rad(yPosition.lat - xPosition.lat)
      var deltaLongitude = this.deg2rad(yPosition.lng - xPosition.lng)

      var a = Math.sin(deltaLatitude / 2) * Math.sin(deltaLatitude / 2) +
            Math.cos(this.deg2rad(xPosition.lat)) * Math.cos(this.deg2rad(yPosition.lat)) *
            Math.sin(deltaLongitude / 2) * Math.sin(deltaLongitude / 2)

      var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a))

      var result = earthMeanRadius * c // En km

      return Math.round(result / 0.001, 2)
    },
    deg2rad: function (degrees) {
      var pi = Math.PI
      return degrees * (pi / 180)
    },
    /** MAP METHODS
     * Metodos para la manipulacion del mapa
     */
    /**
   * @vuese
   * Inicializa librerias y mapa que ocupara
   */
    initializeMap: function () {
      const el = document.getElementById(this.mapName)
      el.style.minHeight = this.height + 'px'

      const options = {
        center: new google.maps.LatLng(this.lat, this.lng),
        zoom: this.zoom,
        minZoom: 2,
        maxZoom: 21,
        zoomControl: this.zoomControl,
        mapTypeControl: this.mapTypeControl,
        scaleControl: this.scaleControl,
        streetViewControl: this.streetViewControl,
        rotateControl: this.rotateControl,
        fullscreenControl: this.fullScreenControl
      }

      this.map = new google.maps.Map(el, options)
      this.bounds = new google.maps.LatLngBounds()

      // Add Listeners
      this.map.addListener('zoom_changed', this.onMapZoomChanged)
      this.map.addListener('click', this.onMapClick)

      this.initializeClusterManager()
      this.initDrawing()
      this.initDirections()
      this.extendsPolygonBounds()
      this.extendsPolylineBounds()

      this.$emit('onMapReady')
    },
    /**
   * @vuese
   * Funcion que centra el mapa en una posicion dada
   * @arg `lat` latitud
   * @arg `lng` longitud
   * @arg `zoom` zoom del mapa
   */
    centerMap: function (lat, lng, zoom = null) {
      try {
        var newLat = parseFloat(lat)
        var newLng = parseFloat(lng)

        if (newLat !== this.mapLat || newLng !== this.mapLng) {
          this.mapLat = newLat
          this.mapLng = newLng
          var position = { lat: this.mapLat, lng: this.mapLng }

          this.map.panTo(position)
        }

        console.debug(`google-map/ CenterMap ${this.mapLat},${this.mapLng}`)

        if (zoom != null) {
          this.setZoom(zoom)
        }
      } catch (err) {}
    },
    /**
   * @vuese
   * Funcion que centra el mapa en una posicion dada de puntos
   * @arg `bounds` puntos a centrar en el mapa
   */
    centerMapToBounds: function (bounds) {
      this.map.fitBounds(bounds)
    },
    /**
   * @vuese
   * Funcion que establece zoom de mapa
   * @arg `zoom` zoom de mapa
   */
    setZoom (zoom) {
      this.mapZoom = zoom
      this.map.setZoom(zoom)
    },
    /** Muestra u oculta los puntos de interes
     * parametro feature puede ser alguno de las siguientes cadenas
     * poi.attraction        selecciona atracciones turísticas.
     * poi.business          selecciona negocios.
     * poi.government        selecciona edificios gubernamentales.
     * poi.medical           selecciona elementos relacionados con emergencias, (hospitales, farmacias, estaciones de policía y médicos, entre otros).
     * poi.park              selecciona parques.
     * poi.place_of_worship  selecciona lugares de culto religioso (iglesias, templos y mezquitas, entre otros).
     * poi.school            selecciona escuelas.
     * poi.sports_complex    selecciona complejos deportivos.
     */
    /**
   * @vuese
   * Establece estilo del mapa
   * @arg `feature`
      * @arg `visibility` visible
   */
    setMapStyle: function (feature, visibility = false) {
      var style = {
        featureType: feature,
        stylers: [{ visibility: visibility }]
      }

      this.mapStyles.set(feature, style)

      var styles = new Array()
      for (var [key, value] of this.mapStyles) {
        styles.push(value)
      }

      this.map.setOptions({ styles: styles })
    },
    /**
   * @vuese
   * Establece estilo del mapa
   * @arg `styleArr`
   */
    setAllMapStyle: function (styleArr) {
      this.map.setOptions({ styles: styleArr })
    },

    setMapType: function (mapType) {
      var mType = google.maps.MapTypeId.ROADMAP

      switch (mapType.toLowerCase()) {
        case 'roadmap':
          mType = google.maps.MapTypeId.ROADMAP
          break

        case 'satellite':
          mType = google.maps.MapTypeId.SATELLITE
          break

        case 'hybrid':
          mType = google.maps.MapTypeId.HYBRID
          break

        case 'terrain':
          mType = google.maps.MapTypeId.TERRAIN
          break

        default:
          mType = google.maps.MapTypeId.ROADMAP
      }

      this.map.setOptions({ mapTypeId: mType })
    },

    /** MARKER METHODS
     * Metodos para la creacion y manipulacion de marcadores
     */
    /**
   * @vuese
   * crea y muestra marcador en mapa
   * @arg `id` id del marcador
   * @arg `lat` latitud
  * @arg `lng` longitud
   * @arg `markerType` tipo de marcador a mostrar
    * @arg `titulo` titulo de marcador, por defecto=null
   * @arg `infoWindowsConent`  contenedor de infowindows, por defecto=null
   */
    addMarker: function (id, lat, lng, markerType = null, title = null, infoWindowContent = null) {
      id = '' + id
      if (this.markers.has(id) === false) {
        if (markerType == null) {
          markerType = 'default'
        }
        // Crear marcador
        var position = new google.maps.LatLng(lat, lng)
        var icon = {
          labelOrigin: new google.maps.Point(
            this.markerSize / 2,
            this.markerSize + 5
          ),
          url: './img/map/markers/' + markerType + '.png',
          scaledSize: new google.maps.Size(this.markerSize, this.markerSize),
          origin: new google.maps.Point(0, 0),
          anchor: new google.maps.Point(this.markerSize / 2, this.markerSize),
          labelInBackground: true
        }

        if (title != null) {
          title = '' + title
        }
        var label = {
          color: 'black',
          fontWeight: 'bold',
          text: title
        }

        var marker = new google.maps.Marker({ position, map: this.map })
        marker.setIcon(icon)
        if (title != null) {
          marker.setLabel(label)
        }

        if (infoWindowContent != null) {
          infoWindowContent = `<div id='info-${id}'>${infoWindowContent}</div>` // convertir a string
          marker.info = new google.maps.InfoWindow({
            content: infoWindowContent
          })
        }

        this.registerMarkerListeners(id, marker)
        this.markers.set(id, marker)
        this.addMarkerToCluster(marker)
      } else {
        console.warn(`google-map/ Marker ${id} already added`)
      }
    },
    /**
   * @vuese
   * Se suscribe a los eventos del marcador
   * @arg `id` id del marcador
   * @arg `marker` marcador
   */
    registerMarkerListeners (id, marker) {
      marker.addListener('click', this.onMarkerClick.bind(this, id))
      marker.addListener('position_changed', this.onMarkerPositionChanged.bind(this, id, marker))
      marker.addListener('animationposition_changed', this.onMarkerAnimationPositionChanged.bind(this, id, marker))
    },
    /**
   * @vuese
   * mueve un marcador
   * @arg `id` id del marcador
   * @arg `lat` latitud
  * @arg `lng` longitud
   * @arg `animate` animacion, por defecto=false
    * @arg `duration` velocidad de aninacion, por defecto=10000
   */
    moveMarker: function (id, lat, lng, animate = false, duration = 10000) {
      id = '' + id
      if (this.markers.has(id)) {
        var position = new google.maps.LatLng(lat, lng)
        var marker = this.markers.get(id)

        var distance = this.haversine({ lat: marker.position.lat(), lng: marker.position.lng() }, { lat: position.lat(), lng: position.lng() })
        var minDistance = 5

        if (animate && distance >= minDistance) {
          marker.setDuration(duration)
          marker.setEasing('linear')
          marker.setPosition(position)
        } else {
          marker.setPositionNotAnimated(position)
        }

        this.markers.set(id, marker)
      } else {
        console.debug(`google-maps/ MoveMarker ${id} not found`)
      }
    },
    /**
   * @vuese
   * elimina marcador
   * @arg `id` id del marcador
   */
    deleteMarker: function (id) {
      try {
        id = '' + id
        var marker = this.markers.get(id)
        this.markers.delete(id)

        this.removeMarkerFromCluster(marker)
        marker.setMap(null)
        marker = null
      } catch (err) { console.warn('DeleteMarker', err.message) }
    },
    /**
   * @vuese
   * cambia imagen (icono) de marcador
   * @arg `id` id del marcador
   * @arg `markerName` tipo de icono marcador
   */
    setMarkerIcon: function (id, markerName) {
      try {
        id = '' + id
        var marker = this.markers.get(id)
        marker.setIcon({
          labelOrigin: new google.maps.Point(16, 37),
          url: 'img/map/markers/' + markerName + '.png',
          scaledSize: new google.maps.Size(32, 32),
          origin: new google.maps.Point(0, 0),
          anchor: new google.maps.Point(11, 40)
        })
        this.markers.set(id, marker)
      } catch (error) {
        console.warn('google-map/ updateMarkerIcon: ' + error)
      }
    },
    /**
   * @vuese
   * Establece titulo a marcador
   * @arg `id` id del marcador
   * @arg `title` titulo marcador
   */
    setMarkerTitle: function (id, title) {
      try {
        id = '' + id
        var marker = this.markers.get(id)

        if (title != null && title != '') {
          title = title.substring(0, this.labelMaxCharters)

          marker.setLabel({
            color: 'black',
            fontWeight: 'bold',
            text: title
          })
        } else {
          marker.setLabel(null)
        }

        this.markers.set(id, marker)
      } catch (error) {
        console.warn('updateMarkerTitle: ' + error)
      }
    },
    /**
   * @vuese
   * Muestra infowindows al marcador
   * @arg `id` id del marcador
   */
    showMarkerInfoWindow: function (id) {
      console.debug('GOOGLE_showMarkerInfoWindow', id)
      var marker = this.markers.get('' + id)

      console.debug(this.markers, 'GOOGLE_showMarkerInfoWindow_MARKER', marker)
      marker.info.open(this.map, marker)

      marker.info.addListener('closeclick', this.onMarkerInfoWindowsClose.bind(this, id, 1))
      // TODO: Remover boton X de google, usar jquery
      // gm-ui-hover-effect
    },
    /**
   * @vuese
   * Cierra infowindows de marcador
   * @arg `id` id del marcador
   */
    closeMarkerInfoWindow: function (id) {
      var marker = this.markers.get(id)
      marker.info.close()
    },
    /**
   * @vuese
   * Cierra todos los infowindows
   */
    closeAllMarkerInfoWindow: function () {
      this.markers.forEach(marker => {
        marker.info.close()
      })
    },
    /**
   * @vuese
   * Establece el contenido de infowindows a marcador
   * @arg `id` id del marcador
   * @arg `content` contenido de infowindows
   */
    setMarkerInfoWindow: function (id, content) {
      console.debug('GOOGLE_setMarkerInfoWindow', id, content)
      if (content != null) {
        id = '' + id
        var marker = this.markers.get(id)
        marker.info.setContent(content)

        try {
          marker.info.close()
        } catch (err) {}
        this.markers.set(id, marker)
      }
    },
    /**
   * @vuese
   * Establece animacion a marcador
   * @arg `id` id del marcador
   * @arg `timeout` tiempo de animacion, por defecto=3000
   */
    animateMarker: function (id, timeout = 3000) {
      var marker = this.markers.get('' + id)
      marker.setAnimation(google.maps.Animation.BOUNCE)

      window.setTimeout(function () {
        marker.setAnimation(null)
      }, timeout)
    },
    /**
   * @vuese
   * Establece si es visible o no
   * @arg `id` id del marcador
   * @arg `visibility` visibilidad de marcador
   */
    setMarkerVisible: function (id, visibility) {
      var marker = this.markers.get(id)
      marker.setVisible(visibility)
      if (visibility) {
        this.addMarkerToCluster(marker)
      } else {
        this.removeMarkerFromCluster(marker)
      }
    },
    /**
   * @vuese
   * Muestra u oculta marcadores
   * @arg `show` mostrar o no
   */
    showAllMarkers: function (show) {
      this.markers.forEach(marker => {
        marker.setVisible(show)
      })

      if (show) {
        this.addAllMarkersToCluster()
      } else {
        this.removeAllMarkersFromCluster()
      }
    },
    /**
   * @vuese
   * Obtiene los puntos de todos los marcadores
   * @arg `arrID` arreglo de marcadores
   */
    getMarkersBounds: function (arrID) {
      var bounds = new google.maps.LatLngBounds()
      arrID.forEach(id => {
        var marker = this.markers.get(id)

        bounds.extend(marker.getPosition())
      })

      return bounds
    },
    /**
   * @vuese
   * Establece los puntos de todos los marcadores y centra mapa
   */
    setBoundsAllMarkers: function () {
      var bounds = new google.maps.LatLngBounds()
      this.markers.forEach(marker => {
        bounds.extend(marker.getPosition())
      })
      this.centerMapToBounds(bounds)
    },

    /** CLUSTER METHODS
     *  Metodos para la gestion de clusters
     */
    /**
   * @vuese
   * Inicializa libreria para cluster
   */
    initializeClusterManager: function () {
      this.clusterManager = new MarkerClusterer(this.map, [], {
        imagePath: './img/map/clusters/',
        maxZoom: this.clustersMaxZoom,
        averageCenter: true,
        zoomOnClick: this.clustersZoomOnClick
      })
    },
    /**
   * @vuese
   * Se suscribe a los eventos del cluster
   */
    registerClusterListeners: function () {
      // obtener array de clusters images
      // agregar eventos on click a cada una de las imagenes
      setTimeout(function () {
        // console.debug('Cluster Count', this.clusterManager.getTotalClusters())
        $('div[style*="./img/map/clusters/1.png"]').on('click', this.onClusterClick)
      }.bind(this), 500)
    },
    /**
   * @vuese
   * Agrega todos los marcadores al cluster
   */
    addAllMarkersToCluster: function () {
      if (this.clusters) {
        var markersArr = Array.from(this.markers.values())

        this.clusterManager.addMarkers(markersArr)
        this.redrawCluster()
      }
    },
    /**
   * @vuese
   * Agrega un marcador al cluster
   * @arg `marker`  marcador
   */
    addMarkerToCluster: function (marker) {
      if (this.clusters) {
        this.clusterManager.addMarker(marker)
      }
    },
    /**
   * @vuese
   * Elimina marcador del cluster
   * @arg `marker`  marcador
   */
    removeMarkerFromCluster: function (marker) {
      if (this.clusters) {
        this.clusterManager.removeMarker(marker)
      }
    },
    /**
   * @vuese
   * Elimina marcadores del cluster
   */
    removeAllMarkersFromCluster: function () {
      this.clusterManager.clearMarkers()
      this.redrawCluster()
    },
    /**
   * @vuese
   * Obtiene cluster
   */
    getClusters: function () {
      console.debug('cluster obj', this.clusterManager)
    },
    /**
   * @vuese
   * Dibuja cluster
   */
    redrawCluster: function () {
      this.clusterManager.resetViewport()
      this.clusterManager.redraw()
    },
    /**
   * @vuese
   * Eventos click cluster
   */
    onClusterClick: function () {
      setTimeout(function () {
        console.debug('Cluster Click', this.mapLat, this.mapLng)
        console.debug('cluster obj', this.clusterManager)
      }.bind(this), 300)
    },

    /** POLYLINE METHODS
     * Metodos para la creacion y manipulacion de lineas
     */
    /**
   * @vuese
   * Elimina marcador del cluster
   * @arg `positions`  arreglo de posiciones
  * @arg `id`  id de polilinea, por defecto='temp_simbol'
  * @arg `color`  color, por defecto=null
  * @arg `showArrows`  puntos, por defecto=false
  * @arg `arrowRepeat`  valor puntos
  * @arg `animate`  animacion, por defecto=false
  * @arg `opacity`  opacidad, por defecto=2
  * @arg `weight`  grosor, por defecto=3
   */
    addPolyline: function (positions, id = 'temp_simbol', color = null, showArrows = false, arrowRepeat = 0, animate = false, opacity = 1, weight = 3) {
      // id = +'' + id

      if (color == null) {
        color = '#F44336'
      }

      // TODO: Permitir agregar custom icon para los trazos(peudes ser en svg)
      var icon = []
      if (showArrows) {
        icon = [
          {
            icon: { path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW },
            offset: '100%',
            repeat: arrowRepeat + '%',
            strokeWeight: 1
          }
        ]
      }

      var line = new google.maps.Polyline({
        path: positions,
        geodesic: true,
        strokeColor: color,
        strokeOpacity: opacity,
        strokeWeight: weight,
        icons: icon
      })

      line.setMap(this.map)
      this.polylines.set(id, line)

      if (showArrows && animate) {
        // animatePolyline(line)
        var animation = new this.animatePolyline(line)
      }
    },
    /**
   * @vuese
   * Elimina polilinea
   * @arg `id`  id polilinea
   */
    deletePolyline (id) {
      var line = this.polylines.get(id)
      line.setMap(null)
      this.polylines.delete(id)
    },
    /**
   * @vuese
   * Muestra todas las polilineas
   * @arg `visible`  visibilidad o no
   */
    showAllPolyline (visible) {
      this.polylines.forEach(draw => {
        draw.setVisible(visible)
      })
    },
    /**
   * @vuese
   * anima la polilinea
   * @arg `line` polilinea
   */
    animatePolyline: function (line) {
      var count = 0
      window.setInterval(function () {
        count = count + 0.1

        var icons = line.get('icons')
        icons[0].offset = count + '%'
        line.set('icons', icons)
      }, 50)
    },
    /**
   * @vuese
   * Obtiene puntos de polilinea
   * @arg `id`  id polilinea
   */
    getPolylineBounds (id) {
      var polyline = this.polylines.get(id)
      var bounds = polyline.getBounds()

      return bounds
    },
    /**
   * @vuese
   * Establece puntos de polilinea
   */
    setBoundsAllPolylines: function () {
      var bounds = new google.maps.LatLngBounds()
      this.polylines.forEach(polyline => {
        bounds.union(polyline.getBounds())
      })
      this.centerMapToBounds(bounds)
    },

    /** EVENT HANDLERS
     Metodos que menejan los eventos del mapa, marcadores, etc y que se encargan de
     emitir dichos eventos al componente padre
     */
    /**
   * @vuese
   * Evento cuando cierra infowindows
   * @arg `id`  id marcador
   */
    onMarkerInfoWindowsClose: function (id, seccion = null) {
      var marker = this.markers.get(id)

      this.$emit('onMarkerInfoWindowsClose', id, seccion)
    },
    /**
   * @vuese
   * Evento click en mapa
   * @arg `e`  evento
   */
    onMapClick: function (e) {
      var position = {
        lat: e.latLng.lat(),
        lng: e.latLng.lng()
      }
      this.mapLat = position.lat
      this.mapLng = position.lng
      console.debug(`google-map/ MapClick ${position.lat},${position.lng}`)
      this.$emit('onMapClick', position)
    },
    /**
   * @vuese
   * Evento zoom en mapa
   * @arg `e`  evento
   */
    onMapZoomChanged: function (e) {
      this.mapZoom = this.map.zoom
      console.debug(`google-map/ ZoomChanged ${this.map.zoom}`)
      this.$emit('onMapZoomChanged', this.map.zoom)

      this.registerClusterListeners()
    },
    /**
   * @vuese
   * Evento click en marcador
   * @arg `id`  id marcador
   */
    onMarkerClick: function (id) {
      id = '' + id
      var marker = this.markers.get(id)

      console.debug(`google-map/ MarkerClick ${id}`)
      this.$emit('onMarkerClick', id, marker)
    },
    /**
   * @vuese
   * Evento cambia posicion de marcador
   * @arg `id`  id marcador
   * @arg `marker`   marcador
   */
    onMarkerPositionChanged: function (id, marker) {
      this.redrawCluster()
      var position = {
        lat: marker.position.lat(),
        lng: marker.position.lng()
      }
      console.debug(`google-map/ MarkerPositionChanged ${id}`, position)
      this.$emit('onMarkerPositionChanged', id, position)
    },
    /**
   * @vuese
   * Evento cambia posicion de marcador y animacion
   * @arg `id`  id marcador
   * @arg `marker`   marcador
   */
    onMarkerAnimationPositionChanged: function (id, marker) {
      var animationPosition = marker.getAnimationPosition()
      var position = {
        lat: animationPosition.lat(),
        lng: animationPosition.lng()
      }

      var distance = this.haversine({ lat: this.mapLat, lng: this.mapLng }, { lat: position.lat, lng: position.lng })
      var minDistanceToAutoCenterMap = 30

      if (distance >= minDistanceToAutoCenterMap && this.followDevice === id) {
        this.centerMap(position.lat, position.lng)
      }

      if (distance > 50) {
        this.$emit('onMarkerAnimationPositionChanged', id, position)
      } else {
        // console.debug(`google-map/ onMarkerEndAnimationPositionChanged ${id}`, position)
        this.$emit('onMarkerEndAnimationPositionChanged', id)
      }
    },

    /** POLYLON, CIRCLE METHODS
     * Metodos para la creacion y manipulacion de poligonos, circulos
     */

    /* TODO: METODOS DEL CIRCLE */
    /**
   * @vuese
   * Evento edita circulos
   * @arg `id`  id circulo
   */
    changed_circle (id) {
      var circle = this.listDrawing.get(id)

      if (this.seccionPunto != null) {
        var radio = 50
        if (circle.getRadius() < radio) {
          if (this.seccionPunto === 'PuntoInteres_new') {
            this.setRadius(radio)
          } else {
            this.setRadius(radio, id)
          }
        }
      }

      if (circle.getRadius() > 3000000) {
        this.setRadius(3000000, id)
      }

      var circlePosition = circle.getCenter()
      var data = {
        'lat': circlePosition.lat(),
        'lng': circlePosition.lng(),
        'radio': circle.getRadius()
      }

      this.$emit('editDrawingCircle', data)
    },
    /**
   * @vuese
   * Evento obtiene datos circulo
   * @arg `id`  id circulo
   */
    getCircle (id) {
      var circle = this.listDrawing.get(id)

      var circlePosition = circle.getCenter()
      var data = {
        'lat': circlePosition.lat(),
        'lng': circlePosition.lng(),
        'radio': circle.getRadius()
      }
    },
    /**
   * @vuese
   * Evento crea circulos
   * @arg `id`  id circulo
   * @arg `lat`  latitud circulo
   * @arg `lng`  longitud circulo
   * @arg `radio`  radio  circulo
   * @arg `seccion`  seccion
   * @arg `color`  color circulo, por defecto='#77d2ff' (azul)
   * @arg `opacidad`  opacidad, por defecto=0.3
   * @arg `border`  borde, por defecto=1
   * @arg `centerOnMap`  centrar mapa en ciculo, por defecto=false
   */
    createCircle (id, lat, lng, radio, seccion = null, color = '#77d2ff', opacidad = 0.3, border = 1, centerOnMap = false) {
      var position = new google.maps.LatLng(lat, lng)

      var radius = parseFloat(radio)

      if (radius > 3000000) {
        radius = 3000000
      }

      if (seccion != null) {
        this.seccionPunto = seccion
      } else {
        this.seccionPunto = null
      }

      var circle = new google.maps.Circle({
        strokeColor: '#656565',
        strokeWeight: border,
        fillColor: color,
        fillOpacity: opacidad,
        map: this.map,
        center: position,
        radius: radius
      })
      // agrega eventos
      this.registerListenerCircle(circle, id)
      this.listDrawing.set(id, circle)
    },
    /**
   * @vuese
   * Obtiene puntos de circulo
   * @arg `id`  id circulo
   */
    getCircleBounds (id) {
      var circle = this.listDrawing.get(id)
      return circle.getBounds()
    },
    /**
   * @vuese
   * Obtiene puntos de circulos
   * @arg `arrID`  arreglo  circulos
   */
    getCirclesBounds (arrID) {
      var bounds = new google.maps.LatLngBounds()
      arrID.forEach(id => {
        var circleBounds = this.getCircleBounds(id)
        var north = circleBounds.getNorthEast()
        var southWest = circleBounds.getSouthWest()

        bounds.extend(north)
        bounds.extend(southWest)
      })

      return bounds
    },
    /**
   * @vuese
   * Establece radio de circulo
   * @arg `id`  id circulo, por defecto='temp_simbol'
   * @arg `radio` radio
   */
    setRadius (radio, id = 'temp_simbol') {
      var circle = this.listDrawing.get(id)
      var radius = parseFloat(radio)
      circle.setRadius(radius)
    },
    /**
   * @vuese
   * Obtiene radio de circulo
   * @arg `id`  id circulo, por defecto='temp_simbol'
   */
    getRadius (id = 'temp_simbol') {
      var circle = this.listDrawing.get(id)
      circle.getRadius()
    },
    /**
   * @vuese
   * Se suscribe a eventos de circulo
   * @arg `id`  id circulo
   * @arg `cicle` ciculo
   */
    registerListenerCircle (circle, id) {
      circle.addListener('center_changed', this.changed_circle.bind(this, id))
      circle.addListener('radius_changed', this.changed_circle.bind(this, id))
    },
    /* TODO: METODOS COMPARTIDOS DRAWING y simbols */
    /**
   * @vuese
   * Inicia libreria de dibujo
   */
    initDrawing () {
      this.drawingManager = new google.maps.drawing.DrawingManager()

      this.registerListenerDrawing()
    },
    /**
   * @vuese
   * Establece si se muestra o no panel de control de dibujo
   * @arg `state` valor
   */
    SetControlDrawingVisible (state) {
      this.drawingManager.setOptions({
        drawingControl: state
      })
    },
    /**
   * @vuese
   * Establece opciones del panel de control de dibujo
   * @arg `stateControl`  panel de control
   */
    SetControlDrawingOptions (stateControl) {
      var drawingManagerOptions = {
        drawingMode: google.maps.drawing.OverlayType.MARKER,
        drawingControl: false,
        drawingControlOptions: {
          position: google.maps.ControlPosition.TOP_CENTER,
          drawingModes: ['marker', 'circle', 'polygon', 'polyline', 'rectangle']
        },
        markerOptions: { icon: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png' }

      }

      this.drawingManager.setOptions(drawingManagerOptions)
    },
    /**
   * @vuese
   * Elimina dibujo
   * @arg `id`  id circulo, por defecto='temp_simbol'
   */
    deleteDrawing (id = 'temp_simbol') {
      if (this.listDrawing.has(id) === true) {
        var drawing = this.listDrawing.get(id)
        drawing.setMap(null)
        this.listDrawing.delete(id)
      }
    },
    /**
   * @vuese
   * Muestra u oculta todos los dibujos
   * @arg `visible`  visibilidad
   */
    showAllDrawing (visible) {
      this.listDrawing.forEach(draw => {
        draw.setVisible(visible)
      })
    },
    /**
   * @vuese
   * activa dibujo, para dibujar en mapa: `circulo`, `poligono`, `marcador`
   * @arg `tipo` tipo de dibujo
   * @arg `radio` radio, por defecto=null
   * @arg `contRuta` contador ruta ,por defecto=null
   * @arg `color` color, por defecto='#77d2ff'(azul)
   * @arg `opacidad` opacidad, por defecto=0.3
   * @arg `editable` por defeco=false
   * @arg `border` borde=1
   */
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
    /**
   * @vuese
   * Evento cuando se termina de dibujar circulo
   * @arg `circle`  circulo
   */
    drawingCircleComplete (circle) {
      var id = 'temp_simbol'//  this.listDrawing.size

      this.listDrawing.set(id, circle)

      if (circle.getRadius() > 3000000) {
        this.setRadius(3000000, id)
      }

      // agrega eventos
      this.registerListenerCircle(circle, id)

      // if (circle.getRadius() < this.radio) {
      //   this.setRadius(this.radio)
      // }
      var circlePosition = circle.getCenter()
      var data = {
        'lat': circlePosition.lat(),
        'lng': circlePosition.lng(),
        'radio': circle.getRadius()
      }

      this.$emit('completeDrawing', data)
    },
    /**
   * @vuese
   * Evento cuando se termina de dibujar un poligono
   * @arg `polygon`  poligono
   */
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

      this.$emit('completeDrawingPlygon', data)
    },
    /**
   * @vuese
   * Obtiene puntos de poligono
   * @arg `id`  id poligono
   */
    getPolygonBounds (id) {
      var polygon = this.listDrawing.get(id)
      var bounds = polygon.getBounds()

      return bounds
    },
    /**
   * @vuese
   * guarda en array dibujo
   * @arg `id`  id dibujo, por defecto='temp_simbol'
   */
    saveDrawing (id) {
      var drawing = this.listDrawing.get('temp_simbol')
      // se eliminia temporal
      this.listDrawing.delete('temp_simbol')

      // guardar con el id DB
      this.listDrawing.set(id, drawing)
    },
    /**
   * @vuese
   * Establece si es editable o no el dibujo
   * @arg `id`  id dibujo
   * @arg `isEdit` editable o no
   */
    setEditDrawing (id, isEdit) {
      var draw = this.listDrawing.get(id)
      draw.setOptions({
        clickable: isEdit,
        draggable: isEdit,
        editable: isEdit
      })
    },
    /**
   * @vuese
   * Establece si es visible o no el dibujo
   * @arg `id`  id dibujo
   * @arg `visible` visible o no
   */
    isVisibleDrawing (id, visible) {
      if (this.listDrawing.has(id) === true) {
        var draw = this.listDrawing.get(id)
        draw.setVisible(visible)
      }
    },
    /**
   * @vuese
   * Establece color del dibujo
   * @arg `id`  id dibujo
   * @arg `color` color
   */
    setcolorDrawing (id, color) {
      var draw = this.listDrawing.get(id)
      draw.setOptions({
        fillColor: color
      })
    },
    /**
   * @vuese
   * Establece color y grosor del borde del dibujo
   * @arg `id`  id dibujo
   * @arg `border` borde
   * @arg `color` color
   */
    setBorderDrawing (id, border, color) {
      var draw = this.listDrawing.get(id)
      draw.setOptions({
        strokeWeight: border,
        strokeColor: color
      })
    },
    /**
   * @vuese
   * Establece opacidad del dibujo
   * @arg `id`  id dibujo
   * @arg `opacity` opacidad
   */
    setOpacityDrawing (id, opacity) {
      var draw = this.listDrawing.get(id)
      draw.setOptions({
        fillOpacity: opacity
      })
    },
    /**
   * @vuese
   * Deshabilita modo de dibujo
   */
    deshabilitarDrawingMode () {
      this.drawingManager.setDrawingMode(null)
    },
    /**
   * @vuese
   * Se suscribe aeventos de dibujo
   */
    registerListenerDrawing () {
      this.drawingManager.addListener('circlecomplete', this.drawingCircleComplete)
      this.drawingManager.addListener('polygoncomplete', this.drawingPolygonComplete)
      this.drawingManager.addListener('markercomplete', this.drawingRutasComplete)
    },

    /* TODO: METODOS DE RUTAS */
    /**
   * @vuese
   * Inicia libreria de rutas
   */
    initDirections () {
      this.directionsService = new google.maps.DirectionsService()
    },
    /**
   * @vuese
   * Evento cuando se acompleta la ruta
   * @arg `id`  marcador
   */
    drawingRutasComplete (marker) {
      this.contRuta++

      var id
      if (this.contRuta == 1) {
        id = 'origen_ruta'
      }
      if (this.contRuta == 2) {
        id = 'destino_ruta'
      }

      this.listDrawing.set(id, marker)

      var position = marker.getPosition()

      var data = {
        'lat': position.lat(),
        'lng': position.lng()
      }
      this.$emit('completeRuta', data)
    },
    /**
   * @vuese
   * Evento para crear ruta
   * @arg `origen`  origen
   * @arg `destino` destino
   * @arg `id` id, por defecto='temp_simbol'
   */
    crearRuta (origen, destino, id = 'temp_simbol') {
      this.deleteDrawing('origen_ruta')
      this.deleteDrawing('destino_ruta')
      this.directionsDisplay = new google.maps.DirectionsRenderer()
      // this.directionsDisplay = new google.maps.DirectionsRenderer()

      var positionOrigin = new google.maps.LatLng(origen.lat, origen.lng)
      var positionDest = new google.maps.LatLng(destino.lat, destino.lng)
      const _self = this
      this.directionsService.route({
        origin: positionOrigin,
        destination: positionDest,
        travelMode: 'DRIVING'

      },
      function (response, status) {
        if (status === 'OK') { // si es diferente de ok-- error
          _self.directionsDisplay.setMap(_self.map)
          _self.directionsDisplay.setDirections(response)
        }

        // agrega eventos
        _self.registerListenerRuta(_self.directionsDisplay, id)

        // guardar datos
        _self.listDrawing.set(id, _self.directionsDisplay)

        _self.setEditRuta(true)

        var result = _self.getDataRuta(response)

        _self.$emit('dataCreateRuta', result)
      })
    },
    /**
   * @vuese
   * Evento para obtener datos de ruta
   * @arg `response`  respuesta ruta
   */
    getDataRuta (response) {
      var origin
      var destino

      if (response.request.origin.location === undefined) {
        origin = response.request.origin
      } else {
        origin = response.request.origin.location
      }
      if (response.request.destination.location === undefined) {
        destino = response.request.destination
      } else {
        destino = response.request.destination.location
      }

      var legsAll = []
      var pointPolyline = []
      var tiempoAll = null
      var distanciaAll = null
      var status = response.status
      var data

      if (status === 'OK') { // si es diferente de ok-- error
        if (response.routes.length > 0) {
          var routes = response.routes[0]

          var legs = routes.legs[0]
          var pathPoline = routes.overview_path

          tiempoAll = legs.duration.value
          distanciaAll = legs.distance.value
          legs.steps.forEach(element => {
            legsAll.push({ lat: element.start_location.lat(), lng: element.start_location.lng(), distance: [element.distance.value], duration: [element.duration.value] })
          })

          var puntosAll = []
          legs.steps.forEach(i => {
            i.lat_lngs.forEach(element => {
              puntosAll.push({ lat: element.lat(), lng: element.lng() })
            })
          })

          pathPoline.forEach(element => {
            pointPolyline.push({ lat: element.lat(), lng: element.lng() })
          })

          pathPoline.forEach(element => {

          })
        }

        data = {
          'status': status,
          'origen': { lat: origin.lat(), lng: origin.lng() },
          'destino': { lat: destino.lat(), lng: destino.lng() },
          'tiempo': tiempoAll,
          'distancia': distanciaAll,
          'checkPoints': legsAll,
          'points': pointPolyline,
          'puntosAll': puntosAll
        }
      } else { // no se creo la ruta
        data = {
          'status': status
        }
      }

      this.listDrawing.set('origen_ruta', origin)
      this.listDrawing.set('destino_ruta', destino)
      return data
    },
    /**
   * @vuese
   * Evento cuando modifica la ruta
   * @arg `id`  ruta
   */
    changed_ruta (id) {
      var draw = this.listDrawing.get(id)
      var directions = draw.getDirections()

      var response = directions
      var result = this.getDataRuta(response)

      this.$emit('dataCreateRuta', result)
      // emitEDIT
    },
    /**
   * @vuese
   * Establece si es editable o no la ruta
   * @arg `id`  id ruta='temp_simbol'
   * @arg `isEdit` editable o no
   */
    setEditRuta (isEdit, id = 'temp_simbol') {
      var draw = this.listDrawing.get(id)

      draw.setOptions({
        draggable: isEdit
      })
    },
    /**
   * @vuese
   * Se suscribe a eventos de ruta
   * @arg `id`  id ruta
   * @arg `ruta` ruta
   */
    registerListenerRuta (ruta, id) {
      ruta.addListener('directions_changed', this.changed_ruta.bind(this, id))
    },

    /* TODO: METODOS DE POLYGON */
    /**
   * @vuese
   * Se suscribe a eventos de poligono
   * @arg `id`  id poligono
   * @arg `polygon` poligono
   */
    registerListenerPolygon (polygon, id) {
      polygon.addListener('mouseup', this.mouseup.bind(this, id))
    },
    /**
   * @vuese
   * Evento cuando edita poligono
   * @arg `id`  id poligono
   */
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
    /**
   * @vuese
   * Crea poligono
   * @arg `id` id de poligono
   * @arg `positions` posicion
   * @arg `color` color, por defecto='#77d2ff'(azul)
   * @arg `opacidad` opacidad, por defecto=0.3
   * @arg `border` borde=1
   */
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
    /**
   * @vuese
   * Obtiene poligono
   * @arg `id` id de poligono
   */
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
    }
  }
}
</script>

<style>
.google-maps {
  margin: 0 auto;
  background: gray;
}
</style>
