
// カタカナ
jQuery.validator.addMethod("katakana", function (value, element) {
  return this.optional(element) || /^([ァ-ヶー]+)$/.test(value);
}, "<br/>全角カタカナを入力してください"
);


$(function () {
  $("#preuser_index").validate({
    rules: {
      email: {
        required: true,
        email: true,

      },
      email2: {
        equalTo: '[name=email]',
        required: true,
      },
    },
    messages: {
      email: {
        required: "※必須項目です",
        email: "※Emailの形式で入力してください",
      },
      email2: {
        required: "※必須項目です",
        equalTo: "一致しません"
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
  });
});


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
        required: true,
        minlength: 7,
        maxlength: 7,
        number: true,
      },
      address1: {
        required: true,
      },
      address2: {
        required: true,
      },
      tel: {
        number: true,
        minlength: 10,
        maxlength: 10,
      },
      mobile: {
        number: true,
        minlength: 11,
        maxlength: 11,
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
        required: "※必須項目です",
        minlength: "７桁で入力してください",
        maxlength: "７桁で入力してください",
        number: "※半角数字、ハイフンなしで入力して下さい",
      },
      address1: {
        required: "※必須項目です",
      },
      address2: {
        required: "※必須項目です",
      },
      tel: {
        minlength: "※最低桁数は10桁です",
        maxlength: "※最大桁数は10桁です",
        number: "※半角数字で入力してください",
      },
      mobile: {
        minlength: "※最低桁数は11桁です",
        maxlength: "※最大桁数は11桁です",
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
  });
});


$(function () {
  var target = ["#user_reservation_create", "#user_reservation_re_calculate"];
  $.each(target, function (index, value) {
    $(value).validate({
      rules: {
        in_charge: {
          required: true,
        },
        tel: {
          required: true,
          minlength: 10,
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
        luggage_count: {
          number: true,
          range: [1, 49],
        },
        luggage_return: {
          number: true,
          range: [1, 49],
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
        luggage_count: {
          number: "※半角数字を入力してください",
          range: "※最大値は49です",
        },
        luggage_return: {
          number: "※半角数字を入力してください",
          range: "※最大値は49です",
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
    });
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
  });
});


$(function () {
  $("#cartConfirm").validate({
    rules: {
      flow: { required: true },
      policy: { required: true },
    },
    messages: {
      flow: {
        required: "※チェックをしてください",
      },
      policy: {
        required: "※チェックをしてください",
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
  });
});





// 数字の入力制限
$(function () {
  $("input[name*='equipment_breakdown']").on("input", function (e) {
    let value = $(e.currentTarget).val();
    value = value
      .replace(/[０-９]/g, function (s) {
        return String.fromCharCode(s.charCodeAt(0) - 65248);
      })
      .replace(/[^0-9]/g, "");
    $(e.currentTarget).val(value);
  });
});




// マイページ会員情報
$(function () {
  $("#register_edit").validate({
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
        required: true,
        number: true,
        maxlength: 7,
        minlength: 7,
      },
      address1: {
        required: true,
      },
      address2: {
        required: true,
      },
      tel: {
        number: true,
        minlength: 10,
        require_from_group: [1, ".phone_number"]
      },
      mobile: {
        number: true,
        minlength: 11,
        require_from_group: [1, ".phone_number"]
      },
      fax: {
        number: true,
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
        required: "※必須項目です",
        number: "※半角数字、ハイフンなしで入力して下さい",
        maxlength: "※7桁で入力してください",
        minlength: "※7桁で入力してください",
      },
      address1: {
        required: "※必須項目です",
      },
      address2: {
        required: "※必須項目です",
      },
      tel: {
        minlength: "※最低桁数は10桁です",
        number: "※半角数字で入力してください",
        require_from_group: "携帯番号、電話番号のどちらか一方は必須です",
      },
      mobile: {
        minlength: "※最低桁数は10桁です",
        number: "※半角数字で入力してください",
        require_from_group: "携帯番号、電話番号のどちらか一方は必須です",
      },
      fax: {
        number: "※半角数字で入力してください",
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


// マイページ メールアドレス変更
$(function () {
  $("#email_reset").validate({
    rules: {
      new_email: {
        email: true,
      },
    },
    messages: {
      new_email: {
        email: "※メールアドレスの形式で入力してください",
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
  });
});




