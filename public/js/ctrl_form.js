

$(function () {
  function resetPostCode($inputName) {
    $($inputName).on("click", function () {
      $($inputName).val("");
    })
  }
  resetPostCode('input[name="post_code"]');
  resetPostCode('input[name="luggage_post_code"]');
})

