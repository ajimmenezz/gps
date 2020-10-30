<template>

        <div class="form-group mb-3" v-bind:style="{width:width}">

            <label :for="id" v-if="label!='null'" >{{label}}</label>
            <input v-if="isRequired" class="form-control classdisabled toupperCase " :type="typeinput" :id="id"
             :placeholder="placeholder"  @input="inputValue" required v-bind:style="{padding: paddingConf, background: backgroundd,  textTransform:toLowerUperCasee}" :min="miNumber" :max="maxNumber" :value="valor"  :maxlength="maxlength" :minlength="minlength"  :onkeypress='onkeypress'>

            <input v-if="!isRequired" class="form-control classdisabled toupperCase" :type="typeinput" :id="id"
             :placeholder="placeholder"  @input="inputValue" v-bind:style="{padding: paddingConf, background: backgroundd,  textTransform:toLowerUperCasee}" :min="miNumber" :max="maxNumber" :value="valor" :maxlength="maxlength" :minlength="minlength"  :onkeypress='onkeypress'>

        </div>

</template>

<script>
/**
* @vuese
 * @group components/basico
 * componente de etiqueta y elemento input
 */
export default {
  name: 'Input',
  data () {
    return {
      idInput: this.id,
      require: null,
      toLowerUperCasee: 'none'

    }
  },
  props: ['id', 'label', 'typeinput', 'placeholder', 'required', 'paddingConf', 'miNumber', 'valor', 'maxNumber', 'disabled', 'backgroundd', 'width', 'maxlength', 'onkeypress', 'minlength', 'toLowerUperCase'],

  created: function () {

  },
  mounted () {
    if (this.disabled === 'true') {
      console.debug('INPUT_TRUE')
      $('#' + this.id).attr('disabled', 'disabled')
    }
    if (this.disabled === 'false') {
      console.debug('IMPUT_FALSE')
      $('#' + this.id).removeAttr('disabled')
    }
    if (this.toLowerUperCase != '' && this.toLowerUperCase != null) {
      this.toLowerUperCasee = this.toLowerUperCase
    }
  },
  methods: {
    /**
   * @vuese
   * Obtiene el valor ingresado en el input
   * @arg `e` valor ingresado
   */
    inputValue: function (e) {
      /** Manda valor ingresado al input
     * @arg `e.target.value` valor ingresado
     */
      this.$emit('input', e.target.value)
    }
  },
  computed: {
    /**
   * @vuese
   * Regresa si el input es requerido o no
   *
   */
    isRequired () {
      if (this.required == 'true') { return this.require = true }
      if (this.required == 'false') { return this.require = false }
    }
  }
}

</script>
