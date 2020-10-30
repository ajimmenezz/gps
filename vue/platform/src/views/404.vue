<template>
  <div class=" row page-noFount">

     <div class="col-12">
         <h3 class="mb-4">Página no encontrada</h3>

        <button class="btn btn-primary shadow-2 mb-4 " @click="redirect()">Ir a inicar sesión</button>
     </div>

  </div>
</template>

<script>

import { SecureStorage } from '@/mixins/SecureStorage.js'

export default {
  name: '',
  mixins: [SecureStorage],
  data () {
    return {

    }
  },
  created () {

  },
  beforeDestroy () {
    if (this.sessionGet('logged')) {
      this.$store.state.showMenu = true
    }
  },

  mounted () {
    this.$store.state.showMenu = false
  },
  methods: {
    redirect () {
      console.debug('redirect')
      this.$router.push('/home')
    }
  },
  computed: {

  }
}
</script>

<style>
.page-noFount{
     position: absolute;
     left: 50%;
    top: 50%;
    transform: translate(-50%, 50%);
    -webkit-transform: translate(-50%, 50%);
}
</style>
