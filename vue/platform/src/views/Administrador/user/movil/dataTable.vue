<template>

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

        <div class="col-12" id="alertasAD" style="margin-top: 40px;"></div>

        <div class="col-12 " style="margin-top: 15px;">
            <!-- <button v-if="!this.$store.state.typeDevice.mobile" id="agregarContac" class="btn btn-primary shadow-2 mb-4 float-right" @click="modalContactCreate()" type="button" >Agregar contacto</button> -->
             <button  id="agregarContac" class="btn  btn-primary shadow-2 mb-4 float-right" @click="modalContactCreate()" type="button" >Agregar contacto</button>
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
export default {
  components: {
    dataTable
  },
  mixins: [API, Functions],
  created () {
    this.changeHeaderTable()
  },
  mounted () {
    this.catPeople()
    console.debug('dt/ Fill Demo')

    this.$refs.table.Render(this.headers, this.rows) // or  this.$refs.table.Render(this.headers)
    this.suscribeToDeviceEvents()
  },
  destroyed () {
    this.unsuscribreToDeviceEvents()
  },
  data () {
    return {
      headers: [],
      rows: [],
      rowVisibility: true,
      id: 1,
      contactos: [],
      contactosFine: [],
      catTipoContact: []

    }
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
        this.agregarContacto(data)
        this.id++
        $('#legales-tab').removeClass('active')
        $('#contactos-tab').addClass('active')
      })

      EventBus.$on('edit_contactos', (data) => {
        this.editarContacto(data)
        $('#legales-tab').removeClass('active')
        $('#contactos-tab').addClass('active')
      })

      EventBus.$on('Delete_contactos', (data) => {
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
      this.rows = []
      console.debug('DATOS_ROWS', this.rows)
      this.$refs.table.Render(this.headers, this.rows)
      this.Refresh()
    },
    async modalContactCreate () {
      this.$store.commit('CLEAR_MODAL_DINAMIC')
      this.$store.state.loader = true

      var datos = {
        'component': modalCreatedContact,
        'datos': {
          'seccion': 'contacto',
          'id': this.id

        }
      }

      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)

      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
    },
    agregarContacto (data) {
      console.debug('DA ', data, ' ta')
      // var element = data.contact

      var row = data

      this.$refs.table.AddRow(row)
      this.contactos.push(data)
      EventBus.$emit('get_listContact', this.contactos)
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
    eliminarcontac (data) {
      console.debug('DATA_DELETE', data)

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
    },
    editarContacto (data) {
      console.debug('DATA_EDIT', data)
      this.eliminarcontac(data.data)

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
  }

}
</script>

<style>

</style>
