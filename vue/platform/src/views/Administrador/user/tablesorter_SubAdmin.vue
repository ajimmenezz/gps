<template>
  <div class=" row " >
      <div class="col-12"> <h5 class="float-left" style="font-size: 20px; padding-bottom: 10px;"><b>Usuarios - Lista de sub administradores</b></h5></div>

      <div class=" col-12">
      <div class="card">
           <div class="card-header row">
              <div class="col-9">
              <h5 class=" float-left">Sub adminsitradores</h5>
              </div>

              <div class="col-3" style="height: 30px;">

                <router-link :to="{name: 'FormSubUsers', params: { id: 1 }}"  >
                  <button  type="button" class="btn btn-primary float-right btn-sm" >NUEVO</button>
                </router-link>

              </div>
            </div>
            <div class="card-body">

              <div class="table-responsive scrollTable">
                  <table  class="table table-hover header_fijo">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th>Cuenta</th>
                              <th>Teléfonos</th>
                              <th>Correo electrónico</th>
                              <th>Fecha de creación</th>
                              <th>Acciones</th>
                          </tr>
                      </thead>
                      <tbody>
                            <tr v-for="(fleet,index) in listFlotas" :key="fleet.id">
                                <td>{{index+1}}</td>
                                <td>{{fleet.name}}</td>
                                <td>{{fleet.totalDevices}}</td>
                                <td > {{fleet.creationTimestamp* 1000 | moment("MMMM DD YYYY") }}</td>
                                <td>
                                    <span class="cursor" ><i class="icon icon-md universalicon-pencil cursor" @click="editar(fleet.id)"></i></span>
                                    <span @click="eliminar(fleet.id,fleet.name)"><i class="cursor icon-small icon universalicon-trash-2 colorText-red"></i></span>
                                </td>
                            </tr>

                      </tbody>
                      <!-- <tfoot>
                          <tr>
                              <th>Name</th>
                              <th>Position</th>
                              <th>Office</th>
                              <th>Age</th>
                              <th>Start date</th>
                              <th>Salary</th>
                          </tr>
                      </tfoot> -->
                  </table>
              </div>

            </div>
        </div>

      </div>

  </div>
</template>

<script>
import { API } from '@/mixins/API'
/**
 * @vuese
 * @group Administrador/Distribuidor
 * Tabla de sub administradores
 */
export default {
  name: 'tablaSubAdmin',
  mixins: [API],
  data () {
    return {
    }
  },
  components: {
  },
  created () {
  },
  mounted () {
    this.$store.state.submenuActive = 'adminUsers'
    this.$store.state.itemSubmenuActive = 'itemSubAdmin'
    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })
  },
  beforeDestroy () {
  },
  methods: {

  },
  computed: {

  }
}
</script>

<style>
.scrollTable{
  position: relative;
    overflow: auto;
    height: 480px;
    width: 100%;
}
</style>
