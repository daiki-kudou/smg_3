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



// $(function () {
//   var target = $("input[name^='price']");

//   for (let index = 0; index < target.length; index++) {
//     var price = "price" + "["+ index + "]";
//     console.log(price);
//     $("#FramePriceCreateForm").validate({
//       rules: {
//         [price]: {
//           required: true,
//           digits: true,
//         },
//       },
//       messages: {
//         [price]: {
//           required: "※必須項目です",
//           digits: "※半角数字で入力してください"
//         },
//       },
//       errorPlacement: function (error, element) {
//         var name = element.attr("name");
//         if (element.attr("name") === "category[]") {
//           error.appendTo($(".is-error-category"));
//         } else if (element.attr("name") === name) {
//           error.appendTo($(".is-error-" + name));
//         }
//       },
//       errorElement: "span",
//       errorClass: "is-error",
//       //送信前にLoadingを表示
//       submitHandler: function (form) {
//         $(".approval").addClass("hide");
//         $(".loading").removeClass("hide");
//         form.submit();
//       },
//     });
//     $("input").on("blur", function () {
//       $(this).valid();
//     });
//   }
// });
