@extends('layouts.user.app')
@section('content')



<div>
  【体系手続き】<br>
</div>


<div>登録者情報<br></div>

<div>
  <table>
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
  </table>
</div>

<div class="d-flex mt-5">
  <a href="{{url('user/home')}}">退会しない</a>
  {{ Form::open(['url' => 'user/home/'.$user->id, 'method'=>'delete', 'id'=>'']) }}
  @csrf
  {{Form::submit('退会する')}}
</div>







@endsection