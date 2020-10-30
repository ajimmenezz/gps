<template>
    <div>
        KEY
        <input type="text" v-model="key">

        VALUE
        <input type="text" v-model="value">

        <button @click="addItem()">SAVE</button>
        <button @click="clearItem()">CLEAR ITEM</button>
        <button @click="clearAll()">CLEAR ALL</button>
        <button @click="getItem()">GET</button>
    </div>
</template>

<script>

import { SecureStorage } from '@/mixins/SecureStorage.js'
export default {
  mixins: [SecureStorage],
  data () {
    return {
      key: '',
      value: ''

    }
  },
  methods: {
    addItem () {
      console.debug(`Agregar a sessionStorage ${this.key}, ${this.value}`)
      this.sessionSet(this.key, this.value)
      this.clearInputs()
    },
    clearItem () {
      console.debug(`Clear sessionStorage Item: ${this.key}`)
      this.sessionRemove(this.key)
      this.clearInputs()
    },
    clearAll () {
      console.debug(`Clear All sessionStorage`)
      this.sessionClear()
    },
    getItem () {
      console.debug(`Get ${this.key}`)
      var val = this.sessionGet(this.key)
      alert(val)
    },

    clearInputs () {
      this.key = ''
      this.value = ''
    }

  }
}
</script>

<style>

</style>
