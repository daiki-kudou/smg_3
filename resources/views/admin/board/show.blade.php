
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
          <span>主催：</span>
          <span>{{$reservation->event_owner}}</span>
        </td>
      </tr>

      <tr class="venue">
        <td>
          <p class="border-line"></p>
          <p>{{ReservationHelper::getVenueForUser($reservation->venue_id)}}</p>
        </td>
      </tr>
    </table>
  </div>
</body>

</html>




<!-- <pre>{{var_dump($reservation)}}</pre>
<br>
<br>
<br>
<br>
<pre>{{var_dump($reservation->user)}}</pre>
<br>
<br>
<br>
<br>
<pre>{{var_dump($reservation->enduser)}}</pre>
<br>
<br>
<br>
<br> -->