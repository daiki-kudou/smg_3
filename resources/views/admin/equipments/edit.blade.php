@extends('layouts.admin.app')
@section('content')
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/admin/validation.js') }}"></script>
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

<div class="content">
  <div class="container-fluid">
    <div class="float-right">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">
            {{ Breadcrumbs::render(Route::currentRouteName(),$eqipment->id) }}
          </li>
        </ol>
      </nav>
    </div>

    <h2 class="mt-3 mb-3">有料備品管理　編集</h2>
    <hr>
    {{ Form::model($eqipment, ['route' => ['admin.equipments.update', $eqipment->id], 'method' => 'put', 'id'=>'EquipmentsUpdateForm']) }}
    @csrf

    <p class="text-right  mt-5">※金額は税抜で入力してください。</p>
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>登録日</th>
          <th class="form_required">有料備品名</th>
          <th class="form_required">料金</th>
          <th class="form_required">数量</th>
          <th>備考</th>
          <th>更新</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>{{ ReservationHelper::IdFormat($eqipment->id) }}</td>
          <td>{{ ReservationHelper::formatDate($eqipment->created_at) }}</td>
          <td>
            <div class="d-flex align-items-center">
              {{ Form::text('item', $eqipment->item, ['class' => 'form-control']) }}
            </div>
            <p class="is-error-item" style="color: red"></p>
          </td>
          <td>
            {{ Form::text('price', $eqipment->price, ['class' => 'form-control']) }}
            <p class="is-error-price" style="color: red"></p>
          </td>
          <td>
            {{ Form::text('stock', $eqipment->stock, ['class' => 'form-control']) }}
            <p class="is-error-stock" style="color: red"></p>
          </td>
          <td>{{ Form::text('remark', $eqipment->remark, ['class' => 'form-control']) }}</td>
          <td>
            {{ Form::submit('更新', ['class' => 'btn more_btn approval']) }}
            <div class="loading hide">
              <button class="btn more_btn" type="button" disabled>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                確認中...
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    {{ Form::close() }}
  </div>
</div>


@endsection