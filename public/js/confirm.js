$(function () {
  // 例: cfm(".confirm", "入力した内容を確定しますか？");
cfm(".confirm_submit","登録してもよろしいでしょうか？");
cfm(".update_submit","更新してもよろしいでしょうか？");

// 料金管理のポップアップ
cfm(".price_confirm","この情報で保存します。保存した時点で会場情報・顧客側予約フォームの料金情報が更新されます");



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