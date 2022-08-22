@extends('layouts.reservation.app')
@section('content')
    <!-- ログイン、会員登録 -->
    <div class="contents mt-5">
        <div class="pagetop-text">
            <h1 class="page-title oddcolor"><span>パスワードの再設定 </span></h1>
        </div>
    </div>

    <section class="contents" id="cartNone">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @elseif($errors->get('email'))
            @foreach ($errors->all() as $error)
                <p class="txtCenter"> {{ $error }}
                <p>
            @endforeach
        @else
            <p class="txtCenter">メールアドレスを入力してください。パスワード再設定用のリンクを送信いたします</p>
        @endif
        <form method="POST" action="{{ route('user.password.email') }}">
            @csrf
            <div class="bgColorGray">
                <table>
                    <tr>
                        <th>メールアドレス<span class="txtRed c-block">＊</span></th>
                        <td>
                            <input id="email" type="email" class="text1 form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        </td>
                    </tr>
                </table>
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        送信する
                    </button>
                </div>
            </div>
        </form>
    </section>
@endsection
