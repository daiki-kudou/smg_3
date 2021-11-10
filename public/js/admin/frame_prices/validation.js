$(function () {
  $("#FramePriceCreateForm").validate({
    rules: {
      "extend": { required: true },
      "frame[0]": { required: true },
      "finish[0]": { required: true },
      "price[0]": { 
        required: true,
        digits: true 
      },
    },
    messages: {
      "extend": { required: "※必須項目です" },
      "frame[0]": { required: "※必須項目です" },
      "finish[0]": { required: "※必須項目です" },
      "price[0]": { 
        required: "※必須項目です",
        digits: "数字を入力してください"
      },
    },
    errorElement: "span",
    errorClass: "is-error",
  });
  $("input, select").on("blur change", function () {
    $(this).valid();
  });
});
