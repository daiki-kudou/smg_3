@extends('layouts.admin.app')

@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/admin/reservation.js') }}"></script>
<script src="{{ asset('/js/admin/agents/validation.js') }}"></script>
<script src="{{ asset('/js/ctrl_form.js') }}"></script>

<style>
  .hide {
    display: none !important;
  }
</style>

<div class="container-field">
  @include('layouts.admin.breadcrumbs',['id'=>$agent->id])
  <h2 class="mt-3 mb-3">仲介会社 詳細情報(編集)</h2>
  <hr>
</div>

<section class="mt-5">
  {{ Form::model($agent, ['route' => ['admin.agents.update', $agent->id], 'method' => 'put', 'id'=>'agentEditForm']) }}
  @csrf
  <div class="row">
    <!-- 左側の項目 ---------------------------------------------------------->
    <div class="col">
      <table class="table table-bordered table_fixed">
        <thead>
          <tr>
            <td colspan="3">
              <p class="title-icon">
                <i class="fas fa-exclamation-circle icon-size" aria-hidden="true">
                </i>基本情報
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
              {{ Form::text('name', $agent->name, ['class' => 'form-control']) }}
              <small>※仲介会社を選択するプルダウンリストに表示されます。</small>
              <p class="is-error-name" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="company">運営会社名</label>
            </td>
            <td colspan="2">
              {{ Form::text('company', $agent->company, ['class' => 'form-control', 'id'=>'company']) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="post_code">郵便番号</label>
            </td>
            <td colspan="2">
              <input class="form-control" onkeyup="AjaxZip3.zip2addr(this,'','address1','address2');" autocomplete="off"
                name="post_code" type="text" value="{{$agent->post_code}}" id="post_code" onpaste="return false"
                oncontextmenu="return false">
              <p class="is-error-post_code" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="address1">住所1（都道府県）</label>
            </td>
            <td colspan="2">
              {{ Form::text('address1', $agent->address1, ['class' => 'form-control', 'id'=>'company']) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="address2">住所2（市町村番地）</label>
            </td>
            <td colspan="2">
              {{ Form::text('address2', $agent->address2, ['class' => 'form-control', 'id'=>'company']) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="address3">住所3（建物名）</label>
            </td>
            <td colspan="2">
              {{ Form::text('address3', $agent->address3, ['class' => 'form-control', 'id'=>'company']) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="tel">電話番号</label>
            </td>
            <td colspan="2">
              {{ Form::text('person_tel', $agent->person_tel, ['class' => 'form-control', 'id'=>'company','placeholder' => '半角数字、ハイフンなしで入力してください']) }}
              <p class="is-error-person_tel" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="fax">FAX</label>
            </td>
            <td colspan="2">
              {{ Form::text('fax', $agent->fax, ['class' => 'form-control', 'id'=>'company','placeholder' => '半角数字、ハイフンなしで入力してください']) }}
              <p class="is-error-fax" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">
              <label for="person_firstname">担当者氏名</label>
            </td>
            <td>姓：
              {{ Form::text('person_firstname', $agent->person_firstname, ['class' => 'form-control', 'id'=>'company']) }}
              <p class="is-error-person_firstname" style="color: red"></p>
            </td>
            <td>名：
              {{ Form::text('person_lastname', $agent->person_lastname, ['class' => 'form-control', 'id'=>'company']) }}
              <p class="is-error-person_lastname" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="firstname_kana">担当者氏名（フリガナ）</label>
            </td>
            <td>セイ：
              {{ Form::text('firstname_kana', $agent->firstname_kana, ['class' => 'form-control', 'id'=>'company']) }}
              <p class="is-error-firstname_kana" style="color: red"></p>
            </td>
            <td>メイ：
              {{ Form::text('lastname_kana', $agent->lastname_kana, ['class' => 'form-control', 'id'=>'company']) }}
              <p class="is-error-lastname_kana" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <th class="table-active">
              <label for="person_tel">担当者TEL</label>
            </th>
            <td colspan="2">
              {{ Form::text('person_mobile', $agent->person_mobile, ['class' => 'form-control', 'id'=>'company','placeholder' => '半角数字、ハイフンなしで入力してください']) }}
              <p class="is-error-person_mobile" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <th class="table-active">
              <label for="email">担当者メールアドレス</label>
            </th>
            <td colspan="2">
              {{ Form::text('email', $agent->email, ['class' => 'form-control', 'id'=>'company']) }}
              <p class="is-error-email" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <th class="table-active">
              <label for="remark">備考</label>
            </th>
            <td colspan="2">
              {{ Form::textarea('last_remark', $agent->last_remark, ['class' => 'form-control', 'id'=>'company']) }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
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
            <td class="table-active">
              <label for="service_name">サイト名</label>
            </td>
            <td colspan="2">
              {{ Form::text('site', $agent->site, ['class' => 'form-control', 'id'=>'company']) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="url">サイトURL</label>
            </td>
            <td colspan="2">
              {{ Form::text('site_url', $agent->site_url, ['class' => 'form-control', 'id'=>'company']) }}
              <p class="is-error-site_url" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="login_url">管理URL</label>
            </td>
            <td colspan="2">
              {{ Form::text('login', $agent->login, ['class' => 'form-control', 'id'=>'company']) }}
              <p class="is-error-login" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="login_id">ID</label>
            </td>
            <td colspan="2">
              {{ Form::text('site_id', $agent->site_id, ['class' => 'form-control', 'id'=>'company']) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="password">パスワード</label>
            </td>
            <td colspan="2">
              {{ Form::text('site_pass', $agent->site_pass, ['class' => 'form-control', 'id'=>'company']) }}
            </td>
          </tr>
          <tr>
            <th class="table-active">
              <label for="site_remark">備考</label>
            </th>
            <td colspan="2">
              {{ Form::textarea('site_remark', $agent->site_remark, ['class' => 'form-control', 'id'=>'company']) }}
            </td>
          </tr>
        </tbody>
      </table>

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
            <th class="table-active form_required">
              <label for="cost">仲介手数料</label>
            </th>
            <td colspan="2">
              <div class="d-flex align-items-center">
                {{ Form::text('cost', $agent->cost, ['class' => 'form-control', 'id'=>'company']) }}
                <span class="ml-1">%</span>
              </div>
              <p class="is-error-cost" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <th class="table-active">
              <label for="deal_details">取引詳細</label>
            </th>
            <td colspan="2">
              {{ Form::textarea('deal_remark', $agent->deal_remark, ['class' => 'form-control', 'id'=>'company']) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="cancel">キャンセルポリシー</label>
            </td>
            <td colspan="2">
              <p>
                {{ Form::radio('cxl', 1, $agent->cxl==1?true:false, ['id' => 'cxl1']) }}
                {{ Form::label('cxl1', 'SMGルール') }}
              </p>
              <p>
                {{ Form::radio('cxl', 2, $agent->cxl==2?true:false, ['id' => 'cxl2']) }}
                {{ Form::label('cxl2', '仲介会社ルール') }}
              </p>
              <p class="mt-2">
                <label for="cancel">キャンセルポリシーURL</label>
                {{ Form::text('cxl_url', $agent->cxl_url, ['class' => 'form-control']) }}
                <p class="is-error-cxl_url" style="color: red"></p>
              </p>
            </td>
          </tr>
          <tr>
            <th class="table-active">
              <label for="deal_remark">備考</label>
            </th>
            <td colspan="2">
              {{ Form::textarea('cxl_remark', $agent->cxl_remark, ['class' => 'form-control']) }}
            </td>
          </tr>
        </tbody>
      </table>

      <table class="table table-bordered">
        <thead>
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-yen-sign icon-size" aria-hidden="true">
                </i>決済条件
              </p>
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th class="table-active form_required">
              <label for="close_date">決済条件</label>
            </th>
            <td>
              <select name="payment_limit" id="payment_limit">
                <option value="1" {{(int)$agent->payment_limit===1?'selected':""}}>当月末締め／当月末支払い</option>
                <option value="2" {{(int)$agent->payment_limit===2?'selected':""}}>当月末締め／翌月末支払い</option>
                <option value="3" {{(int)$agent->payment_limit===3?'selected':""}}>当月末締め／翌々月末支払い</option>
                <option value="3" {{(int)$agent->payment_limit===4?'selected':""}}>当月末締め／翌々々月末支払い</option>
              </select>
            </td>
          </tr>
          <tr>
            <th class="table-active">
              <label for="pay_remark">備考</label>
            </th>
            <td>
              {{ Form::textarea('payment_remark', $agent->payment_remark, ['class' => 'form-control']) }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div class="mt-5">
    {{Form::submit('保存する', ['class' => 'btn more_btn_lg d-block btn-lg mx-auto my-5 approval']) }}
    @include('layouts.admin.loading')
    {{ Form::close() }}
  </div>
</section>




@endsection