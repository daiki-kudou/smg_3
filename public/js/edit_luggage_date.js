$(function () {

    let WeekChars = ["（日）", "（月）", "（火）", "（水）", "（木）", "（金）", "（土）"];

   if ($('#datepicker2').val() !== "") {
        let dObj = new Date($('#datepicker2').val());
        let wDay = dObj.getDay();
        $('#changeLuggageArriveDate').text(WeekChars[wDay]);
    }

    $("#datepicker2").change(function () {
        if ($('#datepicker2').val() !== "") {
            let dObj = new Date($('#datepicker2').val());
            let wDay = dObj.getDay();
            $('#changeLuggageArriveDate').text(WeekChars[wDay]);
        } else {
            $('#changeLuggageArriveDate').text('');
        }
    });
});