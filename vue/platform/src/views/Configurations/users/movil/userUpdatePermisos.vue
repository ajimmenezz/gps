<template>
        <div class="card-body float-left row">

                            <div class="col-12 "><h5 >Permisos</h5></div>
                              <div class="col-12">  <p class="text-muted" style="text-align: justify; font-size: 12px; margin-top: 7px;" >
                                A continuación podras agregar o quitar los permisos que tendrá el usuario en la plataforma asi como que dispositivos que podrá visulizar y monitorear.</p>

                              </div>

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

                          <div class="row" v-if="this.$store.state.clientType==1">
                            <div class="col-12 "><h5 >Dispositivos a visualizar</h5></div>
                              <div class="col-12">  <p class="text-muted" style="text-align: justify; font-size: 12px; margin-top: 7px;">
                                    A continuación podrás seleccionar que dispositivos podrá visualizar el usuario</p>
                              </div>

                                <div class="col-12">
                                          <button id="addAllDevice" type="button" class="btn btn-primary   m-b-10" style="padding: 4px 11px; font-size: 14px;"  @click="agregarTodos">Seleccionar todos</button>
                                          <button id="removeAllDevice" type="button" class="btn btn-primary   m-b-10" style="padding: 4px 11px; font-size: 14px;"  @click="quitarTodos">Deseleccionar todos</button>
                                </div>

                                <div class="col-12">

                                          <select id='custom-headers' class="searchable" multiple='multiple' >
                                              <option v-for="device in listDEviceC"  :key="device.id"  :value="device.id" :selected="device.selectOptions">{{device.alias}}</option>
                                          </select>
                                </div>

                          </div>

                          <div class="col-12" id="alertUser" style="margin-top: 40px; margin-bottom:15px;"></div>

                          <div  class="col-12  float-right">
                              <button v-if="!Getdisabled" id="editSubmit" type="submit" class="btn btn-primary" @click="editarCampos(true)" >Editar</button>
                              <button v-if="Getdisabled" class="btn btn-outline-primary " type="button" @click="editarCampos(false)">Cancelar</button>
                              <button v-if="Getdisabled" id="registerSubmit" type="submit" class="btn btn-primary " @click="editar()" >Guardar</button>
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
      notas: null,
      dynamicComponent: {
        component: null,
        properties: null,
        events: {

        }
      },
      visible: false,
      setDisabled: true

    }
  },
  async created () {
    this.accion = this.$route.params.accion
    this.userID = this.$route.params.id

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

    this.editarCampos(false)
    this.$store.state.loader = false
  },
  methods: {
    editarCampos (disabled) {
      console.debug('editarCampos', disabled)
      this.setDisabled = disabled
      if (disabled == true) {
        $('#permisos').removeAttr('disabled')
        $('#addAllDevice').removeAttr('disabled')
        $('#removeAllDevice').removeAttr('disabled')
        $('#custom-headers').removeAttr('disabled')

        $('#editSubmit').html('Guardar')
      }
      if (disabled == false) {
        $('#permisos').attr('disabled', 'disabled')
        $('#addAllDevice').attr('disabled', 'disabled')
        $('#removeAllDevice').attr('disabled', 'disabled')
        $('#custom-headers').attr('disabled', 'disabled')

        $('#editSubmit').html('Editar')
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
   * Actualiza la informacion del usuario que se haya modificado
   */
    async editar () {
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

        'permissions': permisos

      }

      var datos = {}
      // datosUsuario.devices = Object.values(this.dispositivosUser)
      datos['user'] = datosUsuario
      // datos['devices'] = Object.values(this.dispositivosUser)

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
          this.getUser(this.userID)
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
   * cancela el proceso y regresa a la tabla de usuarios
   */
    cancel () {
      this.$router.push('/listaUsers')
    }
  },
  computed: {
    Getdisabled () {
      return this.setDisabled
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
