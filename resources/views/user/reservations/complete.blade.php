@extends('layouts.reservation.app')
@section('content')
<main>
  <!-- <ul class="tagBtn sticky">
    <li><a href ="https://osaka-conference.com/contact/"><span><img src="https://osaka-conference.com/img/link_conact.png" alt="問い合わせ"></span></a></li>
    <li><a href ="https://osaka-conference.com/reservation/"><img src="https://osaka-conference.com/img/link_entry.png" alt="本申込"></a></li>
</ul> -->

  <ul class="tagBtn sticky">
    <li><a class="contact_btn" href="https://osaka-conference.com/contact/">問合わせ</a></li>
    <li><a class="reserve_btn" href="https://osaka-conference.com/reservation/">会場予約</a></li>
    <li><a class="login_btn" href="https://osaka-conference.com/reservation/">ログイン</a></li>
  </ul>

  <!--コロナ対策中お知らせ非表示-->
  <section class="contents news pc">
    <dl class="information contents">
      <dt>重要なお知らせ</dt>
      <dd><a href="https://osaka-conference.com/corona/">新型コロナウィルスに対する取り組みについて</a></dd>
    </dl>
  </section>
  <section class="contents news sp">
    <dl class="information indexNews">
      <dt>重要なお知らせ</dt>
      <dd><a href="https://osaka-conference.com/corona/">新型コロナウィルスに対する取り組みについて</a></dd>
    </dl>
  </section>
  <!--コロナ対策中お知らせ非表示-->



  <!------パンクズ-------->
  <nav class="contents">
    <ol class="bread" itemscope itemtype="http://schema.org/BreadcrumbList">
      <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
        <a itemscope itemtype="http://schema.org/Thing" itemprop="item" href="https://osaka-conference.com/">
          <span itemprop="name"><img src="https://osaka-conference.com/img/icon_bread.png" alt="HOME"></span></a>
        <meta itemprop="position" content="1">
      </li>
      <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
        <a itemscope itemtype="http://schema.org/Thing" itemprop="item" href="https://osaka-conference.com/calendar/">
          <span itemprop="name"><span class="changeTtl">カレンダー（空室確認）</span></span></a>
        <meta itemprop="position" content="2">
      </li>
    </ol>
  </nav>


  <!-- ログイン、会員登録 -->
  <div class="contents">
    <div class="pagetop-text">
      <h1 class="page-title oddcolor"><span>予約申し込み完了</span></h1>
      <h2>ご予約ありがとうございました。</h2>
      <div class="text-box">
        <p>
          送信が完了しました。内容を確認後、改めて担当者よりご連絡を差し上げます。
          今しばらくお待ちください。</p>
        <p>※フォームからの送信後、弊社からの自動返信が届かない場合は、フォームに入力していただいたメールアドレスに誤りがある可能性がございます。
          お手数ですが再度お問い合わせをいただきますようお願いいたします。</p>
        <p>※弊社からの自動返信がお客様のメール利用環境により迷惑フォルダに受信される場合がございます。
          お手数ですが迷惑フォルダもご確認いただけましたら幸いです。その場合は【@s-mg.co.jp】を受信設定していただきますようお願いいたします。</p>
      </div>
    </div>
    <div class="btn-wrapper2">
      <p class="confirm-btn"><a href="">予約内容・予約履歴を確認する</a></p>
    </div>

  </div>
  </div>

  <div class="top contents"><a href="#top"><img src="https://osaka-conference.com/img/pagetop.png" alt="上に戻る"></a></div>
</main>
@endsection