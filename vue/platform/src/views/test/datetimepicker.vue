<template>
<div class="row">
    <div class="col-12">
        <button @click="setTime">SET TIME</button>
        <button @click="setMinTime">SET MIN DATE</button>
        <button @click="setMaxTime">SET MAX DATE</button>
    </div>
<div class="col-6">
        <label for="date-start">Seleccione Fecha:</label>
        <input
          type="text"
          id="time-start"
          class="form-control mb-3 cursor"
          placeholder="Fecha de inicio"
        />
      </div>
      <div class="col-6">
        <label for="date-start">Hora final:</label>
        {{selectedTime}}
      </div>
</div>
</template>

<script>
export default {
  data () {
    return {
      selectedTime: 0
    }
  },
  mounted () {
    this.initializeDateTimePicker()
    // $('#time-start').bootstrapMaterialDatePicker('setDate', this.$moment(new Date()).startOf('day'))
  },
  methods: {
    initializeDateTimePicker () {
      /// BootstrapDateTimePicker DOC
      // https://github.com/T00rk/bootstrap-material-datetimepicker

      // startOf = 00:00 Hrs del dia actual
      // endOf('day') 11:59 Hrs del dia actual
      // unix() para manejar timestamp
      this.selectedTime = this.$moment(new Date()).startOf('day')
      console.debug('fecha inicial', this.selectedTime.format('LLLL'))

      $('#time-start')
        .bootstrapMaterialDatePicker({
          lang: 'es',
          currentDate: this.selectedTime, // Selecciona fecha por default,
          minDate: this.$moment(new Date()).startOf('day'), // Selecciona la fecha minima para seleccionar
          maxDate: this.$moment(new Date()).endOf('day'), // Selecciona la fecha maxima para seleccionar
          year: true, // Permitir seleccionar año
          date: true, // Permitir seleccionar fecha/mes
          time: true, // Permite seleccionar la hora
          shortTime: true, // Permite mostrar la hora como AM/PM en vez de formato 24 HRS
          format: 'LLL' // Como se presenta la fecha en el input.,
        })
        .on('change', this.onTimestampChanged)
    },
    onTimestampChanged (sender, date) {
      // sender: objecto que envio el evento
      // date: objecto moment que regresa la fecha seleccionada
      console.debug(sender)
      console.debug(date.format('LLL'))
      console.debug(date.format('HH:mm'))
      console.debug(date.unix())

      this.selectedTime = date
      console.debug(this.selectedTime)

      console.debug('OnTimestampChanged', date.format('LLL'))
      alert(this.selectedTime.unix())
    },
    setTime () {
      this.selectedTime = this.$moment.unix(1588312800) // Fecha del primero feb
      $('#time-start').val(this.selectedTime.format('LLL')) // Cambiar el text del input
      $('#time-start').trigger('change', this.selectedTime) // Cambiar el valor del input

      console.debug('Set current time', this.selectedTime.format('LLL'))
    },
    setMinTime () {
      var date = this.$moment.unix(1577858400) // Fecha minima seleccionable enero
      $('#time-start').bootstrapMaterialDatePicker('setMinDate', date)

      console.debug('Set min time', date.format('LLL'))
    },
    setMaxTime () {
      var date = this.$moment.unix(1588312800) // fecha maxima seleccionable mayo
      $('#time-start').bootstrapMaterialDatePicker('setMaxDate', date)

      console.debug('Set Max time', date.format('LLL'))
    }
  }
}
</script>

<style>

</style>
