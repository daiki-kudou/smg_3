@extends('layouts.reservation.app')
@section('content')

      <!-- ログイン、会員登録 -->
      <div class="contents mt-5">
        <div class="pagetop-text">
          <h1 class="page-title oddcolor"><span>ユーザIDの確認・パスワードの再設定 </span></h1>
          <p>新しいパスワードを設定してください</p>
        </div>
      </div>
      <section class="contents">
        <form method="POST" action="{{ route('user.password.update') }}">
          @csrf

          <input type="hidden" name="token" value="{{ $token }}">
          <div class="bgColorGray">
            <table>
              <tr>
                <th>
                  <label for="email">
                    メールアドレス
                  </label>
                </th>
                <td>
                    <input id="email" type="email" class="text1 @error('email') is-invalid @enderror" name="email"
                      value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </td>
              </tr>
              <tr>
                  <th>
                    <label for="password">
                      パスワード
                    </label>
                  </th>
                  <td>
                      <input id="password" type="password" class="text-1 @error('password') is-invalid @enderror"
                        name="password" required autocomplete="new-password">
                      @error('password')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                  </td>
              </tr>

              <tr>
                  <th>
                    <label for="password-confirm">
                      パスワード（確認用）
                    </label>
                  </th>
                  <td>
                      <input id="password-confirm" type="password" class="text-1" name="password_confirmation" required
                        autocomplete="new-password">
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

        </form>
      </section>
    @endsection