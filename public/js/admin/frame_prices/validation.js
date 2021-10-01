$(function () {
  $("#FramePriceCreateForm").validate({
    rules: {
      extend: { required: true },
      // "frame[0]": { required: true },
      // "price[0]": { required: true },
      // "start[0]": { required: true },
      // "finish[0]": { required: true },
    },
    messages: {
      extend: { required: "aaaaaa" },

      // "frame[0]": { required: "※必須項目です" },
      // "price[0]": { required: "※必須項目です" },
      // "start[0]": { required: "※必須項目です" },
      // "finish[0]": { required: "※必須項目です" },
    },
    // errorPlacement: function (error, element) {
    //   var name = element.attr("name");
    //   if (element.attr("name") === "category[]") {
    //     error.appendTo($(".is-error-category"));
    //   } else if (element.attr("name") === name) {
    //     error.appendTo($(".is-error-" + name));
    //   }
    // },
    errorElement: "span",
    errorClass: "is-error",
    //送信前にLoadingを表示
  });
  $("input").on("click blur change", function () {
    $(this).valid();
  });
});