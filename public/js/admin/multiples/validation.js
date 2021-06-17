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


// 仲介会社 一括仮押え切り替え
$(function () {
  $("#multipleagent_switch").validate({
    rules: {
      end_user_tel: {
        number: true,
        minlength: 10,
      },
      end_user_mobile: {
        number: true,
        minlength: 11,
      },
      end_user_email: {
        email: true,
      },
      pre_enduser_attr: {
        required: true,
      },
    },
    messages: {
      end_user_tel: {
        number: "※半角数字を入力してください",
        minlength: "※最低桁数は10です",
      },
      end_user_mobile: {
        number: "※半角数字を入力してください",
        minlength: "※最低桁数は11です",
      },
      end_user_email: {
        email: "※Emailの形式で入力してください",
      },
      pre_enduser_attr: {
        required: "※必須項目です",
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
      $(".spin_btn").removeClass("hide");
      $(".submit_btn").addClass("hide");
      form.submit();
    },
  });
  $("input").on("blur", function () {
    $(this).valid();
  });
});


// 一括仮押さえ　編集＆再計算
$(function () {
  var target = ["#multipleEditForm", "multipleCalculateForm"];
  $.each(target, function (index, value) {
    $(value).validate({
      rules: {
        cp_master_tel: { number: true, minlength: 11 },
        tel: { required: true, number: true, minlength: 11 },
        cp_master_luggage_count: { number: true, range: [0, 49] },
        cp_master_luggage_return: { number: true, range: [0, 49] },
        cp_master_luggage_price: { number: true },
        cp_master_cost: { number: true, range: [1, 100] },
      },
      messages: {
        cp_master_tel: {
          number: "※半角数字を入力してください",
          minlength: "※最低桁数は11です",
        },
        unknown_user_tel: {
          number: "※半角数字を入力してください",
          minlength: "※最低桁数は10です",
        },
        in_charge: { required: "※必須項目です" },
        tel: {
          required: "※必須項目です",
          number: "※半角数字を入力してください",
          minlength: "※最低桁数は11です",
        },
        cp_master_luggage_count: {
          number: "半角数字で入力してください",
          range: "※最大値は49です",
        },
        cp_master_luggage_return: {
          number: "半角数字で入力してください",
          range: "※最大値は49です",
        },
        cp_master_luggage_price: {
          number: "半角数字で入力してください",
        },
        cp_master_cost: {
          number: "半角数字で入力してください",
          range: "※1から100までの数値を入力してください",
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

// 一括仮押さえ　編集画面　タブ内
$(function () {
  var target = $("input[name^='tel_copied']");
  // console.log(target);

  for (let index = 0; index < target.length; index++) {
    var telcopied = "tel_copied" + index;
    var luggagecountcopied = "luggage_count_copied" + index;
    var luggagereturncopied = "luggage_return_copied" + index;
    $("#multipleSpecificUpdateForm" + index).validate({
      rules: {
        [telcopied]: {
          number: true,
          minlength: 11,
        },
        [luggagecountcopied]: {
          number: true,
          range: [1, 49],
        },
        [luggagereturncopied]: {
          number: true,
          range: [1, 49],
        },
      },
      messages: {
        [telcopied]: {
          number: "※半角数字で入力してください",
          minlength: "※最低桁数は11です",
        },
        [luggagecountcopied]: {
          number: "※半角数字で入力してください",
          max: "※最大値は49です",
        },
        [luggagereturncopied]: {
          number: "※半角数字で入力してください",
          max: "※最大値は49です",
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
  }
});

// 一括仮押さえ　編集の計算　タブ内
$(function () {
  var target = $("input[name^='tel_copied']");

  for (let index = 0; index < target.length; index++) {
    var telcopied = "tel_copied" + index;
    var luggagecountcopied = "luggage_count_copied" + index;
    var luggagereturncopied = "luggage_return_copied" + index;
    var luggagepricecopied = "luggage_price_copied" + index;
    $("#multipleCalculateSpecificUpdateForm" + index).validate({
      rules: {
        [telcopied]: {
          number: true,
          minlength: 11,
        },
        [luggagecountcopied]: {
          number: true,
          range: [1, 49],
        },
        [luggagereturncopied]: {
          number: true,
          range: [1, 49],
        },
        [luggagepricecopied]: {
          number: true,
        },
      },
      messages: {
        [telcopied]: {
          number: "※半角数字で入力してください",
          minlength: "※最低桁数は11です",
        },
        [luggagecountcopied]: {
          number: "※半角数字で入力してください",
          max: "※最大値は49です",
        },
        [luggagereturncopied]: {
          number: "※半角数字で入力してください",
          max: "※最大値は49です",
        },
        [luggagepricecopied]: {
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
  }
});

// 一括仮押さえ　仲介会社 編集＆再計算
$(function () {
  var target = ["#multiplesAgentEdit"];
  $.each(target, function (index, value) {
    $(value).validate({
      rules: {
        cp_master_enduser_charge: { required: true, number: true },
        cp_master_luggage_count: { number: true, range: [0, 49] },
        cp_master_luggage_return: { number: true, range: [0, 49] },
        cp_master_cost: { number: true, range: [1, 100] },
      },
      messages: {
        cp_master_enduser_charge: {
          required: "※必須項目です",
          number: "半角数字で入力してください",
        },
        cp_master_luggage_count: {
          number: "半角数字で入力してください",
          range: "※最大値は49です",
        },
        cp_master_luggage_return: {
          number: "半角数字で入力してください",
          range: "※最大値は49です",
        },
        cp_master_cost: {
          number: "半角数字で入力してください",
          range: "※1から100までの数値を入力してください",
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

// 一括仮押さえ　仲介会社 編集　タブ内
$(function () {
  var target = $("input[name^='enduser_charge_copied']");

  for (let index = 0; index < target.length; index++) {
    var enduserchargecopied = "enduser_charge_copied" + index;
    var luggagecountcopied = "luggage_count_copied" + index;
    var luggagereturncopied = "luggage_return_copied" + index;
    var luggagepricecopied = "luggage_price_copied" + index;

    // console.log("enduserchargecopied");

    $("#multiplesAgentSpecificUpdateEdit" + index).validate({
      rules: {
        [enduserchargecopied]: {
          required: true,
          number: true,
        },
        [luggagecountcopied]: {
          number: true,
          range: [1, 49],
        },
        [luggagereturncopied]: {
          number: true,
          range: [1, 49],
        },
        [luggagepricecopied]: {
          number: true,
        },
      },
      messages: {
        [enduserchargecopied]: {
          required: "※必須項目です",
          number: "※半角数字で入力してください",
        },
        [luggagecountcopied]: {
          number: "※半角数字で入力してください",
          max: "※最大値は49です",
        },
        [luggagereturncopied]: {
          number: "※半角数字で入力してください",
          max: "※最大値は49です",
        },
        [luggagepricecopied]: {
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
  }
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
