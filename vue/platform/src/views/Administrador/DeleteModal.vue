<template>
          <!-- MODAL -->

    <div id="modalDelete" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered " role="document">
          <div class="modal-content">
              <div class="modal-header">

                  <h5 class="modal-title" id="exampleModalCenterTitle" v-if="this.$store.state.modal.datosDymanic.tipo=='gps'">Eliminar gps</h5>
                  <h5 class="modal-title" id="exampleModalCenterTitle" v-if="this.$store.state.modal.datosDymanic.tipo=='sims'">Eliminar sim</h5>
                  <h5 class="modal-title" id="exampleModalCenterTitle" v-if="this.$store.state.modal.datosDymanic.tipo=='product'">Eliminar producto</h5>
                  <h5 class="modal-title" id="exampleModalCenterTitle" v-if="this.$store.state.modal.datosDymanic.tipo=='kit'">Eliminar kit</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body ">

                <div class="container">
                  <div class="row">
                    <div class="col-1"></div>
                    <div class="col-10" >
                        <p v-if="this.$store.state.modal.datosDymanic.tipo=='gps'">¿Estás seguro que deseas eliminar el gps con imei: <b>{{this.$store.state.modal.datosDymanic.name}}</b>?</p>
                        <p v-if="this.$store.state.modal.datosDymanic.tipo=='sims'">¿Estás seguro que deseas eliminar la sims con telefono: <b>{{this.$store.state.modal.datosDymanic.name}}</b>?</p>
                        <p v-if="this.$store.state.modal.datosDymanic.tipo=='product'">¿Estás seguro que deseas eliminar el priducto con serial: <b>{{this.$store.state.modal.datosDymanic.name}}</b>?</p>
                        <p v-if="this.$store.state.modal.datosDymanic.tipo=='kit'">¿Estás seguro que deseas eliminar el kit: <b>{{this.$store.state.modal.datosDymanic.name}}</b>?</p>
                    </div>
                    <div class="col-1"></div>

                    <div v-if="this.$store.state.modal.datosDymanic.tipo=='gps' && deviceSims!=null">
                      <div class="col-12" >
                        <p >El dispositivo tiene una sim asociada, que desea hacer con la sim?</p>
                      </div>

                      <div class="col-12 float-left custom-control custom-radio" style="margin-left: 15px;">
                          <input type="radio" id="1" name="customRadio" class="custom-control-input" value="1" v-model="comportamiento">
                          <label class="custom-control-label" for="1">Eliminarla</label>
                      </div>
                      <div class="col-12 float-left custom-control custom-radio" style="margin-left: 15px;">
                          <input type="radio" id="2" name="customRadio" class="custom-control-input" value="2" v-model="comportamiento">
                          <label class="custom-control-label" for="2">Mandar a almacén</label>
                      </div>

                    </div>

                  </div>
                </div>

              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" @click="cancel()">CANCELAR</button>
                  <button type="button" class="btn btn-primary" @click="confirmModal()">ACEPTAR</button>

              </div>
              <div id="alertasModalDelete"></div>

          </div>
      </div>
    </div>

    <!-- fin modal -->
</template>

<script>
import { API } from '@/mixins/API'
import EventBus from '@/EventBus'
/**
 * @group Administrador/Distribuidor
 * Modal para eliminar gps, sims o producto generico de almacen
 */
export default {
  name: 'ModalEliminarGPS',
  mixins: [API],
  data () {
    return {
      deviceSims: null,
      comportamiento: 0
    }
  },
  created () {

  },
  mounted () {
    $('#modalDelete').modal('show')
    this.getSimDevice()
  },
  destroyed () {

  },
  methods: {
    async getSimDevice () {
      if (this.$store.state.modal.datosDymanic.tipo == 'gps') {
        var request = await this.getRequest('devices/sim/' + this.$store.state.modal.datosDymanic.ID)
        console.debug(request)
        if (request.success === true) {
          var val = request.data.sims
          console.debug('VAL', val, val.length)
          if (val.length > 0) {
            console.debug('ENTRA CON SIM', val[0].id)
            this.deviceSims = val[0].id
          } else {
            console.debug('ENTRA SIN SIM')
            this.deviceSims = null
          }
        }
      }
    },
    /**
   * @vuese
   * elimina el gps,sims, o producto generico
   */
    async confirmModal () {
      if (this.$store.state.modal.datosDymanic.tipo == 'gps') {
        var deviceID = this.$store.state.modal.datosDymanic.ID

        var datos = {}
        if (this.deviceSims != null) {
          if (this.comportamiento != 0) {
            datos.simID = this.deviceSims
            datos.StatusSims = parseFloat(this.comportamiento)
          } else {
            $('#alertasModalDelete').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Selecicona que desea hacer con la sims<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
            return false
          }
        }

        var data = {
          'datos': datos,
          'deviceSims': this.deviceSims,
          'comportamiento': this.comportamiento,
          'device': deviceID,
          'item': this.$store.state.modal.datosDymanic.data,
          'sender': this.$store.state.modal.datosDymanic.sender
        }
        console.debug('DATOS', datos)

        // cerrar modal
        $('#modalDelete').modal('hide')
        this.$store.commit('CLEAR_MODAL_DINAMIC')

        EventBus.$emit('eliminar_devices', data)
      }
      if (this.$store.state.modal.datosDymanic.tipo == 'sims') {
        var simsID = this.$store.state.modal.datosDymanic.ID

        var datos = {
          'id': simsID,
          'item': this.$store.state.modal.datosDymanic.item,
          'sender': this.$store.state.modal.datosDymanic.sender
        }

        // cerrar modal
        $('#modalDelete').modal('hide')
        this.$store.commit('CLEAR_MODAL_DINAMIC')
        EventBus.$emit('eliminar_sims', datos)
      }
      if (this.$store.state.modal.datosDymanic.tipo == 'product') {
        var productID = this.$store.state.modal.datosDymanic.ID

        // cerrar modal

        var datos = {
          'id': productID,
          'item': this.$store.state.modal.datosDymanic.item,
          'sender': this.$store.state.modal.datosDymanic.sender
        }

        $('#modalDelete').modal('hide')
        this.$store.commit('CLEAR_MODAL_DINAMIC')

        EventBus.$emit('eliminar_products', datos)
      }
      if (this.$store.state.modal.datosDymanic.tipo == 'kit') {
        var kitID = this.$store.state.modal.datosDymanic.ID

        var request = await this.deleteRequest('kits/' + kitID)

        if (request.success === true) {
          $('#alertasModalDelete').html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha eliminado el kit<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")

          // cerrar modal
          $('#modalDelete').modal('hide')
          this.$store.commit('CLEAR_MODAL_DINAMIC')
          EventBus.$emit('GET_LIST_kits', 1)
        } else {
          $('#alertasModalDelete').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se ha eliminado el kit<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
        }
      }
    },
    cancel () {
      // cerrar modal
      $('#modalDelete').modal('hide')
      this.$store.commit('CLEAR_MODAL_DINAMIC')
    }

  },
  computed: {

  }
}
</script>
