@extends('layouts.admin.app')
@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/ajax.js') }}"></script>
<script src="{{ asset('/js/admin/reservation/validation.js') }}"></script>


<style>
  #fullOverlay {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(100, 100, 100, .5);
    z-index: 2147483647;
    display: none;
  }

  .frame_spinner {
    max-width: 100%;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .hide {
    display: none;
  }
</style>

<div id="fullOverlay">
  <div class="frame_spinner">
    <div class="spinner-border text-primary " role="status">
      <span class="sr-only hide">Loading...</span>
    </div>
  </div>
</div>


{{Form::open(['url' => '/admin/reservations/session_for_edit_calculate', 'method' => 'POST',
'id'=>'reservations_edit'])}}
@csrf

<section class="mt-5">
  <div class="row">
    <div class="col">
      <table class="table table-bordered">
        <tr>
          <td colspan="2">
            <p class="title-icon">
              <i class="fas fa-info-circle icon-size"></i>
              予約情報
            </p>
          </td>
        </tr>
        <tr>
          <td class="table-active form_required">利用日</td>
          <td>
            {{ Form::text('', date('Y-m-d', strtotime($reservation->reserve_date)) ,['class'=>'form-control',
            'readonly'] ) }}
            {{ Form::hidden('reserve_date', $reservation->reserve_date ,['class'=>'form-control', 'readonly'] ) }}
            <p class="is-error-reserve_date" style="color: red"></p>
          </td>
        </tr>
        <tr>
          <td class="table-active form_required">会場</td>
          <td>
            {{ Form::text('', ReservationHelper::getVenue($reservation->venue_id),['class'=>'form-control', 'readonly']
            ) }}
            {{ Form::hidden('venue_id', ($reservation->venue_id),['class'=>'form-control', 'readonly'] ) }}
            <p class="is-error-venue_id" style="color: red"></p>
          </td>
        </tr>
        <tr>
          <td class="table-active">料金体系</td>
          <td>
            @if ($venue->getPriceSystem()[0]==1&&$venue->getPriceSystem()[1]==1)
            <div class='price_radio_selector'>
              <div class="d-flex justfy-content-start align-items-center">
                {{ Form::radio('price_system', 1,
                isset($reservation->price_system)?$reservation->price_system==1?true:false:'', ['class'=>'mr-2',
                'id'=>'price_system_radio1']) }}
                {{Form::label('price_system_radio1','通常（枠貸）')}}
              </div>
              <div class="d-flex justfy-content-start align-items-center">
                {{ Form::radio('price_system', 2,
                isset($reservation->price_system)?$reservation->price_system==2?true:false:'',
                ['class'=>'mr-2','id'=>'price_system_radio2']) }}
                {{Form::label('price_system_radio2','音響HG')}}
              </div>
            </div>
            @elseif($venue->getPriceSystem()[0]==1&&$venue->getPriceSystem()[1]==0)
            <div class='price_radio_selector'>
              <div class="d-flex justfy-content-start align-items-center">
                {{ Form::radio('price_system', 1, true, ['class'=>'mr-2', 'id'=>'price_system_radio1']) }}
                {{Form::label('price_system_radio1','通常（枠貸）')}}
              </div>
            </div>
            @elseif($venue->getPriceSystem()[0]==0&&$venue->getPriceSystem()[1]==1)
            <div class='price_radio_selector'>
              <div class="d-flex justfy-content-start align-items-center">
                {{ Form::radio('price_system', 2, true, ['class'=>'mr-2','id'=>'price_system_radio2']) }}
                {{Form::label('price_system_radio2','音響HG')}}
              </div>
            </div>
            @endif
          </td>
        </tr>
        <tr>
          <td class="table-active form_required">入室時間</td>
          <td>
            <select name="enter_time" id="sales_start" class="form-control">
              <option disabled selected></option>
              {!!ReservationHelper::timeOptionsWithRequest($reservation->enter_time)!!}
            </select>
          </td>
        </tr>
        <tr>
          <td class="table-active form_required">退室時間</td>
          <td>
            <select name="leave_time" id="sales_finish" class="form-control">
              <option disabled selected></option>
              {!!ReservationHelper::timeOptionsWithRequest($reservation->leave_time)!!}
            </select>
          </td>
        </tr>
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
          <td class="table-active">案内板</td>
          <td>
            <div class="radio-box">
              <p>
                <input type="radio" name="board_flag" value="1" id="board_flag"
                  {{isset($reservation->board_flag)?$reservation->board_flag==1?'checked':'':'',}}>
                <span>有り</span>
              </p>
              <p>
                <input type="radio" name="board_flag" value="0" id="no_board_flag"
                  {{isset($reservation->board_flag)?$reservation->board_flag==0?'checked':'':'checked',}}>
                <span>無し</span>
              </p>
            </div>
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント開始時間</td>
          <td>
            <select name="event_start" id="event_start" class="form-control">
              <option disabled>選択してください</option>
              {!!ReservationHelper::timeOptionsWithRequest($reservation->event_start)!!}
            </select>
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント終了時間</td>
          <td>

            <select name="event_finish" id="event_finish" class="form-control">
              <option disabled>選択してください</option>
              {!!ReservationHelper::timeOptionsWithRequest($reservation->event_finish)!!}
            </select>
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント名称1</td>
          <td>
            <div class="align-items-end d-flex">
              {{ Form::text('event_name1', $reservation->event_name1,['class'=>'form-control', 'id'=>'eventname1Count']
              ) }}
              <span class="ml-1 annotation count_num1"></span>
            </div>
            <p class="is-error-event_name1" style="color: red"></p>
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント名称2</td>
          <td>
            <div class="align-items-end d-flex">
              {{ Form::text('event_name2', $reservation->event_name2,['class'=>'form-control', 'id'=>'eventname2Count']
              ) }}
              <span class="ml-1 annotation count_num2"></span>
            </div>
            <p class="is-error-event_name2" style="color: red"></p>
          </td>
        </tr>
        <tr>
          <td class="table-active">主催者名</td>
          <td>
            <div class="align-items-end d-flex">
              {{ Form::text('event_owner', $reservation->event_owner,['class'=>'form-control', 'id'=>'eventownerCount']
              ) }}
              <span class="ml-1 annotation count_num3"></span>
            </div>
            <p class="is-error-event_owner" style="color: red"></p>
          </td>
        </tr>
      </table>
      <div class="equipemnts">
        <table class="table table-bordered" style="table-layout: fixed;">
          <thead class="accordion-ttl">
            <tr>
              <th colspan="2">
                <p class="title-icon fw-bolder">
                  <i class="fas fa-wrench icon-size" aria-hidden="true"></i>有料備品
                </p>
              </th>
            </tr>
          </thead>
          <tbody class="accordion-wrap">
            @foreach ($venue->getEquipments() as $key=>$equ)
            <tr>
              <td class="table-active">
                {{$equ->item}}
              </td>
              <td>
                <input type="text" class="form-control equipment_breakdown" name="{{'equipment_breakdown'.$key}}"
                  @foreach($bill->breakdowns->where('unit_type',2) as $e_break)
                @if ($e_break->unit_item==$equ->item)
                value="{{$e_break->unit_count}}"
                @endif
                @endforeach
                >
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="services">
        <table class="table table-bordered" style="table-layout: fixed;">
          <thead class="accordion-ttl">
            <tr>
              <th colspan="2">
                <p class="title-icon fw-bolder">
                  <i class="fas fa-hand-holding-heart icon-size" aria-hidden="true"></i>有料サービス
                </p>
              </th>
            </tr>
          </thead>
          <tbody class="accordion-wrap">
            @foreach ($venue->getServices() as $key=>$ser)
            <tr>
              <td class="table-active">{{$ser->item}}</td>
              <td>
                <div class="radio-box">
                  <p>
                    {{Form::radio('services_breakdown'.$key, 1, false , ['id' => 'service'.$key.'on'])}}
                    {{Form::label('service'.$key.'on',"有り")}}
                  </p>
                  <p>
                    {{Form::radio('services_breakdown'.$key, 0, true, ['id' => 'service'.$key.'off'])}}
                    {{Form::label('service'.$key.'off',"無し")}}
                  </p>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
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
              <td class="table-active">準備</td>
              <td>
                <div class="radio-box">
                  @if ($bill->breakdowns->where('unit_item','レイアウト準備料金')->count()!=0)
                  <p>
                    {{Form::radio('layout_prepare', 1, true, ['id' => 'layout_prepare'])}}
                    {{Form::label('layout_prepare',"有り")}}
                  </p>
                  <p>
                    {{Form::radio('layout_prepare', 0, false, ['id' => 'no_layout_prepare'])}}
                    {{Form::label('no_layout_prepare',"無し")}}
                  </p>
                  @else
                  <p>
                    {{Form::radio('layout_prepare', 1, false, ['id' => 'layout_prepare'])}}
                    {{Form::label('layout_prepare',"有り")}}
                  </p>
                  <p>
                    {{Form::radio('layout_prepare', 0, true, ['id' => 'no_layout_prepare'])}}
                    {{Form::label('no_layout_prepare',"無し")}}
                  </p>
                </div>
              </td>
            </tr>
            @endif

            <tr>
              <td class="table-active">片付</td>
              <td>
                <div class="radio-box">
                  @if ($bill->breakdowns->where('unit_item','レイアウト片付料金')->count()!=0)
                  <p>
                    {{Form::radio('layout_clean', 1, true, ['id' => 'layout_clean'])}}
                    {{Form::label('layout_clean',"有り")}}
                  </p>
                  <p>
                    {{Form::radio('layout_clean', 0, false, ['id' => 'no_layout_clean'])}}
                    {{Form::label('no_layout_clean',"無し")}}
                  </p>
                  @else
                  <p>
                    {{Form::radio('layout_clean', 1, false, ['id' => 'layout_clean'])}}
                    {{Form::label('layout_clean',"有り")}}
                  </p>
                  <p>
                    {{Form::radio('layout_clean', 0, true, ['id' => 'no_layout_clean'])}}
                    {{Form::label('no_layout_clean',"無し")}}
                  </p>
                  @endif
                </div>
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
                <p class="title-icon">
                  <i class="fas fa-suitcase-rolling icon-size fa-fw"></i>荷物預かり
                </p>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="table-active">事前に預かる荷物<br>（個数）</td>
              <td>
                {{ Form::text('luggage_count', $reservation->luggage_count,['class'=>'form-control','min'=>0] ) }}
                <p class="is-error-luggage_count" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active">事前荷物の到着日<br>午前指定のみ</td>
              <td>
                {{ Form::text('luggage_arrive',
                date('Y-m-d',strtotime($reservation->luggage_arrive)),['class'=>'form-control limited_datepicker'] ) }}
              </td>
            </tr>
            <tr>
              <td class="table-active">事後返送する荷物</td>
              <td>
                {{ Form::number('luggage_return', $reservation->luggage_return,['class'=>'form-control','min'=>0] ) }}
                <p class="is-error-luggage_return" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active">荷物預かり<br>料金</td>
              <td>
                @foreach ($bill->breakdowns()->get() as $l_prices)
                @if ($l_prices->unit_item=="荷物預かり")
                <div class="d-flex align-items-end">
                  {{ Form::text('luggage_price', $l_prices->unit_cost,['class'=>'form-control'] ) }}
                  <span class="ml-1 annotation">円</span>
                </div>
                @break
                @elseif($loop->last)
                {{ Form::text('luggage_price', "",['class'=>'form-control'] ) }}
                @endif
                @endforeach
                <p class="is-error-luggage_price" style="color: red"></p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="eat_in">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th colspan='2'>
                <p class="title-icon">
                  <i class="fas fa-utensils icon-size fa-fw"></i>室内飲食
                </p>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                {{Form::radio('eat_in', 1, $reservation->eat_in==1?true:false , ['id' => 'eat_in'])}}
                {{Form::label('eat_in',"あり")}}
              </td>
              <td>
                {{Form::radio('eat_in_prepare', 1, $reservation->eat_in_prepare==1?true:false , ['id' =>
                'eat_in_prepare', 'disabled'])}}
                {{Form::label('eat_in_prepare',"手配済み")}}
                {{Form::radio('eat_in_prepare', 2, $reservation->eat_in_prepare==2?true:false , ['id' =>
                'eat_in_consider','disabled'])}}
                {{Form::label('eat_in_consider',"検討中")}}
              </td>
            </tr>
            <tr>
              <td>
                {{Form::radio('eat_in', 0, $reservation->eat_in==0?true:false , ['id' => 'no_eat_in'])}}
                {{Form::label('no_eat_in',"なし")}}
              </td>
              <td></td>
            </tr>
          </tbody>
        </table>
      </div>

    </div>
    <div class="col">
      <div class="client_mater">
        <table class="table table-bordered name-table" style="table-layout:fixed;">
          <tr>
            <td colspan="2">
              <div class="d-flex align-items-center justify-content-between">
                <p class="title-icon">
                  <i class="far fa-id-card icon-size"></i>顧客情報
                </p>
                <p class="user_link">
                  <a class="more_btn" target="_blank" rel="noopener"
                    href="{{url('/admin/clients/'.$reservation->user_id)}}">顧客詳細</a>
                </p>
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="user_id" class=" form_required">会社名/団体名</label></td>
            <td>
              <select class="form-control" name="user_id" id="user_select">
                <option disabled selected>選択してください</option>
                @foreach ($users as $user)
                <option value="{{$user->id}}" @if ($reservation->user_id==$user->id)
                  selected
                  @endif
                  >
                  {{$user->company}} ・ {{ReservationHelper::getPersonName($user->id)}} ・ {{$user->email}}
                </option>
                @endforeach
              </select>
              <p class="is-error-user_id" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="name">担当者氏名</label></td>
            <td>
              <p class="person">
                {{ReservationHelper::getPersonName($reservation->user->id)}}
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active">メールアドレス</td>
            <td>
              <p class="email">{{ReservationHelper::getPersonEmail($reservation->user->id)}}</p>
            </td>
          </tr>
          <tr>
            <td class="table-active">携帯番号</td>
            <td>
              <p class="mobile">
                {{ReservationHelper::getPersonMobile($reservation->user->id)}}
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active">固定電話</td>
            <td>
              <p class="tel">
                {{ReservationHelper::getPersonTel($reservation->user->id)}}
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active">割引条件</td>
            <td>
              <p class="condition">
                {!!nl2br(e(ReservationHelper::getPersonCondition($reservation->user->id)))!!}
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active caution">注意事項</td>
            <td class="caution">
              <p class="attention">
                {!!nl2br(e(ReservationHelper::getPersonAttention($reservation->user->id)))!!}
              </p>
            </td>
          </tr>
        </table>
        <table class="table table-bordered oneday-table" style="table-layout:fixed;">
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-user-check icon-size"></i>当日の連絡できる担当者
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="ondayName" class=" form_required">氏名</label></td>
            <td>
              {{ Form::text('in_charge', $reservation->in_charge,['class'=>'form-control'] ) }}
              <p class="is-error-in_charge" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="mobilePhone" class=" form_required">携帯番号</label></td>
            <td>
              {{ Form::text('tel', $reservation->tel,['class'=>'form-control'] ) }}
              <p class="is-error-tel" style="color: red"></p>
            </td>
          </tr>
        </table>
      </div>
      <table class="table table-bordered mail-table" style="table-layout:fixed;">
        <tr>
          <td colspan="2">
            <p class="title-icon">
              <i class="fas fa-envelope icon-size"></i>利用後の送信メール
            </p>
          </td>
        </tr>
        <tr>
          <td class="table-active"><label for="email_flag">送信メール</label></td>
          <td>
            {{ Form::text('', $reservation->email_flag==1?"有り":"無し",['class'=>'form-control'] ) }}
            {{ Form::hidden('email_flag', $reservation->email_flag,['class'=>'form-control'] ) }}
          </td>
        </tr>
      </table>

      @if ($venue->alliance_flag==1)
      <table class="table table-bordered sale-table" style="table-layout:fixed;">
        <tr>
          <td colspan="2">
            <p class="title-icon">
              <i class="fas fa-yen-sign icon-size"></i>売上原価
              <span class="annotation">
                （提携会場を選択した場合、提携会場で設定した原価率が適応されます）
              </span>
            </p>
          </td>
        </tr>
        <tr>
          <td class="table-active"><label for="cost">原価率</label></td>
          <td>
            <div class="d-flex align-items-end">
              {{ Form::text('', $reservation->cost,['class'=>'form-control'] ) }}
              {{ Form::hidden('cost', $reservation->cost,['class'=>'form-control'] ) }}
              <span class="ml-1 annotation">%</span>
            </div>
            <p class="is-error-cost" style="color: red"></p>
          </td>
        </tr>
      </table>
      @endif

      <table class="table table-bordered note-table">
        <tr>
          <td colspan="2">
            <p class="title-icon">
              <i class="fas fa-file-alt icon-size"></i>備考
            </p>
          </td>
        </tr>
        <tr>
          <td>
            <label for="adminNote">管理者備考</label>
            {{ Form::textarea('admin_details', $reservation->admin_details,['class'=>'form-control'] ) }}
          </td>
        </tr>
      </table>
    </div>
  </div>
</section>
{{Form::submit('再計算する', ['class'=>'btn more_btn4_lg mx-auto d-block mt-5 mb-5', 'id'=>'check_submit'])}}
{{Form::close()}}

{{ Form::open(['url' => '/admin/reservations/session_for_edit_check', 'method'=>'POST', 'id'=>'']) }}
@csrf
<section class="mt-5">
  <div class="bill">
    <div class="bill_head">
      <table class="table bill_table">
        <tr>
          <td>
            <h2 class="text-white">
              請求書No
            </h2>
          </td>
          <td>
            <dl class="ttl_box">
              <dt>合計金額</dt>
              <dd class="total_result">{{number_format($reservation->bills()->first()->master_total)}}円</dd>
            </dl>
          </td>
          <td>
            <dl class="ttl_box">
              <dt>支払い期日</dt>
              <dd class="total_result">{{ReservationHelper::formatDate($bill->payment_limit)}}</dd>
            </dl>
          </td>
        </tr>
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
      <div class="main">
        <div class="venues billdetails_content">
          <table class="table table-borderless">
            <tr>
              <td>
                <h4 class="billdetails_content_ttl">
                  会場料
                </h4>
              </td>
            </tr>
            <tbody class="venue_head">
              <tr>
                <td>内容</td>
                <td>単価</td>
                <td>数量</td>
                <td>金額</td>
              </tr>
            </tbody>
            <tbody class="venue_main">
              @for ($i = 0; $i < $v_cnt; $i++) <tr>
                <td>
                  {{ Form::text('venue_breakdown_item'.$i, $result['venue_breakdown_item'.$i],['class'=>'form-control',
                  'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_cost'.$i, $result['venue_breakdown_cost'.$i],['class'=>'form-control',
                  'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_count'.$i,
                  $result['venue_breakdown_count'.$i],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_subtotal'.$i,
                  $result['venue_breakdown_subtotal'.$i],['class'=>'form-control', 'readonly'] ) }}
                </td>
                </tr>
                @endfor
                @if (!empty($result['venue_breakdown_discount_item']))
                <tr>
                  <td>
                    {{ Form::text('venue_breakdown_discount_item',
                    $result['venue_breakdown_discount_item'],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('venue_breakdown_discount_cost',
                    $result['venue_breakdown_discount_cost'],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('venue_breakdown_discount_count',
                    $result['venue_breakdown_discount_count'],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('venue_breakdown_discount_subtotal',
                    $result['venue_breakdown_discount_subtotal'],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                </tr>
                @endif
            </tbody>
            <tbody class="venue_result">
              <tr>
                <td colspan="3"></td>
                <td colspan="1">
                  <p class="text-left">合計</p>
                  {{ Form::text('venue_price', $bill->venue_price,['class'=>'form-control col-xs-3', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        @if (!empty($e_cnt)||!empty($s_cnt)||!empty($result['luggage_subtotal']))
        <div class="equipment billdetails_content">
          <table class="table table-borderless">
            <tr>
              <td colspan="4">
                <h4 class="billdetails_content_ttl">
                  有料備品・サービス
                </h4>
              </td>
            </tr>
            <tbody class="equipment_head">
              <tr>
                <td>内容</td>
                <td>単価</td>
                <td>数量</td>
                <td>金額</td>
              </tr>
            </tbody>
            <tbody class="equipment_main">
              @for ($ii = 0; $ii < $e_cnt; $ii++) <tr>
                <td>
                  {{ Form::text('equipment_breakdown_item'.$ii,
                  $result['equipment_breakdown_item'.$ii],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_cost'.$ii,
                  $result['equipment_breakdown_cost'.$ii],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_count'.$ii,
                  $result['equipment_breakdown_count'.$ii],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_subtotal'.$ii,
                  $result['equipment_breakdown_subtotal'.$ii],['class'=>'form-control', 'readonly'] ) }}
                </td>
                </tr>
                @endfor

                @for ($ss = 0; $ss < $s_cnt; $ss++) <tr>
                  <td>
                    {{ Form::text('service_breakdown_item'.$ss,
                    $result['services_breakdown_item'.$ss],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('service_breakdown_cost'.$ss,
                    $result['services_breakdown_cost'.$ss],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('service_breakdown_count'.$ss,
                    $result['services_breakdown_count'.$ss],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('service_breakdown_subtotal'.$ss,
                    $result['services_breakdown_subtotal'.$ss],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  </tr>
                  @endfor
                  @if ($result['luggage_subtotal'])
                  <tr>
                    <td>
                      {{ Form::text('luggage_item', $result['luggage_item'],['class'=>'form-control', 'readonly'] ) }}
                    </td>
                    <td>
                      {{ Form::text('luggage_cost', $result['luggage_cost'],['class'=>'form-control', 'readonly'] ) }}
                    </td>
                    <td>
                      {{ Form::text('', 1,['class'=>'form-control', 'readonly'] ) }}
                    </td>
                    <td>
                      {{ Form::text('luggage_subtotal', $result['luggage_subtotal'],['class'=>'form-control',
                      'readonly'] ) }}
                    </td>
                  </tr>
                  @endif
                  @if (!empty($result['equipment_breakdown_discount_item']))
                  <tr>
                    <td>
                      {{ Form::text('equipment_breakdown_discount_item',
                      $result['equipment_breakdown_discount_item'],['class'=>'form-control', 'readonly'] ) }}
                    </td>
                    <td>
                      {{ Form::text('equipment_breakdown_discount_cost',
                      $result['equipment_breakdown_discount_cost'],['class'=>'form-control', 'readonly'] ) }}
                    </td>
                    <td>
                      {{ Form::text('equipment_breakdown_discount_count',
                      $result['equipment_breakdown_discount_count'],['class'=>'form-control', 'readonly'] ) }}
                    </td>
                    <td>
                      {{ Form::text('equipment_breakdown_discount_subtotal',
                      $result['equipment_breakdown_discount_subtotal'],['class'=>'form-control', 'readonly'] ) }}
                    </td>
                  </tr>
                  @endif
            </tbody>
            <tbody class="equipment_result">
              <tr>
                <td colspan="3"></td>
                <td colspan="1">
                  <p class="text-left">合計</p>
                  {{ Form::text('equipment_price', $result['equipment_price'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        @endif

        <div class="layout billdetails_content">
          <table class="table table-borderless">
            <tr>
              <td>
                <h4 class="billdetails_content_ttl">
                  レイアウト
                </h4>
              </td>
            </tr>
            <tbody class="layout_head">
              <tr>
                <td>内容</td>
                <td>単価</td>
                <td>数量</td>
                <td>金額</td>
              </tr>
            </tbody>
            <tbody class="layout_main">
              @foreach ($bill->breakdowns->where('unit_type',4) as $key=>$layout_price)
              <tr>
                <td>
                  {{ Form::text('layout_breakdown_item'.$key, $layout_price->unit_item,['class'=>'form-control',
                  'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_breakdown_cost'.$key, $layout_price->unit_cost,['class'=>'form-control',
                  'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_breakdown_count'.$key, $layout_price->unit_count,['class'=>'form-control',
                  'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_breakdown_subtotal'.$key, $layout_price->unit_subtotal,['class'=>'form-control',
                  'readonly'] ) }}
                </td>
              </tr>
              @endforeach
            </tbody>
            <tbody class="layout_result">
              <tr>
                <td colspan="3"></td>
                <td colspan="1">
                  <p class="text-left">合計</p>
                  {{ Form::text('layout_price',$bill->layout_price ,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
            <tbody class="layout_discount">
              <tr>
                <td>割引計算欄</td>
                <td>
                  <p>
                    割引金額
                  </p>
                  <div class="d-flex">
                    {{ Form::text('layout_number_discount', '',['class'=>'form-control'] ) }}
                    <p>円</p>
                  </div>
                  <p class="is-error-layout_number_discount" style="color: red"></p>
                </td>
                <td>
                  <p>
                    割引率
                  </p>
                  <div class="d-flex">
                    {{ Form::text('layout_percent_discount', '',['class'=>'form-control'] ) }}
                    <p>%</p>
                  </div>
                  <p class="is-error-layout_percent_discount" style="color: red"></p>
                </td>
                <td>
                  <input class="btn more_btn layout_discount_btn" type="button" value="計算する">
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="others billdetails_content">
          <table class="table table-borderless">
            <tr>
              <td colspan="5">
                <h4 class="billdetails_content_ttl">
                  その他
                </h4>
              </td>
            </tr>
            <tbody class="others_head">
              <tr>
                <td>内容</td>
                <td>単価</td>
                <td>数量</td>
                <td>金額</td>
                <td>追加/削除</td>
              </tr>
            </tbody>
            <tbody class="others_main">
              @foreach ($bill->breakdowns->where('unit_type',5) as $key=>$others_price)
              <tr>
                <td>
                  {{ Form::text('others_input_item'.$key, $others_price->unit_item,['class'=>'form-control', 'readonly']
                  ) }}
                </td>
                <td>
                  {{ Form::text('others_input_cost'.$key, $others_price->unit_cost,['class'=>'form-control', 'readonly']
                  ) }}
                </td>
                <td>
                  {{ Form::text('others_input_count'.$key, $others_price->unit_count,['class'=>'form-control',
                  'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('others_input_subtotal'.$key, $others_price->unit_subtotal,['class'=>'form-control',
                  'readonly'] ) }}
                </td>
              </tr>
              @endforeach
            </tbody>
            <tbody class="others_result">
              <tr>
                <td colspan="4"></td>
                <td colspan="1">
                  <p class="text-left">合計</p>
                  {{ Form::text('others_price', $bill->others_price,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
            <tbody class="others_discount">
              <tr>
                <td>割引計算欄</td>
                <td>
                  <p>
                    割引金額
                  </p>
                  <div class="d-flex">
                    {{ Form::text('others_number_discount', '',['class'=>'form-control'] ) }}
                    <p>円</p>
                  </div>
                  <p class="is-error-others_number_discount" style="color: red"></p>
                </td>
                <td>
                  <p>
                    割引率
                  </p>
                  <div class="d-flex">
                    {{ Form::text('others_percent_discount', '',['class'=>'form-control'] ) }}
                    <p>%</p>
                  </div>
                  <p class="is-error-others_percent_discount" style="color: red"></p>
                </td>
                <td>
                  <input class="btn more_btn others_discount_btn" type="button" value="計算する">
                </td>
                <td></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="bill_total">
          <table class="table text-right">
            <tr>
              <td>小計：</td>
              <td>
                {{ Form::text('master_subtotal', $bill->master_subtotal,['class'=>'form-control', 'readonly'] ) }}
              </td>
            </tr>
            <tr>
              <td>消費税：</td>
              <td>
                {{ Form::text('master_tax', $bill->master_tax,['class'=>'form-control', 'readonly'] ) }}
              </td>
            </tr>
            <tr>
              <td class="font-weight-bold">合計金額</td>
              <td>
                {{ Form::text('master_total', $bill->master_total,['class'=>'form-control', 'readonly'] ) }}

              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="information">
    <div class="information_details">
      <div class="head d-flex">
        <div class="accordion_btn">
          <i class="fas fa-plus bill_icon_size hide" aria-hidden="true"></i>
          <i class="fas fa-minus bill_icon_size" aria-hidden="true"></i>
        </div>
        <div class="billdetails_ttl">
          <h3>
            請求書情報
          </h3>
        </div>
      </div>
      <div class="main">
        <div class="informations billdetails_content py-3">
          <table class="table">
            <tr>
              <td>請求日：
                {{ Form::text('bill_created_at', $bill->bill_created_at,['class'=>'form-control', 'id'=>'datepicker6'] )
                }}
              </td>
              <td>支払期日
                {{ Form::text('pay_limit', $bill->pay_limit,['class'=>'form-control', 'id'=>'datepicker6'] ) }}
              </td>
            </tr>
            <tr>
              <td>請求書宛名{{ Form::text('pay_company', $bill->pay_company,['class'=>'form-control'] ) }}</td>
              <td>
                担当者{{ Form::text('bill_person', $bill->pay_person,['class'=>'form-control'] ) }}

              </td>
            </tr>
            <tr>
              <td colspan="2">請求書備考{{ Form::textarea('bill_remark', '',['class'=>'form-control'] ) }}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="paid">
    <div class="paid_details">
      <div class="head d-flex">
        <div class="d-flex align-items-center">
          <h3 class="pl-3">
            入金情報
          </h3>
        </div>
      </div>
      <div class="main">
        <div class="paids billdetails_content pt-3">
          <table class="table" style="table-layout: fixed;">
            <tr>
              <td>入金状況
                <select name="paid" class="form-control">
                  <option value="#" disabled>選択してください</option>
                  <option value="0" {{$bill->paid==0?'selected':''}}>未入金</option>
                  <option value="1" {{$bill->paid==1?'selected':''}}>入金済み</option>
                </select>
              </td>
              <td>
                入金日{{ Form::text('pay_day', $bill->pay_day,['class'=>'form-control', 'id'=>'datepicker7'] ) }}
              </td>
            </tr>
            <tr>
              <td>
                振込人名{{ Form::text('pay_person', $bill->pay_person,['class'=>'form-control'] ) }}
                <p class="is-error-pay_person" style="color: red"></p>
              </td>
              <td>入金額{{ Form::text('payment', $bill->payment,['class'=>'form-control'] ) }}
                <p class="is-error-payment" style="color: red"></p>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
{{Form::submit('確認する', ['class'=>'btn more_btn_lg d-block btn-lg mx-auto mt-5 mb-5', 'id'=>'check_submit'])}}
{{Form::close()}}




<script>
  $(function() {
    $(document).on("click", "input:radio[name='eat_in']", function() {
      var radioTarget = $('input:radio[name="eat_in"]:checked').val();
      if (radioTarget == 1) {
        $('input:radio[name="eat_in_prepare"]').prop('disabled', false);
      } else {
        $('input:radio[name="eat_in_prepare"]').prop('disabled', true);
        $('input:radio[name="eat_in_prepare"]').val("");
      }
    })
  })

  $(function() {
    $(function() {
      $(document).on("click", ".add", function() {
        $(this).parent().parent().clone(true).insertAfter($(this).parent().parent());
        addThisTr('.others .others_main tr', 'others_input_item', 'others_input_cost', 'others_input_count', 'others_input_subtotal');
        addThisTr('.venue_main tr', 'venue_breakdown_item', 'venue_breakdown_cost', 'venue_breakdown_count', 'venue_breakdown_subtotal');
        $(this).parent().parent().next().find('td').find('input, select').eq(0).val('');
        $(this).parent().parent().next().find('td').find('input, select').eq(1).val('');
        $(this).parent().parent().next().find('td').find('input, select').eq(2).val('');
        $(this).parent().parent().next().find('td').find('input, select').eq(3).val('');
      });

      function addThisTr($targetTr, $TItem, $TCost, $TCount, $TSubtotal) {
        var count = $($targetTr).length;
        for (let index = 0; index < count; index++) {
          $($targetTr).eq(index).find('td').eq(0).find('input').attr('name', $TItem + index);
          $($targetTr).eq(index).find('td').eq(1).find('input').attr('name', $TCost + index);
          $($targetTr).eq(index).find('td').eq(2).find('input').attr('name', $TCount + index);
          $($targetTr).eq(index).find('td').eq(3).find('input').attr('name', $TSubtotal + index);
        }
      }

      $(document).on("click", ".del", function() {
        if ($(this).parent().parent().parent().attr('class') == "others_main") {
          var count = $('.others .others_main tr').length;
          var target = $(this).parent().parent();
          if (target.parent().children().length > 1) {
            target.remove();
          }
          for (let index = 0; index < count; index++) {
            $('.others_main tr').eq(index).find('td').eq(0).find('input').attr('name', 'others_input_item' + index);
            $('.others_main tr').eq(index).find('td').eq(1).find('input').attr('name', 'others_input_cost' + index);
            $('.others_main tr').eq(index).find('td').eq(2).find('input').attr('name', 'others_input_count' + index);
            $('.others_main tr').eq(index).find('td').eq(3).find('input').attr('name', 'others_input_subtotal' + index);
          }
          var re_count = $('.others .others_main tr').length;
          var total_val = 0;
          for (let index2 = 0; index2 < re_count; index2++) {
            var num1 = $('input[name="others_input_cost' + index2 + '"]').val();
            var num2 = $('input[name="others_input_count' + index2 + '"]').val();
            var num3 = $('input[name="others_input_subtotal' + index2 + '"]');
            num3.val(num1 * num2);
            total_val = total_val + Number(num3.val());
          }
          var total_target = $('input[name="others_price"]');
          total_target.val(total_val);

          var venue = $('input[name="venue_price"]').val() ? Number($('input[name="venue_price"]').val()) : 0;
          var equipment = $('input[name="equipment_price"]').val() ? Number($('input[name="equipment_price"]').val()) : 0;
          var layout = $('input[name="layout_price"]').val() ? Number($('input[name="layout_price"]').val()) : 0;
          var others = $('input[name="others_price"]').val() == "" ? 0 : Number($('input[name="others_price"]').val());
          var result = venue + equipment + layout + others;
          var result_tax = Math.floor(result * 0.1);
          $('.total_result').text('').text(result);
          $('input[name="master_subtotal"]').val(result);
          $('input[name="master_tax"]').val(result_tax);
          $('input[name="master_total"]').val(result + result_tax);
        } else if ($(this).parent().parent().parent().attr('class') == "venue_main") {
          var count = $('.venue_main tr').length;
          var target = $(this).parent().parent();
          if (target.parent().children().length > 1) {
            target.remove();
          }
          for (let index = 0; index < count; index++) {
            $('.venue_main tr').eq(index).find('td').eq(0).find('input').attr('name', 'venue_breakdown_item' + index);
            $('.venue_main tr').eq(index).find('td').eq(1).find('input').attr('name', 'venue_breakdown_cost' + index);
            $('.venue_main tr').eq(index).find('td').eq(2).find('input').attr('name', 'venue_breakdown_count' + index);
            $('.venue_main tr').eq(index).find('td').eq(3).find('input').attr('name', 'venue_breakdown_subtotal' + index);
          }
          var re_count = $(' .venue_main tr').length;
          var total_val = 0;
          for (let index2 = 0; index2 < re_count; index2++) {
            var num1 = $('input[name="venue_breakdown_cost' + index2 + '"]').val();
            var num2 = $('input[name="venue_breakdown_count' + index2 + '"]').val();
            var num3 = $('input[name="venue_breakdown_subtotal' + index2 + '"]');
            num3.val(num1 * num2);
            total_val = total_val + Number(num3.val());
          }
          var total_target = $('input[name="venue_price"]');
          total_target.val(total_val);

          var venue = $('input[name="venue_price"]').val() ? Number($('input[name="venue_price"]').val()) : 0;
          var equipment = $('input[name="equipment_price"]').val() ? Number($('input[name="equipment_price"]').val()) : 0;
          var layout = $('input[name="layout_price"]').val() ? Number($('input[name="layout_price"]').val()) : 0;
          var others = $('input[name="others_price"]').val() == "" ? 0 : Number($('input[name="others_price"]').val());
          var result = venue + equipment + layout + others;
          var result_tax = Math.floor(result * 0.1);
          $('.total_result').text('').text(result);
          $('input[name="master_subtotal"]').val(result);
          $('input[name="master_tax"]').val(result_tax);
          $('input[name="master_total"]').val(result + result_tax);
        }
      });
    });
  })
</script>
@endsection