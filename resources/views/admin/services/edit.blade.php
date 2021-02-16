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
      <li class="breadcrumb-item active">{{ Breadcrumbs::render(Route::currentRouteName(),$service->id) }}</li>
    </ol>
  </nav>
</div>
<h1 class="mt-3 mb-5">有料サービス管理　編集</h1>
<div class="text-right mb-3">
  <a href="/admin/equipments/create" class="btn btn-outline-info btn-lg d-inline-block" style="width: 140px;">新規登録　<i class="fas fa-plus"></i></a>
</div>



{{ Form::model($service, ['route' => ['admin.services.update', $service->id], 'method' => 'put', 'id'=>'ServiceUpdateForm']) }}
<table class="table table-striped table-bordered">
  <thead>
    <tr>
      <th>id</th>
      <th>登録日</th>
      <th class="form_required">サービス名</th>
      <th class="form_required">料金</th>
      <th>備考</th>
      <th>詳細(編集)・削除</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>{{ ReservationHelper::IdFormat($service->id) }}</td>
      <td>{{ ReservationHelper::formatDate($service->created_at) }}</td>
      <td>
        <p class="is-error-item" style="color: white"></p>
        {{ Form::text('item', $service->item, ['class' => 'form-control']) }}
        <p class="is-error-item" style="color: red"></p>
      </td>
      <td>
        <p class="is-error-price" style="color: white"></p>
        {{ Form::text('price', $service->price, ['class' => 'form-control']) }}
        <p class="is-error-price" style="color: red"></p>
      </td>
      <td>
        {{ Form::text('remark', $service->remark, ['class' => 'form-control']) }}
      </td>
      <td>
        {{ Form::submit('更新', ['class' => 'btn btn-primary']) }}
      </td>
    </tr>
  </tbody>
</table>
{{ Form::close() }}

@endsection