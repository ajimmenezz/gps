<template>
  <div class="alert-danger" id="vw-container"
  :style="{ height: container.height+'px', minheight: container.height+'px', minWidth: container.width+'px'}">
      Lorem, ipsum dolor sit amet consectetur adipisicing elit.
       Quas quis quibusdam modi commodi autem iste,
        reprehenderit at corrupti rem hic magni nesciunt
        assumenda obcaecati ad. Architecto quae
        quis placeat maiores.

        <br><br>
        <h4>{{container.height}}x{{container.width}}</h4>
  </div>
</template>

<script>
export default {
  data () {
    return {
      container: {
        height: 100,
        width: 100
      }
    }
  },
  created () {
    this.onWindowResize()
  },
  mounted () {
    console.debug('Mounted')
    $(window).resize(this.onWindowResize)
  },
  methods: {
    onWindowResize () {
      console.debug('OnWindowResize')
      var height = $(window).height()
      var width = $(window).width()
      console.debug('viewport ', height, width)

      this.container.width = width
      this.container.height = height
    }
  }

}
</script>

<style>

</style>
