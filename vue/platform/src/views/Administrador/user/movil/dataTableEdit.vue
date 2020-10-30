<template>
    <div  class="card-body" >
          <div  id="contactos" >

                                    <div class="row">

                                      <div class="col-12">
                                              <!--NO wrapper row required, data-table contains class row inside-->
                                            <data-table ref="table"
                                                @OnWatch="OnWatch"
                                                @OnEdit="OnEdit"
                                                @OnDelete="OnDelete"
                                                :showEditButton="true"
                                                :showWatchButton="false"
                                                :showDeleteButton="true"
                                                 :showIndex="false"
                                            />
                                      </div>

                                      <div class="col-12" v-if="isEmptyContacts ">Sin contactos</div>

                                      <div class="col-12" id="alertasAD" style="margin-top: 40px;"></div>

                                      <div class="col-12 " style="margin-top: 15px;">
                                          <button id="agregarContac" class="btn btn-primary shadow-2 mb-4 float-right" @click="modalContactCreate()" type="button" >Agregar contacto</button>
                                      </div>

                                    </div>

                          </div>

    </div>
</template>

<script>
import { API } from '@/mixins/API'
import { Functions } from '@/mixins/Functions.js'
import EventBus from '@/EventBus.js'
import modalCreatedContact from '@/views/Administrador/user/modalCreateContact'
import deleteContact from '@/views/Administrador/user/modalDeleteContact'
import dataTable from '@/components/DataTable/DataTable'
import modalEditContact from '@/views/Administrador/user/modalEditContact'
/**
 * @vuese
 * @group Administrador/Distribuidor/Cliente
 * Formulario para crear distribuidor/Cliente
 */

export default {
  name: 'dataTableCuenta',
  mixins: [API, Functions],
  components: {
    dataTable
  },
  data () {
    return {
      cuenta: null,
      email: null,
      statusLegal: '',
      labelLegal: null,
      labelRFC: null,
      nameLegal: null,
      rfc: null,
      pais: null,
      region: null,
      codep: null,
      notas: '',
      contactos: [],
      contactosFine: [],
      addres: null,
      catLegalStatus: [],
      catTipoContact: [],
      id: 0,
      seccion: this.$route.params.id,
      title: null,
      zonaH: 14,
      listZonaHoraria: [],
      visabled: true,
      accionT: this.$store.state.modal.datosDymanic.accion,
      active: null,
      setDisabled: true,
      idCliente: null,
      resultado: false,
      idInp: 'input',
      files: [],
      Getlogo: localStorage.getItem('imgLogo')

    }
  },
  async created () {
    console.debug('CREATED_INICIO')
    await this.getInfoCliente()

    console.debug('CREATED_FIN')

    this.catPeople()
    this.idCliente = this.$store.state.modal.datosDymanic.clientID
  },
  async mounted () {
    // [ Responsive-table ] start

    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })

    this.suscribeToDeviceEvents()

    this.$store.state.loader = false
  },
  destroyed () {
    this.unsuscribreToDeviceEvents()
  },
  methods: {

    async catPeople () {
      var request = await this.getRequest('catalogs/people')

      var data = request.data.peopleTypes

      this.catTipoContact = data
    },

    /**
   * @vuese
   * se suscribe a eventos eventBus para actulizar el listado de sims
   */
    suscribeToDeviceEvents () {
      EventBus.$on('GET_list_contactos', (tipo) => {
        this.getInfoMiPerfil()
        $('#legales-tab').removeClass('active')
        $('#contactos-tab').addClass('active')
      })

      EventBus.$on('agregar_contactos', (data) => {
        data.accion = 'agregar'
        this.agregarContacto(data)
        $('#legales-tab').removeClass('active')
        $('#contactos-tab').addClass('active')
      })

      EventBus.$on('edit_contactos', (data) => {
        this.editarContacto(data)
        $('#legales-tab').removeClass('active')
        $('#contactos-tab').addClass('active')
      })

      EventBus.$on('Delete_contactos', (data) => {
        data.accion = 'eliminar'
        this.eliminarcontac(data)
      })
      EventBus.$on('refresh_dataTable', (data) => {
        console.debug('EVEN_REFRESH')
        this.Refresh()
      })
    },
    /**
   * @vuese
   * Se destruye la suscripcion al eventBus
   */
    unsuscribreToDeviceEvents () {
      EventBus.$off('GET_list_contactos')
      EventBus.$off('agregar_contactos')
      EventBus.$off('Delete_contactos')
      EventBus.$off('edit_contactos')
      EventBus.$off('refresh_dataTable')
    },
    async modalContactCreate () {
      this.$store.commit('CLEAR_MODAL_DINAMIC')
      this.$store.state.loader = true

      var datos = {
        'component': modalCreatedContact,
        'datos': {
          'seccion': 'contacto',
          'id': this.idCliente

        }
      }

      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)

      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
    },

    /**
   * @vuese
   * Obtiene la informacion del mi perfil
   */
    async getInfoCliente () {
      var response = await this.getRequest(`accounts/${this.$store.state.modal.datosDymanic.clientID}`)
      console.debug('CLEINTE', response)
      var clientAllInfo = response.data.customer

      this.active = clientAllInfo.active

      this.cuenta = clientAllInfo.account
      // this.email = clientAllInfo
      this.statusLegal = clientAllInfo.legal.statusID

      this.nameLegal = clientAllInfo.legal.name
      this.rfc = clientAllInfo.legal.taxID
      this.pais = clientAllInfo.legal.country
      this.region = clientAllInfo.legal.region
      this.codep = clientAllInfo.legal.zipCode
      this.notas = clientAllInfo.legal.notes
      this.addres = clientAllInfo.legal.address

      var contactosbd = clientAllInfo.contacts
      console.debug('CONTACTOS', contactosbd)
      contactosbd.forEach(element => {
        this.contactos.push({ 'id': element.id, 'idC': element.id, 'name': element.name, 'phone': element.phone, 'cel': element.cel, 'email': element.email, 'tipo': element.contactType, 'notes': element.notes })

        this.contactosFine.push({
          'id': element.id,
          'idC': element.id,
          'type': element.contactTypeID,
          'name': element.name,
          'phone': element.phone,
          'cel': element.cel,
          'email': element.email,
          'notes': element.notes
        })
        this.id++
      })

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
          title: 'Contacto',
          key: 'name',
          default: ''

        },
        {
          title: 'Tipo',
          key: 'tipo',
          default: ''

        },
        {
          title: 'Teléfono',
          key: 'phone',
          default: '-'
        },
        {
          title: 'Celular',
          key: 'cel',
          default: '-'
        },
        {
          title: 'Correo',
          key: 'email',
          default: ''
        }

      ]
      this.rows = this.contactos
      console.debug('DATOS_ROWS', this.rows)
      this.$refs.table.Render(this.headers, this.rows)
      this.Refresh()
    },
    async agregarContacto (data) {
      console.debug('DA ', data, ' ta')
      // var element = data.contact

      if (data.accion == 'editar') {
        this.$store.state.loader = false
        this.$refs.table.AddRow(data)
        this.contactos.push(data)
      } else {
        var row = data

        var contact = {

          'contactType': row.type,
          'name': row.name,
          'phone': row.phone,
          'cel': row.cel,
          'email': row.email,
          'notes': row.notes
        }
        var datos = {}
        datos['contact'] = contact
        console.debug('DATOOS', datos)

        var request = await this.postRequest('accounts/contacts/' + this.idCliente, datos)
        console.debug('DATOOS_REQUEST', request)

        if (request.success === true) {
          this.$store.state.loader = false
          row.id = request.data.contactID
          row.idC = request.data.contactID
          this.$refs.table.AddRow(row)
          this.contactos.push(data)
          EventBus.$emit('get_listContact', this.contactos)
        } else {
          this.$store.state.loader = false
          $('#alertasAD').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error, </strong>No se ha agregado el contacto</div>")
          setTimeout(() => {
            $('#alertasAD').html('')
          }, 5000)
        }
      }
    },
    Refresh () {
      console.debug('data_REFRESH')
      this.$refs.table.Refresh()
    },
    OnWatch (item, sender) {
      alert(`WATCH: ${item.name} ${item.age} ${item.country}`)
    },
    OnEdit (item, sender) {
      this.modalEditContact(item, sender)
    },
    OnDelete (item, sender) {
      console.debug(`DELETE: ${item.name} ${item.id} ${item.tipo}`)
      console.debug('DELETE row', sender, item)

      this.modalEliminarcontac(item.id, sender)
    },
    async eliminarcontac (data) {
      console.debug('DATA_DELETE', data, data.i)

      if (data.accion == 'editar') {
        var search
        var dat = 0
        this.contactos.filter(function (dato, i) {
          console.debug('ITEM', dato)
          if (dato.id == data.id) {
            search = i
            dat = dato
            return true
          }
        })

        console.debug(this.contactos, 'TIPO', dat, data.id)
        this.contactos.splice(search, 1)
        this.$refs.table.RemoveRow(data.sender)
        EventBus.$emit('get_listContact', this.contactos)
      } else {
        var request = await this.deleteRequest('accounts/contacts/' + data.id)

        if (request.success === true) {
          this.$store.state.loader = false
          var search
          var dat = 0
          this.contactos.filter(function (dato, i) {
            console.debug('ITEM', dato)
            if (dato.id == data.id) {
              search = i
              dat = dato
              return true
            }
          })

          console.debug(this.contactos, 'TIPO', dat, data.id)
          this.contactos.splice(search, 1)
          this.$refs.table.RemoveRow(data.sender)
          EventBus.$emit('get_listContact', this.contactos)
        } else {
          this.$store.state.loader = false
          $('#alertasAD').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error, </strong>No se ha eliminado el contacto</div>")
          setTimeout(() => {
            $('#alertasAD').html('')
          }, 5000)
        }
      }
    },
    async editarContacto (data) {
      console.debug('DATA_EDIT', data)

      data.data.accion = 'editar'
      data.accion = 'editar'
      var row = data.data

      var contact = {

        'contactType': row.tipo,
        'name': row.name,
        'phone': row.phone,
        'cel': row.cel,
        'email': row.email,
        'notes': row.notes
      }

      var datos = {}
      datos['contact'] = contact
      console.debug('DATOOS', datos)

      var request = await this.putRequest('contact/' + row.id, datos)

      if (request.success === true) {
        this.$store.state.loader = false

        this.eliminarcontac(data)

        var search
        var tipo = 0

        this.catTipoContact.filter(function (dato, i) {
          if (dato.id === data.data.tipo) {
            search = i
            tipo = dato
            return true
          }
        })

        data.data.tipo = tipo.name

        console.debug('NUEVO_EDIT', data)
        this.agregarContacto(data.data)
      } else {
        this.$store.state.loader = false
        $('#alertasAD').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error, </strong>No se ha agregado el contacto</div>")
        setTimeout(() => {
          $('#alertasAD').html('')
        }, 5000)
      }
    },

    async modalEditContact (item, sender) {
      console.debug('CLICK_EDIT', item)
      this.$store.commit('CLEAR_MODAL_DINAMIC')
      this.$store.state.loader = true
      var search
      var dat = 0
      this.contactos.filter(function (dato, i) {
        if (dato.id == item.id) {
          search = i
          dat = dato
          return true
        }
      })

      var search
      var tipo = 0

      this.catTipoContact.filter(function (item, i) {
        if (item.name === dat.tipo) {
          search = i
          tipo = item
          return true
        }
      })
      console.debug(dat, 'MODAL_CONTAT', this.catTipoContact)

      console.debug('TIPO_MODAL_EDIT', tipo)
      dat.tipoId = tipo.id

      var datos = {
        'component': modalEditContact,
        'datos': {
          'seccion': 'contacto',
          'data': item,
          'sender': sender,
          'dataContact': dat

        }
      }

      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)

      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
    },
    /**
   * @vuese
   * Elimina contactos a la lista
   */
    async modalEliminarcontac (id, sender) {
      this.$store.commit('CLEAR_MODAL_DINAMIC')
      this.$store.state.loader = true

      var datos = {
        'component': deleteContact,
        'datos': {
          'seccion': 'contacto',
          'id': id,
          'sender': sender

        }
      }

      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)

      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
    }

  },
  computed: {

    Getdisabled () {
      return this.setDisabled
    },
    getShowTable () {
      return this.resultado
    },
    getContactos () {
      return this.contactos
    },
    isEmptyContacts () {
      return $.isEmptyObject(this.contactos)
    },
    logoGet () {
      return this.Getlogo
    }
  }
}

</script>

<style scoped>
.toupperCase{
  text-transform: uppercase;
}
.btn-file {
  position: relative;
  overflow: hidden;
}
.btn-file input[type=file] {
  position: absolute;
  top: 0;
  right: 0;
  min-width: 100%;
  min-height: 100%;
  font-size: 100px;
  text-align: right;
  filter: alpha(opacity=0);
  opacity: 0;
  outline: none;
  background: white;
  cursor: inherit;
  display: block;
}

div.dt-buttons.btn-group{
    float: left;
    text-align: left;
}

/* div.dataTables_scrollHeadInner:after {
    width: unset !important;
}

div.dataTables_scrollHeadInner table{
  width:100% !important;
} */

/* .nav-link{
  height: 70px;
}

.nav-link.active{
    box-shadow: none;
    border-bottom: solid 3px #04a9f5;
}

.nav-tabs{
  border-bottom: 1px solid #dee2e6;
} */
</style>
