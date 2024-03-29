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


// 予約登録、編集　仲介会社経由も含む
$(function () {
  var target = [
    "#reservationCreateForm", "#reservations_calculate_form",
    "#reservations_edit", "#edit_calculate",
    "#edit_check", "#edit_calculate",
  ];

  $.each(target, function (index, value) {
    $(value).validate({
      rules: {
        reserve_date: { required: true,byte_check:true },
        venue_id: { required: true },
        price_system: { required: true },
        enter_time: { required: true },
        leave_time: { required: true },
        event_name1: { byte_check: true },
        event_name2: { byte_check: true },
        event_owner: { byte_check2: true },
        user_id: { required: true },
        agent_id: { required: true },
        in_charge: { required: true },
        tel: { required: true, number: true, maxlength: 11, minlength: 11 },
        luggage_count: { number: true, range: [0, 49] },
        luggage_return: { number: true, range: [0, 49] },
        luggage_price: { number: true },
        cost: { number: true, range: [0, 100] },
        venue_number_discount: { number: true },
        venue_percent_discount: { number: true },
        equipment_number_discount: { number: true },
        equipment_percent_discount: { number: true },
        layout_number_discount: { number: true },
        layout_percent_discount: { number: true },
        others_number_discount: { number: true },
        others_percent_discount: { number: true },
        pay_person: { hankaku: true },
        payment: { number: true },
        venue_price: { required: true },
      },
      messages: {
        reserve_date: { required: "※必須項目です"},
        venue_id: { required: "※必須項目です" },
        price_system: { required: "※必須項目です" },
        enter_time: { required: "※必須項目です" },
        leave_time: { required: "※必須項目です" },
        event_name1: { byte_check: "※文字数がオーバーしています" },
        event_name2: { byte_check: "※文字数がオーバーしています" },
        event_owner: { byte_check2: "※文字数がオーバーしています" },
        user_id: { required: "※必須項目です" },
        in_charge: { required: "※必須項目です" },
        tel: {
          required: "※必須項目です",
          number: "※半角数字、ハイフンなしで入力して下さい",
          maxlength: "※11桁を入力して下さい",
          minlength: "※11桁を入力して下さい",
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
        cost: {
          number: "※半角数字で入力してください",
          range: "※1から100までの数字を入力してください",
        },
        venue_number_discount: { number: "※半角数字を入力してください" },
        venue_percent_discount: { number: "※半角数字を入力してください" },
        equipment_number_discount: { number: "※半角数字を入力してください" },
        equipment_percent_discount: { number: "※半角数字を入力してください" },
        layout_number_discount: { number: "※半角数字を入力してください" },
        layout_percent_discount: { number: "※半角数字を入力してください" },
        others_number_discount: { number: "※半角数字を入力してください" },
        others_percent_discount: { number: "※半角数字を入力してください" },
        pay_person: { hankaku: "※半角ｶﾀｶﾅを入力してください" },
        payment: { number: "※半角数字を入力してください" },
        venue_price: { required: "※料金を入力してください" },
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
    $("input").on("blur change", function () {
      $(this).valid();
    });
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
        master_subtotal: { required: true },
        master_tax: { required: true },
        master_total: { required: true },
        pay_person: { hankaku: true },
        payment: { number: true },
        end_user_charge: { required: true },
      },
      messages: {
        master_subtotal: { required: "※金額を入力してください" },
        master_tax: { required: "※金額を入力してください" },
        master_total: { required: "※金額を入力してください" },
        pay_person: { hankaku: "※半角ｶﾀｶﾅを入力してください" },
        payment: { number: "※半角数字を入力してください" },
        end_user_charge: { required: "※金額を入力してください" },
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


// 料金体系がない場合のvalidation
$(function () {
  var target = [
    "#reservations_edit_result",
  ];

  $.each(target, function (index, value) {
    $(value).validate({
      rules: {
        venue_price: {
          required: true
        },
      },
      messages: {
        venue_price: {
          required: "※金額を入力してください"
        }
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



