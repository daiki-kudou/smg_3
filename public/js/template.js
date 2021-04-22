
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
    showCurrentAtPos: 1,   // 表示位置は左から2番目 (真ん中)
    stepMonths: 0,         // 月の移動を3ヶ月単位とする
    autoclose: true
  });
  $('#datepicker99').datepicker({
    dateFormat: 'yy-mm-dd',
    numberOfMonths: 3,
    showCurrentAtPos: 1,   // 表示位置は左から2番目 (真ん中)
    stepMonths: 0,         // 月の移動を3ヶ月単位とする
    autoclose: true
  });


});

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

$(function () {
  $('.check_alert').on('click', function () {
    if (!confirm('入力内容と反映された請求の一致を確認しましたか？')) {
      return false;
    } else {
    }
  })
})


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
  $('.first_double_check').on('click', function () {
    $("html,body").animate({ scrollTop: $('.double_check1_name').offset().top });
  })
  $('.second_double_check').on('click', function () {
    $("html,body").animate({ scrollTop: $('.double_check2_name').offset().top });
  })
})


// マイナスは赤字に
function toRed() {
  $('input').each(function (index, element) {
    var target = Number($(element).val());
    target < 0 ? $(element).css('color', 'red') : $(element).css('color', '#495057');
  });
}

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
  $('.total_result').text('').text(result);
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
        toRed();
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
        toRed();
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
    toRed();
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
    toRed();
    change_all_totals();
  });
})


//アコーディオン
$(function () {
  $(".accordion-wrap").hide();
  $(".accordion-ttl").on("click", function () {
    $(this).next().slideToggle("fast");
    $(this).find(".title-icon").toggleClass("active");
  });
});


// 案内板の文字数カウントダウン
// イベント名称1
const eventname1 = function () {
  var len = textLength($(this).val());
  $('.count_num1').html(len + "/28");
  if (len > 28) {
    $('.count_num1').css('color', 'red');
    $('.is-error-event_name1').text('※文字数がオーバーしています');
    $('.is-error-event_name1').show();
    $('#eventname1Count').addClass('is-error');
    $(':submit').prop("disabled", true);
  } else {
    $('.count_num1').css('color', 'black');
    $('.is-error-event_name1').hide();
    $('#eventname1Count').removeClass('is-error');
    $(':submit').prop("disabled", false);
  }
}

$(function () {
  $(function () {
    $('.is-error-event_name1').hide();
    var len = textLength($('#eventname1Count').val());
    $('.count_num1').html(len + "/28");
  });

  $('#eventname1Count').on('keyup', eventname1);
  $('#eventname1Count').blur(eventname1);
});



// イベント名称2

const eventname2 = function () {
  var len = textLength($(this).val());
  $('.count_num2').html(len + "/28");
  if (len > 28) {
    $('.count_num2').css('color', 'red');
    $('.is-error-event_name2').text('※文字数がオーバーしています');
    $('.is-error-event_name2').show();
    $('#eventname2Count').addClass('is-error');
    $(':submit').prop("disabled", true);
  } else {
    $('.count_num2').css('color', 'black');
    $('.is-error-event_name2').hide();
    $('#eventname2Count').removeClass('is-error');
    $(':submit').prop("disabled", false);
  }
}

$(function () {
  $(function () {
    var len = textLength($('#eventname2Count').val());
    $('.count_num2').html(len + "/28");
  });

  $('#eventname2Count').on('keyup', eventname2);
  $('#eventname2Count').blur(eventname2);
});


// 主催者名
const eventowner = function () {
  var len = textLength($(this).val());

  $('.count_num3').html(len + "/53");
  if (len > 53) {
    $('.count_num3').css('color', 'red');
    $('.is-error-event_owner').text('※文字数がオーバーしています');
    $('.is-error-event_owner').show();
    $('#eventownerCount').addClass('is-error');
    $(':submit').prop("disabled", true);
  } else {
    $('.count_num3').css('color', 'black');
    $('.is-error-event_owner').hide();
    $('#eventownerCount').removeClass('is-error');
    $(':submit').prop("disabled", false);
  }
}

$(function () {
  $(function () {
    var len = textLength($('#eventownerCount').val());
    $('.count_num3').html(len + "/53");
  });

  $('#eventownerCount').on('keyup', eventowner);
  $('#eventownerCount').blur(eventowner);
});


// 一括タブ内、イベント名称1
// $(function () {
//   var m_loop = $('input[name^="event_name1_copied"]');
//   for (let index = 0; index < m_loop.length; index++) {
//     $('.eventname1_error' + index).hide();
//     $('.count_num1_copied' + index).html(textLength($("#copiedeventname1Count" + index).val()) + "/28");

//     $('#copiedeventname1Count' + index).on('keyup', function () {
//       copiedeventname1($(this).val(), $('.count_num1_copied' + index), $('.eventname1_error' + index));
//     })
//     $('#copiedeventname1Count' + index).on('blur', function () {
//       copiedeventname1($(this).val(), $('.count_num1_copied' + index), $('.eventname1_error' + index));
//     })
//   }
//   function copiedeventname1($this_val, $target, $error) {
//     var len = textLength($this_val);
//     $target.html(len + "/28");
//     if (len > 28) {
//       $target.css('color', 'red');
//       $error.text('※文字数がオーバーしています');
//       $error.show();
//       $(':submit').prop("disabled", true);
//     } else {
//       $target.css('color', 'black');
//       $error.hide();
//       $(':submit').prop("disabled", false);
//     }
//   }
// })

// // 一括タブ内、イベント名称2
// $(function () {
//   var m_loop = $('input[name^="event_name1_copied"]');
//   for (let index = 0; index < m_loop.length; index++) {
//     $('.eventname2_error' + index).hide();
//     $('.count_num2_copied' + index).html(textLength($("#copiedeventname2Count" + index).val()) + "/28");

//     $('#copiedeventname2Count' + index).on('keyup', function () {
//       copiedeventname2($(this).val(), $('.count_num2_copied' + index), $('.eventname2_error' + index));
//     })
//     $('#copiedeventname2Count' + index).on('blur', function () {
//       copiedeventname2($(this).val(), $('.count_num2_copied' + index), $('.eventname2_error' + index));
//     })
//   }
//   function copiedeventname2($this_val, $target, $error) {
//     var len = textLength($this_val);
//     $target.html(len + "/28");
//     if (len > 28) {
//       $target.css('color', 'red');
//       $error.text('※文字数がオーバーしています');
//       $error.show();
//       $(':submit').prop("disabled", true);
//     } else {
//       $target.css('color', 'black');
//       $error.hide();
//       $(':submit').prop("disabled", false);
//     }
//   }
// })

// // 一括タブ内、主催者名
// $(function () {
//   var m_loop = $('input[name^="event_name1_copied"]');
//   for (let index = 0; index < m_loop.length; index++) {
//     $('.eventowner_error' + index).hide();
//     $('.count_num3_copied' + index).html(textLength($("#copiedeventOwnerCount" + index).val()) + "/53");

//     $('#copiedeventOwnerCount' + index).on('keyup', function () {
//       copiedeventowner($(this).val(), $('.count_num3_copied' + index), $('.eventowner_error' + index));
//     })
//     $('#copiedeventOwnerCount' + index).on('blur', function () {
//       copiedeventowner($(this).val(), $('.count_num3_copied' + index), $('.eventowner_error' + index));
//     })
//   }
//   function copiedeventowner($this_val, $target, $error) {
//     var len = textLength($this_val);
//     $target.html(len + "/53");
//     if (len > 53) {
//       $target.css('color', 'red');
//       $error.text('※文字数がオーバーしています');
//       $error.show();
//       $(':submit').prop("disabled", true);
//     } else {
//       $target.css('color', 'black');
//       $error.hide();
//       $(':submit').prop("disabled", false);
//     }
//   }
// })


function textLength(text) {
  var regexp = /[\x01-\x7E\u{FF65}-\u{FF9F}]/mu;

  var len = 0;
  for (i = 0; i < text.length; i++) {
    var ch = text[i];
    len += regexp.test(new String(ch)) ? 1 : 2;
  }
  return len;
}









