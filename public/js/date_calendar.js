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
        $('.' + venue_id + 'cal' + $value).addClass('bg-prereserve');
        if ($index == 0) { //会社名挿入 10時以上の予約
          var data = "<a  target='_blank' href='/admin/reservations/" + reservation_id + "'>" + company + "</a>";
          $('.' + venue_id + 'cal' + $value).html(data);
        } else if ($value === "1000") {
          var data = "<a  target='_blank' href='/admin/reservations/" + reservation_id + "'>" + company + "</a>";
          $('.' + venue_id + 'cal' + $value).html(data);
        }
      } else if (status == 3) {// 3なら緑
        $('.' + venue_id + 'cal' + $value).addClass('bg-reserve');
        if ($index == 0) { //会社名挿入 10時以上の予約
          var data = "<a  target='_blank' href='/admin/reservations/" + reservation_id + "'>" + company + "</a>";
          $('.' + venue_id + 'cal' + $value).html(data);
        } else if ($value === "1000") {
          var data = "<a  target='_blank' href='/admin/reservations/" + reservation_id + "'>" + company + "</a>";
          $('.' + venue_id + 'cal' + $value).html(data);
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
      if ($index == 0) {
        if (multiple_id != 0) {
          if (agent_id > 0) { //仲介会社の場合の一括詳細
            var data = "<a target='_blank' href='/admin/multiples/agent/" + multiple_id + "'>" + company + "</a>";
            $('.' + venue_id + 'cal' + $value).html(data);
          } else {　//ユーザーの場合の一括詳細
            var data = "<a target='_blank' href='/admin/multiples/" + multiple_id + "'>" + company + "</a>";
            $('.' + venue_id + 'cal' + $value).html(data);
          }
        } else {　//ユーザー||仲介会社の仮押さえ詳細
          var data = "<a target='_blank' href='/admin/pre_reservations/" + pre_reservation_id + "'>" + company + "</a>";
          $('.' + venue_id + 'cal' + $value).html(data);
        }
      } else if ($value == "1000") {
        if (multiple_id != 0) {
          if (agent_id > 0) { //仲介会社の場合の一括詳細
            var data = "<a target='_blank' href='/admin/multiples/agent/" + multiple_id + "'>" + company + "</a>";
            $('.' + venue_id + 'cal' + $value).html(data);
          } else {　//ユーザーの場合の一括詳細
            var data = "<a target='_blank' href='/admin/multiples/" + multiple_id + "'>" + company + "</a>";
            $('.' + venue_id + 'cal' + $value).html(data);
          }
        } else {　//ユーザー||仲介会社の仮押さえ詳細
          var data = "<a target='_blank' href='/admin/pre_reservations/" + pre_reservation_id + "'>" + company + "</a>";
          $('.' + venue_id + 'cal' + $value).html(data);
        }
      }
    })
  }
})




// 使わない


// $(function () {
//   for (let index = 0; index < $('input[name="start"]').length; index++) {
//     var venue_id = $('input[name="venue_id"]').eq(index).val();
//     var status = $('input[name="status"]').eq(index).val();
//     var company = $('input[name="company"]').eq(index).val();
//     var reservation_id = $('input[name="reservation_id"]').eq(index).val();
//     var json = $('input[name="json"]').val();
//     var json_result = JSON.parse(json);

//     var target_length = (json_result[index]).length;
//     for (let index2 = 0; index2 < target_length; index2++) {
//       if (status == 3) {
//         if (index2 == 0) {
//           if ($("." + venue_id + "cal" + json_result[index][index2]).prev().hasClass('field-title')) {
//           } else {
//             $("." + venue_id + "cal" + json_result[index][index2]).prev().addClass('gray');
//           }
//           $("." + venue_id + "cal" + json_result[index][index2]).addClass('bg-reserve');
//         } else {
//           $("." + venue_id + "cal" + json_result[index][index2]).addClass('bg-reserve');
//         }
//         // if ($("." + venue_id + "cal" + json_result[index][index2]).prev().hasClass('gray')) {
//         //   $("." + venue_id + "cal" + json_result[index][index2]).html(
//         //     "<a href='/admin/reservations/" + reservation_id + "'>" + company + "</a>"
//         //   )
//         // };

//       } else if (status < 3) {
//         if (index2 == 0) {
//           if ($("." + venue_id + "cal" + json_result[index][index2]).prev().hasClass('field-title')) {
//           } else {
//             $("." + venue_id + "cal" + json_result[index][index2]).prev().addClass('gray');
//           }
//           $("." + venue_id + "cal" + json_result[index][index2]).addClass('bg-prereserve');
//         } else {
//           $("." + venue_id + "cal" + json_result[index][index2]).addClass('bg-prereserve');
//         }
//       }
//     }
//     $('.bg-reserve:last').addClass('gray');
//     $('.bg-prereserve:last').addClass('gray');
//   }
// })

// $(function () {
//   for (let index = 0; index < $('input[name="pre_reservation_start"]').length; index++) {
//     var venue_id = $('input[name="pre_reservation_venue_id"]').eq(index).val();
//     var json = $('input[name="pre_json"]').val();
//     var json_result = JSON.parse(json);
//     var target_length = (json_result[index]).length;
//     for (let index2 = 0; index2 < target_length; index2++) {
//       if (index2 == 0) {
//         if ($("." + venue_id + "cal" + json_result[index][index2]).prev().hasClass('field-title')) {
//         } else {
//           $("." + venue_id + "cal" + json_result[index][index2]).prev().addClass('gray');
//         }
//         $("." + venue_id + "cal" + json_result[index][index2]).addClass('bg-prereserve');
//       } else {
//         $("." + venue_id + "cal" + json_result[index][index2]).addClass('bg-prereserve');
//       }
//     }
//     $('.bg-prereserve:last').css('background', 'gray');
//   }
// })