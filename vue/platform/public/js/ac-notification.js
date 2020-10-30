'use strict'

$(document).ready(function () {

})

function notify (title, message, from, align, type, x = 30, y = 30, delay = 3000) {
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
      x: x,
      y: y
    },
    spacing: 10,
    z_index: 999999,
    delay: delay,
    timer: 1000,
    url_target: '_blank',
    mouse_over: false,
    animate: {
      enter: 'animated fadeInRight',
      exit: 'animated fadeOutRight'
    }
  })
};
