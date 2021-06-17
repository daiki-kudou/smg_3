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


// 仲介会社 仮押え登録
$(function () {
  $("#pre_agent_reservationsCreateForm").validate({
    rules: {
      agent_id: {
        required: true,
      },
      pre_enduser_tel: {
        number: true,
        minlength: 10,
      },
      pre_enduser_mobile: {
        number: true,
        minlength: 11,
      },
      pre_enduser_email: {
        email: true,
      },
      pre_enduser_attr: {
        required: true,
      },
      pre_date0: { required: true },
      pre_venue0: { required: true },
      pre_enter0: { required: true },
      pre_leave0: { required: true },
    },
    messages: {
      agent_id: {
        required: "※必須項目です",
      },
      pre_enduser_tel: {
        minlength: "※最低桁数は10です",
        number: "※半角数字を入力してください",
      },
      pre_enduser_mobile: {
        minlength: "※最低桁数は11です",
        number: "※半角数字を入力してください",
      },
      pre_enduser_email: {
        email: "※Emailの形式で入力してください",
      },
      pre_enduser_attr: {
        required: "※必須項目です",
      },
      pre_date0: { required: "※必須項目です" },
      pre_venue0: { required: "※必須項目です" },
      pre_enter0: { required: "※必須項目です" },
      pre_leave0: { required: "※必須項目です" },
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
      $(".spin_btn").removeClass("hide");
      $(".submit_btn").addClass("hide");
      form.submit();
    },
  });
  $("input").on("blur", function () {
    $(this).valid();
  });
});

// 仮押さえ　仲介会社詳細＆再計算&編集&編集の再計算
$(function () {
  var target = [
    "#pre_agent_reservationsSingleCheckForm",
    "#pre_agent_reservationsSingleCalculateForm",
    "#pre_agent_reservationSingleEditForm",
    "#pre_agent_reservationSingleEditForm",
  ];

  $.each(target, function (index, value) {
    $(value).validate({
      rules: {
        enduser_charge: { required: true, number: true },
        luggage_count: { number: true, range: [1, 49] },
        luggage_return: { number: true, range: [1, 49] },
        pre_enduser_tel: { number: true, minlength: 10 },
        pre_enduser_mobile: { number: true, minlength: 11 },
        pre_enduser_email: { email: true },
        pre_enduser_attr: { required: true },
        pre_endusers_tel: { number: true, minlength: 10 },
        pre_endusers_mobile: { number: true, minlength: 11 },
        pre_endusers_email: { email: true },
        pre_endusers_attr: { required: true },
        cost: { number: true, range: [1, 100] },
      },
      messages: {
        enduser_charge: {
          required: "※必須項目です",
          number: "※半角数字を入力してください",
        },
        luggage_count: {
          number: "半角数字で入力してください",
          range: "※最大値は49です",
        },
        luggage_return: {
          number: "半角数字で入力してください",
          range: "※最大値は49です",
        },
        pre_enduser_tel: {
          minlength: "※最低桁数は10です",
          number: "※半角数字を入力してください",
        },
        pre_enduser_mobile: {
          minlength: "※最低桁数は11です",
          number: "※半角数字を入力してください",
        },
        pre_enduser_email: { email: "※Emailの形式で入力してください" },
        pre_enduser_attr: { required: "※必須項目です" },
        pre_endusers_tel: {
          minlength: "※最低桁数は10です",
          number: "※半角数字を入力してください",
        },
        pre_endusers_mobile: {
          minlength: "※最低桁数は11です",
          number: "※半角数字を入力してください",
        },
        pre_endusers_email: { email: "※Emailの形式で入力してください" },
        pre_endusers_attr: { required: "※必須項目です" },
        cost: {
          number: "半角数字で入力してください",
          range: "※1から100までの半角英数字を入力してください",
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