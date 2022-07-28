@extends('layouts.reservation.app')
@section('content')
@include('layouts.user.overlay')
<script src="{{ asset('/js/user/auth/password_update.js') }}"></script>

<!-- ログイン、会員登録 -->
<div class="contents mt-5">
  <div class="pagetop-text">
    <h1 class="page-title oddcolor"><span>パスワードの再設定</span></h1>
    <p>新しいパスワードを設定してください</p>
  </div>
</div>
<section class="contents">
  <form method="POST" action="{{ route('user.password.update') }}" id="password_reset_form">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <div class="bgColorGray">
      <table>
        {{-- <tr>
          <th>
            <label for="email">
              メールアドレス
            </label>
          </th>
          <td>
			<input type="hidden" name="email" value="{{ $email }}">
          </td>
        </tr> --}}
        <tr>
          <th>
            <label for="password">
              新しいパスワード
            </label>
          </th>
          <td>
            {{Form::password('password', ['class' => 'text-1 form-control','id' => 'inputPassword'])}}
            <p class="is-error-password" style="color: red"></p>
            <p class="f-s90 m-t10">※半角英数字6文字以上20文字以内にてご記入お願い致します。</p>
          </td>
        </tr>

        <tr>
          <th>
            <label for="password-confirm">
              新しいパスワード<br>（確認用）
            </label>
          </th>
          <td>
            {{Form::password('password_confirmation', ['class' => 'text-1 form-control','id' => 'password-confirm'])}}
            <p class="is-error-password_confirmation" style="color: red"></p>
          </td>
        </tr>
      </table>
    </div>
    <div class="form-group row mb-0">
      <div class="col-md-6 offset-md-4">
        <button type="submit" class="">
          パスワード再設定
        </button>
      </div>
    </div>
	
	<input type="hidden" name="email" value="{{ $email }}">

  </form>
</section>
@endsection