<template>
          <!-- MODAL -->

    <div class="row justify-content-center">
      <hr style="width: 90%; margin-top: -30px;">
            <div class="col-11">
              <!-- <form @submit.prevent> -->

 <form id="validation-form123" action="" @submit.prevent>
                <div class="row float-left">

                  <div class="col-12  text-left" >
                    <m-select
                    nameSelect="validation-select"
                    ref="customerSelect"
                    :data="dispositivos"
                    filterby="alias"
                    title="unidad *"
                    @selectionChanged="OnCustomerSelected"/>
                  </div>

                  <div class="col-10">

                         <config-text-typography  texto="Fecha de inicio *"></config-text-typography>
                        <input type="text" id="date-start1" class="form-control" placeholder="Fecha de inicio"  name="validation-fechaIni">
                       </div>
                       <div class="input-group-prepend float-right col-2" style=" color: #fff; background-color: #04a9f5; border-color: #04a9f5;
    left: -17px; margin-top: 27px; padding-left: 22px;">
                  <i class=" icon-md universalicon-calendar " style="padding: 4px; padding-top: 5px;"></i>

                  </div>
                  <div class="col-10">

                     <config-text-typography  texto="Fecha final *"></config-text-typography>
                        <input type="text" id="date-end1" class="form-control" placeholder="Fecha final"  name="validation-fechaFin">

                  </div>
                   <div class="input-group-prepend float-right col-2" style=" color: #fff; background-color: #04a9f5; border-color: #04a9f5;
    left: -17px; margin-top: 27px; padding-left: 22px;">
                  <i class=" icon-md universalicon-calendar " style="padding: 4px; padding-top: 5px;"></i>

                  </div>
                   <!-- <div class="col-6 ">

                          <div class="form-group">
                        <label for="order">Orden de como se ordenars los datos del reporte </label>
                        <select class="form-control" id="order" v-model="order" :valor="order"  required>
                            <option value="">Selecciona</option>
                              <option value=1>Descendiente</option>
                              <option value=2>Ascendente</option>

                        </select>
                      </div>

                  </div> -->

                </div>

                      <!-- <div class="col-12">
                        <h5 class="float-left">Conductor</h5>
                        <hr style="margin-top: 2rem;">
                      </div> -->

                  <div class="row"><div class="col-12" style="margin-top: 30px;" id="alertReportConfig"></div></div>

                  <div class="modal-footer row">
                    <div class="col-12">
                    <button class="btn btn-outline-primary" type="button" @click="cancel()">CANCELAR</button>
                    <button id="registerSubmit" type="submit" class="btn btn-primary " @click="SendForm()" >GENERAR REPORTE</button>
                      <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                      </div>

                  </div>

              </form>

            </div>

          </div>

</template>

<script>
import { API } from '@/mixins/API'
import { Functions } from '@/mixins/Functions.js'
import EventBus from '@/EventBus'
import mSelect from '@/components/basico/m.select.vue'
import modalReportLoader from '@/views/Reportes/LoaderModalReport'
/**
* @vuese
 * @group reports
 * form para reporte de distancia
 */
export default {
  name: 'reportDistancia',
  mixins: [Functions, API],
  components: {
    mSelect
  },
  data () {
    return {
      dispositivos: Object.values(this.$store.state.devices.devices),
      unidad: null,
      order: 1,
      fechaIni: null,
      fechaFin: null,
      email: null
    }
  },
  async created () {
    this.$store.state.loader = true
  },
  async mounted () {
    $('.modal-header').css({ 'border-bottom': '10px solid  rgba(233, 236, 239, 0)' })
    $(function () {
      console.debug('FUNCION VALIDATE')
      // [ Add phone validator ] start
      $.validator.addMethod(
        'phone_format',
        function (value, element) {
          return this.optional(element) || /^\(\d{3}\)[ ]\d{3}\-\d{4}$/.test(value)
        },
        'Invalid phone number.'
      )

      // [ Initialize validation ] start
      $('#validation-form123').validate({
        ignore: '.ignore, .select2-input',
        focusInvalid: false,
        rules: {

          'validation-select': {
            required: true
          },
          'validation-fechaIni': {
            required: true
          },
          'validation-fechaFin': {
            required: true
          }

          // Checkbox groups  //
        },

        // Errors //

        errorPlacement: function errorPlacement (error, element) {
          console.debug('errorPlacement', error, element)
          var $parent = $(element).parents('.form-group')

          // Do not duplicate errors
          if ($parent.find('.jquery-validation-error').length) {
            return
          }

          $parent.append(
            error.addClass('jquery-validation-error small form-text invalid-feedback')
          )
        },
        highlight: function (element) {
          console.debug('highlight:MAL', element)
          var $el = $(element)
          var $parent = $el.parents('.form-group')

          $el.addClass('is-invalid')

          // Select2 and Tagsinput
          if ($el.hasClass('select2-hidden-accessible') || $el.attr('data-role') === 'tagsinput') {
            $el.parent().addClass('is-invalid')
          }
        },
        unhighlight: function (element) {
          console.debug('unhighlight_BIEN', element)
          $(element).parents('.form-group').find('.is-invalid').removeClass('is-invalid')
          if (element == 'input.form-control') {
            console.debug('ENTRA_FIN_BIEN')
          }
        }
      })
    })
    $('#validation-email-error').html('Este campo es requerido')
    this.$store.state.loader = false

    /* FECHA Y HORA */
    var f = new Date()
    var dia1 = f.getDate()
    var mes1 = f.getMonth()
    var anioActual = f.getFullYear()

    // var nuevaFECHA = f.setMonth(mes1 - 1)

    // var date = this.$moment(new Date())
    // var fromDate = date.format('MMMM DD, YYYY ')
    // var fechaIni = fromDate + ' 00:00:00'

    // nuevos
    $('#date-end1').bootstrapMaterialDatePicker({
      weekStart: 0,
      lang: 'es',
      // format: 'LLL',
      format: 'MMMM DD, YYYY HH:mm:ss',
      // Selecciona fecha por default,
      shortTime: true, // Permite mostrar la hora como AM/PM en vez de formato 24 HRS
      // maxDate: new Date(),
      //  minDate: f
      year: true, // Permitir seleccionar año
      date: true, // Permitir seleccionar fecha/mes
      time: false, // Permite seleccionar la hora
      maxDate: this.$moment(new Date()).endOf('day'),
      minDate: this.$moment(new Date()).startOf('day'),
      currentDate: this.$moment(new Date()).endOf('day') // Selecciona fecha por default,
    })
    $('#date-start1').bootstrapMaterialDatePicker({
      weekStart: 0,
      lang: 'es',
      // format: 'LLL',
      format: 'MMMM DD, YYYY HH:mm:ss',
      currentDate: this.$moment(new Date()).startOf('day'), // Selecciona fecha por default,
      maxDate: this.$moment(new Date()).endOf('day'),
      shortTime: true, // Permite mostrar la hora como AM/PM en vez de formato 24 HRS
      // minDate: f
      year: true, // Permitir seleccionar año
      date: true, // Permitir seleccionar fecha/mes
      time: false // Permite seleccionar la hora

    }).on('change', function (e, date) {
      // var fechaSelect = this.$moment(new Date(date))

      var fechaSelect = new Date(date)
      this.fechaInicio = date

      // var timeFin = fechaSelect.add(3, 'months')
      // console.debug(fechaSelect, fechaSelect.unix(), 'TIME-FIN', timeFin, timeFin.unix())

      var anio1 = fechaSelect.getFullYear()
      var dia2 = fechaSelect.getDate()
      console.debug(this.fechaInicio, 'fech sin formato', fechaSelect)
      var mesLimit = fechaSelect.getMonth()

      var nuevaFechaLimit = fechaSelect.setMonth(mesLimit + 3)

      var mesLimit2 = fechaSelect.getMonth()
      var anio2 = fechaSelect.getFullYear()
      console.debug('actual', mesLimit, anio1)
      console.debug(fechaSelect, 'fecha mas3', mesLimit2, anio2, 'nueva fecha', nuevaFechaLimit)
      if (anio2 > anioActual) {
        console.debug('año diferente', dia1, dia2)
        fechaSelect = new Date()
        // if (mesLimit2 > 0) {
        //   if (dia2 > dia1) {
        //     console.debug('dia mayor')
        //     fechaSelect = new Date()
        //   }
        // }
      } else {
        if (anio2 == anioActual) {
          console.debug('mismo año')
          if (mesLimit2 > mesLimit) {
            fechaSelect = new Date()
            //     console.debug('entra menos de 3 meses del actual')
            //     fechaSelect = new Date()
            //   }
          }
          if (mesLimit2 == mes1) {
            if (dia2 > dia1) {
              console.debug('dia mayor, mismo mes')
              fechaSelect = new Date()
            }
          }
          // if (anioActual == anio1) {
          //   if (mesLimit2 >= mesLimit) {
          //     console.debug('entra menos de 3 meses del actual')
          //     fechaSelect = new Date()
          //   }
          // }
        }
      }
      console.debug('fecha FINAL', fechaSelect)
      // $('#date-start1').bootstrapMaterialDatePicker('setMinDate', date)
      $('#date-end1').bootstrapMaterialDatePicker('setMinDate', date)
      // 3 meses
      $('#date-end1').bootstrapMaterialDatePicker('setMaxDate', fechaSelect)
      // date.setHours(23)
      // date.setMinutes(59)
      // date.setSeconds(59)
    }).on('change', function (e, date) {
      this.fechaFinal = date
      console.debug('FECHA_FIANL', this.fechaFinal)
    })
  },
  destroyed () {

  },
  methods: {

    OnCustomerSelected (dat) {
      console.debug('UNIDAD', dat)
      if (dat == -1) {

      } else {
        this.unidad = dat.id
      }
    },

    /**
   * @vuese
   * Envia datos de reporte
   */
    async SendForm () {
      console.debug('LLAMDA')
      if (this.unidad != null && this.unidad != '' && this.order != '') {
        console.debug('entra')
        this.$store.state.loader = true

        var fecIni = $('#date-start1').val()
        var fecFin = $('#date-end1').val()

        this.fechaIni = fecIni
        this.fechaFin = fecFin

        fecIni = this.fechaEsp(fecIni)
        fecFin = this.fechaEsp(fecFin)

        var timesIni
        var timeFin
        var StringOrder

        if (this.order == 1) {
          StringOrder = 'desc'
        } if (this.order == 2) {
          StringOrder = 'asc'
        }

        // Filtros para el reporte
        var filters = {
          deviceID: parseInt(this.unidad),
          order: StringOrder
        }

        if (fecIni == '' && fecFin == '') {
        // filtro no se manda y consulta los de hoy
        // timesIni = new Date() / 1000

        // timeFin = new Date() / 1000
        } else {
          if (fecIni != '' && fecFin != '') {
            timesIni = Date.parse(fecIni) / 1000

            timeFin = Date.parse(fecFin) / 1000

            filters.fromTimestamp = timesIni
            filters.toTimestamp = timeFin
          } else {
          // debe llenar las 2 fechas
            $('#alertReportConfig').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Debe ingresar las 2 fechas<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
            setTimeout(() => {
              $('#alertReportConfig').html('')
            }, 3000)
            return 0
          }
        }

        filters.limit = 500
        var timeZone = this.sessionGet('timezone')
        console.debug('TIMEZONE', timeZone)
        filters.timezone = timeZone

        // filters.timezone = 'America/Mexico_City'

        console.debug('FECHAS_FIN', this.fechaIni, this.fechaFin)

        this.modalSend(filters)
        this.$store.state.loader = true
        this.$router.push('reportResults')
      } else {
        $('#alertReportConfig').html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'> Hemos detectado parámetros INCOMPLETOS . <span>COMPLETA los parámetro marcados con un asterisco son obligatorios para generar tu reporte.</span><button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")
      }
    },

    async modalSend (filters) {
      this.$store.state.loader = true

      console.debug('modal_cancel')
      $('#modalReportCreate').modal('hide')

      // EventBus.$emit('GET_LIST_devices', 1)
      // EventBus.$emit('GET_Graficas', 1)
      // this.$router.push('/dashStore/' + this.$store.state.StoreCliente + '/' + this.$store.state.StoreNameCliente)
      var subtittle

      subtittle = 'Reporte Nivel de Batería Consulta la distancia recorrida por una unidad GPS de un periodo de tiempo.'

      var datos = {
        'component': this.$store.state.modal.component,
        'datos': {
          'seccion': 'reporte',
          'id': this.$store.state.modal.datosDymanic.id,
          'tittle': this.$store.state.modal.datosDymanic.tittle,
          'subtittle': subtittle,
          'fechaIni': this.fechaIni,
          'fechaFin': this.fechaFin,
          'filters': filters

        }
      }
      this.$store.commit('CLEAR_MODAL_DINAMIC')

      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)

      this.$store.commit('CLEAR_MODAL_DINAMIC_modaloader')

      var datos = {
        'component': modalReportLoader,
        'datos': {

        }
      }

      await this.$store.commit('ADD_COMPONENT_DINAMIC_modaloader', datos)

      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE_modaloader', true)
      console.debug('MODAl_modaloader', this.$store.state.modal.datosDymanic)

    //  await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', false)
    },
    async cancel () {
      console.debug('CANCEL')
      $('#modalReportCreate').modal('hide') /

      // this.$store.commit('CLEAR_MODAL_DINAMIC')

      this.$router.push('cancelReports')
    }

  },
  computed: {

  }
}
</script>

<style>

</style>
