$(function () {
  $("#loginForm").validate({
    rules: {
      email: {
        required: true,
        email: true
      },
      password: {
        required: true,
        minlength: 8
      },
    },
    messages: {
      email: {
        required: "※必須項目です",
        email: "※Eメールの形式で入力してください",
      },
      password: {
        required: "※必須項目です",
        minlength: "※パスワードは8文字以上です",
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
      $('#userFullOverlay').css('display', 'block');
      form.submit();
    }
  });
  $('input').on('blur', function () {
    $(this).valid();
  });
});
