import Axios from 'axios'
import API from '@/mixins/API'

export const Login = {
  data () {
    return {

    }
  },
  methods: {
    isValidateToken: function (credentials) {
      var datosparams = {
        'token': credentials.token
      }
      return new Promise((res, rej) => {
        Axios.get(credentials.url + 'tokens/validate', { params: datosparams })
          .then((response) => {
            res(response.data)
          })
          .catch((err) => {
            res(err)
          })
      })
    },
    login: function (credentials) {
      var datosparams = {
        'user': credentials.user,
        'password': credentials.password
      }
      return new Promise((res, rej) => {
        Axios.get(credentials.url + 'login', { params: datosparams })
          .then((response) => {
            res(response.data)
          })
          .catch((err) => {
            res(err)
          })
      })
    },
    recover: function (credentials) {
      var datosparams = {
        'email': credentials.email
      }

      return new Promise((res, rej) => {
        Axios.get(credentials.url + 'login/recover', { params: datosparams })
          .then((response) => {
            console.log('api')
            console.log(response)
            res(response.data)
          })
          .catch((err) => {
            res(err)
          })
      })
    },
    changePassword: function (credentials) {
      Axios.defaults.headers.common['Authorization'] = 'Bearer ' + credentials.token

      var datosparams = {
        'password': credentials.password
      }

      return new Promise((res, rej) => {
        Axios.put(credentials.url + 'login/password', datosparams)
          .then((response) => {
            res(response.data)
          })
          .catch((err) => {
            res(err)
          })
      })
    }

  }

}
