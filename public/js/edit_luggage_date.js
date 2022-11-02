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

    if ($('#luggage_arrive').val() !== "") {
        let dObj = new Date($('#luggage_arrive').val());
        let wDay = dObj.getDay();
        $('#changeLuggageArriveDate').text(WeekChars[wDay]);
    }

    $("#luggage_arrive").change(function () {
        if ($('#luggage_arrive').val() !== "") {
            let dObj = new Date($('#luggage_arrive').val());
            let wDay = dObj.getDay();
            $('#changeLuggageArriveDate').text(WeekChars[wDay]);
        } else {
            $('#changeLuggageArriveDate').text('');
        }
    });

});