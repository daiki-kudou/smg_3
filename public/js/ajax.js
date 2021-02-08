// reservation create　会場選択からの備品取得// 以下参考// https://niwacan.com/1619-laravel-ajax/
$(function () {
  ////////////////////
  // ロードトリガー
  ////////////////////
  // var param = location.search;
  // if (param) {
  //   //パラメーターがある場合
  //   function getParam(name, url) {
  //     if (!url) url = window.location.href;
  //     name = name.replace(/[\[\]]/g, "\\$&");
  //     var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
  //       results = regex.exec(url);
  //     if (!results) return null;
  //     if (!results[2]) return '';
  //     return decodeURIComponent(results[2].replace(/\+/g, " "));
  //   }
  //   var reserve_date = getParam('reserve_date');
  //   var venue_id = getParam('venue_id');
  //   var price_system = getParam('price_system');
  //   var enter_time = getParam('enter_time');
  //   var leave_time = getParam('leave_time');
  //   var board_flag = getParam('board_flag');
  //   var event_start = getParam('event_start');
  //   var event_finish = getParam('event_finish');
  //   var event_name1 = getParam('event_name1');
  //   var event_name2 = getParam('event_name2');
  //   var event_owner = getParam('event_owner');
  //   var user_id = getParam('user_id');
  //   var in_charge = getParam('in_charge');
  //   var tel = getParam('tel');
  //   var email_flag = getParam('email_flag');
  //   var cost = getParam('cost');
  //   var discount_condition = getParam('discount_condition');
  //   var attention = getParam('attention');
  //   var user_details = getParam('user_details');
  //   var admin_details = getParam('admin_details');

  //   // 会場挿入
  //   ajaxGetItems(venue_id);
  //   ajaxGetSalesHours(venue_id, dates);
  //   ajaxGetPriceStstem(venue_id);
  //   ajaxGetLayout(venue_id);
  //   ajaxGetLuggage(venue_id);
  //   ajaxGetOperatinSystem(venue_id);
  //   // 日付挿入
  //   ajaxGetSalesHours(venue_id, reserve_date);
  //   // ユーザー挿入
  //   ajaxGetClients(user_id);
  //   // 会場料金挿入
  //   ajaxGetPriceDetails(venue_id, price_system, enter_time, leave_time); //料金計算

  // }
  // else {
  //   // パラメーターがない場合
  // }



  // var venue_id = $('#venues_selector').val();

  // // requestに会場が入っていれば
  // if (venue_id) { //空じゃなければ
  //   $('#sales_start').val();
  //   $('#sales_finish').val();
  //   ajaxGetItems(venue_id);
  //   // ajaxGetSalesHours(venue_id, dates);　管理者は24時間予約登録可能。そのため一旦、本機能停止
  //   ajaxGetPriceStstem(venue_id);
  //   ajaxGetLayout(venue_id); //レイアウトが存在するかしないか、　"0"か"1"でreturn
  //   ajaxGetLuggage(venue_id); //会場に荷物預かりが存在するかしないか、　"0"か"1"でreturn
  //   ajaxGetOperatinSystem(venue_id); //会場形態の判別 直営 or　提携
  //   var hidden_venue = $('input[name="bill_company"]');
  //   var target_venue_id = $(this).val();
  //   hidden_venue.val(target_venue_id);
  // }

  // //requestに顧客情報があれば
  // var client_id = $('#user_select').val();
  // var date = $('#datepicker1').val();

  // if (client_id == 1) {
  //   var dt = new Date(date);
  //   var three_days_before = dt.setDate(dt.getDate() - 3); //営業日前
  //   three_days_before = new Date(three_days_before);
  //   var target_name = $('input[name="payment_limit"]');
  //   var target_name2 = $('input[name="bill_pay_limit"]');
  //   target_name.val(three_days_before.getFullYear() + '-' + (('0' + (three_days_before.getMonth() + 1)).slice(-2)) + '-' + (('0' + three_days_before.getDate()).slice(-2)));
  //   target_name2.val(three_days_before.getFullYear() + '-' + (('0' + (three_days_before.getMonth() + 1)).slice(-2)) + '-' + (('0' + three_days_before.getDate()).slice(-2)));
  // } else if (client_id == 2) {
  //   var dt = new Date(date);
  //   var end_of_month = new Date(dt.getFullYear(), dt.getMonth() + 1, 0);　//当月末日
  //   var target_name = $('input[name="payment_limit"]');
  //   var target_name2 = $('input[name="bill_pay_limit"]');
  //   target_name.val(end_of_month.getFullYear() + '-' + (('0' + (end_of_month.getMonth() + 1)).slice(-2)) + '-' + (('0' + end_of_month.getDate()).slice(-2)));
  //   target_name2.val(end_of_month.getFullYear() + '-' + (('0' + (end_of_month.getMonth() + 1)).slice(-2)) + '-' + (('0' + end_of_month.getDate()).slice(-2)));
  // } else if (client_id == 3) {
  //   var dt = new Date(date);
  //   var end_of_next_month = new Date(dt.getFullYear(), dt.getMonth() + 2, 0);
  //   var target_name = $('input[name="payment_limit"]');
  //   var target_name2 = $('input[name="bill_pay_limit"]');
  //   target_name.val(end_of_next_month.getFullYear() + '-' + (('0' + (end_of_next_month.getMonth() + 1)).slice(-2)) + '-' + (('0' + end_of_next_month.getDate()).slice(-2)));
  //   target_name2.val(end_of_next_month.getFullYear() + '-' + (('0' + (end_of_next_month.getMonth() + 1)).slice(-2)) + '-' + (('0' + end_of_next_month.getDate()).slice(-2)));
  // };





  // 会場選択トリガー
  $('#venues_selector').on('input', function () {
    var dates = $('#datepicker1').val();
    var venue_id = $('#venues_selector').val();
    $('#sales_start').val();
    $('#sales_finish').val();

    ajaxGetItems(venue_id);
    ajaxGetSalesHours(venue_id, dates);
    ajaxGetPriceStstem(venue_id);
    ajaxGetLayout(venue_id); //レイアウトが存在するかしないか、　"0"か"1"でreturn
    ajaxGetLuggage(venue_id); //会場に荷物預かりが存在するかしないか、　"0"か"1"でreturn
    ajaxGetOperatinSystem(venue_id); //会場形態の判別 直営 or　提携
    // var hidden_venue = $('input[name="bill_company"]');
    // var target_venue_id = $(this).val();
    // hidden_venue.val(target_venue_id);
  });

  // 日付選択トリガー
  $('#datepicker1').on('change', function () {
    var dates = $('#datepicker1').val();
    var venue_id = $('#venues_selector').val();
    // ajaxGetItems(venue_id);
    ajaxGetSalesHours(venue_id, dates);

  });

  // 顧客選択トリガー
  // $('.select2-hidden-accessible').on('change', function () {
  //   var user_id = $(this).val();//user_idを取得
  //   if ($('#datepicker1').val() == '') {
  //     swal('予約の支払期日設定に失敗しました。必ず【利用日】を選択してください');
  //     $('.select2-hidden-accessible').val('');
  //     $('.select2-selection__rendered').text('');
  //     alert(user_id);
  //   } else {
  //     ajaxGetClients(user_id);
  //     var hidden_venue = $('input[name="bill_company"]');
  //     var target_venue_id = $(this).val();
  //     hidden_venue.val(target_venue_id);

  //   }
  // })

  /*--------------------------------------------------
  // 計算するボタン押下トリガー
  --------------------------------------------------*/
  $('#calculate').on('click', function () {
    var venue_id = $('#venues_selector').val();
    var radio_val = $('input:radio[name="price_system"]:checked').val();
    var start_time = $('#sales_start').val();
    var finish_time = $('#sales_finish').val();
    ajaxGetPriceDetails(venue_id, radio_val, start_time, finish_time); //料金計算

    // 備品の数取得
    var equipemnts_array = [];
    var equipemnts_length = $('.equipemnts table tbody tr').length;
    for (let equipemnts_index = 0; equipemnts_index < equipemnts_length; equipemnts_index++) {
      var e_target = $('.equipemnts table tbody tr').eq(equipemnts_index).find('input').val();
      equipemnts_array.push(e_target);
    }

    // サービスの数取得
    var services_array = [];
    var services_length = $('.services table tbody tr').length;
    for (let services_index = 0; services_index < services_length; services_index++) {
      // console.log('サービスの_index', services_index);
      var s_target = $('.services table tbody tr').eq(services_index).find("input:radio[name='" + 'service' + (services_index) + "']:checked").val();
      services_array.push(Number(s_target));
    }
    // console.log('サービスの数', services_array);

    ajaxGetItemsDetails(venue_id, equipemnts_array, services_array);

    // レイアウト金額取得
    var layout_prepare = $('input:radio[name="layout_prepare"]:checked').val();
    var layout_clean = $('input:radio[name="layout_clean"]:checked').val();
    ajaxGetLayoutPrice(venue_id, layout_prepare, layout_clean);

    // 割引入力部分、全部初期化
    $('.venue_discount_percent').val('');
    $('.venue_dicsount_number').val('');
    $('.discount_item').val('');
    $('.layout_discount').val('');

    // 手入力部分初期化
    $('input[name^="hand_input"]').each(function (index, elem) {
      $(elem).val('');
    })

    var user_id = $('.select2-hidden-accessible').val();
    ajaxGetClients(user_id);




    // 関数処理の順番にばらつきがあるので、１秒後に実行
    setTimeout(function () {
      // 総請求額反映用
      var all_total_venue = Number($('.venue_extend').val()); //会場料　税抜　料金　（割引反映前）
      var all_total_items = Number($('.selected_items_total').val()); //備品　その他　税抜　料金　（割引反映前）
      var all_total_layouts = Number($('.layout_total').val()); //備品　その他　税抜　料金　（割引反映前）
      var all_totals = all_total_venue + all_total_items + all_total_layouts;
      var only_tax = Math.floor(Number(all_totals) * 0.1);
      $('.all-total-without-tax').text(all_totals);
      $('.all-total-without-tax').val(all_totals);
      $('.all-total-tax').text(only_tax);
      $('.all-total-tax').val(only_tax);
      $('.all-total-amout').text(Number(all_totals) + Number(only_tax));
      $('.all-total-amout').val(Number(all_totals) + Number(only_tax));
      // 以下hidden
      $('#sub_total').val(all_totals);
      $('#tax').val(only_tax);
      $('#total').val(Number(all_totals) + Number(only_tax));


      //詳細内訳初期化
      $('input[name^="venue_breakdowns"]').remove();
      $('input[name^="equipment_breakdowns"]').remove();
      $('input[name^="layout_breakdowns"]').remove();

      // 以下、料金詳細内訳
      var target_v = $('.venue_price_details tbody tr').length;
      for (let c_v = 0; c_v < target_v; c_v++) {
        // 内訳に入るtdは固定で4つ（内容、単価、数量、金額）
        for (let counter = 0; counter < 4; counter++) {
          var unit_venue = $('.venue_price_details tbody tr').eq(c_v).find('td').eq(counter).text();
          $('form').append("<input type='text' name='venue_breakdowns" + c_v + "_" + counter + "' value='" + unit_venue + "'>");
        }
      }
      // 以下、備品・サービス詳細内訳
      var target_e = $('.items_equipments tbody tr').length;
      for (let c_e = 0; c_e < target_e; c_e++) {
        // 内訳に入るtdは固定で4つ（内容、単価、数量、金額）
        for (let counter = 0; counter < 4; counter++) {
          var unit_equipment = $('.items_equipments tbody tr').eq(c_e).find('td').eq(counter).text();
          $('form').append("<input type='text' name='equipment_breakdowns" + c_e + "_" + counter + "' value='" + unit_equipment + "'>");
        }
      }
      // 以下、レイアウト詳細内訳
      var target_l = $('.selected_layouts tbody tr').length;
      for (let c_l = 0; c_l < target_l; c_l++) {
        // 内訳に入るtdは固定で4つ（内容、単価、数量、金額）
        for (let counter = 0; counter < 4; counter++) {
          var unit_layout = $('.selected_layouts tbody tr').eq(c_l).find('td').eq(counter).text();
          $('form').append("<input type='text' name='layout_breakdowns" + c_l + "_" + counter + "' value='" + unit_layout + "'>");
        }
      }

    }, 1000);
  });

  // 備品とサービス取得ajax
  function ajaxGetItems($venue_id) {
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '/admin/reservations/geteitems',
      type: 'POST',
      data: { 'venue_id': $venue_id, 'text': 'Ajax成功' },
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
          $('.equipemnts table tbody').append("<tr><td>" + value['item'] + "</td>" + "<td><input type='text' value='0' min=0 name='equipment_breakdown" + index + "' class='form-control'></td></tr>");
        });
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
        ExceptString($(".equipemnts table tbody input[name^='equipemnt']"));
        // ***********マイナス、全角制御用


        $('.services table tbody').html('');
        $.each($items[1], function (index, value) {
          // ココでサービス取得
          // 有り・無しに変更するため以下コメントアウト
          $('.services table tbody').append("<tr><td>" + value['item'] + "</td>" + "<td><input type='radio' value='1' name='services_breakdown" + index + "' id='service" + index + "on'><label for='service" + index + "on'>有り</label><input type='radio' value='0' id='service" + index + "off' name='services_breakdown" + index + "' checked><label for='service" + index + "off'>無し</label></td></tr>");
        });
      })
      .fail(function (data) {
        $('#fullOverlay').css('display', 'none');
        $('.equipemnts table tbody').html('');
        $('.services table tbody').html('');
        // console.log("item失敗");
      });
  };


  // 新規予約時の入退室時間の制御
  // 管理者は24時間予約登録可能。そのため一旦、本機能停止
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
        // console.log('失敗', $times);

        // $('#sales_start').html('');//初期化
        // $('#sales_finish').html('');//初期化
        // $('#event_start').html('');//初期化
        // $('#event_finish').html(''); //初期化
      });
  };

  // 料金体系取得
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
        // console.log('失敗したよ');
        $('#price_system_radio1').prop('checked', false).prop('disabled', true); //初期化
        $('#price_system_radio2').prop('checked', false).prop('disabled', true); //初期化

      });
  };

  // 料金詳細　取得
  function ajaxGetPriceDetails($venue_id, $status, $start, $finish) {
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '/admin/reservations/getpricedetails',
      type: 'POST',
      data: {
        'venue_id': $venue_id,
        'status': $status,
        'start': $start,
        'finish': $finish,
      },
      dataType: 'json',
      beforeSend: function () {
        $('#fullOverlay').css('display', 'block');
      },
    })
      .done(function ($details) {
        $('#fullOverlay').css('display', 'none');
        // 手入力部分は初期化
        $('#handinput_venue').val('');
        $('#handinput_extend').val('');
        $('#handinput_discount').val('');
        $('#handinput_subtotal').text('');
        $('#handinput_tax').text('');
        $('#handinput_total').text('');
        $('.hand_input').hasClass('hide') ? '' : $('.hand_input').addClass('hide');
        $('.bill-bg').hasClass('hide') ? $('.bill-bg').removeClass('hide') : '';
        //[0]は合計料金, [1]は延長料金, [2]は利用時間, [3]は延長時間
        var venue_extend_price = ($details[0][0]);
        var extend_price = ($details[0][1]);
        var usage = ($details[0][2]);
        var extend_time = ($details[0][3]);
        // console.log($details);
        $('.extend').val('');
        $('.venue_price').val('');
        $('.after_discount_price').text('');
        $('.after_discount_price').val('');
        $('.venue_subtotal').val(''); //小計
        $('.venue_tax').val(''); //消費税
        $('.venue_total').val(''); //会場合計料金
        $('.venue_extend').val(venue_extend_price);
        $('.extend').val(extend_price);
        $('.venue_price').val(venue_extend_price - extend_price);
        $('.after_discount_price').text(venue_extend_price);
        $('.after_discount_price').val(venue_extend_price);
        if ((extend_price) == 0) {
          $('.venue_price_details table tbody').html('');
          $('.venue_price_details table tbody').append("<tr><td>" + '会場料金' + "</td><td>" + venue_extend_price + "</td><td>" + '1' + "</td><td>" + venue_extend_price + "</td></tr>").trigger('create');
          $('.after_discount_price').text(venue_extend_price);
          $('.after_discount_price').val(venue_extend_price);
          $('.venue_subtotal').val(venue_extend_price); //小計
          $('.venue_tax').val(Math.floor(Number((venue_extend_price)) * 0.1)); //消費税
          $('.venue_total').val(Number((venue_extend_price)) + (Math.floor(Number(venue_extend_price * 0.1)))); //会場合計料金
        } else {
          $('.venue_price_details table tbody').html('');
          $('.venue_price_details table tbody').append("<tr><td>" + '会場料金' + "</td><td>" + ((venue_extend_price) - (extend_price)) + "</td><td>" + '1' + "</td><td>" + ((venue_extend_price) - (extend_price)) + "</td></tr>").trigger('create');
          $('.venue_price_details table tbody').append("<tr><td>" + '延長料金' + "</td><td>" + extend_price + "</td><td>" + extend_time + "H</td><td>" + extend_price + "</td></tr>").trigger('create');
          $('.after_discount_price').text(venue_extend_price);
          $('.after_discount_price').val(venue_extend_price);
          $('.venue_subtotal').val(venue_extend_price); //小計
          $('.venue_tax').val(Math.floor(Number(venue_extend_price) * 0.1)); //消費税
          $('.venue_total').val(Number(venue_extend_price) + (Math.floor(Number(venue_extend_price * 0.1)))); //会場合計料金
        }
      })
      .fail(function ($details) {
        $('#fullOverlay').css('display', 'none');
        swal("料金の取得に失敗しました.", '枠料金にて入退室時間が08:00~23:00で入力した場合はページをリロードし再度条件を変え再計算してください。もし08:00~23:00以外で入力した場合は、そのまま進み会場料金を手入力してください')
          .then((value) => {
            swal(`アクセア料金を選択し利用時間が15時間を超過した場合、そのまま進み会場料金を手入力してください`);
          });
        $('.extend').val('');
        $('.venue_price').val('');
        $('.after_discount_price').text('');
        $('.after_discount_price').val('');
        $('.venue_subtotal').val(''); //小計
        $('.venue_tax').val(''); //消費税
        $('.venue_total').val(''); //会場合計料金
        $('.venue_price_details table tbody').html('');

        // $('.bill-bg .bill-box:first-child').addClass('hide');
        $('.hand_input').removeClass('hide');
        $('#handinput_venue').val('');
        $('#handinput_extend').val('');
        $('#handinput_discount').val('');
        $('#handinput_subtotal').text('');
        $('#handinput_tax').text('');
        $('#handinput_total').text('');
      });
  };

  // 備品＆サービス　料金取得
  function ajaxGetItemsDetails($venue_id, $equipemnts, $services) {
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '/admin/reservations/geteitemsprices',
      type: 'POST',
      data: {
        'venue_id': $venue_id,
        'equipemnts': $equipemnts,
        'services': $services,
      },
      dataType: 'json',
      beforeSend: function () {
        $('#fullOverlay').css('display', 'block');
      },
    })
      .done(function ($each) {
        // console.log('成功？？', $each);

        $('#fullOverlay').css('display', 'none');
        // ※$eachの[0][0]には備品とサービスの合計料金
        // ※$eachの[0][1]には連想配列で選択された備品の個数、単価、備品名
        // ※$eachの[0][2]には連想配列で選択されたサービスの個数、単価、備品名
        // ※$eachの[0][3]には備品の合計金額
        // ※$eachの[0][4]にはサービスの合計金額
        var count_equipments = ($each[0][1]).length;
        $('.items_equipments table tbody').html(''); //テーブル初期化
        $('.selected_equipments_price').val(''); //有料備品料金初期化
        $('.selected_services_price').val(''); //有料サービス料金初期化
        $('.selected_items_total').val(''); //有料備品＆有料サービス合計初期化
        $('.items_discount_price').val(''); //割引後 会場料金合計初期化
        $('.items_subtotal').val(''); //小計初期化
        $('.items_tax').val(''); //消費税初期化
        $('.all_items_total').val('');　//請求総額初期化
        $('.selected_luggage_price').val('');　//請求総額初期化
        for (let counter = 0; counter < count_equipments; counter++) {
          var data1 = "<tr><td>"
            + $each[0][1][counter][0]
            + "</td><td>"
            + $each[0][1][counter][1]
            + "</td><td>"
            + $each[0][1][counter][2]
            + "</td><td>"
            + (($each[0][1][counter][1]) * ($each[0][1][counter][2]))
            + "</td></tr>";
          $('.items_equipments table tbody').append(data1);
        }
        var count_services = ($each[0][2]).length;
        for (let counter_s = 0; counter_s < count_services; counter_s++) {
          var data2 = "<tr><td>"
            + $each[0][2][counter_s][0]
            + "</td><td>"
            + $each[0][2][counter_s][1]
            + "</td><td>"
            + $each[0][2][counter_s][2]
            + "</td><td>"
            + (($each[0][2][counter_s][1]) * ($each[0][2][counter_s][2]))
            + "</td></tr>";
          $('.items_equipments table tbody').append(data2);
        }
        //荷物の金額が入力したら反映
        var luggage_target = $('.luggage_price').val();
        // luggage_target == 0 || luggage_target == '' ? 0 : luggage_target;
        if (luggage_target != 0 || luggage_target != '') {
          if ($('.items_equipments table tbody').hasClass('luggage_input_price')) {
            $('.luggage_input_price').remove();
            var data3 = "<tr class='luggage_input_price'><td>"
              + '荷物預かり/返送'
              + "</td><td>"
              + luggage_target
              + "</td><td>"
              + '1' + "</td><td>"
              + luggage_target
              + "</td></tr>";
            $('.items_equipments table tbody').append(data3);
          }
          // else {
          //   var data4 = "<tr class='luggage_input_price'><td>"
          //     + '荷物預かり/返送'
          //     + "</td><td>"
          //     + luggage_target
          //     + "</td><td>"
          //     + '1' + "</td><td>"
          //     + luggage_target
          //     + "</td></tr>";
          //   $('.items_equipments table tbody').append(data4);
          // }
        } else {
          $('.luggage_input_price').remove();
        }
        luggage_target = luggage_target ? Number(luggage_target) : 0;
        $('.selected_equipments_price').val($each[0][3]);
        $('.selected_services_price').val($each[0][4]);
        $('.selected_luggage_price').val(luggage_target);
        $('.selected_items_total').val(Number($each[0][0]) + Number(luggage_target));
        $('.items_discount_price').val(Number($each[0][0]) + Number(luggage_target));
        $('.items_subtotal').val(Number($each[0][0]) + Number(luggage_target));
        $('.items_tax').val(Math.floor((Number($each[0][0]) + Number(luggage_target)) * 0.1));
        $('.all_items_total').val((Math.floor((Number($each[0][0]) + Number(luggage_target)) * 0.1)) + (Number($each[0][0]) + Number(luggage_target)));
      })
      .fail(function ($each) {
        $('#fullOverlay').css('display', 'none');
        // console.log('備品又はサービスの料金取得に失敗しました。ページをリロードし再度試して下さい');
        // console.log('備品エラー', $each);
        $('.items_equipments table tbody').html(''); //テーブル初期化
        $('.selected_equipments_price').val(''); //有料備品料金初期化
        $('.selected_services_price').val(''); //有料サービス料金初期化
        $('.selected_items_total').val(''); //有料備品＆有料サービス合計初期化
        $('.items_discount_price').val(''); //割引後 会場料金合計初期化
        $('.items_subtotal').val(''); //小計初期化
        $('.items_tax').val(''); //消費税初期化
        $('.selected_luggage_price').val('');　//荷物アヅカリ
      });
  };

  // レイアウト有りなし判別
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
        // console.log($result);
        $('.layouts table tbody').html(''); //初期化
        var data =
          $result == 1 ? $('.layouts table tbody').append("<tr><td>レイアウト準備</td><td><input type='radio' name='layout_prepare' id='layout_prepare' value='1'><label for='layout_prepare'>有り</label><input type='radio' name='layout_prepare' id='no_layout_prepare' value='0' checked >  <label for='no_layout_prepare'>無し</label></td></tr><tr><td>レイアウト片付</td><td><input type='radio' name='layout_clean' id='layout_clean' value='1'><label for='layout_clean'>有り</label><input type='radio' name='layout_clean' id='no_layout_clean' value='0'checked><label for='no_layout_clean'>無し</label></td></tr>") : $('.layouts table tbody').append('<tr><td>該当会場はレイアウト変更を受け付けていません</td></tr>');
      })
      .fail(function ($result) {
        $('#fullOverlay').css('display', 'none');
        swal('レイアウトの取得に失敗しました。ページをリロードし再度試して下さい!!!!');
      });
  };

  // レイアウト金額取得
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
        // console.log($result[0]);
        $('.selected_layouts table tbody').html('');
        for (let s_layout = 0; s_layout < $result[0].length; s_layout++) {
          if ($result[0][s_layout] != '') {
            $('.selected_layouts table tbody').append("<tr><td>" + $result[0][s_layout][1] + "</td><td>" + $result[0][s_layout][0] + "</td><td>1</td><td>" + $result[0][s_layout][0] + "</td></tr>")
          }
        }
        $('.layout_prepare_result').val('');
        $('.layout_clean_result').val('');
        $('.layout_total').val('');
        $('.layout_subtotal').val('');
        $('.layout_tax').val('');
        $('.layout_total_amount').val('');
        $('.layout_prepare_result').val($result[0][0][0]); //レイアウト準備
        $('.layout_clean_result').val($result[0][1][0]); //レイアウト片付け
        $('.layout_total').val($result[1]);
        $('.layout_subtotal').val($result[1]);
        $('.layout_tax').val(Math.floor(Number($result[1]) * 0.1));
        $('.layout_total_amount').val((Math.floor(Number($result[1]) * 0.1)) + (Number($result[1])));
        $('.after_duscount_layouts').val($result[1]);
      })
      .fail(function ($result) {
        $('#fullOverlay').css('display', 'none');
        swal('レイアウトの金額取得に失敗しました。ページをリロードし再度試して下さい!!!!');
      });
  };


  // 荷物預かり　有りなし判別
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
          $('.luggage table tbody').append("<tr> <td>事前に預かる荷物<br>（個数）</td> <td class=''><input type='text' class='form-control luggage_count' placeholder='個数入力' name='luggage_count'></td> </tr> <tr> <td>事前荷物の到着日<br>午前指定のみ</td> <td class=''> <input id='datepicker3' type='text' class='form-control' placeholder='年-月-日' name='luggage_arrive'> </td> </tr> <tr> <td>事後返送する荷物</td> <td class=''><input type='text' class='form-control luggage_return' placeholder='個数入力' name='luggage_return'></td> </tr> <tr><td>荷物預かり/返送　料金</td><td class=''><input type='text' class='form-control luggage_price' placeholder='金額入力' name='luggage_price'></td></tr><script>$('#datepicker3').datepicker({ dateFormat: 'yy-mm-dd', minDate: 0, });</script>");
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
          $('.luggage table tbody').append("<tr><td class='colspan='2''>該当会場は荷物預かりを受け付けていません</td></tr>");
        }
      })
      .fail(function ($luggage) {
        $('#fullOverlay').css('display', 'none');
        swal('荷物預かりの取得に失敗しました。ページをリロードし再度試して下さい!!!!');
      });
  };

  // 直営 or 提携会場　判別
  function ajaxGetOperatinSystem($venue_id) {
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '/admin/reservations/getoperation',
      type: 'POST',
      data: {
        'venue_id': $venue_id
      },
      dataType: 'json',
      beforeSend: function () {
        $('#fullOverlay').css('display', 'block');
      },
    })
      .done(function ($operaions) {
        $('.sales_percentage').val('');
        $('.sales_percentage').val($operaions);
      })
      .fail(function ($operaions) {
        $('#fullOverlay').css('display', 'none');
        swal('会場の運営形態の取得に失敗しました');
      });
  };


  // 顧客　情報　取得
  function ajaxGetClients($user_id) {
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '/admin/clients/getclients',
      type: 'POST',
      data: {
        'user_id': $user_id
      },
      dataType: 'json',
      beforeSend: function () {
        $('#fullOverlay').css('display', 'block');
      },
    })
      .done(function ($user_results) {
        $('#fullOverlay').css('display', 'none');
        console.log('ajaxGetClients 成功', $user_results)
        // 1. ３営業日前　2. 当月末　3. 翌月末 のいずれかで返ってくる
        var s_date = $('#datepicker1').val();
        if ($user_results[0] == 1) {
          var dt = new Date(s_date);
          var three_days_before = dt.setDate(dt.getDate() - 3); //営業日前
          three_days_before = new Date(three_days_before);
          var target_name = $('input[name="payment_limit"]');
          var target_name2 = $('input[name="bill_pay_limit"]');
          target_name.val(three_days_before.getFullYear() + '-' + (('0' + (three_days_before.getMonth() + 1)).slice(-2)) + '-' + (('0' + three_days_before.getDate()).slice(-2)));
          target_name2.val(three_days_before.getFullYear() + '-' + (('0' + (three_days_before.getMonth() + 1)).slice(-2)) + '-' + (('0' + three_days_before.getDate()).slice(-2)));
          $('.selected_person').text('');
          $('.selected_person').text($user_results[1]);
          $('input[name="bill_person"]').val(''); //hiddenのbill_personに挿入
          $('input[name="bill_person"]').val($user_results[1]);//hiddenのbill_personに挿入
        } else if ($user_results[0] == 2) {
          var dt = new Date(s_date);
          var end_of_month = new Date(dt.getFullYear(), dt.getMonth() + 1, 0);　//当月末日
          var target_name = $('input[name="payment_limit"]');
          var target_name2 = $('input[name="bill_pay_limit"]');
          target_name.val(end_of_month.getFullYear() + '-' + (('0' + (end_of_month.getMonth() + 1)).slice(-2)) + '-' + (('0' + end_of_month.getDate()).slice(-2)));
          target_name2.val(end_of_month.getFullYear() + '-' + (('0' + (end_of_month.getMonth() + 1)).slice(-2)) + '-' + (('0' + end_of_month.getDate()).slice(-2)));
          $('.selected_person').text('');
          $('.selected_person').text($user_results[1]);
          $('input[name="bill_person"]').val(''); //hiddenのbill_personに挿入
          $('input[name="bill_person"]').val($user_results[1]);//hiddenのbill_personに挿入
        } else if ($user_results[0] == 3) {
          var dt = new Date(s_date);
          var end_of_next_month = new Date(dt.getFullYear(), dt.getMonth() + 2, 0);
          var target_name = $('input[name="payment_limit"]');
          var target_name2 = $('input[name="bill_pay_limit"]');
          target_name.val(end_of_next_month.getFullYear() + '-' + (('0' + (end_of_next_month.getMonth() + 1)).slice(-2)) + '-' + (('0' + end_of_next_month.getDate()).slice(-2)));
          target_name2.val(end_of_next_month.getFullYear() + '-' + (('0' + (end_of_next_month.getMonth() + 1)).slice(-2)) + '-' + (('0' + end_of_next_month.getDate()).slice(-2)));
          $('.selected_person').text('');
          $('.selected_person').text($user_results[1]);
          $('input[name="bill_person"]').val(''); //hiddenのbill_personに挿入
          $('input[name="bill_person"]').val($user_results[1]);//hiddenのbill_personに挿入  
        };
      })
      .fail(function ($user_results) {
        console.log('ajaxGetClients 失敗', $user_results)
        $('#fullOverlay').css('display', 'none');
        swal('顧客情報の取得に失敗しました。');
      });
  };
});


























