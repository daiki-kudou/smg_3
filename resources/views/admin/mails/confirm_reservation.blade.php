<br>
<p>
  下記内容で、予約が承認されました。<br>
  担当の方は、ご確認をお願いします。<br>
  <br>
  予約内容<br>
  ======================================<br>
  {{$reservation->user->company}}<br>
  {{ReservationHelper::getPersonName($reservation->user->id)}}<br>
  日時：{{ReservationHelper::formatDate($reservation_id->reserve_date)}}　{{$reservation_id->enter_time}} -
  {{$reservation_id->leave_time}}<br>
  会場： {{ReservationHelper::getVenue($reservation_id->venue_id)}}<br>
  <br>
  管理画面より確認する"<br>
  <a href="{{'https://staging-smg2.herokuapp.com/admin/reservations/'.$reservation_id->id}}">マイページより確認する</a><br>
  <br>
</p>