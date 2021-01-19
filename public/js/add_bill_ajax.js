$(function () {
  var reservation = $("input[name='reservation']").val();

  $('input:radio[name="billcategory"]').on('click', function () {
    var target = $(this).val();
    if (target == 1) {
      $('.extra-bill-table tbody').html("");
      $('.extra-bill-table thead tr td').eq(3).remove();
      ajaxAddBillsEquipments(reservation);
    } else if (target == 2) {
      $('.extra-bill-table tbody').html("");
      $('.extra-bill-table thead tr td').eq(3).remove();
      ajaxAddBillsLayout(reservation);
    } else if (target == 3) {
      $('.extra-bill-table tbody').html("");
      $('.extra-bill-table thead tr td').eq(3).remove();
      $('.extra-bill-table thead tr').append("<td class='table-active'>追加／削除</td>");
      $('.extra-bill-table tbody').append("<tr><td>" + "<input type='text'>" + "</td><td>" + "<input type='text'>" + "</td><td><input type='text'" + "' ></td><td style='border: 0px solid none!important;'><input type='button' value='＋' class='add pluralBtn'><input type='button' value='ー' class='del pluralBtn'></td></tr>");
    }
  })

  $('.add_bill_calculate').on('click', function () {
    $('.result_table tbody').html(''); //全体初期化
    $('.discount_input').val('');
    var judge = $('input:radio[name="billcategory"]:checked').val();

    var count = $('.extra-bill-table tbody tr').length;

    var main_tar = $('.result_table tbody');

    var sub_total = 0;

    if (judge == 1) { //その他有料備品なら
      $('.result_table tbody').html('');
      for (let index = 0; index < count; index++) {
        var data1 = $('.extra-bill-table tbody tr').eq(index).find('td').eq(0).text();
        var data2 = Number($('.extra-bill-table tbody tr').eq(index).find('td').eq(1).text());
        var data3 = $('.extra-bill-table tbody tr').eq(index).find('td').eq(2).find('input').val();
        var data4 = data2 * data3;
        sub_total = sub_total + data4;
        if (data3 > 0) {
          main_tar.append("<tr><td>" + data1 + "</td><td>" + data2 + "</td><td>" + data3 + "</td><td>" + data4 + "</td></tr>");
        }

      }
    } else if (judge == 2) { //レイアウト変更なら
      $('.result_table tbody').html('');
      for (let index = 0; index < count; index++) {
        var data1 = $('.extra-bill-table tbody tr').eq(index).find('td').eq(0).text();
        var data2 = $('.extra-bill-table tbody tr').eq(index).find('td').eq(1).text();
        var data3 = $('.extra-bill-table tbody tr').eq(index).find('td').eq(2).find('input').val();
        var data4 = data2 * data3;
        sub_total = sub_total + data4;

        if (data3 > 0) {
          main_tar.append("<tr><td>" + data1 + "</td><td>" + data2 + "</td><td>" + data3 + "</td><td>" + data4 + "</td></tr>");
        }
      }
    } else if (judge == 3) {
      $('.result_table tbody').html('');
      for (let index = 0; index < count; index++) {
        var data1 = $('.extra-bill-table tbody tr').eq(index).find('td').eq(0).find('input').val();
        var data2 = $('.extra-bill-table tbody tr').eq(index).find('td').eq(1).find('input').val();
        var data3 = $('.extra-bill-table tbody tr').eq(index).find('td').eq(2).find('input').val();
        var data4 = data2 * data3;
        sub_total = sub_total + data4;
        main_tar.append("<tr><td>" + data1 + "</td><td>" + data2 + "</td><td>" + data3 + "</td><td>" + data4 + "</td></tr>");
      }
    }

    console.log(sub_total);
    $('.sub_total').val(sub_total);
    $('.after_dicsount').val(sub_total);
    $('.tax').val(sub_total * 0.1);
    $('.total').val(sub_total + (sub_total * 0.1));


  })

});


function ajaxAddBillsEquipments($reservation_id) {
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: '/admin/reservations/ajaxaddbillsequipments',
    type: 'POST',
    data: {
      'reservation_id': $reservation_id,
    },
    dataType: 'json',
    beforeSend: function () {
      $('#fullOverlay').css('display', 'block');
    },
  })
    .done(function ($result) {
      $('#fullOverlay').css('display', 'none');
      // $result[0]　は備品が格納
      // $result[1]　はサービスが格納
      $('.extra-bill-table tbody').html(''); //初期化
      // console.log($result);
      for (let index = 0; index < $result[0].length; index++) {
        $('.extra-bill-table tbody').append("<tr><td>" + $result[0][index]['item'] + "</td><td>" + $result[0][index]['price'] + "</td><td><input type='text' class='equipments" + index + "' ></td></tr>");
      }
      for (let index2 = 0; index2 < $result[1].length; index2++) {
        $('.extra-bill-table tbody').append("<tr><td>" + $result[1][index2]['item'] + "</td><td>" + $result[1][index2]['price'] + "</td><td><input type='text' class='services" + index2 + "'></td></tr>");
      }
    })
    .fail(function ($result) {
      $('#fullOverlay').css('display', 'none');
      console.log("しっぱい");
      console.log($result);

    });
};

function ajaxAddBillsLayout($reservation_id) {
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: '/admin/reservations/ajaxaddbillslaytout',
    type: 'POST',
    data: {
      'reservation_id': $reservation_id,
    },
    dataType: 'json',
    beforeSend: function () {
      $('#fullOverlay').css('display', 'block');
    },
  })
    .done(function ($layouts) {
      $('#fullOverlay').css('display', 'none');
      $('.extra-bill-table tbody').html(''); //初期化
      $('.extra-bill-table tbody').append("<tr><td>" + "レイアウト準備" + "</td><td>" + $layouts[0] + "</td><td><input type='text' class='layout_prepare" + "' ></td></tr>");
      $('.extra-bill-table tbody').append("<tr><td>" + "レイアウト片付" + "</td><td>" + $layouts[1] + "</td><td><input type='text' class='layout_clean" + "'></td></tr>");
    })
    .fail(function ($layouts) {
      $('#fullOverlay').css('display', 'none');
      console.log("しっぱい");
      console.log($layouts);

    });
};