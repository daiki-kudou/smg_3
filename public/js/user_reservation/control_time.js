// 会場選択トリガー。該当会場の入退室時間制御
$(document).on("change", "#venue_id", function () {
  var date = $('input[name="date"]').val();
  var venue_id = $(this).val();
  $('#enter_time,#leave_time').find('option').each(function ($key, $value) {
    $($value).prop('disabled', false);
  })
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: 'control_time',
    type: 'post',
    data: { 'date': date, 'venue_id': venue_id },
    dataType: 'json',
    beforeSend: function () {
      $('#fullOverlay').css('display', 'block');
    },
  })
    .done(function ($result) {
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

// 入室時間トリガー、08:00~10:00は最低利用時間3時間
$(document).on("change", "#enter_time", function () {
  for (let index = 1; index <= 5; index++) { //時間selectの08:00から10:00までのkeyに一旦クラスをあてる
    $('#leave_time').find('option').eq(index).prop("disabled", true)
  }
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
    url: 'control_time',
    type: 'post',
    data: { 'date': date, 'venue_id': venue_id },
    dataType: 'json',
    beforeSend: function () {
      $('#fullOverlay').css('display', 'block');
    },
  })
    .done(function ($result) {
      $('#fullOverlay').css('display', 'none');
      // console.log($result);
      // $.each($result, function ($index, $value) {
      //   $('#enter_time, #leave_time').find('option').each(function ($key2, $value2) {
      //     if ($value == $($value2).val()) {
      //       $($value2).prop("disabled", true);
      //     }
      //   })
      // })
      console.log($result);
      $('#enter_time, #leave_time').html("<option value=''></option>");
      $('#fullOverlay').css('display', 'none');
      $.each($result, function ($index, $value) {
        console.log($value);
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