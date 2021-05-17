@extends('layouts.user.app')
@section('content')

@if ($errors->any())
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

<div>
  現在のメールアドレス：
  <br>
  {{$user_email}}
</div>

<div class="mt-5">
  新しいメールアドレスを入力してください
  {{ Form::open(['url' => 'user/home/email_reset_create', 'method'=>'POST']) }}
  @csrf
  {{Form::text('new_email',old('new_email'))}}
  {{Form::submit('送信')}}
  {{Form::close()}}
</div>
@endsection