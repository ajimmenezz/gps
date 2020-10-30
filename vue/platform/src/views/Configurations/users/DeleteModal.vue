<template>
          <!-- MODAL -->

    <div id="modalDelete" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered " role="document">
          <div class="modal-content">

              <div class="modal-body ">

                <div class="container">

                  <div class="row">
                    <div class="col-12 float-left"  style="color: #007bff;">
                        <h5  style="color: #007bff;" class="modal-title" id="exampleModalCenterTitle">Eliminar usuario</h5>
                        <hr style="margin-top: -1px; background: #007bff;">
                    </div>
                  </div>

                  <div class="row" style="margin-top:20px; margin-bottom:20px;">
                    <div class="col-1"></div>
                    <div class="col-10">
                        <p >¿Estás seguro que deseas eliminar el usuario <b>{{this.$store.state.modal.datosDymanic.item.username}}</b> ?</p>
                    </div>
                    <div class="col-1"></div>
                  </div>

                  <div class="row">
                     <div class="col-12">
                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">CANCELAR</button>
                        <button type="button" class="btn btn-primary" @click="confirmModal()">ACEPTAR</button>

                    </div>
                  </div>
                </div>

              </div>

              <div id="alertasUser"></div>

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
 * Modal para elimnar un usuario
 */
export default {
  name: 'ModalEliminarUsuario',
  mixins: [API],
  data () {
    return {

    }
  },
  mounted () {
    $('#modalDelete').modal('show')
  },
  destroyed () {

  },
  methods: {
    /**
   * @vuese
   * Elimina usuario
   */
    async confirmModal () {
      //  $('#alertasUser').html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha eliminado el usuario<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")

      // cerrar modal
      $('#modalDelete').modal('hide')
      var datos = {
        'data': this.$store.state.modal.datosDymanic.item,
        'sender': this.$store.state.modal.datosDymanic.sender
      }

      EventBus.$emit('GET_LIST_users', datos)
    },
    cancel () {
      // cerrar modal
      $('#modalDelete').modal('hide')
      var seccion = this.$store.state.modal.datosDymanic.seccion
      this.$store.commit('CLEAR_MODAL_DINAMIC')

      this.$router.push(`/ListTableDistrobuitor`)
    }

  },
  computed: {

  }
}
</script>
