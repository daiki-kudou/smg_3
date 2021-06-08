@extends('layouts.user.app')
@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/user_reservation/validation.js') }}"></script>

@if ($errors->any())
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

<div class="container-field mt-3">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="http://staging-smg2.herokuapp.com/admin/home">ホーム</a> &gt;
          メールアドレス変更
        </li>
      </ol>
    </nav>
  </div>
  <h2 class="mt-3 mb-3">メールアドレス変更</h2>
  <hr>
</div>

<section class="mt-5">
  <p>
    現在のメールアドレス：{{$user_email}}
  </p>
  
  <div class="mt-5">
    <p class="mb-2">新しいメールアドレスを入力してください</p>
    {{ Form::open(['url' => 'user/home/email_reset_create', 'method'=>'POST', 'id'=>'email_reset']) }}
    @csrf
    <div class="d-flex w-50">
      {{Form::text('new_email',old('new_email'),['class' => 'form-control'])}}
      {{Form::submit('送信する',['class' => 'btn more_btn'])}}
    </div>
    <p class="is-error-new_email" style="color: red"></p>
    {{Form::close()}}
  </div>
</section>
@endsection