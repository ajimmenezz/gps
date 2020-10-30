<template>
          <!-- MODAL -->

    <div id="modalDeleteCreate" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered  " role="document">
          <div class="modal-content">

              <div class="modal-body " style="margin-top: 15px;">

                    <div class="row justify-content-center" style="text-align: center;">

                      <div class="col-10"> <h5 class="modal-title" id="exampleModalCenterTitle" >¿ESTAS SEGURO?</h5></div>

                      <div class="col-10 " style="margin-top:20px;">
                          Una vez eliminado, ¡no podrá recuperar este contacto! <br>
                          Haz click sobre el botón para continuar
                      </div>

                      <div class="col-10 " style="margin-top: 35px;">
                          <button id="1" class="btn btn-outline-primary " type="button" @click="cancel()">Cancelar</button>
                          <button id="2" type="submit" class="btn btn-primary " @click="modalContactDelete()" > Eliminar </button>
                      </div>

                    </div>

              </div>

          </div>
      </div>
    </div>

    <!-- fin modal -->
</template>

<script>
import EventBus from '@/EventBus'
import { API } from '@/mixins/API'
import { Functions } from '@/mixins/Functions.js'

/**
 * @group reportes
 * Modal para configurar reporte
 */
export default {
  name: 'ModalConfigReport',
  mixins: [API, Functions],

  data () {
    return {
      dynamicComponent: {
        component: null,
        properties: null,
        events: {

        }
      },
      visible: false,
      idContac: this.$store.state.modal.datosDymanic.id

    }
  },
  created () {
    this.idContac = this.$store.state.modal.datosDymanic.id
    //   $('#modalDeleteCreate').modal('hide')
  },
  mounted () {
    $('#modalDeleteCreate').modal('show')
    this.$store.state.loader = false
  },
  destroyed () {

  },
  methods: {
    async cancel () {
      console.debug('CANCEL')
      $('#modalDeleteCreate').modal('hide')

      this.$store.commit('CLEAR_MODAL_DINAMIC')
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
   * Elimina contactos a la lista
   */
    async modalContactDelete () {
      this.$store.state.loader = true
      var id = this.idContac

      console.debug('TIPO', this.$store.state.modal.datosDymanic)

      var datos = {
        'id': this.$store.state.modal.datosDymanic.id,
        'sender': this.$store.state.modal.datosDymanic.sender
      }
      EventBus.$emit('Delete_contactos', datos)
      this.cancel()
      this.$store.state.loader = false
      notify('Excelente!', 'El contacto se ha eliminado', 'top', 'right', 'success')
      this.$store.state.loader = false
    }

  },
  computed: {
  }
}
</script>
