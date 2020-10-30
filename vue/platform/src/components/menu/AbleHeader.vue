<template>
    <header class="navbar pcoded-header navbar-expand-lg navbar-light" >
        <div class="m-header">
            <a class="mobile-menu " id="mobile-collapse1"  @click="toggleCollapseMenu('navPrincipal','mobile-collapse1')" style="z-index:9999;"><span></span></a>
            <a href="javascript:;" class="b-brand">
               <div class="b-bg" style="background:linear-gradient(-135deg, #ffffff 0%, #ffffff 100%); !important" >
                   <!-- <i class="feather icon-trending-up"></i> -->
                   <img class="img-fluid"   :src="`${logoGet}isotipo.png`">
                   <!-- <span>
                      <i class=" text-muted scursor icon-small universalicon-user"></i>
                    </span> -->
               </div>
                <div class="cssToolTipp">
                     <p style="top: 50px; left: 70px; position:fixed; width: 250px;" >Usuario: {{this.sessionGet('user')}}  <br> Cuenta: {{this.sessionGet('client')}} <br>Tipo: {{this.$store.state.typeUserMenu}}</p>
                 <span class="b-title float-right" style="font-size: 15px; ">{{this.sessionGet('user')}} </span>

        </div>

           </a>
        </div>
        <a class="mobile-menu" id="mobile-header" >
            <i class="feather icon-more-horizontal"></i>
        </a>

    </header>
</template>

<script>
import { SecureStorage } from '@/mixins/SecureStorage.js'
import EventBus from '@/EventBus'
import { Functions } from '@/mixins/Functions.js'
/**
* @vuese
* @group componenets/menu
* menu head (panel superior)
 */
export default {
  name: 'ableHeader',
  mixins: [SecureStorage, Functions],
  data () {
    return {
      Getlogo: localStorage.getItem('imgLogo')
    }
  },
  created () {
    this.suscribeToDeviceEvents()
  },
  beforeDestroy () {
    this.unsuscribreToDeviceEvents()
  },
  methods: {
    /**
   * @vuese
   * se suscribe a eventos eventBus para actulizar el listado de gps
   */
    suscribeToDeviceEvents () {
      EventBus.$on('cambioLogo_header', (data) => {
        this.Getlogo = data
      })
    },
    /**
   * @vuese
   * Se destruye la suscripcion al eventBus
   */
    unsuscribreToDeviceEvents () {
      EventBus.$off('cambioLogo_header')
    },
    /**
   * @vuese
   * Cuando collapsa menu
   * @arg `elementID` id de elemento padre
   * @arg `elementIdOrigin` id elemento de opcion de menu
   */
    toggleCollapseMenu (elementID, elementIdOrigin) {
      $(`#${elementID}`).toggleClass('mob-open')
      $(`#${elementIdOrigin}`).toggleClass('on')
    }

  },
  computed: {

    logoGet () {
      return this.Getlogo
    }

  }
}
</script>

<style>

</style>
