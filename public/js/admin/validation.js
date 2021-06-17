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


// キャンセル請求書
$(function () {
  var target = [
    "#cxlcalc", "#multi_calc",
    "#cxl_multicalc", "#multi_calc",
    "#cxl_edit", "#cxl_edit_calc",
  ];

  $.each(target, function (index, value) {
    $(value).validate({
      rules: {
        cxl_venue_PC: { number: true },
        cxl_equipment_PC: { number: true },
        cxl_layout_PC: { number: true },
        cxl_other_PC: { number: true },
        pay_person: { hankaku: true },
        payment: { number: true },
      },
      messages: {
        cxl_venue_PC: { number: "※半角数字を入力してください" },
        cxl_equipment_PC: { number: "※半角数字を入力してください" },
        cxl_layout_PC: { number: "※半角数字を入力してください" },
        cxl_other_PC: { number: "※半角数字を入力してください" },
        pay_person: { hankaku: "※半角ｶﾀｶﾅを入力してください" },
        payment: { number: "※半角数字を入力してください" },
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





// 仲介会社新規作成＆編集
$(function () {
  var target = ["#agentCreateForm", "#agentEditForm"];
  $.each(target, function (index, value) {
    $(value).validate({
      rules: {
        name: { required: true },
        post_code: { maxlength: 7, number: true, minlength: 7 },
        person_tel: { minlength: 10, number: true },
        fax: { minlength: 10, number: true },
        firstname_kana: { katakana: true },
        email: { email: true },
        site_url: { url: true },
        login: { url: true },
        cost: { required: true, range: [1, 100], maxlength: 3 },
        cxl_url: { url: true },
        payment_limit: { required: true },
        person_firstname: { required: true },
        person_lastname: { required: true },
        firstname_kana: { katakana: true },
        lastname_kana: { katakana: true },
        person_mobile: { minlength: 10, number: true },
      },
      messages: {
        name: { required: "※必須項目です" },
        post_code: {
          maxlength: "※7桁で入力してください",
          minlength: "※7桁で入力してください",
          number: "半角数字で入力してください",
        },
        person_tel: {
          minlength: "最低桁数は10です",
          number: "半角英数字で入力してください",
        },
        fax: {
          minlength: "最低桁数は10です",
          number: "半角英数字で入力してください",
        },
        email: { email: "※Emailの形式で入力してください" },
        site_url: {
          url:
            "正しいURLを記入してください(例:https://osaka-conference.com/)",
        },
        login: {
          url:
            "正しいURLを記入してください(例:https://osaka-conference.com/)",
        },
        cxl_url: {
          url:
            "正しいURLを記入してください(例:https://osaka-conference.com/)",
        },
        payment_limit: { required: "※必須項目です" },
        cost: {
          required: "※必須項目です",
          range: "※1から100までの半角英数字を入力してください",
          maxlength: "※最大桁数は3です",
        },
        person_firstname: { required: "※必須項目です" },
        person_lastname: { required: "※必須項目です" },
        firstname_kana: { katakana: "※全角カタカナで入力してください" },
        lastname_kana: { katakana: "※全角カタカナで入力してください" },
        person_mobile: {
          minlength: "最低桁数は10です",
          number: "半角英数字で入力してください",
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

// 会場管理　新規登録validation
$(function () {
  $("#VenuesCreateForm").validate({
    rules: {
      alliance_flag: { required: true },
      name_area: { required: true },
      name_bldg: { required: true },
      name_venue: { required: true },
      size1: { required: true, number: true, min: 0, max: 1000 },
      size2: { required: true, number: true, min: 0, max: 1000 },
      capacity: { required: true },
      post_code: { required: true, maxlength: 7, minlength: 7, number: true },
      address1: { required: true },
      address2: { required: true },
      address3: { required: true },
      luggage_flag: { required: true },
      luggage_post_code: { maxlength: 7, minlength: 7, number: true },
      person_tel: { number: true },
      eat_in_flag: { required: true },
      layout: { required: true },
      person_email: { email: true },
      first_name_kana: { katakana: true },
      last_name_kana: { katakana: true },
      mgmt_email: { email: true },
      mgmt_tel: { number: true },
      mgmt_emer_tel: { number: true },
      mgmt_person_tel: { number: true },
      mgmt_sec_tel: { number: true },
      cost: { required: true, range: [1, 100], maxlength: 3 },
      reserver_tel: { number: true },
    },
    messages: {
      alliance_flag: { required: "※必須項目です" },
      name_area: { required: "※必須項目です" },
      name_bldg: { required: "※必須項目です" },
      name_venue: { required: "※必須項目です" },
      size1: {
        required: "※必須項目です",
        number: "※半角英数字を入力してください",
        min: "0以上を入力してください",
        max: "上限値は1000です",
      },
      size2: {
        required: "※必須項目です",
        number: "※半角英数字を入力してください",
        min: "0以上を入力してください",
        max: "上限値は1000です",
      },
      capacity: { required: "※必須項目です" },
      post_code: {
        required: "※必須項目です",
        maxlength: "※7桁で入力してください",
        number: "※半角数字で入力してください",
        minlength: "※7桁で入力してください",
      },
      address1: { required: "※必須項目です" },
      address2: { required: "※必須項目です" },
      address3: { required: "※必須項目です" },
      luggage_flag: { required: "※必須項目です" },
      luggage_post_code: {
        minlength: "※7桁で入力してください",
        maxlength: "※7桁で入力してください",
        number: "※半角数字で入力してください",
      },
      person_tel: { number: "※半角英数字で入力してください" },
      eat_in_flag: { required: "※必須項目です" },
      layout: { required: "※必須項目です" },
      person_email: { email: "※Emailの形式で入力してください" },
      first_name_kana: { katakana: "※カタカナで入力してください" },
      last_name_kana: { katakana: "※カタカナで入力してください" },
      mgmt_email: { email: "※Emailの形式で入力してください" },
      mgmt_tel: { number: "※半角英数字で入力してください" },
      mgmt_emer_tel: { number: "※半角英数字で入力してください" },
      mgmt_person_tel: { number: "※半角英数字で入力してください" },
      mgmt_sec_tel: { number: "※半角英数字で入力してください" },
      cost: {
        required: "※必須項目です",
        range: "※1から100までの数値を入力してください",
        maxlength: "※最大桁数は3です",
      },
      reserver_tel: { number: "※半角英数字で入力してください" },
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
  $("input").on("click blur change", function () {
    $(this).valid();
  });

  // https://qiita.com/konnma/items/eb26651576e625b72805
  $(document).on("change", "#layout", function () {
    if ($('select[name="layout"] option:selected').val() == 1) {
      $("input[name='layout_prepare']").rules("add", {
        required: true,
        min: 1,
        messages: {
          required: "レイアウト変更が【可】の場合、必須項目です",
          min: "0以上を入力してください",
        },
      });
      $("input[name='layout_prepare']").prop("readonly", false);

      $("input[name='layout_clean']").rules("add", {
        required: true,
        min: 1,
        messages: {
          required: "レイアウト変更が【可】の場合、必須項目です",
          min: "0以上を入力してください",
        },
      });
      $("input[name='layout_clean']").prop("readonly", false);
    } else {
      // レイアウト準備
      $("input[name='layout_prepare']").rules("remove", "required");
      $("input[name='layout_prepare']")
        .parent()
        .parent()
        .find("p")
        .css("display", "none");
      $("input[name='layout_prepare']").val("");
      $("input[name='layout_prepare']").prop("readonly", true);
      // レイアウト片付け
      $("input[name='layout_clean']").rules("remove", "required");
      $("input[name='layout_clean']")
        .parent()
        .parent()
        .find("p")
        .css("display", "none");
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
        // number: true,
        // min: 0
      },
      post_code: {
        required: true,
        number: true,
        maxlength: 7,
        minlength: 7,
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
      cost: { required: true, range: [1, 100], maxlength: 3 },
      layout_prepare: {
        required: $("#layout").val() == 1,
        min: $("#layout").val() == 1,
      },
      layout_clean: {
        required: $("#layout").val() == 1,
        min: $("#layout").val() == 1,
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
      luggage_post_code: {
        number: true,
        maxlength: 7,
        minlength: 7,
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
        max: "上限値は1000です",
      },
      size2: {
        required: "※必須項目です",
        number: "※半角数字を入力してください",
        min: "0以上を入力してください",
        max: "上限値は1000です",
      },
      capacity: {
        required: "※必須項目です",
        // number: "※半角英数字を入力してください",
        // min: "0以上を入力してください"
      },
      post_code: {
        required: "※必須項目です",
        number: "※半角数字で入力してください",
        minlength: "※7桁で入力してください",
        maxlength: "※7桁で入力してください",
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
        email: "※メールアドレスの形式で入力してください",
      },
      eat_in_flag: {
        required: "※必須項目です",
      },
      layout: {
        required: "※必須項目です",
      },
      cost: {
        required: "※必須項目です",
        range: "※1から100までの数値を入力してください",
        maxlength: "※最大桁数は3です",
      },
      layout_prepare: {
        required: "レイアウト変更が【可】の場合、必須項目です",
        min: "0以上を入力してください",
      },
      layout_clean: {
        required: "レイアウト変更が【可】の場合、必須項目です",
        min: "0以上を入力してください",
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
      luggage_post_code: {
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
  $("input").on("blur", function () {
    $(this).valid();
    // if ($('span').hasClass('is-error')) {
    //   $('span').css('background', 'white');
    // }
  });
  // https://qiita.com/konnma/items/eb26651576e625b72805
  $(document).on("change", "#layout", function () {
    if ($('select[name="layout"] option:selected').val() == 1) {
      $("input[name='layout_prepare']").rules("add", {
        required: true,
        messages: {
          required: "レイアウト変更が【可】の場合、必須項目です",
        },
      });
      $("input[name='layout_clean']").rules("add", {
        required: true,
        messages: {
          required: "レイアウト変更が【可】の場合、必須項目です",
        },
      });
    } else {
      // レイアウト準備
      $("input[name='layout_prepare']").rules("remove", "required");
      $("input[name='layout_prepare']")
        .next()
        .children()
        .css("display", "none");
      $("input[name='layout_prepare']").val("");
      $("input[name='layout_prepare']").prop("readonly", true);
      // レイアウト片付け
      $("input[name='layout_clean']").rules("remove", "required");
      $("input[name='layout_clean']")
        .next()
        .children()
        .css("display", "none");
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

