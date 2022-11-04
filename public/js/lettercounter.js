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

// ロード時の、案内板入力制御

$(document).ready(function () {
  $("#board_flag:checked").each(function () {
    $("#eventRequired").addClass("form_required"); 
  });
});

$(document).ready(function () {
  $("#no_board_flag:checked").each(function () {
    var flag = $(this);
    $("#eventRequired").addClass("form_required"); 
    if ($(flag).is(":checked") != null) {
      $("#event_start").prop("readonly", true);
      $("#event_start").css("color", "#ccc");
      $("#event_finish").prop("readonly", true);
      $("#event_finish").css("color", "#ccc");
      $("#eventname1Count").prop("readonly", true);
      $("#eventname1Count").css("color", "#ccc");
      $("#eventname2Count").prop("readonly", true);
      $("#eventname2Count").css("color", "#ccc");
      $("#eventownerCount").prop("readonly", true);
      $("#eventownerCount").css("color", "#ccc");
      $("#event_start").prop("disabled", true);
      $("#event_finish").prop("disabled", true);
      $("#eventRequired").removeClass("form_required"); 
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
      $("#eventname1Count").css("color", "#ccc");
      $("#eventname2Count").prop("readonly", true);
      $("#eventname2Count").css("color", "#ccc");
      $("#eventownerCount").prop("readonly", true);
      $("#eventownerCount").css("color", "#ccc");
      $("#event_start").prop("disabled", true);
      $("#event_start").css("color", "#ccc");
      $("#event_finish").prop("disabled", true);
      $("#event_finish").css("color", "#ccc");
      // $(".board-table input[type='text']").val("");
      $("[class^='is-error-event']").hide();
      $("input[name^='event_']").removeClass("is-error");
      var len1 = $("#eventname1Count").val().bytes();
      var len2 = $("#eventname2Count").val().bytes();
      var len3 = $("#eventownerCount").val().bytes();
      $('.count_num1').html(len1 + "/28");
      $('.count_num2').html(len2 + "/28");
      $('.count_num3').html(len3 + "/53");
      $("#eventRequired").removeClass("form_required"); 
    } else {
      $("#event_start").prop("readonly", false);
      $("#event_start").css("color", "#333");
      $("#event_finish").prop("readonly", false);
      $("#event_finish").css("color", "#333");
      $("#eventname1Count").prop("readonly", false);
      $("#eventname1Count").css("color", "#333");
      $("#eventname2Count").prop("readonly", false);
      $("#eventname2Count").css("color", "#333");
      $("#eventownerCount").prop("readonly", false);
      $("#eventownerCount").css("color", "#333");
      $("#event_start").prop("disabled", false);
      $("#event_finish").prop("disabled", false);
      $("#eventRequired").addClass("form_required"); 
    }
  });
});

// 案内板の文字数カウントダウン
// イベント名称1
$(function () {
  var len = $("#eventname1Count").val().bytes();
  $('.count_num1').html(len + "/28");
});

$(document).on('input', '#eventname1Count', function () {
  var len = $(this).val().bytes();
  $('.count_num1').html(len + "/28");
  $('.is-error-event_name1').show();
  $('.is-error-cp_master_event_name1').show();
});

// イベント名称2
$(function () {
  var len = $("#eventname2Count").val().bytes();
  $('.count_num2').html(len + "/28");
});

$(document).on('input', '#eventname2Count', function () {
  var len = $(this).val().bytes();
  $('.count_num2').html(len + "/28");
  $('.is-error-event_name2').show();
  $('.is-error-cp_master_event_name2').show();
});


// 主催者名
$(function () {
  var len = $("#eventownerCount").val().bytes();
  $('.count_num3').html(len + "/53");
});


$(document).on('input', '#eventownerCount', function () {
  var len = $(this).val().bytes();
  $('.count_num3').html(len + "/53");
  $('.is-error-event_owner').show();
  $('.is-error-cp_master_event_owner').show();
});


// 一括ロード時の、案内板入力制御
$(document).ready(function () {
  $("#cp_master_board_no_board_flag:checked").each(function () {
    var flag = $(this);
    if ($(flag).is(":checked") != null) {
      $("#cp_master_event_start").prop("disabled", true);
      $("#cp_master_event_start").css("color", "#ccc");
      $("#cp_master_event_finish").prop("disabled", true);
      $("#cp_master_event_finish").css("color", "#ccc");
      $("#eventname1Count").prop("readonly", true);
      $("#eventname1Count").css("color", "#ccc");
      $("#eventname2Count").prop("readonly", true);
      $("#eventname2Count").css("color", "#ccc");
      $("#eventownerCount").prop("readonly", true);
      $("#eventownerCount").css("color", "#ccc");
    }
  });
});

// 一括ラジオボタンクリック時の入力制御
$(function () {
  $('input[name="cp_master_board_flag"]').change(function () {
    var prop = $("#cp_master_board_no_board_flag").prop("checked");
    if (prop) {
      $("#cp_master_event_start").prop("disabled", true);
      $("#cp_master_event_start").css("color", "#ccc");
      $("#cp_master_event_finish").prop("disabled", true);
      $("#cp_master_event_finish").css("color", "#ccc");
      $("#eventname1Count").prop("readonly", true);
      $("#eventname1Count").css("color", "#ccc");
      $("#eventname2Count").prop("readonly", true);
      $("#eventname2Count").css("color", "#ccc");
      $("#eventownerCount").prop("readonly", true);
      $("#eventownerCount").css("color", "#ccc");
      $(".board-table input[type='text']").val("");
      $("[class^='is-error-cp_master_event']").hide();
      $("input[name^='cp_master_event_']").removeClass("is-error");
      var len1 = $("input[name='cp_master_event_name1']").val().bytes();
      var len2 = $("input[name='cp_master_event_name2']").val().bytes();
      var len3 = $("input[name='cp_master_event_owner']").val().bytes();
      $('.count_num1').html(len1 + "/28");
      $('.count_num2').html(len2 + "/28");
      $('.count_num3').html(len3 + "/53");
    } else {
      $("#cp_master_event_start").prop("disabled", false);
      $("#cp_master_event_start").css("color", "#333");
      $("#cp_master_event_finish").prop("disabled", false);
      $("#cp_master_event_finish").css("color", "#333");
      $("#eventname1Count").prop("readonly", false);
      $("#eventname1Count").css("color", "#333");
      $("#eventname2Count").prop("readonly", false);
      $("#eventname2Count").css("color", "#333");
      $("#eventownerCount").prop("readonly", false);
      $("#eventownerCount").css("color", "#333");
    }
  });
});

// ロード時の、荷物預かり入力制御
$(function () {
  var prop = $("#no_luggage_flag").prop("checked");
  if (prop) {
    $("#luggage_count").prop("readonly", true);
    $("#luggage_count").css("color", "#ccc");
    $("#luggage_arrive").prop("readonly", true);
    $("#luggage_arrive").css("color", "#ccc");
    $('input[name="luggage_arrive"]').prop("readonly", true);
    $('input[name="luggage_arrive"]').css("color", "#ccc");
    $("#luggage_return").prop("readonly", true);
    $("#luggage_return").css("color", "#ccc");
    $("#luggage_price").prop("readonly", true);
    $("#luggage_price").css("color", "#ccc");
    $("#changeLuggageArriveDate").css("color", "#ccc");
    $("#luggage_arrive").removeClass("readonly-no-gray");
    // $(".luggage_info").css("display","none");
  } else {
    $("#luggage_count").prop("readonly", false);
    $("#luggage_count").css("color", "#333");
    $("#luggage_arrive").prop("readonly", true);
    $("#luggage_arrive").css("color", "#333");
    $('input[name="luggage_arrive"]').prop("readonly", true);
    $('input[name="luggage_arrive"]').css("color", "#333");
    $("#luggage_return").prop("readonly", false);
    $("#luggage_return").css("color", "#333");
    $("#luggage_price").prop("readonly", false);
    $("#luggage_price").css("color", "#333");
    $("#changeLuggageArriveDate").css("color", "#333");
    $("#luggage_arrive").addClass("readonly-no-gray");
    // $(".luggage_info").css("display","block");
  }
});

        // 荷物預かりのラジオボタン選択の表示、非表示
        $(function() {
          var no_luggage_flag = $('#no_luggage_flag').prop('checked');
          if (no_luggage_flag) {
              $(".luggage_info").addClass("d-none");
          } else {
              $(".luggage_info").removeClass("d-none");
          }
      });

      $(function() {
          $("input[name='luggage_flag']").change(function() {
              var no_luggage_flag = $('#no_luggage_flag').prop('checked');
              if (no_luggage_flag) {
                  $(".luggage_info").addClass("d-none");
              } else {
                  $(".luggage_info").removeClass("d-none");
              }
          });
      });

// ラジオボタンクリック時の荷物預かり入力制御
$(document).on('change', 'input[name="luggage_flag"]', function () {
  var prop = $("#no_luggage_flag").prop("checked");
  if (prop) {
    $("#luggage_count").prop("readonly", true);
    $("#luggage_count").css("color", "#ccc");
    $("#luggage_arrive").prop("readonly", true);
    $("#luggage_arrive").css("color", "#ccc");
    $('input[name="luggage_arrive"]').prop("readonly", true);
    $('input[name="luggage_arrive"]').css("color", "#ccc");
    $("#luggage_return").prop("readonly", true);
    $("#luggage_return").css("color", "#ccc");
    $("#luggage_price").prop("readonly", true);
    $("#luggage_price").css("color", "#ccc");
    $("#changeLuggageArriveDate").css("color", "#ccc");
    $("#luggage_arrive").removeClass("readonly-no-gray");
    // $(".luggage_info").css("display","none");
  } else {
    $("#luggage_count").prop("readonly", false);
    $("#luggage_count").css("color", "#333");
    $("#luggage_arrive").prop("readonly", true);
    $("#luggage_arrive").css("color", "#333");
    $('input[name="luggage_arrive"]').prop("readonly", true);
    $('input[name="luggage_arrive"]').css("color", "#333");
    $("#luggage_return").prop("readonly", false);
    $("#luggage_return").css("color", "#333");
    $("#luggage_price").prop("readonly", false);
    $("#luggage_price").css("color", "#333");
    $("#changeLuggageArriveDate").css("color", "#333");
    $("#luggage_arrive").addClass("readonly-no-gray");
    // $(".luggage_info").css("display","block");
  }
});

// ロード時の、一括荷物預かり入力制御
$(function () {
  $("#cp_master_no_luggage_flag:checked").each(function () {
    var flag = $(this);
    if ($(flag).is(":checked") != null) {
      $("#cp_master_luggage_count").prop("readonly", true);
      $("#cp_master_luggage_count").css("color", "#ccc");
      $("#cp_master_luggage_arrive").prop("readonly", true);
      $("#cp_master_luggage_arrive").css("color", "#ccc");
      $("#cp_master_luggage_return").prop("readonly", true);
      $("#cp_master_luggage_return").css("color", "#ccc");
    $(".luggage_info").css("display","none");
    } else {
    $(".luggage_info").css("display","block");
    }
  });
})

// ラジオボタンクリック時の荷物預かり入力制御
$(document).on('change', 'input[name*="luggage_flag"]', function () {
  var prop = $("#cp_master_no_luggage_flag").prop("checked");
  if (prop) {
    $("#cp_master_luggage_arrive").removeClass("readonly-no-gray");
    $("#cp_master_luggage_count").prop("readonly", true);
    $("#cp_master_luggage_count").css("color", "#ccc");
    $("#cp_master_luggage_arrive").prop("readonly", true);
    $("#cp_master_luggage_arrive").css("color", "#ccc");
    $("#cp_master_luggage_return").prop("readonly", true);
    $("#cp_master_luggage_return").css("color", "#ccc");
    // $(".luggage_info").css("display","none");
  } else {
    $("#cp_master_luggage_count").prop("readonly", false);
    $("#cp_master_luggage_count").css("color", "#333");
    $("#cp_master_luggage_arrive").prop("readonly", true);
    $("#cp_master_luggage_arrive").css("color", "#333");
    $("#cp_master_luggage_return").prop("readonly", false);
    $("#cp_master_luggage_return").css("color", "#333");
    $("#cp_master_luggage_arrive").addClass("readonly-no-gray");
    // $(".luggage_info").css("display","block");
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

function textLength(text) {
  var regexp = /[\x01-\x7E\u{FF65}-\u{FF9F}]/mu;

  var len = 0;
  for (i = 0; i < text.length; i++) {
    var ch = text[i];
    len += regexp.test(new String(ch)) ? 1 : 2;
  }
  return len;
}