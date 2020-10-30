<template>
    <div class="col-12"  style="margin-top: 50px;">

      <div class="col-12" v>Procesando datos, por favor espere.</div>

  </div>

</template>

<script>
import { API } from '@/mixins/API'
import EventBus from '@/EventBus.js'
/**
 * @vuese
 * @group Reportes
 * resultado del reporte
 */
export default {
  name: 'ReportesTableDist',
  mixins: [API],

  data () {
    return {

    }
  },

  created () {

  },
  async mounted () {

  },
  beforeDestroy () {

  },
  methods: {

  },
  computed: {

  }
}
</script>
