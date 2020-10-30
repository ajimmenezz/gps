export const SecureStorage = {
  data () {
    return {
      crypt: cryptio,
      options: {
        storage: 'session',
        passphrase: process.env.VUE_APP_STORAGE_KEY
      }
    }
  },
  methods: {
    sessionSet: function (key, value) {
      this.crypt.set(this.options, key, value, function (err, results) {
        if (err) throw err
      })
    },
    sessionGet: function (key) {
      var value
      this.crypt.get(this.options, key, function (err, results) {
        if (err) throw err
        value = results
      })

      return value
    },
    sessionRemove: function (key) {
      sessionStorage.removeItem(key)
    },
    sessionClear: function () {
      sessionStorage.clear()
    }
  }

}
