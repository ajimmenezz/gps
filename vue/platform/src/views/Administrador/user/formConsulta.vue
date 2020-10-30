<template>
          <!-- MODAL -->

    <div id="modalConsultaForm" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg " role="document">
          <div class="modal-content">

              <div class="modal-body float-left" style="margin-top: 15px;  margin-bottom: 10px;">
                    <div class="row">
                      <div class="col-12">
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                         <h5 class="modal-title" id="exampleModalCenterTitle" style="color: #007bff;">Consultar {{tipoC}}</h5>
                       <hr style="background: #007bff;   margin-top: -1px;">

                      </div>
                    </div>

                        <div class="row" v-if="getDataClient">

                            <div class="col-12 col-md-4 mb-4">
                                <b>Nombre de la cuenta: </b><br>
                            {{getDataClient.account}}

                            </div>

                            <div class="col-12 col-md-4 mb-4">
                              <b>Estado de la cuenta: </b>   <br>
                            <span v-if="getDataClient.active==1">Activa</span>
                             <span v-if="getDataClient.active==0">Suspendida</span>

                            </div>

                            <div class="col-12 col-md-4 mb-4" v-if="this.$store.state.modal.datosDymanic.seccion!='otro'">
                             <b>    Correo electrónico:</b> <br>
                            {{getDataClient.email}}

                            </div>

                             <div class="col-12" style="margin-top:30px;" >
                                <h5 class="float-left" style="color: #007bff;">Datos legales</h5>
                                <hr style="background: #007bff;   margin-top: 25px;" >
                            </div>

                            <div class="col-12 col-md-4 mb-4 ">

                              <b>     Estado legal: <br></b>
                            {{getDataClient.legal.status}}
                            </div>
                            <div class="col-12 col-md-4 mb-4">
                              <b>    {{nameStatusLegal}}:</b> <br>
                            {{getDataClient.legal.name}}

                            </div>
                            <div id="divRFC" class="col-12 col-md-4 mb-4" style="display:none;">
                             <b>     RFC / ID legal: </b><br>
                            {{getDataClient.legal.taxID}}

                            </div>
                            <div class="col-12 col-md-4 mb-4">
                             <b>    País: </b><br>
                            {{getDataClient.legal.country}}

                            </div>

                            <div class="col-12 col-md-4 mb-4">
                              <b>     Región/Estado:</b> <br>
                           {{getDataClient.legal.region}}

                            </div>
                            <div class="col-12 col-md-4 mb-4">
                               <b>    Código postal:</b> <br>
                           {{getDataClient.legal.zipCode}}
                            </div>

                            <div class="col-12 col-md-4 mb-4">
                             <b>     Dirección: </b><br>
                            {{getDataClient.legal.address}}

                            </div>

                            <div class="col-12 col-md-4 mb-4" v-if="this.$store.state.modal.datosDymanic.seccion!='otro'">

                             <b>       Zona horaria: </b><br>
                            {{getDataClient.zonaH}}
                            </div>

                            <div class="col-12 col-md-4 mb-4">
                             <b>     Notas:</b><br>
                            {{getDataClient.legal.notes}}

                            </div>

                             <div class="col-12" style="margin-top: 20px" >
                                        <div class="row float-left" style="width: 100%;">
                                            <div class="col-12">
                                                <h5 class="float-left" style="color: #007bff;">Lista de contactos</h5>
                                                <hr style="background: #007bff;   margin-top: 25px;" v-if="contactos.length==0">
                                            </div>

                                            <div class="col-12" style="margin-top:15px; overflow: auto;  max-height: 300px;" v-if="this.contactos.length>0">
                                               <table class="table table-hover header_fijo">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Teléfono</th>
                  <th>Celular</th>
                  <!-- <th>Tipo</th> -->
                  <th>Correo</th>

                </tr>
              </thead>
              <tbody>
                <tr v-for="(contac, index) in  this.contactos" :key="index">

                  <td>{{contac.name}}</td>
                  <td>{{contac.phone}}</td>
                  <td>{{contac.cel}}</td>
                  <!-- <td>{{contac.tipo}}</td> -->
                  <td>{{contac.email}}</td>

                </tr>
              </tbody>
            </table>
                                            </div>

                                            <div class="col-12" style="overflow: auto; max-height: 130px;" v-if="this.contactos.length==0">Sin contactos</div>
                                        </div>
                                    </div>

                        </div>

              </div>
              <!-- <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>

              </div> -->

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
 * Modal para consultar clientes y distribuidores
 */
export default {
  name: 'ModalConsultarClientesDistribuidor',
  mixins: [API],
  data () {
    return {
      contactos: [],
      tipoC: '',
      dataClient: null,
      nameStatusLegal: ''
    }
  },
  async created () {
    if (this.$store.state.modal.datosDymanic.accion == 'cliente') {
      this.tipoC = 'Cliente'
    }
    if (this.$store.state.modal.datosDymanic.accion == 'dist') {
      this.tipoC = 'Distribuidor'
    }
    await this.getInfoCliente()
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
    async getInfoCliente () {
      var response = await this.getRequest(`accounts/${this.$store.state.modal.datosDymanic.clientID}`)
      console.debug(response)
      var clientAllInfo = response.data.customer

      this.dataClient = clientAllInfo

      console.debug('clientAllInfo', clientAllInfo, this.dataClient)

      if (clientAllInfo.legal.statusID == 1) { // ninguno
        $('#divRFC').css({ 'display': 'none' })
        this.nameStatusLegal = 'Nombre responasable legal'
      } else { // fisica y moral
        $('#divRFC').css({ 'display': 'block' })
        this.nameStatusLegal = 'Nombre legal / razon social'
      }

      var contactosbd = clientAllInfo.contacts
      console.debug('CONTACTOS', contactosbd)
      contactosbd.forEach(element => {
        this.contactos.push({ 'id': this.id, 'name': element.name, 'phone': element.phone, 'cel': element.cel, 'email': element.email, 'tipo': element.contactType })

        this.id++
      })

      console.debug(clientAllInfo, 'DATOS', this.dataClient, 'COMPUTED', this.getDataClient)
      console.debug(this.dataClient.id, this.dataClient.legal, this.dataClient.legal.name)
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
    getDataClient () {
      return this.dataClient
    }

  }
}
</script>

<style>

</style>
