<template>
    <div class="row m-r-5" >
        <div class="col-12" style="margin-top:20px;"> <h5 class="float-left" style=" padding-bottom: 10px;"><b>Agregar / {{this.title}}</b></h5></div>
        <div class="col-12" style="margin-top:-15px;"> <h6 class="float-left" style=" padding-bottom: 10px;">A continuación te mostramos los pasos para crear un {{this.title}}</h6>
        <hr style="margin-top:25px; ">
        </div>
        <div class="col-12" style="margin-top:15px;">
            <div class="card">

                <div class="card-body float-left">

                    <div id="smartwizard">
                        <ul>
                            <li id="item1" ><a href="#step-1">
                                    <h6>Paso 1</h6>
                                    <p class="m-0">Datos Legales</p>
                                </a></li>
                            <li id="item2"><a href="#step-2">
                                    <h6>Paso 2</h6>
                                    <p class="m-0">Datos domicilio</p>
                                </a></li>
                            <li @click="showContent(3)" id="item3"><a  href="#step-3">
                                    <h6>Paso 3</h6>
                                    <p class="m-0">Lista de contactos</p>
                                </a></li>

                        </ul>
                        <div>
                            <div id="step-1">
                              <div class="row">
                                  <div class="col-12 ">
                                  <div class="form-group ">
                                      <label for="selectStatusLegal">Estado legal *</label>
                                      <select class="form-control classdisabled " id="selectStatusLegal" v-model="statusLegal" @change="changeStatusLegal()" required>
                                        <option value="">Selecciona</option>
                                          <option v-for="slegal in catLegalStatus" :key="slegal.id" :value="slegal.id">{{slegal.name}}</option>
                                      </select>
                                  </div>
                                </div>
                                <div class="col-12 ">
                                    <config-input    id="nombreLegal" :label="labelLegal "  typeinput="text"  :placeholder="labelLegal" v-model.trim="nameLegal" required="true" :valor="nameLegal" toLowerUperCase="uppercase"></config-input>
                                </div>
                                <div id="divRFC" class="col-12 " style="display:none;">
                                    <config-input    id="rfc" :label="labelRFC"  typeinput="text"  :placeholder="labelRFC" v-model.trim="rfc" required="true" :valor="rfc" toLowerUperCase="uppercase"></config-input>
                                </div>
                                <div class="col-12 ">
                                    <config-input    id="addres" label="Dirección *"  typeinput="text"  placeholder="Dirección" v-model.trim="addres" required="true" :valor="addres" toLowerUperCase="uppercase"></config-input>
                                </div>

                                <div class="col-12 ">
                                    <config-input    id="notes" label="Notas"  typeinput="text"  placeholder="Notas" v-model.trim="notas" required="false" :valor="notas"></config-input>
                                </div>

                              </div>
                            </div>

                            <div id="step-2">
                              <div class="row">

                                <div class="col-12 ">
                                    <config-input    id="name" label="Nombre de la cuenta *"  typeinput="text"  placeholder="Nombre de la cuenta" v-model.trim="cuenta" required="true" :valor="cuenta" :disabled="visabled" toLowerUperCase="lowercase"></config-input>
                                </div>
                                <div class="col-12 ">
                                    <config-input    id="pais" label="País *"  typeinput="text"  placeholder="País" v-model.trim="pais" required="true" :valor="pais" toLowerUperCase="uppercase"></config-input>
                                </div>

                                <div class="col-12 ">
                                    <config-input    id="region" label="Región/Estado *"  typeinput="text"  placeholder="Región/Estado" v-model.trim="region" required="true" :valor="region" toLowerUperCase="uppercase"></config-input>
                                </div>
                                <div class="col-12 ">
                                    <config-input    id="cp" label="Código postal *"  typeinput="text"  placeholder="Código postal" v-model.trim="codep" required="true" :valor="codep" toLowerUperCase="uppercase"></config-input>
                                </div>
                                <div class="col-12 " >
                                    <div class="form-group ">
                                        <label for="zonaH">Zona horaria *</label>
                                        <select class="form-control classdisabled" id="zonaH" v-model="zonaH" :valor="zonaH" required>
                                            <option value="">Selecciona</option>
                                            <option v-for="zona in listZonaHoraria" :value="zona.id" :key="zona.id">{{zona.name}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 ">
                                  <config-input    id="email" label="Correo electrónico *"  typeinput="email"  placeholder="Correo electrónico" v-model.trim="email" required="true" :valor="email" toLowerUperCase="lowercase"></config-input>
                                </div>

                              </div>

                              </div>
                            <div id="step-3">
                                  <component :is='dynamicComponent.component'   ></component>

                            </div>

                        </div>

                    </div>

                    <div class="row">
                            <div class="col-12" id="alertasAD" style="margin-top: 40px; margin-bottom:15px;"></div>
                    </div>

                    <div id="btnCancelWizar" class="row" style="margin-top: -50px;">
                        <div class="col-12 col-sm-12 col-md-4  float-left">
                          <button  class="btn btn-outline-primary " type="button" @click="cancel()">Cancelar</button>
                        </div>
                    </div>

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
  },
  async mounted () {
    if (this.seccion == 1) { // distribuidor
      this.title = 'Distribuidor'

      this.$store.state.seccionMenu = 'Distribuidores'
    }
    if (this.seccion == 2) { // cliente
      this.title = 'Cliente'

      this.$store.state.seccionMenu = 'Clientes'
    }

    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })
    this.changeStatusLegal()
    this.$store.state.loader = false
    await EventBus.$emit('NAVBAR_MenuSimple', this.$store.state.seccionMenu)

    $('#smartwizard').smartWizard({
      theme: 'dots',
      transitionEffect: 'fade',
      enableURLhash: true,
      useURLhash: false,
      showStepURLhash: false,
      justified: true, // Nav menu justification. true/false
      autoAdjustHeight: true, // Automatically adjust content height
      lang: { // Language variables for button
        next: 'Siguiente',
        previous: 'Anterior'
      }
    })

    // $('.sw-toolbar-bottom').html(`
    //                               <div class="btn-group mr-2 sw-btn-group" role="group">
    //                                 <div class="col-12 col-md-4  float-left">
    //                                 <button  class="btn btn-outline-primary " type="button" @click="cancel()">Cancelar</button>
    //                                 </div>
    //                                 <div class="col-12 col-md-8">
    //                                   <button class="btn btn-secondary sw-btn-prev disabled" type="button">Previous</button>
    //                                   <button class="btn btn-secondary sw-btn-next" type="button">Next</button>
    //                                 </div>
    //                               </div>
    //                             `)

    $('.sw-btn-prev').removeClass('btn-secondary')
    $('.sw-btn-prev').addClass('btn-outline-primary')

    $('.sw-btn-next').removeClass('btn-secondary')
    $('.sw-btn-next').addClass('btn-primary')

    // $('.sw-btn-next').click(function () {
    //   if ($('#item3').hasClass('active')) {
    //     var stepIndex = $('#smartwizard').smartWizard('getStepIndex')
    //     console.debug('PASO', stepIndex)
    //     this.showContent(3)
    //   }
    // }).bind(this)

    // var stepIndex = $('#smartwizard').smartWizard('getStepIndex')
    // console.debug('PASO', stepIndex)

    $('#smartwizard').on('showStep', function (e, anchorObject, stepIndex, stepDirection, stepPosition) {
      console.debug('Estás en el paso' + stepIndex + 'ahora')
      this.showContent(stepIndex)
    }.bind(this))

    $('#smartwizard').on('click', '.ClickGuardar', function (e) {
      this.SendForm()
    }.bind(this))

    if (this.$store.state.typeDevice.mobile) {
      $('#btnCancelWizar').css({ 'margin-top': '0px' })
    }
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
    saveInfo () {
      alert('GUARDAR')
    },
    showContent (opc) {
      var opc1 = parseInt(opc)
      console.debug('SHOWCONECT', opc1)
      switch (opc1) {
        case 2:
          console.debug('PASO2')
          this.dynamicComponentName = 'tabla'

          this.dynamicComponent.component = () => import('@/views/Administrador/user/movil/dataTable.vue')

          setTimeout(() => {
            $('.sw-btn-next').html('Guardar')
            $('.sw-btn-next').addClass('ClickGuardar')
            $('.sw-btn-next').removeClass('disabled')
          }, 1500)

          this.visible = true

          break
        default:
          $('.sw-btn-next').html('Siguiente')
          $('.sw-btn-next').removeClass('ClickGuardar')
          $('.sw-btn-next').removeClass('disabled')

          break
      }
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
      this.labelLegal = 'Nombre legal / razon social *'
      this.labelRFC = 'RFC / ID legal *'
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

      // registro
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
      } else {
        $('#alertasAD').html(`<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Por favor, acompleta todos los campos marcados con (*) <button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>`)
        setTimeout(() => {
          $('#alertasAD').html('')
        }, 5000)
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

/* .sw-btn-prev{
      color: #04a9f5;
    background-color: transparent;
    background-image: none;
    border-color: #04a9f5;
}

.sw-btn-next{
      color: #04a9f5;
    background-color: transparent;
    background-image: none;
    border-color: #04a9f5;
} */
</style>
