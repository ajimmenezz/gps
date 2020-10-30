<template>
          <!-- MODAL -->

    <div id="modalDeviceParoMotor" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog  " role="document">
          <div class="modal-content">
              <div class="modal-header">
                <div class="col-12 col-fluid">
                  <div class="row">
                    <div class="col-9 text-left">
                    <h5 class="modal-title" id="exampleModalCenterTitle" ><b>{{this.$store.state.devices.devices[this.$store.state.modal.datosDymanic.deviceImei].alias}}</b></h5>
                    </div>
                    <div class="col-2 text-rigth">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                  <div class="col-12 text-left">
                    Habilitar o deshabilitar motor
                  </div>
                  </div>

                </div >
              </div>
              <div class="modal-body " >

                <div class="container">
                  <div class="row">
                    <div class="col-12 text-left">
                      Seleccione la accion a realizar:
                    </div>
                    <div class="col-12" style="margin-top:20px; margin-bottom:30px;">
                      <button id="disableEngineBtn" type="button" class="btn btn-outline-danger float-left" @click="setEngineAction(true)">DESHABILITAR MOTOR</button>
                      <button id="enableEngineBtn" type="button" class="btn btn-outline-success float-rigth" @click="setEngineAction(false)">HABILITAR MOTOR</button>
                    </div>
                    <div class="col-12" v-if="showAlert">
                      <p class="float-left text-left">
                        <span v-if="this.$store.state.modal.datosDymanic.stateParoMotor == false">Se procedera a <b>habilitar</b> el motor de la unidad  '{{this.$store.state.devices.devices[this.$store.state.modal.datosDymanic.deviceImei].alias}}', esta accion permitira que el vehiculo pueda ser <b>encendido</b>.</br></span>
                        <!-- <span v-else>Esta por apagar el vehículo, Esta acción usada de manera inadecuada puede provocar accidentes, si se ejecuta con el automóvil en movimiento.</br>Esta acción se ejecutará hasta que el vehículo no este en movimiento, para evitar accidentes. </span>-->
                          <span v-else><b class="color-danger">PRECAUCIÓN: </b> Se procedera a <b>detener</b> la unidad '{{this.$store.state.devices.devices[this.$store.state.modal.datosDymanic.deviceImei].alias}}',
                          se recomienda realizar esta accion cuando la unidad este en <b>ALTO TOTAL.</b><br><br>
                        </span>
                        <br>
                        <small>Una vez realizada la accion, está no se puede cancelar</small>
                      </p>
                      <!-- @click="toggleStateParoMotor()" -->
                    </div>

                    <div class="col-12 float-left">
                        <div class="col-12" >
                          <config-input  id="passw" label="Contraseña"  typeinput="password"  placeholder="Contraseña" v-model.trim="passwParoMotor" required="true"> </config-input>
                        </div>
                        <div class="col-12" v-if="this.$store.state.modal.datosDymanic.stateParoMotor">
                          <config-input  id="desc" label="Motivo"  typeinput="text"  placeholder="Escriba el motivo en este campo" v-model.trim="descripcionParoMotor" required="true"> </config-input>
                        </div>
                        <div class="col-12" id="alertasM"></div>
                    </div>

                  </div>
                </div>

              </div>
              <div class="modal-footer">

                <div class="col-12">

                  <button id="confirm" type="button" class="btn btn-outline-primary" @click="cancel()">CANCELAR</button>
                  <button id="cancel" type="button" class="btn btn-primary" @click="confirmModal()" >CONFIRMAR</button>
                </div>

              </div>

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
 * Modal para realizar paro de motor
 */
export default {
  name: 'ModalParoMotor',
  mixins: [API],
  data () {
    return {
      markers: new Map(),
      passwParoMotor: null,
      descripcionParoMotor: null,
      showAlert: false
    }
  },
  mounted () {
    $('#modalDeviceParoMotor').modal('show')
    this.$store.state.modal.datosDymanic.stateParoMotor = true
  },
  destroyed () {

  },
  methods: {
    setEngineAction (engineDisabled) {
      this.showAlert = true
      if (engineDisabled) {
        this.$store.state.modal.datosDymanic.stateParoMotor = true
        $('#disableEngineBtn').removeClass('btn-outline-danger')
        $('#disableEngineBtn').addClass('btn-danger')

        $('#enableEngineBtn').addClass('btn-outline-success')
        $('#enableEngineBtn').removeClass('btn-success')
      } else {
        this.$store.state.modal.datosDymanic.stateParoMotor = false
        $('#disableEngineBtn').addClass('btn-outline-danger')
        $('#disableEngineBtn').removeClass('btn-danger')

        $('#enableEngineBtn').removeClass('btn-outline-success')
        $('#enableEngineBtn').addClass('btn-success')
      }
    },
    toggleStateParoMotor () {
      this.$store.state.modal.datosDymanic.stateParoMotor = !this.$store.state.modal.datosDymanic.stateParoMotor
    },
    cancel () {
      $('#modalDeviceParoMotor').modal('hide')
      this.$store.commit('CLEAR_MODAL_DINAMIC')
    },
    /**
   * @vuese
   * Si confirma el paro de motor, verifica que exista una contraseña, que no este expirada y sea correcta si esto es correcto madna a realizar el paro
   */
    async confirmModal () {
      if (!this.$store.state.ws.connected) {
        $('#alertasM').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>El servidor se encuentra fuera de línea, por lo que no se puede realizar la petición<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
        setTimeout(() => {
          $('#alertasM').html('')
        }, 5000)
        return false
      }
      var deviceImei = this.$store.state.modal.datosDymanic.deviceImei
      var stateMotor = this.$store.state.modal.datosDymanic.stateParoMotor

      if (stateMotor) {
        // Motor Habilitado, deshabilitar motor para que no pueda enceder vehiculo
        if ((this.descripcionParoMotor !== null && this.descripcionParoMotor !== '') && (this.passwParoMotor !== null && this.passwParoMotor !== '')) {
          var respApi = this.passwordExist()
          if (respApi) { // existe
            var validatePass = await this.isPassword()
            if (validatePass) {
              var timeExpiridPassword = await this.passwordExpired()
              if (timeExpiridPassword != false) {
                var timesNow = Math.floor(Date.now() / 1000)
                console.debug('timestampsNow', timesNow, timeExpiridPassword)
                if (timeExpiridPassword >= timesNow) { // no expirada
                  console.debug('no ha expirado')
                  this.WS_SET_IGNITION(deviceImei, false)
                } else {
                  timeExpiridPassword = false
                }
              }
              if (!timeExpiridPassword) { // esta expirada
                $('#alertasM').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>La contraseña ha expirado. <br>Ve a configuracion > dispositivos, y reseta la contraseña<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
                setTimeout(() => {
                  $('#alertasM').html('')
                }, 5000)
              }
            } else {
              $('#alertasM').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>La contraseña no es correcta<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
              setTimeout(() => {
                $('#alertasM').html('')
              }, 5000)
            }
          } else {
            $('#alertasM').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se ha establecido una contraseña. <br>Ve a configuracion > dispositivos, y crea una contraseña<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
            setTimeout(() => {
              $('#alertasM').html('')
            }, 5000)
          }
        } else {
          $('#alertasM').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Por favor ingresa todos los campos <button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
          setTimeout(() => {
            $('#alertasM').html('')
          }, 3000)
        }
      } else {
        // Moto Deshabilitado, Habilitar motor para permitir que el vehiculo encienda
        if (this.passwParoMotor !== null && this.passwParoMotor !== '') {
          console.debug('no tiene paro')
          var respApi = await this.passwordExist()
          if (respApi) { // existe
            var validatePass = await this.isPassword()
            if (validatePass) {
              var timeExpiridPassword = await this.passwordExpired()
              if (timeExpiridPassword != false) {
                var timesNow = Math.floor(Date.now() / 1000)
                console.debug('timestampsNow', timesNow, timeExpiridPassword)
                if (timeExpiridPassword >= timesNow) { // no expirada
                  console.debug('no ha expirado')
                  this.WS_SET_IGNITION(deviceImei, true)
                } else {
                  timeExpiridPassword = false
                }
              }
              if (!timeExpiridPassword) { // esta expirada
                $('#alertasM').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>La contraseña ha expirado. <br>Ve a configuracion > dispositivos, y reseta la contraseña<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
                setTimeout(() => {
                  $('#alertasM').html('')
                }, 5000)
              }
            } else {
              $('#alertasM').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>La contraseña no es correcta<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
              setTimeout(() => {
                $('#alertasM').html('')
              }, 5000)
            }
          } else {
            $('#alertasM').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se ha establecido una contraseña. <br>Ve a configuracion > dispositivos, y crea una contraseña<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
            setTimeout(() => {
              $('#alertasM').html('')
            }, 5000)
          }
        } else {
          $('#alertasM').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Por favor ingresa la contraseña <button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
          setTimeout(() => {
            $('#alertasM').html('')
          }, 3000)
        }
      }
    },
    /**
   * @vuese
   * Manda a realizar el paro de motor por webSocket
   */
    WS_SET_IGNITION (deviceImei, stateParoMotor) {
      // cerrar modal

      $('#modalDeviceParoMotor').modal('hide')
      // this.$store.commit('CLEAR_MODAL_DINAMIC')
      // llamada websocret

      var payload = {
        'imei': deviceImei,
        'status': stateParoMotor,
        'eventPassword': this.passwParoMotor

      }
      this.$store.dispatch('ws/SET_ENGINE', payload)
    },
    /**
   * @vuese
   * Valida la contraseña de paro de motor
   */
    async isPassword () {
      // llamada api para obtener estatus de contraseña
      var respuesta

      // configuration/eventpassword/exists
      var data = {
        'password': this.passwParoMotor
      }

      var request = await this.getRequest('configuration/eventpassword/validate', data)
      console.debug('requesPasswordValidate', request, data)
      if (request.success === true) {
        respuesta = request.data.isValidEventPassword // request.data.eventPasswordExists
      } else {
        respuesta = false
      }

      return respuesta
    },
    /**
   * @vuese
   * Valida si existe contraseña de paro de motor
   */
    async passwordExist () {
      // llamada api para obtener estatus de contraseña
      var respuesta

      var request = await this.getRequest('configuration/eventpassword/exists')
      console.debug('requesPassword', request)
      if (request.success === true) {
        respuesta = request.data.eventPasswordExists
      } else {
        respuesta = false
      }

      return respuesta
    },
    /**
   * @vuese
   * Valida si no ha expirado la contraseña de paro de motor
   */
    async passwordExpired () {
      // llamada api para obtener ver ya expiro
      var respuesta

      var request = await this.getRequest('configuration/eventpassword/expiration')
      console.debug('expiration', request)
      if (request.success === true) {
        respuesta = request.data.timestampExpiration
      } else {
        respuesta = false
      }

      this.PasswordExpired = respuesta
      return respuesta
    },
    DeviceParoMotor (deviceImei, stateParoMotor) {
      // comunicacion backend

      var markerName
      if (stateParoMotor == false) {
        markerName = 'MARKER_CANCEL_RED'
        $('#alertasM').html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha realizado el paro de motor</div>")
      } else {
        markerName = this.$store.state.devices.devices[deviceImei].marker.name
        $('#alertasM').html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha cancelado el paro de motor</div>")
      }

      // ocultar iconos y poner realizando paro
      this.$store.state.devices.devices[deviceImei].iconGestionDevices = false

      // cerrar modal
      setTimeout(() => {
        $('#modalDeviceParoMotor').modal('hide')
        this.$store.commit('CLEAR_MODAL_DINAMIC')
      }, 1000)

      // mostrar realizando paro de motor despues de 5 seg hacerlo.

      setTimeout(() => {
        this.$store.state.devices.devices[deviceImei].report.states.engineEnabled = stateParoMotor
        this.$store.state.devices.devices[deviceImei].iconGestionDevices = true
        var params = { 'imei': deviceImei, 'markerName': markerName }
        EventBus.$emit('SET_MARKER_ICON', params)
      }, 5000)
      //
    }
  },
  computed: {

  }
}
</script>
