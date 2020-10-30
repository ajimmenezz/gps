<template>
   <div class="card-body float-left row">

                          <div class="col-12">
                             <config-input  id="userName" label="Nombre *"  typeinput="text"  placeholder="Nombre" v-model.trim="userName" required="true" :valor="userName"> </config-input>
                          </div>
                          <div class="col-12">
                             <config-input  id="apaterno" label="Apellido paterno *"  typeinput="text"  placeholder="Apellido Paterno" v-model.trim="apaterno" required="true" :valor="apaterno"> </config-input>
                          </div>

                          <div class="col-12">
                             <config-input  id="amaterno" label="Apellido materno *"  typeinput="text"  placeholder="Apellido materno" v-model.trim="amaterno" required="true" :valor="amaterno"> </config-input>
                          </div>
                          <div class="col-12">
                             <config-input  id="user" label="Usuario *"  @input="onKeyUp" typeinput="text"  placeholder="Usuario" v-model.trim="user" required="true" :valor="user" toLowerUperCase="lowercase"> </config-input>
                          </div>
                          <!-- <div class="col-6">
                             <config-input  id="pass" label="Contraseña"  typeinput="password"  placeholder="Contraseña" v-model.trim="password" required="true"> </config-input>
                          </div> -->

                          <div class="col-12 ">
                              <config-input  id="notas" label="Notas"  typeinput="text"  placeholder="Notas" v-model.trim="notas" required="false" :valor="notas"></config-input>
                          </div>

                          <div class="col-12" id="alertUser" style="margin-top: 40px; margin-bottom:15px;"></div>

                          <div  class="col-12  float-right">
                            <button v-if="!Getdisabled" id="editSubmit" type="submit" class="btn btn-primary" @click="editarCampos(true)" >Editar</button>
                            <button v-if="Getdisabled" class="btn btn-outline-primary " type="button" @click="cancel()">Cancelar</button>
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
  name: 'FormularioEditLegalesUSer',
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
  },
  async mounted () {
    this.editarCampos(false)
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

    this.$store.state.loader = false
  },
  methods: {
    editarCampos (disabled) {
      console.debug('editarCampos', disabled)
      this.setDisabled = disabled
      if (disabled == true) {
        $('#userName').removeAttr('disabled')
        $('#apaterno').removeAttr('disabled')
        $('#amaterno').removeAttr('disabled')
        $('#user').removeAttr('disabled')
        $('#notas').removeAttr('disabled')
        $('#editSubmit').html('Guardar')
      }
      if (disabled == false) {
        $('#userName').attr('disabled', 'disabled')
        $('#apaterno').attr('disabled', 'disabled')
        $('#amaterno').attr('disabled', 'disabled')
        $('#user').attr('disabled', 'disabled')
        $('#notas').attr('disabled', 'disabled')

        $('#editSubmit').html('Editar')
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

      var tipoUser = 2

      var datosUsuario = {
        'userType': tipoUser,
        'notes': this.notas,
        'name': this.userName,
        'paternalSurname': this.apaterno,
        'maternalSurname': this.amaterno

      }

      var datos = {}
      // datosUsuario.devices = Object.values(this.dispositivosUser)
      datos['user'] = datosUsuario
      // datos['devices'] = Object.values(this.dispositivosUser)

      if (this.user !== this.userData.username) {
        datos.user.username = this.user
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
    Getdisabled () {
      return this.setDisabled
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
