// 予約カレンダー
$(function () {
  var json = JSON.parse($('input[name=each_json]').val());
  for (let index = 0; index < json.length; index++) {
    var status = $('input[name="status"]').eq(index).val();
    var date = $('input[name="date"]').eq(index).val();
    var reservation_id = $('input[name="reservation_id"]').eq(index).val();
    var company = $('input[name="company"]').eq(index).val();
    var data = "<a  target='_blank' href='/admin/reservations/" + reservation_id + "'>" + company + "</a>";
    if (status < 3) {
      $.each(json[index], function ($index, $value) {
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
        } else if ($index + 1 === json[index].length) {
          if (!$('.' + date + 'cal' + $value).next().hasClass('bg-reserve')) {
            $('.' + date + 'cal' + $value).next().css('background', 'gray'); //前後30分灰色
          }
        }
      })
    } else if (status == 3) {
      $.each(json[index], function ($index, $value) {
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
        }
        else if ($index + 1 === json[index].length) {
          if (!$('.' + date + 'cal' + $value).next().hasClass('bg-reserve')) {
            $('.' + date + 'cal' + $value).next().css('background', 'gray'); //前後30分灰色
          }
        }
      })
    }
  }
})

// 仮抑えカレンダー
$(function () {
  var pre_json = JSON.parse($('input[name=pre_each_json]').val());
  for (let index = 0; index < pre_json.length; index++) {
    var pre_date = $('input[name="pre_date"]').eq(index).val();
    var pre_reservation_id = $('input[name="pre_reservation_id"]').eq(index).val();
    var pre_company = $('input[name="pre_company"]').eq(index).val();
    var pre_agent_id = $('input[name="pre_agent_id"]').eq(index).val();
    var multiple_id = $('input[name="multiple_id"]').eq(index).val();
    $.each(pre_json[index], function ($index, $value) {
      $('.' + pre_date + 'cal' + $value).addClass('bg-prereserve');
      if ($index == 0) {
        if (multiple_id != 0) {
          if (pre_agent_id > 0) { //仲介会社の場合の一括詳細
            var data = "<a target='_blank' href='/admin/multiples/agent/" + multiple_id + "'>" + pre_company + "</a>";
            $('.' + pre_date + 'cal' + $value).html(data);
          } else {　//ユーザーの場合の一括詳細
            var data = "<a target='_blank' href='/admin/multiples/" + multiple_id + "'>" + pre_company + "</a>";
            $('.' + pre_date + 'cal' + $value).html(data);
          }
        } else {　//ユーザー||仲介会社の仮押さえ詳細
          var data = "<a target='_blank' href='/admin/pre_reservations/" + pre_reservation_id + "'>" + pre_company + "</a>";
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
            var data = "<a target='_blank' href='/admin/multiples/agent/" + multiple_id + "'>" + pre_company + "</a>";
            $('.' + pre_date + 'cal' + $value).html(data);
          } else {　//ユーザーの場合の一括詳細
            var data = "<a target='_blank' href='/admin/multiples/" + multiple_id + "'>" + pre_company + "</a>";
            $('.' + pre_date + 'cal' + $value).html(data);
          }
        } else {　//ユーザー||仲介会社の仮押さえ詳細
          var data = "<a target='_blank' href='/admin/pre_reservations/" + pre_reservation_id + "'>" + pre_company + "</a>";
          $('.' + pre_date + 'cal' + $value).html(data);
        }
      } else if ($index + 1 === pre_json[index].length) {
        if (!$('.' + pre_date + 'cal' + $value).next().hasClass('bg-prereserve')) {
          $('.' + pre_date + 'cal' + $value).next().addClass('gray');//前後30分灰色
        }
      }
    })

  }
})













