<template>
    <!-- <div class="col-lg-12">
        <div class="col-md-4 offset-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="modal-title" id="exampleModalCenterTitle" v-if="havePassword">Resetear Contraseña</h5>
                    <h5 class="modal-title" id="exampleModalCenterTitle" v-else>Nueva Contraseña</h5>
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <p class="float-left">
                                    <span class="col-12" v-if="havePassword">Usa el formulario de abajo para cambiar la Contraseña<br></span>
                                    <span class="col-12" v-else>Actualmente no cuenta con una contraseña para confirmar eventos con sus dispositivos. Puede definir una contraseña llenando los campos solicitados.<br></span>
                                    <div class="col-12" >
                                        <config-input  id="passw" label="null"  typeinput="password"  placeholder="Nueva Contraseña" required="true"> </config-input>
                                    </div>
                                    <div class="col-12" >
                                        <config-input  id="checkPassw" label="null"  typeinput="password"  placeholder="Repite Nueva Contraseña" required="true"> </config-input>
                                    </div>
                                    <div id="confirmar" v-if="havePassword">
                                        <button v-if="confirmPassw" id='cancelar' type='button' class='btn btn-danger' @click="confirmPassw=!confirmPassw">CANCELAR</button>
                                        <button v-if="confirmPassw" id='guardar' type='button' class='btn btn-primary' @click='saveEventPassword()'>ACEPTAR</button>
                                        <button v-else type="button" class="btn btn-primary" @click="confirmPassw=!confirmPassw">RESETEAR</button>
                                    </div>
                                    <div id="guardar" v-else>
                                        <button type="button" class="btn btn-primary" @click="saveEventPassword()">GUARDAR</button>
                                    </div>
                                </p>
                                <span class="col-12" @click="showPoliciesPanel()" style="cursor: pointer">Politicas de uso</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-12" >
                        <p class="float-left" v-if="havePassword">
                            <span>Nota: Esta contraseña se utiliza para activar diferentes eventos de los dispositivos. Por lo que se recomienda utilizar con precaución</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <div class=" row justify-content-md-center">
      <div class="col-12"> <h5 class="float-left" style="font-size: 20px; padding-bottom: 10px;"><b>Configurar dispositivos - Contraseña de eventos</b></h5></div>
        <div class="col-12 col-md-6">
            <div class="card">
                <h5 class="card-header" v-if="statusPasswordFirst">Nueva contraseña</h5>
                <h5 class="card-header" v-if="!statusPasswordFirst">Resetear contraseña</h5>
                <div class="card-body">

                    <p class="card-text" v-if="statusPasswordFirst">Actualmente no cuenta con una contraseña para confirmar eventos con sus dispositivos.  Puede definir una contraseña llenando lo campos solicitados.</p>
                    <p class="card-text" v-if="!statusPasswordFirst">Usa el formulario de abajo para cambiar la  contraseña.</p>
                    <p class="card-text" v-if="!passwordExpired">Usa el formulario de abajo para cambiar la  contraseña.</p>

                    <div class="row justify-content-center">
                        <div class="col-8">
                             <config-input  id="pwd" label="null"  typeinput="password"  placeholder="Contraseña" v-model.trim="passw" :valor="passw" required="true" :disabled="resetea"> </config-input>
                              <config-input  id="pwd2" label="null"  typeinput="password"  placeholder="Confirma contraseña" v-model.trim="confirmPassw" :valor="confirmPassw" required="true" :disabled="resetea"> </config-input>
                        </div>
                    </div>
                    <div class="col-12" id="alertasCP"></div>
                    <div class="row justify-content-center">
                        <div class="col-5">
                            <button id="cancel" type="button" class="btn btn-secondary"  @click="cancelar()">CANCELAR</button>
                        </div>
                        <div class="col-5">
                            <button id="confirm" type="button" class="btn btn-primary" @click="saveEventPassword()" v-if="statusPasswordFirst || (!statusPasswordFirst && !resetea)">GUARDAR</button>
                            <button id="confirm" type="button" class="btn btn-primary" @click="funResetea()" v-if="!statusPasswordFirst && resetea">RESETEAR</button>

                        </div>
                    </div>

                    <div class="col-12" style="margin-top: 15px;">
                      <p class="text-muted"><b>Nota:</b> Esta contraseña se utiliza para activar diferentes eventos de los dispositivo.  Por lo que se recomienda utilizar con precaución</p>
                    </div>

                    <div class="col-12" style="margin-top: 30px;">
                        <span class="col-12 text-muted " @click="showPoliciesPanel()" style="cursor: pointer">Politicas de uso</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { API } from '@/mixins/API'
import politicas from '@/views/Modals/panelPolicies'
import { ValidateVariables } from '@/mixins/ValidateVariables.js'

export default {
  name: 'no',
  mixins: [ValidateVariables, API],
  components: {
    politicas
  },
  data () {
    return {
      havePassword: false,
      passwEvent: null,
      checkPasswEvent: null,
      confirmPassw: '',
      passw: '',
      resetea: true,
      statusPasswordFirst: false,
      PasswordExpired: false
    }
  },
  async created () {
    // this.havePassword = true
    await this.passwordExist()
  },
  async mounted () {
    this.$store.state.submenuActive = 'config'
    this.$store.state.itemSubmenuActive = 'itemDevice'
    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })
  },
  methods: {
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

      if (respuesta) {
        this.statusPasswordFirst = false
      } else {
        this.statusPasswordFirs = true
      }

      if (this.statusPasswordFirst) {
        this.resetea = false
      } else {
        this.resetea = true
      }

      if (this.resetea) {
        $('#pwd').attr('disabled', 'disabled')
        $('#pwd2').attr('disabled', 'disabled')
      }
      if (!this.resetea) {
        $('#pwd').removeAttr('disabled')
        $('#pwd2').removeAttr('disabled')
      }

      return respuesta
    },
    async passwordExpired () {
      // llamada api para obtener ver ya expiro
      var respuesta
      var request = await this.getRequest('configuration/eventpassword/expiration')

      if (request.success === true) {
        respuesta = request.data.timestampExpiration
      } else {
        respuesta = false
      }

      if (respuesta != false) {
        var timesNow = Math.floor(Date.now() / 1000)
        console.debug('timestampsNow', timesNow, respuesta)
        if (timesNow <= respuesta) { // no expirada
          console.debug('No ha expirado')
          respuesta = true
        } else {
          console.debug('ya expiro')
          respuesta = false
        }
        this.resetea = false
      }
      this.PasswordExpired = respuesta
      return respuesta
    },
    funResetea () {
      this.resetea = false

      $('#pwd').removeAttr('disabled')
      $('#pwd2').removeAttr('disabled')
    },
    async saveEventPassword () {
      // agregar la validacion del password y su respectivo envio a backend

      if ((this.passw !== '' && this.confirmPassw !== '') && (this.passw !== null && this.confirmPassw !== null)) {
        var checkPass = this.ValidatePassword(this.passw, this.confirmPassw)
        if (checkPass === 1) {
          // guardar
          var datos = {
            'password': this.passw
          }
          var request = await this.putRequest('configuration/eventpassword', datos)
          console.log('RESPUESTA', request)
          if (request.success === true) {
            $('#alertasCP').html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha guardado la contraseña. </br> Por favor revisar su correo donde se le ha mandado la nueva contraseña. Se recomienda leer las políticas de uso antes de utilizar la contraseña en el sistema.<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
            setTimeout(() => {
              console.log('setTime')
              $('#alertasCP').html('')
              this.cancelar()
            }, 6000)
          } else {
            $('#alertasCP').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se ha guardado la contraseña<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
          }
        }
        if (checkPass === 0) {
          $('#alertasCP').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>La contraseña debe contener como minimo 8 caracteres (entre ellos: mayúsculas, minúculas, números y caracteres especiales) <button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
        }
      } else {
        $('#alertasCP').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Por favor ingresa todos los campos <button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
        setTimeout(() => {
          $('#alertasCP').html('')
        }, 3000)
      }
    },
    cancelar () {
      this.passw = null
      this.confirmPassw = null
      this.$router.push('/listDevice')
    },
    async showPoliciesPanel () {
      this.$store.commit('CLEAR_MODAL_DINAMIC')
      var datos = {
        'component': politicas
      }
      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)
      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
    }
  }
}

</script>
