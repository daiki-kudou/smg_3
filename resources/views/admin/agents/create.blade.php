@extends('layouts.admin.app')

@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
<script>
  $(function() {
    $('.search_address1').on('change', function() {
      // console.log($('.search_address1').parent().next().find('input'));
      var post_code = $('.search_address1').val();
      var adr1 = $('.search_address2').val();
      var adr2 = $('.search_address3').val();
      $('.search_address1').parent().next().find('input').val(post_code);
      $('.search_address2').parent().next().find('input').val(adr1);
      $('.search_address3').parent().next().find('input').val(adr2);
    })
    $('.search_address2').on('change', function() {
      var adr1 = $('.search_address2').val();
      $('.search_address2').parent().next().find('input').val(adr1);
    })
    $('.search_address3').on('change', function() {
      var adr2 = $('.search_address3').val();
      $('.search_address3').parent().next().find('input').val(adr2);
    })
  })
</script>
<style>
  .error {
    color: red;
  }

  .table th {
    width: 30%;
  }
</style>
<div class="container-field">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">ダミーダミーダミー</li>
      </ol>
    </nav>
  </div>

  <h2 class="mt-3 mb-3">仲介会社　新規登録</h2>
  <hr>

  @if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif
  {{ Form::open(['url' => 'admin/agents', 'method'=>'POST', 'id'=>'agents_create_form']) }}
  @csrf

  <section class="section-wrap">
    <div class="row">
      <!-- 左側の項目 ---------------------------------------------------------->
      <div class="col">
        {{ Form::open(['route' => 'admin.clients.store']) }}
        <table class="table table-bordered table_fixed">
          <thead>
            <tr>
              <td colspan="3">
                <p class="title-icon">
                  <i class="fas fa-exclamation-circle icon-size fa-fw"></i>基本情報
                </p>
              </td>
            </tr>
          </thead>
          <tbody>
            <!-- 工藤さんに確認　増やした項目 -->
            <tr>
              <td class="table-active">{{ Form::label('name', 'サービス名称') }}</td>
              <td colspan="2">{{ Form::text('name', old('name'), ['class' => 'form-control', 'id'=>'name']) }}</td>
            </tr>
            <!-- 工藤さんに確認　増やした項目 -->
            <tr>
              <td class="table-active">{{ Form::label('company', '運営会社名') }}</td>
              <td colspan="2">{{ Form::text('company', old('company'), ['class' => 'form-control', 'id'=>'company']) }}</td>
            </tr>
            <!-- 工藤さんに確認　顧客情報の郵便番号の箇所を引っ張ってきた -->
            <tr>
              <td class="table-active">{{ Form::label('post_code', '郵便番号') }}</td>
              <td colspan="2">{{ Form::text('post_code', old('post_code'), [
                                'class' => 'form-control',
                                'onKeyUp'=>"AjaxZip3.zip2addr(this,'','address1','address2');",
                                'autocomplete'=>'off',
                                ]) }}
              </td>
            </tr>
            <tr>
              <td class="table-active">{{ Form::label('address1', '住所1（都道府県）') }}</td>
              <td colspan="2">{{ Form::text('address1', old('address1'), ['class' => 'form-control']) }}</td>
            </tr>
            <tr>
              <td class="table-active">{{ Form::label('address2', '住所2（市町村番地）') }}</td>
              <td colspan="2">{{ Form::text('address2', old('address2'), ['class' => 'form-control']) }}</td>
            </tr>
            <tr>
              <td class="table-active">{{ Form::label('address3', '住所3（建物名）') }}</td>
              <td colspan="2">{{ Form::text('address3', old('address3'), ['class' => 'form-control']) }}</td>
            </tr>
            <!-- 工藤さんに確認　顧客情報の郵便番号の箇所を引っ張ってきた -->
            <tr>
              <td class="table-active">{{ Form::label('tel', '電話番号') }}</td>
              <td colspan="2">{{ Form::text('tel', old('tel'), ['class' => 'form-control']) }}
              </td>
            </tr>
            <tr>
              <td class="table-active">{{ Form::label('fax', 'FAX') }}</td>
              <td colspan="2">{{ Form::text('fax', old('fax'), ['class' => 'form-control']) }}</td>
            </tr>
            <tr>
              <td class="table-active">{{ Form::label('person_firstname', '担当者氏名') }}</td>
              <td>姓：{{ Form::text('person_lastname', old('person_lastname'), ['class' => 'form-control']) }}</td>
              <td>名：{{ Form::text('person_firstname', old('person_firstname'), ['class' => 'form-control']) }}</td>
            </tr>
            <tr>
              <td class="table-active">{{ Form::label('firstname_kana', '担当者氏名（フリガナ）') }}</td>
              <td>
              セイ：{{ Form::text('lastname_kana', old('lastname_kana'), ['class' => 'form-control']) }}
              </td>
              <td>
              メイ：{{ Form::text('firstname_kana', old('firstname_kana'), ['class' => 'form-control'])}}
              </td>
            </tr>
            <tr>
              <th class="table-active">{{ Form::label('person_tel', '担当者TEL') }}</th>
              <td colspan="2">{{ Form::text('person_tel', old('person_tel'), ['class' => 'form-control']) }}</td>
            </tr>
            <tr>
              <th class="table-active">{{ Form::label('email', '担当者メールアドレス') }}</th>
              <td colspan="2">{{ Form::text('email', old('email'), ['class' => 'form-control']) }}</td>
            </tr>
            <tr>
              <th class="table-active">{{ Form::label('remark', '備考') }}</th>
              <td colspan="2">{{ Form::textarea('remark', old('remark'), ['class' => 'form-control']) }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- 左側の項目 終わり ---------------------------------------------------------->

      <!-- 右側の項目 ---------------------------------------------------------->
      <div class="col">
        <table class="table table-bordered table_fixed">
          <thead>
            <tr>
              <p class="title-icon">
                <td colspan="3"><i class="fas fa-window-restore fa-fw icon-size"></i>サイト情報
              </p>
              </td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="table-active">{{ Form::label('service_name', 'サービス名称') }}</td>
              <td colspan="2">{{ Form::text('service_name', old('service_name'), ['class' => 'form-control', 'id'=>'service_name']) }}</td>
            </tr>
            <tr>
              <td class="table-active">{{ Form::label('url', 'サービスURL') }}</td>
              <td colspan="2">{{ Form::text('url', old('url'), ['class' => 'form-control', 'id'=>'url']) }}</td>
            </tr>
            <tr>
              <td class="table-active">{{ Form::label('login_url', 'ログインURL') }}</td>
              <td colspan="2">{{ Form::text('login_url', old('login_url'), ['class' => 'form-control', 'id'=>'login_url']) }}</td>
            </tr>
            <tr>
              <td class="table-active">{{ Form::label('login_id', 'ID') }}</td>
              <td colspan="2">{{ Form::text('login_id', old('login_id'), ['placeholder' => '半角英数字で入力してください','class' => 'form-control']) }}
              </td>
            </tr>
            <tr>
              <td class="table-active">{{ Form::label('password', 'パスワード') }}</td>
              <td colspan="2">
                {{ Form::text('password', old('password'), ['placeholder' => '半角英数字で入力してください','class' => 'form-control']) }}
              </td>
            </tr>
            <tr>
              <th class="table-active">{{ Form::label('alliance_remark', '提携会場備考') }}</th>
              <td colspan="2">{{ Form::textarea('alliance_remark', old('alliance_remark'), ['class' => 'form-control']) }}</td>
            </tr>
            <tr>
              <th class="table-active">{{ Form::label('site_remark', '備考') }}</th>
              <td colspan="2">{{ Form::textarea('site_remark', old('site_remark'), ['class' => 'form-control']) }}</td>
            </tr>
          </tbody>
        </table>

        <!-- 取引条件 ------------------------------------------------------------>
        <table class="table table-bordered">
          <thead>
            <tr>
              <td colspan="3">
                <p class="title-icon">
                  <i class="fas fa-yen-sign icon-size"></i>取引条件
                </p>
              </td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th class="table-active">{{ Form::label('cost', '仲介手数料') }}</th>
              <td class="d-flex align-items-center">{{ Form::number('cost', old('cost'), ['class' => 'form-control']) }}<span class="ml-1">%</span></td>
            </tr>
            <tr>
              <th class="table-active">{{ Form::label('deal_details', '取引詳細') }}</th>
              <td>{{ Form::textarea('deal_details', old('deal_details'), ['class' => 'form-control']) }}</td>
            </tr>
            <tr>
              <td class="table-active">{{ Form::label('cancel', 'キャンセルポリシー') }}</td>
              <td>
                <p>{{ Form::radio('cancel', old('cancel'), ['class' => 'form-control, mr-1']) }}{{ Form::label('cancel', 'SMGルール') }}</p>
                <p>{{ Form::radio('cancel', old('cancel'), ['class' => 'form-control, mr-1']) }}{{ Form::label('cancel', '仲介会社ルール') }}</p>
                <p class="mt-2">{{ Form::label('cancel', 'キャンセルポリシーURL') }}{{ Form::text('cancel', old('cancel'), ['class' => 'form-control']) }}</p>
              </td>
            </tr>
            <tr>
              <th class="table-active">{{ Form::label('deal_remark', '備考') }}</th>
              <td>{{ Form::textarea('deal_remark', old('deal_remark'), ['class' => 'form-control']) }}</td>
            </tr>
          </tbody>
        </table>

        <!-- 決済条件 ------------------------------------------------------------>
        <table class="table table-bordered">
          <thead>
            <tr>
              <td colspan="2">
                <p class="title-icon">
                  <i class="fas fa-yen-sign icon-size"></i>決済条件
                </p>
              </td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th class="table-active">{{ Form::label('close_date', '〆日') }}</th>
              <td>{{Form::select('close_date', [1=>'月末', 2=>'月初',3=>'', 4=>'', 5=>''])}}</td>
            </tr>
            <tr>
              <th class="table-active">{{ Form::label('payment_day', '支払日') }}</th>
              <td>{{ Form::text('payment_day', '' ,['class'=>'form-control', 'id'=>'datepicker1', 'placeholder'=>'入力してください'] ) }}</td>
            </tr>
            <tr>
              <th class="table-active">{{ Form::label('pay_remark', '備考') }}</th>
              <td>{{ Form::textarea('pay_remark', old('pay_remark'), ['class' => 'form-control']) }}</td>
            </tr>
          </tbody>
        </table>



      </div>
      <!-- 右側の項目 終わり ---------------------------------------------------------->

    </div>

    {{ Form::submit('登録する', ['class' => 'btn more_btn_lg d-block btn-lg mx-auto my-5']) }}
    {{ Form::close() }}

  </section>

  <!-- オリジナル ------------------------------------------------------>
  <!-- <div class="row">
    <div class="col-sm">
      <table class="table">
        <thead>
          <tr>
            <th scope="col"><i class="fas fa-exclamation-circle fa-fw"></i></i>基本情報</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">{{ Form::label('name', '会社・団体名') }}</th>
            <td>{{ Form::text('name', old('name'), ['class' => 'form-control', 'id'=>'name']) }}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('post_code', '郵便番号') }}</th>
            <td><input class="search_address1 form-control" type="text" name="zip01" maxlength="8"
                onKeyUp="AjaxZip3.zip2addr(this,'','pref01','addr01');"></td>
            <td class="">{{ Form::hidden('post_code', old('post_code'), ['class' => 'form-control']) }}
            </td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('address1', '住所1（都道府県）') }}</th>
            <td><input class="search_address2 form-control" type="text" name="pref01"></td>
            <td>{{ Form::hidden('address1', old('address1'), ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('address2', '住所2（市町村番地）') }}</th>
            <td><input class="search_address3 form-control" type="text" name="addr01"></td>
            <td>{{ Form::hidden('address2', old('address2'), ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('address3', '住所3（建物名）') }}</th>
            <td>{{ Form::text('address3', old('address3'), ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('address_remark', '住所備考') }}</th>
            <td>{{ Form::textarea('address_remark', old('address_remark'), ['class' => 'form-control'])}}
            </td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('url', '会社・団体名URL') }}</th>
            <td>{{ Form::text('url', old('url'), ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('attr', '顧客属性') }}</th>
            <td>{{Form::select('attr', ['ネットワーク'=>'ネットワーカー', '個人事業主'=>'個人事業主','宗教団体'=>'宗教団体'])}}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('remark', '備考') }}</th>
            <td>{{ Form::textarea('remark', old('remark'), ['class' => 'form-control']) }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="col-sm">
      <table class="table">
        <thead>
          <tr>
            <th scope="col"><i class="fas fa-user fa-fw"></i>担当者情報</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">{{ Form::label('person_firstname', '担当者氏名') }}</th>
            <td>
              姓{{ Form::text('person_firstname', old('person_firstname'), ['class' => 'form-control']) }}
            </td>
            <td>
              名{{ Form::text('person_lastname', old('person_lastname'), ['class' => 'form-control']) }}
            </td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('firstname_kana', '担当者氏名（ふりがな）') }}</th>
            <td>セイ{{ Form::text('firstname_kana', old('firstname_kana'), ['class' => 'form-control']) }}
            </td>
            <td>メイ{{ Form::text('lastname_kana', old('lastname_kana'), ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('firstname_kana', '携帯電話') }}</th>
            <td>{{ Form::text('person_mobile', old('person_mobile'), ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('person_tel', '固定電話') }}</th>
            <td>{{ Form::text('person_tel', old('person_tel'), ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('fax', 'FAX') }}</th>
            <td>{{ Form::text('fax', old('fax'), ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('email', '担当者メールアドレス') }}</th>
            <td>{{ Form::text('email', old('email'), ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <th scope="row"><i class="fas fa-user fa-fw"></i>支払いデータ</th>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('cost', '支払割合（原価）') }}</th>
            <td>{{ Form::number('cost', old('cost'), ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('payment_limit', '締日') }}</th>
            <td>
              <select name="payment_limit" id="payment_limit">
                <option value="1">当月末</option>
                <option value="2">翌月末</option>
                <option value="3">翌々月末</option>
              </select>
            </td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('payment_day', '支払日') }}</th>
            <td>{{ Form::number('payment_day', old('payment_day'), ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('payment_remark', '備考') }}</th>
            <td>{{ Form::number('payment_remark', old('payment_remark'), ['class' => 'form-control']) }}</td>
          </tr>

        </tbody>
      </table>
    </div>
  </div>
  <div class="container">
    <div class="mx-auto" style="width: 200px;">
      {{ Form::submit('登録', ['class' => 'btn btn-primary']) }}
      {{ Form::close() }}
    </div>
  </div> -->



</div>
@endsection