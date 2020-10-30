<template>
  <div class=" row m-r-5" >
      <div class="col-12 float-left"> <h4 class="float-left" style="font-size: 20px; padding-bottom: 10px;"><b>Lista de clientes</b></h4>
      </div>
      <div class="col-12 float-left" style="margin-top: -18px;">

      <h6>A continuación podrás consultar y editar la lista de clientes.</h6>
      <hr>
      </div>

      <div class=" col-12" style="margin-top: 25px;">
      <div class="card">

                <!-- <router-link :to="{name: 'FormUsers', params: { id: 2 }}"  >
                  <button  type="button" class="btn btn-primary float-right btn-sm cssToolTipp" >NUEVO
                    <p style="top: 25px !important; right: 10% !important;">Editar cliente</p>
                  </button>
                </router-link> -->

            <div class="card-body">

                   <data-table ref="table"
                                                @OnWatch="OnWatch"
                                                @OnEdit="OnEdit"
                                                @OnDelete="OnDelete"
                                                 @onActive="onActive"
                                                :showEditButton="true"
                                                :showWatchButton="true"
                                                :showDeleteButton="true"
                                                :showActiveButton="true"
                                                 :showIndex="true"
                                            />

                  <div class="col-12 " style="margin-top: 15px;">

                        <router-link :to="{name: 'FormUsersM', params: { id: 2 }}"  >
                          <button  type="button" class="btn btn-primary shadow-2 mb-4 float-right cssToolTipp" >Agregar cliente
                            <p style="top: 25px !important; right: 10% !important;">Nuevo cliente</p>
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
import FormClientDistrib from '@/views/Administrador/user/formConsulta'
import dataTable from '@/components/DataTable/DataTableCliente'
/**
 * @vuese
 * @group Administrador/Distribuidor
 * Tabla de clientes
 */
export default {
  name: 'tablaMClientes',
  mixins: [API],
  data () {
    return {
      listClient: null
    }
  },
  components: {
    dataTable
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
          title: 'Cliente',
          key: 'name',
          default: ''

        },
        {
          title: 'Fecha creación',
          key: 'creationTimestamp',
          default: ''

        },
        {
          title: 'Estado',
          key: 'activeDiv',
          default: '-',
          priority: 5
        }

      ]

      this.listClient.forEach(element => {
        if (element.active == 1) {
          element.activeDiv = `<div class="form-group" >
                                      <div class="switch switch-primary d-inline m-r-10 ActiveAction">
                                          <input class="ActiveAction" type="checkbox"  :id="switch-p-${element.id}" checked >
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
      })

      console.debug(this.listClient, 'DATOS_list')
      this.rows = this.listClient
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
      this.consultar(item.id)
    },
    OnEdit (item, sender) {
      console.debug(`onEdit: ${item.name} ${item.age} ${item.country}`)
      this.editar(item.id)
    },
    OnDelete (item, sender) {
      console.debug(`DELETE: ${item.name} ${item.id} `)
      console.debug('DELETE row', sender, item)
      this.eliminar(item.id, item.name)
    },
    async onActive (item, sender) {
      console.debug(`ONaCTIVE: ${item.name} ${item.id} ${item.tipo}`)
      console.debug('ONaCTIVE row', sender, item)

      this.suspender(item.id, item.active)

      // var status = item.active

      // if (status == 1) {
      //   item.active = 0
      // }

      // if (status == 0) {
      //   item.active = 1
      // }

      // var row = item

      // this.$refs.table.AddRow(row)
      await this.clearTable(item)
    },
    async clearTable (item) {
      this.$refs.table.Clear()

      var search
      var dataC = 0
      this.listClient.filter(function (dato, i) {
        console.debug('ITEM', dato)
        if (dato.id == item.id) {
          search = i
          dataC = dato
          return true
        }
      })

      var status = dataC.active

      if (status == 1) {
        dataC.active = 0
      }

      if (status == 0) {
        dataC.active = 1
      }

      if (dataC.active == 1) {
        dataC.activeDiv = `<div class="form-group" >
                                      <div class="switch switch-primary d-inline m-r-10 ActiveAction">
                                          <input class="ActiveAction" type="checkbox"  :id="switch-p-${dataC.id}" checked >
                                          <label :for="switch-p-${dataC.id}" class="cr"></label>
                                      </div><br>
                                      <small  >Activo</small>
                                </div>`
      }
      if (dataC.active == 0) {
        dataC.activeDiv = `<div class="form-group" >
                                      <div class="switch switch-primary d-inline m-r-10 ActiveAction">
                                          <input class="ActiveAction" type="checkbox"  :id="switch-p-${dataC.id}"  >
                                          <label :for="switch-p-${dataC.id}" class="cr"></label>
                                      </div><br>
                                      <small  >Suspendido</small>
                                  </div>`
      }

      dataC.creationTimestamp = moment(dataC.creationTimestamp * 1000).format('DD-MM-YYYY')

      console.debug(this.listClient, 'DATOS_list')
      this.rows = this.listClient
      console.debug('DATOS_ROWS', this.rows)
      await this.$refs.table.AddRows(this.rows)

      this.Refresh()
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
      this.$router.push({ name: 'FormUsersMEdit', params: { id: 2 } })
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

      // this.getClientes()
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
      this.$router.push('DeleteClientm')
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
