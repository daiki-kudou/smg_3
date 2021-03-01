$(function () {
  var target = $('#venue_index_table tr').length;
  console.log(target);
  for (let index = 0; index < target; index++) {
    var targetTd = $('#venue_index_table tr').eq(index).find('td').eq(2);
    if (targetTd.text() == "直営") {
      targetTd.css('color', 'red');
    } else if (targetTd.text() == "提携") {
      targetTd.css('color', 'blue');
    }
  }

})