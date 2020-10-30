<template>
<transition name="fade">
<div id="loader" class="wrapper">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
       <p>{{this.message}}</p>
       <div class="spinner-border" style="display:"/>
      </div>
    </div>
  </div>
</div>
</transition>
</template>

<script>
export default {
  name: 'Loader',
  props: {
    message: {
      type: String,
      default: 'Espere por favor'
    }
  }
}
</script>

<style scoped>
#loader.wrapper{
    z-index: 1080;
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: rgba(0,0,0,0.4);
}

.fade-enter-active, .fade-leave-active {
      transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  -webkit-transition: opacity 0.5s ease-out;
  -moz-transition: opacity 0.5s ease-out;
  -o-transition: opacity 0.5s ease-out;
  opacity: 0;
}
</style>
