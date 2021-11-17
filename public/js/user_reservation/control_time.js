// 会場選択トリガー。該当会場の入退室時間制御
$(document).on("change ", "#venue_id", function () {
  var date = $('input[name="date"]').val();
  var venue_id = $(this).val();
  $('#enter_time,#leave_time').find('option').each(function ($key, $value) {
    $($value).prop('disabled', false);
  })
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: rootPath + '/control_time',
    type: 'post',
    data: { 'date': date, 'venue_id': venue_id },
    dataType: 'json',
    beforeSend: function () {
      $('#fullOverlay').css('display', 'block');
    },
  })
    .done(function ($result) {
      $('#enter_time').html("<option value=''></option>");
      $('#fullOverlay').css('display', 'none');
      $.each($result, function ($index, $value) {
        if ($value['active'] === 0) {
          var html1 = "<option value='" + $value['time'] + "' disabled>";
          var html2 = $value['value'];
          var html3 = "</option>";
          $('#enter_time').append(html1 + html2 + html3);
        } else {
          var html1 = "<option value='" + $value['time'] + "'>";
          var html2 = $value['value'];
          var html3 = "</option>";
          $('#enter_time').append(html1 + html2 + html3);
        }
      })
    })
    .fail(function ($result) {
      $('#fullOverlay').css('display', 'none');
      console.log("失敗");
      console.log($result);
    });
});

// 入室時間トリガー、08:00~10:00は最低利用時間3時間
$(document).on("change", "#enter_time", function () {
  $('#fullOverlay').css('display', 'block'); //cssで画面一旦ストップ
  $('#leave_time').html("<option value=''></option>");
  $('#fullOverlay').css('display', 'none');//cssで画面ストップ解除
  // 以下、入室時間以前と予約（仮押さえ）がある時間の除外開始
  var enter_time = $(this).val();
  $('#enter_time option').each(function ($key, $value) {
    if (enter_time === $($value).val()) {
      for (let index = $key; index < $('#enter_time option').length; index++) {
        if ($('#enter_time option').eq(index).prop('disabled')) {
          return false; //disabledがあれば処理中止
        };

        if ($('#enter_time option').eq(index).val() === "08:00:00" || $('#enter_time option').eq(index).val() === "08:30:00" || $('#enter_time option').eq(index).val() === "09:00:00" || $('#enter_time option').eq(index).val() === "09:30:00" || $('#enter_time option').eq(index).val() === "10:00:00") {
          var html1 = "<option value='" + $('#enter_time option').eq(index).val() + "' disabled>";  // 08~10ならならdisabled
        } else if ($('#enter_time option').eq(index).val() == enter_time) {
          var html1 = "<option value='" + $('#enter_time option').eq(index).val() + "' disabled>";  // 08~10ならならdisabled
        } else {
          var html1 = "<option value='" + $('#enter_time option').eq(index).val() + "'>";
        }

        var html2 = $('#enter_time option').eq(index).text();
        var html3 = "</option>";
        $('#leave_time').append(html1 + html2 + html3);
      }
    }
  })

  if (enter_time == "12:00:00" || enter_time == "12:30:00") {
    $('#leave_time option').each(function ($key, $value) {
      if ($($value).val() == '12:00:00' || $($value).val() == '12:30:00' || $($value).val() == '13:00:00') {
        $('#leave_time option').eq($key).prop('disabled', true);
      }
    });
  } else if (enter_time == "17:00:00" || enter_time == "17:30:00") {
    $('#leave_time option').each(function ($key, $value) {
      if ($($value).val() == '17:00:00' || $($value).val() == '17:30:00' || $($value).val() == '18:00:00') {
        $('#leave_time option').eq($key).prop('disabled', true);
      }
    });
  }

  var venue_id = $('#venue_id').val();
  ajaxCheckPriceSystem(venue_id).done(function ($prices) {
    console.log('成功', $prices);
    console.log('枠', $prices[0].length);
    console.log('時間', $prices[1].length);
    if ($prices[0].length === 0 && $prices[1].length > 0) {
      $('#leave_time option').each(function ($key, $value) {
        if (enter_time === $($value).val()) {
          for (let index = $key; index <= ($key + 5); index++) {
            $('#leave_time option').eq(index).prop('disabled', true);
          }
        }
      })
    }
  })
    .fail(function ($prices) {
      console.log('失敗', $prices);
    });
});



$(document).on("change", "#datepicker2", function () {
  var date = $(this).val();
  var venue_id = $('input[name="venue_id"]').val();
  $('#enter_time,#leave_time').find('option').each(function ($key, $value) {
    $($value).prop('disabled', false);
  })
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: rootPath + '/control_time',
    type: 'post',
    data: { 'date': date, 'venue_id': venue_id },
    dataType: 'json',
    beforeSend: function () {
      $('#fullOverlay').css('display', 'block');
    },
  })
    .done(function ($result) {
      $('#fullOverlay').css('display', 'none');
      $('#enter_time, #leave_time').html("<option value=''></option>");
      $('#fullOverlay').css('display', 'none');
      $.each($result, function ($index, $value) {
        if ($value['active'] === 0) {
          var html1 = "<option value='" + $value['time'] + "' disabled>";
          var html2 = $value['value'];
          var html3 = "</option>";
          $('#enter_time, #leave_time').append(html1 + html2 + html3);
        } else {
          var html1 = "<option value='" + $value['time'] + "'>";
          var html2 = $value['value'];
          var html3 = "</option>";
          $('#enter_time, #leave_time').append(html1 + html2 + html3);
        }
      })
    })
    .fail(function ($result) {
      $('#fullOverlay').css('display', 'none');
      console.log("失敗");
      console.log($result);
    });
});

function ajaxCheckPriceSystem($venue_id) {
  return $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: rootPath + '/getpricesystem',
    type: 'POST',
    data: { 'venue_id': $venue_id },
    dataType: 'json',
    beforeSend: function () {
    },
  })
};
