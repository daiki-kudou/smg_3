// カタカナ
jQuery.validator.addMethod("katakana", function (value, element) {
  return this.optional(element) || /^([ァ-ヶー]+)$/.test(value);
}, "<br/>全角カタカナを入力してください"
);

jQuery.validator.addMethod("alphanum", function (value, element) {
  return this.optional(element) || /^([a-zA-Z0-9]+)$/.test(value);
}, "<br/>※半角英数字を入力してください"
);



// 仮押え新規作成
$(function () {
  $("#pre_reservationCreateForm").validate({
    rules: {
      user_id: { required: true },
      unknown_user_email: { email: true },
      unknown_user_mobile: { number: true, minlength: 11 },
      unknown_user_tel: { number: true, minlength: 10 },
      pre_date0: { required: true, },
      pre_venue0: { required: true, },
      pre_enter0: { required: true, },
      pre_leave0: { required: true, },
    },
    messages: {
      user_id: { required: "※必須項目です" },
      unknown_user_email: { email: '※Emailの形式で入力してください', },
      unknown_user_mobile: { number: '※半角数字を入力してください', minlength: '※最低桁数は11です', },
      unknown_user_tel: { number: '※半角数字を入力してください', minlength: '※最低桁数は10です', },
      pre_date0: { required: '※必須項目です', },
      pre_venue0: { required: '※必須項目です', },
      pre_enter0: { required: '※必須項目です', },
      pre_leave0: { required: '※必須項目です', },
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
});


// 仮押さえ　詳細＆再計算&編集&編集の再計算
$(function () {
  var target = ["#pre_reservationSingleCheckForm", "#pre_reservationSingleCalculateForm"
  ,"#pre_reservationSingleEditForm", "#pre_reservationSingleRecalculateForm"];
  $.each(target, function (index, value) {
    $(value).validate({
      rules: {
        unknown_user_email: { email: true },
        unknown_user_mobile: { number: true, minlength: 11 },
        unknown_user_tel: { number: true, minlength: 10 },

        in_charge: { required: true },
        tel: { required: true, number: true, minlength: 11},
        luggage_count: { max: 49, number: true },
        luggage_return: { max: 49, number: true },
      },
      messages: {
        unknown_user_email: { email: '※Emailの形式で入力してください', },
        unknown_user_mobile: { number: '※半角数字を入力してください', minlength: '※最低桁数は11です' },
        unknown_user_tel: { number: '※半角数字を入力してください', minlength: '※最低桁数は10です' },
        in_charge: { required: "※必須項目です"},
        tel: { required: "※必須項目です", number: '※半角数字を入力してください', minlength: '※最低桁数は11です'},
        luggage_count: { max: '※最大値は49です', number: "半角数字で入力してください" },
        luggage_return: { max: '※最大値は49です', number: "半角数字で入力してください" },
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
});


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
        number: '※半角数字を入力してください',
      },
      pre_enduser_mobile: {
        minlength: '※最低桁数は11です',
        number: '※半角数字を入力してください',
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
  });
})


// 仮押さえ　仲介会社詳細＆再計算&編集&編集の再計算
$(function () {
  var target = ["#pre_agent_reservationsSingleCheckForm", "#pre_agent_reservationsSingleCalculateForm"
  ,"#pre_agent_reservationSingleEditForm", "#pre_agent_reservationSingleEditForm"];
  $.each(target, function (index, value) {
    $(value).validate({
      rules: {
        enduser_charge: { required: true, number: true},
        luggage_count: { max: 49, number: true },
        luggage_return: { max: 49, number: true },
        pre_endusers_tel: {number: true, minlength: 10},
        pre_endusers_mobile: {number: true, minlength: 11},
        pre_endusers_email: {email: true},
      },
      messages: {
        enduser_charge: { required: "※必須項目です", number: '※半角数字を入力してください'},
        luggage_count: { max: '※最大値は49です', number: "半角数字で入力してください" },
        luggage_return: { max: '※最大値は49です', number: "半角数字で入力してください" },
        pre_endusers_tel: {minlength: '※最低桁数は10です',number: '※半角数字を入力してください'},
        pre_endusers_mobile: {minlength: '※最低桁数は11です',number: '※半角数字を入力してください'},
        pre_endusers_email: {email: '※Emailの形式で入力してください'},
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
});


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
        max: 49
      },
      cp_master_luggage_return: {
        number: true,
        max: 49
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
        max: "※最大値は49です",
      },
      cp_master_luggage_return: {
        number: '※半角数字を入力してください',
        max: "※最大値は49です",
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
          max: 49
        },
        [luggagereturncopied]: {
          number: true,
          max: 49
        },
      },
      messages: {
        [telcopied]: {
          number: "※半角数字で入力してください",
        },
        [luggagecountcopied]: {
          number: "※半角数字で入力してください",
          max: "※最大値は49です",
        },
        [luggagereturncopied]: {
          number: "※半角数字で入力してください",
          max: "※最大値は49です",
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
        max: 49
      },
      cp_master_luggage_return: {
        number: true,
        max: 49
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
        max: "※最大値は49です",
      },
      cp_master_luggage_return: {
        number: '※半角数字で入力してください',
        max: "※最大値は49です",
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
        max: 49
      },
      cp_master_luggage_return: {
        number: true,
        max: 49
      },
    },
    messages: {
      cp_master_enduser_charge: {
        required: '※必須項目です',
      },
      cp_master_luggage_count: {
        number: '※半角数字で入力してください',
        max: "※最大値は49です",
      },
      cp_master_luggage_return: {
        number: '※半角数字で入力してください',
        max: "※最大値は49です",
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
          max: 49
        },
        [luggagereturncopied]: {
          number: true,
          max: 49
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
          max: "※最大値は49です",
        },
        [luggagereturncopied]: {
          number: "※半角数字で入力してください",
          max: "※最大値は49です",
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
  });
})

// 仲介会社新規作成＆編集
$(function () {
  var target = ["#agentReservationCreateForm", "#agentEditForm"];
  $.each(target, function (index, value) {
    $(value).validate({
      rules: {
        name: { required: true, },
        post_code: { maxlength: 7, number: true },
        person_tel: { minlength: 10, number: true },
        fax: { minlength: 10, number: true },
        firstname_kana: { katakana: true },
        email: { email: true },
        site_url: { url: true },
        login: { url: true },
        cost: { required: true, range: [1, 100], maxlength: 3 },
        cxl_url: { url: true },
        payment_limit: { required: true, },
        firstname_kana: { katakana: true, },
        lastname_kana: { katakana: true, },
        person_mobile: { minlength: 10, number: true },
      },
      messages: {
        name: { required: "※必須項目です", },
        post_code: { maxlength: '７桁で入力してください', number: "半角英数字で入力してください" },
        person_tel: { minlength: "最低桁数は10です", number: "半角英数字で入力してください" },
        fax: { minlength: "最低桁数は10です", number: "半角英数字で入力してください" },
        email: { email: '※Emailの形式で入力してください', },
        site_url: { url: '正しいURLを記入してください(例:https://osaka-conference.com/)' },
        login: { url: '正しいURLを記入してください(例:https://osaka-conference.com/)' },
        cxl_url: { url: '正しいURLを記入してください(例:https://osaka-conference.com/)' },
        payment_limit: { required: "※必須項目です", },
        cost: { required: "※必須項目です", range: "※1から100までの半角英数字を入力してください", maxlength: "※最大桁数は3です" },
        firstname_kana: { katakana: "※全角カタカナで入力してください", },
        lastname_kana: { katakana: "※全角カタカナで入力してください", },
        person_mobile: { minlength: "最低桁数は10です", number: "半角英数字で入力してください" },

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
});



// 会場管理　新規登録validation
$(function () {
  $("#VenuesCreateForm").validate({
    rules: {
      alliance_flag: { required: true, },
      name_area: { required: true, },
      name_bldg: { required: true, },
      name_venue: { required: true, },
      size1: { required: true, number: true, min: 0, max: 1000, },
      size2: { required: true, number: true, min: 0, max: 1000, },
      capacity: { required: true },
      post_code: { required: true, maxlength: 7, number: true, },
      address1: { required: true, },
      address2: { required: true, },
      address3: { required: true, },
      luggage_flag: { required: true, },
      luggage_post_code: { maxlength: 7, number: true },
      person_tel: { number: true, },
      eat_in_flag: { required: true, },
      layout: { required: true, },
      person_email: { email: true, },
      first_name_kana: { katakana: true, },
      last_name_kana: { katakana: true, },
      mgmt_email: { email: true, },
      mgmt_tel: { number: true },
      mgmt_emer_tel: { number: true },
      mgmt_person_tel: { number: true },
      mgmt_sec_tel: { number: true },
      cost: { range: [1, 100] },
    },
    messages: {
      alliance_flag: { required: "※必須項目です", },
      name_area: { required: "※必須項目です", },
      name_bldg: { required: "※必須項目です", },
      name_venue: { required: "※必須項目です", },
      size1: { required: "※必須項目です", number: "※半角英数字を入力してください", min: "0以上を入力してください", max: '上限値は1000です', },
      size2: { required: "※必須項目です", number: "※半角英数字を入力してください", min: "0以上を入力してください", max: '上限値は1000です', },
      capacity: { required: "※必須項目です" },
      post_code: { required: "※必須項目です", maxlength: '７桁で入力してください', number: "※半角英数字で入力してください", },
      address1: { required: "※必須項目です", },
      address2: { required: "※必須項目です", },
      address3: { required: "※必須項目です", },
      luggage_flag: { required: "※必須項目です", },
      luggage_post_code: { maxlength: '７桁で入力してください', number: "※半角英数字で入力してください" },
      person_tel: { number: "※半角英数字で入力してください", },
      eat_in_flag: { required: "※必須項目です", },
      layout: { required: "※必須項目です", },
      person_email: { email: '※Emailの形式で入力してください', },
      first_name_kana: { katakana: '※カタカナで入力してください', },
      last_name_kana: { katakana: '※カタカナで入力してください', },
      mgmt_email: { email: '※Emailの形式で入力してください', },
      mgmt_tel: { number: "※半角英数字で入力してください" },
      mgmt_emer_tel: { number: "※半角英数字で入力してください" },
      mgmt_person_tel: { number: "※半角英数字で入力してください" },
      mgmt_sec_tel: { number: "※半角英数字で入力してください" },
      cost: { range: "※1から100までの数値を入力してください" },
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
  // https://qiita.com/konnma/items/eb26651576e625b72805
  $(document).on('change', '#layout', function () {
    if ($('select[name="layout"] option:selected').val() == 1) {
      $("input[name='layout_prepare']").rules("add", {
        required: true,
        messages: { required: "レイアウト変更が【可】の場合、必須項目です" },
      });
      $("input[name='layout_prepare']").prop("readonly", false);

      $("input[name='layout_clean']").rules("add", {
        required: true,
        messages: { required: "レイアウト変更が【可】の場合、必須項目です" },
      });
      $("input[name='layout_clean']").prop("readonly", false);

    } else {
      // レイアウト準備
      $("input[name='layout_prepare']").rules("remove", "required");
      $("input[name='layout_prepare']").parent().parent().find("p").css("display", "none");
      $("input[name='layout_prepare']").val("");
      $("input[name='layout_prepare']").prop("readonly", true);
      // レイアウト片付け
      $("input[name='layout_clean']").rules("remove", "required");
      $("input[name='layout_clean']").parent().parent().find("p").css("display", "none");
      $("input[name='layout_clean']").val("");
      $("input[name='layout_clean']").prop("readonly", true);
    }
  });
});




// 会場管理　編集画面validation
$(function () {
  $("#VenuesEditForm").validate({
    rules: {
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
        // number: true,
        // min: 0
      },
      post_code: {
        required: true,
        number: true
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
      person_tel: {
        number: true,
      },
      person_email: {
        email: true,
      },
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
      cost: {
        range: [1, 100]
      },
      layout_prepare: {
        required: $("#layout").val() == 1
      },
      layout_clean: {
        required: $("#layout").val() == 1
      },
      reserver_tel: {
        number: true,
      },
      reserver_fax: {
        number: true,
      },
      mgmt_person_tel: {
        number: true,
      },
      mgmt_emer_tel: {
        number: true,
      },
      mgmt_sec_tel: {
        number: true,
      },
    },
    messages: {
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
        number: "※半角数字を入力してください",
        min: "0以上を入力してください",
        max: "上限値は1000です"
      },
      size2: {
        required: "※必須項目です",
        number: "※半角数字を入力してください",
        min: "0以上を入力してください",
        max: "上限値は1000です"
      },
      capacity: {
        required: "※必須項目です",
        // number: "※半角英数字を入力してください",
        // min: "0以上を入力してください"
      },
      post_code: {
        required: "※必須項目です",
        number: "※半角数字で入力してください"
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
      person_tel: {
        number: "※半角数字で入力してください",
      },
      person_email: {
        email: '※メールアドレスの形式で入力してください',
      },
      eat_in_flag: {
        required: "※必須項目です",
      },
      layout: {
        required: "※必須項目です",
      },
      cost: {
        range: "※1から100までの数値を入力してください"
      },
      layout_prepare: {
        required: "レイアウト変更が【可】の場合、必須項目です"
      },
      layout_clean: {
        required: "レイアウト変更が【可】の場合、必須項目です"
      },
      reserver_tel: {
        number: "※半角数字で入力してください",
      },
      reserver_fax: {
        number: "※半角数字で入力してください",
      },
      mgmt_person_tel: {
        number: "※半角数字で入力してください",
      },
      mgmt_tel: {
        number: "※半角数字で入力してください",
      },
      mgmt_emer_tel: {
        number: "※半角数字で入力してください",
      },
      mgmt_sec_tel: {
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
  // https://qiita.com/konnma/items/eb26651576e625b72805
  $(document).on('change', '#layout', function () {
    if ($('select[name="layout"] option:selected').val() == 1) {
      $("input[name='layout_prepare']").rules("add", {
        required: true,
        messages: { required: "レイアウト変更が【可】の場合、必須項目です" },
      })
      $("input[name='layout_clean']").rules("add", {
        required: true,
        messages: { required: "レイアウト変更が【可】の場合、必須項目です" },
      })
    } else {
      // レイアウト準備
      $("input[name='layout_prepare']").rules("remove", "required");
      $("input[name='layout_prepare']").next().children().css("display", "none");
      $("input[name='layout_prepare']").val("");
      $("input[name='layout_prepare']").prop("readonly", true);
      // レイアウト片付け
      $("input[name='layout_clean']").rules("remove", "required");
      $("input[name='layout_clean']").next().children().css("display", "none");
      $("input[name='layout_clean']").val("");
      $("input[name='layout_clean']").prop("readonly", true);

    }
    console.log("test");
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
        number: true,
        minlength: 10,
      },
      tel: {
        number: true,
        minlength: 10,
      },
      fax: {
        number: true,
        minlength: 10,
      },
      email: {
        required: true,
        email: true
      },
      pay_post_code: {
        number: true
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
        number: '※半角英数字で入力してください',
        minlength: '※10桁以上で入力してください',
      },
      tel: {
        number: '※半角英数字で入力してください',
        minlength: '※10桁以上で入力してください',
      },
      fax: {
        number: '※半角英数字で入力してください',
        minlength: '※10桁以上で入力してください',
      },
      email: {
        required: "※必須項目です",
        email: '※メールアドレスの形式で入力してください'
      },
      pay_post_code: {
        number: '※半角英数字で入力してください',
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

// 料金管理　編集(枠貸し)
// $(function () {
//   $("#FramePriceCreateForm").validate({
//     rules: {
//       company: {
//         required: true,
//       },
//     },
//     messages: {
//       company: {
//         required: "※必須項目です",
//       },
//     },
//     errorPlacement: function (error, element) {
//       var name = element.attr('name');
//       if (element.attr('name') === 'category[]') {
//         error.appendTo($('.is-error-category'));
//       } else if (element.attr('name') === name) {
//         error.appendTo($('.is-error-' + name));
//       }
//     },
//     errorElement: "span",
//     errorClass: "is-error",
//     //送信前にLoadingを表示
//     submitHandler: function (form) {
//       $('.approval').addClass('hide');
//       $('.loading').removeClass('hide');
//       form.submit();
//     }
//   });
//   $('input').on('blur', function () {
//     $(this).valid();
//   });
// });


