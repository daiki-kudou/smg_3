

$(function () {
  $('#datepicker8').on('change', function () {
    $('input[name="date"]').val($(this).val());
    $('#s_calendar').submit();
  })
})


$(function () {
  for (let index = 0; index < $('input[name="start"]').length; index++) {
    // var reservation_id = $('input[name="reservation_id"]').eq(index).val();
    // var venue_id = $('input[name="venue_id"]').eq(index).val();
    var venue_name = $('input[name="venue_name"]').eq(index).val();
    // var user_id = $('input[name="user_id"]').eq(index).val();
    // var start = $('input[name="start"]').eq(index).val();
    // var finish = $('input[name="finish"]').eq(index).val();
    var status = $('input[name="status"]').eq(index).val();

    var json = $('input[name="json"]').val();
    var json_result = JSON.parse(json);

    var target_length = (json_result[index]).length;
    for (let index2 = 0; index2 < target_length; index2++) {
      //最後のみ描写しないためbreak
      if (index2 == target_length - 1) {
        break;
      }
      // 以下ステータス別色分け
      if (status > 3) {
        $("." + venue_name + "cal" + json_result[index][index2]).addClass('bg-prereserve');
      } else if (status == 3) {
        $("." + venue_name + "cal" + json_result[index][index2]).addClass('bg-reserve');
      }
    }
    $('.bg-reserve:last').css('background', 'gray');
  }
})

$(function () {
  for (let index = 0; index < $('input[name="pre_reservation_start"]').length; index++) {
    // var reservation_id = $('input[name="reservation_id"]').eq(index).val();
    // var venue_id = $('input[name="venue_id"]').eq(index).val();
    var venue_name = $('input[name="pre_reservation_venue_name"]').eq(index).val();

    // var user_id = $('input[name="user_id"]').eq(index).val();
    // var start = $('input[name="start"]').eq(index).val();
    // var finish = $('input[name="finish"]').eq(index).val();
    // var status = $('input[name="status"]').eq(index).val();

    var json = $('input[name="pre_json"]').val();
    var json_result = JSON.parse(json);

    var target_length = (json_result[index]).length;


    for (let index2 = 0; index2 < target_length; index2++) {
      //最後のみ描写しないためbreak
      // if (index2 == target_length - 1) {
      //   break;
      // }
      $("." + venue_name + "cal" + json_result[index][index2]).addClass('bg-prereserve');
      console.log(venue_name, json_result[index][index2]);

    }
    $('.bg-reserve:last').css('background', 'gray');
  }
})

