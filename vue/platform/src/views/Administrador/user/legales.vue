<template>
    <div  class="card-body" >
        <div  v-if="!this.$store.state.typeDevice.tablet && !this.$store.state.typeDevice.mobile " id="legales" >
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="form-group ">
                        <label for="selectStatusLegal">Estado legal</label>
                        <select class="form-control classdisabled " id="selectStatusLegal" v-model="statusLegal" @change="changeStatusLegal()" required >
                        <option value="">Selecciona</option>
                            <option v-for="slegal in catLegalStatus" :key="slegal.id" :value="slegal.id">{{slegal.name}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <config-input    id="nombreLegal" :label="labelLegal"  typeinput="text"  :placeholder="labelLegal" v-model.trim="nameLegal" required="true" :valor="nameLegal" toLowerUperCase="uppercase" ></config-input>
                </div>
                <div id="divRFC" class="col-12 col-md-4" style="display:none;">
                    <config-input     id="rfc" :label="labelRFC"  typeinput="text"  :placeholder="labelRFC" v-model.trim="rfc" required="true" :valor="rfc" toLowerUperCase="uppercase"></config-input>
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
                <div class="col-12 col-md-4" >
                    <div class="form-group ">
                        <label for="zonaH">Zona horaria</label>
                        <select class="form-control classdisabled" id="zonaH" v-model="zonaH" :valor="zonaH" required >
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

                <div class="col-12 " id="alertasAD">

                </div>

                <div class="col-12  float-right">
                <button v-if="!Getdisabled" id="editSubmit" type="submit" class="btn btn-primary" @click="editarCampos(true)" >Editar datos</button>
                <button v-if="Getdisabled" class="btn btn-outline-primary " type="button" @click="editarCampos(false)">Cancelar actualizacion</button>
                <button v-if="Getdisabled" id="registerSubmit" type="submit" class="btn btn-primary " @click="SendFormLegales()" >Guardar cambios</button>
                </div>
            </div>
        </div>

        <div v-if="(this.$store.state.typeDevice.tablet || this.$store.state.typeDevice.mobile)"  id="legalesM" >
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group ">
                        <label for="selectStatusLegal">Estado legal</label>
                        <select class="form-control classdisabled " id="selectStatusLegal" v-model="statusLegal" @change="changeStatusLegal()" required >
                        <option value="">Selecciona</option>
                            <option v-for="slegal in catLegalStatus" :key="slegal.id" :value="slegal.id">{{slegal.name}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <config-input    id="nombreLegal" :label="labelLegal"  typeinput="text"  :placeholder="labelLegal" v-model.trim="nameLegal" required="true" :valor="nameLegal" toLowerUperCase="uppercase" ></config-input>
                </div>
                <div id="divRFC" class="col-12 col-md-6" style="display:none;">
                    <config-input     id="rfc" :label="labelRFC"  typeinput="text"  :placeholder="labelRFC" v-model.trim="rfc" required="true" :valor="rfc" toLowerUperCase="uppercase"></config-input>
                </div>
                <div class="col-12 col-md-6">
                    <config-input    id="pais" label="País"  typeinput="text"  placeholder="País" v-model.trim="pais" required="true" :valor="pais" toLowerUperCase="uppercase"></config-input>
                </div>

                <div class="col-12 col-md-6">
                    <config-input    id="region" label="Región/Estado"  typeinput="text"  placeholder="Región/Estado" v-model.trim="region" required="true" :valor="region" toLowerUperCase="uppercase"></config-input>
                </div>
                <div class="col-12 col-md-6">
                    <config-input    id="cp" label="Código postal"  typeinput="text"  placeholder="Código postal" v-model.trim="codep" required="true" :valor="codep" toLowerUperCase="uppercase"></config-input>
                </div>
                <div class="col-12 col-md-6" >
                    <div class="form-group ">
                        <label for="zonaH">Zona horaria</label>
                        <select class="form-control classdisabled" id="zonaH" v-model="zonaH" :valor="zonaH" required >
                            <option value="">Selecciona</option>
                            <option v-for="zona in listZonaHoraria" :value="zona.id" :key="zona.id">{{zona.name}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <config-input    id="addres" label="Dirección"  typeinput="text"  placeholder="Dirección" v-model.trim="addres" required="true" :valor="addres" toLowerUperCase="uppercase"></config-input>
                </div>

                <div class="col-12 col-md-6">
                    <config-input    id="notes" label="Notas"  typeinput="text"  placeholder="Notas" v-model.trim="notas" required="false" :valor="notas"></config-input>
                </div>

                <div v-if="this.$store.state.typeDevice.mobile && optionTab==1"  class="col-12 float-right">
                <button v-if="!Getdisabled" id="editSubmit" type="submit" class=" btn-block btn btn-primary" @click="editarCampos(true)"
                style="    right: 0px;
                bottom: 0px;
                margin-top: 25px;
                ">Editar datos</button>
                <button v-if="Getdisabled" class=" btn-block btn btn-outline-primary " type="button" @click="editarCampos(false)">Cancelar actualizacion</button>
                <button v-if="Getdisabled" id="registerSubmit" type="submit" class=" btn-block btn btn-primary " @click="SendFormLegales()" >Guardar cambios</button>
                </div>

                <div v-if="!this.$store.state.typeDevice.mobile && optionTab==1"  class="col-12 col-md-6 float-right">
                <button v-if="!Getdisabled" id="editSubmit" type="submit" class="btn btn-primary" @click="editarCampos(true)" >Editar datos</button>
                <button v-if="Getdisabled" class="btn btn-outline-primary " type="button" @click="editarCampos(false)">Cancelar actualizacion</button>
                <button v-if="Getdisabled" id="registerSubmit" type="submit" class="btn btn-primary " @click="SendFormLegales()" >Guardar cambios</button>
                </div>

                <div class="col-12 " id="alertasAD">

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
  name: 'datosLegales',
  mixins: [API, Functions],
  components: {

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
      Getlogo: localStorage.getItem('imgLogo'),
      optionTab: 1

    }
  },
  async created () {
    console.debug('CREATED_INICIO')
    await this.getInfoMiPerfil()

    console.debug('CREATED_FIN')

    this.catStatusLegal()
    this.catPeople()
    this.zonaHoraria()
  },
  async mounted () {
    // [ Responsive-table ] start

    this.editarCampos(false)

    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })
    this.changeStatusLegal()

    await EventBus.$emit('NAVBAR_MenuSimple', this.$store.state.seccionMenu)

    this.$store.state.submenuActive = 'config'
    this.$store.state.itemSubmenuActive = 'itemPerfil'
    await EventBus.$emit('NAVBAR_MenuOpciones', 'config', 'itemPerfil')

    this.title = ' Mi cuenta'

    this.suscribeToDeviceEvents()
    // $('input[id=imgLogo]').change(function () {
    //   console.debug('CHANGE_INPUT')

    // })

    // this.$refs.table.Render(this.headers, this.rows)
    // this.Refresh()

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

    editarCampos (disabled) {
      console.debug('editarCampos', disabled)
      this.setDisabled = disabled
      if (disabled == true) {
        $('#selectStatusLegal').removeAttr('disabled')
        $('#nombreLegal').removeAttr('disabled')
        $('#rfc').removeAttr('disabled')
        $('#pais').removeAttr('disabled')
        $('#region').removeAttr('disabled')
        $('#cp').removeAttr('disabled')
        // $('#zonaH').removeAttr('disabled')
        $('#addres').removeAttr('disabled')
        $('#notes').removeAttr('disabled')
      }
      if (disabled == false) {
        $('#selectStatusLegal').attr('disabled', 'disabled')
        $('#nombreLegal').attr('disabled', 'disabled')
        $('#rfc').attr('disabled', 'disabled')
        $('#pais').attr('disabled', 'disabled')
        $('#region').attr('disabled', 'disabled')
        $('#cp').attr('disabled', 'disabled')
        $('#zonaH').attr('disabled', 'disabled')
        $('#addres').attr('disabled', 'disabled')
        $('#notes').attr('disabled', 'disabled')
      }
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
    },
    /**
   * @vuese
   * Se destruye la suscripcion al eventBus
   */
    unsuscribreToDeviceEvents () {
      EventBus.$off('GET_list_contactos')
    },

    /**
   * @vuese
   * Obtiene la informacion del mi perfil
   */
    async getInfoMiPerfil () {
      console.debug('GET_INFO_TABLE_INICIO')
      this.$store.state.loader = true
      this.contactosFine = []
      this.contactos = []
      var response = await this.getRequest(`configuration/account`)
      console.debug('GET_INFO_PERFIL', response)
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
      this.idCliente = clientAllInfo.id

      var contactosbd = clientAllInfo.contacts
      console.debug('CONTACTOS', contactosbd)
      contactosbd.forEach(element => {
        console.debug('PHONE_CELL', element.phone, element.cel)
        if (element.phone == '' || element.phone == null) {
          console.debug('VACIO_PHONE')
          element.phone = null
        }
        if (element.cel == '' - element.cel == null) {
          console.debug('VACIO_CEL')
          element.cel = null
        }
        this.contactos.push({ 'id': element.id,
          'idC': element.id,
          'name': element.name,
          'phone': element.phone,
          'cel': element.cel,
          'email': element.email,
          'tipo': element.contactType,
          'notes': element.notes
        })

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
      })
      this.$store.state.loader = false
      console.debug('GET_INFO_TABLE_FIN')

      this.resultado = true
      await EventBus.$emit('legales_getCuenta', this.cuenta)
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
   * Envia datos y registra un distribuidor o un cliente segun sea el caso
   */
    async SendFormLegales () {
      this.$store.state.loader = true
      var typeUser = 0
      var tipo = ''

      // if (this.contactosFine.length == 0) {
      //   $('#alertasAD').html(`<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Debes agregar al menos un contacto<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>`)
      //   setTimeout(() => {
      //     $('#alertasAD').html('')
      //   }, 5000)
      //   return false
      // }

      // edita mi perfil
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
            // this.cancel()
          }, 3000)
        } else {
          this.$store.state.loader = false
          $('#alertasAD').html(`<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se han actulizado tus datos<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>`)
          setTimeout(() => {
            $('#alertasAD').html('')
          }, 5000)
        }
      } else {
        $('#alertasAD').html(`<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Por favor, ingresa todos los campos<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>`)
        setTimeout(() => {
          $('#alertasAD').html('')
        }, 5000)
      }

      this.$store.state.loader = false
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
