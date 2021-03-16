// 文字、マイナス、数字制御
function CTRLForm($target) {
  jQuery(document).on('keydown', $target, function (e) {
    let k = e.keyCode;
    let str = String.fromCharCode(k);
    if (!(str.match(/[0-9]/) || (37 <= k && k <= 40) || k === 8 || k === 46)) {
      return false;
    }
  });
  jQuery(document).on('keyup', $target, function (e) {
    this.value = this.value.replace(/[^0-9]+/i, '');
  });
  jQuery(document).on('blur', $target, function () {
    this.value = this.value.replace(/[^0-9]+/i, '');
  });
}

CTRLForm("input[name='capacity']");
CTRLForm("input[name='post_code']");
CTRLForm("input[name='luggage_post_code']");
CTRLForm("input[name='luggage_tel']");
CTRLForm("input[name='person_tel']");
CTRLForm("input[name='mgmt_tel']");
CTRLForm("input[name='mgmt_sec_company']");
CTRLForm("input[name='layout_prepare']");
CTRLForm("input[name='layout_clean']");
CTRLForm("input[name='stock']");
CTRLForm("input[name^='price']");
CTRLForm("input[name^='extend']");
CTRLForm("input[name^='time']");
CTRLForm("input[name='fax']");
CTRLForm("input[name='person_mobile']");
CTRLForm("input[name='cost']");
CTRLForm("input[name='tel']");
CTRLForm("input[name='pay_post_code']");
CTRLForm("input[name='mobile']");