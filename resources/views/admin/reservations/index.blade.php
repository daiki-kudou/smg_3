@extends('layouts.admin.app')

@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/admin/validation.js') }}"></script>


@if (session('flash_message'))
<div class="flash_message bg-success text-center py-3 my-0">
  {{ session('flash_message') }}
</div>
@endif

<style>
  .svg {
    width: 20px;
    height: 20px;
  }
</style>

<div class="content">
  <div class="container-fluid">
    <div class="container-field mt-3">
      <div class="float-right">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active">
              ダミーダミーダミーダミー
            </li>
          </ol>
        </nav>
      </div>
      <h2 class="mt-3 mb-3">予約一覧</h2>
      <hr>
    </div>

    {{ Form::open(['url' => 'admin/reservations', 'method'=>'get', 'id'=>'reserve_search'])}}
    @csrf
    <div class="search-wrap">
      <table class="table table-bordered">
        <tbody>
          <tr>
            <th class="search_item_name">
              <label for="multiple_id">予約一括ID</label>
            <td class="text-right">
              {{ Form::text('multiple_id', '', ['class' => 'form-control', 'id'=>'multiple_id']) }}
              <p class="is-error-multiple_id" style="color: red"></p>
            </td>
            <th class="search_item_name">
              <label for="search_id">予約ID</label>
            </th>
            <td>
              {{ Form::text('search_id', '', ['class' => 'form-control', 'id'=>'']) }}
              <p class="is-error-search_id" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <th class="search_item_name">
              <label for="date">利用日</label>
            </th>
            <td class="text-right form-group">
              {{ Form::text('reserve_date', '', ['class' => 'form-control', 'id'=>'datepicker1']) }}
            </td>

            <th class="search_item_name"><label for="time">入室・退室</label></th>
            <td class="text-right">

              <div class="d-flex align-items-center">
                <select class="form-control select2" name="enter_time">
                  <option value=""></option>
                  @for ($start = 0*2; $start <=23*2; $start++) <option
                    value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}">
                    {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}
                    </option>
                    @endfor
                </select>
                <span>～</span>
                <select class="form-control select2" name="leave_time">
                  <option value=""></option>
                  @for ($start = 0*2; $start <=23*2; $start++) <option
                    value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}">
                    {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}
                    </option>
                    @endfor
                </select>
              </div>
            </td>
          </tr>
          <tr>
            <th class="search_item_name">
              <label for="venue">利用会場</label>
            </th>
            <td class="text-right">
              <select class="form-control select2" name="venue_id">
                <option value=""></option>
                @foreach (App\Models\Venue::cursor() as $venues)
                <option value="{{$venues->id}}">
                  {{ReservationHelper::getVenue($venues->id)}}
                </option>
                @endforeach
              </select>
            </td>

            <th class="search_item_name">
              <label for="company">会社・団体名</label>
            </th>
            <td class="text-right">
              {{ Form::text('company', '', ['class' => 'form-control', 'id'=>'']) }}
            </td>
          </tr>
          <tr>
            <th class="search_item_name">
              <label for="person_name">担当者氏名</label>
            </th>
            <td class="text-right">
              {{ Form::text('person_name', '', ['class' => 'form-control', 'id'=>'']) }}
            </td>
            <th class="search_item_name">
              <label for="search_mobile">携帯電話</label>
            </th>
            <td>
              {{ Form::text('search_mobile', '', ['class' => 'form-control', 'id'=>'']) }}
              <p class="is-error-search_mobile" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <th class="search_item_name">
              <label for="search_tel">固定電話</label>
            </th>
            <td>
              {{ Form::text('search_tel', '', ['class' => 'form-control', 'id'=>'']) }}
              <p class="is-error-search_tel" style="color: red"></p>
            </td>
            <th class="search_item_name">
              <label for="agent">仲介会社</label>
            </th>
            <td class="text-right">
              <select class="form-control select2" style="width: 100%;" name="agent">
                <option value=""></option>
                @foreach ($agents->chunk(1000) as $agent_e)
                @foreach ($agent_e as $agent)
                <option value="{{$agent->id}}">
                  {{ReservationHelper::getAgentCompanyName($agent->id)}}
                </option>
                @endforeach
                @endforeach
              </select>
            </td>
          </tr>
          <tr>
            <th class="search_item_name">
              <label for="enduser_person">エンドユーザー</label>
            </th>
            <td class="text-right">
              {{ Form::text('enduser_person', '', ['class' => 'form-control', 'id'=>'']) }}
            </td>
            <th class="search_item_name">
              <label for="category">アイコン</label>
            </th>
            <td class="text-right">
              <ul class="search_category">
                <li>
                  {{Form::checkbox('check_icon1', 2, false,['id'=>'checkboxPrimary1'])}}
                  {{Form::label("checkboxPrimary1","有料備品")}}
                </li>
                <li>
                  {{Form::checkbox('check_icon2', 3, false,['id'=>'checkboxPrimary2'])}}
                  {{Form::label("checkboxPrimary2","有料サービス")}}
                </li>
                <li>
                  {{Form::checkbox('check_icon3', 4, false,['id'=>'checkboxPrimary3'])}}
                  {{Form::label("checkboxPrimary3","レイアウト")}}
                </li>
                <li>
                  {{Form::checkbox('check_icon4', 0, false,['id'=>'checkboxPrimary4'])}}
                  {{Form::label("checkboxPrimary4","ケータリング")}}
                </li>
              </ul>
            </td>
          </tr>
          <tr>
            <th class="search_item_name"><label for="Status">予約状況</label></th>
            <td colspan="3">
              <ul class="search_category">
                <li>
                  {{Form::checkbox('check_status1', 1, false,['id'=>'check_status1'])}}
                  {{Form::label("check_status1","予約確認中")}}
                </li>
                <li>
                  {{Form::checkbox('check_status2', 2, false,['id'=>'check_status2'])}}
                  {{Form::label("check_status2","予約承認待ち")}}
                </li>
                <li>
                  {{Form::checkbox('check_status3', 3, false,['id'=>'check_status3'])}}
                  {{Form::label("check_status3","予約完了")}}
                </li>
                <li>
                  {{Form::checkbox('check_status4', 4, false,['id'=>'check_status4'])}}
                  {{Form::label("check_status4","キャンセル申請中")}}
                </li>
                <li>
                  {{Form::checkbox('check_status5', 5, false,['id'=>'check_status5'])}}
                  {{Form::label("check_status5","キャンセル承認待ち")}}
                </li>
                <li>
                  {{Form::checkbox('check_status6', 6, false,['id'=>'check_status6'])}}
                  {{Form::label("check_status6","キャンセル")}}
                </li>
              </ul>
            </td>
          </tr>
          <tr>
            <th class="search_item_name"><label for="freeword">フリーワード検索</label></th>
            <td colspan="3">
              {{ Form::text('freeword', '', ['class' => 'form-control', 'id'=>'']) }}
            </td>
          </tr>
        </tbody>
      </table>
      <p class="text-right">※フリーワード検索は本画面表記の項目のみ対象となります</p>
      <div class="btn_box d-flex justify-content-center">
        <a href="{{url('admin/reservations')}}" class="btn reset_btn">リセット</a>
        {{ Form::submit('検索', ['class' => 'btn search_btn']) }}
      </div>
    </div>



    <div class="d-flex justify-content-between">
      <ul class="d-flex reservation_list">
        <li>
          {{ Form::submit('前日予約', ['class' => 'btn more_btn','name'=>'day_before','id'=>'day_before']) }}
        </li>
        <li>
          {{ Form::submit('当日予約', ['class' => 'btn more_btn','name'=>'today','id'=>'today']) }}
        </li>
        <li>
          {{ Form::submit('翌日予約', ['class' => 'btn more_btn','name'=>'day_after','id'=>'day_after']) }}
        </li>
        <!-- <li><a class="more_btn bg-red" href="">予約確認中</a></li>
        <li><a class="more_btn bg-red" href="">予約承認待ち</a></li>
        <li><a class="more_btn bg-green" href="">キャンセル申請中</a></li>
        <li><a class="more_btn bg-black" href="">予約完了</a></li> -->
      </ul>
      {{ Form::close() }}


      @if ($counter!=0)
      <p class="font-weight-bold">
        <span class="count-color">
          {{$counter}}</span>件
      </p>
      @endif
    </div>
    <div class="table-wrap">
      <table class="table table-bordered table-scroll">
        <thead>
          <tr class="table_row">
            <th>予約一括ID</th>
            <th>予約ID</th>
            <th>利用日</th>
            <th>入室</th>
            <th>退室</th>
            <th>利用会場</th>
            <th>会社名団体名</th>
            <th>担当者氏名</th>
            <th>携帯電話</th>
            <th>固定電話</th>
            <th>仲介会社</th>
            <th>エンドユーザー</th>
            <th>アイコン</th>
            <th width="120">売上区分</th>
            <th width="120">予約状況</th>
            <th class="text-center">予約詳細</th>
            <th class="text-center">案内板</th>
          </tr>
        </thead>

        <style>
          .cxl_gray {
            background: gray;
          }
        </style>
        @foreach ($reservations as $reservation)
        <tbody class="{{$reservation->cxlGray()? "cxl_gray":""}}">
        <tbody>
          <tr>
            <td rowspan="{{count($reservation->bills)}}">※後ほど修正
            </td>
            <td class="text-center" rowspan="{{count($reservation->bills)}}">
              {{ReservationHelper::fixId($reservation->id)}}</td>
            <td rowspan="{{count($reservation->bills)}}">
              {{ReservationHelper::formatDate($reservation->reserve_date)}}
            </td>
            <td rowspan="{{count($reservation->bills)}}">{{ReservationHelper::formatTime($reservation->enter_time)}}
            </td>
            <td rowspan="{{count($reservation->bills)}}">{{ReservationHelper::formatTime($reservation->leave_time)}}
            </td>
            <td rowspan="{{count($reservation->bills)}}">
              {{ReservationHelper::getVenue($reservation->venue->id)}}
            </td>
            <td rowspan="{{count($reservation->bills)}}">
              @if ($reservation->user_id>0)
              {{$reservation->user->company}}
              @endif
            </td>
            <td rowspan="{{count($reservation->bills)}}">
              @if ($reservation->user_id>0)
              {{ReservationHelper::getPersonName($reservation->user_id)}}
              @elseif($reservation->user_id==0)
              {{ReservationHelper::getAgentPerson($reservation->agent_id)}}
              @endif
            </td>
            <td rowspan="{{count($reservation->bills)}}">
              @if ($reservation->user_id>0)
              {{$reservation->user->mobile}}
              @else
              {{$reservation->agent->mobile}}
              @endif
            </td>
            <td rowspan="{{count($reservation->bills)}}">
              @if ($reservation->user_id>0)
              {{$reservation->user->tel}}
              @else
              {{$reservation->agent->person_tel}}
              @endif
            </td>
            <td rowspan="{{count($reservation->bills)}}">
              @if ($reservation->agent_id>0)
              {{ReservationHelper::getAgentCompanyName($reservation->agent_id)}}
              @endif
            </td>
            <td rowspan="{{count($reservation->bills)}}">
              @if ($reservation->agent_id>0)
              {{!empty($reservation->endusers->company)?$reservation->endusers->company:""}}
              @endif
            </td>
            <td>
              @foreach (ImageHelper::show($reservation->id) as $icon)
              {!!$icon!!}
              @endforeach
              {!!ImageHelper::newUser($reservation->user_id,$reservation->id)!!}
            </td>
            <td>会場予約</td>
            <td>
              {{ReservationHelper::judgeStatus($reservation->bills->first()->reservation_status)}}
            </td>
            <td class="text-center" rowspan="{{count($reservation->bills)}}"><a
                href="{{ url('admin/reservations', $reservation->id) }}" class="more_btn btn">詳細</a></td>
            <td class="text-center" rowspan="{{count($reservation->bills)}}">
              @if ($reservation->board_flag!=0)
              {{ Form::open(['url' => 'admin/board', 'method'=>'post', 'id'=>'', 'target'=>'_blank'])}}
              @csrf
              {{Form::hidden('reservation_id',$reservation->id)}}
              {{Form::submit('表示', ['class' => 'btn more_btn']) }}
              {{Form::close()}}
              @endif
            </td>
          </tr>
          @for ($i = 0; $i < count($reservation->bills)-1; $i++)
            <tr>
              <td>
                @foreach (ImageHelper::addBillsShow($reservation->bills->skip($i+1)->first()->id) as $icon)
                {!!$icon!!}
                @endforeach
              </td>
              <td>
                @if ($reservation->bills->skip($i+1)->first()->category==2)
                追加請求
                @endif
              </td>
              <td>{{ReservationHelper::judgeStatus($reservation->bills->skip($i+1)->first()->reservation_status)}}
              </td>
            </tr>
            @endfor
        </tbody>
        @endforeach
      </table>
    </div>

  </div>

  {{$reservations->appends(request()->input())->links()}}



</div>






<script>
  $(function() {
    $('.flash_message').fadeOut(3000);
  })

  $(function(){
    $('#day_before, #today, #day_after').on('click',function(){
      $('input[type="text"]').each(function($key,$value){
        $($value).val('');
      })
    })
  })
</script>


@endsection