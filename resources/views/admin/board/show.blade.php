<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>案内板</title>

  <link href="{{ asset('/css/invoice.css') }}" rel="stylesheet" media="screen">
  <link href="{{ asset('/css/boardprint.css') }}" rel="stylesheet" media="print">
</head>

<body>
  <div class="button-wrap">
    <p><input class="print-btn" type="button" value="このページを印刷する" onclick="window.print();" /></p>
  </div>
  <div class="print-cover">
    <table cellpadding="0" cellspacing="0" class="board-inner board-box">
      <tr class="date">
        <td>
          <span>{{ReservationHelper::formatDate($reservation->reserve_date)}}</span>
          <span>{{ReservationHelper::formatTime($reservation->event_start)}}～{{ReservationHelper::formatTime($reservation->event_finish)}}</span>
        </td>
      </tr>
      <tr class="event-name">
        <td>
          {{$reservation->event_name1}}
        </td>
      </tr>
      <tr class="event-name2">
        <td>
          <p>{{$reservation->event_name2}}</p>
        </td>
      </tr>

      <tr class="event-owner">
        <td>
          <span class="evet-owner-ttl">主催：</span>
          <span class="evet-owner-name">{{$reservation->event_owner}}</span>
          <p class="border-line"></p>
        </td>
      </tr>

      <tr class="venue">
        <td>
          <!-- <p>{{ReservationHelper::getVenueForUser($reservation->venue_id)}}</p> -->
          <p>{{ $reservation->venue->name_area }}<span class="venue_buildname">{{ $reservation->venue->name_bldg
              }}</span>{{ $reservation->venue->name_venue }}</p>
        </td>
      </tr>
    </table>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script>
    $(function() {
    var owner = $(".evet-owner-name").text();
    if (owner.length>0) {
      $(".evet-owner-ttl").css("display","inline-block");
    } else {
      $(".evet-owner-ttl").css("display","none");
    }
  });
  </script>

</body>


</html>