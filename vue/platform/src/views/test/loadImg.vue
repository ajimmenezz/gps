<template>
    <div>
        <input type="file" id="img" name="img" @change="subirImg"> <br><br><br>

        <form action="<?= base_url() ?>AccountManager/logo_post" method="POST" enctype="multipart/form-data">
            <input type="file" id="img2" name="img2" >

            <button type="submit">guardar con form</button>
        </form>

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
    async subirImg () {
      console.debug($('#img').val())

      var archivos = document.getElementById('img')// Creamos un objeto con el elemento que contiene los archivos: el campo input file, que tiene el id = 'archivos'
      var archivo = archivos.files // Obtenemos los archivos seleccionados en el imput
      // Creamos una instancia del Objeto FormDara.
      var archivos = new FormData()
      /* Como son multiples archivos creamos un ciclo for que recorra la el arreglo de los archivos seleccionados en el input
      Este y añadimos cada elemento al formulario FormData en forma de arreglo, utilizando la variable i (autoincremental) como
      indice para cada archivo, si no hacemos esto, los valores del arreglo se sobre escriben */
      for (var i = 0; i < archivo.length; i++) {
        archivos.append('archivo' + i, archivo[i]) // Añadimos cada archivo a el arreglo con un indice direfente
      }

      /* Ejecutamos la función ajax de jQuery */

      console.debug('ARCHIVOS', archivos)

      $.ajax({
        url: 'saveLogo.php', // Url a donde la enviaremos
        type: 'POST', // Metodo que usaremos
        contentType: false, // Debe estar en false para que pase el objeto sin procesar
        data: archivos, // Le pasamos el objeto que creamos con los archivos
        processData: false, // Debe estar en false para que JQuery no procese los datos a enviar
        cache: false // Para que el formulario no guarde cache
      }).done(function (msg) { // Escuchamos la respuesta y capturamos el mensaje msg
        console.debug(msg)
      })
    },
    async Guardar () {
      var parametros = {
        'img': 12
      }

      $.ajax({
        url: 'saveLogo', // Url a donde la enviaremos
        type: 'GET', // Metodo que usaremos
        contentType: false, // Debe estar en false para que pase el objeto sin procesar
        data: parametros, // Le pasamos el objeto que creamos con los archivos
        processData: false, // Debe estar en false para que JQuery no procese los datos a enviar
        cache: false // Para que el formulario no guarde cache
      }).done(function (msg) { // Escuchamos la respuesta y capturamos el mensaje msg
        this.MensajeFinal(msg)
      })
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
