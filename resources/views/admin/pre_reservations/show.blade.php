@extends('layouts.admin.app')

@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>

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

  <h2 class="mt-3 mb-3">仮押え　詳細</h2>
  <hr>
</div>

<section class="mt-5">
  <div class="row">
    <div class="col-12 mb-2">
      {{Form::open(['url' => 'admin/pre_reservations/destroy', 'method' => 'POST', 'id'=>''])}}
      @csrf
      {{Form::hidden("destroy".$pre_reservation->id, $pre_reservation->id)}}
      {{ Form::submit('削除', ['class' => 'btn more_btn4','id'=>'confirm_destroy']) }}
      {{ Form::close() }}

    </div>
    <div class="col-12">
      <table class="table ttl_head mb-0">
        <tbody>
          <tr>
            <td>
              <h3 class="text-white py-2">
                仮押えID：{{ReservationHelper::fixId($pre_reservation->id)}}
              </h3>
            </td>
            <td>
              <div class="d-flex justify-content-end align-items-center">
                @if ($pre_reservation->status==0)
                @if ($pre_reservation->user_id>0)
                <a href="{{url('admin/pre_reservations/'.$pre_reservation->id.'/edit')}}" class="btn more_btn mr-2">
                  編集
                </a>
                @else
                <a href="{{url('admin/pre_agent_reservations/'.$pre_reservation->id.'/edit')}}"
                  class="btn more_btn mr-2">
                  仲介会社用編集
                </a>
                @endif
                @endif
                {{ Form::open(['url' => 'admin/pre_reservations/switch_status', 'method'=>'POST','id'=>'confirm_prereserve']) }}
                @csrf
                @if ($pre_reservation->status==0)
                {{ Form::hidden('pre_reservation_id', $pre_reservation->id)}}
                {{ Form::submit('仮押え内容を確定する', ['class' => 'btn more_btn4']) }}
                {{ Form::close() }}
                @endif

              </div>
            </td>
        </tbody>
      </table>
    </div>

    <div class="col-12">
      <div class="border-wrap2 p-4">

        @if ($pre_reservation->user_id>0)
        <table class="table table-bordered customer-table mb-3 table_fixed">
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
                {{ReservationHelper::checkAgentOrUserCompany($pre_reservation->user_id, $pre_reservation->agent_id)}}
              </td>
              <td class="table-active"><label for="name">担当者氏名</label></td>
              <td>
                {{ReservationHelper::checkAgentOrUserName($pre_reservation->user_id, $pre_reservation->agent_id)}}
              </td>
            </tr>
            <tr>
              <td class="table-active" scope="row"><label for="email">担当者メールアドレス</label>
              </td>
              <td>
                {{ReservationHelper::checkAgentOrUserEmail($pre_reservation->user_id, $pre_reservation->agent_id)}}
              </td>
              <td class="table-active" scope="row"><label for="mobile">携帯番号</label></td>
              <td>
                {{ReservationHelper::checkAgentOrUserMobile($pre_reservation->user_id, $pre_reservation->agent_id)}}
              </td>
            </tr>

            <tr>
              <td class="table-active" scope="row"><label for="tel">固定電話</label></td>
              <td>
                {{ReservationHelper::checkAgentOrUserTel($pre_reservation->user_id, $pre_reservation->agent_id)}}
              </td>
            </tr>
          </tbody>
        </table>
        @else
        <div class="selected_agent">
          <table class="table table-bordered" style="table-layout: fixed;">
            <thead>
              <tr>
                <th>仲介会社情報</th>
                <th colspan="3">仲介会社ID：<p class="user_id d-inline">
                    {{($pre_reservation->agent_id)}}
                  </p>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="table-active">会社名・団体名</td>
                <td colspan="3">
                  <p class="company">
                    {{ReservationHelper::getAgentCompany($pre_reservation->agent_id)}}
                  </p>
                </td>
              </tr>
              <tr>
                <td class="table-active">担当者氏名</td>
                <td>
                  <p class="person">
                    {{ReservationHelper::getAgentPerson($pre_reservation->agent_id)}}
                  </p>
                </td>
                <td class="table-active">メールアドレス</td>
                <td>
                  <p class="email">
                    {{ReservationHelper::getAgentEmail($pre_reservation->agent_id)}}
                  </p>
                </td>
              </tr>
              <tr>
                <td class="table-active">携帯番号</td>
                <td>
                  <p class="mobile">
                    {{ReservationHelper::getAgentMobile($pre_reservation->agent_id)}}
                  </p>
                </td>
                <td class="table-active">固定電話</td>
                <td>
                  <p class="tel">
                    {{ReservationHelper::getAgentTel($pre_reservation->agent_id)}}
                  </p>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        @endif

        @if ($pre_reservation->user_id>0)
        <table class="table table-bordered oneday-customer-table mb-5 table_fixed">
          <tbody>
            <tr>
              <td colspan="4">
                <p class="title-icon">
                  <i class="fas fa-user icon-size" aria-hidden="true"></i>
                  仮で入力する顧客情報
                </p>
              </td>
            </tr>
            <tr>
              <td class="table-active" width="25%"><label for="onedayCompany">会社・団体名(仮)</label></td>
              <td>
                {{$pre_reservation->unknown_user->unknown_user_company}}
              </td>
              <td class="table-active"><label for="onedayName">担当者名(仮)</label></td>
              <td>
                {{$pre_reservation->unknown_user->unknown_user_name}}
              </td>
            </tr>
            <tr>
              <td class="table-active" scope="row"><label for="onedayTel">固定電話</label>
              </td>
              <td>
                {{$pre_reservation->unknown_user->unknown_user_tel}}
              </td>
              <td class="table-active" scope="row"><label for="onedayMobile">携帯番号</label>
              </td>
              <td>
                {{$pre_reservation->unknown_user->unknown_user_mobile}}
              </td>
            </tr>
            <tr>
              <td class="table-active" scope="row"><label for="onedayEmail">メールアドレス</label></td>
              <td>
                {{$pre_reservation->unknown_user->unknown_user_email}}
              </td>
            </tr>
          </tbody>
        </table>
        @else
        <table class="table table-bordered" style="table-layout: fixed;">
          <thead>
            <tr>
              <th colspan="4">エンドユーザー情報 </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="table-active">エンドユーザー</td>
              <td>
                {{!empty($pre_reservation->pre_enduser->company)?$pre_reservation->pre_enduser->company:""}}
              </td>
              <td class="table-active">住所</td>
              <td>
                {{!empty($pre_reservation->pre_enduser->address)?$pre_reservation->pre_enduser->address:""}}
              </td>
            </tr>
            <tr>
              <td class="table-active">連絡先</td>
              <td>
                {{!empty($pre_reservation->pre_enduser->tel)?$pre_reservation->pre_enduser->tel:""}}
              </td>
              <td class="table-active">メールアドレス</td>
              <td>
                {{!empty($pre_reservation->pre_enduser->email)?$pre_reservation->pre_enduser->email:""}}
              </td>
            </tr>
            <tr>
              <td class="table-active">当日担当者</td>
              <td>
                {{!empty($pre_reservation->pre_enduser->person)?$pre_reservation->pre_enduser->person:""}}
              </td>
              <td class="table-active">当日連絡先</td>
              <td>
                {{!empty($pre_reservation->pre_enduser->mobile)?$pre_reservation->pre_enduser->mobile:""}}
              </td>
            </tr>
            <tr>
              <td class="table-active">利用者属性</td>
              <td>
                {{!empty($pre_reservation->pre_enduser->attr)?ReservationHelper::PreEndUserGetAttr($pre_reservation->pre_enduser->attr):""}}
              </td>
            </tr>
          </tbody>
        </table>
        @endif


        <div class="row">
          <!-- 左側の項目------------------------------------------------------------------------ -->
          <div class="col-6">
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <td colspan="2">
                    <p class="title-icon">
                      <i class="fas fa-info-circle icon-size" aria-hidden="true"></i>
                      仮押え情報
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
                    <p>
                      {{ReservationHelper::getVenue($pre_reservation->venue_id)}}
                    </p>
                    <p>{{$pre_reservation->price_system==1?"通常（枠貸し）":"アクセア（時間貸し）"}}</p>
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

              </tbody>
            </table>

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
                    {{$pre_reservation->board_flag==0?"無し":"有り"}}
                  </p>
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
            </table>

            <div class="equipemnts">
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
                  @foreach ($SPVenue->getEquipments() as $equipment)
                  @foreach ($pre_reservation->pre_breakdowns()->where('unit_type',2)->get() as $equ)
                  @if ($equipment->item==$equ->unit_item)
                  <tr>
                    <td class="justify-content-between d-flex">
                      {{$equ->unit_item}}
                      @if ($equ->unit_cost!=0)
                      ({{number_format($equ->unit_cost)}}円)
                      @endif
                      ×{{$equ->unit_count}}
                    </td>
                  </tr>
                  @endif
                  @endforeach
                  @endforeach
                </tbody>
              </table>
            </div>

            <div class="services">
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
                  <tr>
                    <td colspan="2">
                      <ul class="icheck-primary">
                        @foreach ($SPVenue->getServices() as $service)
                        @foreach ($pre_reservation->pre_breakdowns()->where('unit_type',3)->get() as $ser)
                        @if ($service->item==$ser->unit_item)
                        <li>
                          {{$ser->unit_item}}
                          @if ($ser->unit_cost!=0)
                          {{number_format($ser->unit_cost)}}円
                          @endif
                        </li>
                        @endif
                        @endforeach
                        @endforeach
                      </ul>
                    </td>
                  </tr>

                </tbody>
              </table>
            </div>

            @if ($pre_reservation->venue->layout==1)
            <div class='layouts'>
              <table class='table table-bordered' style="table-layout:fixed;">
                <thead>
                  <tr>
                    <th colspan='2'>
                      <p class="title-icon">
                        <i class="fas fa-th icon-size fa-fw"></i>レイアウト
                      </p>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="table-active"><label for="prelayout">準備</label>
                    </td>
                    <td>
                      @if (!empty($pre_reservation->pre_breakdowns()->where('unit_item','レイアウト準備料金')->first()))
                      あり
                      @else
                      なし
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td class="table-active"><label for="postlayout">片付</label>
                    </td>
                    <td>
                      @if (!empty($pre_reservation->pre_breakdowns()->where('unit_item','レイアウト片付料金')->first()))
                      あり
                      @else
                      なし
                      @endif
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            @endif

            @if ($pre_reservation->venue->layout==1)
            <div class='luggage'>
              <table class='table table-bordered' style="table-layout:fixed;">
                <thead>
                  <tr>
                    <th colspan='2'>
                      <p class="title-icon">
                        <i class="fas fa-suitcase-rolling icon-size fa-fw"></i>荷物預り
                      </p>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="table-active"><label for="Delivery">荷物預り/返送</label>
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
                          <p>荷物個数：{{$pre_reservation->luggage_count?$pre_reservation->luggage_count:0}}個</p>
                        </li>

                        <li class="d-flex justify-content-between">
                          <p>
                            事前荷物の到着日：{{$pre_reservation->luggage_arrive?ReservationHelper::formatDate($pre_reservation->luggage_arrive):""}}
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
                          <p>荷物個数：{{$pre_reservation->luggage_return?$pre_reservation->luggage_return:0}}個</p>
                        </li>
                      </ul>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            @endif

            @if ($pre_reservation->venue->eat_in_flag==1)
            <table class="table table-bordered eating-table">
              <tbody>
                <tr>
                  <td colspan="2">
                    <p class="title-icon">
                      <i class="fas fa-utensils icon-size fa-fw"></i>室内飲食
                    </p>
                  </td>
                </tr>
                <tr>
                  <td>
                    {{$pre_reservation->eat_in==1?"あり":"なし"}}
                  </td>
                </tr>
                <tr>
                  <td>
                    {{$pre_reservation->eat_in_prepare==1?"手配済み":"検討中"}}
                  </td>
                </tr>
              </tbody>
            </table>
            @endif


          </div>
          <!-- 左側の項目 終わり-------------------------------------------------- -->
          <!-- 右側の項目-------------------------------------------------- -->
          <div class="col-6">
            @if ($pre_reservation->user_id>0)
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
            @else
            <table class="table table-bordered sale-table">
              <tbody>
                <tr>
                  <td colspan="2">
                    <p class="title-icon">
                      <i class="fas fa-yen-sign icon-size" aria-hidden="true"></i>エンドユーザーからの入金額
                    </p>
                  </td>
                </tr>
                <tr>
                  <td class="table-active ">
                    <label for="enduser_charge ">支払い料</label>
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      {{number_format($pre_reservation->pre_enduser->charge)}}
                      <span class="ml-2">円</span>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
            @endif

            @if ($pre_reservation->user_id>0)
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

            @endif


            @if ($pre_reservation->venue->alliance_flag==1)
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
                    {{$pre_reservation->cost}}%
                  </td>
                </tr>
              </tbody>
            </table>
            @endif


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
                    <p>管理者備考</p>
                    <p>
                      {!!nl2br(e($pre_reservation->admin_details))!!}
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
<section class="mt-5 pt-0">
  <div class="bill">
    <div class="bill_head">
      <table class="table bill_table">
        <tbody>
          <tr>
            <td>
              <h3 class="text-white">
                請求情報
              </h3>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
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
    <div class="main hide border">
      @if ($pre_reservation->user_id>0)
      <div class="venues billdetails_content">
        <table class="table table-borderless" style="table-layout: fixed;">
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
            @foreach ($pre_reservation->pre_breakdowns()->where('unit_type',1)->get() as $venue)
            <tr>
              <td>{{$venue->unit_item}}</td>
              <td>{{number_format($venue->unit_cost)}}</td>
              <td>{{$venue->unit_count}}</td>
              <td>{{number_format($venue->unit_subtotal)}}</td>
            </tr>
            @endforeach
          </tbody>
          <tbody class="venue_result">
            <tr>
              <td colspan="2"></td>
              <td colspan="1">合計：</td>
              <td colspan="1" class="">
                {{number_format($pre_reservation->pre_bill->venue_price)}}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      @else
      <div class="venues billdetails_content">
        <table class="table table-borderless" style="table-layout: fixed;">
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
            @foreach ($pre_reservation->pre_breakdowns()->where('unit_type',1)->get() as $venue_breakdown)
            <tr>
              <td>{{$venue_breakdown->unit_item}}</td>
              <td></td>
              <td>{{$venue_breakdown->unit_count}}</td>
              <td></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      @endif

      @if ($pre_reservation->user_id>0)
      @if($pre_reservation->pre_breakdowns()->where("unit_type",2)->count()!=0||$pre_reservation->pre_breakdowns()->where("unit_type",2)->count()!=0)
      <div class="equipment billdetails_content">
        <table class="table table-borderless" style="table-layout: fixed;">
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
            @foreach ($pre_reservation->pre_breakdowns()->where('unit_type',2)->get() as $equipment)
            <tr>
              <td>{{$equipment->unit_item}}</td>
              <td>{{number_format($equipment->unit_cost)}}</td>
              <td>{{$equipment->unit_count}}</td>
              <td>{{number_format($equipment->unit_subtotal)}}</td>
            </tr>
            @endforeach

            @foreach ($pre_reservation->pre_breakdowns()->where('unit_type',3)->get() as $service)
            <tr>
              <td>{{$service->unit_item}}</td>
              <td>{{number_format($service->unit_cost)}}</td>
              <td>{{$service->unit_count}}</td>
              <td>{{number_format($service->unit_subtotal)}}</td>
            </tr>
            @endforeach
          </tbody>
          <tbody class="equipment_result">
            <tr>
              <td colspan="2"></td>
              <td colspan="1">合計：</td>
              <td colspan="1" class="">
                {{number_format($pre_reservation->pre_bill->equipment_price)}}
              </td>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      @endif
      @else
      @if($pre_reservation->pre_breakdowns()->where("unit_type",2)->count()!=0||$pre_reservation->pre_breakdowns()->where("unit_type",2)->count()!=0)
      <div class="equipment billdetails_content">
        <table class="table table-borderless" style="table-layout: fixed;">
          <tbody>
            <tr>
              <td>
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
            @foreach ($pre_reservation->pre_breakdowns()->where('unit_type',2)->get() as $equipment_breakdown)
            <tr>
              <td>{{$equipment_breakdown->unit_item}}</td>
              <td></td>
              <td>{{$equipment_breakdown->unit_count}}</td>
              <td></td>
            </tr>
            @endforeach
            @foreach ($pre_reservation->pre_breakdowns()->where('unit_type',3)->get() as $service_breakdown)
            <tr>
              <td>{{$service_breakdown->unit_item}}</td>
              <td></td>
              <td>{{$service_breakdown->unit_count}}</td>
              <td></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      @endif
      @endif

      @if ($pre_reservation->user_id>0)
      @if ($pre_reservation->venue->layout==1)
      @if (!empty($pre_reservation->pre_breakdowns()->where('unit_type',4)->first()))
      <div class="layout billdetails_content">
        <table class="table table-borderless" style="table-layout: fixed;">
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
            @foreach ($pre_reservation->pre_breakdowns()->where('unit_type',4)->get() as $layout)
            <tr>
              <td>{{$layout->unit_item}}</td>
              <td>{{number_format($layout->unit_cost)}}</td>
              <td>{{$layout->unit_count}}</td>
              <td>{{number_format($layout->unit_subtotal)}}</td>
            </tr>
            @endforeach
          </tbody>
          <tbody class="layout_result">
            <tr>
              <td colspan="2"></td>
              <td colspan="1">合計：</td>
              <td colspan="1">
                {{number_format($pre_reservation->pre_bill->layout_price)}}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      @endif
      @endif

      @else
      @if ($pre_reservation->venue->layout==1)
      @if (!empty($pre_reservation->pre_breakdowns()->where('unit_type',4)->first()))
      <div class="layout billdetails_content">
        <table class="table table-borderless" style="table-layout: fixed;">
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
            @foreach ($pre_reservation->pre_breakdowns()->where('unit_type',4)->get() as $layout_breakdown)
            <tr>
              <td>{{$layout_breakdown->unit_item}}</td>
              <td>{{$layout_breakdown->unit_cost}}</td>
              <td>{{$layout_breakdown->unit_count}}</td>
              <td>{{$layout_breakdown->unit_subtotal}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      @endif
      @endif
      @endif
      <div class="bill_total">
        <table class="table text-right">
          <tbody>
            <tr>
              <td>小計：</td>
              <td>
                {{number_format($pre_reservation->pre_bill->master_subtotal)}}
              </td>
            </tr>
            <tr>
              <td>消費税：</td>
              <td>
                {{number_format($pre_reservation->pre_bill->master_tax)}}
              </td>
            </tr>
            <tr>
              <td class="font-weight-bold">合計金額</td>
              <td>
                {{number_format($pre_reservation->pre_bill->master_total)}}
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

<script>
  $(function(){
    $("#confirm_prereserve").on('click',function(){
      if(!confirm('仮押さえの内容を確定し、ユーザーにメールを送付しますか？')){
        return false;
    }
    })

    $("#confirm_destroy").on('click',function(){
      if(!confirm('本当に削除しますか？')){
        return false;
    }
    })

  })
</script>
@endsection