<template>
<div class="container-fluid" style="margin-top:15px; margin-bottom:10px;">
    <div class="row">
        <div class="col-12 text-left">
            <b>TITLE</b>
            <hr>
        </div>
    </div>
    <div class="row" style="max-height:150px; overflow-y:auto;">
        <div class="col-12">
            <button @click="showDraggable()">ShowDrag</button>
        </div>
        <div class="col-12 alert-warning" style="height:900px;">
            Large Content
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Explicabo dolorem maiores delectus reprehenderit sed, non porro repudiandae quaerat provident accusamus doloribus unde aliquid. Praesentium odit mollitia officiis natus laborum corporis?
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
import subTest from '@/views/MapModule 2/MapFloatMenu/test/test.sub.vue'
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
      }
    }
  },
  mounted () {
    this.map = this.getMap()
  },
  methods: {
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
      this.$emit('lockDraggable', lock)
    }
  }
}
</script>

<style>
</style>
