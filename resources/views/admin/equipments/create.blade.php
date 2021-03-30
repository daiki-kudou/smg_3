@extends('layouts.admin.app')
@section('content')
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/validation.js') }}"></script>
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/ctrl_form.js') }}"></script>

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
      <li class="breadcrumb-item active">
        {{ Breadcrumbs::render(Route::currentRouteName()) }}
      </li>
    </ol>
  </nav>
</div>
<h2 class="mt-3 mb-3">有料備品管理　新規登録</h2>
<hr>

{{ Form::open(['url' => 'admin/equipments', 'method'=>'POST', 'id'=>'EquipmentsCreateForm']) }}
@csrf
<p class="text-right mt-5">※金額は税抜で入力してください。</p>
<table class="table table-striped table-bordered">
  <thead>
    <tr>
      <th>ID</th>
      <th>登録日</th>
      <th class="form_required">有料備品名</th>
      <th class="form_required">料金<span class="ml-1 annotation">※税抜</span></th>
      <th class="form_required">数量</th>
      <th>備考</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>{{ReservationHelper::fixId(ReservationHelper::IdFormat(App\Models\Equipment::all()->count()+1))}}</td>
      <td>{{ReservationHelper::formatDate(Carbon\Carbon::now())}}</td>
      <td>
        {{ Form::text('item', old('item'), ['class' => 'form-control']) }}
        <p class="is-error-item" style="color: red"></p>
      </td>
      <td>
        <div class="d-flex align-items-end">
          {{ Form::text('price', old('price'), ['class' => 'form-control']) }}
          <span class="ml-1">円</span>
        </div>
        <p class="is-error-price" style="color: red"></p>
      </td>
      <td>
        {{ Form::text('stock', old('stock'), ['class' => 'form-control']) }}
        <p class="is-error-stock" style="color: red"></p>
      </td>
      <td>
        {{ Form::textarea('remark', old('remark'), ['class' => 'form-control','rows'=>"2"]) }}
      </td>
      <td>
        {{ Form::submit('登録', ['class' => 'btn more_btn approval']) }}
        <div class="loading hide">
          <button class="btn more_btn" type="button" disabled>
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
          </button>
        </div>
      </td>
    </tr>
  </tbody>
</table>
{{ Form::close() }}
@endsection