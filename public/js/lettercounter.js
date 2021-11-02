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

function textLength(text) {
  var regexp = /[\x01-\x7E\u{FF65}-\u{FF9F}]/mu;

  var len = 0;
  for (i = 0; i < text.length; i++) {
    var ch = text[i];
    len += regexp.test(new String(ch)) ? 1 : 2;
  }
  return len;
}




// ロード時の、案内板入力制御
$(document).ready(function () {
  $("#no_board_flag:checked").each(function () {
    var flag = $(this);
    if ($(flag).is(":checked") != null) {
      $("#event_start").prop("readonly", true);
      $("#event_finish").prop("readonly", true);
      $("#eventname1Count").prop("readonly", true);
      $("#eventname2Count").prop("readonly", true);
      $("#eventownerCount").prop("readonly", true);
      $("#event_start").prop("disabled", true);
      $("#event_finish").prop("disabled", true);
      $(".board-table option:selected").val("");
    }
  });
});

// ラジオボタンクリック時の案内板入力制御
$(function () {
  $('input[name="board_flag"]').change(function () {
    var prop = $("#no_board_flag").prop("checked");
    if (prop) {
      $("#event_start").prop("readonly", true);
      $("#event_finish").prop("readonly", true);
      $("#eventname1Count").prop("readonly", true);
      $("#eventname2Count").prop("readonly", true);
      $("#eventownerCount").prop("readonly", true);
      $("#event_start").prop("disabled", true);
      $("#event_finish").prop("disabled", true);
      $(".board-table input[type='text']").val("");
    } else {
      $("#event_start").prop("readonly", false);
      $("#event_finish").prop("readonly", false);
      $("#eventname1Count").prop("readonly", false);
      $("#eventname2Count").prop("readonly", false);
      $("#eventownerCount").prop("readonly", false);
      $("#event_start").prop("disabled", false);
      $("#event_finish").prop("disabled", false);
    }
  });
});

// 一括ロード時の、案内板入力制御
$(document).ready(function () {
  $("#cp_master_board_no_board_flag:checked").each(function () {
    var flag = $(this);
    if ($(flag).is(":checked") != null) {
      $("#cp_master_event_start").prop("disabled", true);
      $("#cp_master_event_finish").prop("disabled", true);
      $("#eventname1Count").prop("readonly", true);
      $("#eventname2Count").prop("readonly", true);
      $("#eventownerCount").prop("readonly", true);
    }
  });
});

// 一括ラジオボタンクリック時の入力制御
$(function () {
  $('input[name="cp_master_board_flag"]').change(function () {
    var prop = $("#cp_master_board_no_board_flag").prop("checked");
    if (prop) {
      $("#cp_master_event_start").prop("disabled", true);
      $("#cp_master_event_finish").prop("disabled", true);
      $("#eventname1Count").prop("readonly", true);
      $("#eventname2Count").prop("readonly", true);
      $("#eventownerCount").prop("readonly", true);
    } else {
      $("#cp_master_event_start").prop("disabled", false);
      $("#cp_master_event_finish").prop("disabled", false);
      $("#eventname1Count").prop("readonly", false);
      $("#eventname2Count").prop("readonly", false);
      $("#eventownerCount").prop("readonly", false);
    }
  });
});

// ロード時の、荷物預かり入力制御
$(function () {
  $("#no_luggage_flag:checked").each(function () {
    var flag = $(this);
    console.log(this);
    if ($(flag).is(":checked") != null) {
      $("#luggage_count").prop("readonly", true);
      $("#luggage_arrive").prop("readonly", true);
      $("#luggage_return").prop("readonly", true);
      $("#luggage_price").prop("readonly", true);
    }
  });
})

// ラジオボタンクリック時の荷物預かり入力制御
$(document).on('change', 'input[name="luggage_flag"]', function () {
  var prop = $("#no_luggage_flag").prop("checked");
  console.log(prop);
  if (prop) {
    $("#luggage_arrive").removeClass("readonly-no-gray");
    $("#luggage_count").prop("readonly", true);
    $("#luggage_arrive").prop("readonly", true);
    $("#luggage_return").prop("readonly", true);
    $("#luggage_price").prop("readonly", true);
  } else {
    $("#luggage_count").prop("readonly", false);
    $("#luggage_arrive").prop("readonly", true);
    $("#luggage_return").prop("readonly", false);
    $("#luggage_price").prop("readonly", false);
    $("#luggage_arrive").addClass("readonly-no-gray");
  }
});

// $(function () {
//   $('input[name="luggage_flag"]').change(function () {
//     var prop = $("#no_luggage_flag").prop("checked");
//     if (prop) {
//       $("#luggage_arrive").removeClass("readonly-no-gray");
//       $("#luggage_count").prop("readonly", true);
//       $("#luggage_arrive").prop("readonly", true);
//       $("#luggage_return").prop("readonly", true);
//       $("#luggage_price").prop("readonly", true);
//     } else {
//       $("#luggage_count").prop("readonly", false);
//       $("#luggage_arrive").prop("readonly", true);
//       $("#luggage_return").prop("readonly", false);
//       $("#luggage_price").prop("readonly", false);
//       $("#luggage_arrive").addClass("readonly-no-gray");
//     }
//   });
// });


// ロード時の、一括荷物預かり入力制御
$(function () {
  $("#cp_master_no_luggage_flag:checked").each(function () {
    var flag = $(this);
    console.log(this);
    if ($(flag).is(":checked") != null) {
      $("#cp_master_luggage_count").addClass("readonly");
      $("#cp_master_luggage_arrive").addClass("readonly");
      $("#cp_master_luggage_return").addClass("readonly");
    }
  });
})

// ラジオボタンクリック時の荷物預かり入力制御
$(document).on('change', 'input[name="luggage_flag"]', function () {
  var prop = $("#cp_master_no_luggage_flag").prop("checked");
  if (prop) {
    $("#cp_master_luggage_count").addClass("readonly");
    $("#cp_master_luggage_arrive").addClass("readonly");
    $("#cp_master_luggage_return").addClass("readonly");
  } else {
    $("#cp_master_luggage_count").removeClass("readonly");
    $("#cp_master_luggage_arrive").removeClass("readonly");
    $("#cp_master_luggage_return").removeClass("readonly");
  }
});


// $(function () {
//   $('input[name="luggage_flag"]').change(function () {
//     var prop = $("#cp_master_no_luggage_flag").prop("checked");
//     if (prop) {
//       $("#cp_master_luggage_count").addClass("readonly");
//       $("#cp_master_luggage_arrive").addClass("readonly");
//       $("#cp_master_luggage_return").addClass("readonly");
//     } else {
//       $("#cp_master_luggage_count").removeClass("readonly");
//       $("#cp_master_luggage_arrive").removeClass("readonly");
//       $("#cp_master_luggage_return").removeClass("readonly");
//     }
//   });
// });