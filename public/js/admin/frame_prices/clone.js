
$(function () {
  $('.add').on('click', function () {
    var validator = $("#FramePriceCreateForm").validate();
    validator.resetForm();
    $('label.error').remove();
    $('span.is-error').remove();
    validator.destroy();

    var tr = $(this).parent().parent();
    tr.clone(true).insertAfter(tr);
    tr.parent().find('tr').each(function (index, element) {
      tr.parent().find('tr').eq(index).find('td').eq(0).find('input').attr('name', "frame[" + index + "]").attr('aria-describedby', "");
      tr.parent().find('tr').eq(index).find('td').eq(1).find('input').attr('name', "start[" + index + "]").attr('aria-describedby', "");
      tr.parent().find('tr').eq(index).find('td').eq(2).find('input').attr('name', "finish[" + index + "]").attr('aria-describedby', "");
      tr.parent().find('tr').eq(index).find('td').eq(3).find('input').attr('name', "price[" + index + "]").attr('aria-describedby', "");
    })

    tr.next().find('td').eq(0).find('input').val("");
    tr.next().find('td').eq(1).find('select').find('option').eq(17).attr('selected', true);
    tr.next().find('td').eq(2).find('select').find('option').eq(25).attr('selected', true);
    tr.next().find('td').eq(3).find('input').val("");

    $("#FramePriceCreateForm").validate({
      rules: {
        extend: { required: true },
      },
      messages: {
        extend: {
          required: "※必須項目です",
        },
      },
      errorElement: "span",
      errorClass: "is-error",
    });
    $('table tbody tr').each(function (index, element) {
      $("input[name='frame[" + index + "]']").rules("add", {
        required: true,
        messages: {
          required: "※必須項目です"
        }
      });
      $("select[name='start[" + index + "]']").rules("add", {
        required: true,
        number: true,
        messages: {
          required: "※必須項目です",
          number: "※半角数字を入力してください",
        }
      });
      $("select[name='finish[" + index + "]']").rules("add", {
        required: true,
        number: true,
        messages: {
          required: "※必須項目です",
          number: "※半角数字を入力してください",
        }
      });
      $("input[name='price[" + index + "]']").rules("add", {
        required: true,
        messages: {
          required: "※必須項目です"
        }
      });
    })
    $("input").on("blur change", function () {
      $(this).valid();
    });


  })

  $(document).on("click", ".del", function () {
    var validator = $("#FramePriceCreateForm").validate();
    validator.resetForm();
    $('label.error').remove();
    $('span.is-error').remove();
    validator.destroy();

    var master = $(this).parent().parent().parent().find('tr').length;
    var target = $(this).parent().parent();
    var target2 = $(this).parent().parent().parent();
    if (master > 1) {
      target.remove();
      target2.find('tr').each(function (index, element) {
        target2.find('tr').eq(index).find('td').eq(0).find('input').attr('name', "frame[" + index + "]").attr('aria-describedby', "");
        target2.find('tr').eq(index).find('td').eq(1).find('input').attr('name', "start[" + index + "]").attr('aria-describedby', "");
        target2.find('tr').eq(index).find('td').eq(2).find('input').attr('name', "finish[" + index + "]").attr('aria-describedby', "");
        target2.find('tr').eq(index).find('td').eq(3).find('input').attr('name', "price[" + index + "]").attr('aria-describedby', "");
      })
      var result = 0;
    }
    $("#FramePriceCreateForm").validate({
      rules: {
        extend: { required: true },
      },
      messages: {
        extend: {
          required: "※必須項目です",
        },
      },
      errorElement: "span",
      errorClass: "is-error",
    });
    $('table tbody tr').each(function (index, element) {
      $("input[name='frame[" + index + "]']").rules("add", {
        required: true,
        messages: {
          required: "※必須項目です"
        }
      });
      $("select[name='start[" + index + "]']").rules("add", {
        required: true,
        number: true,
        messages: {
          required: "※必須項目です",
          number: "※半角数字を入力してください",
        }
      });
      $("select[name='finish[" + index + "]']").rules("add", {
        required: true,
        number: true,
        messages: {
          required: "※必須項目です",
          number: "※半角数字を入力してください",
        }
      });
      $("input[name='price[" + index + "]']").rules("add", {
        required: true,
        messages: {
          required: "※必須項目です"
        }
      });
    })
    $("input").on("blur change", function () {
      $(this).valid();
    });
  })
})