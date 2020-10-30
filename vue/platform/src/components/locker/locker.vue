<template>
<transition name="fade">
  <div id="locker-small" class="locker--wrapper" :style="{zIndex: zIndex}">
      <div class="locker--background" :style="{zIndex: zIndex}"></div>
  </div>
</transition>
</template>
<script>
/**
* @vuese
* @group componenets/locker
* componente de bloqueo de paneles
 */
export default {
  name: 'locker',
  props: {
    zIndex: {
      type: Number,
      default: 1072
    }
  }
}
</script>
<style>
    #locker-small.locker--wrapper{
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0px;
        left: 0px;
    }

    #locker-small  .locker--background{
        top: 0;
        left: 0;
        width:100%;
        height:100%;
        background: rgba(180,180,180,0.5);
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
