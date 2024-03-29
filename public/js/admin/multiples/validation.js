// 案内板文字数制御
String.prototype.bytes = function () {
  var length = 0;
  for (var i = 0; i < this.length; i++) {
    var c = this.charCodeAt(i);
    if ((c >= 0x0 && c < 0x81) || (c === 0xf8f0) || (c >= 0xff61 && c < 0xffa0) || (c >= 0xf8f1 && c < 0xf8f4)) {
      length += 1;
    } else {
      length += 2;
    }
  }
  return length;
};

jQuery.validator.addMethod(
  "byte_check",
  function (value, element) {
    var target = value.bytes();
    var limit = 29;
    return this.optional(element) || target < limit;
  }
);
jQuery.validator.addMethod(
  "byte_check2",
  function (value, element) {
    var target = value.bytes();
    var limit = 54;
    return this.optional(element) || target < limit;
  }
);


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


// 顧客 一括仮押え切り替え
$(function () {
  $("#multiple_switch").validate({
    rules: {
      unknown_user_email: { email: true },
      unknown_user_mobile: { number: true, minlength: 11, maxlength: 11 },
      unknown_user_tel: { number: true, minlength: 10, maxlength: 10 },
      tel: { number: true, minlength: 11, maxlength: 11 },
      luggage_count: { number: true, range: [0, 49] },
      luggage_return: { number: true, range: [0, 49] },
      cost: { number: true, range: [1, 100] },
    },
    messages: {
      unknown_user_email: { email: "※Emailの形式で入力してください" },
      unknown_user_mobile: {
        number: "※半角数字を入力してください",
        minlength: "※11桁を入力して下さい",
        maxlength: "※11桁を入力して下さい",
      },
      unknown_user_tel: {
        number: "※半角数字を入力してください",
        minlength: "※10桁を入力して下さい",
        maxlength: "※10桁を入力して下さい",
      },
      tel: {
        number: "※半角数字を入力してください",
        minlength: "※11桁を入力して下さい",
        maxlength: "※11桁を入力して下さい",
      },
      luggage_count: {
        number: "半角数字で入力してください",
        range: "※最大値は49です",
      },
      luggage_return: {
        number: "半角数字で入力してください",
        range: "※最大値は49です",
      },
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
      $(".spin_btn").removeClass("hide");
      $(".submit_btn").addClass("hide");
      form.submit();
    },
  });
  $("input").on("blur", function () {
    $(this).valid();
  });
});


// 仲介会社 一括仮押え切り替え
$(function () {
  $("#multipleagent_switch").validate({
    rules: {
      end_user_tel: {
        number: true,
        minlength: 10,
        maxlength: 10,
      },
      end_user_mobile: {
        number: true,
        minlength: 11,
        maxlength: 11,
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
        minlength: "※10桁を入力して下さい",
        minlength: "※10桁を入力して下さい",
      },
      end_user_mobile: {
        number: "※半角数字を入力してください",
        minlength: "※11桁を入力して下さい",
        maxlength: "※11桁を入力して下さい",
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
  var target = ["#multipleEditForm", "#multipleCalculateForm"];
  $.each(target, function (index, value) {
    $(value).validate({
      rules: {
        cp_master_tel: { number: true, minlength: 11, maxlength: 11 },
        tel: { required: true, number: true, minlength: 11, maxlength: 11 },
        cp_master_luggage_count: { number: true, range: [0, 49] },
        cp_master_luggage_return: { number: true, range: [0, 49] },
        cp_master_luggage_price: { number: true },
        cp_master_cost: { number: true, range: [1, 100] },
        cp_master_event_name1: { byte_check: true },
        cp_master_event_name2: { byte_check: true },
        cp_master_event_owner: { byte_check2: true },
      },
      messages: {
        cp_master_tel: {
          number: "※半角数字を入力してください",
          minlength: "※11桁を入力して下さい",
          maxlength: "※11桁を入力して下さい",
        },
        unknown_user_tel: {
          number: "※半角数字を入力してください",
          minlength: "※10桁を入力して下さい",
          maxlength: "※10桁を入力して下さい",
        },
        in_charge: { required: "※必須項目です" },
        tel: {
          required: "※必須項目です",
          number: "※半角数字を入力してください",
          minlength: "※11桁を入力して下さい",
          maxlength: "※11桁を入力して下さい",
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
        cp_master_event_name1: { byte_check: "※文字数がオーバーしています" },
        cp_master_event_name2: { byte_check: "※文字数がオーバーしています" },
        cp_master_event_owner: { byte_check2: "※文字数がオーバーしています" },
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
  for (let index = 0; index < target.length; index++) {
    var telcopied = "tel_copied" + index;
    var luggagecountcopied = "luggage_count_copied" + index;
    var luggagereturncopied = "luggage_return_copied" + index;
    var eventname1copied = "event_name1_copied" + index;
    var eventname2copied = "event_name2_copied" + index;
    var eventownercopied = "event_owner" + index;
    $("#multipleSpecificUpdateForm" + index).validate({
      rules: {
        [telcopied]: {
          number: true,
          minlength: 11,
          maxlength: 11,
        },
        [luggagecountcopied]: {
          number: true,
          range: [0, 49],
        },
        [luggagereturncopied]: {
          number: true,
          range: [0, 49],
        },
        [eventname1copied]: {
          byte_check: true,
        },
        [eventname2copied]: {
          byte_check: true,
        },
        [eventownercopied]: {
          byte_check2: true,
        },
      },
      messages: {
        [telcopied]: {
          number: "※半角数字で入力してください",
          minlength: "※11桁を入力して下さい",
          maxlength: "※11桁を入力して下さい",
        },
        [luggagecountcopied]: {
          number: "※半角数字で入力してください",
          range: "※最大値は49です",
        },
        [luggagereturncopied]: {
          number: "※半角数字で入力してください",
          range: "※最大値は49です",
        },
        [eventname1copied]: {
          byte_check: "※文字数がオーバーしています",
        },
        [eventname2copied]: {
          byte_check: "※文字数がオーバーしています",
        },
        [eventownercopied]: {
          byte_check2: "※文字数がオーバーしています",
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
    var eventname1copied = "event_name1_copied" + index;
    var eventname2copied = "event_name2_copied" + index;
    var eventownercopied = "event_owner" + index;
    $("#multipleCalculateSpecificUpdateForm" + index).validate({
      rules: {
        [telcopied]: {
          number: true,
          minlength: 11,
          maxlength: 11,
        },
        [luggagecountcopied]: {
          number: true,
          range: [0, 49],
        },
        [luggagereturncopied]: {
          number: true,
          range: [0, 49],
        },
        [luggagepricecopied]: {
          number: true,
        },
        [eventname1copied]: {
          byte_check: true,
        },
        [eventname2copied]: {
          byte_check: true,
        },
        [eventownercopied]: {
          byte_check2: true,
        },
      },
      messages: {
        [telcopied]: {
          number: "※半角数字で入力してください",
          minlength: "※11桁を入力して下さい",
          maxlength: "※11桁を入力して下さい",
        },
        [luggagecountcopied]: {
          number: "※半角数字で入力してください",
          range: "※最大値は49です",
        },
        [luggagereturncopied]: {
          number: "※半角数字で入力してください",
          range: "※最大値は49です",
        },
        [luggagepricecopied]: {
          number: "※半角数字で入力してください",
        },
        [eventname1copied]: {
          byte_check: "※文字数がオーバーしています",
        },
        [eventname2copied]: {
          byte_check: "※文字数がオーバーしています",
        },
        [eventownercopied]: {
          byte_check2: "※文字数がオーバーしています",
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
        cp_master_end_user_charge: { required: true, number: true },
        cp_master_luggage_count: { number: true, range: [0, 49] },
        cp_master_luggage_return: { number: true, range: [0, 49] },
        cp_master_cost: { number: true, range: [1, 100] },
        cp_master_event_name1: { byte_check: true },
        cp_master_event_name2: { byte_check: true },
        cp_master_event_owner: { byte_check2: true },
      },
      messages: {
        cp_master_end_user_charge: {
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
        cp_master_event_name1: { byte_check: "※文字数がオーバーしています" },
        cp_master_event_name2: { byte_check: "※文字数がオーバーしています" },
        cp_master_event_owner: { byte_check2: "※文字数がオーバーしています" },
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
  var target = $("input[name^='end_user_charge_copied']");

  for (let index = 0; index < target.length; index++) {
    var enduserchargecopied = "end_user_charge_copied" + index;
    var luggagecountcopied = "luggage_count_copied" + index;
    var luggagereturncopied = "luggage_return_copied" + index;
    var luggagepricecopied = "luggage_price_copied" + index;
    var eventname1copied = "event_name1_copied" + index;
    var eventname2copied = "event_name2_copied" + index;
    var eventownercopied = "event_owner" + index;
    $("#multiplesAgentSpecificUpdateEdit" + index).validate({
      rules: {
        [enduserchargecopied]: {
          required: true,
          number: true,
        },
        [luggagecountcopied]: {
          number: true,
          range: [0, 49],
        },
        [luggagereturncopied]: {
          number: true,
          range: [0, 49],
        },
        [luggagepricecopied]: {
          number: true,
        },
        [eventname1copied]: {
          byte_check: true,
        },
        [eventname2copied]: {
          byte_check: true,
        },
        [eventownercopied]: {
          byte_check2: true,
        },
      },
      messages: {
        [enduserchargecopied]: {
          required: "※必須項目です",
          number: "※半角数字で入力してください",
        },
        [luggagecountcopied]: {
          number: "※半角数字で入力してください",
          range: "※最大値は49です",
        },
        [luggagereturncopied]: {
          number: "※半角数字で入力してください",
          range: "※最大値は49です",
        },
        [luggagepricecopied]: {
          number: "※半角数字で入力してください",
        },
        [eventname1copied]: {
          byte_check: "※文字数がオーバーしています",
        },
        [eventname2copied]: {
          byte_check: "※文字数がオーバーしています",
        },
        [eventownercopied]: {
          byte_check2: "※文字数がオーバーしています",
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

