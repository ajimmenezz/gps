<template>
    <div>

      <div class="auth-wrapper aut-bg-img-side cotainer-fiuid align-items-stretch" v-if="isVisibleChangePassw">
        <div class="row align-items-center w-100 align-items-stretch bg-white">
            <div class="d-none d-lg-flex col-lg-8 login-img-bg align-items-center d-flex justify-content-center">

                <div class="col-md-8">
                    <h5 class="text-white mb-5">&nbsp;</h5>

                    <h5 class="text-white mb-5" v-if="loginFirst">Hemos detectado que es la primera vez que ingresas.</br> Por seguridad, <b>Favor de cambiar su contraseña</b>, para continuar.</h5>
                </div>

            </div>
            <div class="col-lg-4 align-items-stret h-100 align-items-center d-flex justify-content-center">
                <div class=" auth-content text-center">

                    <!-- <div class="row" v-if="loginFirst">
											<div class="col-sm-12" style="background-color: #cce5ff; color: #1c7aa5; border-color: #b9e7fc; text-align: justify;">
															<p>Hemos detectado que es la primera vez que ingresas.</br> Por seguridad, <b>Favor de cambiar su contraseña</b>, para continuar.</p>
											</div>
									  </div> -->

                    <div class="mb-4">
                        <img class="img-fluid" :src="`${logoGet}logo.png`">
                    </div>

                    <h3 class="mb-4">Cambiar contraseña</h3>

                      <form @submit.prevent autocomplete="off">

                        <div class="col-md-12">
                          <config-input  id="passw" label="null"  typeinput="password"  placeholder="Contraseña nueva" v-model.trim="passw" required="true"> </config-input>

                        </div>

                        <div class="col-md-12">
                          <config-input  id="confirmPassw" label="null"  typeinput="password"  placeholder="Confirma contraseña" v-model.trim="confirmPassw" required="true"> </config-input>

                            <div id="alertas" ></div>
                        </div>

												<button class="btn btn-primary shadow-2 mb-4" @click="savePassword()">GUARDAR</button>

                      </form>

                      <div  class="row" >
                        <div class="col-sm-12" style="text-align: justify; color:#888;">
                          <p><b>Nota: </b> La contraseña debe contener como minimo 8 caracteres (entre ellos: mayúsculas, minúculas, números y caracteres especiales (.-#$&%))</p>

                        </div>
                      </div>

                </div>
            </div>
        </div>
      </div>

    </div>
</template>

<script>

import { Login } from '@/mixins/Login.js'
import { ValidateVariables } from '@/mixins/ValidateVariables.js'
import { SecureStorage } from '@/mixins/SecureStorage.js'
/**
 * @group Login
 * Formulario para recuperar contraseña de acceso
 */
export default {
  name: 'FormularioRecuperarContrasenia',
  mixins: [Login, ValidateVariables, SecureStorage],
  data () {
    return {
      passw: '',
      confirmPassw: '',
      token: this.$route.params.token,
      userRecover: '',
      visibleChangePassw: false,
      Getlogo: localStorage.getItem('imgLogo')
    }
  },
  mounted () {
    this.validateToken()
    this.Getlogo = localStorage.getItem('imgLogo')
  },
  methods: {
    /**
   * @vuese
   * valida que el token del usuario
   */
    validateToken () {
      const datos = {
        'url': this.$store.state.apiUrl,
        'token': this.token
      }

      this.isValidateToken(datos)
        .then(async (res) => {
          if (res.success === true) {
            this.visibleChangePassw = true
          } else {
            this.$router.push({ name: 'errorValidate' })
          }
        })
        .catch((err) => {
          console.log('error', err)
        })
    },
    /**
   * @vuese
   * Actualiza la contraseña del usuario
   */
    savePassword () {
      if (this.passw !== '' && this.confirmPassw !== '') {
        this.$store.state.loader = true
        var checkPass = this.ValidatePassword(this.passw, this.confirmPassw)
        console.debug(checkPass)
        if (checkPass === 1) {
          const datos = {
            'password': this.passw,
            'url': this.$store.state.apiUrl,
            'token': this.token
          }

          this.changePassword(datos)
            .then(async (res) => {
              if (res.success === true) {
                this.userRecover = res.data.user
                $('#alertas').html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>excelente! </strong>Se ha cambiado la contraseña <button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
                await setTimeout(this.redirecPage(), 7000)
              } else {
                this.$store.state.loader = false
                $('#alertas').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>" + res.error.message + "<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
              }
            })
            .catch((err) => {
              console.log('error', err)
            })
        }
        if (checkPass === 0) {
          this.$store.state.loader = false
          $('#alertas').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>La contraseña debe contener como minimo 8 caracteres (entre ellos: mayúsculas, minúculas, números y caracteres especiales) <button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
        }
        if (checkPass === 2) {
          this.$store.state.loader = false
          $('#alertas').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Las constraseñas no coinciden <button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
        }
      }
    },
    /**
   * @vuese
   * Redirige a la la suiene paguina ya sea logeo automatico o volver al inicio
   */
    async redirecPage () {
      console.log('entraredirec', sessionStorage.firstLogin)
      if (sessionStorage.firstLogin !== undefined) {
        if (sessionStorage.firstLogin === 'true' || sessionStorage.firstLogin === true) { // primera vez
          console.debug('redirecHome')
          this.$store.dispatch('showMenu', true)
          // sessionStorage.setItem('logged', true)
          this.sessionSet('logged', true)
          var data = {
            session: {
              isFirstTimeLogin: sessionStorage.firstLogin,
              userType: sessionStorage.UT,
              clientType: sessionStorage.TC
            }
          }
          await this.$store.dispatch('SuccessLogin', data)
          await this.$store.dispatch('loginFirstTime', false)
          this.$store.state.loader = false
          this.$router.push({ name: 'home' })
        } else {
          this.$store.state.loader = false
          // TODO: Poner todas las variables para iniciar sesion correctamente
          // console.debug('redireclogin2')
          // this.sessionSet('logged', true)
          this.$router.push({ name: 'home' })
        }
      } else {
        console.debug('redirecHomeEmail')
        const datos = {
          'user': this.userRecover,
          'password': this.passw,
          'url': process.env.VUE_APP_API_URL
        }

        this.login(datos)
          .then(async (res) => {
            if (res.success === true) {
              this.sessionSet('token', res.data.session.token)
              this.sessionSet('timezone', res.data.session.timezone)
              this.sessionSet('loginFist', res.data.session.isFirstTimeLogin)
              this.sessionSet('client', res.data.session.client)
              this.sessionSet('user', res.data.session.user)

              sessionStorage.setItem('firstLogin', res.data.session.isFirstTimeLogin)
              sessionStorage.setItem('TC', res.data.session.clientType)
              sessionStorage.setItem('UT', res.data.session.userType)

              var result = await this.getlogoUser_login(this.user)

              this.Getlogo = localStorage.getItem('imgLogo')
              this.$store.state.modaloader.Getlogo = this.Getlogo

              await this.$store.commit('menuOptions', res.data.session.permissions)

              await this.$store.dispatch('devices/LOAD_DEVICES', res.data.devices)

              /* carga array flotillas */

              var fleets = res.data.fleets
              await this.$store.dispatch('devices/LOAD_FLEETS', fleets)
              this.$store.state.devices.fleets.push({ 'id': null, 'name': 'SIN ASIGNAR', 'selected': false, 'iconCollapse': true })

              await this.$store.dispatch('SuccessLogin', res.data)
              this.sessionSet('logged', true)
              this.$store.dispatch('showMenu', true)
              await this.$store.dispatch('loginFirstTime', false)

              this.$store.state.loader = false
              this.$router.push({ name: 'home' })
            } else {
              this.$store.state.loader = false
              var message = ''
              switch (res.error.title) {
                case 'PROVIDER_SUSPEND':
                  message = 'El PROVEEDOR de servicio se encuentra suspendido, por favor comunicate con él para poder acceder a la plataforma.'
                  break
                case 'ACCOUNT_SUSPEND':
                  message = 'La CUENTA se encuentra suspendida, por favor comunicate con soporte.'
                  break
                case 'USER_SUSPEND':
                  message = 'El USUARIO se encuentra suspendido, por favor comunicate con soporte.'
                  break
                default:
                  message = 'El usuario/contraseña son incorrectos.'
                  break
              }
              $('#alertas').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>" + message + "<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
            }
          })
          .catch((err) => {
            console.log('error', err)
          })
      }
    }

  },
  computed: {
    logoGet () {
      return this.Getlogo
    },
    /**
   * @vuese
   * Ver si es la primera vez que se logea el usuario
   */
    loginFirst () {
      return this.$store.getters.getloginFirstTime
    },
    isVisibleChangePassw () {
      return this.visibleChangePassw
    }
  }
}
</script>

<style >

  .login-img-bg{
    background-image: url("../../assets/img/fondo_login.jpg");
    background-size: cover;

    background-position: center;

  }

</style>
