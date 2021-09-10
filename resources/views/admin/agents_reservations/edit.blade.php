@extends('layouts.admin.app')
@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/admin/reservation.js') }}"></script>
<script src="{{ asset('/js/ajax_agent.js') }}"></script>
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/lettercounter.js') }}"></script>
<script src="{{ asset('/js/admin/agents_reservation/validation.js') }}"></script>
<script src="{{ asset('/js/admin/reservation/control_time_reject_self.js') }}"></script>
<script src="{{ asset('/js/holidays.js') }}"></script>

<div class="container-fluid">
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


  <div class="d-flex justify-content-end">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">

          {{-- {{ Breadcrumbs::render(Route::currentRouteName()) }} --}}

        </li>
      </ol>
    </nav>
  </div>


  <div id="fullOverlay">
    <div class="frame_spinner">
      <div class="spinner-border text-primary " role="status">
        <span class="sr-only hide">Loading...</span>
      </div>
    </div>
  </div>

  {{Form::open(['url' => 'admin/agents_reservations/edit_check', 'method' => 'POST', 'id'=>'agentReservationCalculateForm'])}}
  @csrf
  {{ Form::hidden('reservation_id', $reservation['id'])}}
  {{ Form::hidden('bill_id', $reservation->bills[0]['id'])}}
  <section class="mt-4">
    <div class="row">
      <div class="col">
        <table class="table table-bordered reserve_table">
          <tbody>
            <tr>
              <td colspan="2">
                <p class="title-icon">
                  <i class="fas fa-info-circle icon-size" aria-hidden="true"></i>予約情報
                </p>
              </td>
            </tr>
            <tr>
              <td class="table-active form_required">利用日</td>
              <td>
                {{ Form::hidden('reserve_date', $reservation['reserve_date'] ,['class'=>'form-control',  'placeholder'=>'入力してください','readonly'] ) }}
                {{ Form::text('', date('Y-m-d',strtotime($reservation['reserve_date'])),['class'=>'form-control',  'placeholder'=>'入力してください','readonly'] ) }}
                <p class="is-error-reserve_date" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active form_required">会場</td>
              <td>
                {{ Form::text('', ReservationHelper::getVenue($reservation['venue_id']) ,['class'=>'form-control',  'placeholder'=>'入力してください','readonly'] ) }}
                {{ Form::hidden('venue_id', $reservation['venue_id'] ,['class'=>'form-control',  'placeholder'=>'入力してください','readonly'] ) }}
                <p class="is-error-venue_id" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active form_required">料金体系</td>
              <td>
                <div class="price_radio_selector">
                  @if ((int)array_sum($venue->getPriceSystem())===2)
                  <div class="d-flex justfy-content-start align-items-center" id="price_system1">
                    {{ Form::radio('price_system', 1, (int)$reservation['price_system']===1?true:false, ['class'=>'mr-2', 'id'=>'price_system_radio1']) }}
                    {{Form::label('price_system_radio1','通常（枠貸）')}}
                  </div>
                  <div class="d-flex justfy-content-start align-items-center" id="price_system2">
                    {{ Form::radio('price_system', 2, (int)$reservation['price_system']===2?true:false, ['class'=>'mr-2','id'=>'price_system_radio2']) }}
                    {{Form::label('price_system_radio2','アクセア（時間貸）')}}
                  </div>
                  @elseif((int)$venue->getPriceSystem()[0]===1&&(int)$venue->getPriceSystem()[1]===0)
                  <div class="d-flex justfy-content-start align-items-center" id="price_system1">
                    {{ Form::radio('price_system', 1, true, ['class'=>'mr-2', 'id'=>'price_system_radio1']) }}
                    {{Form::label('price_system_radio1','通常（枠貸）')}}
                  </div>
                  @elseif((int)$venue->getPriceSystem()[0]===0&&(int)$venue->getPriceSystem()[1]===1)
                  <div class="d-flex justfy-content-start align-items-center" id="price_system2">
                    {{ Form::radio('price_system', 2, true, ['class'=>'mr-2','id'=>'price_system_radio2']) }}
                    {{Form::label('price_system_radio2','アクセア（時間貸）')}}
                  </div>
                  @endif
                </div>
              </td>
            </tr>
            <tr>
              <td class="table-active form_required">入室時間</td>
              <td>
                <div>
                  <select name="enter_time" id="sales_start" class="form-control">
                    <option disabled selected></option>
                    {!!ReservationHelper::timeOptionsWithRequest($reservation['enter_time'])!!}
                  </select>
                  <p class="is-error-enter_time" style="color: red"></p>
                </div>
              </td>
            </tr>
            <tr>
              <td class="table-active form_required">退室時間</td>
              <td>
                <div>
                  <select name="leave_time" id="sales_finish" class="form-control">
                    <option disabled selected></option>
                    {!!ReservationHelper::timeOptionsWithRequest($reservation['leave_time'])!!}
                  </select>
                  <p class="is-error-leave_time" style="color: red"></p>
                </div>
              </td>
            </tr>
          </tbody>
        </table>

        <table class="table table-bordered board-table">
          <tbody>
            <tr>
              <td colspan="2">
                <div class="d-flex align-items-center justify-content-between">
                  <p class="title-icon">
                    <i class="fas fa-clipboard icon-size" aria-hidden="true"></i>案内版
                  </p>
                </div>
              </td>
            </tr>
            <tr>
              <td class="table-active">案内板</td>
              <td>
                <div class="radio-box">
                  <p>
                    {{ Form::radio('board_flag', 1, $reservation['board_flag']==1?true:false, ['class'=>'', 'id'=>'board_flag']) }}
                    {{Form::label('board_flag','有り')}}
                  </p>
                  <p>
                    {{ Form::radio('board_flag', 0, $reservation['board_flag']==0?true:false, ['class'=>'', 'id'=>'no_board_flag']) }}
                    {{Form::label('no_board_flag','無し')}}
                  </p>
                </div>
              </td>
            </tr>
            <tr>
              <td class="table-active">イベント名称1</td>
              <td>
                <div class="align-items-end d-flex">
                  {{ Form::text('event_name1',!empty($reservation['event_name1'])?$reservation['event_name1']:"",['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'eventname1Count'] ) }}
                  <span class="ml-1 annotation count_num1"></span>
                </div>
                <p class="is-error-event_name1" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active">イベント名称2</td>
              <td>
                <div class="align-items-end d-flex">
                  {{ Form::text('event_name2',!empty($reservation['event_name2'])?$reservation['event_name2']:"",['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'eventname2Count'] ) }}
                  <span class="ml-1 annotation count_num2"></span>
                </div>
                <p class="is-error-event_name2" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active">主催者名</td>
              <td>
                <div class="align-items-end d-flex">
                  {{ Form::text('event_owner',!empty($reservation['event_owner'])?$reservation['event_owner']:"",['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'eventownerCount'] ) }}
                  <span class="ml-1 annotation count_num3"></span>
                </div>
                <p class="is-error-event_owner" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active">イベント開始時間</td>
              <td>
                <div>
                  <select name="event_start" id="event_start" class="form-control">
                    @if ($reservation['board_flag']==1)
                    <option value="" disabled>選択してください</option>
                    {!!ReservationHelper::timeOptionsWithRequestAndLimit($reservation['event_start'],$reservation['enter_time'],$reservation['leave_time'])!!}
                    @else
                    <option value="" selected></option>
                    {!!ReservationHelper::timeOptionsWithRequestAndLimit("",$reservation['enter_time'],$reservation['leave_time'])!!}
                    @endif
                  </select>
                </div>
              </td>
            </tr>
            <tr>
              <td class="table-active">イベント終了時間</td>
              <td>
                <div>
                  <select name="event_finish" id="event_finish" class="form-control">

                    @if ($reservation['board_flag']==1)
                    <option value="" disabled>選択してください</option>
                    {!!ReservationHelper::timeOptionsWithRequestAndLimit($reservation['event_finish'],$reservation['enter_time'],$reservation['leave_time'])!!}
                    @else
                    <option value="" selected></option>
                    {!!ReservationHelper::timeOptionsWithRequestAndLimit("",$reservation['enter_time'],$reservation['leave_time'])!!}
                    @endif
                  </select>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="equipemnts">
          <table class="table table-bordered">
            <thead class="accordion-ttl">
              <tr>
                <th colspan="2">
                  <p class="title-icon fw-bolder active">
                    <i class="fas fa-wrench icon-size" aria-hidden="true"></i>有料備品
                  </p>
                </th>
              </tr>
            </thead>
            <tbody class="accordion-wrap2">
              @foreach ($venue->getEquipments() as $key=>$equipment)
              <tr>
                <td class="table-active">
                  {{$equipment->item}}
                </td>
                <td>
                  <div class="d-flex align-items-end">
                    @foreach ($reservation['bills'][0]['breakdowns'] as $key=>$value)
                    @if ($value['unit_item']===$equipment->item)
                    {{ Form::text('equipment_breakdown[]', $value['unit_count'],['class'=>'form-control equipment_breakdown'] ) }}
                    @break
                    @elseif($loop->last)
                    {{ Form::text('equipment_breakdown[]', "",['class'=>'form-control equipment_breakdown'] ) }}
                    @endif
                    @endforeach
                    <span class="ml-1">個</span>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="services">
          <table class="table table-bordered">
            <thead class="accordion-ttl">
              <tr>
                <th colspan="2">
                  <p class="title-icon fw-bolder active">
                    <i class="fas fa-hand-holding-heart icon-size" aria-hidden="true"></i>有料サービス
                  </p>
                </th>
              </tr>
            </thead>
            <tbody class="accordion-wrap2">
              @foreach ($venue->getServices() as $key=>$service)
              <tr>
                <td class="table-active">
                  {{$service->item}}
                </td>
                <td>
                  <div class="radio-box">
                    @foreach ($reservation['bills'][0]['breakdowns'] as $s_key=>$value)
                    @if ($value['unit_item']===$service->item)
                    <p>
                      {{Form::radio('services_breakdown['.$key.']', 1, true , ['id' => 'service'.$key.'on', 'class' => ''])}}
                      {{Form::label('service'.$key.'on','有り')}}
                    </p>
                    <p>
                      {{Form::radio('services_breakdown['.$key.']', 0, false, ['id' => 'service'.$key.'off', 'class' => ''])}}
                      {{Form::label('service'.$key.'off','無し')}}
                    </p>
                    @break
                    @elseif($loop->last)
                    <p>
                      {{Form::radio('services_breakdown['.$key.']', 1, false , ['id' => 'service'.$key.'on', 'class' => ''])}}
                      {{Form::label('service'.$key.'on','有り')}}
                    </p>
                    <p>
                      {{Form::radio('services_breakdown['.$key.']', 0, true, ['id' => 'service'.$key.'off', 'class' => ''])}}
                      {{Form::label('service'.$key.'off','無し')}}
                    </p>
                    @endif
                    @endforeach
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        @if ($venue->layout!=0)
        <div class="layouts">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th colspan="2">
                  <p class="title-icon">
                    <i class="fas fa-th icon-size fa-fw" aria-hidden="true"></i>レイアウト
                  </p>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="table-active">準備
                  ({{number_format($venue->layout_prepare)}}
                  円)</td>
                <td>
                  <div class="radio-box">
                    <p>
                      {{Form::radio('layout_prepare', 1, collect($reservation['bills'][0]['breakdowns'])->contains('unit_item','レイアウト準備料金')?true:false, ['id' => 'layout_prepare', 'class' => ''])}}
                      <label for='layout_prepare' class="form-check-label">有り</label>
                    </p>
                    <p>
                      {{Form::radio('layout_prepare', 0, collect($reservation['bills'][0]['breakdowns'])->contains('unit_item','レイアウト準備料金')?false:true, ['id' => 'no_layout_prepare', 'class' => ''])}}
                      <label for='no_layout_prepare' class="form-check-label">無し</label>
                    </p>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="table-active">片付
                  ({{number_format($venue->layout_clean)}}
                  円)</td>
                <td>
                  <div class="radio-box">
                    <p>
                      {{Form::radio('layout_clean', 1, collect($reservation['bills'][0]['breakdowns'])->contains('unit_item','レイアウト片付料金')?true:false, ['id' => 'layout_clean', 'class' => ''])}}
                      <label for='layout_clean' class="form-check-label">有り</label>
                    </p>
                    <p>
                      {{Form::radio('layout_clean', 0, collect($reservation['bills'][0]['breakdowns'])->contains('unit_item','レイアウト片付料金')?false:true, ['id' => 'no_layout_clean', 'class' => ''])}}
                      <label for='no_layout_clean' class="form-check-label">無し</label>
                    </p>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        @endif

        @if ($venue->luggage_flag!=0)
        <div class="luggage">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th colspan="2">
                  <p class="title-icon">
                    <i class="fas fa-suitcase-rolling icon-size fa-fw" aria-hidden="true"></i>荷物預り
                  </p>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="table-active">荷物預かり 工藤さん！！こちら</td>
                <td>
                  <div class="radio-box">
                    <p>
                      <input id="luggage_flag" name="luggage_flag" type="radio" value="1">
                      <label for="" class="form-check-label">有り</label>
                    </p>
                    <p>
                      <input id="no_luggage_flag" name="luggage_flag" type="radio" value="0">
                      <label for="" class="form-check-label">無し</label>
                    </p>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="table-active">事前に預かる荷物<br>（個数）</td>
                <td>
                  {{ Form::number('luggage_count', $reservation['luggage_count'],['class'=>'form-control','id'=>'luggage_count'] ) }}
                  <p class="is-error-luggage_count" style="color: red"></p>
                </td>
              </tr>
              <tr>
                <td class="table-active">事前荷物の到着日<br>午前指定のみ</td>
                <td>
                  {{ Form::text('luggage_arrive', !empty($reservation['luggage_arrive'])?date('Y-m-d',strtotime($reservation['luggage_arrive'])):"",['class'=>'form-control holidays','id'=>'luggage_arrive'] ) }}
                </td>
              </tr>
              <tr>
                <td class="table-active">事後返送する荷物</td>
                <td>
                  {{ Form::number('luggage_return', $reservation['luggage_return'],['class'=>'form-control','id'=>'luggage_return'] ) }}
                  <p class="is-error-luggage_return" style="color: red"></p>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        @endif

        @if ($venue->eat_in_flag!=0)
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
                  {{Form::radio('eat_in', 1, $reservation['eat_in']==1?true:false , ['id' => 'eat_in'])}}
                  {{Form::label('eat_in',"あり")}}
                </td>
                <td>
                  {{Form::radio('eat_in_prepare', 1, !empty($reservation['eat_in_prepare'])?($reservation['eat_in_prepare']==1?true:false):false , ['id' => 'eat_in_prepare', $reservation['eat_in']!=1?'disabled':''])}}
                  {{Form::label('eat_in_prepare',"手配済み")}}
                  {{Form::radio('eat_in_prepare', 2, !empty($reservation['eat_in_prepare'])?($reservation['eat_in_prepare']==2?true:false):false , ['id' => 'eat_in_consider',$reservation['eat_in']!=1?'disabled':''])}}
                  {{Form::label('eat_in_consider',"検討中")}}
                </td>
              </tr>
              <tr>
                <td>
                  {{Form::radio('eat_in', 0, $reservation['eat_in']==0?true:false , ['id' => 'no_eat_in'])}}
                  {{Form::label('no_eat_in',"なし")}}
                </td>
                <td></td>
              </tr>
            </tbody>
          </table>
        </div>
        @endif




      </div>

      <div class="col">
        <table class="table table-bordered name-table">
          <tbody>
            <tr>
              <td colspan="2">
                <div class="d-flex align-items-center justify-content-between">
                  <p class="title-icon">
                    <i class="far fa-id-card icon-size" aria-hidden="true"></i>仲介会社情報
                  </p>
                  <p><a class="more_btn" href="">仲介会社詳細</a></p>
                </div>
              </td>
            </tr>
            <tr>
              <td class="table-active">
                <label for="agent_id" class=" form_required">サービス名称</label>
              </td>
              <td>
                <select class="form-control" name="agent_id" id="agent_select">
                  <option disabled selected>選択してください</option>
                  @foreach ($agents as $agent)
                  <option value="
                  {{$agent->id}}" @if ($agent->id==$reservation['agent_id'])
                    selected
                    @endif
                    >
                    {{ReservationHelper::getAgentCompany($agent->id)}}
                    |
                    {{ReservationHelper::getAgentPerson($agent->id)}}
                    |
                    {{$agent->email}}
                  </option>
                  @endforeach
                </select>
                <p class="is-error-user_id" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="name">担当者氏名<br></label></td>
              <td>
                <p class="selected_person">
                  {{ReservationHelper::getAgentPerson($reservation['agent_id'])}}
                </p>
              </td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered oneday-table">
          <tbody>
            <tr>
              <td colspan="2">
                <p class="title-icon">
                  <i class="fas fa-user-check icon-size" aria-hidden="true"></i>エンドユーザー情報
                </p>
              </td>
            </tr>
            <tr>
              <td class="table-active">
                <label for="enduser_company" class="">エンドユーザー</label>
              </td>
              <td>
                {{ Form::text('enduser_company', $reservation['enduser_company'],['class'=>'form-control', 'placeholder'=>'入力してください','id'=>'enduser_company'] ) }}
              </td>
            </tr>
            <tr>
              <td class="table-active">
                <label for="enduser_address" class=" ">住所</label>
              </td>
              <td>
                {{ Form::text('enduser_address', $reservation['enduser_address'],['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'enduser_address'] ) }}
              </td>
            </tr>
            <tr>
              <td class="table-active">
                <label for="enduser_tel" class="">連絡先</label>
              </td>
              <td>
                {{ Form::text('enduser_tel', $reservation['enduser_tel'],['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'enduser_tel'] ) }}
                <p class="is-error-enduser_tel" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active">
                <label for="enduser_mail" class=" ">メールアドレス</label>
              </td>
              <td>
                {{ Form::text('enduser_mail', $reservation['enduser_mail'],['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'enduser_mail'] ) }}
                <p class="is-error-enduser_mail" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active">
                <label for="enduser_incharge" class="">当日担当者</label>
              </td>
              <td>
                {{ Form::text('enduser_incharge', $reservation['enduser_incharge'],['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'enduser_incharge'] ) }}
              </td>
            </tr>
            <tr>
              <td class="table-active">
                <label for="enduser_mobile" class="">当日連絡先</label>
              </td>
              <td>
                {{ Form::text('enduser_mobile', $reservation['enduser_mobile'],['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'enduser_mobile'] ) }}
                <p class="is-error-enduser_mobile" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active">
                <label for="enduser_attr" class="">利用者属性</label>
              </td>
              <td>
                <select name="enduser_attr" class="form-control">
                  <option value="1" {{$reservation['enduser_attr']==1?"selected":""}}>一般企業</option>
                  <option value="2" {{$reservation['enduser_attr']==2?"selected":""}}>上場企業</option>
                  <option value="3" {{$reservation['enduser_attr']==3?"selected":""}}>近隣利用</option>
                  <option value="4" {{$reservation['enduser_attr']==4?"selected":""}}>個人講師</option>
                  <option value="5" {{$reservation['enduser_attr']==5?"selected":""}}>MLM</option>
                  <option value="6" {{$reservation['enduser_attr']==6?"selected":""}}>その他</option>
                </select>
              </td>
            </tr>
          </tbody>
        </table>
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
              <td class="table-active form_required">
                <label for="end_user_charge ">支払い料</label>
              </td>
              <td>
                <div class="d-flex align-items-center">
                  {{ Form::text('end_user_charge', $reservation->bills[0]->end_user_charge,['class'=>'form-control sales_percentage', 'placeholder'=>'入力してください'] ) }}
                  <span class="ml-1">円</span>
                </div>
                <p class="is-error-end_user_charge" style="color: red"></p>
              </td>
            </tr>
          </tbody>
        </table>

        @if ($venue->alliance_flag!=0)
        <table class="table table-bordered sale-table" id="user_cost">
          <tbody>
            <tr>
              <td colspan="2">
                <p class="title-icon">
                  <i class="fas fa-yen-sign icon-size" aria-hidden="true"></i>売上原価<span
                    class="annotation">（提携会場を選択した場合、提携会場で設定した原価率が適応されます）</span>
                </p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="cost">原価率</label></td>
              <td class="d-flex align-items-center">
                {{Form::text('cost',$reservation['cost'],['class'=>'form-control sales_percentage'])}}
                <span class="ml-1">%</span>
                <p class="is-error-cost" style="color: red"></p>
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
                  <i class="fas fa-envelope icon-size" aria-hidden="true"></i>備考
                </p>
              </td>
            </tr>
            <tr>
              <td>
                <label for="adminNote">管理者備考</label>
                {{ Form::textarea('admin_details', $reservation['admin_details'],['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  {{Form::submit('再計算する', ['class'=>'my-5 btn more_btn4_lg mx-auto d-block btn-lg', 'id'=>'check_submit','name'=>'edit_calc'])}}

  {{-- {{Form::close()}} --}}





  {{-- {{ Form::open(['url' => 'admin/agents_reservations/check_session', 'method'=>'POST', 'id'=>'agents_calculate_form']) }}
  --}}

  <section class="">
    <div class="bill">
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
                  <dd class="total_result">
                    {{ReservationHelper::taxAndPrice($reservation->bills[0]->master_subtotal)}}
                    円</dd>
                </dl>
              </td>
              <td>
                <dl class="ttl_box">
                  <dt>支払い期日</dt>
                  <dd class="total_result">
                    {{ReservationHelper::formatDate($reservation->bills[0]->payment_limit)}}
                  </dd>
                </dl>
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
        <div class="main">
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
                @foreach ($reservation->bills[0]->breakdowns->where('unit_type',1) as $item)
                <tr>
                  <td>
                    {{ Form::text('venue_breakdown_item[]', $item['unit_item'],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    <input class="form-control" readonly>
                    {{ Form::hidden('venue_breakdown_cost[]', "" ) }}
                  </td>
                  <td>
                    {{ Form::text('venue_breakdown_count[]', $item['unit_count'],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    <input class="form-control" readonly>
                    {{ Form::hidden('venue_breakdown_subtotal[]', '' ) }}
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          @if ($reservation->bills[0]->breakdowns->contains('unit_type',2)
          ||
          $reservation->bills[0]->breakdowns->contains('unit_type', 3))
          <div class="equipment billdetails_content">
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td colspan="2">
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
                @foreach ($reservation->bills[0]->breakdowns->where('unit_type',2) as $e)
                <tr>
                  <td>
                    {{ Form::text('equipment_breakdown_item[]', $e->unit_item,['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    <input class="form-control" readonly>
                    {{ Form::hidden('equipment_breakdown_cost[]', '' ) }}
                  </td>
                  <td>
                    {{ Form::text('equipment_breakdown_count[]', $e->unit_count,['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    <input class="form-control" readonly>
                    {{ Form::hidden('equipment_breakdown_subtotal[]','' ) }}
                  </td>
                </tr>
                @endforeach
                @foreach ($reservation->bills[0]->breakdowns->where('unit_type',3) as $s)
                <tr>
                  <td>
                    {{ Form::text('services_breakdown_item[]', $s->unit_item,['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    <input class="form-control" readonly>
                    {{ Form::hidden('services_breakdown_cost[]', '' ) }}
                  </td>
                  <td>
                    {{ Form::text('services_breakdown_count[]', $s->unit_count,['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    <input class="form-control" readonly>
                    {{ Form::hidden('services_breakdown_subtotal[]', '' ) }}
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          @endif

          {{-- @endif --}}

          @if ($reservation->bills[0]->breakdowns->contains('unit_type',4))
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
                  <td>単価</td>
                  <td>金額</td>
                </tr>
              </tbody>
              <tbody class="layout_main">
                @foreach ($reservation->bills[0]->breakdowns->where('unit_type',4) as $key=>$value)
                <tr>
                  <td>
                    {{ Form::text('layout_breakdown_item[]', $value['unit_item'],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('layout_breakdown_cost[]', $value['unit_cost'],['class'=>'form-control', 'readonly'] )}}
                  </td>
                  <td>
                    {{ Form::text('layout_breakdown_count[]', $value['unit_count'],['class'=>'form-control', 'readonly'] )}}
                  </td>
                  <td>
                    {{ Form::text('layout_breakdown_subtotal[]', $value['unit_subtotal'],['class'=>'form-control', 'readonly'] )}}
                  </td>
                </tr>
                @endforeach
              </tbody>
              <tbody class="layouts_result">
                <tr>
                  <td colspan="3"></td>
                  <td colspan="1">
                    <p class="text-left">合計</p>
                    {{ Form::text('layout_price', $reservation->bills[0]->layout_price,['class'=>'form-control', 'readonly'] ) }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          @endif

          @if ($reservation->bills[0]->breakdowns->contains('unit_type',5))
          <div class="others billdetails_content">
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td colspan="3">
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
                  <td>追加/削除</td>
                </tr>
              </tbody>
              <tbody class="others_main">
                @foreach ($reservation->bills[0]->breakdowns->where('unit_type',5) as $item)
                <tr>
                  <td>
                    {{ Form::text('others_breakdown_item[]', $item['unit_item'],['class'=>'form-control'] ) }}
                  </td>
                  <td>
                    <input class="form-control" readonly>
                    {{ Form::hidden('others_breakdown_cost[]', '',['class'=>'form-control'] ) }}
                  </td>
                  <td>
                    {{ Form::text('others_breakdown_count[]', $item['unit_count'],['class'=>'form-control'] ) }}
                  </td>
                  <td>
                    <input class="form-control" readonly>
                    {{ Form::hidden('others_breakdown_subtotal[]', '',['class'=>'form-control'] ) }}
                  </td>
                  <td class="text-left">
                    <input type="button" value="＋" class="add pluralBtn">
                    <input type="button" value="ー" class="del pluralBtn">
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          @endif

          <div class="bill_total">
            <table class="table text-right">
              <tbody>
                <tr>
                  <td>小計：</td>
                  <td>
                    {{ Form::text('master_subtotal',$reservation->bills[0]->master_subtotal ,['class'=>'form-control text-right', 'readonly'] ) }}
                  </td>
                </tr>
                <tr>
                  <td>消費税：</td>
                  <td>
                    {{ Form::text('master_tax',ReservationHelper::getTax($reservation->bills[0]->master_subtotal) ,['class'=>'form-control text-right', 'readonly'] ) }}
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold">合計金額</td>
                  <td>
                    {{ Form::text('master_total',ReservationHelper::taxAndPrice($reservation->bills[0]->master_subtotal) ,['class'=>'form-control text-right', 'readonly'] ) }}
                  </td>
                </tr>
              </tbody>
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
          <div class="informations billdetails_content pb-3">
            <table class="table">
              <tbody>
                <tr>
                  <td>請求日
                    {{ Form::text('bill_created_at', $reservation->bills[0]->bill_created_at,['class'=>'form-control', 'id'=>'datepicker6'] ) }}
                  </td>
                  <td>支払期日
                    {{ Form::text('payment_limit', date('Y-m-d',strtotime($reservation->bills[0]->payment_limit)),['class'=>'form-control datepicker'] ) }}
                  </td>
                </tr>
                <tr>
                  <td>
                    請求書宛名
                    {{ Form::text('bill_company', ReservationHelper::getAgentCompanyName($reservation['agent_id']),['class'=>'form-control'] ) }}
                  </td>
                  <td>
                    担当者
                    {{ Form::text('bill_person', ReservationHelper::getAgentPerson($reservation['agent_id']),['class'=>'form-control'] ) }}
                  </td>
                </tr>
                <tr>
                  <td colspan="2">請求書備考
                    {{ Form::textarea('bill_remark', $reservation['bill_remark'],['class'=>'form-control'] ) }}
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
          <div class="d-flex align-items-center">
            <h3 class="pl-3">
              入金情報
            </h3>
          </div>
        </div>
        <div class="main">
          <div class="paids billdetails_content">
            <table class="table">
              <tbody>
                <tr>
                  <td>入金状況
                    {{Form::select('paid', ['未入金', '入金済み','遅延','入金不足','入金過多','次回繰越'],$reservation->bills[0]['paid'],['class'=>'form-control'])}}
                  </td>
                  <td>
                    入金日
                    {{ Form::text('pay_day', !empty($reservation->bills[0]['pay_day'])?date('Y-m-d',strtotime($reservation->bills[0]['pay_day'])):"",['class'=>'form-control', 'id'=>'datepicker7'] ) }}
                  </td>
                </tr>
                <tr>
                  <td>振込人名
                    {{ Form::text('pay_person', $reservation->bills[0]['pay_person'],['class'=>'form-control'] ) }}
                    <p class="is-error-pay_person" style="color: red"></p>
                  </td>
                  <td>入金額

                    {{ Form::text('payment', $reservation->bills[0]['payment'],['class'=>'form-control'] ) }}
                    <p class="is-error-payment" style="color: red"></p>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>


  {{Form::submit('確認する', ['class'=>'btn more_btn_lg d-block  mx-auto my-5', 'id'=>'check_submit'])}}


  {{Form::close()}}


</div>

<script>
  function checkForm($this) {
          var str = $this.value;
          while (str.match(/[^A-Z^a-z\d\-]/)) {
            str = str.replace(/[^A-Z^a-z\d\-]/, "");
          }
          $this.value = str;
        }

  $(document).on(' click', '.holidays', function () {
  getHolidayCalendar($('.holidays'), $('input[name="reserve_date"]'));
});


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
      // プラスボタンクリック
      $(document).on("click", ".add", function() {
        $(this).parent().parent().clone(true).insertAfter($(this).parent().parent());
        // 追加時内容クリア
        $(this).parent().parent().next().find('td').find('input, select').eq(0).val('');
        $(this).parent().parent().next().find('td').find('input, select').eq(1).val('');
      });

      // マイナスボタンクリック
      $(document).on("click", ".del", function() {
        if ($(this).parent().parent().parent().attr('class') == "others_main") {
          var count = $('.others .others_main tr').length;
          var target = $(this).parent().parent();
          if (target.parent().children().length > 1) {
            target.remove();
          }
        }
      });
    });
  })
</script>
@endsection