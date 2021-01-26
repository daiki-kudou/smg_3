<br>
<p>
  {{$bill->reservation->user->company}}<br>
  {{$bill->reservation->user->bill_person}} 様<br>
  <br>
  ご予約いただきありがとうございます。<br>
  以下の内容で予約を確定してもよろしいでしょうか。<br>
  よろしければ、予約の承認をお願い致します。<br>
  <br>
  日時： {{ReservationHelper::formatDate($bill->reservation->reserve_date)}}　{{$bill->reservation->enter_time}} -
  {{$bill->reservation->leave_time}}<br>
  会場：
  {{ReservationHelper::getVenue($bill->reservation->venue_id)}}
  <br>
  住所：
  {{ReservationHelper::getVenueAddreess($bill->reservation->venue_id)[0]}}
  {{ReservationHelper::getVenueAddreess($bill->reservation->venue_id)[1]}}
  {{ReservationHelper::getVenueAddreess($bill->reservation->venue_id)[2]}}
  {{ReservationHelper::getVenueAddreess($bill->reservation->venue_id)[3]}}
  {{ReservationHelper::getVenueAddreess($bill->reservation->venue_id)[4]}}
  <br>
  アクセス<br>
  #########<br>
  #########<br>
  <br>
  <h1>追加内容</h1>
  @if ($bill->category==2)
  その他有料備品、サービス
  @elseif($bill->category==3)
  レイアウト変更又は追加
  @elseif($bill->category==4)
  その他
  @endif
  <br>
  ご請求額　{{number_format($bill->total)}}円<br>
  <br>
  上記内容で問題なければ下記リンク先より承認手続きをお願い致します。<br>
  <a href="{{'https://staging-smg2.herokuapp.com/user/home/'.$reservation_id->id}}">請求書を確認する</a><br>
  {{-- <a href="{{'http://127.0.0.1:8000/user/home/'.$reservation_id->id}}">後ほど修正</a><br> --}}
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