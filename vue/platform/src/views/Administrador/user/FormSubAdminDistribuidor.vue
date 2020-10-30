<template>
    <div class="row" >
        <div class="col-12"> <h5 class="float-left" style="font-size: 20px; padding-bottom: 10px;"><b>{{this.title}}</b></h5></div>
        <div class="col-12">
            <div class="card">
                <div class="card-header row">
                <div class="col-6">
                <h5 class=" float-left" >Nuevo</h5>
                </div>

                </div>
                <div class="card-body float-left">
                    <form @submit.prevent >
                        <div class="row">

                            <div class="col-12 col-md-4">
                                <config-input  id="user" label="Usuario"  typeinput="text"  placeholder="Usuario" v-model.trim="user" required="true" :valor="user"></config-input>
                            </div>
                            <div class="col-12 col-md-4">
                                <config-input  id="email" label="Correo electrónico"  typeinput="email"  placeholder="Correo electrónico" v-model.trim="email" required="true" :valor="email"></config-input>
                            </div>
                            <div class="col-12 col-md-4">
                                 <div class="form-group">
                                    <label for="zonaH">Zona horaria</label>
                                    <select class="form-control" id="zonaH" v-model="zonaH" :valor="zonaH" required>
                                        <option value="">Selecciona</option>
                                        <option v-for="zona in listZonaHoraria" :value="zona.id" :key="zona.id">{{zona.name}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <config-input  id="notes" label="Notas"  typeinput="text"  placeholder="Notas" v-model.trim="notas" required="false" :valor="notas"></config-input>
                            </div>

                            <div class="col-12">
                                <h5 class="float-left">Permisos</h5>
                                <hr style="margin-top: 2rem;">
                            </div>
                              <div class="col-12">

                               <select id="permisos" class="js-example-basic-multiple col-sm-12" multiple="multiple">
                                  <!-- <option value="1" disabled>Localización</option> -->
                                  <option v-for="per in listPermissions" :value="per.id" :key="per.id">{{per.name}}</option>
                              </select>

                            </div>

                             <div class="col-12" id="alertasSAD" style="margin-top: 20px;"></div>

                            <div class="col-12 " style="margin-top: 15px;">
                                <button class="btn btn-secondary shadow-2 mb-4 float-left" @click="cancel()" >CANCELAR</button>
                                <button class="btn btn-primary shadow-2 mb-4 float-right" @click="SendForm()" type="submit">REGISTRAR</button>
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
/**
 * @vuese
 * @group Administrador/Distribuidor/Cliente
 * Formulario para crear sub adminstrador/distribuidor
 */

export default {
  name: 'FormSubAdminDistribuidor',
  mixins: [API, Functions],
  data () {
    return {
      user: null,
      email: null,
      zonaH: '',
      notas: null,
      listZonaHoraria: [],
      seccion: this.$route.params.id,
      title: null,
      listPermissions: []

    }
  },
  created () {
    this.$store.state.loader = true
    this.zonaHoraria()
    this.catPermissions()
  },
  mounted () {
    this.$store.state.submenuActive = 'adminUsers'

    if (this.seccion == 1) { // sub admin
      this.title = 'Usuarios - Nuevo sub administrador'
      this.$store.state.itemSubmenuActive = 'itemSubAdmin'
    }
    if (this.seccion == 2) { // sub distribuidor
      this.title = 'Usuarios - Nuevo sub distribuidor'
      this.$store.state.itemSubmenuActive = 'itemSubDist'
    }

    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })

    // [ Multi Select ] start
    $('.js-example-basic-multiple').select2({
      placeholder: 'Selecciona permisos',
      tags: true,
      tokenSeparators: [',', ' ']
    })

    $('#permisos').val(1)
    this.$store.state.loader = false
  },
  methods: {
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
   * Obtiene catalogo de permisos
   */
    async catPermissions () {
      var request = await this.getRequest('permissions')

      if (request.success === true) {
        this.listPermissions = request.data.permissions
      }
    },
    /**
   * @vuese
   * Envia datos y registra un distribuidor o un cliente segun sea el caso
   */
    async SendForm () {
      if (this.user != null && this.email != null && this.zonaH != '') {
        var tipoUser = 2

        var per = $('#permisos').val()

        var permisos = []
        per.forEach(element => {
          element = parseInt(element)

          permisos.push(element)
        })

        var datosUsuario = {
          'userType': tipoUser,
          'timezone': this.zonaH,
          'username': this.user,
          'email': this.email,
          'notes': this.notas,
          'name': '',
          'paternalSurname': '',
          'maternalSurname': '',
          'phone': 0,
          'permissions': permisos,
          'address': ''

        }

        var datos = {}
        // datosUsuario.devices = Object.values(this.dispositivosUser)
        datos['user'] = datosUsuario
        datos['devices'] = []

        var request = await this.postRequest('users', datos)

        if (request.success === true) {
          $('#alertasSAD').html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha creado el usuario<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
          setTimeout(() => {
            $('#alertasSAD').html('')
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

          $('#alertasSAD').html(`<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>${message}<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>`)
        }
      }
    },
    /**
   * @vuese
   * cancela el proceso y regresa a la tabla de sub admin/distribuidores
   */
    cancel () {
      if (this.seccion == 1) { // admin
        this.$router.push('/ListTableSubAdmin')
      }
      if (this.seccion == 2) { // distribuidor
        this.$router.push('/ListTableSubDistribuitor')
      }
    }
  }
}
</script>
