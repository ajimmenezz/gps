<template>
          <!-- MODAL -->

    <div id="modalContactEdit" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered   modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header row float-left" style="margin: 1px; padding: 5px; margin-top: 25px;  height: 50px;">
                  <div class="col-12"> <h5 class="modal-title" id="exampleModalCenterTitle" >Mi contacto</h5></div>
                  <!-- <div class=col-1><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div> -->

                       <div class="col-12">  <p  class="text-muted" style="text-align: justify; font-size: 12px; margin-top: -3px;">
            A continuación llena el siguiente formulario para editar un contacto</p>

             </div>

              </div>
              <div class="modal-body " style="margin-top: 15px;">

                <form   @submit.prevent>
                    <div class="row float-left" >

                                      <div class="col-12 ">
                                          <div class="form-group">
                                              <label for="exampleFormControlSelect2">Tipo contacto</label>
                                              <select class="form-control" id="exampleFormControlSelect2" v-model="tipoContac">
                                                  <option value="null">Ninguno</option>
                                                  <option v-for="tipoC in catTipoContact" :key="tipoC.id" :value="tipoC.id">{{tipoC.name}}</option>
                                              </select>
                                          </div>
                                      </div>
                                      <div class="col-12">
                                          <config-input   id="nameContac" label="Nombre"  typeinput="text"  placeholder="Nombre" v-model.trim="nameContac" required="false" :valor="nameContac" toLowerUperCase="uppercase"> </config-input>
                                      </div>
                                      <div class="col-12 col-md-6">
                                          <config-input   id="telefono" label="Teléfono"  typeinput="number"  placeholder="Teléfono" v-model.trim="telefono" required="false" :valor="telefono"> </config-input>
                                      </div>
                                      <div class="col-12 col-md-6">
                                          <config-input   id="celular" label="Celular"  typeinput="number"  placeholder="Celular" v-model.trim="celular" required="false" :valor="celular"> </config-input>
                                      </div>

                                      <div class="col-12 ">
                                          <config-input   id="emailContac" label="Correo electrónico"  typeinput="email"  placeholder="Correo electrónico" v-model.trim="emailContac" required="false" :valor="emailContac" toLowerUperCase="lowercase"></config-input>
                                      </div>

                                      <div class="col-12 ">
                                          <config-input   id="notasContac" label="Notas"  typeinput="text"  placeholder="Notas" v-model.trim="notasContac" required="false" :valor="notasContac"></config-input>
                                      </div>

                                       <div class="col-12" id="alertasAD" style="margin-top: 40px;"></div>

                                      <div class="col-12 float-right" >
                                          <button id="1" class="btn btn-outline-primary " type="button" @click="cancel()">Cancelar contacto</button>
                                          <button id="2" type="submit" class="btn btn-primary " @click="agregarContac()" > Editar contacto
                                          </button>
                                      </div>

                                  </div>
                </form>

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

      contactos: [],
      contactosFine: [],
      tipoContac: this.$store.state.modal.datosDymanic.dataContact.tipoId,
      nameContac: this.$store.state.modal.datosDymanic.dataContact.name,
      telefono: this.$store.state.modal.datosDymanic.dataContact.phone,
      celular: this.$store.state.modal.datosDymanic.dataContact.cel,
      emailContac: this.$store.state.modal.datosDymanic.dataContact.email,
      notasContac: this.$store.state.modal.datosDymanic.dataContact.notes,
      catTipoContact: [],
      dataContact: this.$store.state.modal.datosDymanic.dataContact,
      idCliente: this.$store.state.modal.datosDymanic.dataContact.id

    }
  },
  created () {
    //   $('#modalContactEdit').modal('hide')

    this.catPeople()
  },
  mounted () {
    $('#modalContactEdit').modal('show')

    this.$store.state.loader = false
  },
  destroyed () {

  },
  methods: {
    async cancel () {
      console.debug('CANCEL')
      $('#modalContactEdit').modal('hide')

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
   * Obtiene catalogo de tipo de contacto
   */
    async catPeople () {
      var request = await this.getRequest('catalogs/people')

      var data = request.data.peopleTypes

      this.catTipoContact = data
    },
    /**
   * @vuese
   * Agrega contactos a la lista
   */
    async agregarContac () {
      if (this.tipoContac == null || this.tipoContac == '') {
        $('#alertasAD').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Por favor, </strong>Selecciona tipo de contacto</div>")
        setTimeout(() => {
          $('#alertasAD').html('')
        }, 5000)
        return false
      }
      if (this.nameContac == null) {
        $('#alertasAD').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Por favor, </strong>Ingresa nombre de contacto</div>")
        setTimeout(() => {
          $('#alertasAD').html('')
        }, 5000)
        return false
      }
      if ((this.telefono == null || this.telefono == '') && (this.celular == null || this.celular == '')) {
        $('#alertasAD').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Por favor, </strong>Ingresa teléfono o celular</div>")
        setTimeout(() => {
          $('#alertasAD').html('')
        }, 5000)
        return false
      }
      if (this.emailContac == null || this.emailContac == '') {
        $('#alertasAD').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Por favor, </strong>Ingresa correo electrónico de contacto</div>")
        setTimeout(() => {
          $('#alertasAD').html('')
        }, 5000)
        return false
      }

      if (this.emailContac != null) {
        var validateEmail = this.validar_email(this.emailContac)
        if (!validateEmail) {
          $('#alertasAD').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error!, </strong>El correo no es valido</div>")
          setTimeout(() => {
            $('#alertasAD').html('')
          }, 5000)
          return false
        }
      }
      this.$store.state.loader = true

      var contactID = 0

      // validar si es un correo
      var tipoC = this.catTipoContact.find(x => x.id == this.tipoContac)

      // if (this.seccion == 0) {
      this.$store.state.loader = true
      var contact = {

        'contactType': this.tipoContac,
        'name': this.nameContac.toUpperCase(this.nameContac),
        'phone': this.telefono,
        'cel': this.celular,
        'email': this.emailContac.toUpperCase(this.emailContac),
        'notes': this.notasContac
      }

      contactID = this.$store.state.modal.datosDymanic.dataContact.id
      var contactData = {

        'id': contactID,
        'idC': contactID,
        'name': this.nameContac.toUpperCase(this.nameContac),
        'phone': this.telefono,
        'cel': this.celular,
        'email': this.emailContac.toUpperCase(this.emailContac),
        'tipo': this.tipoContac,
        'notes': this.notasContac
      }

      $('#alertasAD').html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha actualizado el contacto<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
      setTimeout(() => {
        $('#alertasAD').html('')

        var datos = {
          'data': contactData,
          'sender': this.$store.state.modal.datosDymanic.sender
        }

        EventBus.$emit('edit_contactos', datos)
        this.$store.state.loader = false
        this.cancel()

        $('#btnRegistrar').removeAttr('disabled')
      }, 3000)
      this.$store.state.loader = false
    }

  },
  computed: {

  }
}
</script>
