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

// 追加請求書
$(function () {
  var target = [
    "#billsCreateForm", "#billsEditForm",
  ];

  $.each(target, function (index, value) {
    $(value).validate({
      rules: {
        // venue_number_discount: { number: true },
        // venue_percent_discount: { number: true },
        // equipment_number_discount: { number: true },
        // equipment_percent_discount: { number: true },
        // layout_number_discount: { number: true },
        // layout_percent_discount: { number: true },
        // others_number_discount: { number: true },
        // others_percent_discount: { number: true },
        master_subtotal: { required: true },
        master_tax: { required: true },
        master_total: { required: true },
        pay_person: { hankaku: true },
        payment: { number: true },
        enduser_charge: { required: true },
      },
      messages: {
        // venue_number_discount: { number: "※半角数字を入力してください" },
        // venue_percent_discount: { number: "※半角数字を入力してください" },
        // equipment_number_discount: { number: "※半角数字を入力してください" },
        // equipment_percent_discount: { number: "※半角数字を入力してください" },
        // layout_number_discount: { number: "※半角数字を入力してください" },
        // layout_percent_discount: { number: "※半角数字を入力してください" },
        // others_number_discount: { number: "※半角数字を入力してください" },
        // others_percent_discount: { number: "※半角数字を入力してください" },
        master_subtotal: { required: "※金額を入力してください" },
        master_tax: { required: "※金額を入力してください" },
        master_total: { required: "※金額を入力してください" },
        pay_person: { hankaku: "※半角ｶﾀｶﾅを入力してください" },
        payment: { number: "※半角数字を入力してください" },
        enduser_charge: { required: "※金額を入力してください" },
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

// 仲介会社追加請求書
$(function () {
  var target = [
    "#agentsbillsCreateForm",
    "#agentsbillsEditForm",
  ];

  $.each(target, function (index, value) {
    $(value).validate({
      rules: {
        venue_breakdown_count: { number: true },
        pay_person: { hankaku: true },
        payment: { number: true },
        enduser_charge: { required: true, number: true },
      },
      messages: {
        venue_breakdown_count: { number: "※半角数字を入力してください" },
        pay_person: { hankaku: "※半角ｶﾀｶﾅを入力してください" },
        payment: { number: "※半角数字を入力してください" },
        enduser_charge: { 
          required: "※金額を入力してください",
          number: "※半角数字を入力してください" 
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




