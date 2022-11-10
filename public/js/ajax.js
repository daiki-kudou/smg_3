// reservation create　会場選択からの備品取得// 以下参考// https://niwacan.com/1619-laravel-ajax/
$(function () {

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
    ajaxGetLuggage(venue_id); //会場に荷物預りが存在するかしないか、　"0"か"1"でreturn
    ajaxGetOperatinSystem(venue_id); //会場形態の判別 直営 or　提携
    ajaxGetEatIn(venue_id); //会場形態の判別 直営 or　提携

  });

  // 日付選択トリガー
  $('#datepicker1').on('change', function () {
    var dates = $('#datepicker1').val();
    var venue_id = $('#venues_selector').val();
    // ajaxGetItems(venue_id);
    ajaxGetSalesHours(venue_id, dates);
  });

  $(document).on("change", "#user_select", function () {
    var user_id = $('#user_select').val();
    $('.user_link').html('');
    $('.user_link').append("<a class='more_btn' target='_blank' rel='noopener' href='" + rootPath + "/admin/clients/" + user_id + "'>顧客詳細</a>")
    getUserDetails(user_id);
  });

  /*--------------------------------------------------
  // 計算するボタン押下トリガー
  --------------------------------------------------*/


  // 備品とサービス取得ajax
  function ajaxGetItems($venue_id) {
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: rootPath + '/admin/reservations/geteitems',
      type: 'POST',
      data: { 'venue_id': $venue_id, 'text': 'Ajax成功' },
      dataType: 'json',
      beforeSend: function () {
        // $('#fullOverlay').css('display', 'block');
      },
    })
      .done(function ($items) {
        // $('#fullOverlay').css('display', 'none');
        $('.equipemnts table tbody').html(''); //一旦初期会
        $.each($items[0], function (index, value) {
          // ココで備品取得
          var data = "<tr><td class='table-active'>" +
            value['item'] +
            "(" + (Number(value['price'])).toLocaleString() +
            "円)" + "</td>" +
            "<td><div class='d-flex align-items-end'><input type='number' value='' min=0 name='equipment_breakdown" +
            index + "' class='form-control equipment_breakdown' onInput='checkForm(this)'><span class='ml-1'>個</span></div></td></tr>";
          $('.equipemnts table tbody').append(data);
        });
        $('.services table tbody').html('');
        $.each($items[1], function (index, value) {
          // ココでサービス取得
          // あり・なしに変更するため以下コメントアウト
          $('.services table tbody').append("<tr><td class='table-active'>" + value['item'] + "(" + (Number(value['price'])).toLocaleString() + "円)" + "</td>" + "<td><input type='radio' value='1' name='services_breakdown" + index + "' id='service" + index + "on'><label class='mr-3 ml-1' for='service" + index + "on'>あり</label><input type='radio' value='0' id='service" + index + "off' name='services_breakdown" + index + "' checked><label for='service" + index + "off' class='ml-1'>なし</label></td></tr>");
        });
      })
      .fail(function (data) {
        $('.equipemnts table tbody').html('');
        $('.services table tbody').html('');
      });
  };


  // 新規予約時の入退室時間の制御
  // 管理者は24時間予約登録可能。そのため一旦、本機能停止
  function ajaxGetSalesHours($venue_id, $dates) {
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: rootPath + '/admin/reservations/getsaleshours',
      type: 'POST',
      data: { 'venue_id': $venue_id, 'dates': $dates },
      dataType: 'json',
      beforeSend: function () {
      },
    })
      .done(function ($times) {
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
      });
  };

  // 料金体系取得
  function ajaxGetPriceStstem($venue_id) {
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: rootPath + '/admin/reservations/getpricesystem',
      type: 'POST',
      data: { 'venue_id': $venue_id },
      dataType: 'json',
      beforeSend: function () {
      },
    })
      .done(function ($prices) {
        $('#price_system_radio1').prop('checked', false).prop('disabled', false); //初期化
        $('#price_system1').removeClass("hide");
        $('#price_system2').removeClass("hide");

        if ($prices[0].length > 0 && $prices[1].length > 0) { //配列の空チェック
          //どちらも配列ある
          $('#price_system_radio1').prop('checked', true);
        } else if ($prices[0].length > 0 && $prices[1].length == 0) {
          //時間枠がある・アクセアがない
          $('#price_system_radio1').prop('checked', true);
          $('#price_system2').addClass("hide");
        } else if ($prices[0].length == 0 && $prices[1].length > 0) {
          //時間枠がない・アクセアがある
          $('#price_system_radio2').prop('checked', true);
          $('#price_system1').addClass("hide");
        } else {
          // どちらも配列がない
          $('#price_system1').addClass("hide");
          $('#price_system2').addClass("hide");
          $('input[name="submit"]').prop('disabled', true);
          return false;
        }
        $('input[name="submit"]').prop('disabled', false);

      })
      .fail(function ($prices) {
        $('#price_system1').addClass("hide");
        $('#price_system2').addClass("hide");

      });
  };



  // レイアウトありなし判別
  function ajaxGetLayout($venue_id) {
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: rootPath + '/admin/reservations/getlayout',
      type: 'POST',
      data: {
        'venue_id': $venue_id
      },
      dataType: 'json',
      beforeSend: function () {
        // $('#fullOverlay').css('display', 'block');
      },
    })
      .done(function ($result) {
        $('.layouts table tbody').html(''); //初期化
        $result == 1 ? $('.layouts table tbody').append("<tr><td class='table-active'>準備</td><td><input type='radio' name='layout_prepare' id='layout_prepare' value='" + 1 + "' class='mr-1'><label for='layout_prepare' class='mr-2'>あり</label><input type='radio' name='layout_prepare' id='no_layout_prepare' value='" + 0 + "' checked class='mr-1'><label for='no_layout_prepare'>なし</label></td></tr><tr><td class='table-active'>片付</td><td><input type='radio' name='layout_clean' id='layout_clean' value='" + 1 + "' class='mr-1'><label for='layout_clean' class='mr-2'>あり</label><input type='radio' name='layout_clean' id='no_layout_clean' value='" + 0 + "'checked class='mr-1'><label for='no_layout_clean'>なし</label></td></tr>") : $('.layouts table tbody').append('<tr><td>該当会場はレイアウト変更を受け付けていません</td></tr>');
      })
      .fail(function ($result) {
        // $('#fullOverlay').css('display', 'none');
        swal('レイアウトの取得に失敗しました。ページをリロードし再度試して下さい!!!!');
      });
  };

  // レイアウト金額取得
  function ajaxGetLayoutPrice($venue_id, $layout_prepare, $layout_clean) {
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: rootPath + '/admin/reservations/getlayoutprice',
      type: 'POST',
      data: {
        'venue_id': $venue_id,
        'layout_prepare': $layout_prepare,
        'layout_clean': $layout_clean,
      },
      dataType: 'json',
      beforeSend: function () {
        // $('#fullOverlay').css('display', 'block');
      },
    })
      .done(function ($result) {
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
        $('.layout_clean_result').val($result[0][1][0]); //片付
        $('.layout_total').val($result[1]);
        $('.layout_subtotal').val($result[1]);
        $('.layout_tax').val(Math.floor(Number($result[1]) * 0.1));
        $('.layout_total_amount').val((Math.floor(Number($result[1]) * 0.1)) + (Number($result[1])));
        $('.after_duscount_layouts').val($result[1]);
      })
      .fail(function ($result) {
        console.log("ajax failed", $result);
      });
  };


  // 荷物預り　ありなし判別
  function ajaxGetLuggage($venue_id) {
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: rootPath + '/admin/reservations/getluggage',
      type: 'POST',
      data: {
        'venue_id': $venue_id
      },
      dataType: 'json',
      beforeSend: function () {
        // $('#fullOverlay').css('display', 'block');
      },
    })
      .done(function ($luggage) {
        if ($luggage == 1) {
          var maxDate = $('#datepicker').val();
          $('.luggage table tbody').html('');
          var data =
            "<tr>" +
            "<td class='table-active'>荷物預かり</td>" +
            "<td>" +
            "<div class='radio-box'>" +
            "<p>" +
            "<input id='luggage_flag' name='luggage_flag' type='radio' value='1'>" +
            "<label for='luggage_flag' class ='form-check-label'>あり</label>" +
            "</p>" +
            "<p>" +
            "<input id='no_luggage_flag' name='luggage_flag' type='radio' value='0' checked>" +
            "<label for='no_luggage_flag' class ='form-check-label'>なし</label>" +
            "</p>" +
            "</div>" +
            "<div class='mt-2 luggage-border'>"+
            "【事前・事後】預かりの荷物について<br>"+
            "事前預かり/事後返送ともに<span class='f-s20'>5個</span>まで。<br>"+
            "6個以上は要相談。その際は事前に必ずお問い合わせ下さい。<br>"+
            "荷物外寸合計(縦・横・奥行)120cm以下/個"+
            "</div>"+
            "</td>" +
            "</tr>" +
            "<tr>" +
            "<tr>" +
            "<td class='table-active'>事前に預かる荷物<br>（目安）</td>" +
            "<td class=''>" +
            "<input type='number' id='luggage_count' class='form-control luggage_count' placeholder='個数入力' name='luggage_count' min='0' readonly>" +
            "<p class='is-error-luggage_count' style='color: red'></p>" +
            "</td>" +
            "</tr>" +
            "<tr>" +
            "<td class='table-active'>事前荷物の到着日<br>(平日午前指定)</td>" +
            "<td class=''> <input id='luggage_arrive' type='text' autocomplete='off' class='form-control holidays' placeholder='年-月-日' name='luggage_arrive' readonly>" +
            "<div class='mt-1 luggage_info'>"+
            "※利用日3日前～前日（平日のみ）を到着日に指定下さい<br>※送付詳細 / 伝票記載方法は該当会場詳細ページ「備品 / サービス」タブの「荷物預かり / 返送 PDF」をご確認下さい。<br>※発送伝票（元払）/ 返送伝票（着払）は各自ご用意下さい。<br>※貴重品等のお預りはできかねます。<br>※事前荷物は入室時間迄に弊社が会場搬入します。"+
            "</div>"+
            "</td>" +
            "</tr>" +
            "<tr> " +
            "<td class='table-active'>事後返送する荷物</td>" +
            "<td class=''><input type='number' id='luggage_return' class='form-control luggage_return' placeholder='個数入力' name='luggage_return' readonly min=0>" +
            "<p class='is-error-luggage_return' style='color: red'></p>" +
            "<div class='mt-1 luggage_info'>"+
            "※返送時の「発送伝票（元払）/返送伝票（着払）」は会場内に用意しているものを必ず使用して下さい。"+
            "</div>"+
            "</td>" +
            "</tr>" +
            "<tr>" +
            "<td class='table-active'>荷物預かり料金(税抜)</td>" +
            "<td class=''>" +
            "<input type='text' id='luggage_price' autocomplete='off' class='form-control luggage_price' placeholder='金額入力' name='luggage_price' readonly>" +
            "<p class='is-error-luggage_price' style='color: red'></p>" +
            "</td>" +
            "</tr>";
          $('.luggage table tbody').append(data);
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
        // $('#fullOverlay').css('display', 'none');
        swal('荷物預りの取得に失敗しました。ページをリロードし再度試して下さい!!!!');
      });
  };

  // 直営 or 提携会場　判別
  function ajaxGetOperatinSystem($venue_id) {
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: rootPath + '/admin/reservations/getoperation',
      type: 'POST',
      data: {
        'venue_id': $venue_id
      },
      dataType: 'json',
      beforeSend: function () {

      },
    })
      .done(function ($operaions) {
        $('#user_cost').removeClass('hide');
        $('.sales_percentage').val('');
        if ($operaions[0] == 0) {
          $('#user_cost').addClass('hide');
        } else {
          $('.sales_percentage').val($operaions[1]);
        }
      })
      .fail(function ($operaions) {
        swal('会場の運営形態の取得に失敗しました');
      });
  };


  function getUserDetails(user_id) {
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: rootPath + '/admin/clients/getclients',
      type: 'POST',
      data: {
        'user_id': user_id
      },
      dataType: 'json',
      beforeSend: function () {
        $('#fullOverlay').css('display', 'block');
      },
    })
      .done(function ($user_results) {
        $('#fullOverlay').css('display', 'none');
        $('.person').text('').text($user_results[0]);
        $('.email').text('').text($user_results[1]);
        $('.mobile').text('').text($user_results[2]);
        $('.tel').text('').text($user_results[3]);
        var condition = $user_results[4];
        var attention = $user_results[5];
        $('.condition').html($('<dummy>').text(condition).html().replace(/\n/g, '<br>'));
        $('.attention').html($('<dummy>').text(attention).html().replace(/\n/g, '<br>'));
      })
      .fail(function ($user_results) {
        $('#fullOverlay').css('display', 'none');
        console.log("ajax failed", $user_results);
      });
  }

  function ajaxGetEatIn(venue_id) {
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: rootPath + '/admin/reservations/get_eat_in',
      type: 'POST',
      data: {
        'venue_id': venue_id
      },
      dataType: 'json',
      beforeSend: function () {
        $('#fullOverlay').css('display', 'block');
      },
    })
      .done(function ($result) {
        $('#fullOverlay').css('display', 'none');
        $('.eat_in').removeClass('hide');
        if ($result != 1) {
          $('.eat_in').addClass('hide');
        }
      })
      .fail(function ($result) {
        $('#fullOverlay').css('display', 'none');
        console.log("ajax failed", $result);
      });
  }
});




























