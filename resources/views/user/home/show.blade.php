@extends('layouts.user.app')
@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
{{-- <script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/ajax.js') }}"></script> --}}


<div class="content">
  <div class="container-fluid">


    <div class="container-field mt-3">
      <div class="float-right">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="http://staging-smg2.herokuapp.com/admin/home">ホーム</a> &gt;
              予約一覧
            </li>
          </ol>
        </nav>
      </div>
      <h1 class="mt-3 mb-5">予約一覧</h1>
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

      <div class="ttl-box d-flex">
        <div class="col-9 d-flex">
          <h2>予約概要</h2>
          <p class="ml-3">予約ID:{{$reservation->id}}</p>
          <p class="ml-3">予約一括ID:00001</p>
        </div>

      </div>
      <section class="register-wrap">

        <div class="section-header">
          <div class="row">
            <div class="d-flex col-10 flex-wrap">
              <dl>
                <dt>予約状況</dt>
                <dd>{{ReservationHelper::judgeStatus($reservation->bills()->first()->reservation_status)}}</dd>
              </dl>

            </div>

            <div class="col-2">
              <p>
                申込日：{{ReservationHelper::formatDate($reservation->created_at)}}
              </p>
              <p>
                予約確定日：※2020/10/15(木)
              </p>
            </div>
          </div>
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
                  <td class="table-active"><label for="date">利用日</label></td>
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
                <tr>
                  <td class="table-active"><label for="direction">案内板</label></td>
                  <td class="d-flex justify-content-between">
                    <p>
                      {{$reservation->board_flag}}
                    </p>
                    <p><a class="more_btn" href="">案内板出力(PDF)</a></p>
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
              </tbody>
            </table>

            <div class="customer-table">
              <table class="table table-bordered oneday-table">
                <tbody>
                  <tr>
                    <td colspan="2">
                      <p class="title-icon">
                        <i class="fas fa-user icon-size" aria-hidden="true"></i>
                        当日の連絡できる担当者
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


          </div>
          <!-- 左側の項目 終わり-------------------------------------------------- -->


          <!-- 右側の項目-------------------------------------------------- -->
          <script>
            $(function() {
              $('thead').on('click', function() {
                $(this).parent().find('tbody').toggleClass('hide');
              });
            })
          </script>
          <div class="col-6">
            <table class="table table-bordered equipment-table">
              <thead class="accordion-ttl">
                <tr>
                  <td colspan="2">
                    <p class="title-icon">有料備品</p>
                  </td>
                </tr>
              </thead>
              <tbody class="accordion-wrap hide">
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
                  <td colspan="2">
                    <p class="title-icon">有料サービス<span class="open_toggle"></span></p>
                  </td>
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
                <tr>
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
                  <td class="table-active"><label for="Delivery">荷物預かり/返送</label></td>
                  <td>
                    @foreach ($reservation->bills()->first()->breakdowns()->get() as $item)
                    @if ($item->unit_item=="荷物預かり/返送")
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
                </tr>
              </tbody>
            </table>

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

        <!-- 請求セクション------------------------------------------------------------------- -->

        <section class="bill-wrap section-wrap section-bg">
          <div class="bill-bg">

            <!-- 請求内容----------- -->

            <!-- 請求書情報-------- -->
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
                  <!-- ステータスが入金確認後に表示------ -->
                  <p class="text-right ml-3"><a class="more_btn" href="">領収書をみる</a></p>
                  @endif
                </div>
              </div>
              <!-- 請求書情報--予約完了後に表示------ -->
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
            <!-- 請求書情報 終わり---------------------------- -->

            <!-- 会場料請求内容----------- -->
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

                {{-- <div class="col-6">
                  <div class="row">
                    <div class="col-4 bill-box_cell cell-gray">
                      <p>割引率</p>
                    </div>
                    <div class="col-5 bill-box_cell">
                      <p class="text-right">1111</p>
                    </div>
                    <div class="col-3 bill-box_cell text-right">
                      <p>割引金額</p>
                      <p class=""><span>円</span></p>
                    </div>
                  </div>
                </div> --}}

                {{-- <div class="col-6">
                  <div class="row">
                    <div class="col-4 bill-box_cell cell-gray">
                      <p>割引料金</p>
                    </div>
                    <div class="col-5 bill-box_cell">
                      <p class="text-right">111</p>
                    </div>
                    <div class="col-3 bill-box_cell text-right">
                      <p>割引率</p>
                      <p class=""><span>%</span></p>
                    </div>
                  </div>
                </div> --}}

                {{-- <div class="col-12 bill-box_cell text-right">
                  <p class="font-weight-bold">割引後会場料金合計</p>
                  <p class=""></p>
                </div> --}}
              </dl>


              <!-- 料金内訳-------------------------------------------------------------- -->
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
              <!-- 料金内訳 終わり---------------------------- -->


            </div>
            <!-- 請求内容 終わり---------------------------- -->

            <!-- 備品その他　請求内容----------- -->
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
                  <dt>荷物預かり/返送</dt>
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

                {{-- <div class="col-6">
                  <div class="row">
                    <div class="col-4 bill-box_cell cell-gray">
                      <p>割引料金</p>
                    </div>
                    <div class="col-5 bill-box_cell">
                      <p class="text-right"></p>
                    </div>
                    <div class="col-3 bill-box_cell text-right">
                      <p>割引率</p>
                      <p class=""><span>%</span></p>
                    </div>
                  </div>
                </div> --}}

                {{-- <div class="col-6 bill-box_cell text-right">
                  <p class="font-weight-bold">割引後備品その他合計</p>
                  <p class=""></p>
                </div> --}}
              </dl>


              <!-- 料金内訳-------------------------------------------------------------- -->
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
              <!-- 料金内訳 終わり---------------------------- -->


            </div>
            <!-- 請求内容 終わり---------------------------- -->

            <!-- レイアウト変更 請求内容----------- -->
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

                {{-- <div class="col-6">
                  <div class="row">
                    <div class="col-4 bill-box_cell cell-gray">
                      <p>割引料金</p>
                    </div>
                    <div class="col-5 bill-box_cell">
                      <p class="text-right"></p>
                    </div>
                    <div class="col-3 bill-box_cell text-right">
                      <p>割引率</p>
                      <p class="layout_discount_percent"><span>%</span></p>
                    </div>
                  </div>
                </div> --}}

                {{-- <div class="col-6 bill-box_cell text-right">
                  <p class="font-weight-bold">割引後レイアウト変更合計</p>
                  <p class="after_duscount_layouts"></p>
                </div> --}}
              </dl>

              <!-- 料金内訳-------------------------------------------------------------- -->
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
              <!-- 料金内訳 終わり---------------------------- -->


            </div>
            <!-- 請求内容 終わり---------------------------- -->
          </div>
        </section>

        　　　　　
        <!-- 請求セクション　キャンセル料 キャンセルをしたときに、表示------------------------------------------------------------------ -->
        {{-- <section class="bill-wrap section-wrap section-bg">
          <div class="bill-bg">

            <!-- 請求書情報-------- -->
            <div class="bill-ttl mb-5">
              <div class="section-ttl-box d-flex align-items-center">
                <div class="col-6">
                  <h3 class="section-ttl">キャンセル料請求情報</h3>
                </div>
                <div class="col-6 d-flex justify-content-end">
                  <p class="text-right"><a class="more_btn" href="">請求書をみる</a></p>
                  <!-- ステータスが入金確認後に表示------ -->
                  <p class="text-right ml-3"><a class="more_btn" href="">領収書をみる</a></p>
                </div>


              </div>
              <!-- 請求書情報--予約完了後に表示------ -->
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
            <!-- 請求書情報 終わり---------------------------- -->


            <!-- 　キャンセル料金内容----------- -->
            <div class="bill-box">
              <h3 class="row">キャンセル料</h3>
              <dl class="row bill-box_wrap">
                <div class="col-12 bill-box_cell">
                  <dt>キャンセル料金合計</dt>
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
                  <p class="font-weight-bold">割引後キャンセル料合計</p>
                  <p class=""></p>
                </div>
              </dl>


              <!-- 料金内訳-------------------------------------------------------------- -->
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
              <!-- 料金内訳 終わり---------------------------- -->


            </div>
            <!-- 請求内容 終わり---------------------------- -->

          </div>
        </section> --}}




      </section>
    </div>

    <!-- 予約詳細   終わり--------------------------------------------------　 -->

    <!-- 追加請求のフィールド------------------------------------------------------------------->
    {{-- ■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■ --}}
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
        <!-- 請求セクション------------------------------------------------------------------- -->
        <section class="section-wrap section-bg">
          <!-- 請求内容----------- -->
          <!-- 請求書情報-------- -->
          <div class="bill-ttl mb-5">
            <div class="section-ttl-box d-flex align-items-center">
              <div class="col-6">
                <h3 class="">請求情報</h3>
              </div>
              <div class="col-6 d-flex justify-content-end">
                <p class="text-right"><a class="more_btn" href="">請求書をみる</a></p>
                <!-- ステータスが入金確認後に表示------ -->
                <p class="text-right ml-3"><a class="more_btn" href="">領収書をみる</a></p>
              </div>
            </div>
            <!-- 請求書情報--予約完了後に表示------ -->
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
          <!-- 　追加請求内容----------- -->
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
            <!-- 料金内訳-------------------------------------------------------------- -->
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
            <!-- 料金内訳 終わり---------------------------- -->
          </div>
          <!-- 請求内容 終わり---------------------------- -->
          <!-- 請求内容 終わり---------------------------- -->
        </section>
        <!-- 請求セクション　キャンセル料-　キャンセルをしたときに、表示------------------------------------------------------------------ -->
        {{-- <section class="bill-wrap section-wrap section-bg">
          <div class="bill-bg">
            <!-- 請求書情報-------- -->
            <div class="bill-ttl mb-5">
              <div class="section-ttl-box d-flex align-items-center">
                <div class="col-6">
                  <h3 class="section-ttl">キャンセル料請求情報</h3>
                </div>
                <div class="col-6 d-flex justify-content-end">
                  <p class="text-right"><a class="more_btn" href="">請求書をみる</a></p>
                  <!-- ステータスが入金確認後に表示------ -->
                  <p class="text-right ml-3"><a class="more_btn" href="">領収書をみる</a></p>
                </div>
              </div>
              <!-- 請求書情報--予約完了後に表示------ -->
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
            <!-- 請求書情報 終わり---------------------------- -->
            <!-- 　キャンセル料金内容----------- -->
            <div class="bill-box">
              <h3 class="row">キャンセル料</h3>
              <dl class="row bill-box_wrap">
                <div class="col-12 bill-box_cell">
                  <dt>キャンセル料金合計</dt>
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
                  <p class="font-weight-bold">割引後キャンセル料合計</p>
                  <p class=""></p>
                </div>
              </dl>
              <!-- 料金内訳-------------------------------------------------------------- -->
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
              <!-- 料金内訳 終わり---------------------------- -->
            </div>
            <!-- 請求内容 終わり---------------------------- -->
          </div>
        </section> --}}
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
    @endforeach

    </section>
    {{-- ■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■ --}}

    <!-- 合計請求額------------------------------------------------------------------- -->
    <div class="total-sum">
      <table class="table table-bordered">
        <thead>
          <tr class="bg-green">
            <td colspan="2">
              合計請求額
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="table-active"><label for="venueFee">会場料</label></td>
            <td class="text-right">
              5,300円
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="serviceFee">備品その他</label></td>
            <td class="text-right">
              5,300円
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="layoutFee">レイアウト変更</label></td>
            <td class="text-right">
              5,300円
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="layoutFee">キャンセル料</label></td>
            <td class="text-right">
              5,300円
            </td>
          </tr>
          <tr>
            <td colspan="2" class="text-right">
              <p><span class="font-weight-bold">小計</span>7,200円</p>
              <p><span>消費税</span>720円</p>
            </td>
          </tr>
          <tr>
            <td colspan="2" class="text-right"><span class="font-weight-bold">請求総額</span>7,200円</td>
          </tr>
        </tbody>
      </table>
    </div>


    <!-- ステータスが予約承認まちのときに表示 -->

    @if ($reservation->bills()->first()->reservation_status==2)
    <div class="confirm-box">
      <p>上記、予約内容で間違いないでしょうか。問題なければ、予約の承認をお願い致します。</p>
      <p class="text-center mb-5 mt-3">
        {{-- <a href="" class="more_btn4_lg">予約を承認する</a> --}}
        {{ Form::model($reservation, ['method'=>'PUT', 'route'=> ['user.home.updatestatus',$reservation->id],'class'=>"text-center"])}}
        @csrf
        {{ Form::hidden('update_status',3,) }}

        {{ Form::submit('予約を承認する',['class' => 'btn more_btn4_lg']) }}
        {{ Form::close() }}
      </p>
      <p>※ご要望に相違がある場合は、下記連絡先までご連絡ください。<br>
        TEL：06-1234-5678<br>
        mail：test@gmail.com</p>
    </div>
    @endif


    <!-- ステータスが予約完了のときに表示 -->
    @if ($reservation->bills()->first()->reservation_status>2)
    <div class="confirm-box">
      <h3 class="caution mb-2 font-weight-bold">振込先案内</h3>
      <p>
        みずほ銀行　四ツ橋支店　普通　1113739　ｶ)ｴｽｴﾑｼﾞｰ</p>
      <p>
        ※該当日が土日祝の場合は直前の平日にお振込み下さい。<br>
        ※振込み手数料はお客様負担となります。<br>
        ※請求書・領収書は原則として発行しておりません。各金融機関発行の振込明細票が領収書扱いとなります。<br>
        <span class="caution">※申込時の「申込者」欄記載の名義でお振込み下さい。別名義でのお振込みの場合は必ず事前にSMGまでご連絡下さい。</span><br>
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