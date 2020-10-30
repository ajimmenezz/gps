<template>
<!-- @vuese card de menu usuarios -->
  <div class=" row">
    <div class="col-12"> <h5 class="float-left" style="font-size: 20px; padding-bottom: 10px;"><b>Almacenes</b></h5></div>

    <div class="col-12">

      <div class="row">

        <div class="col-11 col-sm-6  col-lg-4" v-if="this.$store.getters.permission(9) || this.$store.getters.permission(10) || this.$store.getters.permission(17)">
          <div class="card confCard" >
          <img class="card-img-top imgCard" src="img/cards/store2.jpg" alt="Card image cap" >
            <div class="card-body">
                <h5 class="card-title">Mi almacén </h5>
                <p class="card-text" style="text-align: left;">Podrás crear, consultar, editar y eliminar la información de productos.</p>

                  <button  type="button" class="btn btn-primary" style="position: absolute; bottom: 5px;" @click="continuar(0)">CONTINUAR</button>

            </div>
          </div>

        </div> <!-- fin caard -->
        <div class="col-11 col-sm-6  col-lg-4"  v-if="this.$store.getters.permission(20)">
          <div class="card confCard" >
          <img class="card-img-top imgCard" src="img/cards/store2.jpg" alt="Card image cap" >
            <div class="card-body">
                <h5 class="card-title">Transferencias</h5>
                <p class="card-text" style="text-align: left;">Podrás crear, consultar, aceptar y rechazar transacciones que tengan que ver con el almacén</p>

                  <button  type="button" class="btn btn-primary" style="position: absolute; bottom: 5px;" @click="transaccion()">CONTINUAR</button>

            </div>
          </div>

        </div> <!-- fin caard -->

      </div>

      <div class="row" v-if="this.$store.state.clientType!=1 && (this.$store.getters.permission(9) || this.$store.getters.permission(10) || this.$store.getters.permission(17))">

        <div class="col-12" style="margin-bottom: 15px;">
          <div class="col-12 col-md-6"> <h5 class="float-left" style="font-size: 20px; padding-bottom: 10px;"><b>Almacenes de clientes</b></h5></div>
          <div class="col-12 col-md-5 float-right">
              <config-input id="deviceSearcher" label="null" required="false"
              typeinput="text" placeholder="Buscar"
              @input="filterLista"
              paddingConf="6px 12px" backgroundd="#ffff"></config-input>

            </div>
        </div>

        <div class="col-11 col-sm-6  col-lg-4" v-for="(cliente,index) in getListClientes" :key="cliente.id">
          <div class="card confCard" >
          <img class="card-img-top imgCard" src="img/cards/store3.jpg" alt="Card image cap" >
            <div class="card-body">
                <h5 class="card-title">{{cliente.name}}</h5>
                <p class="card-text" style="text-align: left;">Podrás crear, consultar, editar y eliminar la información de productos.</p>

                  <button  type="button" class="btn btn-primary" style="position: absolute; bottom: 5px;" @click="continuar(cliente.id,cliente.name)">CONTINUAR</button>

            </div>
          </div>

        </div>  <!-- fin caard -->

      </div>

    </div>

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
    if (this.$store.state.clientType != 1) {
      this.getClientes()
    }
  },
  async mounted () {
    this.$store.state.seccionMenu = 'almacen'
    await EventBus.$emit('NAVBAR_MenuSimple', 'almacen')
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
    async continuar (id, name = 'my') {
      this.$store.commit('CLEAR_MODAL_DINAMIC')
      var datos = {

        'datos': {
          'seccion': 'almacen',
          'idCliente': id,
          'nameClient': name

        }
      }

      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)
      this.$router.push('/dashStore/' + id + '/' + name)
    },
    /**
   * @vuese
   * muestra tabla con transacciones
   */
    transaccion () {
      this.$router.push('/transactions/store')
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
  margin-left:10px;
    margin-right:10px;
}
.imgCard{
   background-size: cover;

    background-position: center;
    height: 200px;
}
</style>
