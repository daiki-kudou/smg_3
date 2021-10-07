$(function () {
  // 例: cfm(".confirm", "入力した内容を確定しますか？");
// cfm("input[type='submit']","いける？？？");



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