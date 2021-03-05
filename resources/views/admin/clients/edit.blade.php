@extends('layouts.admin.app')
@section('content')
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/admin/validation.js') }}"></script>
<script src="{{ asset('/js/admin/reservation.js') }}"></script>
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">

<div class="container-field">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">
          ダミーダミーダミーダミー
        </li>
      </ol>
    </nav>
  </div>
  <h2 class="mt-3 mb-3">顧客管理 編集</h2>
  <hr>
</div>

<section class="section-wrap">
  <div class="row">
    <!-- 左側の項目 ---------------------------------------------------------->
    <div class="col">
      {{Form::model($user, ['route' => ['admin.clients.update', $user->id], 'method' => 'put'])}}
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
            <th class="table-active">{{ Form::label('company', '会社・団体名') }}</th>
            <td>{{ Form::text('company', $user->company, ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('post_code', '郵便番号') }}</th>
            <td>{{ Form::text('post_code', $user->post_code, [
                            'class' => 'form-control',
                            'onKeyUp'=>"AjaxZip3.zip2addr(this,'','address1','address2');",
                            'autocomplete'=>'off',
                            ]) }}
            </td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('address1', '住所1（都道府県）') }}</th>
            <td>{{ Form::text('address1', $user->address1, ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('address2', '住所2（市町村番地）') }}</th>
            <td>{{ Form::text('address2', $user->address2, ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('address3', '住所3（建物名）') }}</th>
            <td>{{ Form::text('address3', $user->address3, ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('address_remark', '住所備考') }}</th>
            <td>{{ Form::textarea('address_remark', $user->address_remark, ['class' => 'form-control']) }}
            </td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('url', '会社・団体名URL') }}</th>
            <td>{{ Form::text('url', $user->url, ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('attr', '顧客属性') }}</th>
            <td>{{Form::select('attr', [1=>'一般企業', 2=>'上場企業',3=>'近隣利用', 4=>'講師・セミナー', 5=>'ネットワーク', 6=>'その他'],$user->attr)}}
            </td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('condition', '割引条件') }}</th>
            <td>{{ Form::text('condition', old('condition'), ['class' => 'form-control']) }}</td>
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
            <th class="table-active">{{ Form::label('first_name', '担当者氏名') }}</th>
            <td>姓：{{ Form::text('first_name', $user->first_name, ['class' => 'form-control']) }}
            </td>
            <td>名：{{ Form::text('last_name', $user->last_name, ['class' => 'form-control']) }}
            </td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('first_name_kana', '担当者氏名（フリガナ）') }}</th>
            <td>セイ：{{ Form::text('first_name_kana', $user->first_name_kana, ['class' => 'form-control'])}}
            </td>
            <td>メイ：{{ Form::text('last_name_kana', $user->last_name_kana, ['class' => 'form-control']) }}
            </td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('tel', '電話番号') }}</th>
            <td colspan="2">{{ Form::text('tel', $user->tel, ['class' => 'form-control']) }}
            </td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('mobile', '携帯番号') }}</th>
            <td colspan="2">{{ Form::text('mobile', $user->mobile, ['class' => 'form-control']) }}
            </td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('email', '担当者メールアドレス') }}</th>
            <td colspan="2">{{ Form::text('email', $user->email, ['class' => 'form-control']) }}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('fax', 'FAX') }}</th>
            <td colspan="2">{{ Form::text('fax', $user->fax, ['class' => 'form-control']) }}</td>
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
            <th class="table-active">{{ Form::label('pay_method', '支払方法') }}</th>
            <td>{{Form::select('pay_method', [1=>'銀行振込', 2=>'現金',3=>'クレジットカード', 4=>'スマホ決済'],$user->pay_method)}}
            </td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('pay_limit', '支払期日') }}</th>
            <td>{{Form::select('pay_limit', [1=>'当月末〆当月末CASH', 2=>'当月末〆翌月末CASH',3=>'当月末〆翌々月末CACH',4=>'当月末〆3カ月末CASH'],$user->pay_limit)}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('pay_post_code', '請求書送付先郵便番号') }}</th>
            <td>{{ Form::text('pay_post_code', $user->pay_post_code, [
                                'class' => 'form-control pay_post_code',
                                'onKeyUp'=>"AjaxZip3.zip2addr(this,'','pay_address1','pay_address2');",
                                'autocomplete'=>'off',
                                ]) }}
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
    {{ Form::close() }}
  </div>

</section>
@endsection