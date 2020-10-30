<template>

      <!-- MODAL -->

     <div id="modalAdminForm" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog  modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">

                  <span v-if="this.$store.state.modal.datosDymanic.seccion=='gps'">
                    <h5 class="modal-title" id="exampleModalCenterTitle" v-if="getAccion=='nuevo'">Nuevo gps</h5>
                    <h5 class="modal-title" id="exampleModalCenterTitle" v-if="getAccion=='editar'">editar gps</h5>
                  </span>

                   <span v-if="this.$store.state.modal.datosDymanic.seccion=='sims'">
                    <h5 class="modal-title" id="exampleModalCenterTitle" v-if="getAccion=='nueva'">Nueva sim</h5>
                    <h5 class="modal-title" id="exampleModalCenterTitle" v-if="getAccion=='editar'">editar sim</h5>
                  </span>

                   <span v-if="this.$store.state.modal.datosDymanic.seccion=='product'">
                    <h5 class="modal-title" id="exampleModalCenterTitle" v-if="getAccion=='nuevo'">Nuevo producto genérico</h5>
                    <h5 class="modal-title" id="exampleModalCenterTitle" v-if="getAccion=='editar'">editar producto genérico</h5>
                  </span>

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>

              <div class="modal-body float-left" >

                  <div class="row">

                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="exampleFormControlSelect2">Tipo Producto</label>
                            <select class="form-control" id="exampleFormControlSelect2" v-model="tipoProduct" @change="showContent()">
                                <option value=0>Ninguno</option>
                                <option value=1 v-if="this.$store.getters.permission(9)">Gps</option>
                                <option value=2  v-if="this.$store.getters.permission(10)">Sim</option>
                                <option value=3 v-if="this.$store.getters.permission(17)">Producto genérico</option>

                            </select>
                        </div>
                    </div>

                  </div>

                  <component :is='dynamicComponent.component' v-if="visible" ></component>

              </div> <!-- fin card body -->

          </div>
      </div>
    </div>

    <!-- fin modal -->

</template>

<script>
import { API } from '@/mixins/API'
import EventBus from '@/EventBus'

import FormSims from '@/views/Administrador/sims/FormSims'
import FormGPS from '@/views/Administrador/gps/FormGPS'
import FormProduct from '@/views/Administrador/productos/formProduc'
/**
* @vuese
 * @group Administrador/Distribuidor
 * Modal para registrar GPS
 */
export default {
  name: 'ModalFormPricipal',
  mixins: [API],
  data () {
    return {

      dynamicComponent: {
        component: null,
        properties: null,
        events: {

        }
      },
      visible: false,
      accion: this.$store.state.modal.datosDymanic.accion,
      tipoProduct: 0

    }
  },
  async created () {
    this.$store.state.loader = false
  },
  async mounted () {
    this.$store.state.loader = false
    $('#modalAdminForm').modal('show')
    console.debug('MOUNTED', this.accion)
    if (this.accion == 'editar') {
      console.debug('MOUNTED_IF', this.accion, this.$store.state.modal.datosDymanic.accion)
      this.$store.state.modal.datosDymanic.accion = 'editar'
      $('#exampleFormControlSelect2').attr('disabled', 'disabled')
      if (this.$store.state.modal.datosDymanic.seccion == 'gps') {
        this.tipoProduct = 1
      }
      if (this.$store.state.modal.datosDymanic.seccion == 'sims') {
        this.tipoProduct = 2
      }
      if (this.$store.state.modal.datosDymanic.seccion == 'product') {
        this.tipoProduct = 3
      }
      console.debug('MOUNTED_IF2', this.accion, this.$store.state.modal.datosDymanic.accion)
      this.showContent()
    }
  },
  destroyed () {

  },
  methods: {
    /**
   * @vuese
   * Muestra contenido formulario de productos
   */
    async showContent () {
      console.debug('SHOWCONTENT', this.accion, this.$store.state.modal.datosDymanic.accion)
      this.clearComponentsDinamic()
      if (this.tipoProduct != 0) {
        var opc = parseFloat(this.tipoProduct)
        console.debug(opc)
        switch (opc) {
          case 1: // gps
            console.debug('case1')
            this.dynamicComponentName = 'gps'
            this.$store.state.modal.datosDymanic.seccion = 'gps'
            if (this.accion != 'editar') {
              this.$store.state.modal.datosDymanic.accion = 'nuevo'
              this.accion = this.$store.state.modal.datosDymanic.accion
            }

            this.tipoProduct = 1
            this.dynamicComponent.component = () => import('@/views/Administrador/gps/FormGPS.vue')
            break
          case 2: // sims
            console.debug('case2')
            this.dynamicComponentName = 'sims'
            this.$store.state.modal.datosDymanic.seccion = 'sims'
            if (this.accion != 'editar') {
              this.$store.state.modal.datosDymanic.accion = 'nueva'
              this.accion = this.$store.state.modal.datosDymanic.accion
            }
            this.tipoProduct = 2

            this.dynamicComponent.component = () => import('@/views/Administrador/sims/FormSims.vue')
            break
          case 3: // productoG
            console.debug('case3')
            this.dynamicComponentName = 'productG'
            if (this.accion != 'editar') {
              this.$store.state.modal.datosDymanic.accion = 'nuevo'
              this.accion = this.$store.state.modal.datosDymanic.accion
            }
            this.$store.state.modal.datosDymanic.seccion = 'product'

            this.tipoProduct = 3
            this.dynamicComponent.component = () => import('@/views/Administrador/productos/formProduc.vue')
            break
        }
        this.visible = true
      }
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
    cancel () {
      this.$store.commit('CLEAR_MODAL_DINAMIC')

      $('#modalAdminForm').modal('hide')
    }

  },
  computed: {
    getAccion () {
      return this.$store.state.modal.datosDymanic.accion
    }

  }
}
</script>
