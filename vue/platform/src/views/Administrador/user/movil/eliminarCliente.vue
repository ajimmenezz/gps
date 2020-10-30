<template>
  <div class="row m-r-5" >

     <div class="col-12" style="margin-top:20px;"> <h5 class="float-left" style=" padding-bottom: 10px;"><b>Eliminar / {{this.title}}</b></h5></div>
        <div class="col-12" style="margin-top:-15px;"> <h6 class="float-left" style=" padding-bottom: 10px;">A continuación te mostramos un formulario donde podras rescatar productos del {{this.title}}</h6>
        <hr style="margin-top:25px; ">
        </div>

        <div class="col-12">
            <div class="card">

                <div class="card-body float-left">
                    <form @submit.prevent >

                      <div class="row">
                         <div class="col-12" style="margin-top:10px;" >
                                          <h5 class="float-left">Cliente {{this.$store.state.modal.datosDymanic.nameCliente}}</h5>

                                      </div>
                          <div class="row justify-content-center" style="margin-top:10px; margin-bottom:20px;" >
                                          <div class="col-12 col-md-10 text-center">En esta sección podrás recuperar los productos de tus cliente {{this.$store.state.modal.datosDymanic.nameCliente}}
                                             selecciona los productos a recuperar rellenando los siguientes campos
                                             (los producto recuperados se mostrarán en la lista de abajo)
                                          </div>

                                      </div>

                         <div class="col-12" style="margin-top:10px;" v-if="this.$store.state.modal.datosDymanic.seccion == 2">
                                          <h5 class="float-left">Clientes a recuperar</h5>
                                          <hr style="margin-top: 2rem;">
                                      </div>

                        <div class=" col-8 col-sm-6 col-md-4" v-if="this.$store.state.modal.datosDymanic.seccion == 2">
                              <m-select
                              ref="customerSelect"
                              :data="listCustomers"
                              filterby="name"
                              title="Clientes"
                              @selectionChanged="OnCustomerSelected"/>
                          </div>

                          <div class="col-4 " v-if="this.$store.state.modal.datosDymanic.seccion == 2">
                            <button style="margin-top: 30px;"  type="button" class=" shadow-2 mb-4 btn btn-primary" @click="agregarCustomer()" >AGREGAR</button>
                          </div>

                          <div class="col-12" style="margin-top:15px;" v-if="this.$store.state.modal.datosDymanic.seccion == 2">
                            <table class="table table-hover header_fijo">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Cliente</th>
                                  <th>Estado</th>
                                  <th>Acciones</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="(client, index) in listCustomersFin" :key="index">
                                  <td>{{index+1}}</td>
                                  <td>{{client.name}}</td>
                                  <td v-if="client.active==1">Activo</td>
                                  <td v-if="client.active==0">Suspendido</td>
                                  <td>
                                    <span>
                                      <i
                                        class="icon icon-md universalicon-trash-2 colorText-red cursor"
                                        @click="removeCustomer(client.id)"
                                      ></i>
                                    </span>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>

                          <div class=" col-8 col-sm-6 col-md-4" v-if="this.$store.state.modal.datosDymanic.seccion == 2 && listCustomersFin.length>0">
                                <m-select2
                                ref="customerSelect"
                                :data="listdist"
                                filterby="name"
                                title="Selecciona distribuidor al que se le transferiran los clientes a recuperar"
                                @selectionChanged="OnDistSelected"/>
                          </div>

                          <div class="col-12" v-if="this.$store.state.modal.datosDymanic.seccion == 2" style="margin-bottom:90px;">&nbsp;</div>
                      </div>

                        <div class="row">

                           <div class="col-12 col-sm-4">
                              <div class="form-group">
                                <label for="exampleFormControlSelect2">Tipo Producto</label>
                                <select class="form-control" id="exampleFormControlSelect2" v-model="tipoProduct" @change="showContent()" >
                                    <option value=0>Ninguno</option>
                                    <option value=1 >Gps</option>
                                    <option value=2 >Sim</option>
                                    <option value=3 >Producto genérico</option>

                                </select>
                              </div>
                            </div>
                        </div>

              <div class="row">
                             <!-- gps -->

                    <div class="col-12 col-sm-6" v-if="getTipoProduct==1">
                      <div class="form-group">
                        <label for="marca">Marca</label>
                        <select class="form-control" id="marca" v-model="marca" :valor="marca"  @change="listmodel()" >
                            <option value="">Selecciona</option>
                            <option v-for="factory in listFactories" :value="factory.id" :key="factory.id">{{factory.factory}}</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6" v-if="getTipoProduct==1">
                      <div class="form-group">
                        <label for="model">Modelo</label>
                        <select class="form-control" id="model" v-model="model" :valor="model" @change="listproducts()" >
                            <option value="">Selecciona</option>
                            <option v-for="model in listmodels" :value="model.id" :key="model.id">{{model.model}}</option>
                        </select>
                      </div>
                    </div>

      <!-- fin gps -->

                     <!-- sim -->

                   <div class="col-12 col-md-6" v-if="getTipoProduct==2">
                      <div class="form-group">
                        <label for="carrier">Compañia</label>
                        <select class="form-control" id="carrier" v-model="marca" :valor="marca"  @change="listmodel()" >
                            <option value="">Selecciona</option>
                            <option v-for="carrier in listFactories" :value="carrier.id" :key="carrier.id">{{carrier.name}}</option>
                        </select>
                      </div>
                    </div>

      <!-- fin sim -->

      <!-- producto -->

           <div class="col-12 col-sm-6" v-if="getTipoProduct==3">
                      <div class="form-group">
                        <label for="marca">Marca</label>
                        <select class="form-control" id="marca" v-model="marca" :valor="marca"  @change="listmodel()" >
                            <option value="">Selecciona</option>
                            <option v-for="factory in listFactories" :value="factory.id" :key="factory.id">{{factory.name}}</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6" v-if="getTipoProduct==3">
                      <div class="form-group">
                        <label for="model">Modelo</label>
                        <select class="form-control" id="model" v-model="model" :valor="model"  @change="listproducts()" >
                            <option value="">Selecciona</option>
                            <option v-for="model in listmodels" :value="model.id" :key="model.id">{{model.name}}</option>
                        </select>
                      </div>
                    </div>

                  <!-- fin prducto -->
                    <div class="col-12" v-if="getTipoProduct!=0 && getTipoProduct!=2">
                      <div class="form-group" >
                        <label for="disp">Dispositivos</label>
                        <select class="form-control" id="disp" v-model="Dispositivos" :valor="Dispositivos"  >
                          <option value="">Selecciona</option>
                            <option value="-1" >Seleccionar todos</option>
                            <option v-for="disp in listDisp" :value="disp.id" :key="disp.id">{{disp.id}}</option>
                        </select>
                      </div>

                    </div>

                    <div class="col-6" v-if="getTipoProduct!=0 && getTipoProduct==2">
                      <div class="form-group" >
                        <label for="disp">Dispositivos</label>
                        <select class="form-control" id="disp" v-model="Dispositivos" :valor="Dispositivos"  >
                          <option value="">Selecciona</option>
                            <option value="-1" >Seleccionar todos</option>
                            <option v-for="disp in listDisp" :value="disp.id" :key="disp.id">{{disp.id}}</option>
                        </select>
                      </div>

                    </div>

            <div class="col-12  float-right" v-if="getTipoProduct!=0 ">
            <button style="margin-top: 30px;"  type="button" class=" shadow-2 mb-4 btn btn-primary" @click="funproductoSeleted()" >Confirmar</button>
          </div>

    </div>

           <div class="col-12" style="margin-top:15px;" >
            <table class="table table-hover header_fijo">
              <thead>
                <tr>
                  <th>Tipo de Producto</th>
                  <th>Marca</th>
                   <th>Modelo</th>
                  <th>IMEI/Serie</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(product, index) in productoSeleted" :key="index">
                  <td>{{product.productType}}</td>
                  <td>{{product.factory}}</td>
                  <td v-if="product.productTypeID!=2">{{product.model}}</td>
                  <td v-else> - </td>
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

          <div class="row justify-content-center" style="margin-top:40px; margin-bottom:35px;" >
                                          <div class="col-12 col-md-10 text-center">
                                            A continuación si quieres eliminar a uno de tus clientes haz click
                                            en el botón CONFIRMAR para eliminarlo.
                                          </div>

                                      </div>

                            <div class="col-12" id="alertasACD" style="margin-top: 20px;"></div>

                            <div class="row justify-content-center" style="margin-top: 15px;" >
                               <div class="col-6 float-right">
                                  <button class=" float-right btn  btn-outline-primary  shadow-2 mb-4 " @click="goReturn()" >CANCELAR</button>

                               </div>
                                 <div class="col-6 float-left">
                                  <button class="float-left btn btn-primary shadow-2 mb-4 " @click="SendForm()" type="submit" >CONFIRMAR</button>
                               </div>
                            </div>

                    </form>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import { API } from '@/mixins/API'
import EventBus from '@/EventBus.js'
import mSelect2 from '@/components/basico/m.select.vue'
import mSelect from '@/components/basico/m.selectDelete.vue'
import DeleteClientDistr from '@/views/Administrador/user/DeleteModal.vue'
/**
 * @vuese
 * @group Administrador/cliente- distribuidor
 * Eliminar cliente o distribuidor
 */
export default {
  name: 'elimnarClienteDist',
  mixins: [API],
  components: {
    mSelect,
    mSelect2
  },
  data () {
    return {
      tipoProduct: 0,
      listFactories: null,
      listmodels: null,
      listDisp: [],
      Dispositivos: '',
      model: '',
      marca: '',
      title: '',
      productoSeleted: [],
      productosFin: [],
      listCustomers: [],
      cliente: null,
      listCustomersFin: [],
      listdist: [],
      dist: null,
      listdistFin: []
    }
  },
  created () {
    if (this.$store.state.modal.datosDymanic.seccion == 2) {
      this.getCustomers()
      this.getDist()
    }
  },
  async mounted () {
    if (this.$store.state.modal.datosDymanic.seccion == 1) {
      this.$store.state.seccionMenu = 'Clientes'
      await EventBus.$emit('NAVBAR_MenuSimple', 'Clientes')
      this.title = 'Cliente'
    }
    if (this.$store.state.modal.datosDymanic.seccion == 2) {
      this.$store.state.seccionMenu = 'Distribuidores'
      await EventBus.$emit('NAVBAR_MenuSimple', 'Distribuidores')
      this.title = 'Distribuidor'
    }
    this.$store.state.loader = true
    $('#containerPrincipal').css({
      'margin-left': this.$store.state.widthMenu
    })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })

    this.$store.state.loader = false
  },

  methods: {
    async getCustomers () {
      this.$store.state.loader = true
      var dat = {
        clientID: this.$store.state.modal.datosDymanic.clientID
      }
      var request = await this.getRequest('accounts', dat)
      this.listCustomers = request.data.customers
      console.debug('CLEINTES', this.listCustomers)
      this.$store.state.loader = false
    },
    async getDist () {
      this.$store.state.loader = true

      var request = await this.getRequest('accounts')
      this.listdist = request.data.customers
      console.debug('dist', this.listdist)
      this.$store.state.loader = false
    },
    showContent () {
      console.debug('SHOWCONTENT')

      if (this.tipoProduct != 0) {
        this.factories()
      }
    },
    /**
   * @vuese
   * Obtiene catalogo de marcas dispositivos
   */
    async factories () {
      this.$store.state.loader = true
      this.marca = ''
      this.model = ''
      this.listmodels = null
      this.listFactories = null
      if (this.tipoProduct == 1) {
        var request = await this.getRequest('catalogs/devices/factories')

        if (request.success === true) {
          this.listFactories = request.data.deviceFactories
        }
      }
      if (this.tipoProduct == 2) {
        var request = await this.getRequest('catalogs/sims/carriers')

        if (request.success === true) {
          this.listFactories = request.data.simCarriers
        }
      }
      if (this.tipoProduct == 3) {
        var datos = {
          'productType': 3
        }
        var request = await this.getRequest('catalogs/products/factories', datos)

        if (request.success === true) {
          this.listFactories = request.data.factories
        }
      }
      this.$store.state.loader = false
    },
    /**
   * @vuese
   * Obtiene catalogo de modelos segun la marca
   */
    async listmodel () {
      this.$store.state.loader = true
      this.model = ''
      this.listmodels = null
      if (this.tipoProduct == 1) {
        console.debug('entra modelo', this.marca)
        var request = await this.getRequest('catalogs/devices/factories/' + this.marca + '/models')
        console.debug('RESP', request)
        if (request.success === true) {
          this.listmodels = request.data.deviceModels
        }
      }
      if (this.tipoProduct == 3) {
        var datos = {
          'productType': 3
        }
        console.debug('entra modelo', this.marca)
        var request = await this.getRequest('catalogs/products/factories/' + this.marca + '/models', datos)
        console.debug('RESP', request)
        if (request.success === true) {
          this.listmodels = request.data.models
        }
      }
      if (this.tipoProduct == 2) { // sims con esa compañia
        this.listDisp = []
        var data = {
          clientID: this.$store.state.modal.datosDymanic.clientID,
          productType: this.tipoProduct,
          factory: this.marca
        }

        var request = await this.getRequest('store', data)

        if (request.success === true) {
          this.listDisp = request.data.products
        }
        console.debug(data, 'STORE', request, this.listDisp)
      }
      this.$store.state.loader = false
    },
    /**
   * @vuese
   * Obtiene catalogo de productos segun la marca y modelo
   */
    async listproducts () {
      this.$store.state.loader = true
      this.listDisp = []
      var data = {
        clientID: this.$store.state.modal.datosDymanic.clientID,
        productType: this.tipoProduct,
        factory: this.marca,
        model: this.model
      }

      var request = await this.getRequest('store', data)
      console.debug(data, 'STORE', request)
      if (request.success === true) {
        this.listDisp = request.data.products
      }
      this.$store.state.loader = false
    },
    /**
   * @vuese
   * añade los productos a la lista
   */
    async funproductoSeleted () {
      if (this.marca == '' || this.marca == null) {
        notify('Por favor!', '  Selecciona marca', 'top', 'right', 'danger')
        return false
      }
      if (this.tipoProduct != 2 && (this.model == '' || this.model == null)) {
        notify('Por favor!', '  Selecciona modelo', 'top', 'right', 'danger')
        return false
      }
      if (this.Dispositivos == '' || this.Dispositivos == null) {
        notify('Por favor!', '  Selecciona un dispositivo', 'top', 'right', 'danger')
        return false
      }
      if (this.listDisp.length == 0) {
        notify('', '  No se encontraron dispositivos', 'top', 'right', 'danger')
        return false
      }

      this.$store.state.loader = true
      console.debug(this.Dispositivos)

      if (this.Dispositivos == -1) { // todos
        this.listDisp.forEach(element => {
          var index = this.productoSeleted.findIndex((i) => {
            return i.id == element.id
          })

          if (index == -1) {
            this.productoSeleted.push({
              id: element.id,
              productID: element.productID,
              productTypeID: element.productTypeID,
              productType: element.productType,
              factoryID: element.factoryID,
              factory: element.factory,
              modelID: element.modelID,
              model: element.model
            })
            this.productosFin.push({ idd: element.id, id: element.productID, type: element.productTypeID })
          } else {
            notify('', 'El producto ya se encuentra agregado', 'top', 'right', 'danger')
          }
        })
      } else {
        var element = this.listDisp.find(x => x.id == this.Dispositivos)
        var index = this.productoSeleted.findIndex((i) => {
          return i.id == element.id
        })

        if (index == -1) {
          this.productoSeleted.push({
            id: element.id,
            productID: element.productID,
            productTypeID: element.productTypeID,
            productType: element.productType,
            factoryID: element.factoryID,
            factory: element.factory,
            modelID: element.modelID,
            model: element.model
          })
          this.productosFin.push({ idd: element.id, id: element.productID, type: element.productTypeID })
        } else {
          notify('', 'El producto ya se encuentra agregado', 'top', 'right', 'danger')
        }
      }
      this.Dispositivos = ''
      this.$store.state.loader = false
    },
    removeProduct (type, id) {
      this.$store.state.loader = true
      var search
      var dat = 0
      this.productoSeleted.filter(function (dato, i) {
        if (dato.id == id) {
          search = i
          dat = dato
          return true
        }
      })

      this.productoSeleted.splice(search, 1)

      this.productosFin.filter(function (dato, i) {
        if (dato.idd == id) {
          search = i
          dat = dato
          return true
        }
      })

      this.productosFin.splice(search, 1)
      this.$store.state.loader = false
    },
    /**
   * @vuese
   * añade los clientes a la lista
   */
    async agregarCustomer () {
      if (this.cliente == '' || this.cliente == null) {
        notify('Por favor!', '  Selecciona cliente', 'top', 'right', 'danger')
        return false
      }

      this.$store.state.loader = true
      console.debug(this.cliente)

      if (this.cliente == -1) { // todos
        this.listCustomers.forEach(element => {
          var index = this.listCustomersFin.findIndex((i) => {
            return i.id == element.id
          })

          if (index == -1) {
            this.listCustomersFin.push({
              id: element.id,
              name: element.name,
              active: element.active,
              creationTimestamp: element.creationTimestamp
            })
          } else {
            notify('', 'El cliente ya se encuentra agregado', 'top', 'right', 'danger')
          }
        })
      } else {
        var element = this.listCustomers.find(x => x.id == this.cliente.id)
        var index = this.listCustomersFin.findIndex((i) => {
          return i.id == element.id
        })

        if (index == -1) {
          this.listCustomersFin.push({
            id: element.id,
            name: element.name,
            active: element.active
          })
        } else {
          notify('', 'El cliente ya se encuentra agregado', 'top', 'right', 'danger')
        }
      }
      this.$store.state.loader = false
    },
    removeCustomer (id) {
      this.$store.state.loader = true
      var search
      var dat = 0
      this.listCustomersFin.filter(function (dato, i) {
        if (dato.id == id) {
          search = i
          dat = dato
          return true
        }
      })

      this.listCustomersFin.splice(search, 1)
      this.$store.state.loader = false
    },
    OnCustomerSelected (customer) {
      this.cliente = customer
    },
    OnDistSelected (dist) {
      this.dist = dist
    },
    async SendForm () {
      console.debug('SEND', this.productosFin, this.listCustomersFin, this.dist)

      if (this.$store.state.modal.datosDymanic.seccion == 2 && this.listCustomersFin.length > 0) {
        if (this.dist == null || this.dist == '') {
          notify('Por favor!', '  Selecciona distribuidor', 'top', 'right', 'danger')
          return false
        }
      }

      this.$store.state.loader = true
      var clientID = this.$store.state.modal.datosDymanic.clientID
      var name = this.$store.state.modal.datosDymanic.nameCliente
      var seccion = this.$store.state.modal.datosDymanic.seccion

      this.$store.commit('CLEAR_MODAL_DINAMIC')

      var datos = {
        'component': DeleteClientDistr,
        'datos': {
          'clientID': clientID,
          'name': name,
          'seccion': seccion,
          'customers': this.listCustomersFin,
          'products': this.productosFin

        }
      }
      if (seccion == 2) {
        if (this.listCustomersFin.length == 0) {
          datos.datos.distransf = null
        } else {
          datos.datos.distransf = this.dist.id
        }
      }
      if (seccion == 1) {
        datos.datos.distransf = null
      }

      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)
      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
      this.$store.state.loader = false
    },
    goReturn () {
      this.$router.push(`/ListaCliente`)
    }
  },
  computed: {
    getTipoProduct () {
      return this.tipoProduct
    },
    getlistDisp () {
      return this.listDisp
    }
  }

}
</script>
