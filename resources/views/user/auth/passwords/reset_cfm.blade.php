@extends('layouts.reservation.app')
@section('content')
<!-- ログイン、会員登録 -->
<div class="contents mt-5">
  <div class="pagetop-text">
    <h1 class="page-title oddcolor"><span>パスワードの再設定 </span></h1>
  </div>
</div>

<section class="contents">
  <div class="section-wrap">
    <p class="txtCenter">パスワードの変更が完了しました</p>
    <p class="txtCenter"><a class="link-btn3" href="{{ url('/user/home') }}">新しいパスワードでログイン</a></p>
  </div>
</section>
@endsection