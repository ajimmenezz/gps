<template>
<div class="row">
  <div class="col-12">
    <h5 class="float-left" style="font-size:20px; padding-bottom:10px;">
      <b>Ventas</b>
    </h5>
  </div>
  <div class="col-12 card">
    <div class="card-header row">
        <div class="col-6"></div>
        <div class="col-6 text-right">
          <button type="button" class="btn btn-sm btn-primary" @click="newSale()">NUEVA VENTA</button>
          <button type="button" class="btn btn-sm btn-secondary" @click="goReturn()">REGRESAR</button>
        </div>
    </div>
    <div class="card-body row" style="margin-top:15px;">
      <div class="col-12 text-left" style="font-size:16px"><b>Ventas Realizadas</b></div>
      <div class="col-12" style="margin-top:15px;">
        <table class="table table-hover header_fijo">
          <thead>
            <tr>
              <th>#</th>
              <th>Fecha</th>
              <th>Cliente</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(transaction, index) in transactions" :key="index">
              <td>{{transaction.id}}</td>
              <td>{{transaction.timestampTransaction * 1000 | moment("LL")}}</td>
              <td>{{transaction.toClient}}</td>
              <td>
                <span><i class="icon icon-md universalicon-visible cursor cssToolTipp" @click="getTransactionInfo(transaction.id)"><p style="top: 25px !important; right: -70% !important;">Consultar</p></i></span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <modal-transaction-info ref="modalTransactionInfo" :transaction="transactionSelected"/>
</div>
</template>

<script>
import { API } from '@/mixins/API'
import modalTransactionInfo from '@/views/Administrador/Transactions/modal.transaction.info'
import EventBus from '@/EventBus.js'
export default {
  name: 'Sales',
  mixins: [API],
  components: {
    modalTransactionInfo
  },
  data () {
    return {
      transactions: [],
      transactionSelected: ''
    }
  },
  async mounted () {
    this.$store.state.loader = true
    this.$store.state.seccionMenu = 'operacion'
    await EventBus.$emit('NAVBAR_MenuSimple', 'operacion')
    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })

    this.getSales()
  },
  methods: {
    newSale () {
      this.$router.push(`/transactions/sales/newSale`)
    },
    goReturn () {
      this.$router.push(`/transactions`)
    },
    async getSales () {
      // Obtiene las ventas realizadas y las agrega a la tabla
      this.$store.state.loader = true
      var params = {
        type: 1
      }
      var request = await this.getRequest('transactions', params)
      this.transactions = request.data.transactions
      this.$store.state.loader = false
    },
    async getTransactionInfo (transactionID) {
      console.debug('informacion de la transaccion', transactionID)

      this.$store.state.loader = true
      var request = await this.getRequest(`transactions/${transactionID}`)
      this.transactionSelected = request.data.transaction
      this.$store.state.loader = false

      this.$refs.modalTransactionInfo.show()
      // Obtiene la informacion de la transaccion y la muestra en pantalla
    }
  }
}
</script>

<style>

</style>
