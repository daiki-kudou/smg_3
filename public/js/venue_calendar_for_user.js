// 予約カレンダー
$(function () {
  var json = JSON.parse($('input[name=each_json]').val());
  for (let index = 0; index < json.length; index++) {
    var status = $('input[name="status"]').eq(index).val();
    var date = $('input[name="date"]').eq(index).val();
    var reservation_id = $('input[name="reservation_id"]').eq(index).val();
    var company = $('input[name="company"]').eq(index).val();
    if (status < 3) {
      $.each(json[index], function ($index, $value) {
        $('.' + date + 'cal' + $value).addClass('bg-prereserve');
      })
    } else if (status == 3) {
      $.each(json[index], function ($index, $value) {
        $('.' + date + 'cal' + $value).addClass('bg-reserve');
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
    })

  }
})













