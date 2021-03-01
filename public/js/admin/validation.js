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
