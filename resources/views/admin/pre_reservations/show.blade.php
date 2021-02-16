@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>

<h1>詳細</h1> test test test








<section class="section-wrap">
  <div class="row">
    <div class="col-12">

      <div class="ttl-box d-flex align-items-center justify-content-between">
        <div class="col-5 d-flex align-items-center">
          <h3 class="section-ttl">仮押さえ概要</h3>
          <p class="ml-2">仮押さえID:{{$pre_reservation->id}}</p>
        </div>
      </div>

    </div>

    <div class="col-12">
      <div class="register-wrap">

        <table class="table table-bordered customer-table mb-5">
          <tbody>
            <tr>
              <td colspan="4">
                <div class="d-flex align-items-center justify-content-between">
                  <p class="title-icon">
                    <i class="far fa-address-card icon-size" aria-hidden="true"></i>
                    顧客情報
                  </p>
                </div>
              </td>
            </tr>
            <tr>
              <th class="table-active" width="25%"><label for="company">会社名・団体名</label>
              </th>
              <td>
                {{$pre_reservation->user_id==999?"":ReservationHelper::getCompany($pre_reservation->user_id)}}
              </td>
              <td class="table-active"><label for="name">担当者氏名</label></td>
              <td>
                {{$pre_reservation->user_id==999?"":ReservationHelper::getPersonName($pre_reservation->user_id)}}
              </td>
            </tr>
            <tr>
              <td class="table-active" scope="row"><label for="email">担当者メールアドレス</label>
              </td>
              <td>
                {{$pre_reservation->user_id==999?"":ReservationHelper::getPersonEmail($pre_reservation->user_id)}}
              </td>
              <td class="table-active" scope="row"><label for="mobile">携帯番号</label></td>
              <td>
                {{$pre_reservation->user_id==999?"":ReservationHelper::getPersonMobile($pre_reservation->user_id)}}
              </td>
            </tr>

            <tr>
              <td class="table-active" scope="row"><label for="tel">固定電話</label></td>
              <td>
                {{$pre_reservation->user_id==999?"":ReservationHelper::getPersonTel($pre_reservation->user_id)}}
              </td>
            </tr>
          </tbody>
        </table>

        <table class="table table-bordered oneday-customer-table mb-5">
          <tbody>
            <tr>
              <td colspan="4">
                <p class="title-icon">
                  <i class="fas fa-user icon-size" aria-hidden="true"></i>
                  顧客情報(顧客登録がされていない場合)
                </p>
              </td>
            </tr>

            <tr>
              <td class="table-active" width="25%"><label for="onedayCompany">会社名・団体名</label></td>
              <td>
                {{$pre_reservation->user_id==999?$pre_reservation->unknown_user->unknown_user_company:''}}
              </td>
              <td class="table-active"><label for="onedayName">担当者氏名</label></td>
              <td>
                {{$pre_reservation->user_id==999?$pre_reservation->unknown_user->unknown_user_name:''}}
              </td>
            </tr>
            <tr>
              <td class="table-active" scope="row"><label for="onedayEmail">担当者メールアドレス</label></td>
              <td>
                {{$pre_reservation->user_id==999?$pre_reservation->unknown_user->unknown_user_email:''}}
              </td>
              <td class="table-active" scope="row"><label for="onedayMobile">携帯番号</label>
              </td>
              <td>
                {{$pre_reservation->user_id==999?$pre_reservation->unknown_user->unknown_user_mobile:''}}
              </td>
            </tr>
            <tr>
              <td class="table-active" scope="row"><label for="onedayTel">固定電話</label>
              </td>
              <td>
                {{$pre_reservation->user_id==999?$pre_reservation->unknown_user->unknown_user_tel:''}}
              </td>
            </tr>
          </tbody>
        </table>


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
                    {{ReservationHelper::formatDate($pre_reservation->reserve_date)}}
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="venue">会場</label></td>
                  <td>
                    {{ReservationHelper::getVenue($pre_reservation->venue_id)}}
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="start">入室時間</label></td>
                  <td>
                    {{ReservationHelper::formatTime($pre_reservation->enter_time)}}
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="finish">退室時間</label></td>
                  <td>
                    {{ReservationHelper::formatTime($pre_reservation->leave_time)}}
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="direction">案内板</label></td>
                  <td class="d-flex justify-content-between">
                    <p>
                      {{$pre_reservation->board_flag==0?"なし":"要作成"}}
                    </p>
                    <p><a class="more_btn" href="">案内板出力(PDF)</a></p>
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="eventTime">イベント時間記載</label>
                  </td>
                  <td>
                    あり
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="eventStart">イベント開始時間</label>
                  </td>
                  <td>
                    {{ReservationHelper::formatTime($pre_reservation->event_start)}}
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="eventFinish">イベント終了時間</label>
                  </td>
                  <td>
                    {{ReservationHelper::formatTime($pre_reservation->event_finish)}}
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="eventName1">イベント名称1</label>
                  </td>
                  <td>
                    {{$pre_reservation->event_name1}}
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="eventName2">イベント名称2</label>
                  </td>
                  <td>
                    {{$pre_reservation->event_name2}}
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="organizer">主催者名</label></td>
                  <td>
                    {{$pre_reservation->event_owner}}
                  </td>
                </tr>
              </tbody>
            </table>

            <table class="table table-bordered equipment-table">
              <thead class="accordion-ttl">
                <tr>
                  <td colspan="2">
                    <p class="title-icon active">有料備品</p>
                  </td>
                </tr>
              </thead>
              <tbody class="accordion-wrap">
                @foreach ($equipments as $equipment)
                <tr>
                  <td class="justify-content-between d-flex">
                    {{$equipment->unit_item}}({{number_format($equipment->unit_cost)}}円)×{{$equipment->unit_count}}
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>

            <table class="table table-bordered service-table">
              <thead class="accordion-ttl">
                <tr>
                  <td colspan="2">
                    <p class="title-icon active">有料サービス<span class="open_toggle"></span></p>
                  </td>
                </tr>
              </thead>
              <tbody class="accordion-wrap">
                <tr>
                  <td colspan="2">
                    <ul class="icheck-primary">
                      @foreach ($services as $service)
                      <li>
                        {{$service->unit_item}} {{number_format($service->unit_cost)}}円
                      </li>
                      @endforeach
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="layout">レイアウト変更</label>
                  </td>
                  <td>
                    {{$layouts?"あり":"なし"}}
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="prelayout">レイアウト準備</label>
                  </td>
                  <td>
                    @if ($layouts)
                    @foreach ($layouts as $layout)
                    @if ($layout->unit_item=="レイアウト準備料金")
                    あり
                    @endif
                    @endforeach
                    @endif
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="postlayout">レイアウト片付</label>
                  </td>
                  <td>
                    @if ($layouts)
                    @foreach ($layouts as $layout)
                    @if ($layout->unit_item=="レイアウト片付料金")
                    あり
                    @endif
                    @endforeach
                    @endif
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="Delivery">荷物預かり/返送</label>
                  </td>
                  <td>
                    {{$pre_reservation->luggage_count?"あり":"なし"}}
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="preDelivery">事前に預かる荷物</label></td>
                  <td>
                    <ul class="table-cell-box">
                      <li>
                        <p>
                          {{$pre_reservation->luggage_arrive?"あり":"なし"}}
                        </p>
                      </li>
                      <li class="d-flex justify-content-between">
                        <p>荷物個数</p>
                        <p> {{$pre_reservation->luggage_count?$pre_reservation->luggage_count:0}}個</p>
                      </li>

                      <li class="d-flex justify-content-between">
                        <p>事前荷物の到着日</p>
                        <p>
                          {{$pre_reservation->luggage_arrive?ReservationHelper::formatDate($pre_reservation->luggage_arrive):""}}
                        </p>
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
                          {{$pre_reservation->luggage_return?"あり":"なし"}}
                        </p>
                      </li>
                      <li class="d-flex justify-content-between">
                        <p>荷物個数</p>
                        <p>{{$pre_reservation->luggage_return?$pre_reservation->luggage_return:0}}個</p>
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
          </div>
          <!-- 左側の項目 終わり-------------------------------------------------- -->
          <!-- 右側の項目-------------------------------------------------- -->
          <div class="col-6">

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
                      {{$pre_reservation->in_charge}}
                    </td>
                  </tr>
                  <tr>
                    <td class="table-active"><label for="mobilePhone">携帯番号</label>
                    </td>
                    <td>
                      {{$pre_reservation->tel}}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <table class="table table-bordered mail-table">
              <tbody>
                <tr>
                  <td colspan="2">
                    <p class="title-icon">
                      <i class="fas fa-envelope icon-size" aria-hidden="true"></i>
                      利用後の送信メール
                    </p>
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="sendMail">送信メール</label></td>
                  <td>
                    {{$pre_reservation->email_flag==0?"なし":"あり"}}
                  </td>
                </tr>
              </tbody>
            </table>

            <table class="table table-bordered sale-table">
              <tbody>
                <tr>
                  <td colspan="2">
                    <p class="title-icon">
                      <i class="fas fa-yen-sign icon-size" aria-hidden="true"></i>
                      売上原価
                    </p>
                  </td>
                </tr>
                <tr>
                  <td class="table-active"><label for="sale">原価率</label></td>
                  <td>
                    (提携会場のときに表示)
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
                  <td>
                    <p>
                      割引条件
                    </p>
                    <p>
                      {{$pre_reservation->discount_condition}}
                    </p>
                  </td>
                </tr>
                <tr class="caution">
                  <td>
                    <p>注意事項</p>
                    <p>
                      {{$pre_reservation->attention}}
                    </p>
                  </td>
                </tr>
                <tr>
                  <td>
                    <p>顧客(予約サイト経由)入力の備考</p>
                    <p>
                      {{$pre_reservation->user_details}}
                    </p>
                  </td>
                </tr>
                <tr>
                  <td>
                    <p>管理者備考</p>
                    <p>
                      {{$pre_reservation->admin_details}}
                    </p>
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


{{-- 以下請求情報 --}}
<section class="section-wrap">
  <div class="register-wrap mt-5">
    <h3>請求情報</h3>
  </div>








  <div class="approve_or_confirm">
    @if ($pre_reservation->user_id>0)
    @if ($reservation->bills()->first()->double_check_status==2)
    <!-- 承認確認ボタン-ダブルチェック後に表示------ -->
    {{-- 予約完了後、非表示 --}}
    @if ($reservation->bills()->first()->reservation_status<=2) <div class="row justify-content-end mt-2 mb-2">
      <div class="d-flex col-2 justify-content-around">
        <p class="text-right">
          {{-- 予約ステータスを2にして、ユーザーにメール送付 --}}
          {{-- <a class="more_btn" href="">承認</a> --}}
          {{ Form::open(['url' => 'admin/reservations/'.$reservation->id.'/send_email_and_approve', 'method'=>'POST', 'class'=>'']) }}
          @csrf
          {{ Form::hidden('reservation_id', $reservation->id ) }}
          {{ Form::hidden('user_id', $reservation->user_id ) }}
          {{ Form::submit('承認',['class' => 'btn more_btn']) }}
          {{ Form::close() }}
        </p>
        <p class="text-right">
          {{-- <a class="more_btn4" href="">確定</a> --}}
          {{ Form::open(['url' => 'admin/reservations/'.$reservation->id.'/confirm_reservation', 'method'=>'POST', 'class'=>'']) }}
          @csrf
          {{ Form::hidden('reservation_id', $reservation->id ) }}
          {{ Form::hidden('user_id', $reservation->user_id ) }}
          {{ Form::submit('確定',['class' => 'btn more_btn4']) }}
          {{ Form::close() }}
        </p>
      </div>
      @endif
      @endif
      @else
      @if ($reservation->bills()->first()->double_check_status==2)
      <!-- 承認確認ボタン-ダブルチェック後に表示------ -->
      {{-- 予約完了後、非表示 --}}
      @if ($reservation->bills()->first()->reservation_status<=2) <div class="row justify-content-end mt-2 mb-2">
        <div class="d-flex col-2 justify-content-around">
          <p class="text-right">
            {{-- <a class="more_btn4" href="">確定</a> --}}
            {{ Form::open(['url' => 'admin/reservations/'.$reservation->id.'/confirm_reservation', 'method'=>'POST', 'class'=>'']) }}
            @csrf
            {{ Form::hidden('reservation_id', $reservation->id ) }}
            {{ Form::hidden('user_id', $reservation->user_id ) }}
            {{ Form::submit('確定',['class' => 'btn more_btn4']) }}
            <span>※仲介会社経由の予約は確定のみ。メール送信は扶養</span>
            {{ Form::close() }}
          </p>
        </div>
        @endif
        @endif

        @endif
  </div>
  </div>
  <div class="bill_details">
    <div class="head d-flex">
      <div style="width: 80px; background:gray;" class="d-flex justify-content-center align-items-center">
        <i class="fas fa-plus fa-3x hide" style="color: white;" aria-hidden="true"></i>
        <i class="fas fa-minus fa-3x" style="color: white;" aria-hidden="true"></i>
      </div>
      <div style="font-size: 30px; width:200px;" class="d-flex justify-content-center align-items-center">
        <p>
          請求内訳
        </p>
      </div>
    </div>
    <div class="main hide">

      @if ($reservation->user_id>0)
      <div class="venues" style="padding-top: 80px; width:90%; margin:0 auto;">
        <table class="table table-borderless" style="table-layout: fixed;">
          <tbody>
            <tr>
              <td>
                <h1>
                  ■会場料
                </h1>
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
            @foreach ($reservation->bills()->first()->breakdowns()->get() as $venue_breakdown)
            @if ($venue_breakdown->unit_type==1)
            <tr>
              <td>{{$venue_breakdown->unit_item}}</td>
              <td>{{number_format($venue_breakdown->unit_cost)}}</td>
              <td>{{$venue_breakdown->unit_count}}</td>
              <td>{{number_format($venue_breakdown->unit_subtotal)}}</td>
            </tr>
            @endif
            @endforeach
          </tbody>
          <tbody class="venue_result">
            <tr>
              <td colspan="2"></td>
              <td colspan="1">合計：</td>
              <td colspan="1" class=""> {{number_format($reservation->bills()->first()->venue_price)}}</td>
            </tr>
          </tbody>
        </table>
      </div>
      @else
      <div class="venues" style="padding-top: 80px; width:90%; margin:0 auto;">
        <table class="table table-borderless" style="table-layout: fixed;">
          <tbody>
            <tr>
              <td>
                <h1>
                  ■会場料
                </h1>
              </td>
            </tr>
          </tbody>
          <tbody class="venue_head">
            <tr>
              <td>内容</td>
              <td>数量</td>
            </tr>
          </tbody>
          <tbody class="venue_main">
            @foreach ($reservation->bills()->first()->breakdowns()->get() as $venue_breakdown)
            @if ($venue_breakdown->unit_type==1)
            <tr>
              <td>{{$venue_breakdown->unit_item}}</td>
              <td>{{$venue_breakdown->unit_count}}</td>
            </tr>
            @endif
            @endforeach
          </tbody>
        </table>
      </div>
      @endif

      @if ($reservation->user_id>0)
      @if ($reservation->bills()->first()->equipment_price!=0||$reservation->bills()->first()->equipment_price)
      <div class="equipment" style="padding-top: 80px; width:90%; margin:0 auto;">
        <table class="table table-borderless" style="table-layout: fixed;">
          <tbody>
            <tr>
              <td>
                <h1>
                  ■有料備品・サービス
                </h1>
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
            @foreach ($reservation->bills()->first()->breakdowns()->get() as $equipment_breakdown)
            @if ($equipment_breakdown->unit_type==2)
            <tr>
              <td>{{$equipment_breakdown->unit_item}}</td>
              <td>{{number_format($equipment_breakdown->unit_cost)}}</td>
              <td>{{$equipment_breakdown->unit_count}}</td>
              <td>{{number_format($equipment_breakdown->unit_subtotal)}}</td>
            </tr>
            @endif
            @endforeach
            @foreach ($reservation->bills()->first()->breakdowns()->get() as $service_breakdown)
            @if ($service_breakdown->unit_type==3)
            <tr>
              <td>{{$service_breakdown->unit_item}}</td>
              <td>{{number_format($service_breakdown->unit_cost)}}</td>
              <td>{{$service_breakdown->unit_count}}</td>
              <td>{{number_format($service_breakdown->unit_subtotal)}}</td>
            </tr>
            @endif
            @endforeach
          </tbody>
          <tbody class="equipment_result">
            <tr>
              <td colspan="2"></td>
              <td colspan="1">合計：</td>
              <td colspan="1" class=""> {{number_format($reservation->bills()->first()->equipment_price)}}</td>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      @endif
      @else
      <div class="equipment" style="padding-top: 80px; width:90%; margin:0 auto;">
        <table class="table table-borderless" style="table-layout: fixed;">
          <tbody>
            <tr>
              <td>
                <h1>
                  ■有料備品・サービス
                </h1>
              </td>
            </tr>
          </tbody>
          <tbody class="equipment_head">
            <tr>
              <td>内容</td>
              <td>数量</td>
            </tr>
          </tbody>
          <tbody class="equipment_main">
            @foreach ($reservation->bills()->first()->breakdowns()->get() as $equipment_breakdown)
            @if ($equipment_breakdown->unit_type==2)
            <tr>
              <td>{{$equipment_breakdown->unit_item}}</td>
              <td>{{$equipment_breakdown->unit_count}}</td>
            </tr>
            @endif
            @endforeach
            @foreach ($reservation->bills()->first()->breakdowns()->get() as $service_breakdown)
            @if ($service_breakdown->unit_type==3)
            <tr>
              <td>{{$service_breakdown->unit_item}}</td>
              <td>{{$service_breakdown->unit_count}}</td>
            </tr>
            @endif
            @endforeach
          </tbody>
          @endif



          @if ($reservation->user_id>0)
          @if ($reservation->bills()->first()->layout_price!=0||$reservation->bills()->first()->layout_price)
          <div class="layout" style="padding-top: 80px; width:90%; margin:0 auto;">
            <table class="table table-borderless" style="table-layout: fixed;">
              <tbody>
                <tr>
                  <td colspan="4">
                    <h1>
                      ■レイアウト
                    </h1>
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
                @foreach ($reservation->bills()->first()->breakdowns()->get() as $layout_breakdown)
                @if ($layout_breakdown->unit_type==4)
                <tr>
                  <td>{{$layout_breakdown->unit_item}}</td>
                  <td>{{number_format($layout_breakdown->unit_cost)}}</td>
                  <td>{{$layout_breakdown->unit_count}}</td>
                  <td>{{number_format($layout_breakdown->unit_subtotal)}}</td>
                </tr>
                @endif
                @endforeach
              </tbody>
              <tbody class="layout_result">
                <tr>
                  <td colspan="1"></td>
                  <td colspan="1">合計：</td>
                  <td colspan="2">合計：{{number_format($reservation->bills()->first()->layout_price)}}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          @endif
          @else
          <div class="layout" style="padding-top: 80px; width:90%; margin:0 auto;">
            <table class="table table-borderless" style="table-layout: fixed;">
              <tbody>
                <tr>
                  <td colspan="2">
                    <h1>
                      ■レイアウト
                    </h1>
                  </td>
                </tr>
              </tbody>
              <tbody class="layout_head">
                <tr>
                  <td>内容</td>
                  <td>数量</td>
                </tr>
              </tbody>
              <tbody class="layout_main">
                @foreach ($reservation->bills()->first()->breakdowns()->get() as $layout_breakdown)
                @if ($layout_breakdown->unit_type==4)
                <tr>
                  <td>{{$layout_breakdown->unit_item}}</td>
                  <td>{{$layout_breakdown->unit_count}}</td>
                </tr>
                @endif
                @endforeach
              </tbody>
            </table>
          </div>
          @endif



          @if ($reservation->user_id>0)
          @if ($reservation->bills()->first()->others_price!=0||$reservation->bills()->first()->others_price)
          <div class="others" style="padding: 80px 0px 80px 0px; width:90%; margin:0 auto;">
            <table class="table table-borderless" style="table-layout: fixed;">
              <tbody>
                <tr>
                  <td>
                    <h1>
                      ■その他
                    </h1>
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
                @foreach ($reservation->bills()->first()->breakdowns()->get() as $others_breakdown)
                @if ($others_breakdown->unit_type==5)
                <tr>
                  <td>{{$others_breakdown->unit_item}}</td>
                  <td>{{number_format($others_breakdown->unit_cost)}}</td>
                  <td>{{$others_breakdown->unit_count}}</td>
                  <td>{{number_format($others_breakdown->unit_subtotal)}}</td>
                </tr>
                @endif
                @endforeach
              </tbody>
              <tbody class="others_result">
                <tr>
                  <td colspan="2"></td>
                  <td colspan="1"></td>
                  <td colspan="2">合計：{{$reservation->bills()->first()->others_price}}
                </tr>
              </tbody>
            </table>
          </div>
          @endif
          @else
          <div class="others" style="padding: 80px 0px 80px 0px; width:90%; margin:0 auto;">
            <table class="table table-borderless" style="table-layout: fixed;">
              <tbody>
                <tr>
                  <td>
                    <h1>
                      ■その他
                    </h1>
                  </td>
                </tr>
              </tbody>
              <tbody class="others_head">
                <tr>
                  <td>内容</td>
                  <td>数量</td>
                </tr>
              </tbody>
              <tbody class="others_main">
                @foreach ($reservation->bills()->first()->breakdowns()->get() as $others_breakdown)
                @if ($others_breakdown->unit_type==5)
                <tr>
                  <td>{{$others_breakdown->unit_item}}</td>
                  <td>{{$others_breakdown->unit_count}}</td>
                </tr>
                @endif
                @endforeach
              </tbody>
            </table>
          </div>
          @endif



          <div class="bill_total d-flex justify-content-end"
            style="padding: 80px 0px 80px 0px; width:90%; margin:0 auto;">
            <div style="width: 60%;">
              <table class="table text-right" style="table-layout: fixed; font-size:16px;">
                <tbody>
                  <tr>
                    <td>小計：</td>
                    <td>
                      {{number_format($reservation->bills()->first()->master_subtotal)}}
                    </td>
                  </tr>
                  <tr>
                    <td>消費税：</td>
                    <td>
                      {{number_format($reservation->bills()->first()->master_tax)}}
                    </td>
                  </tr>
                  <tr>
                    <td class="font-weight-bold">合計金額</td>
                    <td>
                      {{number_format($reservation->bills()->first()->master_total)}}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
      </div>
    </div>
  </div>

  <div class="information">
    <div class="information_details">
      <div class="head d-flex">
        <div style="width: 80px; background:gray;" class="d-flex justify-content-center align-items-center">
          <i class="fas fa-plus fa-3x hide" style="color: white;" aria-hidden="true"></i>
          <i class="fas fa-minus fa-3x" style="color: white;" aria-hidden="true"></i>
        </div>
        <div style="font-size: 30px; width:200px;" class="d-flex justify-content-center align-items-center">
          <p>
            請求書情報
          </p>
        </div>
      </div>
      <div class="main hide">
        <div class="informations" style="padding-top: 20px; width:90%; margin:0 auto;">
          <table class="table" style="table-layout: fixed;">
            <tbody>
              <tr>
                <td>請求日：</td>
                <td>支払期日：{{ReservationHelper::formatDate($reservation->bills()->first()->payment_limit)}}
                </td>
              </tr>
              <tr>
                <td>請求書宛名：
                  {{($reservation->bills()->first()->bill_company)}}
                </td>
                <td>
                  担当者：
                  {{$reservation->bills()->first()->bill_person}}
                </td>
              </tr>
              <tr>
                <td colspan="2">請求書備考
                  {{$reservation->bills()->first()->bill_remark}}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="paid">
    <div class="paid_details">
      <div class="head d-flex">
        <div style="width: 80px; background:#ff782d;" class="d-flex justify-content-center align-items-center">
        </div>
        <div style="font-size: 30px; width:200px;" class="d-flex justify-content-center align-items-center">
          <p>
            入金情報
          </p>
        </div>
      </div>
      <div class="main">
        <div class="paids" style="padding-top: 20px; width:90%; margin:0 auto;">
          <table class="table" style="table-layout: fixed;">
            <tbody>
              <tr>
                <td> {{$reservation->bills()->first()->paid==0?"未入金":"入金済"}}
                </td>
                <td>
                  入金日
                  {{$reservation->bills()->first()->pay_day}}
                </td>
              </tr>
              <tr>
                <td>振込人名 {{$reservation->bills()->first()->pay_person}}</td>
                <td>入金額 {{$reservation->bills()->first()->pay_person}}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  @if ($reservation->bills()->first()->double_check_status==0)
  <div class="checkbox section-wrap" style="border: solid 1px gray">
    <dl class="d-flex col-12 justify-content-end align-items-center">
      <dt><label for="checkname">一人目チェック者</label></dt>
      <dd>
        {{ Form::model($reservation->id, ['route'=> ['admin.reservations.double_check',$reservation->id]]) }}
        @csrf
        {{Form::select('double_check1_name', [
  '名前test1' => '名前test1', 
  '名前test2' => '名前test2',
  '名前test3' => '名前test3',
  '名前test4' => '名前test4',], 
  null, ['placeholder' => '選択してください', 'class'=>'form-control double_check1_name'])}}
        {{ Form::hidden('double_check_status', $reservation->bills()->first()->double_check_status ) }}
      </dd>
      <dd>
        <p class="text-right">
          {{Form::submit('チェック完了', ['class'=>'btn more_btn', 'id'=>'double_check1_submit'])}}
          {{ Form::close() }}
        </p>
      </dd>
    </dl>
  </div>
  @elseif($reservation->bills()->first()->double_check_status==1)
  <div class="checkbox section-wrap" style="border: solid 1px gray">
    <dl class="d-flex col-12 justify-content-end align-items-center">
      <dt><label for="checkname">二人目チェック者</label></dt>
      <dd>
        {{ Form::model($reservation->id, ['route'=> ['admin.reservations.double_check',$reservation->id]]) }}
        @csrf
        {{Form::select('double_check2_name', [
  '名前test1' => '名前test1', 
  '名前test2' => '名前test2',
  '名前test3' => '名前test3',
  '名前test4' => '名前test4',], 
  null, ['placeholder' => '選択してください', 'class'=>'form-control double_check2_name'])}}
        {{ Form::hidden('double_check_status', $reservation->bills()->first()->double_check_status ) }}
      </dd>
      <dd>
        <p class="text-right">
          {{Form::submit('チェック完了', ['class'=>'btn more_btn', 'id'=>'double_check2_submit'])}}
          {{ Form::close() }}
        </p>
      </dd>
    </dl>
  </div>
  @endif
  </div>





















</section>



















@endsection