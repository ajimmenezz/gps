<template>
<div class="container-fluid" style="margin-top:15px; margin-bottom:10px;">
    <div class="row">
        <div class="col-12 text-left" style="font-size:1.5rem">
            <b>TITLE</b>
            <hr>
        </div>
    </div>
    <div class="row" style="max-height:150px; overflow-y:auto;">
        <div class="col-12">
            Content
        </div>
        <div class="col-12">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Non, officiis excepturi esse harum, vero sed illum dolore quo accusamus velit ad. Provident aperiam praesentium quae architecto fuga, quidem velit molestiae.
        </div>
        <div class="col-6 alert-danger">Col-6</div>
        <div class="col-6 alert-info">Col-6</div>
        <div class="col-12 alert-success">
            Centrar mapa desde componente dinamico<br>
            {{position}}<br>
            <button @click="centerMap()">Centrar Mapa</button>
             <button @click="showDraggable()">ShowDrag</button>
        </div>
        <div class="col-12 alert-warning" style="height:900px;">
            Large Content
        </div>
        <div class="col-12 alert-danger" style="height:900px;">
            Large Content Lorem ipsum dolor sit, amet consectetur adipisicing elit. Veniam sapiente dolor consequuntur eum in ut atque aspernatur saepe ex? Nisi reiciendis ullam libero iste laborum beatae architecto esse nostrum suscipit.
        </div>
        <div class="col-12 alert-success" style="height:900px;">
            Large Content Lorem ipsum dolor sit, amet consectetur adipisicing elit. Veniam sapiente dolor consequuntur eum in ut atque aspernatur saepe ex? Nisi reiciendis ullam libero iste laborum beatae architecto esse nostrum suscipit.
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <hr>
            Some Footer
        </div>
    </div>

    <draggable
      name="test"
      :top="draggable.top"
      :left="draggable.left"
      :width="draggable.width"
      :height="draggable.height"
      :zindex="draggable.index"
      v-if="draggable.show">
      <draggable-header class="draggable--draggable">Header</draggable-header>
      <draggable-content>
        <sub-test @onClose="onDraggableClose()"/>
      </draggable-content>
    </draggable>
</div>
</template>

<script>
import { draggable, draggableHeader, draggableContent } from '@/components/draggable/'
import subTest from '@/views/MapModule/MapFloatMenu/test/test.sub.vue'
export default {
  components: {
    draggable,
    draggableHeader,
    draggableContent,
    subTest
  },
  inject: ['getMap', 'getDraggableProperties'],
  data () {
    return {
      map: null,
      draggable: {
        name: 'test',
        top: 0,
        left: 0,
        width: 300,
        height: 300,
        index: 100,
        show: false
      },
      position: null
    }
  },
  mounted () {
    this.map = this.getMap()
    this.map.$on('onMapClick', this.onMapClick)
  },
  methods: {
    onMapClick (position) {
      console.debug('Test MapClick', position)
      this.position = position
    },
    centerMap () {
      var zoom = Math.floor(Math.random() * 17 + 9)
      this.map.centerMap(this.position.lat, this.position.lng, zoom)
    },
    showDraggable () {
      var menuFloat = this.getDraggableProperties()
      this.draggable.top = menuFloat.top + 60
      this.draggable.left = -(menuFloat.width + 10)
      this.draggable.show = true
      this.lockDraggable(true)
    },
    onDraggableClose () {
      this.draggable.show = false
      this.lockDraggable(false)
    },
    lockDraggable (lock) {
      console.debug('lockDraggable emit')
      this.$emit('lockDraggable', lock)
    }
  }
}
</script>

<style>
</style>
