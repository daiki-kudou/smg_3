$(function () {
  $(document).on("click", "[class^='venue_main'] .add", function () {

    var master = $(this).parent().parent();
    $(this).parent().parent().clone(true).insertAfter($(this).parent().parent());
    var target1 = $(this).parent().parent().find('td').eq(0).find('input').attr('name');
    var splitKey = target1.split('_copied');

    master.next().find('td').eq(0).find('input').val('');
    master.next().find('td').eq(1).find('input').val('');
    master.next().find('td').eq(2).find('input').val('');
    master.next().find('td').eq(3).find('input').val('');

    var targetTr = $(this).parent().parent().parent().find('tr');
    for (let index = 0; index < targetTr.length; index++) {
      targetTr.eq(index).find('td').eq(0).find('input').attr('name', 'venue_breakdown_item' + index + '_copied' + splitKey[1]);
      targetTr.eq(index).find('td').eq(1).find('input').attr('name', 'venue_breakdown_cost' + index + '_copied' + splitKey[1]);
      targetTr.eq(index).find('td').eq(2).find('input').attr('name', 'venue_breakdown_count' + index + '_copied' + splitKey[1]);
      targetTr.eq(index).find('td').eq(3).find('input').attr('name', 'venue_breakdown_subtotal' + index + '_copied' + splitKey[1]);
    }
  })
  // 会場手打ちの場合のプラス　マイナス　ボタン
  $(document).on("click", "[class^='venue_main'] .del", function () {
    $(this).parent().parent().find('td').eq(0).find('input').val('').trigger("input");
    $(this).parent().parent().find('td').eq(1).find('input').val('').trigger("input");
    $(this).parent().parent().find('td').eq(2).find('input').val('').trigger("input");
    $(this).parent().parent().find('td').eq(3).find('input').val('').trigger("input");
    var sptarget = $(this).parent().parent().find('td').eq(0).find('input').attr('name');
    var splitKey = sptarget.split('_copied');
    var master = $(this).parent().parent().parent();
    var targetTR = master.find('tr').length;
    var thisTR = $(this).parent().parent();
    if (targetTR > 1) {
      thisTR.remove();
    };
    var reTargetTR = master.find('tr');
    for (let index2 = 0; index2 < reTargetTR.length; index2++) {
      reTargetTR.eq(index2).find('td').eq(0).find('input').attr('name', 'venue_breakdown_item' + index2 + '_copied' + splitKey[1]);
      reTargetTR.eq(index2).find('td').eq(1).find('input').attr('name', 'venue_breakdown_cost' + index2 + '_copied' + splitKey[1]);
      reTargetTR.eq(index2).find('td').eq(2).find('input').attr('name', 'venue_breakdown_count' + index2 + '_copied' + splitKey[1]);
      reTargetTR.eq(index2).find('td').eq(3).find('input').attr('name', 'venue_breakdown_subtotal' + index2 + '_copied' + splitKey[1]);
    }
  })
})

$(function () {
  function Mdiscounts($num_dsc, $per_dsc, $m_prc, $dic_btn, $inp_dsc, $item_cla, $cost_cla, $cnt_cla, $subt_cla, $tar_body) {
    var targetLength = $('#counts_reserve').val();
    var number_ar = [];
    var percent_ar = [];
    var price_ar = [];
    for (let loop = 0; loop < targetLength; loop++) {
      var number = "input[name='" + $num_dsc + "" + loop + "']";
      number_ar.push(number);
      var percent = "input[name='" + $per_dsc + "" + loop + "']";
      percent_ar.push(percent);
      var price = Number($("input[name='" + $m_prc + "" + loop + "']").val());
      price_ar.push(price);
    }

    for (let loop2 = 0; loop2 < targetLength; loop2++) {
      $(number_ar[loop2]).on('focus', function () {
        $(percent_ar[loop2]).val('');
      });
      $(percent_ar[loop2]).on('focus', function () {
        $(number_ar[loop2]).val('');
      });

      $('.' + $dic_btn + '' + loop2).on('click', function () {
        console.log("test");
        $('.' + $inp_dsc + '' + loop2).remove();
        $("input[name='" + $m_prc + "" + loop2 + "']").val('');
        $("input[name='" + $m_prc + "" + loop2 + "']").val(price_ar[loop2]);

        if ($(number_ar[loop2]).val() != 0 && $(number_ar[loop2]).val() != '') {
          // 割引料金に金額があったら
          var p_r = Math.floor(Number(($(number_ar[loop2]).val() / price_ar[loop2]) * 100));
          var data = "<tr class='" + $inp_dsc + "" + loop2 + "'>"
            + "<td>"
            + "<input class='form-control' readonly='' name='" + $item_cla + "" + loop2 + "' type='text' value='"
            + "割引料金（" + p_r
            + "%）"
            + "'>"
            + "</td>"
            + "<td>"
            + "<input class='form-control' readonly='' name='" + $cost_cla + "" + loop2 + "' type='text' value='"
            + (-$(number_ar[loop2]).val())
            + "'>"
            + "</td>"
            + "<td>"
            + "<input class='form-control' readonly='' name='" + $cnt_cla + "" + loop2 + "' type='text' value='1'>"
            + "</td>"
            + "<td>"
            + "<input class='form-control' readonly='' name='" + $subt_cla + "" + loop2 + "' type='text' value='"
            + (-$(number_ar[loop2]).val())
            + "'>"
            + "</td>"
            + "</tr>";
          $('.' + $tar_body + '' + loop2).append(data);
          var change = Number(price_ar[loop2]) - Number($(number_ar[loop2]).val());
          $('input[name="' + $m_prc + '' + loop2 + '"]').val(Number(change));
        }

        if ($(percent_ar[loop2]).val() != 0 && $(percent_ar[loop2]).val() != '') {
          var n_r = (price_ar[loop2] * ($(percent_ar[loop2]).val() / 100));
          var datas2 = "<tr class='" + $inp_dsc + "" + loop2 + "'>"
            + "<td>"
            + "<input class='form-control' readonly='' name='" + $item_cla + "" + loop2 + "' type='text' value='"
            + "割引料金（"
            + $(percent_ar[loop2]).val()
            + "%）"
            + "'>"
            + "</td>"
            + "<td>"
            + "<input class='form-control' readonly='' name='" + $cost_cla + "" + loop2 + "' type='text' value='"
            + (-n_r)
            + "'>"
            + "</td>"
            + "<td>"
            + "<input class='form-control' readonly='' name='" + $cnt_cla + "" + loop2 + "' type='text' value='1'>"
            + "</td>"
            + "<td>"
            + "<input class='form-control' readonly='' name='" + $subt_cla + "" + loop2 + "' type='text' value='"
            + (-n_r)
            + "'>"
            + "</td>"
            + "</tr>";
          $('.' + $tar_body + '' + loop2).append(datas2);
          var change = Number(price_ar[loop2]) - Number(n_r);
          $('input[name="' + $m_prc + '' + loop2 + '"]').val(Number(change));
        }
      })
    }
  }
  // ↑までfunction
  // ↓function 実行
  Mdiscounts(
    'venue_number_discount',
    'venue_percent_discount',
    'venue_price',
    'venue_discount_btn',
    'venue_input_discounts',
    'venue_breakdown_discount_item',
    'venue_breakdown_discount_cost',
    'venue_breakdown_discount_count',
    'venue_breakdown_discount_subtotal',
    'venue_main'
  )
  Mdiscounts(
    'equipment_number_discount',
    'equipment_percent_discount',
    'equipment_price',
    'equipment_discount_btn',
    'equipment_input_discounts',
    'equipment_breakdown_discount_item',
    'equipment_breakdown_discount_cost',
    'equipment_breakdown_discount_count',
    'equipment_breakdown_discount_subtotal',
    'equipment_main'
  )
  Mdiscounts(
    'layout_number_discount',
    'layout_percent_discount',
    'layout_price',
    'layout_discount_btn',
    'layout_input_discounts',
    'layout_breakdown_discount_item',
    'layout_breakdown_discount_cost',
    'layout_breakdown_discount_count',
    'layout_breakdown_discount_subtotal',
    'layout_main'
  )
})

$(function () {
  $(document).on("click", "[class^='others_main'] .add", function () {
    var target1 = $(this).parent().parent().find('td').eq(0).find('input').attr('name');
    var splitKey = target1.split('_copied');
    splitKey = Number(splitKey[1]);

    var master = $(this).parent().parent().parent();
    $(this).parent().parent().clone(true).insertAfter($(this).parent().parent());
    var next = $(this).parent().parent().next();
    next.find('td').eq(0).find('input').val('');
    next.find('td').eq(1).find('input').val('');
    next.find('td').eq(2).find('input').val('');
    next.find('td').eq(3).find('input').val('');

    var masterTR = master.find('tr').length;
    for (let index = 0; index < masterTR; index++) {
      master.find('tr').eq(index).find('td').eq(0).find('input').attr('name', 'others_input_item' + index + '_copied' + splitKey);
      master.find('tr').eq(index).find('td').eq(1).find('input').attr('name', 'others_input_cost' + index + '_copied' + splitKey);
      master.find('tr').eq(index).find('td').eq(2).find('input').attr('name', 'others_input_count' + index + '_copied' + splitKey);
      master.find('tr').eq(index).find('td').eq(3).find('input').attr('name', 'others_input_subtotal' + index + '_copied' + splitKey);
    }
  })

  $(document).on("click", "[class^='others_main'] .del", function () {
    $(this).parent().parent().find('td').eq(0).find('input').val('').trigger("input");
    $(this).parent().parent().find('td').eq(1).find('input').val('').trigger("input");
    $(this).parent().parent().find('td').eq(2).find('input').val('').trigger("input");
    $(this).parent().parent().find('td').eq(3).find('input').val('').trigger("input");

    var sptarget = $(this).parent().parent().find('td').eq(0).find('input').attr('name');
    var splitKey = sptarget.split('_copied');
    var master = $(this).parent().parent().parent();
    var targetTR = master.find('tr').length;
    var thisTR = $(this).parent().parent();
    if (targetTR > 1) {
      thisTR.remove();
    };
    var reTargetTR = master.find('tr');
    for (let index2 = 0; index2 < reTargetTR.length; index2++) {
      reTargetTR.eq(index2).find('td').eq(0).find('input').attr('name', 'others_input_item' + index2 + '_copied' + splitKey[1]);
      reTargetTR.eq(index2).find('td').eq(1).find('input').attr('name', 'others_input_cost' + index2 + '_copied' + splitKey[1]);
      reTargetTR.eq(index2).find('td').eq(2).find('input').attr('name', 'others_input_count' + index2 + '_copied' + splitKey[1]);
      reTargetTR.eq(index2).find('td').eq(3).find('input').attr('name', 'others_input_subtotal' + index2 + '_copied' + splitKey[1]);
    }
  })
})


$(function () {
  $(document).on('input', 'input[name^="others_input"]', function (e) {
    var count = $(this).parent().parent().parent().find('tr').length;
    var sptarget = $(this).attr('name');
    var splitKey = sptarget.split('_copied');
    splitKey = Number(splitKey[1]);

    var total_val = 0;
    for (let index = 0; index < count; index++) {
      var num1 = $('input[name="others_input_cost' + index + '_copied' + splitKey + '"]').val();
      var num2 = $('input[name="others_input_count' + index + '_copied' + splitKey + '"]').val();
      var num3 = $('input[name="others_input_subtotal' + index + '_copied' + splitKey + '"]');
      num3.val(num1 * num2);
      total_val = total_val + Number(num3.val());
    }
    var total_target = $('input[name="others_price' + splitKey + '"]');
    total_target.val(total_val);

    var fix = $('input[name="master_subtotal' + splitKey + 'fixed"]').val();
    $('input[name="master_subtotal' + splitKey + '"]').val(Number(fix) + Number(total_val));

  });

  $(document).on('input', 'input[name^="venue_breakdown"]', function (e) {
    var count = $(this).parent().parent().parent().find('tr').length;
    var sptarget = $(this).attr('name');
    var splitKey = sptarget.split('_copied');
    splitKey = Number(splitKey[1]);

    var total_val = 0;
    for (let index = 0; index < count; index++) {
      var num1 = $('input[name="venue_breakdown_cost' + index + '_copied' + splitKey + '"]').val();
      var num2 = $('input[name="venue_breakdown_count' + index + '_copied' + splitKey + '"]').val();
      var num3 = $('input[name="venue_breakdown_subtotal' + index + '_copied' + splitKey + '"]');
      num3.val(num1 * num2);
      total_val = total_val + Number(num3.val());
    }
    var total_target = $('input[name="venue_price' + splitKey + '"]');
    total_target.val(total_val);

    var fix = $('input[name="master_subtotal' + splitKey + 'fixed"]').val();
    $('input[name="master_subtotal' + splitKey + '"]').val(Number(fix) + Number(total_val));
  });


})