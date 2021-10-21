@extends('layouts.user.app')
@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>

<div class="container-fluid">
  <div class="container-field mt-3 d-md-flex justify-content-md-between">
    <h2 class="mt-3 mb-md-5">本予約 申込み　完了</h2>
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
      本予約にお申込みいただき、ありがとうございました。
    </h3>
    <div class="notion_inner">
      <p class="mb-2">
        弊社で受付が完了しましたら「予約完了連絡」をお送りします。<br>
        弊社からの予約完了連絡が到着した時点で「予約完了（予約確定）」となります。
      </p>
      <p>※フォームからの送信後、弊社からの自動返信が届かない場合は、フォームに入力していただいたメールアドレスに誤りがある可能性がございます。
        お手数ですが再度お問い合わせをいただきますようお願いいたします。</p>
      <p>※弊社からの自動返信がお客様のメール利用環境により迷惑フォルダに受信される場合がございます。
        お手数ですが迷惑フォルダもご確認いただけましたら幸いです。その場合は【@s-mg.co.jp】を受信設定していただきますようお願いいたします。</p>
    </div>
    <div class="confirm_inner">
      <p class="text-center mb-5 mt-5">
        <a href="{{url('user/home')}}" class="more_btn_lg">予約一覧へ</a>
      </p>
    </div>
  </div>
</div>
@endsection