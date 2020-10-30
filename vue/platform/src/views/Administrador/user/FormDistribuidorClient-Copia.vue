<template>
    <div class="row" >
        <div class="col-12"> <h5 class="float-left" style="font-size: 20px; padding-bottom: 10px;"><b>{{this.title}}</b></h5></div>
        <div class="col-12">
            <div class="card">
                <div class="card-header row">
                <div class="col-6" >
                <h5 class=" float-left" v-if="this.$store.state.modal.datosDymanic.accion=='editar'">Editar</h5>
                 <h5 class=" float-left" v-if="this.$store.state.modal.datosDymanic.accion=='consultar'" >Consultar</h5>
                 <h5 class=" float-left" v-if="this.$store.state.modal.datosDymanic.accion!='consultar' && this.$store.state.modal.datosDymanic.accion!='editar' && this.seccion!=0" >Nuevo</h5>
                 <h5 class=" float-left" v-if="this.seccion==0" >Mis datos</h5>
                </div>

                </div>
                <div class="card-body float-left">
                    <form @submit.prevent >
                        <div class="row">
                          <div class="col-12">  <p v-if="this.seccion==0" class="text-muted" style="text-align: justify; font-size: 12px; margin-top: 7px;">
             A continuación podrás consultar y modificar tus datos personales asi como de contacto</p>
             <p v-if="this.$store.state.modal.datosDymanic.accion=='editar'" class="text-muted" style="text-align: justify; font-size: 12px; margin-top: 7px;">
             A continuación podrás consultar y modificar los datos personales asi como de contacto de tus clientes</p>
              <p v-if="this.$store.state.modal.datosDymanic.accion!='consultar' && this.$store.state.modal.datosDymanic.accion!='editar' && this.seccion!=0" class="text-muted" style="text-align: justify; font-size: 12px; margin-top: 7px;">
             A continuación podrás registrar los datos personales asi como de contacto de tus clientes</p>
             </div>

                            <div class="col-12 col-md-4">

                              <p v-if="this.$store.state.modal.datosDymanic.accion=='editar' || this.seccion==0">Nombre de la cuenta:
                              <b >{{cuenta}}</b></p>
                                <config-input v-else   id="name" label="Nombre de la cuenta"  typeinput="text"  placeholder="Nombre de la cuenta" v-model.trim="cuenta" required="true" :valor="cuenta" :disabled="visabled" toLowerUperCase="lowercase"></config-input>
                            </div>
                            <div class="col-6" v-if="this.$store.state.modal.datosDymanic.accion=='editar'">
                              <p >Estado de la cuenta:
                              <b v-if="active==1">Activa</b>
                              <b v-if="active==0">Suspendida</b>
                              </p>
                            </div>
                            <div class="col-12 col-md-4" v-if="this.$store.state.modal.datosDymanic.accion!='editar' && this.seccion!=0">
                                <config-input    id="email" label="Correo electrónico"  typeinput="email"  placeholder="Correo electrónico" v-model.trim="email" required="true" :valor="email" toLowerUperCase="lowercase"></config-input>

                            </div>
                             <!-- <div class="col-12 col-md-4" v-if="this.seccion==0">

                                <p >Correo electrónico:
                                  <b >{{email}}</b></p>
                            </div> -->

                             <div class="col-12" style="margin-top:30px;" >
                                <h5 class="float-left">Datos legales</h5>
                                <hr style="margin-top: 2rem;">
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="form-group ">
                                    <label for="selectStatusLegal">Estado legal</label>
                                    <select class="form-control classdisabled " id="selectStatusLegal" v-model="statusLegal" @change="changeStatusLegal()" required>
                                      <option value="">Selecciona</option>
                                        <option v-for="slegal in catLegalStatus" :key="slegal.id" :value="slegal.id">{{slegal.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <config-input    id="nombreLegal" :label="labelLegal"  typeinput="text"  :placeholder="labelLegal" v-model.trim="nameLegal" required="true" :valor="nameLegal" toLowerUperCase="uppercase"></config-input>
                            </div>
                            <div id="divRFC" class="col-12 col-md-4" style="display:none;">
                                <config-input    id="rfc" :label="labelRFC"  typeinput="text"  :placeholder="labelRFC" v-model.trim="rfc" required="true" :valor="rfc" toLowerUperCase="uppercase"></config-input>
                            </div>
                            <div class="col-12 col-md-4">
                                <config-input    id="pais" label="País"  typeinput="text"  placeholder="País" v-model.trim="pais" required="true" :valor="pais" toLowerUperCase="uppercase"></config-input>
                            </div>

                            <div class="col-12 col-md-4">
                                <config-input    id="region" label="Región/Estado"  typeinput="text"  placeholder="Región/Estado" v-model.trim="region" required="true" :valor="region" toLowerUperCase="uppercase"></config-input>
                            </div>
                            <div class="col-12 col-md-4">
                                <config-input    id="cp" label="Código postal"  typeinput="text"  placeholder="Código postal" v-model.trim="codep" required="true" :valor="codep" toLowerUperCase="uppercase"></config-input>
                            </div>
                            <div class="col-12 col-md-4" v-if="this.$store.state.modal.datosDymanic.accion!='editar'">
                                 <div class="form-group ">
                                    <label for="zonaH">Zona horaria</label>
                                    <select class="form-control classdisabled" id="zonaH" v-model="zonaH" :valor="zonaH" required>
                                        <option value="">Selecciona</option>
                                        <option v-for="zona in listZonaHoraria" :value="zona.id" :key="zona.id">{{zona.name}}</option>
                                    </select>
                                </div>
                            </div>
                             <div class="col-12 col-md-4">
                                <config-input    id="addres" label="Dirección"  typeinput="text"  placeholder="Dirección" v-model.trim="addres" required="true" :valor="addres" toLowerUperCase="uppercase"></config-input>
                            </div>

                            <div class="col-12 col-md-4">
                                <config-input    id="notes" label="Notas"  typeinput="text"  placeholder="Notas" v-model.trim="notas" required="false" :valor="notas"></config-input>
                            </div>

                            <div class="col-12" style="margin-top:50px;" v-if="this.$store.state.modal.datosDymanic.accion!='consultar'">
                                <h5 class="float-left">Contactos</h5>
                                <hr style="margin-top: 2rem;">
                            </div>

                            <div class="col-12" v-if="this.$store.state.modal.datosDymanic.accion!='consultar'">
                                  <div class="row float-left" >

                                      <div class="col-12 col-md-3">
                                          <div class="form-group">
                                              <label for="exampleFormControlSelect2">Tipo contacto</label>
                                              <select class="form-control" id="exampleFormControlSelect2" v-model="tipoContac">
                                                  <option value="null">Ninguno</option>
                                                  <option v-for="tipoC in catTipoContact" :key="tipoC.id" :value="tipoC.id">{{tipoC.name}}</option>
                                              </select>
                                          </div>
                                      </div>
                                      <div class="col-12 col-md-3">
                                          <config-input   id="nameContac" label="Nombre"  typeinput="text"  placeholder="Nombre" v-model.trim="nameContac" required="false" :valor="nameContac" toLowerUperCase="uppercase"> </config-input>
                                      </div>
                                      <div class="col-12 col-md-3">
                                          <config-input   id="telefono" label="Teléfono"  typeinput="number"  placeholder="Teléfono" v-model.trim="telefono" required="false" :valor="telefono"> </config-input>
                                      </div>
                                      <div class="col-12 col-md-3">
                                          <config-input   id="celular" label="Celular"  typeinput="number"  placeholder="Celular" v-model.trim="celular" required="false" :valor="celular"> </config-input>
                                      </div>

                                      <div class="col-12 col-md-4">
                                          <config-input   id="emailContac" label="Correo electrónico"  typeinput="email"  placeholder="Correo electrónico" v-model.trim="emailContac" required="false" :valor="emailContac" toLowerUperCase="lowercase"></config-input>
                                      </div>

                                      <div class="col-10 col-md-7">
                                          <config-input   id="notasContac" label="Notas"  typeinput="text"  placeholder="Notas" v-model.trim="notasContac" required="false" :valor="notasContac"></config-input>
                                      </div>
                                      <div class="col-2 col-md-1" style="padding-left: 0px;">
                                          <button id="agregarContac" type="button" class="btn btn-icon btn-primary" @click="agregarContac()" style="height: 35px; padding-top:8px; margin-top: 32px;">
                                              <i class="feather icon-plus"></i>
                                          </button>
                                      </div>
                                  </div>

                            </div>

                             <div class="col-12" style="margin-top: 20px" >
                                        <div class="row float-left" style="width: 100%;">
                                            <div class="col-12">
                                                <h5 class="float-left">Lista de contactos</h5>
                                            <hr style="margin-top: 2rem;" v-if="contactos.length==0">
                                            </div>

                                            <div class="col-12" style="margin-top:15px; overflow: auto;  max-height: 300px;" v-if="contactos.length>0">
                                              <table class="table table-hover header_fijo">
                                                <thead>
                                                  <tr>
                                                    <th>#</th>
                                                    <th>contacto</th>
                                                    <th>Tipo</th>
                                                    <th>telefono</th>
                                                    <th>celular</th>
                                                    <th>correo</th>
                                                    <th>Acciones</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  <tr v-for="(element, index) in contactos" :key="index">
                                                    <td>{{index+1}}</td>
                                                    <td >{{element.name}}</td>
                                                    <td>{{element.tipo}}</td>
                                                    <td >{{element.phone}}</td>
                                                    <td>{{element.cel}}</td>
                                                    <td>{{element.email}}</td>
                                                    <td id="btnEliminar" class="classdisabled">

                                                      <span class="btnEliminar" @click="eliminarcontac(element.id)"><i class="cursor icon-small icon universalicon-trash-2 colorText-red"></i></span>
                                                    </td>

                                                  </tr>
                                                </tbody>
                                              </table>
                                            </div>

                                            <div class="col-12" style="overflow: auto; max-height: 130px;" v-if="contactos.length==0">Sin contactos</div>
                                        </div>
                                    </div>

                            <div class="col-12" id="alertasAD" style="margin-top: 40px;"></div>

                            <div class="col-12 " style="margin-top: 15px;">
                                <button class="btn btn-secondary shadow-2 mb-4 float-left" @click="cancel()" v-if="this.seccion!=0">CANCELAR</button>
                                <button class="btn btn-primary shadow-2 mb-4 float-right" @click="SendForm()" type="submit" v-if="this.$store.state.modal.datosDymanic.accion != 'editar' && this.$store.state.modal.datosDymanic.accion != 'consultar' && this.seccion!=0">REGISTRAR</button>
                                <button class="btn btn-primary shadow-2 mb-4 float-right" @click="SendForm()" type="submit" v-if="this.$store.state.modal.datosDymanic.accion == 'editar' || this.seccion==0 ">EDITAR</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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
      active: null

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
        this.contactos.push({ 'id': this.id, 'idC': element.id, 'name': element.name, 'phone': element.phone, 'cel': element.cel, 'email': element.email, 'tipo': element.contactType })

        this.contactosFine.push({
          'id': this.id,
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
        this.contactos.push({ 'id': this.id, 'idC': element.id, 'name': element.name, 'phone': element.phone, 'cel': element.cel, 'email': element.email, 'tipo': element.contactType })

        this.contactosFine.push({
          'id': this.id,
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
      this.$store.state.loader = true

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
          console.debug('DATOOS_REQUEST', request)

          if (request.success === true) {
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
          this.contactos.push({ 'id': this.id, 'name': this.nameContac, 'phone': this.telefono, 'cel': this.celular, 'email': this.emailContac, 'tipo': tipoC.name })

          this.contactosFine.push({
            'id': this.id,
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

      console.debug('TIPO', dat)

      var eliminarC = true
      this.$store.state.loader = true

      if (this.$store.state.modal.datosDymanic.accion == 'editar' || this.seccion == 0) {
        var request = await this.deleteRequest('accounts/contacts/' + dat.idC)

        if (request.success === true) {
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
    },
    /**
   * @vuese
   * Envia datos y registra un distribuidor o un cliente segun sea el caso
   */
    async SendForm () {
      this.$store.state.loader = true
      var typeUser = 0
      var tipo = ''

      if (this.contactosFine.length == 0) {
        $('#alertasAD').html(`<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Debes agregar al menos un contacto<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>`)
        setTimeout(() => {
          $('#alertasAD').html('')
        }, 5000)
        return false
      }

      if (this.$store.state.modal.datosDymanic.accion == 'editar') { // edita clientes y distribuidores
        console.debug('EDITAR CLIENTES_DISTRIBUIDOR')
        if (this.statusLegal != '' && this.statusLegal != null && this.nameLegal != null && this.nameLegal != '' &&
          this.pais != null && this.pais != '' && this.region != null && this.region != '' && this.codep != null && this.codep != '' && this.addres != null && this.addres != '' && this.rfc != null && this.rfc != '') {
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
              'statusID': this.statusLegal,

              'taxID': this.rfc.toUpperCase(this.rfc),
              'name': this.nameLegal.toUpperCase(this.nameLegal),
              'country': this.pais.toUpperCase(this.pais),
              'region': this.region.toUpperCase(this.region),
              'zipCode': this.codep.toUpperCase(this.codep),
              'notes': this.notas,
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
      } else {
        if (this.seccion == 0) { // edita mi perfil
          console.debug('MI PERFIL')
          if (this.statusLegal != '' && this.statusLegal != null && this.nameLegal != null && this.nameLegal != '' &&
          this.pais != null && this.pais != '' && this.region != null && this.region != '' && this.codep != null && this.codep != '' && this.addres != null && this.addres != '' && this.rfc != null && this.rfc != '') {
            console.debug('MIS ENTRA')
            var datos = {}

            var datlegal = {
              'legal': {
                'statusID': this.statusLegal,
                'taxID': this.rfc.toUpperCase(this.rfc),
                'name': this.nameLegal.toUpperCase(this.nameLegal),
                'country': this.pais.toUpperCase(this.pais),
                'region': this.region.toUpperCase(this.region),
                'zipCode': this.codep.toUpperCase(this.codep),
                'notes': this.notas,
                'address': this.addres.toUpperCase(this.addres)

              }
            }

            datos.customer = datlegal

            console.debug(datlegal, 'DATOS', datos)

            var request = await this.putRequest('configuration/account', datos)

            if (request.success === true) {
              this.$store.state.loader = false
              $('#alertasAD').html(`<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se han actualizado tus datos<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>`)
              setTimeout(() => {
                $('#alertasAD').html('')
                this.cancel()
              }, 3000)
            } else {
              this.$store.state.loader = false
              $('#alertasAD').html(`<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se han actulizado tus datos<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>`)
              setTimeout(() => {
                $('#alertasAD').html('')
              }, 5000)
            }
          }
        } else { // registro
          console.debug('REGISTRO')
          if (this.cuenta != null && this.cuenta != '' && this.email != null && this.email != '' && this.zonaH != '' && this.zonaH != null && this.statusLegal != '' && this.statusLegal != null && this.nameLegal != null && this.nameLegal != '' &&
          this.pais != null && this.pais != '' && this.region != null && this.region != '' && this.codep != null && this.codep != '' && this.addres != null && this.addres != '' &&
          this.rfc != null && this.rfc != '') {
            if (this.seccion == 1) { // distribuidor
              typeUser = 2
              tipo = 'distribuidor'
            }
            if (this.seccion == 2) { // cliente
              typeUser = 1
              tipo = 'cliente'
            }

            var datos = {}

            var datosAccount = {
              'type': typeUser,
              'name': this.cuenta.toLowerCase(this.cuenta),
              'email': this.email.toLowerCase(this.email),
              'timezone': this.zonaH
            }

            var legal = {
              'statusID': this.statusLegal,
              'name': this.nameLegal.toUpperCase(this.nameLegal),
              'country': this.pais.toUpperCase(this.pais),
              'region': this.region.toUpperCase(this.region),
              'zipCode': this.codep.toUpperCase(this.codep),
              'notes': this.notas,
              'address': this.addres.toUpperCase(this.addres),
              'id': this.rfc.toUpperCase(this.rfc)
            }

            var listContactos = []
            this.contactosFine.forEach(element => {
              listContactos.push({
                'type': element.type,
                'name': element.name.toUpperCase(element.name),
                'phone': element.phone,
                'cel': element.cel,
                'email': element.email.toLowerCase(element.email),
                'notes': element.notes
              })
            })

            datos['account'] = datosAccount
            datos['legal'] = legal
            datos['contacts'] = listContactos

            console.debug('DATOS', datos)

            var request = await this.postRequest('accounts', datos)

            if (request.success === true) {
              this.$store.state.loader = false
              $('#alertasAD').html(`<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha creado el ${tipo} <button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>`)
              setTimeout(() => {
                $('#alertasAD').html('')
                this.cancel()
              }, 3000)
            } else {
              this.$store.state.loader = false
              var message = ''
              switch (request.error.title) {
                case 'USER_EXISTS':
                  message = 'El usuario ya existe'
                  break
                case 'EMAIL_EXISTS':
                  message = 'El correo electrónico ya existe'
                  break
                case 'UNAUTHORIZED':
                  message = 'No cuenta con los permisos para realizar la accion'
                  break
                default:
                  message = 'No se ha podido crear el ' + tipo
                  break
              }

              $('#alertasAD').html(`<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>${message} <button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>`)
              setTimeout(() => {
                $('#alertasAD').html('')
              }, 5000)
            }
          }
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
        this.$router.push('/ListTableClient')
      }
    }
  }

}
</script>

<style >
.toupperCase{
  text-transform: uppercase;
}
</style>
