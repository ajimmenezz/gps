<template>
  <div
    id="modal-transactionInfo"
    class="modal fade"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header text-left">
          <h5 style="font-size:20px; padding-bottom:10px;">
            <b>{{transaction.transactionType}}</b>
          </h5>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12 text-left" style="font-size:16px">
              Fecha:
              <b>{{transaction.timestampTransaction * 1000 | moment("LL")}}</b>
            </div>
            <div class="col-12 text-left" style="font-size:16px">
              Cliente:
              <b>{{transaction.toClient}}</b>
            </div>
            <div class="col-12 text-left" style="font-size:16px; margin-top:30px;">
              <b>Productos</b>
            </div>
            <div class="col-12">
              <table class="table table-hover header_fijo">
                <thead>
                  <tr>
                    <th>Tipo de Producto</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Imei/Serie</th>
                    <th>Kit</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(product, index) in transaction.products" :key="index">
                    <td>{{product.productType}}</td>
                    <td>{{product.factory}}</td>
                    <td>{{product.model}}</td>
                    <td>{{product.product}}</td>
                    <td>{{product.kitName}}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="row" style="margin-top:30px;">
            <div class="col-12">
              <hr />
            </div>
            <div class="col-12 text-right">
              <button class="btn btn-primary btn-sm" @click="hide()">CERRAR</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'TransactionInfo',
  props: {
    transaction: {
      required: true
    }
  },
  mounted () {},
  data () {
    return {}
  },
  methods: {
    show () {
      $('#modal-transactionInfo').modal('show')
    },
    hide () {
      $('#modal-transactionInfo').modal('hide')
    }
  }
}
</script>

<style>
</style>
