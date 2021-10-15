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

// 会場管理　新規登録validation
$(function () {
  $("#VenuesCreateForm").validate({
    rules: {
      alliance_flag: { required: true },
      name_area: { required: true },
      name_bldg: { required: true },
      name_venue: { required: true },
      size1: {
        required: true,
        // number: true, 
        min: 0,
        max: 1000
      },
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
      layout_prepare: {
        required: $("#layout").val() == 1,
        min: $("#layout").val() == 1,
      },
      layout_clean: {
        required: $("#layout").val() == 1,
        min: $("#layout").val() == 1,
      },
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
        // number: "※半角英数字を入力してください",
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
      person_tel: { number: "※半角数字、ハイフンなしで入力して下さい" },
      eat_in_flag: { required: "※必須項目です" },
      layout_prepare: {
        required: "レイアウト変更が【可】の場合、必須項目です",
        min: "0以上を入力してください",
      },
      layout_clean: {
        required: "レイアウト変更が【可】の場合、必須項目です",
        min: "0以上を入力してください",
      },
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
        // number: true,
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
        // number: "※半角数字を入力してください",
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



