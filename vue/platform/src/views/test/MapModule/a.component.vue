<template>
<div class="alert-danger">
    <div>COMPONENTE A</div>
    <component-b></component-b>
</div>
</template>

<script>
import componentB from '@/views/test/MapModule/b.component'
export default {
  components: {
    componentB
  },
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
    onMapClick (position) {
      console.debug('Map Click componente A', position)
    }
  }
}
</script>

<style>

</style>
