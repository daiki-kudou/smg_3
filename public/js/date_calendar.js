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
    var status = json[index].status;
    var venue_id = json[index].venue_id;
    var reservation_id = json[index].id;
    var company = json[index].company;
    var text_limit = json[index]['time'].length + 1;　//折返し文字数
    var data = "<a target='_blank' href='" + rootPath + "/admin/reservations/" + reservation_id + "'>" + line_break(company, text_limit) + "</a>";
    $.each(json[index]['time'], function ($index, $value) {
      if (status < 3) {// 3以下が黄色
        if ($index == 0) { //会社名挿入 10時以上の予約
          $('.' + venue_id + 'cal' + $value).html(data); //リンク挿入
          if ($value !== "0800") {
            if (!$('.' + venue_id + 'cal' + $value).prev().hasClass('bg-prereserve') && !$('.' + venue_id + 'cal' + $value).prev().hasClass('bg-reserve')) {
              $('.' + venue_id + 'cal' + $value).prev().addClass('gray'); //前後30分灰色
            }
          }
        } else if ($value === "0800") {
          $('.' + venue_id + 'cal' + $value).html(data);
        } else if ($index + 1 === json[index]['time'].length) {
          if (!$('.' + venue_id + 'cal' + $value).next().hasClass('bg-prereserve') && !$('.' + venue_id + 'cal' + $value).next().hasClass('bg-reserve')) {
            $('.' + venue_id + 'cal' + $value).next().addClass('gray');//前後30分灰色
          }
        }
        $('.' + venue_id + 'cal' + $value).addClass('bg-prereserve');
        if (json[index]['time'].length === 1) { //30分利用の時のみ、次のマスをグレー
          $('.' + venue_id + 'cal' + $value).next().addClass('gray');
        }
        if (json[index]['time'].slice(-1)[0] == "0800") { //かなりイレギュラー、02:00~08:30などの特定の時間を利用した上で30分だけカレンダーにかかる場合の後の30分のGray
          $('.' + venue_id + 'cal' + $value).next().addClass('gray');
        }
      } else if (status == 3) {// 3なら緑
        if ($index == 0) { //会社名挿入 10時以上の予約
          $('.' + venue_id + 'cal' + $value).html(data);
          if ($value !== "0800") {
            if (!$('.' + venue_id + 'cal' + $value).prev().hasClass('bg-reserve')) {
              $('.' + venue_id + 'cal' + $value).prev().addClass('gray'); //前後30分灰色
            }
          }
        } else if ($value === "0800") {
          $('.' + venue_id + 'cal' + $value).html(data);
        } else if ($index + 1 === json[index]['time'].length) {
          if (!$('.' + venue_id + 'cal' + $value).next().hasClass('bg-prereserve') && !$('.' + venue_id + 'cal' + $value).next().hasClass('bg-reserve')) {
            $('.' + venue_id + 'cal' + $value).next().addClass('gray');//前後30分灰色
          }
        }
        $('.' + venue_id + 'cal' + $value).addClass('bg-reserve');
        if (json[index]['time'].length === 1) { //30分利用の時のみ、次のマスをグレー
          $('.' + venue_id + 'cal' + $value).next().addClass('gray');
        }
        if (json[index]['time'].slice(-1)[0] == "0800") { //かなりイレギュラー、02:00~08:30などの特定の時間を利用した上で30分だけカレンダーにかかる場合の後の30分のGray
          $('.' + venue_id + 'cal' + $value).next().addClass('gray');
        }
      }
    })
  }
  // ==============================================
  // 仮抑え用カレンダー表示
  var json = JSON.parse($('input[name=pre_json]').val());

  for (let index = 0; index < json.length; index++) {
    var venue_id = json[index].venue_id;
    var multiple_id = json[index].multiple_id;
    var agent_id = json[index].agent_id;
    var company = json[index].company;
    var pre_reservation_id = json[index].id;
    var pre_text_limit = json[index]['time'].length + 1;　//折返し文字数

    $.each(json[index]['time'], function ($index, $value) {
      if (json[index]['time'].slice(-1)[0] == "0800") { //かなりイレギュラー、02:00~08:30などの特定の時間を利用した上で30分だけカレンダーにかかる場合の後の30分のGray
        $('.' + venue_id + 'cal' + $value).next().addClass('gray');
      }
      $('.' + venue_id + 'cal' + $value).addClass('bg-prereserve');
      if (json[index]['time'].length === 1) {//30分利用の時のみ、次のマスをグレー
        $('.' + venue_id + 'cal' + $value).next().addClass('gray');
      }
      if ($index == 0) {
        if (multiple_id != 0) {
          if (agent_id > 0) { //仲介会社の場合の一括詳細
            var data = "<a target='_blank' href='" + rootPath + "/admin/multiples/agent/" + multiple_id + "'>" + line_break(company, pre_text_limit) + "</a>";
            $('.' + venue_id + 'cal' + $value).html(data);
          } else {　//ユーザーの場合の一括詳細
            var data = "<a target='_blank' href='" + rootPath + "/admin/multiples/" + multiple_id + "'>" + line_break(company, pre_text_limit) + "</a>";
            $('.' + venue_id + 'cal' + $value).html(data);
          }
        } else {　//ユーザー||仲介会社の仮押さえ詳細
          var data = "<a target='_blank' href='" + rootPath + "/admin/pre_reservations/" + pre_reservation_id + "'>" + line_break(company, pre_text_limit) + "</a>";
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
            var data = "<a target='_blank' href='" + rootPath + "/admin/multiples/agent/" + multiple_id + "'>" + line_break(company, pre_text_limit) + "</a>";
            $('.' + venue_id + 'cal' + $value).html(data);
          } else {　//ユーザーの場合の一括詳細
            var data = "<a target='_blank' href='" + rootPath + "/admin/multiples/" + multiple_id + "'>" + line_break(company, pre_text_limit) + "</a>";
            $('.' + venue_id + 'cal' + $value).html(data);
          }
        } else {　//ユーザー||仲介会社の仮押さえ詳細
          var data = "<a target='_blank' href='" + rootPath + "/admin/pre_reservations/" + pre_reservation_id + "'>" + line_break(company, pre_text_limit) + "</a>";
          $('.' + venue_id + 'cal' + $value).html(data);
        }
      } else if ($index + 1 === json[index]['time'].length) {
        if (!$('.' + venue_id + 'cal' + $value).next().hasClass('bg-prereserve') && !$('.' + venue_id + 'cal' + $value).next().hasClass('bg-reserve')) {
          $('.' + venue_id + 'cal' + $value).next().addClass('gray');//前後30分灰色
        }
      }
    })
  }

  function line_break($targetText, $textLimit) {
    var textLimit = Number($textLimit);
    var target = String($targetText);
    var tmp = target.split("\n");
    var kaigyouBody = [];
    for (var key in tmp) {
      if (tmp[key] != "") {
        if (tmp[key].length >= textLimit) {
          let oneSplit = tmp[key].split('');
          let oneBody = [];
          for (var key2 in oneSplit) {
            //key2 1文字目でなく、さらに textLimit の倍数の数値なら改行コードを挿入
            if (key2 != 0 && key2 % textLimit == 0) {
              oneBody.push("<br>");
            }
            oneBody.push(oneSplit[key2]);
          }
          kaigyouBody.push(oneBody.join(""));
        } else {
          kaigyouBody.push(tmp[key]);
        }
      }
    }
    // var result = kaigyouBody.join("\n");
    var result = kaigyouBody.join();
    return result;
  }

})


