@extends('layouts.admin.app')
@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<div class="container-field mt-3">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">{{ Breadcrumbs::render(Route::currentRouteName(),$venue->id) }}</li>
      </ol>
    </nav>
  </div>
  
  <h2 class="mt-3 mb-3">料金管理　詳細</h2>
  <hr>
</div>

@if (count($frame_prices)==0 && count($time_prices)==0)
<div class="section-wrap">
  <div class="w-100">
    <span class="d-block mb-2">会場</span>
    <strong class="border border-light d-block"
      style="width:100%;">{{$venue->name_area}}{{$venue->name_bldg}}{{$venue->name_venue}}</strong>
    <span class="mt-5 mb-5 d-block">料金データが登録されていません</span>
  </div>
  <div class="d-flex justify-content-around">
    <div>
      {{ link_to_route('admin.frame_prices.create', '通常の料金体系で登録（枠貸し料金）', $parameters=$venue->id,['class' => 'btn more_btn']) }}
    </div>
    <div>
      {{ link_to_route('admin.time_prices.create', 'アクセア料金体系で登録（時間貸し料金）', $parameters=$venue->id,['class' => 'btn more_btn']) }}
    </div>
  </div>
</div>
@else

<div class="section-wrap">
  <span>会場</span>
  <div class="form-group">
    {{ $venue->name_area}}{{ $venue->name_bldg}}{{ $venue->name_venue}}
  </div>
  <div>
    <div class="d-flex justify-content-between mb-3">
      <h4>料金体系：通常(枠貸し料金)</h4>
      @if (!count($frame_prices)==0)
      {{ link_to_route('admin.frame_prices.edit', '枠貸し編集', $parameters=$venue->id,['class' => 'btn more_btn']) }}
      @else
      {{ link_to_route('admin.frame_prices.create', '枠貸し新規作成', $parameters=$venue->id,['class' => 'btn more_btn']) }}
      @endif
    </div>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col">枠</th>
          <th scope="col">時間</th>
          <th scope="col">料金</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($frame_prices as $frame_price)
        <tr>
          <td>{{ $frame_price->frame}}</td>
          <td>{{Carbon\Carbon::parse($frame_price->start)->format('H:i')}} ~
            {{Carbon\Carbon::parse($frame_price->finish)->format('H:i')}}　（{{Carbon\Carbon::parse($frame_price->finish)->diffInHours(Carbon\Carbon::parse($frame_price->start))}}H）
          </td>
          <td>{{ number_format($frame_price->price)}}円</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>



<div class="p-3 mb-2 bg-white text-dark">
  <span>会場</span>
  <div class="form-group">
    {{ $venue->name_area}}{{ $venue->name_bldg}}{{ $venue->name_venue}}
  </div>
  <div>
    <div class="d-flex justify-content-between mb-3">
      <h4>料金体系：アクセア仕様(時間貸し料金)</h4>
      @if (!count($time_prices)==0)
      {{ link_to_route('admin.time_prices.edit', '時間貸し編集', $parameters=$venue->id,['class' => 'btn more_btn']) }}
      @else
      {{ link_to_route('admin.time_prices.create', '時間貸し新規作成', $parameters=$venue->id,['class' => 'btn more_btn']) }}
      @endif
    </div>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col">時間</th>
          <th scope="col">料金</th>
          <th scope="col">延長料金</th>
          <th scope="col">登録日</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($time_prices as $time_price)
        <tr>
          <th>{{ $time_price->time}}</th>
          <td>{{ number_format($time_price->price)}}</td>
          <td>{{ number_format($time_price->extend)}}</td>
          <td>{{ ReservationHelper::formatDate($time_price->created_at)}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endif
@endsection