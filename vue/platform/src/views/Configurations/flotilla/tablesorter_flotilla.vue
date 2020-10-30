<template>
  <div class=" row " >
      <div class="col-12"> <h5 class="float-left" style="font-size: 20px; padding-bottom: 10px;"><b>Flotillas - Lista de flotillas</b></h5></div>

      <div class=" col-12">
      <div class="card">
           <div class="card-header row">
              <div class="col-9">
              <h5 class=" float-left">Flotillas</h5>
              </div>

              <div class="col-3" style="height: 30px;">
                <router-link to="/registerFlotilla"  >
                  <button  type="button" class="btn btn-primary float-right btn-sm cssToolTipp" >NUEVA
                     <p style="top: 25px !important; right: 10% !important;">Nueva flotilla</p>
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
                              <th>Flotilla</th>
                              <th>Dispositivos</th>
                              <th>Fecha de creación</th>
                              <th>Acciones</th>
                          </tr>
                      </thead>
                      <tbody>
                            <tr v-for="(fleet,index) in listFlotas" :key="fleet.id">
                                <td>{{index+1}}</td>
                                <td>{{fleet.name}}</td>
                                <td>{{fleet.totalDevices}}</td>
                                <td > {{fleet.creationTimestamp* 1000 | moment("MMMM DD YYYY") }}</td>
                                <td>
                                    <span class="cursor" ><i class="icon icon-md universalicon-pencil cursor cssToolTipp" @click="editar(fleet.id)"><p style="top: 25px !important; right: 10% !important;">Editar flotilla</p></i></span>
                                    <span @click="eliminar(fleet.id,fleet.name)"><i class="cursor icon-small icon universalicon-trash-2 colorText-red cssToolTipp"><p style="top: 25px !important; right: 10% !important;">Eliminar flotilla</p></i></span>
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
import EventBus from '@/EventBus'
import cModalDelete from '@/views/Configurations/flotilla/DeleteModal'
/**
 * @group Flotillas
 * Tabla de flotillas
 */
export default {
  name: 'tablaFlotillas',
  mixins: [API],
  data () {
    return {
      listaFlotillas: []
    }
  },
  components: {
    cModalDelete
  },
  created () {
    this.listFlotillas()
  },
  async mounted () {
    this.$store.state.submenuActive = 'config'
    this.$store.state.itemSubmenuActive = 'itemFlotilla'
    await EventBus.$emit('NAVBAR_MenuOpciones', 'config', 'itemFlotilla')
    this.suscribeToDeviceEvents()
    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })
    // $('#zero-configuration').DataTable({ scrollY: 360 })

    // $('#zero-configuration_length').css({ 'float': 'left' })
  },
  beforeDestroy () {
    this.unsuscribreToDeviceEvents()
  },
  methods: {
    /**
   * @vuese
   * obtiene la lista de flotillas creadas
   */
    async listFlotillas () {
      var request = await this.getRequest('fleets')

      var datos
      if (request.success === true) {
        datos = request.data.fleets
      }

      this.listaFlotillas = datos
      this.$store.commit('CLEAR_MODAL_DINAMIC')
    },
    /**
   * @vuese
   * Manda a formulario para editar flotilla
   */
    editar (id) {
      this.$store.commit('CLEAR_MODAL_DINAMIC')
      this.$store.state.loader = true
      this.$router.push({ name: 'registerFlotilla', params: { accion: 'editar', id: id } })
    },
    /**
   * @vuese
   * Abre el modal de confirmacion para eliminar la flotilla
   * @arg `id` Id de flotilla
  * @arg `name` Nombre de flotilla
   */

    async eliminar (id, name) {
      this.$store.commit('CLEAR_MODAL_DINAMIC')

      var datos = {
        'component': cModalDelete,
        'datos': {
          'ID': id,
          'name': name
        }
      }
      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)
      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
    },
    /**
   * @vuese
   * se suscribe a eventos eventBus para actulizar el listado de flotillas
   */
    suscribeToDeviceEvents () {
      EventBus.$on('GET_LIST_fleets', (tipo) => {
        this.listFlotillas()
      })
    },
    /**
   * @vuese
   * Se destruye la suscripcion al eventBus
   */
    unsuscribreToDeviceEvents () {
      EventBus.$off('GET_LIST_fleets')
    }
  },
  computed: {
    /**
   * @vuese
   * obtiene el listado de las flotillas a mostrar
   */
    listFlotas () {
      return this.listaFlotillas
    }
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
