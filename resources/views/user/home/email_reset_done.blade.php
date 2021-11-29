@extends('layouts.reservation.app')
@section('content')

<!-- ログイン、会員登録 -->
<div class="contents mt-5">
  <div class="pagetop-text">
    <h1 class="page-title oddcolor"><span>ログイン</span></h1>
  </div>
</div>
<section class="contents section-wrap">

  <div class="page-text">
    <p>
      メールアドレスの変更が完了しました。以下から再度ログインをお願いします。
    </p>
    <p class="txtCenter cell-margin"><a class="link-btn2" href="{{ url('/user/login') }}">ログインする</a></p>
  </div>

</section>
<div class="top contents"><a href="#top"><img src="https://system.osaka-conference.com/img/pagetop.png" alt="上に戻る"></a>
</div>
@endsection