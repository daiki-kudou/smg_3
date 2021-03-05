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
<div class="container-fluid">


  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">
          {{ Breadcrumbs::render(Route::currentRouteName(),$service->id) }}
        </li>
      </ol>
    </nav>
  </div>

  <h2 class="mt-3 mb-3">有料サービス管理　編集</h2>
  <hr>


  {{ Form::model($service, ['route' => ['admin.services.update', $service->id], 'method' => 'put', 'id'=>'ServiceUpdateForm']) }}
  @csrf
  <table class="table table-striped table-bordered mt-5">
    <thead>
      <tr>
        <th>ID</th>
        <th>登録日</th>
        <th class="form_required">サービス名</th>
        <th class="form_required">料金</th>
        <th>備考</th>
        <th>更新</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>{{ ReservationHelper::IdFormat($service->id) }}</td>
        <td>{{ ($service->created_at) }}</td>
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
          {{ Form::submit('更新', ['class' => 'btn more_btn approval']) }}
          <div class="loading hide">
            <button class="btn more_btn" type="button" disabled>
              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            </button>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
  </form>

</div>
@endsection