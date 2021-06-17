// カタカナ
jQuery.validator.addMethod(
  "katakana",
  function (value, element) {
    return this.optional(element) || /^([ァ-ヶー]+)$/.test(value);
  },
  "<br/>全角カタカナを入力してください"
);
// 半角カタカナと英数字
jQuery.validator.addMethod(
  "hankaku",
  function (value, element) {
    return this.optional(element) || /^[ｱ-ﾝﾞﾟｧ-ｫｬ-ｮｰ｡｢｣､a-zA-Z0-9()]+$/.test(value);
  },
);

jQuery.validator.addMethod(
  "alphanum",
  function (value, element) {
    return this.optional(element) || /^([a-zA-Z0-9]+)$/.test(value);
  },
  "<br/>※半角英数字を入力してください"
);

// 半角プラス記号
jQuery.validator.addMethod(
  "sign",
  function (value, element) {
    return this.optional(element) || /^([a-zA-Z0-9!@#$%^\[\\\]\&*()+-={};:?,._]+)$/.test(value);
  },
);

jQuery.validator.addMethod(
  "number",
  function (value, element) {
    return this.optional(element) || /^([0-9-]+)$/.test(value);
  },
);


// 有料備品の数字入力制限
$(function () {
  $(".equipment_validation").on("input", function (e) {
    let value = $(e.currentTarget).val();
    value = value
      .replace(/[０-９]/g, function (s) {
        return String.fromCharCode(s.charCodeAt(0) - 65248);
      })
      .replace(/[^0-9]/g, "");
    $(e.currentTarget).val(value);
  });
});

// その他の数字入力制限
$(function () {
  $("input[name*='others_input_cost']").on("input", function (e) {
    let value = $(e.currentTarget).val();
    value = value
      .replace(/[０-９]/g, function (s) {
        return String.fromCharCode(s.charCodeAt(0) - 65248);
      })
      .replace(/[^0-9]/g, "");
    $(e.currentTarget).val(value);
  });
});

// 数字入力制限
$(function () {
  $(".number_validation").on("input", function (e) {
    let value = $(e.currentTarget).val();
    value = value
      .replace(/[０-９]/g, function (s) {
        return String.fromCharCode(s.charCodeAt(0) - 65248);
      })
      .replace(/[^0-9]/g, "");
    $(e.currentTarget).val(value);
  });
});



//検索
$(function () {
  var target = ["#preserve_search", "#multiples_search"
    , "#clients_search", "#reserve_search"];
  $.each(target, function (index, value) {
    $(value).validate({
      rules: {
        multiple_id: { number: true },
        search_id: { number: true },
        search_mobile: { number: true },
        search_tel: { number: true },
        search_email: { sign: true },
        id: { number: true },
        mobile: { number: true },
        tel: { number: true },
      },
      messages: {
        multiple_id: { number: "※半角数字を入力してください" },
        search_id: { number: "※半角数字を入力してください" },
        search_mobile: { number: "※半角数字を入力してください" },
        search_tel: { number: "※半角数字を入力してください" },
        search_email: { sign: "※半角英数字を入力してください" },
        id: { number: "※半角数字を入力してください" },
        mobile: { number: "※半角数字を入力してください" },
        tel: { number: "※半角数字を入力してください" },
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


// 備品のカウントイッタン非表示
// $(function () {
//   var items = $(".equipment_breakdown");

//   for (var i=0; i<items.length; i++) {
//     console.log(i);

//     var equipment_breakdown = "equipment_breakdown" + i;
//     $("input[name='equipment_breakdown']").on("input", function (e) {
//       let value = $(e.currentTarget).val();
//       value = value
//         .replace(/[０-９]/g, function (s) {
//           return String.fromCharCode(s.charCodeAt(0) - 65248);
//         })
//         .replace(/[^0-9]/g, "");
//       $(e.currentTarget).val(value);
//     });

//   }


// });


// 備品アップデート
$(function () {
  $("#EquipmentsUpdateForm").validate({
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
      stock: {
        required: true,
        number: true,
        min: 1,
      },
    },
    messages: {
      item: {
        required: "※必須項目です",
      },
      price: {
        required: "※必須項目です",
        number: "※半角英数字で入力してください",
        min: "※1以上を入力してください",
        maxlength: '100,000円以内で入力してください',
      },
      stock: {
        required: "※必須項目です",
        number: "※半角英数字で入力してください",
        min: "※1以上を入力してください",
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
    // if ($('span').hasClass('is-error')) {
    //   $('span').css('background', 'white');
    // }
  });
});

// 顧客新規登録、編集
$(function () {
  var target = ["#ClientsCreateForm", "#ClientsEditForm"];

  $.each(target, function (index, value) {
    $(value).validate({
      // groups: {
      //   nameGroup : "mobile tel"
      // },
      rules: {
        company: {
          required: true,
        },
        post_code: {
          number: true,
          maxlength: 7,
          minlength: 7,
        },
        url: {
          url: true,
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
          number: true,
          minlength: 10,
          require_from_group: [1, ".phone_number"]
        },
        tel: {
          number: true,
          minlength: 10,
          require_from_group: [1, ".phone_number"]
        },

        fax: {
          number: true,
          minlength: 10,
        },
        email: {
          required: true,
          email: true,
        },
        pay_post_code: {
          number: true,
          maxlength: 7,
          minlength: 7,
        },
      },
      messages: {
        company: {
          required: "※必須項目です",
        },
        post_code: {
          number: "※半角数字で入力してください",
          minlength: "※7桁で入力してください",
          maxlength: "※7桁で入力してください",
        },
        url: {
          url:
            "正しいURLを記入してください(例:https://osaka-conference.com/)",
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
          number: "※半角数字で入力してください",
          minlength: "※10桁以上で入力してください",
          require_from_group: "携帯番号、電話番号のどちらか一方は必須です",
        },
        tel: {
          number: "※半角数字で入力してください",
          minlength: "※10桁以上で入力してください",
          require_from_group: "携帯番号、電話番号のどちらか一方は必須です",
        },
        fax: {
          number: "※半角数字で入力してください",
          minlength: "※10桁以上で入力してください",
        },
        email: {
          required: "※必須項目です",
          email: "※メールアドレスの形式で入力してください",
        },
        pay_post_code: {
          number: "※半角数字で入力してください",
          minlength: "※7桁で入力してください",
          maxlength: "※7桁で入力してください",
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
    $("input").on("blur input change", function () {
      $(this).valid();
    });
  });
});

// 一括仮押さえ一覧　検索
$(function () {
  $("#searchMultiple").validate({
    rules: {
      search_id: { number: true, min: 1 },
      search_mobile: { number: true, minlength: 11 },
      search_tel: { number: true, minlength: 10 },
    },
    messages: {
      search_id: {
        number: "※半角英数字で入力してください",
        min: "※0以上を入力してください",
      },
      search_mobile: {
        number: "※半角英数字で入力してください",
        minlength: "11桁で入力してください",
      },
      search_tel: {
        number: "※半角英数字で入力してください",
        minlength: "10桁で入力してください",
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
    // if ($('span').hasClass('is-error')) {
    //   $('span').css('background', 'white');
    // }
  });
});




// マイページvalidation

$(function () {
  var target = [
    "#mypageForm", "#mypageDone",
  ];

  $.each(target, function (index, value) {
    $(value).validate({
      rules: {
        in_charge: { required: true },
        tel: { required: true, number: true, minlength: 11 },
        luggage_count: { number: true, range: [0, 49] },
        luggage_return: { number: true, range: [0, 49] },
        luggage_price: { number: true },

      },
      messages: {
        in_charge: { required: "※必須項目です" },
        tel: {
          required: "※必須項目です",
          number: "※半角数字を入力してください",
          minlength: "※最低桁数は11です",
        },
        luggage_count: {
          number: "半角数字で入力してください",
          range: "※最大値は49です",
        },
        luggage_return: {
          number: "※半角数字で入力してください",
          range: "※最大値は49です",
        },
        luggage_price: {
          number: "※半角数字で入力してください",
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

