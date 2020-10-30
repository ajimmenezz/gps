<?php

include("saveLogo.php")
?>

<template>
    <div class="row m-r-5" style="margin-top:10px;">

        <div class="col-12">

            <div class="row">
              <div class="col-12">
                <h5 class="float-left" style="font-size: 20px; padding-bottom: 10px;" >Mi cuenta</h5>

              </div>
              <div class="col-6">  <p  class="text-muted" style="text-align: justify; font-size: 12px; margin-top: -18px;">
                  A continuación podrás consultar y modificar tus datos personales asi como de contacto</p>
              </div>
              <div class="col-6 float-right" style=" font-size: 12px; margin-top: -18px;">Nombre de la cuenta: <b >{{cuenta}}</b>
              </div>
             <hr style="margin-top: -10px; margin-bottom:20px; width:100%;">
            </div>
        </div>

        <div class="col-12">

                   <!-- <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a  style=" box-shadow: none;" class="nav-link active text-uppercase" id="legales-tab" data-toggle="tab" href="#legales" role="tab" aria-controls="legales" aria-selected="true">Datos legales</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase" id="contactos-tab" data-toggle="tab" href="#contactos" role="tab" aria-controls="contactos" aria-selected="false">Contactos</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase" id="logotipo-tab" data-toggle="tab" href="#logotipo" role="tab" aria-controls="logotipo" aria-selected="false">Logotipo</a>
                                        </li>
                                    </ul> -->

                                       <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active text-uppercase" id="legales-tab" data-toggle="tab" href="#legales" role="tab" aria-controls="legales" aria-selected="true">Datos legales</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase" id="contactos-tab" data-toggle="tab" href="#contactos" role="tab" aria-controls="contactos" aria-selected="false">Contactos</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase" id="logotipo-ta" data-toggle="tab" href="#logotipo" role="tab" aria-controls="logotipo" aria-selected="false">Logotipo</a>
                                        </li>
                                    </ul>

                <div class="float-left tab-content " id="myTabContent" style=" box-shadow: none; width: 100%;">
                    <!-- <form @submit.prevent > -->
                          <div class=" tab-pane fade show active " id="legales"   role="tabpanel" aria-labelledby="legales-tab">
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

                          <div class=" tab-pane fade" id="contactos"  role="tabpanel" aria-labelledby="contactos-tab">

                                  <div class="row">

                                <div class="table-responsive " v-if="getShowTable && !isEmptyContacts">
                                  <table id="zero-configuration" class="display table nowrap table-striped table-hover" style="width:100%">
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

                                        <tr v-for="(element, index) in getContactos" :key="index">
                                          <td>{{index+1}}</td>
                                          <td >{{element.name}}</td>
                                          <td>{{element.tipo}}</td>
                                          <td v-if="element.phone!=null">{{element.phone}}</td>
                                          <td v-else>-</td>
                                          <td v-if="element.cel!=null">{{element.cel}}</td>
                                          <td v-else>-</td>
                                          <td>{{element.email}}</td>
                                          <td id="btnEliminar" class="classdisabled float-left">
                                              <span class="btnEditar" @click="editarcontac(element.id)"><i class="cursor icon-small icon universalicon-pencil "></i></span>
                                            <span class="btnEliminar" @click="eliminarcontac(element.id)"><i class="cursor icon-small icon universalicon-trash-2 "></i></span>
                                          </td>

                                        </tr>

                                      </tbody>
                                      <!-- <tfoot>
                                          <tr>
                                                <th>#</th>
                                              <th>Fecha inicial</th>
                                              <th>Fecha final</th>
                                              <th>Kilometros recorridos</th>
                                              <th>Velocidad promedio</th>
                                              <th>Tiempo total</th>
                                          </tr>
                                      </tfoot> -->
                                  </table>
                                </div>

                                            <div class="col-12" v-if="isEmptyContacts ">Sin contactos</div>

                                            <div class="col-12" id="alertasAD" style="margin-top: 40px;"></div>

                                            <div class="col-12 " style="margin-top: 15px;">
                                                <button id="agregarContac" class="btn btn-primary shadow-2 mb-4 float-right" @click="modalContactCreate()" type="submit" >Agregar contacto</button>
                                            </div>

                                    </div>

                          </div>

                          <div class="  tab-pane fade" style="margin-top:50px; " id="logotipo"  role="tabpanel" aria-labelledby="logotipo-tab" >
                              <div class="row justify-content-center" style="text-align: justify;">

                                <div class="col-12 col-md-4  " style="margin-top:10px; text-align: center; margin-bottom:10px;">

                                  <div class="card" style="width:200px; text-align: center;  ">
                                      <div class="card-block p-0" style="margin-bottom:10px;">
                                          <img class="img-fluid" style="width:90%; margin-left:12px;"   :src="`${logoGet}isotipo.png`" alt="dashboard-user">
                                          <div class="ux-designer" style="padding:0px;">

                                          <!-- <form id="fichero1" name="fichero1" method="post" enctype="multipart/form-data"  action="<%= BASE_URL %>saveLogo.php" > -->
                                            <span class="btn btn-primary btn-file" style="position: absolute; margin-right: -45px;" @click="upload()">
                                                 <i class=" iconMenu icon-md universalicon-camera cursor f-14 mr-0 m-t-3" style="position: absolute; padding-top: 12px;  margin-left: -18px;">
                                                    <!-- <input type="file" id="imgLogo" name="imgLogo" @change="subirLogo()"> -->
                                                    <input :id="idInp+'--inputfile'" @change="onSelectedFiles" ref="file" type="file" name="files" style="display: none">
                                                    </i>

                                              </span>
                                                <input type="hidden" id="idClienteID" name="idClienteID" :value="this.idCliente">
                                            <!-- </form> -->
                                                <!-- <button type="submit" class="btn btn-primary" style="margin-right: -30px; margin-top: -5px;">
                                                    <i class=" iconMenu icon-md universalicon-camera cursor f-14 mr-0 m-t-3"></i>
                                                </button> -->

                                          </div>
                                      </div>
                                  </div>
                                </div>

                                <div class="col-12 col-md-4 float-left" style="text-align: justify;">
                                    <b >¿Quieres cambiar tú logotipo?</b> haz click en el icono junto a la imagen para seleccionar un nuevo logotipo. <br>El formato permitido únicamente será: PNG
                                    <br>Este es tu logotipo visible en GPS INFINITY. Para visualizar el logotipo en la plataforma has click en la URL junto al logotipo
                                    <br>
                                </div>

                                <div class="col-8" style="margin-top:30px; text-align: justify;">
                                Para visualizar tu logotipo en la pantalla de registro te pedimos que sigas estos sencillos pasos: <br><br><br>

                                <b>Copia la URL</b> que se muestra en la parte de abajo marcado de azul. <br>
                                <b>Pega la URL</b> en tu navegador favorito y da enter para abrir la ventana. <br><br>

                                </div>
                                <div class="col-7" style="text-align: center;">
                                   <a :href="`https://gpsinfinity.mx/#/platform/${cuenta}`">https://gpsinfinity.mx/#/platform/{{cuenta}}</a>
                                </div>

                              </div>

                          </div>

                    <!-- </form> -->
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
    this.$store.state.loader = true
    console.debug('CREATED_INICIO')
    await this.getInfoMiPerfil()
    console.debug('CREATED_FIN')

    this.catStatusLegal()
    // this.catPeople()
    this.zonaHoraria()

    console.debug('TABLE_INICIO')
    var table = $('#zero-configuration').DataTable({
      'scrollY': '550px',
      // dom: 'Bfrtip',
      // buttons: [
      //   'copyHtml5',
      //   'excelHtml5',
      //   'csvHtml5',
      //   'pdfHtml5'
      // ],
      'language': {
        'sLengthMenu': 'Mostrar _MENU_ registros',
        'emptyTable': 'No se encontraron datos',
        'info': 'Mostrando del _START_ al _END_ de _TOTAL_ resultados',
        'infoEmpty': 'Mostrando 0 al 0 de 0 resultados',
        'loadingRecords': 'Obteniendo datos...',
        'processing': 'Procesando datos...',
        'search': 'Buscar:',
        'zeroRecords': 'No se encontraron datos',
        'paginate': {
          'first': 'Primero',
          'last': 'Último',
          'next': 'Siguiente',
          'previous': 'Anterior'
        }

      },
      scrollX: true,
      scrollCollapse: true,
      scrollXInner: '100%',
      fixedColumns: {
        leftColumns: 3,
        rightColumns: 1
      },
      fixedHeader: {
        header: true,
        footer: true
      }

    })

    table.columns.adjust()
    table.responsive.recalc()
    table.columns.adjust().draw()
    console.debug('TABLE_FIN')
  },
  async mounted () {
    // [ Responsive-table ] start

    this.editarCampos(false)

    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })
    this.changeStatusLegal()
    this.$store.state.loader = false
    await EventBus.$emit('NAVBAR_MenuSimple', this.$store.state.seccionMenu)

    this.$store.state.submenuActive = 'config'
    this.$store.state.itemSubmenuActive = 'itemPerfil'
    await EventBus.$emit('NAVBAR_MenuOpciones', 'config', 'itemPerfil')

    this.title = ' Mi cuenta'

    this.suscribeToDeviceEvents()
    // $('input[id=imgLogo]').change(function () {
    //   console.debug('CHANGE_INPUT')

    // })

    this.$store.state.loader = false
  },
  destroyed () {
    this.unsuscribreToDeviceEvents()
  },
  methods: {
    upload () {
      this.$refs.file.click()
    },
    async onSelectedFiles (sender) {
      var files = sender.target.files
      var filesArr = Array.prototype.slice.call(files)
      for (var i = 0; i < filesArr.length; i++) {
        this.files.push({
          file: filesArr[i],
          name: 'img_' + i
        })
      }

      await this.uploadFile()
    },
    async uploadFile () {
      var formData = new FormData()
      for (var i = 0; i < this.files.length; i++) {
        console.debug('File to add', this.files[i])
        if (this.files[i].file != null) {
          formData.append('files[]', this.files[i].file)
          formData.append('filenames[]', this.files[i].name)
          formData.append('idClienteID', this.idCliente)
        } else {
          console.debug('Null file')
        }
      }

      var datos = {
        formData: formData,
        idClienteID: this.idCliente
      }

      console.debug('post', formData, datos)

      var result = await this.postRequest(`configuration/uploadFile`, formData)

      if (result.success) {
        var datos = {
          'iduser': this.idCliente
        }
        console.debug('success_SAVELOGO', result, datos)
        var result = await this.postRequest('configuration/account/logo', datos)
        console.debug('RSULTADO_SAVELOGO', result, result.data)
        localStorage.setItem('StringName', result.data.cuenta) // credentials.user

        // var url = 'img/storage/Distribuidores/' + result.data.user + '/logotipo/'
        localStorage.setItem('imgLogo', result.data.url)
        console.debug('RSULTADO_SAVELOGO', result, result.data)
        notify('', 'Se ha subido el logo', 'top', 'right', 'success')
      } else {
        console.error('fail', result)
        notify('', 'No se ha subido el logo', 'top', 'right', 'danger')
      }
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
    async modalContactCreate () {
      this.$store.commit('CLEAR_MODAL_DINAMIC')
      this.$store.state.loader = true

      var datos = {
        'component': modalCreatedContact,
        'datos': {
          'seccion': 'contacto'

        }
      }

      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)

      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
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
      })
      this.$store.state.loader = false
      console.debug('GET_INFO_TABLE_FIN')
      this.resultado = true
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
   * Elimina contactos a la lista
   */
    async eliminarcontac (id) {
      this.$store.commit('CLEAR_MODAL_DINAMIC')
      this.$store.state.loader = true

      var datos = {
        'component': deleteContact,
        'datos': {
          'seccion': 'contacto',
          'id': id

        }
      }

      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)

      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
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
#zero-configuration_length{
   float: left;
    text-align: left;
}
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
