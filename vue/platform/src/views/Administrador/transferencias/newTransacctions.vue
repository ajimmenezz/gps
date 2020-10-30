<template>
  <div class="row" style="margin-bottom:150px;">
    <div class="col-12">

      <h5 class="float-left" style="font-size:20px; padding-bottom:10px;">
        <b v-if="this.tipo==1">Nueva transferencia</b>
        <b v-if="this.tipo==2">Nueva devolución</b>

      </h5>
    </div>

    <div class="col-12 card" >
      <div class="card-body">
        <div class="row" >
           <div class="col-12">  <p class="text-muted" style="text-align: justify; font-size: 12px; margin-top: 7px;">
             A continuación podrás transferir producto a tus clientes o devolver productos a tus proveedores</p></div>
           <div class="col-12 col-md-4 float-left" style="margin-bottom:15px;"  v-if=" this.$store.state.clientType==2">
                      <div class="form-group">
                        <label for="typeTranf">Tipo de tranferencia</label>
                        <select class="form-control" id="typeTranf" v-model="typeTranf" :valor="typeTranf"  @change="tipoTranf()" required>
                            <option value="">Selecciona</option>

                            <option v-for="tranf in listCatypeTranf" :value="tranf.id" :key="tranf.id">{{tranf.type}}</option>
                        </select>
                      </div>
                    </div>

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
            <b v-if="this.tipo==1">Productos seleccionados a transferir</b>
              <b v-if="this.tipo==2">Productos seleccionados a devolver</b>
          </div>
          <div class="col-12" style="margin-top:15px;">
            <table class="table table-hover header_fijo">
              <thead>
                <tr>
                  <th>Tipo de Producto</th>
                  <th>Marca</th>
                  <th>IMEI/Serie</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(product, index) in products" :key="index">
                  <td>{{product.productType}}</td>
                  <td>{{product.factory}}</td>
                  <td>{{product.id}}</td>
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

           <div class="col-12 float-left" style="padding-top:21px;">
                        <config-input  id="notes" label="Notas"  typeinput="text"  placeholder="Notas" v-model.trim="notas" required="false" :valor="notas"></config-input>
                    </div>

          <div class="col-6 col-lg-5 text-left" >
            <m-select v-if="this.tipo!=2"
            ref="customerSelect"
            :data="customer.customers"
            filterby="name"
            :title="titleCliente"
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
  name: 'NewTransDev',
  mixins: [API],
  components: {
    productSelector,
    mSelect
  },

  created () {
    this.$store.state.loader = true
    this.tipo = this.$route.params.tipo
    if (this.$store.state.clientType == 2) {
      this.catTypeTransfer()
    }
  },
  async mounted () {
    this.$store.state.seccionMenu = 'almacen'
    await EventBus.$emit('NAVBAR_MenuSimple', 'almacen')

    $('#containerPrincipal').css({
      'margin-left': this.$store.state.widthMenu
    })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })

    if (this.$store.state.clientType == 2) {
      this.titleCliente = 'Seleccione cliente'
    }
    if (this.$store.state.clientType == 3) {
      this.titleCliente = 'Seleccione distribuidor'
    }

    if (this.$store.state.clientType != 1) {
      this.getCustomers()
    }
    this.$store.state.loader = false
  },
  data () {
    return {
      currentProductSelectorTab: productSelector,
      products: [],
      customer: {
        customers: [],
        selected: ''
      },
      confirmSaleBtnEnabled: true,
      titleCliente: null,
      notas: null,
      listCatypeTranf: null,
      typeTranf: 1,
      tipo: null
    }
  },
  methods: {
    async catTypeTransfer () {
      this.$store.state.loader = true
      var request = await this.getRequest('catalogs/transfers/types')
      this.listCatypeTranf = request.data.types
      this.$store.state.loader = false
    },
    async getCustomers () {
      this.$store.state.loader = true
      var request = await this.getRequest('accounts')
      this.customer.customers = request.data.customers
      this.$store.state.loader = false
    },
    tipoTranf () {
      if (this.typeTranf == '') {
        notify('', 'Selecciona tipo de tranferencia', 'top', 'right', 'danger')
        return false
      }
      this.tipo = this.typeTranf
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
        // transf
        this.processTransferencia()
      }
    },
    goReturn () {
      this.$router.push(`/transactions/store`)
    },
    validateTransaction () {
      var validTransaction = true

      if (!this.products.length) {
        validTransaction = false
        notify('Error, ', 'Debe seleccionar por lo menos 1 producto', 'top', 'right', 'danger')
      }
      if (this.tipo == 1) {
        if (!this.$refs.customerSelect.selectedItem || this.$refs.customerSelect.selectedItem == -1) {
          validTransaction = false
          notify('Error, ', 'Debe seleccionar el cliente', 'top', 'right', 'danger')
        }
      }

      if (this.typeTranf == '') {
        notify('Errors', 'Selecciona tipo de tranferencia', 'top', 'right', 'danger')
        validTransaction = false
      }

      return validTransaction
    },
    async processTransferencia () {
      this.$store.state.loader = true
      this.confirmSaleBtnEnabled = false

      // Prepare Products Param
      var products = []
      this.products.forEach(product => {
        var p = {
          id: product.productID,
          type: product.productTypeID

        }
        products.push(p)
      })

      // Prepare Params
      var params = {
        transfer: {
          notes: this.notas
        },
        products: products
      }

      if (this.tipo == 1) {
        params.transfer.clientID = this.customer.selected.id
      }

      // Process Transaction

      var request = await this.postRequest('transfers', params)
      console.debug('DATOS', params)
      this.$store.state.loader = false

      if (request.success) {
        if (this.tipo == 1) {
          notify('', 'Transferencia realizada con exito', 'top', 'right', 'success')
        }
        if (this.tipo == 2) {
          notify('', 'Devolución realizada con exito', 'top', 'right', 'success')
        }
        await setTimeout(() => {
          this.goReturn()
        }, 3000)
      } else {
        if (this.tipo == 1) {
          notify('', 'Error al realizar la transferencia', 'top', 'right', 'danger')
        }
        if (this.tipo == 2) {
          notify('', 'Error al realizar la devolución', 'top', 'right', 'danger')
        }
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
