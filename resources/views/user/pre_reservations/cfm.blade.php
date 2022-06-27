@extends('layouts.user.app')
@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>

<div class="container-fluid">
  <div class="container-field mt-3 d-md-flex justify-content-md-between">
    <h2 class="mt-3 mb-md-5">予約お申込みを承りました</h2>
    <div class="">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">
            {{ Breadcrumbs::render(Route::currentRouteName()) }}
          </li>
        </ol>
      </nav>
    </div>
  </div>
  <hr>

  <div class="notion_wrap mt-5">
    <h3 class="text-md-center mt-3 f-bold">
    予約お申込みを承りました<br>
    <p class="mt-2" style="font-size: 1.1rem;">※現段階では予約は確定しておりません。</p>
    </h3>
    <div class="notion_inner mb-5">
      <p class="mb-2">ただいま弊社での受付対応を進めております。現段階では予約は確定しておりません。<br>後ほど、弊社からお送りする「予約完了」のご連絡をもって、正式に予約が完了致しますので、メールの到着をお待ち下さい。</p>
      <p class="mb-2"><span class="txt-indent">※弊社でもすみやかな受付対応を心掛けておりますが、万が一、本メール到着の１営業日経過後も弊社からの返信がない場合は、大変お手数をおかけ致しますが弊社までご連絡下さい。</span></p>
      <p class="mb-2">
        <span class="txt-indent">
          ※お客様のメール環境によっては迷惑メールフォルダに分類される場合がございますので、<br>
          お手数をお掛け致しますが【@s-mg.co.jp】の受信できるようご設定をお願い致します。
        </span>
      </p>
    </div>
    <div class="confirm_inner">
      <p class="text-center mb-5">
        <a href="{{url('/user/pre_reservations')}}" class="more_btn_lg">仮押さえ一覧へ</a>
      </p>
      <p class="text-center">
        <a href="{{url('/user/home')}}" class="more_btn_lg">予約一覧へ</a>
      </p>
    </div>
  </div>
</div>
@endsection