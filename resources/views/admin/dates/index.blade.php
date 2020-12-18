@extends('layouts.admin.app')

@section('content')
<script src="{{ asset('/js/template.js') }}"></script>
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">


<div class="container-field mt-3">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">{{ Breadcrumbs::render(Route::currentRouteName()) }}</li>
      </ol>
    </nav>
  </div>
  <h1 class="mt-3 mb-5">営業時間管理</h1>
  <hr>
  <div class="d-flex justify-content-between mt-3 mb-5">
  </div>
</div>

<div class="p-3 mb-2 bg-white text-dark">
  <div>営業時間管理</div>
  <hr>
  <span>会場</span>
  <!-- 選択事後、自動で該当IDに変遷。ライブラリhtml2を利用 -->
  <div class="form-group">
    <select id="venue_id" name="venue_id" class="form-control form-control-lg w-50" onChange="location.href=value;">
      <option value="" selected></option>
      @foreach ($venues as $venue)
      <option value="{{ url('/admin/dates',$venue->id) }}">
        {{ $venue->name_area}}{{ $venue->name_bldg}}{{ $venue->name_venue}}
      </option>
      @endforeach
    </select>
  </div>
</div>

@endsection