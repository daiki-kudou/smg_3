@extends('layouts.reservation.app')
@section('content')


<div id="fullOverlay">
  <div class="spinner">
    <div class="loader">Loading...</div>
  </div>
</div>


@if ($errors->any())
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

<!-- カート一覧 -->
<div class="contents">
  <div class="pagetop-text">
    <h1 class="page-title oddcolor"><span>予約一覧</span></h1>
  </div>
</div>

<section class="contents">
  <!-- 予約内容 -------------------------------------------->
  @if (empty($sessions))
  <div style="margin-top:100px;margin-bottom:200px;">
    <h2>選択されている予約はありません</h2>
  </div>
  @else
  @foreach ($sessions as $key=>$reservation)
  <h2>予約{{(int) $loop->index+1}}</h2>
  <div class="section-wrap">
    <table class="table-sum">
      <thead>
        <tr>
          <th colspan="2">
            {{ReservationHelper::getVenueForUser($reservation[0]['venue_id'])}}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th class=""><label for="date">利用日</label></th>
          <td>
            <ul class="sum-list">
              <li>
                <p>
                  {{ReservationHelper::formatDateJA($reservation[0]['date'])}}
                </p>
              </li>
            </ul>
          </td>
        </tr>
        <tr>
          <th class=""><label for="venueFee">会場料金</label></th>
          <td>
            <ul class="sum-list">
              <li>
                <p>
                  {{ReservationHelper::formatTime($reservation[0]['enter_time'])}}
                  ～
                  {{ReservationHelper::formatTime($reservation[0]['leave_time'])}}
                </p>
                <p>
                  {{number_format(ReservationHelper::jsonDecode($reservation[0]['price_result'])[0])}}<span>円</span>
                </p>
              </li>
              @if (ReservationHelper::jsonDecode($reservation[0]['price_result'])[1]!=0)
              <li>
                <p>延長{{ReservationHelper::jsonDecode($reservation[0]['price_result'])[4]}}h</p>
                <p>
                  {{number_format(ReservationHelper::jsonDecode($reservation[0]['price_result'])[1])}}<span>円</span>
                </p>
              </li>
              @endif
            </ul>
          </td>
        </tr>

        @if (!empty(ReservationHelper::DBLJsonDecode($reservation[0]['items_results'])[1]))
        <tr>
          <th class=""><label for="equipment">有料備品</label></th>
          <td>
            <ul class="sum-list">
              @foreach ((object)ReservationHelper::DBLJsonDecode($reservation[0]['items_results'])[1] as $equ)
              <li>
                <p>{{$equ[0]}}<span>×</span><span>{{$equ[2]}}</span> 個</p>
                <p>{{number_format(ReservationHelper::numTimesNum($equ[1],$equ[2]))}}<span>円</span></p>
              </li>
              @endforeach
            </ul>
          </td>
        </tr>
        @endif

        @if (!empty(ReservationHelper::DBLJsonDecode($reservation[0]['items_results'])[2]))
        <tr>
          <th class=""><label for="service">有料サービス</label></th>
          <td>
            <ul class="sum-list">
              @foreach ((object)ReservationHelper::DBLJsonDecode($reservation[0]['items_results'])[2] as $ser)
              <li>
                <p>{{$ser[0]}}</p>
                <p>{{$ser[1]}}<span>円</span></p>
              </li>
              @endforeach
              @if($reservation[0]['luggage_count']||$reservation[0]['luggage_arrive']||$reservation[0]['luggage_return'])
              <li>
                <p>荷持預り/返送</p>
                <p>500<span>円</span></p>
              </li>
              @endif
            </ul>
          </td>
        </tr>
        @endif


        @if (!empty($reservation[0]['layout_prepare'])||!empty($reservation[0]['layout_clean']))
        <tr>
          <th class=""><label for="service">レイアウト</label></th>
          <td>
            <ul class="sum-list">
              @if (!empty($reservation[0]['layout_prepare']))
              <li>
                <p>レイアウト準備料金</p>
                <p>
                  {{number_format(ReservationHelper::getLayoutPrice($reservation[0]['venue_id'])[0])}}<span>円</span>
                </p>
              </li>
              @endif
              @if (!empty($reservation[0]['layout_clean']))
              <li>
                <p>レイアウト片付料金</p>
                <p>
                  {{number_format(ReservationHelper::getLayoutPrice($reservation[0]['venue_id'])[1])}}<span>円</span>
                </p>
              </li>
              @endif
            </ul>
          </td>
        </tr>
        @endif


        <tr>
          <td colspan="2" class="text-right">
            <p class="checkbox-txt"><span>小計</span>{{number_format($reservation[0]['master'])}}円</p>
            <p class="checkbox-txt">
              <span>消費税</span>{{number_format(ReservationHelper::getTax($reservation[0]['master']))}}円
            </p>
          </td>
        </tr>
        <tr>
          <td colspan="2" class="text-right checkbox-txt"><span>合計金額</span>
            <span
              class="sumText">{{number_format(ReservationHelper::taxAndPrice($reservation[0]['master']))}}</span><span>円</span>
          </td>
        </tr>
      </tbody>
    </table>
    <ul class="btn-wrapper">
      <li>
        {{ Form::open(['url' => 'user/reservations/destroy_check', 'method'=>'POST', 'id'=>'']) }}
        {{ Form::hidden("session_reservation_id",$key )}}
        <p>{{Form::submit('予約を取り消す', ['class' => 'confirm-btn'])}}</p>
        {{Form::close()}}

      </li>
      <li>
        {{ Form::open(['url' => 'user/reservations/re_create', 'method'=>'POST', 'id'=>'']) }}
        {{ Form::hidden("session_reservation_id",$key )}}
        <p>{{Form::submit('予約内容を変更する', ['class' => 'link-btn'])}}</p>
        {{Form::close()}}

        {{-- <p class="link-btn"><a href="">予約内容を変更する</a></p> --}}
      </li>
    </ul>
  </div>
  @endforeach
  @endif

  @if (!empty($sessions))
  <div class="section-wrap">
    <table class="table-sum">
      <thead>
        <tr>
          <th colspan="3">
            <p>総合計(<span>{{count($sessions)}}</span><span>件</span>)</p>
          </th>
        </tr>
      </thead>
      <tbody>
        @foreach ($sessions as $t_key=>$t_reservation)
        <tr>
          <th class="">
            <label for="date">{{ReservationHelper::getVenueForUser($t_reservation[0]["venue_id"])}}</label>
          </th>
          <td>
            <ul class="sum-list">
              <li>
                <p>{{ReservationHelper::formatDateJA($t_reservation[0]["date"])}}<br class="sp">会場ご利用料</p>
                <p>{{number_format($t_reservation[0]['master'])}}<span>円</span></p>
              </li>
            </ul>
          </td>
        </tr>
        @endforeach
        <tr>
          <td colspan="2">
            <p class="checkbox-txt">
              <span>小計</span>
              {{number_format(ReservationHelper::numTimesNumArrays($sessions, "master"))}}円
            </p>
            <p class="checkbox-txt">
              <span>消費税</span>
              {{number_format(ReservationHelper::getTax(ReservationHelper::numTimesNumArrays($sessions, "master")))}}円
            </p>
          </td>
        </tr>
        <tr>
          <td colspan="2" class="checkbox-txt">
            <span>合計総額</span>
            <span class="sumText">
              {{number_format(ReservationHelper::taxAndPrice(ReservationHelper::numTimesNumArrays($sessions, "master")))}}
            </span>
            <span>円</span>
            <p>※上記合計金額にケータリングは入っておりません。<br>
              ※お申込み内容によっては、弊社からご連絡の上で、合計金額が変更となる場合がございます</p>
          </td>
        </tr>
      </tbody>
    </table>

    <ul class="btn-wrapper">
      <li>
        <p><a class="link-btn3" href="/">他の日程を予約する</a></p>
      </li>
      <li>
        {{ Form::open(['url' => 'user/reservations/store', 'method'=>'POST', 'id'=>'']) }}
        <p>{{Form::submit('予約を確定する', ['class' => 'confirm-btn','id'=>'master_submit'])}}</p>
        {{Form::close()}}
      </li>
    </ul>
  </div>
  @endif

</section>
<div class="top contents"><a href="#top"><img src="https://osaka-conference.com/img/pagetop.png" alt="上に戻る"></a>
</div>

<script>
  $(function(){
    $('#master_submit').on('click',function(){
      if(!confirm('予約を確定しますか？')){
        return false;
    }else{
        $('#fullOverlay').css('display', 'block');
      }
    })
  })
</script>
@endsection