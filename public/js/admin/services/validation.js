$(function () {
  $("#ServiceCreateForm").validate({
    rules: {
      item: {
        required: true,
      },
      price: {
        required: true,
        number: true,
        min: 1,
        maxlength: 6,
      },
    },
    messages: {
      item: {
        required: "※必須項目です",
        url: '正しいURLを記入してください(例:https://system.osaka-conference.com/rental/t6-maronie/hall/)'
      },
      price: {
        required: "※必須項目です",
        number: "※半角英数字で入力してください",
        min: "※1以上を入力してください",
        maxlength: "※100,000円以内で入力してください"
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


// サービスアップデート
$(function () {
  $("#ServiceUpdateForm").validate({
    rules: {
      item: {
        required: true,
      },
      price: {
        required: true,
        number: true,
        min: 1,
        maxlength: 6
      },
    },
    messages: {
      item: {
        required: "※必須項目です",
        url: '正しいURLを記入してください(例:https://system.osaka-conference.com/rental/t6-maronie/hall/)'
      },
      price: {
        required: "※必須項目です",
        number: "※数字を入力してください",
        min: "※1以上を入力してください",
        maxlength: '100,000円以内で入力してください',
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