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
    var reservation_id = $('input[name="reservation_id"]').eq(index).val();
    var company = $('input[name="company"]').eq(index).val();
    $.each(json[index], function ($index, $value) {
      if (status < 3) {// 3以下が黄色
        if ($index == 0) { //会社名挿入 10時以上の予約
          var data = "<a target='_blank' href='" + rootPath + "/admin/reservations/" + reservation_id + "'>" + company + "</a>";
          $('.' + venue_id + 'cal' + $value).html(data); //リンク挿入
          if ($value !== "0800") {
            if (!$('.' + venue_id + 'cal' + $value).prev().hasClass('bg-prereserve') && !$('.' + venue_id + 'cal' + $value).prev().hasClass('bg-reserve')) {
              $('.' + venue_id + 'cal' + $value).prev().addClass('gray'); //前後30分灰色
            }
          }
        } else if ($value === "0800") {
          var data = "<a target='_blank' href='" + rootPath + "/admin/reservations/" + reservation_id + "'>" + company + "</a>";
          $('.' + venue_id + 'cal' + $value).html(data);
        } else if ($index + 1 === json[index].length) {
          if (!$('.' + venue_id + 'cal' + $value).next().hasClass('bg-prereserve') && !$('.' + venue_id + 'cal' + $value).next().hasClass('bg-reserve')) {
            $('.' + venue_id + 'cal' + $value).next().addClass('gray');//前後30分灰色
          }
        }
        $('.' + venue_id + 'cal' + $value).addClass('bg-prereserve');
        if (json[index].length === 1) { //30分利用の時のみ、次のマスをグレー
          $('.' + venue_id + 'cal' + $value).next().addClass('gray');
        }
        if (json[index].slice(-1)[0] == "0800") { //かなりイレギュラー、02:00~08:30などの特定の時間を利用した上で30分だけカレンダーにかかる場合の後の30分のGray
          $('.' + venue_id + 'cal' + $value).next().addClass('gray');
        }
      } else if (status == 3) {// 3なら緑
        if ($index == 0) { //会社名挿入 10時以上の予約
          var data = "<a target='_blank' href='" + rootPath + "/admin/reservations/" + reservation_id + "'>" + company + "</a>";
          $('.' + venue_id + 'cal' + $value).html(data);
          if ($value !== "0800") {
            if (!$('.' + venue_id + 'cal' + $value).prev().hasClass('bg-reserve')) {
              $('.' + venue_id + 'cal' + $value).prev().addClass('gray'); //前後30分灰色
            }
          }
        } else if ($value === "0800") {
          var data = "<a target='_blank' href='" + rootPath + "/admin/reservations/" + reservation_id + "'>" + company + "</a>";
          $('.' + venue_id + 'cal' + $value).html(data);
        } else if ($index + 1 === json[index].length) {
          if (!$('.' + venue_id + 'cal' + $value).next().hasClass('bg-reserve')) {
            $('.' + venue_id + 'cal' + $value).next().addClass('gray');//前後30分灰色
          }
        }
        $('.' + venue_id + 'cal' + $value).addClass('bg-reserve');
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
      if (json[index].slice(-1)[0] == "0800") { //かなりイレギュラー、02:00~08:30などの特定の時間を利用した上で30分だけカレンダーにかかる場合の後の30分のGray
        $('.' + venue_id + 'cal' + $value).next().addClass('gray');
      }
      $('.' + venue_id + 'cal' + $value).addClass('bg-prereserve');
      if (json[index].length === 1) {//30分利用の時のみ、次のマスをグレー
        $('.' + venue_id + 'cal' + $value).next().addClass('gray');
      }
      if ($index == 0) {
        if (multiple_id != 0) {
          if (agent_id > 0) { //仲介会社の場合の一括詳細
            var data = "<a target='_blank' href='" + rootPath + "/admin/multiples/agent/" + multiple_id + "'>" + company + "</a>";
            $('.' + venue_id + 'cal' + $value).html(data);
          } else {　//ユーザーの場合の一括詳細
            var data = "<a target='_blank' href='" + rootPath + "/admin/multiples/" + multiple_id + "'>" + company + "</a>";
            $('.' + venue_id + 'cal' + $value).html(data);
          }
        } else {　//ユーザー||仲介会社の仮押さえ詳細
          var data = "<a target='_blank' href='" + rootPath + "/admin/pre_reservations/" + pre_reservation_id + "'>" + company + "</a>";
          $('.' + venue_id + 'cal' + $value).html(data);
        }
        if ($value !== "0800") {
          if (!$('.' + venue_id + 'cal' + $value).prev().hasClass('bg-prereserve') && !$('.' + venue_id + 'cal' + $value).prev().hasClass('bg-reserve')) {
            $('.' + venue_id + 'cal' + $value).prev().addClass('gray'); //前後30分灰色
          }
        }
      } else if ($value == "0800") {
        if (multiple_id != 0) {
          if (agent_id > 0) { //仲介会社の場合の一括詳細
            var data = "<a target='_blank' href='" + rootPath + "/admin/multiples/agent/" + multiple_id + "'>" + company + "</a>";
            $('.' + venue_id + 'cal' + $value).html(data);
          } else {　//ユーザーの場合の一括詳細
            var data = "<a target='_blank' href='" + rootPath + "/admin/multiples/" + multiple_id + "'>" + company + "</a>";
            $('.' + venue_id + 'cal' + $value).html(data);
          }
        } else {　//ユーザー||仲介会社の仮押さえ詳細
          var data = "<a target='_blank' href='" + rootPath + "/admin/pre_reservations/" + pre_reservation_id + "'>" + company + "</a>";
          $('.' + venue_id + 'cal' + $value).html(data);
        }
      } else if ($index + 1 === json[index].length) {
        if (!$('.' + venue_id + 'cal' + $value).next().hasClass('bg-prereserve') && !$('.' + venue_id + 'cal' + $value).next().hasClass('bg-reserve')) {
          $('.' + venue_id + 'cal' + $value).next().addClass('gray');//前後30分灰色
        }
      }
    })
  }
})


