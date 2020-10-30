<template>
  <div class=" row justify-content-center" >
      <div class="col-12"> <h5 class=" float-left">Configurar dispositivo</h5></div>
      <div class=" col-11">

        <div class="card">
            <div class="card-header row">
              <div class="col-6">
              <h5 class=" float-left">Dispositivos</h5>
              </div>

            </div>
            <div class="card-body">

              <div class="table-responsive">
                  <table id="zero-configuration" class="display table nowrap table-striped table-hover" style="width:100%">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th>Dispositivo</th>
                              <th>Fecha de creación</th>
                              <th>Estado</th>
                              <th>Acciones</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr>
                              <td>Tiger Nixon</td>
                              <td>System Architect</td>
                              <td>Edinburgh</td>
                              <td>61</td>
                              <td>
                                  <span class="cursor" ><i class="icon icon-md universalicon-pencil cursor" @click="editar()"></i></span>
                              </td>
                          </tr>
                          <tr>
                              <td>Garrett Winters</td>
                              <td>Accountant</td>
                              <td>Tokyo</td>
                              <td>63</td>
                               <td>
                                  <span class="cursor" ><i class="icon icon-md universalicon-pencil cursor" @click="editar()"></i></span>
                              </td>
                          </tr>
                          <tr>
                              <td>Ashton Cox</td>
                              <td>Junior Technical Author</td>
                              <td>San Francisco</td>
                              <td>66</td>
                               <td>
                                  <span class="cursor" ><i class="icon icon-md universalicon-pencil cursor" @click="editar()"></i></span>
                              </td>
                          </tr>
                          <tr>
                              <td>Cedric Kelly</td>
                              <td>Senior Javascript Developer</td>
                              <td>Edinburgh</td>
                              <td>22</td>
                               <td>
                                  <span class="cursor" ><i class="icon icon-md universalicon-pencil cursor" @click="editar()"></i></span>
                              </td>
                          </tr>
                          <tr>
                              <td>Herrod Chandler</td>
                              <td>Sales Assistant</td>
                              <td>San Francisco</td>
                              <td>59</td>
                               <td>
                                  <span class="cursor" ><i class="icon icon-md universalicon-pencil cursor" @click="editar()"></i></span>
                              </td>
                          </tr>
                           <tr>
                              <td>Ashton Cox</td>
                              <td>Junior Technical Author</td>
                              <td>San Francisco</td>
                              <td>66</td>
                              <td>
                                  <span class="cursor" ><i class="icon icon-md universalicon-pencil cursor" @click="editar()"></i></span>
                              </td>
                          </tr>
                          <tr>
                              <td>Cedric Kelly</td>
                              <td>Senior Javascript Developer</td>
                              <td>Edinburgh</td>
                              <td>22</td>
                               <td>
                                  <span class="cursor" ><i class="icon icon-md universalicon-pencil cursor" @click="editar()"></i></span>
                              </td>
                          </tr>
                          <tr>
                              <td>Herrod Chandler</td>
                              <td>Sales Assistant</td>
                              <td>San Francisco</td>
                              <td>59</td>
                               <td>
                                  <span class="cursor" ><i class="icon icon-md universalicon-pencil cursor" @click="editar()"></i></span>
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
/**
 * @vuese
 * @group Reportes
 * tabla de reportes (no)
 */
export default {
  name: 'tablaReportes',
  data () {
    return {

    }
  },
  created () {

  },
  mounted () {
    $('#containerPrincipal').css({ 'margin-left': this.$store.state.widthMenu })
    $('#containerPrincipal').css({ 'margin-top': this.$store.state.topMenu })
    $('#zero-configuration').DataTable({ scrollY: 360 })

    $('#zero-configuration_length').css({ 'float': 'left' })
  },
  methods: {
    editar () {
      this.$router.push('/devicesEdit')
    }
  },
  computed: {

  }
}
</script>
