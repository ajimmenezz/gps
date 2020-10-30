<template>
  <div class=" row">

   <div class="col-12">DASHBOARD</div>

  </div>
</template>

<script>
import { functions } from '@/mixins/Functions'
/**
 * @vuese
 * @group Administrador/Dashboard
 * pantalla principal, administrador
 */
export default {
  name: 'DashboardAdmin',
  mixins: { functions },
  data () {
    return {

    }
  },
  created () {

  },
  mounted () {
    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })
    this.$store.state.seccionMenu = 'Dashboard'
    this.$store.state.itemSubmenuActive = null
    this.selectMenuSimple(this.$store.state.seccionMenu)
  },
  methods: {

  },
  computed: {

  }
}
</script>

<style>

</style>
