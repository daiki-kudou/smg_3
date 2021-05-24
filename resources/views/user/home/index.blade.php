@extends('layouts.user.app')
@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
{{-- <script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/ajax.js') }}"></script> --}}

<div class="container-field mt-3">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="http://staging-smg2.herokuapp.com/admin/home">ホーム</a> >
          ダミーダミー
        </li>
      </ol>
    </nav>
  </div>

  <h2 class="mt-3 mb-3">予約一覧</h2>
  <hr>
</div>

<div class="col-12">
  <dl class="d-flex col-12 justify-content-end align-items-center statuscheck">
    <dt><label for="">支払状況</label></dt>
    <dd class="mr-1">
      <select class="form-control select2" name="">
        <option>未入金</option>
        <option>入金済</option>
      </select>
    </dd>
    <dd>
      <p class="text-right"><a class="more_btn" href="">検索</a></p>
    </dd>
  </dl>

</div>
<div class="col-12">
  <p class="text-right font-weight-bold"><span class="count-color">10</span>件</p>
</div>

<!-- 一覧　　------------------------------------------------ -->

<ul class="nav nav-tabs">
  <li class="nav-item">
    <a href="#reserve-list" class="nav-link {{empty($request->past)?"active":""}}" data-toggle="tab"
      id="future_link">予約一覧</a>
  </li>
  <li class="nav-item">
    <a href="#used-list" class="nav-link {{!empty($request->past)?"active":""}}" data-toggle="tab"
      id="past_link">過去履歴</a>
  </li>
</ul>

{{Form::open(['url' => 'user/home', 'method' => 'get', 'id'=>'future'])}}
@csrf
{{Form::close()}}
<script>
  $('#future_link').on('click',function(){
    $('#future').submit();
  })
</script>

{{Form::open(['url' => 'user/home', 'method' => 'get', 'id'=>'past'])}}
@csrf
{{Form::hidden('past',1)}}
{{Form::close()}}
<script>
  $('#past_link').on('click',function(){
    $('#past').submit();
  })
</script>


<div class="tab-content">
  <div id="reserve-list" class="tab-pane active">
    <div class="table-wrap">
      <table class="table table-bordered table-box table-scroll">
        <thead>
          <tr>
            <th>予約ID</th>
            <th>利用日</th>
            <th>入室</th>
            <th>退室</th>
            <th>会場</th>
            <th width="120">予約状況</th>
            <th width="120">カテゴリー</th>
            <th>利用料金（税込）</th>
            <th>支払期日</th>
            <th>支払状況</th>
            <th class="btn-cell">詳細</th>
            <th class="btn-cell">請求書</th>
            <th class="btn-cell">領収書</th>
          </tr>
        </thead>
        @foreach ($reservations as $reservation)
        <tbody>
          <tr>
            <td rowspan="{{count($reservation->bills)}}">{{ReservationHelper::fixId($reservation->id)}}
            </td>
            <td rowspan="{{count($reservation->bills)}}">
              {{ReservationHelper::formatDate($reservation->reserve_date)}}</td>
            <td rowspan="{{count($reservation->bills)}}">
              {{ReservationHelper::formatTime($reservation->enter_time)}}</td>
            <td rowspan="{{count($reservation->bills)}}">
              {{ReservationHelper::formatTime($reservation->leave_time)}}</td>
            <td rowspan="{{count($reservation->bills)}}">{{ReservationHelper::getVenueForUser($reservation->venue_id)}}
            </td>
            <td>{{ReservationHelper::judgeStatus($reservation->bills->first()->reservation_status)}}</td>
            <td>会場予約</td>
            <td>{{number_format($reservation->bills->first()->master_total)}}円</td>
            <td>{{ReservationHelper::formatDate($reservation->bills->first()->payment_limit)}}</td>
            <td>{{ReservationHelper::paidStatus($reservation->bills->first()->paid)}}</td>
            <td rowspan="{{count($reservation->bills)}}"><a href="{{ url('user/home/'.$reservation->id) }}"
                class="more_btn btn">詳細</a></td>
            <td>
              {{ Form::open(['url' => 'admin/invoice', 'method'=>'post', 'target'=>'_blank', 'class'=>'']) }}
              @csrf
              {{ Form::hidden('reservation_id', $reservation->id ) }}
              {{ Form::hidden('bill_id', $reservation->bills->first()->id ) }}
              <p class="mr-2">{{ Form::submit('請求書をみる',['class' => 'btn more_btn']) }}</p>
              {{ Form::close() }}
            </td>
            <td>
              {{ Form::open(['url' => 'admin/receipts', 'method'=>'post', 'target'=>'_blank', 'class'=>'']) }}
              @csrf
              {{ Form::hidden('bill_id', $reservation->bills->first()->id ) }}
              @if ($reservation->bills->first()->paid==1)
              <p class="mr-2">{{ Form::submit('領収書をみる',['class' => 'more_btn btn']) }}</p>
              @endif
              {{ Form::close() }}
            </td>
          </tr>
          @for ($i = 0; $i < count($reservation->bills)-1; $i++)
            <tr>
              <td>
                {{ReservationHelper::judgeStatus($reservation->bills->skip($i+1)->first()->reservation_status)}}
              </td>
              <td>追加請求</td>
              <td>{{number_format($reservation->bills->skip($i+1)->first()->master_total)}}円</td>
              <td>{{ReservationHelper::formatDate($reservation->bills->skip($i+1)->first()->payment_limit)}}</td>
              <td>{{ReservationHelper::paidStatus($reservation->bills->skip($i+1)->first()->paid)}}</td>
              <td>
                {{ Form::open(['url' => 'admin/invoice', 'method'=>'post', 'target'=>'_blank', 'class'=>'']) }}
                @csrf
                {{ Form::hidden('reservation_id', $reservation->id ) }}
                {{ Form::hidden('bill_id', $reservation->bills->skip($i+1)->first()->id ) }}
                <p class="mr-2">{{ Form::submit('請求書をみる',['class' => 'btn more_btn']) }}</p>
                {{ Form::close() }}
              </td>
              <td>
                {{ Form::open(['url' => 'admin/receipts', 'method'=>'post', 'target'=>'_blank', 'class'=>'']) }}
                @csrf
                {{ Form::hidden('bill_id', $reservation->bills->skip($i+1)->first()->id)}}
                @if ($reservation->bills->skip($i+1)->first()->paid==1)
                <p class="mr-2">{{ Form::submit('領収書をみる',['class' => 'more_btn btn']) }}</p>
                @endif
                {{ Form::close() }}
              </td>
            </tr>
            @endfor
        </tbody>
        @endforeach
      </table>
    </div>
  </div>
</div>

<!-- 一覧　　終わり------------------------------------------------ -->

{{$reservations->appends(request()->input())->render()}}

</div>
























@endsection