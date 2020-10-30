<template>
          <!-- MODAL -->

    <div id="modalDelete" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered " role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalCenterTitle" >Eliminar {{tipo}}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body ">

                <div class="container">
                  <div class="row">
                    <div class="col-1"></div>
                    <div class="col-10">
                        <p >¿Estás seguro que deseas eliminar la {{tipo}}?</p>
                    </div>
                    <div class="col-1"></div>
                  </div>
                </div>

              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" @click="cancel()">CANCELAR</button>
                  <button type="button" class="btn btn-primary" @click="confirmModal()" >ACEPTAR</button>

              </div>
              <div id="alertastransf"></div>

          </div>
      </div>
    </div>

    <!-- fin modal -->
</template>

<script>
import EventBus from '@/EventBus'
import { API } from '@/mixins/API'
/**
 * @group Modals
 * Modal para eliminar transferencias o devoluciones
 */
export default {
  name: 'ModalEliminarTransf',
  mixins: [API],
  data () {
    return {
      passwParoMotor: '',
      confirmPasswParoMotor: '',
      tipo: ''
    }
  },
  created () {
    this.tipo = this.$store.state.modal.datosDymanic.tipo
  },
  mounted () {
    $('#modalDelete').modal('show')
  },
  destroyed () {

  },
  methods: {
    cancel () {
      this.$store.commit('CLEAR_MODAL_DINAMIC')

      $('#modalDelete').modal('hide')
    },
    /**
   * @vuese
   * elimina la transferencia
   */
    async confirmModal () {
      console.debug('elimianr transfDev', this.$store.state.modal.datosDymanic, this.$store.state.modal.datosDymanic.tipo)

      var idTranf = this.$store.state.modal.datosDymanic.ID
      var request = await this.deleteRequest('transfers/' + idTranf)

      if (request.success === true) {
        $('#alertastransf').html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha cancelado la " + this.tipo + "<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")

        // cerrar modal
        $('#modalDelete').modal('hide')
        this.$store.commit('CLEAR_MODAL_DINAMIC')
        // actualizar lista geocercas
        EventBus.$emit('Modal_GET_LIST_transf', 1)
      } else {
        $('#alertastransf').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se ha cancelado la " + this.tipo + "<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
      }
    }

  },
  computed: {
  }
}
</script>
