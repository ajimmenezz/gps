<template>
  <div class="row">
      <div class="col-4"><button @click="loadComponent">Cargar componente</button></div>
      <div class="col-4">
        <div id="" ref="render">
            <div id="header"></div>
            <div id="container"></div>
        </div>
      </div>
      <div class="col-4">&nbsp;</div>
  </div>

</template>

<script>
import componente from '@/components/DeviceInfoWindow.vue'
// import Geofence from '@/views/MapModule OLD/Geofence/GeofenceListPanel.vue'

import Vue from 'vue'
export default {
  mounted () {

  },
  methods: {
    loadComponent () {
      // var ComponentX = Vue.extend(componente)
      // var instance = new ComponentX({
      //   propsData: { no: 'UNO2', deviceID: 5 }
      // })
      // instance.$mount()
      // $('#header').append(instance.$el)

      // var GeofenceComponent = Vue.extend(Geofence)
      // var instance2 = new GeofenceComponent({})
      // instance2.$mount()
      // $('#container').append(instance2.$el)
    // this.$refs.render.appendChild(instance.$el) //via ref
    }
  }

}
</script>

<style>

</style>
