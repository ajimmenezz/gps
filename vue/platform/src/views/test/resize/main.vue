<template>
  <div id="map-module">
        <google-maps name="map" ref="map"
        :lat="18.9240744" :lng ="-99.2252484" :zoom="5"
        :height="map.height"
        :width="map.width"/>

        <draggable
        :name="draggable.name"
        :top="draggable.top"
        :left="draggable.left"
        :width="draggable.width"
        :height="draggable.height"
        :zindex="draggable.index"
        v-if="draggable.show">
            <draggable-header>
                <div class="continer-fluid alert-success">
                    <div class="col-12 draggable--draggable move"
                    style="height:100px;">
                        Header
                    </div>
                </div>
            </draggable-header>
            <draggable-content>
                <div class="container-fluid">
                    <div class="row alert-warning">
                        <div class="col-12 " style="height:5000px;">
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Placeat accusantium ratione magnam blanditiis ipsa, odio sapiente praesentium veritatis quae molestias quis id accusamus, tempora, deleniti iure ab saepe eveniet. Consectetur?
                        </div>
                        <div class="col-12">
                            END
                        </div>
                    </div>
                </div>
            </draggable-content>
            <draggable-bottom>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 alert-danger"
                        style="height:50px;">
                            Footer
                            <button class="btn btn-primary icon" @click="draggable.show = !draggable.show">Show Draggable</button>
                        </div>
                    </div>
                </div>
            </draggable-bottom>
        </draggable>

        <div style="position: absolute !important; left:20px; top:80px;">
            <button class="btn btn-large btn-primary" @click="draggable.show = !draggable.show">Show Draggable</button>
        </div>
  </div>
</template>

<script>
import googleMaps from '@/components/google/google.maps'
import { draggable, draggableHeader, draggableContent, draggableBottom } from '@/components/draggable/'

export default {
  components: {
    googleMaps,
    draggable,
    draggableHeader,
    draggableContent,
    draggableBottom
  },
  data () {
    return {
      map: {
        width: 0,
        height: 0
      },
      draggable: {
        name: 'FloatMenu',
        top: 0,
        left: 0,
        width: 300,
        height: 100,
        index: 99,
        show: false
      }
    }
  },
  created () {
    this.onWindowResize()
  },
  mounted () {
    $(window).resize(this.onWindowResize)
  },
  methods: {
    onWindowResize () {
      this.resizeMap()
      this.resizeDraggable()
    },
    resizeDraggable () {
      var draggableHeaderHeight = 50
      var draggableBottomHeigth = 0

      this.draggable.width = $(window).width()
      this.draggable.height = $(window).height() - (draggableHeaderHeight + draggableBottomHeigth)
    },
    resizeMap () {
      var top = 0
      if (this.$store.state.typeDevice.mobileOrTable) {
        top = 70
      }
      this.map.height = $(window).height() - top
      this.map.width = $(window).width()

      console.debug(`MapResize `, this.map.height, this.map.width)
    }
  }
}
</script>

<style>

</style>
