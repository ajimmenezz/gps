<template>
<!-- @vuese card de menu usuarios -->
  <div class=" row">
    <div class="col-12"> <h5 class="float-left" style="font-size: 20px; padding-bottom: 10px;"><b>Usuarios</b></h5></div>

      <div class="col-6 col-md-4">
        <div class="card confCard" >
        <img class="card-img-top imgCard" src="img/cards/user3.jpg" alt="Card image cap" >
          <div class="card-body">
              <h5 class="card-title">Usuarios</h5>
              <p class="card-text" style="text-align: left;">Podrás crear, consultar, editar y eliminar la información de los usuarios, así como agregarle y quitarle permisos a los mismos.</p>
              <router-link to="/listUser"  >
                <button  type="button" class="btn btn-primary" style="position: absolute; bottom: 5px;">CONTINUAR</button>
              </router-link>

          </div>
        </div>

      </div>

  </div>
</template>

<script>
import EventBus from '@/EventBus.js'
/**
* @vuese
 * @group Usuarios
 * menu principal de usuarios
 */
export default {
  name: 'MenuPrincipalUsuarios',
  data () {
    return {

    }
  },
  created () {

  },
  async mounted () {
    this.$store.state.submenuActive = 'config'
    this.$store.state.itemSubmenuActive = 'itemUser'
    await EventBus.$emit('NAVBAR_MenuOpciones', 'config', 'itemUser')
    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })
  },
  methods: {

  },
  computed: {

  }
}
</script>

<style>
.confCard{
  width:300px;
  height: 400px;

}
.imgCard{
   background-size: cover;

    background-position: center;
    height: 200px;
}
</style>
