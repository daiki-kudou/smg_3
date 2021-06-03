

$(function () {
  $('input[name="post_code"]').on('blur', function () {
    $('input[name="address1"]').click();
  })
})

