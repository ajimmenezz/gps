<template>
  <div class="row" style="margin-bottom:150px;">
    <div class="col-12">
      <h5 class="float-left" style="font-size:20px; padding-bottom:10px;">
        <b>Nueva Venta</b>
      </h5>
    </div>
    <div class="col-12 card" style="margin-top:40px;">
      <div class="card-body">
        <div class="row" >
          <div class="col-12 text-left">
           <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active cursor" data-toggle="tab" role="tab" aria-selected="true"
                @click="showProductSelector()">Agregar Producto
                </a>
              </li>
              <!-- <li class="nav-item">
                <a class="nav-link cursor" data-toggle="tab" role="tab" aria-selected="false"
                @click="showKitSelector()">Agregar Kit</a>
              </li> -->
            </ul>
          </div>
          <div class="col-12" style="border: solid 1px lightgrey; padding:10px;">
            <component v-bind:is="currentProductSelectorTab" @OnProductSelected="OnProductSelected" @OnProductsSelected="OnProductsSelected"></component>
          </div>
        </div>

        <!--Products-->
        <div class="row" style="margin-top:70px;">
          <div class="col-12 text-left" style="font-size:16px">
            <b>Productos seleccionados</b>
          </div>
          <div class="col-12" style="margin-top:15px;">
            <table class="table table-hover header_fijo">
              <thead>
                <tr>
                  <th>Tipo de Producto</th>
                  <th>Marca</th>
                  <th>IMEI/Serie</th>
                  <th>KIT</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(product, index) in products" :key="index">
                  <td>{{product.productType}}</td>
                  <td>{{product.factory}}</td>
                  <td>{{product.id}}</td>
                  <td>{{product.kit}}</td>
                  <td>
                    <span>
                      <i
                        class="icon icon-md universalicon-trash-2 colorText-red cursor"
                        @click="removeProduct(product.productTypeID, product.id)"
                      ></i>
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <!--Process Sale-->
        <div class="row" style="margin-top:50px;">
          <div class="col-12">
            <hr>
          </div>
          <div class="col-6 col-lg-5 text-left">
            <m-select
            ref="customerSelect"
            :data="customer.customers"
            filterby="name"
            title="Seleccione cliente"
            @selectionChanged="OnCustomerSelected"/>
          </div>
          <div class="col-6 col-lg-7 text-right align-self-end">
            <button type="button" class="btn btn-sm btn-secondary" @click="goReturn">CANCELAR</button>
            <button type="button" class="btn btn-sm btn-primary" @click="confirmSale" :disabled="!confirmSaleBtnEnabled">CONFIRMAR</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { API } from '@/mixins/API'
import mSelect from '@/components/basico/m.select.vue'
import productSelector from '@/views/Administrador/Transactions/Sales/productSelector.vue'
import EventBus from '@/EventBus.js'

export default {
  name: 'NewSale',
  mixins: [API],
  components: {
    productSelector,
    mSelect
  },
  async mounted () {
    this.$store.state.seccionMenu = 'operacion'
    await EventBus.$emit('NAVBAR_MenuSimple', 'operacion')
    this.$store.state.loader = true
    $('#containerPrincipal').css({
      'margin-left': this.$store.state.widthMenu
    })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })

    this.$store.state.loader = false

    this.getCustomers()
  },
  data () {
    return {
      currentProductSelectorTab: productSelector,
      products: [],
      customer: {
        customers: [],
        selected: ''
      },
      confirmSaleBtnEnabled: true
    }
  },
  methods: {
    async getCustomers () {
      this.$store.state.loader = true
      var request = await this.getRequest('accounts')
      this.customer.customers = request.data.customers
      this.$store.state.loader = false
    },
    showProductSelector () {
      this.currentProductSelectorTab = productSelector
    },
    showKitSelector () {
      this.currentProductSelectorTab = null
    },
    OnProductSelected (product) {
      console.debug('ProductSelected', product)
      this.addProduct(product)
    },
    OnProductsSelected (products) {
      products.forEach(product => {
        this.addProduct(product)
      })
    },
    OnCustomerSelected (customer) {
      this.customer.selected = customer
    },
    addProduct (product) {
      var index = this.products.findIndex((i) => {
        return i.id == product.id && i.productTypeID == product.productTypeID
      })

      if (index == -1) {
        this.products.push(product)
      } else {
        notify('', 'El producto ya se encuentra agregado', 'top', 'right', 'danger')
      }
    },
    removeProduct (productTypeID, productID) {
      var index = this.products.findIndex((i) => {
        return i.id == productID && i.productTypeID == productTypeID
      })

      if (index > -1) { this.products.splice(index, 1) }
    },
    confirmSale () {
      // TODO: SI contiene kits verificar que estan completos
      if (this.validateTransaction()) {
        this.processTransaction()
      }
    },
    goReturn () {
      this.$router.push(`/transactions/sales`)
    },
    validateTransaction () {
      var validTransaction = true

      if (!this.products.length) {
        validTransaction = false
        notify('Error, ', 'Debe seleccionar por lo menos 1 producto', 'top', 'right', 'danger')
      } else if (!this.$refs.customerSelect.selectedItem || this.$refs.customerSelect.selectedItem == -1) {
        validTransaction = false
        notify('Error, ', 'Debe seleccionar el cliente', 'top', 'right', 'danger')
      }

      return validTransaction
    },
    async processTransaction () {
      this.$store.state.loader = true
      this.confirmSaleBtnEnabled = false

      // Prepare Products Param
      var products = []
      this.products.forEach(product => {
        var p = {
          id: product.productID,
          type: product.productTypeID,
          kitID: product.kitID
        }
        products.push(p)
      })

      // Prepare Params
      var params = {
        transaction: {
          clientID: this.customer.selected.id,
          transactionType: 1
        },
        products: products
      }

      // Process Transaction
      var request = await this.postRequest('transactions', params)
      this.$store.state.loader = false

      if (request.success) {
        notify('', 'Transaccion realizada con exito', 'top', 'rigth', 'success')
        await setTimeout(() => {
          this.goReturn()
        }, 3000)
      } else {
        notify('', 'Error al realizar la transaccion', 'top', 'right', 'danger')
        this.confirmSaleBtnEnabled = true
      }
    }

  }

}
</script>

<style scoped>
.nav-item .active{
  background-color: #04a9f5 !important;
  color:white !important;
}
</style>
