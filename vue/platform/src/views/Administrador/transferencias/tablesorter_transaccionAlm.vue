<template>
  <div class=" row " >
      <div class="col-12"> <h5 class="float-left" style="font-size: 20px; padding-bottom: 10px;"><b>Almacén - Transferencias</b></h5></div>

      <div class=" col-12">
      <div class="card">
           <div class="card-header row">
              <div class="col-12 col-md-3">
              <h5 class=" float-left">Transferencias</h5>
              </div>

              <div class="col-12 col-md-9" style="height: 30px;">

                <router-link to="/transactions/new/1"  >
                  <button  type="button" class="btn btn-primary float-right btn-sm"  v-if=" this.$store.state.clientType==3">NUEVA TRANSFERENCIA</button>
                </router-link>
                 <router-link to="/transactions/new/2"  >
                  <button  type="button" class="btn btn-primary float-right btn-sm"  v-if="this.$store.state.clientType==1 ">NUEVA DEVOLUCIÓN</button>
                </router-link>
                 <router-link to="/transactions/new/1"  >
                  <button  type="button" class="btn btn-primary float-right btn-sm"  v-if="this.$store.state.clientType==2 ">NUEVA TRANSFERENCIA</button>
                </router-link>

                  <button  type="button" class="btn btn-secondary float-right btn-sm" @click="cancel()" >REGRESAR</button>

              </div>

            </div>
            <div class="card-body">

                                   <!-- <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item cursor">
                                            <a class="nav-link h-blue active text-uppercase cursor" data-toggle="tab" role="tab"  @click="loadListPendAceptar()">Pend. por aceptar</a>
                                        </li>
                                        <li class="nav-item cursor">
                                            <a class="nav-link h-blue text-uppercase cursor" id="profile-tab" data-toggle="tab"  role="tab"  @click="loadListMisTrans()">Transf. pendientes</a>
                                        </li>
                                        <li class="nav-item cursor">
                                            <a class="nav-link h-blue text-uppercase cursor" id="contact-tab" data-toggle="tab" role="tab" @click="loadListMisdev()">Dev.pendientes</a>
                                        </li>
                                        <li class="nav-item cursor">
                                            <a class="nav-link h-blue text-uppercase cursor" id="contact2-tab" data-toggle="tab" role="tab" @click="loadListFinish()">Completadas</a>
                                        </li>
                                    </ul> -->

                    <div class="row">

                      <div class="col-12 col-md-6 float-right">
                          <!-- <config-input id="deviceSearcher" label="null" required="false"
                          typeinput="text" placeholder="Buscar"
                          @input="filterLista"
                          paddingConf="6px 12px" backgroundd="#ffff"></config-input> -->

                      </div>
                      <div class="col-md-2"></div>
                      <div class="col-12 col-md-4 float-left" style="margin-bottom:15px;" >
                        <div class="form-group">
                          <label for="typeFiltro">Filtrar tranferencias: </label>
                          <select class="form-control float-left" id="typeFiltro" v-model="typeFiltro" :valor="typeFiltro"  @change="getListTipoTranf()" required>
                              <option value="1">Recibidos pendientes</option>
                              <option value="2">Envios pendientes</option>
                              <option value="3">Completadas</option>

                          </select>
                        </div>
                      </div>

                    </div>

                                    <div class="col-12 float-left "  style="padding-top:40px; border-top: 1px solid #dee2e6"><h5>{{title}}</h5></div>
                                    <div class=" table-responsive scrollTable" id="myTabContent" >

                                    <table  class="table table-hover header_fijo ">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Del cliente</th>
                                                <th>Para el cliente</th>
                                                <th>Tipo</th>
                                                 <th>Estado</th>
                                                <th>Fecha de solicitud</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                              <tr v-for="(trans,index) in listTransf" :key="trans.id">
                                                  <td>{{index+1}}</td>
                                                  <td>{{trans.fromClient}}</td>
                                                  <td>{{trans.toClient}}</td>
                                                  <td>{{trans.type}}</td>
                                                   <td>{{trans.state}}</td>
                                                  <td > {{trans.creationTimestamp* 1000 | moment("MMMM DD YYYY") }}</td>

                                                  <td>

                                                    <span  class="cursor" @click="consultar(trans.id,trans.typeID)" v-if="tipo!=1"><i class="icon icon-md universalicon-visible cursor cssToolTipp" ><p style="top: 25px !important; right: -70% !important;">Consultar transferencia/devolución</p></i></span>
                                                      <span class="cursor" @click="pendientes(trans.id,trans.typeID)" v-if="tipo==1"><i class="icon icon-md universalicon-checklist cursor cssToolTipp" ><p style="top: 25px !important; right: -70% !important;">Aceptar ó Declinar transferencia/devolución</p></i></span>
                                                      <span @click="eliminar(trans.id,trans.typeID)" v-if="tipo==2 "><i class="cursor icon-small icon universalicon-cancel colorText-red cssToolTipp"> <p style="top: 25px !important; right: -70% !important;">Cancelar transferencia/devolución</p></i></span>
                                                  </td>
                                              </tr>

                                        </tbody>

                                    </table>
                                  </div>

                                    </div>

            </div>
        </div>

      </div>

  </div>
</template>

<script>
import { API } from '@/mixins/API'
import EventBus from '@/EventBus.js'
import FormTransactionView from '@/views/Administrador/transferencias/formConsulta'
import cModalDelete from '@/views/Administrador/transferencias/DeleteModal'
import { Functions } from '@/mixins/Functions.js'
/**
 * @vuese
 * @group Administrador/transferencias
 * Tabla de transferencias del alamcén
 */
export default {
  name: 'tablaTransaferenciasStore',
  mixins: [API, Functions],
  data () {
    return {
      listTransf: null,
      title: 'Transferencias pendientes por revisar y aceptar',
      tipo: 1,
      desde: null,
      typeFiltro: 1,
      listTransfOrigin: null

    }
  },
  components: {
  },
  created () {

  },
  async mounted () {
    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })
    this.$store.state.seccionMenu = 'almacen'
    await EventBus.$emit('NAVBAR_MenuSimple', 'almacen')
    var f = new Date()
    var mes1 = f.getMonth()
    var nuevaFECHA = f.setMonth(mes1 - 2)

    this.desde = Date.parse(new Date(nuevaFECHA)) / 1000
    this.typeFiltro = 1
    this.getListTipoTranf()
    this.suscribeToEvents()
  },
  beforeDestroy () {
    this.unsuscribreToEvents()
  },
  methods: {
    /**
   * @vuese
   * Obtiene resultados de coincidencias del string con lista de clientes
   * @arg `searchTerm` String de filtro
   */
    filterLista (searchTerm) {
      var tipo = 'tipo'

      this.listTransf = this.filterList(this.listTransfOrigin, 'type', searchTerm, tipo)
    },
    /**
   * @vuese
   * Obtiene la lista de transacciones segun sea el caso
   */
    async getListTipoTranf () {
      var transfersState

      if (this.typeFiltro == 1) {
        this.tipo = 1
        this.title = 'Transferencias y devoluciónes recibidos y pendientes'
        transfersState = 1
      }
      if (this.typeFiltro == 2) {
        this.tipo = 2
        this.title = 'Transferencias y devoluciónes enviados y pendientes'
        transfersState = 1
      }
      if (this.typeFiltro == 3) {
        this.tipo = 3
        this.title = 'Transferencias y devoluciónes completadas'
        transfersState = 2
      }

      var params = {
        // 'fromTimestamp': this.desde,
        'transferStates': [transfersState]
        // 'transferTypes': [1]

      }

      console.debug('DATOS', params)
      var request = await this.getRequest('transfers', params)
      var data = request.data.transfers
      console.debug('transfers', data)
      this.listTransf = data
      this.listTransfOrigin = data

      if (this.tipo == 2) { // mis tranferencias
        this.listTransf = []
        this.listTransfOrigin.forEach(element => {
          if (element.isReceivedTransfer == 0) { // && element.fromClientID == 'yo'
            this.listTransf.push({
              id: element.id,
              fromClientID: element.fromClientID,
              fromClient: element.fromClient,
              toClientID: element.toClientID,
              toClient: element.toClient,
              typeID: element.typeID,
              type: element.type,
              stateID: element.stateID,
              state: element.state,
              creationTimestamp: element.creationTimestamp,
              notes: element.notes,
              isReceivedTransfer: element.isReceivedTransfer
            })
          }
        })
      }
      if (this.tipo == 1) { // me mandaron
        this.listTransf = []
        this.listTransfOrigin.forEach(element => {
          if (element.isReceivedTransfer == 1) { // && element.toClientID == 'yo'
            this.listTransf.push({
              id: element.id,
              fromClientID: element.fromClientID,
              fromClient: element.fromClient,
              toClientID: element.toClientID,
              toClient: element.toClient,
              typeID: element.typeID,
              type: element.type,
              stateID: element.stateID,
              state: element.state,
              creationTimestamp: element.creationTimestamp,
              notes: element.notes,
              isReceivedTransfer: element.isReceivedTransfer
            })
          }
        })
      }

      console.debug('transfersFINAL', this.listTransf)
    },

    /**
   * @vuese
   * abre formulario de pendientes
   */
    async pendientes (id, tipo) {
      this.$store.commit('CLEAR_MODAL_DINAMIC')
      var datos = {
        'datos': {
          'idTrans': id,
          // 'accion': 'consultar',
          'tipo': tipo,
          'seccion': 'check'
        }
      }

      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)
      this.$router.push('/transactions/agree')
    },

    /**
   * @vuese
   * Obtiene la informacion del cliente
   * @arg `id` Id de usuario
   */
    async consultar (id, tipo) {
      this.$store.state.loader = true
      this.$store.commit('CLEAR_MODAL_DINAMIC')
      var tipoString

      var datos = {
        'component': FormTransactionView,
        'datos': {
          'clientID': id,
          // 'accion': 'consultar',

          'seccion': 'otro'
        }
      }

      if (tipo == 2) { // dev
        tipoString = 'dev'
      } else { // trans
        tipoString = 'trans'
      }

      datos.datos.accion = tipoString

      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)
      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
      // this.$router.push({ name: 'FormUsers', params: { id: 2 } })
    },

    /**
   * @vuese
   * Abre el modal de confirmacion para cancelar transferencia
   * @arg `id` Id de transferencia

   */
    async eliminar (id, tipo) {
      this.$store.commit('CLEAR_MODAL_DINAMIC')

      var datos = {
        'component': cModalDelete,
        'datos': {
          'ID': id,
          'tipo': 'trans'
        }
      }

      var tipoString
      if (tipo == 2) { // dev
        tipoString = 'devolución'
      } else { // trans
        tipoString = 'transferencia'
      }

      datos.datos.tipo = tipoString

      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)
      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
    },

    /**
   * @vuese
   * cancela el proceso y regresa una pagina anterior
   */
    cancel () {
      this.$router.push('/store')
    },
    /**
   * @vuese
   * se suscribe a eventos eventBus para actulizar el listado de gps
   */
    suscribeToEvents () {
      EventBus.$on('Modal_GET_LIST_transf', (tipo) => {
        this.getListTipoTranf()
      })
    },
    /**
   * @vuese
   * Se destruye la suscripcion al eventBus
   */
    unsuscribreToEvents () {
      EventBus.$off('Modal_GET_LIST_transf')
    }
  },
  computed: {

  }
}
</script>

<style>
.scrollTable{
  position: relative;
    overflow: auto;
    height: 350px;
    width: 100%;
}
</style>
