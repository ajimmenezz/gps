<template>
<div>
    <div>TITULO GEOCERCAS</div>
    <div>BUSCADOR</div>
    <div>LISTA</div>
    <button @click="crearPolyline">Crear linea</button>
    <button @click="deletePolyline">Borrar Linea</button>
</div>
</template>

<script>
export default {
  data () {
    return {
      map: null
    }
  },
  inject: [
    'getMap'
  ],
  mounted () {
    this.map = this.getMap()
    this.map.$on('onMapClick', this.onMapClick)
  },
  methods: {
    crearPolyline () {
      var positions = [
        { lng: -99.17419000000001, lat: 18.89639 },
        { lng: -99.17461, lat: 18.897750000000002 },
        { lng: -99.17461, lat: 18.897820000000003 },
        { lng: -99.17458, lat: 18.89788 }
      ]

      // (id, positions, color = null, showArrows = false, arrowRepeat = 0, animate = false, opacity = 1, weight = 3) {
      this.map.addPolyline(positions, 'poli1', '#E65100', false, 0, false, 0.6, 10)
    },
    deletePolyline () {
      this.map.deletePolyline('poli1')
    },
    addMarker () {
      this.map.addMarker('m', 19.4444205, -99.2041043)
    }
  }
}
</script>

<style>

</style>
