@extends('layouts.admin.app')
@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
{{-- <script src="{{ asset('/js/ajax.js') }}"></script> --}}
<script src="{{ asset('/js/validation.js') }}"></script>




{{-- <div class="container-field mt-3">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">{{ Breadcrumbs::render(Route::currentRouteName()) }}</li>
</ol>
</nav>
</div>
<h1 class="mt-3 mb-5">予約　新規登録</h1>
<hr>
</div> --}}

<div class="container-field bg-white text-dark">
  <div class="row">
    <div class="col">
      <table class="table table-bordered">
        <tr>
          <td colspan="2">予約情報</td>
        </tr>
        <tr>
          <td class="table-active form_required">利用日</td>
          <td>{{$request->reserve_date}}</td>
        </tr>
        <tr>
          <td class="table-active form_required">会場</td>
          <td>{{ReservationHelper::getVenue($request->venue_id)}}</td>
        </tr>
        <tr>
          <td>料金体系</td>
          <td>{{ReservationHelper::priceSystem($request->price_system)}}</td>
        </tr>
        <tr>
          <td class="table-active form_required">入室時間</td>
          <td>{{$request->enter_time}}</td>
        </tr>
        <tr>
          <td class="table-active form_required">退室時間</td>
          <td>{{$request->leave_time}}</td>
        </tr>
        <tr>
          <td>案内板</td>
          <td>{{$request->board_flag}}</td>
        </tr>
        <tr>
          <td class="table-active">イベント開始時間</td>
          <td>{{$request->event_start}}</td>
        </tr>
        <tr>
          <td class="table-active">イベント終了時間</td>
          <td>{{$request->event_finish}}</td>
        </tr>
        <tr>
          <td class="table-active">イベント名称1</td>
          <td>{{$request->event_name1}}</td>
        </tr>
        <tr>
          <td class="table-active">イベント名称2</td>
          <td>{{$request->event_name2}}</td>
        </tr>
        <tr>
          <td class="table-active">主催者名</td>
          <td>{{$request->event_owner}}</td>
        </tr>
      </table>
      <div class="equipemnts">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th colspan="2">
                <div class="d-flex justify-content-between align-items-center">
                  有料備品
                  <i class="fas fa-plus icon_plus hide"></i>
                  <i class="fas fa-minus icon_minus"></i>
                </div>
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach ($equipments as $key=>$equipment)
            <tr>
              <td>{{$equipment->item}}</td>
              <td>{{$s_equipment[$key]}}</td>
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
                  <i class="fas fa-plus icon_plus hide"></i>
                  <i class="fas fa-minus icon_minus"></i>
                </div>
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach ($services as $key=>$service)
            <tr>
              <td>{{$service->item}}</td>
              <td>{{$s_services[$key]==1?"有り":"無し"}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class='layouts'>
        <table class='table table-bordered' style="table-layout:fixed;">
          <thead>
            <tr>
              <th colspan='2'>レイアウト</th>
            </tr>
          </thead>
          <tbody>
            @if ($request->layout_prepare)
            <tr>
              <td>レイアウト準備</td>
              <td>{{$request->layout_prepare==1?"有り":"無し"}}</td>
            </tr>
            @endif
            @if ($request->layout_clean)
            <tr>
              <td>レイアウト準備</td>
              <td>{{$request->layout_clean==1?"有り":"無し"}}</td>
            </tr>
            @endif
          </tbody>
        </table>
      </div>
      <div class='luggage'>
        <table class='table table-bordered' style="table-layout:fixed;">
          <thead>
            <tr>
              <th colspan='2'>荷物預かり</th>
            </tr>
          </thead>
          <tbody>
            @if ($request->luggage_count)
            <tr>
              <td>事前に預かる荷物<br>（個数）</td>
              <td>{{$request->luggage_count}}</td>
            </tr>
            @endif
            @if ($request->luggage_arrive)
            <tr>
              <td>事前荷物の到着日<br>午前指定のみ</td>
              <td>{{$request->luggage_arrive}}</td>
            </tr>
            @endif
            @if ($request->luggage_return)
            <tr>
              <td>事後返送する荷物</td>
              <td>{{$request->luggage_return}}</td>
            </tr>
            @endif
            @if ($request->luggage_price)
            <tr>
              <td>荷物預かり/返送<br>料金</td>
              <td>{{$request->luggage_price}}</td>
            </tr>
            @endif
          </tbody>
        </table>
      </div>

    </div>
    {{-- 右側 --}}
    <div class="col">
      <div class="client_mater">　
        <table class="table table-bordered name-table" style="table-layout:fixed;">
          <tr>
            <td colspan="2">
              <div class="d-flex align-items-center justify-content-between">
                <p class="title-icon">
                  <i class="far fa-id-card fa-2x fa-fw"></i>顧客情報
                </p>
                <p><a class="more_btn bg-green" href="">顧客詳細</a></p>
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="user_id" class=" form_required">会社名/団体名</label></td>
            <td>{{ReservationHelper::getCompany($request->user_id)}}</td>
          </tr>
          <tr>
            <td class="table-active"><label for="name" class=" form_required">担当者氏名<br></label></td>
            <td>{{ReservationHelper::getPersonName($request->user_id)}}</td>
          </tr>
        </table>
        <table class="table table-bordered oneday-table" style="table-layout:fixed;">
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-user-check fa-2x fa-fw"></i>当日の連絡できる担当者
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="ondayName" class=" form_required">氏名</label></td>
            <td>{{$request->in_charge}}</td>
          </tr>
          <tr>
            <td class="table-active"><label for="mobilePhone" class=" form_required">携帯番号</label></td>
            <td>{{$request->tel}}</td>
          </tr>
        </table>
      </div>
      <table class="table table-bordered mail-table" style="table-layout:fixed;">
        <tr>
          <td colspan="2">
            <p class="title-icon">
              <i class="fas fa-envelope fa-2x fa-fw"></i>利用後の送信メール
            </p>
          </td>
        </tr>
        <tr>
          <td class="table-active"><label for="email_flag">送信メール</label></td>
          <td>{{$request->email_flag==1?"有り":"無し"}}</td>
        </tr>
      </table>
      <table class="table table-bordered sale-table" style="table-layout:fixed;">
        <tr>
          <td colspan="2">
            <p class="title-icon">
              <i class="fas fa-yen-sign fa-2x fa-fw"></i>売上原価（提携会場を選択した場合、提携会場で設定した原価率が適応されます）
            </p>
          </td>
        </tr>
        <tr>
          <td class="table-active"><label for="cost">原価率</label></td>
          <td>{{$request->cost}}%</td>
        </tr>
      </table>
      <table class="table table-bordered note-table">
        <tr>
          <td colspan="2">
            <p class="title-icon">
              <i class="fas fa-envelope fa-2x fa-fw"></i>備考
            </p>
          </td>
        </tr>
        <tr>
          <td>
            <input type="checkbox" id="discount" checked>
            <label for="discount">割引条件</label>
            <textarea name="" id="" cols="30" rows="10" class="form-control">{{$request->discount_condition}}</textarea>
          </td>
        </tr>
        <tr class="caution">
          <td>
            <label for="caution">注意事項</label>
            <textarea name="" id="" cols="30" rows="10" class="form-control">{{$request->attention}}</textarea>
          </td>
        </tr>
        <tr>
          <td>
            <label for="userNote">顧客情報の備考</label>
            <textarea name="" id="" cols="30" rows="10" class="form-control">{{$request->user_details}}</textarea>
          </td>
        </tr>
        <tr>
          <td>
            <label for="adminNote">管理者備考</label>
            <textarea name="" id="" cols="30" rows="10" class="form-control">{{$request->admin_details}}</textarea>
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>

{{-- 丸岡さんカスタム --}}
<section class="bill-wrap section-wrap">
  <div class="bill-bg">
    <div class="bill-box" style="border: solid 1px rgba(0,0,0,0.2);">
      <div class="venue_price_details">
        <table class="table table-bordered" style="table-layout:fixed;">
          <thead>
            <tr>
              <th colspan='4' style="background: #35A7A7; color:white;">会場料</th>
            </tr>
            <tr>
              <th colspan='1'>
                会場料金
              </th>
              <th colspan='1'>
                延長料金
              </th>
              <th colspan='2'>
                会場料金合計
              </th>
            </tr>
            <tr>
              <th colspan="1">
                割引率
              </th>
              <th colspan="1">割引金額
              </th>
              <th colspan="1">
                割引料金
              </th>
              <th colspan="1">
                割引率
              </th>
            </tr>
            <tr>
              <th colspan='4'>割引後　会場料金合計
              </th>
            </tr>
            <tr>
              <th colspan=4 style="background: gray; color:white;">料金内訳</th>
            </tr>
            <tr style="background: #B2B2B2; color:white;">
              <th>内容</th>
              <th>単価</th>
              <th>数量</th>
              <th>小計</th>
            </tr>
          </thead>
          <tbody class="table table-striped"></tbody>
        </table>
      </div>
      <table style="table-layout:fixed;" class="table table-bordered mb-0">
        <tr>
          <td>小計</td>
          <td>消費税</td>
          <td>請求総額</td>
        </tr>
      </table>
    </div>

    <div class="hand_input hide">
      <h3 style="font-weight: bold;font-size: 16px;background: #840A01;color: #fff;margin-bottom: 0;padding: 0.8em;">
        会場料（手入力）</h3>
      <div class="hand_input_details">
        <table class="table table-bordered">
          <thead>
            <tr>
              <td>内容</td>
              <td>単価</td>
              <td>数量</td>
              <td>金額</td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>会場料</td>
              <td>
              </td>
              <td>
              </td>
              <td>
              </td>
            </tr>
            <tr>
              <td>延長料金</td>
              <td>
              </td>
              <td>
              </td>
              <td>
              </td>
            </tr>
            <tr>
              <td>割引</td>
              <td>
              </td>
              <td>
              </td>
              <td>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="text-right hand_input_result">
          <p>小計
          </p>
          <p>消費税
          </p>
          <p>請求総額
          </p>
        </div>
      </div>
    </div>

    <div class="bill-box" style="border: solid 1px rgba(0,0,0,0.2);">
      <div class="items_equipments">
        <table class="table table-bordered" style="table-layout:fixed;">
          <thead>
            <tr>
              <th colspan='4' style="background: #35A7A7; color:white;">備品その他</th>
            </tr>
            <tr>
              <th colspan='1'>
                有料備品料金
              </th>
              <th colspan='1'>
                有料サービス料金
              </th>
              <th colspan='1'>
                荷物預かり/返送
              </th>
              <th colspan='1'>
                有料備品＆有料サービス合計
              </th>
            </tr>
            <tr>
              <th colspan="2">
                割引料金
              </th>
              <th colspan="2">
                割引率
              </th>
            </tr>
            <tr>
              <th colspan='4'>割引後　有料備品＆有料サービス合計
              </th>
            </tr>
            <tr>
              <th colspan=4 style="background: gray; color:white;">料金内訳</th>
            </tr>
            <tr style="background: #B2B2B2; color:white;">
              <th>内容</th>
              <th>単価</th>
              <th>数量</th>
              <th>小計</th>
            </tr>
          </thead>
          <tbody class="table table-striped"></tbody>
        </table>
      </div>
      <table style="table-layout:fixed;" class="table table-bordered mb-0">
        <tr>
          <td>小計</td>
          <td>消費税</td>
          <td>請求総額</td>
        </tr>
      </table>
    </div>

    <div class="bill-box" style="border: solid 1px rgba(0,0,0,0.2);">
      <div class="selected_layouts">
        <table class="table table-bordered" style="table-layout:fixed;">
          <thead>
            <tr>
              <th colspan='4' style="background: #35A7A7; color:white;">レイアウト</th>
            </tr>
            <tr>
              <th colspan='1'>
                レイアウト準備料金
              </th>
              <th colspan='1'>
                レイアウト片付料金
              </th>
              <th colspan='1'>
                レイアウト変更合計
              </th>
            </tr>
            <tr>
              <th colspan="2">
                割引料金
              </th>
              <th colspan="2">
                割引率
              </th>
            </tr>
            <tr>
              <th colspan='4'>割引後レイアウト変更合計
              </th>
            </tr>
            <tr>
              <th colspan=4 style="background: gray; color:white;">料金内訳</th>
            </tr>
            <tr style="background: #B2B2B2; color:white;">
              <th>内容</th>
              <th>単価</th>
              <th>数量</th>
              <th>小計</th>
            </tr>
          </thead>
          <tbody class="table table-striped"></tbody>
        </table>
      </div>
      <table style="table-layout:fixed;" class="table table-bordered mb-0">
        <tr>
          <td>小計</td>
          <td>消費税</td>
          <td>請求総額
          </td>
        </tr>
      </table>
    </div>






    <div class="bill-box" style="border: solid 1px rgba(0,0,0,0.2);">
      <div class="all_total">
        <table class="table table-bordered" style="table-layout:fixed;">
          <thead>
            <tr>
              <th colspan='2' style="background: #35A7A7; color:white;">合計請求額</th>
            </tr>
          </thead>
          <tbody class="table table-striped">
            <tr>
              <td>会場料</td>
              <td></td>
            </tr>
            <tr>
              <td>備品その他</td>
              <td></td>
            </tr>
            <tr>
              <td>レイアウト変更</td>
              <td></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>



  </div>
</section>


{{ Form::hidden('payment_limit',isset($request)?$request->payment_limit:'')}}
{{ Form::hidden('paid', isset($request)?$request->paid:0 ) }} {{--デフォ0で未入金--}}
{{ Form::hidden('reservation_status', isset($request)?$request->reservation_status:1 ) }}
{{-- ※注意　管理者からの予約は予約ステータスが1。予約確認中 --}}
{{ Form::hidden('double_check_status', isset($request)?$request->double_check_status:0 ) }}

{{ Form::hidden('bill_company', isset($request)?$request->bill_company:'' ) }}
{{ Form::hidden('bill_person', isset($request)?$request->bill_person:'' ) }}
{{ Form::hidden('bill_created_at', isset($request)?$request->bill_created_at:date('Y-m-d')) }}
{{ Form::hidden('bill_pay_limit', isset($request)?$request->bill_pay_limit:'' ) }}

{{Form::submit('送信', ['class'=>'btn btn-primary mx-auto', 'id'=>'check_submit'])}}

{{Form::close()}}





@endsection