@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
{{-- <script src="{{ asset('/js/template.js') }}"></script> --}}

<h1>仲介会社　単発　計算</h1>




{{Form::open(['url' => 'admin/pre_agent_reservations/calculate', 'method' => 'POST', 'id'=>''])}}
@csrf

<div class="selected_user mt-5">
  <table class="table table-bordered" style="table-layout: fixed;">
    <thead>
      <tr>
        <th>仲介会社情報</th>
        <th colspan="3">ID：<p class="user_id d-inline">{{$agent->id}}</p>
        </th>
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
        <td class="table-active">担当者指名</td>
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






<div class="unknown_user mt-5">
  <table class="table table-bordered" style="table-layout: fixed;">
    <thead>
      <tr>
        <th colspan="4">仲介会社の顧客情報 </th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="table-active">会社名・団体名</td>
        <td>
          {{ Form::text('pre_enduser_company', ($request->pre_enduser_company),['class'=>'form-control', 'readonly'] ) }}
        </td>
        <td colspan="2"></td>
      </tr>
      <tr>
        <td class="table-active">担当者指名</td>
        <td>
          {{ Form::text('pre_enduser_name', ($request->pre_enduser_name),['class'=>'form-control', 'readonly'] ) }}
        </td>
        <td class="table-active">メールアドレス</td>
        <td>
          {{ Form::text('pre_enduser_email', ($request->pre_enduser_email),['class'=>'form-control', 'readonly'] ) }}
        </td>
      </tr>
      <tr>
        <td class="table-active">携帯番号</td>
        <td>
          {{ Form::text('pre_enduser_mobile', ($request->pre_enduser_mobile),['class'=>'form-control', 'readonly'] ) }}
        </td>
        <td class="table-active">固定電話</td>
        <td>
          {{ Form::text('pre_enduser_tel', ($request->pre_enduser_tel),['class'=>'form-control', 'readonly'] ) }}
        </td>
      </tr>
    </tbody>
  </table>
</div>



<div class="container-field bg-white text-dark">
  <div class="row">
    <div class="col">
      <table class="table table-bordered">
        <tbody>
          <tr>
            <td colspan="2">予約情報</td>
          </tr>
          <tr>
            <td class="table-active form_required">利用日</td>
            <td>

              {{ Form::text('reserve_date', $request->reserve_date,['class'=>'form-control', 'readonly'] ) }}
              <p class="is-error-reserve_date" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">会場</td>
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
                    <input class="mr-2" id="price_system_radio1" name="price_system" type="radio" value="1">
                    <label for="price_system_radio1">通常（枠貸）</label>
                  </div>
                  <div class="d-flex justfy-content-start align-items-center">
                    <input class="mr-2" id="price_system_radio2" name="price_system" type="radio" value="2">
                    <label for="price_system_radio2">アクセア（時間貸）</label>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">入室時間</td>
            <td>
              <div>
                {{ Form::text('', date('H:i',strtotime($request->enter_time)),['class'=>'form-control', 'readonly'] ) }}
                {{ Form::hidden('enter_time', $request->enter_time,['class'=>'form-control', 'readonly'] ) }}
                <p class="is-error-enter_time" style="color: red"></p>
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">退室時間</td>
            <td>
              <div>
                {{ Form::text('', date('H:i',strtotime($request->leave_time)),['class'=>'form-control', 'readonly'] ) }}
                {{ Form::hidden('leave_time', $request->leave_time,['class'=>'form-control', 'readonly'] ) }}
                <p class="is-error-leave_time" style="color: red"></p>
              </div>
            </td>
          </tr>
          <tr>
            <td>案内板</td>
            <td>
              <input type="radio" name="board_flag" value="0" checked="">無し
              <input type="radio" name="board_flag" value="1">有り
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント開始時間</td>
            <td>
              <select name="event_start" id="event_start" class="form-control">
                <option disabled></option>
                @for ($start = 0*2; $start <=23*2; $start++) <option
                  value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}"
                  @if(date("H:i:s",strtotime("00:00 +". $start * 30 ." minute"))==$request->enter_time)
                  selected
                  @endif>
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
                @for ($start = 0*2; $start <=23*2; $start++) <option
                  value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}"
                  @if(date("H:i:s",strtotime("00:00 +". $start * 30 ." minute"))==$request->event_finish)
                  selected
                  @endif>
                  {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}
                  </option>
                  @endfor
              </select>
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント名称1</td>
            <td>
              {{ Form::text('event_name1',$request->event_name1,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント名称2</td>
            <td>
              {{ Form::text('event_name2', $request->event_name2,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">主催者名</td>
            <td>
              {{ Form::text('event_owner', $request->event_owner,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
            </td>
          </tr>
        </tbody>
      </table>
      <div class="equipemnts">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th colspan="2">
                <div class="d-flex justify-content-between align-items-center">
                  有料備品
                  <i class="fas fa-plus icon_plus hide" aria-hidden="true"></i>
                  <i class="fas fa-minus icon_minus" aria-hidden="true"></i>
                </div>
              </th>
            </tr>
          </thead>
          <tbody>
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
          <thead>
            <tr>
              <th colspan="2">
                <div class="d-flex justify-content-between align-items-center">
                  有料サービス
                  <i class="fas fa-plus icon_plus hide" aria-hidden="true"></i>
                  <i class="fas fa-minus icon_minus" aria-hidden="true"></i>
                </div>
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach ($venue->getServices() as $s_key=>$service)
            <tr>
              <td class="table-active">
                {{$service->item}}
              </td>
              <td>
                <div class="form-check form-check-inline">
                  {{Form::radio('services_breakdown'.$s_key, 1, $request->{'services_breakdown'.$s_key}==1?true:false , ['id' => 'service'.$s_key.'on', 'class' => 'form-check-input'])}}
                  {{Form::label('service'.$s_key.'on', "有り")}}
                  {{Form::radio('services_breakdown'.$s_key, 0, $request->{'services_breakdown'.$s_key}==0?true:false, ['id' => 'services_breakdown'.$s_key.'off', 'class' => 'form-check-input'])}}
                  {{Form::label('services_breakdown'.$s_key.'off', "無し")}}
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="layouts">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th colspan="2">レイアウト</th>
            </tr>
          </thead>
          <tbody>
            @if ($venue->getLayouts()[0])
            <tr>
              <td class="table-active">
                レイアウト準備
              </td>
              <td>
                <div class="form-check form-check-inline">
                  {{Form::radio('layout_prepare', 1, $request->layout_prepare==1?true:false , ['id' => 'layout_prepare', 'class' => 'form-check-input'])}}
                  {{Form::label('layout_prepare', "有り")}}
                  {{Form::radio('layout_prepare', 0, $request->layout_prepare==0?true:false, ['id' => 'no_layout_prepare', 'class' => 'form-check-input'])}}
                  {{Form::label('no_layout_prepare', "無し")}}
                </div>
              </td>
            </tr>
            @endif
            @if ($venue->getLayouts()[1])
            <tr>
              <td class="table-active">
                レイアウト片付け
              </td>
              <td>
                <div class="form-check form-check-inline">
                  {{Form::radio('layout_clean', 1, $request->layout_clean==1?true:false, ['id' => 'layout_clean', 'class' => 'form-check-input'])}}
                  {{Form::label('layout_clean', "有り")}}
                  {{Form::radio('layout_clean', 0, $request->layout_clean==0?true:false, ['id' => 'no_layout_clean', 'class' => 'form-check-input'])}}
                  {{Form::label('no_layout_clean', "無し")}}
                </div>
              </td>
            </tr>
            @endif
          </tbody>
        </table>
      </div>
      <div class="luggage">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th colspan="2">荷物預かり</th>
            </tr>
          </thead>
          <tbody>
            @if ($venue->getLuggage()==1)
            <tr>
              <td>事前に預かる荷物<br>（個数）</td>
              <td>
                {{ Form::text('luggage_count', $request->luggage_count,['class'=>'form-control'] ) }}
              </td>
            </tr>
            <tr>
              <td>事前荷物の到着日<br>午前指定のみ</td>
              <td>
                {{ Form::text('luggage_arrive', $request->luggage_arrive,['class'=>'form-control', 'id'=>'datepicker1'] ) }}
              </td>
            </tr>
            <tr>
              <td>事後返送する荷物</td>
              <td>
                {{ Form::text('luggage_return', $request->luggage_return,['class'=>'form-control'] ) }}
              </td>
            </tr>
            <tr>
              <td>荷物預かり/返送<br>料金</td>
              <td>
                {{ Form::text('luggage_price', $request->luggage_price,['class'=>'form-control'] ) }}
              </td>
            </tr>
            @endif
          </tbody>
        </table>
      </div>
      <div class="price_details">
      </div>
    </div>

    <div class="col">
      <div class="client_mater">　
      </div>
      <table class="table table-bordered sale-table">
        <tbody>
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-yen-sign fa-2x fa-fw" aria-hidden="true"></i>仲介会社の顧客への支払い料
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">
              <label for="enduser_charge ">支払い料</label>
            </td>
            <td class="d-flex align-items-center">
              {{ Form::text('enduser_charge', $request->enduser_charge,['class'=>'form-control'] ) }}円
            </td>
          </tr>
        </tbody>
      </table>
      <table class="table table-bordered note-table">
        <tbody>
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-envelope fa-2x fa-fw" aria-hidden="true"></i>備考
              </p>
            </td>
          </tr>
          <tr class="caution">
            <td>
              <label for="caution">注意事項</label>
              {{ Form::textarea('attention', $request->attention,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
            </td>
          </tr>
          <tr>
            <td>
              <label for="userNote">顧客情報の備考</label>
              {{ Form::textarea('user_details', $request->user_details,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
            </td>
          </tr>
          <tr>
            <td>
              <label for="adminNote">管理者備考</label>
              {{ Form::textarea('admin_details', $request->user_details,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>


{{ Form::hidden('agent_id', ($request->agent_id) ) }}
{{Form::submit('再計算する', ['class'=>'btn btn-danger mx-auto d-block btn-lg', 'id'=>'check_submit'])}}
{{Form::close()}}



{{ Form::open(['url' => 'admin/pre_agent_reservations/store', 'method'=>'POST', 'id'=>'']) }}
@csrf
{{-- 以下計算結果 --}}
<div class="container-fluid">
  <div class="bill">
    <div class="bill_head">
      <table class="table" style="table-layout: fixed">
        <tbody>
          <tr>
            <td>
              <h1 class="text-white">
                請求書No
              </h1>
            </td>
            <td style="font-size: 16px;">
              <div class="bg-white d-flex justify-content-around align-items-center" style="height: 60px;">
                <div>合計金額</div>
                <div class="total_result">
                  {{number_format(ReservationHelper::taxAndPrice(floor($price+$venue->getLayouts()[2])))}}
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td></td>
            <td style="font-size: 16px;">

            </td>
          </tr>
        </tbody>
      </table>
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
      <div class="main">
        <div class="venues" style="padding-top: 80px; width:90%; margin:0 auto;">
          <table class="table table-borderless">
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
              <tr>
                <td>{{ Form::text('venue_breakdown_item0', "会場料金",['class'=>'form-control', 'readonly'] ) }} </td>
                <td>
                  {{ Form::text('venue_breakdown_count0', ReservationHelper::getUsage($request->enter_time,$request->leave_time)."h",['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="equipment" style="padding-top: 80px; width:90%; margin:0 auto;">
          <table class="table table-borderless">
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
              @foreach ($venue->getEquipments() as $e_key=>$equipment)
              @if ($request->{'equipment_breakdown'.$e_key}>0)
              <tr>
                <td>
                  {{ Form::text('equipment_breakdown_item'.$e_key, $equipment->item,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_count'.$e_key, $request->{'equipment_breakdown'.$e_key},['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              @endif
              @endforeach
              @foreach ($venue->getServices() as $s_key=>$service)
              @if ($request->{'services_breakdown'.$s_key}>0)
              <tr>
                <td>
                  {{ Form::text('service_breakdown_item'.$s_key, $service->item,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('service_breakdown_count'.$s_key, $request->{'services_breakdown'.$s_key},['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              @endif
              @endforeach
              @if ($request->luggage_price)
              <tr>
                <td>
                  {{ Form::text('luggage_item', '荷物預かり/返送',['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('luggage_count', $request->luggage_price,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>

        <div class="layout" style="padding-top: 80px; width:90%; margin:0 auto;">
          <table class="table table-borderless">
            <tbody>
              <tr>
                <td>
                  <h1>
                    ■レイアウト（請求に100％反映）
                  </h1>
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
                <td colspan="2"></td>
                <td colspan="3">合計
                  {{ Form::text('layouts_price', $venue->getLayouts()[2],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
            @endif

          </table>
        </div>

        <div class="others" style="padding: 80px 0px 80px 0px; width:90%; margin:0 auto;">
          <table class="table table-borderless">
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
                <td>追加/削除</td>
              </tr>
            </tbody>
            <tbody class="others_main">
              <tr>
                <td>{{ Form::text('others_input_item0', '',['class'=>'form-control'] ) }}</td>
                <td>{{ Form::text('others_input_count0', '',['class'=>'form-control'] ) }}</td>
                <td>
                  <input type="button" value="＋" class="add pluralBtn">
                  <input type="button" value="ー" class="del pluralBtn">
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="bill_total d-flex justify-content-end"
          style="padding: 80px 0px 80px 0px; width:90%; margin:0 auto;">
          <div style="width: 60%;">
            <table class="table text-right" style="table-layout: fixed; font-size:16px;">
              <tbody>
                <tr>
                  <td>小計：</td>
                  <td>
                    {{ Form::text('master_subtotal',(floor($price+$venue->getLayouts()[2])) ,['class'=>'form-control text-right', 'readonly'] ) }}
                  </td>
                </tr>
                <tr>
                  <td>消費税：</td>
                  <td>
                    {{ Form::text('master_tax',ReservationHelper::getTax(floor($price+$venue->getLayouts()[2])) ,['class'=>'form-control text-right', 'readonly'] ) }}
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold">合計金額</td>
                  <td>
                    {{ Form::text('master_total',ReservationHelper::taxAndPrice(floor($price+$venue->getLayouts()[2])) ,['class'=>'form-control text-right', 'readonly'] ) }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
{{ Form::hidden('venue_id', $request->venue_id )}}
{{ Form::hidden('reserve_date', $request )}}
{{ Form::hidden('agent_id', $request )}}
{{ Form::hidden('price_system', $request )}}
{{ Form::hidden('enter_time', $request )}}
{{ Form::hidden('leave_time', $request )}}
{{ Form::hidden('board_flag', $request )}}
{{ Form::hidden('event_start',  )}}
{{ Form::hidden('event_finish', $request )}}
{{ Form::hidden('event_name1', $request )}}
{{ Form::hidden('event_name2', $request )}}
{{ Form::hidden('event_owner', $request )}}

{{ Form::hidden('luggage_arrive', $request )}}
{{ Form::hidden('luggage_return', $request )}}
{{ Form::hidden('luggage_return', $request )}}
{{ Form::hidden('luggage_price', $request )}}

{{ Form::hidden('enduser_company', $request ) }}
{{ Form::hidden('enduser_incharge', $request) }}
{{ Form::hidden('enduser_address', $request) }}
{{ Form::hidden('enduser_tel', $request) }}
{{ Form::hidden('enduser_mail', $request) }}
{{ Form::hidden('enduser_attr', $request) }}
{{ Form::hidden('enduser_charge', $request) }}
{{ Form::hidden('attention', $request) }}
{{ Form::hidden('user_details', $request) }}
{{ Form::hidden('admin_details', $request) }}
{{Form::submit('保存する', ['class'=>'btn btn-primary d-block btn-lg mx-auto mt-5 mb-5', 'id'=>'check_submit'])}}
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
        addThisTr('.others .others_main tr', 'others_input_item', 'others_input_cost', 'others_input_count','others_input_subtotal');
                // 追加時内容クリア
        $(this).parent().parent().next().find('td').find('input, select').eq(0).val('');
        $(this).parent().parent().next().find('td').find('input, select').eq(1).val('');
      });

      function addThisTr($targetTr, $TItem, $TCost,$TCount, $TSubtotal){
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
        if ($(this).parent().parent().parent().attr('class')=="others_main") {
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
</script>





@endsection