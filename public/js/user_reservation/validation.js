
// カタカナ
jQuery.validator.addMethod("katakana", function (value, element) {
  return this.optional(element) || /^([ァ-ヶー]+)$/.test(value);
}, "<br/>全角カタカナを入力してください"
);



$(function () {
  $("#slct_date_form").validate({
    rules: {
      venue_id: {
        required: true,
      },
      enter_time: {
        required: true,
      },
      leave_time: {
        required: true,
      },
      q1: {
        required: true,
      },

    },
    messages: {
      venue_id: {
        required: "※必須項目です",
      },
      enter_time: {
        required: "※必須項目です",
        date: "true"
      },
      leave_time: {
        required: "※必須項目です",
        date: "true"
      },
      q1: {
        required: "※必須項目です",
      },
    },
    errorPlacement: function (error, element) {
      var name = element.attr('name');
      if (element.attr('name') === 'category[]') {
        error.appendTo($('.is-error-category'));
      } else if (element.attr('name') === name) {
        error.appendTo($('.is-error-' + name));
      }
    },
    errorElement: "span",
    errorClass: "is-error",
  });
  $('input').on('blur', function () {
    $(this).valid();
    // if ($('span').hasClass('is-error')) {
    //   $('span').css('background', 'white');
    // }
  });
});




$(function () {
  $("#user_reservation_create").validate({
    rules: {
      in_charge: {
        required: true,
      },
      tel: {
        required: true,
        minlength: 9,
      },
      price_system: {
        required: true,
      },
      board_flag: {
        required: true,
      },
      q1: {
        required: true,
      },
      cataring: {
        required: true,
      },
      event_name1: {
        maxlength: 16,
      },
      event_name2: {
        maxlength: 16,
      },
      event_owner: {
        maxlength: 30,
      },

    },
    messages: {
      in_charge: {
        required: "※必須項目です",
      },
      tel: {
        required: "※必須項目です",
        minlength: '※最低桁数は10桁です',
      },
      price_system: {
        required: "※必須項目です",
        date: "true"
      },
      board_flag: {
        required: "※必須項目です",
      },
      q1: {
        required: "※必須項目です",
      },
      cataring: {
        required: "※必須項目です",
      },
      event_name1: {
        maxlength: '※最大文字数は16文字です',
      },
      event_name2: {
        maxlength: '※最大文字数は16文字です',
      },
      event_owner: {
        maxlength: '※最大文字数は30文字です',
      },

    },
    errorPlacement: function (error, element) {
      var name = element.attr('name');
      if (element.attr('name') === 'category[]') {
        error.appendTo($('.is-error-category'));
      } else if (element.attr('name') === name) {
        error.appendTo($('.is-error-' + name));
      }
    },
    errorElement: "span",
    errorClass: "is-error",
  });
  $('input').on('blur', function () {
    $(this).valid();
    // if ($('span').hasClass('is-error')) {
    //   $('span .is-error').css('background', 'white');
    // }
  });
});






$(function () {
  $("#user_reservation_re_calculate").validate({
    rules: {
      in_charge: {
        required: true,
      },
      tel: {
        required: true,
        minlength: 9,
      },
      price_system: {
        required: true,
      },
      board_flag: {
        required: true,
      },
      q1: {
        required: true,
      },
      cataring: {
        required: true,
      },
      event_name1: {
        maxlength: 16,
      },
      event_name2: {
        maxlength: 16,
      },
      event_owner: {
        maxlength: 30,
      },
    },
    messages: {
      in_charge: {
        required: "※必須項目です",
      },
      tel: {
        required: "※必須項目です",
        minlength: '※最低桁数は10桁です',
      },
      price_system: {
        required: "※必須項目です",
        date: "true"
      },
      board_flag: {
        required: "※必須項目です",
      },
      q1: {
        required: "※必須項目です",
      },
      cataring: {
        required: "※必須項目です",
      },
      event_name1: {
        maxlength: '※最大文字数は16文字です',
      },
      event_name2: {
        maxlength: '※最大文字数は16文字です',
      },
      event_owner: {
        maxlength: '※最大文字数は30文字です',
      },

    },
    errorPlacement: function (error, element) {
      var name = element.attr('name');
      if (element.attr('name') === 'category[]') {
        error.appendTo($('.is-error-category'));
      } else if (element.attr('name') === name) {
        error.appendTo($('.is-error-' + name));
      }
    },
    errorElement: "span",
    errorClass: "is-error",
  });
  $('input').on('blur', function () {
    $(this).valid();
    // if ($('span').hasClass('is-error')) {
    //   $('span .is-error').css('background', 'white');
    // }
  });
});







$(function () {
  function ExceptString($target) {
    $target.numeric({ negative: false, });
    $target.on('change', function () {
      charactersChange($(this));
    })
    charactersChange = function (ele) {
      var val = ele.val();
      var han = val.replace(/[Ａ-Ｚａ-ｚ０-９]/g, function (s) { return String.fromCharCode(s.charCodeAt(0) - 0xFEE0) });
      if (val.match(/[Ａ-Ｚａ-ｚ０-９]/g)) {
        $(ele).val(han);
      }
    }
  }
  var tel = $("input[name^='tel']");
  var equ = $("input[name^='equipment_breakdown']");
  ExceptString(tel);
  ExceptString(equ);
})
