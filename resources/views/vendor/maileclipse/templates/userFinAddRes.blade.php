<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Plain Jane Text</title>
  <style type="text/css">
    /* Based on The MailChimp Reset INLINE: Yes. */
    /* Client-specific Styles */
    #outlook a {
      padding: 0;
    }

    /* Force Outlook to provide a "view in browser" menu link. */
    body {
      width: 100% !important;
      margin: 0;
      padding: 0;
      -webkit-text-size-adjust: 100%;
      -ms-text-size-adjust: 100%;
    }

    /* Prevent Webkit and Windows Mobile platforms from changing default font sizes.*/
    .ExternalClass {
      width: 100%;
    }

    /* Force Hotmail to display emails at full width */
    .ExternalClass,
    .ExternalClass p,
    .ExternalClass span,
    .ExternalClass font,
    .ExternalClass td,
    .ExternalClass div {
      line-height: 100%;
    }

    /* Forces Hotmail to display normal line spacing.  More on that: http://www.emailonacid.com/forum/viewthread/43/ */
    #backgroundTable {
      margin: 0;
      padding: 0;
      width: 100% !important;
      line-height: 100% !important;
    }

    /* End reset */
    /* Some sensible defaults for images
          Bring inline: Yes. */

    img {
      outline: none;
      text-decoration: none;
      -ms-interpolation-mode: bicubic;
    }

    a img {
      border: none;
    }

    .image_fix {
      display: block;
    }

    /* Yahoo paragraph fix
          Bring inline: Yes. */
    p {
      margin: 1em 0;
    }

    /* Hotmail header color reset
          Bring inline: Yes. */
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
      color: black !important;
    }

    h1 a,
    h2 a,
    h3 a,
    h4 a,
    h5 a,
    h6 a {
      color: blue !important;
    }

    h1 a:active,
    h2 a:active,
    h3 a:active,
    h4 a:active,
    h5 a:active,
    h6 a:active {
      color: red !important;
      /* Preferably not the same color as the normal header link color.  There is limited support for psuedo classes in email clients, this was added just for good measure. */
    }

    h1 a:visited,
    h2 a:visited,
    h3 a:visited,
    h4 a:visited,
    h5 a:visited,
    h6 a:visited {
      color: #000;
      color: purple !important;
      /* Preferably not the same color as the normal header link color. There is limited support for psuedo classes in email clients, this was added just for good measure. */
    }

    /* Outlook 07, 10 Padding issue fix
          Bring inline: No.*/
    table td {
      border-collapse: collapse;
    }

    /* Remove spacing around Outlook 07, 10 tables
          Bring inline: Yes */
    table {
      border-collapse: collapse;
      mso-table-lspace: 0pt;
      mso-table-rspace: 0pt;
    }


    /* Global */
    * {
      margin: 0;
      padding: 0;
    }

    body {
      -webkit-text-size-adjust: 100%;
      -ms-text-size-adjust: 100%;
      width: 100% !important;
      height: 100%;
      font-family: Cambria, Utopia, "Liberation Serif", Times, "Times New Roman", serif;
      font-weight: 400;
      font-size: 100%;
      line-height: 1.6;
    }

    /* Styling your links has become much simpler with the new Yahoo.  In fact, it falls in line with the main credo of styling in email and make sure to bring your styles inline.  Your link colors will be uniform across clients when brought inline.
          Bring inline: Yes. */
    a {
      color: #348eda;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    p,
    ul,
    ol {
      /* This fixes Gmail's terrible text rendering  */
      font-family: Cambria, Utopia, "Liberation Serif", Times, "Times New Roman", serif;
      font-weight: 400;
    }

    h1,
    h2,
    h3,
    h4,
    h5 {
      margin: 20px 0 10px;
      color: #000;
      line-height: 1.2;
    }

    h1 {
      font-size: 32px;
    }

    h2 {
      font-size: 26px;
    }

    h3 {
      font-size: 22px;
    }

    h4 {
      font-size: 18px;
    }

    h5 {
      font-size: 16px;
    }

    p,
    ul,
    ol {
      margin-bottom: 10px;
      font-weight: normal;
      font-size: 16px;
      line-height: 1.4;
    }

    ul li,
    ol li {
      margin-left: 5px;
      list-style-position: inside;
    }

    /* Body */
    table.body-wrap {
      width: 100%;
      padding: 30px;
    }


    /* Footer */
    table.footer-wrap {
      width: 100%;
      clear: both !important;
    }

    .footer-wrap .container p {
      font-size: 12px;
      color: #666;
    }

    table.footer-wrap a {
      color: #999;
    }


    /* Give it some responsive love */
    .container {
      display: block !important;
      max-width: 600px !important;
      margin: 0 auto !important;
      /* makes it centered */
      clear: both !important;
    }

    /* Set the padding on the td rather than the div for Outlook compatibility */
    .body-wrap .container {
      padding: 30px;
    }

    /* This should also be a block element, so that it will fill 100% of the .container */
    .content {
      max-width: 600px;
      margin: 0 auto;
      display: block;
    }

    /* Let's make sure tables in the content area are 100% wide */
    .content table {
      width: 100%;
    }
  </style>
  <!--[if gte mso 9]>
      <style>
        /* Target Outlook 2007 and 2010 */
      </style>
    <![endif]-->
</head>

<body>
  ----------------------------------------------------------------------------------
  <br />
  当メールは自動送信メールです。
  <br />
  ----------------------------------------------------------------------------------
  <br />

  <br />
  {{ $company }} 様
  <br />

  <br />
  株式会社SMGです。
  <br />

  <br />
  いつも「SMG貸し会議室」をご利用頂き、
  <br />
  誠にありがとうございます。
  <br />

  <br />
  本メールをもちまして
  <br />
  下記の通り、予約が完了しました。
  <br />
  ご確認の上、支払期日までに利用料金をお振込下さいますよう
  <br />
  よろしくお願いいたします。
  <br />

  <br />
  ▼マイページログイン
  <br />
  <a href="{{url('/user/login')}}">マイページ</a>
  <br />
  ────────────────
  <br />
  【予約内容】
  <br />
  ────────────────
  <br />
  ・会員ID：
  <br />
  {{ $user_id }}
  <br />

  <br />
  ・カテゴリ：
  <br />
  追加請求
  <br />

  <br />
  ・予約ID：
  <br />
  {{ $reservation_id }}
  <br />

  <br />
  ・ご利用日：
  <br />
  {{ $reserve_date }}
  <br />

  <br />
  ・ご利用時間：
  <br />
  {{ $enter_time }}～{{ $leave_time }}
  <br />

  <br />
  ・会場：
  <br />
  {{ $venue_name }}
  <br />

  <br />
  ・当日の担当者：
  <br />
  {{ $in_charge }}
  <br />

  <br />
  ・当日の担当者連絡先：
  <br />
  {{ $tel }}
  <br />

  <br />
  @if ((int)$price_system===2)
  ・音響ハイグレード： する<br><br>
  @endif

  @if ((int)$board_flag===1)
  ・案内板の作成：<br />
  案内板の作成　する<br />
  イベント名称1行目：{{ $event_name1 }}<br />
  イベント名称2行目：
  @if (!empty($event_name2))
  {{ $event_name2 }}
  @endif
  <br>主催者名：
  @if (!empty($event_owner))
  {{ $event_owner }}
  @endif
  <br>イベント時間：
  @if (!empty($enter_time)&&!empty($leave_time))
  {{ $enter_time }}~{{ $leave_time }}
  @endif
  <br><br>
  @endif

  @if ((int)$eat_in===1)
  ・室内飲食：<br />
  室内飲食　あり<br />
  @if ((int)$eat_in_prepare===1)
  手配済み
  @elseif((int)$eat_in_prepare===2)
  検討中
  @endif
  <br /><br />
  @endif

  @if (count($equipment_data)!==0)
  ・有料備品：<br />
  @foreach ($equipment_data as $e)
  {{ $e['unit_item'] }}+{{ number_format($e['unit_cost']) }}円+{{ $e['unit_count'] }}個<br>
  @endforeach
  <br>
  @endif

  @if (count($service_data)!==0)
  ・有料サービス：<br />
  @foreach ($service_data as $s)
  {{ $s['unit_item'] }}+{{ number_format($s['unit_cost']) }}円<br>
  @endforeach
  <br>
  @endif

  @if (count($layout_data)!==0)
  ・レイアウト変更：<br />
  @foreach ($layout_data as $l)
  {{ $l }}<br>
  @endforeach
  <br>
  @endif

  @if ((int)$luggage_flag===1)
  ・荷物預かり：<br />
  荷物預かり あり<br />
  事前に預かる荷物（目安）：{{ $luggage_count }}個<br />
  事前荷物の到着日（午前指定）：{{ $luggage_arrive }}<br />
  事後返送する荷物：{{ $luggage_return }}個<br />
  <br />
  @endif

  @if (!empty($admin_details))
  ・備考：<br />
  {{ $admin_details }}<br />
  <br />
  @endif

  ・ご利用料金：<br />
  {{ $bill_data->master_total }}円<br />
  <br />

  ・支払期日：<br />
  {{ $bill_data->payment_limit }}<br />
  <br />

  ・会場URL：<br />
  {{ $smg_url }}<br />
  <br />

  ────────────────
  <br />
  【料金のお支払いについて】
  <br />
  ────────────────
  <br />
  支払期日をご確認の上、銀行振込みにてお支払い下さい。
  <br />
  ・請求書No：{{ $bill_data->invoice_number }}<br />
  ・利用料金：{{ $bill_data->master_total }}<br />
  ・支払期日：{{ $bill_data->payment_limit }}<br />
  ▼SMG銀行口座情報
  <br />
  銀行名　：関西みらい銀行　堀江支店
  <br />
  口座番号：普通　0088187　
  <br />
  口座名義：ｶ)ｴｽｴﾑｼﾞｰ
  <br />
  ※お支払いについて
  <br />
  https://osaka-conference.com/flow/#step3
  <br />
  ────────────────
  <br />
  【予約キャンセル・変更について】
  <br />
  ────────────────
  <br />
  本メールをもって「予約完了」しております。
  <br />
  これより予約変更・キャンセルをされる場合は、
  <br />
  原則、キャンセル料金が発生致しますのでご了承下さい。
  <br />
  キャンセルポリシー
  <br />
  https://osaka-conference.com/cancelpolicy/
  <br />
  ────────────────
  <br />
  ▼マイページログイン
  <br />
  <a href="{{url('/user/login')}}">マイページ</a>
  <br />
  貸し会議室の予約申込み、予約内容の確認、
  <br />
  会員情報変更などが可能です。
  <br />
  ────────────────
  <br />

  <br />
  ご不明な点がございましたら気軽にお問合せ下さい。
  <br />
  どうぞよろしくお願い致します。
  <br />

  <br />
  ----------------------------------------------------------------------------------
  <br />
  ※万一、本メールにお心当たりがない場合は、
  <br />
  　大変お手数ですが下記署名欄の連絡先までお知らせ下さい。
  <br />
  ----------------------------------------------------------------------------------
  <br />
  SMG貸し会議室（株式会社SMG）
  <br />
  〒550-0014
  <br />
  大阪市西区北堀江1-6-2 サンワールドビル11F
  <br />
  TEL: 0665566462　FAX: 0665384315
  <br />
  （受付時間：平日10時～18時）
  <br />
  E-mail: kaigi@s-mg.co.jp
  <br />
  HP: {{url('/')}}
  <br />
  ----------------------------------------------------------------------------------
</body>

</html>