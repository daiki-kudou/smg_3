$(function () {
  // 例: cfm(".more_btn", "ほんとにOK????");



  // $target = 対象クラス;
  // $comment = 表示するコメント;
  function cfm($target, $comment) {
    $($target).on('click', function () {
      if (!confirm($comment)) {
        return false;
      }
    })
  }
})