@extends('layouts.user.app')
@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
{{--<script src="{{ asset('/js/ajax.js') }}"></script> --}}


<div class="content">
  <div class="container-fluid">
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
    @if ($reservation->bills()->first()->reservation_status==2)
    <div class="confirm-box text-center">
      <p>下記、予約内容で承認される場合は、承認ボタンを押してください。</p>
      <p>※承認ボタンは、画面一番下にあります。</p>
    </div>
    @endif

    <!-- 予約詳細--------------------------------------------------------　 -->
    <div class="section-wrap">
      <table class="table ttl_head mb-0">
        <tbody>
          <tr>
            <td>
              <h3 class="text-white">
                予約概要
              </h3>
            </td>
            <td>
              <dl class="ttl_box">
                <dt>予約ID：</dt>
                <dd class="total_result">{{ReservationHelper::fixId($reservation->id)}}</dd>
              </dl>
            </td>
            <td>
              <dl class="ttl_box">
                <dt>予約一括ID</dt>
                <dd class="total_result">ダミー</dd>
              </dl>
            </td>
        </tbody>
      </table>
      <section class="border-wrap2 p-4">
        <div class="bill_status">
          <table class="table">
            <tbody>
              <tr>
                <td>
                  <div class="d-flex">
                    <p class="bg-status p-2">予約状況</p>
                    <p class="border p-2">
                      {{ReservationHelper::judgeStatus($reservation->bills()->first()->reservation_status)}}
                    </p>
                  </div>
                </td>
                <td class="text-right">
                  <div><span>申込日：</span>{{ReservationHelper::formatDate($reservation->created_at)}}</div>
                  <div><span>予約確定日：</span>※2020/10/15(木)</div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="row">
          <!-- 左側の項目------------------------------------------------------------------------ -->
          <div class="col-6">
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
                      {{ReservationHelper::getVenue($reservation->venue_id)}}
                    </p>
                    <p>{{ReservationHelper::priceSystem($reservation->price_system)}}</p>

                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="start">入室時間</label></td>
                  <td>
                    {{$reservation->enter_time}}
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="finish">退室時間</label></td>
                  <td>
                    {{$reservation->leave_time}}
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
                    {{$reservation->board_flag}}
                  </p>
                </td>
              </tr>
              <tr>
                <td class="table-active"><label for="eventTime">イベント時間記載</label></td>
                <td>
                  {{isset($reservation->event_start)?'有り':"無し"}}
                </td>
              </tr>
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
          <div class="col-6">
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
                @foreach ($reservation->bills()->first()->breakdowns()->get() as $breakdown)
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
                @foreach ($reservation->bills()->first()->breakdowns()->get() as $breakdown)
                @if ($service->item==$breakdown->unit_item)
                <tr>
                  <td colspan="2">
                    {{$service->item}}　{{$service->price}}円
                  </td>
                </tr>
                @endif
                @endforeach
                @endforeach
                <!-- <tr>
                  <td class="table-active"><label for="layout">レイアウト変更</label></td>
                  <td>
                    @foreach ($reservation->bills()->first()->get() as $layout)
                    {{$layout->layout_total?'有り':'無し'}}
                    @endforeach
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="prelayout">レイアウト準備</label></td>
                  <td>
                    @foreach ($reservation->bills()->first()->breakdowns()->get() as $item)
                    @if ($item->unit_item=="レイアウト準備")
                    有り
                    @endif
                    @endforeach
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="postlayout">レイアウト片付</label></td>
                  <td>
                    @foreach ($reservation->bills()->first()->breakdowns()->get() as $item)
                    @if ($item->unit_item=="レイアウト片付")
                    有り
                    @endif
                    @endforeach
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="Delivery">荷物預り/返送</label></td>
                  <td>
                    @foreach ($reservation->bills()->first()->breakdowns()->get() as $item)
                    @if ($item->unit_item=="荷物預り/返送")
                    有り
                    @endif
                    @endforeach
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="preDelivery">事前に預かる荷物</label></td>
                  <td>
                    <ul class="table-cell-box">
                      <li>
                        <p>
                          {{$reservation->luggage_count?'有り':'無し'}}
                        </p>
                      </li>
                      <li class="d-flex justify-content-between">
                        <p>荷物個数</p>
                        <p>
                          {{$reservation->luggage_count}}個
                        </p>
                      </li>
                      <li class="d-flex justify-content-between">
                        <p>事前荷物の到着日</p>
                        <p>{{$reservation->luggage_arrive}}</p>
                      </li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="postDelivery">事後返送する荷物</label></td>
                  <td>
                    <ul class="table-cell-box">
                      <li>
                        <p>
                          {{$reservation->luggage_return?'有り':'無し'}}
                        </p>
                      </li>
                      <li class="d-flex justify-content-between">
                        <p>荷物個数</p>
                        <p>{{$reservation->luggage_return}}個</p>
                      </li>
                    </ul>
                  </td>
                </tr> -->
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
                  <!-- <tr>
                    <td class="table-active"><label for="layout">レイアウト変更</label></td>
                    <td>
                      @foreach ($reservation->bills()->first()->get() as $layout)
                      {{$layout->layout_total?'有り':'無し'}}
                      @endforeach
                    </td>
                  </tr> -->
                  <tr>
                    <td class="table-active"><label for="prelayout">準備</label></td>
                    <td>
                      @foreach ($reservation->bills()->first()->breakdowns()->get() as $item)
                      @if ($item->unit_item=="レイアウト準備")
                      有り
                      @endif
                      @endforeach
                    </td>
                  </tr>
                  <tr>
                    <td class="table-active"><label for="postlayout">片付</label></td>
                    <td>
                      @foreach ($reservation->bills()->first()->breakdowns()->get() as $item)
                      @if ($item->unit_item=="レイアウト片付")
                      有り
                      @endif
                      @endforeach
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
                  <tr>
                    <td class="table-active"><label for="Delivery"> お荷物預り/返送</label></td>
                    <td>
                      @foreach ($reservation->bills()->first()->breakdowns()->get() as $item)
                      @if ($item->unit_item=="荷物預り/返送")
                      有り
                      @endif
                      @endforeach
                    </td>
                  </tr>
                  <tr>
                    <td class="table-active"><label for="preDelivery">事前にお預りする荷物</label></td>
                    <td>
                      <ul class="table-cell-box">
                        <li>
                          <p>
                            {{$reservation->luggage_count?'有り':'無し'}}
                          </p>
                        </li>
                        <li class="d-flex justify-content-between">
                          <p>荷物個数</p>
                          <p>
                            {{$reservation->luggage_count}}個
                          </p>
                        </li>

                        <li class="d-flex justify-content-between">
                          <p>事前荷物の到着日</p>
                          <p>
                            {{$reservation->luggage_arrive}}
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
                        <li class="d-flex justify-content-between">
                          <p>荷物個数</p>
                          <p>
                            {{$reservation->luggage_return}}個
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
                  <td>
                    <p class="title-icon">室内飲食</p>
                  </td>
                </tr>
                <tr>
                  <td>
                    なし
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
              </tbody>
            </table>
          </div>
          <!-- 右側の項目 終わり-------------------------------------------------- -->
        </div>



      </section>
      <!-- 予約詳細   終わり--------------------------------------------------　 -->

      <!-- 請求セクション　静的ページ --工藤さんPHPの実装をお願いします---------------------------------------------------------------- -->
      <section class="mt-5">
        <div class="bill">
          {{-- ステータス３は予約完了 --}}
          <!-- @if ($reservation->bills()->first()->reservation_status>=3) -->
          <div class="bill_head">
            <table class="table bill_table">
              <tbody>
                <tr>
                  <td>
                    <h2 class="text-white">
                      請求書No
                    </h2>
                  </td>
                  <td>
                    <dl class="ttl_box">
                      <dt>合計金額</dt>
                      <dd class="total_result">ダミー円</dd>
                    </dl>
                  </td>
                  <td>
                    <dl class="ttl_box">
                      <dt>支払い期日</dt>
                      <dd class="total_result">ダミー</dd>
                    </dl>
                  </td>
                  <td class="text-right">
                    <a class="mr-1 more_btn" href="{{ url('user/home/generate_invoice/'.$reservation->id) }}">請求書を見る</a>
                    <!-- @if ($reservation->bills()->first()->paid==1) -->
                    <!-- ステータスが入金確認後に表示------ -->
                    <a class="more_btn" href="">領収書をみる</a>
                    <!-- @endif -->
                  </td>
                </tr>
              </tbody>
            </table>
            <!-- @endif -->
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
                <table class="table table-borderless">
                  <tbody>
                    <tr>
                      <td>
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
                    <tr>
                      <td>会場料金</td>
                      <td>36,000</td>
                      <td>4</td>
                      <td>36,000</td>
                    </tr>
                  </tbody>
                  <tbody class="venue_result">
                    <tr>
                      <td colspan="2"></td>
                      <td colspan="1">合計：</td>
                      <td colspan="1" class=""> 36,000</td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="equipment billdetails_content">
                <table class="table table-borderless">
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
                    <tr>
                      <td>無線マイク</td>
                      <td>3,000</td>
                      <td>1</td>
                      <td>3,000</td>
                    </tr>
                    <tr>
                      <td>次亜塩素酸水専用・超音波加湿器＋スプレーボトル</td>
                      <td>1,000</td>
                      <td>1</td>
                      <td>1,000</td>
                    </tr>
                  </tbody>
                  <tbody class="equipment_result">
                    <tr>
                      <td colspan="2"></td>
                      <td colspan="1">合計：</td>
                      <td colspan="1" class=""> 8,500</td>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="layout billdetails_content">
                <table class="table table-borderless">
                  <tbody>
                    <tr>
                      <td>
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
                    <tr>
                      <td>レイアウト準備料金</td>
                      <td>5,000</td>
                      <td>1</td>
                      <td>5,000</td>
                    </tr>
                    <tr>
                      <td>レイアウト片付料金</td>
                      <td>8,000</td>
                      <td>1</td>
                      <td>8,000</td>
                    </tr>
                  </tbody>
                  <tbody class="layout_result">
                    <tr>
                      <td colspan="1"></td>
                      <td colspan="1">合計：</td>
                      <td colspan="2">合計：13,000
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="others billdetails_content">
                <table class="table table-borderless">
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
                    <tr>
                      <td>ダミーダミーダミー</td>
                      <td>ダミーダミーダミー</td>
                      <td>ダミーダミーダミー</td>
                      <td>ダミーダミーダミー</td>
                    </tr>
                  </tbody>
                  <tbody class="others_result">
                    <tr>
                      <td colspan="2"></td>
                      <td colspan="1"></td>
                      <td colspan="2">合計：ダミー
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="bill_total">
                <div>
                  <table class="table text-right">
                    <tbody>
                      <tr>
                        <td>小計：</td>
                        <td>
                          57,500
                        </td>
                      </tr>
                      <tr>
                        <td>消費税：</td>
                        <td>
                          5,750
                        </td>
                      </tr>
                      <tr>
                        <td class="font-weight-bold">合計金額</td>
                        <td>
                          63,250
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- 追加請求セクション------------------------------------------------------------------- -->
      <section class="mt-5">
        <div class="bill">
          <div class="bill_head2">
            <table class="table bill_table">
              <tbody>
                <tr>
                  <td>
                    <h2 class="text-white">
                      請求書No
                    </h2>
                  </td>
                  <td>
                    <dl class="ttl_box">
                      <dt>合計金額</dt>
                      <dd class="total_result">ダミー円</dd>
                    </dl>
                  </td>
                  <td>
                    <dl class="ttl_box">
                      <dt>支払い期日</dt>
                      <dd class="total_result">ダミー</dd>
                    </dl>
                  </td>
                  <td class="text-right">
                    <a class="mr-1 more_btn" href="{{ url('user/home/generate_invoice/'.$reservation->id) }}">請求書を見る</a>
                    @if ($reservation->bills()->first()->paid==1)
                    <!-- ステータスが入金確認後に表示------ -->
                    <a class="more_btn" href="">領収書をみる</a>
                    @endif
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
                    <div class="d-flex">
                      <p class="bg-status p-2">予約状況</p>
                      <p class="border p-2">
                        {{ReservationHelper::judgeStatus($reservation->bills()->first()->reservation_status)}}
                      </p>
                    </div>
                  </td>
                  <td class="text-right">
                    <div><span>申込日：</span>{{ReservationHelper::formatDate($reservation->created_at)}}</div>
                    <div><span>予約確定日：</span>※2020/10/15(木)</div>
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
                <table class="table table-borderless">
                  <tbody>
                    <tr>
                      <td>
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
                    <tr>
                      <td>会場料金</td>
                      <td>36,000</td>
                      <td>4</td>
                      <td>36,000</td>
                    </tr>
                  </tbody>
                  <tbody class="venue_result">
                    <tr>
                      <td colspan="2"></td>
                      <td colspan="1">合計：</td>
                      <td colspan="1" class=""> 36,000</td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="equipment billdetails_content">
                <table class="table table-borderless">
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
                    <tr>
                      <td>無線マイク</td>
                      <td>3,000</td>
                      <td>1</td>
                      <td>3,000</td>
                    </tr>
                    <tr>
                      <td>次亜塩素酸水専用・超音波加湿器＋スプレーボトル</td>
                      <td>1,000</td>
                      <td>1</td>
                      <td>1,000</td>
                    </tr>
                  </tbody>
                  <tbody class="equipment_result">
                    <tr>
                      <td colspan="2"></td>
                      <td colspan="1">合計：</td>
                      <td colspan="1" class=""> 8,500</td>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="layout billdetails_content">
                <table class="table table-borderless">
                  <tbody>
                    <tr>
                      <td>
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
                    <tr>
                      <td>レイアウト準備料金</td>
                      <td>5,000</td>
                      <td>1</td>
                      <td>5,000</td>
                    </tr>
                    <tr>
                      <td>レイアウト片付料金</td>
                      <td>8,000</td>
                      <td>1</td>
                      <td>8,000</td>
                    </tr>
                  </tbody>
                  <tbody class="layout_result">
                    <tr>
                      <td colspan="1"></td>
                      <td colspan="1">合計：</td>
                      <td colspan="2">合計：13,000
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="others billdetails_content">
                <table class="table table-borderless">
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
                    <tr>
                      <td>ダミーダミーダミー</td>
                      <td>ダミーダミーダミー</td>
                      <td>ダミーダミーダミー</td>
                      <td>ダミーダミーダミー</td>
                    </tr>
                  </tbody>
                  <tbody class="others_result">
                    <tr>
                      <td colspan="2"></td>
                      <td colspan="1"></td>
                      <td colspan="2">合計：ダミー
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="bill_total">
                <div>
                  <table class="table text-right">
                    <tbody>
                      <tr>
                        <td>小計：</td>
                        <td>
                          57,500
                        </td>
                      </tr>
                      <tr>
                        <td>消費税：</td>
                        <td>
                          5,750
                        </td>
                      </tr>
                      <tr>
                        <td class="font-weight-bold">合計金額</td>
                        <td>
                          63,250
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <!-- 合計請求額------------------------------------------------------------------- -->
    <section class="master_totals section-wrap ">
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
            <td>・会場料</td>
            <td>ダミーダミーダミーダミー円</td>
          </tr>
          <tr>
            <td>・有料備品　サービス</td>
            <td>ダミーダミーダミーダミー円</td>
          </tr>
          <tr>
            <td>・レイアウト変更料</td>
            <td>ダミーダミーダミーダミー円</td>
          </tr>
          <tr>
            <td>・その他</td>
            <td>ダミーダミーダミーダミー円</td>
          </tr>
        </tbody>
        <tbody class="master_total_bottom">
          <tr>
            <td></td>
            <td class="d-flex justify-content-end" colspan="2">
              <p>小計：</p>
              <p>ダミーダミーダミーダミー円</p>
            </td>
          </tr>
          <tr>
            <td></td>
            <td class="d-flex justify-content-end" colspan="2">
              <p>消費税：</p>
              <p>ダミーダミーダミーダミー円</p>
            </td>
          </tr>
          <tr>
            <td></td>
            <td class="d-flex justify-content-end" colspan="2">
              <p>合計金額：</p>
              <p>ダミーダミーダミーダミー円</p>
            </td>
          </tr>
        </tbody>
      </table>
    </section>

    <!-- ステータスが予約承認まちのときに表示 -->

    @if ($reservation->bills()->first()->reservation_status==2)
    <div class="confirm-box text-center">
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
    @if ($reservation->bills()->first()->reservation_status>2)
    <div class="confirm-box">
      <h3 class="caution_color mb-2 font-weight-bold">振込先案内</h3>
      <p class="p-3 border-wrap2">
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

    <div class="btn_wrapper">
      <p class="text-center"><a class="more_btn_lg" href="">予約一覧へもどる</a></p>
    </div>

  </div>
</div>
@endsection


<!-- 請求セクション元データ-------------------------------------------------------------------
<section class="bill-wrap section-wrap section-bg">
  <div class="bill-bg">

    {{-- ステータス３は予約完了 --}}
    @if ($reservation->bills()->first()->reservation_status>=3)
    <div class="bill-ttl mb-5">
      <div class="section-ttl-box d-flex align-items-center">
        <div class="col-6">
          <h3 class="">請求情報</h3>
        </div>
        <div class="col-6 d-flex justify-content-end">
          <p class="text-right">
            {{-- <a class="more_btn" href="{{url('user.home.generate_invoice')}}">請求書をみる</a> --}}
            <a href="{{ url('user/home/generate_invoice/'.$reservation->id) }}" class="more_btn">請求書を見る</a>

          </p>
          @if ($reservation->bills()->first()->paid==1)
          <p class="text-right ml-3"><a class="more_btn" href="">領収書をみる</a></p>
          @endif
        </div>
      </div>
      <dl class="row bill-box_wrap">
        <div class="col-4 bill-box_cell">
          <dt><label for="billCompany">請求No</label></dt>
          <dd>2020092225</dd>
        </div>
        <div class="col-4 bill-box_cell">
          <dt><label for="billCustomer">請求日</label></dt>
          <dd>2020/09/02</dd>
        </div>
        <div class="col-4 bill-box_cell">
          <dt><label for="billDate">支払期日</label></dt>
          <dd>2020/12/10(木)</dd>
        </div>
      </dl>
    </div>
    @endif
    <div class="bill-box">
      <h3 class="row">会場料</h3>
      <dl class="row bill-box_wrap">
        <div class="col-3 bill-box_cell">
          <dt>会場料金</dt>
          <dd>
            @foreach ($reservation->bills()->first()->breakdowns as $breakdowns)
            @if ($breakdowns->unit_item=="会場料金")
            {{$breakdowns->unit_cost}}
            @endif
            @endforeach
          </dd>
        </div>
        <div class="col-3 bill-box_cell">
          <dt>延長料金</dt>
          <dd>
            @foreach ($reservation->bills()->first()->breakdowns as $breakdowns)
            @if ($breakdowns->unit_item=="延長料金")
            {{$breakdowns->unit_cost}}
            @endif
            @endforeach
          </dd>
        </div>
        <div class="col-6 bill-box_cell">
          <dt>会場料金合計</dt>
          <dd class="text-right">
            {{$reservation->bills()->first()->venue_total}}
          </dd>
        </div>
      </dl>
      <div class="bill-list">
        <h3 class="row">料金内訳</h3>
        <div class="col-12 venue_price_details">
          <table class="table table-bordered">
            <thead>
              <tr>
                <td>内容</td>
                <td>単価</td>
                <td>数量</td>
                <td>金額</td>
              </tr>
            </thead>
            <tbody>
              @foreach ($reservation->bills()->first()->breakdowns as $breakdown)
              @if ($breakdown->unit_type==1)
              <tr>
                <td>{{$breakdown->unit_item}}</td>
                <td>{{$breakdown->unit_cost}}</td>
                <td>{{$breakdown->unit_count}}</td>
                <td>{{$breakdown->unit_subtotal}}</td>
              </tr>
              @endif
              @endforeach
            </tbody>
          </table>
        </div>

        <div class="row bill-box_wrap price-sum bill-box_cell flex-column">
          <p class="text-right">
            <span class="font-weight-bold">小計</span>
            {{$reservation->bills()->first()->discount_venue_total}}
          </p>
          <p class="text-right">
            <span>消費税</span>
            {{ReservationHelper::getTax($reservation->bills()->first()->discount_venue_total)}}
          </p>
          <p class="text-right">
            <span class="font-weight-bold">合計金額</span>
            {{ReservationHelper::taxAndPrice($reservation->bills()->first()->discount_venue_total)}}
          </p>
        </div>
      </div>
    </div>
    <div class="bill-box">
      <h3 class="row">備品その他</h3>
      <dl class="row bill-box_wrap">
        <div class="col-3 bill-box_cell">
          <dt>有料備品料金</dt>
          <dd>
            {{$reservation->bills()->first()->equipment_total}}
            円
          </dd>
        </div>
        <div class="col-3 bill-box_cell">
          <dt>有料サービス料金</dt>
          <dd>
            {{$reservation->bills()->first()->service_total}}
            円
          </dd>
        </div>
        <div class="col-3 bill-box_cell">
          <dt>荷物預り/返送</dt>
          <dd class="d-flex align-items-center">
            {{$reservation->bills()->first()->luggage_total}}
            円
          </dd>
        </div>
        <div class="col-3 bill-box_cell">
          <dt>備品その他合計</dt>
          <dd class="text-right">
            {{$reservation->bills()->first()->equipment_service_total}}
          </dd>
        </div>
      </dl>
      <div class="bill-list">
        <h3 class="row">料金内訳</h3>
        <div class="col-12 items_equipments">
          <table class="table table-bordered">
            <thead>
              <tr>
                <td>内容</td>
                <td>単価</td>
                <td>数量</td>
                <td>金額</td>
              </tr>
            </thead>
            <tbody>
              @foreach ($reservation->bills()->first()->breakdowns as $breakdown)
              @if ($breakdown->unit_type==2)
              <tr>
                <td>{{$breakdown->unit_item}}</td>
                <td>{{$breakdown->unit_cost}}</td>
                <td>{{$breakdown->unit_count}}</td>
                <td>{{$breakdown->unit_subtotal}}</td>
              </tr>
              @endif
              @endforeach
            </tbody>
          </table>
        </div>

        <div class="row bill-box_wrap price-sum bill-box_cell flex-column">
          <p class="text-right">
            <span class="font-weight-bold">小計</span>
            {{$reservation->bills()->first()->discount_equipment_service_total}}
          </p>
          <p class="text-right">
            <span>消費税</span>
            {{ReservationHelper::getTax($reservation->bills()->first()->discount_equipment_service_total)}}
          </p>
          <p class="text-right">
            <span class="font-weight-bold">合計金額</span>
            {{ReservationHelper::taxAndPrice($reservation->bills()->first()->discount_equipment_service_total)}}
          </p>
        </div>
      </div>

    </div>
    <div class="bill-box layout_price_list">
      <h3 class="row">レイアウト変更</h3>
      <dl class="row bill-box_wrap">
        <div class="col-4 bill-box_cell">
          <dt>レイアウト準備料金</dt>
          <dd>
            <p class="layout_prepare_result">

            </p>
          </dd>
        </div>
        <div class="col-4 bill-box_cell">
          <dt>レイアウト片付料金</dt>
          <dd>
            <p class="layout_clean_result"></p>
          </dd>
        </div>
        <div class="col-4 bill-box_cell">
          <dt>レイアウト変更合計</dt>
          <dd class="text-right">
            <p class="layout_total"></p>
          </dd>
        </div>
      </dl>
      <div class="bill-list">
        <h3 class="row">料金内訳</h3>
        <div class="col-12 items_equipments">
          <table class="table table-bordered">
            <thead>
              <tr>
                <td>内容</td>
                <td>単価</td>
                <td>数量</td>
                <td>金額</td>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>

        <div class="row bill-box_wrap price-sum bill-box_cell flex-column">
          <p class="text-right"><span class="font-weight-bold">小計</span>7,200円</p>
          <p class="text-right"><span>消費税</span>720円</p>
          <p class="text-right"><span class="font-weight-bold">合計金額</span>7,200円</p>
        </div>
      </div>
    </div>
  </div>
</section> -->


<!-- 追加請求元データ
@foreach ($other_bills as $key=>$other_bill)
    <div class="section-wrap">
      <div class="ttl-box d-flex align-items-center">
        <div class="col-9 d-flex justify-content-between">
          <h2>
            @if ($other_bill->category==2)
            その他の有料備品、サービス
            @elseif($other_bill->category==3)
            レイアウト
            @elseif($other_bill->category==4)
            その他
            @endif
          </h2>
        </div>
      </div>
      <section class="register-wrap">
        <div class="section-header">
          <div class="row">
            <div class="d-flex col-10 flex-wrap">
              <dl>
                <dt>予約状況</dt>
                <dd>{{ReservationHelper::judgeStatus($other_bill->reservation_status)}}</dd>
              </dl>
            </div>
            <div class="col-2">
              <p>
                申込日：2020/10/15(木)
              </p>
              <p>
                予約確定日：2020/10/15(木)
              </p>
            </div>
          </div>
        </div>
        <section class="section-wrap section-bg">
          <div class="bill-ttl mb-5">
            <div class="section-ttl-box d-flex align-items-center">
              <div class="col-6">
                <h3 class="">請求情報</h3>
              </div>
              <div class="col-6 d-flex justify-content-end">
                <p class="text-right"><a class="more_btn" href="">請求書をみる</a></p>
                <p class="text-right ml-3"><a class="more_btn" href="">領収書をみる</a></p>
              </div>
            </div>
            <dl class="row bill-box_wrap">
              <div class="col-4 bill-box_cell">
                <dt><label for="billCompany">請求No</label></dt>
                <dd>2020092225</dd>
              </div>
              <div class="col-4 bill-box_cell">
                <dt><label for="billCustomer">請求日</label></dt>
                <dd>2020/09/02</dd>
              </div>
              <div class="col-4 bill-box_cell">
                <dt><label for="billDate">支払期日</label></dt>
                <dd>2020/12/10(木)</dd>
              </div>
            </dl>
          </div>
          <div class="bill-box">
            <h3 class="row">その他の有料備品、サービス</h3>
            <dl class="row bill-box_wrap">
              <div class="col-12 bill-box_cell">
                <dt>その他の有料備品、サービス合計</dt>
                <dd class="text-right">57,700円</dd>
              </div>
              <div class="col-6">
                <div class="row">
                  <div class="col-4 bill-box_cell cell-gray">
                    <p>割引率</p>
                  </div>
                  <div class="col-5 bill-box_cell">
                    <p class="text-right"></p>
                  </div>
                  <div class="col-3 bill-box_cell text-right">
                    <p>割引金額</p>
                    <p class=""><span>円</span></p>
                  </div>
                </div>
              </div>
              <div class="col-6 bill-box_cell text-right">
                <p class="font-weight-bold">割引後その他の有料備品、サービス合計</p>
                <p class=""></p>
              </div>
            </dl>
            <div class="bill-list">
              <h3 class="row">料金内訳</h3>
              <div class="col-12 venue_price_details">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <td>内容</td>
                      <td>単価</td>
                      <td>数量</td>
                      <td>金額</td>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
              <div class="row bill-box_wrap price-sum bill-box_cell flex-column">
                <p class="text-right"><span class="font-weight-bold">小計</span>7,200円</p>
                <p class="text-right"><span>消費税</span>720円</p>
                <p class="text-right"><span class="font-weight-bold">合計金額</span>7,200円</p>
              </div>
            </div>
          </div>
        </section>

        {{-- 承認部分 --}}
        @if ($other_bill->reservation_status==2)
        <div class="confirm-box">
          <p>上記、予約内容で間違いないでしょうか。問題なければ、予約の承認をお願い致します。</p>
          <p class="text-center mb-5 mt-3">
            {{ Form::open(['url' => '/user/home/'.$other_bill->id.'/update_other_bills', 'method'=>'PUT', 'id'=>'agents_create_form']) }}
            @csrf
            {{ Form::hidden('update_status',3) }}
            {{ Form::hidden('bill_id',$other_bill->id) }}

            {{ Form::submit('予約を承認する',['class' => 'btn more_btn4_lg']) }}
            {{ Form::close() }}
          </p>
          <p>※ご要望に相違がある場合は、下記連絡先までご連絡ください。<br>
            TEL：06-1234-5678<br>
            mail：test@gmail.com</p>
        </div>
        @endif
    </div>
    @endforeach -->