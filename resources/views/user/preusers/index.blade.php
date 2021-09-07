@extends('layouts.reservation.app')
@section('content')

<script src="{{ asset('/js/user_reservation/validation.js') }}"></script>

<div class="contents mt-5">
  <div class="pagetop-text">
    <h1 class="page-title oddcolor"><span>会員登録</span></h1>
    <p>メールアドレスを入力してください。会員登録フォームのご案内をします。</p>
  </div>
</div>
<section class="contents">
  <form action="/user/preusers/create" method="POST" id="preuser_index">
    @csrf
    <div class="bgColorGray">
      <table>
        <tr>
          <th>メールアドレス<span class="txtRed c-block">＊</span></th>
          <td>
            <input type="email" class="form-control text1 " id="email" aria-describedby="emailHelp"
              placeholder="" name="email">
              <p class="is-error-email" style="color: red"></p>
          </td>
        </tr>
        <tr>
          <th>メールアドレス（確認）<span class="txtRed c-block">＊</span></th>
          <td>
            <input type="email2" class="form-control text1" id="email2" aria-describedby="emailHelp"
              placeholder="" name="email2">
            <p class="is-error-email2" style="color: red"></p>
          </td>
        </tr>
      </table>
    </div>
    <button type="submit" class="btn">送信する</button>
  </form>
</section>
@endsection