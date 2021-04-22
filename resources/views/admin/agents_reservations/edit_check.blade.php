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
  {{ Form::open(['url' => 'admin/agents_reservations/show_input', 'method'=>'get', 'class'=>'']) }}
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
  {{Form::text("",$inputs['price_system']==1?"通常(枠貸)":"アクセア(時間貸)",['class'=>'form-control','readonly'])}}
  @endslot

  {{-- スロット --}}
  @slot('price_system2')
  @endslot

  {{-- スロット --}}
  @slot('price_system2')
  @endslot

  {{-- スロット --}}
  @slot('enter_time_loop')
  {{Form::text("",$inputs['enter_time'],['class'=>'form-control','readonly'])}}
  @endslot

  {{-- スロット --}}
  @slot('leave_time_loop')
  {{Form::text("",$inputs['leave_time'],['class'=>'form-control','readonly'])}}
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
  {{Form::text("",$inputs['event_start'],['class'=>'form-control','readonly'])}}
  @endslot

  {{-- スロット --}}
  @slot('event_finish_loop')
  {{Form::text("",$inputs['event_finish'],['class'=>'form-control','readonly'])}}
  @endslot

  {{-- スロット --}}
  @slot('event_name1')
  {{ Form::text('event_name1', $inputs['event_name1'],['class'=>'form-control','readonly', 'id'=>'eventname1Count'] ) }}
  @endslot

  {{-- スロット --}}
  @slot('event_name2')
  {{ Form::text('event_name2', $inputs['event_name2'],['class'=>'form-control', 'id'=>'eventname2Count','readonly'] ) }}
  @endslot

  {{-- スロット --}}
  @slot('event_owner')
  {{ Form::text('event_owner', $inputs['event_owner'],['class'=>'form-control', 'id'=>'eventownerCount','readonly'] ) }}
  @endslot

  {{-- スロット --}}
  @slot('m_equipment_loop')
  @foreach ($venue->getEquipments() as $key=>$equ)
  <tr>
    <td class="table-active">
      {{$equ->item}}
    </td>
    <td>
      {{Form::text('equipment_breakdown'.$key,$inputs['equipment_breakdown'.$key],['class'=>'form-control','readonly'])}}
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
      {{Form::text('',$inputs['services_breakdown'.$key]==1?"あり":"なし",['class'=>'form-control','readonly'])}}
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
      {{Form::text('',$inputs['layout_prepare']==1?"あり":"なし",['class'=>'form-control','readonly'])}}
    </td>
  </tr>
  @endif
  @if ($venue->layout_clean)
  <tr>
    <td class="table-active">準備</td>
    <td>
      {{Form::text('',$inputs['layout_clean']==1?"あり":"なし",['class'=>'form-control','readonly'])}}
    </td>
  </tr>
  @endif
  @endslot

  {{-- スロット --}}
  @slot('luggage_count')
  {{ Form::text('luggage_count', $inputs['luggage_count'],['class'=>'form-control','readonly'] ) }}
  @endslot

  {{-- スロット --}}
  @slot('luggage_arrive')
  {{ Form::text('luggage_arrive', $inputs['luggage_arrive'],['class'=>'form-control','readonly'] ) }}
  @endslot

  {{-- スロット --}}
  @slot('luggage_return')
  {{ Form::text('luggage_return', $inputs['luggage_return'],['class'=>'form-control','readonly'] ) }}
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
  {{Form::close()}}
  @endslot

  {{-- スロット --}}
  @slot('form_open2')
  {{ Form::open(['url' => 'admin/agents_reservations/update', 'method'=>'post', 'class'=>'']) }}
  @csrf
  @endslot


  {{-- スロット --}}
  @slot('payment_limit')
  {{$payment_limit}}
  @endslot

  {{-- スロット --}}
  @slot('venue_breakdown_loop')
  <tr>
    <td>
      {{ Form::text('venue_breakdown_item0', "会場料金",['class'=>'form-control', 'readonly'] ) }}
    </td>
    <td><input class="form-control" readonly></td>
    <td>
      {{ Form::text('venue_breakdown_count0', $usage_hours."h",['class'=>'form-control', 'readonly'] ) }}
    </td>
    <td><input class="form-control" readonly></td>
  </tr>
  @endslot


  {{-- スロット --}}
  @slot('equipment_breakdown_loop')
  @foreach ($venue->getEquipments() as $key=>$equipment)
  @if (!empty($inputs['equipment_breakdown'.$key]))
  <tr>
    <td>
      {{ Form::text('equipment_breakdown_item'.$key, $equipment->item,['class'=>'form-control', 'readonly'] ) }}
    </td>
    <td><input class="form-control" readonly></td>
    <td>
      {{ Form::text('equipment_breakdown_count'.$key, $inputs['equipment_breakdown'.$key],['class'=>'form-control', 'readonly'] ) }}
    </td>
    <td><input class="form-control" readonly></td>
  </tr>
  @endif
  @endforeach
  @endslot

  {{-- スロット --}}
  @slot('service_breakdown_loop')
  @foreach ($venue->getServices() as $key=>$service)
  @if (!empty($inputs['services_breakdown'.$key]))
  <tr>
    <td>
      {{ Form::text('service_breakdown_item'.$key, $service->item,['class'=>'form-control', 'readonly'] ) }}
    </td>
    <td><input class="form-control" readonly></td>
    <td>
      {{ Form::text('service_breakdown_count'.$key, $inputs['services_breakdown'.$key],['class'=>'form-control', 'readonly'] ) }}
    </td>
    <td><input class="form-control" readonly></td>
  </tr>
  @endif
  @endforeach
  @endslot

  {{-- スロット --}}
  @slot('equipment_price')
  {{-- {{ Form::text('equipment_price', $reservation->bills->first()->equipment_price,['class'=>'form-control', 'readonly'] ) }}
  --}}
  @endslot


  {{-- スロット --}}
  @slot('layout_breakdown_loop')
  @if ($inputs['layout_prepare']!=0)
  <tr>
    <td>{{ Form::text('layout_prepare_item', "レイアウト準備料金",['class'=>'form-control', 'readonly'] ) }}</td>
    <td>
      {{ Form::text('layout_prepare_cost', $layoutPrice[0],['class'=>'form-control', 'readonly'] ) }}
    </td>
    <td>{{ Form::text('layout_prepare_count', 1,['class'=>'form-control', 'readonly'] )}}</td>
    <td>
      {{ Form::text('layout_prepare_subtotal', $venue->getLayouts()[0],['class'=>'form-control', 'readonly'] ) }}
    </td>
  </tr>
  @endif
  @if ($inputs['layout_clean']!=0)
  <tr>
    <td>{{ Form::text('layout_clean_item', "レイアウト片付料金",['class'=>'form-control', 'readonly'] ) }}</td>
    <td>
      {{ Form::text('layout_clean_cost', $layoutPrice[1],['class'=>'form-control', 'readonly'] ) }}
    </td>
    <td>{{ Form::text('layout_clean_count', 1,['class'=>'form-control', 'readonly'] )}}</td>
    <td>
      {{ Form::text('layout_clean_subtotal', $venue->getLayouts()[1],['class'=>'form-control', 'readonly'] ) }}
    </td>
  </tr>
  @endif
  @endslot


  {{-- スロット --}}
  @slot('layout_price')
  {{ Form::text('layout_price',$layoutPrice[2] ,['class'=>'form-control', 'readonly'] ) }}
  @endslot

  {{-- スロット --}}
  @slot('others_breakdown_loop')
  @for ($i = 0; $i < count($result["others_input_item"]); $i++) <tr>
    <td>
      {{ Form::text('others_breakdown_item'.$i, $result['others_input_item'][$i],['class'=>'form-control','readonly'] ) }}
    </td>
    <td>
      <input class="form-control" readonly></td>
    <td>
      {{ Form::text('others_breakdown_count'.$i, $result['others_input_count'][$i],['class'=>'form-control','readonly'] ) }}
    </td>
    <td>
      <input class="form-control" readonly></td>
    </tr>
    @endfor
    @endslot

    {{-- スロット --}}
    @slot('others_price')
    {{-- {{ Form::text('others_price', $reservation->bills->first()->others_price,['class'=>'form-control', 'readonly'] ) }}
    --}}
    @endslot

    {{-- スロット --}}
    @slot('master_subtotal')
    {{ Form::text('master_subtotal', ($price),['class'=>'form-control', 'readonly'] ) }}
    @endslot

    {{-- スロット --}}
    @slot('master_tax')
    {{ Form::text('master_tax', (ReservationHelper::getTax($price)),['class'=>'form-control', 'readonly'] ) }}
    @endslot

    {{-- スロット --}}
    @slot('master_total1')
    {{number_format(ReservationHelper::taxAndPrice($price))}}
    @endslot

    {{-- スロット --}}
    @slot('master_total2')
    {{ Form::text('master_total', (ReservationHelper::taxAndPrice($price)),['class'=>'form-control', 'readonly'] ) }}
    @endslot

    {{-- スロット --}}
    @slot('bill_created_at')
    {{ Form::text('bill_created_at', $bill->bill_created_at,['class'=>'form-control', 'id'=>'datepicker6','readonly'] ) }}
    @endslot

    {{-- スロット --}}
    @slot('pay_limit')
    {{ Form::text('pay_limit', $payment_limit,['class'=>'form-control', 'id'=>'datepicker6','readonly'] ) }}
    @endslot

    {{-- スロット --}}
    @slot('pay_company')
    {{ Form::text('pay_company', ReservationHelper::getAgentCompanyName($inputs['agent_id']),['class'=>'form-control','readonly'] ) }}
    @endslot

    {{-- スロット --}}
    @slot('bill_person')
    {{ Form::text('bill_person', ReservationHelper::getAgentPerson($inputs['agent_id']),['class'=>'form-control','readonly'] ) }}
    @endslot

    {{-- スロット --}}
    @slot('bill_remark')
    {{ Form::textarea('bill_remark', $result['bill_remark'],['class'=>'form-control','readonly'] ) }}
    @endslot

    {{-- スロット --}}
    @slot('paid_select')
    {{ Form::text('', $bill->paid==0?"未入金":"入金済",['class'=>'form-control','readonly'] ) }}
    @endslot

    {{-- スロット --}}
    @slot('pay_day')
    {{ Form::text('pay_day', date('Y-m-d',strtotime($bill->pay_day)),['class'=>'form-control', 'id'=>'datepicker7','readonly'] ) }}
    @endslot

    {{-- スロット --}}
    @slot('pay_person')
    {{ Form::text('pay_person', $bill->pay_person,['class'=>'form-control','readonly'] ) }}
    @endslot
    {{-- スロット --}}
    @slot('payment')
    {{ Form::text('payment', $bill->payment,['class'=>'form-control','readonly'] ) }}
    @endslot

    {{-- スロット --}}
    @slot('form_submit2')
    {{Form::submit('編集を確定する', ['class'=>'btn more_btn_lg d-block btn-lg mx-auto mt-5 mb-5', 'id'=>'check_submit'])}}
    @endslot
    {{-- スロット --}}

    @slot('form_close2')
    {{Form::close()}}
    @endslot

    {{-- スロット --}}
    @slot('agent_select')
    {{ Form::text('', $agents->find($inputs['agent_id'])->company,['class'=>'form-control','readonly'] ) }}
    @endslot

    {{-- スロット --}}
    @slot('agent_person')
    {{ Form::text('', ReservationHelper::getAgentPerson($inputs['agent_id']),['class'=>'form-control','readonly'] ) }}

    @endslot

    {{-- スロット --}}
    @slot('end_user')
    {{ Form::text('enduser_company', $inputs['enduser_company'],['class'=>'form-control', 'placeholder'=>'入力してください','id'=>'enduser_company','readonly'] ) }}
    @endslot

    {{-- スロット --}}
    @slot('end_user_address')
    {{ Form::text('enduser_address', $inputs['enduser_address'],['class'=>'form-control', 'placeholder'=>'入力してください','id'=>'enduser_address','readonly'] ) }}
    @endslot

    {{-- スロット --}}
    @slot('end_user_tel')
    {{ Form::text('enduser_tel', $inputs['enduser_tel'],['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'enduser_tel','readonly']) }}
    @endslot

    {{-- スロット --}}
    @slot('end_user_email')
    {{ Form::text('enduser_mail', $inputs['enduser_mail'],['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'enduser_mail','readonly'] ) }}
    @endslot

    {{-- スロット --}}
    @slot('end_user_person')
    {{ Form::text('enduser_incharge', $inputs['enduser_incharge'],['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'enduser_incharge','readonly'] ) }}
    @endslot

    {{-- スロット --}}
    @slot('end_user_mobile')
    {{ Form::text('enduser_mobile', $inputs['enduser_mobile'],['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'enduser_mobile','readonly'] ) }}
    @endslot

    {{-- スロット --}}
    @slot('end_user_attr')
    {{ Form::text('enduser_attr', ReservationHelper::getAttr($inputs['enduser_attr']),['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'enduser_mobile','readonly'] ) }}
    @endslot

    {{-- スロット --}}
    @slot('end_user_charge')
    {{ Form::text('enduser_charge', $inputs['enduser_charge'],['class'=>'form-control ', 'placeholder'=>'入力してください','readonly'] ) }}
    @endslot

    {{-- スロット --}}
    @slot('user_details')
    {{ Form::textarea('user_details', $inputs['user_details'],['class'=>'form-control ', 'placeholder'=>'入力してください','readonly'] ) }}
    @endslot

    {{-- スロット --}}
    @slot('admin_details')
    {{ Form::textarea('admin_details', $inputs['admin_details'],['class'=>'form-control ', 'placeholder'=>'入力してください','readonly'] ) }}
    @endslot



    @endcomponent

    @endsection