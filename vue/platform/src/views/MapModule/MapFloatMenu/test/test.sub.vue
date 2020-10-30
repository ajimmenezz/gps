<template>
  <div class="container-fluid">
      <div class="row">
          <div class="col-12 alert-warning">
              some content
          </div>
          <div class="col-12">
              <button @click="close">Close</button>
          </div>
          <div class="col-6 alert-info">col-6</div>
          <div class="col-6 alert-danger">col-6</div>
          <div class="col-12 alert-success" style="min-height:800px;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet eos, vero nam quas magnam ipsum in eum vitae impedit ex esse dolore laboriosam voluptates quis sint consectetur est accusantium earum!</div>
      </div>
  </div>
</template>

<script>
export default {
  methods: {
    close () {
      console.debug('auto close')
      this.$emit('onClose')
    }
  }
}
</script>

<style>

</style>
