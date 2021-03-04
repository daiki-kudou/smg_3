@extends('layouts.admin.app')

@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<!-- <script src="{{ asset('/js/template.js') }}"></script> -->
<script src="{{ asset('/js/admin/reservation.js') }}"></script>
<script src="{{ asset('/js/admin/validation.js') }}"></script>


<script>
  $(function() {
    $('.search_address1').on('change', function() {
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


<div class="container-fluid">

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

    {{ Form::open(['url' => 'admin/agents', 'method'=>'POST', 'id'=>'agentReservationCreateForm']) }}
    @csrf
    <section class="section-wrap">
      <div class="row">
        <!-- 左側の項目 ---------------------------------------------------------->
        <div class="col">
          <table class="table table-bordered table_fixed">
            <thead>
              <tr>
                <td colspan="3">
                  <p class="title-icon">
                    <i class="fas fa-exclamation-circle icon-size fa-fw" aria-hidden="true"></i>基本情報
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
                  <input class="search_address1 form-control" type="text" name="post_code" maxlength="8"
                    onKeyUp="AjaxZip3.zip2addr(this,'','address1','address2');">
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
                  {{ Form::text('person_tel', old('person_tel'), ['class' => 'form-control']) }}
                </td>
              </tr>
              <tr>
                <td class="table-active"><label for="fax">FAX</label></td>
                <td colspan="2">
                  {{ Form::text('fax', old('fax'), ['class' => 'form-control']) }}
                </td>
              </tr>
              <tr>
                <td class="table-active"><label for="person_firstname">担当者氏名</label></td>
                <td>姓：
                  {{ Form::text('person_firstname', old('person_firstname'), ['class' => 'form-control']) }}
                </td>
                <td>名：
                  {{ Form::text('person_lastname', old('person_lastname'), ['class' => 'form-control']) }}
                </td>
              </tr>
              <tr>
                <td class="table-active"><label for="firstname_kana">担当者氏名（フリガナ）</label></td>
                <td>
                  セイ：
                  {{ Form::text('firstname_kana', old('firstname_kana'), ['class' => 'form-control']) }}
                </td>
                <td>
                  メイ：
                  {{ Form::text('lastname_kana', old('lastname_kana'), ['class' => 'form-control']) }}
                </td>
              </tr>
              <tr>
                <th class="table-active"><label for="person_tel">担当者TEL</label></th>
                <td colspan="2">
                  {{ Form::text('person_mobile', old('person_mobile'), ['class' => 'form-control']) }}
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
                <td colspan="3"><i class="fas fa-window-restore fa-fw icon-size" aria-hidden="true"></i>サイト情報
                  <p></p>
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
                  <label for="login_url">ログインURL</label>
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
                <th class="table-active">
                  <label for="alliance_remark">提携会場備考</label>
                </th>
                <td colspan="2">
                  {{ Form::textarea('agent_remark', old('agent_remark'), ['class' => 'form-control']) }}
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
                    {{ Form::number('cost', old('cost'), ['class' => 'form-control']) }}
                    <span class="ml-1">%</span>
                  </div>
                  <p class="is-error-cost" style="color: red"></p>
                </td>
              </tr>
              <tr>
                <th class="table-active"><label for="deal_details">取引詳細</label></th>
                <td colspan="2">
                  {{ Form::text('deal_remark', old('deal_remark'), ['class' => 'form-control']) }}
                </td>
              </tr>
              <tr>
                <td class="table-active"><label for="cancel">キャンセルポリシー</label></td>
                <td colspan="2">
                  <p>
                    {{ Form::radio('cxl', 1,true, ['class' => '']) }}
                    {{ Form::label('cxl', 'SMGルール') }}
                  </p>
                  <p>
                    {{ Form::radio('cxl', 2,false, ['class' => '']) }}
                    {{ Form::label('cxl', '仲介会社ルール') }}
                  </p>
                  <p class="mt-2">
                    <label for="cancel">キャンセルポリシーURL</label>
                    {{ Form::text('cxl_url', old('cxl_url'), ['class' => 'form-control']) }}
                    <p class="is-error-cxl_url" style="color: red"></p>
                  </p>
                </td>
              </tr>
              <tr>
                <th class="table-active"><label for="deal_remark">備考</label></th>
                <td colspan="2">
                  {{ Form::text('cxl_remark', old('cxl_remark'), ['class' => 'form-control']) }}
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
                    <i class="fas fa-yen-sign icon-size" aria-hidden="true"></i>決済条件
                  </p>
                </td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th class="table-active form_required"><label for="close_date">決済条件</label></th>
                <td>
                  <select name="payment_limit" id="payment_limit">
                    <option value="1">当月末〆当月末CASH</option>
                    <option value="2">当月末〆翌月末CASH</option>
                    <option value="3">当月末〆翌々月末CASH</option>
                  </select>
                </td>
              </tr>
              <!-- <tr>
                <th class="table-active"><label for="payment_day">支払日</label></th>
                <td>
                  {{ Form::text('payment_day', old('payment_day'), ['class' => 'form-control']) }}
                </td>
              </tr> -->
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
      {{ Form::submit('登録する', ['class' => 'btn more_btn_lg d-block btn-lg mx-auto my-5']) }}
    </section>
    {{ Form::close() }}
  </div>
</div>
@endsection