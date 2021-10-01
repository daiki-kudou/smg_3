$(function () {
  $("#FramePriceCreateForm").validate({
    rules: {
      extend: { required: true },
      'frame[0]': { required: true },
    },
    messages: {
      extend: {
        required: "※必須項目です",
      },
      'frame[0]': {
        required: "※必須項目です",
      },

    },
    errorElement: "span",
    errorClass: "is-error",
  });
  $('table tbody tr').each(function (index, element) {
    $("input[name='frame[" + index + "]']").rules("add", {
      required: true,
      messages: {
        required: "※必須項目です"
      }
    });
    $("select[name='start[" + index + "]']").rules("add", {
      required: true,
      number: true,
      messages: {
        required: "※必須項目です",
        number: "※半角数字を入力してください",
      }
    });
    $("select[name='finish[" + index + "]']").rules("add", {
      required: true,
      number: true,
      messages: {
        required: "※必須項目です",
        number: "※半角数字を入力してください",
      }
    });
    $("input[name='price[" + index + "]']").rules("add", {
      required: true,
      messages: {
        required: "※必須項目です"
      }
    });
  })
  $("input").on("blur change", function () {
    $(this).valid();
  });

})