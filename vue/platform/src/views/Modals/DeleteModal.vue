<template>
          <!-- MODAL -->

    <div id="modalDelete" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered " role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalCenterTitle" v-if="this.$store.state.modal.datosDymanic.tipo==='geofence'">Eliminar geocerca</h5>
                  <h5 class="modal-title" id="exampleModalCenterTitle" v-if="this.$store.state.modal.datosDymanic.tipo==='puntoInteres'">Eliminar punto de interés</h5>
                  <h5 class="modal-title" id="exampleModalCenterTitle" v-if="this.$store.state.modal.datosDymanic.tipo==='ruta'">Eliminar ruta</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body ">

                <div class="container">
                  <div class="row">
                    <div class="col-1"></div>
                    <div class="col-10">
                        <p v-if="this.$store.state.modal.datosDymanic.tipo==='geofence'">¿Estás seguro que deseas eliminar la geocerca {{this.$store.state.modal.datosDymanic.name}} ?</p>
                        <p v-if="this.$store.state.modal.datosDymanic.tipo==='puntoInteres'">¿Estás seguro que deseas eliminar el punto de interés {{this.$store.state.modal.datosDymanic.name}} ?</p>
                        <p v-if="this.$store.state.modal.datosDymanic.tipo==='ruta'">¿Estás seguro que deseas eliminar la ruta?</p>
                    </div>
                    <div class="col-1"></div>
                  </div>
                </div>

              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" @click="cancel()">CANCELAR</button>
                  <button type="button" class="btn btn-primary" @click="confirmModalGeofence()" v-if="this.$store.state.modal.datosDymanic.tipo==='geofence'">ACEPTAR</button>
                  <button type="button" class="btn btn-primary" @click="confirmModalPuntoInt()" v-if="this.$store.state.modal.datosDymanic.tipo==='puntoInteres'">ACEPTAR</button>
                  <button type="button" class="btn btn-primary" @click="confirmModalRuta()" v-if="this.$store.state.modal.datosDymanic.tipo==='ruta'">ACEPTAR</button>

              </div>
              <div id="alertasGeocercas"></div>

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
 * Modal para eliminar geocerca, punto de interes y rutas
 */
export default {
  name: 'ModalEliminar',
  mixins: [API],
  data () {
    return {
      passwParoMotor: '',
      confirmPasswParoMotor: ''
    }
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
   * elimina la geocerca
   */
    async confirmModalGeofence () {
      console.debug('Elimgeocerca', this.$store.state.modal.datosDymanic, this.$store.state.modal.datosDymanic.GeofenceID)

      var idGeocerca = this.$store.state.modal.datosDymanic.GeofenceID
      var request = await this.deleteRequest('geofences/' + idGeocerca)

      if (request.success === true) {
        $('#alertasGeocercas').html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha eliminado la geocerca<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")

        // cerrar modal
        $('#modalDelete').modal('hide')
        this.$store.commit('CLEAR_MODAL_DINAMIC')
        // actualizar lista geocercas
        EventBus.$emit('Modal_GET_LIST_GEOFENCES', 1)
      } else {
        $('#alertasGeocercas').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se ha eliminado la geocerca<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
      }
    },
    /**
   * @vuese
   * elimina el punto de interes
   */
    async confirmModalPuntoInt () {
      console.log('ElimpuntoInteres', this.$store.state.modal.datosDymanic)

      var puntoInteresID = this.$store.state.modal.datosDymanic.puntoInteresID
      var request = await this.deleteRequest('geofences/' + puntoInteresID)

      if (request.success === true) {
        $('#alertasGeocercas').html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha eliminado el punto de interés<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")

        // cerrar modal
        $('#modalDelete').modal('hide')
        this.$store.commit('CLEAR_MODAL_DINAMIC')
        // actualizar lista geocercas
        EventBus.$emit('Modal_GET_LIST_GEOFENCES', 2)
      } else {
        $('#alertasGeocercas').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se ha eliminado el punto de interés<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
      }
    },
    /**
   * @vuese
   * elimina la ruta
   */
    confirmModalRuta () {
      console.log('ElimRuta', this.$store.state.modal.datosDymanic)

      // cerrar modal
      $('#modalDelete').modal('hide')
      this.$store.commit('CLEAR_MODAL_DINAMIC')
    }
  },
  computed: {
  }
}
</script>
