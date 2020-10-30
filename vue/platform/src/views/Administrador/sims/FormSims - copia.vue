<template>
          <!-- MODAL -->

    <div id="modalAdminSims" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog  modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalCenterTitle" v-if="this.accion=='nueva'">Nueva sims</h5>
                  <h5 class="modal-title" id="exampleModalCenterTitle" v-if="this.accion=='editar'">Editar sims</h5>

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
               <form @submit.prevent >
              <div class="modal-body float-left" >

                <p v-if="this.$store.state.modal.datosDymanic.idCliente != 0" class="text-muted">La sim se agregará en el almacén del cliente: <b>{{this.$store.state.modal.datosDymanic.nameClient}}</b></p>
                <p v-else>La sim se agregará en tú almacén</p>

                  <div class="row">

                    <div class="col-12 col-md-4">
                      <div class="form-group">
                        <label for="carrier">Compañia</label>
                        <select class="form-control" id="carrier" v-model="carrier" :valor="carrier"  required>
                            <option value="">Selecciona</option>
                            <option v-for="carrier in listCarries" :value="carrier.id" :key="carrier.id">{{carrier.name}}</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <config-input  id="icc" label="ICC"  typeinput="text"  placeholder="ICC" v-model.trim="icc" required="false" :valor="icc"></config-input>
                    </div>
                    <div class="col-12 col-md-4">
                        <config-input  id="tel" label="Teléfono"  typeinput="text"  placeholder="Teléfono" v-model.trim="telefono" required="true" :valor="telefono"></config-input>
                    </div>

                    <div class="col-12 col-md-4">
                      <div class="form-group">
                        <label for="plan">Plan</label>
                        <select class="form-control" id="plan" v-model="plan" :valor="plan"  required>

                            <option v-for="plan in listPlan" :value="plan.id" :key="plan.id">{{plan.name}}</option>
                        </select>
                      </div>
                    </div>
                     <!-- <div class="col-12 col-md-4">
                      <div class="form-group">
                        <label for="device">Dispositivo</label>
                        <select class="form-control" id="device" v-model="device" :valor="device"  >
                            <option value="">Selecciona</option>
                            <option v-for="factory in listFactories" :value="factory.id" :key="factory.id">{{factory.factory}}</option>
                        </select>
                      </div>
                    </div> -->
                    <div class="col-12 ">
                        <config-input  id="notas" label="Notas"  typeinput="text"  placeholder="Notas" v-model.trim="notas" required="false" :valor="notas"></config-input>
                    </div>

                  </div>

                  <div class="row"><div class="col-12" id="alertAdminSims"></div></div>

              </div> <!-- fin card body -->
              <div class="modal-footer">
                   <button class="btn btn-secondary shadow-2 mb-4 float-left"@click="cancel()" >CANCELAR</button>
                    <button class="btn btn-primary shadow-2 mb-4 float-right" @click="SendForm()" type="submit" v-if="this.$store.state.modal.datosDymanic.accion === 'nueva'" >REGISTRAR</button>
                    <button class="btn btn-primary shadow-2 mb-4 float-right" @click="SendForm()" type="submit" v-if="this.$store.state.modal.datosDymanic.accion === 'editar'" >EDITAR</button>

              </div>
              </form>

          </div>
      </div>
    </div>

    <!-- fin modal -->
</template>

<script>
import { API } from '@/mixins/API'
import EventBus from '@/EventBus'
/**
* @vuese
 * @group Administrador/Distribuidor
 * Modal para registrar Sims
 */
export default {
  name: 'ModalFormSims',
  mixins: [API],
  data () {
    return {
      carrier: '',
      icc: null,
      iccOrigin: null,
      telefono: null,
      telefonOrigin: null,
      plan: 5,
      notas: null,
      listCarries: [],
      device: '',
      listPlan: [],
      accion: this.$store.state.modal.datosDymanic.accion

    }
  },
  async created () {
    this.catCarrier()
    this.catPlan()
    if (this.accion == 'editar') {
      this.getsimsInfo()
    }
  },
  async mounted () {
    this.$store.state.loader = false
    $('#modalAdminSims').modal('show')
  },
  destroyed () {

  },
  methods: {
    /**
   * @vuese
   * Obtiene catalogo de compañias telefonicas
   */
    async catCarrier () {
      var request = await this.getRequest('catalogs/sims/carriers')

      if (request.success === true) {
        this.listCarries = request.data.simCarriers
      }
    },
    /**
   * @vuese
   * Obtiene catalogo de plan de operacion de sims
   */
    async catPlan () {
      var request = await this.getRequest('catalogs/sims/plan')

      if (request.success === true) {
        this.listPlan = request.data.simPlans
      }
    },
    /**
   * @vuese
   * Envia datos y registra un gps
   */
    async SendForm () {
      if (this.carrier != '' && this.telefono != null) {
        this.$store.state.loader = true
        if (this.accion === 'nueva') {
          var sims = {
            'carrier': this.carrier,
            'deviceID': this.device,
            'icc': this.icc,
            'planID': this.plan,
            'phone': this.telefono,
            'notes': this.notas
          }

          if (this.$store.state.modal.datosDymanic.idCliente != 0) {
            sims.clientID = this.$store.state.modal.datosDymanic.idCliente
          }

          var datos = {}

          datos['sims'] = sims

          console.debug('DATOS', datos)

          var request = await this.postRequest('sims', datos)

          if (request.success === true) {
            this.$store.state.loader = false
            $('#alertAdminSims').html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha registrado la sims<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
            setTimeout(() => {
              $('#alertAdminSims').html('')
              this.cancel()
              EventBus.$emit('GET_LIST_sims', 1)
            }, 3000)
          } else {
            this.$store.state.loader = false
            var message = ''
            switch (request.error.title) {
              case 'SIMS_EXISTS':
                message = 'El número de sims ya existe'
                break
              case 'UNAUTHORIZED':
                message = 'No cuenta con los permisos para realizar la accion'
                break
              default:
                message = 'No se ha registrado la sims'
                break
            }

            $('#alertAdminSims').html(`<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>${message}<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>`)
          }
        }
        if (this.accion === 'editar') {
          var sims = {
            'carrier': this.carrier,
            'planID': this.plan,

            'notes': this.notas
          }

          if (this.icc != this.iccOrigin) {
            sims.icc = this.icc
          }
          if (this.telefono != this.telefonOrigin) {
            sims.phone = this.telefono
          }

          var datos = {}

          datos['sims'] = sims

          console.debug('DATOS', datos)

          var request = await this.putRequest('sims/' + this.$store.state.modal.datosDymanic.id, datos)

          if (request.success === true) {
            this.$store.state.loader = false
            $('#alertAdminSims').html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha actualizado la sims<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
            setTimeout(() => {
              $('#alertAdminSims').html('')
              this.cancel()
              EventBus.$emit('GET_LIST_sims', 1)
            }, 3000)
          } else {
            this.$store.state.loader = false
            var message = ''
            switch (request.error.title) {
              case 'SIMS_EXISTS':
                message = 'El número de sims ya existe'
                break
              case 'ICC_EXISTS':
                message = 'El icc de sims ya existe'
                break
              case 'UNAUTHORIZED':
                message = 'No cuenta con los permisos para realizar la accion'
                break
              default:
                message = 'No se ha actualizado la sims'
                break
            }

            $('#alertAdminSims').html(`<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>${message}<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>`)
          }
        }
      }
    },
    /**
   * @vuese
   * obtiene datos de sims
   */
    async getsimsInfo () {
      var response = await this.getRequest(`sims/${this.$store.state.modal.datosDymanic.id}`)
      var simsInfo = response.data.sims
      console.debug(simsInfo)

      this.carrier = simsInfo[0].idCompañiaTelefonica
      this.icc = simsInfo[0].icc
      this.iccOrigin = simsInfo[0].icc
      this.telefono = simsInfo[0].telefono
      this.telefonOrigin = simsInfo[0].telefono
      this.plan = simsInfo[0].idPlan
      this.notas = simsInfo[0].notas
    },
    cancel () {
      this.$store.commit('CLEAR_MODAL_DINAMIC')

      $('#modalAdminSims').modal('hide')
    }

  },
  computed: {
  }
}
</script>
