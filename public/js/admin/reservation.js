// select2
$(function () {
  // 日付選択画面にてボックス内、検索機能
  $('#user_select').select2({ width: '100%' });
  $('#venues_selector').select2({ width: '100%' });
  $('#agent_select').select2({ width: '100%' });
  // $('#venues_selector').select2({ width: '100%' });
});
// datepicker
$(function () {
  $('#datepicker').datepicker({
    dateFormat: 'yy-mm-dd',
    minDate: 0,
    autoclose: false
  });
});
// 文字、マイナス、数字制御
// $(document).on('click', 'input', function (e) {
  $(function () {
  function ExceptString($target) {
    $target.numeric({ negative: false, });
    $target.on('change', function () {
      charactersChange($(this));
    })
    charactersChange = function (ele) {
      var val = ele.val();
      var han = val.replace(/[Ａ-Ｚａ-ｚ０-９]/g, function (s) { return String.fromCharCode(s.charCodeAt(0) - 0xFEE0) });
      if (val.match(/[Ａ-Ｚａ-ｚ０-９]/g)) {
        $(ele).val(han);
      }
    }
  }

  var tel = $("input[name^='tel']");
  ExceptString(tel);
  var equ = $("input[name^='equipment_breakdown']");
  ExceptString(equ);
  var end = $("input[name^='enduser_charge']");
  ExceptString(end);
  var post_code = $("input[name^='post_code']");
  ExceptString(post_code);
  var luggage_post_code = $("input[name^='luggage_post_code']");
  ExceptString(luggage_post_code);
  var luggage_tel = $("input[name^='luggage_tel']");
  ExceptString(luggage_tel);
  var person_tel = $("input[name^='person_tel']");
  ExceptString(person_tel);
  var fax = $("input[name^='fax']");
  ExceptString(fax);
  var person_mobile = $("input[name^='person_mobile']");
  ExceptString(person_mobile);
  var email = $("input[name^='email']");
  ExceptString(email);
  var person_mobile = $("input[name^='person_mobile']");
  ExceptString(person_mobile);
  var person_mobile = $("input[name^='password']");
  ExceptString(person_mobile);
  var site_id = $("input[name^='site_id']");
  ExceptString(site_id);
  var site_pass = $("input[name^='site_pass']");
  ExceptString(site_pass);
  var fax = $("input[name^='fax']");
  ExceptString(fax);
  var site_url = $("input[name^='site_url']");
  ExceptString(site_url);
  var login = $("input[name^='login']");
  ExceptString(login);

});



