@extends('layouts.admin.app')

@section('content')
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/admin/validation.js') }}"></script>
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">

<h2 class="mt-3 mb-3">仲介会社　仮押え 計算</h2>
<hr>

{{ Form::open(['url' => 'admin/pre_agent_reservations/'.$id.'/edit_calculate', 'method'=>'POST', 'id'=>'pre_agent_reservationSingleEditForm']) }}
@csrf

<section class="mt-5">
  <div class="selected_user">
    <table class="table table-bordered" style="table-layout: fixed;">
      <thead>
        <tr>
          <th>仲介会社情報</th>
          <td colspan="3">ID：<p class="user_id d-inline">{{ReservationHelper::fixId($agent->id)}}</p>
          </td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="table-active">会社名・団体名</td>
          <td colspan="3">
            <p class="company">
              {{ReservationHelper::getAgentCompany($agent->id)}}
            </p>
          </td>
        </tr>
        <tr>
          <td class="table-active">担当者氏名</td>
          <td>
            <p class="person">
              {{ReservationHelper::getAgentPerson($agent->id)}}
            </p>
          </td>
          <td class="table-active">メールアドレス</td>
          <td>
            <p class="email">
              {{ReservationHelper::getAgentEmail($agent->id)}}
            </p>
          </td>
        </tr>
        <tr>
          <td class="table-active">携帯番号</td>
          <td>
            <p class="mobile">
              {{ReservationHelper::getAgentMobile($agent->id)}}
            </p>
          </td>
          <td class="table-active">固定電話</td>
          <td>
            <p class="tel">
              {{ReservationHelper::getAgentTel($agent->id)}}
            </p>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="unknown_user mt-3">
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
            {{ Form::text('pre_endusers_company', ($request->pre_endusers_company),['class'=>'form-control'] ) }}
          </td>
          <td class="table-active">住所</td>
          <td>
            {{ Form::text('pre_endusers_address', ($request->pre_endusers_address),['class'=>'form-control'] ) }}
          </td>
        </tr>
        <tr>
          <td class="table-active">連絡先</td>
          <td>
            {{ Form::text('pre_endusers_tel', ($request->pre_endusers_tel),['class'=>'form-control'] ) }}
            <p class="is-error-pre_endusers_tel" style="color: red"></p>
          </td>
          <td class="table-active">メールアドレス</td>
          <td>
            {{ Form::text('pre_endusers_email', ($request->pre_endusers_email),['class'=>'form-control'] ) }}
            <p class="is-error-pre_endusers_email" style="color: red"></p>
          </td>
        </tr>
        <tr>
          <td class="table-active">当日担当者</td>
          <td>
            {{ Form::text('pre_endusers_person', ($request->pre_endusers_person),['class'=>'form-control'] ) }}
          </td>
          <td class="table-active">当日連絡先</td>
          <td>
            {{ Form::text('pre_endusers_mobile', ($request->pre_endusers_mobile),['class'=>'form-control'] ) }}
            <p class="is-error-pre_endusers_mobile" style="color: red"></p>
          </td>
        </tr>
        <tr>
          <td class="table-active form_required">利用者属性</td>
          <td>
            {{ Form::text('', ReservationHelper::getEndUser($request->pre_endusers_attr),['class'=>'form-control'] ) }}
            {{ Form::hidden('pre_endusers_attr', ($request->pre_endusers_attr),['class'=>'form-control'] ) }}
            <p class="is-error-pre_enduser_attr" style="color: red"></p>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="container-field mt-5">
    <div class="row">
      <div class="col">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td colspan="2">
                <p class="title-icon">
                  <i class="fas fa-info-circle icon-size"></i>仮押え情報
                </p>
              </td>
            </tr>
            <tr>
              <td class="table-active">利用日</td>
              <td>

                {{ Form::text('reserve_date', $request->reserve_date,['class'=>'form-control', 'readonly'] ) }}
                <p class="is-error-reserve_date" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active">会場</td>
              <td>
                {{ Form::text('', ReservationHelper::getVenue($request->venue_id),['class'=>'form-control', 'readonly'] ) }}
                {{ Form::hidden('venue_id', $request->venue_id,['class'=>'form-control', 'readonly'] ) }}

                <p class="is-error-venue_id" style="color: red"></p>
                <div class="price_selector">
                  <div>
                    <small>※料金体系を選択してください</small>
                  </div>
                  <div class="price_radio_selector">
                    <div class="d-flex justfy-content-start align-items-center">
                      {{Form::radio('price_system',1,true,['class'=>'mr-2','id'=>'price_system_radio1'])}}
                      {{Form::label('price_system_radio1','通常（枠貸）')}}
                    </div>
                    <div class="d-flex justfy-content-start align-items-center">
                      {{Form::radio('price_system',2,false,['class'=>'mr-2','id'=>'price_system_radio2'])}}
                      {{Form::label('price_system_radio2','アクセア（時間貸）')}}
                    </div>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td class="table-active">入室時間</td>
              <td>
                <div>
                  {{ Form::text('', date('H:i',strtotime($request->enter_time)),['class'=>'form-control', 'readonly'] ) }}
                  {{ Form::hidden('enter_time', $request->enter_time,['class'=>'form-control', 'readonly'] ) }}
                  <p class="is-error-enter_time" style="color: red"></p>
                </div>
              </td>
            </tr>
            <tr>
              <td class="table-active">退室時間</td>
              <td>
                <div>
                  {{ Form::text('', date('H:i',strtotime($request->leave_time)),['class'=>'form-control', 'readonly'] ) }}
                  {{ Form::hidden('leave_time', $request->leave_time,['class'=>'form-control', 'readonly'] ) }}
                  <p class="is-error-leave_time" style="color: red"></p>
                </div>
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
            <td class="table-active">案内板</td>
            <td>
              <div class="radio-box">
                <p>
                  {{Form::radio('board_flag', 1, $request->board_flag==1?true:false , ['id' => 'board_flag_on'])}}
                  {{Form::label('board_flag_on','有り')}}
                </p>
                <p>
                  {{Form::radio('board_flag', 0, $request->board_flag==0?true:false, ['id' => 'board_flag_off'])}}
                  {{Form::label('board_flag_off','無し')}}
                </p>
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント開始時間</td>
            <td>
              <select name="event_start" id="event_start" class="form-control">
                <option disabled></option>

                @for ($start = 0*2; $start <=23*2; $start++) <option value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))==$request->event_start)
                  selected
                  @elseif(date("H:i:s",strtotime("00:00 +". $start * 30 ." minute")) < $request->enter_time)
                    disabled
                    @elseif(date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))>$request->leave_time)
                    disabled
                    @endif
                    >
                    {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}
                    </option>
                    @endfor

              </select>
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント終了時間</td>
            <td>
              <select name="event_finish" id="event_finish" class="form-control">
                <option disabled></option>

                @for ($start = 0*2; $start <=23*2; $start++) <option value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if(date("H:i:s",strtotime("00:00 +". $start * 30 ." minute"))==$request->event_finish)
                  selected
                  @elseif(date("H:i:s",strtotime("00:00 +". $start * 30 ." minute")) < $request->enter_time)
                    disabled
                    @elseif(date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))>$request->leave_time)
                    disabled
                    @endif
                    >
                    {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}
                    </option>
                    @endfor

              </select>
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント名称1</td>
            <td>
              <div class="align-items-end d-flex">
                {{ Form::text('event_name1',$request->event_name1,['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'eventname1Count'] ) }}
                <span class="ml-1 annotation count_num1"></span>
              </div>
              <p class="is-error-event_name1" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント名称2</td>
            <td>
              <div class="align-items-end d-flex">
                {{ Form::text('event_name2', $request->event_name2,['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'eventname2Count'] ) }}
                <span class="ml-1 annotation count_num2"></span>
              </div>
              <p class="is-error-event_name2" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active">主催者名</td>
            <td>
              <div class="align-items-end d-flex">
                {{ Form::text('event_owner', $request->event_owner,['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'eventownerCount'] ) }}
                <span class="ml-1 annotation count_num3"></span>
              </div>
              <p class="is-error-event_owner" style="color: red"></p>
            </td>
          </tr>
        </table>

        <div class="equipemnts">
          <table class="table table-bordered">
            <thead class="accordion-ttl">
              <tr>
                <th colspan="2">
                  <p class="title-icon fw-bolder py-1">
                    <i class="fas fa-wrench icon-size"></i>有料備品
                  </p>
                </th>
              </tr>
            </thead>
            <tbody class="accordion-wrap">
              @foreach ($venue->getEquipments() as $e_key=>$equipment)
              <tr>
                <td class="table-active">
                  {{$equipment->item}}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown'.$e_key, $request->{'equipment_breakdown'.$e_key},['class'=>'form-control'] ) }}
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
                  <p class="title-icon fw-bolder py-1">
                    <i class="fas fa-hand-holding-heart icon-size"></i>有料サービス
                  </p>
                </th>
              </tr>
            </thead>
            <tbody class="accordion-wrap">
              @foreach ($venue->getServices() as $s_key=>$service)
              <tr>
                <td class="table-active">
                  {{$service->item}}
                </td>
                <td>
                  <div class="radio-box">
                    <p>
                      {{Form::radio('services_breakdown'.$s_key, 1, $request->{'services_breakdown'.$s_key}==1?true:false , ['id' => 'service'.$s_key.'on'])}}
                      {{Form::label('service'.$s_key.'on', "有り")}}
                    </p>
                    <p>
                      {{Form::radio('services_breakdown'.$s_key, 0, $request->{'services_breakdown'.$s_key}==0?true:false, ['id' => 'services_breakdown'.$s_key.'off'])}}
                      {{Form::label('services_breakdown'.$s_key.'off', "無し")}}
                    </p>
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
                <th colspan='2'>
                  <p class="title-icon py-1">
                    <i class="fas fa-th icon-size"></i>レイアウト
                  </p>
                </th>
              </tr>
            </thead>
            <tbody>
              @if ($venue->getLayouts()[0])
              <tr>
                <td class="table-active">
                  レイアウト準備
                </td>
                <td>
                  <div class="radio-box">
                    <p>
                      {{Form::radio('layout_prepare', 1, $request->layout_prepare==1?true:false , ['id' => 'layout_prepare'])}}
                      {{Form::label('layout_prepare', "有り")}}
                    </p>
                    <p>
                      {{Form::radio('layout_prepare', 0, $request->layout_prepare==0?true:false, ['id' => 'no_layout_prepare'])}}
                      {{Form::label('no_layout_prepare', "無し")}}
                    </p>
                  </div>
                </td>
              </tr>
              @endif
              @if ($venue->getLayouts()[1])
              <tr>
                <td class="table-active">
                  レイアウト片付
                </td>
                <td>
                  <div class="radio-box">
                    <p>
                      {{Form::radio('layout_clean', 1, $request->layout_clean==1?true:false, ['id' => 'layout_clean'])}}
                      {{Form::label('layout_clean', "有り")}}
                    </p>
                    <p>
                      {{Form::radio('layout_clean', 0, $request->layout_clean==0?true:false, ['id' => 'no_layout_clean'])}}
                      {{Form::label('no_layout_clean', "無し")}}
                    </p>
                  </div>
                </td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>
        @endif


        <div class="luggage">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th colspan='2'>
                  <p class="title-icon">
                    <i class="fas fa-suitcase-rolling icon-size"></i>荷物預り
                  </p>
                </th>
              </tr>
            </thead>
            <tbody>
              @if ($venue->getLuggage()==1)
              <tr>
                <td class="table-active">事前に預かる荷物<br>（個数）</td>
                <td>
                  {{ Form::text('luggage_count', $request->luggage_count,['class'=>'form-control'] ) }}
                  <p class='is-error-luggage_count' style=' color: red'></p>
                </td>
              </tr>
              <tr>
                <td class="table-active">事前荷物の到着日<br>午前指定のみ</td>
                <td>
                  {{ Form::text('luggage_arrive', $request->luggage_arrive,['class'=>'form-control', 'id'=>'datepicker9'] ) }}
                </td>
              </tr>
              <tr>
                <td class="table-active">事後返送する荷物</td>
                <td>
                  {{ Form::text('luggage_return', $request->luggage_return,['class'=>'form-control'] ) }}
                  <p class='is-error-luggage_return' style=' color: red'></p>
                </td>
              </tr>

              @endif
            </tbody>
          </table>
        </div>

        @if ($venue->eat_in_flag==1)
        <div class="eat_in">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th colspan='2'>
                  <p class="title-icon">
                    <i class="fas fa-utensils icon-size"></i>室内飲食
                  </p>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  {{Form::radio('eat_in', 1, $request->eat_in==1?true:false , ['id' => 'eat_in'])}}
                  {{Form::label('eat_in',"あり")}}
                </td>
                <td>
                  {{Form::radio('eat_in_prepare', 1, $request->eat_in_prepare==1?true:false , ['id' => 'eat_in_prepare', ''])}}
                  {{Form::label('eat_in_prepare',"手配済み")}}
                  {{Form::radio('eat_in_prepare', 2, $request->eat_in_prepare==2?true:false , ['id' => 'eat_in_consider',''])}}
                  {{Form::label('eat_in_consider',"検討中")}}
                </td>
              </tr>
              <tr>
                <td>
                  {{Form::radio('eat_in', 0, $request->eat_in==0?true:false , ['id' => 'no_eat_in'])}}
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
                <label for="enduser_charge ">支払い料</label>
              </td>
              <td>
                <div class="d-flex align-items-end">
                  {{ Form::text('enduser_charge', $request->enduser_charge,['class'=>'form-control'] ) }}
                  <span class="ml-1">円</span>
                </div>
                <p class="is-error-enduser_charge" style="color: red"></p>
              </td>
            </tr>
          </tbody>
        </table>
        @if ($venue->alliance_flag==1)
        <table class="table table-bordered cost-table">
          <tbody>
            <tr>
              <td colspan="2">
                <p class="title-icon">
                  <i class="fas fa-yen-sign icon-size" aria-hidden="true"></i>売上原価
                </p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="">原価率</label></td>
              <td>
                <div class="align-items-end d-flex">
                  {{ Form::text('cost', $request->cost,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
                  <span class="ml-2">%</span>
                </div>
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
                  <i class="fas fa-file-alt icon-size" aria-hidden="true"></i>備考
                </p>
              </td>
            </tr>
            <!-- <tr class="caution">
              <td>
                <label for="caution">注意事項</label>
                {{ Form::textarea('attention', $request->attention,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
              </td>
            </tr> -->
            <!-- <tr>
              <td>
                <label for="userNote">申し込みフォーム備考</label>
                {{ Form::textarea('user_details', $request->user_details,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
              </td>
            </tr> -->
            <tr>
              <td>
                <label for="adminNote">管理者備考</label>
                {{ Form::textarea('admin_details', $request->admin_details,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>


  {{ Form::hidden('agent_id', ($request->agent_id) ) }}
  {{Form::submit('再計算する', ['class'=>'btn more_btn4_lg mx-auto d-block my-5', 'id'=>'check_submit'])}}
  {{Form::close()}}



  {{ Form::open(['url' => 'admin/pre_agent_reservations/'.$id.'/update', 'method'=>'PUT', 'id'=>'']) }}
  @csrf
  {{-- 以下計算結果 --}}
  <div class="container-fluid">
    <div class="bill">
      <div class="bill_head">
        <table class="table bill_table" style="table-layout: fixed">
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
                    {{number_format(ReservationHelper::taxAndPrice(floor($price+$layout_prepare+$layout_clean)))}}
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
                <tr>
                  <td>{{ Form::text('venue_breakdown_item0', "会場料金",['class'=>'form-control', 'readonly'] ) }} </td>
                  <td><input class="form-control" readonly></td>
                  <td>
                    {{ Form::text('venue_breakdown_count0', ReservationHelper::getUsage($request->enter_time,$request->leave_time)."h",['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td><input class="form-control" readonly></td>
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
                @foreach ($venue->getEquipments() as $e_key=>$equipment)
                @if ($request->{'equipment_breakdown'.$e_key}>0)
                <tr>
                  <td>
                    {{ Form::text('equipment_breakdown_item'.$e_key, $equipment->item,['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td><input class="form-control" readonly></td>
                  <td>
                    {{ Form::text('equipment_breakdown_count'.$e_key, $request->{'equipment_breakdown'.$e_key},['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td><input class="form-control" readonly></td>
                </tr>
                @endif
                @endforeach
                @foreach ($venue->getServices() as $s_key=>$service)
                @if ($request->{'services_breakdown'.$s_key}>0)
                <tr>
                  <td>
                    {{ Form::text('service_breakdown_item'.$s_key, $service->item,['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td><input class="form-control" readonly></td>
                  <td>
                    {{ Form::text('service_breakdown_count'.$s_key, $request->{'services_breakdown'.$s_key},['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td><input class="form-control" readonly></td>
                </tr>
                @endif
                @endforeach
                @if ($request->luggage_price)
                <tr>
                  <td>
                    {{ Form::text('luggage_item', '荷物預り/返送',['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td><input class="form-control" readonly></td>
                  <td>
                    {{ Form::text('luggage_count', $request->luggage_price,['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td><input class="form-control" readonly></td>
                </tr>
                @endif
              </tbody>
            </table>
          </div>

          @if ($venue->layout!=0)

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
                @if ($request->layout_prepare==1)
                <tr>
                  <td>{{ Form::text('layout_prepare_item', "レイアウト準備料金",['class'=>'form-control', 'readonly'] ) }}</td>
                  <td>
                    {{ Form::text('layout_prepare_cost', $venue->getLayouts()[0],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>{{ Form::text('layout_prepare_count', 1,['class'=>'form-control', 'readonly'] )}}</td>
                  <td>
                    {{ Form::text('layout_prepare_subtotal', $venue->getLayouts()[0],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                </tr>
                @endif
                @if ($request->layout_clean==1)
                <tr>
                  <td>{{ Form::text('layout_clean_item', "レイアウト準備料金",['class'=>'form-control', 'readonly'] ) }}</td>
                  <td>
                    {{ Form::text('layout_clean_cost', $venue->getLayouts()[1],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>{{ Form::text('layout_clean_count', 1,['class'=>'form-control', 'readonly'] )}}</td>
                  <td>
                    {{ Form::text('layout_clean_subtotal', $venue->getLayouts()[1],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                </tr>
                @endif
              </tbody>
              @if($request->layout_prepare==1||$request->layout_clean==1)
              <tbody class="layouts_result">
                <tr>
                  <td colspan="3"></td>
                  <td colspan="1">合計
                    {{ Form::text('layouts_price', $layout_total,['class'=>'form-control', 'readonly'] ) }}
                  </td>
                </tr>
              </tbody>
              @endif
            </table>
          </div>
          @endif


          <div class="bill_total">
            <table class="table text-right" style="table-layout: fixed;">
              <tbody>
                <tr>
                  <td>小計：</td>
                  <td>
                    {{ Form::text('master_subtotal',(floor($price+$layout_prepare+$layout_clean)) ,['class'=>'form-control text-right', 'readonly'] ) }}
                  </td>
                </tr>
                <tr>
                  <td>消費税：</td>
                  <td>
                    {{ Form::text('master_tax',ReservationHelper::getTax(floor($price+$layout_prepare+$layout_clean)) ,['class'=>'form-control text-right', 'readonly'] ) }}
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold">合計金額</td>
                  <td>
                    {{ Form::text('master_total',ReservationHelper::taxAndPrice(floor($price+$layout_prepare+$layout_clean)) ,['class'=>'form-control text-right', 'readonly'] ) }}
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


{{ Form::hidden('venue_id', $request->venue_id )}}
{{ Form::hidden('reserve_date', $request->reserve_date )}}
{{ Form::hidden('agent_id', $request->agent_id )}}
{{ Form::hidden('price_system', $request->price_system )}}
{{ Form::hidden('enter_time', $request->enter_time )}}
{{ Form::hidden('leave_time', $request->leave_time )}}
{{ Form::hidden('board_flag', $request->board_flag )}}
{{ Form::hidden('event_start',$request->event_start  )}}
{{ Form::hidden('event_finish', $request->event_finish )}}
{{ Form::hidden('event_name1', $request->event_name1 )}}
{{ Form::hidden('event_name2', $request->event_name2 )}}
{{ Form::hidden('event_owner', $request->event_owner )}}

{{ Form::hidden('luggage_count', $request->luggage_count )}}
{{ Form::hidden('luggage_arrive', $request->luggage_arrive )}}
{{ Form::hidden('luggage_return', $request->luggage_return )}}
{{ Form::hidden('luggage_price', $request->luggage_price )}}

{{ Form::hidden('pre_enduser_company', $request->pre_enduser_company ) }}
{{ Form::hidden('pre_enduser_name', $request->pre_enduser_name) }}
{{ Form::hidden('pre_enduser_email', $request->pre_enduser_email) }}
{{ Form::hidden('pre_enduser_mobile', $request->pre_enduser_mobile) }}
{{ Form::hidden('pre_enduser_tel', $request->pre_enduser_tel) }}
{{ Form::hidden('enduser_charge', $request->enduser_charge) }}
{{ Form::hidden('attention', $request->attention) }}
{{ Form::hidden('user_details', $request->user_details) }}
{{ Form::hidden('admin_details', $request->admin_details) }}

{{ Form::hidden('pre_enduser_attr', ($request->pre_enduser_attr),['class'=>'form-control', 'readonly'] ) }}
{{ Form::hidden('pre_enduser_address', ($request->pre_enduser_address),['class'=>'form-control', 'readonly'] ) }}

{{Form::hidden('eat_in_prepare', $request->eat_in_prepare)}}
{{Form::hidden('eat_in', $request->eat_in)}}
{{Form::hidden('cost', $request->cost)}}

{{Form::hidden('enduser_charge', $request->enduser_charge)}}

{{Form::hidden('pre_endusers_company',$request->pre_endusers_company)}}
{{Form::hidden('pre_endusers_person',$request->pre_endusers_person)}}
{{Form::hidden('pre_endusers_mobile',$request->pre_endusers_mobile)}}
{{Form::hidden('pre_endusers_tel',$request->pre_endusers_tel)}}
{{Form::hidden('pre_endusers_email',$request->pre_endusers_email)}}




{{Form::submit('保存する', ['class'=>'btn more_btn_lg d-block btn-lg mx-auto my-5', 'id'=>'check_submit'])}}
{{Form::close()}}




<script>
  $(function() {
    $("html,body").animate({
      scrollTop: $('.bill').offset().top
    });

    $(function() {
      // プラスボタンクリック
      $(document).on("click", ".add", function() {
        $(this).parent().parent().clone(true).insertAfter($(this).parent().parent());
        addThisTr('.others .others_main tr', 'others_input_item', 'others_input_cost', 'others_input_count', 'others_input_subtotal');
        // 追加時内容クリア
        $(this).parent().parent().next().find('td').find('input, select').eq(0).val('');
        $(this).parent().parent().next().find('td').find('input, select').eq(1).val('');
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

      // マイナスボタンクリック
      $(document).on("click", ".del", function() {
        if ($(this).parent().parent().parent().attr('class') == "others_main") {
          var count = $('.others .others_main tr').length;
          var target = $(this).parent().parent();
          if (target.parent().children().length > 1) {
            target.remove();
          }
          for (let index = 0; index < count; index++) {
            // console.log(index);
            $('.others_main tr').eq(index).find('td').eq(0).find('input').attr('name', 'others_input_item' + index);
            $('.others_main tr').eq(index).find('td').eq(1).find('input').attr('name', 'others_input_cost' + index);
          }
        }
      });
    });
  })

  $(function() {
    var maxTarget = $('input[name="reserve_date"]').val();
    $('#datepicker9').datepicker({
      dateFormat: 'yy-mm-dd',
      minDate: 0,
      maxDate: maxTarget,
      autoclose: true,
    });
  })


  $(function() {
    $(document).on("click", "input:radio[name='eat_in']", function() {
      var radioTarget = $('input:radio[name="eat_in"]:checked').val();
      if (radioTarget == 1) {
        $('input:radio[name="eat_in_prepare"]').prop('disabled', false);
      } else {
        $('input:radio[name="eat_in_prepare"]').prop('disabled', true);
        $('input:radio[name="eat_in_prepare"]').prop('checked', false);
      }
    })
  })
</script>





@endsection