<template>
  <div class="row justify-content-center">

    <div class="col-12 col-md-9">
      <div class="row">
        <div class="col-12" style="margin-top:50px; margin-bottom:20px;">
          <div class="row justify-content-center">
              <div class="col-5 col-sm-4 col-md-4 text-center" style="margin-bottom: 40px;">
              <h4><b>Bienvenido</b></h4>
              <img class="img-fluid"  :src="`${logoGet}isotipo.png`" style="height:100px;">

            </div>
            <div class="col-3 col-sm-4 col-md-3 text-justify" style="margin-bottom: 40px; border-left: 1px solid #a99d9df5; padding: 20px;"><h5>SISTEMA DE <b>ADMINISTRACIÓN</b></h5></div>
          </div>
        </div>

        <div class="col-12">
          <div class="row justify-content-center">
              <div class="col-12 col-sm-7 col-md-5 ">
                <div class="card cardFloat_1" style="width: 330px;">
                    <div class="card-body row" style="padding-top: 10px; padding-right: 15px; height: 90px;  width: 350px; padding-left: 15px; margin-bottom: 15px;">
                        <div class="col-8" style="padding-right: 0px;">
                          <div class="row">
                            <div class="col-12 float-left"><h5 class="card-title"><b>Usuarios</b></h5></div>
                            <div class="col-12 float-left">
                              <p class="card-text text-muted" style="padding-right: 0px;">Gestiona diferentes usuarios y asigna un nivel de acceso diferente o privilegios.</p>
                            </div>
                          </div>
                        </div>

                        <div class="col-4"> <img class="img-fluid" src="img/home/laptop.png" ></div>

                    </div>
                    <div class="card-footer text-center" style="padding: 7px 7px;">
                          <router-link to="/users" >
                          <span class="text-muted" style="color:#1487EB !important;"><b>VER USUSARIOS</b></span>
                          </router-link>
                    </div>
                  </div>
              </div>

              <div class="col-12 col-sm-7 col-md-5 ">
                <div class="card cardFloat_2" style="width: 330px;">
                    <div class="card-body row" style="padding-top: 10px; padding-right: 15px; height: 90px;  width: 350px; padding-left: 15px; margin-bottom: 15px;">
                        <div class="col-8" style="padding-right: 0px;">
                          <div class="row">
                            <div class="col-12 float-left">
                                <h5 class="card-title" v-if="tipoClient==1"><b></b></h5>
                                <h5 class="card-title" v-if="tipoClient==2"><b>Clientes</b></h5>
                                <h5 class="card-title" v-if="tipoClient==3"><b>Distribuidores</b></h5>
                              </div>
                            <div class="col-12 float-left" style="padding-right: 0px;">
                              <p class="card-text text-muted">Permite la gestión de distribuidores, asi como la gestión de sus clientes que administra el distribuidor.</p>
                            </div>
                          </div>
                        </div>

                        <div class="col-4"> <img class="img-fluid" src="img/home/bloc.png" ></div>

                    </div>
                    <div class="card-footer text-center" style="padding: 7px;">
                        <router-link to="/ListTableDistrobuitor" v-if="tipoClient==3">
                        <span class="text-muted" style="color:#1487EB !important;" ><b>VER DISTRIBUIDORES</b></span>
                        </router-link>
                        <router-link to="/ListTableClient" v-if="tipoClient==2">
                        <span class="text-muted" style="color:#1487EB !important;" ><b>VER CLIENTES</b></span>
                        </router-link>
                        <router-link to="/ListTableClient" v-if="tipoClient==1">
                        <span class="text-muted" style="color:#1487EB !important;" ><b>VER?</b></span>
                        </router-link>
                    </div>
                </div>
              </div>

              <div class="col-12 col-sm-7 col-md-5 "  v-if="tipoClient!=3">
                <div class="card cardFloat_3" style="width: 330px;">
                    <div class="card-body row"  style="padding-top: 10px; padding-right: 15px; height: 90px;  width: 350px; padding-left: 15px; margin-bottom: 15px;">
                        <div class="col-8" style="padding-right: 0px;">
                          <div class="row">
                            <div class="col-12 float-left"><h5 class="card-title"><b>Almacén</b></h5></div>
                            <div class="col-12 float-left" style="padding-right: 0px;">
                              <p class="card-text text-muted">Muestra información para el análisis del almacén, asi como la gestión de almacén, propio y de sus clientes.</p>
                            </div>
                          </div>
                        </div>

                        <div class="col-4"> <img class="img-fluid" src="img/home/icono_almacen.png" ></div>

                    </div>
                    <div class="card-footer text-center" style="padding: 7px;">
                      <router-link to="/store" >
                        <span class="text-muted" style="color:#1487EB !important;"><b>IR A ALMACÉN</b></span>
                      </router-link>
                    </div>
                </div>
              </div>

              <div class="col-12 col-sm-7 col-md-5 ">
                <div class="card cardFloat_4" style="width: 330px;">
                    <div class="card-body row" style="padding-top: 10px; padding-right: 15px; height: 90px;  width: 350px; padding-left: 15px; margin-bottom: 15px;">
                        <div class="col-8" style="padding-right: 0px;">
                          <div class="row">
                            <div class="col-12 float-left"><h5 class="card-title"><b>Operaciones</b></h5></div>
                            <div class="col-12 float-left" style="padding-right: 0px;">
                              <p class="card-text text-muted">Permite la gestión de ventas, facturación, cobranza, entre otros. de los distribuidores.</p>
                            </div>
                          </div>
                        </div>

                        <div class="col-4"> <img class="img-fluid" src="img/home/controlar.png" ></div>

                    </div>
                    <div class="card-footer text-center" style="padding: 7px;">
                      <router-link to="/transactions" >
                        <span class="text-muted" style="color:#1487EB !important;"><b>IR A OPERACIONES</b></span>
                      </router-link>
                    </div>
                </div>
              </div>
          </div>

        </div>
      </div>
    </div>

  </div>
</template>

<script>
import { Functions } from '@/mixins/Functions.js'
import EventBus from '@/EventBus.js'
/**
 * @vuese
 * @group Administrador/Home
 * pantalla principal, administrador
 */
export default {
  name: 'HomeAdmin',
  mixins: { Functions },
  data () {
    return {
      tipoClient: null,
      Getlogo: localStorage.getItem('imgLogo')
    }
  },
  created () {
    this.tipoClient = sessionStorage.TC
    this.suscribeToDeviceEvents()
  },
  beforeDestroy () {
    this.unsuscribreToDeviceEvents()
  },
  mounted () {
    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })
    this.menu()
  },
  methods: {
    /**
   * @vuese
   * se suscribe a eventos eventBus para actulizar el listado de gps
   */
    suscribeToDeviceEvents () {
      EventBus.$on('cambioLogo_home', (data) => {
        this.Getlogo = data
      })
    },
    /**
   * @vuese
   * Se destruye la suscripcion al eventBus
   */
    unsuscribreToDeviceEvents () {
      EventBus.$off('cambioLogo_home')
    },
    async menu () {
      this.$store.state.seccionMenu = 'adminHome'
      await EventBus.$emit('NAVBAR_MenuSimple', 'adminHome')
    }

  },
  computed: {
    logoGet () {
      return this.Getlogo
    }

  }
}
</script>

<style>

@media  (min-width: 768px) {
  .cardFloat_1 {
    float: right;
  }
  .cardFloat_2{
    float: left;
  }
   .cardFloat_3 {
    float: right;
  }
  .cardFloat_4{
    float: left;
  }

}

@media (max-width: 767px) {
  /* no tiene float */
   .cardFloat_1 {
    float: none;
  }
  .cardFloat_2{
    float: none;
  }
   .cardFloat_3 {
    float: none;
  }
  .cardFloat_4{
    float: none;
  }
}

</style>
