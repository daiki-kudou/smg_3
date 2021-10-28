$(function () {
  $(function () {
    $('#fullOverlay').css('display', 'block');

    $('.PreResCre select').on('click', function () {
      var this_tr = $(this).parent().parent();
      var this_date = this_tr.find('td').eq(0).find('input').val();
      var this_venue = this_tr.find('td').eq(1).find('select').val();
      var this_enter = this_tr.find('td').eq(2).find('select');
      var this_leave = this_tr.find('td').eq(3).find('select');
      initializeTimeOption(this_enter);
      initializeTimeOption(this_leave);
      if (this_date !== "" && this_venue !== "") {
        resultGetTimeAjax(this_date, this_venue, this_enter);
        resultGetTimeAjax(this_date, this_venue, this_leave);
      }
    })
    $('.PreResCre input').on('click', function () {
      var this_tr = $(this).parent().parent();
      var this_date = this_tr.find('td').eq(0).find('input').val();
      var this_venue = this_tr.find('td').eq(1).find('select').val();
      var this_enter = this_tr.find('td').eq(2).find('select');
      var this_leave = this_tr.find('td').eq(3).find('select');
      initializeTimeOption(this_enter);
      initializeTimeOption(this_leave);
      if (this_date !== "" && this_venue !== "") {
        resultGetTimeAjax(this_date, this_venue, this_enter);
        resultGetTimeAjax(this_date, this_venue, this_leave);
      }
    })
    $('#fullOverlay').css('display', 'none');

  })


  function resultGetTimeAjax(date, venue_id, target) {
    getTimeAjax(date, venue_id).done(function ($result) {
      $('#fullOverlay').css('display', 'none');
      target.find('option').each(function ($index, $element) { //メイン時間
        $.each($result, function ($resultIndex, $resultValue) { //ajax結果
          if ($result.length == $resultIndex + 1) {
            return false; //最後はdisabledしない。管理者は たとえば10~12:00で予約が入ってたら12:00から予約がとれる
          }
          if ($($element).val() == $resultValue) {
            $($element).prop('disabled', true);
          }
        })
      })
    }).fail(function ($result) {
      console.log("ajax失敗");
      console.log($result);
    });
  }

  function getTimeAjax($date, $venue_id) {
    return $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: rootPath + '/admin/control_time',
      type: 'POST',
      data: { 'date': $date, 'venue_id': $venue_id },
      dataType: 'json',
      beforeSend: function () {
        $('#fullOverlay').css('display', 'block');
      },
    })
  }

  function initializeTimeOption($target) {
    $target.find('option').each(function ($index, $element) {
      $($element).prop('disabled', false);
    })
  }
})