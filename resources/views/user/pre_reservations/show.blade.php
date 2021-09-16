@extends('layouts.user.app')
@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/lettercounter.js') }}"></script>
<script src="{{ asset('/js/user/validation.js') }}"></script>

<div class="container-field mt-3 d-md-flex justify-content-md-between">
  <h2 class="mt-3 mb-md-5">仮押え 申込み</h2>
  <div class="">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">
          {{ Breadcrumbs::render(Route::currentRouteName(),$pre_reservation->id) }}
        </li>
      </ol>
    </nav>
  </div>
</div>
<hr>


@if ($pre_reservation->status==1)
<div class="confirm-box text-md-center mt-5">
  <p>
    下記日程で会場を仮押えしています。<br>
    予約に関する詳細情報を入力し、<span class="f-wb f-s15">下部の「金額を確認する」ボタンをクリック</span>してお申込み手続きを進めて下さい。<br>
    なお、取消しの際はSMGまでご連絡下さい。
  </p>
</div>
@endif

<section class="mt-5">
  <table class="table ttl_head mb-0">
    <tbody>
      <tr>
        <td>
          <h3 class="text-white p-2">
            仮押え内容
          </h3>
        </td>
      </tr>
    </tbody>
  </table>
  {{ Form::open(['url' => 'user/pre_reservations/'.$pre_reservation->id.'/calculate', 'method'=>'POST', 'id'=>'mypageForm']) }}
  @csrf
  <div class="border-wrap2 p-4">
    <div class="row">
      <div class="col-md-6 col-12">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td colspan="2">
                <p class="title-icon">
                  <i class="fas fa-info-circle icon-size" aria-hidden="true"></i>
                  仮押え情報
                  <span class="ml-3">仮押えID：{{ReservationHelper::fixId($pre_reservation->id)}}</span>
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
                {{ReservationHelper::getVenueForUser($venue->id)}}
                <div>料金体系：{{$pre_reservation->price_system==1?"通常（枠貸）":"アクセア（時間貸）"}}</div>
              </td>
            </tr>
            <tr>
              <td class="table-active">入室時間</td>
              <td>
                {{ReservationHelper::formatTime($pre_reservation->enter_time)}}
              </td>
            </tr>
            <tr>
              <td class="table-active">退室時間</td>
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
                    {{Form::radio('board_flag',1,$pre_reservation->board_flag==1?true:false,['class'=>'','id'=>'board_flag'])}}
                    {{Form::label('board_flag','あり')}}
                  </p>
                  <p>
                    {{Form::radio('board_flag',0,$pre_reservation->board_flag==0?true:false,['class'=>'','id'=>'no_board_flag'])}}
                    {{Form::label('no_board_flag','なし')}}
                  </p>
                </div>
              </td>
            </tr>
            <tr>
              <td class="table-active">イベント開始時間</td>
              <td>
                <select name="event_start" id="event_start" class="form-control">
                  <option disabled>選択してください</option>
                  {!!ReservationHelper::timeOptionsWithRequestAndLimit($pre_reservation->event_start,$pre_reservation->enter_time,$pre_reservation->leave_time)!!}
                </select>
              </td>
            </tr>
            <tr>
              <td class="table-active">イベント終了時間</td>
              <td>
                <select name="event_finish" id="event_finish" class="form-control">
                  <option disabled>選択してください</option>
                  {!!ReservationHelper::timeOptionsWithRequestAndLimit($pre_reservation->event_finish,$pre_reservation->enter_time,$pre_reservation->leave_time)!!}
                </select>
              </td>
            </tr>
            <tr>
              <td class="table-active">イベント名称1</td>
              <td>
                <div class="align-items-end d-flex">
                  {{Form::text('event_name1',$pre_reservation->event_name1,['class'=>'form-control', 'id'=>'eventname1Count'])}}
                  <span class="ml-1 annotation count_num1"></span>
                </div>
                <p class="is-error-event_name1" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active">イベント名称2</td>
              <td>
                <div class="align-items-end d-flex">
                  {{Form::text('event_name2',$pre_reservation->event_name2,['class'=>'form-control', 'id'=>'eventname2Count'])}}
                  <span class="ml-1 annotation count_num2"></span>
                </div>
                <p class="is-error-event_name2" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active">主催者名</td>
              <td>
                <div class="align-items-end d-flex">
                  {{Form::text('event_owner',$pre_reservation->event_owner,['class'=>'form-control', 'id'=>'eventownerCount'])}}
                  <span class="ml-1 annotation count_num3"></span>
                </div>
                <p class="is-error-event_owner" style="color: red"></p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="col-md-6 col-12">
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
            <tbody class="accordion-wrap">
              @foreach ($venue->getEquipments() as $key=>$equ)
              <tr>
                <td class="table-active">
                  {{$equ->item}}
                </td>
                <td>
                  @foreach ($pre_reservation->pre_breakdowns()->get() as $s_equ)
                  @if ($s_equ->unit_item==$equ->item)
                  {{Form::number('equipment_breakdown[]',$s_equ->unit_count,['class'=>'form-control equipment_validation', 'autocomplete="off"'])}}
                  @break
                  @elseif($loop->last)
                  {{Form::number('equipment_breakdown[]','',['class'=>'form-control equipment_validation', 'autocomplete="off"'])}}
                  @endif
                  @endforeach
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
            <tbody class="accordion-wrap">
              @foreach ($venue->getServices() as $key=>$ser)
              <tr>
                <td class="table-active">
                  {{$ser->item}}
                </td>
                <td>
                  @foreach ($pre_reservation->pre_breakdowns()->get() as $s_ser)
                  @if ($s_ser->unit_item==$ser->item)
                  <div class="radio-box">
                    <p>
                      {{Form::radio("services_breakdown[$key]", 1, true , ['id' => 'service'.$key.'on', 'class' => ''])}}
                      {{Form::label('service'.$key.'on','あり')}}
                    </p>
                    <p>
                      {{Form::radio("services_breakdown[$key]", 0, false, ['id' => 'services_breakdown'.$key.'off', 'class' => ''])}}
                      {{Form::label('services_breakdown'.$key.'off','なし')}}
                    </p>
                  </div>
                  @break
                  @elseif($loop->last)
                  <div class="radio-box">
                    <p>
                      {{Form::radio("services_breakdown[$key]", 1, false , ['id' => 'service'.$key.'on', 'class' => ''])}}
                      {{Form::label('service'.$key.'on','あり')}}
                    </p>
                    <p>
                      {{Form::radio("services_breakdown[$key]", 0, true, ['id' => 'services_breakdown'.$key.'off', 'class' => ''])}}
                      {{Form::label('services_breakdown'.$key.'off','なし')}}
                    </p>
                  </div>
                  @endif
                  @endforeach
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
                  @foreach ($pre_reservation->pre_breakdowns()->get() as $s_lay)
                  @if ($s_lay->unit_item=='レイアウト準備料金')
                  <div class="radio-box">
                    <p>
                      {{Form::radio('layout_prepare', 1, true , ['id' => 'layout_prepare', 'class' => ''])}}
                      {{Form::label('layout_prepare','あり')}}
                    </p>
                    <p>
                      {{Form::radio('layout_prepare', 0, false, ['id' => 'no_layout_prepare', 'class' => ''])}}
                      {{Form::label('no_layout_prepare','なし')}}
                    </p>
                  </div>
                  @break
                  @elseif($loop->last)
                  <div class="radio-box">
                    <p>
                      {{Form::radio('layout_prepare', 1, false , ['id' => 'layout_prepare', 'class' => ''])}}
                      {{Form::label('layout_prepare','あり')}}
                    </p>
                    <p>
                      {{Form::radio('layout_prepare', 0, true, ['id' => 'no_layout_prepare', 'class' => ''])}}
                      {{Form::label('no_layout_prepare','なし')}}
                    </p>
                  </div>
                  @endif
                  @endforeach
                </td>
              </tr>
              <tr>
                <td class="table-active">レイアウト片付</td>
                <td>
                  @foreach ($pre_reservation->pre_breakdowns()->get() as $s_lay)
                  @if ($s_lay->unit_item=='レイアウト片付料金')
                  <div class="radio-box">
                    <p>
                      {{Form::radio('layout_clean', 1, true , ['id' => 'layout_clean', 'class' => ''])}}
                      {{Form::label('layout_clean','あり')}}
                    </p>
                    <p>
                      {{Form::radio('layout_clean', 0, false, ['id' => 'no_layout_clean', 'class' => ''])}}
                      {{Form::label('no_layout_clean','なし')}}
                    </p>
                  </div>
                  @break
                  @elseif($loop->last)
                  <div class="radio-box">
                    <p>
                      {{Form::radio('layout_clean', 1, false , ['id' => 'layout_clean', 'class' => ''])}}
                      {{Form::label('layout_clean','あり')}}
                    </p>
                    <p>
                      {{Form::radio('layout_clean', 0, true, ['id' => 'no_layout_clean', 'class' => ''])}}
                      {{Form::label('no_layout_clean','なし')}}
                    </p>
                  </div>
                  @endif
                  @endforeach
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
                    <i class="fas fa-suitcase-rolling icon-size" aria-hidden="true"></i>お荷物預り
                  </p>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="table-active">お荷物預り 工藤さん！！こちら</td>
                <td>
                  <div class="radio-box">
                    <p>
                      <input id="luggage_flag" name="luggage_flag" type="radio" value="1">
                      <label for="" class="form-check-label">あり</label>
                    </p>
                    <p>
                      <input id="no_luggage_flag" name="luggage_flag" type="radio" value="0">
                      <label for="" class="form-check-label">なし</label>
                    </p>
                  </div>
                  <p class="is-error-luggage_flag" style="color: red"></p>
                </td>
              </tr>
              <tr>
                <td class="table-active">事前にお預りする荷物</td>
                <td>
                  {{Form::number('luggage_count',$pre_reservation->luggage_count,['class'=>'form-control','id' => 'luggage_count', 'autocomplete="off"'])}}
                  <p class="is-error-luggage_count" style="color: red"></p>
                </td>
              </tr>
              <tr>
                <td class="table-active">事前荷物の到着日<br>午前指定のみ</td>
                <td>
                  {{Form::text('luggage_arrive',date('Y-m-d',strtotime($pre_reservation->luggage_arrive)),['class'=>'form-control luggage_arrive','id'=>'datepicker9'])}}
                </td>
              </tr>
              <tr>
                <td class="table-active">事後返送するお荷物</td>
                <td>
                  {{Form::number('luggage_return',$pre_reservation->luggage_return,['class'=>'form-control luggage_return','id' => 'luggage_return', 'autocomplete="off"'])}}
                  <p class="is-error-luggage_return" style="color: red"></p>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

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
                  <input id="eat_in" name="eat_in" type="radio" value="1">
                  <label for="eat_in">あり</label>
                </td>
                <td>
                  <input id="eat_in_prepare" disabled name="eat_in_prepare" type="radio" value="1">
                  <label for="eat_in_prepare">手配済み</label>
                  <input id="eat_in_consider" disabled name="eat_in_prepare" type="radio" value="2">
                  <label for="eat_in_consider">検討中</label>
                </td>
              </tr>
              <tr>
                <td>
                  <input id="no_eat_in" checked="checked" name="eat_in" type="radio" value="0">
                  <label for="no_eat_in">なし</label>
                </td>
                <td></td>
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
                {{Form::textarea('user_details',$pre_reservation->user_details,['class'=>'form-control'])}}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="btn_wrapper">
    {{ Form::submit('金額を確認する', ['class' => 'btn more_btn_lg mx-auto d-block my-5']) }}
  </div>
  {{ Form::close() }}


  {{-- <div class="bill mt-5">
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
                  <dd class="total_result">39,600円</dd>
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
                <tr>
                  <td>
                    <input class="form-control col-xs-3" readonly="" name="venue_breakdown_item0" type="text"
                      value="会場料金">
                  </td>
                  <td>
                    <input class="form-control col-xs-3" readonly="" name="venue_breakdown_cost0" type="text"
                      value="36000">
                  </td>
                  <td>
                    <input class="form-control col-xs-3" readonly="" name="venue_breakdown_count0" type="text"
                      value="3.5">
                  </td>
                  <td>
                    <input class="form-control col-xs-3" readonly="" name="venue_breakdown_subtotal0" type="text"
                      value="36000">
                  </td>
                </tr>
              </tbody>
              <tbody class="venue_result">
                <tr>
                  <td colspan="3"></td>
                  <td colspan="1">合計
                    <input class="form-control col-xs-3" readonly="" name="venue_price" type="text" value="36000">
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
                <tr>
                  <td>
                    <input class="form-control" readonly="" name="equipment_breakdown_item0" type="text" value="有線マイク">
                  </td>
                  <td>
                    <input class="form-control" readonly="" name="equipment_breakdown_cost0" type="text" value="3000">
                  </td>
                  <td>
                    <input class="form-control" readonly="" name="equipment_breakdown_count0" type="text" value="1">
                  </td>
                  <td>
                    <input class="form-control" readonly="" name="equipment_breakdown_subtotal0" type="text"
                      value="3000">
                  </td>
                </tr>
                <tr>
                  <td colspan="3"></td>
                  <td colspan="1">合計
                    <input class="form-control" readonly="" name="equipment_price" type="text" value="0">
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
                <tr>
                  <td><input class="form-control" readonly="" name="layout_prepare_item" type="text" value="レイアウト準備料金">
                  </td>
                  <td><input class="form-control" readonly="" name="layout_prepare_cost" type="text" value="5000">
                  </td>
                  <td><input class="form-control" readonly="" name="layout_prepare_count" type="text" value="1"></td>
                  <td>
                    <input class="form-control" readonly="" name="layout_prepare_subtotal" type="text" value="5000">
                  </td>
                </tr>
                <tr>
                  <td colspan="3"></td>
                  <td colspan="1">合計
                    <input class="form-control" readonly="" name="layout_price" type="text" value="0">
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
                    <input class="form-control text-right" readonly="" name="master_subtotal" type="text" value="36000">
                  </td>
                </tr>
                <tr>
                  <td>消費税：</td>
                  <td>
                    <input class="form-control text-right" readonly="" name="master_tax" type="text" value="3600">
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold">合計金額</td>
                  <td>
                    <input class="form-control text-right" readonly="" name="master_total" type="text" value="39600">
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div> --}}

</section>

{{-- <div class="confirm-box">
    <div class="confirm_inner">
      <p class="mb-4">上記、内容で予約を申し込んでもよろしいでしょうか。よろしければ、予約の申し込みをお願いします。</p>
      <p class="text-center mb-5 mt-3"><a href="" class="more_btn4_lg">予約を申し込む</a></p>
      <p>※ご要望に相違がある場合は、下記連絡先までご連絡ください。<br>
        TEL：06-1234-5678<br>
        mail：test@gmail.com
      </p>
    </div>
  </div> --}}



<script>
  $(function() {
    var maxTarget = $('input[name="reserve_date"]').val();
    $('#datepicker9').datepicker({
      dateFormat: 'yy-mm-dd',
      minDate: 0,
      maxDate: maxTarget,
      autoclose: true,
    });
  })

    // ロード時の、案内板入力制御
    $(document).ready(function() {
    $("#no_board_flag:checked").each(function() {
      var flag = $(this);
      if ($(flag).is(":checked") != null) {
        $("#event_start").prop("disabled", true);
        $("#event_finish").prop("disabled", true);
        $("#eventname1Count").prop("disabled", true);
        $("#eventname2Count").prop("disabled", true);
        $("#eventownerCount").prop("disabled", true);
        // $(".board-table input[type='text']").val("");
        $(".board-table option:selected").val("");
      }
    });
  });

  // ラジオボタンクリック時の案内板入力制御
  $(function() {
    $('input[name="board_flag"]').change(function() {
      var prop = $("#no_board_flag").prop("checked");
      if (prop) {
        $("#event_start").prop("disabled", true);
        $("#event_finish").prop("disabled", true);
        $("#eventname1Count").prop("disabled", true);
        $("#eventname2Count").prop("disabled", true);
        $("#eventownerCount").prop("disabled", true);
        // $(".board-table input[type='text']").val("");
      } else {
        $("#event_start").prop("disabled", false);
        $("#event_finish").prop("disabled", false);
        $("#eventname1Count").prop("disabled", false);
        $("#eventname2Count").prop("disabled", false);
        $("#eventownerCount").prop("disabled", false);
      }
    });
  });

      // 荷物預かりのラジオボタン選択の表示、非表示
      $(function() {
    var no_luggage_flag = $('#no_luggage_flag').val();
    if (no_luggage_flag == 0) {
          $(".luggage_info").addClass("d-none");
        } else {
          $(".luggage_info").removeClass("d-none");
         }
    });

    $(function() {
     $("input[name='luggage_flag']").change(function() {
       var no_luggage_flag = $('#no_luggage_flag').prop('checked');
        if (no_luggage_flag) {
          $(".luggage_info").addClass("d-none");
        } else {
          $(".luggage_info").removeClass("d-none");
         }
      });
    });
</script>
@endsection