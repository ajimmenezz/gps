<template>
    <div>
        componenete APP
        <componentA />

        dinamic

           <component :is='this.$store.state.test.modal.component' v-if="isVisible"></component>
    </div>
</template>

<script>
import componentA from './componentA.vue'

export default {

  data () {
    return {

    }
  },
  components: {
    componentA
  },
  computed: {
    isVisible () {
      if (this.$store.state.test.modal.isVisible) {
        console.log('visible')
      } else {
        console.log('false')
      }
      return this.$store.state.test.modal.isVisible
    }
  }
}
</script>
