<template>
    <div>
        <button @click="doGetRequest">Test GET</button>
        <button @click="doPutRequest">Test PUT</button>
        <button @click="doDeleteRequest">Test DELETE</button>
        <button @click="doDownloadFileRequest">Test DOWNLOAD PDF</button>

        <div style="margin:top:50px; margin-left:50px;">{{message}}</div>
    </div>
</template>

<script>
import { API } from '@/mixins/API'
export default {
  mixins: [API],
  data () {
    return {
      message: ''
    }
  },
  methods: {
    async doGetRequest () {
      var datos = {
        user: 'ajimenez',
        password: '123'
      }
      var result = await this.getRequest('login', datos)

      console.debug('Result', result)
    },
    async doPutRequest () {
      var datos = {
        password: 'noe'
      }
      var result = await this.putRequest('login/password', datos)
      console.debug('Put Result', result)
    },
    async doDeleteRequest () {
      var params = {
        p1: 'algun valor',
        p2: 'otro valor'
      }
      var body = {
        value: 'some key',
        array: [1, 2, 3],
        arr2: [{ type: 1, name: 'juan' }, { type: 2, name: 'jon' }]
      }

      var request = await this.deleteRequest('accounts/4', params, body)
      alert(request)
    },
    async doDownloadFileRequest () {
      this.$store.state.loader = true

      var params = {
        deviceID: 70,
        fromTimestamp: 1581747100,
        toTimestamp: 1584148272,
        timezone: 'America/Mexico_City',
        maxSpeed: 80,
        format: 'pdf'
      }

      // indica el titulo del archivo y la extension que se mostraran en el dialogo de guardado
      var fileParams = {
        name: 'Bonita descarga',
        extension: 'pdf'
      }

      await this.downloadFileRequest('reports/battery/export', params, fileParams)
      this.message = 'archivo descargado'

      this.$store.state.loader = false
    }
  }

}
</script>

<style>

</style>
