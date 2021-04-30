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
    <a href="#reserve-list" class="nav-link active" data-toggle="tab">予約一覧</a>
  </li>
  <li class="nav-item">
    <a href="#used-list" class="nav-link" data-toggle="tab">過去履歴</a>
  </li>
</ul>

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
        @foreach ($user->reservations()->get() as $reservation)
        <tbody>
          <tr>
            <td rowspan="{{count($reservation->bills()->get())}}">{{ReservationHelper::fixId($reservation->id)}}
            </td>
            <td rowspan="{{count($reservation->bills()->get())}}">
              {{ReservationHelper::formatDate($reservation->reserve_date)}}</td>
            <td rowspan="{{count($reservation->bills()->get())}}">
              {{ReservationHelper::formatTime($reservation->enter_time)}}</td>
            <td rowspan="{{count($reservation->bills()->get())}}">
              {{ReservationHelper::formatTime($reservation->leave_time)}}</td>
            <td>{{ReservationHelper::getVenueForUser($reservation->venue_id)}}</td>
            <td>{{ReservationHelper::judgeStatus($reservation->bills()->first()->reservation_status)}}</td>
            <td>※カテゴリー</td>
            <td>{{number_format($reservation->bills()->first()->total)}}円</td>
            <td>{{$reservation->payment_limit}}</td>
            <td rowspan="{{count($reservation->bills()->get())}}">{{$reservation->bills()->first()->paid}}</td>
            <td><a href="{{ url('user/home/'.$reservation->id) }}" class="more_btn btn">詳細</a></td>
            <td> {{ Form::open(['url' => 'admin/invoice', 'method'=>'post', 'class'=>'']) }}
              @csrf
              {{ Form::hidden('reservation_id', $reservation->id ) }}
              {{ Form::hidden('bill_id', $reservation->bills->first()->id ) }}
              <p class="mr-2">{{ Form::submit('請求書をみる',['class' => 'btn more_btn']) }}</p>
              {{ Form::close() }}
            </td>
            <td><a href="" class="more_btn btn">領収書をみる</a></td>
          </tr>
          @for ($i = 0; $i < count($reservation->bills()->get())-1; $i++)
            <tr>
              <td></td>
              <td>
                {{ReservationHelper::judgeStatus($reservation->bills()->skip($i+1)->first()->reservation_status)}}
              </td>
              <td>カテゴリ</td>
              <td>{{number_format($reservation->bills()->skip($i+1)->first()->total)}}円</td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            @endfor
        </tbody>
        @endforeach

        <tbody>
          <tr>
            <td class="text-center">00000</td>
            <td>2020/12/07(月)</td>
            <td>00：00</td>
            <td>00：00</td>
            <td>四ツ橋・サンワールドビル22号室</td>
            <td class="table_column">
              <p>ステータス</p>
              <p>ステータス</p>
            </td>
            <td class="table_column">
              <p>カテゴリー</p>
              <p>カテゴリー</p>
            </td>
            <td class="table_column">
              <p class="justify-content-center">0円</p>
              <p class="justify-content-center">0円</p>
            </td>
            <td class="table_column">
              <p>2020/12/07(月)</p>
              <p>2020/12/07(月)</p>
            </td>
            <td class="table_column">
              <p>ステータス</p>
              <p>ステータス</p>
            </td>
            <td class="table_column">
              <p class="justify-content-center"><a class="more_btn btn" href="">詳細</a></p>
              <p class="justify-content-center"><a class="more_btn btn" href="">詳細</a></p>
            </td>
            <td class="table_column">
              <p class="justify-content-center"><a class="more_btn btn" href="">請求書をみる</a></p>
              <p class="justify-content-center"><a class="more_btn btn" href="">請求書をみる</a></p>
            </td>
            <td class="table_column">
              <p class="justify-content-center"><a class="more_btn btn" href="">領収書をみる</a></p>
              <p class="justify-content-center"><a class="more_btn btn" href="">領収書をみる</a></p>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- 一覧　　終わり------------------------------------------------ -->

<ul class="pagination justify-content-center">
  <li class="page-item disabled" aria-disabled="true" aria-label="&laquo; 前">
    <span class="page-link" aria-hidden="true">&lsaquo;</span>
  </li>
  <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
  <li class="page-item"><a class="page-link" href="">2</a>
  </li>
  <li class="page-item"><a class="page-link" href="">3</a>
  </li>
  <li class="page-item">
    <a class="page-link" href="http://staging-smg2.herokuapp.com/admin/clients?page=2" rel="next"
      aria-label="次 &raquo">&rsaquo;</a>
  </li>
</ul>
</div>
























@endsection