@extends('layouts.admin.app')
@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
{{-- <script src="{{ asset('/js/admin/reservation.js') }}"></script> --}}
<script src="{{ asset('/js/ajax.js') }}"></script>
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/admin/validation.js') }}"></script>


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
            $($targetTr).eq(index).find('td').eq(1).find('input').attr('name', $TCount + index);
            // $($targetTr).eq(index).find('td').eq(2).find('input').attr('name', $TCount + index);
            // $($targetTr).eq(index).find('td').eq(3).find('input').attr('name', $TSubtotal + index);
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
              $('.others_main tr').eq(index).find('td').eq(1).find('input').attr('name', 'others_input_count' + index);
            }
          }
        });
      });
    })
  </script>

  <div id="fullOverlay">
    <div class="frame_spinner">
      <div class="spinner-border text-primary " role="status">
        <span class="sr-only hide">Loading...</span>
      </div>
    </div>
  </div>


  {{Form::open(['url' => 'admin/agents_reservations/calculate', 'method' => 'POST', 'id'=>'agentReservationCreateForm'])}}
  @csrf
  <section class="mt-5">
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
                {{ Form::text('reserve_date', $request->reserve_date ,['class'=>'form-control', 'id'=>'datepicker1', 'placeholder'=>'入力してください'] ) }}
                <p class="is-error-reserve_date" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active form_required">会場</td>
              <td>
                <select id="venues_selector" class=" form-control" name='venue_id'>
                  <option value='#' disabled selected>選択してください</option>
                  @foreach ($venues as $venue)
                  <option value="{{$venue->id}}" @if ($request->venue_id==$venue->id)
                    selected
                    @endif
                    >
                    {{ReservationHelper::getVenue($venue->id)}}
                  </option>
                  @endforeach
                </select>
                <p class="is-error-venue_id" style="color: red"></p>
                <div class="price_selector">
                  <div>
                    <small>※料金体系を選択してください</small>
                  </div>
                  <div class="price_radio_selector">
                    <div class="d-flex justfy-content-start align-items-center">
                      {{ Form::radio('price_system', 1, $request->price_system==1?true:false, ['class'=>'mr-2', 'id'=>'price_system_radio1']) }}
                      {{Form::label('price_system_radio1','通常（枠貸）')}}
                    </div>
                    <div class="d-flex justfy-content-start align-items-center">
                      {{ Form::radio('price_system', 2, $request->price_system==2?true:false, ['class'=>'mr-2','id'=>'price_system_radio2']) }}
                      {{Form::label('price_system_radio2','アクセア（時間貸）')}}
                    </div>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td class="table-active form_required">入室時間</td>
              <td>
                <div>
                  <select name="enter_time" id="sales_start" class="form-control">
                    <option disabled selected></option>
                    @for ($start = 0*2; $start <=23*2; $start++) <option value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if(!empty($request->
                      enter_time))
                      @if($request->enter_time==date("H:i:s", strtotime("00:00+".$start * 30 ." minute")))
                      selected
                      @endif
                      @endif
                      >
                      {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}
                      </option>
                      @endfor
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
                    @for ($start = 0*2; $start <=23*2; $start++) <option value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if(!empty($request->
                      leave_time))
                      @if($request->leave_time==date("H:i:s", strtotime("00:00
                      +".$start * 30 ." minute"))) selected @endif @endif>
                      {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}</option>
                      @endfor
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
                    {{ Form::radio('board_flag', 0, $request->board_flag==0?true:false, ['class'=>'mr-2', 'id'=>'board_flag1']) }}
                    {{Form::label('board_flag1','無し')}}
                  </p>
                  <p>
                    {{ Form::radio('board_flag', 1, $request->board_flag==1?true:false, ['class'=>'mr-2', 'id'=>'board_flag2']) }}
                    {{Form::label('board_flag2','有り')}}
                  </p>
                </div>
              </td>
            </tr>
            <tr>
              <td class="table-active">イベント開始時間</td>
              <td>
                <div>
                  <select name="event_start" id="event_start" class="form-control">
                    <option disabled>選択してください</option>
                    @for ($start = 0*2; $start <=23*2; $start++) <option value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if(!empty($request->
                      event_start))
                      @if($request->event_start==date("H:i:s", strtotime("00:00 +".
                      $start * 30 ." minute"))) selected @endif @endif>
                      {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}</option>
                      @endfor
                  </select>
                </div>
              </td>
            </tr>
            <tr>
              <td class="table-active">イベント終了時間</td>
              <td>
                <div>
                  <select name="event_finish" id="event_finish" class="form-control">
                    <option disabled>選択してください</option>
                    @for ($start = 0*2; $start <=23*2; $start++) <option value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if(!empty($request->
                      event_finish)) @if($request->event_finish==date("H:i:s", strtotime("00:00
                      +". $start * 30 ." minute"))) selected @endif @endif>
                      {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}</option>
                      @endfor
                  </select>
                </div>
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
                {{ Form::text('event_name2',$request->event_name2,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
              </td>
            </tr>
            <tr>
              <td class="table-active">主催者名</td>
              <td>
                {{ Form::text('event_owner',$request->event_owner,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
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
              @foreach ($SPvenue->getEquipments() as $key=>$equipment)
              <tr>
                <td class="table-active">{{$equipment->item}}</td>
                <td>
                  {{ Form::text('equipment_breakdown'.$key, $request->{'equipment_breakdown'.$key},['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
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
              @foreach ($SPvenue->getServices() as $key=>$service)
              <tr>
                <td class="table-active">{{$service->item}}</td>
                <td>
                  <div class="form-check form-check-inline">
                    {{Form::radio('services_breakdown'.$key, 1,$request->{'services_breakdown'.$key}==1?true:false , ['id' => 'service'.$key.'on', 'class' => 'form-check-input'])}}
                    <label for="{{'service'.$key.'on'}}" class="form-check-label">有り</label>
                    {{Form::radio('services_breakdown'.$key, 0, $request->{'services_breakdown'.$key}==0?true:false, ['id' => 'service'.$key.'off', 'class' => 'form-check-input'])}}
                    <label for="{{'service'.$key.'off'}}" class="form-check-label">無し</label>
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
                  <div class="form-check form-check-inline">
                    {{Form::radio('layout_prepare', 1, $request->layout_prepare==1?true:false, ['id' => 'layout_prepare', 'class' => 'form-check-input'])}}
                    <label for='layout_prepare' class="form-check-label">有り</label>
                    {{Form::radio('layout_prepare', 0, $request->layout_prepare==0?true:false, ['id' => 'no_layout_prepare', 'class' => 'form-check-input'])}}
                    <label for='no_layout_prepare' class="form-check-label">無し</label>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="table-active">片付</td>
                <td>
                  <div class="form-check form-check-inline">
                    {{Form::radio('layout_clean', 1, $request->layout_clean==1?true:false, ['id' => 'layout_clean', 'class' => 'form-check-input'])}}
                    <label for='layout_clean' class="form-check-label">有り</label>
                    {{Form::radio('layout_clean', 0, $request->layout_clean==0?true:false, ['id' => 'no_layout_clean', 'class' => 'form-check-input'])}}
                    <label for='no_layout_clean' class="form-check-label">無し</label>
                  </div>
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
                    <i class="fas fa-suitcase-rolling icon-size fa-fw" aria-hidden="true"></i>荷物預かり
                  </p>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="table-active">事前に預かる荷物<br>（個数）</td>
                <td>
                  {{ Form::text('luggage_count', $request->luggage_count,['class'=>'form-control'] ) }}
                </td>
              </tr>
              <tr>
                <td class="table-active">事前荷物の到着日<br>午前指定のみ</td>
                <td>
                  {{ Form::text('luggage_arrive', $request->luggage_arrive,['class'=>'form-control','id'=>'datepicker'] ) }}
                </td>
              </tr>

              <tr>
                <td class="table-active">事後返送する荷物</td>
                <td>
                  {{ Form::text('luggage_return', $request->luggage_return,['class'=>'form-control'] ) }}
                </td>
              </tr>
              <!-- <tr>
                <td class="table-active">荷物預かり/返送<br>料金</td>
                <td>
                  {{ Form::text('luggage_price', $request->luggage_price,['class'=>'form-control'] ) }}
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
                <select class="form-control" name="agent_id" id="agent_select">
                  <option disabled selected>選択してください</option>
                  @foreach ($agents as $agent)
                  <option value="{{$agent->id}}" @if ($agent->id==$request->agent_id)
                    selected
                    @endif
                    >{{ReservationHelper::getAgentCompany($agent->id)}}
                    |{{ReservationHelper::getAgentPerson($agent->id)}}
                    | {{$agent->email}}
                  </option>
                  @endforeach
                </select>
                <p class="is-error-user_id" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="name" class=" form_required">担当者氏名<br></label></td>
              <td>
                <p class="selected_person">{{ReservationHelper::getAgentPerson($request->agent_id)}}</p>
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
                {{ Form::text('enduser_company', $request->enduser_company,['class'=>'form-control', 'placeholder'=>'入力してください','id'=>'enduser_company'] ) }}
              </td>
            </tr>
            <tr>
              <td class="table-active">
                <label for="enduser_address" class=" ">住所</label>
              </td>
              <td>
                {{ Form::text('enduser_address', $request->enduser_address,['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'enduser_address'] ) }}
              </td>
            </tr>
            <tr>
              <td class="table-active">
                <label for="enduser_tel" class="">連絡先</label>
              </td>
              <td>
                {{ Form::text('enduser_tel', $request->enduser_tel,['class'=>'form-control', 'placeholder'=>'入力してください', 'maxlength'=>13, 'id'=>'enduser_tel'] ) }}
              </td>
            </tr>
            <tr>
              <td class="table-active">
                <label for="enduser_mail" class=" ">メールアドレス</label>
              </td>
              <td>
                {{ Form::text('enduser_mail', $request->enduser_mail,['class'=>'form-control', 'placeholder'=>'入力してください', 'maxlength'=>13,'id'=>'enduser_mail'] ) }}
              </td>
            </tr>
            <tr>
              <td class="table-active">
                <label for="enduser_incharge" class="">当日担当者</label>
              </td>
              <td>
                {{ Form::text('enduser_incharge', $request->enduser_incharge,['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'enduser_incharge'] ) }}
              </td>
            </tr>
            <tr>
              <td class="table-active">
                <label for="enduser_mobile" class="">当日連絡先</label>
              </td>
              <td>
                {{ Form::text('enduser_mobile', "",['class'=>'form-control', 'placeholder'=>'入力してください', 'maxlength'=>13, 'id'=>'enduser_tel'] ) }}
              </td>
            </tr>
            <tr>
              <td class="table-active">
                <label for="enduser_attr" class="">利用者属性</label>
              </td>
              <td>
                {{ Form::text('enduser_attr', $request->enduser_attr,['class'=>'form-control', 'placeholder'=>'入力してください', 'maxlength'=>13, 'id'=>'enduser_attr'] ) }}
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
                <label for="enduser_charge ">支払い料</label>
              </td>
              <td class="d-flex align-items-center">
                {{ Form::text('enduser_charge', $request->enduser_charge,['class'=>'form-control sales_percentage', 'placeholder'=>'入力してください'] ) }}円
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

  {{Form::submit('再計算する', ['class'=>'my-5 btn more_btn4_lg mx-auto d-block btn-lg', 'id'=>'check_submit'])}}

  {{Form::close()}}



  {{ Form::open(['url' => 'admin/agents_reservations/check', 'method'=>'POST', 'id'=>'agents_calculate_form']) }}
  @csrf
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
                  <dd class="total_result">{{number_format(floor($price))}}円</dd>
                </dl>
              </td>
              <td>
                <dl class="ttl_box">
                  <dt>支払い期日</dt>
                  <dd class="total_result">
                    {{ReservationHelper::formatDate($payment_limit)}}
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
                    {{ Form::text('venue_breakdown_item0', "会場料金",['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('venue_breakdown_count0', $usage_hours."h",['class'=>'form-control', 'readonly'] ) }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          @if ($_equipment>0||$_service>0||$request->luggage_price>0)

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
                  <td>数量</td>
                </tr>
              </tbody>
              <tbody class="equipment_main">
                @foreach ($SPvenue->getEquipments() as $key=>$equipment)
                @if ($request->{'equipment_breakdown'.$key}>0)
                <tr>
                  <td>
                    {{ Form::text('equipment_breakdown_item'.$key, $equipment->item,['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('equipment_breakdown_count'.$key, $request->{'equipment_breakdown'.$key},['class'=>'form-control', 'readonly'] ) }}
                  </td>
                </tr>
                @endif
                @endforeach
                @foreach ($SPvenue->getServices() as $key=>$service)
                @if ($request->{'services_breakdown'.$key}>0)
                <tr>
                  <td>
                    {{ Form::text('service_breakdown_item'.$key, $service->item,['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('service_breakdown_count'.$key, $request->{'services_breakdown'.$key},['class'=>'form-control', 'readonly'] ) }}
                  </td>
                </tr>
                @endif
                @endforeach
                @if (!empty($request->luggage_price))
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
          @endif

          @if ($request->layout_prepare!=0&&$request->layout_clean!=0)
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
                @if ($request->layout_prepare!=0)
                <tr>
                  <td>{{ Form::text('layout_prepare_item', "レイアウト準備料金",['class'=>'form-control', 'readonly'] ) }}</td>
                  <td>
                    {{ Form::text('layout_prepare_cost', $SPvenue->getLayouts()[0],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>{{ Form::text('layout_prepare_count', 1,['class'=>'form-control', 'readonly'] )}}</td>
                  <td>
                    {{ Form::text('layout_prepare_subtotal', $SPvenue->getLayouts()[0],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                </tr>
                @endif
                @if ($request->layout_clean!=0)
                <tr>
                  <td>{{ Form::text('layout_clean_item', "レイアウト片付料金",['class'=>'form-control', 'readonly'] ) }}</td>
                  <td>
                    {{ Form::text('layout_clean_cost', $SPvenue->getLayouts()[1],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>{{ Form::text('layout_clean_count', 1,['class'=>'form-control', 'readonly'] )}}</td>
                  <td>
                    {{ Form::text('layout_clean_subtotal', $SPvenue->getLayouts()[1],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                </tr>
                @endif
              </tbody>
              <tbody class="layouts_result">
                <tr>
                  <td colspan="2"></td>
                  <td colspan="3">合計
                    {{ Form::text('layouts_price', $layout_price,['class'=>'form-control', 'readonly'] ) }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          @endif


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

          <div class="bill_total">
            <table class="table text-right">
              <tbody>
                <tr>
                  <td>小計：</td>
                  <td>
                    {{ Form::text('master_subtotal',(floor($price)) ,['class'=>'form-control text-right', 'readonly'] ) }}
                  </td>
                </tr>
                <tr>
                  <td>消費税：</td>
                  <td>
                    {{ Form::text('master_tax',ReservationHelper::getTax($price) ,['class'=>'form-control text-right', 'readonly'] ) }}
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold">合計金額</td>
                  <td>
                    {{ Form::text('master_total',ReservationHelper::taxAndPrice($price) ,['class'=>'form-control text-right', 'readonly'] ) }}
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
                  <td>支払期日 {{ Form::text('pay_limit', $payment_limit,['class'=>'form-control', 'id'=>'datepicker6'] ) }}
                  </td>
                </tr>
                <tr>
                  <td>
                    請求書宛名
                    {{ Form::text('pay_company', ReservationHelper::getAgentCompany($agent->id),['class'=>'form-control'] ) }}
                  </td>
                  <td>
                    担当者
                    {{ Form::text('bill_person', ReservationHelper::getAgentPerson($agent->id),['class'=>'form-control'] ) }}

                  </td>
                </tr>
                <tr>
                  <td colspan="2">請求書備考
                    {{ Form::textarea('bill_remark', '',['class'=>'form-control'] ) }}
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
                  <td>入金状況<select class="form-control" name="paid">
                      <option value="0">未入金</option>
                      <option value="1">入金済み</option>
                    </select></td>
                  <td>
                    入金日<input class="form-control" id="datepicker7" name="pay_day" type="text">
                  </td>
                </tr>
                <tr>
                  <td>振込人名<input class="form-control" name="pay_person" type="text"></td>
                  <td>入金額<input class="form-control" name="payment" type="text"></td>
                </tr>
              </tbody>
            </table>
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
  {{ Form::hidden('event_start', $request->event_start)}}
  {{ Form::hidden('event_finish', $request->event_finish )}}
  {{ Form::hidden('event_name1', $request->event_name1 )}}
  {{ Form::hidden('event_name2', $request->event_name2 )}}
  {{ Form::hidden('event_owner', $request->event_owner )}}

  {{ Form::hidden('luggage_arrive', $request->luggage_arrive )}}
  {{ Form::hidden('luggage_return', $request->luggage_return )}}
  {{ Form::hidden('luggage_return', $request->luggage_return )}}
  {{ Form::hidden('luggage_price', $request->luggage_price )}}

  {{ Form::hidden('enduser_company', $request->enduser_company ) }}
  {{ Form::hidden('enduser_incharge', $request->enduser_incharge) }}
  {{ Form::hidden('enduser_address', $request->enduser_address) }}
  {{ Form::hidden('enduser_tel', $request->enduser_tel) }}
  {{ Form::hidden('enduser_mail', $request->enduser_mail) }}
  {{ Form::hidden('enduser_attr', $request->enduser_attr) }}
  {{ Form::hidden('enduser_charge', $request->enduser_charge) }}
  {{ Form::hidden('attention', $request->attention) }}
  {{ Form::hidden('user_details', $request->user_details) }}
  {{ Form::hidden('admin_details', $request->admin_details) }}

  {{Form::submit('確認する', ['class'=>'btn more_btn_lg d-block  mx-auto my-5', 'id'=>'check_submit'])}}
  {{Form::close()}}

</div>
@endsection