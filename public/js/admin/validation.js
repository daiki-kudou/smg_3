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



// ロード時の、案内板入力制御
$(document).ready(function () {
  $("#no_board_flag:checked").each(function () {
    var flag = $(this);
    if ($(flag).is(":checked") != null) {
      $("#event_start").prop("readonly", true);
      $("#event_finish").prop("readonly", true);
      $("#eventname1Count").prop("readonly", true);
      $("#eventname2Count").prop("readonly", true);
      $("#eventownerCount").prop("readonly", true);
      // $(".board-table input[type='text']").val("");
      $(".board-table option:selected").val("");
    }
  });
});

// ラジオボタンクリック時の案内板入力制御
$(function () {
  $('input[name="board_flag"]').change(function () {
    var prop = $("#no_board_flag").prop("checked");
    if (prop) {
      $("#event_start").prop("readonly", true);
      $("#event_finish").prop("readonly", true);
      $("#eventname1Count").prop("readonly", true);
      $("#eventname2Count").prop("readonly", true);
      $("#eventownerCount").prop("readonly", true);
      $(".board-table input[type='text']").val("");
    } else {
      $("#event_start").prop("readonly", false);
      $("#event_finish").prop("readonly", false);
      $("#eventname1Count").prop("readonly", false);
      $("#eventname2Count").prop("readonly", false);
      $("#eventownerCount").prop("readonly", false);
    }
  });
});

// 一括ロード時の、案内板入力制御
$(document).ready(function () {
  $("#cp_master_board_no_board_flag:checked").each(function () {
    var flag = $(this);
    if ($(flag).is(":checked") != null) {
      $("#cp_master_event_start").prop("readonly", true);
      $("#cp_master_event_finish").prop("readonly", true);
      $("#eventname1Count").prop("readonly", true);
      $("#eventname2Count").prop("readonly", true);
      $("#eventownerCount").prop("readonly", true);
      // $(".board-table input[type='text']").val("");
    }
  });
});

// 一括ラジオボタンクリック時の入力制御
$(function () {
  $('input[name="cp_master_board_flag"]').change(function () {
    var prop = $("#cp_master_board_no_board_flag").prop("checked");
    if (prop) {
      $("#cp_master_event_start").prop("readonly", true);
      $("#cp_master_event_finish").prop("readonly", true);
      $("#eventname1Count").prop("readonly", true);
      $("#eventname2Count").prop("readonly", true);
      $("#eventownerCount").prop("readonly", true);
      // $(".board-table input[type='text']").val("");
    } else {
      $("#cp_master_event_start").prop("readonly", false);
      $("#cp_master_event_finish").prop("readonly", false);
      $("#eventname1Count").prop("readonly", false);
      $("#eventname2Count").prop("readonly", false);
      $("#eventownerCount").prop("readonly", false);
    }
  });
});

// 一括仮押さえ 日程ごとのタブ
// $(function () {
//     var target = $('[id^="board_flag_copied_off"]');
//     console.log(target);
//     for (let index = 0; index < target.length; index++) {
//         var board_flag_copied_off = "#board_flag_copied_off" + index;
//         var event_start_copied = "#event_start_copied" + index;
//         var event_finish_copied = "#event_finish_copied" + index;
//         var copiedeventname1Count = "#copiedeventname1Count" + index;
//         var copiedeventname2Count = "#copiedeventname2Count" + index;
//         var copiedeventOwnerCount = "#copiedeventOwnerCount" + index;

//     $(board_flag_copied_off).ready(function () {
//         var flag = $(this);
//         if ($(flag).is(":checked") != null) {
//             $(event_start_copied).prop("disabled", true);
//             $(event_finish_copied).prop("disabled", true);
//             $(copiedeventname1Count).prop("disabled", true);
//             $(copiedeventname2Count).prop("disabled", true);
//             $(copiedeventOwnerCount).prop("disabled", true);
//         }
//     });
// }
// });

// $(function () {
//     var target = $('[id^="board_flag_copied_off"]');
//     console.log(target);
//     for (let index = 0; index < target.length; index++) {
//         var board_flag_copied = "board_flag_copied" + index;
//         var board_flag_copied_off = "#board_flag_copied_off" + index;
//         var event_start_copied = "#event_start_copied" + index;
//         var event_finish_copied = "#event_finish_copied" + index;
//         var copiedeventname1Count = "#copiedeventname1Count" + index;
//         var copiedeventname2Count = "#copiedeventname2Count" + index;
//         var copiedeventOwnerCount = "#copiedeventOwnerCount" + index;
//         console.log(board_flag_copied_off);
//         console.log(event_start_copied);
//         console.log(board_flag_copied);

//         $("input[name='board_flag_copied']" + index).change(function () {
//             var prop = $(board_flag_copied_off).prop("checked");
//             console.log(board_flag_copied_off);
//             if (prop) {
//                 $(event_start_copied).prop("disabled", true);
//                 $(event_finish_copied).prop("disabled", true);
//                 $(copiedeventname1Count).prop("disabled", true);
//                 $(copiedeventname2Count).prop("disabled", true);
//                 $(copiedeventOwnerCount).prop("disabled", true);
//                 $(board_flag_copied_off).val("");
//             } else {
//                 $(event_start_copied).prop("disabled", false);
//                 $(event_finish_copied).prop("disabled", false);
//                 $(copiedeventname1Count).prop("disabled", false);
//                 $(copiedeventname2Count).prop("disabled", false);
//                 $(copiedeventOwnerCount).prop("disabled", false);
//             }
//         });
//     }
// });


// 仮押さえ、一括仮押さえ一覧検索
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

// 仮押え新規作成
$(function () {
  $("#pre_reservationCreateForm").validate({
    rules: {
      user_id: { required: true },
      unknown_user_email: { email: true },
      unknown_user_mobile: { number: true, minlength: 11 },
      unknown_user_tel: { number: true, minlength: 10 },
      pre_date0: { required: true },
      pre_venue0: { required: true },
      pre_enter0: { required: true },
      pre_leave0: { required: true },
    },
    messages: {
      user_id: { required: "※必須項目です" },
      unknown_user_email: { email: "※Emailの形式で入力してください" },
      unknown_user_mobile: {
        number: "※半角数字を入力してください",
        minlength: "※最低桁数は11です",
      },
      unknown_user_tel: {
        number: "※半角数字を入力してください",
        minlength: "※最低桁数は10です",
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


// 仮押さえ　詳細＆再計算&編集&編集の再計算
$(function () {
  var target = [
    "#pre_reservationSingleCheckForm",
    "#pre_reservationSingleCalculateForm",
    "#pre_reservationSingleEditForm",
    "#pre_reservationSingleRecalculateForm",
    "#multiple_switch",
  ];

  $.each(target, function (index, value) {
    $(value).validate({
      rules: {
        unknown_user_email: { email: true },
        unknown_user_mobile: { number: true, minlength: 11 },
        unknown_user_tel: { number: true, minlength: 10 },
        in_charge: { required: true },
        tel: { required: true, number: true, minlength: 11 },
        luggage_count: { number: true, range: [1, 49] },
        luggage_return: { number: true, range: [1, 49] },
        cost: { number: true, range: [1, 100] },
      },
      messages: {
        unknown_user_email: { email: "※Emailの形式で入力してください" },
        unknown_user_mobile: {
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

// 予約登録、編集　仲介会社経由も含む
$(function () {
  var target = [
    "#reservationCreateForm", "#reservations_calculate_form",
    "#reservations_edit", "#edit_calculate",
    "#edit_check", "#edit_calculate", "#agentReservationCreateForm",
    "#agentReservationCalculateForm", "#agents_calculate_form",
    "#agents_reservations_edit", "#agents_reservations_editcalc",
    "#agents_reservations_bill", "#",
  ];

  $.each(target, function (index, value) {
    $(value).validate({
      rules: {
        reserve_date: { required: true },
        venue_id: { required: true },
        price_system: { required: true },
        enter_time: { required: true },
        leave_time: { required: true },
        user_id: { required: true },
        agent_id: { required: true },
        in_charge: { required: true },
        tel: { required: true, number: true, minlength: 10 },
        enduser_tel: { number: true, minlength: 10 },
        enduser_mail: { email: true },
        enduser_mobile: { number: true, minlength: 11 },
        enduser_charge: { required: true, number: true },
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
      },
      messages: {
        reserve_date: { required: "※必須項目です" },
        venue_id: { required: "※必須項目です" },
        price_system: { required: "※必須項目です" },
        enter_time: { required: "※必須項目です" },
        leave_time: { required: "※必須項目です" },
        user_id: { required: "※必須項目です" },
        agent_id: { required: "※必須項目です" },
        in_charge: { required: "※必須項目です" },
        tel: {
          required: "※必須項目です",
          number: "※半角数字を入力してください",
          minlength: "※最低桁数は10です",
        },
        enduser_tel: {
          number: "※半角数字を入力してください",
          minlength: "※最低桁数は10です",
        },
        enduser_mail: {
          email: "※メールアドレスの形式で入力してください",
        },
        enduser_mobile: {
          number: "※半角数字を入力してください",
          minlength: "※最低桁数は11です",
        },
        enduser_charge: {
          required: "※必須項目です",
          number: "※半角数字を入力してください",
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


$(function () {
  var target = [
    "#payment_info",
    "#payment_info2",
    "#payment_info3"
  ];

  $.each(target, function (index, value) {
    $(value).validate({
      rules: {
        pay_person: { hankaku: true },
        payment: { number: true }
      },
      messages: {
        pay_person: { hankaku: "※半角で入力してください" },
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
    "#agentsbillsCreateForm"
  ];

  $.each(target, function (index, value) {
    $(value).validate({
      rules: {
        pay_person: { hankaku: true },
        payment: { number: true },
        enduser_charge: { required: true },
      },
      messages: {
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
        post_code: { maxlength: 7, number: true },
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
          maxlength: "７桁で入力してください",
          number: "半角英数字で入力してください",
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
      post_code: { required: true, maxlength: 7, number: true },
      address1: { required: true },
      address2: { required: true },
      address3: { required: true },
      luggage_flag: { required: true },
      luggage_post_code: { maxlength: 7, number: true },
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
      cost: { required:true, range: [1, 100], maxlength: 3 },
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
        maxlength: "７桁で入力してください",
        number: "※半角数字で入力してください",
      },
      address1: { required: "※必須項目です" },
      address2: { required: "※必須項目です" },
      address3: { required: "※必須項目です" },
      luggage_flag: { required: "※必須項目です" },
      luggage_post_code: {
        maxlength: "７桁で入力してください",
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
      $("input[name='layout_prepare']").prop("readonly", false);

      $("input[name='layout_clean']").rules("add", {
        required: true,
        messages: {
          required: "レイアウト変更が【可】の場合、必須項目です",
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
      cost: { required:true, range: [1, 100], maxlength: 3 },
      layout_prepare: {
        required: $("#layout").val() == 1,
      },
      layout_clean: {
        required: $("#layout").val() == 1,
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
      },
      layout_clean: {
        required: "レイアウト変更が【可】の場合、必須項目です",
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
        number: "※半角英数字で入力してください",
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
      rules: {
        company: {
          required: true,
        },
        post_code: {
          number: true,
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
          required: true,
          number: true,
          minlength: 10,
        },
        tel: {
          number: true,
          minlength: 10,
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
        },
      },
      messages: {
        company: {
          required: "※必須項目です",
        },
        post_code: {
          number: "※半角数字で入力してください",
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
        },
        tel: {
          number: "※半角数字で入力してください",
          minlength: "※10桁以上で入力してください",
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

