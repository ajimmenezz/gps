<template>
<div class="text-left" style="margin-bottom:10px;">
     <label>{{title}}</label>
      <select class="form-control"
      :name="nameSelect"
      refs="select"
      @change="onChange"
      v-model="selectedItem">
        <option disabled value=''>Seleccione</option>
        <option  value=-1>Seleccionar todos</option>
        <option v-for="(item, index) in data" v-bind:key="index" v-bind:value="item">{{item[filterby]}}</option>
      </select>
</div>
</template>

<script>
export default {
  name: 'MSelect',
  props: {
    data: {
      type: Array,
      required: true
    },
    filterby: {
      type: String,
      required: true
    },
    title: {
      default: 'Seleccione',
      type: String
    },
    nameSelect: {
      type: String,
      required: false
    }
  },
  data () {
    return {
      selectedItem: ''
    }
  },
  methods: {
    onChange () {
      this.$emit('selectionChanged', this.selectedItem)
    }
  },
  watch: {
    data () {
      this.selectedItem = ''
    }
  }

}
</script>

<style>

</style>
