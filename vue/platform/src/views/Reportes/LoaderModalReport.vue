<template>
  <!-- MODAL -->

  <div
    id="modalLoaderReport"
    class="modal fade"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <p>Espere por favor</p>
          <div class="spinner-border" style="display:" />
        </div>
      </div>
    </div>
  </div>

  <!-- fin modal -->
</template>

<script>
import EventBus from '@/EventBus'
import { API } from '@/mixins/API'
/**
 * @group Modals
 * Modal para eliminar geocerca, punto de interes y rutas
 */
export default {
  name: 'modalLoaderReporte',
  mixins: [API],
  data () {
    return {}
  },
  mounted () {
    $('#modalLoaderReport').modal('show')
  },
  destroyed () {},
  methods: {},
  computed: {}
}
</script>
