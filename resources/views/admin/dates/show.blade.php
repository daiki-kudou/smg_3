@extends('layouts.admin.app')

@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>


<div class="content">
  <div class="container-fluid">

    <div class="float-right">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">
            {{ Breadcrumbs::render(Route::currentRouteName(),$venues->id) }}
          </li>
        </ol>
      </nav>
    </div>

    <h2 class="mt-3 mb-3">営業時間管理　詳細</h2>
    <hr>


    <div class="section-wrap bg-white wrap_shadow">
      <h3 class="border border-light d-block">
        <span>会場：</span>{{ReservationHelper::getVenue($venues->id)}}
      </h3>
      <div class="mt-5 mb-2">
        <p>※この情報はSMGサイト内、会場カレンダーや会場予約フォームの時間指定の開始・終了時間に紐づく情報です</p>
      </div>
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td width="10%" class="text-center">曜日</td>
              <td>営業時間</td>
              <td width="10%"></td>
            </tr>
            @foreach ($date_venues as $date_venue)
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
              <td>{{Carbon\Carbon::parse($date_venue->start)->format('H:i')}} ~
                {{Carbon\Carbon::parse($date_venue->finish)->format('H:i')}}
              </td>
              <td class="text-center">{{ Form::open(['url' => 'admin/dates/create', 'method'=>'get']) }}
                @csrf
                {{Form::hidden('weekday_id', $date_venue->week_day)}}
                {{Form::hidden('id', $venues->id)}}
                {{Form::submit('編集', ['class'=>'btn more_btn'])}}
                {{ Form::close() }}
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
    </div>
  </div>
</div>




@endsection