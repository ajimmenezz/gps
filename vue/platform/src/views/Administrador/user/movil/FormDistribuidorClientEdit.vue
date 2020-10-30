<template>
    <div class="row m-r-5" >
        <div class="col-12" style="margin-top:20px;"> <h5 class="float-left" style=" padding-bottom: 10px;"><b>Editar / {{this.title}}</b></h5></div>
        <div class="col-12" style="margin-top:-15px;"> <h6 class="float-left" style=" padding-bottom: 10px;">A continuación podrás consultar y editar los datos legales</h6>
          <hr style="margin-top:25px; ">
        </div>

        <div class="col-12" style="margin-top:15px;">

                                       <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item cursor" @click="showOptionTab(1)">
                                            <a class="nav-link active text-uppercase" id="legales-tab" data-toggle="tab"  role="tab" aria-controls="legales" aria-selected="true">Datos legales</a>
                                        </li>
                                        <li class="nav-item cursor" @click="showOptionTab(2)">
                                            <a class="nav-link text-uppercase" id="contactos-tab" data-toggle="tab" role="tab" aria-controls="contactos" aria-selected="false">Datos de domicilio</a>
                                        </li>
                                         <li class="nav-item cursor" @click="showOptionTab(3)">
                                            <a class="nav-link text-uppercase" id="contactos-tab" data-toggle="tab" role="tab" aria-controls="contactos" aria-selected="false">Lista de contactos</a>
                                        </li>

                                    </ul>

                                     <div class="card float-left" style=" box-shadow: none; width: 100%;">
                                    <!-- <form @submit.prevent > -->

                                        <component :is='dynamicComponent.component'   v-if="visible" ></component>

                                    <!-- </form> -->

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
      active: null,
      dynamicComponent: {
        component: null,
        properties: null,
        events: {

        }
      },
      visible: false

    }
  },
  async created () {
    this.$store.state.loader = true
    this.catStatusLegal()
    this.catPeople()
    this.zonaHoraria()

    this.getInfoCliente()
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

      this.$store.state.seccionMenu = 'Clientes'
    }

    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })
    this.changeStatusLegal()
    this.$store.state.loader = false
    await EventBus.$emit('NAVBAR_MenuSimple', this.$store.state.seccionMenu)

    this.showOptionTab(1)
    this.suscribeToDeviceEvents()
  },
  destroyed () {
    this.unsuscribreToDeviceEvents()
  },
  methods: {
    /**
   * @vuese
   * se suscribe a eventos eventBus para actulizar el listado de sims
   */
    suscribeToDeviceEvents () {
      EventBus.$on('get_listContact', (data) => {
        this.getListContactos(data)
      })
    },
    /**
   * @vuese
   * Se destruye la suscripcion al eventBus
   */
    unsuscribreToDeviceEvents () {
      EventBus.$off('get_listContact')
    },
    /**
   * @vuese
   * Muestra contenido formulario de clientesz
   */
    async showOptionTab (item) {
      console.debug('SHOWCONTENT', item)
      this.visible = false
      this.$store.state.loader = true
      this.clearComponentsDinamic()

      var opc = parseFloat(item)
      console.debug(opc)

      this.optionTab = opc
      switch (opc) {
        case 1: // legales
          console.debug('case1')
          this.dynamicComponentName = 'legales'
          this.dynamicComponent.component = () => import('@/views/Administrador/user/movil/editLegales.vue')

          break
        case 2: // tabla

          console.debug('case2')
          this.dynamicComponentName = 'domicilio'

          this.dynamicComponent.component = () => import('@/views/Administrador/user/movil/editDomicilio.vue')

          break
        case 3: // logo
          console.debug('case3')
          this.dynamicComponentName = 'tabla'

          this.dynamicComponent.component = () => import('@/views/Administrador/user/movil/dataTableEdit.vue')

          break
      }
      this.visible = true
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
    getListContactos (data) {
      this.contactosFine = []
      console.debug('DATOS_FORM', data)
      data.forEach(element => {
        var search
        var tipo = 0

        this.catTipoContact.filter(function (dato, i) {
          if (dato.name === element.tipo) {
            search = i
            tipo = dato
            return true
          }
        })
        console.debug('DOTOS_FORM_2', element.tipo, tipo)

        this.contactosFine.push({
          'type': tipo.id,
          'name': element.name,
          'phone': element.phone,
          'cel': element.cel,
          'email': element.email,
          'notes': element.notes
        })
      })
    },
    /**
   * @vuese
   * Envia datos y registra un distribuidor o un cliente segun sea el caso
   */
    async SendForm () {
      var typeUser = 0
      var tipo = ''

      if (this.contactosFine.length == 0) {
        $('#alertasAD').html(`<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Debes agregar al menos un contacto<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>`)
        setTimeout(() => {
          $('#alertasAD').html('')
        }, 5000)
        return false
      }

      this.$store.state.loader = true

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
        this.$router.push('/ListaCliente')
      }
    }
  }

}
</script>

<style scoped>
.toupperCase{
  text-transform: uppercase;
}
</style>
