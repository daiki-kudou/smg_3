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
    if ($('span').hasClass('is-error')) {
      $('span').css('background', 'white');
    }
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
    if ($('span').hasClass('is-error')) {
      $('span').css('background', 'white');
    }
  });
});


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
  });
  $('input').on('blur', function () {
    $(this).valid();
    if ($('span').hasClass('is-error')) {
      $('span').css('background', 'white');
    }
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
  });
  $('input').on('blur', function () {
    $(this).valid();
    if ($('span').hasClass('is-error')) {
      $('span').css('background', 'white');
    }
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
  });
  $('input').on('blur', function () {
    $(this).valid();
    if ($('span').hasClass('is-error')) {
      $('span').css('background', 'white');
    }
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
  });
  $('input').on('blur', function () {
    $(this).valid();
    if ($('span').hasClass('is-error')) {
      $('span').css('background', 'white');
    }
  });
});


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
    if ($('span').hasClass('is-error')) {
      $('span').css('background', 'white');
    }
  });
  $("input[name^='frame']").each( function( index, elem ) {
    console.log(index);
      $("input[name='frame"+index+"']").rules( "add", {
    required: true,
    messages: {
      required: "※必須項目です",
    }
  });
  });
  $("input[name^='price']").each( function( index, elem ) {
    console.log(index);
      $("input[name='price"+index+"']").rules( "add", {
    required: true,
    number: true,
    messages: {
      required: "※必須項目です",
      number:"※半角英数字を入力してください"
    }
  });
  });
      $("input[name='extend").rules( "add", {
    required: true,
    number: true,
    messages: {
      required: "※必須項目です",
      number:"※半角英数字を入力してください"
    }
  });


});