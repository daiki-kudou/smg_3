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
      $('#fullOverlay').css('display', 'none');
      console.log($result);
      $.each($result, function ($index, $value) {
        $('#enter_time, #leave_time').find('option').each(function ($key2, $value2) {
          if ($value == $($value2).val()) {
            $($value2).prop("disabled", true);
          }
        })
      })
    })
    .fail(function ($result) {
      $('#fullOverlay').css('display', 'none');
      console.log("失敗");
      console.log($result);
    });
});
