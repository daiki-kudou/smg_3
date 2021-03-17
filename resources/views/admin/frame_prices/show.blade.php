@extends('layouts.admin.app')
@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
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

  <h2 class="mt-3 mb-3">料金管理　詳細</h2>
  <hr>
</div>

<section class="section-wrap bg-white wrap_shadow">
  @if (count($frame_prices)==0 && count($time_prices)==0)
  <h3 class="d-block"><span
      class="mr-3">ID:{{ ReservationHelper::IdFormat($venue->id)}}</span>{{$venue->name_area}}・{{$venue->name_bldg}}{{$venue->name_venue}}
  </h3>
  <span class="mt-5 mb-5 d-block">※料金データが登録されていません</span>
  <div class="d-flex justify-content-around">
    <div>
      {{ link_to_route('admin.frame_prices.create', '通常の料金体系で登録（枠貸し料金）', $parameters=$venue->id,['class' => 'btn more_btn']) }}
    </div>
    <div>
      {{ link_to_route('admin.time_prices.create', 'アクセア料金体系で登録（時間貸し料金）', $parameters=$venue->id,['class' => 'btn more_btn']) }}
    </div>
  </div>
  @else

  <div class="mb-5">
    <h3 class="d-block mb-3 price_ttl"><span class="mr-3">ID:{{ ReservationHelper::IdFormat($venue->id)}}</span>
      {{ $venue->name_area }}・{{ $venue->name_bldg }}{{ $venue->name_venue }}
    </h3>
    <hr>

    <h4 class="mt-5">料金体系：通常(枠貸し料金)</h4>
    <div class="d-flex justify-content-between align-items-center mt-3">
      <p class="mb-2">・枠は「午前」「午後」「夜間」「午前＆午後」「午後＆夜間」「終日」です。</p>
      <div class="text-right mb-2">
        @if (!count($frame_prices)==0)
        {{ link_to_route('admin.frame_prices.edit', '枠貸し編集', $parameters=$venue->id,['class' => 'btn more_btn']) }}
        @else
        {{ link_to_route('admin.frame_prices.create', '枠貸し新規登録', $parameters=$venue->id,['class' => 'btn more_btn']) }}
        @endif
      </div>
    </div>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th class="table-active" scope="col">枠</th>
          <th class="table-active" scope="col">時間</th>
          <th class="table-active" scope="col">料金<span class="ml-1 annotation">※税抜</span></th>
          <th class="table-active" scope="col">延長料金</th>
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
          @if ($loop->first)
          <td rowspan={{$frame_prices->count()}}>test</td>
          @endif
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="pt-5">
    <h4 class="mb-3">料金体系：アクセア仕様(時間貸し料金)</h4>
    <div class="text-right mb-2">
      @if (!count($time_prices)==0)
      {{ link_to_route('admin.time_prices.edit', '時間貸し編集', $parameters=$venue->id,['class' => 'btn more_btn']) }}
      @else
      {{ link_to_route('admin.time_prices.create', '時間貸し新規登録', $parameters=$venue->id,['class' => 'btn more_btn']) }}
      @endif
    </div>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th class="table-active" scope="col">時間</th>
          <th class="table-active" scope="col">料金<span class="ml-1 annotation">※税抜</span></th>
          <th class="table-active" scope="col">延長料金<span class="ml-1 annotation">※税抜</span></th>
          <!-- <th scope="col">登録日</th> -->
        </tr>
      </thead>
      <tbody>
        @foreach ($time_prices as $time_price)
        <tr>
          <th>{{ $time_price->time}}</th>
          <td>{{ number_format($time_price->price)}}円</td>
          <td>{{ number_format($time_price->extend)}}円</td>
          <!-- <td>{{ ReservationHelper::formatDate($time_price->created_at)}}</td> -->
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @endif




</section>
@endsection