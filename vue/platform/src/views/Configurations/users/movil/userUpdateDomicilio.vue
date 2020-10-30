<template>
         <div class="card-body float-left row">

                            <div class="col-12">
                             <config-input  id="email" label="Correo electrónico *"  typeinput="email"  placeholder="Correo electrónico" v-model.trim="email" required="true" :valor="email" toLowerUperCase="lowercase"> </config-input>
                            </div>
                            <div class="col-12">
                              <config-input  id="telefono" label="Teléfono"  typeinput="number"  placeholder="Teléfono" v-model.trim="telefono" required="true" :valor="telefono"> </config-input>
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
  name: 'FormularioUsersDimicilioEdit',
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

    this.zonaHoraria()
  },
  async mounted () {
    this.$store.state.submenuActive = 'config'
    this.$store.state.itemSubmenuActive = 'itemUser'
    await EventBus.$emit('NAVBAR_MenuOpciones', 'config', 'itemUser')

    await this.getUser(this.userID)
    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })

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
        $('#email').removeAttr('disabled')
        $('#telefono').removeAttr('disabled')
        $('#direc').removeAttr('disabled')
        $('#zonaH').removeAttr('disabled')

        $('#editSubmit').html('Guardar')
      }
      if (disabled == false) {
        $('#email').attr('disabled', 'disabled')
        $('#telefono').attr('disabled', 'disabled')
        $('#direc').attr('disabled', 'disabled')
        $('#zonaH').attr('disabled', 'disabled')

        $('#editSubmit').html('Editar')
      }
    },

    /**
   * @vuese
   * Actualiza la informacion del usuario que se haya modificado
   */
    async editar () {
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

      var tipoUser = 2

      var datosUsuario = {
        'userType': tipoUser,
        'timezone': this.zonaH,

        'phone': this.telefono,
        'address': this.direc

      }

      var datos = {}
      // datosUsuario.devices = Object.values(this.dispositivosUser)
      datos['user'] = datosUsuario
      // datos['devices'] = Object.values(this.dispositivosUser)

      validateEmail = false
      if (this.email !== this.userData.email) {
        datos.user.email = this.email.toLowerCase(this.email)
      } else {
        validateEmail = true
      }

      var request = await this.putRequest('users/' + this.userID, datos)

      if (request.success === true) {
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
   * Obtiene listado de zonas horarias
   */
    listZonasHor () {
      return this.listZonaHoraria
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
