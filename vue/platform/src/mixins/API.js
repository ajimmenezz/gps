import Axios from 'axios'
import { SecureStorage } from '@/mixins/SecureStorage'
export const API = {
  mixins: [SecureStorage],
  data () {
    return {
    }
  },
  methods: {
    setAxiosHeaders () {
      try {
        if (sessionStorage.token) {
          Axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.sessionGet('token')
        }
      } catch (err) {
        console.error('SetAxiosHeaders')
      }
    },
    async getRequest (url, params = {}, body = {}) {
      this.setAxiosHeaders()

      // Axios.defaults.headers.common['Authorization'] = 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0b2tlblR5cGUiOiJMT0dJTiIsImRpc3RyaWJ1dG9ySUQiOiIxNyIsImNsaWVudElEIjoiNDIiLCJ1c2VySUQiOiI2OSIsInVzZXJUeXBlIjoiMSIsImlhdCI6MTU2NzQ0MzAxOX0.wZ0XNKpgpt2XLG4rSdm-jK-z9nJMjtnn_pdN0O5I8OA'

      console.debug('API GET', process.env.VUE_APP_API_URL + url)
      var result = await Axios.get(process.env.VUE_APP_API_URL + url, { params: params, body: body })
        .then((response) => {
          return response.data
        })
        .catch((err) => {
          console.error('API ERROR', err.response.data)
          return err.response.data
        })
      return result
    },
    async putRequest (url, params = {}) {
      this.setAxiosHeaders()
      console.debug('API PUT', process.env.VUE_APP_API_URL + url)
      var result = await Axios.put(process.env.VUE_APP_API_URL + url, params)
        .then((response) => {
          return response.data
        })
        .catch((err) => {
          console.error('API ERROR', err.response.data)
          return err.response.data
        })
      return result
    },
    async postRequest (url, params = {}) {
      this.setAxiosHeaders()
      console.debug('API POST', process.env.VUE_APP_API_URL + url)

      var result = await Axios.post(process.env.VUE_APP_API_URL + url, params)
        .then((response) => {
          return response.data
        })
        .catch((err) => {
          console.error('API ERROR', err.response.data)
          return err.response.data
        })
      return result
    },
    async deleteRequest (url, params = {}, body = {}) {
      this.setAxiosHeaders()
      console.debug('API DELETE', process.env.VUE_APP_API_URL + url)
      var result = await Axios.delete(process.env.VUE_APP_API_URL + url, { params: params, data: body })
        .then((response) => {
          return response.data
        })
        .catch((err) => {
          console.error('API ERROR', err.response.data)
          return err.response.data
        })
      return result
    },
    async getBlobRequest (url, params = {}) {
      this.setAxiosHeaders()
      var result = await Axios({
        method: 'get',
        responseType: 'blob',
        url: process.env.VUE_APP_API_URL + url,
        params: params
      })

      return result
    },
    async downloadFileRequest (url, params = {}, fileParams = { name: 'file', extension: 'pdf' }) {
      var result = await this.getBlobRequest(url, params)

      const fileUrl = window.URL.createObjectURL(new Blob([result.data]))
      const link = document.createElement('a')
      link.href = fileUrl
      link.setAttribute('download', `${fileParams.name}.${fileParams.extension}`)
      document.body.appendChild(link)
      link.click()
    }
  }

}
