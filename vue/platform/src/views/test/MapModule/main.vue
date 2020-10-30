<template>
<div class="container-fluid">
    <div class="row">
        <div class="col-6" v-if="map.ready">
            <component-a ></component-a>
        </div>
        <div class="col-6">
            <google-maps name="map" ref="map"
            :lat="18.9240744" :lng ="-99.2252484" :zoom="5" :height="600"
            :zoomControl="true"
            :streetViewControl="false"
            markerSize="38"
            @onMapReady="onMapReady"
            ></google-maps>
        </div>
    </div>
</div>
</template>

<script>
import componentA from '@/views/test/MapModule/a.component'
import googleMaps from '@/components/google/google.maps'
export default {
  components: {
    googleMaps,
    componentA
  },
  provide () {
    return {
      centerMap: this.centerMap,
      getMap: this.getMap
    }
  },
  data () {
    return {
      map: {
        ready: false
      }
    }
  },
  methods: {
    onMapReady () {
      this.map.ready = true
      this.$refs.map.$on('onMapClick', this.mapClicked)
    },
    getMap () {
      return this.$refs.map
    },
    centerMap () {
      this.$refs.map.centerMap(19.4444205, -99.2041043, 17)
    },
    mapClicked (position) {
      console.log('Map Click Padre')
    }
  }
}
</script>

<style>

</style>
