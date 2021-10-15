$(function () {
  //アコーディオン
  $(function () {
    $(".accordion-wrap").hide();
    $(".accordion-ttl").on("click", function () {
      $(this).next().slideToggle("fast");
      $(this).find(".title-icon").toggleClass("active");
    });
  });

  // 追加請求　その他ラジオボタン-------------------------
  $(function () {
    $('input[name="billcategory"]:radio').change(function () {
      var radioval = $(this).val();
      if (radioval == 3) {
        $('#inputother').removeAttr('disabled');
      } else {
        $('#inputother').attr('disabled', 'disabled');
      }
    });
  });

  // 追加請求　ラジオボタン-------------------------
  $(function () {
    $('.fee-table').hide();
    $('.service').show();
    $('[name="category"]:radio').change(function () {
      if ($('[id=service]').prop('checked')) {
        $('.fee-table').hide();
        $('.service').show();
      }
      else if ($('[id=layout]').prop('checked')) {
        $('.fee-table').hide();
        $('.layout').show();
      }
      else {
        $('.fee-table').hide();
        $('.other').show();
      }
    });
  });

  //   ドラッグアンドドロップ------------------------------------------
  $(function () {
    $("#sortableArea").sortable();
  });
});
