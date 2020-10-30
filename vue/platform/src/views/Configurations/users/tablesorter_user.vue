<template>
  <div class=" row " > <!-- justify-content-center -->
    <div class="col-12"> <h5 class="float-left" style="font-size: 20px; padding-bottom: 10px;"><b>Usuarios - Lista de usuarios</b></h5></div>

      <div class=" col-12">

        <div class="card">
            <div class="card-header row">
              <div class="col-6">
              <h5 class=" float-left">Usuarios</h5>
              </div>

              <div class="col-6 " style="height: 30px;">
                <div class="row float-right">

                    <button class="btn btn-secondary float-left btn-sm" @click="cancel()" >REGRESAR</button>
                      <router-link to="/userRegister"  >
                      <button  type="button" class="btn btn-primary float-right btn-sm cssToolTipp" >NUEVO
                        <p style="top: 25px !important; right: 10% !important;">Nuevo usuario</p>
                      </button>
                    </router-link>

                </div>
              </div>

            </div>
            <div class="card-body">

              <div class="table-responsive scrollTable">
                                                <table class="table table-hover header_fijo">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Usuario</th>
                                                            <th>Fecha de creación</th>
                                                            <th>Tipo</th>
                                                            <th>Correo</th>
                                                            <th>Estado</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <tr v-for="(user,index) in getUserList" :key="user.id">
                                                            <td>{{index+1}}</td>
                                                            <td>{{user.username}}</td>
                                                            <td> {{user.creationTimestamp* 1000 | moment("DD MMMM YYYY") }} </td>
                                                            <td v-if="user.userType==1">Cliente</td>
                                                            <td v-if="user.userType==2">Asociado</td>
                                                            <td v-if="user.userType==3">Distribuidor</td>
                                                            <td >{{user.email}}</td>
                                                            <td>
                                                               <div class="form-group" v-if="user.active==1">
                                                                  <div class="switch switch-primary d-inline m-r-10">
                                                                      <input type="checkbox"  :id="`switch-p-${user.id}`" checked @change="suspender(user.id,user.active)">
                                                                      <label :for="`switch-p-${user.id}`" class="cr"></label>
                                                                  </div><br>
                                                                  <small  >Activo</small>
                                                              </div>
                                                              <div class="form-group" v-if="user.active==0">
                                                                  <div class="switch switch-primary d-inline m-r-10">
                                                                      <input type="checkbox"  :id="`switch-p-${user.id}`"  @change="suspender(user.id,user.active)">
                                                                      <label :for="`switch-p-${user.id}`" class="cr"></label>
                                                                  </div><br>
                                                                  <small  >Suspendido</small>
                                                              </div>
                                                            </td>
                                                            <td>
                                                              <!-- <span class="cursor" @click="suspender(user.id,user.active)">
                                                                <i v-if="user.active==1" class="icon icon-md universalicon-lock cursor colorText-red"></i>
                                                                <i  v-if="user.active==0" class="icon icon-md universalicon-unlock cursor colorText-green" ></i>
                                                              </span> -->

                                                              <span class="cursor" ><i class="icon icon-md universalicon-pencil cursor cssToolTipp" @click="editar(user.id)"><p style="top: 25px !important; right: 10% !important;">Editar usuario</p></i></span>
                                                              <span @click="eliminar(user.id,user.username)"><i class="cursor icon-md icon universalicon-trash-2 colorText-red cssToolTipp"><p style="top: 25px !important; right: 10% !important;">Eliminar usuario</p></i></span>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>

            </div>
        </div>

      </div>

  </div>
</template>

<script>
import { API } from '@/mixins/API'
import EventBus from '@/EventBus'
import cModalDelete from '@/views/Configurations/users/DeleteModal'
/**
 * @group Usuarios
 * Tabla de usuarios
 */
export default {
  name: 'tablaUsuarios',
  mixins: [API],
  data () {
    return {
      listUser: [],
      table: null
    }
  },
  components: {
    cModalDelete
  },
  async created () {
    this.table = await this.flistaUsers()
  },
  async mounted () {
    this.$store.state.submenuActive = 'config'
    this.$store.state.itemSubmenuActive = 'itemUser'
    await EventBus.$emit('NAVBAR_MenuOpciones', 'config', 'itemUser')
    this.suscribeToDeviceEvents()
    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })
  },
  beforeDestroy () {
    this.unsuscribreToDeviceEvents()
  },
  methods: {
    /**
   * @vuese
   * Obtiene la lista de usuarios
   */
    async flistaUsers () {
      var request = await this.getRequest('users')

      var datos
      if (request.success === true) {
        datos = request.data.users
      }

      this.listUser = datos
    },
    /**
   * @vuese
   * Obtiene la informacion del usuario a consultar
   * @arg `id` Id de usuario
   */
    editar (id) {
      this.$store.state.loader = true
      this.$router.push({ name: 'userRegister', params: { accion: 'editar', id: id } })
    },
    /**
   * @vuese
   * Abre el modal de confirmacion para eliminar el usuario
   * @arg `id` Id de usuario
  * @arg `name` nombre de usuario
   */
    async eliminar (id, name) {
      this.$store.commit('CLEAR_MODAL_DINAMIC')

      var datos = {
        'component': cModalDelete,
        'datos': {
          'userID': id,
          'name': name
        }
      }
      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)
      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
    },
    /**
   * @vuese
   * accion para suspendero activar al usuario
   * @arg `id` Id de usuario
   */
    async suspender (id, active) {
      var status = true
      var tipo = 'activado'
      if (active == 1) {
        tipo = 'suspendido'
        status = false
      }

      var dat = {
        'status': status
      }

      var request = await this.putRequest('users/' + id + '/status', dat)

      if (request.success === true) {
        notify('Excelente!', 'Se ha ' + tipo + ' el usuario ', 'top', 'right', 'success', 10, 50)
      } else {
        notify('Error!', 'No se ha ' + tipo + ' el usuario ', 'top', 'right', 'danger', 10, 50)
      }

      this.flistaUsers()
    },
    /**
   * @vuese
   * cancela el proceso y regresa una pagina anterior
   */
    cancel () {
      this.$router.push('/users')
    },
    /**
   * @vuese
   * se suscribe a eventos eventBus para actulizar el listado de usuarios
   */
    suscribeToDeviceEvents () {
      EventBus.$on('GET_LIST_users', (tipo) => {
        this.flistaUsers()
      })
    },
    /**
   * @vuese
   * Se destruye la suscripcion al eventBus
   */
    unsuscribreToDeviceEvents () {
      EventBus.$off('GET_LIST_users')
    }
  },
  computed: {
    /**
   * @vuese
   * obtiene el listado de los usuarios a mostrar
   */
    getUserList () {
      return this.listUser
    }

  }
}
</script>

<style>

/* .table-hover thead{
  width: 100%;
}

.table-hover tbody {

  height: 230px;
  overflow-y: auto;
  width: 100%;
}

.table-hover thead,
.table-hover tbody,
.table-hover tr,
.table-hover td,
.table-hover th {
   display: block;
}

.table-hover tbody td,
.table-hover thead > tr> th{
  float: left;
  border-bottom-width: 0;
} */

 /* thead, tbody { display: block; }
tbody {
    height: 200px;
    overflow-y: auto;
    overflow-x: hidden;
} */

/* .header_fijo thead tr {
  display: block;
  position: relative;
}
.header_fijo tbody {
  display: block;
  overflow: auto;
  width: 100%;
  height: 300px;
} */

.scrollTable{
  position: relative;
    overflow: auto;
    height: 480px;
    width: 100%;
}

</style>
