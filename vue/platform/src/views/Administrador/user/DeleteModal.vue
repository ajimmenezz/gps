<template>
          <!-- MODAL -->

    <div id="modalDelete" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered " role="document">
          <div class="modal-content">

              <div class="modal-body m-10">

                <div class="container">

                  <div class="row">
                    <div class="col-12" style="color: #007bff;">
                        <h5 style="color: #007bff;" class="modal-title float-left" id="exampleModalCenterTitle">Eliminar {{tipo}}</h5>
                        <hr style="margin-top: 25px; background: #007bff;">
                    </div>
                  </div>

                  <div class="row justify-content-center m-20">

                    <div class="col-10">
                        <p >¿Estás seguro que deseas eliminar el {{tipo}} <b>{{this.$store.state.modal.datosDymanic.name}} </b>?</p>
                    </div>

                  </div>

                    <div class="row justify-content-center">
                      <div class="col-6">
                         <button type="button" class="btn btn-outline-primary float-right" data-dismiss="modal" @click="cancel()">CANCELAR</button>
                      </div>
                      <div class="col-6">
                          <button type="button" id="btnRegist" class="btn btn-primary float-left" @click="confirmModal()">ACEPTAR</button>
                      </div>
                    </div>

                     <div class="col-12" id="alertDelete" style="margin-top:20px;"></div>

                </div>

              </div>

              <div id="alertDelete"></div>

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
 * Modal para elimnar un cliente o distribuidor
 */
export default {
  name: 'ModalEliminarClientDist',
  mixins: [API],
  data () {
    return {
      tipo: ''
    }
  },
  created () {
    if (this.$store.state.modal.datosDymanic.seccion == 1) {
      this.tipo = 'cliente'
    }
    if (this.$store.state.modal.datosDymanic.seccion == 2) {
      this.tipo = 'distribuidor'
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
   * Elimina distribuidor o cliente
   */
    async confirmModal () {
      this.$store.state.loader = true
      var clientes = []
      var productos = []
      var dist = ''
      var datos = {}

      if (this.$store.state.modal.datosDymanic.seccion == 2) {
        if (this.$store.state.modal.datosDymanic.customers.length > 0) {
          this.$store.state.modal.datosDymanic.customers.forEach(element => {
            clientes.push(parseInt(element.id))
          })
        }

        if (this.$store.state.modal.datosDymanic.distransf != null && this.$store.state.modal.datosDymanic.distransf != '') {
          dist = parseInt(this.$store.state.modal.datosDymanic.distransf)
        }

        datos = {
          'transferClients': {
            distributorID: dist,
            clients: clientes
          }
        }
      }

      if (this.$store.state.modal.datosDymanic.products.length > 0) {
        this.$store.state.modal.datosDymanic.products.forEach(element => {
          productos.push({ id: parseInt(element.id), type: parseInt(element.type) })
        })
      }

      datos.transfers = productos

      console.debug('DATOS', datos)
      var request = await this.deleteRequest('accounts/' + this.$store.state.modal.datosDymanic.clientID, {}, datos)

      console.debug('RESP', request)

      if (request.success === true) {
        $('#btnRegist').attr('disabled', 'disabled')
        this.$store.state.loader = false
        $('#alertDelete').html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha eliminado el " + this.tipo + "<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")

        setTimeout(() => {
          $('#alertDelete').html('')
          this.cancel()
        }, 5000)

        this.cancel()
      } else {
        this.$store.state.loader = false
        $('#alertDelete').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se ha eliminado el " + this.tipo + "<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
      }
    },
    cancel () {
      // cerrar modal
      $('#modalDelete').modal('hide')
      var seccion = this.$store.state.modal.datosDymanic.seccion
      this.$store.commit('CLEAR_MODAL_DINAMIC')

      if (seccion == 1) {
        this.$router.push(`/ListaCliente`)
      }
      if (seccion == 2) {
        this.$router.push(`/ListTableDistrobuitor`)
      }
    }

  },
  computed: {

  }
}
</script>
