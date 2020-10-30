<template>
    <div style="margin-top:100px;">
        <div>TIMESTAMP NOW: {{now}}</div>
        <br>
        <div>DATE NOW: {{now | moment()}}</div>
        <br>
        <input type="number" v-model="timestamp" placeholder="your timestamp" />
        <button @click="getTime">GET TIME</button>
        <div>YOUR TIMESTAMP: {{timestamp}}</div>
        <div>FROM NOW: {{timestamp | moment("from", "now", true)}}</div>
        <div>NOW VIA JAVASCRIPT: {{timestampFormatted}}</div>
        <br>
        <input type="number" v-model="seconds" placeholder="your seconds elapsed" />
        {{seconds}}
        <div>Duration: {{ [seconds, 'seconds'] | duration('humanize')}}</div>
    </div>
</template>

<script>
export default {
  data () {
    return {
      now: Date.now(),
      timestamp: Date.now(),
      timestampFormatted: 0,
      timestampFormattedNow: 0,
      seconds: 129923
    }
  },
  mounted () {
    window.setInterval(function () {
      this.updateString()
    }.bind(this), 1000)
  },
  methods: {
    getTime () {
      var date = new Date(this.timestamp)
      this.timestampFormattedNow = this.$moment(date).fromNow()
      this.timestampFormatted = this.$moment(date).format('MMMM Do YYYY, h:mm:ss a')
      console.debug('New Time', this.timestampFormatted)
      // fechaString = 'fecha (now)'
    },
    updateString () {
      var date = new Date(this.timestamp)
      var from = this.$moment(date).fromNow()
      var fechaString = this.$moment(date).format('MMMM Do YYYY, h:mm:ss a')

      this.timestampFormatted = `${fechaString} (${from})`
      console.debug('New Time', this.timestampFormatted)
    }
  }
}
</script>

<style>

</style>
