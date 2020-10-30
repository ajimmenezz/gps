<template>

        <div class="row">

            <config-text-typography :texto="label" label="true"></config-text-typography>

            <config-text-typography v-if="value!==null && value!==''" :texto="value"></config-text-typography>
            <config-text-typography v-else texto="No disponible"></config-text-typography>

        </div>

</template>

<script>
/**
* @vuese
 * @group components/basico
 * componente de texto
 */
export default {
  name: 'texto',
  data () {
    return {
      // valuee:value
    }
  },
  props: {
    // string de etiqueta de elemento
    label: {
      type: String,
      required: false
    },
    // valor del elemento
    value: {
      required: false
    }
  },
  methods: {

  }
}
</script>

<style>

label{
  padding-left: 0px !important;
    padding-right: 0px !important;
    text-align: right;
}
.padd{
  padding-left: 0px !important;
}
</style>
