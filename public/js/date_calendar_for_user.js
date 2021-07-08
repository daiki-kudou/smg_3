$(function () {
  $('#datepicker8').on('change', function () {
    $('input[name="date"]').val($(this).val());
    $('#s_calendar').submit();
  })
})

// 予約用カレンダー表示
$(function () {
  var json = JSON.parse($('input[name=json]').val());
  for (let index = 0; index < json.length; index++) {
    var status = $('input[name="status"]').eq(index).val();
    var venue_id = $('input[name="venue_id"]').eq(index).val();
    $.each(json[index], function ($index, $value) {
      if (status < 3) {// 3以下が黄色
        $('.' + venue_id + 'cal' + $value).addClass('bg-prereserve');
        if ($value !== "0800") {
          if (!$('.' + venue_id + 'cal' + $value).prev().hasClass('bg-prereserve') && !$('.' + venue_id + 'cal' + $value).prev().hasClass('bg-reserve')) {
            $('.' + venue_id + 'cal' + $value).prev().css('background', 'gray'); //前後30分灰色
          } else if ($index + 1 === json[index].length) {
            if (!$('.' + venue_id + 'cal' + $value).next().hasClass('bg-prereserve') && !$('.' + venue_id + 'cal' + $value).next().hasClass('bg-reserve')) {
              $('.' + venue_id + 'cal' + $value).next().addClass('gray');//前後30分灰色
            }
          }
        }
        if (json[index].length === 1) { //30分利用の時のみ、次のマスをグレー
          $('.' + venue_id + 'cal' + $value).next().addClass('gray');
        }
        if (json[index].slice(-1)[0] == "0800") { //かなりイレギュラー、02:00~08:30などの特定の時間を利用した上で30分だけカレンダーにかかる場合の後の30分のGray
          $('.' + venue_id + 'cal' + $value).next().addClass('gray');
        }

      } else if (status == 3) {// 3なら緑
        $('.' + venue_id + 'cal' + $value).addClass('bg-reserve');
        if ($value !== "0800") {
          if (!$('.' + venue_id + 'cal' + $value).prev().hasClass('bg-prereserve') && !$('.' + venue_id + 'cal' + $value).prev().hasClass('bg-reserve')) {
            $('.' + venue_id + 'cal' + $value).prev().css('background', 'gray'); //前後30分灰色
          } else if ($index + 1 === json[index].length) {
            if (!$('.' + venue_id + 'cal' + $value).next().hasClass('bg-prereserve') && !$('.' + venue_id + 'cal' + $value).next().hasClass('bg-reserve')) {
              $('.' + venue_id + 'cal' + $value).next().addClass('gray');//前後30分灰色
            }
          }
        }
        if (json[index].length === 1) { //30分利用の時のみ、次のマスをグレー
          $('.' + venue_id + 'cal' + $value).next().addClass('gray');
        }
        if (json[index].slice(-1)[0] == "0800") { //かなりイレギュラー、02:00~08:30などの特定の時間を利用した上で30分だけカレンダーにかかる場合の後の30分のGray
          $('.' + venue_id + 'cal' + $value).next().addClass('gray');
        }

      }
    })
  }
})
// ==============================================
// 仮抑え用カレンダー表示
$(function () {
  var json = JSON.parse($('input[name=pre_json]').val());
  for (let index = 0; index < json.length; index++) {
    var venue_id = $('input[name="pre_reservation_venue_id"]').eq(index).val();
    var multiple_id = $('input[name="pre_multiple_id"]').eq(index).val();
    var agent_id = $('input[name="pre_agent_id"]').eq(index).val();
    var company = $('input[name="pre_company"]').eq(index).val();
    var pre_reservation_id = $('input[name="pre_reservation_id"]').eq(index).val();
    $.each(json[index], function ($index, $value) {
      $('.' + venue_id + 'cal' + $value).addClass('bg-prereserve');
      if (json[index].slice(-1)[0] == "0800") { //かなりイレギュラー、02:00~08:30などの特定の時間を利用した上で30分だけカレンダーにかかる場合の後の30分のGray
        $('.' + venue_id + 'cal' + $value).next().addClass('gray');
      }
      if (json[index].length === 1) {//30分利用の時のみ、次のマスをグレー
        $('.' + venue_id + 'cal' + $value).next().addClass('gray');
      }
      if ($value !== "0800") {
        if (!$('.' + venue_id + 'cal' + $value).prev().hasClass('bg-prereserve') && !$('.' + venue_id + 'cal' + $value).prev().hasClass('bg-reserve')) {
          $('.' + venue_id + 'cal' + $value).prev().css('background', 'gray'); //前後30分灰色
        } else if ($index + 1 === json[index].length) {
          if (!$('.' + venue_id + 'cal' + $value).next().hasClass('bg-prereserve') && !$('.' + venue_id + 'cal' + $value).next().hasClass('bg-reserve')) {
            $('.' + venue_id + 'cal' + $value).next().addClass('gray');//前後30分灰色
          }
        }
      }
    })
  }
})


