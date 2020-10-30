<template>
  <div class=" row m-r-5">
      <div class="col-12 float-left"> <h4 class="float-left" style="font-size: 20px; padding-bottom: 10px;"><b>Crear /</b> usuario</h4>
      </div>
      <div class="col-12 float-left" style="margin-top: -18px;">

      <h6>A continuación podras registrar los datos personales del usuario y agregar permisos.</h6>
      <hr>
      </div>

      <div class=" col-12">

        <div class="card">

            <div class="card-body float-left">

              <div id="smartwizard" >
                  <ul>
                      <li > <!-- class="active" -->
                        <a href="#step-1">
                            <h6>Paso 1</h6>
                            <p class="m-0">Datos legales</p>
                        </a>
                      </li>
                      <li > <!-- class="done" -->
                        <a href="#step-2">
                            <h6>Paso 2</h6>
                            <p class="m-0">Datos de domicilio</p>
                        </a>
                      </li>
                        <li @click="showContent(3)"> <!-- class="done" -->
                        <a href="#step-3">
                            <h6>Paso 3</h6>
                            <p class="m-0">Permisos</p>
                        </a>
                      </li>

                  </ul>

                  <div>

                      <div id="step-1" class="mpConf" >
                        <div class="row">

                          <div class="col-12">
                             <config-input  id="name" label="Nombre *"  typeinput="text"  placeholder="Nombre" v-model.trim="userName" required="true" :valor="userName"> </config-input>
                          </div>
                          <div class="col-12">
                             <config-input  id="name1" label="Apellido paterno *"  typeinput="text"  placeholder="Apellido Paterno" v-model.trim="apaterno" required="true" :valor="apaterno"> </config-input>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                             <config-input  id="ap2" label="Apellido materno *"  typeinput="text"  placeholder="Apellido materno" v-model.trim="amaterno" required="true" :valor="amaterno"> </config-input>
                          </div>
                          <div class="col-12">
                             <config-input  id="user_minus" label="Usuario *"  @input="onKeyUp" typeinput="text"  placeholder="Usuario" v-model.trim="user" required="true" :valor="user" toLowerUperCase="lowercase"> </config-input>
                          </div>
                          <!-- <div class="col-6">
                             <config-input  id="pass" label="Contraseña"  typeinput="password"  placeholder="Contraseña" v-model.trim="password" required="true"> </config-input>
                          </div> -->
                        </div>

                        <div class="row">

                            <div class="col-12">
                                <config-input  id="notes" label="Notas"  typeinput="text"  placeholder="Notas" v-model.trim="notas" required="false" :valor="notas"></config-input>
                            </div>
                        </div>
                      </div>

                      <div id="step-2">
                        <div class="row">
                            <div class="col-12">
                             <config-input  id="email" label="Correo electrónico *"  typeinput="email"  placeholder="Correo electrónico" v-model.trim="email" required="true" :valor="email" toLowerUperCase="lowercase"> </config-input>
                            </div>
                            <div class="col-12">
                              <config-input  id="tel" label="Teléfono"  typeinput="number"  placeholder="Teléfono" v-model.trim="telefono" required="true" :valor="telefono"> </config-input>
                            </div>
                            <div class="col-12">
                              <config-input  id="direc" label="Dirección"  typeinput="text"  placeholder="Dirección" v-model.trim="direc" required="true" :valor="direc"> </config-input>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="zonaH">Zona horaria *</label>
                                    <select class="form-control" id="zonaH" v-model="zonaH" :valor="zonaH">
                                        <option value="0">Selecciona</option>
                                        <option v-for="zona in listZonasHor" :value="zona.id" :key="zona.id">{{zona.name}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                      </div>

                      <div id="step-3" class="mpConf">

                          <div class="row">
                            <div class="col-12 "><h5 >Permisos</h5></div>
                              <div class="col-12">  <p class="text-muted" style="text-align: justify; font-size: 12px; margin-top: 7px;" >
                                A continuación podras agregar o quitar los permisos que tendrá el usuario en la plataforma asi como que dispositivos que podrá visulizar y monitorear.</p>

                              </div>
                                    <hr>

                              <div class="col-12">

                                  <config-text-typography  texto="Asignar permisos:"></config-text-typography>
                                    <select id="permisos" class="js-example-basic-multiple col-sm-12" multiple="multiple">

                                        <option v-for="per in listPermissions" :value="per.id" :key="per.id">{{per.name}}</option>
                                    </select>

                                  <div v-if="this.$store.state.clientType == 1" style="margin-top:20px; text-align: justify; font-size: 12px; " class="text-muted">

                                  <b>Nota: </b>Los usuarios  tendran por default asignados los permiso de: <br>

                                  <span class="badge badge-secondary" style="font-size: 11px !important;">SECCION LOCALIZACIÓN</span>&nbsp;
                                  <span class="badge badge-secondary" style="font-size: 11px !important; margin-bottom:10px;">GESTION DE GEOCERCAS Y PI</span>
                              </div>

                            </div>
                          </div>
                          <hr>

                          <div class="row" v-if="this.$store.state.clientType==1">
                            <div class="col-12 "><h5 >Dispositivos a visualizar</h5></div>
                              <div class="col-12">  <p class="text-muted" style="text-align: justify; font-size: 12px; margin-top: 7px;">
                                    A continuación podrás seleccionar que dispositivos podrá visualizar el usuario</p>
                              </div>

                                <div class="col-12">
                                          <button type="button" class="btn btn-primary   m-b-10" style="padding: 4px 11px; font-size: 14px;"  @click="agregarTodos">Seleccionar todos</button>
                                                      <button type="button" class="btn btn-primary   m-b-10" style="padding: 4px 11px; font-size: 14px;"  @click="quitarTodos">Deseleccionar todos</button>
                                </div>

                                <div class="col-12">

                                          <select id='custom-headers' class="searchable" multiple='multiple' >
                                              <option v-for="device in listDEviceC"  :key="device.id"  :value="device.id" :selected="device.selectOptions">{{device.alias}}</option>
                                          </select>
                                </div>

                          </div>

                          <div class="row" style=" margin-top: 20px;">
                            <div class="col-12" id="alertUser"></div>
                          </div>

                      </div>

                  </div>

              </div>

              <div class="row">
                      <div class="col-12" id="alertUser" style="margin-top: 40px; margin-bottom:15px;"></div>
              </div>

              <div id="btnCancelWizar" class="row" style="margin-top: -110px;">
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
import EventBus from '@/EventBus.js'
/**
 * @group Usuarios
 * formulario para crear, editar y consultar usuarios
 */
export default {
  name: 'FormularioUsersM',
  mixins: [API],
  data () {
    return {
      userName: '',
      user: '',
      password: '',
      email: '',
      telefono: 0,
      direc: '',
      tipoUser: 0,
      apaterno: '',
      amaterno: '',
      dispositivosUser: [],
      dispositivos_list: [],
      accion: '',
      userID: '',
      userData: [],
      permisos: [],
      listZonaHoraria: [],
      zonaH: 14,
      getDevicesUser: [],
      showDevice: false,
      deviceesUs: [],
      listPermissions: [],
      notas: null

    }
  },
  async created () {
    this.accion = this.$route.params.accion
    this.userID = this.$route.params.id

    this.zonaHoraria()
    this.catPermissions()
  },
  async mounted () {
    this.$store.state.submenuActive = 'config'
    this.$store.state.itemSubmenuActive = 'itemUser'
    await EventBus.$emit('NAVBAR_MenuOpciones', 'config', 'itemUser')

    await this.getDevices()
    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })

    // [ Searchable ] start
    await $('.searchable').multiSelect({
      selectableHeader: "<input type='text' class='form-control' autocomplete='off' placeholder='Disponibles'>",
      selectionHeader: "<input type='text' class='form-control' autocomplete='off' placeholder='Asignados'>",
      afterInit: function (ms) {
        var that = this
        var $selectableSearch = that.$selectableUl.prev()
        var $selectionSearch = that.$selectionUl.prev()
        var selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)'
        var selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected'

        that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
          .on('keydown', function (e) {
            if (e.which === 40) {
              that.$selectableUl.focus()
              return false
            }
          })

        that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
          .on('keydown', function (e) {
            if (e.which == 40) {
              that.$selectionUl.focus()
              return false
            }
          })
      },
      afterSelect: async function (value) {
        // this.qs1.cache()
        // this.qs2.cache()
        var id = parseInt(value)
        var disp = this.dispositivosUser.find(x => x == id)
        console.debug('DISP', disp)
        if (disp == undefined) {
          this.dispositivosUser.push(id)
        }
      }.bind(this),
      afterDeselect: async function (value) {
        // this.qs1.cache()
        // this.qs2.cache()
        var id = parseInt(value)

        var search
        this.dispositivosUser.filter(function (dato, i) {
          if (dato == value) {
            search = i
            return true
          }
        })

        this.dispositivosUser.splice(search, 1)
      }.bind(this)

    })

    // await $('#smartwizard').smartWizard('theme', 'dots')
    $('#smartwizard').smartWizard({
      theme: 'dots',
      transitionEffect: 'fade',
      autoAdjustHeight: false,
      useURLhash: false,
      showStepURLhash: false,
      enableURLhash: true,
      justified: true, // Nav menu justification. true/false

      lang: { // Language variables for button
        next: 'Siguiente',
        previous: 'Anterior'
      }
    })

    $('.sw-btn-prev').removeClass('btn-secondary')
    $('.sw-btn-prev').addClass('btn-outline-primary')

    $('.sw-btn-next').removeClass('btn-secondary')
    $('.sw-btn-next').addClass('btn-primary')

    $('#smartwizard').on('showStep', function (e, anchorObject, stepIndex, stepDirection, stepPosition) {
      console.debug('Estás en el paso' + stepIndex + 'ahora')
      this.showContent(stepIndex)
    }.bind(this))

    $('#smartwizard').on('click', '.ClickGuardar', function (e) {
      this.register()
    }.bind(this))

    $('#smartwizard .sw-toolbar').appendTo($('#smartwizard .sw-container'))
    // btn-toolbar sw-toolbar sw-toolbar-bottom justify-content-end
    // $('.sw-btn-prev').css({ 'display': 'none' })
    // $('.sw-btn-next').css({ 'display': 'none' })
    // $('#smartwizard').addClass('sw-main sw-theme-dots')

    // [ Multi Select ] start
    $('.js-example-basic-multiple').select2({
      placeholder: 'Selecciona permisos',
      tags: true,
      tokenSeparators: [',', ' ']
    })

    this.$store.state.loader = false

    $('.sw-btn-next').click(function () {
      window.scrollTo(0, 0)
    })
    $('.sw-btn-prev').click(function () {
      window.scrollTo(0, 0)
    })
  },
  methods: {
    showContent (opc) {
      var opc1 = parseInt(opc)
      console.debug('SHOWCONECT', opc1)
      switch (opc1) {
        case 2:
          console.debug('PASO2')

          setTimeout(() => {
            $('.sw-btn-next').html('Confirmar')
            $('.sw-btn-next').addClass('ClickGuardar')
            $('.sw-btn-next').removeClass('disabled')
          }, 1500)

          break
        default:
          $('.sw-btn-next').html('Siguiente')
          $('.sw-btn-next').removeClass('ClickGuardar')
          $('.sw-btn-next').removeClass('disabled')

          break
      }
    },
    agregarTodos () {
      console.debug('ENTRA TODOS')
      this.dispositivos_list.forEach(element => {
        var disp = this.dispositivosUser.find(x => x == element.id)
        console.debug('DISP', disp)
        if (disp == undefined) {
          this.dispositivosUser.push(element.id)
        }
      })
      $('.searchable').multiSelect('select_all')
      return false
    },
    quitarTodos () {
      console.debug('quitar TODOS')
      $('.searchable').multiSelect('deselect_all')

      this.dispositivosUser = []

      return false
    },
    /**
   * @vuese
   * Obtiene el listado de dispositivos
   */
    async getDevices () {
      var dispositivos = Object.values(this.$store.state.devices.devices)

      this.dispositivos_list = []
      dispositivos.forEach(element => {
        this.dispositivos_list.push({ 'id': parseInt(element.id), 'alias': element.alias, 'selectOptions': false })
      })

      if (this.accion === 'editar') {
        await this.getUser(this.userID)
      } else {
        this.showDevice = true
      }
    },
    /**
   * @vuese
   * Obtiene catalogo de permisos
   */
    async catPermissions () {
      var request = await this.getRequest('permissions')

      if (request.success === true) {
        var data = request.data.permissions

        if (this.$store.state.clientType == 1) {
          data.forEach(element => {
            if (element.id != 1 && element.id != 16) {
              this.listPermissions.push({ id: element.id, code: element.code, name: element.name })
            }
          })
        } else {
          this.listPermissions = data
        }
      }
    },
    /**
   * @vuese
   * Registra al usuario junto con todos sus datos
   */
    async register () {
      if (this.user == '') {
        $('#alertUser').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Ingresa usuario<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
        setTimeout(() => {
          $('#alertUser').html('')
        }, 3000)
        return false
      }

      if (this.email != '') {
        var validateEmail = this.validar_email(this.email)
        if (!validateEmail) {
          $('#alertUser').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>El correo electrónico no es valido<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
          setTimeout(() => {
            $('#alertUser').html('')
          }, 3000)
          return false
        }
      } else {
        $('#alertUser').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Ingresa correo electrónico<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
        setTimeout(() => {
          $('#alertUser').html('')
        }, 3000)
        return false
      }

      if (this.zonaH == 0) {
        $('#alertUser').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Selecciona zona horaria<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
        setTimeout(() => {
          $('#alertUser').html('')
        }, 3000)
        return false
      }

      if (this.userName != null && this.userName != '' && this.apaterno != null && this.apaterno != '' && this.amaterno != null && this.amaterno != '') {
        var tipoUser = 2

        var per = $('#permisos').val()

        var permisos = []
        if (this.$store.state.clientType == 1) {
          permisos.push(1)
          permisos.push(16)
        }
        per.forEach(element => {
          element = parseInt(element)

          permisos.push(element)
        })

        var datosUsuario = {
          'userType': tipoUser,
          'timezone': this.zonaH,
          'username': this.user.toLowerCase(this.user),
          'email': this.email.toLowerCase(this.email),
          'notes': this.notas,
          'name': this.userName,
          'paternalSurname': this.apaterno,
          'maternalSurname': this.amaterno,
          'phone': this.telefono,
          'permissions': permisos,
          'address': this.direc

        }

        var datos = {}
        // datosUsuario.devices = Object.values(this.dispositivosUser)
        datos['user'] = datosUsuario

        datos['devices'] = []
        if (this.$store.state.clientType == 1) {
          datos.clientID = 0
          datos.userType = this.tipoUser
          datos['devices'] = Object.values(this.dispositivosUser)
        }

        var request = await this.postRequest('users', datos)

        if (request.success === true) {
          $('#alertUser').html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha creado el usuario<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
          setTimeout(() => {
            $('#alertUser').html('')
            this.cancel()
          }, 3000)
        } else {
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
              message = 'No se ha creado el usuario'
              break
          }

          $('#alertUser').html(`<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>${message}<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>`)
          setTimeout(() => {
            $('#alertUser').html('')
          }, 3000)
        }
      } else {
        $('#alertUser').html(`<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Por favor, acompleta todos los campos marcados con (*) <button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>`)
        setTimeout(() => {
          $('#alertUser').html('')
        }, 5000)
      }
    },
    /**
   * @vuese
   * Actualiza la informacion del usuario que se haya modificado
   */
    async editar () {
      if (this.user == '') {
        $('#alertUser').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Ingresa usuario<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
        setTimeout(() => {
          $('#alertUser').html('')
        }, 3000)
        return false
      }

      if (this.email != '') {
        var validateEmail = this.validar_email(this.email)
        if (!validateEmail) {
          $('#alertUser').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>El correo electrónico no es valido<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
          setTimeout(() => {
            $('#alertUser').html('')
          }, 3000)
          return false
        }
      } else {
        $('#alertUser').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Ingresa correo electrónico<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
        setTimeout(() => {
          $('#alertUser').html('')
        }, 3000)
        return false
      }

      if (this.zonaH == 0) {
        $('#alertUser').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Selecciona zona horaria<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
        setTimeout(() => {
          $('#alertUser').html('')
        }, 3000)
        return false
      }

      var per = $('#permisos').val()

      var permisos = []
      if (this.$store.state.clientType == 1) {
        permisos.push(1)
        permisos.push(16)
      }
      per.forEach(element => {
        element = parseInt(element)

        permisos.push(element)
      })

      var tipoUser = 2

      var datosUsuario = {
        'userType': tipoUser,
        'timezone': this.zonaH,
        'notes': this.notas,
        'name': this.userName,
        'paternalSurname': this.apaterno,
        'maternalSurname': this.amaterno,
        'phone': this.telefono,
        'permissions': permisos,
        'address': this.direc

      }

      var datos = {}
      // datosUsuario.devices = Object.values(this.dispositivosUser)
      datos['user'] = datosUsuario
      // datos['devices'] = Object.values(this.dispositivosUser)

      if (this.user !== this.userData.username) {
        datos.user.username = this.user
      }

      validateEmail = false
      if (this.email !== this.userData.email) {
        datos.user.email = this.email.toLowerCase(this.email)
      } else {
        validateEmail = true
      }

      var request = await this.putRequest('users/' + this.userID, datos)

      if (request.success === true) {
        // eliminar dispositivos

        var responseDevices = false
        var responseDevicesAdd = false
        var devicees = this.deviceesUs
        devicees.forEach(async disp => {
          var request = await this.deleteRequest('users/' + this.userID + '/devices/' + disp.id)

          if (request.success === true) {
            responseDevices = true
          } else {
            responseDevices = false
          }
        })

        // agregar dispositivos
        var datdevice = {}
        datdevice['devices'] = Object.values(this.dispositivosUser)
        var request2 = await this.postRequest('users/' + this.userID + '/devices', datdevice)

        if (request2.success === true) {
          responseDevicesAdd = true
        } else {
          responseDevicesAdd = false
        }

        $('#alertUser').html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha actualizado el usuario<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
        setTimeout(() => {
          $('#alertUser').html('')
          this.cancel()
        }, 3000)
      } else {
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
            message = 'No se ha actualizado el usuario'
            break
        }

        $('#alertUser').html(`<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>${message}<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>`)
      }
    },
    /**
   * @vuese
   * verifica que el correo sea valido
   * @arg `email` Correo electronico del usuario
   */
    validar_email (email) {
      var emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i

      if (emailRegex.test(email)) {
        return true
      } else {
        return false
      }
    },
    /**
   * @vuese
   * Obtiene la informacion del usuario a consultar
   * @arg `userID` Id de usuario
   */
    async getUser (userID) {
      var request = await this.getRequest('users/' + userID)

      if (request.success === true) {
        this.userData = request.data.user

        this.userName = this.userData.name
        this.user = this.userData.username
        this.email = this.userData.email
        this.telefono = this.userData.phone
        this.direc = this.userData.address
        this.tipoUser = this.userData.userType
        this.apaterno = this.userData.paternalSurname
        this.amaterno = this.userData.maternalSurname
        this.zonaH = this.userData.timezoneID
        this.notas = this.userData.notes

        this.permisos = this.userData.permissions
        var listPermisos = []

        this.permisos.forEach(element => {
          var id = element.id// parseInt(element.id)

          listPermisos.push(id)
        })

        this.permisos = Object.values(listPermisos)

        $('#permisos').val(this.permisos)

        this.getDevicesUser = []

        this.dispositivosUser = []

        var disp = request.data.devices
        this.deviceesUs = request.data.devices
        // var device_list = this.dispositivos_list

        disp.forEach(element => {
          var search
          this.dispositivos_list.filter(function (dato, i) {
            if (dato.id == element.id) {
              search = i
              return true
            }
          })

          this.dispositivos_list.splice(search, 1)
        })

        disp.forEach(element => {
          this.dispositivos_list.push({ 'id': parseInt(element.id), 'alias': element.alias, 'selectOptions': true })
          this.dispositivosUser.push(parseInt(element.id))
        })
      }

      this.showDevice = true
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
   * convierte el valor del campo usuario todo a minusculas
   * @arg `e` cadena del campo usuario
   */
    onKeyUp: function (e) {
      var cadena = e.toLowerCase()
      this.user = cadena
    },
    /**
   * @vuese
   * cancela el proceso y regresa a la tabla de usuarios
   */
    cancel () {
      this.$router.push('/listaUsers')
    }
  },
  computed: {
    /**
   * @vuese
   * Obtiene listado de zonas horarias
   */
    listZonasHor () {
      return this.listZonaHoraria
    },
    /**
   * @vuese
   * Obtiene listado de dispositivos
   */
    listDEviceC () {
      return this.dispositivos_list
    },
    /**
   * @vuese
   * Obtiene tipo de usuario
   */
    getTypeUser () {
      this.$store.state.userType
      this.$store.state.clientType
      return this.dispositivos_list
    }

  }
}
</script>

<style>
.mpConf{
  margin: 10px;
  padding-top: 10px;
}

.minusculas{
	text-transform:lowercase;
}

.mayusculas{
	text-transform:uppercase;
}
</style>
