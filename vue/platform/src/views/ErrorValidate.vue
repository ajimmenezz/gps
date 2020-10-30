<template>
    <div class="row content-notification" >

        <div class="col-12">
          <div style="margin: 20px;"><img class="img-fluid " src="img/logo.png"></div>
          <div class="card text-center" style="box-shadow: 0 1px 3px 0 rgba(69, 90, 100, 0.9)">
              <div class="card-body">
                  <h5 class="card-title">¡Lo sentimos!</h5>
                  <p class="card-text text-muted" style="font-size:14px;">El enlace al que desea acceder se encuentra deshabilitado. Por las siguientes razones:</p>

                  <p class="card-text text-left" >
                    <ul>
                        <li class="text-muted">El acceso a este enlace ya ha sido utilizado.</li>
                        <li class="text-muted">La vigencia del mismo, ya ha caducado.</li>
                    </ul>
                  </p>
                  <router-link to="/login"><button class="btn btn-primary mb-2" style="margin-top: 10px;">Ir a GPSinfinity</button></router-link>
              </div>
          </div>
        </div>

    </div>
</template>

<script>
/**
* @vuese
 * @group PaginaValidarEnlace
 * pagina de mensaje de enlace utilizado o vigencia caducada en caso de recuperar contraseña
 */
export default {
  name: 'PaginaValidacionEnlace',
  data () {
    return {

    }
  },
	 methods: {

  },
  computed: {

  }
}
</script>

<style >

  .content-notification{
    width: 650px;
    font-family: "Open Sans", sans-serif;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, 30%);
    -webkit-transform: translate(-50%, 30%);
  }

  body{
        background: #fff;
  }
</style>
