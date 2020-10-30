<template>
  <div class="row">
    <div class="col-12">
      <h5 class="float-left" style="font-size: 20px; padding-bottom: 10px;">
        <b>Configurar dispositivos</b>
      </h5>
    </div>

    <div class="col-6 col-md-4" v-if="this.$store.getters.permission(5)">
      <!-- v-if="this.$store.getters.permission(5)" -->

      <div class="card confCardd">
        <h5
          class="card-header"
          style="padding: 15px 25px !important;"
          v-if="statusPasswordFirst"
        >Nueva contraseña</h5>
        <h5
          class="card-header"
          style="padding: 15px 25px !important;"
          v-if="!statusPasswordFirst"
        >Resetear contraseña</h5>
        <div class="card-body" style="padding-top: 10px; text-align: justify; ">
          <p
            class="card-text"
            v-if="statusPasswordFirst"
          >Actualmente no cuenta con una contraseña para confirmar eventos con sus dispositivos. Defina una llenando lo campos solicitados.</p>
          <p
            class="card-text"
            v-if="!statusPasswordFirst"
          >Usa el formulario de abajo para cambiar la contraseña.</p>
          <p
            class="card-text"
            v-if="!passwordExpired"
          >Usa el formulario de abajo para cambiar la contraseña.</p>

          <div class="row">
            <div class="col-12">
              <small v-show="!resetea">
                <i
                  class="icon-md universalicon-info color-light-gray"
                  style="position:absolute"
                >&nbsp;</i>
                <span style="margin-left:25px;">La contraseña debe ser 6 digitos numericos</span>
              </small>
              <config-input
                id="pwd"
                label="null"
                typeinput="password"
                placeholder="Contraseña"
                v-model.trim="passw"
                :valor="passw"
                required="true"
                :disabled="resetea"
              ></config-input>
              <config-input
                id="pwd2"
                label="null"
                typeinput="password"
                placeholder="Confirma contraseña"
                v-model.trim="confirmPassw"
                :valor="confirmPassw"
                required="true"
                :disabled="resetea"
              ></config-input>
            </div>
          </div>
          <div class="col-12" id="alertasCP"></div>
          <div class="row">
            <!--  justify-content-center --->

            <div class="col-12" v-if="!statusPasswordFirst && resetea" style="text-align: center;">
              <button
                id="confirm"
                type="button"
                class="btn btn-primary"
                @click="funResetea()"
              >RESETEAR</button>
            </div>

            <div class="col-12" id="botones_2">
              <div class="row">
                <div class="col-6">
                  <button
                    id="cancel"
                    type="button"
                    class="btn btn-secondary float-left"
                    @click="cancelar()"
                    v-if="statusPasswordFirst || (!statusPasswordFirst && !resetea)"
                  >CANCELAR</button>
                </div>
                <div class="col-6">
                  <button
                    id="confirm"
                    type="button"
                    class="btn btn-primary float-right"
                    @click="saveEventPassword()"
                    v-if="statusPasswordFirst || (!statusPasswordFirst && !resetea)"
                  >GUARDAR</button>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12" style="margin-top: 5px; font-size:12px !important; " id="passwNote">
            <p class="text-muted">
              <b>Nota:</b> Esta contraseña se utiliza para activar diferentes eventos de los dispositivo. Por lo que se recomienda utilizar con precaución
            </p>
          </div>

          <div class="row" id="politicas">
            <div class="col-12" style=" text-align: center; position: absolute; bottom: 5px;">
              <span
                class="col-12 text-muted"
                @click="showPoliciesPanel()"
                style="cursor: pointer"
              >Politicas de uso</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-md-4" v-if="this.$store.getters.permission(6)">
      <!-- v-if="this.$store.getters.permission(6)" -->
      <div class="card confCardd">
        <img class="card-img-top imgCard" src="img/cards/cars.jpg" alt="Card image cap" />
        <div class="card-body">
          <h5 class="card-title">Configuración de dispositivos</h5>
          <p
            class="card-text"
            style="text-align: left;"
          >Consulta, edita y modifica los datos del dispositivo y vehículo, así como el intervalo de reporte en movimiento y detenido del dispositivo.</p>

          <router-link to="/listDevice">
            <button
              type="button"
              class="btn btn-primary"
              style="position: absolute; bottom: 10px;"
            >CONTINUAR</button>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { API } from '@/mixins/API'
import politicas from '@/views/Modals/panelPolicies'
import { ValidateVariables } from '@/mixins/ValidateVariables.js'
import EventBus from '@/EventBus'

/**
 * @group Dispositivos
 * pantalla principal, con el panel para resetear, crear contraseña de eventos y editar dispositivo
 */
export default {
  name: 'MenuPrincipalDispositivos',
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
    await EventBus.$emit('NAVBAR_MenuOpciones', 'config', 'itemDevice')
    $('#containerPrincipal').css({
      'margin-left': this.$store.state.widthMenu
    })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })
  },
  methods: {
    /**
     * @vuese
     * PanelContraseña: verifica si ya ha creado contraseña
     */
    async passwordExist () {
      // llamada api para obtener estatus de contraseña
      var respuesta

      var request = await this.getRequest('configuration/eventpassword/exists')

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
    /**
     * @vuese
     * PanelContraseña: verifica si la cantraseña se encuentra vigente
     */
    async passwordExpired () {
      // llamada api para obtener ver ya expiro
      var respuesta
      var request = await this.getRequest(
        'configuration/eventpassword/expiration'
      )

      if (request.success === true) {
        respuesta = request.data.timestampExpiration
      } else {
        respuesta = false
      }

      if (respuesta != false) {
        var timesNow = Math.floor(Date.now() / 1000)

        if (timesNow <= respuesta) {
          // no expirada
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
    /**
     * @vuese
     * panelContraseña: restablece los valores
     */
    funResetea () {
      this.resetea = false

      $('#pwd').removeAttr('disabled')
      $('#pwd2').removeAttr('disabled')
    },
    /**
     * @vuese
     * PanelContraseña: hace la llamada api y guarda la contraseña ingresada
     */
    async saveEventPassword () {
      // agregar la validacion del password y su respectivo envio a backend

      if (
        this.passw !== '' &&
        this.confirmPassw !== '' &&
        this.passw !== null &&
        this.confirmPassw !== null
      ) {
        var checkPass = this.ValidatePasswordParo(
          this.passw,
          this.confirmPassw
        )
        if (checkPass === 1) {
          // guardar
          var datos = {
            password: this.passw
          }
          var request = await this.putRequest(
            'configuration/eventpassword',
            datos
          )

          if (request.success === true) {
            $('#passwNote').css({ display: 'none' })
            $('#politicas').css({ display: 'none' })
            $('#botones_2').css({ display: 'none' })

            $('#alertasCP').html(
              "<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha guardado la contraseña. </br>Revisa tu correo se te ha mandado la nueva contraseña. Se recomienda leer las políticas de uso antes de utilizar la contraseña.<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>"
            )
            setTimeout(() => {
              console.debug('setTime')
              $('#alertasCP').html('')
              $('#passwNote').css({ display: 'block' })
              $('#politicas').css({ display: 'block' })
              $('#botones_2').css({ display: 'block' })
              this.cancelar()
            }, 6000)
          } else {
            $('#passwNote').css({ display: 'none' })
            $('#alertasCP').html(
              "<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se ha guardado la contraseña<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>"
            )
            setTimeout(() => {
              console.debug('setTime')
              $('#alertasCP').html('')
              $('#passwNote').css({ display: 'block' })
              // this.cancelar()
            }, 6000)
          }
        }
        if (checkPass === 0) {
          $('#passwNote').css({ display: 'none' })
          $('#alertasCP').html(
            "<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>La contraseña debe contener 6 digitos númericos.<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>"
          )
          setTimeout(() => {
            console.debug('setTime')
            $('#alertasCP').html('')
            $('#passwNote').css({ display: 'block' })
            // this.cancelar()
          }, 6000)
        }
        if (checkPass === 2) {
          $('#passwNote').css({ display: 'none' })
          $('#alertasCP').html(
            "<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Las contraseñas no coinciden.<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>"
          )
          setTimeout(() => {
            console.debug('setTime')
            $('#alertasCP').html('')
            $('#passwNote').css({ display: 'block' })
            // this.cancelar()
          }, 6000)
        }
      } else {
        $('#passwNote').css({ display: 'none' })
        $('#alertasCP').html(
          "<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Por favor ingresa todos los campos <button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>"
        )
        setTimeout(() => {
          $('#alertasCP').html('')
          $('#passwNote').css({ display: 'block' })
        }, 3000)
      }
    },
    /**
     * @vuese
     * PanelContraseña: valida que las contraselas seas igual, y cumplan con 6 digitos y solo números
     * @arg `passw`, `compass` contraseñas introducidas
     */
    ValidatePasswordParo (passw, compass) {
      console.debug('validate', passw, compass)
      if (passw === compass) {
        if (passw.length == 6) {
          var numeroTelefono = passw
          var expresionRegular1 = /^([0-9]+){6}$/ // <--- con esto vamos a validar el numero
          var expresionRegular2 = /\s/ // <--- con esto vamos a validar que no tenga espacios en blanco

          if (!expresionRegular2.test(numeroTelefono)) {
            // alert('error existen espacios en blanco')
            if (expresionRegular1.test(numeroTelefono)) {
              // alert('Numero de telefono incorrecto')
              return 1
            }
          }
        }
        return 0
      } else {
        return 2
      }
    },

    /**
     * @vuese
     * cancela el proceso
     */
    cancelar () {
      this.passw = null
      this.confirmPassw = null
      // this.$router.push('/devices')
      this.passwordExist()
    },

    /**
     * @vuese
     * PanelContraseña: abre modal con la información de las politicas de contraseña
     */
    async showPoliciesPanel () {
      this.$store.commit('CLEAR_MODAL_DINAMIC')
      var datos = {
        component: politicas
      }
      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)
      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
    }
  },
  computed: {}
}
</script>

<style>
.confCardd {
  width: 300px;
  height: 450px;
}
.imgCard {
  background-size: cover;

  background-position: center;
  height: 200px;
}
</style>
