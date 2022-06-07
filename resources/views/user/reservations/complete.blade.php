@extends('layouts.reservation.app')
@section('content')

  <!-- ログイン、会員登録 -->
  <div class="contents">
    <div class="pagetop-text">
      <h1 class="page-title oddcolor"><span>予約お申込みを承りました</span></h1>
      <div class="page-ttl">※現段階では予約は確定しておりません。</div>
      <div class="text-box">

      <p class="mb-15">ただいま弊社での受付対応を進めております。現段階では予約は確定しておりません。後ほど、弊社からお送りする「予約完了」のご連絡をもって、正式に予約が完了致しますので、メールの到着をお待ち下さい。</p>
      <p class="mb-15">※弊社でもすみやかな受付対応を心掛けておりますが、万が一、本メール到着の１営業日経過後も弊社からの返信がない場合は、大変お手数をおかけ致しますが弊社までご連絡下さい。</p>
      <p class="mb-15">
        ※お客様のメール環境によっては迷惑メールフォルダに分類される場合がございますので、<br>
        お手数をお掛け致しますが【@s-mg.co.jp】の受信できるようご設定をお願い致します。
      </p>
      </div>
    </div>
    <p class="page-text m-b80"><a href="{{url("user/home")}}" class="confirm-btn">マイページで予約内容を確認する</a></p>


  </div>
  </div>

  <div class="top contents"><a href="#top"><img src="https://system.osaka-conference.com/img/pagetop.png" alt="上に戻る"></a></div>
@endsection