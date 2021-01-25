$(function () {

  $('#agent_id').on('blur', function () {
    var agent_id = $('select[name="agent_id"] option:selected').val();
    ajaxGetAgent(agent_id);
  });

  function ajaxGetAgent($agent_id) {
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '/admin/agents_reservations/get_agent',
      type: 'POST',
      data: {
        'agent_id': $agent_id,
      },
      dataType: 'json',
      beforeSend: function () {
        $('#fullOverlay').css('display', 'block');
      },
    })
      .done(function ($agent) {
        $('#fullOverlay').css('display', 'none');
        $('.cost_percent').val($agent[0]);
        $('.selected_person').val($agent[2] + $agent[1]);
      })
      .fail(function ($agent) {
        $('#fullOverlay').css('display', 'none');
        console.log('ajaxGetAgent失敗', $agent);
        swal('仲介会社を選択してください');
      });
  };
})


$(function () {
  $('form').on('change', function () {
    var date = $('#datepicker1').val();
    var agent_id = $('#agent_id').val();
    var venues_selector = $('#venues_selector').val();

    if (date && agent_id && venues_selector) {
      $('#calculate').removeClass('disabled');
    } else {
      if (!$('#calculate').hasClass('disabled')) {
        $('#calculate').addClass('disabled');
      }
    }
  })

})