
export const ValidateVariables = {
  data () {
    return {

    }
  },
  methods: {
    ValidatePassword: function (passw, confirmPass) {
      if (passw === confirmPass) {
        if (passw.length >= 8) {
          var mayuscula = false
          var minuscula = false
          var numero = false
          var caracter_raro = false

          for (var i = 0; i < passw.length; i++) {
            if (passw.charCodeAt(i) >= 65 && passw.charCodeAt(i) <= 90) {
              mayuscula = true
            } else if (passw.charCodeAt(i) >= 97 && passw.charCodeAt(i) <= 122) {
              minuscula = true
            } else if (passw.charCodeAt(i) >= 48 && passw.charCodeAt(i) <= 57) {
              numero = true
            } else if (passw.charCodeAt(i) >= 35 && passw.charCodeAt(i) <= 38 || passw.charCodeAt(i) >= 45 && passw.charCodeAt(i) <= 46) {
              caracter_raro = true
            }
          }
          if (mayuscula == true && minuscula == true && caracter_raro == true && numero == true) {
            return 1
          }
        }
        return 0
      } else {
        return 2
      }
    }
  }

}
