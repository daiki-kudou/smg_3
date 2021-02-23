@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>

<h1>単発　仮抑え　仲介会社　詳細入力画面</h1>

{{ Form::open(['url' => 'admin/pre_agent_reservations/calculate', 'method'=>'POST', 'id'=>'']) }}
@csrf
<div class="selected_user mt-5">
  <table class="table table-bordered" style="table-layout: fixed;">
    <thead>
      <tr>
        <th>仲介会社情報</th>
        <th colspan="3">顧客ID：<p class="user_id d-inline">{{$request->user_id}}</p>
        </th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="table-active">会社名・団体名</td>
        <td colspan="3">
          <p class="company">
            {{ReservationHelper::getAgentCompany($request->agent_id)}}
          </p>
        </td>
      </tr>
      <tr>
        <td class="table-active">担当者指名</td>
        <td>
          <p class="person">
            {{ReservationHelper::getAgentPerson($request->agent_id)}}
          </p>
        </td>
        <td class="table-active">メールアドレス</td>
        <td>
          <p class="email">
            {{ReservationHelper::getAgentEmail($request->agent_id)}}
          </p>
        </td>
      </tr>
      <tr>
        <td class="table-active">携帯番号</td>
        <td>
          <p class="mobile">
            {{ReservationHelper::getAgentMobile($request->agent_id)}}
          </p>
        </td>
        <td class="table-active">固定電話</td>
        <td>
          <p class="tel">
            {{ReservationHelper::getAgentTel($request->agent_id)}}
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


{{-- 以下、詳細入力 --}}
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
              {{ Form::text('reserve_date', $request->pre_date0,['class'=>'form-control', 'readonly'] ) }}
              <p class="is-error-reserve_date" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">会場</td>
            <td>
              {{ Form::text('', ReservationHelper::getVenue($request->pre_venue0),['class'=>'form-control', 'readonly'] ) }}
              {{ Form::hidden('venue_id', $request->pre_venue0,['class'=>'form-control', 'readonly'] ) }}

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
                {{ Form::text('', date('H:i',strtotime($request->pre_enter0)),['class'=>'form-control', 'readonly'] ) }}
                {{ Form::hidden('enter_time', $request->pre_enter0,['class'=>'form-control', 'readonly'] ) }}
                <p class="is-error-enter_time" style="color: red"></p>
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">退室時間</td>
            <td>
              <div>
                {{ Form::text('', date('H:i',strtotime($request->pre_leave0)),['class'=>'form-control', 'readonly'] ) }}
                {{ Form::hidden('leave_time', $request->pre_leave0,['class'=>'form-control', 'readonly'] ) }}

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
              <div>
                <select name="event_start" id="event_start" class="form-control">
                  {!!ReservationHelper::timeOptions()!!}
                </select>
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント終了時間</td>
            <td>
              <div>
                <select name="event_finish" id="event_finish" class="form-control">
                  {!!ReservationHelper::timeOptions()!!}
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
            @foreach ($venue->getEquipments() as $key=>$equipment)
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
            @foreach ($venue->getServices() as $key=>$service)
            <tr>
              <td class="table-active">
                {{$service->item}}
              </td>
              <td>
                <div class="form-check form-check-inline">
                  {{Form::radio('services_breakdown'.$key, 1, false , ['id' => 'service'.$key.'on', 'class' => 'form-check-input'])}}
                  {{Form::label('service'.$key.'on', "有り")}}
                  {{Form::radio('services_breakdown'.$key, 0, true, ['id' => 'services_breakdown'.$key.'off', 'class' => 'form-check-input'])}}
                  {{Form::label('services_breakdown'.$key.'off', "無し")}}
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
                  {{Form::radio('layout_prepare', 1, false , ['id' => 'layout_prepare', 'class' => 'form-check-input'])}}
                  {{Form::label('layout_prepare', "有り")}}
                  {{Form::radio('layout_prepare', 0, true, ['id' => 'no_layout_prepare', 'class' => 'form-check-input'])}}
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
                  {{Form::radio('layout_clean', 1, false, ['id' => 'layout_clean', 'class' => 'form-check-input'])}}
                  {{Form::label('layout_clean', "有り")}}
                  {{Form::radio('layout_clean', 0, true, ['id' => 'no_layout_clean', 'class' => 'form-check-input'])}}
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
                {{ Form::text('luggage_count', '',['class'=>'form-control'] ) }}
              </td>
            </tr>
            <tr>
              <td>事前荷物の到着日<br>午前指定のみ</td>
              <td>
                {{ Form::text('luggage_arrive', '',['class'=>'form-control', 'id'=>'datepicker1'] ) }}
              </td>
            </tr>
            <tr>
              <td>事後返送する荷物</td>
              <td>
                {{ Form::text('luggage_return', '',['class'=>'form-control'] ) }}
              </td>
            </tr>
            <tr>
              <td>荷物預かり/返送<br>料金</td>
              <td>
                {{ Form::text('luggage_price', '',['class'=>'form-control'] ) }}
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
              {{ Form::text('enduser_charge', '',['class'=>'form-control'] ) }}円
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
              {{ Form::textarea('attention', '',['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
            </td>
          </tr>
          <tr>
            <td>
              <label for="userNote">顧客情報の備考</label>
              {{ Form::textarea('user_details', '',['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
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

<div class="submit_btn">
  <div class="d-flex justify-content-center">
    {{-- 単発仮抑えか？一括仮抑えか？ --}}
    {{ Form::hidden('judge_count', 1 ) }}
    {{-- ユーザー --}}
    {{ Form::hidden('agent_id', $request->agent_id ) }}
    {{Form::submit('計算する', ['class'=>'btn btn-primary btn-lg ', 'id'=>'check_submit'])}}
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




{{Form::close()}}



@endsection