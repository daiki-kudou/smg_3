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
<h2 class="mt-3 mb-3">有料サービス管理　新規登録</h2>
<hr>

{{ Form::open(['url' => 'admin/services', 'method'=>'POST', 'id'=>'ServiceCreateForm']) }}
@csrf
<p class="text-right mt-5">※金額は税抜で入力してください。</p>
<table class="table table-bordered">
  <thead>
    <tr>
      <th>ID</th>
      <th>登録日</th>
      <th class="form_required">有料サービス名</th>
      <th class="form_required">料金<span class="ml-1 annotation">※税抜</span></th>
      <th>備考</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>{{ReservationHelper::fixId(App\Models\Service::all()->count()+1)}}</td>
      <td>{{ReservationHelper::formatDate(Carbon\Carbon::now())}}</td>
      <td>
        {{ Form::text('item', "", ['class' => 'form-control']) }}
        <p class="is-error-item" style="color: red"></p>
      </td>
      <td>
        <div class="d-flex align-items-end">
          {{ Form::text('price',"" , ['class' => 'form-control']) }}
          <span class="ml-1">円</span>
        </div>
        <p class="is-error-price" style="color: red"></p>
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
      {{ Form::close() }}
    </tr>
  </tbody>
</table>



@endsection