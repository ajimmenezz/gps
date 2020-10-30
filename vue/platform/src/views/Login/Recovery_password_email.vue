<template>
    <div>
<!--
			<div id="bg">
				<img src="@/assets/img/fondo_login.jpg" alt="">
			</div>
-->
       <div class="auth-wrapper aut-bg-img-side cotainer-fiuid align-items-stretch">
        <div class="row align-items-center w-100 align-items-stretch bg-white">
            <div class="d-none d-lg-flex col-lg-8 login-img-bg  align-items-center d-flex justify-content-center">
                <div class="col-md-8">
                    <h1 class="text-white mb-5">&nbsp</h1>
                    <p class="text-white"></p>
                </div>
            </div>
            <div class="col-lg-4 align-items-stret h-100 align-items-center d-flex justify-content-center">
                <div class=" auth-content text-center">
                    <div class="mb-4">
                        <img class="img-fluid"  :src="`${logoGet}logo.png`">
                    </div>
                    <h3 class="mb-4">Recuperar contraseña</h3>
                    <form @submit.prevent >
                      <div class="col-12"> <!-- " -->
                        <config-input  id="email_recovery" label="null"  typeinput="email"  placeholder="Correo electrónico" v-model.trim="emailRecovery" required="true" toLowerUperCase="lowercase"> </config-input>

                        <div id="alertas"></div>

                      </div>
                      <button id="btnSend" class="btn btn-primary shadow-2 mb-4" @click="Sendrecover()">ENVIAR CORREO</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    </div>
</template>

<script>

import { Login } from '@/mixins/Login.js'
/**
 * @group Login
 * Formulario de correo electronico para recuperar contraseña
 */
export default {
  name: 'FormularioCorreoRecuperarContrasenia',
  mixins: [Login],
  data () {
    return {
      emailRecovery: '',
      Getlogo: localStorage.getItem('imgLogo')
    }
  },
  components: {

  },
  mounted () {
    this.Getlogo = localStorage.getItem('imgLogo')
  },
  methods: {
    /**
   * @vuese
   * Manda correo electronico con las instrucciones y ruta para recuperar contraseña
   */
    Sendrecover: function () {
      if (this.emailRecovery !== '') {
        this.$store.state.loader = true
        const datos = {
          'email': this.emailRecovery.toLowerCase(this.emailRecovery),
          'url': this.$store.state.apiUrl
        }

        this.recover(datos)
          .then(async (res) => {
            if (res.success === true) {
              this.$store.state.loader = false
              $('#alertas').html("<div class='alert alert-success ' role='alert' style='text-align: initial;'><b>Excelente! </b>Se le ha enviado un correo electrónico, para recuperar su contraseña. Gracias</div>")
              $('#btnSend').addClass('disabled')
            } else {
              this.$store.state.loader = false
              $('#alertas').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>" + res.error.message + "<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
              setTimeout(() => {
                $('#alertas').html('')
              }, 4000)
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
