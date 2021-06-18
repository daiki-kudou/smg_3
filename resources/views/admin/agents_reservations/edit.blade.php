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
<script src="{{ asset('/js/lettercounter.js') }}"></script>
<script src="{{ asset('/js/admin/agents_reservation/validation.js') }}"></script>


<div class="">
  {{-- <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">
          <a href="http://staging-smg2.herokuapp.com/admin/home">ホーム</a>
          仲介会社経由　予約　編集
        </li>
      </ol>
    </nav>
  </div> --}}
  <h2 class="mt-3 mb-3">仲介会社経由　予約　編集</h2>
  <hr>

  <div class="alert-box d-flex align-items-center mb-0 mt-5">
    <p>
      編集を行う場合は、必ず計算するボタンをクリックしてください。<br>
      請求書内容は、計算するボタンをクリック後の画面で編集できます。
    </p>
  </div>　

  {{ Form::open(['url' => 'admin/agents_reservations/session_input', 'method'=>'post', 'class'=>'', 'id'=>'agents_reservations_edit']) }}
  {{Form::hidden('agent_id',$reservation->agent->id)}}
  {{Form::hidden('reservation_id',$reservation->id)}}
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
              {{ Form::text('reserve_date', date('Y-m-d', strtotime($reservation->reserve_date)) ,['class'=>'form-control',  'readonly'] ) }}
              <p class="is-error-reserve_date" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">会場</td>
            <td>
              {{ Form::text('',  ReservationHelper::getVenue($reservation->venue_id),['class'=>'form-control',  'readonly'] ) }}
              {{ Form::hidden('venue_id',  $reservation->venue_id,['class'=>'form-control',  'readonly'] ) }}
              <p class="is-error-venue_id" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active">料金体系</td>
            <td>
              <div class='price_radio_selector'>
                <div class="d-flex justfy-content-start align-items-center">
                  {{ Form::radio('price_system', 1, isset($reservation->price_system)?$reservation->price_system==1?true:false:'', ['class'=>'mr-2', 'id'=>'price_system_radio1']) }}
                  {{Form::label('price_system_radio1','通常（枠貸）')}}
                </div>
                <div class="d-flex justfy-content-start align-items-center">
                  {{ Form::radio('price_system', 2, isset($reservation->price_system)?$reservation->price_system==2?true:false:'', ['class'=>'mr-2','id'=>'price_system_radio2']) }}
                  {{Form::label('price_system_radio2','アクセア（時間貸）')}}
                </div>
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
                  {{Form::label('board_flag','あり')}}
                </p>
                <p>
                  <input type="radio" name="board_flag" value="0" id="no_board_flag"
                    {{isset($reservation->board_flag)?$reservation->board_flag==0?'checked':'':'checked',}}>
                  {{Form::label('no_board_flag','無し')}}
                </p>
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント開始時間</td>
            <td>
              <select name="event_start" id="event_start" class="form-control">
                <option></option>
                {!!ReservationHelper::timeOptionsWithRequest($reservation->event_start)!!}
              </select>
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント終了時間</td>
            <td>
              <select name="event_finish" id="event_finish" class="form-control">
                <option></option>
                {!!ReservationHelper::timeOptionsWithRequest($reservation->event_finish)!!}
              </select>
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント名称1</td>
            <td>
              <div class="align-items-end d-flex">
                {{ Form::text('event_name1', $reservation->event_name1,['class'=>'form-control', 'id'=>'eventname1Count'] ) }}
                <span class="ml-1 annotation count_num1"></span>
              </div>
              <p class="is-error-event_name1" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント名称2</td>
            <td>
              <div class="align-items-end d-flex">
                {{ Form::text('event_name2', $reservation->event_name2,['class'=>'form-control', 'id'=>'eventname2Count'] ) }}
                <span class="ml-1 annotation count_num2"></span>
              </div>
              <p class="is-error-event_name2" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active">主催者名</td>
            <td>
              <div class="align-items-end d-flex">
                {{ Form::text('event_owner', $reservation->event_owner,['class'=>'form-control', 'id'=>'eventownerCount'] ) }}
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
                  <input type="text" class="form-control equipment_breakdown equipment_validation" name="{{'equipment_breakdown'.$key}}"
                    @foreach($reservation->bills->sortBy("id")->first()->breakdowns->where('unit_type',2) as $e_break)
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
              @foreach ($reservation->venue->getServices() as $key=>$service)
              <tr>
                <td class="table-active">{{$service->item}}</td>
                <td>
                  @if ($reservation->bills->sortBy("id")->first()->breakdowns->count()!=0)
                  @foreach ($reservation->bills->sortBy("id")->first()->breakdowns as $s_break)
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
              @endforeach </tbody>
          </table>
        </div>


        @if ($reservation->venue->layout!=0)
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
              @if ($reservation->venue->layout_prepare)
              <tr>
                <td class="table-active">準備</td>
                <td>
                  <div class="radio-box">
                    @if ($reservation->bills->sortBy("id")->first()->breakdowns->count()!=0)
                    @foreach ($reservation->bills->sortBy("id")->first()->breakdowns as $key=>$l_break)
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
                <td class="table-active">片付</td>
                <td>
                  <div class="radio-box">
                    @if ($reservation->bills->sortBy("id")->first()->breakdowns->count()!=0)
                    @foreach ($reservation->bills->sortBy("id")->first()->breakdowns as $key=>$lc_break)
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
            </tbody>
          </table>
        </div>
        @endif



        @if ($reservation->venue->luggage_flag!=0)
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
                <td class="table-active">事前に預かる荷物<br>（個数）</td>
                <td>
                  {{ Form::text('luggage_count', $reservation->luggage_count,['class'=>'form-control'] ) }}
                  <p class="is-error-luggage_count" style="color: red"></p>
                </td>
              </tr>
              <tr>
                <td class="table-active">事前荷物の到着日<br>午前指定のみ</td>
                <td>
                  {{ Form::text('luggage_arrive', $reservation->luggage_arrive,['class'=>'form-control limited_datepicker'] ) }}
                </td>
              </tr>
              <tr>
                <td class="table-active">事後返送する荷物</td>
                <td>
                  {{ Form::text('luggage_return', $reservation->luggage_return,['class'=>'form-control'] ) }}
                  <p class="is-error-luggage_return" style="color: red"></p>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        @endif

        @if ($reservation->venue->eat_in_flag!=0)
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
                  {{Form::radio('eat_in_prepare', 1, $reservation->eat_in==1?($reservation->eat_in_prepare==1?true:false):"" , ['id' => 'eat_in_prepare', $reservation->eat_in==0?'disabled':''])}}
                  {{Form::label('eat_in_prepare',"手配済み")}}
                  {{Form::radio('eat_in_prepare', 2, $reservation->eat_in==1?($reservation->eat_in_prepare==2?true:false):"" , ['id' => 'eat_in_consider',$reservation->eat_in==0?'disabled':''])}}
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
        @endif


      </div>
      <div class="col">
        <div class="client_mater">
          <table class="table table-bordered name-table">
            <tr>
              <td colspan="2">
                <div class="d-flex align-items-center justify-content-between">
                  <p class="title-icon">
                    <i class="far fa-id-card icon-size"></i>仲介会社情報
                  </p>
                  <p>
                    <a class="more_btn" href="{{url('admin/clients/'.$reservation->user_id)}}">顧客詳細</a>
                  </p>
                </div>
              </td>
            </tr>
            <tr>
              <td class="table-active">
                <label for="agent_id">サービス名称</label>
              </td>
              <td>
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
                <p class="is-error-user_id" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="name">担当者氏名<br></label></td>
              <td>
                {{ReservationHelper::getAgentPerson($reservation->agent_id)}}
                <p class="selected_person"></p>
              </td>
            </tr>
          </table>
          <table class="table table-bordered oneday-table">
            <tr>
              <td colspan="2">
                <p class="title-icon">
                  <i class="fas fa-user-check icon-size"></i>エンドユーザー情報
                </p>
              </td>
            </tr>
            <tr>
              <td class="table-active">
                <label for="enduser_company" class="">エンドユーザー</label>
              </td>
              <td>
                {{ Form::text('enduser_company', $reservation->enduser->company,['class'=>'form-control', 'placeholder'=>'入力してください','id'=>'enduser_company'] ) }}
              </td>
            </tr>
            <tr>
              <td class="table-active">
                <label for="enduser_address" class=" ">住所</label>
              </td>
              <td>
                {{ Form::text('enduser_address', $reservation->enduser->address,['class'=>'form-control', 'placeholder'=>'入力してください','id'=>'enduser_address'] ) }}
              </td>
            </tr>
            <tr>
              <td class="table-active">
                <label for="enduser_tel" class="">連絡先</label>
              </td>
              <td>
                {{ Form::text('enduser_tel', $reservation->enduser->tel,['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'enduser_tel'] ) }}
                <p class="is-error-enduser_tel" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active">
                <label for="enduser_mail" class=" ">メールアドレス</label>
              </td>
              <td>
                {{ Form::text('enduser_mail', $reservation->enduser->email,['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'enduser_mail'] ) }}
                <p class="is-error-enduser_mail" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active">
                <label for="enduser_incharge" class="">当日担当者</label>
              </td>
              <td>
                {{ Form::text('enduser_incharge', $reservation->enduser->person,['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'enduser_incharge'] ) }}
              </td>
            </tr>
            <tr>
              <td class="table-active">
                <label for="" class="">当日連絡先</label>
              </td>
              <td>
                {{ Form::text('enduser_mobile', $reservation->enduser->mobile,['class'=>'form-control', 'placeholder'=>'入力してください', 'id'=>'enduser_mobile'] ) }}
                <p class="is-error-enduser_mobile" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active">
                <label for="enduser_attr" class="">利用者属性</label>
              </td>
              <td>
                <select name="enduser_attr" class="form-control">
                  <option value="1" {{$reservation->enduser->attr==1?"selected":""}}>一般企業</option>
                  <option value="2" {{$reservation->enduser->attr==2?"selected":""}}>上場企業</option>
                  <option value="3" {{$reservation->enduser->attr==3?"selected":""}}>近隣利用</option>
                  <option value="4" {{$reservation->enduser->attr==4?"selected":""}}>個人講師</option>
                  <option value="5" {{$reservation->enduser->attr==5?"selected":""}}>MLM</option>
                  <option value="6" {{$reservation->enduser->attr==6?"selected":""}}>その他</option>
                </select>
              </td>
            </tr>
          </table>
        </div>
        <table class="table table-bordered sale-table">
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-yen-sign icon-size"></i>エンドユーザーへの支払い料
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">
              <label for="enduser_charge">支払い料</label>
            </td>
            <td>
              <div class="d-flex align-items-center">
                {{ Form::text('enduser_charge', $reservation->enduser->charge,['class'=>'form-control ', 'placeholder'=>'入力してください'] ) }}
                <span class="ml-1">円</span>
              </div>
              <p class="is-error-enduser_charge" style="color: red"></p>
            </td>
          </tr>
        </table>

        @if ($reservation->venue->alliance_flag!=0)
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
                {{Form::text('cost',$reservation->cost,['class'=>'form-control sales_percentage'])}}
                <span class="ml-1">%</span>
                <p class="is-error-cost" style="color: red"></p>
              </td>
            </tr>
          </tbody>
        </table>
        @endif

        <table class="table table-bordered note-table">
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-envelope icon-size"></i>備考
              </p>
            </td>
          </tr>
          <tr>
            <td>
              <label for="adminNote">管理者備考</label>
              <div>
                {{ Form::textarea('admin_details', $reservation->admin_details,['class'=>'form-control ', 'placeholder'=>'入力してください'] ) }}
              </div>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </section>
  {{Form::submit('計算する', ['class'=>'btn more_btn_lg mx-auto d-block mt-5 mb-5', 'id'=>'check_submit'])}}
  {{Form::close()}}

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
                <dd class="total_result">
                  {{$reservation->bills->sortBy("id")->first()->master_total}}
                  円</dd>
              </dl>
            </td>
            <td>
              <dl class="ttl_box">
                <dt>支払い期日</dt>
                <dd class="total_result">
                  {{ReservationHelper::formatDate($reservation->bills->sortBy("id")->first()->payment_limit)}}
                </dd>
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
                @foreach ($reservation->bills->sortBy("id")->first()->breakdowns->where('unit_type',1) as
                $v_key=>$venue_break)
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
              </tbody>
            </table>
          </div>

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
                @foreach ($reservation->bills->sortBy("id")->first()->breakdowns->where('unit_type',2) as
                $e_key=>$equipment_break)
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
                @foreach ($reservation->bills->sortBy("id")->first()->breakdowns->where('unit_type',3) as
                $s_key=>$service_break)
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
              </tbody>
            </table>
          </div>

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
                @foreach ($reservation->bills->sortBy("id")->first()->breakdowns->where('unit_type',4) as
                $l_key=>$layout_break)
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
              </tbody>
              <tbody class="layout_result">
                <tr>
                  <td colspan="3"></td>
                  <td colspan="1">
                    <p class="text-left">合計</p>
                    {{ Form::text('layout_price',$reservation->bills->sortBy("id")->first()->layout_price ,['class'=>'form-control', 'readonly'] ) }}
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
                  {!!empty(preg_match('/edit_check/',url()->current()))?"<td>追加/削除</td>":""!!}
                </tr>
              </tbody>
              <tbody class="others_main">
                @foreach ($reservation->bills->sortBy("id")->first()->breakdowns->where('unit_type',5) as
                $o_key=>$other_break)
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
              </tbody>

            </table>
          </div>
          <div class="bill_total">
            <table class="table text-right">
              <tr>
                <td>小計：</td>
                <td>
                  {{ Form::text('master_subtotal', $reservation->bills->sortBy("id")->first()->master_subtotal,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td>消費税：</td>
                <td>
                  {{ Form::text('master_tax', $reservation->bills->sortBy("id")->first()->master_tax,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td class="font-weight-bold">合計金額</td>
                <td>
                  {{ Form::text('master_total', $reservation->bills->sortBy("id")->first()->master_total,['class'=>'form-control', 'readonly'] ) }}
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
                <td>請求日
                  {{ Form::text('bill_created_at', $reservation->bills->sortBy("id")->first()->bill_created_at,['class'=>'form-control', 'id'=>'datepicker6'] ) }}
                </td>
                <td>支払期日
                  {{ Form::text('pay_limit', ReservationHelper::formatDate($reservation->bills->sortBy("id")->first()->pay_limit),['class'=>'form-control', 'id'=>'datepicker6'] ) }}
                </td>
              </tr>
              <tr>
                <td>請求書宛名
                  {{ Form::text('pay_company', $reservation->agent->company,['class'=>'form-control'] ) }}
                </td>
                <td>
                  担当者
                  {{ Form::text('bill_person', $reservation->agent->bill_person,['class'=>'form-control'] ) }}
                </td>
              </tr>
              <tr>
                <td colspan="2">請求書備考
                  {{ Form::textarea('bill_remark', $reservation->agent->bill_remark,['class'=>'form-control'] ) }}
                </td>
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
                    <option value="0" {{$reservation->bills->sortBy("id")->first()->paid==0?'selected':''}}>未入金</option>
                    <option value="1" {{$reservation->bills->sortBy("id")->first()->paid==1?'selected':''}}>入金済み
                    </option>
                  </select> </td>
                <td>
                  入金日
                  {{ Form::text('pay_day', $reservation->bills->sortBy("id")->first()->pay_day,['class'=>'form-control', 'id'=>'datepicker7'] ) }}
                </td>
              </tr>
              <tr>
                <td>
                  振込人名
                  {{ Form::text('pay_person', $reservation->bills->sortBy("id")->first()->pay_person,['class'=>'form-control'] ) }}
                  <p class="is-error-pay_person" style="color: red"></p>
                </td>
                <td>入金額
                  {{ Form::text('payment', $reservation->bills->sortBy("id")->first()->payment,['class'=>'form-control'] ) }}
                  <p class="is-error-payment" style="color: red"></p>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>



  <script>
    $(function() {
    $(document).on("click", "input:radio[name='eat_in']", function() {
      var radioTarget = $('input:radio[name="eat_in"]:checked').val();
      if (radioTarget == 1) {
        $('input:radio[name="eat_in_prepare"]').prop('disabled', false);
        $('input:radio[name="eat_in_prepare"]:first-child').prop('checked', true);
      } else {
        $('input:radio[name="eat_in_prepare"]').prop('disabled', true);
        $('input:radio[name="eat_in_prepare"]').val("");
      }
    })
  })
  </script>

  <script>
    $(function(){
      $(".bill").hide();
      $(".information").hide();
      $(".paid").hide();
    })
  </script>
  @endsection