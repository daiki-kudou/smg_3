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

// 顧客新規登録、編集
$(function () {
  var target = ["#ClientsCreateForm", "#ClientsEditForm"];

  $.each(target, function (index, value) {
    $(value).validate({
      rules: {
        company: {
          required: true,
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
          minlength: 11,
          maxlength: 11,
          require_from_group: [1, ".phone_number"]
        },
        tel: {
          number: true,
          minlength: 10,
          maxlength: 10,
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
          required: "※必須項目です",
          number: "※半角数字、ハイフンなしで入力して下さい",
          minlength: "※7桁で入力してください",
          maxlength: "※7桁で入力してください",
        },
        address1: {
          required: "※必須項目です",
        },
        address2: {
          required: "※必須項目です",
        },
        url: {
          url:
            "正しいURLを記入してください(例:https://system.osaka-conference.com/)",
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
          number: "※半角数字、ハイフンなしで入力して下さい",
          minlength: "※11桁で入力してください",
          maxlength: "※11桁で入力してください",
          require_from_group: "携帯番号、電話番号のどちらか一方は必須です",
        },
        tel: {
          number: "※半角数字、ハイフンなしで入力して下さい",
          minlength: "※10桁で入力してください",
          maxlength: "※10桁で入力してください",
          require_from_group: "携帯番号、電話番号のどちらか一方は必須です",
        },
        fax: {
          number: "※半角数字、ハイフンなしで入力して下さい",
          minlength: "※10桁で入力してください",
        },
        email: {
          required: "※必須項目です",
          email: "※メールアドレスの形式で入力してください",
        },
        pay_post_code: {
          number: "※半角数字、ハイフンなしで入力して下さい",
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