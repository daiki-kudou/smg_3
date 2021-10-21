@extends('layouts.admin.app')
@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script src="{{ asset('/js/admin/clients/validation.js') }}"></script>
<script src="{{ asset('/js/ctrl_form.js') }}"></script>



<style>
  .checkon {
    display: none;
  }
</style>

<div class="container-field">
  <div class="float-right">
    @include('layouts.admin.breadcrumbs',['id'=>$user->id])
  </div>
  <h2 class="mt-3 mb-3">顧客管理 詳細情報(編集)</h2>
  <hr>
</div>

{{ Form::open(['url' => 'admin/clients/'.$user->id, 'method'=>'PUT', 'id'=>'ClientsEditForm']) }}
@csrf

<section class="mt-5">
  <div class="row">
    <!-- 左側の項目 ---------------------------------------------------------->
    <div class="col">
      <table class="table table-bordered">
        <thead>
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-exclamation-circle icon-size fa-fw"></i>基本情報
              </p>
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th class="table-active form_required">{{ Form::label('company', '会社・団体名') }}</th>
            <td>{{ Form::text('company', $user->company, ['class' => 'form-control']) }}
              <p class="is-error-company" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <th class="table-active form_required">{{ Form::label('post_code', '郵便番号') }}</th>
            <td>{{ Form::text('post_code', $user->post_code, [
                            'class' => 'form-control',
                            'onKeyUp'=>"AjaxZip3.zip2addr(this,'','address1','address2');",
                            'autocomplete'=>'off',
                            'onpaste'=>"return false",
                  'oncontextmenu'=>"return false" 

                            ]) }}
              <p class="is-error-post_code" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <th class="table-active form_required">{{ Form::label('address1', '住所1（都道府県）') }}</th>
            <td>{{ Form::text('address1', $user->address1, ['class' => 'form-control']) }}
            <p class="is-error-address1" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <th class="table-active form_required">{{ Form::label('address2', '住所2（市町村番地）') }}</th>
            <td>{{ Form::text('address2', $user->address2, ['class' => 'form-control']) }}
            <p class="is-error-address2" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('address3', '住所3（建物名）') }}</th>
            <td>{{ Form::text('address3', $user->address3, ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('url', '会社・団体名URL') }}</th>
            <td>{{ Form::text('url', $user->url, ['class' => 'form-control']) }}
              <p class="is-error-url" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <div class="d-flex align-items-center">
                <input type="checkbox" class="discount mr-1" {{$user->condition?"checked":""}}>
                {{ Form::label('condition', '割引条件') }}
              </div>
            </td>
            <td>
              {{ Form::textarea('condition', $user->condition?$user->condition:"平日 %\n土日 %\n3週間前 %\n", $user->condition?['class' => 'form-control ']:['class' => 'form-control checkon']) }}
            </td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('attr', '顧客属性') }}</th>
            <td>
              {{Form::select('attr', [0=>'',1=>'一般企業', 2=>'上場企業',3=>'近隣利用', 4=>'個人講師', 5=>'MLM', 6=>'仲介会社', 7=>'その他'],$user->attr)}}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- 左側の項目 終わり---------------------------------------------------------->

    <!-- 右側の項目 ---------------------------------------------------------->
    <div class="col">
      <table class="table table-bordered">
        <thead>
          <tr>
            <p class="title-icon">
              <td colspan="3"><i class="fas fa-user fa-fw icon-size"></i>担当者情報
            </p>
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th class="table-active form_required">
              {{ Form::label('first_name', '担当者氏名') }}
            </th>
            <td>姓：
              {{ Form::text('first_name', $user->first_name, ['class' => 'form-control']) }}
              <p class="is-error-first_name" style="color: red"></p>
            </td>
            <td>名：{{ Form::text('last_name', $user->last_name, ['class' => 'form-control']) }}
              <p class="is-error-last_name" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <th class="table-active form_required">{{ Form::label('first_name_kana', '担当者氏名（フリガナ）') }}</th>
            <td>セイ：
              {{ Form::text('first_name_kana', $user->first_name_kana, ['class' => 'form-control'])}}
              <p class="is-error-first_name_kana" style="color: red"></p>
            </td>
            <td>メイ：{{ Form::text('last_name_kana', $user->last_name_kana, ['class' => 'form-control']) }}
              <p class="is-error-last_name_kana" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('mobile', '携帯番号') }}
              <p class="annotation">※携帯番号、電話番号のどちらか一方は必須</p>
            </th>
            <td colspan="2">
              {{ Form::text('mobile', $user->mobile, ['class' => 'form-control phone_number','placeholder' => '半角数字、ハイフンなしで入力してください']) }}
              <p class="is-error-mobile" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('tel', '固定電話') }}
              <p class="annotation">※携帯番号、電話番号のどちらか一方は必須</p>
            </th>
            <td colspan="2">
              {{ Form::text('tel', $user->tel, ['class' => 'form-control phone_number','placeholder' => '半角数字、ハイフンなしで入力してください']) }}
              <p class="is-error-tel" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <th class="table-active form_required">{{ Form::label('email', '担当者メールアドレス') }}</th>
            <td colspan="2">{{ Form::text('email', $user->email, ['class' => 'form-control']) }}
              <p class="is-error-email" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('fax', 'FAX') }}</th>
            <td colspan="2">
              {{ Form::text('fax', $user->fax, ['class' => 'form-control','placeholder' => '半角数字、ハイフンなしで入力してください']) }}
              <p class="is-error-fax" style="color: red"></p>
            </td>
          </tr>
        <tbody>
      </table>

      <!-- 支払いデータ ------------------------------------------------------------>
      <table class="table table-bordered">
        <thead>
          <tr>
            <td colspan="3">
              <p class="title-icon">
                <i class="fas fa-yen-sign icon-size"></i>支払いデータ
              </p>
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th class="table-active form_required">{{ Form::label('pay_method', '支払方法') }}</th>
            <td>{{Form::select('pay_method', [1=>'銀行振込', 2=>'現金',3=>'クレジットカード', 4=>'スマホ決済'],$user->pay_method)}}
              <p class="is-error-pay_metdod" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <th class="table-active form_required">{{ Form::label('pay_limit', '支払期日') }}</th>
            <td>
              {{Form::select('pay_limit', [1=>'当日',2=>'3営業日前', 3=>'当月末締め／当月末支払い',4=>'当月末締め／翌月末支払い',5=>'当月末締め／翌々月末支払い'],$user->pay_limit)}}
              <p class="is-error-pay_limit" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('pay_post_code', '請求書送付先郵便番号') }}</th>
            <td>{{ Form::text('pay_post_code', $user->pay_post_code, [
                                'class' => 'form-control pay_post_code',
                                'onKeyUp'=>"AjaxZip3.zip2addr(this,'','pay_address1','pay_address2');",
                                'autocomplete'=>'off',
                                ]) }}
              <p class="is-error-pay_post_code" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('pay_address1', '請求書送付先（都道府県）') }}</th>
            <td>{{ Form::text('pay_address1', $user->pay_address1, ['class' => 'form-control pay_address_1']) }}
            </td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('pay_address2', '請求書送付先（市町村番地）') }}</th>
            <td>{{ Form::text('pay_address2',$user->pay_address2, ['class' => 'form-control pay_address_2']) }}
            </td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('pay_address3', '請求書送付先 (建物名)') }}</th>
            <td>{{ Form::text('pay_address3',$user->pay_address3, ['class' => 'form-control']) }}
            </td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('pay_remark', '請求書備考') }}</th>
            <td>{{ Form::textarea('pay_remark', $user->pay_remark, ['class' => 'form-control']) }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- 右側の項目 終わり---------------------------------------------------------->

  </div>
  <div class="row">
    <div class="col">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th class="table-active caution caution_bg">{{ Form::label('attention', '注意事項') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="caution">{{ Form::textarea('attention', $user->attention, ['class' => 'form-control']) }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="col">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th class="table-active">{{ Form::label('remark', '備考') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ Form::textarea('remark', $user->remark, ['class' => 'form-control']) }}</td>
          </tr>
          </thead>
        </tbody>
      </table>
    </div>
  </div>

  <div class="mt-5">
    {{ Form::submit('保存する', ['class' => 'btn more_btn_lg d-block btn-lg mx-auto my-5']) }}
  </div>

</section>
{{ Form::close() }}

<script>
  $(function() {
    $('.discount').on('click', function() {
      $('#condition').toggleClass('checkon');
    })

  })
</script>


@endsection