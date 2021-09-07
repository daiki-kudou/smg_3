@extends('layouts.user.app')
@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
{{-- <script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/ajax.js') }}"></script> --}}

<div class="container-field mt-3">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="http://staging-smg2.herokuapp.com/admin/home">ホーム</a> &gt;
          会員情報
        </li>
      </ol>
    </nav>
  </div>
  <h2 class="mt-3 mb-3">会員情報</h2>
  <hr>
</div>

@if (session('flash_message'))
<div class="alert alert-danger">
  <ul>
    <li> {!! session('flash_message') !!} </li>
  </ul>
</div>
@endif

<section class="section-bg mt-5">
  <table class="table user-profile table-bordered">
    <thead>
      <tr>
        <td colspan="2">
          <div class="d-flex align-items-center">
            <i class="fas fa-info-circle icon-size" aria-hidden="true"></i>
            <p class="section-ttl">会員情報</p>
          </div>
        </td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th><label for="company">会社・団体名</label></th>
        <td colspan="2">{{$user->company}}</td>
      </tr>
      <tr>
        <th><label for="first_name">担当者氏名</label></th>
        <td>{{ReservationHelper::getPersonName($user->id)}}</td>
      </tr>
      <tr>
        <th><label for="first_name_kana">担当者氏名（フリガナ）</label></th>
        <td>{{ReservationHelper::getPersonNameKANA($user->id)}}</td>
      </tr>
      <tr>
        <th>郵便番号</th>
        <td class="d-flex align-items-center">
          <p>〒{{$user->post_code}}</p>
        </td>
      </tr>
      <tr>
        <th><label for="address1">住所1（都道府県）</label></th>
        <td colspan="2">{{$user->address1}}</td>
      </tr>
      <tr>
        <th><label for="address2">住所2（市町村番地）</label></th>
        <td colspan="2">{{$user->address2}}</td>
      </tr>
      <tr>
        <th><label for="address3">住所3（建物名）</label></th>
        <td colspan="2">{{$user->address3}}</td>
      </tr>
      <tr>
        <th><label for="tel">電話番号</label></th>
        <td colspan="2">{{$user->tel}}
        </td>
      </tr>
      <tr>
        <th><label for="mobile">携帯番号</label></th>
        <td colspan="2">{{$user->mobile}}
        </td>
      </tr>
      <tr>
        <th><label for="fax">FAX</label></th>
        <td colspan="2">{{$user->fax}}
        </td>
      </tr>
      <tr>
        <th><label for="email">メールアドレス</label></th>
        <td colspan="2">{{$user->email}}
          <p class="">
            <a href="{{url('user/home/email_reset')}}">メールアドレスを変更する</a>
          </p>
        </td>
      </tr>
      <tr>
        <th><label for="password">パスワード</label></th>
        <td colspan="2">
          <p class="">
            <a href="{{url('user/password/reset')}}">パスワードを変更する</a>
          </p>
        </td>
      </tr>
    </tbody>
  </table>
</section>


<div class="btn_wrapper ">
  {{Form::open(['url' => 'user/home/user_edit', 'method' => 'POST'])}}
  @csrf
  {{Form::hidden('user_id',$user->id)}}
  <p class="text-center">{{Form::submit('編集する',['class'=>'more_btn_lg btn'])}}
    {{Form::close()}}
  </p>
  <hr class="my-5 user-profile">
  <p class="user-profile text-right">
    <a href="{{url('user/home/cxl_membership')}}">退会を希望する</a>
  </p>
</div>



@endsection