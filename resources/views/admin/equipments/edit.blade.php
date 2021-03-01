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
      <li class="breadcrumb-item active">{{ Breadcrumbs::render(Route::currentRouteName(),$eqipment->id) }}</li>
    </ol>
  </nav>
</div>
<h1 class="mt-3 mb-5">有料備品管理　編集</h1>
<div class="text-right mb-3">
  <a href="/admin/equipments/create" class="btn btn-outline-info btn-lg d-inline-block" style="width: 140px;">新規登録　<i
      class="fas fa-plus"></i></a>
</div>


{{ Form::model($eqipment, ['route' => ['admin.equipments.update', $eqipment->id], 'method' => 'put', 'id'=>'EquipmentsUpdateForm']) }}
<table class="table table-striped table-bordered">
  <thead>
    <tr>
      <th>ID</th>
      <th>登録日</th>
      <th class="form_required">有料備品名</th>
      <th class="form_required">料金</th>
      <th class="form_required">数量</th>
      <th>備考</th>
      <th>詳細(編集)・削除</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>{{ ReservationHelper::IdFormat($eqipment->id) }}</td>
      <td>{{ ReservationHelper::formatDate($eqipment->created_at) }}</td>
      <td>
        <p class="is-error-item" style="color: white"></p>
        <div class="d-flex align-items-center">
          {{ Form::text('item', $eqipment->item, ['class' => 'form-control']) }}
        </div>
        <p class="is-error-item" style="color: red"></p>
      </td>
      <td>
        <p class="is-error-price" style="color: white"></p>
        {{ Form::text('price', $eqipment->price, ['class' => 'form-control']) }}
        <p class="is-error-price" style="color: red"></p>
      </td>
      <td>
        <p class="is-error-stock" style="color: white"></p>
        {{ Form::text('stock', $eqipment->stock, ['class' => 'form-control']) }}
        <p class="is-error-stock" style="color: red"></p>
      </td>
      <td>{{ Form::text('remark', $eqipment->remark, ['class' => 'form-control']) }}</td>
      <td>
        {{ Form::submit('更新', ['class' => 'btn btn-primary']) }}
      </td>
    </tr>
  </tbody>
</table>
{{ Form::close() }}

@endsection