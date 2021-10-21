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
        firstname_kana: { katakana: true },
        lastname_kana: { katakana: true },
        person_mobile: { minlength: 10, number: true },
      },
      messages: {
        name: { required: "※必須項目です" },
        post_code: {
          maxlength: "※7桁で入力してください",
          minlength: "※7桁で入力してください",
          number: "※半角数字、ハイフンなしで入力して下さい",
        },
        person_tel: {
          minlength: "最低桁数は10です",
          number: "※半角数字、ハイフンなしで入力して下さい",
        },
        fax: {
          minlength: "最低桁数は10です",
          number: "※半角数字、ハイフンなしで入力して下さい",
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
        firstname_kana: { katakana: "※全角カタカナで入力してください" },
        lastname_kana: { katakana: "※全角カタカナで入力してください" },
        person_mobile: {
          minlength: "最低桁数は10です",
          number: "※半角数字、ハイフンなしで入力して下さい",
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




