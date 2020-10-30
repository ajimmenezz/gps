<template>
<transition name="fade">
  <div id="loader-small" class="loader--wrapper">
      <div class="loader loader--loader"></div>
      <div class="loader--message">{{message}}</div>
      <div class="loader--background"></div>
  </div>
</transition>
</template>
<script>
/**
* @vuese
* @group componenets/loader
* componente de cargando
 */
export default {
  name: 'LoaderSmall',
  props: {
    message: {
      type: String,
      default: 'Espere por favor'
    }
  }
}
</script>
<style>
    #loader-small.loader--wrapper{
        z-index: 1072;
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0px;
        left: 0px;
    }

    #loader-small .loader{
      font-size: 10px !important;
      width: 0.5em !important;
      height: 0.5em !important;
    }

    #loader-small  .loader--background{
        z-index: 1072;
        top: 0;
        left: 0;
        width:100%;
        height:100%;
        background: rgba(0,0,0,0.4);
    }

    #loader-small .loader--loader{
        margin: auto !important;
        position: absolute !important;
        z-index: 1074;
        top: 45% !important;
        left: 45% !important;
    }

    #loader-small .loader--message{
        margin: auto !important;
        position: absolute !important;
        z-index: 1074;
        top: 70% !important;
        color: white;
        font-size: 1.5rem;
        width: 100%;
        padding-left: 20px;
        padding-right: 20px;
        white-space: nowrap;
        overflow: hidden;
        text-align: center;
        text-overflow: ellipsis;
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
