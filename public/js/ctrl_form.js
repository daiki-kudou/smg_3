
// $(function () {
//   function CTRLForm($inputName) {
//     $($inputName).on('input', function () {
//       check_numtype($(this), $inputName);
//     });
//   }
//   CTRLForm("input[name='capacity']");
//   CTRLForm("input[name='post_code']");
//   CTRLForm("input[name='luggage_post_code']");
//   CTRLForm("input[name='luggage_tel']");
//   CTRLForm("input[name='person_tel']");
//   CTRLForm("input[name='mgmt_tel']");
//   // CTRLForm("input[name='mgmt_sec_company']");
//   CTRLForm("input[name='layout_prepare']");
//   CTRLForm("input[name='layout_clean']");
//   CTRLForm("input[name='stock']");
//   // CTRLForm("input[name^='price0']");
//   CTRLForm("input[name^='extend']");
//   CTRLForm("input[name^='time']");
//   CTRLForm("input[name='fax']");
//   CTRLForm("input[name='person_mobile']");
//   CTRLForm("input[name='cost']");
//   CTRLForm("input[name='tel']");
//   CTRLForm("input[name='pay_post_code']");
//   CTRLForm("input[name='mobile']");
//   CTRLForm("input[name='mgmt_emer_tel']");
//   CTRLForm("input[name='mgmt_sec_tel']");
//   CTRLForm("input[name='mgmt_person_tel']");
// });

// // 文字制御開始
// var _chknum_value = "";
// function check_numtype(obj, inputName) {
//   var txt_obj = $(obj).val();
//   var text_length = txt_obj.length;
//   if (txt_obj.match(/^[0-9]+$/)) {
//     if (text_length > 9) {
//       $(inputName).val(_chknum_value);
//     } else {
//       _chknum_value = txt_obj;
//     }
//   } else {
//     if (text_length == 0) {
//       _chknum_value = "";
//     } else {
//       $(inputName).val(_chknum_value);
//     }
//   }
// }


$(function () {
  function resetPostCode($inputName) {
    $($inputName).on("click", function () {
      $($inputName).val("");
    })
  }
  resetPostCode('input[name="post_code"]');
  resetPostCode('input[name="luggage_post_code"]');
})

