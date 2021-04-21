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
  @csrf
  @endslot

  {{-- スロット --}}
  @slot('reserve_date')
  {{ Form::text('reserve_date', date('Y-m-d', strtotime($inputs['reserve_date'])) ,['class'=>'form-control',  'readonly'] ) }}
  @endslot

  {{-- スロット --}}
  @slot('venue')
  {{ Form::text('',  ReservationHelper::getVenue($inputs['venue_id']),['class'=>'form-control',  'readonly'] ) }}
  @endslot

  {{-- スロット --}}
  @slot('venue_hidden')
  {{ Form::hidden('venue_id',  $inputs['venue_id'],['class'=>'form-control',  'readonly'] ) }}
  @endslot

  {{-- スロット --}}
  @slot('price_system1')
  {{ Form::radio('price_system', 1, isset($inputs['price_system'])?$inputs['price_system']==1?true:false:'', ['class'=>'mr-2', 'id'=>'price_system_radio1']) }}
  @endslot

  {{-- スロット --}}
  @slot('price_system2')
  {{ Form::radio('price_system', 2, isset($inputs['price_system'])?$inputs['price_system']==2?true:false:'', ['class'=>'mr-2','id'=>'price_system_radio2']) }}
  @endslot

  {{-- スロット --}}
  @slot('price_system2')
  {{ Form::radio('price_system', 2, isset($inputs['price_system'])?$inputs['price_system']==2?true:false:'', ['class'=>'mr-2','id'=>'price_system_radio2']) }}
  @endslot

  {{-- スロット --}}
  @slot('enter_time_loop')
  @for ($start = 0*2; $start <=23*2; $start++) <option
    value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (date("H:i:s", strtotime("00:00 +".
    $start * 30 ." minute"))==$inputs['enter_time']) selected @endif>
    {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}
    </option>
    @endfor
    @endslot

    {{-- スロット --}}
    @slot('leave_time_loop')
    @for ($start = 0*2; $start <=23*2; $start++) <option
      value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (date("H:i:s", strtotime("00:00
      +".$start * 30 ." minute"))==$inputs['leave_time']) selected @endif>
      {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}</option>
      @endfor
      @endslot

      {{-- スロット --}}
      @slot('board_flag1')
      {{isset($inputs['board_flag'])?$inputs['board_flag']==1?'checked':'':'',}}
      @endslot

      {{-- スロット --}}
      @slot('board_flag2')
      {{isset($inputs['board_flag'])?$inputs['board_flag']==0?'checked':'':'checked',}}
      @endslot

      {{-- スロット --}}
      @slot('event_start_loop')
      @for ($start = 0*2; $start <=23*2; $start++) <option
        value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (date("H:i:s", strtotime("00:00 +".
        $start * 30 ." minute"))==$inputs['event_start']) selected @endif>
        {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}</option>
        @endfor
        @endslot

        {{-- スロット --}}
        @slot('event_finish_loop')
        @for ($start = 0*2; $start <=23*2; $start++) <option
          value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (date("H:i:s", strtotime("00:00
          +". $start * 30 ." minute"))==$inputs['event_finish']) selected @endif>
          {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}</option>
          @endfor
          @endslot

          {{-- スロット --}}
          @slot('event_name1')
          {{ Form::text('event_name1', $inputs['event_name1'],['class'=>'form-control', 'id'=>'eventname1Count'] ) }}
          @endslot

          {{-- スロット --}}
          @slot('event_name2')
          {{ Form::text('event_name2', $inputs['event_name2'],['class'=>'form-control', 'id'=>'eventname2Count'] ) }}
          @endslot

          {{-- スロット --}}
          @slot('event_owner')
          {{ Form::text('event_owner', $inputs['event_owner'],['class'=>'form-control', 'id'=>'eventownerCount'] ) }}
          @endslot

          {{-- スロット --}}
          @slot('m_equipment_loop')
          @foreach ($venue->getEquipments() as $key=>$equ)
          <tr>
            <td class="table-active">
              {{$equ->item}}
            </td>
            <td>
              {{Form::text('equipment_breakdown'.$key,$inputs['equipment_breakdown'.$key],['class'=>'form-control'])}}
            </td>
          </tr>
          @endforeach
          @endslot

          {{-- スロット --}}
          @slot('m_service_loop')
          @foreach ($venue->getServices() as $key=>$service)
          <tr>
            <td class="table-active">{{$service->item}}</td>
            <td>
              <div class="radio-box">
                <p>
                  {{Form::radio('services_breakdown'.$key, 1, $inputs['services_breakdown'.$key]==1?true:false , ['id' => 'service'.$key.'on'])}}
                  {{Form::label('service'.$key.'on',"有り")}}
                </p>
                <p>
                  {{Form::radio('services_breakdown'.$key, 0, $inputs['services_breakdown'.$key]==0?true:false, ['id' => 'service'.$key.'off'])}}
                  {{Form::label('service'.$key.'off',"無し")}}
                </p>
              </div>
            </td>
          </tr>
          @endforeach
          @endslot

          {{-- スロット --}}
          @slot('m_layout_loop')
          @if ($venue->layout_prepare)
          <tr>
            <td class="table-active">準備</td>
            <td>
              <div class="radio-box">
                <p>
                  {{Form::radio('layout_prepare', 1, $inputs['layout_prepare']==1?true:false, ['id' => 'layout_prepare'])}}
                  {{Form::label('layout_prepare',"有り")}}
                </p>
                <p>
                  {{Form::radio('layout_prepare', 0, $inputs['layout_prepare']==0?true:false, ['id' => 'no_layout_prepare'])}}
                  {{Form::label('no_layout_prepare',"無し")}}
                </p>
              </div>
            </td>
          </tr>
          @endif
          @if ($venue->layout_clean)
          <tr>
            <td class="table-active">準備</td>
            <td>
              <div class="radio-box">
                <p>
                  {{Form::radio('layout_clean', 1, $inputs['layout_clean']==1?true:false, ['id' => 'layout_clean'])}}
                  {{Form::label('layout_clean',"有り")}}
                </p>
                <p>
                  {{Form::radio('layout_clean', 0, $inputs['layout_clean']==0?true:false, ['id' => 'no_layout_clean'])}}
                  {{Form::label('no_layout_clean',"無し")}}
                </p>
              </div>
            </td>
          </tr>
          @endif
          @endslot

          {{-- スロット --}}
          @slot('luggage_count')
          {{ Form::text('luggage_count', $inputs['luggage_count'],['class'=>'form-control'] ) }}
          @endslot

          {{-- スロット --}}
          @slot('luggage_arrive')
          {{ Form::text('luggage_arrive', $inputs['luggage_arrive'],['class'=>'form-control'] ) }}
          @endslot

          {{-- スロット --}}
          @slot('luggage_return')
          {{ Form::text('luggage_return', $inputs['luggage_return'],['class'=>'form-control'] ) }}
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
          {{-- <a class="more_btn" href="{{url('admin/clients/'.$reservation->user_id)}}">顧客詳細</a> --}}
          @endslot

          {{-- スロット --}}
          @slot('form_submit1')
          {{Form::submit('再計算する', ['class'=>'btn more_btn4_lg mx-auto d-block mt-5 mb-5', 'id'=>'check_submit'])}}
          @endslot

          {{-- スロット --}}
          @slot('form_close1')
          {{-- {{Form::close()}} --}}
          @endslot

          {{-- スロット --}}
          @slot('form_open2')
          {{-- {{ Form::open(['url' => '###################', 'method'=>'POST', 'id'=>'reservations_calculate_form']) }}
          --}}
          @csrf
          @endslot

          {{-- スロット --}}
          @slot('master_total')
          {{-- {{number_format($reservation->bills->first()->master_total)}} --}}
          @endslot

          {{-- スロット --}}
          @slot('payment_limit')
          {{-- {{ReservationHelper::formatDate($reservation->bills->first()->payment_limit)}} --}}
          @endslot

          {{-- スロット --}}
          @slot('venue_breakdown_loop')
          {{-- @foreach ($reservation->bills->first()->breakdowns->where('unit_type',1) as $v_key=>$venue_break)
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
          @endforeach --}}
          @endslot


          {{-- スロット --}}
          @slot('equipment_breakdown_loop')
          {{-- @foreach ($reservation->bills->first()->breakdowns->where('unit_type',2) as $e_key=>$equipment_break)
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
          @endforeach --}}
          @endslot

          {{-- スロット --}}
          @slot('service_breakdown_loop')
          {{-- @foreach ($reservation->bills->first()->breakdowns->where('unit_type',3) as $s_key=>$service_break)
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
          @endforeach --}}
          @endslot

          {{-- スロット --}}
          @slot('equipment_price')
          {{-- {{ Form::text('equipment_price', $reservation->bills->first()->equipment_price,['class'=>'form-control', 'readonly'] ) }}
          --}}
          @endslot

          {{-- スロット --}}
          @slot('layout_breakdown_loop')
          {{-- @foreach ($reservation->bills->first()->breakdowns->where('unit_type',4) as $l_key=>$layout_break)
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
          @endforeach --}}
          @endslot

          {{-- スロット --}}
          @slot('layout_price')
          {{-- {{ Form::text('layout_price',$reservation->bills->first()->layout_price ,['class'=>'form-control', 'readonly'] ) }}
          --}}
          @endslot

          {{-- スロット --}}
          @slot('others_breakdown_loop')
          {{-- @foreach ($reservation->bills->first()->breakdowns->where('unit_type',5) as $o_key=>$other_break) --}}
          {{-- <tr>
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
          </tr> --}}
          {{-- @endforeach --}}
          @endslot

          {{-- スロット --}}
          @slot('others_price')
          {{-- {{ Form::text('others_price', $reservation->bills->first()->others_price,['class'=>'form-control', 'readonly'] ) }}
          --}}
          @endslot

          {{-- スロット --}}
          @slot('master_subtotal')
          {{-- {{ Form::text('master_subtotal', $reservation->bills->first()->master_subtotal,['class'=>'form-control', 'readonly'] ) }}
          --}}
          @endslot

          {{-- スロット --}}
          @slot('master_tax')
          {{-- {{ Form::text('master_tax', $reservation->bills->first()->master_tax,['class'=>'form-control', 'readonly'] ) }}
          --}}
          @endslot

          {{-- スロット --}}
          @slot('master_total1')
          {{-- {{$reservation->bills->first()->master_total}} --}}
          @endslot

          {{-- スロット --}}
          @slot('master_total2')
          {{-- {{ Form::text('master_total', $reservation->bills->first()->master_total,['class'=>'form-control', 'readonly'] ) }}
          --}}
          @endslot

          {{-- スロット --}}
          @slot('bill_created_at')
          {{-- {{ Form::text('bill_created_at', $reservation->bills->first()->bill_created_at,['class'=>'form-control', 'id'=>'datepicker6'] ) }}
          --}}
          @endslot

          {{-- スロット --}}
          @slot('pay_limit')
          {{-- {{ Form::text('pay_limit', $reservation->bills->first()->pay_limit,['class'=>'form-control', 'id'=>'datepicker6'] ) }}
          --}}
          @endslot

          {{-- スロット --}}
          @slot('pay_company')
          {{-- {{ Form::text('pay_company', $reservation->agent->company,['class'=>'form-control'] ) }} --}}
          @endslot

          {{-- スロット --}}
          @slot('bill_person')
          {{-- {{ Form::text('bill_person', $reservation->agent->bill_person,['class'=>'form-control'] ) }} --}}
          @endslot
          {{-- スロット --}}
          @slot('bill_remark')
          {{-- {{ Form::textarea('bill_remark', $reservation->agent->bill_remark,['class'=>'form-control'] ) }} --}}
          @endslot
          {{-- スロット --}}
          @slot('paid_select')
          {{-- <option value="0" {{$reservation->bills->first()->paid==0?'selected':''}}>未入金</option>
          <option value="1" {{$reservation->bills->first()->paid==1?'selected':''}}>入金済み</option> --}}
          @endslot
          {{-- スロット --}}
          @slot('pay_day')
          {{-- {{ Form::text('pay_day', $reservation->bills->first()->pay_day,['class'=>'form-control', 'id'=>'datepicker7'] ) }}
          --}}
          @endslot
          {{-- スロット --}}
          @slot('pay_person')
          {{-- {{ Form::text('pay_person', $reservation->bills->first()->pay_person,['class'=>'form-control'] ) }} --}}
          @endslot
          {{-- スロット --}}
          @slot('payment')
          {{-- {{ Form::text('payment', $reservation->bills->first()->payment,['class'=>'form-control'] ) }} --}}
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
          @foreach ($agents as $agent)
          <option value="{{$agent->id}}" @if ($agent->id==$inputs['agent_id'])
            selected
            @endif
            >{{$agent->name}} | {{ReservationHelper::getAgentPerson($agent->id)}} | {{$agent->email}}
          </option>
          @endforeach
          @endslot

          {{-- スロット --}}
          @slot('agent_person')
          {{ReservationHelper::getAgentPerson($inputs['agent_id'])}}
          @endslot

          {{-- スロット --}}
          @slot('end_user')
          {{ Form::text('enduser_company', $inputs['enduser_company'],['class'=>'form-control', 'placeholder'=>'入力してください','id'=>'enduser_company'] ) }}

          @endslot

          {{-- スロット --}}
          @slot('end_user_address')
          {{ Form::text('enduser_address', $inputs['enduser_address'],['class'=>'form-control', 'placeholder'=>'入力してください','id'=>'enduser_address'] ) }}

          @endslot

          {{-- スロット --}}
          @slot('end_user_tel')
          {{ Form::text('enduser_tel', $inputs['enduser_tel'],['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'enduser_tel'] ) }}

          @endslot

          {{-- スロット --}}
          @slot('end_user_email')
          {{ Form::text('enduser_mail', $inputs['enduser_mail'],['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'enduser_mail'] ) }}

          @endslot


          {{-- スロット --}}
          @slot('end_user_person')
          {{ Form::text('enduser_incharge', $inputs['enduser_incharge'],['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'enduser_incharge'] ) }}
          @endslot

          {{-- スロット --}}
          @slot('end_user_mobile')
          {{ Form::text('enduser_mobile', $inputs['enduser_mobile'],['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'enduser_mobile'] ) }}
          @endslot

          {{-- スロット --}}
          @slot('end_user_attr')
          <select name="enduser_attr" class="form-control">
            <option value="1" {{$inputs['enduser_attr']==1?"selected":""}}>一般企業</option>
            <option value="2" {{$inputs['enduser_attr']==2?"selected":""}}>上場企業</option>
            <option value="3" {{$inputs['enduser_attr']==3?"selected":""}}>近隣利用</option>
            <option value="4" {{$inputs['enduser_attr']==4?"selected":""}}>個人講師</option>
            <option value="5" {{$inputs['enduser_attr']==5?"selected":""}}>MLM</option>
            <option value="6" {{$inputs['enduser_attr']==6?"selected":""}}>その他</option>
          </select>
          @endslot

          {{-- スロット --}}
          @slot('end_user_charge')
          {{ Form::text('enduser_charge', $inputs['enduser_charge'],['class'=>'form-control ', 'placeholder'=>'入力してください'] ) }}
          @endslot

          {{-- スロット --}}
          @slot('user_details')
          {{ Form::textarea('user_details', $inputs['user_details'],['class'=>'form-control ', 'placeholder'=>'入力してください'] ) }}

          @endslot

          {{-- スロット --}}
          @slot('admin_details')
          {{ Form::textarea('admin_details', $inputs['admin_details'],['class'=>'form-control ', 'placeholder'=>'入力してください'] ) }}

          @endslot









          @endcomponent
          @endsection