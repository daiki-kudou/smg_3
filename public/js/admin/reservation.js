// select2
$(function () {
  // 日付選択画面にてボックス内、検索機能
  $('#user_select').select2({ width: '100%' });
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
$(document).on('click', 'input', function (e) {
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
});



