<template>
<div class="row">
    <div class="col-12">
        <h5 class="float-left" style="font-size:20px; padding-bottom:10px;">
            <b>Operaciones</b>
        </h5>
    </div>

    <div class="col-6 col-md-4">
        <div class="card card-custom">
            <img class="card-img-top" src="img/cards/shoppingCart.jpg" alt="Ventas"/>
            <div class="card-body">
                <h5 class="card-title">Ventas</h5>
                <p class="card-text text-left">
                    Consulta las ventas realizadas y genera nuevas ventas.
                </p>
                <button type="button" class="btn btn-primary float-right" @click="goto('sales')">CONTINUAR</button>
            </div>
        </div>
    </div>

    <!-- <div class="col-6 col-md-4">
        <div class="card card-custom">
            <img class="card-img-top" src="img/cards/returns.jpg" alt="Ventas"/>
            <div class="card-body">
                <h5 class="card-title">Devoluciones</h5>
                <p class="card-text text-left">
                    Consulta las devoluciones realizadas y genera nuevas devoluciones.
                </p>
                <button type="button" class="btn btn-primary float-right" @click="goto('returns')">CONTINUAR</button>
            </div>
        </div>
    </div> -->
</div>
</template>

<script>
import EventBus from '@/EventBus.js'
export default {
  name: 'Transactions',
  async mounted () {
    this.$store.state.seccionMenu = 'operacion'
    await EventBus.$emit('NAVBAR_MenuSimple', 'operacion')
    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })
  },
  methods: {
    goto (name) {
      this.$router.push(`/transactions/${name}`)
    }
  }
}
</script>

<style scoped>
.card-custom{
    width: 300px;
    height: 400px;
}
.card-custom > img{
    background-size: cover;
    background-position: center;
    height: 200px;
}
</style>
