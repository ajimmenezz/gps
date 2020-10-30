<template>
          <!-- MODAL -->

    <div id="modalConsultaForm" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg " role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalCenterTitle">Consultar {{tipoC}}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body float-left">

                        <div class="row" v-if="getDataTransf">

                             <div class="col-12 col-md-4 mb-4">
                                 Quién solicita la {{tipoC}}: <br>
                            <b>{{getDataTransf.fromClient}}</b>

                            </div>

                            <div class="col-12 col-md-4 mb-4" >
                                 Para quién solicita la {{tipoC}}: <br>
                            <b>{{getDataTransf.toClient}}</b>

                            </div>
                             <div class="col-12 col-md-4 mb-4" >
                                 Tipo de {{tipoC}}: <br>
                            <b>{{getDataTransf.type}}</b>

                            </div>

                            <div class="col-12">
                                  Notas:<br>
                            <b>{{getDataTransf.notes}}</b>

                            </div>

                             <div class="col-12" style="margin-top: 20px" >
                                <div class="row float-left" style="width: 100%;">
                                    <div class="col-12">
                                        <h5 class="float-left">Lista de Productos</h5>
                                    <hr style="margin-top: 2rem;" v-if="productosList.length==0">
                                    </div>

                                    <div class="col-12" style="margin-top:15px; overflow: auto;  max-height: 300px;" v-if="productosList.length>0">
                                      <table class="table table-hover header_fijo">
                                        <thead>
                                          <tr>
                                            <th>#</th>
                                            <th>Tipo de Producto</th>
                                            <th>Marca</th>
                                              <th >Modelo</th>
                                            <th>IMEI/Serie</th>
                                              <th v-if="getDataTransf.stateID==2">Estado</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tr v-for="(element, index) in getDataTransf.products" :key="index">
                                            <td>{{index+1}}</td>
                                            <td >{{element.type}}</td>
                                            <td>{{element.factory}}</td>
                                            <td v-if="element.type!=2">{{element.model}}</td>
                                            <td v-else> - </td>
                                            <td >{{element.serie}}</td>
                                            <td v-if="getDataTransf.stateID==2">{{element.state}}</td>

                                          </tr>
                                        </tbody>
                                      </table>
                                    </div>

                                    <div class="col-12" style="overflow: auto; max-height: 130px;" v-if="productosList.length==0">Sin productos</div>
                                </div>
                            </div>

                            <!-- <div class="col-12 float-left" v-if="getDataTransf.stateID==2">
                               <div class="col-12">
                                    <h5 class="float-left">Mensales de la {{tipoC}}</h5>
                                    <hr style="margin-top: 2rem;" >
                                </div>
                                <div class="row">
                                  <div class="col-12" v-for="(element, index) in getDataTransf.bitacora" :key="index">
                                     <div class="row">
                                       <div class="col-12 col-md-6 float-left">Cliente:{{element.client}}</div>   <div class="col-12 col-md-6 float-right">Fecha: {{element.creationTimestamp* 1000 | moment("MMMM DD YYYY") }}</div>
                                      <div class="col-12"></div>acción:{{element.action}}
                                      <div class="col-12"></div>notas: {{element.notes}}
                                   </div><br>
                                  </div>
                                </div>
                            </div> -->

                        </div>

              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>

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
 * @group Usuarios
 * Modal para consultar transferncias
 */
export default {
  name: 'ModalConsultarTransferencia',
  mixins: [API],
  data () {
    return {
      productosList: [],
      tipoC: '',
      dataTransf: null,
      nameStatusLegal: ''
    }
  },
  async created () {
    if (this.$store.state.modal.datosDymanic.accion == 'trans') {
      this.tipoC = 'transferencia'
    }
    if (this.$store.state.modal.datosDymanic.accion == 'dev') {
      this.tipoC = 'devolución'
    }
    await this.getInfoTransf()
  },
  mounted () {
    this.$store.state.loader = false
    $('#modalConsultaForm').modal('show')
  },
  destroyed () {

  },
  methods: {
    /**
   * @vuese
   * Obtiene la informacion del cliene
   */
    async getInfoTransf () {
      var response = await this.getRequest(`transfers/${this.$store.state.modal.datosDymanic.clientID}`)

      var clientAllInfo = response.data.transfer

      this.dataTransf = clientAllInfo

      this.productosList = clientAllInfo.products
      console.debug(clientAllInfo)
    },
    /**
   * @vuese
   * Elimina usuario
   */
    async confirmModal () {
      var userId = this.$store.state.modal.datosDymanic.userID
      var request = await this.deleteRequest('users/' + userId)

      if (request.success === true) {
      //  $('#alertasUser').html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha eliminado el usuario<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")

        // cerrar modal
        $('#modalConsultaForm').modal('hide')
        this.$store.commit('CLEAR_MODAL_DINAMIC')
        EventBus.$emit('GET_LIST_users', 1)
      } else {
        $('#alertasUser').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se ha eliminado el usuario<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
      }
    }

  },
  computed: {
    getDataTransf () {
      return this.dataTransf
    }

  }
}
</script>

<style>

</style>
