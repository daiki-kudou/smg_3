$(function () {
  var name = $('input[name="start"]');
  for (let nums = 0; nums < name.length; nums++) {
    var start = $('input[name="start"]').eq(nums).val();
    var finish = $('input[name="finish"]').eq(nums).val();
    var s_date = $('input[name="date"]').eq(nums).val();
    var status = $('input[name="status"]').eq(nums).val();
    var company = $('input[name="company"]').eq(nums).val();
    var reservation_id = $('input[name="reservation_id"]').eq(nums).val();
    var ds = new Date(start);
    ds.setMinutes(ds.getMinutes() - (60));
    var df = new Date(finish);
    var diffTime = df.getTime() - ds.getTime();
    var diffTime = Math.floor(diffTime / (1000 * 60));
    var target = diffTime / 30;

    function zeroPadding(num) {
      return ('0' + num).slice(-2);
    }
    for (let index = 0; index < target; index++) {
      ds.setMinutes(ds.getMinutes() + (30));
      var hours = ds.getHours();
      hours = zeroPadding(hours);
      var minutes = ds.getMinutes();
      minutes = zeroPadding(minutes);
      var result = hours + minutes;
      if (status == 3) {
        $("." + s_date + "cal" + result).addClass('bg-reserve');
        if (!$("." + s_date + "cal" + result).prev().hasClass('bg-reserve')) {
          // 始めに灰色
          $("." + s_date + "cal" + result).addClass('gray');
        }
        if ($("." + s_date + "cal" + result).prev().hasClass('gray')) {
          $("." + s_date + "cal" + result).html(
            "<a href='/admin/reservations/" + reservation_id + "'>" + company + "</a>"
          );
        }
      } else if (status < 3) {
        $("." + s_date + "cal" + result).addClass('bg-prereserve');
      }
    }
    // 最後に灰色
    $('.bg-reserve:last').addClass('gray');
    $('.bg-prereserve:last').addClass('gray');
  }
})

$(function () {
  var name = $('input[name="pre_start"]');
  for (let nums = 0; nums < name.length; nums++) {
    var start = $('input[name="pre_start"]').eq(nums).val();
    var finish = $('input[name="pre_finish"]').eq(nums).val();
    var s_date = $('input[name="pre_date"]').eq(nums).val();
    // var status = $('input[name="status"]').eq(nums).val();
    var company = $('input[name="pre_company"]').eq(nums).val();
    var reservation_id = $('input[name="pre_reservation_id"]').eq(nums).val();
    var ds = new Date(start);
    ds.setMinutes(ds.getMinutes() - (60));
    var df = new Date(finish);
    var diffTime = df.getTime() - ds.getTime();
    var diffTime = Math.floor(diffTime / (1000 * 60));
    var target = diffTime / 30;

    function zeroPadding(num) {
      return ('0' + num).slice(-2);
    }
    for (let index = 0; index < target; index++) {
      ds.setMinutes(ds.getMinutes() + (30));
      var hours = ds.getHours();
      hours = zeroPadding(hours);
      var minutes = ds.getMinutes();
      minutes = zeroPadding(minutes);
      var result = hours + minutes;
      if (index == 0) {
        $("." + s_date + "cal" + result).addClass('gray');
      } else {
        $("." + s_date + "cal" + result).addClass('bg-prereserve');
      }
    }
    // 最後に灰色
    $('.bg-reserve:last').addClass('gray');
    $('.bg-prereserve:last').addClass('gray');
  }
})
