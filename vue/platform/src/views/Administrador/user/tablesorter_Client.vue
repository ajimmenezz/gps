<template>
  <div class=" row " >
      <div class="col-12"> <h5 class="float-left" style="font-size: 20px; padding-bottom: 10px;"><b>Usuarios - Lista de clientes</b></h5></div>

      <div class=" col-12">
      <div class="card">
           <div class="card-header row">
              <div class="col-9">
              <h5 class=" float-left">Clientes</h5>
              </div>

              <div class="col-3" style="height: 30px;">

                <router-link :to="{name: 'FormUsers', params: { id: 2 }}"  >
                  <button  type="button" class="btn btn-primary float-right btn-sm cssToolTipp" >NUEVO
                    <p style="top: 25px !important; right: 10% !important;">Editar cliente</p>
                  </button>
                </router-link>

              </div>
            </div>
            <div class="card-body">

              <div class="table-responsive scrollTable">
                  <table  class="table table-hover header_fijo">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th>Cliente</th>
                              <th>Fecha de creación</th>
                              <th>Estado</th>
                              <th>Acciones</th>
                          </tr>
                      </thead>
                      <tbody>
                            <tr v-for="(cliente,index) in listClient" :key="cliente.id">
                                <td>{{index+1}}</td>
                                <td>{{cliente.name}}</td>
                                <td > {{cliente.creationTimestamp* 1000 | moment("MMMM DD YYYY") }}</td>
                                <td>
                                    <div class="form-group" v-if="cliente.active==1">
                                      <div class="switch switch-primary d-inline m-r-10">
                                          <input type="checkbox"  :id="`switch-p-${cliente.id}`" checked @change="suspender(cliente.id,cliente.active)">
                                          <label :for="`switch-p-${cliente.id}`" class="cr"></label>
                                      </div><br>
                                      <small  >Activo</small>
                                    </div>
                                    <div class="form-group" v-if="cliente.active==0">
                                      <div class="switch switch-primary d-inline m-r-10">
                                          <input type="checkbox"  :id="`switch-p-${cliente.id}`"  @change="suspender(cliente.id,cliente.active)">
                                          <label :for="`switch-p-${cliente.id}`" class="cr"></label>
                                      </div><br>
                                      <small  >Suspendido</small>
                                    </div>
                                </td>

                                <td>
                                  <!-- <span class="cursor" @click="suspender(cliente.id,cliente.active)">
                                    <i v-if="cliente.active==1" class="icon icon-md universalicon-lock cursor colorText-red"></i>
                                    <i  v-if="cliente.active==0" class="icon icon-md universalicon-unlock cursor colorText-green" ></i>
                                  </span> -->
                                  <span  class="cursor" ><i class="icon icon-md universalicon-visible cursor cssToolTipp" @click="consultar(cliente.id)">   <p style="top: 25px !important; right: -70% !important;">Consultar cliente</p></i></span>
                                    <span class="cursor" ><i class="icon icon-md universalicon-pencil cursor cssToolTipp" @click="editar(cliente.id)" ><p style="top: 25px !important; right: -70% !important;">Editar cliente</p></i></span>
                                    <span @click="eliminar(cliente.id,cliente.name)"><i class="cursor icon-small icon universalicon-trash-2 colorText-red cssToolTipp"><p style="top: 25px !important; right: -70% !important;">Eliminar cliente</p></i></span>
                                </td>
                            </tr>

                      </tbody>
                      <!-- <tfoot>
                          <tr>
                              <th>Name</th>
                              <th>Position</th>
                              <th>Office</th>
                              <th>Age</th>
                              <th>Start date</th>
                              <th>Salary</th>
                          </tr>
                      </tfoot> -->
                  </table>
              </div>

            </div>
        </div>

      </div>

  </div>
</template>

<script>
import { API } from '@/mixins/API'
import EventBus from '@/EventBus.js'
import FormClientDistrib from '@/views/Administrador/user/formConsulta'
/**
 * @vuese
 * @group Administrador/Distribuidor
 * Tabla de clientes
 */
export default {
  name: 'tablaClientes',
  mixins: [API],
  data () {
    return {
      listClient: null
    }
  },
  components: {
  },
  created () {
    this.getClientes()
  },
  async mounted () {
    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })
    this.$store.state.seccionMenu = 'Clientes'
    await EventBus.$emit('NAVBAR_MenuSimple', 'Clientes')
  },
  beforeDestroy () {
  },
  methods: {
    /**
   * @vuese
   * Obtiene la lsita de clientes
   */
    async getClientes () {
      var request = await this.getRequest('accounts')
      var data = request.data.customers
      console.debug('CLIENTES', data)
      this.listClient = data
      this.$store.commit('CLEAR_MODAL_DINAMIC')
    },
    /**
   * @vuese
   * Obtiene la informacion del cliente
   * @arg `id` Id de usuario
   */
    async consultar (id) {
      this.$store.state.loader = true
      this.$store.commit('CLEAR_MODAL_DINAMIC')

      var datos = {
        'component': FormClientDistrib,
        'datos': {
          'clientID': id,
          // 'accion': 'consultar',
          'accion': 'cliente',
          'seccion': 'otro'
        }
      }
      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)
      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
      // this.$router.push({ name: 'FormUsers', params: { id: 2 } })
    },
    /**
   * @vuese
   * Obtiene la informacion del cliente a editar
   * @arg `id` Id de usuario
   */
    async editar (id) {
      this.$store.commit('CLEAR_MODAL_DINAMIC')

      var datos = {

        'datos': {
          'clientID': id,
          'accion': 'editar'
        }
      }
      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)

      this.$store.state.loader = true
      this.$router.push({ name: 'FormUsers', params: { id: 2 } })
    },
    /**
   * @vuese
   * accion para suspender o activar al cliente
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

      var request = await this.putRequest('accounts/' + id + '/status', dat)

      if (request.success === true) {
        notify('Excelente!', 'Se ha ' + tipo + ' al cliente ', 'top', 'right', 'success', 10, 50)
      } else {
        notify('Error!', 'No se ha ' + tipo + ' al cliente ', 'top', 'right', 'danger', 10, 50)
      }

      this.getClientes()
    },
    /**
   * @vuese
   * accion para eliminar al cliente
   * @arg `id` Id de usuario
   */
    async eliminar (id, name) {
      this.$store.commit('CLEAR_MODAL_DINAMIC')

      var datos = {

        'datos': {
          'clientID': id,
          'nameCliente': name,
          'seccion': 1 // cliente,

        }
      }
      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)
      this.$router.push('DeleteClient')
    }
  },
  computed: {

  }
}
</script>

<style>
.scrollTable{
  position: relative;
    overflow: auto;
    height: 480px;
    width: 100%;
}
</style>
