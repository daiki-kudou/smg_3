// 予約カレンダー
$(function () {
  var json = JSON.parse($('input[name=each_json]').val());
  for (let index = 0; index < json.length; index++) {
    var status = $('input[name="status"]').eq(index).val();
    var date = $('input[name="date"]').eq(index).val();
    if (status < 3) {
      $.each(json[index], function ($index, $value) {
        $('.' + date + 'cal' + $value).addClass('bg-prereserve');
        if ($value !== "0800") {
          if (!$('.' + date + 'cal' + $value).prev().hasClass('bg-reserve')) {
            $('.' + date + 'cal' + $value).prev().css('background', 'gray'); //前後30分灰色
          };
          if (!$('.' + date + 'cal' + $value).next().hasClass('bg-reserve')) {
            $('.' + date + 'cal' + $value).next().css('background', 'gray'); //前後30分灰色
          };
        }
        if (json[index].length === 1) { //30分利用の時のみ、次のマスをグレー
          $('.' + date + 'cal' + $value).next().addClass('gray');
        }
        if (json[index].slice(-1)[0] == "0800") { //かなりイレギュラー、02:00~08:30などの特定の時間を利用した上で30分だけカレンダーにかかる場合の後の30分のGray
          $('.' + date + 'cal' + $value).next().addClass('gray');
        }
      })
    } else if (status == 3) {
      $.each(json[index], function ($index, $value) {
        $('.' + date + 'cal' + $value).addClass('bg-reserve');
        if ($value !== "0800") {
          if (!$('.' + date + 'cal' + $value).prev().hasClass('bg-reserve')) {
            $('.' + date + 'cal' + $value).prev().css('background', 'gray'); //前後30分灰色
          };
          if (!$('.' + date + 'cal' + $value).next().hasClass('bg-reserve')) {
            $('.' + date + 'cal' + $value).next().css('background', 'gray'); //前後30分灰色
          };
        }
        if (json[index].length === 1) { //30分利用の時のみ、次のマスをグレー
          $('.' + date + 'cal' + $value).next().addClass('gray');
        }
        if (json[index].slice(-1)[0] == "0800") { //かなりイレギュラー、02:00~08:30などの特定の時間を利用した上で30分だけカレンダーにかかる場合の後の30分のGray
          $('.' + date + 'cal' + $value).next().addClass('gray');
        }
      })
    }
  }
})


// 仮抑えカレンダー
$(function () {
  var pre_json = JSON.parse($('input[name=pre_each_json]').val());
  console.log(pre_json);
  for (let index = 0; index < pre_json.length; index++) {
    var pre_date = $('input[name="pre_date"]').eq(index).val();
    $.each(pre_json[index], function ($index, $value) {
      $('.' + pre_date + 'cal' + $value).addClass('bg-prereserve');
      if (pre_json[index].slice(-1)[0] == "0800") { //かなりイレギュラー、02:00~08:30などの特定の時間を利用した上で30分だけカレンダーにかかる場合の後の30分のGray
        $('.' + pre_date + 'cal' + $value).next().addClass('gray');
      }
      if (pre_json[index].length === 1) {//30分利用の時のみ、次のマスをグレー
        $('.' + pre_date + 'cal' + $value).next().addClass('gray');
      }
      if ($value !== "0800") {
        if (!$('.' + pre_date + 'cal' + $value).prev().hasClass('bg-prereserve')) {
          $('.' + pre_date + 'cal' + $value).prev().addClass('gray'); //前後30分灰色
        } else if (!$('.' + pre_date + 'cal' + $value).next().hasClass('bg-prereserve')) {
          $('.' + pre_date + 'cal' + $value).next().addClass('gray');//前後30分灰色
        }
      }
    })
  }
})

