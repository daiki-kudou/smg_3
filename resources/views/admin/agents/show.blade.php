@extends('layouts.admin.app')
@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">

<style>
  .table th {
    width: 35%;
  }
</style>

<div class="container-field">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">
          {{ Breadcrumbs::render(Route::currentRouteName(),$agents->id) }}
        </li>
      </ol>
    </nav>
  </div>
  <h2 class="mt-3 mb-3">仲介会社　詳細</h2>
  <hr>
</div>

<section class="section-wrap">
  <div class="col-12 align-items-center d-flex justify-content-between mt-5 mb-2">
    <div>
      {{ Form::model($agent, ['route' => ['admin.agents.destroy', $agent->id], 'method' => 'delete']) }}
      @csrf
      {{ Form::submit('削除', ['class' => 'btn more_btn4_lg']) }}
      {{ Form::close() }}
    </div>
    <div>
      {{ link_to_route('admin.agents.edit', '編集する', $parameters = $agent->id, ['class' => 'btn more_btn_lg']) }}
    </div>
  </div>

  <!-- <div class="d-flex">
    {{ link_to_route('admin.agents.edit', '編集', $parameters = $agent->id, ['class' => 'btn btn-primary']) }}
    {{ Form::model($agent, ['route' => ['admin.agents.destroy', $agent->id], 'method' => 'delete']) }}
    @csrf
    {{ Form::submit('削除', ['class' => 'btn btn-danger']) }}
    {{ Form::close() }}
  </div> -->


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
            <th class="table-active">{{ Form::label('name', 'サービス名称') }}</th>
            <td>{{ $agent->name }}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('company', '運営会社') }}</th>
            <td>{{ $agent->company }}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('post_code', '郵便番号') }}</th>
            <td>{{ $agent->post_code }}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('address1', '住所1（都道府県）') }}</th>
            <td>{{ $agent->address1 }}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('address2', '住所2（市町村番地）') }}</th>
            <td>{{$agent->address2}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('address3', '住所3（建物名）') }}</th>
            <td>{{$agent->address3}}</td>
            </td>
          </tr>
          <tr>
            <td class="table-active">{{ Form::label('tel', '電話番号') }}</td>
            <td>{{$agent->tel}}</td>
          </tr>
          <tr>
            <td class="table-active">{{ Form::label('fax', 'FAX') }}</td>
            <td>{{$agent->fax}}</td>
          </tr>
          <tr>
            <td class="table-active">{{ Form::label('person_firstname', '担当者氏名') }}</td>
            <td>{{ $agent->person_firstname}}{{ $agent->person_lastname}}</td>
          </tr>
          <tr>
            <td class="table-active">{{ Form::label('firstname_kana', '担当者氏名（ふりがな）') }}</td>
            <td>{{ $agent->firstname_kana}}{{ $agent->lastname_kana}}</td>
          </tr>
          <tr>
            <td class="table-active">{{ Form::label('person_tel', '担当者TEL') }}</td>
            <td>{{$agent->person_tel}}</td>
          </tr>
          <tr>
            <td class="table-active">{{ Form::label('email', '担当者メールアドレス') }}</td>
            <td>{{$agent->email}}</td>
          </tr>
          <tr>
            <td class="table-active">{{ Form::label('remark', '備考') }}</td>
            <td>{{$agent->remark}}</td>
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
              <td colspan="3"><i class="fas fa-window-restore fa-fw icon-size"></i>サイト情報
            </p>
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th class="table-active">{{ Form::label('service_name', 'サービス名称') }}</th>
            <td>{{$agent->service_name}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('service_url', 'サービスURL') }}</th>
            <td>{{$agent->service_url}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('login_url', 'ログインURL') }}</th>
            <td>{{$agent->login_url}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('login_id', 'ID') }}</th>
            <td>{{$agent->login_id}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('password', 'パスワード') }}</th>
            <td>{{$agent->password}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('alliance_remark', '提携会場備考') }}</th>
            <td>{{$agent->alliance_remark}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('site_remark', '備考') }}</th>
            <td>{{$agent->site_remark}}</td>
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
            <td>{{ $agent->cost}}%</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('deal_details', '取引詳細') }}</th>
            <td>{{ $agent->deal_details}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('cancel', 'キャンセルポリシー') }}</th>
            <td>{{ $agent->cancel}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('deal_remark', '備考') }}</th>
            <td>{{ $agent->deal_remark}}</td>
          </tr>
        </tbody>
      </table>

      <!-- 決済条件 ------------------------------------------------------------>
      <table class="table table-bordered">
        <thead>
          <tr>
            <td colspan="3">
              <p class="title-icon">
                <i class="fas fa-yen-sign icon-size"></i>決済条件
              </p>
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th class="table-active">{{ Form::label('close_date', '〆日') }}</th>
            <td>{{ $agent->close_date}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('cost', '支払日') }}</th>
            <td>{{ $agent->payment_day}}</td>
          </tr>
          <tr>
            <th class="table-active">{{ Form::label('pay_remark', '備考') }}</th>
            <td>{{ $agent->payment_remark}}</td>
          </tr>
        </tbody>
      </table>



    </div>
    <!-- 右側の項目　終わり -------------------------------------------------->
  </div>

  <div class="text-center mt-5">
  <p><a class="more_btn_lg" href="">一覧にもどる</a>
  </p>
  </div>



  <!-- オリジナル --------------------------------------------------------------->
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
            <td>{{ $agent->name }}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('post_code', '郵便番号') }}</th>
            <td>{{ $agent->post_code }}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('address1', '住所1（都道府県）') }}</th>
            <td>{{ $agent->address1 }}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('address2', '住所2（市町村番地）') }}</th>
            <td>{{ $agent->address2 }}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('address3', '住所3（建物名）') }}</th>
            <td>{{ $agent->address3 }}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('address_remark', '住所備考') }}</th>
            <td>{{ $agent->address_remark }}</td>
            </td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('url', '会社・団体名URL') }}</th>
            <td><a href="{{ $agent->url }}">{{ $agent->url }}</a></td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('attr', '顧客属性') }}</th>
            <td>{{ $agent->attr}}</td>

          </tr>
          <tr>
            <th scope="row">{{ Form::label('remark', '備考') }}</th>
            <td>{{ $agent->remark}}</td>
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
              <div>姓</div>{{ $agent->person_firstname}}
            </td>
            <td>
              <div>名</div>{{ $agent->person_lastname}}
            </td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('firstname_kana', '担当者氏名（ふりがな）') }}</th>
            <td>
              <div>セイ</div>{{ $agent->firstname_kana}}
            </td>
            <td>
              <div>メイ</div>{{ $agent->lastname_kana}}
            </td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('firstname_kana', '携帯電話') }}</th>
            <td>{{ $agent->person_mobile}}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('person_tel', '固定電話') }}</th>
            <td>{{ $agent->person_tel}}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('fax', 'FAX') }}</th>
            <td>{{ $agent->fax}}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('email', '担当者メールアドレス') }}</th>
            <td>{{ $agent->email}}</td>
          </tr>
          <tr>
            <th scope="row"><i class="fas fa-user fa-fw"></i>支払いデータ</th>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('cost', '支払割合（原価）') }}</th>
            <td>{{ $agent->cost}}%</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('cost', '締日') }}</th>
            <td>{{ $agent->payment_limit}}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('cost', '支払日') }}</th>
            <td>{{ $agent->payment_day}}</td>
          </tr>
          <tr>
            <th scope="row">{{ Form::label('cost', '備考') }}</th>
            <td>{{ $agent->payment_remark}}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div> -->

</section>
@endsection