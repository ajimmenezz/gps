<template>
          <!-- MODAL -->

    <div id="modalDelete" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered " role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalCenterTitle">Eliminar flotilla</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body ">

                <div class="container">
                  <div class="row">
                    <div class="col-1"></div>
                    <div class="col-10">
                        <p >¿Estás seguro que deseas eliminar la flotilla {{this.$store.state.modal.datosDymanic.name}} ?</p>
                    </div>
                    <div class="col-1"></div>
                  </div>
                </div>

              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                  <button type="button" class="btn btn-primary" @click="confirmModal()">ACEPTAR</button>

              </div>
              <div id="alertasFleet"></div>

          </div>
      </div>
    </div>

    <!-- fin modal -->
</template>

<script>
import { API } from '@/mixins/API'
import EventBus from '@/EventBus'
/**
 * @group Flotillas
 * Modal para eliminar flotilla
 */
export default {
  name: 'ModalEliminarFlotilla',
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
   * elimina la flotilla
   */
    async confirmModal () {
      var fleetId = this.$store.state.modal.datosDymanic.ID

      // obtener deviceFlotiila para pasarlos a null
      var request = await this.getRequest('fleets/' + fleetId)

      var datos
      var devicesFleet = []
      if (request.success === true) {
        datos = request.data.fleet
        devicesFleet = datos.devices
      }

      var request = await this.deleteRequest('fleets/' + fleetId)

      if (request.success === true) {
        // $('#alertasFleet').html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha eliminado la flotilla<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")

        if (devicesFleet.length > 0) {
          var dispositivos = Object.values(this.$store.state.devices.devices)
          dispositivos.forEach(disp => {
            devicesFleet.forEach(element => {
              if (parseInt(disp.id) == element) {
                disp.fleetID = null
              }
            })
          })
        }

        var search
        var nameFlet = this.$store.state.modal.datosDymanic.name
        var fleet = Object.values(this.$store.state.devices.fleets)
        fleet.filter(function (dato, i) {
          if (dato.name === nameFlet) {
            search = i
            return true
          }
        })

        fleet.splice(search, 1)

        // cerrar modal
        $('#modalDelete').modal('hide')
        this.$store.commit('CLEAR_MODAL_DINAMIC')

        EventBus.$emit('GET_LIST_fleets', 1)
      } else {
        $('#alertasFleet').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se ha eliminado la flotilla<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
      }
    }

  },
  computed: {

  }
}
</script>
