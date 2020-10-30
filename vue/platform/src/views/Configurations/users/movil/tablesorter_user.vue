<template>
  <div class=" row m-r-5" > <!-- justify-content-center -->
     <div class="col-12 float-left"> <h4 class="float-left" style="font-size: 20px; padding-bottom: 10px;"><b>Usuarios</b></h4>
      </div>
      <div class="col-12 float-left" style="margin-top: -18px;">

      <h6>Podrás crear, consultar, editar y eliminar  la información de usuarios.</h6>
      <hr>
      </div>

     <div class=" col-12" style="margin-top: 25px;">
      <div class="card">

            <!-- <div class="card-header row">
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

            </div> -->
            <div class="card-body">

                                             <data-table ref="table"
                                                @OnWatch="OnWatch"
                                                @OnEdit="OnEdit"
                                                @OnDelete="OnDelete"
                                                 @onActive="onActive"
                                                :showEditButton="true"
                                                :showWatchButton="false"
                                                :showDeleteButton="true"
                                                :showActiveButton="true"
                                                 :showIndex="true"
                                            />

                  <div class="col-12 " style="margin-top: 15px;">

                        <router-link to="userRegisterM"  >
                          <button  type="button" class="btn btn-primary shadow-2 mb-4 float-right cssToolTipp" >Agregar usuario
                            <p style="top: 25px !important; right: 10% !important;">Nuevo Usuario</p>
                          </button>
                        </router-link>

                  </div>

            </div>
        </div>

      </div>

  </div>
</template>

<script>
import { API } from '@/mixins/API'
import EventBus from '@/EventBus.js'
import cModalDelete from '@/views/Configurations/users/DeleteModal'
import dataTable from '@/components/DataTable/DataTableCliente'
/**
 * @group Usuarios
 * Tabla de usuarios
 */
export default {
  name: 'tablaUsuariosM',
  mixins: [API],
  data () {
    return {
      listUser: [],
      table: null
    }
  },
  components: {
    cModalDelete,
    dataTable
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
    async getListUser () {
      var request = await this.getRequest('users')

      var datos
      if (request.success === true) {
        datos = request.data.users
      }

      this.listUser = datos
    },
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
      await this.changeHeaderTable()
    },
    changeHeaderTable () {
      this.headers = [
        // {
        //   title: '#',
        //   key: 'index',
        //   default: ''
        // },
        {
          title: 'Usuario',
          key: 'username',
          default: ''

        },
        {
          title: 'Estado',
          key: 'activeDiv',
          default: '-',
          priority: 1
        },
        {
          title: 'Fecha creación',
          key: 'creationTimestamp',
          default: ''

        },
        {
          title: 'Tipo',
          key: 'tipo',
          default: '-',
          priority: 5
        },
        {
          title: 'Correo',
          key: 'email',
          default: '-',
          priority: 5
        }

      ]

      this.listUser.forEach(element => {
        if (element.active == 1) {
          element.activeDiv = `  <div class="form-group" >
                                        <div class="switch switch-primary d-inline m-r-10 ActiveAction">
                                            <input class="ActiveAction" type="checkbox"  :id="switch-p-${element.id}" checked>
                                            <label :for="switch-p-${element.id}" class="cr"></label>
                                        </div><br>
                                        <small  >Activo</small>
                                    </div>`
        }
        if (element.active == 0) {
          element.activeDiv = `<div class="form-group" >
                                      <div class="switch switch-primary d-inline m-r-10 ActiveAction">
                                          <input class="ActiveAction" type="checkbox"  :id="switch-p-${element.id}"  >
                                          <label :for="switch-p-${element.id}" class="cr"></label>
                                      </div><br>
                                      <small  >Suspendido</small>
                                  </div>`
        }
        if (element.creationTimestamp) {
          element.creationTimestamp = moment(element.creationTimestamp * 1000).format('DD-MM-YYYY')
        }
        if (element.userType == 1) {
          element.tipo = 'Cliente'
        }
        if (element.userType == 2) {
          element.tipo = 'Asociado'
        }
        if (element.userType == 3) {
          element.tipo = 'Distribuidor'
        }
      })

      console.debug(this.listUser, 'DATOS_list')
      this.rows = this.listUser
      console.debug('DATOS_ROWS', this.rows)
      this.$refs.table.Render(this.headers, this.rows)
      this.Refresh()
    },
    Refresh () {
      console.debug('data_REFRESH')
      this.$refs.table.Refresh()
    },
    OnWatch (item, sender) {
      console.debug(`WATCH: ${item.name} ${item.id}`)
      // this.consultar(item.id)
    },
    OnEdit (item, sender) {
      console.debug(`onEdit: ${item.name} ${item.username}`)
      this.editar(item.id)
    },
    OnDelete (item, sender) {
      console.debug(`DELETE: ${item.name} ${item.id} `)
      console.debug('DELETE row', sender, item)
      this.eliminarModal(item, sender)
    },
    async onActive (item, sender) {
      console.debug(`ONaCTIVE: ${item.name} ${item.id} ${item.tipo}`)
      console.debug('ONaCTIVE row', sender, item)

      this.suspender(item.id, item.active)

      await this.clearTable(item)
    },
    /**
   * @vuese
   * Obtiene la informacion del usuario a consultar
   * @arg `id` Id de usuario
   */
    editar (id) {
      this.$store.state.loader = true
      this.$router.push({ name: 'userUpdate', params: { accion: 'editar', id: id } })
    },
    /**
   * @vuese
   * Abre el modal de confirmacion para eliminar el usuario
   * @arg `id` Id de usuario
  * @arg `name` nombre de usuario
   */
    async eliminarModal (item, sender) {
      this.$store.commit('CLEAR_MODAL_DINAMIC')

      var datos = {
        'component': cModalDelete,
        'datos': {
          'item': item,
          'sender': sender
        }
      }
      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)
      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
    },
    async eliminar (data) {
      console.debug('DATA_DELETE', data, data.id)
      var dataUser = data.data
      var userId = dataUser.id
      var request = await this.deleteRequest('users/' + userId)

      if (request.success === true) {
        this.$refs.table.RemoveRow(data.sender)
        this.getListUser()
        this.$store.state.loader = false
        notify('Excelente!', 'Se ha eliminado al usuario ', 'top', 'right', 'success', 10, 50)
      } else {
        this.$store.state.loader = false
        notify('Error!', 'No se ha eliminado al usuario ', 'top', 'right', 'danger', 10, 50)
      }
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
    },
    async clearTable (item) {
      this.$refs.table.Clear()

      var search
      var element = 0

      this.listUser.filter(function (dato, i) {
        console.debug('ITEM', dato)
        if (dato.id == item.id) {
          search = i
          element = dato
          return true
        }
      })

      var status = element.active

      if (status == 1) {
        element.active = 0
      }

      if (status == 0) {
        element.active = 1
      }

      if (element.active == 1) {
        element.activeDiv = `  <div class="form-group" >
                                        <div class="switch switch-primary d-inline m-r-10 ActiveAction">
                                            <input class="ActiveAction" type="checkbox"  :id="switch-p-${element.id}" checked>
                                            <label :for="switch-p-${element.id}" class="cr"></label>
                                        </div><br>
                                        <small  >Activo</small>
                                    </div>`
      }
      if (element.active == 0) {
        element.activeDiv = `<div class="form-group" >
                                      <div class="switch switch-primary d-inline m-r-10 ActiveAction">
                                          <input class="ActiveAction" type="checkbox"  :id="switch-p-${element.id}"  >
                                          <label :for="switch-p-${element.id}" class="cr"></label>
                                      </div><br>
                                      <small  >Suspendido</small>
                                  </div>`
      }
      if (element.creationTimestamp) {
        element.creationTimestamp = moment(element.creationTimestamp * 1000).format('DD-MM-YYYY')
      }
      if (element.userType == 1) {
        element.tipo = 'Cliente'
      }
      if (element.userType == 2) {
        element.tipo = 'Asociado'
      }
      if (element.userType == 3) {
        element.tipo = 'Distribuidor'
      }

      console.debug(this.listUser, 'DATOS_list')
      this.rows = this.listUser
      console.debug('DATOS_ROWS', this.rows)
      await this.$refs.table.AddRows(this.rows)
      this.Refresh()
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
        console.debug('BUS_ELIMINAR_USER', tipo)
        this.eliminar(tipo)
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
