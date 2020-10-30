<template>
    <div :id="name" class="draggable--content scroll-style">
        <slot/>
    </div>
</template>

<script>
/**
* @vuese
 * @group components/draggable
 * componente draggable-content
 */
export default {
  name: 'draggable-content',
  inject: [
    'getParent'
  ],
  data: function () {
    return {
      parentID: this.$parent.parentID,
      name: this.$parent.parentID + '-content',
      minHeight: this.$parent.parentMinHeight,
      width: this.$parent.parentWidth,
      height: this.$parent.parentHeight,
      color: this.$parent.color
    }
  },
  mounted: function () {
    var parent = this.getParent()
    parent.$on('onSizeChanged', this.resize)

    this.resize()
    $(window).resize(this.resize)
  },
  beforeDestroy () {
    var parent = this.getParent()
    parent.$off('onSizeChanged')
  },
  methods: {
    resize () {
      this.minHeight = this.$parent.parentMinHeight
      this.width = this.$parent.parentWidth
      this.height = this.$parent.parentHeight
      this.color = this.$parent.color

      console.debug('Draggable-Content Resize', this.width, this.height)

      $(`#${this.name}`).css({
        'width': this.width + 'px',
        'max-width': this.width + 'px',
        'max-height': this.height + 'px',
        'color': this.color + ';'
      })

      if (this.minHeight > 0) {
        $(`#${this.name}`).css({
          'height': this.minHeight + 'px'
        })
      }
    }
  }
}
</script>

<style>
.draggable--content{
    /* padding-right: 10px;
    padding-left: 10px;
    padding-bottom: 10px; */
    overflow-y:auto;
}
.scroll-style::-webkit-scrollbar { width: 8px; height: 3px;}
/* .scroll-style::-webkit-scrollbar-button {  background-color: #E0E0E0; }  espacio superior e inferior barras*/
.scroll-style::-webkit-scrollbar-track {  background-color:yellow;}
.scroll-style::-webkit-scrollbar-track-piece { background-color:#E0E0E0;}
.scroll-style::-webkit-scrollbar-thumb { height: 50px; background-color: #757575; border-radius: 3px;}
/* .scroll-style::-webkit-scrollbar-corner { background-color: green;}  union*/
.scroll-style::-webkit-resizer { background-color: #666;}
</style>
