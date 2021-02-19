@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/multiples/script.js') }}"></script>
<script src="{{ asset('/js/multiples/calculate.js') }}"></script>


























<div class="content">
  <div class="container-fluid">
    <div class="container-field mt-3">
      <div class="float-right">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="http://staging-smg2.herokuapp.com/admin/home">ホーム</a> &gt;
              一括仮押さえ 編集
            </li>
          </ol>
        </nav>
      </div>
      <h1 class="mt-3 mb-5">一括仮押さえ　編集</h1>
    </div>
    <!-- 仮押さえ登録--------------------------------------------------------　 -->
    <div class="alert-box d-flex align-items-center">
      <span class="mr-3"><i class="fas alert-icon fa-exclamation-triangle" aria-hidden="true"></i></span>
      <p>
        変更がある場合は、必ず更新するボタンを押してください。<br>
        更新しないまま画面遷移をすると、データが反映されません。
      </p>
    </div>　

    <!-- 詳細選択画面--------------------------------------------------　 -->
    <div class="col">
      <p class="font-weight-bold">日程ごとに、詳細を編集できます。</p>
    </div>
    <div class="col">
      <h3 class="bg-green py-2 px-1">仮押さえ一括ID:<span>{{$multiple->id}}</span><span
          class="ml-4">{{ReservationHelper::getVenue($venue->id)}}</span>
      </h3>



      {{ Form::open(['url' => 'admin/multiples/'.$multiple->id."/edit/".$venue->id.'/calculate', 'method'=>'POST', 'id'=>'']) }}
      @csrf
      <section class="col mt-4">
        <div class="register-wrap">
          <div class="mb-2">
            <p>同じ内容をすべての日程に反映することができます。</p>
          </div>
          <dl class="card">
            <dt class="card-header accordion-ttl2">
              <ul class="title-icon active d-flex">
                <li class="col-3">
                  <p>コピー作成用選択欄</p>
                </li>
                <li class="plus_icon">
                </li>
              </ul>
            </dt>
            <dt class="accordion-wrap p-3" style="display: none;">
              <div class="row">
                <!-- 左側の項目------------------------------------------------------------------------ -->
                <div class="col">
                  <table class="table table-bordered">
                    <tbody>
                      <tr>
                        <td colspan="2">
                          <p class="title-icon">
                            <i class="fas fa-info-circle icon-size" aria-hidden="true"></i>
                            予約情報</p>
                        </td>
                      </tr>
                      <tr>
                        <td class="table-active"><label for="direction">料金体系</label></td>
                        <td>
                          <div class="">
                            <div>
                              {{ Form::radio('cp_master_price_system', 1, true, ['class'=>'mr-2', 'id'=>'cp_master_price_system_radio1']) }}
                              {{Form::label('cp_master_price_system_radio1','通常（枠貸）')}}
                            </div>
                            <div>
                              {{ Form::radio('cp_master_price_system', 2, false, ['class'=>'mr-2', 'id'=>'cp_master_price_system_radio2']) }}
                              {{Form::label('cp_master_price_system_radio2','アクセア（時間貸）')}}
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td class="table-active"><label for="direction">案内板</label></td>
                        <td>
                          <div>
                            <div>
                              {{ Form::radio('cp_master_board_flag', 1, false, ['class'=>'mr-2', 'id'=>'cp_master_board_flag1']) }}
                              {{Form::label('cp_master_board_flag1','あり')}}
                            </div>
                            <div>
                              {{ Form::radio('cp_master_board_flag', 0, true, ['class'=>'mr-2', 'id'=>'cp_master_board_flagboard_flag2']) }}
                              {{Form::label('cp_master_board_flagboard_flag2','なし')}}
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td class="table-active"><label for="eventTime">イベント時間記載</label></td>
                        <td>
                          <div>
                            <div>
                              {{ Form::radio('cp_master_event', 1, false, ['class'=>'mr-2', 'id'=>'cp_master_event1']) }}
                              {{Form::label('cp_master_event1','あり')}}
                            </div>
                            <div>
                              {{ Form::radio('cp_master_event', 0, true, ['class'=>'mr-2', 'id'=>'cp_master_event2']) }}
                              {{Form::label('cp_master_event2','なし')}}
                            </div>
                          </div>
                        </td>
                      </tr>
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
                          <p class="title-icon active">有料備品</p>
                        </th>
                      </tr>
                    </thead>
                    <tbody class="accordion-wrap" style="display:none;">
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
                          <p class="title-icon active">有料サービス<span class="open_toggle"></span></p>
                        </th>
                      </tr>
                    </thead>
                    <tbody class="accordion-wrap" style="display: none;">
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
                    <thead class="accordion-ttl">
                      <tr>
                        <th colspan="2">
                          <p class="title-icon active">レイアウト<span class="open_toggle"></span></p>
                        </th>
                      </tr>
                    </thead>
                    <tbody class="accordion-wrap" style="display: none;">
                      @if ($venue->getLayouts()[0])
                      <tr>
                        <td class="table-active">レイアウト準備</td>
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
                        <td class="table-active">レイアウト片付け</td>
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
                    <thead class="accordion-ttl">
                      <tr>
                        <th colspan="2">
                          <p class="title-icon active">荷物預かり<span class="open_toggle"></span></p>
                        </th>
                      </tr>
                    </thead>
                    <tbody class="accordion-wrap" style="display: none;">
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
                    <tbody>
                      <tr>
                        <th>
                          <p class="title-icon">室内飲食</p>
                        </th>
                      </tr>
                      <tr>
                        <td>
                          <div class="radio-box">
                            <div class="icheck-primary">
                              <input type="radio" id="eatin" name="eatin" checked="">
                              <label for="eatin">あり</label>
                            </div>
                            <div class="icheck-primary">
                              <input type="radio" id="eatin" name="eatin" checked="">
                              <label for="eatin">手配済</label>
                            </div>
                            <div class="icheck-primary">
                              <input type="radio" id="eatin" name="eatin" checked="">
                              <label for="eatin">検討中</label>
                            </div>
                            <div class="icheck-primary">
                              <input type="radio" id="eatin" name="eatin" checked="">
                              <label for="eatin">なし</label>
                            </div>
                          </div>
                        </td>
                      </tr>
                    </tbody>
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
                      <tr>
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
                      </tr>
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
          <div class="btn_wrapper">
            <p class="text-center">
              {{ Form::submit('登録', ['class' => 'btn btn-primary'])}}
              {{ Form::close() }}
            </p>
          </div>
        </div>
      </section>
      <ul class="register-list-header">
        <li class="from-group">
          <div class="form-check">
            <input class="form-check-input" type="checkbox">
            <label class="form-check-label">すべてチェックする</label>
          </div>
        </li>
        <li>
          <p><a class="more_btn4" href="">削除</a></p>
        </li>
      </ul>
    </div>

    {{-- jsで仮抑えの件数判別のためのhidden --}}
    {{ Form::hidden('', $multiple->pre_reservations()->where('venue_id',$venue->id)->get()->count(),['id'=>'counts_reserve']) }}
    {{-- 以下、pre_reservationの数分　ループ --}}
    @foreach ($multiple->pre_reservations()->where('venue_id',$venue->id)->get() as $key=>$pre_reservation)
    <section class="register-list col">
      <!-- 仮押さえ一括 タブ-->
      <div class="register-list-item">
        <div class="from-group">
          <div class="form-check">
            <input class="form-check-input" type="checkbox">
            <label class="form-check-label"></label>
          </div>
        </div>
        <dl class="card">
          <dt class="card-header accordion-ttl2">
            <ul class="title-icon active d-flex">
              <li class="col-1">
                {{$pre_reservation->id}}
              </li>
              <li class="col-2">
                <div class="input-group">
                  <label for="date"></label>
                  {{ Form::text('', ReservationHelper::formatDate($pre_reservation->reserve_date) ,['class'=>'form-control', 'readonly'] ) }}
                  {{ Form::hidden('reserve_date', $pre_reservation->reserve_date ,['class'=>'form-control', 'readonly'] ) }}
                </div>
              </li>
              <li class="col-3 d-flex align-items-center">
                <p>
                </p>
                <div class="input-group">
                  <label for="start"></label>
                  {{ Form::text('', ReservationHelper::formatTime($pre_reservation->enter_time) ,['class'=>'form-control', 'readonly'] ) }}
                  {{ Form::hidden('enter_time', $pre_reservation->enter_time ,['class'=>'form-control', 'readonly'] ) }}
                </div>
                <p></p>
                <p class="mx-1">～</p>
                <p>
                </p>
                <div class="input-group">
                  <label for="finish"></label>
                  {{ Form::text('', ReservationHelper::formatTime($pre_reservation->leave_time) ,['class'=>'form-control', 'readonly'] ) }}
                  {{ Form::hidden('leave_time', $pre_reservation->leave_time ,['class'=>'form-control', 'readonly'] ) }}
                </div>
                <p></p>
              </li>
              <li class="plus_icon">
              </li>
            </ul>
          </dt>
          <dt class="accordion-wrap" style="display: none;">
            <div class="row">
              <!-- 左側の項目------------------------------------------------------------------------ -->
              <div class="col">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td colspan="2">
                        <p class="title-icon">
                          <i class="fas fa-info-circle icon-size" aria-hidden="true"></i>
                          予約情報</p>
                      </td>
                    </tr>
                    <tr>
                      <td class="table-active"><label for="direction">料金体系</label></td>
                      <td>
                        <div class="">
                          <div>
                            {{ Form::radio('price_system_copied'.$key, 1, $request->cp_master_price_system==1?true:false, ['class'=>'mr-2', 'id'=>'price_system_copied'.$key]) }}
                            {{Form::label('price_system_copied'.$key,'通常（枠貸）')}}
                          </div>
                          <div>
                            {{ Form::radio('price_system_copied'.$key, 2, $request->cp_master_price_system==2?true:false, ['class'=>'mr-2', 'id'=>'price_system_copied_off'.$key]) }}
                            {{Form::label('price_system_copied_off'.$key,'アクセア（時間貸）')}}
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="table-active"><label for="direction">案内板</label></td>
                      <td>
                        <div>
                          <div>
                            {{ Form::radio('board_flag_copied'.$key, 1, $request->cp_master_board_flag==1?true:false, ['class'=>'mr-2', 'id'=>'board_flag_copied'.$key]) }}
                            {{Form::label('board_flag1','あり')}}
                          </div>
                          <div>
                            {{ Form::radio('board_flag_copied'.$key, 0, $request->cp_master_board_flag==0?true:false, ['class'=>'mr-2', 'id'=>'board_flag_copied_off'.$key]) }}
                            {{Form::label('board_flag_copied_off'.$key,'なし')}}
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="table-active"><label for="eventTime">イベント時間記載</label></td>
                      <td>
                        <div>
                          <div>
                            {{ Form::radio('event_copied'.$key, 1, $request->cp_master_event==1?true:false, ['class'=>'mr-2', 'id'=>'event_copied'.$key]) }}
                            {{Form::label('event1','あり')}}
                          </div>
                          <div>
                            {{ Form::radio('event_copied'.$key, 0, $request->cp_master_event==0?true:false, ['class'=>'mr-2', 'id'=>'event_copied_off'.$key]) }}
                            {{Form::label('event_copied_off'.$key,'なし')}}
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="table-active"><label for="eventStart">イベント開始時間</label></td>
                      <td>
                        <select name="{{'event_start_copied'.$key}}" class="form-control">
                          <option disabled>選択してください</option>
                          @for ($start = 0*2; $start <=23*2; $start++) <option
                            value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if($request->
                            cp_master_event_start==date("H:i:s", strtotime("00:00 +". $start * 30 ." minute")))
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
                        <select name="{{'event_finish_copied'.$key}}" class="form-control">
                          <option disabled>選択してください</option>
                          @for ($start = 0*2; $start <=23*2; $start++) <option
                            value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if($request->
                            cp_master_event_finish==date("H:i:s", strtotime("00:00 +". $start * 30 ." minute")))
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
                        {{ Form::text('event_name1_copied'.$key,$request->cp_master_event_name1,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
                      </td>
                    </tr>
                    <tr>
                      <td class="table-active"><label for="eventName2">イベント名称2</label></td>
                      <td>
                        {{ Form::text('event_name2_copied'.$key,$request->cp_master_event_name2,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
                      </td>
                    </tr>
                    <tr>
                      <td class="table-active"><label for="organizer">主催者名</label></td>
                      <td>
                        {{ Form::text('event_owner'.$key, $request->cp_master_event_owner,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
                      </td>
                    </tr>
                  </tbody>
                </table>

                <table class="table table-bordered equipment-table" style="table-layout: fixed;">
                  <thead class="accordion-ttl">
                    <tr>
                      <th colspan="2">
                        <p class="title-icon active">有料備品</p>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="accordion-wrap" style="display: none;">
                    @foreach ($venue->getEquipments() as $e_key=>$equipment)
                    <tr>
                      <td class="table-active">{{$equipment->item}}</td>
                      <td>
                        {{Form::text('equipment_breakdown'.$e_key.'_copied'.$key , $request->{'cp_master_equipment_breakdown'.$e_key}, ['class' => 'form-control'])}}
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>

                <table class="table table-bordered service-table">
                  <thead class="accordion-ttl">
                    <tr>
                      <th colspan="2">
                        <p class="title-icon active">有料サービス<span class="open_toggle"></span></p>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="accordion-wrap" style="display: none;">
                    @foreach ($venue->getServices() as $s_key=>$service)
                    <tr>
                      <td class="table-active">{{$service->item}}</td>
                      <td>
                        <div class="form-check form-check-inline">
                          {{Form::radio('services_breakdown'.$s_key.'_copied'.$key, 1, $request->{'cp_master_services_breakdown'.$s_key}==1?true:false , ['id' => 'services_breakdown'.$s_key.'_copied'.$key, 'class' => 'form-check-input'])}}
                          {{Form::label('services_breakdown'.$s_key.'_copied'.$key,'有り')}}
                          {{Form::radio('services_breakdown'.$s_key.'_copied'.$key, 0, $request->{'cp_master_services_breakdown'.$s_key}==0?true:false, ['id' => 'services_breakdown_off'.$s_key.'_copied'.$key, 'class' => 'form-check-input'])}}
                          {{Form::label('services_breakdown_off'.$s_key.'_copied'.$key,'無し')}}
                        </div>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>

                <table class="table table-bordered layout-table">
                  <thead class="accordion-ttl">
                    <tr>
                      <th colspan="2">
                        <p class="title-icon active">レイアウト<span class="open_toggle"></span></p>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="accordion-wrap" style="display: none;">
                    <tr>
                      <td class="table-active">レイアウト準備</td>
                      <td>
                        <div class="form-check form-check-inline">
                          {{Form::radio('layout_prepare_copied'.$key, 1, $request->cp_master_layout_prepare==1?true:false, ['id' => 'layout_prepare_copied'.$key, 'class' => 'form-check-input'])}}
                          {{Form::label('layout_prepare_copied'.$key,'有り')}}
                          {{Form::radio('layout_prepare_copied'.$key, 0, $request->cp_master_layout_prepare==0?true:false, ['id' => 'no_layout_prepare_copied'.$key, 'class' => 'form-check-input'])}}
                          {{Form::label('no_layout_prepare_copied'.$key,'無し')}}
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="table-active">レイアウト片付け</td>
                      <td>
                        <div class="form-check form-check-inline">
                          {{Form::radio('layout_clean_copied'.$key, 1, $request->cp_master_layout_clean==1?true:false, ['id' => 'layout_clean_copied'.$key, 'class' => 'form-check-input'])}}
                          {{Form::label('layout_clean_copied'.$key,'有り')}}
                          {{Form::radio('layout_clean_copied'.$key, 0, $request->cp_master_layout_clean==0?true:false, ['id' => 'no_layout_clean_copied'.$key, 'class' => 'form-check-input'])}}
                          {{Form::label('no_layout_clean_copied'.$key,'無し')}}
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>

                <table class="table table-bordered luggage-table" style="table-layout: fixed;">
                  <thead class="accordion-ttl">
                    <tr>
                      <th colspan="2">
                        <p class="title-icon active">荷物預かり<span class="open_toggle"></span></p>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="accordion-wrap" style="display: none;">
                    @if ($venue->getLuggage()===1)
                    <tr>
                      <td class="table-active">事前に預かる荷物<br>（個数）</td>
                      <td>
                        {{ Form::text('luggage_count_copied'.$key, $request->cp_master_luggage_count,['class'=>'form-control'] ) }}
                      </td>
                    </tr>
                    <tr>
                      <td class="table-active">事前荷物の到着日<br>午前指定のみ</td>
                      <td>
                        {{ Form::text('luggage_arrive_copied'.$key, $request->cp_master_luggage_arrive,['class'=>'form-control'] ) }}
                      </td>
                    </tr>
                    <tr>
                      <td class="table-active">事後返送する荷物</td>
                      <td>
                        {{ Form::text('luggage_return_copied'.$key, $request->cp_master_luggage_return,['class'=>'form-control'] ) }}
                      </td>
                    </tr>
                    <tr>
                      <td class="table-active">荷物預かり/返送<br>料金</td>
                      <td>
                        {{ Form::text('luggage_price_copied'.$key, $request->cp_master_luggage_price,['class'=>'form-control'] ) }}
                      </td>
                    </tr>
                    @endif
                  </tbody>
                </table>

                <table class="table table-bordered eating-table">
                  <tbody>
                    <tr>
                      <td>
                        <p class="title-icon">室内飲食</p>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="radio-box">
                          <div class="icheck-primary">
                            <input type="radio" id="eatin" name="eatin" checked="">
                            <label for="eatin">あり</label>
                          </div>
                          <div class="icheck-primary">
                            <input type="radio" id="eatin" name="eatin" checked="">
                            <label for="eatin">手配済</label>
                          </div>
                          <div class="icheck-primary">
                            <input type="radio" id="eatin" name="eatin" checked="">
                            <label for="eatin">検討中</label>
                          </div>
                          <div class="icheck-primary">
                            <input type="radio" id="eatin" name="eatin" checked="">
                            <label for="eatin">なし</label>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
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
                          {{ Form::text('in_charge_copied'.$key, $request->cp_master_in_charge,['class'=>'form-control'] ) }}
                        </td>
                      </tr>
                      <tr>
                        <td class="table-active"><label for="mobilePhone">携帯番号</label></td>
                        <td>
                          {{ Form::text('tel_copied'.$key, $request->cp_master_tel,['class'=>'form-control'] ) }}
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
                            {{Form::radio('email_flag_copied'.$key, 1, $request->cp_master_email_flag==1?true:false, ['id' => 'email_flag_copied'.$key, 'class' => 'form-check-input'])}}
                            {{Form::label('email_flag_copied'.$key,'有り',['class'=>'mr-5'])}}
                            {{Form::radio('email_flag_copied'.$key, 0, $request->cp_master_email_flag==0?true:false, ['id' => 'no_email_flag_copied'.$key, 'class' => 'form-check-input'])}}
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
                        {{ Form::text('cost_copied'.$key, $request->cp_master_cost,['class'=>'form-control'] ) }}%
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
                    <tr>
                      <td>
                        <p>
                          <input type="checkbox" id="discount" checked="">
                          <label for="discount">割引条件</label>
                        </p>
                        {{ Form::textarea('discount_condition_copied'.$key, $request->cp_master_discount_condition,['class'=>'form-control'] ) }}
                      </td>
                    </tr>
                    <tr class="caution">
                      <td>
                        <label for="caution">注意事項</label>
                        {{ Form::textarea('attention_copied'.$key, $request->cp_master_attention,['class'=>'form-control'] ) }}
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label for="adminNote">管理者備考</label>
                        {{ Form::textarea('admin_details_copied'.$key, $request->cp_master_admin_details,['class'=>'form-control'] ) }}
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- 右側の項目 終わり-------------------------------------------------- -->
            </div>
            <div class="btn_wrapper">
              <p class="text-center"><a class="more_btn_lg" href="">請求に反映する</a></p>
            </div>
            <!-- 請求セクション------------------------------------------------------------------- -->
            <section class="bill-wrap section-wrap">
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
                            {{-- {{number_format($masters)}} --}}
                            円</dd>
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
                        @if ($result[0][$key])
                        <tbody class="venue_head">
                          <tr>
                            <td>内容</td>
                            <td>単価</td>
                            <td>数量</td>
                            <td>金額</td>
                          </tr>
                        </tbody>
                        @if ($result[0][$key][1]){{--延長があるなら--}}
                        <tbody class="{{'venue_main'.$key}}">
                          <tr>
                            <td>
                              {{ Form::text('venue_breakdown_item0_copied'.$key, "会場料金",['class'=>'form-control', 'readonly'] ) }}
                            </td>
                            <td>
                              {{ Form::text('venue_breakdown_cost0_copied'.$key, $result[0][$key][0],['class'=>'form-control', 'readonly'] ) }}
                            </td>
                            <td>
                              {{ Form::text('venue_breakdown_count0_copied'.$key, $result[0][$key][3]-$result[0][$key][4],['class'=>'form-control', 'readonly'] ) }}
                            </td>
                            <td>
                              {{ Form::text('venue_breakdown_subtotal0_copied'.$key, $result[0][$key][0],['class'=>'form-control', 'readonly'] ) }}
                            </td>
                          </tr>
                          <tr>
                            <td>
                              {{ Form::text('venue_breakdown_item1_copied'.$key, "延長料金",['class'=>'form-control', 'readonly'] ) }}
                            </td>
                            <td>
                              {{ Form::text('venue_breakdown_cost1_copied'.$key, $result[0][$key][1],['class'=>'form-control', 'readonly'] ) }}
                            </td>
                            <td>
                              {{ Form::text('venue_breakdown_count1_copied'.$key, $result[0][$key][4],['class'=>'form-control', 'readonly'] ) }}
                            </td>
                            <td>
                              {{ Form::text('venue_breakdown_subtotal1_copied'.$key, $result[0][$key][1],['class'=>'form-control', 'readonly'] ) }}
                            </td>
                          </tr>
                        </tbody>
                        <tbody class="{{'venue_result'.$key}}">
                          <tr>
                            <td colspan="2"></td>
                            <td colspan="2">合計
                              {{ Form::text('venue_price'.$key,$result[0][$key][2],['class'=>'form-control col-xs-3', 'readonly'] ) }}
                            </td>
                          </tr>
                        </tbody>
                        <tbody class="{{'venue_discount'.$key}}">
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
                        </tbody>
                        @else{{--延長なし。会場料金のみ--}}
                        <tbody class="{{'venue_main'.$key}}">
                          <tr>
                            <td>
                              {{ Form::text('venue_breakdown_item0_copied'.$key, "会場料金",['class'=>'form-control', 'readonly'] ) }}
                            </td>
                            <td>
                              {{ Form::text('venue_breakdown_cost0_copied'.$key, $result[0][$key][0],['class'=>'form-control', 'readonly'] ) }}
                            </td>
                            <td>
                              {{ Form::text('venue_breakdown_count0_copied'.$key, $result[0][$key][3]-$result[0][$key][4],['class'=>'form-control', 'readonly'] ) }}
                            </td>
                            <td>
                              {{ Form::text('venue_breakdown_subtotal0_copied'.$key, $result[0][$key][0],['class'=>'form-control', 'readonly'] ) }}
                            </td>
                          </tr>
                        </tbody>
                        <tbody class="{{'venue_result'.$key}}">
                          <tr>
                            <td colspan="2"></td>
                            <td colspan="2">合計
                              {{ Form::text('venue_price'.$key,$result[0][$key][2],['class'=>'form-control col-xs-3', 'readonly'] ) }}
                            </td>
                          </tr>
                        </tbody>
                        <tbody class="{{'venue_discount'.$key}}">
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
                        </tbody>
                        @endif
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

                    0が料金合計　
                    1が備品breakdown
                    2がserviceのbreakdown
                    3が備品料金
                    4がサービス料金
                    {{-- 以下備品 --}}
                    @if ($result[1][0])
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
                          @foreach ($result[1][1] as $eb_key=>$equipment)
                          <tr>
                            <td>
                              {{ Form::text('equipment_breakdown_item'.$eb_key.'_copied'.$key, $equipment[0],['class'=>'form-control', 'readonly'] ) }}
                            </td>
                            <td>
                              {{ Form::text('equipment_breakdown_cost'.$eb_key.'_copied'.$key, $equipment[1],['class'=>'form-control', 'readonly'] ) }}
                            </td>
                            <td>
                              {{ Form::text('equipment_breakdown_count'.$eb_key.'_copied'.$key, $equipment[2],['class'=>'form-control', 'readonly'] ) }}
                            </td>
                            <td>
                              {{ Form::text('equipment_breakdown_subtotal'.$eb_key.'_copied'.$key, ReservationHelper::numTimesNum($equipment[1],$equipment[2]),['class'=>'form-control', 'readonly'] ) }}
                            </td>
                          </tr>
                          @endforeach
                          @foreach ($result[1][2] as $sb_key=>$service)
                          <tr>
                            <td>
                              {{ Form::text('equipment_breakdown_item'.$sb_key.'_copied'.$key, $service[0],['class'=>'form-control', 'readonly'] ) }}
                            </td>
                            <td>
                              {{ Form::text('equipment_breakdown_cost'.$sb_key.'_copied'.$key, $service[1],['class'=>'form-control', 'readonly'] ) }}
                            </td>
                            <td>
                              {{ Form::text('equipment_breakdown_count'.$sb_key.'_copied'.$key, $service[2],['class'=>'form-control', 'readonly'] ) }}
                            </td>
                            <td>
                              {{ Form::text('equipment_breakdown_subtotal'.$sb_key.'_copied'.$key, ReservationHelper::numTimesNum($service[1],$service[2]),['class'=>'form-control', 'readonly'] ) }}
                            </td>
                          </tr>
                          @endforeach
                          @if ($request->cp_master_luggage_price)
                          <tr>
                            <td>
                              {{ Form::text('luggage_item_copied'.$key, '荷物預かり/返送',['class'=>'form-control', 'readonly'] ) }}
                            </td>
                            <td>
                              {{ Form::text('luggage_cost_copied'.$key, $request->cp_master_luggage_price,['class'=>'form-control', 'readonly'] ) }}
                            </td>
                            <td>
                              {{ Form::text('luggage_count_copied'.$key, 1,['class'=>'form-control', 'readonly'] ) }}
                            </td>
                            <td>
                              {{ Form::text('luggage_subtotal_copied'.$key, $request->cp_master_luggage_price,['class'=>'form-control', 'readonly'] ) }}
                            </td>
                          </tr> @endif
                        </tbody>
                        <tbody class="{{'equipment_result'.$key}}">
                          <tr>
                            <td colspan="2"></td>
                            <td colspan="2">合計
                              {{ Form::text('equipment_price'.$key, ((int)$result[1][0])+((int)$request->cp_master_luggage_price),['class'=>'form-control', 'readonly'] ) }}
                            </td>
                          </tr>
                        </tbody>
                        <tbody class="{{'equipment_discount'.$key}}">
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
                        </tbody>
                      </table>
                    </div>
                    @endif

                    {{-- 以下、レイアウト --}}
                    @if ($result[2])
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
                          @if ($result[2][0])
                          <tr>
                            <td>
                              {{ Form::text('layout_prepare_item_copied'.$key, "レイアウト準備料金",['class'=>'form-control', 'readonly'] ) }}
                            </td>
                            <td>
                              {{ Form::text('layout_prepare_cost_copied'.$key, $result[2][0],['class'=>'form-control', 'readonly'] )}}
                            </td>
                            <td>
                              {{ Form::text('layout_prepare_count_copied'.$key, 1,['class'=>'form-control', 'readonly'] )}}
                            </td>
                            <td>
                              {{ Form::text('layout_prepare_subtotal_copied'.$key, $result[2][0],['class'=>'form-control', 'readonly'] )}}
                            </td>
                          </tr>
                          @endif
                          @if ($result[2][1])
                          <tr>
                            <td>
                              {{ Form::text('layout_clean_item_copied'.$key, "レイアウト準備料金",['class'=>'form-control', 'readonly'] ) }}
                            </td>
                            <td>
                              {{ Form::text('layout_clean_cost_copied'.$key, $result[2][1],['class'=>'form-control', 'readonly'] )}}
                            </td>
                            <td>
                              {{ Form::text('layout_clean_count_copied'.$key, 1,['class'=>'form-control', 'readonly'] )}}
                            </td>
                            <td>
                              {{ Form::text('layout_clean_subtotal_copied'.$key, $result[2][1],['class'=>'form-control', 'readonly'] )}}
                            </td>
                          </tr>
                          @endif
                        </tbody>
                        <tbody class="{{'layout_result'.$key}}">
                          <tr>
                            <td colspan="2"></td>
                            <td colspan="2">合計
                              {{-- {{ Form::text('layout_price',$layouts_details[2] ,['class'=>'form-control', 'readonly'] ) }}
                              --}}
                            </td>
                          </tr>
                        </tbody>
                        <tbody class="{{'layout_discount'.$key}}">
                          <tr>
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
                        </tbody>
                      </table>
                    </div>
                    @endif


                    {{-- 以下、その他 --}}
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
                            <td>追加/削除</td>
                          </tr>
                        </tbody>
                        <tbody class="others_main">
                          <tr>
                            <td>
                              {{-- {{ Form::text('others_input_item0', '',['class'=>'form-control'] ) }} --}}
                            </td>
                            <td>
                              {{-- {{ Form::text('others_input_cost0', '',['class'=>'form-control'] ) }} --}}
                            </td>
                            <td>
                              {{-- {{ Form::text('others_input_count0', '',['class'=>'form-control'] ) }} --}}
                            </td>
                            <td>
                              {{-- {{ Form::text('others_input_subtotal0', '',['class'=>'form-control', 'readonly'] ) }}
                              --}}
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
                              {{-- {{ Form::text('others_price', '',['class'=>'form-control', 'readonly'] ) }} --}}
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    {{-- 以下、総合計 --}}
                    <div class="bill_total">
                      <table class="table">
                        <tr>
                          <td>小計：</td>
                          <td>
                            {{-- {{ Form::text('master_subtotal',$masters ,['class'=>'form-control text-right', 'readonly'] ) }}
                            --}}
                          </td>
                        </tr>
                        <tr>
                          <td>消費税：</td>
                          <td>
                            {{-- {{ Form::text('master_tax',ReservationHelper::getTax($masters) ,['class'=>'form-control text-right', 'readonly'] ) }}
                            --}}
                          </td>
                        </tr>
                        <tr>
                          <td class="font-weight-bold">合計金額</td>
                          <td>
                            {{-- {{ Form::text('master_total',ReservationHelper::taxAndPrice($masters) ,['class'=>'form-control text-right', 'readonly'] ) }}
                            --}}
                          </td>
                        </tr>
                      </table>
                    </div>

                  </div>
                  <!-- 請求内訳 終わり ------------------------------------------------------>
                </div>
              </div>
            </section>
            <div class="section-wrap">
              <table class="table table-bordered">
                <thead>
                  <tr class="bg-green">
                    <td colspan="2">
                      <p>合計請求額</p>
                    </td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="table-active"><label for="venueFee">会場料</label></td>
                    <td class="text-right">
                      5,300円
                    </td>
                  </tr>
                  <tr>
                    <td class="table-active"><label for="serviceFee">備品その他</label></td>
                    <td class="text-right">
                      5,300円
                    </td>
                  </tr>
                  <tr>
                    <td class="table-active"><label for="layoutFee">レイアウト変更</label></td>
                    <td class="text-right">
                      5,300円
                    </td>
                  </tr>
                  <tr>
                    <td class="table-active"><label for="layoutFee">キャンセル料</label></td>
                    <td class="text-right">
                      5,300円
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2" class="text-right">
                      <p><span class="font-weight-bold">小計</span>7,200円</p>
                      <p><span>消費税</span>720円</p>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2" class="text-right"><span class="font-weight-bold">請求総額</span>7,200円</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </dt>
          <!-- /.card-body -->
        </dl>
        <!-- /.card -->
      </div>
      <!-- 仮押さえ一括 タブ終わり-->
    </section>

    @endforeach


    <!-- コピー作成用フィールド ------------------------------------------------------------->

    <!-- 詳細選択画面--終わり------------------------------------------------　 -->

    <div class="col-12 mt-5">
      <div class="d-flex bg-green py-2 px-1">
        <h4>合計請求額</h4>
        <p class="ml-2">(<span>3</span>件分)</p>
      </div>
      <table class="table table-bordered">
        <tbody>
          <tr>
            <td class="table-active"><label for="venueFee">会場料</label></td>
            <td class="text-right">
              5,300円
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="serviceFee">備品その他</label></td>
            <td class="text-right">
              5,300円
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="layoutFee">レイアウト変更</label></td>
            <td class="text-right">
              5,300円
            </td>
          </tr>
          <tr>
            <td colspan="2" class="text-right">
              <p><span class="font-weight-bold">小計</span>7,200円</p>
              <p><span>消費税</span>720円</p>
            </td>
          </tr>
          <tr>
            <td colspan="2" class="text-right"><span class="font-weight-bold">請求総額</span>7,200円</td>
          </tr>
        </tbody>
      </table>
    </div>

    <ul class="d-flex col-12 justify-content-around mt-5">
      <li>
        <p><a class="more_btn_lg" href="">詳細にもどる</a></p>
      </li>
      <li>
        <p><a class="more_btn_lg" href="">更新する</a></p>
      </li>
    </ul>
  </div>
</div>


@endsection