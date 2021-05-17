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
      resultGetTimeAjax(date, venue_id, target);
    });
  }

  function resultGetTimeAjax(date, venue_id, target) {
    getTimeAjax(date, venue_id).done(function ($result) {
      $('#fullOverlay').css('display', 'none');
      target.find('option').each(function ($index, $element) { //メイン時間
        $.each($result, function ($resultIndex, $resultValue) { //ajax結果
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
      url: '/admin/control_time',
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