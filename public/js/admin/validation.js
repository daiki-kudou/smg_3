// カタカナ
jQuery.validator.addMethod("katakana", function (value, element) {
  return this.optional(element) || /^([ァ-ヶー]+)$/.test(value);
}, "<br/>全角カタカナを入力してください"
);

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
        min: 1
      },
      cxl_url: {
        url: true
      },
      payment_limit: {
        required: true,
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
        min: "※最低でも1以上を入力してください"
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
        min: 1
      },
      cxl_url: {
        url: true
      },
      payment_limit: {
        required: true,
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
        min: "※最低でも1以上を入力してください"
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


// 会場管理　新規登録validation
$(function () {
  $("#VenuesCreateForm").validate({
    // errorClass: "validate_danger", //エラー表示classをbootstrapのアラートに変える
    rules: {
      smg_url: {
        required: true,
        url: true
      },
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
        min: 0
      },
      size2: {
        required: true,
        number: true,
        min: 0
      },
      capacity: {
        required: true,
        number: true,
        min: 0
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
        required: true,
        maxlength: 7
      },
      luggage_address1: {
        required: true,
      },
      luggage_address2: {
        required: true,
      },
      luggage_address3: {
        required: true,
      },
      luggage_name: {
        required: true,
      },
      luggage_tel: {
        required: true,
      },
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
      mgmt_sec_company: {
        minlength: 10
      },
    },
    messages: {
      smg_url: {
        required: "※必須項目です",
        url: '正しいURLを記入してください(例:https://osaka-conference.com/rental/t6-maronie/hall/)'
      },
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
        number: "数字を入力してください",
        min: "0以上を入力してください"
      },
      size2: {
        required: "※必須項目です",
        number: "数字を入力してください",
        min: "0以上を入力してください"
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
        required: "※必須項目です",
        maxlength: '７桁で入力してください'
      },
      luggage_address1: {
        required: "※必須項目です",
      },
      luggage_address2: {
        required: "※必須項目です",
      },
      luggage_address3: {
        required: "※必須項目です",
      },
      luggage_name: {
        required: "※必須項目です",
      },
      luggage_tel: {
        required: "※必須項目です",
      },
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




// 会場管理　編集画面validation
$(function () {
  $("#VenuesEditForm").validate({
    rules: {
      smg_url: {
        required: true,
        url: true
      },
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
        min: 0
      },
      size2: {
        required: true,
        number: true,
        min: 0
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
      luggage_post_code: {
        required: true,
      },
      luggage_address1: {
        required: true,
      },
      luggage_address2: {
        required: true,
      },
      luggage_address3: {
        required: true,
      },
      luggage_name: {
        required: true,
      },
      luggage_tel: {
        required: true,
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
      mgmt_sec_company: {
        minlength: 10
      },
    },
    messages: {
      smg_url: {
        required: "※必須項目です",
        url: '正しいURLを記入してください(例:https://osaka-conference.com/rental/t6-maronie/hall/)'
      },
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
        number: "数字を入力してください",
        min: "0以上を入力してください"
      },
      size2: {
        required: "※必須項目です",
        number: "数字を入力してください",
        min: "0以上を入力してください"
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
      luggage_post_code: {
        required: "※必須項目です",
      },
      luggage_address1: {
        required: "※必須項目です",
      },
      luggage_address2: {
        required: "※必須項目です",
      },
      luggage_address3: {
        required: "※必須項目です",
      },
      luggage_name: {
        required: "※必須項目です",
      },
      luggage_tel: {
        required: "※必須項目です",
      },
      eat_in_flag: {
        required: "※必須項目です",
      },
      layout: {
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
  });
  $('input').on('blur', function () {
    $(this).valid();
    // if ($('span').hasClass('is-error')) {
    //   $('span').css('background', 'white');
    // }
  });
});
