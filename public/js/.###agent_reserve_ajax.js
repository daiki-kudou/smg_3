$(function () {
  $('#agent_id').select2({ width: '100%' });
  $('#venues_selector').select2({ width: '100%' });
  $('#sales_start').select2({ width: '100%' });
  $('#sales_finish').select2({ width: '100%' });
  $('#event_start').select2({ width: '100%' });
  $('#event_finish').select2({ width: '100%' });
})

$(function () {
  $('#agent_id').on('change', function () {
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
        $('.agent_cost').val($agent[0]);
        $('.selected_person').val($agent[2] + $agent[1]);
      })
      .fail(function ($agent) {
        $('#fullOverlay').css('display', 'none');
        console.log('ajaxGetAgent失敗', $agent);
        swal('仲介会社を選択してください');
      });
  };
});


$(function () {
  $('form').on('change', function () {
    var date = $('#datepicker1').val();
    var agent_id = $('#agent_id').val();
    var venues_selector = $('#venues_selector').val();
    var end_charge = $('#end_charge').val();

    if (date && agent_id && venues_selector && end_charge) {
      $('#calculate').removeClass('disabled');
    } else {
      if (!$('#calculate').hasClass('disabled')) {
        $('#calculate').addClass('disabled');
      }
    }
  })
});


$(function () {
  $('#venues_selector').on('change', function () {
    var dates = $('#datepicker1').val();
    var venue_id = $('#venues_selector').val();
    $('#sales_start').val();
    $('#sales_finish').val();

    ajaxGetItems(venue_id);
    ajaxGetSalesHours(venue_id, dates);
    // ajaxGetOperatinSystem(venue_id); //会場形態の判別 直営 or　提携
    ajaxGetPriceStstem(venue_id);

    ajaxGetLayout(venue_id); //レイアウトが存在するかしないか、　"0"か"1"でreturn
    ajaxGetLuggage(venue_id); //会場に荷物預りが存在するかしないか、　"0"か"1"でreturn
    // ajaxGetOperatinSystem(venue_id); //会場形態の判別 直営 or　提携
  });
})

function ajaxGetItems($venue_id) {
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: '/admin/reservations/geteitems',
    type: 'POST',
    data: { 'venue_id': $venue_id },
    dataType: 'json',
    beforeSend: function () {
      $('#fullOverlay').css('display', 'block');
    },
  })
    .done(function ($items) {
      $('#fullOverlay').css('display', 'none');
      $('.equipemnts table tbody').html(''); //一旦初期会
      $.each($items[0], function (index, value) {
        // ココで備品取得
        var data1 = "<tr><td>"
          + value['item']
          + "</td>"
          + "<td><input type='text' value='0' min=0 name='equipemnt"
          + index
          + "' class='form-control'></td></tr>";
        $('.equipemnts table tbody').append(data1);
      });
      // ***********マイナス、全角制御用
      function ExceptString($target) {
        $target.numeric({ negative: false, });
        $target.on('change', function () {
          charactersChange($(this));
        })
        charactersChange = function (ele) {
          var val = ele.val();
          var han = val.replace(/[Ａ-Ｚａ-ｚ０-９]/g, function (s) {
            return String.fromCharCode(s.charCodeAt(0) - 0xFEE0)
          });
          if (val.match(/[Ａ-Ｚａ-ｚ０-９]/g)) {
            $(ele).val(han);
          }
        }
      }
      ExceptString($(".equipemnts table tbody input[name^='equipemnt']"));

      $('.services table tbody').html('');
      $.each($items[1], function (index, value) {
        // ココでサービス取得
        // 有り・無しに変更するため以下コメントアウト
        var data2 = "<tr><td>"
          + value['item']
          + "</td>"
          + "<td><input type='radio' value='1' name='service"
          + index
          + "'>有り<input type='radio' value='0' name='service"
          + index
          + "' checked>無し</td></tr>";
        $('.services table tbody').append(data2);
      });
    })
    .fail(function (data) {
      $('#fullOverlay').css('display', 'none');
      $('.equipemnts table tbody').html('');
      $('.services table tbody').html('');
      console.log("item失敗");
    });
};


function ajaxGetSalesHours($venue_id, $dates) {
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: '/admin/reservations/getsaleshours',
    type: 'POST',
    data: { 'venue_id': $venue_id, 'dates': $dates },
    dataType: 'json',
    beforeSend: function () {
      $('#fullOverlay').css('display', 'block');
    },
  })
    .done(function ($times) {
      $('#fullOverlay').css('display', 'none');
      // 初期化
      $("#sales_start option").each(function ($result) {
        $('#sales_start option').eq($result).prop('disabled', false);
      });
      $("#sales_finish option").each(function ($result) {
        $('#sales_finish option').eq($result).prop('disabled', false);
      });


      for (let index = 0; index < $times[0].length; index++) {
        $("#sales_start option").each(function ($result) {
          if ($times[0][index] == $('#sales_start option').eq($result).val()) {
            $('#sales_start option').eq($result).prop('disabled', true);
          }
        });
      };

      for (let index = 0; index < $times[0].length; index++) {
        $("#sales_finish option").each(function ($result) {
          if ($times[0][index] == $('#sales_finish option').eq($result).val()) {
            $('#sales_finish option').eq($result).prop('disabled', true);
          }
        });
      }


    })
    .fail(function ($times) {
      $('#fullOverlay').css('display', 'none');
      console.log('失敗', $times);
    });
};

function ajaxGetPriceStstem($venue_id) {
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: '/admin/reservations/getpricesystem',
    type: 'POST',
    data: { 'venue_id': $venue_id },
    dataType: 'json',
    beforeSend: function () {
      $('#fullOverlay').css('display', 'block');
    },
  })
    .done(function ($prices) {
      $('#fullOverlay').css('display', 'none');
      if ($prices[0].length > 0 && $prices[1].length > 0) { //配列の空チェック
        //どちらも配列ある
        $('#price_system_radio1').prop('checked', false).prop('disabled', false); //初期化
        $('#price_system_radio2').prop('checked', false).prop('disabled', false); //初期化
      } else if ($prices[0].length > 0 && $prices[1].length == 0) {
        //時間枠がある・アクセアがない
        $('#price_system_radio1').prop('checked', false).prop('disabled', false); //初期化
        $('#price_system_radio2').prop('checked', false).prop('disabled', false); //初期化
        $('#price_system_radio1').prop('checked', true);
        $('#price_system_radio2').prop('disabled', true);
      } else if ($prices[0].length == 0 && $prices[1].length > 0) {
        //時間枠がない・アクセアがある
        $('#price_system_radio1').prop('checked', false).prop('disabled', false); //初期化
        $('#price_system_radio2').prop('checked', false).prop('disabled', false); //初期化
        $('#price_system_radio2').prop('checked', true);
        $('#price_system_radio1').prop('disabled', true);
      } else {
        // どちらも配列がない
        swal('選択した会場は登録された料金体系がありません。会場管理/料金管理 にて作成してください');
        $('#price_system_radio1').prop('checked', false).prop('disabled', true); //初期化
        $('#price_system_radio2').prop('checked', false).prop('disabled', true); //初期化
      }
    })
    .fail(function ($prices) {
      $('#fullOverlay').css('display', 'none');
      // $('.price_selector').html('');
      console.log('失敗したよ');
      $('#price_system_radio1').prop('checked', false).prop('disabled', true); //初期化
      $('#price_system_radio2').prop('checked', false).prop('disabled', true); //初期化

    });
};

function ajaxGetLayout($venue_id) {
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: '/admin/reservations/getlayout',
    type: 'POST',
    data: {
      'venue_id': $venue_id
    },
    dataType: 'json',
    beforeSend: function () {
      $('#fullOverlay').css('display', 'block');
    },
  })
    .done(function ($result) {
      $('#fullOverlay').css('display', 'none');
      console.log($result);
      $('.layouts table tbody').html(''); //初期化
      $result == 1 ? $('.layouts table tbody').append("<tr><td>レイアウト準備</td><td><input type='radio' name='layout_prepare' id='layout_prepare' value='1'><label for='layout_prepare'>有り</label><input type='radio' name='layout_prepare' id='no_layout_prepare' value='0' checked >  <label for='no_layout_prepare'>無し</label></td></tr><tr><td>レイアウト片付</td><td><input type='radio' name='layout_clean' id='layout_clean' value='1'><label for='layout_clean'>有り</label><input type='radio' name='layout_clean' id='no_layout_clean' value='0'checked><label for='no_layout_clean'>無し</label></td></tr>") : $('.layouts table tbody').append('<tr><td>該当会場はレイアウト変更を受け付けていません</td></tr>');
    })
    .fail(function ($result) {
      $('#fullOverlay').css('display', 'none');
      swal('レイアウトの取得に失敗しました。ページをリロードし再度試して下さい!!!!');
    });
};


function ajaxGetLuggage($venue_id) {
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: '/admin/reservations/getluggage',
    type: 'POST',
    data: {
      'venue_id': $venue_id
    },
    dataType: 'json',
    beforeSend: function () {
      $('#fullOverlay').css('display', 'block');
    },
  })
    .done(function ($luggage) {
      if ($luggage == 1) {
        $('.luggage table tbody').html('');
        $('.luggage table tbody').append("<tr> <td>事前に預かる荷物<br>（個数）</td> <td class=''><input type='text' class='form-control luggage_count' placeholder='個数入力' name='luggage_count'></td> </tr> <tr> <td>事前荷物の到着日<br>午前指定のみ</td> <td class=''> <input id='datepicker3' type='text' class='form-control' placeholder='年-月-日' name='luggage_arrive'> </td> </tr> <tr> <td>事後返送する荷物</td> <td class=''><input type='text' class='form-control luggage_return' placeholder='個数入力' name='luggage_return'></td> </tr> <tr><td>荷物預かり　料金</td><td class=''><input type='text' class='form-control luggage_price' placeholder='金額入力' name='luggage_price'></td></tr><script>$('#datepicker3').datepicker({ dateFormat: 'yy-mm-dd', minDate: 0, });</script>");
        // ***********マイナス、全角制御用
        function ExceptString($target) {
          $target.numeric({ negative: false, });
          $target.on('change', function () {
            charactersChange($(this));
          })
          charactersChange = function (ele) {
            var val = ele.val();
            var han = val.replace(/[Ａ-Ｚａ-ｚ０-９]/g, function (s) { return String.fromCharCode(s.charCodeAt(0) - 0xFEE0) });
            if (val.match(/[Ａ-Ｚａ-ｚ０-９]/g)) {
              $(ele).val(han);
            }
          }
        }
        ExceptString($(".luggage table tbody input[name='luggage_count']"));
        ExceptString($(".luggage table tbody input[name='luggage_return']"));
        ExceptString($(".luggage table tbody input[name='luggage_price']"));
      } else {
        $('.luggage table tbody').html('');
        $('.luggage table tbody').append("<tr><td class='colspan='2''>該当会場は荷物預りを受け付けていません</td></tr>");
      }
    })
    .fail(function ($luggage) {
      $('#fullOverlay').css('display', 'none');
      swal('荷物預りの取得に失敗しました。ページをリロードし再度試して下さい!!!!');
    });
};

// 計算する
$(function () {
  $('#calculate').on('click', function () {
    var venue_id = $('#venues_selector').val();
    var end_charge = Number($('#end_charge').val());
    var agent_cost = Number($('#agent_cost').val() / 100);
    var cost_result = end_charge - (end_charge * agent_cost);
    var cost_result_tax = cost_result * 0.1;
    var cost_total = cost_result + cost_result_tax

    $('.venue_extend').val(cost_result);
    $('.after_discount_price').val(cost_result);
    $('.venue_price_details tbody tr:first-child td:nth-child(2)').text(cost_result);
    $('.venue_price_details tbody tr:first-child td:nth-child(4)').text(cost_result);
    $('.venue_subtotal').val(cost_result);
    $('.venue_tax').val(cost_result_tax);
    $('.venue_total').val(cost_total);

    var layout_prepare = Number($('input:radio[name="layout_prepare"]:checked').val());
    var layout_clean = Number($('input:radio[name="layout_clean"]:checked').val());
    ajaxGetLayoutPrice(venue_id, layout_prepare, layout_clean);

    var agent_id = $('#agent_id').val();
    var date = $('#datepicker1').val();
    ajaxGetAgentPayDetails(agent_id, date);


    setTimeout(function () {
      var venue_subtotal = Number($('.venue_subtotal').val());
      var layout_subtotal = Number($('.layout_subtotal').val());
      var agent_venue_layout = venue_subtotal + layout_subtotal;
      $('.agent_venue_sub_total').val(venue_subtotal);
      $('.agent_layout_sub_total').val(layout_subtotal);
      $('.agent_sub_total').val(agent_venue_layout);
      $('.agent_tax').val(agent_venue_layout * 0.1);
      $('.agent_total').val(agent_venue_layout + (agent_venue_layout * 0.1));


    }, 1000);


  })
})

function ajaxGetLayoutPrice($venue_id, $layout_prepare, $layout_clean) {
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: '/admin/reservations/getlayoutprice',
    type: 'POST',
    data: {
      'venue_id': $venue_id,
      'layout_prepare': $layout_prepare,
      'layout_clean': $layout_clean,
    },
    dataType: 'json',
    beforeSend: function () {
      $('#fullOverlay').css('display', 'block');
    },
  })
    .done(function ($result) {
      $('#fullOverlay').css('display', 'none');
      if ($result[0]) {
        $('.layout_prepare_result').val($result[0][0][0]);
        $('.layout_clean_result').val($result[0][1][0]);
        $('.layout_total').val($result[1]);
        $('.after_duscount_layouts').val($result[1]);
        $('.selected_layouts tbody').html('');
        $.each($result[0], function (index, value) {
          var data = "<tr>"
            + "<td>" + value[1] + "</td>"
            + "<td>" + value[0] + "</td>"
            + "<td>1</td>"
            + "<td>" + value[0] + "</td>"
            + "</tr>";
          if (value) {
            $('.selected_layouts tbody').append(data);
          };
        });
        $('.layout_subtotal').val($result[1]);
        $('.layout_tax').val($result[1] * 0.1);
        $('.layout_total_amount').val(($result[1] * 0.1) + $result[1]);
      };
    })
    .fail(function ($result) {
      $('#fullOverlay').css('display', 'none');
      swal('レイアウトの金額取得に失敗しました。ページをリロードし再度試して下さい!!!!');
    });
};



$(function () {
  $('#datepicker1').on('change', function () {
    var dates = $('#datepicker1').val();
    var venue_id = $('#venues_selector').val();
    // ajaxGetItems(venue_id);
    ajaxGetSalesHours(venue_id, dates);

    // if ($('.select2-hidden-accessible').val() != null) { //顧客が選択されていたら、支払い期日抽出
    //   var user_id = $('.select2-hidden-accessible').val();
    //   ajaxGetClients(user_id);
    // }
  });
});

function ajaxGetSalesHours($venue_id, $dates) {
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: '/admin/reservations/getsaleshours',
    type: 'POST',
    data: { 'venue_id': $venue_id, 'dates': $dates },
    dataType: 'json',
    beforeSend: function () {
      $('#fullOverlay').css('display', 'block');
    },
  })
    .done(function ($times) {
      $('#fullOverlay').css('display', 'none');
      // 初期化
      $("#sales_start option").each(function ($result) {
        $('#sales_start option').eq($result).prop('disabled', false);
      });
      $("#sales_finish option").each(function ($result) {
        $('#sales_finish option').eq($result).prop('disabled', false);
      });


      for (let index = 0; index < $times[0].length; index++) {
        $("#sales_start option").each(function ($result) {
          if ($times[0][index] == $('#sales_start option').eq($result).val()) {
            $('#sales_start option').eq($result).prop('disabled', true);
          }
        });
      };

      for (let index = 0; index < $times[0].length; index++) {
        $("#sales_finish option").each(function ($result) {
          if ($times[0][index] == $('#sales_finish option').eq($result).val()) {
            $('#sales_finish option').eq($result).prop('disabled', true);
          }
        });
      }


    })
    .fail(function ($times) {
      $('#fullOverlay').css('display', 'none');
      console.log('失敗', $times);
    });
};



function ajaxGetAgentPayDetails($agent_id, $date) {
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: '/admin/agents_reservations/pay_limits',
    type: 'POST',
    data: {
      'agent_id': $agent_id, 'date': $date
    },
    dataType: 'text',
    beforeSend: function () {
      $('#fullOverlay').css('display', 'block');
    },
  })
    .done(function ($agent_results) {
      $('#fullOverlay').css('display', 'none');
      console.log($agent_results);
      $('input[name="payment_limit"]').val($agent_results);
    })
    .fail(function ($agent_results) {
      console.log('agent_results 失敗', $agent_results)
      $('#fullOverlay').css('display', 'none');
    });
};