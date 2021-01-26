@extends('layouts.admin.app')

@section('content')

<h1><span class="badge badge-secondary">仲介会社　詳細</span></h1>
<div class="d-flex">
  {{ link_to_route('admin.agents.edit', '編集', $parameters = $agent->id, ['class' => 'btn btn-primary']) }}
  {{ Form::model($agent, ['route' => ['admin.agents.destroy', $agent->id], 'method' => 'delete']) }}
  @csrf
  {{ Form::submit('削除', ['class' => 'btn btn-danger']) }}
  {{ Form::close() }}
</div>
<div class="row">
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
</div>
@endsection