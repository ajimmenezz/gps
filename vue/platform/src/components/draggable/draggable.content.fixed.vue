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
  data: function () {
    return {
      parentID: this.$parent.parentID,
      name: this.$parent.parentID + '-content',
      minHeight: this.$parent.parentMinHeight,
      width: this.$parent.parentWidth,
      height: this.$parent.parentHeight
    }
  },
  mounted: function () {
    this.resize()
  },
  methods: {
    resize (height = null) {
      this.minHeight = this.$parent.parentMinHeight
      this.width = this.$parent.parentWidth
      if (height != null) {
        this.height = this.$parent.parentHeight
      } else {
        this.height = height
      }

      console.debug('Draggable Content Resize:', this.width, this.height)

      $(`#${this.name}`).css({
        'width': this.width + 'px',
        'max-width': this.width + 'px',
        'max-height': this.height + 'px',
        'height': this.height + 'px'
      })
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
.scroll-style::-webkit-scrollbar-button {  background-color: #E0E0E0; }
.scroll-style::-webkit-scrollbar-track {  background-color:yellow;}
.scroll-style::-webkit-scrollbar-track-piece { background-color:#E0E0E0;}
.scroll-style::-webkit-scrollbar-thumb { height: 50px; background-color: #757575; border-radius: 3px;}
.scroll-style::-webkit-scrollbar-corner { background-color: green;}
.scroll-style::-webkit-resizer { background-color: #666;}
</style>
