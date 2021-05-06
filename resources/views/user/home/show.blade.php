@extends('layouts.user.app')
@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
{{--<script src="{{ asset('/js/ajax.js') }}"></script> --}}


<div class="container-field mt-3">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">
          ダミーダミーダミー
        </li>
      </ol>
    </nav>
  </div>
  <h2 class="mt-3 mb-3">予約 詳細</h2>
  <hr>
</div>

{{-- ステータス承認待ち --}}
@if ($reservation->bills->first()->reservation_status==2)
<div class="confirm-box text-center">
  <p>下記、予約内容で承認される場合は、承認ボタンを押してください。</p>
  <p>※承認ボタンは、画面一番下にあります。</p>
</div>
@endif

<!-- 工藤さん！！！キャンセル承認まちのときの文言です。 -->
@if ($reservation->cxls->pluck("cxl_status")->contains(1))
<div class="confirm-box text-center">
  <p>下記、予約内容のキャンセルを承認される場合は、承認ボタンを押してください。</p>
  <p>※承認ボタンは、画面一番下にあります。</p>
</div>
@endif

<!-- 予約詳細--------------------------------------------------------　 -->
<section class="mt-5">
  <table class="table ttl_head mb-0">
    <tbody>
      <tr>
        <td>
          <h3 class="text-white">
            予約概要
          </h3>
        </td>
        <td>
          <div class="d-md-flex justify-content-end">
            <dl class="ttl_box">
              <dt>予約ID：</dt>
              <dd class="total_result">{{ReservationHelper::fixId($reservation->id)}}</dd>
            </dl>
            <!-- <dl class="ttl_box">
                  <dt>予約一括ID</dt>
                  <dd class="total_result">ダミー</dd>
                </dl> -->
          </div>
        </td>
    </tbody>
  </table>
  <section class="border-wrap2 px-4">
    <div class="bill_status">
      <table class="table">
        <tbody>
          <tr>
            <td>
              <ul class="d-sm-flex justify-content-between">
                <li class="d-flex align-items-center mb-2">
                  <p class="bg-status p-2">予約状況</p>
                  <p class="border p-2">
                    {{ReservationHelper::judgeStatus($reservation->bills->first()->reservation_status)}}
                  </p>
                </li>
                <li>
                  <p><span>申込日：</span>{{ReservationHelper::formatDate($reservation->created_at)}}</p>
                  <p><span>予約確定日：</span>{{!empty($reservation->approve_send_at)?ReservationHelper::formatDate($reservation->approve_send_at):""}}</p>
                </li>
              </ul>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="row user_wrap">
      <!-- 左側の項目------------------------------------------------------------------------ -->
      <div class="col-md-6 col-12">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td colspan="2">
                <p class="title-icon">
                  <i class="fas fa-info-circle icon-size" aria-hidden="true"></i>
                  予約情報
                </p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="date">ご利用日</label></td>
              <td>
                {{ReservationHelper::formatDate($reservation->reserve_date)}}
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="venue">会場</label></td>
              <td>
                <p>
                  {{ReservationHelper::getVenueForUser($reservation->venue_id)}}
                </p>
                <p>{{ReservationHelper::priceSystem($reservation->price_system)}}</p>

              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="start">入室時間</label></td>
              <td>
                {{ReservationHelper::formatTime($reservation->enter_time)}}
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="finish">退室時間</label></td>
              <td>
                {{ReservationHelper::formatTime($reservation->leave_time)}}
              </td>
            </tr>
          </tbody>
        </table>
        <div class="customer-table">
          <table class="table table-bordered oneday-table">
            <tbody>
              <tr>
                <td colspan="2">
                  <p class="title-icon">
                    <i class="fas fa-user icon-size" aria-hidden="true"></i>
                    当日連絡のできるご担当者様
                  </p>
                </td>
              </tr>
              <tr>
                <td class="table-active"><label for="ondayName">氏名</label></td>
                <td>
                  {{$reservation->in_charge}}
                </td>
              </tr>
              <tr>
                <td class="table-active"><label for="mobilePhone">携帯番号</label></td>
                <td>
                  {{$reservation->tel}}
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <table class="table table-bordered board-table">
          <tr>
            <td colspan="2">
              <div class="d-flex align-items-center justify-content-between">
                <p class="title-icon">
                  <i class="fas fa-clipboard icon-size"></i>案内版
                </p>
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="direction">案内板</label></td>
            <td class="d-flex justify-content-between">
              <p>
                {{$reservation->board_flag==1?"有り":"無し"}}
              </p>
            </td>
          </tr>
          <!-- <tr>
            <td class="table-active"><label for="eventTime">イベント時間記載</label></td>
            <td>
              {{isset($reservation->event_start)?'有り':"無し"}}
            </td>
          </tr> -->
          <tr>
            <td class="table-active"><label for="eventStart">イベント開始時間</label></td>
            <td>
              {{isset($reservation->event_start)?$reservation->event_start:"無し"}}
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="eventFinish">イベント終了時間</label></td>
            <td>
              {{isset($reservation->event_finish)?$reservation->event_finish:"無し"}}
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="eventName1">イベント名称1</label></td>
            <td>
              {{$reservation->event_name1}}
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="eventName2">イベント名称2</label></td>
            <td>
              {{$reservation->event_name2}}
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="organizer">主催者名</label></td>
            <td>
              {{$reservation->event_owner}}
            </td>
          </tr>
        </table>
      </div>
      <!-- 左側の項目 終わり-------------------------------------------------- -->

      <!-- 右側の項目-------------------------------------------------- -->
      <div class="col-md-6 col-12">
        <table class="table table-bordered equipment-table">
          <thead class="accordion-ttl">
            <tr>
              <th colspan="2">
                <p class="title-icon fw-bolder py-1">
                  <i class="fas fa-wrench icon-size fa-fw"></i>有料備品
                </p>
              </th>
            </tr>
          </thead>
          <tbody class="accordion-wrap">
            @foreach ($venue->equipments()->get() as $equipment)
            @foreach ($reservation->bills->first()->breakdowns as $breakdown)
            @if ($equipment->item==$breakdown->unit_item)
            <tr>
              <td class="justify-content-between d-flex">
                {{$equipment->item}}({{$equipment->price}}円)×{{$breakdown->unit_count}}
              </td>
            </tr>
            @endif
            @endforeach
            @endforeach
          </tbody>
        </table>

        <table class="table table-bordered service-table">
          <thead class="accordion-ttl">
            <tr>
              <th colspan="2">
                <p class="title-icon fw-bolder py-1">
                  <i class="fas fa-hand-holding-heart icon-size fa-fw"></i>有料サービス
                </p>
              </th>
            </tr>
          </thead>
          <tbody class="accordion-wrap">
            @foreach ($venue->services()->get() as $service)
            @foreach ($reservation->bills->first()->breakdowns as $breakdown)
            @if ($service->item==$breakdown->unit_item)
            <tr>
              <td colspan="2">
                {{$service->item}}　{{$service->price}}円
              </td>
            </tr>
            @endif
            @endforeach
            @endforeach
          </tbody>
        </table>

        <div class='layouts'>
          <table class='table table-bordered' style="table-layout:fixed;">
            <thead>
              <tr>
                <th colspan='2'>
                  <p class="title-icon py-1">
                    <i class="fas fa-th icon-size fa-fw"></i>レイアウト
                  </p>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="table-active"><label for="prelayout">準備</label></td>
                <td>
                  {{!empty($reservation->bills->first()->breakdowns->where("unit_item","レイアウト準備料金"))?"有り":"無し"}}
                </td>
              </tr>
              <tr>
                <td class="table-active"><label for="postlayout">片付</label></td>
                <td>
                  {{!empty($reservation->bills->first()->breakdowns->where("unit_item","レイアウト片付料金"))?"有り":"無し"}}
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class='luggage'>
          <table class='table table-bordered' style="table-layout:fixed;">
            <thead>
              <tr>
                <th colspan='2'>
                  <p class="title-icon py-1">
                    <i class="fas fa-suitcase-rolling icon-size fa-fw"></i>お荷物預り
                  </p>
                </th>
              </tr>
            </thead>
            <tbody>
              <!-- <tr>
                <td class="table-active"><label for="Delivery"> お荷物預り/返送</label></td>
                <td>
                  @foreach ($reservation->bills->first()->breakdowns as $item)
                  @if ($item->unit_item=="荷物預り/返送")
                  有り
                  @endif
                  @endforeach
                </td>
              </tr> -->
              <tr>
                <td class="table-active"><label for="preDelivery">事前にお預りする荷物</label></td>
                <td>
                  <ul class="table-cell-box">
                    <li>
                      <p>
                        {{$reservation->luggage_count?'有り':'無し'}}
                      </p>
                    </li>
                    <li>
                      <p>
                        荷物個数：{{$reservation->luggage_count}}個
                      </p>
                    </li>

                    <li>
                      <p>事前荷物の到着日</p>
                      <p>
                        {{ReservationHelper::formatDate($reservation->luggage_arrive)}}
                      </p>
                    </li>
                  </ul>
                </td>
              </tr>
              <tr>
                <td class="table-active"><label for="postDelivery">事後返送するお荷物</label></td>
                <td>
                  <ul class="table-cell-box">
                    <li>
                      <p>
                        {{$reservation->luggage_return?'有り':'無し'}}
                      </p>
                    </li>
                    <li>
                      <p>
                        荷物個数：{{$reservation->luggage_return}}個
                      </p>
                    </li>
                  </ul>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <table class="table table-bordered eating-table">
          <tbody>
            <tr>
              <th colspan="2">
                <p class="title-icon">
                  <i class="fas fa-utensils icon-size"></i>室内飲食
                </p>
              </th>
            </tr>
            <tr>
              <td>
                {{$reservation->eat_in==1?"あり":"なし"}}
              </td>
            </tr>
            <tr>
              <td>
                {{$reservation->eat_in_prepare==1?"手配済み":"検討中"}}
              </td>
            </tr>
          </tbody>
        </table>



        <table class="table table-bordered note-table">
          <tbody>
            <tr>
              <td colspan="2">
                <p class="title-icon">
                  <i class="fas fa-file-alt icon-size" aria-hidden="true"></i>
                  備考
                </p>
              </td>
            </tr>
            <tr>
              <td>{{$reservation->remark}}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- 右側の項目 終わり-------------------------------------------------- -->
    </div>
  </section>
  <!-- 予約詳細   終わり--------------------------------------------------　 -->

  <section class="mt-5">
    <div class="bill">
      {{-- ステータス３は予約完了 --}}
      {{--@if ($reservation->bills()->first()->reservation_status>=3)--}}
      <div class="bill_head">
        <table class="table bill_table">
          <tbody>
            <tr>
              <td>
                <ul class="bill_header">
                  <li>
                    <h2 class="text-white">
                      請求書No
                    </h2>
                  </li>
                  <li>
                    <dl class="ttl_box">
                      <dd class="total_result">合計金額：
                        {{number_format($reservation->bills->first()->master_total)}}
                      </dd>
                    </dl>
                    <dl class="ttl_box">
                      <dd class="total_result">支払い期日：
                        {{(ReservationHelper::formatDate($reservation->bills->first()->payment_limit))}}

                      </dd>
                    </dl>
                    <div class="bill_btn_wrap">
                      {{ Form::open(['url' => 'admin/invoice', 'method'=>'post', 'target'=>'_blank', 'class'=>'']) }}
                      @csrf
                      {{ Form::hidden('reservation_id', $reservation->id ) }}
                      {{ Form::hidden('bill_id', $reservation->bills->first()->id ) }}
                      <p class="mr-2">{{ Form::submit('請求書をみる',['class' => 'btn more_btn']) }}</p>
                      {{ Form::close() }}
                      <!-- 工藤さん！領収書をみるボタンはステータスが入金確認後に表示------ -->
                      @if ($reservation->bills->first()->paid==1)
                      <p><a class="more_btn4" href="">領収書を見る</a></p>
                      @endif
                    </div>
                  </li>
                </ul>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="bill_details">
        <div class="head d-flex">
          <div class="accordion_btn">
            <i class="fas fa-plus bill_icon_size hide" aria-hidden="true"></i>
            <i class="fas fa-minus bill_icon_size" aria-hidden="true"></i>
          </div>
          <div class="billdetails_ttl">
            <h3>
              請求内訳
            </h3>
          </div>
        </div>
        <div class="main hide">
          <div class="venues billdetails_content">
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <td colspan="4">
                    <h4 class="billdetails_content_ttl">
                      会場料
                    </h4>
                  </td>
                </tr>
              </tbody>
              <tbody class="venue_head">
                <tr>
                  <td>内容</td>
                  <td>単価</td>
                  <td>数量</td>
                  <td>金額</td>
                </tr>
              </tbody>
              <tbody class="venue_main">
                @foreach ($reservation->bills->first()->breakdowns->where("unit_type",1) as $v)
                <tr>
                  <td>{{$v->unit_item}}</td>
                  <td>{{number_format($v->unit_cost)}}</td>
                  <td>{{$v->unit_count}}</td>
                  <td>{{number_format($v->unit_subtotal)}}</td>
                </tr>
                @endforeach
              </tbody>
              <tbody class="venue_result">
                <tr>
                  <td colspan="4">
                    <div class="result_sum">
                      <p class="text-right">合計金額：
                        {{number_format($reservation->bills->first()->venue_price)}}
                      </p>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="equipment billdetails_content">
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <td colspan="4">
                    <h4 class="billdetails_content_ttl">
                      有料備品・サービス
                    </h4>
                  </td>
                </tr>
              </tbody>
              <tbody class="equipment_head">
                <tr>
                  <td>内容</td>
                  <td>単価</td>
                  <td>数量</td>
                  <td>金額</td>
                </tr>
              </tbody>
              <tbody class="equipment_main">
                @foreach ($reservation->bills->first()->breakdowns->where("unit_type",2) as $e)
                <tr>
                  <td>{{$e->unit_item}}</td>
                  <td>{{number_format($e->unit_cost)}}</td>
                  <td>{{$e->unit_count}}</td>
                  <td>{{number_format($e->unit_subtotal)}}</td>
                </tr>
                @endforeach
                @foreach ($reservation->bills->first()->breakdowns->where("unit_type",3) as $s)
                <tr>
                  <td>{{$s->unit_item}}</td>
                  <td>{{number_format($s->unit_cost)}}</td>
                  <td>{{$s->unit_count}}</td>
                  <td>{{number_format($s->unit_subtotal)}}</td>
                </tr>
                @endforeach
              </tbody>
              <tbody class="equipment_result">
                <tr>
                  <td colspan="4">
                    <div class="result_sum">
                      <p class="text-right">合計金額：
                        {{number_format($reservation->bills->first()->equipment_price)}}
                      </p>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="layout billdetails_content">
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <td colspan="4">
                    <h4 class="billdetails_content_ttl">
                      レイアウト
                    </h4>
                  </td>
                </tr>
              </tbody>
              <tbody class="layout_head">
                <tr>
                  <td>内容</td>
                  <td>単価</td>
                  <td>数量</td>
                  <td>金額</td>
                </tr>
              </tbody>
              <tbody class="layout_main">
                @foreach ($reservation->bills->first()->breakdowns->where("unit_type",4) as $l)
                <tr>
                  <td>{{$l->unit_item}}</td>
                  <td>{{number_format($l->unit_cost)}}</td>
                  <td>{{$l->unit_count}}</td>
                  <td>{{number_format($l->unit_subtotal)}}</td>
                </tr>
                @endforeach
              </tbody>
              <tbody class="layout_result">
                <tr>
                  <td colspan="4">
                    <div class="result_sum">
                      <p class="text-right">合計金額：
                        {{number_format($reservation->bills->first()->layout_price)}}
                      </p>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="others billdetails_content">
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <td colspan="4">
                    <h4 class="billdetails_content_ttl">
                      その他
                    </h4>
                  </td>
                </tr>
              </tbody>
              <tbody class="others_head">
                <tr>
                  <td>内容</td>
                  <td>単価</td>
                  <td>数量</td>
                  <td>金額</td>
                </tr>
              </tbody>
              <tbody class="others_main">
                @foreach ($reservation->bills->first()->breakdowns->where("unit_type",5) as $o)
                <tr>
                  <td>{{$o->unit_item}}</td>
                  <td>{{$o->unit_cost}}</td>
                  <td>{{$o->unit_count}}</td>
                  <td>{{$o->unit_subtotal}}</td>
                </tr>
                @endforeach
              </tbody>
              <tbody class="others_result">
                <tr>
                  <td colspan="4">
                    <div class="result_sum">
                      <p class="text-right">合計金額：
                        {{number_format($reservation->bills->first()->others_price)}}
                      </p>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="bill_total">
            <table class="table text-right">
              <tbody>
                <tr>
                  <td>小計：</td>
                  <td>
                    {{number_format($reservation->bills->first()->master_subtotal)}}
                  </td>
                </tr>
                <tr>
                  <td>消費税：</td>
                  <td>
                    {{number_format($reservation->bills->first()->master_tax)}}
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold">合計金額</td>
                  <td>
                    {{number_format($reservation->bills->first()->master_total)}}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 追加請求セクション------------------------------------------------------------------- -->
  @foreach ($other_bills as $other_bill)
  <section class="mt-5">
    <div class="bill">
      <div class="bill_head2">
        <table class="table bill_table">
          <tbody>
            <tr>
              <td>
                <ul class="bill_header">
                  <li>
                    <h2 class="text-white">
                      請求書No
                    </h2>
                  </li>
                  <li>
                    <dl class="ttl_box">
                      <dd class="total_result">合計金額：
                        {{$other_bill->master_total}}
                        円
                      </dd>
                    </dl>
                    <dl class="ttl_box">
                      <dd class="total_result">支払い期日：
                        {{ReservationHelper::formatDate($other_bill->payment_limit)}}
                      </dd>
                    </dl>
                    <div class="bill_btn_wrap">
                      <!-- <p class="mb-2"><a class="more_btn" href="{{ url('user/home/generate_invoice/'.$reservation->id) }}">請求書を見る</a></p> -->
                      {{ Form::open(['url' => 'admin/invoice', 'method'=>'post', 'target'=>'_blank', 'class'=>'']) }}
                      @csrf
                      {{ Form::hidden('reservation_id', $reservation->id ) }}
                      {{ Form::hidden('bill_id', $other_bill->id ) }}
                      <p class="mr-2">{{ Form::submit('請求書をみる',['class' => 'btn more_btn']) }}</p>
                      {{ Form::close() }}

                      <!-- 工藤さん！領収書をみるボタンはステータスが入金確認後に表示------ -->
                      @if ($other_bill->paid==1)
                      <p><a class="more_btn4" href="">領収書を見る</a></p>
                      @endif
                    </div>
                  </li>
                </ul>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="bill_status">
        <table class="table">
          <tbody>
            <tr>
              <td>
                <ul class="d-sm-flex justify-content-between">
                  <li class="d-flex align-items-center mb-2">
                    <p class="bg-status p-2 border">予約状況</p>
                    <p class="border p-2">
                      {{ReservationHelper::judgeStatus($other_bill->reservation_status)}}
                    </p>
                  </li>
                  <li>
                    <p><span>申込日：</span>
                      {{ReservationHelper::formatDate($other_bill->created_at)}}
                    </p>
                    <p><span>予約確定日：</span>
                      {{!empty($other_bill->approve_send_at)?ReservationHelper::formatDate($other_bill->approve_send_at):""}}
                    </p>
                  </li>
                </ul>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="bill_details">
        <div class="head d-flex">
          <div class="accordion_btn">
            <i class="fas fa-plus bill_icon_size hide" aria-hidden="true"></i>
            <i class="fas fa-minus bill_icon_size" aria-hidden="true"></i>
          </div>
          <div class="billdetails_ttl">
            <h3>
              請求内訳
            </h3>
          </div>
        </div>
        <div class="main hide">
          <div class="venues billdetails_content">
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <td colspan="4">
                    <h4 class="billdetails_content_ttl">
                      会場料
                    </h4>
                  </td>
                </tr>
              </tbody>
              <tbody class="venue_head">
                <tr>
                  <td>内容</td>
                  <td>単価</td>
                  <td>数量</td>
                  <td>金額</td>
                </tr>
              </tbody>
              <tbody class="venue_main">
                @foreach ($other_bill->breakdowns->where("unit_type",1) as $o_v)
                <tr>
                  <td>{{$o_v->unit_item}}</td>
                  <td>{{number_format($o_v->unit_cost)}}</td>
                  <td>{{$o_v->unit_count}}</td>
                  <td>{{number_format($o_v->unit_subtotal)}}</td>
                </tr>
                @endforeach
              </tbody>
              <tbody class="venue_result">
                <tr>
                  <td colspan="4">
                    <div class="result_sum">
                      <p class="text-right">合計金額：
                        {{number_format($other_bill->venue_price)}}
                      </p>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="equipment billdetails_content">
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <td colspan="4">
                    <h4 class="billdetails_content_ttl">
                      有料備品・サービス
                    </h4>
                  </td>
                </tr>
              </tbody>
              <tbody class="equipment_head">
                <tr>
                  <td>内容</td>
                  <td>単価</td>
                  <td>数量</td>
                  <td>金額</td>
                </tr>
              </tbody>
              <tbody class="equipment_main">
                @foreach ($other_bill->breakdowns->where("unit_type",2) as $o_e)
                <tr>
                  <td>{{$o_e->unit_item}}</td>
                  <td>{{number_format($o_e->unit_cost)}}</td>
                  <td>{{$o_e->unit_count}}</td>
                  <td>{{number_format($o_e->unit_subtotal)}}</td>
                </tr>
                @endforeach
                @foreach ($other_bill->breakdowns->where("unit_type",3) as $o_s)
                <tr>
                  <td>{{$o_s->unit_item}}</td>
                  <td>{{number_format($o_s->unit_cost)}}</td>
                  <td>{{$o_s->unit_count}}</td>
                  <td>{{number_format($o_s->unit_subtotal)}}</td>
                </tr>
                @endforeach
              </tbody>
              <tbody class="equipment_result">
                <tr>
                  <td colspan="4">
                    <div class="result_sum">
                      <p class="text-right">合計金額：
                        {{number_format($other_bill->equipment_price)}}
                      </p>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="layout billdetails_content">
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <td colspan="4">
                    <h4 class="billdetails_content_ttl">
                      レイアウト
                    </h4>
                  </td>
                </tr>
              </tbody>
              <tbody class="layout_head">
                <tr>
                  <td>内容</td>
                  <td>単価</td>
                  <td>数量</td>
                  <td>金額</td>
                </tr>
              </tbody>
              <tbody class="layout_main">
                @foreach ($other_bill->breakdowns->where("unit_type",4) as $o_l)
                <tr>
                  <td>{{($o_l->unit_item)}}</td>
                  <td>{{number_format($o_l->unit_cost)}}</td>
                  <td>{{($o_l->unit_count)}}</td>
                  <td>{{number_format($o_l->unit_subtotal)}}</td>
                </tr>
                @endforeach
              </tbody>
              <tbody class="layout_result">
                <tr>
                  <td colspan="4">
                    <div class="result_sum">
                      <p class="text-right">合計金額：
                        {{number_format($other_bill->layout_price)}}
                      </p>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="others billdetails_content">
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <td colspan="4">
                    <h4 class="billdetails_content_ttl">
                      その他
                    </h4>
                  </td>
                </tr>
              </tbody>
              <tbody class="others_head">
                <tr>
                  <td>内容</td>
                  <td>単価</td>
                  <td>数量</td>
                  <td>金額</td>
                </tr>
              </tbody>
              <tbody class="others_main">
                @foreach ($other_bill->breakdowns->where("unit_type",4) as $o_o)
                <tr>
                  <td>{{$o_o->unit_item}}</td>
                  <td>{{number_format($o_o->unit_cost)}}</td>
                  <td>{{$o_o->unit_count}}</td>
                  <td>{{number_format($o_o->unit_subtotal)}}</td>
                </tr>
                @endforeach
              </tbody>
              <tbody class="others_result">
                <tr>
                  <td colspan="4">
                    <div class="result_sum">
                      <p class="text-right">合計金額：
                        {{number_format($other_bill->others_price)}}
                      </p>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="bill_total">
            <table class="table text-right">
              <tbody>
                <tr>
                  <td>小計：</td>
                  <td>
                    {{number_format($other_bill->master_subtotal)}}
                  </td>
                </tr>
                <tr>
                  <td>消費税：</td>
                  <td>
                    {{number_format($other_bill->master_tax)}}
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold">合計金額</td>
                  <td>
                    {{number_format($other_bill->master_total)}}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
  @endforeach




  <!-- 合計請求額------------------------------------------------------------------- -->
  <section class="master_totals mt-5">
    <table class="table border-wrap">
      <tbody class="master_total_head">
        <tr>
          <td colspan="2">
            <h3>
              合計請求額
            </h3>
          </td>
        </tr>
      </tbody>
      <tr>
        <td colspan="2" class="master_total_subttl">
          <h4>内訳</h4>
        </td>
      </tr>
      <tbody class="master_total_body">
        <tr>
          <td>会場料</td>
          <td>
            <p>{{number_format($reservation->bills()->where("reservation_status","<=",3)->pluck("venue_price")->sum())}}円</p>
          </td>
        </tr>
        <tr>
          <td>有料備品　サービス</td>
          <td>
            <p>{{number_format($reservation->bills()->where("reservation_status","<=",3)->pluck("equipment_price")->sum())}}円</p>
          </td>
        </tr>
        <tr>
          <td>レイアウト変更料</td>
          <td>
            <p>{{number_format($reservation->bills()->where("reservation_status","<=",3)->pluck("layout_price")->sum())}}円</p>
          </td>
        </tr>
        <tr>
          <td>その他</td>
          <td>
            <p>{{number_format($reservation->bills()->where("reservation_status","<=",3)->pluck("others_price")->sum())}}円</p>
          </td>
        </tr>
      </tbody>
      <tbody class="master_total_bottom">
        <tr>
          <td colspan="2">
            <div class="d-flex justify-content-end">
              <p>小計：</p>
              <p>{{number_format($reservation->bills()->where("reservation_status","<=",3)->pluck("master_subtotal")->sum())}}円</p>
            </div>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <div class="d-flex justify-content-end">
              <p>消費税：</p>
              <p>{{number_format(ReservationHelper::getTax($reservation->bills()->where("reservation_status","<=",3)->pluck("master_subtotal")->sum()))}}円</p>
            </div>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <div class="d-flex justify-content-end">
              <p>合計金額：</p>
              <p>{{number_format(ReservationHelper::taxAndPrice($reservation->bills()->where("reservation_status","<=",3)->pluck("master_subtotal")->sum()))}}円</p>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </section>

  <!-- キャンセル請求セクション------------------------------------------------------------------- -->
  @foreach ($reservation->cxls as $cxl)
  <section class="mt-5">
    <div class="bill">
      <div class="bill_head_cancel">
        <table class="table bill_table">
          <tbody>
            <tr>
              <td>
                <ul class="bill_header">
                  <li>
                    <h2 class="text-white">
                      請求書No
                    </h2>
                  </li>
                  <li>
                    <dl class="ttl_box">
                      <!-- <dt>合計金額</dt> -->
                      <dd class="total_result">合計金額：
                        {{number_format($cxl->master_total)}}
                        円
                      </dd>
                    </dl>
                    <dl class="ttl_box">
                      <!-- <dt>支払い期日</dt> -->
                      <dd class="total_result">支払い期日：
                        {{(ReservationHelper::formatDate($cxl->payment_limit))}}
                      </dd>
                    </dl>
                    <div class="bill_btn_wrap">
                      <p class="mb-2"><a class="more_btn" href="{{ url('user/home/generate_invoice/'.$reservation->id) }}">請求書を見る</a></p>
                      <!-- 工藤さん！領収書をみるボタンはステータスが入金確認後に表示------ -->
                      <p><a class="more_btn4" href="">領収書を見る</a></p>
                    </div>
                  </li>
                </ul>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="bill_status">
        <table class="table">
          <tbody>
            <tr>
              <td>
                <ul class="d-sm-flex justify-content-between">
                  <li class="d-flex align-items-center mb-2">
                    <p class="bg-status p-2 border">予約状況</p>
                    <p class="border p-2">
                      {{ReservationHelper::cxlStatus($cxl->cxl_status)}}
                    </p>
                  </li>
                  <li>
                    <p><span>申込日：</span>{{ReservationHelper::formatDate($reservation->created_at)}}</p>
                    {{-- <p><span>予約確定日：</span>工藤さん！！！！</p> --}}
                  </li>
                </ul>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="bill_details">
        <div class="head d-flex">
          <div class="accordion_btn">
            <i class="fas fa-plus bill_icon_size hide" aria-hidden="true"></i>
            <i class="fas fa-minus bill_icon_size" aria-hidden="true"></i>
          </div>
          <div class="billdetails_ttl">
            <h3>
              請求内訳
            </h3>
          </div>
        </div>
        <div class="main hide">

          <div class="billdetails_content">
            <h4 class="cancel_ttl">キャンセル料計算の内訳</h4>
            <table class="table table-borderless">
              <thead class="head_cancel">
                <tr>
                  <td>内容</td>
                  <td>申込み金額</td>
                  <td></td>
                  <td>キャンセル料率</td>
                </tr>
              </thead>
              @foreach ($cxl->cxl_breakdowns->where('unit_type',2) as $cxl_calc)
              <tr>
                <td>{{$cxl_calc->unit_item}}円</td>
                <td>{{($cxl_calc->unit_cost)}}</td>
                <td>×</td>
                <td>{{$cxl_calc->unit_count}}%</td>
              </tr>
              @endforeach
            </table>
          </div>

          <div class="billdetails_content">
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <td colspan="4">
                    <h4 class="billdetails_content_ttl">
                      キャンセル料
                    </h4>
                  </td>
                </tr>
              </tbody>
              <tbody class="venue_head">
                <tr>
                  <td>内容</td>
                  <td>単価</td>
                  <td>数量</td>
                  <td>金額</td>
                </tr>
              </tbody>
              <tbody class="venue_main">
                @foreach ($cxl->cxl_breakdowns->where('unit_type',1) as $cxl_breakdowns)
                <tr>
                  <td>{{$cxl_breakdowns->unit_item}}</td>
                  <td>{{number_format($cxl_breakdowns->unit_cost)}}</td>
                  <td>{{$cxl_breakdowns->unit_count}}</td>
                  <td>{{number_format($cxl_breakdowns->unit_subtotal)}}</td>
                </tr>
                @endforeach
              </tbody>
              <tbody class="venue_result">
                <tr>
                  <td colspan="4">
                    <div class="result_sum">
                      <p class="text-right">合計金額：{{$cxl->master_subtotal}}</p>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="bill_total">
            <table class="table text-right">
              <tbody>
                <tr>
                  <td>小計：</td>
                  <td>
                    {{number_format($cxl->master_subtotal)}}
                  </td>
                </tr>
                <tr>
                  <td>消費税：</td>
                  <td>
                    {{number_format($cxl->master_tax)}}
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold">合計金額</td>
                  <td>
                    {{number_format($cxl->master_total)}}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
  @endforeach

  <!-- 工藤さん！！キャンセル料合計請求額------------------------------------------------------------------- -->
  <div class="master_totals_cancel">
    <table class="table mb-0">
      <tbody class="master_total_head2">
        <tr>
          <td colspan="2">
            <h3>
              キャンセル料　合計請求額
            </h3>
          </td>
        </tr>
      </tbody>
      <tr>
        <td colspan="2" class="master_total_subttl2">
          <h4>内訳</h4>
        </td>
      </tr>
      <tbody class="master_total_body">
        <tr>
          <td>キャンセル料</td>
          <td><p>
            {{number_format($reservation->cxls->pluck("master_subtotal")->sum())}}
            円</p></td>
        </tr>
      </tbody>
      <tbody class="master_total_bottom mb-0">
        <tr>
          <td></td>
          <td>
            <div class="d-flex justify-content-end" colspan="2">
              <p>小計：</p>
              <p>
                {{number_format($reservation->cxls->pluck("master_subtotal")->sum())}}
                円</p>
            </div>
          </td>
        </tr>
        <tr>
          <td></td>
          <td>
            <div class="d-flex justify-content-end" colspan="2">
              <p>消費税：</p>
              <p>
                {{number_format(ReservationHelper::getTax($reservation->cxls->pluck("master_subtotal")->sum()))}}
                円</p>
            </div>
          </td>
        </tr>
        <tr>
          <td></td>
          <td>
            <div class="d-flex justify-content-end" colspan="2">
              <p>合計金額：</p>
              <p>
                {{number_format(ReservationHelper::taxAndPrice($reservation->cxls->pluck("master_subtotal")->sum()))}}
                円</p>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div> 
</section>


<!-- ステータスが予約承認まちのときに表示 -->

@if ($reservation->bills->first()->reservation_status==2)
<div class="confirm-box text-center mt-5">
  <p>上記、予約内容で間違いないでしょうか。問題なければ、予約の承認をお願い致します。</p>
  <p class="text-center mt-3">
    {{ Form::model($reservation, ['method'=>'PUT', 'route'=> ['user.home.updatestatus',$reservation->id],'class'=>"text-center"])}}
    @csrf
    {{ Form::hidden('update_status',3,) }}

    {{ Form::submit('予約を承認する',['class' => 'btn more_btn4_lg']) }}
    {{ Form::close() }}
  </p>
  <p class="notion">※ご要望に相違がある場合は、下記連絡先までご連絡ください。<br>
    TEL：06-1234-5678<br>
    mail：test@gmail.com</p>
</div>
@endif


<!-- ステータスが予約完了のときに表示 -->
@if ($reservation->bills->first()->reservation_status>2)
<div class="confirm-box mt-5">
  <h3 class="caution_color mb-2 font-weight-bold">振込先案内</h3>
  <p class="p-3 border-wrap2 mb-2">
    みずほ銀行　四ツ橋支店　普通　1113739　ｶ)ｴｽｴﾑｼﾞｰ</p>
  <p>
    ※該当日が土日祝の場合は直前の平日にお振込み下さい。<br>
    ※振込み手数料はお客様負担となります。<br>
    ※請求書・領収書は原則として発行しておりません。各金融機関発行の振込明細票が領収書扱いとなります。<br>
    <span class="caution_color">※申込時の「申込者」欄記載の名義でお振込み下さい。別名義でのお振込みの場合は必ず事前にSMGまでご連絡下さい。</span><br>
    ※お振込み後に追加料金が発生した場合は、追加でお振込み願います。
  </p>
</div>
@endif

<!-- 工藤さん！！！！追加請求のステータスが予約承認まちのときに表示 -->
<!-- <div class="confirm-box text-center mt-5">
  <p>上記、追加請求の内容で間違いないでしょうか。問題なければ、予約の承認をお願い致します。</p>
  <p class="text-center mt-3">
  <input class="btn more_btn4_lg" type="submit" value="追加請求の内容を承認する">
  </p>
  <p class="notion">※ご要望に相違がある場合は、下記連絡先までご連絡ください。<br>
    TEL：06-1234-5678<br>
    mail：test@gmail.com</p>
</div> -->



<!-- 工藤さん！！キャンセルが承認まちの時に表示です！！！ -->
@if ($reservation->cxls->pluck("cxl_status")->contains(1))
<div class="confirm-box text-center mt-5">
  <p>上記、予約内容をキャンセルしてもよろしいでしょうか。問題なければ、承認をお願い致します。</p>
  <p class="text-center mt-3">
    @foreach ($reservation->cxls->where("cxl_status",1) as $cfm_selected_cxl)

    {{ Form::open(['url' => "user/home/cfm_cxl", 'method'=>'post', 'class'=>'']) }}
    @csrf
    {{ Form::hidden('cxl_id', $cfm_selected_cxl->id)}}
    {{ Form::submit('キャンセルを承認する',['class' => 'btn more_btn4_lg']) }}
    {{ Form::close() }}
    @endforeach
  </p>
  <p class="notion">※ご要望に相違がある場合は、下記連絡先までご連絡ください。<br>
    TEL：06-1234-5678<br>
    mail：test@gmail.com</p>
</div>
@endif


<div class="btn_wrapper">
  <p class="text-center"><a class="more_btn_lg" href="">予約一覧へもどる</a></p>
</div>

@endsection