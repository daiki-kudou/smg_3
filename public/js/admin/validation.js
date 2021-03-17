// カタカナ
jQuery.validator.addMethod("katakana", function (value, element) {
  return this.optional(element) || /^([ァ-ヶー]+)$/.test(value);
}, "<br/>全角カタカナを入力してください"
);

jQuery.validator.addMethod("alphanum", function (value, element) {
  return this.optional(element) || /^([a-zA-Z0-9]+)$/.test(value);
}, "<br/>半角英数字を入力してください"
);



// 仮押え新規作成
$(function () {
  $("#pre_reservationCreateForm").validate({
    rules: {
      unknown_user_email: {
        email: true
      },
      unknown_user_mobile: {
        number: true,
        minlength: 11
      },
      unknown_user_tel: {
        number: true,
        minlength: 10
      },
      pre_date0: {
        required: true,
      },
      pre_venue0: {
        required: true,
      },
      pre_enter0: {
        required: true,
      },
      pre_leave0: {
        required: true,
      },
    },
    messages: {
      unknown_user_email: {
        email: '※Emailの形式で入力してください',
      },
      unknown_user_mobile: {
        number: '※数字を入力してください',
        minlength: '※最低桁数は11です',
      },
      unknown_user_tel: {
        number: '※数字を入力してください',
        minlength: '※最低桁数は10です',
      },
      pre_date0: {
        required: '※必須項目です',
      },
      pre_venue0: {
        required: '※必須項目です',
      },
      pre_enter0: {
        required: '※必須項目です',
      },
      pre_leave0: {
        required: '※必須項目です',
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
    //送信前にLoadingを表示
    submitHandler: function (form) {
      $('.spin_btn').removeClass('hide');
      $('.submit_btn').addClass('hide');
      form.submit();
    }
  });
  $('input').on('blur', function () {
    $(this).valid();
  });
})

// 仮押え詳細入力
$(function () {
  $("#pre_reservationSingleCheckForm").validate({
    rules: {
      in_charge: {
        required: true,
      },
      tel: {
        required: true,
        number: true,
        minlength: 11
      },
      unknown_user_tel: {
        minlength: 10
      },
    },
    messages: {
      in_charge: {
        required: '※必須項目です',
      },
      tel: {
        required: '※必須項目です',
        number: '※数字を入力してください',
        minlength: '※最低桁数は11です',
      },
      unknown_user_tel: {
        minlength: '※最低桁数は10です',
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
    //送信前にLoadingを表示
    submitHandler: function (form) {
      $('.spin_btn').removeClass('hide');
      $('.submit_btn').addClass('hide');
      form.submit();
    }
  });
  $('input').on('blur', function () {
    $(this).valid();
    // if ($('span').hasClass('is-error')) {
    //   $('span').css('background', 'white');
    // }
  });
})

// 仮押え再計算
$(function () {
  $("#pre_reservationSingleCheckForm").validate({
    rules: {
      in_charge: {
        required: true,
      },
      tel: {
        required: true,
        number: true,
        minlength: 11
      },
      unknown_user_tel: {
        minlength: 10
      },
    },
    messages: {
      in_charge: {
        required: '※必須項目です',
      },
      tel: {
        required: '※必須項目です',
        number: '※数字を入力してください',
        minlength: '※最低桁数は11です',
      },
      unknown_user_tel: {
        minlength: '※最低桁数は10です',
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
    //送信前にLoadingを表示
    submitHandler: function (form) {
      $('.spin_btn').removeClass('hide');
      $('.submit_btn').addClass('hide');
      form.submit();
    }
  });
  $('input').on('blur', function () {
    $(this).valid();
    // if ($('span').hasClass('is-error')) {
    //   $('span').css('background', 'white');
    // }
  });
})

// 仮押え編集
$(function () {
  $("#pre_reservationSingleEditForm").validate({
    rules: {
      enduser_charge: {
        required: true,
        number: true,
      },
      pre_endusers_tel: {
        number: true,
      },
      pre_endusers_mobile: {
        number: true,
        // minlength: 11
      },
    },
    messages: {
      enduser_charge: {
        required: '※必須項目です',
        number: '※半角数字を入力してください',
      },
      pre_endusers_tel: {
        number: '※半角数字を入力してください',
      },
      pre_endusers_mobile: {
        number: '※半角数字を入力してください',
        // minlength: '※最低桁数は11です',
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
    //送信前にLoadingを表示
    submitHandler: function (form) {
      $('.spin_btn').removeClass('hide');
      $('.submit_btn').addClass('hide');
      form.submit();
    }
  });
  $('input').on('blur', function () {
    $(this).valid();
    // if ($('span').hasClass('is-error')) {
    //   $('span').css('background', 'white');
    // }
  });
})

// 仮押え編集からの再計算
$(function () {
  $("#pre_reservationSingleRecalculateForm").validate({
    rules: {
      in_charge: {
        required: true,
      },
      tel: {
        required: true,
        number: true,
        minlength: 11
      },
      unknown_user_tel: {
        minlength: 10
      },
    },
    messages: {
      in_charge: {
        required: '※必須項目です',
      },
      tel: {
        required: '※必須項目です',
        number: '※数字を入力してください',
        minlength: '※最低桁数は11です',
      },
      unknown_user_tel: {
        minlength: '※最低桁数は10です',
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
    //送信前にLoadingを表示
    submitHandler: function (form) {
      $('.spin_btn').removeClass('hide');
      $('.submit_btn').addClass('hide');
      form.submit();
    }
  });
  $('input').on('blur', function () {
    $(this).valid();
    // if ($('span').hasClass('is-error')) {
    //   $('span').css('background', 'white');
    // }
  });
})


// 仲介会社 仮押え新規作成
$(function () {
  $("#pre_agent_reservationsCreateForm").validate({
    rules: {
      pre_enduser_tel: {
        number: true,
        minlength: 10
      },
      pre_enduser_mobile: {
        number: true,
        minlength: 11
      },
      pre_enduser_email: {
        email: true,
      },
    },
    messages: {
      pre_enduser_tel: {
        minlength: '※最低桁数は10です',
        number: '※数字を入力してください',
      },
      pre_enduser_mobile: {
        minlength: '※最低桁数は11です',
        number: '※数字を入力してください',
      },
      pre_enduser_email: {
        email: '※Emailの形式で入力してください',
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
    //送信前にLoadingを表示
    submitHandler: function (form) {
      $('.spin_btn').removeClass('hide');
      $('.submit_btn').addClass('hide');
      form.submit();
    }
  });
  $('input').on('blur', function () {
    $(this).valid();
    // if ($('span').hasClass('is-error')) {
    //   $('span').css('background', 'white');
    // }
  });
})

// 仮押え 仲介会社 詳細入力画面
$(function () {
  $("#pre_agent_reservationsSingleCheckForm").validate({
    rules: {
      enduser_charge: {
        required: true,
        number: true,
      },
    },
    messages: {
      enduser_charge: {
        required: '※必須項目です',
        number: '※半角数字を入力してください',
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
    //送信前にLoadingを表示
    submitHandler: function (form) {
      $('.spin_btn').removeClass('hide');
      $('.submit_btn').addClass('hide');
      form.submit();
    }
  });
  $('input').on('blur', function () {
    $(this).valid();
    // if ($('span').hasClass('is-error')) {
    //   $('span').css('background', 'white');
    // }
  });
})


// 仮押え 仲介会社 計算画面
$(function () {
  $("#pre_agent_reservationsSingleCalculateForm").validate({
    rules: {
      enduser_charge: {
        required: true,
        number: true,
      },
    },
    messages: {
      enduser_charge: {
        required: '※必須項目です',
        number: '※半角数字を入力してください',
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
    //送信前にLoadingを表示
    submitHandler: function (form) {
      $('.spin_btn').removeClass('hide');
      $('.submit_btn').addClass('hide');
      form.submit();
    }
  });
  $('input').on('blur', function () {
    $(this).valid();
    // if ($('span').hasClass('is-error')) {
    //   $('span').css('background', 'white');
    // }
  });
})

// 一括仮押さえ　編集画面　
$(function () {
  $("#multipleEditForm").validate({
    rules: {
      cp_master_tel: {
        number: true,
        minlength: 11
      },
      cp_master_luggage_count: {
        number: true,
      },
      cp_master_luggage_return: {
        number: true,
      },
      cp_master_luggage_price: {
        number: true,
      },
      cp_master_cost: {
        range: [1, 100]
      },
    },
    messages: {
      cp_master_tel: {
        number: '※半角数字を入力してください',
        minlength: '※最低桁数は11です',
      },
      cp_master_luggage_count: {
        number: '※半角数字を入力してください',
      },
      cp_master_luggage_return: {
        number: '※半角数字を入力してください',
      },
      cp_master_luggage_price: {
        number: '※半角数字を入力してください',
      },
      cp_master_cost: {
        range: '※1から100までの数値を入力してください',
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
    //送信前にLoadingを表示
    submitHandler: function (form) {
      $('.spin_btn').removeClass('hide');
      $('.submit_btn').addClass('hide');
      form.submit();
    }
  });
  $('input').on('blur', function () {
    $(this).valid();
    // if ($('span').hasClass('is-error')) {
    //   $('span').css('background', 'white');
    // }
  });
})

// 一括仮押さえ　編集画面　タブ内　　
$(function () {
  var target = $("input[name^='tel_copied']");

  for (let index = 0; index < target.length; index++) {
    var telcopied = "tel_copied" + index;
    var luggagecountcopied = "luggage_count_copied" + index;
    var luggagereturncopied = "luggage_return_copied" + index;
    $("#multipleSpecificUpdateForm" + index).validate({
      rules: {
        [telcopied]: {
          number: true,
        },
        [luggagecountcopied]: {
          number: true,
        },
        [luggagereturncopied]: {
          number: true,
        },
      },
      messages: {
        [telcopied]: {
          number: "※半角数字で入力してください",
        },
        [luggagecountcopied]: {
          number: "※半角数字で入力してください",
        },
        [luggagereturncopied]: {
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
      //送信前にLoadingを表示
      submitHandler: function (form) {
        $('.approval').addClass('hide');
        $('.loading').removeClass('hide');
        form.submit();
      }
    });
    $('input').on('blur', function () {
      $(this).valid();
      // if ($('span').hasClass('is-error')) {
      //   $('span').css('background', 'white');
      // }
    });
  }
})

// 一括仮押さえ　編集の計算
$(function () {
  $("#multipleCalculateForm").validate({
    rules: {
      cp_master_tel: {
        number: true,
        minlength: 11
      },
      cp_master_luggage_count: {
        number: true,
      },
      cp_master_luggage_return: {
        number: true,
      },
      cp_master_luggage_price: {
        number: true,
      },

    },
    messages: {
      cp_master_tel: {
        number: '※半角数字で入力してください',
        minlength: '※最低桁数は11です',
      },
      cp_master_luggage_count: {
        number: '※半角数字で入力してください',
      },
      cp_master_luggage_return: {
        number: '※半角数字で入力してください',
      },
      cp_master_luggage_price: {
        number: '※半角数字で入力してください',
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
    //送信前にLoadingを表示
    submitHandler: function (form) {
      $('.spin_btn').removeClass('hide');
      $('.submit_btn').addClass('hide');
      form.submit();
    }
  });
  $('input').on('blur', function () {
    $(this).valid();
    // if ($('span').hasClass('is-error')) {
    //   $('span').css('background', 'white');
    // }
  });
})


// 一括仮押さえ　編集の計算　タブ内　
$(function () {
  var target = $("input[name^='tel_copied']");

  for (let index = 0; index < target.length; index++) {
    var telcopied = "tel_copied" + index;
    var luggagecountcopied = "luggage_count_copied" + index;
    var luggagereturncopied = "luggage_return_copied" + index;
    var luggagepricecopied = "luggage_price_copied" + index;
    $("#multipleCalculateSpecificUpdateForm" + index).validate({
      rules: {
        [telcopied]: {
          number: true,
        },
        [luggagecountcopied]: {
          number: true,
        },
        [luggagereturncopied]: {
          number: true,
        },
        [luggagepricecopied]: {
          number: true,
        },
      },
      messages: {
        [telcopied]: {
          number: "※半角数字で入力してください",
        },
        [luggagecountcopied]: {
          number: "※半角数字で入力してください",
        },
        [luggagereturncopied]: {
          number: "※半角数字で入力してください",
        },
        [luggagepricecopied]: {
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
      //送信前にLoadingを表示
      submitHandler: function (form) {
        $('.approval').addClass('hide');
        $('.loading').removeClass('hide');
        form.submit();
      }
    });
    $('input').on('blur', function () {
      $(this).valid();
      // if ($('span').hasClass('is-error')) {
      //   $('span').css('background', 'white');
      // }
    });
  }
})

// 一括仮押え 仲介会社 編集
$(function () {
  $("#multiplesAgentEdit").validate({
    rules: {
      cp_master_enduser_charge: {
        required: true,
      },
      cp_master_luggage_count: {
        number: true,
      },
      cp_master_luggage_return: {
        number: true,
      },
    },
    messages: {
      cp_master_enduser_charge: {
        required: '※必須項目です',
      },
      cp_master_luggage_count: {
        number: '※半角数字で入力してください',
      },
      cp_master_luggage_return: {
        number: '※半角数字で入力してください',
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
    //送信前にLoadingを表示
    submitHandler: function (form) {
      $('.spin_btn').removeClass('hide');
      $('.submit_btn').addClass('hide');
      form.submit();
    }
  });
  $('input').on('blur', function () {
    $(this).valid();
    // if ($('span').hasClass('is-error')) {
    //   $('span').css('background', 'white');
    // }
  });
})

// 一括仮押さえ　仲介会社 編集　タブ内　
$(function () {
  var target = $("input[name^='enduser_charge_copied']");

  for (let index = 0; index < target.length; index++) {
    var enduserchargecopied = "enduser_charge_copied" + index;
    var luggagecountcopied = "luggage_count_copied" + index;
    var luggagereturncopied = "luggage_return_copied" + index;
    var luggagepricecopied = "luggage_price_copied" + index;
    $("#multiplesAgentSpecificUpdateEdit" + index).validate({
      rules: {
        [enduserchargecopied]: {
          required: true,
        },
        [luggagecountcopied]: {
          number: true,
        },
        [luggagereturncopied]: {
          number: true,
        },
        [luggagepricecopied]: {
          number: true,
        },
      },
      messages: {
        [enduserchargecopied]: {
          required: "※必須項目です",
        },
        [luggagecountcopied]: {
          number: "※半角数字で入力してください",
        },
        [luggagereturncopied]: {
          number: "※半角数字で入力してください",
        },
        [luggagepricecopied]: {
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
      //送信前にLoadingを表示
      submitHandler: function (form) {
        $('.approval').addClass('hide');
        $('.loading').removeClass('hide');
        form.submit();
      }
    });
    $('input').on('blur', function () {
      $(this).valid();
      // if ($('span').hasClass('is-error')) {
      //   $('span').css('background', 'white');
      // }
    });
  }
})











// 予約新規作成
$(function () {
  $("#reservationCreateForm").validate({
    rules: {
      reserve_date: {
        required: true,
      },
      venue_id: {
        required: true,
      },
      price_system: {
        required: true,
      },
      enter_time: {
        required: true,
      },
      leave_time: {
        required: true,
      },
      user_id: {
        required: true,
      },
      in_charge: {
        required: true,
      },
      tel: {
        required: true,
        minlength: 10
      },
    },
    messages: {
      reserve_date: {
        required: "※必須項目です",
      },
      venue_id: {
        required: "※必須項目です",
      },
      price_system: {
        required: '※必須項目です',
      },
      enter_time: {
        required: "※必須項目です",
      },
      leave_time: {
        required: "※必須項目です",
      },
      user_id: {
        required: "※必須項目です",
      },
      in_charge: {
        required: "※必須項目です",
      },
      tel: {
        required: "※必須項目です",
        minlength: '※最低桁数は10です',

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
    //送信前にLoadingを表示
    submitHandler: function (form) {
      $('.spin_btn').removeClass('hide');
      $('.submit_btn').addClass('hide');
      form.submit();
    }
  });
  $('input').on('blur', function () {
    $(this).valid();
    // if ($('span').hasClass('is-error')) {
    //   $('span').css('background', 'white');
    // }
  });
})

// 仲介会社新規作成
$(function () {
  $("#agentReservationCreateForm").validate({
    rules: {
      name: {
        required: true,
      },
      post_code: {
        maxlength: 7
      },
      tel: {
        minlength: 10
      },
      email: {
        email: true
      },
      site_url: {
        url: true
      },
      login: {
        url: true
      },
      cost: {
        required: true,
        range: [1, 100]
      },
      cxl_url: {
        url: true
      },
      payment_limit: {
        required: true,
      },
      firstname_kana: {
        katakana: true,
      },
      lastname_kana: {
        katakana: true,
      },
    },
    messages: {
      name: {
        required: "※必須項目です",
      },
      post_code: {
        required: "※必須項目です",
        maxlength: '７桁で入力してください'
      },
      email: {
        email: '※Emailの形式で入力してください',
      },
      site_url: {
        url: '正しいURLを記入してください(例:https://osaka-conference.com/)'
      },
      login: {
        url: '正しいURLを記入してください(例:https://osaka-conference.com/)'
      },
      cxl_url: {
        url: '正しいURLを記入してください(例:https://osaka-conference.com/)'
      },
      payment_limit: {
        required: "※必須項目です",
      },
      cost: {
        required: "※必須項目です",
        range: "※1から100までの数値を入力してください"
      },
      firstname_kana: {
        katakana: "※カタカナで入力してください",
      },
      lastname_kana: {
        katakana: "※カタカナで入力してください",
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
    //送信前にLoadingを表示
    submitHandler: function (form) {
      $('.approval').addClass('hide');
      $('.loading').removeClass('hide');
      form.submit();
    }
  });
  $('input').on('blur', function () {
    $(this).valid();
  });
})


// 仲介会社　編集
$(function () {
  $("#agentReservationEditForm").validate({
    rules: {
      name: {
        required: true,
      },
      post_code: {
        maxlength: 7
      },
      tel: {
        minlength: 10
      },
      email: {
        email: true
      },
      site_url: {
        url: true
      },
      login: {
        url: true
      },
      cost: {
        required: true,
        range: [1, 100]
      },
      cxl_url: {
        url: true
      },
      payment_limit: {
        required: true,
      },
      firstname_kana: {
        katakana: true,
      },
      lastname_kana: {
        katakana: true,
      },

    },
    messages: {
      name: {
        required: "※必須項目です",
      },
      post_code: {
        required: "※必須項目です",
        maxlength: '７桁で入力してください'
      },
      email: {
        email: '※Emailの形式で入力してください',
      },
      site_url: {
        url: '正しいURLを記入してください(例:https://osaka-conference.com/)'
      },
      login: {
        url: '正しいURLを記入してください(例:https://osaka-conference.com/)'
      },
      cxl_url: {
        url: '正しいURLを記入してください(例:https://osaka-conference.com/)'
      },
      payment_limit: {
        required: "※必須項目です",
      },
      cost: {
        required: "※必須項目です",
        range: "※1から100までの数値を入力してください"
      },
      firstname_kana: {
        katakana: "カタカナで入力してください",
      },
      lastname_kana: {
        katakana: "カタカナで入力してください",
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
    //送信前にLoadingを表示
    submitHandler: function (form) {
      $('.approval').addClass('hide');
      $('.loading').removeClass('hide');
      form.submit();
    }
  });
  $('input').on('blur', function () {
    $(this).valid();
  });
})


// 会場管理　新規登録validation
$(function () {
  $("#VenuesCreateForm").validate({
    rules: {
      // smg_url: {
      //   required: true,
      //   url: true
      // },
      alliance_flag: {
        required: true,
      },
      name_area: {
        required: true,
      },
      name_bldg: {
        required: true,
      },
      name_venue: {
        required: true,
      },
      size1: {
        required: true,
        number: true,
        min: 0,
        max: 1000,
      },
      size2: {
        required: true,
        number: true,
        min: 0,
        max: 1000,

      },
      capacity: {
        required: true,
        number: true,
        min: 0,
      },
      post_code: {
        required: true,
        maxlength: 7
      },
      address1: {
        required: true,
      },
      address2: {
        required: true,
      },
      address3: {
        required: true,
      },
      luggage_flag: {
        required: true,
      },
      luggage_post_code: {
        // required: true,
        maxlength: 7
      },
      luggage_tel: {
        number: true,
      },
      person_tel: {
        number: true,
      },
      // luggage_address1: {
      //   required: true,
      // },
      // luggage_address2: {
      //   required: true,
      // },
      // luggage_address3: {
      //   required: true,
      // },
      // luggage_name: {
      //   required: true,
      // },
      // luggage_tel: {
      //   required: true,
      // },
      eat_in_flag: {
        required: true,
      },
      layout: {
        required: true,
      },
      person_email: {
        email: true,
      },
      first_name_kana: {
        katakana: true,
      },
      last_name_kana: {
        katakana: true,
      },
      mgmt_email: {
        email: true,
      },
      // mgmt_sec_company: {
      //   minlength: 10
      // },
      cost: {
        range: [1, 100]
      },
    },
    messages: {
      // smg_url: {
      //   required: "※必須項目です",
      //   url: '正しいURLを記入してください(例:https://osaka-conference.com/rental/t6-maronie/hall/)'
      // },
      alliance_flag: {
        required: "※必須項目です",
      },
      name_area: {
        required: "※必須項目です",
      },
      name_bldg: {
        required: "※必須項目です",
      },
      name_venue: {
        required: "※必須項目です",
      },
      size1: {
        required: "※必須項目です",
        number: "半角英数字を入力してください",
        min: "0以上を入力してください",
        max: '上限値は1000です',
      },
      size2: {
        required: "※必須項目です",
        number: "半角英数字を入力してください",
        min: "0以上を入力してください",
        max: '上限値は1000です',
      },
      capacity: {
        required: "※必須項目です",
        number: "数字を入力してください",
        min: "0以上を入力してください"
      },
      post_code: {
        required: "※必須項目です",
        maxlength: '７桁で入力してください'
      },
      address1: {
        required: "※必須項目です",
      },
      address2: {
        required: "※必須項目です",
      },
      address3: {
        required: "※必須項目です",
      },
      luggage_flag: {
        required: "※必須項目です",
      },
      luggage_post_code: {
        // required: "※必須項目です",
        maxlength: '７桁で入力してください'
      },
      luggage_tel: {
        number: '数字のみ入力してください'
      },
      luggage_post_code: {
        // required: "※必須項目です",
        maxlength: '７桁で入力してください'
      },
      // luggage_address1: {
      //   required: "※必須項目です",
      // },
      // luggage_address2: {
      //   required: "※必須項目です",
      // },
      // luggage_address3: {
      //   required: "※必須項目です",
      // },
      // luggage_name: {
      //   required: "※必須項目です",
      // },
      // luggage_tel: {
      //   required: "※必須項目です",
      // },
      eat_in_flag: {
        required: "※必須項目です",
      },
      layout: {
        required: "※必須項目です",
      },
      person_email: {
        email: '※Emailの形式で入力してください',
      },
      first_name_kana: {
        katakana: '※カタカナで入力してください',
      },
      last_name_kana: {
        katakana: '※カタカナで入力してください',
      },
      mgmt_email: {
        email: '※Emailの形式で入力してください',
      },
      cost: {
        range: "※1から100までの数値を入力してください"
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
    //送信前にLoadingを表示
    submitHandler: function (form) {
      $('.approval').addClass('hide');
      $('.loading').removeClass('hide');
      form.submit();
    }
  });
  $('input').on('blur', function () {
    $(this).valid();
    // if ($('span').hasClass('is-error')) {
    //   $('span').css('background', 'white');
    // }
  });
});




// 会場管理　編集画面validation
$(function () {
  $("#VenuesEditForm").validate({
    rules: {
      // smg_url: {
      //   required: true,
      //   url: true
      // },
      alliance_flag: {
        required: true,
      },
      name_area: {
        required: true,
      },
      name_bldg: {
        required: true,
      },
      name_venue: {
        required: true,
      },
      size1: {
        required: true,
        number: true,
        min: 0,
        max: 1000
      },
      size2: {
        required: true,
        number: true,
        min: 0,
        max: 1000
      },
      capacity: {
        required: true,
        number: true,
        min: 0
      },
      post_code: {
        required: true,
      },
      address1: {
        required: true,
      },
      address2: {
        required: true,
      },
      address3: {
        required: true,
      },
      luggage_flag: {
        required: true,
      },
      first_name_kana: {
        katakana: true,
      },
      last_name_kana: {
        katakana: true,
      },
      // luggage_post_code: {
      //   required: true,
      // },
      // luggage_address1: {
      //   required: true,
      // },
      // luggage_address2: {
      //   required: true,
      // },
      // luggage_address3: {
      //   required: true,
      // },
      // luggage_name: {
      //   required: true,
      // },
      // luggage_tel: {
      //   required: true,
      // },
      eat_in_flag: {
        required: true,
      },
      layout: {
        required: true,
      },
      mgmt_tel: {
        number: true,
      },
      mgmt_email: {
        email: true,
      },
      // mgmt_sec_company: {
      //   minlength: 10
      // },
      cost: {
        range: [1, 100]
      },
    },
    messages: {
      // smg_url: {
      //   required: "※必須項目です",
      //   url: '正しいURLを記入してください(例:https://osaka-conference.com/rental/t6-maronie/hall/)'
      // },
      alliance_flag: {
        required: "※必須項目です",
      },
      name_area: {
        required: "※必須項目です",
      },
      name_bldg: {
        required: "※必須項目です",
      },
      name_venue: {
        required: "※必須項目です",
      },
      size1: {
        required: "※必須項目です",
        number: "半角英数字を入力してください",
        min: "0以上を入力してください",
        max: "上限値は1000です"
      },
      size2: {
        required: "※必須項目です",
        number: "半角英数字を入力してください",
        min: "0以上を入力してください",
        max: "上限値は1000です"
      },
      capacity: {
        required: "※必須項目です",
        number: "数字を入力してください",
        min: "0以上を入力してください"
      },
      post_code: {
        required: "※必須項目です",
      },
      address1: {
        required: "※必須項目です",
      },
      address2: {
        required: "※必須項目です",
      },
      address3: {
        required: "※必須項目です",
      },
      luggage_flag: {
        required: "※必須項目です",
      },
      first_name_kana: {
        katakana: "※カタカナで入力してください",
      },
      last_name_kana: {
        katakana: "※カタカナで入力してください",
      },
      // luggage_post_code: {
      //   required: "※必須項目です",
      // },
      // luggage_address1: {
      //   required: "※必須項目です",
      // },
      // luggage_address2: {
      //   required: "※必須項目です",
      // },
      // luggage_address3: {
      //   required: "※必須項目です",
      // },
      // luggage_name: {
      //   required: "※必須項目です",
      // },
      // luggage_tel: {
      //   required: "※必須項目です",
      // },
      eat_in_flag: {
        required: "※必須項目です",
      },
      layout: {
        required: "※必須項目です",
      },
      cost: {
        range: "※1から100までの数値を入力してください"
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
    //送信前にLoadingを表示
    submitHandler: function (form) {
      $('.approval').addClass('hide');
      $('.loading').removeClass('hide');
      form.submit();
    }
  });
  $('input').on('blur', function () {
    $(this).valid();
    // if ($('span').hasClass('is-error')) {
    //   $('span').css('background', 'white');
    // }
  });
});



// 備品アップデート
// 会場管理　新規登録validation
$(function () {
  $("#EquipmentsUpdateForm").validate({
    rules: {
      item: {
        required: true,
      },
      price: {
        required: true,
      },
      stock: {
        required: true,
      },
    },
    messages: {
      item: {
        required: "※必須項目です",
      },
      price: {
        required: "※必須項目です",
      },
      stock: {
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
    //送信前にLoadingを表示
    submitHandler: function (form) {
      $('.approval').addClass('hide');
      $('.loading').removeClass('hide');
      form.submit();
    }
  });
  $('input').on('blur', function () {
    $(this).valid();
    // if ($('span').hasClass('is-error')) {
    //   $('span').css('background', 'white');
    // }
  });
});
// 顧客管理　新規作成
$(function () {
  $("#ClientsCreateForm").validate({
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
      mobile: {
        required: true,
      },
      email: {
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
        katakana: "※カタカナで入力してください",
      },
      last_name_kana: {
        required: "※必須項目です",
        katakana: "※カタカナで入力してください",
      },
      mobile: {
        required: "※必須項目です",
      },
      email: {
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
    //送信前にLoadingを表示
    submitHandler: function (form) {
      $('.approval').addClass('hide');
      $('.loading').removeClass('hide');
      form.submit();
    }
  });
  $('input').on('blur', function () {
    $(this).valid();
    // if ($('span').hasClass('is-error')) {
    //   $('span').css('background', 'white');
    // }
  });
});
// 顧客管理　編集
$(function () {
  $("#ClientsEditForm").validate({
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
      mobile: {
        required: true,
      },
      email: {
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
        katakana: "※カタカナで入力してください",
      },
      last_name_kana: {
        required: "※必須項目です",
        katakana: "※カタカナで入力してください",
      },
      mobile: {
        required: "※必須項目です",
      },
      email: {
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
    //送信前にLoadingを表示
    submitHandler: function (form) {
      $('.approval').addClass('hide');
      $('.loading').removeClass('hide');
      form.submit();
    }
  });
  $('input').on('blur', function () {
    $(this).valid();
    // if ($('span').hasClass('is-error')) {
    //   $('span').css('background', 'white');
    // }
  });
});



