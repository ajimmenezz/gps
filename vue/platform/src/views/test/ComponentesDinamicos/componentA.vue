<template>
    <div>
        componenete principal
        {{this.$store.state.test.modal}}
        getters
          {{this.$store.getters['test/Modal']}}

</br>
        <button  @click="loadComponent(1)">componentA</button>
         <button  @click="loadComponent(2)">componentB</button>

    </div>
</template>

<script>

import componentB from './componentB.vue'
import componentC from './componentC.vue'

export default {

  data () {
    return {
      knownEvents: ['onDeviceSelected', 'onDevicesSelected']
    }
  },
  components: {
    componentB,
    componentC
  },
  methods: {
    loadComponent (opc) {
      switch (opc) {
        case 1:
          // cargar componenete a store y hace visible
          console.log('a')
          this.$store.commit('test/ADD_COMPONENT_DINAMIC', componentB)
          this.$store.commit('test/ADD_COMPONENT_DINAMIC_STATE', true)
          break
        case 2:
          console.log('b')
          this.$store.commit('test/ADD_COMPONENT_DINAMIC', componentC)
          break
      }
    },
    proxyEvent (eventName, eventData) {
      switch (eventName) {
        case 'onDevicesSelected':
          this.$emit('onDevicesSelected', eventData)
          break
      }
    }
  }
}
</script>
