
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




// マイナスは赤字に
// function toRed() {
//   $('input').each(function (index, element) {
//     var target = Number($(element).val());
//     target < 0 ? $(element).css('color', 'red') : $(element).css('color', '#495057');
//   });
// }

// アコーディオン
$(function () {
  $(".accordion-wrap").hide();
  $(".accordion-ttl").on("click", function () {
    $(this).next().slideToggle("fast");
    $(this).find(".title-icon").toggleClass("active");
  });

  $(".accordion-innbtn").on("click", function () {
    $(this).parent().slideToggle("");
  });
});











