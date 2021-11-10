@extends('layouts.admin.app')
@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/ctrl_form.js') }}"></script>
<script src="{{ asset('/js/admin/frame_prices/clone.js') }}"></script>
<script src="{{ asset('/js/admin/frame_prices/validation.js') }}"></script>


<style>
  .is-error {
    color: red;
  }
</style>

<div class="container-field mt-3">

  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">
          {{ Breadcrumbs::render(Route::currentRouteName(),$venue->id) }}
        </li>
      </ol>
    </nav>
  </div>
  <h2 class="mt-3 mb-3">料金管理　新規登録（枠貸し）</h2>
  <hr>
</div>

<div class="section-wrap bg-white wrap_shadow">
  <h3 class="d-block mt-3 mb-5"><span class="mr-3">ID:{{ ReservationHelper::Fixid($venue->id)}}</span>
    {{ $venue->name_bldg }}{{ $venue->name_venue }}
  </h3>
  <div class="new_price">
    @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    <div>
      {{ Form::open( ['route' => 'admin.frame_prices.store',"id"=>'FramePriceCreateForm']) }}
      @csrf
      <p class="mb-2 text-right">※枠は「午前」「午後」「夜間」「午前＆午後」「午後＆夜間」「終日」です。</p>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>枠</th>
            <th>時間（開始）</th>
            <th>時間（終了）</th>
            <th>料金<span class="ml-1 annotation">※税抜</span></th>
            <th>追加・削除</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              {{ Form::text('frame[0]', old('frame[0]'), ['class' => 'form-control']) }}
            </td>
            <td>
              <select name="start[0]" id="start" class="form-control col-sm-12">
                <option value=""></option>
                {!!ReservationHelper::timeOptionsWithRequest('08:00:00')!!}
              </select>
            </td>
            <td>
              <select name="finish[0]" id="finish" class="form-control col-sm-12">
                <option value=""></option>
                {!!ReservationHelper::timeOptionsWithRequest('12:00:00')!!}
              </select>
            </td>
            <td>
              <div class="d-flex align-items-end">
                <p>{{ Form::text('price[0]', "", ['class' => 'form-control']) }}</p>
                <p class="ml-1">円</p>
              </div>
            </td>
            <td>
              <input type="button" value="＋" class="add pluralBtn">
              <input type="button" value="－" class="del pluralBtn">
            </td>
          </tr>
        </tbody>
      </table>
      <div>
        <p>
          延長料金(1H)<span class="ml-1 annotation">※税抜</span>
        </p>
      </div>
      {{ Form::number('extend', old('extend'),['class'=>'form-control w-25']) }}
      <p class="is-error-extend" style="color: red"></p>
      {{Form::hidden('venue_id', $venue->id)}}
      <div class="mt-5 mx-auto d-flex w-50">
        {{ Form::submit('登録する', ['class' => 'btn more_btn_lg d-block btn-lg mx-auto my-5']) }}
      </div>
      {{ Form::close() }}
    </div>
  </div>
</div>



@endsection