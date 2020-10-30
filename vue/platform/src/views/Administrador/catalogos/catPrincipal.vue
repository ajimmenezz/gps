<template>
<!-- @vuese card de menu usuarios -->
  <div class=" row">
    <div class="col-12"> <h5 class="float-left" style="font-size: 20px; padding-bottom: 10px;"><b>Catálogos</b></h5></div>

      <!-- <div class="col-12" style="margin-bottom: 15px;">
         <div class="col-5 float-right">
            <config-input id="deviceSearcher" label="null" required="false"
            typeinput="text" placeholder="Buscar"
            @input="filterLista"
            paddingConf="6px 12px" backgroundd="#ffff"></config-input>

          </div>
      </div> -->

      <div class="col-6 col-md-4" >
        <div class="card confCard" >
        <img class="card-img-top imgCard" src="img/cards/store.jpg" alt="Card image cap" >
          <div class="card-body">
              <h5 class="card-title">Kits </h5>
              <p class="card-text" style="text-align: left;">Podrás crear, consultar, editar y eliminar kits.</p>

                <button  type="button" class="btn btn-primary" style="position: absolute; bottom: 5px;" @click="continuar()">CONTINUAR</button>

          </div>
        </div>

      </div> <!-- fin caard -->

  </div>
</template>

<script>
import { API } from '@/mixins/API'
import { Functions } from '@/mixins/Functions.js'
import EventBus from '@/EventBus.js'
/**
* @vuese
 * @group Administrador/almacen
 * menu principal de almacenes
 */
export default {
  name: 'almacenPrincipal',
  mixins: [API, Functions],
  data () {
    return {
      listClient: null,
      listClientOrigin: null

    }
  },
  created () {
    this.getClientes()
  },
  async mounted () {
    this.$store.state.seccionMenu = 'catalogos'
    await EventBus.$emit('NAVBAR_MenuSimple', 'catalogos')
    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })
  },
  methods: {
    /**
   * @vuese
   * Obtiene resultados de coincidencias del string con lista de clientes
   * @arg `searchTerm` String de filtro
   */
    filterLista (searchTerm) {
      var tipo = 'customer'

      this.listClient = this.filterList(this.listClientOrigin, 'name', searchTerm, tipo)
    },
    /**
   * @vuese
   * Obtiene la lsita de clientes
   */
    async getClientes () {
      var request = await this.getRequest('accounts')
      var data = request.data.customers
      console.debug('CLIENTES', data)
      this.listClient = data
      this.listClientOrigin = data
    },
    /**
   * @vuese
   * muestra almacen del distribuidor o de algun cliente
   */
    async continuar () {
      this.$router.push('/ListTableKits')
    }

  },
  computed: {
    /**
   * @vuese
   * Obtiene lista de clientes
   */
    getListClientes: function () {
      return this.listClient
    }
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
