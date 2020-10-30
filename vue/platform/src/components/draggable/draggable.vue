<template>
    <div :id="name" v-if="visible" class="draggable--wrapper" :class="{'background': background}">
        <slot/>
    </div>
</template>

<script>
/**
* @vuese
 * @group components/draggable
 * componente draggable
 */
export default {
  name: 'draggable',
  props: {
    // nombre
    name: {
      type: String,
      required: true
    },
    // top
    top: {
      type: Number,
      default: 0
    },
    // derecha
    left: {
      type: Number,
      default: 0
    },
    // ancho
    width: {
      type: Number,
      default: 300
    },
    // alto
    height: {
      type: Number,
      default: 400
    },
    // valor minimo de alto
    minHeight: {
      type: Number,
      default: 0
    },
    // index
    zindex: {
      type: Number,
      default: 2
    },
    // si tendra color de fondo o no
    background: {
      type: Boolean,
      default: true
    }

  },
  data: function () {
    return {
      parentID: this.name,
      visible: true,
      parentHeight: this.height,
      parentMinHeight: this.minHeight,
      parentWidth: this.width,
      isCollapsed: false
    }
  },
  provide () {
    return {
      getParent: () => { return this }
    }
  },
  mounted: function () {
    $(`#${this.name}`).css({
      'top': this.top + 'px',
      'left': this.left + 'px',
      'width': this.width + 'px',
      'max-width': this.width + 'px',
      'z-index': this.zindex
    })

    this.register()
  },
  methods: {
    /**
   * @vuese
   * Collapsa o no el componente.
   */
    collapse () {
      if (this.isCollapsed) {
        this.isCollapsed = false
        $(`#${this.parentID}-content`).show()
        $(`#${this.parentID}-content-fixed`).show()
        $(`#${this.parentID}-bottom`).show()
      } else {
        this.isCollapsed = true
        $(`#${this.parentID}-content`).hide()
        $(`#${this.parentID}-content-fixed`).hide()
        $(`#${this.parentID}-bottom`).hide()
      }
    },
    /**
   * @vuese
   * Muestra o no el componente
   */
    show (value) {
      this.visible = value
    },
    /**
   * @vuese
   * Establece top y left
   */
    setPosition (top, left) {
      $(`#${this.name}`).css({
        'top': top + 'px',
        'left': left + 'px'
      })
    },
    /**
   * @vuese
   * Hace dragable el componente
   */
    register () {
      // Hacer draggable
      $(`#${this.name}`).draggable({
        handle: '.draggable--draggable',
        zIndex: 100,
        containment: 'window'
      })

      $(`#${this.name} .draggable--collapse`).click(function () {
        this.collapse()
      }.bind(this))
    }
  },
  watch: {
    top: function (value) {
      $(`#${this.name}`).css({
        'top': value + 'px'
      })
    },
    left: function (value) {
      $(`#${this.name}`).css({
        'left': value + 'px'
      })
    },
    width: function (value) {
      console.debug('Draggable New Width', value)
      this.parentWidth = value

      $(`#${this.name}`).css({
        'width': this.width + 'px',
        'max-width': this.width + 'px'
      })

      this.$emit('onSizeChanged')
    },
    height (value) {
      console.debug('Draggable New Height', value)
      this.parentHeight = this.height
      this.$emit('onSizeChanged')
    },
    minHeight (value) {
      console.debug('Draggable New MinHeightvc', value)
      this.parentMinHeight = value
      this.$emit('onSizeChanged')
    }
  }
}
</script>

<style>
.draggable--wrapper{
    position: absolute !important;

    /* box-shadow:0 2px 2px 0 rgba(0,0,0,.14),0 3px 1px -2px rgba(0,0,0,.2),0 1px 5px 0 rgba(0,0,0,.12); */

    padding-right: 0px;
    padding-left: 0px;
    padding-bottom: 0px;
    margin-top:0px;
    margin-right: auto;
    margin-left: auto;

    /* display: -webkit-box;
    display: -ms-flexbox;
    display: flex; */
    /* -ms-flex-wrap: wrap; */
}
.draggable--draggable{
    cursor: move;
}
.draggable--collapse{
    cursor: pointer
}

.draggable--wrapper.background{
   background-color: white;
}

</style>
