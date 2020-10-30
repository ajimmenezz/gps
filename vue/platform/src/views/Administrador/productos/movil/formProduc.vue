<template>
          <!-- MODAL -->

    <div class="row">

               <form @submit.prevent >
              <div class="col-12" >

                 <p v-if="this.$store.state.modal.datosDymanic.idCliente != 0 && this.accion=='nuevo'" class="text-muted">El producto se agregará en el almacén del cliente: <b>{{this.$store.state.modal.datosDymanic.nameClient}}</b></p>
                <p v-if="this.$store.state.modal.datosDymanic.idCliente == 0 && this.accion=='nuevo'">El producto se agregará en tú almacén</p>

                  <div class="row">

                    <div class="col-12 col-md-4">
                      <div class="form-group">
                        <label for="marca">Marca</label>
                        <select class="form-control" id="marca" v-model="marca" :valor="marca"  @change="modelProduct()" required>
                            <option value="">Selecciona</option>
                            <option v-for="factory in listFactories" :value="factory.id" :key="factory.id">{{factory.name}}</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-12 col-md-4">
                      <div class="form-group">
                        <label for="model">Modelo</label>
                        <select class="form-control" id="model" v-model="model" :valor="model" required>
                            <option value="">Selecciona</option>
                            <option v-for="model in listmodels" :value="model.id" :key="model.id">{{model.name}}</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <config-input  id="serial" label="Serial"  typeinput="text"  placeholder="Serial" v-model.trim="serial" required="true" :valor="serial" v-if="this.accion=='nuevo'"></config-input>
                        <config-input  id="serial" label="Serial"  typeinput="text"  placeholder="Serial" v-model.trim="serial" required="true" :valor="serial"  v-if="this.accion=='editar'"></config-input>
                    </div>

                    <!-- <div class="col-12 col-md-4">
                      <div class="form-group">
                        <label for="model">Estado</label>
                        <select class="form-control" id="model" v-model="statusP" :valor="statusP" required>
                            <option value="">Selecciona</option>
                            <option v-for="state in listStatusP" :value="state.id" :key="state.id">{{state.state}}</option>
                        </select>
                      </div>
                    </div> -->

                    <div class="col-12 ">
                        <config-input  id="desc" label="Descripción"  typeinput="text"  placeholder="Descripción" v-model.trim="notas" required="false" :valor="notas"></config-input>
                    </div>

                  </div>

                  <div class="row"><div class="col-12" id="alertAdminProducts"></div></div>

              </div> <!-- fin card body -->
              <div class="col-12 ">
                   <button class="btn btn-secondary shadow-2 mb-4 float-left" @click="cancel()" >CANCELAR</button>
                    <button id="btnRegistrar" class="btn btn-primary shadow-2 mb-4 float-right" @click="SendForm()" type="submit" v-if="this.$store.state.modal.datosDymanic.accion === 'nuevo'" >REGISTRAR</button>
                    <button id="btnEnditar" class="btn btn-primary shadow-2 mb-4 float-right" @click="SendForm()" type="submit" v-if="this.$store.state.modal.datosDymanic.accion === 'editar' && this.$store.state.StoreCliente==0" >EDITAR</button>

              </div>
              </form>

    </div>

    <!-- fin modal -->
</template>

<script>
import { API } from '@/mixins/API'
import EventBus from '@/EventBus'
/**
* @vuese
 * @group Administrador/Distribuidor
 * Modal para registrar producto generico
 */
export default {
  name: 'ModalFormProductosG',
  mixins: [API],
  data () {
    return {
      listStatusP: [],
      statusP: 1,
      serial: null,
      marca: '',
      model: '',
      notas: null,
      listFactories: [],
      listmodels: [],

      model2: null,
      accion: this.$store.state.modal.datosDymanic.accion

    }
  },
  async created () {
    this.$store.state.loader = true
    this.factories()
    this.statusProduct()
    console.debug('ACCION', this.accion)
    if (this.accion == 'editar') {
      this.getRPoductInfo()
    }
  },
  async mounted () {
    this.$store.state.loader = false
    // $('#modalAdminForm').modal('show')
    if (this.marca != null) {
      this.modelProduct()
    }
  },
  destroyed () {

  },
  methods: {
    /**
   * @vuese
   * Obtiene catalogo de marcas de prodcutos
   */
    async factories () {
      var datos = {
        'productType': 3
      }
      var request = await this.getRequest('catalogs/products/factories', datos)

      if (request.success === true) {
        this.listFactories = request.data.factories
      }
    },
    /**
   * @vuese
   * Obtiene catalogo de modelos segun la marca
   */
    async modelProduct () {
      if (this.marca == null) {
        this.marca = null
      }

      if (this.model2 != null) {
        console.debug('MODEL2', this.model2, this.marca)
        if (this.model2 != this.marca) {
          this.model = ''
        }
      }

      var datos = {
        'productType': 3
      }

      console.debug('entra modelo', this.marca)
      var request = await this.getRequest('catalogs/products/factories/' + this.marca + '/models', datos)
      console.debug('RESP', request)
      if (request.success === true) {
        this.listmodels = request.data.models
      }
    },
    /**
   * @vuese
   * obtiene el estatus de producto
   */
    async statusProduct () {
      var request = await this.getRequest('catalogs/products/states')
      console.debug('RESP', request)
      if (request.success === true) {
        this.listStatusP = request.data.states
      }
    },
    /**
   * @vuese
   * obtiene datos de gps
   */
    async getRPoductInfo () {
      var response = await this.getRequest(`products/generic/${this.$store.state.modal.datosDymanic.id}`)
      var info = response.data.product
      console.debug(info)
      this.marca = info.factoryID
      this.model = info.modelID
      this.serial = info.serial
      this.notas = info.notes
      this.statusP = info.productStatusID

      await this.modelProduct()
    },
    /**
   * @vuese
   * Envia datos y registra un producto
   */
    async SendForm () {
      if (this.marca != '' && this.model != '' && this.serial != null) {
        this.$store.state.loader = true
        $('#btnRegistrar').attr('disabled', 'disabled')
        $('#btnEnditar').attr('disabled', 'disabled')
        if (this.accion == 'nuevo') {
          var product = {
            'model': this.model,
            'productStatus': this.statusP,
            'notes': this.notas,
            'serial': this.serial
          }

          console.debug('this.$store.state.modal.datosDymanic.idCliente', this.$store.state.modal.datosDymanic.idCliente)
          if (this.$store.state.modal.datosDymanic.idCliente != 0) {
            product.clientID = this.$store.state.modal.datosDymanic.idCliente
          }

          var datos = {}

          datos['product'] = product

          console.debug('DATOS', datos)

          var request = await this.postRequest('products/generic', datos)

          if (request.success === true) {
            this.$store.state.loader = false
            $('#alertAdminProducts').html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha registrado el producto<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
            setTimeout(() => {
              $('#alertAdminProducts').html('')
              // this.cancel()
              EventBus.$emit('GET_Graficas', 1)
              $('#btnRegistrar').removeAttr('disabled')
            }, 3000)
          } else {
            this.$store.state.loader = false

            $('#btnRegistrar').removeAttr('disabled')
            $('#alertAdminProducts').html(`<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se ha registrado el producto<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>`)
          }

          // this.model = ''
          // this.marca = ''
          // this.imei = null
        }
        if (this.accion == 'editar') {
          var product = {
            'model': this.model,
            'productStatus': this.statusP,
            'notes': this.notas,
            'serial': this.serial
          }

          var datos = {}

          datos['product'] = product

          console.debug('DATOS EDIT', datos)

          this.$store.state.loader = true

          var request = await this.putRequest('products/generic/' + this.$store.state.modal.datosDymanic.id, datos)

          if (request.success === true) {
            this.$store.state.loader = false

            $('#alertAdminProducts').html(`<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha actualizado el producto<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>`)
            setTimeout(() => {
              $('#alertAdminProducts').html('')
              this.cancel()
            }, 3000)
          } else {
            this.$store.state.loader = false
            $('#btnEnditar').removeAttr('disabled')
            var message = ''
            switch (request.error.title) {
              case 'SERIAL_EXISTS':
                message = 'El serial ya existe'
                break
              case 'UNAUTHORIZED':
                message = 'No cuenta con los permisos para realizar la accion'
                break
              default:
                message = 'No se ha actualizado el producto'
                break
            }
            $('#alertAdminProducts').html(`<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>${message}<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>`)
          }
        }
        this.serial = null
        this.notas = null
      }
    },
    cancel () {
      this.$store.commit('CLEAR_MODAL_DINAMIC')
      EventBus.$emit('GET_LIST_products', 1)
      EventBus.$emit('GET_Graficas', 1)
      this.$router.push('/dashStore/' + this.$store.state.StoreCliente + '/' + this.$store.state.StoreNameCliente)

      $('#modalAdminForm').modal('hide')
    }

  },
  computed: {
    messageInfo () {
      return this.messageInfoImei
    },
    getMarca () {
      return this.marca
    }
  }
}
</script>
