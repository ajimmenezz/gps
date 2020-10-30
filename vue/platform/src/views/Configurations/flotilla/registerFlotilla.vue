<template>
  <div class=" row ">
    <div class="col-12"> <h5 class="float-left" style="font-size: 20px; padding-bottom: 10px;">
      <b v-if="accion!='editar'">Flotillas - Nueva flotilla</b>
      <b v-if="accion=='editar'">Flotillas - Editar flotilla</b>
      </h5></div>

      <div class=" col-12">

        <div class="card">
            <div class="card-header row">

              <h5 class=" float-left" v-if="accion!='editar'">Crear flotilla</h5>
              <h5 class=" float-left" v-if="accion=='editar'">Editar flotilla</h5>

            </div>
            <div class="card-body float-left">

                <div class="row justify-content-center">
                  <div class="col-12">  <p class="text-muted" style="text-align: justify; font-size: 12px; margin-top: 7px;">
             A continuación podrás agrupar unidades con un nombre especifico (flotilla) que poras visualizar en la sección de localizacion-dispositivos </p></div>

                  <div class="col-12 col-md-6">
                    <div class="row">
                      <div class="col-9">
                        <config-input  id="alias" label="Nombre de la flotilla"  typeinput="text"  placeholder="Nombre" v-model.trim="alias" required="true" :valor="alias"> </config-input>
                      </div>

                      <hr>

                      <div class="col-12 " style="margin-top:20px;"><h5 >Asignar dispositivos a flotilla</h5></div>

                       <div class="col-12">
                        <button type="button" class="btn btn-primary   m-b-10" style="padding: 4px 11px; font-size: 14px;"  @click="agregarTodos">Seleccionar todos</button>
                                    <button type="button" class="btn btn-primary   m-b-10" style="padding: 4px 11px; font-size: 14px;"  @click="quitarTodos">Deseleccionar todos</button>
                      </div>

                       <div class="col-12" >
                            <select id='custom-headers' class="searchable" multiple='multiple' >
                                <option v-for="device in dispositivoSinAsignar"  :key="device.id"  :value="device.id" :selected="device.selectOptions">{{device.alias}}</option>
                            </select>
                        </div>

                      </div>

                    </div>

                  </div>

                  <div class="row" style=" margin-top: 20px;">
                    <div class="col-12" id="alerts"></div>
                  </div>

                  <div class="row  justify-content-center">
                    <div class="col-6 " style="margin-top: 30px;     text-align: center;">

                      <button class="btn btn-secondary " @click="cancel()" >CANCELAR</button>
                      <button class="btn btn-primary " @click="registrar()"  v-if="accion!='editar'">REGISTRAR</button>
                      <button class="btn btn-primary " @click="editar()"  v-if="accion=='editar'">EDITAR</button>
                    <!-- <div class="col-6" >
                      <button class="btn btn-secondary float-left" @click="cancel()" >CANCELAR</button>
                    </div>

                     <div class="col-6" >
                      <button class="btn btn-primary float-right" @click="registrar()"  v-if="accion!='editar'">REGISTRAR</button>
                      <button class="btn btn-primary float-right" @click="editar()"  v-if="accion=='editar'">EDITAR</button>
                    </div> -->
                    </div>

                  </div>

            </div>
        </div>

      </div>

  </div>
</template>

<script>
import { API } from '@/mixins/API'
import EventBus from '@/EventBus'
/**
 * @group Flotillas
 * Formulario para crear, editar y consultar una flotilla
 */
export default {
  name: 'FormularioFlotilla',
  mixins: [API],
  data () {
    return {
      alias: '',
      dispositivosFlotilla: [],
      accion: '',
      idFleet: 0,
      dispositivoSinAsignar: [],
      dataFlotilla: []

    }
  },
  async created () {
    this.accion = this.$route.params.accion
    this.idFleet = this.$route.params.id
  },
  async mounted () {
    this.$store.commit('CLEAR_MODAL_DINAMIC')
    // [ Searchable ] start
    this.$store.state.submenuActive = 'config'
    this.$store.state.itemSubmenuActive = 'itemFlotilla'
    await EventBus.$emit('NAVBAR_MenuOpciones', 'config', 'itemFlotilla')

    await this.getDevices()

    await $('.searchable').multiSelect({
      selectableHeader: "<div class='custom-header'>Dispositivos disponibles</div><input type='text' class='form-control' autocomplete='off' placeholder='Disponibles'>",
      selectionHeader: "<div class='custom-header'>Dispositivos asignados</div><input type='text' class='form-control' autocomplete='off' placeholder='Asignados'>",
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
      afterSelect: function (value) {
        // this.qs1.cache()
        // this.qs2.cache()
        var id = parseInt(value)
        var disp = 0
        disp = this.dispositivosFlotilla.find(x => x == id)
        console.debug('DISP', disp)
        if (disp == undefined) {
          this.dispositivosFlotilla.push(id)
        }
      }.bind(this),
      afterDeselect: function (value) {
        // this.qs1.cache()
        // this.qs2.cache()
        var id = parseInt(value)

        var search
        this.dispositivosFlotilla.filter(function (dato, i) {
          if (dato == value) {
            search = i
            return true
          }
        })

        this.dispositivosFlotilla.splice(search, 1)
      }.bind(this)
    })

    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })
    this.$store.state.loader = false
  },
  methods: {
    agregarTodos () {
      console.debug('ENTRA TODOS')
      this.dispositivoSinAsignar.forEach(element => {
        var disp = this.dispositivosFlotilla.find(x => x == element.id)
        console.debug('DISP', disp)
        if (disp == undefined) {
          this.dispositivosFlotilla.push(element.id)
        }
      })
      $('.searchable').multiSelect('select_all')
      return false
    },
    quitarTodos () {
      console.debug('quitar TODOS')
      $('.searchable').multiSelect('deselect_all')

      this.dispositivosFlotilla = []

      return false
    },
    /**
   * @vuese
   * obtiene los datos de la flotilla a consultar
   */
    async getFleet () {
      var request = await this.getRequest('fleets/' + this.idFleet)

      var datos
      if (request.success === true) {
        datos = request.data.fleet
      }

      this.dataFlotilla = datos

      this.alias = datos.name
      var devicesFleet = datos.devices

      var dispositivos = Object.values(this.$store.state.devices.devices)
      dispositivos.forEach(disp => {
        devicesFleet.forEach(element => {
          if (parseInt(disp.id) == element) {
            this.dispositivoSinAsignar.push({ 'id': parseInt(disp.id), 'alias': disp.alias, 'selectOptions': true })
            this.dispositivosFlotilla.push(parseInt(disp.id))
          }
        })
      })
    },
    /**
   * @vuese
   * obtiene y crear el arreglo con los dispositivos diponibles
   */
    async getDevices () {
      var dispositivos = Object.values(this.$store.state.devices.devices)

      this.dispositivoSinAsignar = []
      dispositivos.forEach(element => {
        if (element.fleetID == null) {
          this.dispositivoSinAsignar.push({ 'id': parseInt(element.id), 'alias': element.alias, 'selectOptions': false })
        }
      })

      if (this.accion === 'editar') {
        await this.getFleet()
      }
    },

    /**
   * @vuese
   * registra la bueva flotilla creada
   */
    async registrar () {
      if (this.alias === '') {
        $('#alerts').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Por favor ingresa por lo menos el nombre de la flotilla</div>")
        setTimeout(() => {
          $('#alerts').html('')
        }, 3000)
        return false
      }

      if (this.dispositivosFlotilla.length <= 0) {
        $('#alerts').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Por favor selecciona por lo menos 1 dispositivo</div>")
        setTimeout(() => {
          $('#alerts').html('')
        }, 3000)
        return false
      }

      var datosFleet = {
        'name': this.alias,
        'devices': this.dispositivosFlotilla

      }

      var datos = {}

      datos['fleet'] = datosFleet

      var request = await this.postRequest('fleets', datos)

      if (request.success === true) {
        var id = request.data.fleetID
        var dispositivos = Object.values(this.$store.state.devices.devices)

        dispositivos.forEach(disp => {
          this.dispositivosFlotilla.forEach(element => {
            if (parseInt(disp.id) == element) {
              disp.fleetID = id
              this.$store.state.devices.devices[disp.imei].fleetID = id
            }
          })
        })

        $('#alerts').html(`<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha registrado la flotilla<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>`)
        setTimeout(() => {
          $('#alerts').html('')
          this.cancel()
        }, 3000)
      } else {
        $('#alerts').html(`<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se ha registrado la flotilla<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>`)
      }
    },

    /**
   * @vuese
   * Actualiza los datos de la flotilla creada que hayan sido modificados
   */
    async editar () {
      if (this.alias === '') {
        $('#alerts').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Por favor ingresa por lo menos el nombre de la flotilla</div>")
        setTimeout(() => {
          $('#alerts').html('')
        }, 3000)
        return false
      }

      if (this.dispositivosFlotilla.length <= 0) {
        $('#alerts').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Por favor ingresa por lo menos 1 dispositivo</div>")
        setTimeout(() => {
          $('#alerts').html('')
        }, 3000)
        return false
      }

      if (this.dispositivosFlotilla.length <= 0) {
        this.dispositivosFlotilla = []
      }
      var datosFleet = {
        'name': this.alias,
        'devices': this.dispositivosFlotilla

      }

      var datos = {}

      datos['fleet'] = datosFleet

      var request = await this.putRequest('fleets/' + this.idFleet, datos)

      if (request.success === true) {
        var id = this.idFleet

        // mandar todos a null

        var fleets_ALL = this.dataFlotilla.devices
        var dispositivoss = Object.values(this.$store.state.devices.devices)

        dispositivoss.forEach(disp => {
          fleets_ALL.forEach(element => {
            if (parseInt(disp.id) == element) {
              disp.fleetID = null
              this.$store.state.devices.devices[disp.imei].fleetID = null
            }
          })
        })

        var dispositivos = Object.values(this.$store.state.devices.devices)

        dispositivos.forEach(disp => {
          this.dispositivosFlotilla.forEach(element => {
            if (parseInt(disp.id) == element) {
              disp.fleetID = id
              this.$store.state.devices.devices[disp.imei].fleetID = id
            }
          })
        })

        $('#alerts').html(`<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha actualizado la flotilla<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>`)
        setTimeout(() => {
          $('#alerts').html('')
          this.cancel()
        }, 3000)
      } else {
        $('#alerts').html(`<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se ha actualizado la flotilla<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>`)
      }
    },
    /**
   * @vuese
   * concela el proceso y manda a la tabla de flotillas
   */
    cancel () {
      this.$router.push('/flotillas')
    }
  },
  computed: {

  }
}
</script>

<style>
.mpConf{
  margin: 10px;
  padding-top: 10px;
}
</style>
