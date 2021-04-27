@extends('layouts.admin.app')
@section('content')

<div id="fullOverlay">
  <div class="frame_spinner">
    <div class="spinner-border text-primary " role="status">
      <span class="sr-only hide">Loading...</span>
    </div>
  </div>
</div>

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>


<div class="">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">
          <a href="http://staging-smg2.herokuapp.com/admin/home">ホーム</a>
          仲介会社経由　予約　編集
        </li>
      </ol>
    </nav>
  </div>
  <h2 class="mt-3 mb-3">仲介会社経由　予約　編集</h2>
  <hr>

  @component('components.reservation.m_reservation')
  {{-- スロット --}}
  @slot('form_open1')
  {{ Form::open(['url' => 'admin/agents_reservations/session_input', 'method'=>'post', 'class'=>'']) }}
  {{Form::hidden('agent_id',$reservation->agent->id)}}
  {{Form::hidden('reservation_id',$reservation->id)}}
  @csrf
  @endslot

  {{-- スロット --}}
  @slot('reserve_date')
  {{ Form::text('reserve_date', date('Y-m-d', strtotime($reservation->reserve_date)) ,['class'=>'form-control',  'readonly'] ) }}
  @endslot

  {{-- スロット --}}
  @slot('venue')
  {{ Form::text('',  ReservationHelper::getVenue($reservation->venue_id),['class'=>'form-control',  'readonly'] ) }}
  @endslot

  {{-- スロット --}}
  @slot('venue_hidden')
  {{ Form::hidden('venue_id',  $reservation->venue_id,['class'=>'form-control',  'readonly'] ) }}
  @endslot

  {{-- スロット --}}
  @slot('price_system1')
  {{ Form::radio('price_system', 1, isset($reservation->price_system)?$reservation->price_system==1?true:false:'', ['class'=>'mr-2', 'id'=>'price_system_radio1']) }}
  {{Form::label('price_system_radio1','通常（枠貸）')}}
  @endslot

  {{-- スロット --}}
  @slot('price_system2')
  {{ Form::radio('price_system', 2, isset($reservation->price_system)?$reservation->price_system==2?true:false:'', ['class'=>'mr-2','id'=>'price_system_radio2']) }}
  @endslot

  {{-- スロット --}}
  @slot('price_system2')
  {{ Form::radio('price_system', 2, isset($reservation->price_system)?$reservation->price_system==2?true:false:'', ['class'=>'mr-2','id'=>'price_system_radio2']) }}
  {{Form::label('price_system_radio2','アクセア（時間貸）')}}
  @endslot

  {{-- スロット --}}
  @slot('enter_time_loop')
  <select name="enter_time" id="sales_start" class="form-control">
    <option disabled selected></option>
    @for ($start = 0*2; $start <=23*2; $start++) <option
      value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (date("H:i:s", strtotime("00:00 +".
      $start * 30 ." minute"))==$reservation->enter_time)
      selected
      @endif>
      {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}
      </option>
      @endfor
  </select>
  @endslot

  {{-- スロット --}}
  @slot('leave_time_loop')
  <select name="leave_time" id="sales_finish" class="form-control">
    <option disabled selected></option>
    @for ($start = 0*2; $start <=23*2; $start++) <option
      value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (date("H:i:s", strtotime("00:00
      +".$start * 30 ." minute"))==$reservation->leave_time)
      selected
      @endif
      >
      {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}</option>
      @endfor
  </select>
  @endslot

  {{-- スロット --}}
  @slot('board_flag1')
  {{isset($reservation->board_flag)?$reservation->board_flag==1?'checked':'':'',}}
  @endslot

  {{-- スロット --}}
  @slot('board_flag2')
  {{isset($reservation->board_flag)?$reservation->board_flag==0?'checked':'':'checked',}}
  @endslot

  {{-- スロット --}}
  @slot('event_start_loop')
  <select name="event_start" id="event_start" class="form-control">
    <option disabled>選択してください</option>
    @for ($start = 0*2; $start <=23*2; $start++) <option
      value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (date("H:i:s", strtotime("00:00 +".
      $start * 30 ." minute"))==$reservation->event_start)
      selected
      @endif
      >
      {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}</option>
      @endfor
  </select>
  @endslot

  {{-- スロット --}}
  @slot('event_finish_loop')
  <select name="event_finish" id="event_finish" class="form-control">
    <option disabled>選択してください</option>
    @for ($start = 0*2; $start <=23*2; $start++) <option
      value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (date("H:i:s", strtotime("00:00 +".
      $start * 30 ." minute"))==$reservation->event_finish)
      selected
      @endif
      >
      {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}</option>
      @endfor
  </select>
  @endslot

  {{-- スロット --}}
  @slot('event_name1')
  {{ Form::text('event_name1', $reservation->event_name1,['class'=>'form-control', 'id'=>'eventname1Count'] ) }}
  @endslot

  {{-- スロット --}}
  @slot('event_name2')
  {{ Form::text('event_name2', $reservation->event_name2,['class'=>'form-control', 'id'=>'eventname2Count'] ) }}
  @endslot

  {{-- スロット --}}
  @slot('event_owner')
  {{ Form::text('event_owner', $reservation->event_owner,['class'=>'form-control', 'id'=>'eventownerCount'] ) }}
  @endslot

  {{-- スロット --}}
  @slot('m_equipment_loop')
  @foreach ($venue->getEquipments() as $key=>$equ)
  <tr>
    <td class="table-active">
      {{$equ->item}}
    </td>
    <td>
      <input type="text" class="form-control equipment_breakdown" name="{{'equipment_breakdown'.$key}}"
        @foreach($reservation->bills->first()->breakdowns->where('unit_type',2) as $e_break)
      @if ($e_break->unit_item==$equ->item)
      value="{{$e_break->unit_count}}"
      @endif
      @endforeach
      >
    </td>
  </tr>
  @endforeach
  @endslot

  {{-- スロット --}}
  @slot('m_service_loop')
  @foreach ($reservation->venue->getServices() as $key=>$service)
  <tr>
    <td class="table-active">{{$service->item}}</td>
    <td>
      @if ($reservation->bills->first()->breakdowns->count()!=0)
      @foreach ($reservation->bills->first()->breakdowns as $s_break)
      @if ($s_break->unit_item==$service->item)
      <div class="radio-box">
        <p>
          {{Form::radio('services_breakdown'.$key, 1, true , ['id' => 'service'.$key.'on'])}}
          {{Form::label('service'.$key.'on',"有り")}}
        </p>
        <p>
          {{Form::radio('services_breakdown'.$key, 0, false, ['id' => 'service'.$key.'off'])}}
          {{Form::label('service'.$key.'off',"無し")}}
        </p>
      </div>
      @break
      @elseif(empty($s_break))
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
      @break
      @elseif($loop->last)
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
      @endif
      @endforeach
      @else
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
      @endif

    </td>
  </tr>
  @endforeach
  @endslot

  {{-- スロット --}}
  @slot('m_layout_loop')
  @if ($reservation->venue->layout_prepare)
  <tr>
    <td class="table-active">準備</td>
    <td>
      <div class="radio-box">
        @if ($reservation->bills->first()->breakdowns->count()!=0)
        @foreach ($reservation->bills->first()->breakdowns as $key=>$l_break)
        @if ($l_break->unit_item=="レイアウト準備料金")
        <p>
          {{Form::radio('layout_prepare', 1, true, ['id' => 'layout_prepare'])}}
          {{Form::label('layout_prepare',"有り")}}
        </p>
        <p>
          {{Form::radio('layout_prepare', 0, false, ['id' => 'no_layout_prepare'])}}
          {{Form::label('no_layout_prepare',"無し")}}
        </p>
        @break
        @elseif($loop->last)
        <p>
          {{Form::radio('layout_prepare', 1, false, ['id' => 'layout_prepare'])}}
          {{Form::label('layout_prepare',"有り")}}
        </p>
        <p>
          {{Form::radio('layout_prepare', 0, true, ['id' => 'no_layout_prepare'])}}
          {{Form::label('no_layout_prepare',"無し")}}
        </p>
        @endif
        @endforeach
        @else
        <p>
          {{Form::radio('layout_prepare', 1, false, ['id' => 'layout_prepare'])}}
          {{Form::label('layout_prepare',"有り")}}
        </p>
        <p>
          {{Form::radio('layout_prepare', 0, true, ['id' => 'no_layout_prepare'])}}
          {{Form::label('no_layout_prepare',"無し")}}
        </p>
        @endif
      </div>
    </td>
  </tr>
  @endif
  @if ($reservation->venue->layout_clean)
  <tr>
    <td class="table-active">準備</td>
    <td>
      <div class="radio-box">
        @if ($reservation->bills->first()->breakdowns->count()!=0)
        @foreach ($reservation->bills->first()->breakdowns as $key=>$lc_break)
        @if ($lc_break->unit_item=="レイアウト片付料金")
        <p>
          {{Form::radio('layout_clean', 1, true, ['id' => 'layout_clean'])}}
          {{Form::label('layout_clean',"有り")}}
        </p>
        <p>
          {{Form::radio('layout_clean', 0, false, ['id' => 'no_layout_clean'])}}
          {{Form::label('no_layout_clean',"無し")}}
        </p>
        @break
        @elseif($loop->last)
        <p>
          {{Form::radio('layout_clean', 1, false, ['id' => 'layout_clean'])}}
          {{Form::label('layout_clean',"有り")}}
        </p>
        <p>
          {{Form::radio('layout_clean', 0, true, ['id' => 'no_layout_clean'])}}
          {{Form::label('no_layout_clean',"無し")}}
        </p>
        @endif
        @endforeach
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
  @endif
  @endslot

  {{-- スロット --}}
  @slot('luggage_count')
  {{ Form::text('luggage_count', $reservation->luggage_count,['class'=>'form-control'] ) }}
  @endslot

  {{-- スロット --}}
  @slot('luggage_arrive')
  {{ Form::text('luggage_arrive', $reservation->luggage_arrive,['class'=>'form-control'] ) }}
  @endslot

  {{-- スロット --}}
  @slot('luggage_return')
  {{ Form::text('luggage_return', $reservation->luggage_return,['class'=>'form-control'] ) }}
  @endslot

  {{-- スロット --}}
  @slot('eat_in1')
  {{Form::radio('eat_in', 1, false , ['id' => 'eat_in'])}}
  {{Form::label('eat_in',"あり")}}
  @endslot

  {{-- スロット --}}
  @slot('eat_in_prepare')
  {{Form::radio('eat_in_prepare', 1, false , ['id' => 'eat_in_prepare', 'disabled'])}}
  {{Form::label('eat_in_prepare',"手配済み")}}
  {{Form::radio('eat_in_prepare', 2, false , ['id' => 'eat_in_consider','disabled'])}}
  {{Form::label('eat_in_consider',"検討中")}}
  @endslot

  {{-- スロット --}}
  @slot('eat_in2')
  {{Form::radio('eat_in', 0, true , ['id' => 'no_eat_in'])}}
  {{Form::label('no_eat_in',"なし")}}
  @endslot

  {{-- スロット --}}
  @slot('client_link')
  <a class="more_btn" href="{{url('admin/clients/'.$reservation->user_id)}}">顧客詳細</a>
  @endslot

  {{-- スロット --}}
  @slot('form_submit1')
  {{Form::submit('再計算する', ['class'=>'btn more_btn4_lg mx-auto d-block mt-5 mb-5', 'id'=>'check_submit'])}}
  @endslot

  {{-- スロット --}}
  @slot('form_close1')
  {{Form::close()}}
  @endslot

  {{-- スロット --}}
  @slot('form_open2')
  {{-- {{ Form::open(['url' => '###################', 'method'=>'POST', 'id'=>'reservations_calculate_form']) }} --}}
  @csrf
  @endslot

  {{-- スロット --}}
  @slot('master_total')
  {{number_format($reservation->bills->first()->master_total)}}
  @endslot

  {{-- スロット --}}
  @slot('payment_limit')
  {{ReservationHelper::formatDate($reservation->bills->first()->payment_limit)}}
  @endslot

  {{-- スロット --}}
  @slot('venue_breakdown_loop')
  @foreach ($reservation->bills->first()->breakdowns->where('unit_type',1) as $v_key=>$venue_break)
  <tr>
    <td>
      {{ Form::text('venue_breakdown_item'.$v_key, $venue_break->unit_item,['class'=>'form-control', 'readonly'] ) }}
    </td>
    <td>
      {{ Form::text('venue_breakdown_cost'.$v_key, $venue_break->unit_cost,['class'=>'form-control', 'readonly'] ) }}
    </td>
    <td>
      {{ Form::text('venue_breakdown_count'.$v_key, $venue_break->unit_count,['class'=>'form-control', 'readonly'] ) }}
    </td>
    <td>
      {{ Form::text('venue_breakdown_subtotal'.$v_key, $venue_break->unit_subtotal,['class'=>'form-control', 'readonly'] ) }}
    </td>
  </tr>
  @endforeach
  @endslot


  {{-- スロット --}}
  @slot('equipment_breakdown_loop')
  {{-- {{var_dump($reservation)}} --}}
  @foreach ($reservation->bills->first()->breakdowns->where('unit_type',2) as $e_key=>$equipment_break)
  <tr>
    <td>
      {{ Form::text('equipment_breakdown_item'.$e_key, $equipment_break->unit_item,['class'=>'form-control', 'readonly'] ) }}
    </td>
    <td>
      {{ Form::text('equipment_breakdown_cost'.$e_key, $equipment_break->unit_cost,['class'=>'form-control', 'readonly'] ) }}
    </td>
    <td>
      {{ Form::text('equipment_breakdown_count'.$e_key, $equipment_break->unit_count,['class'=>'form-control', 'readonly'] ) }}
    </td>
    <td>
      {{ Form::text('equipment_breakdown_subtotal'.$e_key, $equipment_break->unit_subtotal,['class'=>'form-control', 'readonly'] ) }}
    </td>
  </tr>
  @endforeach
  @endslot

  {{-- スロット --}}
  @slot('service_breakdown_loop')
  @foreach ($reservation->bills->first()->breakdowns->where('unit_type',3) as $s_key=>$service_break)
  <tr>
    <td>
      {{ Form::text('service_breakdown_cost'.$s_key, $service_break->unit_item,['class'=>'form-control', 'readonly'] ) }}
    </td>
    <td>
      {{ Form::text('service_breakdown_cost'.$s_key, $service_break->unit_cost,['class'=>'form-control', 'readonly'] ) }}
    </td>
    <td>
      {{ Form::text('service_breakdown_count'.$s_key, $service_break->unit_count,['class'=>'form-control', 'readonly'] ) }}
    </td>
    <td>
      {{ Form::text('servie_breakdown_subtotal'.$s_key, $service_break->unit_subtotal,['class'=>'form-control', 'readonly'] ) }}
    </td>
  </tr>
  @endforeach
  @endslot

  {{-- スロット --}}
  @slot('equipment_price')
  {{ Form::text('equipment_price', $reservation->bills->first()->equipment_price,['class'=>'form-control', 'readonly'] ) }}
  @endslot

  {{-- スロット --}}
  @slot('layout_breakdown_loop')
  @foreach ($reservation->bills->first()->breakdowns->where('unit_type',4) as $l_key=>$layout_break)
  <tr>
    <td>
      {{ Form::text('layout_breakdown_item'.$l_key, $layout_break->unit_item,['class'=>'form-control', 'readonly'] ) }}
    </td>
    <td>
      {{ Form::text('layout_breakdown_cost'.$l_key, $layout_break->unit_cost,['class'=>'form-control', 'readonly'] ) }}
    </td>
    <td>
      {{ Form::text('layout_breakdown_count'.$l_key, $layout_break->unit_count,['class'=>'form-control', 'readonly'] ) }}
    </td>
    <td>
      {{ Form::text('layout_breakdown_subtotal'.$l_key, $layout_break->unit_subtotal,['class'=>'form-control', 'readonly'] ) }}
    </td>
  </tr>
  @endforeach
  @endslot

  {{-- スロット --}}
  @slot('layout_price')
  {{ Form::text('layout_price',$reservation->bills->first()->layout_price ,['class'=>'form-control', 'readonly'] ) }}
  @endslot

  {{-- スロット --}}
  @slot('others_breakdown_loop')
  @foreach ($reservation->bills->first()->breakdowns->where('unit_type',5) as $o_key=>$other_break)
  <tr>
    <td>
      {{ Form::text('others_input_item'.$o_key, $other_break->unit_item,['class'=>'form-control', 'readonly'] ) }}
    </td>
    <td>
      {{ Form::text('others_input_cost'.$o_key, $other_break->unit_cost,['class'=>'form-control', 'readonly'] ) }}
    </td>
    <td>
      {{ Form::text('others_input_count'.$o_key, $other_break->unit_count,['class'=>'form-control', 'readonly'] ) }}
    </td>
    <td>
      {{ Form::text('others_input_subtotal'.$o_key, $other_break->unit_subtotal,['class'=>'form-control', 'readonly'] ) }}
    </td>
  </tr>
  @endforeach
  @endslot

  {{-- スロット --}}
  @slot('others_price')
  {{ Form::text('others_price', $reservation->bills->first()->others_price,['class'=>'form-control', 'readonly'] ) }}
  @endslot

  {{-- スロット --}}
  @slot('master_subtotal')
  {{ Form::text('master_subtotal', $reservation->bills->first()->master_subtotal,['class'=>'form-control', 'readonly'] ) }}
  @endslot

  {{-- スロット --}}
  @slot('master_tax')
  {{ Form::text('master_tax', $reservation->bills->first()->master_tax,['class'=>'form-control', 'readonly'] ) }}
  @endslot

  {{-- スロット --}}
  @slot('master_total1')
  {{$reservation->bills->first()->master_total}}
  @endslot

  {{-- スロット --}}
  @slot('master_total2')
  {{ Form::text('master_total', $reservation->bills->first()->master_total,['class'=>'form-control', 'readonly'] ) }}
  @endslot

  {{-- スロット --}}
  @slot('bill_created_at')
  {{ Form::text('bill_created_at', $reservation->bills->first()->bill_created_at,['class'=>'form-control', 'id'=>'datepicker6'] ) }}
  @endslot

  {{-- スロット --}}
  @slot('pay_limit')
  {{ Form::text('pay_limit', $reservation->bills->first()->pay_limit,['class'=>'form-control', 'id'=>'datepicker6'] ) }}
  @endslot

  {{-- スロット --}}
  @slot('pay_company')
  {{ Form::text('pay_company', $reservation->agent->company,['class'=>'form-control'] ) }}
  @endslot

  {{-- スロット --}}
  @slot('bill_person')
  {{ Form::text('bill_person', $reservation->agent->bill_person,['class'=>'form-control'] ) }}
  @endslot
  {{-- スロット --}}
  @slot('bill_remark')
  {{ Form::textarea('bill_remark', $reservation->agent->bill_remark,['class'=>'form-control'] ) }}
  @endslot
  {{-- スロット --}}
  @slot('paid_select')
  <select name="paid" class="form-control">
    <option value="#" disabled>選択してください</option>
    <option value="0" {{$reservation->bills->first()->paid==0?'selected':''}}>未入金</option>
    <option value="1" {{$reservation->bills->first()->paid==1?'selected':''}}>入金済み</option>
  </select>
  @endslot
  {{-- スロット --}}
  @slot('pay_day')
  {{ Form::text('pay_day', $reservation->bills->first()->pay_day,['class'=>'form-control', 'id'=>'datepicker7'] ) }}
  @endslot
  {{-- スロット --}}
  @slot('pay_person')
  {{ Form::text('pay_person', $reservation->bills->first()->pay_person,['class'=>'form-control'] ) }}
  @endslot
  {{-- スロット --}}
  @slot('payment')
  {{ Form::text('payment', $reservation->bills->first()->payment,['class'=>'form-control'] ) }}
  @endslot
  {{-- スロット --}}
  @slot('form_submit2')
  {{-- {{Form::submit('確認する', ['class'=>'btn more_btn_lg d-block btn-lg mx-auto mt-5 mb-5', 'id'=>'check_submit'])}}
  --}}
  @endslot
  {{-- スロット --}}
  @slot('form_close2')
  {{-- {{Form::close()}} --}}
  @endslot

  {{-- スロット --}}
  @slot('agent_select')
  <select class="form-control" name="agent_id" id="agent_select">
    <option disabled selected>選択してください</option>
    @foreach ($agents as $agent)
    <option value="{{$agent->id}}" @if ($agent->id==$reservation->agent_id)
      selected
      @endif
      >{{$agent->name}} |
      {{$agent->person_firstname}}{{$agent->person_lastname}} | {{$agent->email}}
    </option>
    @endforeach
  </select>
  @endslot

  {{-- スロット --}}
  @slot('agent_person')
  {{ReservationHelper::getAgentPerson($reservation->agent_id)}}
  @endslot

  {{-- スロット --}}
  @slot('end_user')
  {{ Form::text('enduser_company', $reservation->enduser->company,['class'=>'form-control', 'placeholder'=>'入力してください','id'=>'enduser_company'] ) }}
  @endslot

  {{-- スロット --}}
  @slot('end_user_address')
  {{ Form::text('enduser_address', $reservation->enduser->address,['class'=>'form-control', 'placeholder'=>'入力してください','id'=>'enduser_address'] ) }}
  @endslot

  {{-- スロット --}}
  @slot('end_user_tel')
  {{ Form::text('enduser_tel', $reservation->enduser->tel,['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'enduser_tel'] ) }}
  @endslot

  {{-- スロット --}}
  @slot('end_user_email')
  {{ Form::text('enduser_mail', $reservation->enduser->email,['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'enduser_mail'] ) }}
  @endslot


  {{-- スロット --}}
  @slot('end_user_person')
  {{ Form::text('enduser_incharge', $reservation->enduser->person,['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'enduser_incharge'] ) }}
  @endslot

  {{-- スロット --}}
  @slot('end_user_mobile')
  {{ Form::text('enduser_mobile', $reservation->enduser->mobile,['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'enduser_mobile'] ) }}
  @endslot
  {{-- スロット --}}
  @slot('end_user_attr')
  <select name="enduser_attr" class="form-control">
    <option value="1" {{$reservation->enduser->attr==1?"selected":""}}>一般企業</option>
    <option value="2" {{$reservation->enduser->attr==2?"selected":""}}>上場企業</option>
    <option value="3" {{$reservation->enduser->attr==3?"selected":""}}>近隣利用</option>
    <option value="4" {{$reservation->enduser->attr==4?"selected":""}}>個人講師</option>
    <option value="5" {{$reservation->enduser->attr==5?"selected":""}}>MLM</option>
    <option value="6" {{$reservation->enduser->attr==6?"selected":""}}>その他</option>
  </select>
  @endslot
  {{-- スロット --}}
  @slot('end_user_charge')
  {{ Form::text('enduser_charge', $reservation->enduser->charge,['class'=>'form-control ', 'placeholder'=>'入力してください'] ) }}
  @endslot


  {{-- スロット --}}
  @slot('admin_details')
  {{ Form::textarea('admin_details', $reservation->admin_details,['class'=>'form-control ', 'placeholder'=>'入力してください'] ) }}
  @endslot









  @endcomponent
  @endsection