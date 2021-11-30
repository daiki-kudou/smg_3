@extends('layouts.admin.app')

@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<div class="float-right">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">
        {{ Breadcrumbs::render(Route::currentRouteName(),$venue->id) }}
      </li>
    </ol>
  </nav>
</div>

<h2 class="mt-3 mb-3">営業時間管理　編集</h2>
<hr>
<div class="section-wrap bg-white wrap_shadow">
  <h3 class="d-block">
    <span>会場：</span>{{ReservationHelper::getVenue($venue->id)}}
  </h3>
  <div class="mt-5 mb-2 warning-text">
    <p>※この情報はSMGサイト内、会場カレンダーや会場予約フォームの時間指定の開始・終了時間に紐づく情報です。<br>
    ※SMG管理者側では下記の営業時間に関係なく、24時間の予約入力が可能です。</p>
  </div>
  <table class="table table-bordered">
    <thead>
      <tr>
        <td width="10%" class="text-center">曜日</td>
        <td>営業時間</td>
        <td width="10%"></td>
      </tr>
    </thead>
    <tbody>

      @foreach ($date_venues as $date_venue)
      @if ($date_venue->week_day==$weekday_id)
      {{ Form::open(['url' => '/admin/dates', 'method'=>'POST']) }}
      @csrf
      <tr>
        <td class="text-center">
          @if ($date_venue->week_day==1)
          月
          @elseif ($date_venue->week_day==2)
          火
          @elseif ($date_venue->week_day==3)
          水
          @elseif ($date_venue->week_day==4)
          木
          @elseif ($date_venue->week_day==5)
          金
          @elseif ($date_venue->week_day==6)
          土
          @elseif ($date_venue->week_day==7)
          日
          @endif
        </td>
        <td>
          <div class="form-inline">
            <select name="start" id="start" class="form-control">
              {!!ReservationHelper::timeOptionsWithRequest($date_venues->where('week_day',$weekday_id)->first()->start)!!}
            </select>
            ~
            <select name="finish" id="finish" class="form-control col-sm-2">
              {!!ReservationHelper::timeOptionsWithRequest($date_venues->where('week_day',$weekday_id)->first()->finish)!!}
            </select>
          </div>
        </td>
        <td class="text-center">
          {{Form::hidden('weekday_id', $weekday_id)}}
          {{Form::hidden('venue_id', $venue_id)}}
          {{Form::submit('更新', ['class'=>'submit btn more_btn'])}}

        </td>
      </tr>
      {{ Form::close() }}
      @else
      <tr>
        <td class="text-center">
          @if ($date_venue->week_day==1)
          月
          @elseif ($date_venue->week_day==2)
          火
          @elseif ($date_venue->week_day==3)
          水
          @elseif ($date_venue->week_day==4)
          木
          @elseif ($date_venue->week_day==5)
          金
          @elseif ($date_venue->week_day==6)
          土
          @elseif ($date_venue->week_day==7)
          日
          @endif
        </td>
        <td>
          {{date('H:i',strtotime($date_venue->start))}}
          ~
          {{date('H:i',strtotime($date_venue->finish))}}
        </td>
        <td></td>
      </tr>
      @endif
      @endforeach
    </tbody>
  </table>
</div>
<script>
  $(function() {
    $('#start').on('change', function() {
      var start = $('#start').val();
      var finish = $('#finish').val();
      if (start > finish) {
        swal('営業開始時間は営業終了時間より前に設定してください');
        $('#start').val('');
      }
    })
    $('#finish').on('change', function() {
      var start = $('#start').val();
      var finish = $('#finish').val();
      if (start > finish) {
        swal('営業終了時間は営業開始時間より後に設定してください');
        $('#finish').val('');
      }
    })
  })
</script>
@endsection