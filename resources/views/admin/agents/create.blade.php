@extends('layouts.admin.app')

@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/admin/reservation.js') }}"></script>
<script src="{{ asset('/js/admin/agents/validation.js') }}"></script>
<script src="{{ asset('/js/ctrl_form.js') }}"></script>


<style>
  .error {
    color: red;
  }

  .table th {
    width: 30%;
  }

  .hide {
    display: none !important;
  }
</style>

<div class="content">
  <div class="container-field">
    @include('layouts.admin.breadcrumbs')

    <h2 class="mt-3 mb-3">仲介会社　新規登録</h2>
    <hr>

    {{ Form::open(['url' => '/admin/agents', 'method'=>'POST', 'id'=>'agentCreateForm','autocomplete'=>'off']) }}
    @csrf
    <section class="mt-5">
      <div class="row">
        <!-- 左側の項目 ---------------------------------------------------------->
        <div class="col">
          <table class="table table-bordered table_fixed">
            <thead>
              <tr>
                <td colspan="3">
                  <p class="title-icon">
                    <i class="fas fa-exclamation-circle icon-size" aria-hidden="true"></i>基本情報
                  </p>
                </td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="table-active form_required">
                  <label for="name">サービス名称</label>
                </td>
                <td colspan="2">
                  {{ Form::text('name', old('name'), ['class' => 'form-control', 'id'=>'name']) }}
                  <small>※仲介会社を選択するプルダウンリストに表示されます。</small>
                  <p class="is-error-name" style="color: red"></p>
                </td>
              </tr>
              <tr>
                <td class="table-active"><label for="company">運営会社名</label></td>
                <td colspan="2">
                  {{ Form::text('company', old('company'), ['class' => 'form-control', 'id'=>'company']) }}
                </td>
              </tr>
              <tr>
                <td class="table-active"><label for="post_code">郵便番号</label></td>
                <td colspan="2">

                  <div class="d-flex">
                    <p>{{ Form::text('post_code',"",['class'=>'search_address1 form-control']) }}</p>
                    <button class="btn more_btn ml-1" type="button" id="post_code_search">住所検索</button>
                  </div>

                  <p class="is-error-post_code" style="color: red"></p>
                </td>
              </tr>
              <tr>
                <td class="table-active"><label for="address1">住所1（都道府県）</label></td>
                <td colspan="2">
                  {{ Form::text('address1', old('address1'), ['class' => 'form-control ']) }}
              </tr>
              <tr>
                <td class="table-active"><label for="address2">住所2（市町村番地）</label></td>
                <td colspan="2">
                  {{ Form::text('address2', old('address2'), ['class' => 'form-control addr01']) }}
                </td>
              </tr>
              <tr>
                <td class="table-active"><label for="address3">住所3（建物名）</label></td>
                <td colspan="2">
                  {{ Form::text('address3', old('address3'), ['class' => 'form-control']) }}
                </td>
              </tr>
              <tr>
                <td class="table-active"><label for="tel">電話番号</label></td>
                <td colspan="2">
                  {{ Form::text('person_tel', old('person_tel'), ['class' => 'form-control','placeholder' =>
                  '半角数字、ハイフンなしで入力してください']) }}
                  <p class="is-error-person_tel" style="color: red"></p>
                  <p class="annotation mt-1">※半角数字、ハイフンなしで入力下さい。</p>
                </td>
              </tr>
              <tr>
                <td class="table-active"><label for="fax">FAX</label></td>
                <td colspan="2">
                  {{ Form::text('fax', old('fax'), ['class' => 'form-control','placeholder' => '半角数字、ハイフンなしで入力してください'])
                  }}
                  <p class="is-error-fax" style="color: red"></p>
                </td>
              </tr>
              <tr>
                <td class="table-active form_required"><label for="person_firstname">担当者氏名</label></td>
                <td>姓：
                  {{ Form::text('person_firstname', old('person_firstname'), ['class' => 'form-control']) }}
                  <p class="is-error-person_firstname" style="color: red"></p>
                </td>
                <td>名：
                  {{ Form::text('person_lastname', old('person_lastname'), ['class' => 'form-control']) }}
                  <p class="is-error-person_lastname" style="color: red"></p>
                </td>
              </tr>
              <tr>
                <td class="table-active"><label for="firstname_kana">担当者氏名（フリガナ）</label></td>
                <td>
                  セイ：
                  {{ Form::text('firstname_kana', old('firstname_kana'), ['class' => 'form-control']) }}
                  <p class="is-error-firstname_kana" style="color: red"></p>
                </td>
                <td>
                  メイ：
                  {{ Form::text('lastname_kana', old('lastname_kana'), ['class' => 'form-control']) }}
                  <p class="is-error-lastname_kana" style="color: red"></p>
                </td>
              </tr>
              <tr>
                <th class="table-active"><label for="person_mobile">担当者TEL</label></th>
                <td colspan="2">
                  {{ Form::text('person_mobile', old('person_mobile'), ['class' => 'form-control','placeholder' =>
                  '半角数字、ハイフンなしで入力してください']) }}
                  <p class="is-error-person_mobile" style="color: red"></p>
                  <p class="annotation mt-1">※半角数字、ハイフンなしで入力下さい。</p>
                </td>
              </tr>
              <tr>
                <th class="table-active"><label for="email">担当者メールアドレス</label></th>
                <td colspan="2">
                  {{ Form::text('email', old('email'), ['class' => 'form-control']) }}
                  <p class="is-error-email" style="color: red"></p>
                </td>
              </tr>
              <tr>
                <th class="table-active">
                  <label for="remark">備考</label>
                </th>
                <td colspan="2">
                  {{ Form::textarea('last_remark', old('last_remark'), ['class' => 'form-control']) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- 左側の項目 終わり ---------------------------------------------------------->
        <!-- 右側の項目 ---------------------------------------------------------->
        <div class="col">
          <p class="title-icon">
          </p>
          <table class="table table-bordered table_fixed">
            <thead>
              <tr>
                <td colspan="3">
                  <p class="title-icon">
                    <i class="fas fa-window-restore icon-size" aria-hidden="true"></i>サイト情報
                  </p>
                </td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="table-active"><label for="service_name">サイト名</label></td>
                <td colspan="2">
                  {{ Form::text('site', old('site'), ['class' => 'form-control']) }}
                </td>
              </tr>
              <tr>
                <td class="table-active"><label for="url">サイトURL</label></td>
                <td colspan="2">
                  {{ Form::text('site_url', old('site_url'), ['class' => 'form-control']) }}
                  <p class="is-error-site_url" style="color: red"></p>
                </td>
              </tr>
              <tr>
                <td class="table-active">
                  <label for="login_url">管理URL</label>
                </td>
                <td colspan="2">
                  {{ Form::text('login', old('login'), ['class' => 'form-control']) }}
                  <p class="is-error-login" style="color: red"></p>
                </td>
              </tr>
              <tr>
                <td class="table-active"><label for="login_id">ID</label></td>
                <td colspan="2">
                  {{ Form::text('site_id', old('site_id'), ['class' => 'form-control']) }}
                </td>
              </tr>
              <tr>
                <td class="table-active"><label for="password">パスワード</label></td>
                <td colspan="2">
                  {{ Form::text('site_pass', old('site_pass'), ['class' => 'form-control']) }}
                </td>
              </tr>
              <tr>
                <th class="table-active"><label for="site_remark">備考</label></th>
                <td colspan="2">
                  {{ Form::textarea('site_remark', old('site_remark'), ['class' => 'form-control']) }}
                </td>
              </tr>
            </tbody>
          </table>

          <!-- 取引条件 ------------------------------------------------------------>
          <table class="table table-bordered table_fixed">
            <thead>
              <tr>
                <td colspan="3">
                  <p class="title-icon">
                    <i class="fas fa-yen-sign icon-size" aria-hidden="true"></i>取引条件
                  </p>
                </td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th class="table-active form_required"><label for="cost">仲介手数料</label></th>
                <td colspan="2">
                  <div class="d-flex align-items-center">
                    {{ Form::text('cost', old('cost'), ['class' => 'form-control']) }}
                    <span class="ml-1">%</span>
                  </div>
                  <p class="is-error-cost" style="color: red"></p>
                </td>
              </tr>
              <tr>
                <th class="table-active"><label for="deal_remark">取引詳細</label></th>
                <td colspan="2">
                  {{ Form::textarea('deal_remark', old('deal_remark'), ['class' => 'form-control']) }}
                </td>
              </tr>
              <tr>
                <td class="table-active"><label for="cancel">キャンセルポリシー</label></td>
                <td colspan="2">
                  <p>
                    {{ Form::radio('cxl', 1,true, ['id' => 'cxl1']) }}
                    {{ Form::label('cxl1', 'SMGルール') }}
                  </p>
                  <p>
                    {{ Form::radio('cxl', 2,false, ['id' => 'cxl2']) }}
                    {{ Form::label('cxl2', '仲介会社ルール') }}
                  </p>
                  <p class="mt-2">
                    <label for="cxl_url">キャンセルポリシーURL</label>
                    {{ Form::text('cxl_url', old('cxl_url'), ['class' => 'form-control']) }}
                  <p class="is-error-cxl_url" style="color: red"></p>
                  </p>
                </td>
              </tr>
              <tr>
                <th class="table-active"><label for="cxl_remark">備考</label></th>
                <td colspan="2">
                  {{ Form::textarea('cxl_remark', old('cxl_remark'), ['class' => 'form-control']) }}
                </td>
              </tr>
            </tbody>
          </table>

          <!-- 決済条件 ------------------------------------------------------------>
          <table class="table table-bordered">
            <thead>
              <tr>
                <td colspan="2">
                  <p class="title-icon">
                    <i class="fas fa-yen-sign icon-size" aria-hidden="true"></i>
                    決済条件
                  </p>
                </td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th class="table-active form_required"><label for="close_date">決済条件</label></th>
                <td>
                  {{{Form::select('payment_limit', [
                  1=>'当月末締め／当月末支払い',
                  2=>'当月末締め／翌月末支払い',
                  3=>'当月末締め／翌々月末支払い',
                  4=>'当月末締め／翌々々月末支払い'
                  ],"",['placeholder' => '選択してください', 'class'=>'custom-select mr-sm-2'])}}}
                  <p class="is-error-payment_limit" style="color: red"></p>
                </td>
              </tr>
              <tr>
                <th class="table-active"><label for="pay_remark">備考</label></th>
                <td>
                  {{ Form::textarea('payment_remark', old('payment_remark'), ['class' => 'form-control']) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      {{ Form::submit('登録する', ['class' => 'btn more_btn_lg d-block btn-lg mx-auto my-5 approval']) }}
      @include('layouts.admin.loading')
    </section>
    {{ Form::close() }}
  </div>
</div>

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

@endsection