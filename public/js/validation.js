// カタカナ
jQuery.validator.addMethod("katakana", function (value, element) {
  return this.optional(element) || /^([ァ-ヶー]+)$/.test(value);
}, "<br/>全角カタカナを入力してください"
);






$(function () {
  $("#ServiceCreateForm").validate({
    rules: {
      item: {
        required: true,
      },
      price: {
        required: true,
        number: true
      },
      stock: {
        required: true,
        number: true
      },
    },
    messages: {
      item: {
        required: "※必須項目です",
        url: '正しいURLを記入してください(例:https://osaka-conference.com/rental/t6-maronie/hall/)'
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
        number: true
      },
      stock: {
        required: true,
        number: true
      },
    },
    messages: {
      item: {
        required: "※必須項目です",
        url: '正しいURLを記入してください(例:https://osaka-conference.com/rental/t6-maronie/hall/)'
      },
      price: {
        required: "※必須項目です",
        number: "※数字を入力してください"
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
  });
})
// 備品作成
$(function () {
  $("#EquipmentsCreateForm").validate({
    rules: {
      item: {
        required: true,
      },
      price: {
        required: true,
        number: true
      },
      stock: {
        required: true,
        number: true
      },
    },
    messages: {
      item: {
        required: "※必須項目です",
        url: '正しいURLを記入してください(例:https://osaka-conference.com/rental/t6-maronie/hall/)'
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
// // 備品アップデート
// // 会場管理　新規登録validation
// $(function () {
//   $("#EquipmentsUpdateForm").validate({
//     rules: {
//       item: {
//         required: true,
//       },
//       price: {
//         required: true,
//         number: true
//       },
//       stock: {
//         required: true,
//         number: true
//       },
//     },
//     messages: {
//       item: {
//         required: "※必須項目です",
//         url: '正しいURLを記入してください(例:https://osaka-conference.com/rental/t6-maronie/hall/)'
//       },
//       price: {
//         required: "※必須項目です",
//       },
//       stock: {
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
//   });
//   $('input').on('blur', function () {
//     $(this).valid();
//     // if ($('span').hasClass('is-error')) {
//     //   $('span').css('background', 'white');
//     // }
//   });
// });


// 料金管理　編集
$(function () {
  $("#dateCreateForm").validate({
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
  $("input[name^='frame']").each(function (index, elem) {

    $("input[name='frame" + index + "']").rules("add", {
      required: true,
      messages: {
        required: "※必須項目です",
      }
    });
  });
  $("input[name^='price']").each(function (index, elem) {
    $("input[name='price" + index + "']").rules("add", {
      required: true,
      number: true,
      messages: {
        required: "※必須項目です",
        number: "※半角英数字を入力してください"
      }
    });
  });
  // $("input[name='extend").rules("add", {
  //   required: true,
  //   number: true,
  //   messages: {
  //     required: "※必須項目です",
  //     number: "※半角英数字を入力してください"
  //   }
  // });


});



// 料金管理　編集
$(function () {
  $("#timeEditForm").validate({
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
  $("input[name^='time']").each(function (index, elem) {
    $("input[name='time" + index + "']").rules("add", {
      required: true,
      messages: {
        required: "※必須項目です",
      }
    });
  });
  $("input[name^='price']").each(function (index, elem) {
    $("input[name='price" + index + "']").rules("add", {
      required: true,
      number: true,
      messages: {
        required: "※必須項目です",
        number: "※半角英数字を入力してください"
      }
    });
  });
  $("input[name^='extend']").each(function (index, elem) {
    $("input[name='extend" + index + "']").rules("add", {
      required: true,
      number: true,
      messages: {
        required: "※必須項目です",
        number: "※半角英数字を入力してください"
      }
    });
  });


});


// 予約新規登録
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
