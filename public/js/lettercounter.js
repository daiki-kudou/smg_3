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
  