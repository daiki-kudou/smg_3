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


// マイページ仮押さえ申し込み
$(function () {
    var target = [
        "#mypageForm"
    ];

    $.each(target, function (index, value) {
        $(value).validate({
            rules: {
                in_charge: {
                    required: true
                },
                tel: {
                    required: true,
                    number: true,
                    minlength: 11,
                    maxlength: 11
                },
                luggage_flag: {
                    required: true
                },
                luggage_count: {
                    number: true,
                    range: [0, 49]
                },
                luggage_return: {
                    number: true,
                    range: [0, 49]
                },
                luggage_price: {
                    number: true
                },
                event_name1: { byte_check: true },
                event_name2: { byte_check: true },
                event_owner: { byte_check2: true },
            },
            messages: {
                in_charge: {
                    required: "※必須項目です"
                },
                tel: {
                    required: "※必須項目です",
                    number: "※半角数字を入力してください",
                    minlength: "※11桁で入力してください",
                    maxlength: "※11桁で入力してください",
                },
                luggage_flag: {
                    required: "※必須項目です",
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
                event_name1: { byte_check: "※文字数がオーバーしています" },
                event_name2: { byte_check: "※文字数がオーバーしています" },
                event_owner: { byte_check2: "※文字数がオーバーしています" },
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


// マイページ メールアドレス変更
$(function () {
    $("#mypageDone").validate({
        rules: {
            in_charge: {
                required: true
            },
            tel: {
                required: true,
                number: true,
                minlength: 11,
                maxlength: 11
            },
            luggage_flag: {
                required: true
            },
            luggage_count: {
                number: true,
                range: [0, 49]
            },
            luggage_return: {
                number: true,
                range: [0, 49]
            },
            luggage_price: {
                number: true
            },
            event_name1: { byte_check: true },
            event_name2: { byte_check: true },
            event_owner: { byte_check2: true },
          //   flow: {
          //     required: true
          // },
          // policy: {
          //     required: true
          // },
        },
        messages: {
            in_charge: {
                required: "※必須項目です"
            },
            tel: {
                required: "※必須項目です",
                number: "※半角数字を入力してください",
                minlength: "※11桁で入力してください",
                maxlength: "※11桁で入力してください",
            },
            luggage_flag: {
                required: "※必須項目です",
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
            flow: {
              required: "※チェックをしてください",
          },
          policy: {
              required: "※チェックをしてください",
          },
          event_name1: { byte_check: "※文字数がオーバーしています" },
          event_name2: { byte_check: "※文字数がオーバーしています" },
          event_owner: { byte_check2: "※文字数がオーバーしています" },
        },
        errorPlacement: function (error, element) {
            var name = element.attr('name');
            if (element.attr('name') === 'category[]') {
                error.appendTo($('.is-error-category'));
            } else if (element.attr('name') === name) {
                error.appendTo($('.is-error-' + name));
            }
        },
        errorElement: "span",
        errorClass: "is-error",
        submitHandler: function (form) {
            $(".approval").addClass("hide");
            $(".loading").removeClass("hide");
            form.submit();
        },
    });
    $('input').on('blur', function () {
        $(this).valid();
    });

    $('input[name="cfm"]').on('click', function(){
      if ($('input[name="flow"]').prop("checked") == true) {
        $('input[name="flow"]').rules('remove', 'required');
      } else if ($('input[name="policy"]').prop("checked") == true) {
        $('input[name="policy"]').rules('remove', 'required');
      } else {
        $('input[name="flow"]').rules('add', 'required');
        $('input[name="policy"]').rules('add', 'required');
      }
      $('form').valid();
    });
});

