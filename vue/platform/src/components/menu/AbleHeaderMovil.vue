<template>
    <div id="containerMenuMovil" style="background: #3f4d67; color: #fff; ">
        <div class="row" v-if="this.$store.state.pruebas" style="height:10%;">
          <div class="col">
              <a href="javascript:;" class="b-brand">
                <div class="b-bg" style="background:linear-gradient(-135deg, #ffffff 0%, #ffffff 100%); !important" >
                    <!-- <i class="feather icon-trending-up"></i> -->
                    <!-- <img class="img-fluid" src="img/logo/isotipo_xl.png"> -->
                    <span>
                      <i class=" text-muted cursor icon-small universalicon-user"></i>
                    </span>
                </div>
                <!-- <span class="b-title">GPSinfinity</span> -->
                <div class="cssToolTipp">
                    <p style="top: 50px; left: 70px; position:fixed; width: 250px;" >Usuario: {{this.sessionGet('user')}}  <br> Cuenta: {{this.sessionGet('client')}} <br>Tipo: {{this.$store.state.typeUserMenu}}</p>

        <span class="b-title float-right" style="font-size: 15px; ">{{this.sessionGet('user')}}</span>
        </div>
            </a>
           </div>

           <div class="col " >
            <a class=" cursor float-right size-movile" @click="logout()">
              <span>
                <i class="iconMenu icon-lg universalicon-log-out cursor"></i>
              </span>

            </a>
          </div>

          </div>

          </div>
    </div>

</template>

<script>
import Vue from 'vue'
import { SecureStorage } from '@/mixins/SecureStorage.js'
/**
* @vuese
* @group componenets/menu
* menu superior para movil
 */
export default {
  name: 'ableHeaderMovil',
  mixins: [SecureStorage],
  created () {
    this.getRutaHome()
  },
  methods: {
    /**
   * @vuese
   * Obtiene la ruta principal
   */
    getRutaHome () {
      var tipoUser = sessionStorage.UT
      var tipoClient = sessionStorage.TC
      var ruta = ''

      if (tipoUser == 2) { // asociado
        if (tipoClient == 1) { // cliente/asociado
          ruta = 'localizacion'
          this.$store.state.showDasboard = false
        } else { // sub admin
          ruta = 'adminHome'
          this.$store.state.showDasboard = true
        }
      } else { // cliente, distribuidor, admin
        if (tipoUser == 1) { // cliente
          ruta = 'localizacion'
          this.$store.state.showDasboard = false
        } else {
          ruta = 'adminHome'
          this.$store.state.showDasboard = true
        }
      }

      if (tipoUser == 1) { // cliente
        this.$store.state.typeUserMenu = 'Cliente'
      }
      if (tipoUser == 3) { // cliente
        this.$store.state.typeUserMenu = 'Distribuidor'
      }
      if (tipoUser == 4) { // cliente
        this.$store.state.typeUserMenu = 'Administrador'
      }

      if (tipoUser == 2) { // asociado
        if (tipoClient == 1) { // cliente
          this.$store.state.typeUserMenu = 'Asociado'
        }
        if (tipoClient == 2) { // dist
          this.$store.state.typeUserMenu = 'Asociado distribuidor'
        }
        if (tipoClient == 3) { // admin
          this.$store.state.typeUserMenu = 'Asociado administrador'
        }
      }

      // this.$store.state.seccionMenu = ruta
      console.debug(ruta, 'MENU_RUTA', this.$store.state.apiUrl, this.$store.state.seccionMenu)
    },
    /**
   * @vuese
   * Cierra sesion de la plataforma
   */
    async logout () {
      Vue.prototype.$disconnect()
      await this.$store.dispatch('LogOut')
      await this.$router.push('/')
    }
  }
}
</script>

<style>

</style>
