

@extends('layouts.user.app')
@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">

@if ($errors->any())
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

<div class="container-field mt-3">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="http://staging-smg2.herokuapp.com/admin/home">ホーム</a> &gt;
          メールアドレス送信完了
        </li>
      </ol>
    </nav>
  </div>
  <h2 class="mt-3 mb-3">メールアドレス送信完了</h2>
  <hr>
</div>

<section class="mt-5">
  <div class="text-box">
    <p>メールを送信したので、確認してください。<br>
      1時間以内に受信されてこない場合は、メールアドレスのお間違えの可能性がございますので、ご確認ください。</p>
    <p>会員登録メールに会員登録のためのURLが記載されております。
      こちらのURLの有効期限は2時間となりますので、ご注意お願い致します。</p>
    <p>※弊社からの自動返信がお客様のメール利用環境により迷惑フォルダに受信される場合がございます。
      お手数ですが迷惑フォルダもご確認いただけましたら幸いです。<br>その場合は【@s-mg.co.jp】を
      受信設定していただきますようお願いいたします。</p>
  </div>
</section>


@endsection