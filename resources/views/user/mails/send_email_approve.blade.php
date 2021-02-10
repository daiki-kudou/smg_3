<br>
<p>
  {{$reservation_id->user->company}}<br>
  {{$reservation_id->bill_person}} 様<br>
  <br>
  ご予約いただきありがとうございます。<br>
  以下の内容で予約を確定してもよろしいでしょうか。<br>
  よろしければ、予約の承認をお願い致します。<br>
  <br>
  日時： {{ReservationHelper::formatDate($reservation_id->reserve_date)}}　{{$reservation_id->enter_time}} -
  {{$reservation_id->leave_time}}<br>
  会場：
  {{ReservationHelper::getVenue($reservation_id->venue_id)}}
  <br>
  住所：
  {{ReservationHelper::getVenueAddreess($reservation_id->venue_id)[0]}}
  {{ReservationHelper::getVenueAddreess($reservation_id->venue_id)[1]}}
  {{ReservationHelper::getVenueAddreess($reservation_id->venue_id)[2]}}
  {{ReservationHelper::getVenueAddreess($reservation_id->venue_id)[3]}}
  {{ReservationHelper::getVenueAddreess($reservation_id->venue_id)[4]}}
  <br>
  アクセス<br>
  #########<br>
  #########<br>
  <br>
  ご請求額　{{number_format($reservation_id->bills()->first()->total)}}円<br>
  <br>
  上記内容で問題なければ下記リンク先より承認手続きをお願い致します。<br>
  {{-- <a href="{{'https://staging-smg2.herokuapp.com/user/home/'.$reservation_id->id}}">請求書を確認する</a><br> --}}
  <a href="{{'https://staging-smg2.herokuapp.com/user/home/'.$reservation_id->id}}">請求書を確認する</a><br>
  <br>
  ご確認お願いします。<br>
  <br>
  ※本メールはサーバーからの自動返信メールとなっております。<br>
  本メールに送信いただいていもご連絡致しかねますのでご了承ください。<br>
  <br>
  <br>
  ---------------------------------<br>
  SMGアクセア貸し会議室<br>
  Email: info@<br>
  Web: https://<br>
  TEL: 03-0000-0000<br>
  ---------------------------------<br>

</p>