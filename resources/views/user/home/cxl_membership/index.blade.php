@extends('layouts.user.app')
@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">

<div class="container-field mt-3">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="http://staging-smg2.herokuapp.com/admin/home">ホーム</a> &gt;
          退会手続き
        </li>
      </ol>
    </nav>
  </div>
  <h2 class="mt-3 mb-3">退会手続き</h2>
  <hr>
</div>

<section class="container-field mt-5">
  <div>
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
          <td>会社・団体名</td>
          <td>{{$user->company}}</td>
        </tr>
        <tr>
          <td>担当者氏名</td>
          <td>{{ReservationHelper::getPersonName($user->id)}}</td>
        </tr>
        <tr>
          <td>担当者氏名（フリガナ）</td>
          <td>{{ReservationHelper::getPersonNameKANA($user->id)}}</td>
        </tr>
        <tr>
          <td>郵便番号</td>
          <td>{{$user->post_code}}</td>
        </tr>
        <tr>
          <td>都道府県</td>
          <td>{{$user->address1}}</td>
        </tr>
        <tr>
          <td>市町村番地</td>
          <td>{{$user->address2}}</td>
        </tr>
        <tr>
          <td>建物名</td>
          <td>{{$user->address3}}</td>
        </tr>
        <tr>
          <td>携帯電話</td>
          <td>{{$user->mobile}}</td>
        </tr>
        <tr>
          <td>固定電話</td>
          <td>{{$user->tel}}</td>
        </tr>
        <tr>
          <td>FAX</td>
          <td>{{$user->fax}}</td>
        </tr>
        <tr>
          <td>メールアドレス</td>
          <td>{{$user->email}}</td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="d-flex mt-5 justify-content-between user-profile">
    <p><a class="more_btn_lg btn" href="{{url('user/home')}}">退会しない</a></p>
    {{ Form::open(['url' => 'user/home/'.$user->id, 'method'=>'delete', 'id'=>'']) }}
    @csrf
    {{Form::hidden('user_id',$user->id)}}
    <p>{{Form::submit('退会する',['class'=>'more_btn_lg btn'])}}</p>
  </div>
</section>


@endsection