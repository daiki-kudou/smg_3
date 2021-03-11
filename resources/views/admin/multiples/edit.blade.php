@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
<!-- <script src="{{ asset('/js/multiples/script.js') }}"></script> -->
<script src="{{ asset('/js/multiples/calculate.js') }}"></script>



<div class="content">
  <div class="container-fluid">

    <div class="container-field mt-3">
      <div class="float-right">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active">
              ダミーダミーダミー
            </li>
          </ol>
        </nav>
      </div>
      <h2 class="mt-3 mb-3">一括仮押さえ　編集</h2>
      <hr>
    </div>

    <div class="alert-box d-flex align-items-center">
      <span class="mr-3"><i class="fas alert-icon fa-exclamation-triangle" aria-hidden="true"></i></span>
      <p>
        変更がある場合は、必ず更新するボタンを押してください。<br>
        更新しないまま画面遷移をすると、データが反映されません。
      </p>
    </div>　

    <!-- 詳細選択画面--------------------------------------------------　 -->
    <p class="font-weight-bold">日程ごとに、詳細を編集できます。</p>
    <section class="border-wrap2 pb-5">
      <table class="table ttl_head">
        <tbody>
          <tr>
            <td class="text-white d-flex align-items-center">
              <h3>
                仮押さえ一括ID:<span class="mr-1">{{$multiple->id}}</span>
              </h3>
              <h4 class="ml-2">{{ReservationHelper::getVenue($venue->id)}}</h4>
            </td>
        </tbody>
      </table>



      {{ Form::open(['url' => 'admin/multiples/'.$multiple->id."/edit/".$venue->id.'/calculate', 'method'=>'POST', 'id'=>'']) }}
      @csrf
      <section class="m-5 border-inwrap">
        <div class="mb-2">
          <!-- <p>同じ内容をすべての日程に反映することができます。</p> -->
        </div>
        <dl class="card">
          <dt class="card-header accordion-ttl">
            <ul class="title-icon d-flex">
              <li>
                <p>すべての日程に反映したい場合はこちらから選択ください</p>
              </li>
              <!-- <li class="plus_icon">
              </li> -->
            </ul>
          </dt>
          <dt class="accordion-wrap p-3">
            <div class="row">
              <!-- 左側の項目------------------------------------------------------------------------ -->
              <div class="col">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td colspan="2">
                        <p class="title-icon">
                          <i class="fas fa-info-circle icon-size" aria-hidden="true"></i>
                          仮押さえ情報
                        </p>
                      </td>
                    </tr>
                    <tr>
                      <td class="table-active"><label for="direction">料金体系</label></td>
                      <td>
                        <div class="">
                          <p>
                            {{ Form::radio('cp_master_price_system', 1, true, ['id'=>'cp_master_price_system_radio1']) }}
                            {{Form::label('cp_master_price_system_radio1','通常（枠貸）')}}
                          </p>
                          <p>
                            {{ Form::radio('cp_master_price_system', 2, false, ['id'=>'cp_master_price_system_radio2']) }}
                            {{Form::label('cp_master_price_system_radio2','アクセア（時間貸）')}}
                          </p>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="table-active"><label for="direction">案内板</label></td>
                      <td>
                        <div class="radio-box">
                          <p>
                            {{ Form::radio('cp_master_board_flag', 1, false, ['id'=>'cp_master_board_flag1']) }}
                            {{Form::label('cp_master_board_flag1','あり')}}
                          </p>
                          <p>
                            {{ Form::radio('cp_master_board_flag', 0, true, ['id'=>'cp_master_board_flagboard_flag2']) }}
                            {{Form::label('cp_master_board_flagboard_flag2','なし')}}
                          </p>
                        </div>
                      </td>
                    </tr>
                    <!-- <tr>
                      <td class="table-active"><label for="eventTime">イベント時間記載</label></td>
                      <td>
                        <div class="radio-box">
                          <p>
                            {{ Form::radio('cp_master_event', 1, false, ['id'=>'cp_master_event1']) }}
                            {{Form::label('cp_master_event1','あり')}}
                          </p>
                          <p>
                            {{ Form::radio('cp_master_event', 0, true, ['id'=>'cp_master_event2']) }}
                            {{Form::label('cp_master_event2','なし')}}
                          </p>
                        </div>
                      </td>
                    </tr> -->
                    <tr>
                      <td class="table-active"><label for="eventStart">イベント開始時間</label></td>
                      <td>
                        <select name="cp_master_event_start" id="cp_master_event_start" class="form-control">
                          {!!ReservationHelper::timeOptions()!!}
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td class="table-active"><label for="eventFinish">イベント終了時間</label></td>
                      <td>
                        <select name="cp_master_event_finish" id="cp_master_event_finish" class="form-control">
                          {!!ReservationHelper::timeOptions()!!}
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td class="table-active"><label for="eventName1">イベント名称1</label></td>
                      <td>
                        {{ Form::text('cp_master_event_name1','',['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
                      </td>
                    </tr>
                    <tr>
                      <td class="table-active"><label for="eventName2">イベント名称2</label></td>
                      <td>
                        {{ Form::text('cp_master_event_name2', '',['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
                      </td>
                    </tr>
                    <tr>
                      <td class="table-active"><label for="organizer">主催者名</label></td>
                      <td>
                        {{ Form::text('cp_master_event_owner', '',['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
                      </td>
                    </tr>
                  </tbody>
                </table>
                <table class="table table-bordered equipment-table">
                  <thead class="accordion-ttl">
                    <tr>
                      <th colspan="2">
                        <p class="title-icon fw-bolder py-1">
                          <i class="fas fa-wrench icon-size fa-fw"></i>有料備品
                        </p>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="accordion-wrap">
                    @foreach ($venue->getEquipments() as $key=>$equipment)
                    <tr>
                      <td class="table-active">{{$equipment->item}}</td>
                      <td>
                        {{Form::text('cp_master_equipment_breakdown' . $key , '', ['class' => 'form-control'])}}
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>

                <table class="table table-bordered service-table">
                  <thead class="accordion-ttl">
                    <tr>
                      <th colspan="2">
                        <p class="title-icon fw-bolder py-1">
                          <i class="fas fa-hand-holding-heart icon-size fa-fw"></i>有料サービス
                        </p>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="accordion-wrap">
                    @foreach ($venue->getServices() as $key=>$service)
                    <tr>
                      <td class="table-active">{{$service->item}}</td>
                      <td>
                        <div class="form-check form-check-inline">
                          {{Form::radio('cp_master_services_breakdown'.$key, 1, false , ['id' => 'cp_master_service'.$key.'on', 'class' => 'form-check-input'])}}
                          {{Form::label('cp_master_service'.$key.'on','有り')}}
                          {{Form::radio('cp_master_services_breakdown'.$key, 0, true, ['id' => 'cp_master_service'.$key.'off', 'class' => 'form-check-input'])}}
                          {{Form::label('cp_master_service'.$key.'on','無し')}}
                        </div>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                <table class="table table-bordered layout-table">
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
                    @if ($venue->getLayouts()[0])
                    <tr>
                      <td class="table-active">準備</td>
                      <td>
                        <div class="form-check form-check-inline">
                          {{Form::radio('cp_master_layout_prepare', 1, false, ['id' => 'cp_master_layout_prepare', 'class' => 'form-check-input'])}}
                          {{Form::label('cp_master_layout_prepare','有り')}}
                          {{Form::radio('cp_master_layout_prepare', 0, true, ['id' => 'cp_master_no_layout_prepare', 'class' => 'form-check-input'])}}
                          {{Form::label('cp_master_no_layout_prepare','無し')}}
                        </div>
                      </td>
                    </tr>
                    @endif
                    @if ($venue->getLayouts()[1])
                    <tr>
                      <td class="table-active">片付</td>
                      <td>
                        <div class="form-check form-check-inline">
                          {{Form::radio('cp_master_layout_clean', 1, false, ['id' => 'cp_master_layout_clean', 'class' => 'form-check-input'])}}
                          {{Form::label('cp_master_layout_clean','有り')}}
                          {{Form::radio('cp_master_layout_clean', 0, true, ['id' => 'cp_master_no_layout_clean', 'class' => 'form-check-input'])}}
                          {{Form::label('cp_master_no_layout_clean','無し')}}
                        </div>
                      </td>
                    </tr>
                    @endif
                  </tbody>
                </table>

                <table class="table table-bordered luggage-table" style="table-layout: fixed;">
                  <thead>
                    <tr>
                      <th colspan='2'>
                        <p class="title-icon">
                          <i class="fas fa-suitcase-rolling icon-size fa-fw"></i>荷物預かり
                        </p>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    @if ($venue->getLuggage()===1)
                    <tr>
                      <td class="table-active">事前に預かる荷物<br>（個数）</td>
                      <td>
                        {{ Form::text('cp_master_luggage_count', '',['class'=>'form-control'] ) }}
                      </td>
                    </tr>
                    <tr>
                      <td class="table-active">事前荷物の到着日<br>午前指定のみ</td>
                      <td>
                        {{ Form::text('cp_master_luggage_arrive', '',['class'=>'form-control'] ) }}
                      </td>
                    </tr>
                    <tr>
                      <td class="table-active">事後返送する荷物</td>
                      <td>
                        {{ Form::text('cp_master_luggage_return', '',['class'=>'form-control'] ) }}
                      </td>
                    </tr>
                    <tr>
                      <td class="table-active">荷物預かり/返送<br>料金</td>
                      <td>
                        {{ Form::text('cp_master_luggage_price', '',['class'=>'form-control'] ) }}
                      </td>
                    </tr>
                    @endif
                  </tbody>
                </table>



                <table class="table table-bordered eating-table">
                  <thead>
                    <tr>
                      <th colspan='2'>
                        <p class="title-icon">
                          <i class="fas fa-suitcase-rolling icon-size fa-fw"></i>室内飲食
                        </p>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        {{Form::radio('cp_master_eat_in', 1, false , ['id' => 'eat_in'])}}
                        {{Form::label('eat_in',"あり")}}
                      </td>
                      <td>
                        {{Form::radio('cp_master_eat_in_prepare', 1, "" , ['id' => 'eat_in_prepare' ])}}
                        {{Form::label('eat_in_prepare',"手配済み")}}
                        {{Form::radio('cp_master_eat_in_prepare', 2, "" , ['id' => 'eat_in_consider'])}}
                        {{Form::label('eat_in_consider',"検討中")}}
                      </td>
                    </tr>
                    <tr>
                      <td>
                        {{Form::radio('cp_master_eat_in', 0, true , ['id' => 'no_eat_in'])}}
                        {{Form::label('no_eat_in',"なし")}}
                      </td>
                      <td></td>
                    </tr>
                </table>
              </div>
              <!-- 左側の項目 終わり-------------------------------------------------- -->


              <!-- 右側の項目-------------------------------------------------- -->
              <div class="col">
                <div class="customer-table">
                  <table class="table table-bordered oneday-table">
                    <tbody>
                      <tr>
                        <td colspan="2">
                          <p class="title-icon">
                            <i class="fas fa-user icon-size" aria-hidden="true"></i>
                            当日の連絡できる担当者
                          </p>
                        </td>
                      </tr>
                      <tr>
                        <td class="table-active"><label for="ondayName">氏名</label></td>
                        <td>
                          {{ Form::text('cp_master_in_charge', '',['class'=>'form-control'] ) }}
                        </td>
                      </tr>
                      <tr>
                        <td class="table-active"><label for="mobilePhone">携帯番号</label></td>
                        <td>
                          {{ Form::text('cp_master_tel', '',['class'=>'form-control'] ) }}
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <table class="table table-bordered mail-table">
                  <tbody>
                    <tr>
                      <td colspan="2">
                        <p class="title-icon">
                          <i class="fas fa-envelope icon-size" aria-hidden="true"></i>
                          利用後の送信メール
                        </p>
                      </td>
                    </tr>
                    <tr>
                      <td class="table-active"><label for="sendMail">送信メール</label></td>
                      <td>
                        <div class="d-flex">
                          <div class="form-check form-check-inline">
                            {{Form::radio('cp_master_email_flag', 1, false, ['id' => 'cp_master_email_flag', 'class' => 'form-check-input'])}}
                            {{Form::label('cp_master_email_flag','有り',['class'=>'mr-5'])}}
                            {{Form::radio('cp_master_email_flag', 0, true, ['id' => 'cp_master_no_email_flag', 'class' => 'form-check-input'])}}
                            {{Form::label('cp_master_no_email_flag','無し')}}
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>

                <table class="table table-bordered sale-table">
                  <tbody>
                    <tr>
                      <td colspan="2">
                        <p class="title-icon">
                          <i class="fas fa-yen-sign icon-size" aria-hidden="true"></i>
                          売上原価
                        </p>
                      </td>
                    </tr>
                    <tr>
                      <td class="table-active"><label for="sale">原価率</label></td>
                      <td class="d-flex align-items-center">
                        {{ Form::text('cp_master_cost', '',['class'=>'form-control'] ) }}%
                      </td>
                    </tr>
                  </tbody>
                </table>
                <table class="table table-bordered note-table">
                  <tbody>
                    <tr>
                      <td colspan="2">
                        <p class="title-icon">
                          <i class="fas fa-file-alt icon-size" aria-hidden="true"></i>
                          備考
                        </p>
                      </td>
                    </tr>
                    <!-- <tr>
                      <td>
                        <p>
                          <input type="checkbox" id="discount" checked="">
                          <label for="discount">割引条件</label>
                        </p>
                        {{ Form::textarea('cp_master_discount_condition', '',['class'=>'form-control'] ) }}
                      </td>
                    </tr>
                    <tr class="caution">
                      <td>
                        <label for="caution">注意事項</label>
                        {{ Form::textarea('cp_master_attention', '',['class'=>'form-control'] ) }}
                      </td>
                    </tr> -->
                    <tr>
                      <td>
                        <label for="adminNote">管理者備考</label>
                        {{ Form::textarea('cp_master_admin_details', '',['class'=>'form-control'] ) }}
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- 右側の項目 終わり-------------------------------------------------- -->
            </div>
          </dt>
          <!-- /.card-body -->
        </dl>
        <!-- コピー作成用フィールド   終わり--------------------------------------------------　 -->
        <p class="text-center">
          {{ Form::submit('すべての日程に反映する', ['class' => 'btn more_btn_lg mt-3'])}}
          {{ Form::close() }}
        </p>
      </section>

      <ul class="register-list-header mt-5">
        <li class="from-group">
          <div class="form-check">
            <input class="mr-1" type="checkbox" name="all_check" id="all_check" />
            <label class="form-check-label">すべてチェックする</label>
          </div>
        </li>
        <li>
          <p><a class="more_btn4" href="">削除</a></p>
        </li>
      </ul>

      {{-- jsで仮押さえの件数判別のためのhidden --}}
      {{ Form::hidden('', $multiple->pre_reservations()->where('venue_id',$venue->id)->get()->count(),['id'=>'counts_reserve']) }}
      {{-- 以下、pre_reservationの数分　ループ --}}
      @foreach ($multiple->pre_reservations()->where('venue_id',$venue->id)->get() as $key=>$pre_reservation)
      {{ Form::open(['url' => 'admin/multiples/'.$multiple->id."/edit/".$venue->id.'/calculate/'.$pre_reservation->id.'/specific_update', 'method'=>'POST', 'id'=>'']) }}
      @csrf
      {{ Form::hidden('split_keys', $key) }}

      <section class="register-list col">
        <!-- 仮押さえ一括 タブ-->
        <div class="register-list-item">
          <div class="from-group list_checkbox">
            <div class="form-check">
              <input type="checkbox" name="{{'delete_check'.$pre_reservation->id}}" value="{{$pre_reservation->id}}"
                class="checkbox mr-1" />
              <!-- <input class="form-check-input" type="checkbox"> -->
              <label class="form-check-label"></label>
            </div>
          </div>
          <dl class="card">
            <dt class="card-header accordion-ttl">
              <ul class="title-icon d-flex">
                <li class="col-1">
                  {{$pre_reservation->id}}
                </li>
                <li class="col-2">
                  <div class="input-group">
                    <label for="date"></label>
                    {{ Form::text('', ReservationHelper::formatDate($pre_reservation->reserve_date) ,['class'=>'form-control', 'readonly'] ) }}
                    {{ Form::hidden('reserve_date'.$key, $pre_reservation->reserve_date ,['class'=>'form-control', 'readonly'] ) }}
                  </div>
                </li>
                <li class="col-3 d-flex align-items-center">
                  <p>
                  </p>
                  <div class="input-group">
                    <label for="start"></label>
                    {{ Form::text('', ReservationHelper::formatTime($pre_reservation->enter_time) ,['class'=>'form-control', 'readonly'] ) }}
                    {{ Form::hidden('enter_time'.$key, $pre_reservation->enter_time ,['class'=>'form-control', 'readonly'] ) }}
                  </div>
                  <p></p>
                  <p class="mx-1">～</p>
                  <p>
                  </p>
                  <div class="input-group">
                    <label for="finish"></label>
                    {{ Form::text('', ReservationHelper::formatTime($pre_reservation->leave_time) ,['class'=>'form-control', 'readonly'] ) }}
                    {{ Form::hidden('leave_time'.$key, $pre_reservation->leave_time ,['class'=>'form-control', 'readonly'] ) }}
                  </div>
                  <p></p>
                </li>
              </ul>
            </dt>
            <dt class="accordion-wrap">
              <div class="row p-3">
                <!-- 左側の項目------------------------------------------------------------------------ -->
                <div class="col">
                  <table class="table table-bordered">
                    <tbody>
                      <tr>
                        <td colspan="2">
                          <p class="title-icon">
                            <i class="fas fa-info-circle icon-size" aria-hidden="true"></i>
                            仮押さえ情報
                          </p>
                        </td>
                      </tr>
                      <tr>
                        <td class="table-active">
                          <label for="direction">料金体系</label>
                        </td>
                        <td>
                          <div class="">
                            {{ Form::radio('price_system_copied'.$key, 1, $pre_reservation->price_system==1?true:false, ['id'=>'price_system_copied'.$key]) }}
                            {{Form::label('price_system_copied'.$key,'通常（枠貸）')}}
                          </div>
                          <div>
                            {{ Form::radio('price_system_copied'.$key, 2, $pre_reservation->price_system==2?true:false, ['id'=>'price_system_copied_off'.$key]) }}
                            {{Form::label('price_system_copied_off'.$key,'アクセア（時間貸）')}}
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td class="table-active"><label for="direction">案内板</label></td>
                        <td>
                          <div class="radio-box">
                            <p>
                              {{ Form::radio('board_flag_copied'.$key, 1, $pre_reservation->board_flag==1?true:false, ['id'=>'board_flag_copied'.$key]) }}
                              {{Form::label('board_flag_copied'.$key,'あり')}}
                            </p>
                            <p>
                              {{ Form::radio('board_flag_copied'.$key, 0, $pre_reservation->board_flag==0?true:false, ['id'=>'board_flag_copied_off'.$key]) }}
                              {{Form::label('board_flag_copied_off'.$key,'なし')}}
                            </p>
                          </div>
                        </td>
                      </tr>
                      <!-- <tr>
                        <td class="table-active"><label for="eventTime">イベント時間記載</label></td>
                        <td>
                          <div class="radio-box">
                            <p>
                              <input type="radio" id="eventTime" name="eventTime" checked="">
                              <label for="eventTime">あり</label>
                            </p>
                            <p>
                              <input type="radio" id="eventTime" name="eventTime" checked="">
                              <label for="eventTime">なし</label>
                            </p>
                          </div>
                        </td>
                      </tr> -->
                      <tr>
                        <td class="table-active"><label for="eventStart">イベント開始時間</label></td>
                        <td>
                          <select name="{{'event_start_copied'.$key}}" class="form-control">
                            <option disabled>選択してください</option>
                            @for ($start = 0*2; $start <=23*2; $start++) <option
                              value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if(date("H:i:s",
                              strtotime("00:00 +". $start * 30 ." minute"))==$pre_reservation->enter_time)
                              selected
                              @endif
                              >
                              {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}</option>
                              @endfor
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td class="table-active"><label for="eventFinish">イベント終了時間</label></td>
                        <td>
                          <select name="{{'event_finish_copied'.$key}}" id="{{'event_finish_copied'.$key}}"
                            class="form-control">
                            <option disabled>選択してください</option>
                            @for ($start = 0*2; $start <=23*2; $start++) <option
                              value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (date("H:i:s",
                              strtotime("00:00 +". $start * 30 ." minute"))==$pre_reservation->leave_time)
                              selected
                              @endif
                              >
                              {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}</option>
                              @endfor
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td class="table-active"><label for="eventName1">イベント名称1</label></td>
                        <td>
                          {{ Form::text('event_name1_copied'.$key,$pre_reservation->event_name1,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
                        </td>
                      </tr>
                      <tr>
                        <td class="table-active"><label for="eventName2">イベント名称2</label></td>
                        <td>
                          {{ Form::text('event_name2_copied'.$key, $pre_reservation->event_name2,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
                        </td>
                      </tr>
                      <tr>
                        <td class="table-active"><label for="organizer">主催者名</label></td>
                        <td>
                          {{ Form::text('event_owner'.$key, $pre_reservation->event_owner,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <table class="table table-bordered equipment-table">
                    <thead class="accordion-ttl">
                      <tr>
                        <th colspan="2">
                          <p class="title-icon fw-bolder py-1">
                            <i class="fas fa-wrench icon-size fa-fw"></i>有料備品
                          </p>
                        </th>
                      </tr>
                    </thead>
                    <tbody class="accordion-wrap">

                      @foreach ($venue->getEquipments() as $e_key=>$equipment)
                      <tr>
                        <td class="table-active">{{$equipment->item}}</td>
                        <td>
                          @if ($pre_reservation->pre_breakdowns)
                          @foreach ($pre_reservation->pre_breakdowns()->get() as $pre_re)
                          @if ($pre_re->unit_item==$equipment->item)
                          {{Form::text('equipment_breakdown' . $e_key.'_copied'.$key , $pre_re->unit_count, ['class' => 'form-control'])}}
                          @break
                          @elseif($loop->last)
                          {{Form::text('equipment_breakdown' . $e_key.'_copied'.$key , '', ['class' => 'form-control'])}}
                          @endif
                          @endforeach
                          @else
                          {{Form::text('equipment_breakdown' . $e_key.'_copied'.$key , '', ['class' => 'form-control'])}}
                          @endif
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                  <table class="table table-bordered service-table">
                    <thead class="accordion-ttl">
                      <tr>
                        <th colspan="2">
                          <p class="title-icon fw-bolder py-1">
                            <i class="fas fa-hand-holding-heart icon-size fa-fw"></i>有料サービス
                          </p>
                        </th>
                      </tr>
                    </thead>
                    <tbody class="accordion-wrap">
                      @foreach ($venue->getServices() as $s_key=>$service)
                      <tr>
                        <td class="table-active">{{$service->item}}</td>
                        <td>
                          @if ($pre_reservation->pre_breakdowns)
                          @foreach ($pre_reservation->pre_breakdowns()->get() as $pre_re)
                          @if ($pre_re->unit_item==$service->item)
                          <div class="form-check form-check-inline">
                            {{Form::radio('services_breakdown'.$s_key.'_copied'.$key, 1, true , ['id' => 'services_breakdown'.$s_key.'_copied'.$key, 'class' => 'form-check-input'])}}
                            {{Form::label('services_breakdown'.$s_key.'_copied'.$key,'有り')}}
                            {{Form::radio('services_breakdown'.$s_key.'_copied'.$key, 0, false, ['id' => 'services_breakdown'.$s_key.'_copied'.$key."off", 'class' => 'form-check-input'])}}
                            {{Form::label('services_breakdown'.$s_key.'_copied'.$key."off",'無し')}}
                          </div>
                          @break
                          @elseif($loop->last)
                          <div class="form-check form-check-inline">
                            {{Form::radio('services_breakdown'.$s_key.'_copied'.$key, 1, false , ['id' => 'services_breakdown'.$s_key.'_copied'.$key, 'class' => 'form-check-input'])}}
                            {{Form::label('services_breakdown'.$s_key.'_copied'.$key,'有り')}}
                            {{Form::radio('services_breakdown'.$s_key.'_copied'.$key, 0, true, ['id' => 'services_breakdown'.$s_key.'_copied'.$key."off", 'class' => 'form-check-input'])}}
                            {{Form::label('services_breakdown'.$s_key.'_copied'.$key."off",'無し')}}
                          </div>
                          @endif
                          @endforeach
                          @else
                          <div class="form-check form-check-inline">
                            {{Form::radio('services_breakdown'.$s_key.'_copied'.$key, 1, false , ['id' => 'services_breakdown'.$s_key.'_copied'.$key, 'class' => 'form-check-input'])}}
                            {{Form::label('services_breakdown'.$s_key.'_copied'.$key,'有り')}}
                            {{Form::radio('services_breakdown'.$s_key.'_copied'.$key, 0, true, ['id' => 'services_breakdown'.$s_key.'_copied'.$key."off", 'class' => 'form-check-input'])}}
                            {{Form::label('services_breakdown'.$s_key.'_copied'.$key."off",'無し')}}
                          </div>
                          @endif
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>

                  <table class="table table-bordered layout-table">
                    <thead>
                      <tr>
                        <th colspan="2">
                          <p class="title-icon py-1">
                            <i class="fas fa-th icon-size fa-fw"></i>レイアウト
                          </p>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="table-active">準備</td>
                        <td>
                          <div class="form-check form-check-inline">
                            @foreach ($pre_reservation->pre_breakdowns()->get() as $layout_prepares)
                            @if ($layout_prepares->unit_item=="レイアウト準備料金")
                            {{Form::radio('layout_prepare_copied'.$key, 1, true, ['id' => 'layout_prepare_copied'.$key, 'class' => 'form-check-input'])}}
                            {{Form::label('layout_prepare_copied'.$key,'有り')}}
                            {{Form::radio('layout_prepare_copied'.$key, 0, false, ['id' => 'no_layout_prepare_copied'.$key, 'class' => 'form-check-input'])}}
                            {{Form::label('no_layout_prepare_copied'.$key,'無し')}}
                            @break
                            @elseif($loop->last)
                            {{Form::radio('layout_prepare_copied'.$key, 1, false, ['id' => 'layout_prepare_copied'.$key, 'class' => 'form-check-input'])}}
                            {{Form::label('layout_prepare_copied'.$key,'有り')}}
                            {{Form::radio('layout_prepare_copied'.$key, 0, true, ['id' => 'no_layout_prepare_copied'.$key, 'class' => 'form-check-input'])}}
                            {{Form::label('no_layout_prepare_copied'.$key,'無し')}}
                            @endif
                            @endforeach
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td class="table-active">片付</td>
                        <td>
                          <div class="form-check form-check-inline">
                            @foreach ($pre_reservation->pre_breakdowns()->get() as $layout_prepares)
                            @if ($layout_prepares->unit_item=="レイアウト片付料金")
                            {{Form::radio('layout_clean_copied'.$key, 1, true, ['id' => 'layout_clean_copied'.$key, 'class' => 'form-check-input'])}}
                            {{Form::label('layout_clean_copied'.$key,'有り')}}
                            {{Form::radio('layout_clean_copied'.$key, 0, false, ['id' => 'no_layout_clean_copied'.$key, 'class' => 'form-check-input'])}}
                            {{Form::label('no_layout_clean_copied'.$key,'無し')}}
                            @break
                            @elseif($loop->last)
                            {{Form::radio('layout_clean_copied'.$key, 1, false, ['id' => 'layout_clean_copied'.$key, 'class' => 'form-check-input'])}}
                            {{Form::label('layout_clean_copied'.$key,'有り')}}
                            {{Form::radio('layout_clean_copied'.$key, 0, true, ['id' => 'no_layout_clean_copied'.$key, 'class' => 'form-check-input'])}}
                            {{Form::label('no_layout_clean_copied'.$key,'無し')}}
                            @endif
                            @endforeach
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>

                  <table class="table table-bordered luggage-table" style="table-layout: fixed;">
                    <thead>
                      <tr>
                        <th colspan="2">
                          <p class="title-icon">
                            <i class="fas fa-suitcase-rolling icon-size fa-fw"></i>荷物預かり
                          </p>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="table-active">事前に預かる荷物<br>（個数）</td>
                        <td>
                          {{ Form::text('luggage_count_copied'.$key, $pre_reservation->luggage_count,['class'=>'form-control'] ) }}
                        </td>
                      </tr>
                      <tr>
                        <td class="table-active">事前荷物の到着日<br>午前指定のみ</td>
                        <td>
                          {{ Form::text('luggage_arrive_copied'.$key, $pre_reservation->luggage_arrive,['class'=>'form-control'] ) }}
                        </td>
                      </tr>
                      <tr>
                        <td class="table-active">事後返送する荷物</td>
                        <td>
                          {{ Form::text('luggage_return_copied'.$key, $pre_reservation->luggage_return,['class'=>'form-control'] ) }}
                        </td>
                      </tr>

                      <tr>
                        <td class="table-active">荷物預かり/返送<br>料金</td>
                        <td>
                          @foreach ($pre_reservation->pre_breakdowns()->get() as $lugg)
                          @if ($lugg->unit_item=="荷物預かり/返送")
                          {{ Form::text('luggage_price_copied'.$key, $lugg->unit_cost,['class'=>'form-control'] ) }}
                          @break
                          @elseif($loop->last)
                          {{ Form::text('luggage_price_copied'.$key, '',['class'=>'form-control'] ) }}
                          @endif
                          @endforeach
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <table class="table table-bordered eating-table">
                    <thead>
                      <tr>
                        <th colspan='2'>
                          <p class="title-icon">
                            <i class="fas fa-suitcase-rolling icon-size fa-fw"></i>室内飲食
                          </p>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          {{Form::radio('cp_master_eat_in', 1, false , ['id' => 'eat_in'])}}
                          {{Form::label('eat_in',"あり")}}
                        </td>
                        <td>
                          {{Form::radio('cp_master_eat_in_prepare', 1, "" , ['id' => 'eat_in_prepare' ])}}
                          {{Form::label('eat_in_prepare',"手配済み")}}
                          {{Form::radio('cp_master_eat_in_prepare', 2, "" , ['id' => 'eat_in_consider'])}}
                          {{Form::label('eat_in_consider',"検討中")}}
                        </td>
                      </tr>
                      <tr>
                        <td>
                          {{Form::radio('cp_master_eat_in', 0, true , ['id' => 'no_eat_in'])}}
                          {{Form::label('no_eat_in',"なし")}}
                        </td>
                        <td></td>
                      </tr>
                  </table>
                </div>
                <!-- 左側の項目 終わり-------------------------------------------------- -->
                <!-- 右側の項目-------------------------------------------------- -->
                <div class="col">
                  <div class="customer-table">
                    <table class="table table-bordered oneday-table">
                      <tbody>
                        <tr>
                          <td colspan="2">
                            <p class="title-icon">
                              <i class="fas fa-user icon-size" aria-hidden="true"></i>
                              当日の連絡できる担当者
                            </p>
                          </td>
                        </tr>
                        <tr>
                          <td class="table-active"><label for="ondayName">氏名</label></td>
                          <td>
                            {{ Form::text('in_charge_copied'.$key, $pre_reservation->in_charge,['class'=>'form-control'] ) }}
                          </td>
                        </tr>
                        <tr>
                          <td class="table-active"><label for="mobilePhone">携帯番号</label></td>
                          <td>
                            {{ Form::text('tel_copied'.$key, $pre_reservation->tel,['class'=>'form-control'] ) }}
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <table class="table table-bordered mail-table">
                    <tbody>
                      <tr>
                        <td colspan="2">
                          <p class="title-icon">
                            <i class="fas fa-envelope icon-size" aria-hidden="true"></i>
                            利用後の送信メール
                          </p>
                        </td>
                      </tr>
                      <tr>
                        <td class="table-active"><label for="sendMail">送信メール</label></td>
                        <td>
                          <div class="d-flex">
                            <div class="form-check form-check-inline">
                              {{Form::radio('email_flag_copied'.$key, 1, $pre_reservation->email_flag==1?true:false, ['id' => 'email_flag_copied'.$key, 'class' => 'form-check-input'])}}
                              {{Form::label('email_flag_copied'.$key,'有り',['class'=>'mr-5'])}}
                              {{Form::radio('email_flag_copied'.$key, 0, $pre_reservation->email_flag==0?true:false, ['id' => 'no_email_flag_copied'.$key, 'class' => 'form-check-input'])}}
                              {{Form::label('no_email_flag_copied'.$key,'無し')}}
                            </div>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <table class="table table-bordered sale-table">
                    <tbody>
                      <tr>
                        <td colspan="2">
                          <p class="title-icon">
                            <i class="fas fa-yen-sign icon-size" aria-hidden="true"></i>
                            売上原価
                          </p>
                        </td>
                      </tr>
                      <tr>
                        <td class="table-active"><label for="sale">原価率</label></td>
                        <td class="d-flex align-items-center">
                          {{ Form::text('cost_copied'.$key, $pre_reservation->cost,['class'=>'form-control'] ) }}%
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <table class="table table-bordered note-table">
                    <tbody>
                      <tr>
                        <td colspan="2">
                          <p class="title-icon">
                            <i class="fas fa-file-alt icon-size" aria-hidden="true"></i>
                            備考
                          </p>
                        </td>
                      </tr>
                      <!-- <tr>
                        <td>
                          <p>
                            <input type="checkbox" id="discount" checked="">
                            <label for="discount">割引条件</label>
                          </p>
                          {{ Form::textarea('discount_condition_copied'.$key, $pre_reservation->cp_master_discount_condition,['class'=>'form-control'] ) }}
                        </td>
                      </tr>
                      <tr class="caution">
                        <td>
                          <label for="caution">注意事項</label>
                          {{ Form::textarea('attention_copied'.$key, $pre_reservation->attention,['class'=>'form-control'] ) }}
                        </td>
                      </tr> -->
                      <tr>
                        <td>
                          <label for="adminNote">管理者備考</label>
                          {{ Form::textarea('admin_details_copied'.$key, $pre_reservation->admin_details,['class'=>'form-control'] ) }}
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <!-- 右側の項目 終わり-------------------------------------------------- -->
              </div>
              <div class="btn_wrapper">
                <p class="text-center">
                  {{ Form::submit('請求に反映する', ['class' => 'btn more_btn_lg'])}}
                </p>
                {{ Form::close() }}
              </div>

              <section class="section-wrap">
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
                          <dl class="ttl_box mb-0">
                            <dt>合計金額</dt>
                            <dd class="total_result">
                              {{number_format(empty($pre_reservation->pre_bill->master_total)?0:$pre_reservation->pre_bill->master_total)}}
                              円
                            </dd>
                          </dl>
                        </td>
                      </tr>
                    </table>
                  </div>
                  <div class="bill_details">
                    <div class="head d-flex">
                      <div class="accordion_btn">
                        <i class="fas fa-plus bill_icon_size hide"></i>
                        <i class="fas fa-minus bill_icon_size"></i>
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
                          @if (!empty($pre_reservation->pre_bill->venue_price))
                          <tbody class="venue_head">
                            <tr>
                              <td>内容</td>
                              <td>単価</td>
                              <td>数量</td>
                              <td>金額</td>
                            </tr>
                          </tbody>
                          <tbody class="{{'venue_main'.$key}}">
                            @foreach ($pre_reservation->pre_breakdowns()->where('unit_type',1)->get() as $each_venue)
                            <tr>
                              <td>
                                {{ Form::text('venue_breakdown_item0_copied'.$key, $each_venue->unit_item,['class'=>'form-control', 'readonly'] ) }}
                              </td>
                              <td>
                                {{ Form::text('venue_breakdown_cost0_copied'.$key, $each_venue->unit_cost,['class'=>'form-control', 'readonly'] ) }}
                              </td>
                              <td>
                                {{ Form::text('venue_breakdown_count0_copied'.$key, $each_venue->unit_count,['class'=>'form-control', 'readonly'] ) }}
                              </td>
                              <td>
                                {{ Form::text('venue_breakdown_subtotal0_copied'.$key, $each_venue->unit_subtotal,['class'=>'form-control', 'readonly'] ) }}
                              </td>
                            </tr>
                            @endforeach
                          </tbody>
                          <tbody class="{{'venue_result'.$key}}">
                            <tr>
                              <td colspan="2"></td>
                              <td colspan="2">合計
                                {{ Form::text('venue_price'.$key,$pre_reservation->pre_bill->venue_price,['class'=>'form-control col-xs-3', 'readonly'] ) }}
                              </td>
                            </tr>
                          </tbody>
                          <!-- <tbody class="{{'venue_discount'.$key}}">
                            <tr>
                              <td>割引計算欄</td>
                              <td>
                                <p>
                                  割引金額
                                </p>
                                <div class="d-flex align-items-end">
                                  {{ Form::text('venue_number_discount'.$key, '',['class'=>'form-control'] ) }}
                                  <p class="ml-1">円</p>
                                </div>
                              </td>
                              <td>
                                <p>
                                  割引率
                                </p>
                                <div class="d-flex align-items-end">
                                  {{ Form::text('venue_percent_discount'.$key, '',['class'=>'form-control'] ) }}
                                  <p class="ml-1">%</p>
                                </div>
                              </td>
                              <td>
                                <input class="{{'btn more_btn venue_discount_btn'.$key}}" type="button" value="計算する">
                              </td>
                            </tr>
                          </tbody> -->
                          @else{{--料金体系無し、手打ち--}}
                          <span>※料金体系がないため、手打ちで会場料を入力してください</span>
                          <tbody class="venue_head">
                            <tr>
                              <td>内容</td>
                              <td>単価</td>
                              <td>数量</td>
                              <td>金額</td>
                              <td></td>
                            </tr>
                          </tbody>
                          <tbody class="{{'venue_main'.$key}}">
                            <tr>
                              <td>
                                {{ Form::text('venue_breakdown_item0_copied'.$key, '',['class'=>'form-control'] ) }}
                              </td>
                              <td>
                                {{ Form::text('venue_breakdown_cost0_copied'.$key, '',['class'=>'form-control'] ) }}
                              </td>
                              <td>
                                {{ Form::text('venue_breakdown_count0_copied'.$key, '',['class'=>'form-control'] ) }}
                              </td>
                              <td>
                                {{ Form::text('venue_breakdown_subtotal0_copied'.$key, '',['class'=>'form-control'] ) }}
                              </td>
                              <td>
                                <input type="button" value="＋" class="add pluralBtn">
                                <input type="button" value="ー" class="del pluralBtn">
                              </td>
                            </tr>
                          </tbody>
                          <tbody class="{{'venue_result'.$key}}">
                            <tr>
                              <td colspan="2"></td>
                              <td colspan="2">合計
                                {{ Form::text('venue_price'.$key,'',['class'=>'form-control col-xs-3', 'readonly'] ) }}
                              </td>
                            </tr>
                          </tbody>
                          @endif
                        </table>
                      </div>

                      {{-- 0が料金合計　
                    1が備品breakdown
                    2がserviceのbreakdown
                    3が備品料金
                    4がサービス料金 --}}
                      {{-- 以下備品 --}}
                      @if (!empty($pre_reservation->pre_bill->equipment_price))
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
                          <tbody class="{{'equipment_main'.$key}}">
                            @foreach ($pre_reservation->pre_breakdowns()->where('unit_type',2)->get() as
                            $eb_key=>$each_equ)
                            <tr>
                              <td>
                                {{ Form::text('equipment_breakdown_item'.$eb_key.'_copied'.$key, $each_equ->unit_item,['class'=>'form-control', 'readonly'] ) }}
                              </td>
                              <td>
                                {{ Form::text('equipment_breakdown_cost'.$eb_key.'_copied'.$key, $each_equ->unit_cost,['class'=>'form-control', 'readonly'] ) }}
                              </td>
                              <td>
                                {{ Form::text('equipment_breakdown_count'.$eb_key.'_copied'.$key, $each_equ->unit_count,['class'=>'form-control', 'readonly'] ) }}
                              </td>
                              <td>
                                {{ Form::text('equipment_breakdown_subtotal'.$eb_key.'_copied'.$key, $each_equ->unit_subtotal,['class'=>'form-control', 'readonly'] ) }}
                              </td>
                            </tr>
                            @endforeach
                            @foreach ($pre_reservation->pre_breakdowns()->where('unit_type',3)->get() as
                            $sb_key=>$each_ser)
                            <tr>
                              <td>
                                {{ Form::text('services_breakdown_item'.$sb_key.'_copied'.$key, $each_ser->unit_item,['class'=>'form-control', 'readonly'] ) }}
                              </td>
                              <td>
                                {{ Form::text('services_breakdown_cost'.$sb_key.'_copied'.$key, $each_ser->unit_cost,['class'=>'form-control', 'readonly'] ) }}
                              </td>
                              <td>
                                {{ Form::text('services_breakdown_count'.$sb_key.'_copied'.$key, $each_ser->unit_count,['class'=>'form-control', 'readonly'] ) }}
                              </td>
                              <td>
                                {{ Form::text('services_breakdown_subtotal'.$sb_key.'_copied'.$key, $each_ser->unit_subtotal,['class'=>'form-control', 'readonly'] ) }}
                              </td>
                            </tr>
                            @if ($each_ser->unit_item=="荷物預かり/返送")
                            <tr>
                              <td>
                                {{ Form::text('luggage_item_copied'.$key, '荷物預かり/返送',['class'=>'form-control', 'readonly'] ) }}
                              </td>
                              <td>
                                {{ Form::text('luggage_cost_copied'.$key, $each_ser->unit_cost,['class'=>'form-control', 'readonly'] ) }}
                              </td>
                              <td>
                                {{ Form::text('luggage_count_copied'.$key, 1,['class'=>'form-control', 'readonly'] ) }}
                              </td>
                              <td>
                                {{ Form::text('luggage_subtotal_copied'.$key, $each_ser->unit_cost,['class'=>'form-control', 'readonly'] ) }}
                              </td>
                            </tr>
                            @endif
                            @endforeach
                          </tbody>
                          <tbody class="{{'equipment_result'.$key}}">
                            <tr>
                              <td colspan="2"></td>
                              <td colspan="2">合計
                                {{ Form::text('equipment_price'.$key, $pre_reservation->pre_bill->equipment_price,['class'=>'form-control', 'readonly'] ) }}
                              </td>
                            </tr>
                          </tbody>
                          <!-- <tbody class="{{'equipment_discount'.$key}}">
                            <tr>
                              <td>割引計算欄</td>
                              <td>
                                <p>
                                  割引金額
                                </p>
                                <div class="d-flex align-items-end">
                                  {{ Form::text('equipment_number_discount'.$key,'',['class'=>'form-control'] ) }}
                                  <p class="ml-1">円</p>
                                </div>
                              </td>
                              <td>
                                <p>
                                  割引率
                                </p>
                                <div class="d-flex align-items-end">
                                  {{ Form::text('equipment_percent_discount'.$key, '',['class'=>'form-control'] ) }}
                                  <p class="ml-1">%</p>
                                </div>
                              </td>
                              <td>
                                <input class="btn more_btn {{'equipment_discount_btn'.$key}}" type="button" value="計算する">
                              </td>
                            </tr>
                          </tbody> -->
                        </table>
                      </div>
                      @endif

                      {{-- 以下、レイアウト --}}
                      @if (!empty($pre_reservation->pre_bill->layout_price))
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
                          <tbody class="{{'layout_main'.$key}}">
                            @foreach ($pre_reservation->pre_breakdowns()->where('unit_type',4)->get() as
                            $slp_key=>$each_play)
                            <tr>
                              <td>
                                {{ Form::text('layout_breakdown_item'.$slp_key.'_copied'.$key, $each_play->unit_item,['class'=>'form-control', 'readonly'] ) }}
                              </td>
                              <td>
                                {{ Form::text('layout_breakdown_cost'.$slp_key.'_copied'.$key, $each_play->unit_cost,['class'=>'form-control', 'readonly'] ) }}
                              </td>
                              <td>
                                {{ Form::text('layout_breakdown_count'.$slp_key.'_copied'.$key, $each_play->unit_count,['class'=>'form-control', 'readonly'] ) }}
                              </td>
                              <td>
                                {{ Form::text('layout_breakdown_subtotal'.$slp_key.'_copied'.$key, $each_play->unit_subtotal,['class'=>'form-control', 'readonly'] ) }}
                              </td>
                            </tr>
                            @endforeach
                          </tbody>
                          <tbody class="{{'layout_result'.$key}}">
                            <tr>
                              <td colspan="2"></td>
                              <td colspan="2">合計
                                {{ Form::text('layout_price'.$key, $pre_reservation->pre_bill->layout_price,['class'=>'form-control', 'readonly'] ) }}
                              </td>
                            </tr>
                          </tbody>
                          <tbody class="{{'layout_discount'.$key}}">
                            <!-- <tr>
                              <td>割引計算欄</td>
                              <td>
                                <p>
                                  割引金額
                                </p>
                                <div class="d-flex align-items-end">
                                  {{ Form::text('layout_number_discount'.$key, '',['class'=>'form-control'] ) }}
                                  <p class="ml-1">円</p>
                                </div>
                              </td>
                              <td>
                                <p>
                                  割引率
                                </p>
                                <div class="d-flex align-items-end">
                                  {{ Form::text('layout_percent_discount'.$key, '',['class'=>'form-control'] ) }}
                                  <p class="ml-1">%</p>
                                </div>
                              </td>
                              <td>
                                <input class="btn more_btn {{'layout_discount_btn'.$key}}" type="button" value="計算する">
                              </td>
                            </tr>
                          </tbody> -->
                        </table>
                      </div>
                      @endif

                      {{-- 以下、その他 --}}
                      <!-- <div class="others billdetails_content">
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
                              <td>追加/削除</td>
                            </tr>
                          </tbody>
                          <tbody class="{{'others_main'.$key}}">
                            <tr>
                              <td>
                                {{ Form::text('others_input_item0_copied'.$key, '',['class'=>'form-control'] ) }}
                              </td>
                              <td>
                                {{ Form::text('others_input_cost0_copied'.$key, '',['class'=>'form-control'] ) }}
                              </td>
                              <td>
                                {{ Form::text('others_input_count0_copied'.$key, '',['class'=>'form-control'] ) }}
                              </td>
                              <td>
                                {{ Form::text('others_input_subtotal0_copied'.$key, '',['class'=>'form-control', 'readonly'] ) }}
                              </td>
                              <td>
                                <input type="button" value="＋" class="add pluralBtn bg-blue">
                                <input type="button" value="ー" class="del pluralBtn bg-red">
                              </td>
                            </tr>
                          </tbody>
                          <tbody class="others_result">
                            <tr>
                              <td colspan="2"></td>
                              <td colspan="3">合計
                                {{ Form::text('others_price'.$key, '',['class'=>'form-control', 'readonly'] ) }}
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div> -->
                      {{-- 以下、総合計 --}}
                      <div class="bill_total">
                        <table class="table">
                          <tr>
                            <td>小計：</td>
                            <td>
                              {{ Form::hidden('master_subtotal'.$key.'fixed',empty($pre_reservation->pre_bill->master_subtotal)?0:$pre_reservation->pre_bill->master_subtotal,['class'=>'form-control text-right', 'readonly'] ) }}
                              {{ Form::text('master_subtotal'.$key,empty($pre_reservation->pre_bill->master_subtotal)?0:$pre_reservation->pre_bill->master_subtotal,['class'=>'form-control text-right', 'readonly'] ) }}
                            </td>
                          </tr>
                          <tr>
                            <td>消費税：</td>
                            <td>
                              {{ Form::text('master_tax'.$key, empty($pre_reservation->pre_bill->master_tax)?0:$pre_reservation->pre_bill->master_tax ,['class'=>'form-control text-right', 'readonly'] ) }}
                            </td>
                          </tr>
                          <tr>
                            <td class="font-weight-bold">合計金額</td>
                            <td>
                              {{ Form::text('master_total'.$key, empty($pre_reservation->pre_bill->master_total)?0:$pre_reservation->pre_bill->master_total,['class'=>'form-control text-right', 'readonly'] ) }}
                            </td>
                          </tr>
                        </table>
                      </div>

                    </div>
                    <!-- 請求内訳 終わり ------------------------------------------------------>
                  </div>
                </div>
              </section>
            </dt>
            <!-- /.card-body -->
          </dl>
          <!-- /.card -->
        </div>
        <!-- 仮押さえ一括 タブ終わり-->
      </section>
      @endforeach

    </section>


    <section class="master_totals border-wrap">
      <table class="table">
        <tbody class="master_total_head">
          <tr>
            <td colspan="2">
              <h3>
                合計請求額
                <span>({{$multiple->pre_reservations()->get()->count()}}件分)</span>
              </h3>
            </td>
          </tr>
        </tbody>
        <tr>
          <td colspan="2" class="master_total_subttl">
            <h4>内訳</h4>
          </td>
        </tr>
        <tbody class="master_total_body">
          <tr>
            <td>・会場料</td>
            <td>{{$multiple->sumVenues($venue->id)}}円</td>
          </tr>
          <tr>
            <td>・有料備品　サービス</td>
            <td>{{$multiple->sumEquips($venue->id)}}円</td>
          </tr>
          <tr>
            <td>・レイアウト変更料</td>
            <td>{{$multiple->sumLayouts($venue->id)}}円</td>
          </tr>
          <!-- <tr>
            <td>・その他</td>
            <td>ダミー円</td>
          </tr> -->
        </tbody>
        <tbody class="master_total_bottom">
          <tr>
            <td></td>
            <td class="d-flex justify-content-end" colspan="2">
              <p>小計：</p>
              <p>{{$multiple->sumMasterSubs($venue->id)}}円</p>
            </td>
          </tr>
          <tr>
            <td></td>
            <td class="d-flex justify-content-end" colspan="2">
              <p>消費税：</p>
              <p>{{$multiple->sumMasterTax($venue->id)}}円</p>
            </td>
          </tr>
          <tr>
            <td></td>
            <td class="d-flex justify-content-end" colspan="2">
              <p>合計金額：</p>
              <p>{{$multiple->sumMasterTotal($venue->id)}}円</p>
            </td>
          </tr>
        </tbody>
      </table>
    </section>

    <ul class="d-flex col-12 justify-content-around mt-5 align-items-center">
      <li>
        <p><a class="btn more_btn_lg" href="">詳細にもどる</a></p>
      </li>
      <li>
        <p id="master_submit" class="btn more_btn_lg">保存する</p>
      </li>
    </ul>
  </div>
</div>

{{ Form::open(['url' => 'admin/multiples/'.$multiple->id."/all_updates/".$venue->id, 'method'=>'POST', 'id'=>'master_form']) }}
@csrf
{{ Form::hidden('master_data', '',['class' => 'btn btn-primary more_btn_lg', 'id'=>'master_data'])}}
{{ Form::close() }}


<script>
  $(function() {
    $(document).on("click", "#master_submit", function() {
      var data = {};
      $('input:radio:checked').each(function(index, elem) {
        var key = $(elem).attr('name');
        var value = $(elem).val();
        data[key] = value;
      })
      $('select option:selected').each(function(index, elem) {
        var key = $(elem).parent().attr('name');
        var value = $(elem).val();
        data[key] = value;
      })
      $('input:text').each(function(index, elem) {
        var key = $(elem).attr('name');
        var value = $(elem).val();
        data[key] = value;
      })

      console.log(data);
      var encodes = JSON.stringify(data);
      $('#master_data').val(encodes);
      $('#master_form').submit();
    })

  })
</script>



@endsection