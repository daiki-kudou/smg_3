String.prototype.bytes = function () {
  var length = 0;
  for (var i = 0; i < this.length; i++) {
    var c = this.charCodeAt(i);
    if ((c >= 0x0 && c < 0x81) || (c === 0xf8f0) || (c >= 0xff61 && c < 0xffa0) || (c >= 0xf8f1 && c < 0xf8f4)) {
      length += 1;
    } else {
      length += 2;
    }
  }
  return length;
};


// 案内板の文字数カウントダウン
// イベント名称1
// const eventname1 = function () {
//   var len = textLength($(this).val());
//   $('.count_num1').html(len + "/28");
//   if (len > 28) {
//     $('.count_num1').css('color', 'red');
//     $('.is-error-event_name1').text('※文字数がオーバーしています');
//     $('.is-error-event_name1').show();
//     $('#eventname1Count').addClass('is-error');
//     $(':submit').prop("disabled", true);
//   } else {
//     $('.count_num1').css('color', 'black');
//     $('.is-error-event_name1').hide();
//     $('#eventname1Count').removeClass('is-error');
//     $(':submit').prop("disabled", false);
//   }
// }

// $(function () {
//   $(function () {
//     $('.is-error-event_name1').hide();
//     var len = textLength($('#eventname1Count').val());
//     $('.count_num1').html(len + "/28");
//   });

//   $('#eventname1Count').on('keyup', eventname1);
//   $('#eventname1Count').blur(eventname1);
// });


$(function () {
  var len = $("#eventname1Count").val().bytes();
  $('.count_num1').html(len + "/28");
});

$(document).on('input', '#eventname1Count', function () {
  var len = $(this).val().bytes();
  $('.count_num1').html(len + "/28");
});

// イベント名称2
$(function () {
  var len = $("#eventname2Count").val().bytes();
  $('.count_num2').html(len + "/28");
});

$(document).on('input', '#eventname2Count', function () {
  var len = $(this).val().bytes();
  $('.count_num2').html(len + "/28");
});

// const eventname2 = function () {
//   var len = textLength($(this).val());
//   $('.count_num2').html(len + "/28");
//   if (len > 28) {
//     $('.count_num2').css('color', 'red');
//     $('.is-error-event_name2').text('※文字数がオーバーしています');
//     $('.is-error-event_name2').show();
//     $('#eventname2Count').addClass('is-error');
//     $(':submit').prop("disabled", true);
//   } else {
//     $('.count_num2').css('color', 'black');
//     $('.is-error-event_name2').hide();
//     $('#eventname2Count').removeClass('is-error');
//     $(':submit').prop("disabled", false);
//   }
// }

// $(function () {
//   $(function () {
//     var len = textLength($('#eventname2Count').val());
//     $('.count_num2').html(len + "/28");
//   });

//   $('#eventname2Count').on('keyup', eventname2);
//   $('#eventname2Count').blur(eventname2);
// });


// 主催者名

$(function () {
  var len = $("#eventownerCount").val().bytes();
  $('.count_num3').html(len + "/53");
});


$(document).on('input', '#eventownerCount', function () {
  var len = $(this).val().bytes();
  $('.count_num3').html(len + "/53");
});


// const eventowner = function () {
//   var len = textLength($(this).val());

//   $('.count_num3').html(len + "/53");
//   if (len > 53) {
//     $('.count_num3').css('color', 'red');
//     $('.is-error-event_owner').text('※文字数がオーバーしています');
//     $('.is-error-event_owner').show();
//     $('#eventownerCount').addClass('is-error');
//     $(':submit').prop("disabled", true);
//   } else {
//     $('.count_num3').css('color', 'black');
//     $('.is-error-event_owner').hide();
//     $('#eventownerCount').removeClass('is-error');
//     $(':submit').prop("disabled", false);
//   }
// }

// $(function () {
//   $(function () {
//     var len = textLength($('#eventownerCount').val());
//     $('.count_num3').html(len + "/53");
//   });

//   $('#eventownerCount').on('keyup', eventowner);
//   $('#eventownerCount').blur(eventowner);
// });




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
      $(':submit').prop("disabled", false);
      $("[class^='is-error-event']").hide();
      $(".count_num1").css('color', '#333');
      $(".count_num2").css('color', '#333');
      $(".count_num3").css('color', '#333');
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
      $(':submit').prop("disabled", false);
      $("[class^='is-error-event']").hide();
      $(".count_num1").css('color', '#333');
      $(".count_num2").css('color', '#333');
      $(".count_num3").css('color', '#333');
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
    var prop = $("#no_luggage_flag").prop("checked");
    if (prop) {
      $("#luggage_arrive").removeClass("readonly-no-gray");
      $("#luggage_count").prop("readonly", true);
      $("#luggage_arrive").prop("readonly", true);
      $('input[name="luggage_arrive"]').prop("readonly", true);
      $("#luggage_return").prop("readonly", true);
      $("#luggage_price").prop("readonly", true);
    } else {
      $("#luggage_count").prop("readonly", false);
      $("#luggage_arrive").prop("readonly", true);
      $('input[name="luggage_arrive"]').prop("readonly", true);
      $("#luggage_return").prop("readonly", false);
      $("#luggage_price").prop("readonly", false);
      $("#luggage_arrive").addClass("readonly-no-gray");
    }
});

// ラジオボタンクリック時の荷物預かり入力制御
$(document).on('change', 'input[name="luggage_flag"]', function () {
  var prop = $("#no_luggage_flag").prop("checked");
  if (prop) {
    $("#luggage_arrive").removeClass("readonly-no-gray");
    $("#luggage_count").prop("readonly", true);
    $("#luggage_arrive").prop("readonly", true);
    $('input[name="luggage_arrive"]').prop("readonly", true);
    $("#luggage_return").prop("readonly", true);
    $("#luggage_price").prop("readonly", true);
  } else {
    $("#luggage_count").prop("readonly", false);
    $("#luggage_arrive").prop("readonly", true);
    $('input[name="luggage_arrive"]').prop("readonly", true);
    $("#luggage_return").prop("readonly", false);
    $("#luggage_price").prop("readonly", false);
    $("#luggage_arrive").addClass("readonly-no-gray");
  }
});

// ロード時の、一括荷物預かり入力制御
$(function () {
  $("#cp_master_no_luggage_flag:checked").each(function () {
    var flag = $(this);
    if ($(flag).is(":checked") != null) {
      $("#cp_master_luggage_count").prop("readonly", true);
      $("#cp_master_luggage_arrive").prop("readonly", true);
      $("#cp_master_luggage_return").prop("readonly", true);
    }
  });
})

// ラジオボタンクリック時の荷物預かり入力制御
$(document).on('change', 'input[name*="luggage_flag"]', function () {
  var prop = $("#cp_master_no_luggage_flag").prop("checked");
  if (prop) {
    $("#cp_master_luggage_arrive").removeClass("readonly-no-gray");
    $("#cp_master_luggage_count").prop("readonly", true);
    $("#cp_master_luggage_arrive").prop("readonly", true);
    $("#cp_master_luggage_return").prop("readonly", true);
  } else {
    $("#cp_master_luggage_count").prop("readonly", false);
    $("#cp_master_luggage_arrive").prop("readonly", true);
    $("#cp_master_luggage_return").prop("readonly", false);
    $("#cp_master_luggage_arrive").addClass("readonly-no-gray");
  }
});


// 一括の個別の荷物の制御
const flagCheck = function () {
  var target = $('input[name*="luggage_flag_copied"]');
  for (let i = 0; i < target.length; i++) {
    var flag = '#no_luggage_flag' + i;
    var luggage_count = $('input[name="luggage_count_copied' + i + '"]');
    var luggage_arrive = $('input[name="luggage_arrive_copied' + i + '"]');
    var luggage_return = $('input[name="luggage_return_copied' + i + '"]');

    var prop = $(flag).prop("checked");

    if (prop) {
      luggage_arrive.removeClass("readonly-no-gray");
      luggage_count.prop("readonly", true);
      luggage_arrive.prop("readonly", true);
      luggage_return.prop("readonly", true);
    } else {
      luggage_count.prop("readonly", false);
      luggage_arrive.prop("readonly", true);
      luggage_return.prop("readonly", false);
      luggage_arrive.addClass("readonly-no-gray");
    }
  }
}

$(function () {
  flagCheck();
  var flagItem = $('input[name*="luggage_flag_copied"]');
  flagItem.on('click', flagCheck);
});

// 一括の個別の案内板の制御
const boardCheck = function () {
  var target = $('input[name*="board_flag_copied"]');
  for (let i = 0; i < target.length; i++) {
    var flag = '#board_flag_copied_off' + i;
    var event_name1 = $('input[name="event_name1_copied' + i + '"]');
    var event_name2 = $('input[name="event_name2_copied' + i + '"]');
    var event_owner = $('input[name="event_owner' + i + '"]');
    var event_start = $('select[name="event_start_copied' + i + '"]');
    var event_finish = $('select[name="event_finish_copied' + i + '"]');

    var prop = $(flag).prop("checked");
    if (prop) {
      event_name1.addClass("readonly");
      event_name2.addClass("readonly");
      event_owner.addClass("readonly");
      event_start.addClass("readonly");
      event_finish.addClass("readonly");
    } else {
      event_name1.removeClass("readonly");
      event_name2.removeClass("readonly");
      event_owner.removeClass("readonly");
      event_start.removeClass("readonly");
      event_finish.removeClass("readonly");
    }
  }
}

$(function () {
  boardCheck();

  var flagItem = $('input[name*="board_flag_copied"]');
  flagItem.on('click', boardCheck);
});


// 一括の個別の案内板の文字数制御
// $(function () {
//   var target = $('input[name*="event_name1_copied"]');
//   for(let i=0 ; i< target.length; i++){
//     var event_name1 = $('input[name="event_name1_copied' + i + '"]');
//     var copiedeventname1Count = '#copiedeventname1Count' + i;
//     var error_message = '.eventname1_error' + i;
//     var count_num1 = '.count_num1_copied' + i;


//     var len = textLength($(event_name1).val());
//     $(count_num1).html(len + "/28");

//         if (len > 28) {
//       $(count_num1).css('color', 'red');
//       $(error_message).text('※文字数がオーバーしています');
//       $(error_message).show();
//       $(copiedeventname1Count).addClass('is-error');
//       $(':submit').prop("disabled", true);
//     } else {
//       $(count_num1).css('color', 'black');
//       $(error_message).hide();
//       $(copiedeventname1Count).removeClass('is-error');
//       $(':submit').prop("disabled", false);
//     }
//   }

// });


// $(function () {
//   $(function () {
//     $('.is-error-event_name1').hide();
//     var len = textLength($('#eventname1Count').val());
//     $('.count_num1').html(len + "/28");
//   });

//   $('#eventname1Count').on('keyup', eventname1);
//   $('#eventname1Count').blur(eventname1);
// });



// function textLength(text) {
//   var regexp = /[\x01-\x7E\u{FF65}-\u{FF9F}]/mu;

//   var len = 0;
//   for (i = 0; i < text.length; i++) {
//     var ch = text[i];
//     len += regexp.test(new String(ch)) ? 1 : 2;
//   }
//   return len;
// }