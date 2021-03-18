@extends('layouts.admin.app')
@section('content')
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/admin/validation.js') }}"></script>
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">

<h2 class="mt-3 mb-3">仮押え　詳細入力画面</h2>
<hr>

{{ Form::open(['url' => 'admin/pre_reservations/calculate', 'method'=>'POST', 'id'=>'pre_reservationSingleCheckForm']) }}
@csrf

<section class="mt-5">
  <div class="selected_user">
    <table class="table table-bordered" style="table-layout: fixed;">
      <thead>
        <tr>
          <th>顧客情報</th>
          <th colspan="3">顧客ID：<p class="user_id d-inline">{{$request->user_id}}</p>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="table-active">会社名・団体名</td>
          <td colspan="3">
            <p class="company">{{$request->user_id==999?"":ReservationHelper::getCompany($request->user_id)}}</p>
          </td>
        </tr>
        <tr>
          <td class="table-active">担当者氏名</td>
          <td>
            <p class="person">{{$request->user_id==999?"":ReservationHelper::getPersonName($request->user_id)}}</p>
          </td>
          <td class="table-active">メールアドレス</td>
          <td>
            <p class="email">{{$request->user_id==999?"":ReservationHelper::getPersonEmail($request->user_id)}}</p>
          </td>
        </tr>
        <tr>
          <td class="table-active">携帯番号</td>
          <td>
            <p class="mobile">{{$request->user_id==999?"":ReservationHelper::getPersonMobile($request->user_id)}}</p>
          </td>
          <td class="table-active">固定電話</td>
          <td>
            <p class="tel">{{$request->user_id==999?"":ReservationHelper::getPersonTel($request->user_id)}}</p>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="unknown_user mt-3">
    <table class="table table-bordered" style="table-layout: fixed;">
      <thead>
        <tr>
          <th colspan="4">仮で入力する顧客情報</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="table-active">会社・団体名(仮)</td>
          <td>
            {{ Form::text('unknown_user_company', ($request->unknown_user_company),['class'=>'form-control', 'readonly'] ) }}
          </td>
          <td class="table-active">担当者名(仮)</td>
          <td>
            {{ Form::text('unknown_user_name', ($request->unknown_user_name),['class'=>'form-control', 'readonly'] ) }}
          </td>
        </tr>
        <tr>
          <td class="table-active">携帯番号</td>
          <td>
            {{ Form::text('unknown_user_mobile', ($request->unknown_user_mobile),['class'=>'form-control', 'readonly'] ) }}
          </td>
          <td class="table-active">固定電話</td>
          <td>
            {{ Form::text('unknown_user_tel', ($request->unknown_user_tel),['class'=>'form-control', 'readonly'] ) }}
          </td>
        </tr>
        <tr>
          <td class="table-active">メールアドレス</td>
          <td>
            {{ Form::text('unknown_user_email', ($request->unknown_user_email),['class'=>'form-control', 'readonly'] ) }}
          </td>
        </tr>
      </tbody>
    </table>
  </div>


  {{-- 以下、詳細入力 --}}
  <div class="container-field text-dark mt-5 mb-5">
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
                {{ Form::text('reserve_date', $request->pre_date0,['class'=>'form-control', 'readonly'] ) }}
              </td>
            </tr>
            <tr>
              <td class="table-active">会場</td>
              <td>
                {{ Form::text('', ReservationHelper::getVenue($request->pre_venue0),['class'=>'form-control', 'readonly'] ) }}
                {{ Form::hidden('venue_id', $request->pre_venue0,['class'=>'form-control', 'readonly'] ) }}
                <div class="price_selector">
                  <div>
                    <small>※料金体系を選択してください</small>
                  </div>
                  <div class="price_radio_selector">
                    <div class="d-flex justfy-content-start align-items-center">
                      {{ Form::radio('price_system', 1, true, ['class'=>'mr-2', 'id'=>'price_system_radio1']) }}
                      {{Form::label('price_system_radio1','通常（枠貸）')}}
                    </div>
                    <div class="d-flex justfy-content-start align-items-center">
                      {{ Form::radio('price_system', 2, false, ['class'=>'mr-2', 'id'=>'price_system_radio2']) }}
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
                  {{ Form::text('', date('H:i',strtotime($request->pre_enter0)),['class'=>'form-control', 'readonly'] ) }}
                  {{ Form::hidden('enter_time', $request->pre_enter0,['class'=>'form-control', 'readonly'] ) }}
                </div>
              </td>
            </tr>
            <tr>
              <td class="table-active">退室時間</td>
              <td>
                <div>
                  {{ Form::text('', date('H:i',strtotime($request->pre_leave0)),['class'=>'form-control', 'readonly'] ) }}
                  {{ Form::hidden('leave_time', $request->pre_leave0,['class'=>'form-control', 'readonly'] ) }}
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
                  {{Form::radio('board_flag',1,false,['id'=>'board_flag'])}}
                  {{Form::label('board_flag',"有り")}}
                </p>
                <p>
                  {{Form::radio('board_flag',0,true,['id'=>'no_board_flag'])}}
                  {{Form::label('no_board_flag',"無し")}}
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
                  @for ($start = 0*2; $start <=23*2; $start++) <option value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))<$request->pre_enter0)
                    disabled
                    @elseif(date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))>$request->pre_leave0)
                    disabled
                    @endif
                    >
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
                  @for ($start = 0*2; $start <=23*2; $start++) <option value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))>$request->pre_leave0)
                    disabled
                    @elseif(date("H:i:s",strtotime("00:00 +". $start * 30 ." minute"))<$request->pre_enter0)
                      disabled
                      @endif
                      >
                      {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}</option>
                      @endfor
                </select>
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント名称1</td>
            <td>
              {{ Form::text('event_name1','',['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント名称2</td>
            <td>
              {{ Form::text('event_name2', '',['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active">主催者名</td>
            <td>
              {{ Form::text('event_owner', '',['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
            </td>
          </tr>
        </table>

        <div class="equipemnts">
          <table class="table table-bordered" style="table-layout: fixed;">
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
              @foreach ($equipments as $key=>$equipment)
              <tr>
                <td class="table-active">
                  {{$equipment->item}}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown'.$key, '',['class'=>'form-control'] ) }}
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
                    <i class="fas fa-hand-holding-heart icon-size fa-fw"></i>有料サービス
                  </p>
                </th>
              </tr>
            </thead>
            <tbody class="accordion-wrap">
              @foreach ($services as $key=>$service)
              <tr>
                <td class="table-active">
                  {{$service->item}}
                </td>
                <td>
                  <div class="radio-box">
                    <p>
                    {{Form::radio('services_breakdown'.$key, 1, false , ['id' => 'service'.$key.'on'])}}
                    <label for="{{'service'.$key.'on'}}" class="form-check-label">有り</label>
                    </p>
                    <p>
                    {{Form::radio('services_breakdown'.$key, 0, true, ['id' => 'services_breakdown'.$key.'off'])}}
                    <label for="{{'services_breakdown'.$key.'off'}}" class="form-check-label">無し</label>
                    </p>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        @if ($venue->layout==1)
        <div class="layouts">
          <table class="table table-bordered">
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
              @if ($layouts[0]!=0)
              <tr>
                <td class="table-active">
                  準備
                </td>
                <td>
                  <div class="radio-box">
                    <p>
                    {{Form::radio('layout_prepare', 1, false , ['id' => 'layout_prepare'])}}
                    <label for="{{'layout_prepare'}}" class="form-check-label">有り</label>
                    </p>
                    <p>
                    {{Form::radio('layout_prepare', 0, true, ['id' => 'no_layout_prepare'])}}
                    <label for="{{'no_layout_prepare'}}" class="form-check-label">無し</label>
                    </p>
                  </div>
                </td>
              </tr>
              @endif
              @if ($layouts[1]!=0)
              <tr>
                <td class="table-active">
                  片付
                </td>
                <td>
                  <div class="radio-box">
                    <p>
                    {{Form::radio('layout_clean', 1, false, ['id' => 'layout_clean'])}}
                    <label for='layout_clean' class="form-check-label">有り</label>
                    </p>
                    <p>
                    {{Form::radio('layout_clean', 0, true, ['id' => 'no_layout_clean'])}}
                    <label for='no_layout_clean' class="form-check-label">無し</label>
                    </p>
                  </div>
                </td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>
        @endif

        @if ($venue->luggage_flag==1)
        <div class="luggage">
          <table class="table table-bordered">
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
              @if ($venue->luggage_flag==1)
              <tr>
                <td class="table-active">事前に預かる荷物<br>（個数）</td>
                <td>
                  {{ Form::text('luggage_count', '',['class'=>'form-control'] ) }}
                </td>
              </tr>
              <tr>
                <td class="table-active">事前荷物の到着日<br>午前指定のみ</td>
                <td>
                  {{ Form::text('luggage_arrive', '',['class'=>'form-control', 'id'=>'datepicker9'] ) }}
                </td>
              </tr>
              <tr>
                <td class="table-active">事後返送する荷物</td>
                <td>
                  {{ Form::text('luggage_return', '',['class'=>'form-control'] ) }}
                </td>
              </tr>
              <tr>
                <td class="table-active">荷物預かり/返送<br>料金</td>
                <td>
                  <div class="d-flex align-items-end">
                  {{ Form::text('luggage_price', '',['class'=>'form-control'] ) }}
                  <span class="ml-1">円</span>
                  </div>
                </td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>
        @endif

        @if ($venue->eat_in_flag==1)
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
                  {{Form::radio('eat_in', 1, false , ['id' => 'eat_in'])}}
                  {{Form::label('eat_in',"あり")}}
                </td>
                <td>
                  {{Form::radio('eat_in_prepare', 1, false , ['id' => 'eat_in_prepare', 'disabled'])}}
                  {{Form::label('eat_in_prepare',"手配済み")}}
                  {{Form::radio('eat_in_prepare', 2, false , ['id' => 'eat_in_consider','disabled'])}}
                  {{Form::label('eat_in_consider',"検討中")}}
                </td>
              </tr>
              <tr>
                <td>
                  {{Form::radio('eat_in', 0, true , ['id' => 'no_eat_in'])}}
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
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td colspan="2">
                <p class="title-icon">
                  <i class="fas fa-user-check icon-size" aria-hidden="true"></i>
                  当日の連絡できる担当者
                </p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="ondayName" class=" form_required">氏名</label></td>
              <td>
                {{ Form::text('in_charge', '',['class'=>'form-control'] ) }}
                <p class="is-error-in_charge" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="mobilePhone" class=" form_required">携帯番号</label></td>
              <td>
                {{ Form::text('tel', '',['class'=>'form-control','placeholder' => '半角数字、ハイフンなしで入力してください'] ) }}
                <p class="is-error-tel" style="color: red"></p>
              </td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered mail-table">
          <tbody>
            <tr>
              <td colspan="2">
                <p class="title-icon">
                  <i class="fas fa-envelope icon-size" aria-hidden="true"></i>利用後の送信メール
                </p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="email_flag">送信メール</label></td>
              <td>
                <div class="radio-box">
                  <p>
                    {{Form::radio('email_flag', 1, false , ['id' => 'email_flag'])}}
                    <label for="{{'email_flag'}}" class="form-check-label">有り</label>
                  </p>
                  <p>
                    {{Form::radio('email_flag', 0, true, ['id' => 'no_email_flag'])}}
                    <label for="{{'no_email_flag'}}" class="form-check-label">無し</label>
                </div>
                </p>
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
                <div class="d-flex align-items-center">
                  {{ Form::text('cost', $venue->cost,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
                  <span class="ml-1">%</span>
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
            <tr>
              <td>
                <label for="adminNote">管理者備考</label>
                {{ Form::textarea('admin_details', '',['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
<div class="submit_btn">
  <div class="d-flex justify-content-center">
    {{-- 単発仮押えか？一括仮押えか？ --}}
    {{ Form::hidden('judge_count', 1 ) }}
    {{ Form::hidden('user_id', $request->user_id ) }}
    {{-- 枠料金、時間料金どちらもない場合 --}}
    @if ($venue->getPriceSystems()==0)
    <div class="">
      <p class="d-block">選択された会場は料金が設定されていません。会場管理/料金管理に戻り設定してください</p>
      <a href="{{url('admin/frame_prices')}}" class="btn more_btn_lg mt-5 d-flex justify-content-center">料金管理画面へ</a>
    </div>
    @else
    {{Form::submit('計算する', ['class'=>'btn more_btn_lg mt-5', 'id'=>'check_submit'])}}
    @endif
  </div>
</div>

<div class="spin_btn hide">
  <div class="d-flex justify-content-center">
    <button class="btn btn-primary btn-lg" type="button" disabled>
      <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
      Loading...
    </button>
  </div>
</div>

{{Form::close()}}



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
</script>
@endsection