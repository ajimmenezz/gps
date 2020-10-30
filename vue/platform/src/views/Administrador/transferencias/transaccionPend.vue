<template>
  <div class="row" style="margin-bottom:150px;">
    <div class="col-12">
      <h5 class="float-left" style="font-size:20px; padding-bottom:10px;">
        <b v-if="tipo==1">Transferencia pendiente</b>
        <b v-if="tipo==2">Devolución pendiente</b>
      </h5>
    </div>
    <div class="col-12 card" >
      <div class="card-body">

         <div class="row" v-if="getDataTransf">
           <div class="col-12">  <p class="text-muted" style="text-align: justify; font-size: 12px; margin-top: 7px;">
             A continuación podrás consultar y elegir los productos a aceptar y confirmar la transferencia o devolución</p></div>

              <div class="col-12 col-md-4 mb-4">
                  Quién solicita la {{tipoString}}: <br>
              <b>{{getDataTransf.fromClient}}</b>

              </div>
                <div class="col-12 col-md-4 mb-4">
                   Para quién solicita la {{tipoString}}: <br>
                <b>{{getDataTransf.toClient}}</b>

                </div>
                 <div class="col-12 col-md-4 mb-4">
                 Tipo: <br>
                <b>{{getDataTransf.type}}</b>

                </div>

                 <div class="col-12 col-md-4 mb-4">
                 Notas sobre la {{tipoString}}: <br>
                <b>{{getDataTransf.notes}}</b>

                </div>

        </div>
        <!--Products-->
        <div class="row" style="margin-top:40px;" v-if="getDataTransf">
          <div class="col-12 text-left" style="font-size:16px">
            <b>Productos a aceptar</b>
          </div>
          <div class="col-12" style="margin-top:15px;">
            <table class="table table-hover header_fijo">
              <thead>
                <tr>
                  <th>Selecciona</th>
                  <th>Tipo de Producto</th>
                  <th>Marca</th>
                  <th>Modelo</th>
                  <th>IMEI/Serie</th>

                </tr>
              </thead>
              <tbody>
                <tr v-for="(product, index) in  this.productosList" :key="index">
                  <td>
                     <div class=" custom-control custom-checkbox">
                     <input
                        type="checkbox"
                        class="custom-control-input cursor"
                        :id="`Check-${product.productID}`"
                        @change="onCheckedProduct($event,product.productID)"
                      >
                      <label class="custom-control-label" :for="`Check-${product.productID}`"></label>
                      </div>
                  </td>
                  <td>{{product.type}}</td>
                  <td>{{product.factory}}</td>
                  <td v-if="product.typeID!=2">{{product.model}}</td>
                  <td v-else> - </td>
                  <td>{{product.serie}}</td>

                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <!--Process Sale-->
        <div class="row" style="margin-top:50px;">

          <div class="col-12 text-left">
            <config-input  id="notasTrans" label="Comentarios sobre la transacción"  typeinput="text"  placeholder="Comentarios sobre la transacción" v-model.trim="notasTrans" required="false" :valor="notasTrans"></config-input>

          </div>
          <div class="col-12 text-right align-self-end">
            <button type="button" class="btn btn-sm btn-secondary" @click="goReturn">CANCELAR</button>
            <button type="button" class="btn btn-sm btn-primary" @click="confirm" :disabled="!confirmSaleBtnEnabled">CONFIRMAR</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { API } from '@/mixins/API'
import EventBus from '@/EventBus.js'

export default {
  name: 'transfPend',
  mixins: [API],
  components: {
  },
  async mounted () {
    this.$store.state.seccionMenu = 'almacen'
    await EventBus.$emit('NAVBAR_MenuSimple', 'almacen')
    this.$store.state.loader = true
    $('#containerPrincipal').css({
      'margin-left': this.$store.state.widthMenu
    })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })

    this.$store.state.loader = false
    this.tipo = this.$store.state.modal.datosDymanic.tipo
    if (this.tipo == 1) {
      this.tipoString = 'transferencia'
    }
    if (this.tipo == 2) {
      this.tipoString = 'devolución'
    }

    this.getInfotransf()
  },
  data () {
    return {

      productosList: [],
      productsdb: [],
      customer: {
        dataTransf: null,
        selected: ''
      },
      confirmSaleBtnEnabled: true,
      notasTrans: null,
      tipo: null,
      tipoString: ''

    }
  },
  methods: {
    async getInfotransf () {
      this.$store.state.loader = true
      var response = await this.getRequest(`transfers/${this.$store.state.modal.datosDymanic.idTrans}`)

      var clientAllInfo = response.data.transfer

      this.customer.dataTransf = clientAllInfo

      this.productosList = clientAllInfo.products
      console.debug(clientAllInfo)
      this.$store.state.loader = false
    },

    goReturn () {
      this.$router.push('/transactions/store')
    },

    async confirm () {
      this.$store.state.loader = true
      this.confirmSaleBtnEnabled = false

      console.debug('DATOS', this.notasTrans, ' PRODUCTS ', this.productsdb)

      // Prepare Params
      var params = {
        notes: this.notasTrans,
        products: this.productsdb
      }

      // Process Transaction
      var request = await this.putRequest('transfers/' + this.$store.state.modal.datosDymanic.idTrans + '/finalize', params)
      this.$store.state.loader = false

      if (request.success) {
        this.$store.state.loader = false
        notify('', this.tipoString + ' completada con exito', 'top', 'right', 'success')
        await setTimeout(() => {
          this.goReturn()
        }, 3000)
      } else {
        notify('', 'Error al completar la ' + this.tipoString, 'top', 'right', 'danger')
        this.confirmSaleBtnEnabled = true
        this.$store.state.loader = false
      }
    },
    onCheckedProduct (event, id) {
      var status = event.target.checked
      console.debug('STATUS_CHECK', status)
      if (status) {
        this.agregarProduct(id)
      } else {
        this.eliminarProduct(id)
      }
    },
    /**
   * @vuese
   * Agrega contactos a la lista
   */
    async agregarProduct (id) {
      // validar si es un correo
      var prod = this.productosList.find(x => x.productID == id)

      this.productsdb.push({
        'id': prod.productID,
        'type': prod.typeID,
        'state': 2
      })
    },
    /**
   * @vuese
   * Elimina contactos a la lista
   */
    eliminarProduct (id) {
      var search
      var dat = 0
      this.productsdb.filter(function (dato, i) {
        if (dato.id == id) {
          search = i
          dat = dato
          return true
        }
      })

      console.debug('TIPO', dat)

      this.productsdb.splice(search, 1)
    }

  },
  computed: {
    getDataTransf () {
      return this.customer.dataTransf
    }

  }

}
</script>
