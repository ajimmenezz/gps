<template>
          <!-- MODAL -->

    <div id="modalConsultaForm" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg " role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalCenterTitle">Consultar GPS</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body float-left">

                        <div class="row" v-if="getDataDevice">

                            <div class="col-12 col-md-4 mb-4">
                               Marca: <br>
                            <b>{{getDataDevice.deviceBrand}}</b>

                            </div>

                            <div class="col-12 col-md-4 mb-4">
                               Modelo: <br>

                             <b >{{getDataDevice.deviceModel}}</b>

                            </div>

                            <div class="col-12 col-md-4 mb-4">
                                IMEI: <br>
                            <b>{{getDataDevice.imei}}</b>

                            </div>
                            <div class="col-12 col-md-4 mb-4">
                                Alias: <br>
                            <b>{{getDataDevice.alias}}</b>

                            </div>

                            <div class="col-12 col-md-4 mb-4 ">

                                   Notas: <br>
                            <b>{{getDataDevice.notas}}</b>
                            </div>

                        </div>

              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="cancel()">CANCELAR</button>

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
 * Modal para consultar clientes y distribuidores
 */
export default {
  name: 'ModalConsultarClientesDistribuidor',
  mixins: [API],
  data () {
    return {
      dataDevice: null
    }
  },
  async created () {
    await this.getDeviceInfo()
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
   * obtiene datos de gps
   */
    async getDeviceInfo () {
      var response = await this.getRequest(`devices/${this.$store.state.modal.datosDymanic.id}`)
      var deviceAllInfo = response.data.device
      console.debug(deviceAllInfo)
      this.dataDevice = deviceAllInfo
    }

  },
  computed: {
    getDataDevice () {
      return this.dataDevice
    }

  }
}
</script>

<style>

</style>
