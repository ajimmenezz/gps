<template>
    <div  class="card-body" >

          <div  style="margin-top:50px; " id="logotipo"   v-if="getPermissionDistribuidor">
              <div class="row justify-content-center" style="text-align: justify;">

                <div class="col-12 col-md-4  " style="margin-top:10px; text-align: center; margin-bottom:10px;">

                  <div class="card" style="width:200px; text-align: center;  ">
                      <div class="card-block p-0" style="margin-bottom:10px;">
                          <img class="img-fluid" style="width:90%; margin-left:12px;"   :src="`${logoGet}isotipo.png`" alt="dashboard-user">
                          <div class="ux-designer" style="padding:0px;">

                            <!-- <form id="fichero1" name="fichero1" method="post" enctype="multipart/form-data"  action="<%= BASE_URL %>saveLogo.php" > -->
                            <span class="btn btn-primary btn-file" style="position: absolute; margin-right: -45px;" @click="upload()" >
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
  name: 'logoDist',
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
    this.$store.state.loader = true
    console.debug('CREATED_INICIO')
    await this.getInfoMiPerfil()

    console.debug('CREATED_FIN')
  },
  async mounted () {
    // [ Responsive-table ] start

    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })

    this.$store.state.loader = false
    await EventBus.$emit('NAVBAR_MenuSimple', this.$store.state.seccionMenu)

    this.$store.state.submenuActive = 'config'
    this.$store.state.itemSubmenuActive = 'itemPerfil'
    await EventBus.$emit('NAVBAR_MenuOpciones', 'config', 'itemPerfil')

    this.title = ' Mi cuenta'

    this.suscribeToDeviceEvents()

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
        console.debug('RSULTADO_SAVELOGO2', result, result.data)
        localStorage.setItem('StringName', result.data.cuenta) // credentials.user

        // var url = 'img/storage/Distribuidores/' + result.data.user + '/logotipo/'
        localStorage.setItem('imgLogo', result.data.url)
        this.$store.state.modaloader.Getlogo = result.data.url

        this.Getlogo = result.data.url

        await EventBus.$emit('cambioLogo_navbar', result.data.url)
        await EventBus.$emit('cambioLogo_header', result.data.url)
        await EventBus.$emit('cambioLogo_home', result.data.url)

        console.debug('RSULTADO_SAVELOGO', result, result.data)
        notify('', 'Se ha subido el logo', 'top', 'right', 'success')
      } else {
        console.error('fail', result)
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

      this.idCliente = clientAllInfo.id

      var contactosbd = clientAllInfo.contacts
      console.debug('CONTACTOS', contactosbd)

      this.contactos = clientAllInfo.contacts

      this.contactosFine = clientAllInfo.contacts

      this.$store.state.loader = false
      console.debug('GET_INFO_TABLE_FIN')
      this.resultado = true
    }

  },
  computed: {
    getPermissionDistribuidor () {
      var tipoUser = sessionStorage.UT
      var tipoClient = sessionStorage.TC

      if (tipoUser == 2) { // asociado
        if (tipoClient == 2) { // dist/asociado
          return true
        } else { // sub admin, dist, cliente
          return false
        }
      } else { // cliente, distribuidor, admin
        if (tipoUser == 3) { // dist
          return true
        } else {
          return false
        }
      }
    },
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
