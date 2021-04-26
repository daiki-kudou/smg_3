@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>


<div class="">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">
          <a href="http://staging-smg2.herokuapp.com/admin/home">ホーム</a>
          予約 詳細
        </li>
      </ol>
    </nav>
  </div>
  <h2 class="mt-3 mb-3">予約 詳細</h2>
  <hr>
  <div class="mb-3 mt-5 align-items-center d-flex justify-content-between">
    @if ($reservation->bills()->first()->reservation_status<3) <div class="text-left">
      {{ Form::model($reservation, ['route' => ['admin.reservations.destroy', $reservation->id], 'method' => 'delete']) }}
      @csrf
      {{ Form::submit('削除', ['class' => 'btn more_btn4']) }}
      {{ Form::close() }}
  </div>
  @endif

  @if ($reservation->user_id>0)
  @if ($reservation->bills()->first()->reservation_status==3)
  <p class="text-right mb-5">
    {{ Form::open(['url' => 'admin/bills/create/', 'method'=>'get', 'class'=>'']) }}
    @csrf
    {{ Form::hidden('reservation_id', $reservation->id ) }}
    {{ Form::submit('追加の請求書を作成する',['class' => 'btn more_btn3']) }}
    {{ Form::close() }}
  </p>
  @endif
  @else
  @if ($reservation->bills()->first()->reservation_status==3)
  <p class="text-right mb-5">
    {{ Form::open(['url' => 'admin/agents_reservations/add_bills', 'method'=>'get', 'class'=>'']) }}
    @csrf
    {{ Form::hidden('reservation_id', $reservation->id ) }}
    {{ Form::submit('追加の請求書を作成する',['class' => 'btn more_btn3']) }}
    {{ Form::close() }}
  </p>
  @endif
  @endif

</div>

@if ($reservation->bills->first()->double_check_status==0)

<div class="alert-box d-flex align-items-center mb-0">
  <p>
    一人目のチェックが終了しています。ダブルチェックを行ってください。
  </p>
</div>　
@endif

<section class="register-wrap mt-2">
  <div class="row">
    <!-- 左側の項目------------------------------------------------------------------------ -->
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
          <td class="table-active"><label for="date">利用日</label></td>
          <td>{{ReservationHelper::formatDate($reservation->reserve_date)}}</td>
        </tr>
        <tr>
          <td class="table-active"><label for="venue">会場</label></td>
          <td>
            <p>{{ReservationHelper::getVenue($reservation->venue_id)}}</p>
            <p>
              {{($reservation->price_system==1?'通常（枠貸）':"アクセア（時間貸）")}}
            </p>
          </td>
        </tr>
        <tr>
          <td class="table-active"><label for="start">入室時間</label></td>
          <td>
            {{ReservationHelper::formatTime($reservation->enter_time)}}
          </td>
        </tr>
        <tr>
          <td class="table-active"><label for="finish">退室時間</label></td>
          <td>
            {{ReservationHelper::formatTime($reservation->leave_time)}}
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
          <td class="table-active"><label for="direction">案内板</label></td>
          <td class="d-flex justify-content-between">
            <p>{{$reservation->board_flag==0?'無し':"要作成"}}</p>
            <p>
              <a href="{{ url('/admin/reservations/generate_pdf', $reservation->id) }}" class="more_btn">案内版出力</a>
            </p>
          </td>
        </tr>
        <tr>
          <td class="table-active"><label for="eventTime">イベント時間記載</label></td>
          <td>
            {{isset($reservation->event_start)&&isset($reservation->event_finish)?"有り":"無し"}}
          </td>
        </tr>
        <tr>
          <td class="table-active"><label for="eventStart">イベント開始時間</label></td>
          <td>
            {{$reservation->event_start}}
          </td>
        </tr>
        <tr>
          <td class="table-active"><label for="eventFinish">イベント終了時間</label></td>
          <td>
            {{$reservation->event_finish}}
          </td>
        </tr>
        <tr>
          <td class="table-active"><label for="eventName1">イベント名称1</label></td>
          <td>{{$reservation->event_name1}}</td>
        </tr>
        <tr>
          <td class="table-active"><label for="eventName2">イベント名称2</label></td>
          <td>{{$reservation->event_name2}}</td>
        </tr>
        <tr>
          <td class="table-active"><label for="organizer">主催者名</label></td>
          <td>{{$reservation->event_owner}}</td>
        </tr>
      </table>


      <table class="table table-bordered equipment-table">
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
          @foreach ($venue->getEquipments() as $equipment)
          @foreach ($reservation->breakdowns()->get() as $breakdown)
          @if ($equipment->item==$breakdown->unit_item)
          <tr>
            <td class="justify-content-between d-flex">
              {{$equipment->item}}({{$equipment->price}}円)×{{$breakdown->unit_count}}
            </td>
          </tr>
          @endif
          @endforeach
          @endforeach
        </tbody>
      </table>

      <table class="table table-bordered service-table">
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
          <tr>
            <td colspan="2">
              <ul class="icheck-primary">
                @foreach ($venue->getServices() as $service)
                @foreach ($reservation->breakdowns()->get() as $breakdown)
                @if ($service->item==$breakdown->unit_item)
                <li>
                  {{$service->item}}({{$service->price}}円)
                </li>
                @endif
                @endforeach
                @endforeach
              </ul>
            </td>
          </tr>
        </tbody>
      </table>


      <div class='layouts'>
        <table class='table table-bordered' style="table-layout:fixed;">
          <thead>
            <tr>
              <th colspan='2'>
                <p class="title-icon">
                  <i class="fas fa-th icon-size fa-fw"></i>レイアウト
                </p>
              </th>
            </tr>
          </thead>

          <tbody>
            <tr>
              <td class="table-active"><label for="prelayout">準備</label></td>
              <td>
                @foreach ($reservation->bills->first()->breakdowns as $breakdown)
                {{$breakdown->unit_item=='レイアウト準備料金'?'あり':''}}
                @endforeach
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="postlayout">片付</label></td>
              <td>
                @foreach ($reservation->breakdowns()->get() as $breakdown)
                {{$breakdown->unit_item=='レイアウト片付料金'?'あり':''}}
                @endforeach
              </td>
            </tr>
          </tbody>
        </table>
      </div>

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
              <td class="table-active"><label for="preDelivery">事前に預かる荷物</label></td>
              <td>
                <ul class="table-cell-box">
                  <li>
                    <p>
                      {{isset($reservation->luggage_count)?'あり':'なし'}}
                    </p>
                  </li>
                  <li>
                    <p>
                      荷物個数：{{isset($reservation->luggage_count)?$reservation->luggage_count:''}}個
                    </p>
                  </li>

                  <li>
                    <p>
                      事前荷物の到着日：
                      {{!empty($reservation->luggage_arrive)?ReservationHelper::formatDate($reservation->luggage_arrive):''}}

                    </p>
                  </li>
                </ul>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="postDelivery">事後返送する荷物</label></td>
              <td>
                <ul class="table-cell-box">
                  <li>
                    <p>
                      {{isset($reservation->luggage_return)?'あり':''}}
                    </p>
                  </li>
                  <li>
                    <p>
                      荷物個数：{{isset($reservation->luggage_return)?$reservation->luggage_return:''}}個
                    </p>
                  </li>
                </ul>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <table class="table table-bordered eating-table">
        <tr>
          <td>
            <p class="title-icon">
              <i class="fas fa-utensils icon-size fa-fw"></i>室内飲食
            </p>
          </td>
        </tr>
        <tr>
          <td>
            ※後ほど修正　なし
          </td>
        </tr>
      </table>
    </div>
    <!-- 左側の項目 終わり-------------------------------------------------- -->
    <!-- 右側の項目-------------------------------------------------- -->
    @if ($reservation->user_id>0)
    @include('admin.reservations.show.user.right_column')
    @else
    @include('admin.reservations.show.agent.right_column')
    @endif

    <!-- 右側の項目 終わり-------------------------------------------------- -->
    <!-- 予約完了後も編集可能な備考欄-------------------------------------------------- -->
    <div class="col-12">
      <table class="table table-bordered note-table">
        <tr>
          <td>
            <p class="title-icon">
              <i class="fas fa-file-alt icon-size"></i>
              <label for="extraNote">予約内容変更履歴</label>
            </p>
          </td>
        </tr>
        <tr>
          <td>
            なし
          </td>
        </tr>
      </table>
    </div>
  </div>
</section>

<section class="mt-5 p-0">
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
            <td style="width: 70%;">
              <div class="d-flex align-items-center justify-content-end">
                <dl class="ttl_box">
                  <dt>合計金額：</dt>
                  <dd class="total_result">{{number_format($reservation->bills()->first()->master_total)}} 円</dd>
                </dl>
                <dl class="ttl_box">
                  <dt>支払い期日：</dt>
                  <dd class="total_result">
                    {{ReservationHelper::formatDate($reservation->bills()->first()->payment_limit)}}
                  </dd>
                </dl>
                @if (!empty($reservation->user))
                @if ($reservation->bills->first()->reservation_status<3) <p>
                  <a href="{{url('admin/reservations/'.$reservation->bills()->first()->id.'/edit')}}"
                    class="btn more_btn">編集</a>
                  </p>
                  @endif
                  @else
                  @if ($reservation->bills->first()->reservation_status<3) <p>
                    {{-- <a href="{{url('admin/agents_reservations/'.$reservation->bills->first()->id.'/edit/')}}"
                    class="btn more_btn">編集</a>
                    </p> --}}
                    {{ Form::open(['url' => "admin/agents_reservations/edit", 'method'=>'post', 'class'=>'']) }}
                    @csrf
                    {{ Form::hidden('reservation_id', $reservation->id ) }}
                    {{ Form::hidden('bill_id', $reservation->bills->first()->id)}}
                    {{ Form::submit('編集',['class' => 'btn more_btn']) }}
                    {{ Form::close() }} @endif
                    @endif
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="bill_status mb-0 pt-3">
      <table class="table">
        <tbody>
          <tr>
            <td>
              <div class="d-flex">
                <p class="bg-status p-2">予約状況</p>
                <p class="border p-2">
                  {{ReservationHelper::judgeStatus($reservation->bills()->first()->reservation_status)}}
                </p>
              </div>
            </td>
            @if ($reservation->bills()->first()->double_check_status==0)
            <td>
              <div class="d-flex">
                <p class="bg-status p-2">一人目チェック</p>
                <p class="border p-2">未
                </p>
              </div>
            </td>
            @elseif ($reservation->bills()->first()->double_check_status==1)
            <td>
              <div class="d-flex">
                <p class="bg-status p-2">一人目チェック</p>
                <p class="border p-2">{{$reservation->bills()->first()->double_check1_name}}</p>
              </div>
            </td>
            <td>
              <div class="d-flex">
                <p class="bg-status p-2">二人目チェック</p>
                <p class="border p-2">未
                </p>
              </div>
            </td>
            @elseif ($reservation->bills()->first()->double_check_status==2)
            <td>
              <div class="d-flex">
                <p class="bg-status p-2">一人目チェック</p>
                <p class="border p-2">{{$reservation->bills()->first()->double_check1_name}}</p>
              </div>
            </td>
            <td>
              <div class="d-flex">
                <p class="bg-status p-2">二人目チェック</p>
                <p class="border p-2">{{$reservation->bills()->first()->double_check2_name}}</p>
              </div>
            </td>
            @endif
            <td>
              <div><span>申込日：</span>{{$reservation->bills()->first()->created_at}}</div>
              <div><span>予約確定日：</span>{{$reservation->bills()->first()->approve_send_at}}</div>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="approve_or_confirm">
        @if ($reservation->user_id>0)
        @include('admin.reservations.show.user.double_check')
        @else
        @include('admin.reservations.show.agent.double_check')
        @endif
      </div>
      <div class="cancel">
        @if ($reservation->bills()->first()->reservation_status==3)
        {{ Form::open(['url' => 'admin/cxl/multi_create', 'method'=>'get', 'class'=>'']) }}
        @csrf
        {{ Form::hidden('reservation_id', $reservation->id ) }}
        <p class="text-right py-2 mr-2">
          {{ Form::submit('一括キャンセル',['class' => 'btn more_btn4', $judgeMultiDelete!=1?"disabled":"",'name'=>'multi']) }}
          <div class="text-right"><span>※全ての予約ステータスが「予約完了」か確認してください</span></div>
        </p>
        {{ Form::close() }}
        @endif
      </div>

      <div class="invoice_box d-flex justify-content-end my-3">
        {{ Form::open(['url' => 'admin/invoice', 'method'=>'post', 'class'=>'']) }}
        @csrf
        {{ Form::hidden('reservation_id', $reservation->id ) }}
        {{ Form::hidden('bill_id', $reservation->bills->first()->id ) }}
        <p class="mr-2">{{ Form::submit('請求書をみる',['class' => 'btn more_btn']) }}</p>
        {{ Form::close() }}
        <p class="mr-2"><input class="btn more_btn4" type="submit" value="領収書をみる"></p>
      </div>
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
      <div class="main hide">
        @if ($reservation->user_id>0)
        @include('admin.reservations.show.user.breakdown')
        @else
        @include('admin.reservations.show.agent.breakdown')
        @endif
        <div class="bill_total">
          <table class="table text-right">
            <tbody>
              <tr>
                <td></td>
                <td>
                  小計：{{number_format($reservation->bills()->first()->master_subtotal)}}
                </td>
              </tr>
              <tr>
                <td></td>
                <td>
                  消費税：{{number_format($reservation->bills()->first()->master_tax)}}
                </td>
              </tr>
              <tr>
                <td></td>
                <td>
                  <span
                    class="font-weight-bold">合計金額：</span>{{number_format($reservation->bills()->first()->master_total)}}
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
      <div class="main hide">
        <div class="informations billdetails_content">
          <table class="table">
            <tbody>
              <tr>
                <td>請求日：</td>
                <td>支払期日：{{ReservationHelper::formatDate($reservation->bills()->first()->payment_limit)}}
                </td>
              </tr>
              <tr>
                <td>請求書宛名：
                  {{($reservation->bills()->first()->bill_company)}}
                </td>
                <td>
                  担当者：
                  {{$reservation->bills()->first()->bill_person}}
                </td>
              </tr>
              <tr>
                <td colspan="2">請求書備考
                  {{$reservation->bills()->first()->bill_remark}}
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
                <td> {{$reservation->bills()->first()->paid==0?"未入金":"入金済"}}
                </td>
                <td>
                  入金日
                  {{$reservation->bills()->first()->pay_day}}
                </td>
              </tr>
              <tr>
                <td>振込人名 {{$reservation->bills()->first()->pay_person}}</td>
                <td>入金額 {{$reservation->bills()->first()->pay_person}}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  @if ($reservation->bills()->first()->double_check_status==0)
  <div class="double_checkbox section-wrap">
    <dl class="d-flex col-12 justify-content-end align-items-center">
      <dt><label for="checkname">一人目チェック者</label></dt>
      <dd>
        {{ Form::model($reservation->id, ['route'=> ['admin.reservations.double_check',$reservation->id]]) }}
        @csrf
        {{Form::select('double_check1_name', $admin, null, ['placeholder' => '選択してください', 'class'=>'form-control double_check1_name'])}}
        {{ Form::hidden('double_check_status', $reservation->bills()->first()->double_check_status ) }}
      </dd>
      <dd class="ml-2">
        <p class="text-right">
          {{Form::submit('チェック完了', ['class'=>'btn more_btn', 'id'=>'double_check1_submit'])}}
          {{ Form::close() }}
        </p>
      </dd>
    </dl>
  </div>
  @elseif($reservation->bills()->first()->double_check_status==1)
  <div class="double_checkbox section-wrap">
    <dl class="d-flex col-12 justify-content-end align-items-center">
      <dt><label for="checkname">二人目チェック者</label></dt>
      <dd class="ml-2">
        {{ Form::model($reservation->id, ['route'=> ['admin.reservations.double_check',$reservation->id]]) }}
        @csrf
        {{Form::select('double_check2_name', $admin, null, ['placeholder' => '選択してください', 'class'=>'form-control double_check2_name'])}}
        {{ Form::hidden('double_check_status', $reservation->bills()->first()->double_check_status ) }}
      </dd>
      <dd>
        <p class="text-right">
          {{Form::submit('チェック完了', ['class'=>'btn more_btn', 'id'=>'double_check2_submit'])}}
          {{ Form::close() }}
        </p>
      </dd>
    </dl>
  </div>
  @endif
  </div>

</section>



{{-- 追加請求 セクション --}}
@foreach ($other_bills as $key=>$other_bill)
<section class="mt-5 p-0">
  <div class="bill">
    <div class="bill_head2">
      <table class="table bill_table pt-2">
        <tbody>
          <tr>
            <td>
              <h2 class="text-white">
                請求書No
              </h2>
            </td>
            <td style="width: 70%;">
              <div class="d-flex align-items-center justify-content-end">
                <dl class="ttl_box">
                  <dt>合計金額：</dt>
                  <dd class="total_result">{{number_format($other_bill->master_total)}} 円</dd>
                </dl>
                <dl class="ttl_box">
                  <dt>支払い期日：</dt>
                  <dd class="total_result">{{ReservationHelper::formatDate($other_bill->payment_limit)}}</dd>
                </dl>
                <p>
                  @if ($reservation->user_id>0)
                  <a href="{{url('admin/bills/'.$other_bill->id.'/edit')}}" class="btn more_btn">編集</a>
                  @else
                  <a href="{{url('admin/bills/'.$other_bill->id.'/agent_edit')}}" class="btn more_btn">編集</a>
                  @endif
                </p>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="bill_status2">
      <table class="table">
        <tbody>
          <tr>
            <td>
              <div class="d-flex">
                <p class="bg-status p-2">予約状況</p>
                <p class="border p-2">{{ReservationHelper::judgeStatus($other_bill->reservation_status)}}</p>
              </div>
            </td>
            @if ($other_bill->double_check_status==0)
            <td>
              <div class="d-flex">
                <p class="bg-status p-2">一人目チェック</p>
                <p class="border p-2">未
                </p>
              </div>
            </td>
            @elseif ($other_bill->double_check_status==1)
            <td>
              <div class="d-flex">
                <p class="bg-status p-2">一人目チェック</p>
                <p class="border p-2">{{$other_bill->double_check1_name}}</p>
              </div>
            </td>
            <td>
              <div class="d-flex">
                <p class="bg-status p-2">二人目チェック</p>
                <p class="border p-2">未
                </p>
              </div>
            </td>
            @elseif ($other_bill->double_check_status==2)
            <td>
              <div class="d-flex">
                <p class="bg-status p-2">一人目チェック</p>
                <p class="border p-2">{{$other_bill->double_check1_name}}</p>
              </div>
            </td>
            <td>
              <div class="d-flex">
                <p class="bg-status p-2">二人目チェック</p>
                <p class="border p-2">{{$other_bill->double_check2_name}}</p>
              </div>
            </td>
            @endif
            <td>
              <div><span>申込日：</span>{{$other_bill->created_at}}</div>
              <div><span>予約確定日：</span>{{$other_bill->approve_send_at}}</div>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="approve_or_confirm">
        @if ($other_bill->double_check_status==2)
        @if ($other_bill->reservation_status<=2) <div class="d-flex justify-content-end mt-2 mb-2">
          {{ Form::open(['url' => 'admin/bills/other_send_approve', 'method'=>'POST', 'class'=>'']) }}
          @csrf
          {{ Form::hidden('bill_id', $other_bill->id ) }}
          {{ Form::hidden('user_id', $reservation->user_id ) }}
          {{ Form::hidden('reservation_id', $reservation->id ) }}

          <p class="mr-2">{{ Form::submit('利用者に承認メールを送る',['class' => 'btn more_btn approve_send']) }}</p>
          {{ Form::close() }}
          {{ Form::open(['url' => 'admin/agents_reservations/confirm', 'method'=>'POST', 'class'=>'']) }}
          @csrf
          {{ Form::hidden('bill_id', $other_bill->id ) }}
          <p>{{ Form::submit('予約を確定する',['class' => 'btn more_btn4 confirm_btn']) }}</p>
          {{ Form::close() }}
          @endif
          @endif
      </div>
      <div class="cancel">
        @if ($other_bill->reservation_status==3)
        {{ Form::open(['url' => 'admin/cxl/multi_create', 'method'=>'get', 'class'=>'']) }}
        @csrf
        {{ Form::hidden('reservation_id', $reservation->id ) }}
        {{ Form::hidden('bill_id', $other_bill->id ) }}
        <p class="text-right py-2 mr-2">
          {{ Form::submit('個別キャンセル',['class' => 'btn more_btn4',$judgeSingleDelete!=1?"disabled":"", 'name'=>'single']) }}
        </p>
        {{ Form::close() }}
        @endif
      </div>
      <div class="invoice_box d-flex justify-content-end my-3">
        <p class="mr-2"><a class="btn more_btn" href="">請求書をみる</a></p>
        <p class="mr-2"><a class="btn more_btn4" href="">領収書をみる</a></p>
      </div>
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
      <div class="main hide">
        @if ($reservation->user_id>0)
        @include('admin.reservations.show.user.additional_breakdown')
        @else
        @include('admin.reservations.show.agent.additional_breakdown')
        @endif


        <div class="bill_total">
          <table class="table text-right">
            <tbody>
              <tr>
                <td>
                  小計：{{number_format($other_bill->master_subtotal)}}
                </td>
              </tr>
              <tr>
                <td>
                  消費税：{{number_format($other_bill->master_tax)}}
                </td>
              </tr>
              <tr>
                <td>
                  <span class="font-weight-bold">合計金額：</span>{{number_format($other_bill->master_total)}}
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
      <div class="main hide">
        <div class="informations billdetails_content">
          <table class="table">
            <tbody>
              <tr>
                <td>請求日：</td>
                <td>支払期日：{{ReservationHelper::formatDate($other_bill->payment_limit)}}
                </td>
              </tr>
              <tr>
                <td>請求書宛名：
                  {{($other_bill->bill_company)}}
                </td>
                <td>
                  担当者：
                  {{$other_bill->bill_person}}
                </td>
              </tr>
              <tr>
                <td colspan="2">請求書備考
                  {{$other_bill->bill_remark}}
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
                <td> {{$other_bill->paid==0?"未入金":"入金済"}}
                </td>
                <td>
                  入金日
                  {{$other_bill->pay_day}}
                </td>
              </tr>
              <tr>
                <td>振込人名 {{$other_bill->pay_person}}</td>
                <td>入金額 {{$other_bill->pay_person}}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  @if ($other_bill->double_check_status==0)
  <div class="double_checkbox section-wrap">
    <dl class="d-flex col-12 justify-content-end align-items-center">
      <dt><label for="checkname">一人目チェック者</label></dt>
      <dd>
        {{ Form::open(['url' => 'admin/bills/other_doublecheck', 'method'=>'POST']) }}
        @csrf
        {{Form::select('double_check1_name', $admin, 
        null, ['placeholder' => '選択してください', 'class'=>'form-control double_check1_name'])}}
        {{ Form::hidden('double_check_status', $other_bill->double_check_status ) }}
        {{ Form::hidden('bills_id', $other_bill->id ) }}
      </dd>
      <dd>
        <p class="text-right">
          {{Form::submit('チェック完了', ['class'=>'btn more_btn', 'id'=>'double_check1_submit'])}}
          {{ Form::close() }}
        </p>
      </dd>
    </dl>
  </div>
  @elseif($other_bill->double_check_status==1)
  <div class="double_checkbox section-wrap">
    <dl class="d-flex col-12 justify-content-end align-items-center">
      <dt><label for="checkname">二人目チェック者</label></dt>
      <dd>
        {{ Form::open(['url' => 'admin/bills/other_doublecheck', 'method'=>'POST']) }}
        @csrf
        {{Form::select('double_check2_name', $admin, 
        null, ['placeholder' => '選択してください', 'class'=>'form-control double_check2_name'])}}
        {{ Form::hidden('double_check_status', $other_bill->double_check_status ) }}
        {{ Form::hidden('bills_id', $other_bill->id ) }}
      </dd>
      <dd>
        <p class="text-right">
          {{Form::submit('チェック完了', ['class'=>'btn more_btn', 'id'=>'double_check2_submit'])}}
          {{ Form::close() }}
        </p>
      </dd>
    </dl>
  </div>
  @endif
</section>
@endforeach




<!-- 合計請求額------------------------------------------------------------------- -->
@if ($reservation->user_id>0)
<div class="master_totals border-wrap">
  <table class="table">
    <tbody class="master_total_head">
      <tr>
        <td colspan="2">
          <h3>
            合計請求額
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
        <td>{{number_format($master_prices[0])}}円</td>
      </tr>
      <tr>
        <td>・有料備品　サービス</td>
        <td>{{number_format($master_prices[1])}}円</td>
      </tr>
      <tr>
        <td>・レイアウト変更料</td>
        <td>{{number_format($master_prices[2])}}円</td>
      </tr>
      <tr>
        <td>・その他</td>
        <td>{{number_format($master_prices[3])}}円</td>
      </tr>
    </tbody>
    <tbody class="master_total_bottom mb-0">
      <tr>
        <td></td>
        <td>
          <div class="d-flex justify-content-end" colspan="2">
            <p>小計：</p>
            <p>{{number_format($master_prices[4])}}円</p>
          </div>
        </td>
      </tr>
      <tr>
        <td></td>
        <td>
          <div class="d-flex justify-content-end" colspan="2">
            <p>消費税：</p>
            <p>{{number_format(ReservationHelper::getTax($master_prices[4]))}}円</p>
          </div>
        </td>
      </tr>
      <tr>
        <td></td>
        <td>
          <div class="d-flex justify-content-end" colspan="2">
            <p>合計金額：</p>
            <p>{{number_format(ReservationHelper::taxAndPrice($master_prices[4]))}}円</p>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
  <div class="payment_situation">
    <dl>
      <dt>合計入金額</dt>
      <dd>円</dd>
    </dl>
    <dl>
      <dt>未入金額</dt>
      <dd>円</dd>
    </dl>
  </div>
</div>
@else
<div class="master_totals border-wrap">
  <table class="table">
    <tbody class="master_total_head">
      <tr>
        <td colspan="2">
          <h3>
            合計請求額
          </h3>
        </td>
        <td></td>
      </tr>
    </tbody>
    <tbody class="master_total_bottom">
      <tr>
        <td></td>
        <td>
          <div class="d-flex justify-content-end" colspan="2">
            <p>小計：</p>
            <p>
              {{number_format($master_prices[4])}}
              円
            </p>
          </div>
        </td>
      </tr>
      <tr>
        <td></td>
        <td>
          <div class="d-flex justify-content-end" colspan="2">
            <p>消費税：</p>
            <p>{{number_format(ReservationHelper::getTax($master_prices[4]))}}円</p>
          </div>
        </td>
      </tr>
      <tr>
        <td></td>
        <td>
          <div class="d-flex justify-content-end" colspan="2">
            <p>合計金額：</p>
            <p>{{number_format(ReservationHelper::taxAndPrice($master_prices[4]))}}円</p>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
  <div class="payment_situation">
    <dl>
      <dt>合計入金額</dt>
      <dd>円</dd>
    </dl>
    <dl>
      <dt>未入金額</dt>
      <dd>円</dd>
    </dl>
  </div>
</div>
@endif


{{-- キャンセル詳細 --}}
@foreach ($reservation->cxls as $key=>$cxl)
<section class="mt-5 p-0">
  <div class="bill">
    <div class="bill_head_cancel">
      <table class="table bill_table pt-2 bill_head_cancel">
        <tbody>
          <tr>
            <td>
              <h2 class="text-white">
                請求書No
              </h2>
            </td>
            <td style="width: 70%;">
              <div class="d-flex align-items-center justify-content-end">
                <dl class="ttl_box">
                  <dt>合計金額：</dt>
                  <dd class="total_result">{{number_format($cxl->master_total)}} 円</dd>
                </dl>
                <!-- </td> -->
                <!-- <td> -->
                <dl class="ttl_box">
                  <dt>支払い期日：</dt>
                  <dd class="total_result">{{ReservationHelper::formatDate($cxl->payment_limit)}}</dd>
                </dl>
                <!-- </td> -->
                <!-- <td> -->
                <p><a href="#" class="btn more_btn">編集</a></p>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="bill_status2">
      <table class="table">
        <tbody>
          <tr>
            <td>
              <div class="d-flex">
                <p class="bg-status p-2">予約状況</p>
                <p class="border p-2">{{(ReservationHelper::cxlStatus($cxl->cxl_status))}}</p>
              </div>
            </td>
            @if ($cxl->double_check_status==0)
            <td>
              <div class="d-flex">
                <p class="bg-status p-2">一人目チェック</p>
                <p class="border p-2">未
                </p>
              </div>
            </td>
            @elseif ($cxl->double_check_status==1)
            <td>
              <div class="d-flex">
                <p class="bg-status p-2">一人目チェック</p>
                <p class="border p-2">{{$cxl->double_check1_name}}</p>
              </div>
            </td>
            <td>
              <div class="d-flex">
                <p class="bg-status p-2">二人目チェック</p>
                <p class="border p-2">未
                </p>
              </div>
            </td>
            @elseif ($cxl->double_check_status==2)
            <td>
              <div class="d-flex">
                <p class="bg-status p-2">一人目チェック</p>
                <p class="border p-2">{{$cxl->double_check1_name}}</p>
              </div>
            </td>
            <td>
              <div class="d-flex">
                <p class="bg-status p-2">二人目チェック</p>
                <p class="border p-2">{{$cxl->double_check2_name}}</p>
              </div>
            </td>
            @endif
            <td>
              <div><span>申込日：</span>{{$cxl->created_at}}</div>
              <div><span>予約確定日：</span>{{$cxl->approve_send_at}}</div>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="approve_or_confirm">
        @if ($cxl->double_check_status==2)
        @if ($cxl->cxl_status<2) <div class="d-flex justify-content-end mt-2 mb-2">
          {{ Form::open(['url' => 'admin/cxl/send_email_and_approve', 'method'=>'POST', 'class'=>'']) }}
          @csrf
          {{ Form::hidden('cxl_id', $cxl->id ) }}
          <p class="mr-2">
            {{ Form::submit('利用者にキャンセル承認メールを送る',['class' => 'btn more_btn approve_send']) }}
          </p>
          {{ Form::close() }}

          {{ Form::open(['url' => 'admin/cxl/confirm', 'method'=>'POST', 'class'=>'']) }}
          @csrf
          {{ Form::hidden('cxl_id', $cxl->id ) }}
          <p>
            {{ Form::submit('キャンセルを確定する',['class' => 'btn more_btn4']) }}
          </p>
          {{ Form::close() }}
          @endif
          @endif
      </div>

      <div class="invoice_box d-flex justify-content-end my-3">
        <p class="mr-2"><a class="btn more_btn" href="">請求書をみる</a></p>
        <p class="mr-2"><a class="btn more_btn4" href="">領収書をみる</a></p>
      </div>
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
      <div class="main hide">
        <div class="billdetails_content">
          <h4 class="cancel_ttl">キャンセル料計算</h4>
          <table class="table table-borderless">
            <thead class="head_cancel">
              <tr>
                <td>内容</td>
                <td>申込み金額</td>
                <td></td>
                <td>キャンセル料率</td>
              </tr>
            </thead>
            @foreach ($cxl->cxl_breakdowns->where('unit_type',2) as $cxl_calc)
            <tr>
              <td>{{$cxl_calc->unit_item}}円</td>
              <td>{{($cxl_calc->unit_cost)}}</td>
              <td>×</td>
              <td>{{$cxl_calc->unit_count}}%</td>
            </tr>
            @endforeach
          </table>
        </div>

        <div class="billdetails_content">
          <table class="table table-borderless">
            <tbody>
              <tr>
                <td>
                  <h4 class="billdetails_content_ttl">
                    キャンセル料
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
              @foreach ($cxl->cxl_breakdowns->where('unit_type',1) as $cxl_breakdowns)
              <tr>
                <td>{{$cxl_breakdowns->unit_item}}</td>
                <td>{{number_format($cxl_breakdowns->unit_cost)}}</td>
                <td>{{$cxl_breakdowns->unit_count}}</td>
                <td>{{number_format($cxl_breakdowns->unit_subtotal)}}</td>
              </tr>
              @endforeach
            </tbody>
            <tbody class="venue_result">
              <tr>
                <td colspan="3"></td>
                <td colspan="1" class="">合計：{{number_format($cxl->master_subtotal)}}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="bill_total">
          <table class="table text-right">
            <tbody>
              <tr>
                <td>
                  小計：{{number_format($cxl->master_subtotal)}}
                </td>
              </tr>
              <tr>
                <td>
                  消費税：{{number_format($cxl->master_tax)}}
                </td>
              </tr>
              <tr>
                <td>
                  <span class="font-weight-bold">合計金額：</span>
                  {{number_format($cxl->master_total)}}
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
      <div class="main hide">
        <div class="informations billdetails_content">
          <table class="table">
            <tbody>
              <tr>
                <td>請求日：</td>
                <td>支払期日：{{ReservationHelper::formatDate($cxl->payment_limit)}}
                </td>
              </tr>
              <tr>
                <td>請求書宛名：
                  {{($cxl->bill_company)}}
                </td>
                <td>
                  担当者：
                  {{$cxl->bill_person}}
                </td>
              </tr>
              <tr>
                <td colspan="2">請求書備考
                  {{$cxl->bill_remark}}
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
                <td> {{$cxl->paid==0?"未入金":"入金済"}}
                </td>
                <td>
                  入金日
                  {{$cxl->pay_day}}
                </td>
              </tr>
              <tr>
                <td>振込人名 {{$cxl->pay_person}}</td>
                <td>入金額 {{$cxl->pay_person}}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  @if ($cxl->double_check_status==0)
  <div class="double_checkbox section-wrap">
    <dl class="d-flex col-12 justify-content-end align-items-center">
      <dt><label for="checkname">一人目チェック者</label></dt>
      <dd>
        {{ Form::open(['url' => 'admin/cxl/double_check', 'method'=>'POST']) }}
        @csrf
        {{Form::select('double_check1_name', $admin, 
        null, ['placeholder' => '選択してください', 'class'=>'form-control double_check1_name'])}}
        {{ Form::hidden('double_check_status', $cxl->double_check_status ) }}
        {{ Form::hidden('reservation_id', $reservation->id ) }}
        {{ Form::hidden('cxl_id', $cxl->id ) }}
      </dd>
      <dd>
        <p class="text-right">
          {{Form::submit('チェック完了', ['class'=>'btn more_btn', 'id'=>'double_check1_submit'])}}
          {{ Form::close() }}
        </p>
      </dd>
    </dl>
  </div>
  @elseif($cxl->double_check_status==1)
  <div class="double_checkbox section-wrap">
    <dl class="d-flex col-12 justify-content-end align-items-center">
      <dt><label for="checkname">二人目チェック者</label></dt>
      <dd>
        {{ Form::open(['url' => 'admin/cxl/double_check', 'method'=>'POST']) }}
        @csrf
        {{Form::select('double_check2_name', $admin, 
        null, ['placeholder' => '選択してください', 'class'=>'form-control double_check2_name'])}}
        {{ Form::hidden('double_check_status', $cxl->double_check_status ) }}
        {{ Form::hidden('cxl_id', $cxl->id ) }}
      </dd>
      <dd>
        <p class="text-right">
          {{Form::submit('チェック完了', ['class'=>'btn more_btn', 'id'=>'double_check2_submit'])}}
          {{ Form::close() }}
        </p>
      </dd>
    </dl>
  </div>
  @endif
</section>
@endforeach

{{-- キャンセル総合計請求額 --}}
@if ($reservation->cxls->count()!=0)

<div class="master_totals_cancel">
  <table class="table">
    <tbody class="master_total_head2">
      <tr>
        <td colspan="2">
          <h3>
            キャンセル料　合計請求額
          </h3>
        </td>
      </tr>
    </tbody>
    <tr>
      <td colspan="2" class="master_total_subttl2">
        <h4>内訳</h4>
      </td>
    </tr>
    <tbody class="master_total_body">
      <tr>
        <td>・キャンセル料</td>
        <td>{{number_format($cxl_subtotal)}}円</td>
      </tr>
    </tbody>
    <tbody class="master_total_bottom mb-0">
      <tr>
        <td></td>
        <td>
          <div class="d-flex justify-content-end" colspan="2">
            <p>小計：</p>
            <p>{{number_format($cxl_subtotal)}}円</p>
          </div>
        </td>
      </tr>
      <tr>
        <td></td>
        <td>
          <div class="d-flex justify-content-end" colspan="2">
            <p>消費税：</p>
            <p>{{number_format(ReservationHelper::getTax($cxl_subtotal))}}円</p>
          </div>
        </td>
      </tr>
      <tr>
        <td></td>
        <td>
          <div class="d-flex justify-content-end" colspan="2">
            <p>合計金額：</p>
            <p>{{number_format(ReservationHelper::taxAndPrice($cxl_subtotal))}}円</p>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
  <div class="payment_situation">
    <dl>
      <dt>合計入金額</dt>
      <dd>円</dd>
    </dl>
    <dl>
      <dt>未入金額</dt>
      <dd>円</dd>
    </dl>
  </div>
</div>
@endif


<script>
  $(function() {
    $('#double_check1_submit,#double_check2_submit').on('click', function() {
      if (!confirm('チェック完了しますか？')) {
        return false;
      }
    });
    $('#send_confirm').on('click', function() {
      if (!confirm('利用者に承認メールを送付しますか？')) {
        return false;
      }
    });
    $('#reservation_confirm').on('click', function() {
      if (!confirm('予約を確定しますか？')) {
        return false;
      }
    });
    $('.approve_send').on('click', function() {
      if (!confirm('利用者に承認メールを送付しますか？')) {
        return false;
      }
    });
    $('.confirm_btn').on('click', function() {
      if (!confirm('予約を確定しますか？')) {
        return false;
      }
    });
  });


</script>






@endsection