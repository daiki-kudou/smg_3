@extends('layouts.admin.app')
@section('content')
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/validation.js') }}"></script>
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">

@if ($errors->any())
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif
<div class="float-right">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">{{ Breadcrumbs::render(Route::currentRouteName()) }}</li>
    </ol>
  </nav>
</div>

<h1 class="mt-3 mb-5">有料サービス管理　新規作成</h1>
<div class="text-right mb-3">
  <a href="/admin/equipments/create" class="btn btn-outline-info btn-lg d-inline-block" style="width: 140px;">新規登録　<i
      class="fas fa-plus"></i></a>
</div>

{{ Form::open(['url' => 'admin/services', 'method'=>'POST', 'id'=>'ServiceCreateForm']) }}
@csrf
<table class="table table-striped table-bordered">
  <thead>
    <tr>
      <th>id</th>
      <th>登録日</th>
      <th class="form_required">有料サービス名</th>
      <th class="form_required">料金</th>
      <th>備考</th>
      <th>詳細(編集)・削除</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>{{ReservationHelper::IdFormat(App\Models\Service::all()->count()+1)}}</td>
      <td>{{ReservationHelper::formatDate(Carbon\Carbon::now())}}</td>
      <td>
        <p class="is-error-item" style="color: white"></p>
        {{ Form::text('item', old('item'), ['class' => 'form-control']) }}
        <p class="is-error-item" style="color: red"></p>
      </td>
      <td>
        <p class="is-error-price" style="color: white"></p>
        {{ Form::text('price', old('price'), ['class' => 'form-control']) }}
        <p class="is-error-price" style="color: red"></p>
      </td>
      <td>
        {{ Form::textarea('remark', old('remark'), ['class' => 'form-control','rows'=>"2"]) }}
      </td>
      <td>{{ Form::submit('登録', ['class' => 'btn btn-primary']) }}</td>
      {{ Form::close() }}
    </tr>
  </tbody>
</table>
@endsection