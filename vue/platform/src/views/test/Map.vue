<template>
    <div class="container-fluid">
    <div class="row">
        <div class="col-9">
            <google-maps name="map" ref="map"
            :lat="map.lat" :lng ="map.lng" :zoom="map.zoom" :height="map.height"
            :zoomControl="true"
            :streetViewControl="true"
            :clusters="map.cluster"
            markerSize="38"
            @onMarkerClick ="onMarkerClick"
            @onMapClick="onMapClick"
            ></google-maps>
        </div>

        <div class="col-3" >
            <ul class="list-group" :style="{ 'overflow-y': 'auto', 'max-height': map.height + 'px' }">
                <li class="list-group-item">
                      <input v-model="data.markerID" placeholder="Marker ID">
                      <input v-model="data.lat" placeholder="Latitude">
                      <input v-model="data.lng" placeholder="Longitude">
                </li>
                <li class="list-group-item">
                    <button @click="addMarker">Agregar Marcador</button>
                    </li>
                <li class="list-group-item">
                    <input v-model="data.marker.name" placeholder="markerType">
                    <button @click="changeMarker">Changer Marker Icon</button>
                </li>
                <li class="list-group-item">
                  <button @click="moveMarker">Mover Marcador</button>
                  <br>
                  <input type="checkbox" v-model="data.marker.animate" id="animateMarkerCheck">
                  <label for="animateMarkerCheck">Animate Marker</label>
                </li>
                <li class="list-group-item">
                  <button @click="deleteMarker">Borar Marcador</button>
                </li>
                 <li class="list-group-item">
                  <button @click="centerMapFitBounds">Centrar Mapa en seleccionados</button>
                </li>
                 <li class="list-group-item">
                   <button @click="showMarker(false)">Ocultar Marcador</button>
                   <button @click="showMarker(true)">Mostrar Marcador</button>
                </li>
                <li class="list-group-item">
                  <button @click="redrawCluster">Redraw CLuster</button>
                </li>
                <li class="list-group-item">
                  <button @click="getClusters">Get Clusters and markers</button>
                </li>
                <li class="list-group-item">
                  <input type="checkbox" v-model="map.cluster" id="mapCluster">
                  <label for="mapCluster">Show Cluster {{map.cluster}}</label>
                </li>
                 <li class="list-group-item">
                  <button @click="addPolyline">Agregar Polyline</button>
                </li>
            </ul>
        </div>
    </div>

    <draggable name="deviceList">
      <draggable-header class="alert-info draggable--draggable">
        LISTA DE DISPOSITIVOS
      </draggable-header>
      <draggable-content>
        <ul class="list-group" v-for="marker in markers" :key="marker.id">
          <li class="list-group-item">
              <input type="checkbox" v-model="marker.selected" >
              <span>
                {{marker.id}}
              </span>
          </li>
        </ul>
      </draggable-content>
    </draggable>

    </div>
</template>

<script>
import googleMaps from '@/components/google/google.maps'
import { draggable, draggableHeader, draggableContent } from '@/components/draggable/'
import { constants } from 'crypto'
export default {
  components: {
    googleMaps,
    draggable,
    draggableHeader,
    draggableContent
  },
  data () {
    return {
      map: {
        height: 0,
        cluster: false,
        lat: 19.408632,
        lng: -99.1433132,
        zoom: 12
      },
      markers: [],
      data: {
        markerID: '',
        lat: '',
        lng: '',
        marker: {
          name: '',
          animate: false
        }
      }
    }
  },
  created () {
    this.resizeMap()
  },
  mounted () {
    $(window).resize(function () {
      this.resizeMap()
    }.bind(this))
  },
  methods: {
    resizeMap () {
      this.map.height = $(window).height()
    },
    // # Metodos de la vista
    addMarker () {
      // id, lat, lng, markerType =opcional, title =opcional, infoWindowContent =opcional
      this.$refs.map.addMarker(this.data.markerID, this.data.lat, this.data.lng)
      this.markers.push({ id: this.data.markerID, selected: false })
    },
    changeMarker () {
      console.debug(this.data.marker.name)
      this.$refs.map.setMarkerIcon(this.data.markerID, this.data.marker.name)
    },
    moveMarker () {
      this.$refs.map.moveMarker(this.data.markerID, this.data.lat, this.data.lng, this.data.marker.animate)
    },
    deleteMarker () {
      this.$refs.map.deleteMarker(this.data.markerID)
    },
    showMarker (show) {
      this.$refs.map.setMarkerVisible(this.data.markerID, show)
    },
    redrawCluster () {
      this.$refs.map.redrawCluster()
    },
    showCluster () {
    },
    getClusters () {
      this.$refs.map.getClusters()
    },
    centerMapFitBounds () {
      var markersSelected = []
      this.markers.forEach(marker => {
        if (marker.selected) {
          markersSelected.push(marker.id)
        }
      })

      console.debug('MarkersSelected', markersSelected)
      var bounds = this.$refs.map.getMarkersBounds(markersSelected)
      this.$refs.map.centerMapToBounds(bounds)
    },
    addPolyline () {
      var positions = [
        { 'lng': -99.17419000000001, 'lat': 18.89639 },
        { 'lng': -99.17461, 'lat': 18.897750000000002 },
        { 'lng': -99.17461, 'lat': 18.897820000000003 },
        { 'lng': -99.17458, 'lat': 18.89788 }
      ]

      // (id, positions, color = null, showArrows = false, arrowRepeat = 0, animate = false, opacity = 1, weight = 3) {
      this.$refs.map.addPolyline('poli1', positions, '#E65100', false, 0, false, 0.6, 10)
    },

    // #Metodos Hadler (los que reciben los eventos del componente google-maps)
    onMarkerClick (id) {},
    onMapClick (position) {
      this.data.lat = position.lat
      this.data.lng = position.lng
    }
  }
}
</script>

<style>

</style>
