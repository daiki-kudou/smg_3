@extends('layouts.user.app')
@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>

<div class="container-fluid">
  <div class="container-field mt-3 d-md-flex justify-content-md-between">
    <h2 class="mt-3 mb-md-5">本予約 申込み　完了</h2>
    <div class="">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">
            {{ Breadcrumbs::render(Route::currentRouteName()) }}
          </li>
        </ol>
      </nav>
    </div>
  </div>
  <hr>

  <div class="notion_wrap mt-5">
    <h3 class="text-center">
      本予約にお申込みいただき、ありがとうございました。
    </h3>
    <div class="notion_inner">
      <p>弊社で内容を確認して、ご連絡致します。</p>
      <p>※追加のお申込み内容をご希望の場合は、下記連絡先までご連絡ください。<br>
        TEL：06-1234-5678<br>
        mail：test@gmail.com
      </p>
    </div>
    <div class="confirm_inner">
      <p class="text-center mb-5 mt-3">
        <a href="{{url('user/home')}}" class="more_btn_lg">予約一覧</a>
      </p>
    </div>
  </div>
</div>
@endsection