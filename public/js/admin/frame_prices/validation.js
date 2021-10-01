$(function () {
  $("#FramePriceCreateForm").validate({
    rules: {
      "extend": { required: true },
      "reserve_date[0]": { required: true },
      "venue_id[0]": { required: true },
      "enter_time[0]": { required: true },
      "leave_time[0]": { required: true },
    },
    messages: {
      "extend": { required: "※必須項目です" },
      "reserve_date[0]": { required: "※必須項目です" },
      "venue_id[0]": { required: "※必須項目です" },
      "enter_time[0]": { required: "※必須項目です" },
      "leave_time[0]": { required: "※必須項目です" },
    },
    errorElement: "span",
    errorClass: "is-error",
  });
  $("input, select").on("blur change", function () {
    $(this).valid();
  });
})
