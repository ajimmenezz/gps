<template>

                <div class="card-body float-left row">

                    <div class="col-12 ">
                        <config-input    id="pais" label="País"  typeinput="text"  placeholder="País" v-model.trim="pais" required="true" :valor="pais" toLowerUperCase="uppercase"></config-input>
                    </div>

                    <div class="col-12 ">
                        <config-input    id="region" label="Región/Estado"  typeinput="text"  placeholder="Región/Estado" v-model.trim="region" required="true" :valor="region" toLowerUperCase="uppercase"></config-input>
                    </div>
                    <div class="col-12 ">
                        <config-input    id="cp" label="Código postal"  typeinput="text"  placeholder="Código postal" v-model.trim="codep" required="true" :valor="codep" toLowerUperCase="uppercase"></config-input>
                    </div>
                    <div class="col-12 " v-if="this.$store.state.modal.datosDymanic.accion!='editar'">
                          <div class="form-group ">
                            <label for="zonaH">Zona horaria</label>
                            <select class="form-control classdisabled" id="zonaH" v-model="zonaH" :valor="zonaH" required>
                                <option value="">Selecciona</option>
                                <option v-for="zona in listZonaHoraria" :value="zona.id" :key="zona.id">{{zona.name}}</option>
                            </select>
                        </div>
                    </div>
                     <div class="col-12">
                      <config-input    id="addres" label="Dirección"  typeinput="text"  placeholder="Dirección" v-model.trim="addres" required="true" :valor="addres" toLowerUperCase="uppercase"></config-input>
                    </div>
                     <!-- <div class="col-12 ">
                      <config-input    id="email" label="Correo electrónico"  typeinput="email"  placeholder="Correo electrónico" v-model.trim="email" required="true" :valor="email" toLowerUperCase="lowercase"></config-input>
                    </div> -->

                    <div  class="col-12  float-right">
                      <button v-if="!Getdisabled" id="editSubmit" type="submit" class="btn btn-primary" @click="editarCampos(true)" >Editar</button>
                      <button v-if="Getdisabled" class="btn btn-outline-primary " type="button" @click="editarCampos(false)">Cancelar</button>
                      <button v-if="Getdisabled" id="registerSubmit" type="submit" class="btn btn-primary " @click="SendForm()" >Guardar</button>
                    </div>

                </div>

</template>

<script>
import { API } from '@/mixins/API'
import { Functions } from '@/mixins/Functions.js'
import EventBus from '@/EventBus.js'
/**
 * @vuese
 * @group Administrador/Distribuidor/Cliente
 * Formulario para crear distribuidor/Cliente
 */

export default {
  name: 'FormDistribuidorCliente',
  mixins: [API, Functions],
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
      tipoContac: null,
      nameContac: null,
      telefono: null,
      celular: null,
      addres: null,
      emailContac: null,
      notasContac: null,
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
      setDisabled: true

    }
  },
  async created () {
    this.$store.state.loader = true
    this.catStatusLegal()
    this.catPeople()
    this.zonaHoraria()
    if (this.$store.state.modal.datosDymanic.accion == 'editar') {
      this.getInfoCliente()
    }

    if (this.seccion == 0) {
      this.getInfoMiPerfil()
    }
  },
  async mounted () {
    this.editarCampos(false)
    if (this.seccion == 1) { // distribuidor
      if (this.$store.state.modal.datosDymanic.accion == 'editar') {
        this.title = 'Distribuidor'
      } else {
        this.title = 'Distribuidor'
      }
      this.$store.state.seccionMenu = 'Distribuidores'
    }
    if (this.seccion == 2) { // cliente
      this.title = 'Cliente'
      if (this.$store.state.modal.datosDymanic.accion == 'editar') {
        this.title = 'Cliente'
      }
      if (this.$store.state.modal.datosDymanic.accion == 'consultar') {
        this.title = 'Cliente'
        // $('.classdisabled').attr('disabled', 'disabled')
        // $('.btnEliminar').css({ 'display': 'none' })
        // $('.btnEliminar').css({ 'display': 'none' })
      }
      this.$store.state.seccionMenu = 'Clientes'
    }

    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })
    this.changeStatusLegal()
    this.$store.state.loader = false
    await EventBus.$emit('NAVBAR_MenuSimple', this.$store.state.seccionMenu)

    if (this.seccion == 0) {
      this.$store.state.submenuActive = 'config'
      this.$store.state.itemSubmenuActive = 'itemPerfil'
      await EventBus.$emit('NAVBAR_MenuOpciones', 'config', 'itemPerfil')

      this.title = ' Mi cuenta'
    }
  },
  methods: {
    /**
   * @vuese
   * cancela el proceso y regresa a la tabla de distribuidores/clientes
   */
    cancel () {
      if (this.seccion == 1) { // distribuidor
        this.$router.push('/ListTableDistrobuitor')
      }
      if (this.seccion == 2) { // cliente
        this.$router.push('/ListTableClient')
      }
    },
    editarCampos (disabled) {
      console.debug('editarCampos', disabled)
      this.setDisabled = disabled
      if (disabled == true) {
        $('#pais').removeAttr('disabled')
        $('#region').removeAttr('disabled')
        $('#cp').removeAttr('disabled')
        // $('#zonaH').removeAttr('disabled')
        $('#addres').removeAttr('disabled')
        $('#editSubmit').html('Guardar')
      }
      if (disabled == false) {
        $('#pais').attr('disabled', 'disabled')
        $('#region').attr('disabled', 'disabled')
        $('#cp').attr('disabled', 'disabled')

        $('#addres').attr('disabled', 'disabled')
        $('#email').attr('disabled', 'disabled')
        $('#editSubmit').html('Editar')
      }
    },
    /**
   * @vuese
   * Obtiene la informacion del cliene
   */
    async getInfoCliente () {
      var response = await this.getRequest(`accounts/${this.$store.state.modal.datosDymanic.clientID}`)
      console.debug(response)
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
        this.contactos.push({ 'id': element.id, 'idC': element.id, 'name': element.name, 'phone': element.phone, 'cel': element.cel, 'email': element.email, 'tipo': element.contactType })

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
    },
    /**
   * @vuese
   * Obtiene la informacion del mi perfil
   */
    async getInfoMiPerfil () {
      var response = await this.getRequest(`configuration/account`)
      console.debug(response)
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
        this.contactos.push({ 'id': element.id, 'idC': element.id, 'name': element.name, 'phone': element.phone, 'cel': element.cel, 'email': element.email, 'tipo': element.contactType })

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
    },
    /**
   * @vuese
   * Obtiene catalogo de estatus legal
   */
    async catStatusLegal () {
      var request = await this.getRequest('catalogs/legalstatus')

      var data = request.data.legalStatus

      this.catLegalStatus = data
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
   * Obtiene catalogo de las zonas horarias
   */
    async zonaHoraria () {
      var request = await this.getRequest('catalogs/timezones')

      if (request.success === true) {
        this.listZonaHoraria = request.data.timezones
      }
    },
    /**
   * @vuese
   * Cada que se cambia el estatus legal, muestra u oculta elementos
   */
    changeStatusLegal () {
      // fisica y moral
      $('#divRFC').css({ 'display': 'block' })
      this.labelLegal = 'Nombre legal / razon social'
      this.labelRFC = 'RFC / ID legal'
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

      if (this.contactos.length < 3) {
        var agregar = true

        if (this.$store.state.modal.datosDymanic.accion == 'editar') {
          var contact = {
            'contactType': this.tipoContac,
            'name': this.nameContac.toUpperCase(this.nameContac),
            'phone': this.telefono,
            'cel': this.celular,
            'email': this.emailContac.toUpperCase(this.emailContac),
            'notes': this.notasContac
          }
          var datos = {}
          datos['contact'] = contact
          console.debug('DATOOS', datos)
          var request = await this.postRequest('accounts/' + this.$store.state.modal.datosDymanic.clientID + '/contacts', datos)

          if (request.success === true) {
            agregar = true
            contactID = request.data.contactID
            this.$store.state.loader = false
          } else {
            agregar = false
            this.$store.state.loader = false
            $('#alertasAD').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error, </strong>No se ha agregado el contacto</div>")
            setTimeout(() => {
              $('#alertasAD').html('')
            }, 5000)
          }
        }

        if (this.seccion == 0) {
          this.$store.state.loader = true
          var contact = {

            'contactType': this.tipoContac,
            'name': this.nameContac.toUpperCase(this.nameContac),
            'phone': this.telefono,
            'cel': this.celular,
            'email': this.emailContac.toUpperCase(this.emailContac),
            'notes': this.notasContac
          }
          var datos = {}
          datos['contact'] = contact
          console.debug('DATOOS', datos)
          var request = await this.postRequest('accounts/contacts', datos)

          if (request.success === true) {
            contactID = request.data.contactID
            this.$store.state.loader = false
            agregar = true
          } else {
            agregar = false
            this.$store.state.loader = false
            $('#alertasAD').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error, </strong>No se ha agregado el contacto</div>")
            setTimeout(() => {
              $('#alertasAD').html('')
            }, 5000)
          }
        }

        if (agregar) {
          if (this.$store.state.modal.datosDymanic.accion != 'editar') {
            contactID = this.id
          }
          this.contactos.push({ 'id': contactID, 'idC': contactID, 'name': this.nameContac, 'phone': this.telefono, 'cel': this.celular, 'email': this.emailContac, 'tipo': tipoC.name })

          this.contactosFine.push({
            'id': contactID,
            'idC': contactID,
            'type': this.tipoContac,

            'name': this.nameContac.toUpperCase(this.nameContac),
            'phone': this.telefono,
            'cel': this.celular,
            'email': this.emailContac.toUpperCase(this.emailContac),
            'notes': this.notasContac
          })

          this.id++
        }
      }

      if (this.contactos.length == 3) {
        this.$store.state.loader = false
        $('#alertasAD').html("<div class='alert alert-info alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente, </strong>Limite de 3 contactos alcanzado</div>")
        setTimeout(() => {
          $('#alertasAD').html('')
        }, 5000)

        $('#agregarContac').attr('disabled', 'disabled')
        this.nameContac = null
        this.telefono = null
        this.celular = null
        this.emailContac = null
        return true
      }

      this.nameContac = null
      this.telefono = null
      this.celular = null
      this.emailContac = null
      this.$store.state.loader = false
    },
    /**
   * @vuese
   * Elimina contactos a la lista
   */
    async eliminarcontac (id) {
      var search
      var dat = 0
      this.contactos.filter(function (dato, i) {
        if (dato.id == id) {
          search = i
          dat = dato
          return true
        }
      })

      console.debug('TIPO', dat, this.$store.state.modal.datosDymanic.accion, this.seccion)

      var eliminarC = true
      this.$store.state.loader = true

      if (this.$store.state.modal.datosDymanic.accion == 'editar' || this.seccion == 0) {
        var params = {}
        var body = {}
        var request = await this.deleteRequest('accounts/contacts/' + dat.idC, params, body)

        console.debug('REQUEST_DELETE', await request)

        if (request.success == true) {
          this.$store.state.loader = false
          eliminarC = true
        } else {
          eliminarC = false
          this.$store.state.loader = false
          $('#alertasAD').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error, </strong>No se ha eliminado el contacto</div>")
          setTimeout(() => {
            $('#alertasAD').html('')
          }, 5000)
        }
      }

      if (eliminarC) {
        this.contactos.splice(search, 1)
        this.contactosFine.splice(search, 1)
      }
      $('#agregarContac').removeAttr('disabled')
      this.$store.state.loader = false
    },
    /**
   * @vuese
   * Envia datos y registra un distribuidor o un cliente segun sea el caso
   */
    async SendForm () {
      var typeUser = 0
      var tipo = ''

      this.$store.state.loader = true

      // edita clientes y distribuidores
      console.debug('EDITAR CLIENTES_DISTRIBUIDOR')
      if (this.pais != null && this.pais != '' && this.region != null && this.region != '' &&
         this.codep != null && this.codep != '' && this.addres != null && this.addres != '') {
        if (this.seccion == 1) { // distribuidor
          typeUser = 2
          tipo = 'distribuidor'
        }
        if (this.seccion == 2) { // cliente
          typeUser = 1
          tipo = 'cliente'
        }

        var datos = {}

        var datlegal = {
          'legal': {

            'country': this.pais.toUpperCase(this.pais),
            'region': this.region.toUpperCase(this.region),
            'zipCode': this.codep.toUpperCase(this.codep),
            'address': this.addres.toUpperCase(this.addres)

          }
        }

        datos.customer = datlegal

        console.debug(datlegal, 'DATOS', datos)

        var request = await this.putRequest('accounts/' + this.$store.state.modal.datosDymanic.clientID, datos)

        if (request.success === true) {
          this.$store.state.loader = false
          $('#alertasAD').html(`<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha actualizado el ${tipo} <button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>`)
          setTimeout(() => {
            $('#alertasAD').html('')
            this.cancel()
          }, 3000)
        } else {
          this.$store.state.loader = false
          $('#alertasAD').html(`<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se ha actulizado<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>`)
          setTimeout(() => {
            $('#alertasAD').html('')
          }, 5000)
        }
      }

      this.$store.state.loader = false
    },
    /**
   * @vuese
   * cancela el proceso y regresa a la tabla de distribuidores/clientes
   */
    cancel () {
      if (this.seccion == 1) { // distribuidor
        this.$router.push('/ListTableDistrobuitor')
      }
      if (this.seccion == 2) { // cliente
        this.$router.push('/ListaCliente')
      }
    }
  },
  computed: {
    Getdisabled () {
      return this.setDisabled
    }
  }

}
</script>

<style scoped>
.toupperCase{
  text-transform: uppercase;
}
</style>
