<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>

<body>
  <p>&nbsp;</p>
  !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
  <p>{{$reservation_id->user->company}}<br />{{ReservationHelper::getPersonName($reservation_id->user->id)}}
    様<br /><br />この度は、SMG貸し会議室のご予約をいただきありがとうございます。<br />下記の内容で、予約が完了しました。</p>
  <p>
    <br /><br />ご予約内容<br />======================================<br />日時：{{ReservationHelper::formatDate($reservation_id->reserve_date)}}　{{$reservation_id->enter_time}}
    - {{$reservation_id->leave_time}}<br />会場： {{ReservationHelper::getVenueUser($reservation_id->venue_id)}}<br />住所：
    {{ReservationHelper::getVenueAddreess($reservation_id->venue_id)[0]}}
    {{ReservationHelper::getVenueAddreess($reservation_id->venue_id)[1]}}
    {{ReservationHelper::getVenueAddreess($reservation_id->venue_id)[2]}}
    {{ReservationHelper::getVenueAddreess($reservation_id->venue_id)[3]}}
    {{ReservationHelper::getVenueAddreess($reservation_id->venue_id)[4]}}
    <br /><br />詳細については、下記リンク先よりご確認をお願い致します。<br /><a
      href="{{'https:/staging-smg2.herokuapp.com/user/home/'.$reservation_id->id}}">マイページより確認する</a><br /><br /><br />--------------------------------------------------------------<br />※このメールは自動返信用です。こちらのメールに返信いただきましてもご返答できませんので予めご了承ください。<br /><br />■お問い合わせについて　<br />=====================================<br />▼お電話で<br />TEL：06-6556-6462
    / 受付時間：10時～18時　年中無休<br />▼メールで<br />info@osaka-conference.com /
    24時間受付中<br />=====================================<br />SMG貸し会議室は大阪市内各主要駅から徒歩0〜2分。<br />JR大阪/梅田・新大阪駅からアクセス抜群。<br /><br />-----------------------------------------------------------------------------<br />株式会社SMG<br />TEL：06-6556-6462<br />〒550-0014　<br />大阪市西区北堀江1丁目6番2号
    サンワールドビル11階<br />-----------------------------------------------------------------------------"<br /><br /></p>
</body>

</html>