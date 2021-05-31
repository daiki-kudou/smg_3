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
  {{ Form::open(['url' => 'user/home', 'method'=>'get', 'id'=>'']) }}
  @csrf
  <dl class="d-flex col-12 justify-content-end align-items-center statuscheck">
    <dt><label for="">支払状況</label></dt>
    <dd class="mr-1">
      {{Form::select('paid', [""=>"",0=>'未入金', 1=>'入金済み',2=>'遅延',3=>'入金不足',4=>'入金過多',5=>'次回繰越'],$request->paid,['class'=>'form-control'])}}
      @if ($request->past)
      {{Form::hidden('past',1)}}
      @endif
    </dd>
    <dd>
      <p class="text-right">
        {{Form::submit('検索')}}
      </p>
    </dd>
  </dl>
  {{Form::close()}}

</div>
<div class="col-12">
  <p class="text-right font-weight-bold"><span class="count-color">{{$counter}}</span>件</p>
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
        {{-- ここに追加 --}}
        @foreach ($reservations as $reservation)
        <tbody class="sale-body">
          @for ($i = 0; $i < $reservation->billCount(); $i++)
            @if ($i==0)
            <tr class="table_row">
              <td rowspan="{{($reservation->billCount()*2)+$reservation->cxlCount()+2}}">
                {{ReservationHelper::IdFormat($reservation->id)}}
              </td>
              <td rowspan="{{($reservation->billCount()*2)+$reservation->cxlCount()+2}}">
                {{ReservationHelper::formatDate($reservation->reserve_date)}}
              </td>
              <td rowspan="{{($reservation->billCount()*2)+$reservation->cxlCount()+2}}">
                {{ReservationHelper::formatTime($reservation->enter_time)}}
              </td>
              <td rowspan="{{($reservation->billCount()*2)+$reservation->cxlCount()+2}}">
                {{ReservationHelper::formatTime($reservation->leave_time)}}
              </td>
              <td rowspan="{{($reservation->billCount()*2)+$reservation->cxlCount()+2}}">
                {{ReservationHelper::getVenue($reservation->venue_id)}}
              </td>
              <td> {{ReservationHelper::judgeStatus($reservation->bills->first()->reservation_status)}}</td>
              <td>{{($reservation->bills->first()->category==1?"会場予約":"")}}</td>
              <td>
                {{-- 売上 --}}
                {{number_format($reservation->bills->first()->master_total)}}円
              </td>
              <td>{{ReservationHelper::formatDate($reservation->bills->first()->payment_limit)}}</td>
              <td> {{ReservationHelper::paidStatus($reservation->bills->first()->paid)}}</td>
              <td class="text-center" rowspan="{{($reservation->billCount()*2)+$reservation->cxlCount()+2}}">
                <a class="more_btn" href="{{route('admin.reservations.show',$reservation->id)}}">
                  予約詳細
                </a>
              </td>
              <td>
                請求書</td>
              <td>領収書</td>
            </tr>
            @if ($reservation->cxls->where('bill_id',0)->count()>0)
            <tr> {{--個別キャンセル分 --}}
              <td>予約状況</td>
              <td>カテゴリ</td>
              <td>利用料金</td>
              <td>支払期日</td>
              <td>支払状況</td>
              <td>請求書</td>
              <td>領収書</td>
              {{-- <td style="color:red">
                {{number_format(-$reservation->bills->first()->master_total)}}円
              </td>
              <td>
                -
              </td>
              <td>
                -
              </td>
              <td>
                {{"会場予約キャンセル"}}
              </td>
              <td>
                {{ReservationHelper::judgeStatus($reservation->bills->first()->reservation_status)}}
              </td>
              <td>-</td>
              <td>-</td> --}}
              {{-- <td>振り込み名　表示必要なし</td> --}}
              {{-- <td>-</td> --}}
            </tr>
            @endif
            @else
            <tr>
              <td>予約状況2</td>
              <td>カテゴリ2</td>
              <td>利用料金2</td>
              <td>支払期日2</td>
              <td>支払状況2</td>
              <td>請求書2</td>
              <td>領収書2</td>
              {{-- <td>
                {{number_format($reservation->bills->skip($i)->first()->master_total)}}円
              </td> --}}
              {{-- <td> {{($reservation->bills->skip($i)->first()->category==2?"追加請求".$i:"")}}</td>
              <td> {{ReservationHelper::judgeStatus($reservation->bills->skip($i)->first()->reservation_status)}}</td>
              <td> {{ReservationHelper::formatDate($reservation->bills->skip($i)->first()->pay_day)}}</td>
              <td> {{$reservation->bills->skip($i)->first()->paid==0?"未入金":"入金済"}}</td>
              <td>
                <p class="remark_limit">{{($reservation->bills->skip($i)->first()->pay_person)}}</p>
              </td>
              <td> {{ReservationHelper::formatDate($reservation->bills->skip($i)->first()->payment_limit)}}</td> --}}
            </tr>
            @if ($reservation->bills->skip($i)->first()->cxl)
            <tr> {{--個別キャンセル分 --}}
              <td>予約状況3</td>
              <td>カテゴリ3</td>
              <td>利用料金3</td>
              <td>支払期日3</td>
              <td>支払状況3</td>
              <td>請求書3</td>
              <td>領収書3</td>
              {{-- <td style="color:red">
                {{number_format(-$reservation->bills->skip($i)->first()->master_total)}}円
              </td>
              <td>-</td>
              <td>-</td> --}}
              {{-- <td>
                {{"追加請求".$i."キャンセル"}}
              </td>
              <td>
                {{ReservationHelper::cxlStatus($reservation->bills->skip($i)->first()->cxl->cxl_status)}}
              </td>
              <td>-</td>
              <td>-</td>
              <td>振り込み名　表示必要なし</td>
              <td>-</td> --}}
            </tr>
            @elseif($reservation->cxls->where('bill_id',0)->count()>0)
            <tr> {{--個別キャンセルではなく、メインの予約がキャンセルされた際 --}}
              <td>予約状況4</td>
              <td>カテゴリ4</td>
              <td>利用料金4</td>
              <td>支払期日4</td>
              <td>支払状況4</td>
              <td>請求書4</td>
              <td>領収書4</td>
              {{-- <td style="color:red">
                {{number_format(-$reservation->bills->skip($i)->first()->master_total)}}円
              </td>
              <td>-</td>
              <td>-</td> --}}
              {{-- <td>
                {{"追加請求".$i."キャンセル"}}
              </td>
              <td>
                {{ReservationHelper::judgeStatus($reservation->bills->skip($i)->first()->reservation_status)}}
              </td>
              <td>-</td>
              <td>-</td>
              <td>振り込み名　表示必要なし</td>
              <td>-</td> --}}
            </tr>
            @endif
            @endif
            @endfor

            {{-- キャンセル部分　一番下にくる --}}
            @if ($reservation->cxls->count()>0)
            <tr>
              <td>予約状況5</td>
              <td>カテゴリ5</td>
              <td>利用料金5</td>
              <td>支払期日5</td>
              <td>支払状況5</td>
              <td>請求書5</td>
              <td>領収書5</td>
              {{-- <td>{{number_format($reservation->cxlSubtotal())}}円</td>
              <td>{{number_format($reservation->cxlCost())}}円</td>
              <td>{{number_format($reservation->cxlProfit())}}円</td>粗利 --}}
              {{-- <td>キャンセル</td>
              <td>キャンセル</td>
              <td></td>
              <td></td>
              <td>振り込み名　表示必要なし</td>
              <td></td> --}}
            </tr>
            @endif
            {{-- キャンセル部分 --}}
        </tbody>
        @endforeach
        {{-- ここに追加 --}}

      </table>
    </div>
  </div>
</div>

<!-- 一覧　　終わり------------------------------------------------ -->

{{$reservations->appends(request()->input())->render()}}

</div>
























@endsection