@extends('layouts.reservation.app')
@section('content')
<main>

  <!-- ログイン、会員登録 -->
  <div class="contents">
    <div class="pagetop-text">
      <h1 class="page-title oddcolor"><span>予約申し込み完了</span></h1>
      <p class="page-ttl">ご予約ありがとうございました。</p>
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
    <p class="page-text m-b80"><a href="{{url("user/home")}}" class="confirm-btn">マイページで予約内容を確認する</a></p>


  </div>
  </div>

  <div class="top contents"><a href="#top"><img src="https://osaka-conference.com/img/pagetop.png" alt="上に戻る"></a></div>
</main>
@endsection