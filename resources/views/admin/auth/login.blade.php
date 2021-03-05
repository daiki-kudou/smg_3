@extends('layouts.admin.auth')

@section('content')
<style>
  h3 {
    font-size: 24px;
    font-weight: bold;
    color: #555;
    margin-bottom: 0px;
    line-height: 48px;
    margin-left: 25px;
  }
</style>
<div class="container" style="margin-top: 10%;">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          {{-- <h3>管理者管理画面</h3>ログイン --}}
          <div class="d-flex justify-content-center">
            <img src="https://osaka-conference.com/img/logo.jpg" alt="" width="40" height="40">
            <h3>SMGアクセア貸し会議室 </h3>
          </div>
        </div>

        <div class="card-body">
          <form method="POST" action="{{ route('admin.login') }}">
            @csrf

            <div class="form-group row">
              <label for="email" class="col-md-4 col-form-label text-md-right">メールアドレス</label>

              <div class="col-md-6">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                  value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label for="password" class="col-md-4 col-form-label text-md-right">パスワード</label>

              <div class="col-md-6">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                  name="password" required autocomplete="current-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <div class="col-md-6 offset-md-4">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="remember" id="remember"
                    {{ old('remember') ? 'checked' : '' }}>

                  <label class="form-check-label" for="remember">
                    情報を保持する
                  </label>
                </div>
              </div>
            </div>

            <div class="form-group row mb-0">
              <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                  {{ __('Login') }}
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection