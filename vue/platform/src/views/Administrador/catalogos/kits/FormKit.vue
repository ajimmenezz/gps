<template>
          <!-- MODAL -->

    <div id="modalAdminKits" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog  modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalCenterTitle" v-if="this.accion=='nuevo'">Nuevo kit</h5>
                  <h5 class="modal-title" id="exampleModalCenterTitle" v-if="this.accion=='editar'">Editar kit</h5>

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>

              <div class="modal-body float-left" >

                  <div class="row">

                    <div class="col-12 col-md-6">
                        <config-input  id="nameKit" label="Nombre"  typeinput="text"  placeholder="Nombre" v-model.trim="nameKit" required="true" :valor="nameKit"></config-input>
                    </div>
                    <div class="col-12 col-md-6">
                        <config-input  id="notas" label="Notas"  typeinput="text"  placeholder="Notas" v-model.trim="notasKit" required="false" :valor="notasKit"></config-input>
                    </div>

                     <div class="col-12" >
                        <h5 class="float-left">Agregar productos</h5>
                        <hr style="margin-top: 2rem;">
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="exampleFormControlSelect2">Tipo Producto</label>
                            <select class="form-control" id="exampleFormControlSelect2" v-model="tipoProduct" @change="catMarcas()" required>
                                <option value=0>Ninguno</option>
                                <option value=1>Gps</option>
                                <option value=2>Sim</option>
                                <option value=3>Producto genérico</option>

                            </select>
                        </div>
                    </div>

                    <div class="col-12">
                      <div class="row float-left">
                          <!-- select para gps, sims y producto generico-->
                          <div class="col-12 col-md-4" v-if="tipoProduct!=0">
                              <div class="form-group">
                                  <label for="exampleFormControlSelect2">{{marca}}</label>
                                  <select class="form-control" id="exampleFormControlSelect2" v-model="marcaProduct" :valor="marcaProduct"   @change="cat_model()" >
                                      <option value=null>Ninguno</option>
                                     <option  v-for="factory in listMarcas" :value="factory.id" :key="factory.id">{{factory.name}}</option>

                                  </select>

                              </div>
                          </div>

                          <div class="col-12 col-md-4" v-if="tipoProduct!=0">
                              <div class="form-group">
                                  <label for="exampleFormControlSelect2">{{modelo}}</label>
                                  <select class="form-control" id="exampleFormControlSelect2" v-model="modeloProduct" :valor="modeloProduct" v-if="tipoProduct==1">
                                      <option value=null>Ninguno</option>
                                       <option v-for="model in getlistModel" :value="model.id" :key="model.id">{{model.model}}</option>

                                  </select>
                                    <select class="form-control" id="exampleFormControlSelect2" v-model="modeloProduct" :valor="modeloProduct" v-if="tipoProduct==3">
                                      <option value=null>Ninguno</option>
                                       <option v-for="model in getlistModel" :value="model.id" :key="model.id">{{model.name}}</option>

                                  </select>
                                  <select class="form-control" id="exampleFormControlSelect2" v-model="modeloProduct" :valor="modeloProduct" v-if="tipoProduct==2">
                                     <option v-for="plan in getlistModel" :value="plan.id" :key="plan.id">{{plan.name}}</option>

                                  </select>
                              </div>
                          </div>

                          <div class="col-10 col-md-3" v-if="tipoProduct!=0">
                              <config-input  id="Cantidad" label="Cantidad"  typeinput="number"  placeholder="Cantidad" v-model.trim="cantidadKit" required="true" :valor="cantidadKit"></config-input>
                          </div>
                          <!-- fin select para gps, sims y productos-->

                          <div class="col-2 col-md-1" style="padding-left: 0px;" v-if="tipoProduct!=0">
                              <button id="agregarProducts" type="button" class="btn btn-icon btn-primary" @click="agregarProducts()" style="height: 35px; padding-top:8px; margin-top: 32px;">
                                  <i class="feather icon-plus"></i>
                              </button>
                          </div>

                          <div class="col-12" style="margin-top: 20px" v-if="tipoProduct!=0 || this.accion=='editar'">
                              <div class="row"  >
                                  <div class="col-12" >
                                      <h5 class="float-left">Lista de productos que contiene el kit</h5>
                                      <!-- <hr style="margin-top: 2rem;"> -->
                                  </div>
                                  <!-- <div class="col-12" v-if="listProductosKit.length>0" style="overflow: auto;  height: 100px;">
                                      <div class="row" v-for="item in listProductosKit" :key="item.id">
                                          <div class="col-10"><b v-if="item.productType==1">Gps</b><b v-if="item.productType==2">Sim</b><b v-if="item.productType==3">Producto</b>
                                           &nbsp;&nbsp;&nbsp;<b>  tipo: </b>{{item.marcaString}} - {{item.modeloString}}&nbsp;&nbsp;&nbsp;<b>Cantidad: </b>{{item.quantity}}</div>
                                          <div class="col-2"><span @click="eliminarProduct(item.id)"><i class="cursor icon-small icon universalicon-trash-2 colorText-red"></i></span></div>
                                      </div>

                                  </div> -->

                                   <div class="col-12" style="margin-top:15px; overflow: auto;  max-height: 300px;" v-if="listProductosKit.length>0">
                                    <table class="table table-hover header_fijo">
                                      <thead>
                                        <tr>
                                          <th>#</th>
                                          <th>Producto</th>
                                          <th>Tipo</th>
                                          <th>Cantidad</th>
                                          <th>Acciones</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <tr v-for="(product, index) in listProductosKit" :key="index">
                                           <td>{{index+1}}</td>
                                          <td v-if="product.productType==1">GPS</td>
                                          <td v-if="product.productType==2">SIM</td>
                                          <td v-if="product.productType==3">GENÉRICO</td>
                                          <td>{{product.marcaString}}-{{product.modeloString}}</td>
                                          <td>{{product.quantity}}</td>
                                          <td>
                                            <span @click="eliminarProduct(product.id)"><i class="cursor icon-small icon universalicon-trash-2 colorText-red"></i></span>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>

                                  <div class="col-12" v-if="listProductosKit.length==0">
                                    Sin productos
                                  </div>

                              </div>
                          </div>
                      </div>
                    </div>

                  </div>

                  <div class="row"><div class="col-12" id="alertAdminKits" style="margin-top: 35px;"></div></div>

              </div> <!-- fin card body -->
              <div class="modal-footer ">
                   <button class="btn btn-secondary shadow-2 mb-4 float-left"@click="cancel()" >CANCELAR</button>
                    <button id="btnRegistrar" class="btn btn-primary shadow-2 mb-4 float-right" @click="SendForm()" type="submit" v-if="this.$store.state.modal.datosDymanic.accion === 'nuevo'" >REGISTRAR</button>
                    <button id="btnEnditar" class="btn btn-primary shadow-2 mb-4 float-right" @click="SendForm()" type="submit" v-if="this.$store.state.modal.datosDymanic.accion === 'editar'" >EDITAR</button>

              </div>

          </div>
      </div>
    </div>

    <!-- fin modal -->
</template>

<script>
import { API } from '@/mixins/API'
import EventBus from '@/EventBus'
/**
* @vuese
 * @group Administrador/Distribuidor
 * Modal para registrar kits
 */
export default {
  name: 'ModalFormKits',
  mixins: [API],
  data () {
    return {
      marca: 'Marca',
      modelo: 'Modelo',
      marcaProduct: null,
      modeloProduct: null,
      nameKit: null,
      notasKit: null,
      cantidadKit: null,
      tipoProduct: 0,
      listMarcas: [],
      listaModelos: [],
      accion: this.$store.state.modal.datosDymanic.accion,
      listProductosKit: [],
      index: 0

    }
  },
  async created () {
    if (this.accion == 'editar') {
      this.getInfoKit()
    }
  },
  async mounted () {
    this.$store.state.loader = false
    $('#modalAdminKits').modal('show')
  },
  destroyed () {

  },
  methods: {
    /**
   * @vuese
   * Obtiene catalogo de marcas
   */
    async catMarcas () {
      this.marcaProduct = null
      this.modeloProduct = null
      this.listMarcas = []
      this.listaModelos = []
      if (this.tipoProduct != 0) {
        if (this.tipoProduct == 2) { // sims
          console.debug('CAT_SIMS')
          this.marca = 'Compañia teléfonica'
          this.modelo = 'Plan'
          this.modeloProduct = 5

          var request = await this.getRequest('catalogs/sims/carriers')

          if (request.success === true) {
            this.listMarcas = request.data.simCarriers
          }

          this.catPlan()
        } else {
          this.marca = 'Marca'
          this.modelo = 'Modelo'
          console.debug('CAT_PRODUCT_GPS', this.tipoProduct)
          var datos = {
            'productType': this.tipoProduct
          }

          var request = await this.getRequest('catalogs/products/factories', datos)

          if (request.success === true) {
            this.listMarcas = request.data.factories
          }
        }
      }
    },
    /**
   * @vuese
   * Obtiene catalogo de modelos
   */
    async cat_model () {
      console.debug('marca', this.marcaProduct)
      console.debug('tipoP', this.tipoProduct)
      this.listaModelos = []
      if (this.marcaProduct != null) {
        if (this.tipoProduct == 2) { // sims
          var request = await this.getRequest('catalogs/sims/plan')
          console.debug('SIMS_RESP', request)
          if (request.success === true) {
            this.listaModelos = request.data.simPlans
          }
        }
        // gps, product
        if (this.tipoProduct == 1) {
          var request = await this.getRequest('catalogs/devices/factories/' + this.marcaProduct + '/models')

          if (request.success === true) {
            this.listaModelos = request.data.deviceModels
          }

          console.debug('GPS_RESP', request, this.listaModelos)
        }
        if (this.tipoProduct == 3) {
          var request = await this.getRequest('catalogs/products/factories/' + this.marcaProduct + '/models')

          if (request.success === true) {
            this.listaModelos = request.data.models
          }

          console.debug('PRDUC_RESP', request, this.listaModelos)
        }
      }
    },
    /**
   * @vuese
   * Obtiene catalogo de plan de operacion de sims
   */
    async catPlan () {
      this.listaModelos = []
      this.modeloProduct = 5
      var request = await this.getRequest('catalogs/sims/plan')

      if (request.success === true) {
        this.listaModelos = request.data.simPlans
      }
    },
    /**
   * @vuese
   * Agrega productos a la lista
   */
    agregarProducts () {
      if (this.marcaProduct == null) {
        if (this.tipoProduct != 2) {
          $('#alertAdminKits').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Por favor, </strong>Selecciona la marca</div>")
        } else {
          $('#alertAdminKits').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Por favor, </strong>Selecciona la compañia</div>")
        }
        setTimeout(() => {
          $('#alertAdminKits').html('')
        }, 3000)
        return false
      }
      if (this.modeloProduct == null) {
        if (this.tipoProduct != 2) {
          $('#alertAdminKits').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Por favor, </strong>Selecciona el modelo</div>")
        } else {
          $('#alertAdminKits').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Por favor, </strong>Selecciona el plan</div>")
        }
        setTimeout(() => {
          $('#alertAdminKits').html('')
        }, 3000)
        return false
      }

      if (this.cantidadKit == null || this.cantidadKit == '') {
        $('#alertAdminKits').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Por favor, </strong>Ingresa cantidad</div>")

        setTimeout(() => {
          $('#alertAdminKits').html('')
        }, 3000)
        return false
      }

      var marcaString = this.listMarcas.find(x => x.id == this.marcaProduct)

      var modelStrig = this.listaModelos.find(x => x.id == this.modeloProduct)

      console.debug(this.cantidadKit, 'MARCA', marcaString)
      console.debug('MODELO', modelStrig)

      if (this.tipoProduct != 1) {
        this.listProductosKit.push({ 'id': this.index, 'productType': this.tipoProduct, 'model': this.modeloProduct, 'quantity': this.cantidadKit, 'marcaString': marcaString.name, 'modeloString': modelStrig.name })
      } else {
        this.listProductosKit.push({ 'id': this.index, 'productType': this.tipoProduct, 'model': this.modeloProduct, 'quantity': this.cantidadKit, 'marcaString': marcaString.name, 'modeloString': modelStrig.model })
      }

      this.index++

      this.marcaProduct = null
      this.modeloProduct = null
      this.cantidadKit = null
    },
    /**
   * @vuese
   * Elimina productos de la lista
   */
    eliminarProduct (id) {
      var search
      this.listProductosKit.filter(function (dato, i) {
        if (dato.id == id) {
          search = i
          return true
        }
      })

      this.listProductosKit.splice(search, 1)
    },
    /**
   * @vuese
   * Envia datos y registra un gps
   */
    async SendForm () {
      if (this.nameKit == null || this.nameKit == '') {
        $('#alertAdminKits').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Por favor, </strong>Ingresa nombre</div>")

        setTimeout(() => {
          $('#alertAdminKits').html('')
        }, 3000)
        return false
      }

      if (this.listProductosKit.length == 0) {
        $('#alertAdminKits').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Por favor, </strong>Agrega productos</div>")

        setTimeout(() => {
          $('#alertAdminKits').html('')
        }, 3000)
        return false
      }

      $('#btnRegistrar').attr('disabled', 'disabled')
      $('#btnEnditar').attr('disabled', 'disabled')
      this.$store.state.loader = true
      if (this.accion === 'nuevo') {
        var kit = {
          'name': this.nameKit,
          'notes': this.notasKit
        }

        var datos = {}

        datos['kit'] = kit
        datos['products'] = this.listProductosKit

        console.debug('DATOS', datos)

        var request = await this.postRequest('kits', datos)

        if (request.success === true) {
          this.$store.state.loader = false
          $('#alertAdminKits').html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha registrado el kit<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")

          setTimeout(() => {
            $('#alertAdminKits').html('')
            this.cancel()
            EventBus.$emit('GET_LIST_kits', 1)
          }, 3000)
        } else {
          this.$store.state.loader = false
          $('#btnRegistrar').removeAttr('disabled')

          $('#alertAdminKits').html(`<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se ha registrado el kit <button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>`)
        }
      }
      if (this.accion === 'editar') {
        var kit = {
          'name': this.nameKit,
          'notes': this.notasKit
        }

        var datos = {}

        datos['kit'] = kit
        datos['products'] = this.listProductosKit

        console.debug('DATOS', datos)

        var request = await this.putRequest('kits/' + this.$store.state.modal.datosDymanic.id, datos)

        if (request.success === true) {
          this.$store.state.loader = false
          $('#alertAdminKits').html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha actualizado el kit<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
          setTimeout(() => {
            $('#alertAdminKits').html('')
            this.cancel()
            EventBus.$emit('GET_LIST_kits', 1)
          }, 3000)
        } else {
          this.$store.state.loader = false

          $('#btnEnditar').removeAttr('disabled')
          $('#alertAdminKits').html(`<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se ha actualizado el kit <button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>`)
        }
      }
    },
    /**
   * @vuese
   * obtiene datos de kit
   */
    async getInfoKit () {
      var response = await this.getRequest(`kits/${this.$store.state.modal.datosDymanic.id}`)
      var kitInfo = response.data.kit
      console.debug(kitInfo)

      this.nameKit = kitInfo.kitName
      this.notasKit = kitInfo.notes

      kitInfo.products.forEach(element => {
        this.listProductosKit.push({ 'id': this.index, 'productType': element.productTypeID, 'model': element.modelID, 'quantity': element.quantity, 'marcaString': element.factory, 'modeloString': element.model })
        this.index++
      })
    },
    cancel () {
      this.$store.commit('CLEAR_MODAL_DINAMIC')

      $('#modalAdminKits').modal('hide')
    }

  },
  computed: {
    getlistModel () {
      return this.listaModelos
    }
  }
}
</script>
