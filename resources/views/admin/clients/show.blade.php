@extends('layouts.admin.app')

@section('content')
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
  <h2 class="mt-3 mb-3">顧客管理 詳細</h2>
  <hr>
</div>

<section class="section-wrap">
  <div class="align-items-center d-flex justify-content-between mb-3">
  <div>
      {{ Form::model($user, ['route' => ['admin.clients.destroy', $user->id], 'method' => 'delete']) }}
      @csrf
      {{ Form::submit('削除', ['class' => 'btn more_btn4']) }}
      {{ Form::close() }}
    </div>
    <div>
      {{ link_to_route('admin.clients.edit', '編集する', $parameters = $user->id, ['class' => 'btn more_btn']) }}
    </div>
  </div>

  <div class="row">
    <!-- 左側の項目 ---------------------------------------------------->
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
            <th class="table-active">{{ Form::label('id', '利用者ID') }}</th>
            <td>{{$user->id}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('company', '会社・団体名') }}</th>
            <td>{{$user->company}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('post_code', '郵便番号') }}</th>
            <td>{{$user->post_code}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('address1', '住所1（都道府県）') }}</th>
            <td>{{$user->address1}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('address2', '住所2（市町村番地）') }}</th>
            <td>{{$user->address2}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('address3', '住所3（建物名）') }}</th>
            <td>{{$user->address3}}</td>
            </td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('address_remark', '住所備考') }}</th>
            <td>{{$user->address_remark}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('url', '会社・団体名URL') }}</th>
            <td>{{$user->url}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('attr', '顧客属性') }}</th>
            <td>
              @if ($user->attr==1)
              一般企業
              @elseif($user->attr==2)
              上場企業
              @elseif($user->attr==3)
              近隣利用
              @elseif($user->attr==4)
              講師・セミナー
              @elseif($user->attr==5)
              ネットワーク
              @elseif($user->attr==6)
              その他
              @endif
            </td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('condition', '割引条件') }}</th>
            <td>{{$user->condition}}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- 左側の項目 終わり---------------------------------------------------->


    <!-- 右側の項目 ---------------------------------------------------->
    <div class="col">
      <!-- 担当者情報 ------------------------------------------------------>
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
            <td>{{$user->first_name}}{{$user->last_name}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('first_name_kana', '担当者氏名（フリガナ）') }}</th>
            <td>{{$user->first_name_kana}}{{$user->last_name_kana}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('mobile', '携帯電話') }}</th>
            <td>{{$user->mobile}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('tel', '固定電話') }}</th>
            <td>{{$user->tel}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('email', '担当者メールアドレス') }}</th>
            <td>{{$user->email}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('fax', 'FAX') }}</th>
            <td>{{$user->fax}}</td>
          </tr>
        </tbody>
      </table>

      <!-- 支払いデータ ------------------------------------------------>
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
            <td>
              @if ($user->pay_method==1)
              銀行振込
              @elseif($user->pay_method==2)
              現金
              @elseif($user->pay_method==3)
              クレジットカード
              @elseif($user->pay_method==4)
              スマホ決済
              @endif
            </td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('pay_limit', '支払期日') }}</th>
            <td>
              @if ($user->pay_limit==1)
              当月末〆当月末CASH
              @elseif($user->pay_limit==2)
              当月末〆翌月末CASH
              @elseif($user->pay_limit==3)
              当月末〆翌々月末CACH
              @elseif($user->pay_limit==4)
              当月末〆3カ月末CASH
              @endif
            </td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('pay_post_code', '請求書送付先郵便番号') }}</th>
            <td>{{$user->pay_post_code}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('pay_address1', '請求書送付先（都道府県）') }}</th>
            <td>{{$user->pay_address1}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('pay_address2', '請求書送付先（市町村番地）') }}</th>
            <td>{{$user->pay_address2}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('pay_address3', '請求書送付先 (建物名)') }}</th>
            <td>{{$user->pay_address3}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('pay_remark', '請求書備考') }}</th>
            <td>{{$user->pay_remark}}</td>
          </tr>
        </tbody>
      </table>



    </div>
    <!-- 右側の項目　終わり -------------------------------------------------->
  </div>

  <!-- 備考 ----------------------------------------------------------->
  <div class="row">
    <div class="col">
      <table class="table table table-bordered">
        <thead>
          <tr>
          <th class="table-active caution">{{ Form::label('attention', '注意事項') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="caution">{{$user->attention}}</td>
          </tr>

        </tbody>
      </table>
    </div>
    <div class="col">
      <table class="table table table-bordered">
        <thead>
          <tr>
          <th class="table-active">{{ Form::label('remark', '備考') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{$user->remark}}</td>
          </tr>
          </thead>
        </tbody>
      </table>
    </div>
  </div>
  <!-- 　備考終わり ----------------------------------------->
  
  <div class="text-center mt-5">
  <p><a class="more_btn_lg" href="">一覧にもどる</a>
  </p>
  </div>

</section>
@endsection