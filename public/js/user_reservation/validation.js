
// カタカナ
jQuery.validator.addMethod("katakana", function (value, element) {
  return this.optional(element) || /^([ァ-ヶー]+)$/.test(value);
}, "<br/>全角カタカナを入力してください"
);


$(function () {
  $("#user_register").validate({
    rules: {
      company: {
        required: true,
      },
      first_name: {
        required: true,
      },
      last_name: {
        required: true,
      },
      first_name_kana: {
        required: true,
        katakana: true,
      },
      last_name_kana: {
        required: true,
        katakana: true,
      },
      post_code: {
        maxlength: 7,
        number: true,
      },
      tel: {
        number: true, 
        minlength: 10
      },
      mobile: {
        number: true, 
        minlength: 11
      },
      fax: {
        number: true,
      },
      password: {
        minlength: 6,
        maxlength: 20,
        required: true,
      },
      password_confirmation: {
        equalTo: '[name=password]'
      },
      q1: {
        required: true,
      },
    },
    messages: {
      company: {
        required: "※必須項目です",
      },
      first_name: {
        required: "※必須項目です",
      },
      last_name: {
        required: "※必須項目です",
      },
      first_name_kana: {
        required: "※必須項目です",
        katakana: "※全角カタカナで入力してください",
      },
      last_name_kana: {
        required: "※必須項目です",
        katakana: "※全角カタカナで入力してください",
      },
      post_code: {
        maxlength: "７桁で入力してください",
        number: "※半角数字で入力してください",
      },
      tel: {
        minlength: "※最低桁数は10桁です",
        number: "※半角数字で入力してください",
      },
      mobile: {
        minlength: "※最低桁数は10桁です",
        number: "※半角数字で入力してください",
      },
      fax: {
        number: "※半角数字で入力してください",
      },
      password: {
        required: "※必須項目です",
        minlength: "※6文字以上で入力してください",
        maxlength: "※20文字以内で入力してください",
      },
      password_confirmation: {
        equalTo: "一致しません"
      },
      q1: {
        required: "※必須項目です"
      }
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
  var target = ["#slct_date_form", "#slct_venue_form"];
  $.each(target, function (index, value) {
    $(value).validate({
      rules: {
        venue_id: {
          required: true,
        },
        date: {
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
        date: {
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
        var name = element.attr("name");
        if (element.attr("name") === "category[]") {
          error.appendTo($(".is-error-category"));
        } else if (element.attr("name") === name) {
          error.appendTo($(".is-error-" + name));
        }
      },
      errorElement: "span",
      errorClass: "is-error",
      //送信前にLoadingを表示
      submitHandler: function (form) {
        $(".approval").addClass("hide");
        $(".loading").removeClass("hide");
        form.submit();
      },
    });
    $("input").on("blur", function () {
      $(this).valid();
    });
  });
});


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







// $(function () {
//   function ExceptString($target) {
//     $target.numeric({ negative: false, });
//     $target.on('change', function () {
//       charactersChange($(this));
//     })
//     charactersChange = function (ele) {
//       var val = ele.val();
//       var han = val.replace(/[Ａ-Ｚａ-ｚ０-９]/g, function (s) { return String.fromCharCode(s.charCodeAt(0) - 0xFEE0) });
//       if (val.match(/[Ａ-Ｚａ-ｚ０-９]/g)) {
//         $(ele).val(han);
//       }
//     }
//   }
//   var tel = $("input[name^='tel']");
//   var equ = $("input[name^='equipment_breakdown']");
//   ExceptString(tel);
//   ExceptString(equ);
// })
