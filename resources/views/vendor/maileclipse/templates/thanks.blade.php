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
<pre>----------------------------------------------------------------------------------<br />当メールは自動送信メールです。<br />----------------------------------------------------------------------------------<br /><br />{{ $company }} 様<br /><br />株式会社SMGです。<br /><br />この度は「SMG貸し会議室」をご利用頂き、<br />誠にありがとうございました。<br /><br />弊社貸し会議室では、お客様へのサービス向上のため、<br />ご要望・お問合わせを随時受け付けております。<br />何か気がついたことがありましたら、<br />問い合わせフォームよりお気軽にお申し付け下さい。<br /><br />問い合わせフォーム<br />https://osaka-conference.com/contact/<br /><br />また、下記の「SMG貸し会議室の利用案内」を<br />ご一読いただけましたら幸いです。<br />────────────────<br />■口コミ投稿のお願い<br />ご利用頂いた皆さまへ。<br />Googleマップの口コミ投稿をお願いしております。<br />今後の貸し会議室運営の参考にさせて頂きますので<br />ご協力のほどよろしくお願い致します。<br />※下記リンク先はGoogleマップになります<br />四ツ橋・サンワールドビル　<br />[各会場のGoogleマイビジネスURL]<br />────────────────<br />■定期・複数日程割引＆特典のご案内<br />https://osaka-conference.com/characteristic/regular-use/<br />SMG貸し会議室では、定期・複数日程でご利用いただけるお客様に<br />長期間心地よくご利用いただきたい、という想いから、<br />利用頻度や回数、そしてご予算に応じた特別料金のご提示はもちろんのこと、<br />利用スタイルに合わせて下記特典を含む様々な提案をさせていただきます。<br />例えば、特別お見積り（利用頻度・回数・ご予算に応じて個別にお見積り）や<br />鍵の貸出サービスなど。<br />まずはお気軽に問い合わせ下さい。<br />────────────────<br />▼マイページログイン<br /><a href="{{url('/user/login')}}">マイページ</a><br />```<br />四ツ橋・サンワールドビル全会場　https://goo.gl/maps/KpJKfWkZD7XRyMpg6<br />四ツ橋・近商ビル全会場　https://goo.gl/maps/zgtVPWPm9jknwEte8<br />本町・カーニープレイス全会場　https://goo.gl/maps/CnV29S7JEokd3UNg8<br />難波・日興ビル　https://goo.gl/maps/nAkpBdFRmSQxjz1r7<br />＜注意＞難波・日興ビルにつきましては、B2FのみURLを記載します。 <br />　　　　6FA・6FBにつきましては記載しません。<br />```<br />貸し会議室の予約申込み、予約内容の確認、<br />会員情報変更などが可能です。<br />────────────────<br /><br />それではこの度のご利用に関しまして重ねて御礼申し上げます。<br />今後ともSMG貸し会議室をよろしくお願い致します。<br /><br />----------------------------------------------------------------------------------<br />※万一、本メールにお心当たりがない場合は、<br />　大変お手数ですが下記署名欄の連絡先までお知らせ下さい。<br />----------------------------------------------------------------------------------<br />SMG貸し会議室（株式会社SMG）<br />〒550-0014 <br />大阪市西区北堀江1-6-2 サンワールドビル11F<br />TEL: 0665566462　FAX: 0665384315<br />（受付時間：平日10時～18時）<br />E-mail: kaigi@s-mg.co.jp<br />HP: {{url('/')}}<br />----------------------------------------------------------------------------------</pre>
</body>
</html>