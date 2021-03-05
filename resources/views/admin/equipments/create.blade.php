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



<div class="content">
  <div class="container-fluid">
    <div class="float-right">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">
            {{ Breadcrumbs::render(Route::currentRouteName()) }}
          </li>
        </ol>
      </nav>
    </div>
    <h2 class="mt-3 mb-3">有料備品新規登録</h2>
    <hr>

    {{ Form::open(['url' => 'admin/equipments', 'method'=>'POST', 'id'=>'EquipmentsCreateForm']) }}
    @csrf
    <table class="table table-striped table-bordered mt-5">
      <thead>
        <tr>
          <th>id</th>
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
          <td>{{ReservationHelper::IdFormat(App\Models\Equipment::all()->count()+1)}}</td>
          <td>{{ReservationHelper::formatDate(Carbon\Carbon::now())}}</td>
          <td>
            <p class="is-error-item" style="color: white"></p>
            {{ Form::text('item', old('item'), ['class' => 'form-control']) }}
            <p class="is-error-item" style="color: red"></p>
          </td>
          <td>
            <p class="is-error-price" style="color: white"></p>
            {{ Form::number('price', old('price'), ['class' => 'form-control']) }}
            <p class="is-error-price" style="color: red"></p>
          </td>
          <td>
            <p class="is-error-stock" style="color: white"></p>
            {{ Form::number('stock', old('stock'), ['class' => 'form-control']) }}
            <p class="is-error-stock" style="color: red"></p>
          </td>
          <td>{{ Form::textarea('remark', old('remark'), ['class' => 'form-control','rows'=>"2"]) }}</td>
          <td>{{ Form::submit('登録', ['class' => 'btn more_btn']) }}</td>
        </tr>
      </tbody>
    </table>
    {{ Form::close() }}
  </div>
</div>
@endsection