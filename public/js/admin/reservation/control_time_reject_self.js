$(function () {

  $(function () {
    $('#sales_start').on('click', function () {
      // 仮抑え入室時間クリック制御開始
      preReservationControlTime("#sales_start", $("#sales_start"));
      // 仮抑え退室時間クリック制御開始
      preReservationControlTime("#sales_finish", $("#sales_finish"));
    })
  })

  function preReservationControlTime(targetClass, targetElement) {
    $(document).on('click', targetClass, function () {
      var target = targetElement;
      initializeTimeOption(target);
      var date = $('input[name="reserve_date"]').val();
      var venue_id = $('select[name="venue_id"]').val();
      if (venue_id == undefined) {
        venue_id = $('input[name="venue_id"]').val();
      }
      var reservation_id = $('input[name="reservation_id"]').val();
      resultGetTimeAjax(date, venue_id, target, reservation_id);
    });
  }

  function resultGetTimeAjax(date, venue_id, target, reservation_id) {
    getTimeAjax(date, venue_id, reservation_id).done(function ($result) {
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

  function getTimeAjax($date, $venue_id, $reservation_id) {
    return $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      //rootPathを付与
      url: rootPath + '/admin/control_time_reject_self',
      type: 'POST',
      data: { 'date': $date, 'venue_id': $venue_id, 'reservation_id': $reservation_id },
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