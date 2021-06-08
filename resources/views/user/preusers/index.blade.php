@extends('layouts.reservation.app')
@section('content')

<div class="contents mt-5">
  <div class="pagetop-text">
    <h1 class="page-title oddcolor"><span>会員登録</span></h1>
    <p>メールアドレスを入力してください。会員登録フォームのご案内をします。</p>
  </div>
</div>
<section class="contents">
  <form action="/user/preusers/create" method="POST">
    @csrf
    <div class="bgColorGray">
      <table>
        <tr>
          <th>メールアドレス<span class="txtRed c-block">＊</span></th>
          <td>
            <input type="email" class="form-control text1 " id="email" aria-describedby="emailHelp"
              placeholder="sample@sample.com" name="email">
            <a name="a-mail01" class="error-r"></a>
          </td>
        </tr>
        <tr>
          <th>メールアドレス（確認）<span class="txtRed c-block">＊</span></th>
          <td>
            <input type="email2" class="form-control text1" id="email2" aria-describedby="emailHelp"
              placeholder="sample@sample.com" name="email2">
            <a name="a-mail02" class="error-r"></a>
          </td>
        </tr>
      </table>
    </div>
    <button type="submit" class="btn">送信する</button>
  </form>
</section>
@endsection