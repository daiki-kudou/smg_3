// 予約カレンダー
$(function () {
  var json = JSON.parse($('input[name=each_json]').val());
  for (let index = 0; index < json.length; index++) {
    var status = json[index].status;
    var date = json[index].reserve_date;
    var reservation_id = json[index].id;
    var company = json[index].company;
    var data = "<a  target='_blank' href='" + rootPath + "/admin/reservations/" + reservation_id + "'>" + company + "</a>";
    if (status < 3) {
      $.each(json[index]['time'], function ($index, $value) {
        console.log(json[index]['time']);
        $('.' + date + 'cal' + $value).addClass('bg-prereserve');
        if ($index == 0) { //会社名挿入 10時以上の予約
          $('.' + date + 'cal' + $value).html(data);//リンク挿入
          if ($value !== "0800") {
            if (!$('.' + date + 'cal' + $value).prev().hasClass('bg-reserve')) {
              $('.' + date + 'cal' + $value).prev().css('background', 'gray'); //前後30分灰色
            }
          }
        } else if ($value == "0800") {
          $('.' + date + 'cal' + $value).html(data);//リンク挿入
        } else if ($index + 1 === json[index]['time'].length) {
          if (!$('.' + date + 'cal' + $value).next().hasClass('bg-reserve')) {
            $('.' + date + 'cal' + $value).next().css('background', 'gray'); //前後30分灰色
          }
        }
        if (json[index]['time'].length === 1) { //30分利用の時のみ、次のマスをグレー
          $('.' + date + 'cal' + $value).next().addClass('gray');
        }
        if (json[index]['time'].slice(-1)[0] == "0800") { //かなりイレギュラー、02:00~08:30などの特定の時間を利用した上で30分だけカレンダーにかかる場合の後の30分のGray
          $('.' + date + 'cal' + $value).next().addClass('gray');
        }
      })
    } else if (status == 3) {
      $.each(json[index]['time'], function ($index, $value) {
        $('.' + date + 'cal' + $value).addClass('bg-reserve');
        if ($index == 0) { //会社名挿入 10時以上の予約
          $('.' + date + 'cal' + $value).html(data);
          if ($value !== "0800") {
            if (!$('.' + date + 'cal' + $value).prev().hasClass('bg-reserve')) {
              $('.' + date + 'cal' + $value).prev().css('background', 'gray'); //前後30分灰色
            }
          }
        } else if ($value == "0800") {
          $('.' + date + 'cal' + $value).html(data);
        } else if ($index + 1 === json[index]['time'].length) {
          if (!$('.' + date + 'cal' + $value).next().hasClass('bg-reserve')) {
            $('.' + date + 'cal' + $value).next().css('background', 'gray'); //前後30分灰色
          }
        }
        if (json[index]['time'].length === 1) { //30分利用の時のみ、次のマスをグレー
          $('.' + date + 'cal' + $value).next().addClass('gray');
        }
        if (json[index]['time'].slice(-1)[0] == "0800") { //かなりイレギュラー、02:00~08:30などの特定の時間を利用した上で30分だけカレンダーにかかる場合の後の30分のGray
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
    var pre_date = pre_json[index].reserve_date;
    var pre_reservation_id = pre_json[index].id;
    var pre_company = pre_json[index].company;
    var pre_agent_id = pre_json[index].agent_id;
    var multiple_id = pre_json[index].multiple_id;
    $.each(pre_json[index]['time'], function ($index, $value) {
      if (pre_json[index]['time'].slice(-1)[0] == "0800") { //かなりイレギュラー、02:00~08:30などの特定の時間を利用した上で30分だけカレンダーにかかる場合の後の30分のGray
        $('.' + pre_date + 'cal' + $value).next().addClass('gray');
      }

      $('.' + pre_date + 'cal' + $value).addClass('bg-prereserve');

      if (pre_json[index]['time'].length === 1) {//30分利用の時のみ、次のマスをグレー
        $('.' + pre_date + 'cal' + $value).next().addClass('gray');
      }

      if ($index == 0) {
        if (multiple_id != 0) {
          if (pre_agent_id > 0) { //仲介会社の場合の一括詳細
            var data = "<a target='_blank' href='" + rootPath + "/admin/multiples/agent/" + multiple_id + "'>" + pre_company + "</a>";
            $('.' + pre_date + 'cal' + $value).html(data);
          } else {　//ユーザーの場合の一括詳細
            var data = "<a target='_blank' href='" + rootPath + "/admin/multiples/" + multiple_id + "'>" + pre_company + "</a>";
            $('.' + pre_date + 'cal' + $value).html(data);
          }
        } else {　//ユーザー||仲介会社の仮押さえ詳細
          var data = "<a target='_blank' href='" + rootPath + "/admin/pre_reservations/" + pre_reservation_id + "'>" + pre_company + "</a>";
          $('.' + pre_date + 'cal' + $value).html(data);
        }
        if ($value !== "0800") {
          if (!$('.' + pre_date + 'cal' + $value).prev().hasClass('bg-prereserve')) {
            $('.' + pre_date + 'cal' + $value).prev().addClass('gray'); //前後30分灰色
          }
        }
      }
      else if ($value == "0800") {
        if (multiple_id != 0) {
          if (pre_agent_id > 0) { //仲介会社の場合の一括詳細
            var data = "<a target='_blank' href='" + rootPath + "/admin/multiples/agent/" + multiple_id + "'>" + pre_company + "</a>";
            $('.' + pre_date + 'cal' + $value).html(data);
          } else {　//ユーザーの場合の一括詳細
            var data = "<a target='_blank' href='" + rootPath + "/admin/multiples/" + multiple_id + "'>" + pre_company + "</a>";
            $('.' + pre_date + 'cal' + $value).html(data);
          }
        } else {　//ユーザー||仲介会社の仮押さえ詳細
          var data = "<a target='_blank' href='" + rootPath + "/admin/pre_reservations/" + pre_reservation_id + "'>" + pre_company + "</a>";
          $('.' + pre_date + 'cal' + $value).html(data);
        }
      } else if ($index + 1 === pre_json[index]['time'].length) {
        if (!$('.' + pre_date + 'cal' + $value).next().hasClass('bg-prereserve')) {
          $('.' + pre_date + 'cal' + $value).next().addClass('gray');//前後30分灰色
        }
      }
    })

  }
})













