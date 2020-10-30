<template>

    <div id="modalPolicies" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog  " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Políticas de Uso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body " >
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <p class="float-left">
                                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quisquam vitae officia nihil commodi inventore nulla dolores sequi, iure ab in. Consequuntur alias aut, cum iure nisi necessitatibus perspiciatis ab aspernatur?
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-12" >
                        <button id="guardar" type="button" class="btn btn-secondary" @click="cancel()">CERRAR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
/**
   * @vuese
 * @group Modals
 * Modal de  politicas de contraseña
 */
export default {
  name: 'panelDePoliticas',
  mounted () {
    $('#modalPolicies').modal('show')
  },
  methods: {
    cancel () {
      this.$store.commit('CLEAR_MODAL_DINAMIC')

      $('#modalPolicies').modal('hide')
    }
  },
  computed: {

  }
}

</script>
