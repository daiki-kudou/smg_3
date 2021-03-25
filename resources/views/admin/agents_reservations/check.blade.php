@extends('layouts.admin.app')
@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/ajax.js') }}"></script>
{{-- <script src="{{ asset('/js/validation.js') }}"></script> --}}



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



{{Form::open(['url' => 'admin/agents_reservations', 'method' => 'POST', 'id'=>'agentReservationCreateForm'])}}
@csrf
<section class="mt-5">
  <div class="row">
    <div class="col">
      <table class="table table-bordered">
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
              {{ Form::text('reserve_date', $request->reserve_date ,['class'=>'form-control', 'id'=>'datepicker1', 'placeholder'=>'入力してください', 'readonly'] ) }}
              <p class="is-error-reserve_date" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">会場</td>
            <td>
              {{ Form::text('', ReservationHelper::getVenue($request->venue_id) ,['class'=>'form-control', 'placeholder'=>'入力してください','readonly'] ) }}
              {{ Form::hidden('venue_id', $request->venue_id ,['class'=>'form-control', 'placeholder'=>'入力してください','readonly'] ) }}
              <p class="is-error-venue_id" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">料金体系</td>
            <td>
              {{ Form::text('price_system', ReservationHelper::priceSystem($request->price_system) ,['class'=>'form-control', 'placeholder'=>'入力してください','readonly'] ) }}
              {{ Form::hidden('price_system', $request->price_system ,['class'=>'form-control', 'placeholder'=>'入力してください','readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">入室時間</td>
            <td>
              {{ Form::text('', date('H:i',strtotime($request->enter_time)) ,['class'=>'form-control','readonly'] ) }}
              {{ Form::hidden('enter_time', $request->enter_time ,['class'=>'form-control','readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">退室時間</td>
            <td>
              <div>
                {{ Form::text('', date('H:i',strtotime($request->leave_time)) ,['class'=>'form-control','readonly'] ) }}
                {{ Form::hidden('leave_time', $request->leave_time ,['class'=>'form-control','readonly'] ) }}
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
              {{ Form::text('', $request->board_flag==1?"有り":"無し" ,['class'=>'form-control','readonly'] ) }}
              {{ Form::hidden('board_flag', $request->board_flag ,['class'=>'form-control','readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント開始時間</td>
            <td>
              <div>
                {{ Form::text('', date('H:i',strtotime($request->event_start)) ,['class'=>'form-control','readonly'] ) }}
                {{ Form::hidden('event_start', $request->event_start ,['class'=>'form-control','readonly'] ) }}
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント終了時間</td>
            <td>
              {{ Form::text('', date('H:i',strtotime($request->event_finish)) ,['class'=>'form-control','readonly'] ) }}
              {{ Form::hidden('event_finish', $request->event_start ,['class'=>'form-control','readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント名称1</td>
            <td>
              {{ Form::text('event_name1', $request->event_name1 ,['class'=>'form-control','readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント名称2</td>
            <td>
              {{ Form::text('event_name2', $request->event_name2 ,['class'=>'form-control','readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">主催者名</td>
            <td>
              {{ Form::text('event_owner', $request->event_owner ,['class'=>'form-control','readonly'] ) }}
            </td>
          </tr>
        </tbody>
      </table>
      <div class="equipemnts">
        <table class="table table-bordered">
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
              <td class="table-active">{{$equ->item}}</td>
              <td>
                {{ Form::text('equipment_breakdown'.$key, $request->{'equipment_breakdown_count'.$key} ,['class'=>'form-control','readonly'] ) }}
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
                {{ Form::text('services_breakdown'.$key, $request->{'service_breakdown_count'.$key} ,['class'=>'form-control','readonly'] ) }}
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
              <th colspan="2">
                <p class="title-icon">
                  <i class="fas fa-th icon-size fa-fw" aria-hidden="true"></i>レイアウト
                </p>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="table-active">準備</td>
              <td>
                {{ Form::text('layout_prepare_count', $request->layout_prepare_count ,['class'=>'form-control','readonly'] ) }}
              </td>
            </tr>
            <tr>
              <td class="table-active">片付</td>
              <td>
                {{ Form::text('layout_clean_count', $request->layout_clean_count ,['class'=>'form-control','readonly'] ) }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
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
              <td class="table-active">事前に預かる荷物<br>（個数）</td>
              <td>
                {{ Form::text('luggage_count', $request->luggage_count,['class'=>'form-control', 'readonly'] ) }}
              </td>
            </tr>
            <tr>
              <td class="table-active">事前荷物の到着日<br>午前指定のみ</td>
              <td>
                {{ Form::text('luggage_arrive', $request->luggage_arrive,['class'=>'form-control', 'readonly'] ) }}
              </td>
            </tr>

            <tr>
              <td class="table-active">事後返送する荷物</td>
              <td>
                {{ Form::text('luggage_return', $request->luggage_return,['class'=>'form-control', 'readonly'] ) }}
              </td>
            </tr>
            <!-- <tr>
              <td class="table-active">荷物預り料金</td>
              <td>
                {{ Form::text('luggage_price', $request->luggage_price,['class'=>'form-control', 'readonly'] ) }}
              </td>
            </tr> -->
          </tbody>
        </table>
      </div>
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
                <p><a class="more_btn bg-green" href="">仲介会社詳細</a></p>
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="agent_id" class=" form_required">サービス名称</label>
            </td>
            <td>
              {{ Form::text('', ReservationHelper::getAgentCompany($request->agent_id),['class'=>'form-control', 'readonly'] ) }}
              {{ Form::hidden('agent_id', $request->agent_id,['class'=>'form-control'] ) }}
              <p class="is-error-user_id" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="name" class=" form_required">担当者氏名<br></label></td>
            <td>
              {{ Form::text('', ReservationHelper::getAgentPerson($request->agent_id),['class'=>'form-control', 'readonly'] ) }}
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
              {{ Form::text('enduser_company', $request->enduser_company,['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_address" class=" ">住所</label>
            </td>
            <td>
              {{ Form::text('enduser_address', $request->enduser_address,['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_tel" class="">連絡先</label>
            </td>
            <td>
              {{ Form::text('enduser_tel', $request->enduser_tel,['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_mail" class=" ">メールアドレス</label>
            </td>
            <td>
              {{ Form::text('enduser_mail', $request->enduser_mail,['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_incharge" class="">当日担当者</label>
            </td>
            <td>
              {{ Form::text('enduser_incharge', $request->enduser_incharge,['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_mobile" class="">当日連絡先</label>
            </td>
            <td>
              {{ Form::text('enduser_mobile', $request->enduser_mobile,['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_attr" class="">利用者属性</label>
            </td>
            <td>
              {{ Form::text('enduser_attr', $request->enduser_attr,['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
        </tbody>
      </table>
      <table class="table table-bordered sale-table">
        <tbody>
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-yen-sign icon-size" aria-hidden="true"></i>エンドユーザーへの支払い料
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">
              <label for="enduser_charge ">支払い料</label>
            </td>
            <td class="d-flex align-items-center">
              {{ Form::text('enduser_charge', $request->enduser_charge,['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
        </tbody>
      </table>
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
              {{ Form::textarea('admin_details', $request->admin_details,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

<section class="mt-5">
  <div class="bill">
    <div class="bill_head">
      <table class="table">
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
                  {{number_format($request->master_subtotal)}}
                  円
                </dd>
              </dl>
            </td>
            <td>
              <dl class="ttl_box">
                <dt>支払い期日</dt>
                <dd class="total_result">
                  {{ReservationHelper::formatDate($request->pay_limit)}}
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
                <td>数量</td>
              </tr>
            </tbody>
            <tbody class="venue_main">
              <tr>
                <td>
                  {{ Form::text('venue_breakdown_item0', $request->venue_breakdown_item0,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_count0', $request->venue_breakdown_count0,['class'=>'form-control', 'readonly'] ) }}
                </td>
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
                <td>数量</td>
              </tr>
            </tbody>
            <tbody class="equipment_main">
              @foreach ($venue->getEquipments() as $key=>$equ)
              @if (!empty($request->{'equipment_breakdown_item'.$key}))
              <tr>
                <td>
                  {{ Form::text('equipment_breakdown_item'.$key, $request->{'equipment_breakdown_item'.$key} ,['class'=>'form-control','readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_count'.$key, $request->{'equipment_breakdown_count'.$key} ,['class'=>'form-control','readonly'] ) }}
                </td>
              </tr>
              @endif
              @endforeach

              @foreach ($venue->getServices() as $key=>$ser)
              @if (!empty($request->{'service_breakdown_item'.$key}))
              <tr>
                <td>
                  {{ Form::text('service_breakdown_item'.$key, $request->{'service_breakdown_item'.$key} ,['class'=>'form-control','readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('service_breakdown_count'.$key, $request->{'service_breakdown_count'.$key} ,['class'=>'form-control','readonly'] ) }}
                </td>
              </tr>
              @endif
              @endforeach
              @if ($request->luggage_count)
              <tr>
                <td>
                  {{ Form::text('luggage_item', $request->luggage_item ,['class'=>'form-control','readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('luggage_count', $request->luggage_count ,['class'=>'form-control','readonly'] ) }}
                </td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>

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
              @if ($request->layout_prepare_count==1)
              <tr>
                <td>
                  {{ Form::text('layout_prepare_item', $request->layout_prepare_item ,['class'=>'form-control','readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_prepare_cost', $request->layout_prepare_cost ,['class'=>'form-control','readonly'] ) }}
                </td>
                </td>
                <td>
                  {{ Form::text('layout_prepare_count', $request->layout_prepare_count ,['class'=>'form-control','readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_prepare_subtotal', $request->layout_prepare_subtotal ,['class'=>'form-control','readonly'] ) }}
                </td>
              </tr>
              @endif
              @if ($request->layout_clean_count==1)
              <tr>
                <td>
                  {{ Form::text('layout_clean_item', $request->layout_clean_item ,['class'=>'form-control','readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_clean_cost', $request->layout_clean_cost ,['class'=>'form-control','readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_clean_count', $request->layout_clean_count ,['class'=>'form-control','readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_clean_subtotal', $request->layout_clean_subtotal ,['class'=>'form-control','readonly'] ) }}
                </td>
              </tr>
              @endif
            </tbody>
            <tbody class="layouts_result">
              <tr>
                <td colspan="2"></td>
                <td colspan="2">合計
                  {{ Form::text('layouts_price', $request->layouts_price,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>


        @if ($others_details!="")
        <div class="others" style="padding: 80px 0px 80px 0px; width:90%; margin:0 auto;">
          <table class="table table-borderless" style="table-layout: fixed;">
            <tr>
              <td>
                <h1>
                  ■その他
                </h1>
              </td>
            </tr>
            <tbody class="others_head">
              <tr>
                <td>内容</td>
                <td>数量</td>
              </tr>
            </tbody>
            <tbody class="others_main">
              @for ($i = 0; $i < $others_details; $i++) <tr>
                <td>
                  {{ Form::text('others_breakdown_item'.$i, $request->{'others_input_item'.$i} ,['class'=>'form-control','readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('others_breakdown_count'.$i, $request->{'others_input_count'.$i} ,['class'=>'form-control','readonly'] ) }}
                </td>
                </tr>
                @endfor
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
                  {{ Form::text('master_subtotal',$request->master_subtotal ,['class'=>'form-control text-right', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td>消費税：</td>
                <td>
                  {{ Form::text('master_tax',$request->master_tax ,['class'=>'form-control text-right', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td class="font-weight-bold">合計金額</td>
                <td>
                  {{ Form::text('master_total',$request->master_total ,['class'=>'form-control text-right', 'readonly'] ) }}
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
                <td>請求日：</td>
                <td>支払期日
                  {{ Form::text('pay_limit', $request->pay_limit,['class'=>'form-control', 'id'=>'datepicker6', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td>
                  請求書宛名
                  {{ Form::text('pay_company', $request->pay_company,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  担当者
                  {{ Form::text('bill_person', $request->bill_person,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td colspan="2">
                  請求書備考
                  {{ Form::textarea('bill_remark', $request->bill_remark,['class'=>'form-control', 'readonly'] ) }}
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
                  {{ Form::text('paid', $request->paid,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  入金日
                  {{ Form::text('pay_day', $request->pay_day,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td>振込人名{{ Form::text('pay_person', $request->pay_day,['class'=>'form-control', 'readonly'] ) }}</td>
                <td>入金額{{ Form::text('payment', $request->payment,['class'=>'form-control', 'readonly'] ) }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="container-field d-flex justify-content-center mt-5">
  <a href="javascript:$('#back').submit()" class="btn more_btn4_lg d-block mr-5">請求内訳を修正する</a>
  {{Form::submit('予約を登録する', ['class'=>'d-block btn more_btn_lg', 'id'=>'check_submit'])}}
  {{Form::close()}}
</div>

{{Form::open(['url' => 'admin/agents_reservations/calculate', 'method' => 'POST', 'id'=>'back'])}}
{{ Form::hidden('reserve_date', $request->reserve_date) }}
{{ Form::hidden('venue_id', $request->venue_id)}}
{{ Form::hidden('price_system', $request->price_system)}}
{{ Form::hidden('enter_time', $request->enter_time)}}
{{ Form::hidden('leave_time', $request->leave_time)}}
{{ Form::hidden('board_flag', $request->board_flag)}}
{{ Form::hidden('event_start', $request->event_start)}}
{{ Form::hidden('event_finish', $request->event_start)}}
{{ Form::hidden('event_name1', $request->event_name1)}}
{{ Form::hidden('event_name2', $request->event_name2)}}
{{ Form::hidden('event_owner', $request->event_owner)}}
@foreach ($venue->getEquipments() as $key=>$equ)
{{ Form::hidden('equipment_breakdown'.$key, $request->{'equipment_breakdown_count'.$key})}}
@endforeach
@foreach ($venue->getServices() as $key=>$ser)
{{ Form::hidden('services_breakdown'.$key, $request->{'service_breakdown_count'.$key})}}
@endforeach
{{ Form::hidden('layout_prepare_count', $request->layout_prepare_count)}}
{{ Form::hidden('layout_clean_count', $request->layout_clean_count)}}
{{ Form::hidden('luggage_count', $request->luggage_count)}}
{{ Form::hidden('luggage_arrive', $request->luggage_arrive)}}
{{ Form::hidden('luggage_return', $request->luggage_return)}}
{{ Form::hidden('luggage_price', $request->luggage_price)}}
{{ Form::hidden('agent_id', $request->agent_id,['class'=>'form-control'])}}
{{ Form::hidden('enduser_company', $request->enduser_company)}}
{{ Form::hidden('enduser_incharge', $request->enduser_incharge)}}
{{ Form::hidden('enduser_address', $request->enduser_address)}}
{{ Form::hidden('enduser_tel', $request->enduser_tel)}}
{{ Form::hidden('enduser_mail', $request->enduser_mail)}}
{{ Form::hidden('enduser_attr', $request->enduser_attr)}}
{{ Form::hidden('enduser_charge', $request->enduser_charge)}}
{{ Form::hidden('enduser_mobile', $request->enduser_mobile)}}
{{ Form::hidden('attention', $request->attention)}}
{{ Form::hidden('user_details', $request->user_details)}}
{{ Form::hidden('admin_details', $request->admin_details)}}
{{Form::close()}}
@endsection