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
      h1, h2, h3, h4, h5, h6 {
        color: black !important;
      }

      h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {
        color: blue !important;
      }

      h1 a:active, h2 a:active, h3 a:active, h4 a:active, h5 a:active, h6 a:active {
        color: red !important;
        /* Preferably not the same color as the normal header link color.  There is limited support for psuedo classes in email clients, this was added just for good measure. */
      }

      h1 a:visited, h2 a:visited, h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {
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
        width: 100%!important;
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

      h1, h2, h3, h4, h5,
      p, ul, ol {
        /* This fixes Gmail's terrible text rendering  */
        font-family: Cambria, Utopia, "Liberation Serif",Times, "Times New Roman", serif;
        font-weight: 400;
      }

      h1, h2, h3, h4, h5 {
        margin: 20px 0 10px;
        color: #000;
        line-height: 1.2;
      }

      h1 { font-size: 32px; }
      h2 { font-size: 26px; }
      h3 { font-size: 22px; }
      h4 { font-size: 18px; }
      h5 { font-size: 16px; }

      p, ul, ol {
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
        clear: both!important;
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
        display: block!important;
        max-width: 600px!important;
        margin: 0 auto!important; /* makes it centered */
        clear: both!important;
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
<pre>----------------------------------------------------------------------------------<br />当メールは自動送信メールです。<br />----------------------------------------------------------------------------------<br /><br />{{ $company }} 様<br /><br />株式会社SMGです。<br /><br />いつも「SMG貸し会議室」をご利用頂き、<br />誠にありがとうございます。<br /><br />下記の通り、予約申込みを受付しました。<br /><br />なお現段階ではまだ予約は完了しておりません。<br />弊社で予約申込みの内容確認を行い、<br />その後、弊社からの「予約完了」連絡をもって<br />正式に予約完了となります。<br /><br />────────────────<br />【予約受付内容】<br />────────────────<br />・会員ID：{{ $user_id }}<br />・カテゴリ：会場予約<br />・予約ID：{{ $user_id }}<br />・ご利用日：{{ $reserve_date }}<br />・ご利用時間：{{ $enter_time }}～{{ $leave_time }}<br />・会場：{{ $venue_name }}<br />・利用料金：{{ $master_total }}円 税込<br />　※予約内容によって料金変動が生じる際はSMGからご連絡を差し上げます。<br />・会場URL：{{ $smg_url }}<br /><br />────────────────<br />【この後のお手続きについて】<br />────────────────<br />・ただいま弊社で予約申込みの受付、<br />　内容確認の手続きを進めております。<br />現段階で、まだご予約は完了しておりません。<br /><br />・後ほど、弊社からお送りする「予約完了」の連絡をもって、<br />　正式に予約完了となりますので、メールの到着をお待ち下さい。<br />　━━━ご注意━━━━━━━━━━━━━━━<br />　「予約完了」後に変更・キャンセルが生じる場合は、<br />　原則、キャンセル料金が発生しますのでご了承下さい。<br />　キャンセルポリシー<br />　https://osaka-conference.com/cancelpolicy/<br />　━━━━━━━━━━━━━━━━━━━━━<br /><br />・「予約完了」前に、変更等のご相談がある場合は、<br />　まずは電話またはメールにて弊社へ連絡をお願いします。<br /><br />・万一、本メール到着の３営業日経過後も<br />　弊社からの返信がない場合は、<br />　大変お手数をおかけ致しますが、署名の連絡先へお知らせ下さい。<br /><br />ご不明な点がございましたら気軽にお問合せ下さい。<br />どうぞよろしくお願い致します。<br />────────────────<br />▼マイページログイン<br /><a href="{{url('/user/login')}}">マイページ</a><br />貸し会議室の予約申込み、予約内容の確認、<br />会員情報変更などが可能です。<br />────────────────<br /><br />----------------------------------------------------------------------------------<br />※万一、本メールにお心当たりがない場合は、<br />　大変お手数ですが下記署名欄の連絡先までお知らせ下さい。<br />----------------------------------------------------------------------------------<br />SMG貸し会議室（株式会社SMG）<br />〒550-0014 <br />大阪市西区北堀江1-6-2 サンワールドビル11F<br />TEL: 0665566462　FAX: 0665384315<br />（受付時間：平日10時～18時）<br />E-mail: kaigi@s-mg.co.jp<br />HP: {{url('/')}}<br />----------------------------------------------------------------------------------</pre>
</body>
</html>