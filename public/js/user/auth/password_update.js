$(function () {
  $("#password_reset_form").validate({
    rules: {
      email: {
        required: true,
        email: true
      },
      password: {
        required: true,
        minlength: 6,
        maxlength: 20
      },
      password_confirmation: {
        required: true,
        minlength: 6,
        maxlength: 20,
        equalTo: "#inputPassword"
      },
    },
    messages: {
      email: {
        required: "※必須項目です",
        email: "※Eメールの形式で入力してください",
      },
      password: {
        required: "※必須項目です",
        minlength: "※パスワードは6文字以上です",
        maxlength: "※パスワードは最大20文字です",
      },
      password_confirmation: {
        required: "※必須項目です",
        minlength: "※パスワードは6文字以上です",
        maxlength: "※パスワードは最大20文字です",
        equalTo: "※パスワードが一致しません",
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
