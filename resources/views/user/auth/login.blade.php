@extends('layouts.reservation.app')
@section('content')
<script src="{{ asset('/js/user/auth/login_validation.js') }}"></script>
@include('layouts.user.overlay')


<!-- ログイン、会員登録 -->
@if (session('flash_message'))
<div class="contents mt-5">
  <div class="pagetop-text">
    <h1 class="page-title oddcolor"><span>会員登録完了</span></h1>
  </div>
  <div class="text-box">
    <p class="txtCenter">会員登録が完了しました。<br>下記より、ログインしてください。</p>
  </div>
</div>
@else
<div class="contents mt-5" id="cartNone">
  <div class="pagetop-text">
    <h1 class="page-title oddcolor"><span>ログイン/会員登録</span></h1>
  </div>
</div>
@endif

<section class="contents">
  <form method="POST" action="{{ route('user.login') }}" id="loginForm">
    @csrf
    <div class="bgColorGray">
      <table>
        <tr>
          <th>
            <label for="email" class="col-md-4 col-form-label text-md-right">メールアドレス</label>
          </th>
          <td class="col-md-6">
            {{ Form::text('email', old('email'),['class'=>'form-control text2','autocomplete'=>'email']) }}
            <p class="is-error-email" style="color: red"></p>
            @error('email')
            <div class="alert text-left">{{ $message }}</div>
            @enderror
            {{-- <input id="email" type="email" class="form-control text2 @error('email') is-invalid @enderror"
              name="email" value="{{ old('email') }}" required autocomplete="email" autofocus> --}}
            {{-- @error('email')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror --}}
          </td>
        </tr>
        <tr>
          <th>
            <label for="password" class="col-md-4 col-form-label text-md-right">パスワード</label>
          </th>
          <td class="col-md-6">
            {{ Form::password('password',['class'=>'form-control text2','autocomplete'=>'current-password']) }}
            <p class="is-error-password" style="color: red"></p>
            {{-- <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
              name="password" required autocomplete="current-password"> --}}

            {{-- @error('password')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror --}}
          </td>
        </tr>

        <tr>
          <td></td>
          <td>
            <div>
              <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember')
                ? 'checked' : '' }}>

              <label class="form-check-label" for="remember">
                ログイン状態を保持する
              </label>
              <p><a href="{{url('user/password/reset')}}" target="_blank">パスワードをお忘れの方はこちら</a></p>
            </div>
          </td>
        </tr>
      </table>
    </div>
    <div class="btn-wrapper2">
      <button type="submit" class="btn">
        ログインする
      </button>
    </div>
  </form>

  <div class="borderBox page-text">
    <p>WEBからの予約をご希望の場合は、会員登録が必要になります。<br>
      お手数ですが、会員登録のお手続きをよろしくお願い致します。</p>
    <div class="btn-wrapper2">
      <a href="{{url('user/preusers')}}">
        <p class="link-btn">
          会員登録をする
        </p>
      </a>
    </div>
  </div>
</section>



@endsection