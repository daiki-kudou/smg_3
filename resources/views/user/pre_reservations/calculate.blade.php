@extends('layouts.user.app')
@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>


<div class="container-fluid">
  <div class="container-field mt-3">
    <div class="float-right">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">
            ダミーダミーダミーダミー
          </li>
        </ol>
      </nav>
    </div>
    <h2 class="mt-3 mb-5">仮押え 申込み</h2>
    <hr>
  </div>

  @if ($pre_reservation->status==1)
  <div class="confirm-box text-center mt-5">
    <p>下記の日程にて、会場を仮押えしています。
      本予約に申し込む場合は、詳細を入力してお申込みください。</p>
  </div>
  @endif

  <section class="section-wrap">
    <table class="table ttl_head mb-0">
      <tbody>
        <tr>
          <td>
            <h3 class="text-white p-2">
              仮押えお申込み内容
            </h3>
          </td>
        </tr>
      </tbody>
    </table>
    {{ Form::open(['url' => 'user/pre_reservations/'.$pre_reservation->id.'/calculate', 'method'=>'POST', 'id'=>'']) }}
    @csrf
    <div class="border-wrap2 p-5">
      <div class="row">
        <div class="col">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <td colspan="2">
                  <p class="title-icon">
                    <i class="fas fa-info-circle icon-size" aria-hidden="true"></i>
                    仮押え情報
                    <span class="ml-3">仮押えID：{{$pre_reservation->id}}</span>
                  </p>
                </td>
              </tr>
              <tr>
                <td class="table-active">利用日</td>
                <td>
                  {{ReservationHelper::formatDate($pre_reservation->reserve_date)}}
                  {{Form::hidden('reserve_date',$pre_reservation->reserve_date)}}
                </td>
              </tr>
              <tr>
                <td class="table-active">会場</td>
                <td>
                  {{ReservationHelper::getVenue($venue->id)}}
                  <div>料金体系：{{$pre_reservation->price_system==1?"通常（枠貸）":"アクセア（時間貸）"}}</div>
                </td>
              </tr>
              <tr>
                <td class="table-active form_required">入室時間</td>
                <td>
                  {{ReservationHelper::formatTime($pre_reservation->enter_time)}}
                </td>
              </tr>
              <tr>
                <td class="table-active form_required">退室時間</td>
                <td>
                  {{ReservationHelper::formatTime($pre_reservation->leave_time)}}
                </td>
              </tr>
            </tbody>
          </table>
          <table class="table table-bordered">
            <tbody>
              <tr>
                <td colspan="2">
                  <p class="title-icon">
                    <i class="fas fa-user-check icon-size" aria-hidden="true"></i>
                    当日連絡のできるご担当者様
                  </p>
                </td>
              </tr>
              <tr>
                <td class="table-active">
                  <label for="ondayName" class=" form_required">氏名</label>
                </td>
                <td>
                  {{Form::text('in_charge',$pre_reservation->in_charge,['class'=>'form-control'])}}
                  <p class="is-error-in_charge" style="color: red"></p>
                </td>
              </tr>
              <tr>
                <td class="table-active"><label for="mobilePhone" class=" form_required">携帯番号</label></td>
                <td>
                  {{Form::text('tel',$pre_reservation->tel,['class'=>'form-control'])}}
                  <p class="is-error-tel" style="color: red"></p>
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
                      {{Form::radio('board_flag',0,true,['class'=>'','id'=>'board_flag'])}}
                      {{Form::label('board_flag','なし')}}
                    </p>
                    <p>
                      {{Form::radio('board_flag',1,false,['class'=>'','id'=>'no_board_flag'])}}
                      {{Form::label('no_board_flag','あり')}}
                    </p>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="table-active">イベント開始時間</td>
                <td>
                  <select name="event_start" id="event_start" class="form-control">
                    <option disabled>選択してください</option>
                    @for ($start = 0*2; $start <=23*2; $start++) <option
                      value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (date("H:i:s",
                      strtotime("00:00 +". $start * 30 ." minute"))<$pre_reservation->enter_time)
                      disabled
                      @elseif(date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))>$pre_reservation->leave_time)
                      disabled
                      @endif
                      >
                      {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}</option>
                      @endfor
                  </select>
                </td>
              </tr>
              <tr>
                <td class="table-active">イベント終了時間</td>
                <td>
                  <select name="event_finish" id="event_finish" class="form-control">
                    <option disabled>選択してください</option>
                    @for ($start = 0*2; $start <=23*2; $start++) <option
                      value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (date("H:i:s",
                      strtotime("00:00 +". $start * 30 ." minute"))>$pre_reservation->leave_time)
                      disabled
                      @elseif(date("H:i:s",strtotime("00:00 +". $start * 30 ." minute"))<$pre_reservation->enter_time)
                        disabled
                        @endif
                        >
                        {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}</option>
                        @endfor
                  </select>
                </td>
              </tr>
              <tr>
                <td class="table-active">イベント名称1</td>
                <td>
                  {{Form::text('event_name1',$pre_reservation->event_name1,['class'=>'form-control'])}}
                </td>
              </tr>
              <tr>
                <td class="table-active">イベント名称2</td>
                <td>
                  {{Form::text('event_name2',$pre_reservation->event_name2,['class'=>'form-control'])}}
                </td>
              </tr>
              <tr>
                <td class="table-active">主催者名</td>
                <td>
                  {{Form::text('event_owner',$pre_reservation->event_owner,['class'=>'form-control'])}}
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="col">
          <div class="equipemnts">
            <table class="table table-bordered" style="table-layout: fixed;">
              <thead class="accordion-ttl">
                <tr>
                  <th colspan="2">
                    <p class="title-icon fw-bolder py-1">
                      <i class="fas fa-wrench icon-size" aria-hidden="true"></i>有料備品
                    </p>
                  </th>
                </tr>
              </thead>
              <tbody class="accordion-wrap" style="display: none;">
                @foreach ($venue->getEquipments() as $key=>$equ)
                <tr>
                  <td class="table-active">
                    {{$equ->item}}
                  </td>
                  <td>
                    {{Form::text('equipment_breakdown'.$key,$request->{'equipment_breakdown'.$key},['class'=>'form-control'])}}
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
                      <i class="fas fa-hand-holding-heart icon-size" aria-hidden="true"></i>有料サービス
                    </p>
                  </th>
                </tr>
              </thead>
              <tbody class="accordion-wrap" style="display: none;">
                @foreach ($venue->getServices() as $key=>$ser)
                <tr>
                  <td class="table-active">
                    {{$ser->item}}
                  </td>
                  <td>
                    <div class="form-check form-check-inline">
                      {{Form::radio('services_breakdown'.$key, 1, $request->{'services_breakdown'.$key}==1?true:false , ['id' => 'service'.$key.'on', 'class' => 'form-check-input'])}}
                      {{Form::label('service'.$key.'on','あり')}}
                      {{Form::radio('services_breakdown'.$key, 0, $request->{'services_breakdown'.$key}==0?true:false, ['id' => 'services_breakdown'.$key.'off', 'class' => 'form-check-input'])}}
                      {{Form::label('services_breakdown'.$key.'off','なし')}}
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
                    <p class="title-icon py-1">
                      <i class="fas fa-th icon-size" aria-hidden="true"></i>レイアウト
                    </p>
                  </th>
                </tr>
              </thead>
              <tbody>
                @if ($pre_reservation->venue->layout==1)
                <tr>
                  <td class="table-active">レイアウト準備</td>
                  <td>
                    <div class="form-check form-check-inline">
                      {{Form::radio('layout_prepare', 1, $request->layout_prepare==1?true:false , ['id' => 'layout_prepare', 'class' => 'form-check-input'])}}
                      {{Form::label('layout_prepare','あり')}}
                      {{Form::radio('layout_prepare', 0, $request->layout_prepare==0?true:false, ['id' => 'no_layout_prepare', 'class' => 'form-check-input'])}}
                      {{Form::label('no_layout_prepare','なし')}}
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="table-active">レイアウト片付</td>
                  <td>
                    <div class="form-check form-check-inline">
                      {{Form::radio('layout_clean', 1, $request->layout_clean==1?true:false , ['id' => 'layout_clean', 'class' => 'form-check-input'])}}
                      {{Form::label('layout_clean','あり')}}
                      {{Form::radio('layout_clean', 0, $request->layout_clean==0?true:false, ['id' => 'no_layout_clean', 'class' => 'form-check-input'])}}
                      {{Form::label('no_layout_clean','なし')}}
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
                  <th colspan="2">
                    <p class="title-icon">
                      <i class="fas fa-suitcase-rolling icon-size" aria-hidden="true"></i>お荷物預かり
                    </p>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="table-active">事前にお預かりする荷物</td>
                  <td>
                    {{Form::text('luggage_count',$request->luggage_count,['class'=>'form-control'])}}
                  </td>
                </tr>
                <tr>
                  <td class="table-active">事前荷物の到着日<br>午前指定のみ</td>
                  <td>
                    {{Form::text('luggage_arrive',date('Y-m-d',strtotime($request->luggage_arrive)),['class'=>'form-control','id'=>'datepicker9'])}}
                  </td>
                </tr>
                <tr>
                  <td class="table-active">事後返送するお荷物</td>
                  <td>
                    {{Form::text('luggage_return',$request->luggage_return,['class'=>'form-control'])}}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>


          <table class="table table-bordered note-table">
            <tbody>
              <tr>
                <td colspan="2">
                  <p class="title-icon">
                    <i class="fas fa-file-alt icon-size" aria-hidden="true"></i>備考
                  </p>
                </td>
              </tr>
              <tr>
                <td>
                  <label for="userNote">備考</label>
                  {{Form::textarea('user_details',$request->user_details,['class'=>'form-control'])}}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="btn_wrapper">
      {{ Form::submit('再計算する', ['class' => 'btn more_btn_lg mx-auto d-block my-5']) }}
    </div>
    {{ Form::close() }}

    {{ Form::open(['url' => 'user/pre_reservations/'.$id.'/cfm', 'method'=>'POST']) }}
    @csrf
    <div class="bill mt-5">
      <div class="bill_head">
        <table class="table" style="table-layout: fixed">
          <tbody>
            <tr>
              <td>
                <h2 class="text-white">
                  ご利用料金
                </h2>
              </td>
              <td>
                <dl class="ttl_box">
                  <dt>合計金額</dt>
                  <dd class="total_result">{{number_format(ReservationHelper::taxAndPrice($master))}}円</dd>
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
              内訳
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
                @foreach ($pre_reservation->pre_breakdowns()->where('unit_type',1)->get() as $key=>$price_details)
                <tr>
                  <td>
                    {{ Form::text('venue_breakdown_item'.$key, $price_details->unit_item,['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('venue_breakdown_cost'.$key, $price_details->unit_cost,['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('venue_breakdown_count'.$key, $price_details->unit_count,['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('venue_breakdown_subtotal'.$key, $price_details->unit_subtotal,['class'=>'form-control', 'readonly'] ) }}
                  </td>
                </tr>
                @endforeach
              </tbody>
              <tbody class="venue_result">
                <tr>
                  <td colspan="2"></td>
                  <td colspan="2">合計
                    {{ Form::text('venue_price', $venue_price,['class'=>'form-control col-xs-3', 'readonly'] ) }}
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
                  <td>単価</td>
                  <td>数量</td>
                  <td>金額</td>
                </tr>
              </tbody>
              <tbody class="equipment_main">
              </tbody>
              <tbody class="equipment_result">
                @foreach ($item_details[1] as $key=>$item)
                <tr>
                  <td>
                    {{ Form::text('equipment_breakdown_item'.$key, $item[0],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('equipment_breakdown_cost'.$key, $item[1],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('equipment_breakdown_count'.$key, $item[2],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('equipment_breakdown_subtotal'.$key, $item[1]*$item[2],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                </tr>
                @endforeach
                @foreach ($item_details[2] as $key=>$item)
                <tr>
                  <td>
                    {{ Form::text('services_breakdown_item'.$key, $item[0],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('services_breakdown_cost'.$key, $item[1],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('services_breakdown_count'.$key, $item[2],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('services_breakdown_subtotal'.$key, $item[1]*$item[2],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                </tr>
                @endforeach
                @if (!empty($luggage_price))
                <tr>
                  <td>
                    {{ Form::text('luggage_item', '荷物預かり/返送',['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('luggage_cost', $luggage_price->unit_cost,['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('luggage_count', $luggage_price->unit_count,['class'=>'form-control', 'readonly'] ) }}
                  </td>
                  <td>
                    {{ Form::text('luggage_subtotal', $luggage_price->unit_subtotal,['class'=>'form-control', 'readonly'] ) }}
                  </td>
                </tr>
                @endif
              </tbody>
              <tbody class="equipment_result">
                <tr>
                  <td colspan="2"></td>
                  <td colspan="2">合計
                    {{ Form::text('equipment_price', ($item_details[0]),['class'=>'form-control', 'readonly'])}}
                  </td>
                </tr>
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
              </tbody>
              <tbody class="layout_result">
                @if ($request->layout_prepare==1)
                <tr>
                  <td>{{ Form::text('layout_prepare_item', "レイアウト準備料金",['class'=>'form-control', 'readonly'] ) }}</td>
                  <td>
                    {{ Form::text('layout_prepare_cost', $venue->layout_prepare,['class'=>'form-control', 'readonly'] )}}
                  </td>
                  <td>{{ Form::text('layout_prepare_count', 1,['class'=>'form-control', 'readonly'] )}}</td>
                  <td>
                    {{ Form::text('layout_prepare_subtotal', $venue->layout_prepare,['class'=>'form-control', 'readonly'] )}}
                  </td>
                </tr>
                @endif
                @if ($request->layout_clean==1)
                <tr>
                  <td>{{ Form::text('layout_clean_item', "レイアウト片付料金",['class'=>'form-control', 'readonly'] ) }}</td>
                  <td>
                    {{ Form::text('layout_clean_cost', $venue->layout_clean,['class'=>'form-control', 'readonly'] )}}
                  </td>
                  <td>{{ Form::text('layout_clean_count', 1,['class'=>'form-control', 'readonly'] )}}</td>
                  <td>
                    {{ Form::text('layout_clean_subtotal', $venue->layout_clean,['class'=>'form-control', 'readonly'] )}}
                  </td>
                </tr>
                @endif
                <tr>
                  <td colspan="3"></td>
                  <td colspan="1">合計
                    {{ Form::text('layout_price', $layout_details,['class'=>'form-control', 'readonly'] )}}
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
                    {{ Form::text('master_subtotal', $master,['class'=>'form-control', 'readonly'] )}}
                  </td>
                </tr>
                <tr>
                  <td>消費税：</td>
                  <td>
                    {{ Form::text('master_tax', ReservationHelper::getTax($master),['class'=>'form-control', 'readonly'] )}}
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold">合計金額</td>
                  <td>
                    {{ Form::text('master_total', ReservationHelper::taxAndPrice($master),['class'=>'form-control', 'readonly'] )}}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="confirm-box">
    <div class="confirm_inner">
      <p class="mb-4">上記、内容で予約を申し込んでもよろしいでしょうか。よろしければ、予約の申し込みをお願いします。</p>
      <p class="text-center mb-5 mt-3">
        {{ Form::submit('予約を申し込む', ['class' => 'btn more_btn4_lg confirm']) }}
        {{ Form::close() }}
      </p>
      <p>※ご要望に相違がある場合は、下記連絡先までご連絡ください。<br>
        TEL：06-1234-5678<br>
        mail：test@gmail.com
      </p>
    </div>
  </div>
</div>


<script>
  $(function(){
    var maxTarget=$('input[name="reserve_date"]').val();
    $('#datepicker9').datepicker({
      dateFormat: 'yy-mm-dd',
      minDate: 0,
      maxDate:maxTarget,
      autoclose: true,
    });
  })

  $(function(){
    $('.confirm').on('click',function(){
      if (!confirm('予約を申し込みますか？')) {
      return false;
    }
    })
  })
</script>
@endsection