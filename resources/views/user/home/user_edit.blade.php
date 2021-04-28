@extends('layouts.user.app')
@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">

<div class="container-field mt-3">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="http://staging-smg2.herokuapp.com/admin/home">ホーム</a> &gt;
          登録者情報
        </li>
      </ol>
    </nav>
  </div>
  <h2 class="mt-3 mb-3">登録者情報</h2>
  <hr>
</div>

{{Form::open(['url' => 'user/home/user_update', 'method' => 'POST'])}}
@csrf

<section class="section-bg mt-5">
  <table class="table user-profile table-bordered">
    <thead>
      <tr>
        <td colspan="2">
          <div class="d-flex align-items-center">
            <i class="fas fa-info-circle icon-size" aria-hidden="true"></i>
            <p class="section-ttl">登録者情報</p>
          </div>
        </td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th><label for="company">会社・団体名</label></th>
        {{-- <td colspan="2">{{$user->company}}</td> --}}
        <td colspan="2">
          {{Form::text('company',$user->company,['class'=>'form-control'])}}
        </td>
      </tr>
      <tr>
        <th><label for="first_name">担当者氏名</label></th>
        <td>
          <div class="d-flex">
            {{Form::text('first_name',$user->first_name,['class'=>'form-control'])}}
            {{Form::text('last_name',$user->last_name,['class'=>'form-control'])}}
          </div>
        </td>
      </tr>
      <tr>
        <th><label for="first_name_kana">担当者氏名（フリガナ）</label></th>
        <td>
          <div class="d-flex">
            {{Form::text('first_name_kana',$user->first_name_kana,['class'=>'form-control'])}}
            {{Form::text('last_name_kana',$user->last_name_kana,['class'=>'form-control'])}}
          </div>
        </td>
      </tr>
      <tr>
        <th>郵便番号</th>
        <td class="d-flex align-items-center">
          <p>
            {{Form::text('post_code',$user->post_code,['class'=>'form-control'])}}
          </p>
        </td>
      </tr>
      <tr>
        <th><label for="address1">住所1（都道府県）</label></th>
        <td colspan="2">
          {{Form::text('address1',$user->address1,['class'=>'form-control'])}}
        </td>
      </tr>
      <tr>
        <th><label for="address2">住所2（市町村番地）</label></th>
        <td colspan="2">
          {{Form::text('address2',$user->address2,['class'=>'form-control'])}}
        </td>
      </tr>
      <tr>
        <th><label for="address3">住所3（建物名）</label></th>
        <td colspan="2">
          {{Form::text('address3',$user->address3,['class'=>'form-control'])}}
        </td>
      </tr>
      <tr>
        <th><label for="tel">電話番号</label></th>
        <td colspan="2">
          {{Form::text('tel',$user->tel,['class'=>'form-control'])}}
        </td>
      </tr>
      <tr>
        <th><label for="mobile">携帯番号</label></th>
        <td colspan="2">
          {{Form::text('mobile',$user->mobile,['class'=>'form-control'])}}
        </td>
      </tr>
      <tr>
        <th><label for="fax">FAX</label></th>
        <td colspan="2">
          {{Form::text('fax',$user->fax,['class'=>'form-control'])}}
        </td>
      </tr>
      <tr>
        <th><label for="email">メールアドレス</label></th>
        <td colspan="2">
          {{Form::text('email',$user->email,['class'=>'form-control'])}}
        </td>
      </tr>
    </tbody>
  </table>
</section>

　<div class="btn-wrapper mt-5">
  <p class="text-center">
    {{Form::hidden('user_id',$user->id,['class'=>'form-control'])}}
    {{Form::submit('更新',['class'=>'more_btn_lg btn'])}}
  </p>
</div>


{{Form::close()}}







@endsection