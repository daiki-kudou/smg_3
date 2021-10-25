
$(function () {
  $('#equipment_id').multiSelect();
  $('#service_id').multiSelect();
});

$(function () {
  // 日付選択画面にてボックス内、検索機能
  $('#venue_id').select2({ width: '100%' });
  $('#venues_selector').select2({ width: '100%' });
  $('#agent_select').select2({ width: '100%' });
  $('#user_id').select2({ width: '100%' });
  $('#agent_id').select2({ width: '100%' });
  $('#user_select').select2({ width: '100%' });
});


// datepicker
$(function () {
  $('#datepicker1').datepicker({
    dateFormat: 'yy-mm-dd',
    minDate: 0,
    autoclose: true
  });
  $('#datepicker2').datepicker({
    dateFormat: 'yy-mm-dd',
    autoclose: true,
    minDate: 0,
  });
  $('#datepicker6').datepicker({
    dateFormat: 'yy-mm-dd',
    autoclose: true
  });
  $('#datepicker7').datepicker({
    dateFormat: 'yy-mm-dd',
    autoclose: true
  });
  $('#datepicker8').datepicker({
    dateFormat: 'yy-mm-dd',
    numberOfMonths: 3,
    showCurrentAtPos: 0,   // 表示位置は左から2番目 (真ん中)
    stepMonths: 1,         // 月の移動を3ヶ月単位とする
    autoclose: true
  });
  $('.datepicker').datepicker({
    dateFormat: 'yy-mm-dd',
    minDate: 0,
    autoclose: true
  });
  $('.datepicker_no_min_date').datepicker({
    dateFormat: 'yy-mm-dd',
    autoclose: true
  });
});

$(function () {
  var maxDate = $('input[name="reserve_date"]').val();
  $('.limited_datepicker').datepicker({
    dateFormat: 'yy-mm-dd',
    autoclose: true,
    minDate: 0,
    maxDate: maxDate
  })
})


// reservatiosn create の時間取得
// 一旦やめる。別の予約が入っていないか制御する必要あり
$(function () {
  $('#timepicker1').wickedpicker({
    now: "12:00", //hh：mm 24時間形式のみ、デフォルトは現在時刻
    twentyFour: true, //24時間形式を表示します。デフォルトはfalseです。
    title: '時間入力', //Wickedpickerのタイトル
    minutesInterval: 30, //分間隔を変更します。デフォルトは1です。  
  });
  $('#timepicker2').wickedpicker({
    now: "12:00", //hh：mm 24時間形式のみ、デフォルトは現在時刻
    twentyFour: true, //24時間形式を表示します。デフォルトはfalseです。
    title: '時間入力', //Wickedpickerのタイトル
    minutesInterval: 30, //分間隔を変更します。デフォルトは1です。  
  });
});

// プラスマイナスボタン
$(function () {
  $('.equipemnts .icon_minus').on('click', function () {
    $('.equipemnts table tbody').slideUp();
    $('.equipemnts .icon_minus').addClass('hide');
    $('.equipemnts .icon_plus').removeClass('hide');
  })
  $('.equipemnts .icon_plus').on('click', function () {
    $('.equipemnts table tbody').slideDown();
    $('.equipemnts .icon_plus').addClass('hide');
    $('.equipemnts .icon_minus').removeClass('hide');
  })
  $('.services .icon_minus').on('click', function () {
    $('.services table tbody').slideUp();
    $('.services .icon_minus').addClass('hide');
    $('.services .icon_plus').removeClass('hide');
  })
  $('.services .icon_plus').on('click', function () {
    $('.services table tbody').slideDown();
    $('.services .icon_plus').addClass('hide');
    $('.services .icon_minus').removeClass('hide');
  })
})

// 請求内容のプラスマイナスボタン　開閉
$(function () {
  function OpenClose($target) {
    $($target).on('click', function () {
      var minus = $(this).children().find('.fa-minus');
      var plus = $(this).children().find('.fa-plus');
      var main = $(this).next();
      $(minus).toggleClass('hide');
      $(plus).toggleClass('hide');
      $(minus).addClass('fa-spin');
      $(plus).addClass('fa-spin');
      setTimeout(function () {
        $(minus).removeClass('fa-spin');
        $(plus).removeClass('fa-spin');
      }, 300);
      $(main).slideToggle();
    })
  }
  OpenClose('.bill_details .head');
  OpenClose('.information_details .head');

})

// $(function () {
//   $('.check_alert').on('click', function () {
//     if (!confirm('入力内容と反映された請求の一致を確認しましたか？')) {
//       return false;
//     } else {
//     }
//   })
// })


// 予約新規登録、入退室時間があれば、イベント開始終了の時間制御
$(function () {
  $('#event_start, #event_finish').on('click', function () {
    var parent_target_start = $('#sales_start').val();
    var parent_target_finish = $('#sales_finish').val();
    var target = ($(this).find('option')).length;
    for (let index = 0; index < target; index++) {
      if ($(this).find('option').eq(index).val() < parent_target_start || $(this).find('option').eq(index).val() > parent_target_finish) {
        $(this).find('option').eq(index).prop('disabled', true);
      }
    }
  })
  $('#sales_start').on('change', function () {
    var child_target = $('#event_start').val();
    $('#event_start option').prop('disabled', false);
    if ($(this).val() > child_target) {
      $('#event_start').val('');
      // swal('イベント開始時間は入室時間より後に設定してください');
    }
  })
  $('#sales_finish').on('change', function () {
    var child_target2 = $('#event_finish').val();
    $('#event_finish option').prop('disabled', false);
    if ($(this).val() < child_target2) {
      $('#event_finish').val('');
      // swal('イベント終了時間は退室時間より前に設定してください');
    }
  })
})

// submit確認
$(function () {
  // $('.first_double_check').on('click', function () {
  //   $("html,body").animate({ scrollTop: $('.double_check1_name').offset().top });
  // })
  // $('.second_double_check').on('click', function () {
  //   $("html,body").animate({ scrollTop: $('.double_check2_name').offset().top });
  // })
})


// マイナスは赤字に
// function toRed() {
//   $('input').each(function (index, element) {
//     var target = Number($(element).val());
//     target < 0 ? $(element).css('color', 'red') : $(element).css('color', '#495057');
//   });
// }

function change_all_totals() {
  var venue = Number($('input[name="venue_price"]').val());
  var equipment = Number($('input[name="equipment_price"]').val());
  var layout = Number($('input[name="layout_price"]').val());
  var others = $('input[name="others_price"]').val() == "" ? 0 : Number($('input[name="others_price"]').val());
  venue ? venue : venue = 0;
  equipment ? equipment : equipment = 0;
  layout ? layout : layout = 0;
  others ? others : others = 0;
  var result = venue + equipment + layout + others;
  var result_tax = Math.floor(result * 0.1);
  $('.total_result').text('').text((result + result_tax));
  $('input[name="master_subtotal"]').val(result);
  $('input[name="master_tax"]').val(result_tax);
  $('input[name="master_total"]').val(result + result_tax);
}

// admin reservations calculate
$(function () {
  function discounts(
    venue_number_discount,
    venue_percent_discount,
    venue_price,
    venue_discount_btn,
    venue_input_discounts,
    venue_breakdown_discount_item,
    venue_breakdown_discount_cost,
    venue_breakdown_discount_count,
    venue_breakdown_discount_subtotal,
    venue_main
  ) {
    var number = $('input[name="' + venue_number_discount + '"]');
    var percent = $('input[name="' + venue_percent_discount + '"]');
    var price = Number($('input[name="' + venue_price + '"]').val());
    $(number).on('focus', function () {
      $(percent).val('');
    });
    $(percent).on('focus', function () {
      $(number).val('');
    });
    $('.' + venue_discount_btn).on('click', function () {
      $('.' + venue_input_discounts).remove();
      $('input[name="' + venue_price + '"]').val(price);
      if (number.val() != 0 && number.val() != '') {
        // 割引料金に金額があったら
        var p_r = Math.floor(Number((number.val() / price) * 100));
        var data1 = "<tr class='" + venue_input_discounts + "'>"
          + "<td>"
          + "<input class='form-control' readonly='' name='" + venue_breakdown_discount_item + "' type='text' value='"
          + "割引料金（" + p_r
          + "%）"
          + "'>"
          + "</td>"
          + "<td>"
          + "<input class='form-control' readonly='' name='" + venue_breakdown_discount_cost + "' type='text' value='"
          + (-number.val())
          + "'>"
          + "</td>"
          + "<td>"
          + "<input class='form-control' readonly='' name='" + venue_breakdown_discount_count + "' type='text' value='1'>"
          + "</td>"
          + "<td>"
          + "<input class='form-control' readonly='' name='" + venue_breakdown_discount_subtotal + "' type='text' value='"
          + (-number.val())
          + "'>"
          + "</td>"
          + "</tr>";
        $('.' + venue_main).append(data1);
        var change = price - Number(number.val());
        $('input[name="' + venue_price + '"]').val(change);
        // toRed();
      }
      if (percent.val() != 0 && percent.val() != '') {
        // 割引料金に金額があったら
        var n_r = (price * (percent.val() / 100));
        var data2 = "<tr class='" + venue_input_discounts + "'>"
          + "<td>"
          + "<input class='form-control' readonly='' name='" + venue_breakdown_discount_item + "' type='text' value='"
          + "割引料金（"
          + percent.val()
          + "%）"
          + "'>"
          + "</td>"
          + "<td>"
          + "<input class='form-control' readonly='' name='" + venue_breakdown_discount_cost + "' type='text' value='"
          + (-n_r)
          + "'>"
          + "</td>"
          + "<td><input class='form-control' readonly='' name='" + venue_breakdown_discount_count + "' type='text' value='1'></td>"
          + "<td>"
          + "<input class='form-control' readonly='' name='" + venue_breakdown_discount_subtotal + "' type='text' value='"
          + (-n_r)
          + "'>"
          + "</td>"
          + "</tr>";
        $('.' + venue_main).append(data2);
        var change = price - Number(n_r);
        $('input[name="' + venue_price + '"]').val(change);
        // toRed();
      }
      change_all_totals();
    })
  }
  discounts(
    'venue_number_discount', 'venue_percent_discount', 'venue_price',
    'venue_discount_btn', 'venue_input_discounts', 'venue_breakdown_discount_item',
    'venue_breakdown_discount_cost', 'venue_breakdown_discount_count', 'venue_breakdown_discount_subtotal',
    'venue_main'
  );
  discounts(
    'equipment_number_discount', 'equipment_percent_discount', 'equipment_price',
    'equipment_discount_btn', 'equipment_input_discounts', 'equipment_breakdown_discount_item',
    'equipment_breakdown_discount_cost', 'equipment_breakdown_discount_count',
    'equipment_breakdown_discount_subtotal', 'equipment_main'
  );
  discounts(
    'layout_number_discount', 'layout_percent_discount', 'layout_price',
    'layout_discount_btn', 'layout_input_discounts', 'layout_breakdown_discount_item',
    'layout_breakdown_discount_cost', 'layout_breakdown_discount_count', 'layout_breakdown_discount_subtotal',
    'layout_main'
  );
  discounts(
    'layout_number_discount', 'layout_percent_discount', 'layout_price',
    'layout_discount_btn', 'layout_input_discounts', 'layout_breakdown_discount_item',
    'layout_breakdown_discount_cost', 'layout_breakdown_discount_count', 'layout_breakdown_discount_subtotal',
    'layout_main'
  );
  discounts(
    'others_number_discount', 'others_percent_discount', 'others_price',
    'others_discount_btn', 'others_input_discounts',
    'others_breakdown_discount_item',
    'others_breakdown_discount_cost',
    'others_breakdown_discount_count',
    'others_breakdown_discount_subtotal',
    'others_main'
  );
})



// その他の計算用
$(function () {
  $(document).on('input', 'input[name^="others_input"]', function (e) {
    var count = $('.others_main tr').length;
    var total_val = 0;
    for (let index = 0; index < count; index++) {
      var num1 = $('input[name="others_input_cost' + index + '"]').val();
      var num2 = $('input[name="others_input_count' + index + '"]').val();
      var num3 = $('input[name="others_input_subtotal' + index + '"]');
      num3.val(num1 * num2);
      total_val = total_val + Number(num3.val());
    }
    var total_target = $('input[name="others_price"]');
    total_target.val(total_val);
    // toRed();
    change_all_totals();
  });
  $(document).on('input', 'input[name^="venue_breakdown"]', function (e) {
    var count = $('.venue_main tr').length;
    var total_val = 0;
    for (let index = 0; index < count; index++) {
      var num1 = $('input[name="venue_breakdown_cost' + index + '"]').val();
      var num2 = $('input[name="venue_breakdown_count' + index + '"]').val();
      var num3 = $('input[name="venue_breakdown_subtotal' + index + '"]');
      num3.val(num1 * num2);
      total_val = total_val + Number(num3.val());
    }
    var total_target = $('input[name="venue_price"]');
    total_target.val(total_val);
    // toRed();
    change_all_totals();
  });
})

$(function () {
  $(document).on('input', 'input[name^="others_breakdown"]', function (e) {
    var count = $('.others_main tr').length;
    var total_val = 0;
    for (let index = 0; index < count; index++) {
      var num1 = $('input[name="others_breakdown_cost' + index + '"]').val();
      var num2 = $('input[name="others_breakdown_count' + index + '"]').val();
      var num3 = $('input[name="others_breakdown_subtotal' + index + '"]');
      num3.val(num1 * num2);
      total_val = total_val + Number(num3.val());
    }
    var total_target = $('input[name="others_price"]');
    total_target.val(total_val);
    // toRed();
    change_all_totals();
  });
  $(document).on('input', 'input[name^="venue_breakdown"]', function (e) {
    var count = $('.venue_main tr').length;
    var total_val = 0;
    for (let index = 0; index < count; index++) {
      var num1 = $('input[name="venue_breakdown_cost' + index + '"]').val();
      var num2 = $('input[name="venue_breakdown_count' + index + '"]').val();
      var num3 = $('input[name="venue_breakdown_subtotal' + index + '"]');
      num3.val(num1 * num2);
      total_val = total_val + Number(num3.val());
    }
    var total_target = $('input[name="venue_price"]');
    total_target.val(total_val);
    // toRed();
    change_all_totals();
  });
})


// アコーディオン
$(function () {
  $(".accordion-wrap").show();
  $(".accordion-wrap2").show();
  $(".accordion-ttl").on("click", function () {
    $(this).next().slideToggle("fast");
    $(this).find(".title-icon").toggleClass("active");
  });

  $(".accordion-innbtn").on("click", function () {
    $(this).parent().slideToggle("");
  });
});

// $(function () {
//   $(".accordion-wrap2").show();
//   $(".accordion-ttl2").on("click", function () {
//     $(this).next().slideToggle("fast");
//     $(this).find(".title-icon").toggleClass("active");
//   });

//   $(".accordion-innbtn").on("click", function () {
//     $(this).parent().slideToggle("");
//   });
// });


// マイナスの場合の色変更
// $(function () {
//   $('.venue_main td:nth-child(2n) input').each(function (index, value) {
//     var target = $(value).val();
//     if (target.match(/-/)) {
//       $(value).css('color', 'red');
//     }
//   });
//   $('.equipment_main td:nth-child(2n) input').each(function (index, value) {
//     var target = $(value).val();
//     if (target.match(/-/)) {
//       $(value).css('color', 'red');
//     }
//   });
//   $('.layout_main td:nth-child(2n) input').each(function (index, value) {
//     var target = $(value).val();
//     if (target.match(/-/)) {
//       $(value).css('color', 'red');
//     }
//   });
//   $('.others_main td:nth-child(2n) input').each(function (index, value) {
//     var target = $(value).val();
//     if (target.match(/-/)) {
//       $(value).css('color', 'red');
//     }
//   });
// });

// $(function () {
//   $('.venue_main td:nth-child(2n), .equipment_main td:nth-child(2n), .layout_main td:nth-child(2n), .others_main td:nth-child(2n)').each(function (index, value) {
//     var target = $(value).text();
//     if (target.match(/-/)) {
//       $(value).css('color', 'red');
//       //   var result =target.replace('-','▲');
//       //   $(value).text(result);
//     }
//   });
// });











