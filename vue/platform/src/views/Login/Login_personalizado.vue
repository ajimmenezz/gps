<template>
    <div>

      <div class="auth-wrapper aut-bg-img-side cotainer-fiuid align-items-stretch">
        <div class="row align-items-center w-100 align-items-stretch bg-white">
            <div class="d-none d-lg-flex col-lg-8  align-items-center d-flex justify-content-center login-img-bg" :style="{ 'background-image': 'url(img/fondo_login.jpg)' }">

                <div class="col-md-8">
                    <h1 class="text-white mb-5">&nbsp;</h1>
                    <p class="text-white"></p>
                </div>

            </div>

            <div class="col-lg-4 align-items-stret h-100 align-items-center d-flex justify-content-center">
                <div class=" auth-content text-center">
                    <div class="mb-4" >
                      <img class="img-fluid" :src="`${logoGet}logo.png`" style="height:100px;">
                      <div class="col-12 version" >Rev. {{this.$store.getters.appVersion}} </div>
                    </div>
                    <h3 class="mb-4">Iniciar sesión</h3>

                    <form @submit.prevent >

                      <div class="col-12" >

                        <config-input  id="usr" label="null"  typeinput="text"  placeholder="Usuario" v-model.trim="user" required="true" toLowerUperCase="lowercase"> </config-input>
                      </div>
                      <div class="col-12">

                        <config-input  id="pwd" label="null"  typeinput="password"  placeholder="Contraseña" v-model.trim="passw" required="true"> </config-input>

                        <div id="alertas" v-if="!logged"></div>

                      </div>

                      <button class="btn btn-primary shadow-2 mb-4" @click="Sendlogin()">INGRESAR</button>
                    </form>

                    <router-link to="/login/recover"><p class="mb-2 text-muted">¿Olvidaste tu contraseña?</p></router-link>

                </div>
            </div>
        </div>
      </div>

    </div>
</template>

<script>

import { Login } from '@/mixins/Login.js'
import { API } from '@/mixins/API'
import { Functions } from '@/mixins/Functions'
import { SecureStorage } from '@/mixins/SecureStorage.js'
/**
 * @group Login
 * Formulario de inicio de sesion para acceder a la plataforma
 */
export default {
  name: 'Login_personalizado',
  mixins: [SecureStorage, Login, API, Functions],
 	data () {
    return {
      user: '',
      passw: '',
      paramNameUser: this.$route.params.user,
      Getlogo: localStorage.getItem('imgLogo')
    }
  },
  async created () {
    this.$store.state.loader = true

    console.debug('ENTRA_SI_DEFINIDA_LLAMDA API DE OBTENER LOGO DE USER')

    console.debug('PARAMS_NAME_USER', this.paramNameUser)

    var result = await this.getlogoUser(this.paramNameUser)

    this.Getlogo = localStorage.getItem('imgLogo')
    this.$store.state.modaloader.Getlogo = this.Getlogo

    console.debug('PARAMS_NAME_USER_STATE', result)
    if (result == false) {
      await this.$router.push('/')
      // location.href
    }
    this.$store.state.loader = false
  },
  mounted () {

  },
  methods: {
    /**
   * @vuese
   * se valida y se procede a realizar el logeo del usuario y sus posibles causas como: 1.- primera vez. 2.- logeo normal.
   */
    Sendlogin: async function () {
      this.$store.state.loader = true
      if (this.user != '' && this.passw != '') {
        const datos = {
          'user': this.user.toLowerCase(this.user),
          'password': this.passw,
          'url': this.$store.state.apiUrl
        }
        this.login(datos)

          .then(async (res) => {
            console.debug('LOGIN', res)
            if (res.success === true) {
              this.sessionSet('token', res.data.session.token)
              this.sessionSet('timezone', res.data.session.timezone)
              this.sessionSet('loginFist', res.data.session.isFirstTimeLogin)
              // this.sessionSet('userType', res.data.session.userType)

              sessionStorage.setItem('TC', res.data.session.clientType)
              sessionStorage.setItem('UT', res.data.session.userType)

              // logo

              var result = await this.getlogoUser_login(this.user)

              this.Getlogo = localStorage.getItem('imgLogo')
              this.$store.state.modaloader.Getlogo = this.Getlogo

              console.debug('PARAMS_NAME_USER_STATE', result)
              /// fin logo

              this.sessionSet('client', res.data.session.client)
              this.sessionSet('user', res.data.session.user)

              this.$moment.tz.setDefault(res.data.session.timezone)

              sessionStorage.setItem('firstLogin', res.data.session.isFirstTimeLogin)
              // this.sessionSet('acceso', res.data.session.permissions)

              await this.$store.commit('menuOptions', res.data.session.permissions)

              await this.$store.dispatch('devices/LOAD_DEVICES', res.data.devices)
              /* carga array flotillas */

              var fleetsDb = res.data.fleets

              await this.$store.dispatch('devices/LOAD_FLEETS', fleetsDb)

              this.$store.state.devices.fleets.push({ 'id': null, 'name': 'SIN ASIGNAR', 'selected': false, 'iconCollapse': true })

              /** * */
              this.$store.state.loader = false
              if (res.data.session.isFirstTimeLogin === true) {
                await this.$store.dispatch('loginFirstTime', true)
                this.$router.push({ name: 'loginchangePassword', params: { token: this.sessionGet('token') } })
              } else {
                await this.$store.dispatch('SuccessLogin', res.data)
                this.sessionSet('logged', true)
                this.$store.dispatch('showMenu', true)
                await this.$store.dispatch('loginFirstTime', false)

                this.$router.push({ name: 'home' })
              }
            } else {
              this.$store.state.loader = false
              this.sessionSet('logged', false)
              await this.$store.dispatch('FailLogin', res.error)
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
      this.$store.state.loader = false
    }
  },
  computed: {
    logoGet () {
      return this.Getlogo
    },

    /**
   * @vuese
   * Si el logeo no fue exitoso, se muestran la alerta correspondiente
   */
    logged () {
      return this.$store.getters.isLogged
    }
  }

}

</script>

<style >
  .version{
    font-style: italic;
    font-weight: 600;
    font-size: 14px;
    color: #ccc;
    margin-left: 50px;
  }
/*

 #bg img {
	 position: fixed;
	 top:0%;
	 left:0%;

		width: 100%;
		height: 100%;
  }
  	.card-body{
		min-width: 350px;
  }
*/

  .login-img-bg{
     /* background-image: url(require("@/assets/img/fondo_login.jpg"));  */
    background-size: cover;

    background-position: center;

  }

.slide-fade-enter-active {
  transition: all .3s ease;
}
.slide-fade-leave-active {
  transition: all .5s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.slide-fade-enter, .slide-fade-leave-to
/* .slide-fade-leave-active below version 2.1.8 */ {

  transform: translateX(10px);
  opacity: 0;
}

</style>
