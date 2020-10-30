<template>
  <div class=" row " >
      <div class="col-12"> <h5 class="float-left" style="font-size: 20px; padding-bottom: 10px;"><b>Catálogos - Kits</b></h5></div>

      <div class=" col-12">
      <div class="card">
           <div class="card-header row">
              <div class="col-9">
              <h5 class=" float-left">Lista de kits</h5>
              </div>

              <div class="col-3" style="height: 30px;">

                  <button  type="button" class="btn btn-primary float-right btn-sm" @click="modalFormKit()">NUEVO</button>

              </div>
            </div>
            <div class="card-body">

              <div class="table-responsive scrollTable">
                  <table  class="table table-hover header_fijo">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th>Kit</th>
                              <th>Fecha de creación</th>
                              <th>Acciones</th>
                          </tr>
                      </thead>
                      <tbody>
                            <tr v-for="(kit,index) in listKits" :key="kit.id">
                                <td>{{index+1}}</td>
                                <td>{{kit.kitName}}</td>
                                <td> {{kit.creationTimestamp* 1000 | moment("DD MMMM YYYY") }}</td>
                                <td>
                                    <span class="cursor" ><i class="icon icon-md universalicon-pencil cursor" @click="modalEdit(kit.id)"></i></span>
                                    <span @click="eliminar(kit.id,kit.kitName)"><i class="cursor icon-small icon universalicon-trash-2 colorText-red"></i></span>
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
import FormKit from '@/views/Administrador/catalogos/kits/FormKit'
import cModalDelete from '@/views/Administrador/DeleteModal'
import EventBus from '@/EventBus'
/**
 * @vuese
 * @group Administrador/Distribuidor
 * Tabla de sims
 */
export default {
  name: 'tablaSims',
  mixins: [API],
  data () {
    return {
      listKits: null
    }
  },
  components: {
    cModalDelete
  },
  created () {
    this.$store.state.StoreCliente = this.$store.state.modal.datosDymanic.idCliente
    this.getlistKit()
  },
  async mounted () {
    this.$store.state.seccionMenu = 'catalogos'
    await EventBus.$emit('NAVBAR_MenuSimple', 'catalogos')
    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })
    this.suscribeToDeviceEvents()
  },
  beforeDestroy () {
    this.unsuscribreToDeviceEvents()
  },
  methods: {
    /**
   * @vuese
   * Obtiene la lista de los kits
   */
    async getlistKit () {
      var request = await this.getRequest('kits')

      if (request.success === true) {
        this.listKits = request.data.kits
      }
    },
    /**
   * @vuese
   * Abre el modal para registrar sims
   */
    async modalFormKit () {
      this.$store.state.loader = true
      this.$store.commit('CLEAR_MODAL_DINAMIC')

      var datos = {
        'component': FormKit,
        'datos': {
          'seccion': 'kit',
          'accion': 'nuevo'

        }
      }

      console.debug(datos)

      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)
      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
    },
    /**
   * @vuese
   * Abre el modal para editar kit
   * @arg `id` Id de kit
   */
    async modalEdit (id) {
      this.$store.state.loader = true
      this.$store.commit('CLEAR_MODAL_DINAMIC')

      var datos = {
        'component': FormKit,
        'datos': {
          'seccion': 'kit',
          'accion': 'editar',
          'id': id

        }
      }

      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)
      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
    },
    /**
   * @vuese
   * Abre el modal de confirmacion para eliminar kit
   * @arg `id` Id de kit
  * @arg `name` nombre del kit
   */
    async eliminar (id, name) {
      this.$store.commit('CLEAR_MODAL_DINAMIC')

      var datos = {
        'component': cModalDelete,
        'datos': {
          'ID': id,
          'name': name,
          'tipo': 'kit'
        }
      }
      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)
      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
    },
    /**
   * @vuese
   * se suscribe a eventos eventBus para actulizar el listado de sims
   */
    suscribeToDeviceEvents () {
      EventBus.$on('GET_LIST_kits', (tipo) => {
        this.getlistKit()
      })
    },
    /**
   * @vuese
   * Se destruye la suscripcion al eventBus
   */
    unsuscribreToDeviceEvents () {
      EventBus.$off('GET_LIST_kits')
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
    height: 293px;
    /* height: 480px; */
    width: 100%;
}
</style>
