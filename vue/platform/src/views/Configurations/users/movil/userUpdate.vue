<template>
  <div class=" row m-r-5">
      <div class="col-12 float-left"> <h4 class="float-left" style="font-size: 20px; padding-bottom: 10px;"><b>Editar /</b> usuario</h4>
      </div>
      <div class="col-12 float-left" style="margin-top: -18px;">
        <h6>A continuación podras consultar y modificar tus datos de usuario.</h6>
        <hr>
      </div>

     <div class="col-12" style="margin-top:15px;">

              <div id="smartwizard" >

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item cursor" @click="showOptionTab(1)">
                            <a class="nav-link active text-uppercase" id="legales-tab" data-toggle="tab"  role="tab" aria-controls="legales" aria-selected="true">Datos legales</a>
                        </li>
                        <li class="nav-item cursor" @click="showOptionTab(2)">
                            <a class="nav-link text-uppercase" id="contactos-tab" data-toggle="tab" role="tab" aria-controls="contactos" aria-selected="false">Datos de domicilio</a>
                        </li>
                          <li class="nav-item cursor" @click="showOptionTab(3)">
                            <a class="nav-link text-uppercase" id="contactos-tab" data-toggle="tab" role="tab" aria-controls="contactos" aria-selected="false">Permiso</a>
                        </li>

                    </ul>

                    <div class="card float-left" style=" box-shadow: none; width: 100%;">
                       <component :is='dynamicComponent.component'   v-if="visible" ></component>
                    </div>

              </div>

      </div>

  </div>

</template>

<script>
import { API } from '@/mixins/API'
import EventBus from '@/EventBus.js'
/**
 * @group Usuarios
 * formulario para crear, editar y consultar usuarios
 */
export default {
  name: 'FormularioUsersEdit',
  mixins: [API],
  data () {
    return {
      userName: '',
      user: '',
      password: '',
      email: '',
      telefono: 0,
      direc: '',
      tipoUser: 0,
      apaterno: '',
      amaterno: '',
      dispositivosUser: [],
      dispositivos_list: [],
      accion: '',
      userID: '',
      userData: [],
      permisos: [],
      listZonaHoraria: [],
      zonaH: 14,
      getDevicesUser: [],
      showDevice: false,
      deviceesUs: [],
      listPermissions: [],
      notas: null,
      dynamicComponent: {
        component: null,
        properties: null,
        events: {

        }
      },
      visible: false

    }
  },
  async created () {
    this.accion = this.$route.params.accion
    this.userID = this.$route.params.id
  },
  async mounted () {
    this.$store.state.submenuActive = 'config'
    this.$store.state.itemSubmenuActive = 'itemUser'
    await EventBus.$emit('NAVBAR_MenuOpciones', 'config', 'itemUser')

    this.showOptionTab(1)
  },
  methods: {
    /**
   * @vuese
   * Muestra contenido formulario de clientesz
   */
    async showOptionTab (item) {
      console.debug('SHOWCONTENT', item)
      this.visible = false
      this.$store.state.loader = true
      this.clearComponentsDinamic()

      var opc = parseFloat(item)
      console.debug(opc)

      this.optionTab = opc
      switch (opc) {
        case 1: // legales
          console.debug('case1')
          this.dynamicComponentName = 'legales'
          this.dynamicComponent.component = () => import('@/views/Configurations/users/movil/userUpdateLegales.vue')

          break
        case 2: // tabla

          console.debug('case2')
          this.dynamicComponentName = 'domicilio'

          this.dynamicComponent.component = () => import('@/views/Configurations/users/movil/userUpdateDomicilio.vue')

          break
        case 3: // logo
          console.debug('case3')
          this.dynamicComponentName = 'tabla'

          this.dynamicComponent.component = () => import('@/views/Configurations/users/movil/userUpdatePermisos.vue')

          break
      }
      this.visible = true
    },
    /**
   * @vuese
   * Limpia las variables del componenete dinamico
   */
    clearComponentsDinamic () {
      this.dynamicComponentName = null
      this.dynamicComponent.component = null
      this.dynamicComponent.properties = null
      // this.showAllDrawing(false)
      // this.showAllDrawing(false, 1)
    },

    /**
   * @vuese
   * cancela el proceso y regresa a la tabla de usuarios
   */
    cancel () {
      this.$router.push('/listaUsers')
    }
  },
  computed: {

    /**
   * @vuese
   * Obtiene tipo de usuario
   */
    getTypeUser () {
      this.$store.state.userType
      this.$store.state.clientType
      return this.dispositivos_list
    }

  }
}
</script>

<style>
.mpConf{
  margin: 10px;
  padding-top: 10px;
}

.minusculas{
text-transform:lowercase;
}

.mayusculas{
text-transform:uppercase;
}
</style>
