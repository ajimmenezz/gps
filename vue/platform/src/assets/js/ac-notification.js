'use strict'

$(document).ready(function () {
  // show the alert
  // setTimeout(function () {
  //   $('.alert').alert('close')
  // }, 2000)
})

// example: notify('Error! ', "Las contraseñas no coinciden ",'top', 'right', 'danger')
function notify (title, message, from, align, type, duration = 5000) {
  $.growl({

    title: title,
    message: message

  }, {
    element: 'body',
    type: type,
    allow_dismiss: true,
    placement: {
      from: from,
      align: align
    },
    offset: {
      x: 30,
      y: 30
    },
    spacing: 10,
    z_index: 999999,
    delay: duration,
    timer: 1000,
    url_target: '_blank',
    mouse_over: false,
    animate: {
      enter: 'animated fadeInRight',
      exit: 'animated fadeOutRight'
    }
  })
};
