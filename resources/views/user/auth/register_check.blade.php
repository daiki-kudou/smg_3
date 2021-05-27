@extends('layouts.reservation.app')
@section('content')

<!-- ログイン、会員登録 -->
<div class="contents">
  <div class="pagetop-text">
    <h1 class="page-title oddcolor"><span>会員登録 確認</span></h1>
    <p>入力内容をご確認ください。</p>
  </div>
</div>
<section class="contents">
  {{ Form::open(['route' => 'user.preusers.store', 'method'=>'POST']) }}
  <div class="bgColorGray first">
    <table class="table-box">
      <tr>
        <th>会社・団体名</th>
        <td>
          {{$request->company}}
        </td>
      </tr>
      <tr>
        <th>担当者氏名</th>
        <td>
          {{$request->first_name}} {{$request->last_name}}
        </td>
      </tr>
      <tr>
        <th>担当者氏名(フリガナ)</th>
        <td>
          {{$request->first_name_kana}} {{$request->last_name_kana}}
        </td>
      </tr>
      <tr>
        <th><label for="post_code">郵便番号</label></th>
        <td>
          <p class="postal-p">〒</p>
          {{$request->post_code}}
        </td>
      </tr>
      <tr>
        <th><label for="address1">住所1（都道府県）</label></th>
        <td>
          {{$request->address1}}
        </td>
      </tr>
      <tr>
        <th><label for="address2">住所2（市町村番地）</label></th>
        <td>
          {{$request->address2}}
        </td>
      </tr>
      <tr>
        <th><label for="address3">住所3（建物名）</label></th>
        <td>
          {{$request->address3}}
        </td>
      </tr>
      <tr class="tr-tel-1">
        <th>
          連絡先
        </th>
        <td>
          <p class="checkbox-txt">携帯電話</p>
          <p>
            {{$request->tel}}
          </p>
        </td>
      </tr>
      <tr class="tr-tel-2">
        <th>
        </th>
        <td>
          <p class="checkbox-txt">固定電話</p>
          <p>
            {{$request->mobile}}
          </p>
        </td>
      </tr>
      <tr>
        <th>FAX</th>
        <td>
          <p>
            {{$request->fax}}
          </p>
        </td>
      </tr>
      <tr>
        <th>メールアドレス</th>
        <td>
          {{$request->email}}
        </td>
      </tr>
      {{-- <tr>
                <th>パスワード</th>
                <td>
                  ●●●●●●●●●●●●●●
                </td>
              </tr> --}}
      <tr>
        <th>SMGを何で知りましたか</th>
        <td>
          <ul class="radio-box">
            <li>
              {{$request->research}}
            </li>

          </ul>
        </td>
      </tr>
    </table>
  </div>
  <div class="borderBox page-text">
    <p>プライバシーポリシー、利用規約に合意しました。</p>
  </div>

  <ul class="btn-wrapper">
    <li>
      <p class="link-btn">
        {{ Form::submit('戻る', ['name'=>'back']) }}
        {{-- <a href="">戻る</a> --}}
      </p>
    </li>
    <li>
      <p>
        {{ Form::submit('登録する', ['name'=>'register','class' => 'btn confirm-btn']) }}
      </p>
    </li>
  </ul>
  {{ Form::hidden('company', $request->company) }}
  {{ Form::hidden('first_name', $request->first_name) }}
  {{ Form::hidden('last_name', $request->last_name) }}
  {{ Form::hidden('first_name_kana', $request->first_name_kana) }}
  {{ Form::hidden('last_name_kana', $request->last_name_kana) }}
  {{ Form::hidden('post_code', $request->post_code) }}
  {{ Form::hidden('address1', $request->address1) }}
  {{ Form::hidden('address2', $request->address2) }}
  {{ Form::hidden('address3', $request->address3) }}
  {{ Form::hidden('tel', $request->tel) }}
  {{ Form::hidden('mobile', $request->mobile) }}
  {{ Form::hidden('fax', $request->fax) }}
  {{ Form::hidden('email', $request->email) }}
  {{ Form::hidden('research', $request->research) }}
  {{ Form::hidden('password', $request->password) }}

  {{ Form::hidden('id', $request->id) }}
  {{ Form::hidden('token', $request->token) }}
  {{ Form::hidden('email', $request->email) }}
  {{ Form::hidden('status', $request->status) }}


  {{ Form::close() }}




</section>
@endsection