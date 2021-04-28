

$(function () {
  $('#datepicker8').on('change', function () {
    $('input[name="date"]').val($(this).val());
    $('#s_calendar').submit();
  })
})


$(function () {
  for (let index = 0; index < $('input[name="start"]').length; index++) {
    var venue_name = $('input[name="venue_name"]').eq(index).val();
    var status = $('input[name="status"]').eq(index).val();
    var company = $('input[name="company"]').eq(index).val();
    var reservation_id = $('input[name="reservation_id"]').eq(index).val();

    var json = $('input[name="json"]').val();
    var json_result = JSON.parse(json);

    var target_length = (json_result[index]).length;
    for (let index2 = 0; index2 < target_length; index2++) {
      // 以下ステータス別色分け
      if (status == 3) {
        if (index2 == 0) {
          $("." + venue_name + "cal" + json_result[index][index2]).prev().addClass('gray');
          $("." + venue_name + "cal" + json_result[index][index2]).addClass('bg-reserve');
        } else {
          $("." + venue_name + "cal" + json_result[index][index2]).addClass('bg-reserve');
        }
        if ($("." + venue_name + "cal" + json_result[index][index2]).prev().hasClass('gray')) {
          $("." + venue_name + "cal" + json_result[index][index2]).html(
            "<a href='/admin/reservations/" + reservation_id + "'>" + company + "</a>"
          )
        };

      } else if (status < 3) {
        if (index2 == 0) {
          $("." + venue_name + "cal" + json_result[index][index2]).prev().addClass('gray');
          $("." + venue_name + "cal" + json_result[index][index2]).addClass('bg-prereserve');
        } else {
          $("." + venue_name + "cal" + json_result[index][index2]).addClass('bg-prereserve');
        }
      }
    }
    $('.bg-reserve:last').addClass('gray');
    $('.bg-prereserve:last').addClass('gray');
  }
})

$(function () {
  for (let index = 0; index < $('input[name="pre_reservation_start"]').length; index++) {
    var venue_name = $('input[name="pre_reservation_venue_name"]').eq(index).val();

    var json = $('input[name="pre_json"]').val();
    var json_result = JSON.parse(json);

    var target_length = (json_result[index]).length;


    for (let index2 = 0; index2 < target_length; index2++) {
      if (index2 == 0) {
        $("." + venue_name + "cal" + json_result[index][index2]).prev().addClass('gray');
        $("." + venue_name + "cal" + json_result[index][index2]).addClass('bg-prereserve');
      } else {
        $("." + venue_name + "cal" + json_result[index][index2]).addClass('bg-prereserve');
      }
    }
    $('.bg-prereserve:last').css('background', 'gray');
  }
})

