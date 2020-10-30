export const Functions = {
  data () {
    return {

    }
  },
  methods: {
    filterList: function (list, filterName, searchTerm, tipo) {
      var listaFiltro
      console.debug(list)
      var lista = Object.values(list)
      var result = new Promise(resolve => {
        // if (tipo === 'device') {
        //   var alias = filterName.replace('"', '')
        // } else {
        //   var name = filterName.replace('"', '')
        // }

        if (!searchTerm) {
          listaFiltro = lista
          resolve('AllDevices', lista)
        } else {
          const term = searchTerm.toLowerCase()
          if (tipo === 'device') {
            listaFiltro = lista.filter(({ alias }) => {
              return alias.toLowerCase().includes(term)
            })
          } else {
            if (tipo === 'tipo') {
              listaFiltro = lista.filter(({ type }) => {
                return type.toLowerCase().includes(term)
              })
            } else {
              listaFiltro = lista.filter(({ name }) => {
                return name.toLowerCase().includes(term)
              })
            }
          }
          resolve('Device Filtered', listaFiltro)
        }
      })

      return listaFiltro
    },
    validar_email (email) {
      var emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i

      if (emailRegex.test(email)) {
        return true
      } else {
        return false
      }
    },
    fechaEsp (fecha) {
      fecha = fecha.replace('enero', 'January')
      fecha = fecha.replace('febrero', 'February')
      fecha = fecha.replace('marzo', 'March')
      fecha = fecha.replace('abril', 'April')
      fecha = fecha.replace('mayo', 'May')
      fecha = fecha.replace('junio', 'June')
      fecha = fecha.replace('julio', 'July')
      fecha = fecha.replace('agosto', 'August')
      fecha = fecha.replace('septiembre', 'September')
      fecha = fecha.replace('octubre', 'October')
      fecha = fecha.replace('noviembre', 'November')
      fecha = fecha.replace('diciembre', 'December')

      return fecha
    },
    obtenerMesString (mes) {
      var StringMes = mes.substr(0, 2)
      StringMes = StringMes.replace('01', 'enero')
      StringMes = StringMes.replace('02', 'febrero')
      StringMes = StringMes.replace('03', 'marzo')
      StringMes = StringMes.replace('04', 'abril')
      StringMes = StringMes.replace('05', 'mayo')
      StringMes = StringMes.replace('06', 'junio')
      StringMes = StringMes.replace('07', 'julio')
      StringMes = StringMes.replace('08', 'agosto')
      StringMes = StringMes.replace('09', 'septiembre')
      StringMes = StringMes.replace('10', 'octubre')
      StringMes = StringMes.replace('11', 'noviembre')
      StringMes = StringMes.replace('12', 'diciembre')

      return StringMes
    },

    async getlogoUser (credentials) {
      var params = {
        user: credentials
      }

      localStorage.setItem('StringName', 'gps infinity')
      localStorage.setItem('imgLogo', 'img/storage/Distribuidores/17/logotipo/')

      // Process get logo

      var request = await this.getRequest('getLogo', params)
      console.debug('DATOS_GET_LOGIN', request)
      if (request.success) {
        if (request.data.user.length > 0) {
          if (request.data.user[0].idTipoCliente == 2) {
            localStorage.setItem('StringName', request.data.user[0].cuenta) // credentials.user
            localStorage.setItem('imgLogo', request.data.user[0].logo)
            return true
          }
        } else {
          return false
        }

        this.$store.state.loader = false
      } else {
        return false
      }
    },

    async getlogoUser_login (credentials) {
      var params = {
        user: credentials
      }

      localStorage.setItem('StringName', 'gps infinity')
      localStorage.setItem('imgLogo', 'img/storage/Distribuidores/17/logotipo/')

      // Process get logo

      var request = await this.getRequest('getLogoUser', params)
      console.debug('DATOS_GET_LOGIN', request)
      if (request.success) {
        if (request.data.user.length > 0) {
          if (request.data.user[0].idTipoCliente == 2) {
            localStorage.setItem('StringName', request.data.user[0].cuenta) // credentials.user
            localStorage.setItem('imgLogo', request.data.user[0].logo)
            return true
          }
        } else {
          return false
        }

        this.$store.state.loader = false
      } else {
        return false
      }
    }

  }

}
