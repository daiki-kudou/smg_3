@extends('layouts.reservation.app')
@section('content')

@include('layouts.user.overlay')

<script src="{{ asset('/js/user_reservation/validation.js') }}"></script>

<!-- ログイン、会員登録 -->
<div class="contents mt-5">
  <div class="pagetop-text">
    <h1 class="page-title oddcolor"><span>会員登録</span></h1>
    <p>WEB予約には会員登録が必須となります。<br>下記フォームの入力をお願いします。<span class="txtRed">＊</span>は必須です。</p>
  </div>
</div>
<section id="cartNone" class="contents">
  <style>
    .alert {
      padding: 15px;
      margin-bottom: 20px;
      border: 1px solid transparent;
      border-radius: 4px;
    }

    .alert h4 {
      margin-top: 0;
      color: inherit;
    }

    .alert .alert-link {
      font-weight: bold;
    }

    .alert>p,
    .alert>ul {
      margin-bottom: 0;
    }

    .alert>p+p {
      margin-top: 5px;
    }

    .alert-dismissable,
    .alert-dismissible {
      padding-right: 35px;
    }

    .alert-dismissable .close,
    .alert-dismissible .close {
      position: relative;
      top: -2px;
      right: -21px;
      color: inherit;
    }

    .alert-success {
      background-color: #dff0d8;
      border-color: #d6e9c6;
      color: #3c763d;
    }

    .alert-success hr {
      border-top-color: #c9e2b3;
    }

    .alert-success .alert-link {
      color: #2b542c;
    }

    .alert-info {
      background-color: #d9edf7;
      border-color: #bce8f1;
      color: #31708f;
    }

    .alert-info hr {
      border-top-color: #a6e1ec;
    }

    .alert-info .alert-link {
      color: #245269;
    }

    .alert-warning {
      background-color: #fcf8e3;
      border-color: #faebcc;
      color: #8a6d3b;
    }

    .alert-warning hr {
      border-top-color: #f7e1b5;
    }

    .alert-warning .alert-link {
      color: #66512c;
    }

    .alert-danger {
      background-color: #f2dede;
      border-color: #ebccd1;
      color: #a94442;
    }

    .alert-danger hr {
      border-top-color: #e4b9c0;
    }

    .alert-danger .alert-link {
      color: #843534;
    }

    .bg-gray {
      background: #f0f0f0f0;
    }
  </style>
  {{-- エラーメッセージ --}}
  @if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  {{ Form::open(['url' => '/user/preusers/register_check', 'method' => 'POST','id'=>'user_register','autocomplete'=>'off',]) }}
  @csrf
  <div class="bgColorGray first">
    <table>
      <tr>
        <th>会社・団体名 <span class="txtRed c-block">＊</span></th>
        <td>
          {{ Form::text('company', !empty($session['company'])?$session['company']:"", ['class' => 'text3', 'id' =>
          'company',
          'placeholder' => '入力してください']) }}
          <p><span>法人・団体ではない方は、担当者氏名を入力下さい。</span></p>
          <p class="is-error-company" style="color: red"></p>
        </td>
      </tr>
      <tr>
        <th>担当者氏名
          <span class="txtRed c-block">＊</span>
        </th>
        <td>
          <ul class="form-cell">
            <li>
              <div>
                <p>姓</p>
                {{ Form::text('first_name', !empty($session['first_name'])?$session['first_name']:"", ['class' =>
                'text1', 'id' =>
                'first_nam', 'placeholder' => '入力してください']) }}
                <br class="spOnlyunder">
                <p class="is-error-first_name" style="color: red"></p>
              </div>
            </li>
            <li>
              <div>
                <p>名</p>
                {{ Form::text('last_name', !empty($session['last_name'])?$session['last_name']:"", ['class' => 'text1',
                'id' =>
                'last_nam', 'placeholder' => '入力してください']) }}
                <br class="spOnlyunder">
                <p class="is-error-last_name" style="color: red"></p>
              </div>
            </li>
          </ul>
        </td>
      </tr>
      <tr>
        <th>担当者氏名(フリガナ) <span class="txtRed c-block">＊</span></th>
        <td>
          <ul class="form-cell">
            <li>
              <div>
                <p>セイ</p>
                {{ Form::text('first_name_kana', !empty($session['first_name_kana'])?$session['first_name_kana']:"",
                ['class' =>
                'text1', 'id' => 'firstkana_nam', 'placeholder' => '入力してください']) }}
                <br class="spOnlyunder">
                <p class="is-error-first_name_kana" style="color: red"></p>
              </div>
            </li>
            <li>
              <div>
                <p>メイ</p>
                {{ Form::text('last_name_kana', !empty($session['last_name_kana'])?$session['last_name_kana']:"",
                ['class' => 'text1',
                'id' => 'lastkana_nam', 'placeholder' => '入力してください']) }}
                <br class="spOnlyunder">
                <p class="is-error-last_name_kana" style="color: red"></p>
              </div>
            </li>
          </ul>
          <p>※全角カタカナで入力下さい。</p>
        </td>
      </tr>
      <tr>
        <th><label for="post_code">郵便番号</label><span class="txtRed c-block">＊</span></th>
        <td>
          <div class="form-cell">
              <!-- <span class="postal-p">〒</span> -->
              {{ Form::text('post_code',(!empty($session['post_code'])?$session['post_code']:"")) }}
            <button type="button" id="post_code_search">住所検索</button>
          </div>
          <p style="margin-top: 10px;">※半角数字、ハイフンなしで入力下さい。</p>
          <p class="is-error-post_code" style="color: red"></p>
        </td>
      </tr>
      <tr>
        <th>
          <label for="address1">住所1（都道府県）</label><span class="txtRed c-block">＊</span>
        </th>
        <td>
          {{ Form::text('address1', !empty($session['address1'])?$session['address1']:"", ['class' => 'text2', 'id' =>
          'address1',
          'placeholder' => '入力してください']) }}
          <p class="is-error-address1" style="color: red"></p>
        </td>
      </tr>
      <tr>
        <th><label for="address2">住所2（市町村番地）</label><span class="txtRed c-block">＊</span></th>
        <td>
          {{ Form::text('address2', !empty($session['address2'])?$session['address2']:"", ['class' => 'text3', 'id' =>
          'address2',
          'placeholder' => '入力してください']) }}
          <p class="is-error-address2" style="color: red"></p>
        </td>
      </tr>
      <tr>
        <th><label for="address3">住所3（建物名）</label></th>
        <td>
          {{ Form::text('address3', !empty($session['address3'])?$session['address3']:"", ['class' => 'text3', 'id' =>
          'address3',
          'placeholder' => '入力してください']) }}
        </td>
      </tr>
      <tr class="tr-tel-0">
        <th>連絡先 <span class="txtRed">＊</span></th>
        <td>
          <span class="txtRed">携帯電話、固定電話のどちらか一方は必須入力です</span>
          <a name="a-tel" class="error-r"></a>
        </td>
      </tr>
      <tr class="tr-tel-1">
        <th>
        </th>
        <td>
          <p class="checkbox-txt">固定電話</p>
          {{ Form::text('tel', !empty($session['tel'])?$session['tel']:"", ['class' => 'text2', 'id' => 'tel',
          'placeholder' =>
          '入力してください']) }}
          <p style="display:inline-block">10文字</p>
          <p class="is-error-tel" style="color: red"></p>
          <p>※半角数字、ハイフンなしで入力下さい。</p>
        </td>
      </tr>
      <tr class="tr-tel-2">
        <th>
        </th>
        <td>
          <p class="checkbox-txt">携帯電話</p>
          {{ Form::text('mobile', !empty($session['mobile'])?$session['mobile']:"", ['class' => 'text2', 'id' =>
          'mobile',
          'placeholder' => '入力してください']) }}
          <p style="display:inline-block">11文字</p>
          <p>※半角数字、ハイフンなしで入力下さい。</p>
          <p class="is-error-mobile" style="color: red"></p>

        </td>
      </tr>
      <tr>
        <th>FAX</th>
        <td>
          {{ Form::text('fax', !empty($session['fax'])?$session['fax']:"", ['class' => 'text2', 'id' => 'fax',
          'placeholder' =>
          '入力してください','autocomplete'=>"address-line3"]) }}
          <p class="is-error-fax" style="color: red"></p>
          <p>※半角数字、ハイフンなしで入力下さい。</p>
        </td>
      </tr>
      <tr>
        <th>メールアドレス</th>
        <td>
          {{ Form::text('email', !empty($session['email'])?$session['email']:$request->email, ['id' =>
          'email','readonly','class' => 'text2 bg-gray']) }}
        </td>
      </tr>
      <tr>
        <th>パスワード<span class="txtRed">＊</span></th>
        <td>
          {{ Form::password('password', ['class' => 'text2','autocomplete'=>"address-line3"]) }}
          <p class="is-error-password" style="color: red"></p>
          <p>※半角英数字6文字以上20文字以内にてご記入お願い致します。</p>
        </td>
      </tr>
      <tr>
        <th>パスワード確認<span class="txtRed">＊</span></th>
        <td>
          {{ Form::password('password_confirmation', ['class' => 'text2'], null) }}
          <p class="is-error-password_confirmation" style="color: red"></p>
          <p>※確認のため、もう一度パスワードを入力してください。</p>
        </td>
      </tr>
      <tr>
        <th>SMGを何で知りましたか</th>
        <td>
          <ul class="radio-box">
            <li>PC検索：
              <div>
                {{Form::radio('research','Google',!empty($session['research'])?((int)$session['research']===1?true:false):false,['id'=>'google'])}}
                {{ Form::label('google','Google') }}
                {{Form::radio('research','Yahoo',!empty($session['research'])?((int)$session['research']===2?true:false):false,['id'=>'yahoo'])}}
                {{ Form::label('yahoo','Yahoo') }}
                {{Form::radio('research','その他',!empty($session['research'])?((int)$session['research']===3?true:false):false,['id'=>'others'])}}
                {{ Form::label('others','その他') }}
              </div>
            </li>
            <li>
              {{Form::radio('research','スマホ検索',!empty($session['research'])?((int)$session['research']===4?true:false):false,['id'=>'smart_phone'])}}
              {{ Form::label('smart_phone','スマホ検索') }}
            </li>
            <li>
              {{Form::radio('research','ご紹介',!empty($session['research'])?((int)$session['research']===5?true:false):false,['id'=>'suggest'])}}
              {{ Form::label('suggest','ご紹介') }}
              {{
              Form::text('suggest_input',!empty($session['suggest_input'])?$session['suggest_input']:"",['placeholder'=>'入力してください','id'=>'intro'])
              }}
            </li>
            <li>
              {{Form::radio('research','メルマガ',!empty($session['research'])?((int)$session['research']===6?true:false):false,['id'=>'mail'])}}
              {{ Form::label('mail','メルマガ') }}
            </li>
            <li>
              {{Form::radio('research','看板・チラシ',!empty($session['research'])?((int)$session['research']===7?true:false):false,['id'=>'kanban'])}}
              {{ Form::label('kanban','看板・チラシ') }}
            </li>
            <li>
              {{Form::radio('research','その他',!empty($session['research'])?((int)$session['research']===8?true:false):false,['id'=>'oth'])}}
              {{ Form::label('oth','その他') }}
              {{
              Form::text('oth_input',!empty($session['oth_input'])?$session['oth_input']:"",['placeholder'=>'入力してください','id'=>'other'])
              }}
            </li>
          </ul>
        </td>
      </tr>
    </table>
  </div>
  <dl class="attention-txt">
    <dt>【個人情報の取り扱いについて】</dt>
    <dd>当フォームにご入力いただく内容は、弊社が責任を持って保管し、その他の目的に使用いたしません。また、許可なく第三者に提供することはございません。個人情報の取り扱いに関しては、<a target="_blank" rel="noopener noreferrer"
        href="https://system.osaka-conference.com/privacypolicy/">プライバシーポリシー</a>をご確認下さい。</dd>
  </dl>

  <div class="page-text">
    <p class="checkbox-txt ">
      {{ Form::checkbox('q1', '1', false, ['id' => 'last_checkbox']) }}
      {{ Form::label('last_checkbox', '【個人情報の取り扱いについて】に同意します。') }}
    <p class="is-error-q1" style="color: red"></p>

    </p>
  </div>

  <div class="btn-wrapper2">
    <p>
      <button type="submit" name="action" block="false">確認画面へ</button>
    </p>
  </div>
  {{ Form::hidden('id', $request->id) }}
  {{ Form::hidden('token', $request->token) }}
  {{ Form::hidden('status', $request->status) }}
  {{ Form::close() }}

  <script>
    $('#post_code_search').on('click', function(){
    AjaxZip3.zip2addr('post_code','','address1','address2');
    
    //成功時に実行する処理
    AjaxZip3.onSuccess = function() {
      $('input[name="address1"]').click();
      $('input[name="address2"]').click();
    };
    
    //失敗時に実行する処理
    AjaxZip3.onFailure = function() {
    $('input[name="address1"]').val('');
    $('input[name="address2"]').val('');
    alert('郵便番号に該当する住所が見つかりません');
    };
    
    return false;
    });
  </script>

</section>
@endsection