<template>
          <!-- MODAL -->
    <div id="modalDeleteConf" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog  modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header  row float-left" style="margin: 1px;
    padding: 5px;">

                  <div class="col-11">
                    <h5 class="modal-title" id="exampleModalCenterTitle"><b>{{geofence.name}}</b></h5>
                    Configurar Geocerca
                  </div>
                  <div class=col-1><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
              </div>
              <div class="modal-body " >

                  <div class="row">
                    <div class="col-12">  <p class="text-muted" style="text-align: justify; font-size: 12px; margin-top: 7px;">A continuación podrás configurar los eventos de notificación que tendra la geocerca, asi como los dispositivos que notificarán y a que correos deseas que se les notifique</p></div>

                            <div class="col-12" id="alertAdminImeiNotas" style="margin-top: 10px;">
                      <div class='alert alert-info alert-dismissible fade show' role='alert' style='text-align: initial;' > <!-- v-if="getMarca!=null && getMarca!=''" -->
                        <strong style="font-weight: 800;">Nota! </strong>
                          La información que estas a punto de actualizar de geocerca puede demorar 5 min. en que se refleje en la plataforma, por favor ten paciencia, gracias. </br>

                          <!-- <button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'>
                            <span aria-hidden='true'>&times;</span>
                          </button> -->
                      </div>
                    </div>

                      <div class="col-12">
                            <h5 class="float-left">Eventos de notificación de geocerca</h5>
                      </div>
                       <div class="col-12">
                             <p class="text-muted"  style="text-align: justify; font-size: 12px; margin-top: 1px;">Eventos de notificación que tendrá la geocerca</p>
                             </div>

                          <div class="col-12">

                            <div class="row">
                              <div class="col-12 col-sm-4 custom-control custom-radio cssToolTipp">
                                  <input type="radio" id="1" name="customRadio" class="custom-control-input" value="1" v-model="comportamiento">
                                  <label class="custom-control-label" for="1">Entrada</label>
                                  <p style="top: 25px !important; right: 30% !important;">Notificar cuando una unidad entre a la geocerca</p>
                              </div>
                              <div class="col-12 col-sm-4 custom-control custom-radio cssToolTipp">
                                  <input type="radio" id="2" name="customRadio" class="custom-control-input" value="2" v-model="comportamiento">
                                  <label class="custom-control-label" for="2">Salida</label>
                                  <p style="top: 25px !important; right: 30% !important;">Notificar cuando una unidad salga de la geocerca</p>
                              </div>
                              <div class="col-12 col-sm-4 custom-control custom-radio cssToolTipp">
                                  <input type="radio" id="3" name="customRadio" class="custom-control-input" value="3" v-model="comportamiento">
                                  <label class="custom-control-label" for="3">Entradas/Salidas</label>
                                  <p style="top: 25px !important; right: 30% !important;">Notificar entradas/salidas de una unidad a la geocerca</p>
                              </div>

                            </div>
                          </div>
                           <hr style="width:100%">

                          <div class="col-12" style=" margin-top: 20px;">
                              <div class="row">
                                <div class="col-12 " style="margin-bottom:30px;">
                                  <div class="row">
                                    <div class="col-12">
                                    <h5 class="float-left">Asignar dispositivos a geocerca</h5>
                                    </div>
                                    <div class="col-12"> <p class="text-muted"  style="text-align: justify; font-size: 12px; margin-top: 1px;">Dispositivos que notificarán en la geocerca</p></div>
                                    <div class="row ">
                                      <!-- <select id='custom-headers' class="searchable" multiple='multiple' v-if="this.$store.state.modal.datosDymanic.accion === 'editar'">

                                          <option v-for="device in listDevices"  :key="device.deviceID"  :value="device.deviceID" selected>{{device.deviceAlias}}</option>

                                      </select> -->
                                      <div class="col-12">
                                        <button type="button" class="btn btn-primary   m-b-10" style="padding: 4px 11px; font-size: 14px;"  @click="agregarTodos">Seleccionar todos</button>
                                                    <button type="button" class="btn btn-primary   m-b-10" style="padding: 4px 11px; font-size: 14px;"  @click="quitarTodos">Deseleccionar todos</button>
                                      </div>
                                      <div class="col-12" style="text-align: -webkit-center;">
                                       <select id='custom-headers' class="searchable" multiple='multiple' >

                                          <option v-for="device in listDevices" :id="`option${device.id}`" :key="device.id"  :value="device.id"  :selected="device.selectGeofence">{{device.alias}}</option>
                                          <!-- <option v-for="device in listDevices"  :key="device.id"  :value="device.id" v-if="!device.select">{{device.alias}}</option> -->

                                      </select>
                                      </div>
                                    </div> <!-- fin row -->
                                  </div> <!-- fin col.12 -->

                                </div> <!-- fin col-6 -->

                                   <hr style="width:100%">

                                <div class="col-12 ">
                                  <div class="row">
                                    <div class="col-12">
                                      <h5 class="float-left">Correos a notificar</h5>
                                    </div>
                                    <div class="col-12">
                                        <div class="row float-left">
                                          <div class="col-9" >
                                            <config-input  id="email" label="Correo electrónico"  typeinput="email"  placeholder="Correo electrónico" v-model.trim="email" required="true" :valor="email"> </config-input>
                                          </div>
                                          <div class="col-2" style="padding-left: 0px;"><button type="button" class="btn  btn-primary" @click="agregarDest()" style="padding-top:8px; margin-top: 32px;">Agregar</button></div>
                                          <!-- <i class="feather icon-plus"></i> -->
                                          <div class="col-12">
                                            <div class="row float-left" style="width: 100%;">
                                              <div class="col-12">
                                                <h5 class="float-left">Lista de correos a los que se les notificara</h5>
                                              </div>
                                              <div class="col-12" style="overflow: auto; max-height: 128px; height:128px;" v-if="getListEmail.length>0">
                                                <div class="row" v-for="dest in getListEmail" :key="dest.id">
                                                  <div class="col-10">{{dest.email}}</div>
                                                  <div class="col-2"><span @click="eliminarDest(dest.id)"><i class="cursor icon-small icon universalicon-trash-2 colorText-red"></i></span></div>
                                                </div>

                                              </div>
                                               <div class="col-12" style="overflow: auto; max-height: 130px;" v-if="getListEmail.length==0">Sin destinatarios</div>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                          </div> <!-- fin devices -->

                           <div class="col-12" id="alertConfig"></div>
                            <div class="col-12" id="alertConfigEvent"></div>
                             <div class="col-12" id="alertConfigEmail"></div>
                              <div class="col-12" id="alertConfigDevice"></div>

                </div>

              </div> <!-- fin card body -->
              <div class="modal-footer">
                  <button id="confirm" type="button" class="btn btn-secondary" @click="cancel()">CANCELAR</button>
                  <button id="cancel" type="button" class="btn btn-primary" v-if="this.$store.state.modal.datosDymanic.accion === 'editar'" @click="guardarEdit()" >GUARDAR</button>
                  <button id="cancel" type="button" class="btn btn-primary" v-if="this.$store.state.modal.datosDymanic.accion === 'nueva'" @click="guardarNueva()" >GUARDAR</button>

              </div>

          </div>
      </div>
    </div>

    <!-- fin modal -->
</template>

<script>
import { API } from '@/mixins/API'
import storeNew from '@/store'
import { Functions } from '@/mixins/Functions.js'
/**
 * @group MapModule/MapFloatMenu/Geocercas
 * Modal para eliminar geocercas
 */
export default {
  name: 'ModalEliminarGeocerca',
  mixins: [API, Functions],
  data () {
    return {
      dispositivos: [],
      listDispositivos: [],
      dispositivosGeofence: [],
      comportamiento: 3,
      email: '',
      listEmail: [],
      id: 0,
      idGeofence: null,
      accion: this.$store.state.modal.datosDymanic.accion,
      storeNew,
      geofence: {
        name: ''
      }
    }
  },
  async created () {
    if (this.$store.state.modal.datosDymanic.accion === 'editar') {
      this.geofence.name = this.$store.state.modal.datosDymanic.dataGeofence.name
      this.idGeofence = this.$store.state.modal.datosDymanic.dataGeofence.id
      this.comportamiento = parseInt(this.$store.state.modal.datosDymanic.dataGeofence.behavior)
      await this.getcorreos()
      // await this.getdispositivos()
    }

    if (this.$store.state.modal.datosDymanic.accion === 'nueva') {
      this.accion = this.$store.state.modal.datosDymanic.accion
      this.idGeofence = this.$store.state.modal.datosDymanic.idGeofence
      await this.getdispositivosNew()
    }
  },
  async mounted () {
    this.$store.state.loader = false
    $('#modalDeleteConf').modal('show')

    // [ Searchable ] start

    const accion = this.$store.state.modal.datosDymanic.accion
    if (this.$store.state.modal.datosDymanic.accion === 'editar') {
      await this.getdispositivos()
    }

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
      afterSelect: async function (value) {
        // this.qs1.cache()
        // this.qs2.cache()

        var id = parseInt(value)
        console.debug('ID', id)

        var disp = 0
        disp = this.listDispositivos.find(x => x.id == id)
        console.debug('DISP', disp)
        if (disp == undefined) {
          console.debug('DISP0')
          this.listDispositivos.push({ 'id': id, 'device': 'device' })
        }
      }.bind(this),
      afterDeselect: async function (value) {
        // this.qs1.cache()
        // this.qs2.cache()

        var id = parseInt(value)

        var search
        this.listDispositivos.filter(function (dato, i) {
          if (dato.id == value) {
            search = i
            return true
          }
        })
        this.listDispositivos.splice(search, 1)
      }.bind(this)
    })
  },
  destroyed () {

  },
  methods: {
    agregarTodos () {
      console.debug('ENTRA TODOS')
      this.dispositivos.forEach(element => {
        var disp = this.listDispositivos.find(x => x.id == element.id)
        console.debug('DISP', disp)
        if (disp == undefined) {
          this.listDispositivos.push({ 'id': element.id, 'device': 'device' })
        }
      })
      $('.searchable').multiSelect('select_all')
      return false
    },
    quitarTodos () {
      console.debug('quitar TODOS')
      $('.searchable').multiSelect('deselect_all')

      this.listDispositivos = []

      return false
    },
    cancel () {
      this.$store.commit('CLEAR_MODAL_DINAMIC')

      $('#modalDeleteConf').modal('hide')
    },
    /**
   * @vuese
   * Agrega distinatario (correo electronicos) a la lista
   */
    async agregarDest () {
      //  if (this.$store.state.modal.datosDymanic.accion === 'nueva') {
      if (this.email == null || this.email == '') {
        $('#alertConfigEmail').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Por favor, </strong>Ingresa correo electrónico</div>")
        setTimeout(() => {
          $('#alertConfigEmail').html('')
        }, 5000)
        return false
      }

      if (this.email != '') {
        var validateEmail = this.validar_email(this.email)
        if (!validateEmail) {
          $('#alertConfigEmail').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error!, </strong>El correo no es valido</div>")
          setTimeout(() => {
            $('#alertConfigEmail').html('')
          }, 5000)
          return false
        }
        var correo = null

        // this.listEmail.filter(function (dato, i) {
        //   console.debug(dato, 'FILTER', this.email)
        //   // if (dato.email === this.email) {
        //   //   $('#alertConfigEmail').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error!, </strong>El correo ya existe</div>")
        //   //   setTimeout(() => {
        //   //     $('#alertConfigEmail').html('')
        //   //   }, 5000)
        //   //   return false
        //   // }
        // })

        correo = this.listEmail.find(x => x.email === this.email)
        console.debug(correo, 'FILTER', this.email)

        if (correo != undefined && correo.email === this.email) {
          $('#alertConfigEmail').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error!, </strong>El correo ya existe</div>")
          setTimeout(() => {
            $('#alertConfigEmail').html('')
          }, 5000)
          this.email = ''

          return false
        }

        this.listEmail.push({ 'id': this.id, 'email': this.email })

        this.id++
      }

      this.email = ''

      // if (this.$store.state.modal.datosDymanic.accion === 'editar') {
      //   var idGeofence = this.$store.state.modal.datosDymanic.dataGeofence.id

      //   var data = {
      //     'email': this.email
      //   }
      //   var request = await this.postRequest('geofences/' + idGeofence + '/subscribers/emails', data)

      //   if (request.success === true) {
      //     this.getcorreos()
      //     return true
      //   } else {
      //     $('#alertConfigEmail').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Se guardado el correo<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
      //     setTimeout(() => {
      //       $('#alertConfigEmail').html('')
      //     }, 3000)
      //     return false
      //   }
      // }
    },
    /**
   * @vuese
   * elimina destinatario
  * @arg `id` Id de destinatario
   */
    async eliminarDest (id) {
      // if (this.$store.state.modal.datosDymanic.accion === 'nueva') {
      var search
      this.listEmail.filter(function (dato, i) {
        if (dato.id == id) {
          search = i
          return true
        }
      })

      this.listEmail.splice(search, 1)

      // if (this.$store.state.modal.datosDymanic.accion === 'editar') {
      //   var idGeofence = this.$store.state.modal.datosDymanic.dataGeofence.id

      //   var request = await this.deleteRequest('geofences/' + idGeofence + '/subscribers/emails/' + id)

      //   if (request.success === true) {
      //     this.getcorreos()
      //     return true
      //   } else {
      //     $('#alertConfigEmail').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se ha eliminado el correo<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
      //     setTimeout(() => {
      //       $('#alertConfigEmail').html('')
      //     }, 3000)
      //     return false
      //   }
      // }
    },
    /**
   * @vuese
   * Actualiza informacion de geocerca: destinatarios, dipositivos, informacion
   */
    async guardarEdit () {
      this.$store.state.loader = true
      var idGeofence = this.$store.state.modal.datosDymanic.dataGeofence.id

      // guardar evento

      if (this.comportamiento.length > 0) {
        var request = await this.putRequest('geofences/' + this.idGeofence + '/behavior/' + this.comportamiento)

        if (request.success === true) {
          // $('#alertConfigEvent').html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha asignado el comportamiento a la geocerca<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
        } else {
          $('#alertConfigEvent').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se ha asignado el comportamiento a la geocerca<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
        }
      }

      // elimina correos
      var resultCorreo
      var request = await this.getRequest('geofences/' + idGeofence + '/subscribers/emails')

      if (request.success === true) {
        var correosApi = request.data.emailSubscribers

        var dato
        for (var i = 0; i < correosApi.length; i++) {
          dato = JSON.parse(JSON.stringify(correosApi[i]))

          var request2 = await this.deleteRequest('geofences/' + idGeofence + '/subscribers/emails/' + dato.id)
        }

        // correos agrega

        var listEmail = this.listEmail// this.$store.state.modal.datosDymanic.datos.listEmailGeofence
        if (listEmail.length > 0) {
          for (let index = 0; index < listEmail.length; index++) {
            const element = listEmail[index]
            await this.registerEmailGeofence(this.idGeofence, element.email)
          }
        }
      }

      // dispositivos
      var resultDevice

      var request = await this.getRequest('geofences/' + idGeofence + '/devices')

      if (request.success === true) {
        var disp = request.data.devices

        for (var i = 0; i < disp.length; i++) {
          var dato = disp[i]
          var request2 = await this.deleteRequest('geofences/' + idGeofence + '/devices/' + dato.deviceID)
        }

        // agrega dispositivos
        var dispositivos = this.listDispositivos// this.$store.state.modal.datosDymanic.datos.dispositivosGeofence

        if (dispositivos.length > 0) {
          for (let index = 0; index < dispositivos.length; index++) {
            const element = dispositivos[index]
            await this.registerDevicesGeofence(this.idGeofence, element.id)
          }
        }
      }

      // if (resultDevice != true) {
      //   $('#alertConfigDevice').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se han asignado los dispositivos a la geocerca<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
      // }

      // if (resultCorreo != true) {
      //   $('#alertConfigEmail').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se han asignado los correos a la geocerca<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
      // }

      this.$store.state.loader = false
      $('#alertConfig').html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha configurado la geocerca<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")

      setTimeout(() => {
        $('#alertConfig').html('')
        // cerrar modal
        this.$store.commit('CLEAR_MODAL_DINAMIC')

        $('#modalDeleteConf').modal('hide')
      }, 3000)
    },
    /**
   * @vuese
   * Guarda informacion de geocerca nueva: destinatarios, dipositivos, informacion
   */
    async guardarNueva () {
      this.$store.state.loader = true
      // var datos = {

      //   'datos': {
      //     'comportamientoGeofence': this.comportamiento,
      //     'listEmailGeofence': this.listEmail,
      //     'dispositivosGeofence': this.listDispositivos

      //   }
      // }

      //  this.$store.state.modal.datosDymanic = datos

      // guardar evento
      if (this.comportamiento.length > 0) {
        var request = await this.putRequest('geofences/' + this.idGeofence + '/behavior/' + this.comportamiento)

        if (request.success === true) {
          // $('#alertConfigEvent').html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha asignado el comportamiento a la geocerca<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
        } else {
          $('#alertConfigEvent').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se ha asignado el comportamiento a la geocerca<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
        }
      }

      // correos
      var resultCorreo
      var listEmail = this.listEmail// this.$store.state.modal.datosDymanic.datos.listEmailGeofence
      if (listEmail.length > 0) {
        // listEmail.forEach(element => {
        //   this.registerEmailGeofence(this.idGeofence, element.email)
        // })

        for (let index = 0; index < listEmail.length; index++) {
          const element = listEmail[index]
          await this.registerEmailGeofence(this.idGeofence, element.email)
        }
      }

      // dispositivos
      var resultDevice
      var dispositivos = this.listDispositivos// this.$store.state.modal.datosDymanic.datos.dispositivosGeofence

      if (dispositivos.length > 0) {
        // dispositivos.forEach(async element => {
        //   console.debug('RETURN DEVICES', this.idGeofence, element.id)
        //   await this.registerDevicesGeofence(this.idGeofence, element.id)
        // })

        for (let index = 0; index < dispositivos.length; index++) {
          const element = dispositivos[index]
          await this.registerDevicesGeofence(this.idGeofence, element.id)
        }
      }

      // if (resultDevice != true) {
      //   $('#alertConfigDevice').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se han asignado los dispositivos a la geocerca<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
      // }

      // if (resultCorreo != true) {
      //   $('#alertConfigEmail').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se han asignado los dispositivos a la geocerca<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
      // }
      this.$store.state.loader = false
      $('#alertConfig').html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha configurado la geocerca<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")

      setTimeout(() => {
        $('#alertConfig').html('')
        // cerrar modal
        this.$store.commit('CLEAR_MODAL_DINAMIC')

        $('#modalDeleteConf').modal('hide')
      }, 3000)
    },
    /**
   * @vuese
   * Guarda correo de notificacion de geocerca
   */
    async registerEmailGeofence (id, email) {
      var data = {
        'email': email
      }
      var request = await this.postRequest('geofences/' + id + '/subscribers/emails', data)

      if (request.success == true) {
        return true
      } else {
        return false
      }
    },
    /**
   * @vuese
   * Guarda dispoaitivo de notificacion de geocerca
   */
    async registerDevicesGeofence (id, device) {
      var res
      var request = await this.postRequest('geofences/' + id + '/devices/' + device)

      if (request.success == true) {
        res = true
      } else {
        res = false
      }

      return res
    },
    /**
   * @vuese
   * Obtiene correos electronicos de geocerca
   */
    async getcorreos () {
      this.listEmail = []
      var idGeofence = this.$store.state.modal.datosDymanic.dataGeofence.id

      var request = await this.getRequest('geofences/' + idGeofence + '/subscribers/emails')

      if (request.success === true) {
        var correosApi = request.data.emailSubscribers

        var dato
        for (var i = 0; i < correosApi.length; i++) {
          dato = JSON.parse(JSON.stringify(correosApi[i]))

          this.listEmail.push({ 'id': dato.id, 'email': dato.correo })
        }
      }
    },
    /**
   * @vuese
   * Obtener lista de dipositivos cuando es geocerca nueva
   */
    getdispositivosNew () {
      this.dispositivos = []
      this.dispositivos = Object.values(this.$store.state.devices.devices)
      this.dispositivos.forEach(disp => {
        disp.selectGeofence = false
      })
    },
    /**
   * @vuese
   * Obtener lista de dipositivos que tiene una geocerca
   */
    async getdispositivos () {
      this.dispositivosGeofence = []
      this.dispositivos = []
      this.dispositivos = Object.values(this.$store.state.devices.devices)
      var idGeofence = this.$store.state.modal.datosDymanic.dataGeofence.id

      var request = await this.getRequest('geofences/' + idGeofence + '/devices')

      if (request.success === true) {
        var disp = request.data.devices

        var dato
        for (var i = 0; i < disp.length; i++) {
          dato = disp[i]

          this.dispositivosGeofence.push({ 'deviceID': dato.deviceID, 'deviceAlias': dato.deviceAlias })
          this.listDispositivos.push({ 'id': dato.deviceID, 'device': 'device' })
        }
      }
    }

  },
  computed: {
    /**
   * @vuese
   * Obtener lista de correos a mostrar
   */
    getListEmail () {
      return this.listEmail
    },
    /**
   * @vuese
   * Obtener lista de dipositivos a mostrar
   */
    listDevices () {
      this.dispositivos.forEach(disp => {
        disp.selectGeofence = false
      })

      this.dispositivos.forEach(disp => {
        this.dispositivosGeofence.forEach(dispSelect => {
          if (disp.id == dispSelect.deviceID) {
            disp.selectGeofence = true
          }
        })
      })
      return this.dispositivos
    }
  }
}
</script>
