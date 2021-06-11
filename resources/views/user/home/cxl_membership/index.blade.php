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
          <th>会社・団体名</th>
          <td>{{$user->company}}</td>
        </tr>
        <tr>
          <th>担当者氏名</th>
          <td>{{ReservationHelper::getPersonName($user->id)}}</td>
        </tr>
        <tr>
          <th>担当者氏名（フリガナ）</th>
          <td>{{ReservationHelper::getPersonNameKANA($user->id)}}</td>
        </tr>
        <tr>
          <th>郵便番号</th>
          <td>{{$user->post_code}}</td>
        </tr>
        <tr>
          <th>都道府県</th>
          <td>{{$user->address1}}</td>
        </tr>
        <tr>
          <th>市町村番地</th>
          <td>{{$user->address2}}</td>
        </tr>
        <tr>
          <th>建物名</th>
          <td>{{$user->address3}}</td>
        </tr>
        <tr>
          <th>携帯電話</th>
          <td>{{$user->mobile}}</td>
        </tr>
        <tr>
          <th>固定電話</th>
          <td>{{$user->tel}}</td>
        </tr>
        <tr>
          <th>FAX</th>
          <td>{{$user->fax}}</td>
        </tr>
        <tr>
          <th>メールアドレス</th>
          <td>{{$user->email}}</td>
        </tr>
      </tbody>
    </table>

  <div class="d-sm-flex mt-5 justify-content-between cancel-profile">
    <p><a class="more_btn_lg btn" href="{{url('user/home')}}">退会しない</a></p>
    {{ Form::open(['url' => 'user/home/'.$user->id, 'method'=>'delete', 'id'=>'']) }}
    @csrf
    {{Form::hidden('user_id',$user->id)}}
    <p>{{Form::submit('退会する',['class'=>'more_btn_lg btn', 'id'=>'cxl_membership'])}}</p>
  </div>
</section>


  
<script>
  $(function() {
    $('#cxl_membership').on('click', function() {
      if (!confirm('本当に退会しますか？')) {
        return false;
      }
    })
  })
</script>
@endsection