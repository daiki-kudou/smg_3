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
  var end = $("input[name^='enduser_charge']");
  ExceptString(end);
});

//////////////////////////////////////////////////////////////////
// プラスボタンクリック
// クローン
function addButton(_this) {
  $(_this).parent().parent().clone(true).insertAfter($(_this).parent().parent());
}
// trカウント
function countTL(_this) {
  var tbody = $(_this).parent().parent().parent(); //tbody
  var result = tbody.find('tr').length;
  return result;
}
// 初期化
function resetData(_this) {
  var TL = $(_this).parent().parent();
  for (let index = 0; index <= 3; index++) {
    TL.next().find('td').eq(index).find('input').val('');
  }
}
// name再付与
function assignName(_this, _count) {
  var tbody = $(_this).parent().parent().parent();
  for (let index = 0; index < _count; index++) {
    for (let indexTD = 0; indexTD <= 3; indexTD++) {
      var target = tbody.find('tr').eq(index).find('td').eq(indexTD).find('input').attr('name');
      var replaceNum = target.replace(/\d+/, '');
      tbody.find('tr').eq(index).find('td').eq(indexTD).find('input').attr('name', replaceNum + index);
    }
  }
}
// ボタントリガー
$(document).on("click", ".add", function () {
  addButton(this);
  resetData(this);
  countTL(this);
  assignName(this, countTL(this));
})
// プラスボタンクリック
//////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////
//マイナスボタン
// ボタン押下、該当trをremove
function delButton(_this) {
  var parentTbody = $(_this).parent().parent().parent();
  var targetTR = $(_this).parent().parent();
  if (parentTbody.find('tr').length > 1) {
    targetTR.remove();
  }
  return parentTbody;
}
// name再付与
function assignName2(_this, _tbody) {
  for (let index = 0; index < $(_tbody).find('tr').length; index++) {
    for (let indexTD = 0; indexTD <= 3; indexTD++) {
      var target = $(_tbody).find('tr').eq(index).find('td').eq(indexTD).find('input').attr('name');
      var replaceNum = target.replace(/\d+/, '');
      $(_tbody).find('tr').eq(index).find('td').eq(indexTD).find('input').attr('name', replaceNum + index);
    }
  }
}
$(document).on("click", ".del", function () {
  assignName2(this, $(delButton(this)))
})
//マイナスボタン
/////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////
// 単価と数量　計算
// thisのindex判定
function getThisIndex(_this) {
  var masterTR = $(_this).parent().parent();
  var TD = masterTR.find('td');
  var thisIndex = TD.index($(_this).parent());
  // console.log(thisIndex);
  return thisIndex;
}
// 単価と数量の数値取得
function getIndexNum(_this) {
  var findTR = $(_this).parent().parent();
  var cost = Number(findTR.find('td').eq(1).find('input').val());
  var count = Number(findTR.find('td').eq(2).find('input').val());
  return [cost, count];
}
// indexが1か2の場合（単価or数量）に掛け算
function calcIndex($array) {
  $result = $array[0] * $array[1];
  return Number($result);
}
// 金額に計算結果挿入
function insertResult(_this, $result) {
  $(_this).parent().parent().find('td').eq(3).find('input').val($result);
}
function sumAllPrices(_this) {
  var MasterVal = $(_this).parent().parent().parent().next().find('tr').find('td').eq(1).find('input').val();
  console.log(MasterVal);

  var thisTbody = $(_this).parent().parent().parent();
  var countTR = thisTbody.find('tr').length();
  for (let index = 0; index < countTR; index++) {
    console.log(index);
  }

}
// input 各　計算
$(document).on("input", "input", function () {
  var $judge = getThisIndex(this);
  var $num = getIndexNum(this);
  if ($judge == 1 || $judge == 2) {
    var $result = calcIndex($num);
  } else {
    var $result = 0;
  }
  insertResult(this, $result);
  sumAllPrices(this);
})
// 単価と数量　計算
/////////////////////////////////////////////////////////////////
