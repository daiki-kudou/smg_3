@extends('layouts.admin.app')

@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>

<div class="container-fluid">
  <div class="container-field mt-3">
    <div class="float-right">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">
            {{ Breadcrumbs::render(Route::currentRouteName()) }}
          </li>
        </ol>
      </nav>
    </div>

    <h2 class="mt-3 mb-3">料金管理</h2>
    <hr>
  </div>

  <div class="p-3 mb-2 bg-white text-dark wrap_shadow">
    <span>会場</span>
    <div class="form-group">
      <select id="venue_id" name="venue_id" class="form-control form-control-lg w-50" onChange="location.href=value;">
        <option value="" selected></option>
        @foreach ($venues as $venue)
        <option value="{{ url('/admin/frame_prices',$venue->id) }}">
          {{ $venue->name_area}}{{ $venue->name_bldg}}{{ $venue->name_venue}}
        </option>
        @endforeach
      </select>
    </div>
  </div>


</div>


@endsection