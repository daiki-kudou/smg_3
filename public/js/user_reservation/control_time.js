$(document).on("change", "#venue_id", function () {
  var date = $('input[name="date"]').val();
  var venue_id = $(this).val();
  $('#enter_time').find('option').each(function ($key, $value) {
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


      // $('#enter_time').find('option').each(function (key, value) {
      // if ($result[0] == $(value).val()) {
      //   $(value).prop("disabled", true);
      // } else if ($result[1] == $(value).val()) {
      //   $(value).prop("disabled", true);
      // } else if ($(value).prev("option").prop("disabled")) {
      //   $(value).prop("disabled", true);
      // } else if ($result[2] == $(value).val()) {
      //   $(value).prop("disabled", true);
      // } else if ($result[3] == $(value).val()) {
      //   $(value).prop("disabled", true);
      // } else if ($(value).prev("option").prop("disabled")) {
      //   $(value).prop("disabled", true);
      //   return false;
      // };

      // if ($result[2] == $(value).val()) {
      //   $(value).prop("disabled", true);
      // } else if ($result[3] == $(value).val()) {
      //   $(value).prop("disabled", true);
      //   return false;
      // } else if ($(value).prev("option").prop("disabled")) {
      //   $(value).prop("disabled", true);
      // }
      // })
    })
    .fail(function ($result) {
      $('#fullOverlay').css('display', 'none');
      console.log("失敗");
      console.log($result);
    });
});
