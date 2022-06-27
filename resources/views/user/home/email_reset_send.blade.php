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

<div class="container-field mt-3 d-md-flex justify-content-md-between">
  <h2 class="mt-3 mb-md-5">メール送信完了</h2>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="http://staging-smg2.herokuapp.com/admin/home">ホーム</a> &gt;
          メール送信完了
        </li>
      </ol>
    </nav>
  </div>
  <hr>

<section class="mt-5">
  <div class="text-box">
  <p class="mb-3">
    ご入力頂いたメールアドレスに「変更手続きに関するメール」をお送りしました。<br>
    「変更手続きに関するメール」に記載のURLをクリックし、変更手続きを完了させて下さい。
  </p>

  <p class="mb-3"><span class="txt-indent">※1時間以内にメールが到着しない場合は、ご入力頂いたメールアドレスに誤りがある可能性がございますので、再度、正しいアドレスでお手続き下さい。</span></p>
  <p class="mb-3"><span class="txt-indent">※URLの有効期限はメール到着後～2時間となりますので、期限内にお手続きをお願い致します。</span></p>

  <p class="mb-3">
    <span class="txt-indent">
      ※お客様のメール環境によっては迷惑メールフォルダに分類される場合がございますので、<br>
      お手数をお掛け致しますが【@s-mg.co.jp】の受信できるようご設定をお願い致します。
    </span>
  </p>
  </div>
</section>


@endsection