@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>



<div class="content">
  <div class="container-fluid">
    <div class="container-field mt-3">
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
      <h1 class="mt-3 mb-5">予約 詳細</h1>
    </div>
    <div class="btn-wrapper2 col-12 align-items-center d-flex justify-content-between">
      <!-- 削除ボタン-ステータス：予約が完了する前で表示----- -->
      @if ($reservation->bills()->first()->reservation_status<3) <div class="text-left">
        {{ Form::model($reservation, ['route' => ['admin.reservations.destroy', $reservation->id], 'method' => 'delete']) }}
        @csrf
        {{ Form::submit('削除', ['class' => 'btn more_btn4']) }}
        {{ Form::close() }}
    </div>
    @endif

    @if ($reservation->bills()->first()->reservation_status==3)
    <!-- 請求書の追加ボタン-ステータス：予約完了で表示----- -->
    <p class="text-right">
      {{ Form::open(['url' => 'admin/bills/create/'.$reservation->id, 'method'=>'POST', 'class'=>'']) }}
      @csrf
      {{ Form::hidden('reservation_id', $reservation->id ) }}
      {{ Form::submit('追加の請求書を作成する',['class' => 'btn more_btn3']) }}
      {{ Form::close() }}
    </p>
    @endif
  </div>
  <div class="col-12 btn-wrapper2">
    <!-- 請求書の追加ボタン-ステータス：予約完了で表示----- -->
    {{-- <p class="text-right"><a class="more_btn4_lg" href="">一括キャンセルをする</a></p> --}}
  </div>
  <!-- 予約詳細--------------------------------------------------------　 -->
  <div class="section-wrap">
    <div class="ttl-box d-flex align-items-center">
      <div class="col-9 d-flex justify-content-between">
        <h2>予約概要</h2>
        <p>予約ID: {{$reservation->id}}</p>
        <p>予約一括ID:</p>
      </div>
      {{-- 予約完了前（予約ステータス3以前）なら表示 --}}
      @if ($reservation->bills()->first()->reservation_status<3) <div class="col-3">
        <p class="text-right">
          {{ link_to_route('admin.reservations.edit', '編集', $parameters = $reservation->id, ['class' => 'more_btn']) }}
        </p>
    </div>
    @endif
  </div>
  <section class="register-wrap">
    <div class="section-header">
      <div class="row">
        <div class="d-flex col-10 flex-wrap">
          <dl>
            <dt>予約状況</dt>
            <dd>{{ReservationHelper::judgeStatus($reservation->bills()->first()->reservation_status)}}</dd>
          </dl>
          @if ($reservation->bills()->first()->double_check_status==0)
          <dl>
            <dt>一人目チェック</dt>
            <dd class="d-flex">
              <p>未</p>
              <p class="ml-2"> <button class="btn more_btn first_double_check">チェックをする</button> </p>
            </dd>
          </dl>
          @elseif ($reservation->bills()->first()->double_check_status==1)
          <dl>
            <dt>一人目チェック</dt>
            <dd class="d-flex">
              <p>{{$reservation->bills()->first()->double_check1_name}}</p>
            </dd>
          </dl>
          <dl>
            <dt>二人目チェック</dt>
            <dd class="d-flex">
              <p>未</p>
              <p class="ml-2"> <button class="btn more_btn second_double_check">チェックをする</button> </p>
            </dd>
          </dl>
          @elseif ($reservation->bills()->first()->double_check_status==2)
          <dl>
            <dt>一人目チェック</dt>
            <dd class="d-flex">
              <p>{{$reservation->bills()->first()->double_check1_name}}</p>
            </dd>
          </dl>
          <dl>
            <dt>二人目チェック</dt>
            <dd class="d-flex">
              <p>{{$reservation->bills()->first()->double_check2_name}}</p>
            </dd>
          </dl>
          @endif
        </div>
        <div class="col-2">
          <p>
            <dd>申込日：{{ReservationHelper::formatDate($reservation->created_at)}}</dd>
          </p>
          <p>
            ※後ほど修正※　予約確定日：2020/10/15(木)
          </p>
        </div>
      </div>
      @if ($reservation->bills()->first()->double_check_status==2)
      <!-- 承認確認ボタン-ダブルチェック後に表示------ -->
      {{-- 予約完了後、非表示 --}}
      @if ($reservation->bills()->first()->reservation_status<=2) <div class="row justify-content-end mt-5">
        <div class="d-flex col-2 justify-content-around">
          <p class="text-right">
            {{-- 予約ステータスを2にして、ユーザーにメール送付 --}}
            {{-- <a class="more_btn" href="">承認</a> --}}
            {{ Form::open(['url' => 'admin/reservations/'.$reservation->id.'/send_email_and_approve', 'method'=>'POST', 'class'=>'']) }}
            @csrf
            {{ Form::hidden('reservation_id', $reservation->id ) }}
            {{ Form::hidden('user_id', $reservation->user_id ) }}
            {{ Form::submit('承認',['class' => 'btn more_btn']) }}
            {{ Form::close() }}
          </p>
          <p class="text-right">
            {{-- <a class="more_btn4" href="">確定</a> --}}
            {{ Form::open(['url' => 'admin/reservations/'.$reservation->id.'/confirm_reservation', 'method'=>'POST', 'class'=>'']) }}
            @csrf
            {{ Form::hidden('reservation_id', $reservation->id ) }}
            {{ Form::hidden('user_id', $reservation->user_id ) }}
            {{ Form::submit('確定',['class' => 'btn more_btn4']) }}
            {{ Form::close() }}
          </p>
        </div>
    </div>
    @endif
    @endif


    <div class="row">
      <!-- 左側の項目------------------------------------------------------------------------ -->
      <div class="col-6">
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
              <p>
                {{ReservationHelper::getVenue($reservation->venue_id)}}
              </p>
              <p>アクセア仕様</p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="start">入室時間</label></td>
            <td>
              {{$reservation->enter_time}}
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="finish">退室時間</label></td>
            <td>
              {{$reservation->leave_time}}
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
              <td colspan="2">
                <p class="title-icon active">有料備品</p>
              </td>
            </tr>
          </thead>
          <tbody class="accordion-wrap">
            @foreach ($equipments as $equipment)
            @foreach ($breakdowns as $breakdown)
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
              <td colspan="2">
                <p class="title-icon active">有料サービス<span class="open_toggle"></span></p>
              </td>
            </tr>
          </thead>
          <tbody class="accordion-wrap">
            <tr>
              <td colspan="2">
                <ul class="icheck-primary">
                  @foreach ($services as $service)
                  @foreach ($breakdowns as $breakdown)
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
            <tr>
              <td class="table-active"><label for="layout">レイアウト変更</label></td>
              <td>
                @foreach ($breakdowns as $breakdown)
                @if ($breakdown->unit_type==3)
                あり
                @break
                @endif
                @endforeach
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="prelayout">レイアウト準備</label></td>
              <td>
                @foreach ($breakdowns as $breakdown)
                {{$breakdown->unit_item=='レイアウト準備'?'あり':''}}
                @endforeach
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="postlayout">レイアウト片付</label></td>
              <td>
                @foreach ($breakdowns as $breakdown)
                {{$breakdown->unit_item=='レイアウト片付'?'あり':''}}
                @endforeach
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="Delivery">荷物預かり/返送</label></td>
              <td>
                @foreach ($breakdowns as $breakdown)
                {{$breakdown->unit_item=='荷物預かり/返送'?'あり':''}}
                @endforeach
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="preDelivery">事前に預かる荷物</label></td>
              <td>
                <ul class="table-cell-box">
                  <li>
                    <p>
                      {{isset($reservation->luggage_count)?'あり':'なし'}}
                    </p>
                  </li>
                  <li class="d-flex justify-content-between">
                    <p>荷物個数</p>
                    <p>
                      {{isset($reservation->luggage_count)?$reservation->luggage_count:''}}個
                    </p>
                  </li>

                  <li class="d-flex justify-content-between">
                    <p>事前荷物の到着日</p>
                    <p>
                      {{isset($reservation->luggage_arrive)?ReservationHelper::formatDate($reservation->luggage_arrive):''}}
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
                  <li class="d-flex justify-content-between">
                    <p>荷物個数</p>
                    <p>
                      {{isset($reservation->luggage_return)?$reservation->luggage_return:''}}個
                    </p>
                  </li>
                </ul>
              </td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered eating-table">
          <tr>
            <td>
              <p class="title-icon">室内飲食</p>
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
      <div class="col-6">
        <div class="customer-table">
          <table class="table table-bordered name-table">
            <tr>
              <td colspan="2">
                <div class="d-flex align-items-center justify-content-between">
                  <p class="title-icon">
                    <i class="far fa-address-card icon-size"></i>
                    顧客情報
                  </p>
                  <p><a class="more_btn" href="">顧客詳細</a></p>
                </div>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="company">会社名・団体名</label></td>
              <td>
                {{$user->company}}
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="name">担当者氏名</label></td>
              <td>
                {{$user->first_name}}{{$user->last_name}}
              </td>
            </tr>
            <tr>
              <td class="table-active">担当者氏名(フリガナ)</td>
              <td>
                {{$user->first_name_kana}}{{$user->last_name_kana}}
              </td>
            </tr>
            <tr>
              <td class="table-active">電話番号</td>
              <td>
                <ul class="table-cell-box">
                  <li>
                    <p>携帯番号</p>
                    <p> {{$user->mobile}}
                    </p>
                  </li>
                  <li>
                    <p>固定番号</p>
                    <p> {{$user->tel}}
                    </p>
                  </li>
                </ul>
              </td>
            </tr>
            <tr>
              <td class="table-active">メールアドレス</td>
              <td>
                {{$user->email}}
              </td>
            </tr>
            <tr>
              <td class="table-active">顧客属性</td>
              <td>
                {{$user->attr}}
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <p>備考</p>
                <p> {{$user->remark}}
                </p>
              </td>
            </tr>
            <tr class="caution">
              <td colspan="2">
                <p>注意事項</p>
                <p>{{$user->attention}}</p>
              </td>
            </tr>
          </table>

          <table class="table table-bordered oneday-table">
            <tr>
              <td colspan="2">
                <p class="title-icon">
                  <i class="fas fa-user icon-size"></i>
                  当日の連絡できる担当者
                </p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="ondayName">氏名</label></td>
              <td>{{$reservation->in_charge}}</td>
            </tr>
            <tr>
              <td class="table-active"><label for="mobilePhone">携帯番号</label></td>
              <td>{{$reservation->tel}}</td>
            </tr>
          </table>
        </div>

        <table class="table table-bordered mail-table">
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-envelope icon-size"></i>
                利用後の送信メール
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="sendMail">送信メール</label></td>
            <td>{{$reservation->email_flag==1?'あり':'なし'}}</td>
          </tr>
        </table>

        <table class="table table-bordered sale-table">
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-yen-sign icon-size"></i>
                売上原価
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="sale">原価率</label></td>
            <td>{{$reservation->cost==0?'':$reservation->cost}}</td>
          </tr>
        </table>

        <table class="table table-bordered note-table">
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-file-alt icon-size"></i>
                備考
              </p>
            </td>
          </tr>
          <tr>
            <td>
              <p>
                割引条件
              </p>
              <p>{{isset($reservation->discount_condition)?$reservation->discount_condition:'なし'}}</p>
            </td>
          </tr>
          <tr class="caution">
            <td>
              <p>注意事項</p>
              <p>{{isset($reservation->attention)?$reservation->attention:'なし'}}</p>
            </td>
          </tr>
          <tr>
            <td>
              <p>顧客(予約サイト経由)入力の備考</p>
              <p>{{isset($reservation->user_details)?$reservation->user_details:'なし'}}</p>
            </td>
          </tr>
          <tr>
            <td>
              <p>管理者備考</p>
              <p>{{isset($reservation->admin_details)?$reservation->admin_details:'なし'}}</p>
            </td>
          </tr>
        </table>
      </div>
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


  <div class="register-wrap mt-5">
    <h3>請求情報</h3>
  </div>

  <div class="container-fluid mt-5 p-0">
    <div class="bill">
      <div class="bill_head">
        <table class="table" style="table-layout: fixed">
          <tbody>
            <tr>
              <td>
                <h1 class="text-white">
                  請求書No
                </h1>
              </td>
              <td style="font-size: 16px;">
                <div class="bg-white d-flex justify-content-around align-items-center" style="height: 60px;">
                  <div>合計金額</div>
                  <div class="total_result"> {{number_format($reservation->bills()->first()->master_total)}} 円</div>
                </div>
              </td>
            </tr>
            <tr>
              <td></td>
              <td style="font-size: 16px;">
                <div class="bg-white d-flex justify-content-around align-items-center" style="height: 60px;">
                  <div>支払い期日</div>
                  <div>{{ReservationHelper::formatDate($reservation->bills()->first()->payment_limit)}}</div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="bill_details">
        <div class="head d-flex">
          <div style="width: 80px; background:gray;" class="d-flex justify-content-center align-items-center">
            <i class="fas fa-plus fa-3x hide" style="color: white;" aria-hidden="true"></i>
            <i class="fas fa-minus fa-3x" style="color: white;" aria-hidden="true"></i>
          </div>
          <div style="font-size: 30px; width:200px;" class="d-flex justify-content-center align-items-center">
            <p>
              請求内訳
            </p>
          </div>
        </div>
        <div class="main">
          <div class="venues" style="padding-top: 80px; width:90%; margin:0 auto;">
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td>
                    <h1>
                      ■会場料
                    </h1>
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
                @foreach ($reservation->bills()->first()->breakdowns()->get() as $venue_breakdown)
                @if ($venue_breakdown->unit_type==1)
                <tr>
                  <td>{{$venue_breakdown->unit_item}}</td>
                  <td>{{number_format($venue_breakdown->unit_cost)}}</td>
                  <td>{{$venue_breakdown->unit_count}}</td>
                  <td>{{number_format($venue_breakdown->unit_subtotal)}}</td>
                </tr>
                @endif
                @endforeach
              </tbody>
              <tbody class="venue_result">
                <tr>
                  <td colspan="2"></td>
                  <td colspan="1">合計：</td>
                  <td colspan="1" class=""> {{number_format($reservation->bills()->first()->venue_price)}}</td>
                </tr>
              </tbody>
            </table>
          </div>

          @if ($reservation->bills()->first()->equipment_price!=0||$reservation->bills()->first()->equipment_price)
          <div class="equipment" style="padding-top: 80px; width:90%; margin:0 auto;">
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td>
                    <h1>
                      ■有料備品・サービス
                    </h1>
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
                @foreach ($reservation->bills()->first()->breakdowns()->get() as $equipment_breakdown)
                @if ($equipment_breakdown->unit_type==2)
                <tr>
                  <td>{{$equipment_breakdown->unit_item}}</td>
                  <td>{{number_format($equipment_breakdown->unit_cost)}}</td>
                  <td>{{$equipment_breakdown->unit_count}}</td>
                  <td>{{number_format($equipment_breakdown->unit_subtotal)}}</td>
                </tr>
                @endif
                @endforeach
                @foreach ($reservation->bills()->first()->breakdowns()->get() as $service_breakdown)
                @if ($service_breakdown->unit_type==3)
                <tr>
                  <td>{{$service_breakdown->unit_item}}</td>
                  <td>{{number_format($service_breakdown->unit_cost)}}</td>
                  <td>{{$service_breakdown->unit_count}}</td>
                  <td>{{number_format($service_breakdown->unit_subtotal)}}</td>
                </tr>
                @endif
                @endforeach
              </tbody>
              <tbody class="equipment_result">
                <tr>
                  <td colspan="2"></td>
                  <td colspan="1">合計：</td>
                  <td colspan="1" class=""> {{number_format($reservation->bills()->first()->equipment_price)}}</td>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          @endif

          @if ($reservation->bills()->first()->layout_price!=0||$reservation->bills()->first()->layout_price)
          <div class="layout" style="padding-top: 80px; width:90%; margin:0 auto;">
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td>
                    <h1>
                      ■レイアウト
                    </h1>
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
                @foreach ($reservation->bills()->first()->breakdowns()->get() as $layout_breakdown)
                @if ($layout_breakdown->unit_type==4)
                <tr>
                  <td>{{$layout_breakdown->unit_item}}</td>
                  <td>{{number_format($layout_breakdown->unit_cost)}}</td>
                  <td>{{$layout_breakdown->unit_count}}</td>
                  <td>{{number_format($layout_breakdown->unit_subtotal)}}</td>
                </tr>
                @endif
                @endforeach
              </tbody>
              <tbody class="layout_result">
                <tr>
                  <td colspan="2"></td>
                  <td colspan="1">合計：</td>
                  <td colspan="2">合計：{{number_format($reservation->bills()->first()->layout_price)}}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          @endif


          @if ($reservation->bills()->first()->others_price!=0||$reservation->bills()->first()->others_price)
          <div class="others" style="padding: 80px 0px 80px 0px; width:90%; margin:0 auto;">
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td>
                    <h1>
                      ■その他
                    </h1>
                  </td>
                </tr>
              </tbody>
              <tbody class="others_head">
                <tr>
                  <td>内容</td>
                  <td>単価</td>
                  <td>数量</td>
                  <td>金額</td>
                </tr>
              </tbody>
              <tbody class="others_main">
                @foreach ($reservation->bills()->first()->breakdowns()->get() as $others_breakdown)
                @if ($others_breakdown->unit_type==5)
                <tr>
                  <td>{{$others_breakdown->unit_item}}</td>
                  <td>{{number_format($others_breakdown->unit_cost)}}</td>
                  <td>{{$others_breakdown->unit_count}}</td>
                  <td>{{number_format($others_breakdown->unit_subtotal)}}</td>
                </tr>
                @endif
                @endforeach
              </tbody>
              <tbody class="others_result">
                <tr>
                  <td colspan="2"></td>
                  <td colspan="1"></td>
                  <td colspan="2">合計：{{$reservation->bills()->first()->others_price}}
                </tr>
              </tbody>
            </table>
          </div>
          @endif
          <div class="bill_total d-flex justify-content-end" style="padding: 80px 0px 80px 0px; width:90%; margin:0 auto;">
            <div style="width: 60%;">
              <table class="table text-right" style="table-layout: fixed; font-size:16px;">
                <tbody>
                  <tr>
                    <td>小計：</td>
                    <td>
                      {{number_format($reservation->bills()->first()->master_subtotal)}}
                    </td>
                  </tr>
                  <tr>
                    <td>消費税：</td>
                    <td>
                      {{number_format($reservation->bills()->first()->master_tax)}}
                    </td>
                  </tr>
                  <tr>
                    <td class="font-weight-bold">合計金額</td>
                    <td>
                      {{number_format($reservation->bills()->first()->master_total)}}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="information">
      <div class="information_details">
        <div class="head d-flex">
          <div style="width: 80px; background:gray;" class="d-flex justify-content-center align-items-center">
            <i class="fas fa-plus fa-3x hide" style="color: white;" aria-hidden="true"></i>
            <i class="fas fa-minus fa-3x" style="color: white;" aria-hidden="true"></i>
          </div>
          <div style="font-size: 30px; width:200px;" class="d-flex justify-content-center align-items-center">
            <p>
              請求書情報
            </p>
          </div>
        </div>
        <div class="main">
          <div class="informations" style="padding-top: 20px; width:90%; margin:0 auto;">
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
          <div style="width: 80px; background:#ff782d;" class="d-flex justify-content-center align-items-center">
          </div>
          <div style="font-size: 30px; width:200px;" class="d-flex justify-content-center align-items-center">
            <p>
              入金情報
            </p>
          </div>
        </div>
        <div class="main">
          <div class="paids" style="padding-top: 20px; width:90%; margin:0 auto;">
            <table class="table" style="table-layout: fixed;">
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
    <div class="checkbox section-wrap" style="border: solid 1px gray">
      <dl class="d-flex col-12 justify-content-end align-items-center">
        <dt><label for="checkname">一人目チェック者</label></dt>
        <dd>
          {{ Form::model($reservation->id, ['route'=> ['admin.reservations.double_check',$reservation->id]]) }}
          @csrf
          {{Form::select('double_check1_name', [
        '名前test1' => '名前test1', 
        '名前test2' => '名前test2',
        '名前test3' => '名前test3',
        '名前test4' => '名前test4',], 
        null, ['placeholder' => '選択してください', 'class'=>'form-control double_check1_name'])}}
          {{ Form::hidden('double_check_status', $reservation->bills()->first()->double_check_status ) }}
        </dd>
        <dd>
          <p class="text-right">
            {{Form::submit('チェック完了', ['class'=>'btn more_btn', 'id'=>'double_check1_submit'])}}
            {{ Form::close() }}
          </p>
        </dd>
      </dl>
    </div>
    @elseif($reservation->bills()->first()->double_check_status==1)
    <div class="checkbox section-wrap">
      <dl class="d-flex col-12 justify-content-end align-items-center">
        <dt><label for="checkname">二人目チェック者</label></dt>
        <dd>
          {{ Form::model($reservation->id, ['route'=> ['admin.reservations.double_check',$reservation->id]]) }}
          @csrf
          {{Form::select('double_check2_name', [
        '名前test1' => '名前test1', 
        '名前test2' => '名前test2',
        '名前test3' => '名前test3',
        '名前test4' => '名前test4',], 
        null, ['placeholder' => '選択してください', 'class'=>'form-control double_check2_name'])}}
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













  追加請求

  @foreach ($other_bills as $key=>$other_bill)
  <div class="container-fluid mt-5 p-0">
    <div class="bill">
      <div class="bill_head2">
        <table class="table" style="table-layout: fixed">
          <tbody>
            <tr>
              <td>
                <h1 class="text-white">
                  請求書No
                </h1>
              </td>
              <td style="font-size: 16px;">
                <div class="bg-white d-flex justify-content-around align-items-center" style="height: 60px;">
                  <div>合計金額</div>
                  <div class="total_result"> {{number_format($other_bill->master_total)}} 円</div>
                  ■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
                  ここ！！！
                  $other_billに買える必要あり
                  2/1深夜
                  ■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
                </div>
              </td>
            </tr>
            <tr>
              <td></td>
              <td style="font-size: 16px;">
                <div class="bg-white d-flex justify-content-around align-items-center" style="height: 60px;">
                  <div>支払い期日</div>
                  <div>{{ReservationHelper::formatDate($reservation->bills()->first()->payment_limit)}}</div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="bill_details">
        <div class="head d-flex">
          <div style="width: 80px; background:gray;" class="d-flex justify-content-center align-items-center">
            <i class="fas fa-plus fa-3x hide" style="color: white;" aria-hidden="true"></i>
            <i class="fas fa-minus fa-3x" style="color: white;" aria-hidden="true"></i>
          </div>
          <div style="font-size: 30px; width:200px;" class="d-flex justify-content-center align-items-center">
            <p>
              請求内訳
            </p>
          </div>
        </div>
        <div class="main">
          <div class="venues" style="padding-top: 80px; width:90%; margin:0 auto;">
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td>
                    <h1>
                      ■会場料
                    </h1>
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
                @foreach ($reservation->bills()->first()->breakdowns()->get() as $venue_breakdown)
                @if ($venue_breakdown->unit_type==1)
                <tr>
                  <td>{{$venue_breakdown->unit_item}}</td>
                  <td>{{number_format($venue_breakdown->unit_cost)}}</td>
                  <td>{{$venue_breakdown->unit_count}}</td>
                  <td>{{number_format($venue_breakdown->unit_subtotal)}}</td>
                </tr>
                @endif
                @endforeach
              </tbody>
              <tbody class="venue_result">
                <tr>
                  <td colspan="2"></td>
                  <td colspan="1">合計：</td>
                  <td colspan="1" class=""> {{number_format($reservation->bills()->first()->venue_price)}}</td>
                </tr>
              </tbody>
            </table>
          </div>

          @if ($reservation->bills()->first()->equipment_price!=0||$reservation->bills()->first()->equipment_price)
          <div class="equipment" style="padding-top: 80px; width:90%; margin:0 auto;">
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td>
                    <h1>
                      ■有料備品・サービス
                    </h1>
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
                @foreach ($reservation->bills()->first()->breakdowns()->get() as $equipment_breakdown)
                @if ($equipment_breakdown->unit_type==2)
                <tr>
                  <td>{{$equipment_breakdown->unit_item}}</td>
                  <td>{{number_format($equipment_breakdown->unit_cost)}}</td>
                  <td>{{$equipment_breakdown->unit_count}}</td>
                  <td>{{number_format($equipment_breakdown->unit_subtotal)}}</td>
                </tr>
                @endif
                @endforeach
                @foreach ($reservation->bills()->first()->breakdowns()->get() as $service_breakdown)
                @if ($service_breakdown->unit_type==3)
                <tr>
                  <td>{{$service_breakdown->unit_item}}</td>
                  <td>{{number_format($service_breakdown->unit_cost)}}</td>
                  <td>{{$service_breakdown->unit_count}}</td>
                  <td>{{number_format($service_breakdown->unit_subtotal)}}</td>
                </tr>
                @endif
                @endforeach
              </tbody>
              <tbody class="equipment_result">
                <tr>
                  <td colspan="2"></td>
                  <td colspan="1">合計：</td>
                  <td colspan="1" class=""> {{number_format($reservation->bills()->first()->equipment_price)}}</td>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          @endif

          @if ($reservation->bills()->first()->layout_price!=0||$reservation->bills()->first()->layout_price)
          <div class="layout" style="padding-top: 80px; width:90%; margin:0 auto;">
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td>
                    <h1>
                      ■レイアウト
                    </h1>
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
                @foreach ($reservation->bills()->first()->breakdowns()->get() as $layout_breakdown)
                @if ($layout_breakdown->unit_type==4)
                <tr>
                  <td>{{$layout_breakdown->unit_item}}</td>
                  <td>{{number_format($layout_breakdown->unit_cost)}}</td>
                  <td>{{$layout_breakdown->unit_count}}</td>
                  <td>{{number_format($layout_breakdown->unit_subtotal)}}</td>
                </tr>
                @endif
                @endforeach
              </tbody>
              <tbody class="layout_result">
                <tr>
                  <td colspan="2"></td>
                  <td colspan="1">合計：</td>
                  <td colspan="2">合計：{{number_format($reservation->bills()->first()->layout_price)}}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          @endif


          @if ($reservation->bills()->first()->others_price!=0||$reservation->bills()->first()->others_price)
          <div class="others" style="padding: 80px 0px 80px 0px; width:90%; margin:0 auto;">
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td>
                    <h1>
                      ■その他
                    </h1>
                  </td>
                </tr>
              </tbody>
              <tbody class="others_head">
                <tr>
                  <td>内容</td>
                  <td>単価</td>
                  <td>数量</td>
                  <td>金額</td>
                </tr>
              </tbody>
              <tbody class="others_main">
                @foreach ($reservation->bills()->first()->breakdowns()->get() as $others_breakdown)
                @if ($others_breakdown->unit_type==5)
                <tr>
                  <td>{{$others_breakdown->unit_item}}</td>
                  <td>{{number_format($others_breakdown->unit_cost)}}</td>
                  <td>{{$others_breakdown->unit_count}}</td>
                  <td>{{number_format($others_breakdown->unit_subtotal)}}</td>
                </tr>
                @endif
                @endforeach
              </tbody>
              <tbody class="others_result">
                <tr>
                  <td colspan="2"></td>
                  <td colspan="1"></td>
                  <td colspan="2">合計：{{$reservation->bills()->first()->others_price}}
                </tr>
              </tbody>
            </table>
          </div>
          @endif
          <div class="bill_total d-flex justify-content-end" style="padding: 80px 0px 80px 0px; width:90%; margin:0 auto;">
            <div style="width: 60%;">
              <table class="table text-right" style="table-layout: fixed; font-size:16px;">
                <tbody>
                  <tr>
                    <td>小計：</td>
                    <td>
                      {{number_format($reservation->bills()->first()->master_subtotal)}}
                    </td>
                  </tr>
                  <tr>
                    <td>消費税：</td>
                    <td>
                      {{number_format($reservation->bills()->first()->master_tax)}}
                    </td>
                  </tr>
                  <tr>
                    <td class="font-weight-bold">合計金額</td>
                    <td>
                      {{number_format($reservation->bills()->first()->master_total)}}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="information">
      <div class="information_details">
        <div class="head d-flex">
          <div style="width: 80px; background:gray;" class="d-flex justify-content-center align-items-center">
            <i class="fas fa-plus fa-3x hide" style="color: white;" aria-hidden="true"></i>
            <i class="fas fa-minus fa-3x" style="color: white;" aria-hidden="true"></i>
          </div>
          <div style="font-size: 30px; width:200px;" class="d-flex justify-content-center align-items-center">
            <p>
              請求書情報
            </p>
          </div>
        </div>
        <div class="main">
          <div class="informations" style="padding-top: 20px; width:90%; margin:0 auto;">
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
          <div style="width: 80px; background:#ff782d;" class="d-flex justify-content-center align-items-center">
          </div>
          <div style="font-size: 30px; width:200px;" class="d-flex justify-content-center align-items-center">
            <p>
              入金情報
            </p>
          </div>
        </div>
        <div class="main">
          <div class="paids" style="padding-top: 20px; width:90%; margin:0 auto;">
            <table class="table" style="table-layout: fixed;">
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
    <div class="checkbox section-wrap" style="border: solid 1px gray">
      <dl class="d-flex col-12 justify-content-end align-items-center">
        <dt><label for="checkname">一人目チェック者</label></dt>
        <dd>
          {{ Form::model($reservation->id, ['route'=> ['admin.reservations.double_check',$reservation->id]]) }}
          @csrf
          {{Form::select('double_check1_name', [
        '名前test1' => '名前test1', 
        '名前test2' => '名前test2',
        '名前test3' => '名前test3',
        '名前test4' => '名前test4',], 
        null, ['placeholder' => '選択してください', 'class'=>'form-control double_check1_name'])}}
          {{ Form::hidden('double_check_status', $reservation->bills()->first()->double_check_status ) }}
        </dd>
        <dd>
          <p class="text-right">
            {{Form::submit('チェック完了', ['class'=>'btn more_btn', 'id'=>'double_check1_submit'])}}
            {{ Form::close() }}
          </p>
        </dd>
      </dl>
    </div>
    @elseif($reservation->bills()->first()->double_check_status==1)
    <div class="checkbox section-wrap">
      <dl class="d-flex col-12 justify-content-end align-items-center">
        <dt><label for="checkname">二人目チェック者</label></dt>
        <dd>
          {{ Form::model($reservation->id, ['route'=> ['admin.reservations.double_check',$reservation->id]]) }}
          @csrf
          {{Form::select('double_check2_name', [
        '名前test1' => '名前test1', 
        '名前test2' => '名前test2',
        '名前test3' => '名前test3',
        '名前test4' => '名前test4',], 
        null, ['placeholder' => '選択してください', 'class'=>'form-control double_check2_name'])}}
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
  @endforeach







































  <!-- 請求セクション------------------------------------------------------------------- -->
  <!-- <section class="bill-wrap section-wrap section-bg">
    <div class="bill-bg">
      <div class="bill-ttl mb-5">
        <div class="section-ttl-box d-flex align-items-center">
          <div class="col-6">
            <h3 class="">請求情報</h3>
          </div>
          <div class="col-6 d-flex justify-content-end">
            @if ($reservation->bills()->first()->reservation_status>=3)
            <p class="text-right"><a class="more_btn" href="">請求書をみる</a></p>
            @endif
            @if ($reservation->bills()->first()->paid==1)
            <p class="text-right ml-3"><a class="more_btn" href="">※後ほど修正　領収書をみる</a></p>
            @endif
          </div>
        </div>
      </div>
      <div class="bill-box">
        <h3 class="row">会場料</h3>
        <dl class="row bill-box_wrap">
          <div class="col-3 bill-box_cell">
            <dt>会場料金</dt>
            <dd>
              @foreach ($breakdowns as $breakdown)
              @if ($breakdown->unit_type==1)
              @if ($breakdown->unit_item=='会場料金')
              {{number_format($breakdown->unit_cost)}}
              @endif
              @endif
              @endforeach
            </dd>
          </div>
          <div class="col-3 bill-box_cell">
            <dt>延長料金</dt>
            <dd>
              @foreach ($breakdowns as $breakdown)
              @if ($breakdown->unit_type==1)
              @if ($breakdown->unit_item=='延長料金')
              {{number_format($breakdown->unit_cost)}}
              @endif
              @endif
              @endforeach
            </dd>
          </div>
          <div class="col-6 bill-box_cell">
            <dt>会場料金合計</dt>
            <dd class="text-right">
              {{$reservation->bills()->first()->venue_total}}
            </dd>
          </div>
        </dl>
        <div class="bill-list">
          <h3 class="row">料金内訳</h3>
          <div class="col-12 venue_price_details">
            <table class="table table-bordered">
              <thead>
                <tr style="background: #B2B2B2; color:white;">
                  <td>内容</td>
                  <td>単価</td>
                  <td>数量</td>
                  <td>金額</td>
                </tr>
              </thead>
              <tbody>
                @foreach ($breakdowns as $breakdown)
                @if ($breakdown->unit_type==1)
                <tr>
                  <td>{{$breakdown->unit_item}}</td>
                  <td>{{$breakdown->unit_cost}}</td>
                  <td>{{$breakdown->unit_count}}</td>
                  <td>{{$breakdown->unit_subtotal}}</td>
                </tr>
                @endif
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="row bill-box_wrap price-sum bill-box_cell flex-column">
            <p class="text-right">
              <span class="font-weight-bold">小計</span>
              {{number_format($reservation->bills()->first()->discount_venue_total)}}
            </p>
            <p class="text-right">
              <span>消費税</span>
              {{number_format(($reservation->bills()->first()->discount_venue_total)*0.1)}}
            </p>
            <p class="text-right">
              <span class="font-weight-bold">合計金額</span>
              {{number_format(($reservation->bills()->first()->discount_venue_total)+(($reservation->bills()->first()->discount_venue_total)*0.1))}}
            </p>
          </div>
        </div>
      </div>
      <div class="bill-box">
        <h3 class="row">備品その他</h3>
        <dl class="row bill-box_wrap">
          <div class="col-3 bill-box_cell">
            <dt>有料備品料金</dt>
            <dd>
              {{$reservation->bills()->first()->equipment_total}}
            </dd>
          </div>
          <div class="col-3 bill-box_cell">
            <dt>有料サービス料金</dt>
            <dd>
              {{$reservation->bills()->first()->service_total}}
            </dd>
          </div>
          <div class="col-3 bill-box_cell">
            <dt>荷物預かり/返送</dt>
            <dd class="d-flex align-items-center">
              {{$reservation->bills()->first()->luggage_total}}
              円
            </dd>
          </div>
          <div class="col-3 bill-box_cell">
            <dt>備品その他合計</dt>
            <dd class="text-right">
              {{$reservation->bills()->first()->equipment_service_total}}
            </dd>
          </div>
        </dl>

        <div class="bill-list">
          <h3 class="row">料金内訳</h3>
          <div class="col-12 items_equipments">
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
                @foreach ($breakdowns as $breakdown)
                @if ($breakdown->unit_type==2)
                <tr>
                  <td>{{$breakdown->unit_item}}</td>
                  <td>{{$breakdown->unit_cost}}</td>
                  <td>{{$breakdown->unit_count}}</td>
                  <td>{{$breakdown->unit_subtotal}}</td>
                </tr>
                @endif
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="row bill-box_wrap price-sum bill-box_cell flex-column">
            <p class="text-right"><span class="font-weight-bold">小計</span>
              {{number_format($reservation->bills()->first()->discount_equipment_service_total)}}
            </p>
            <p class="text-right"><span>消費税</span>
              {{number_format(($reservation->bills()->first()->discount_equipment_service_total)*0.1)}}
            </p>
            <p class="text-right"><span class="font-weight-bold">合計金額</span>
              {{number_format(($reservation->bills()->first()->discount_equipment_service_total)+(($reservation->bills()->first()->discount_equipment_service_total)*0.1))}}
            </p>
          </div>
        </div>
      </div>
      <div class="bill-box layout_price_list">
        <h3 class="row">レイアウト変更</h3>
        <dl class="row bill-box_wrap">
          <div class="col-4 bill-box_cell">
            <dt>レイアウト準備料金</dt>
            <dd>
              <p class="layout_prepare_result">
                @foreach ($breakdowns as $breakdown)
                @if ($breakdown->unit_type==3)
                @if ($breakdown->unit_item=='レイアウト準備')
                {{number_format($breakdown->unit_cost)}}
                @endif
                @endif
                @endforeach
              </p>
            </dd>
          </div>
          <div class="col-4 bill-box_cell">
            <dt>レイアウト片付料金</dt>
            <dd>
              <p class="layout_clean_result">
                @foreach ($breakdowns as $breakdown)
                @if ($breakdown->unit_type==3)
                @if ($breakdown->unit_item=='レイアウト片付')
                {{number_format($breakdown->unit_cost)}}
                @endif
                @endif
                @endforeach
              </p>
            </dd>
          </div>
          <div class="col-4 bill-box_cell">
            <dt>レイアウト変更合計</dt>
            <dd class="text-right">
              <p class="layout_total">
                {{$reservation->bills()->first()->layout_total}}
              </p>
            </dd>
          </div>
        </dl>
        <div class="bill-list">
          <h3 class="row">料金内訳</h3>
          <div class="col-12 items_equipments">
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
                @foreach ($breakdowns as $breakdown)
                @if ($breakdown->unit_type==3)
                <tr>
                  <td>{{$breakdown->unit_item}}</td>
                  <td>{{$breakdown->unit_cost}}</td>
                  <td>{{$breakdown->unit_count}}</td>
                  <td>{{$breakdown->unit_subtotal}}</td>
                </tr>
                @endif
                @endforeach
              </tbody>
            </table>
          </div>

          <div class="row bill-box_wrap price-sum bill-box_cell flex-column">
            <p class="text-right"><span class="font-weight-bold">小計</span>
              {{number_format($reservation->bills()->first()->after_duscount_layouts)}}
            </p>
            <p class="text-right"><span>消費税</span>
              {{number_format(($reservation->bills()->first()->after_duscount_layouts)*0.1)}}
            </p>
            <p class="text-right"><span class="font-weight-bold">合計金額</span>
              {{number_format(($reservation->bills()->first()->after_duscount_layouts)+(($reservation->bills()->first()->after_duscount_layouts)*0.1))}}
            </p>
          </div>
        </div>
      </div>
      <div class="bill-box">
        <h3 class="row">請求書内容</h3>
        <dl class="row bill-box_wrap">
          <div class="col-6 bill-box_cell">
            <dt><label for="billCompany">請求書の会社名</label></dt>
            <dd>{{$user->company}}</dd>
          </div>
          <div class="col-6 bill-box_cell">
            <dt><label for="billCustomer">請求書の担当者名</label></dt>
            <dd>{{$user->first_name}}{{$user->last_name}}</dd>
          </div>
          <div class="col-6 bill-box_cell">
            <dt><label for="billDate">請求日</label></dt>
            <dd>{{ReservationHelper::formatDate($reservation->created_at)}}</dd>
          </div>
          <div class="col-6 bill-box_cell">
            <dt><label for="billDue">支払期日</label></dt>
            <dd>{{ReservationHelper::formatDate($reservation->payment_limit)}}</dd>
          </div>
          <div class="col-12 bill-box_cell">
            <dt><label for="billNote">備考</label></dt>
            <dd>{{$reservation->bill_remark}}</dd>
          </div>
        </dl>
      </div>
    </div>
  </section>  -->


  <!-- @foreach ($other_bills as $key=>$other_bill)
  <div class="section-wrap">
    <div class="ttl-box d-flex align-items-center">
      <div class="col-9 d-flex justify-content-between">
        <h2>
          @if ($other_bill->category==2)
          その他の有料備品、サービス
          @elseif($other_bill->category==3)
          レイアウト
          @elseif($other_bill->category==4)
          その他
          @endif
        </h2>
      </div>
      <div class="col-3">
        @if ($other_bill->reservation_status<3) <div class="col-3">
          <p class="text-right">
            {{ link_to_route('admin.reservations.edit', '編集', $parameters = $reservation->id, ['class' => 'more_btn']) }}
          </p>
      </div>
      @endif

    </div>
  </div>
  <section class="register-wrap">

    <div class="section-header">
      <div class="row">
        <div class="d-flex col-10 flex-wrap">
          <dl>
            <dt>予約状況</dt>
            <dd>{{ReservationHelper::judgeStatus($other_bill->reservation_status)}}</dd>
          </dl>
          @if ($other_bill->double_check_status==0)
          <dl>
            <dt>一人目チェック</dt>
            <dd class="d-flex">
              <p>未</p>
              <p class="ml-2"> <button class="btn more_btn first_double_check{{$key}}">チェックをする</button> </p>
            </dd>
          </dl>
          @elseif ($other_bill->double_check_status==1)
          <dl>
            <dt>一人目チェック</dt>
            <dd class="d-flex">
              <p>{{$other_bill->double_check1_name}}</p>
            </dd>
          </dl>
          <dl>
            <dt>二人目チェック</dt>
            <dd class="d-flex">
              <p>未</p>
              <p class="ml-2"> <button class="btn more_btn second_double_check">チェックをする</button> </p>
            </dd>
          </dl>
          @elseif ($other_bill->double_check_status==2)
          <dl>
            <dt>一人目チェック</dt>
            <dd class="d-flex">
              <p>{{$other_bill->double_check1_name}}</p>
            </dd>
          </dl>
          <dl>
            <dt>二人目チェック</dt>
            <dd class="d-flex">
              <p>{{$other_bill->double_check2_name}}</p>
            </dd>
          </dl>
          @endif
        </div>
        <div class="col-2">
          <p>
            申込日：2020/10/15(木)
          </p>
          <p>
            予約確定日：2020/10/15(木)
          </p>
        </div>
      </div>
      @if ($other_bill->double_check_status==2)
      @if ($other_bill->reservation_status<=2) <div class="row justify-content-end mt-5">
        <div class="d-flex col-2 justify-content-around">
          <p class="text-right">
            {{ Form::open(['url' => 'admin/bills/other_send_approve', 'method'=>'POST', 'class'=>'']) }}
            @csrf
            {{ Form::hidden('id', $other_bill->id ) }}
            {{ Form::submit('承認',['class' => 'btn more_btn']) }}
            {{ Form::close() }}
          </p>
          <p class="text-right">
            確定ボタン（※後ほど実装）
          </p>
        </div>
    </div>
    @endif
    @endif

</div>

<section class="section-wrap section-bg">
  <div class="bill-ttl mb-5">
    <div class="section-ttl-box d-flex align-items-center">
      <div class="col-6">
        <h3 class="">請求情報</h3>
      </div>
      <div class="col-6 d-flex justify-content-end">
        <p class="text-right"><a class="more_btn" href="">請求書をみる</a></p>
        <p class="text-right ml-3"><a class="more_btn" href="">領収書をみる</a></p>
      </div>
    </div>
    <dl class="row bill-box_wrap">
      <div class="col-4 bill-box_cell">
        <dt><label for="billCompany">請求No</label></dt>
        <dd>2020092225</dd>
      </div>
      <div class="col-4 bill-box_cell">
        <dt><label for="billCustomer">請求日</label></dt>
        <dd>2020/09/02</dd>
      </div>
      <div class="col-4 bill-box_cell">
        <dt><label for="billDate">支払期日</label></dt>
        <dd>2020/12/10(木)</dd>
      </div>
    </dl>
  </div>
  <div class="bill-box">
    <h3 class="row">その他の有料備品、サービス</h3>
    <dl class="row bill-box_wrap">
      <div class="col-12 bill-box_cell">
        <dt>その他の有料備品、サービス合計</dt>
        <dd class="text-right">57,700円</dd>
      </div>

      <div class="col-6">
        <div class="row">
          <div class="col-4 bill-box_cell cell-gray">
            <p>割引率</p>
          </div>
          <div class="col-5 bill-box_cell">
            <p class="text-right"></p>
          </div>
          <div class="col-3 bill-box_cell text-right">
            <p>割引金額</p>
            <p class=""><span>円</span></p>
          </div>
        </div>
      </div>
      <div class="col-6 bill-box_cell text-right">
        <p class="font-weight-bold">割引後その他の有料備品、サービス合計</p>
        <p class=""></p>
      </div>
    </dl>
    <div class="bill-list">
      <h3 class="row">料金内訳</h3>
      <div class="col-12 venue_price_details">
        <table class="table table-bordered">
          <thead>
            <tr>
              <td>内容</td>
              <td>単価</td>
              <td>数量</td>
              <td>金額</td>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
      <div class="row bill-box_wrap price-sum bill-box_cell flex-column">
        <p class="text-right"><span class="font-weight-bold">小計</span>7,200円</p>
        <p class="text-right"><span>消費税</span>720円</p>
        <p class="text-right"><span class="font-weight-bold">合計金額</span>7,200円</p>
      </div>
    </div>
  </div>
  <div class="bill-box">
    <h3 class="row">請求書内容</h3>
    <dl class="row bill-box_wrap">
      <div class="col-6 bill-box_cell">
        <dt><label for="billCompany">請求書の会社名</label></dt>
        <dd>株式会社テスト</dd>
      </div>
      <div class="col-6 bill-box_cell">
        <dt><label for="billCustomer">請求書の担当者名</label></dt>
        <dd>山田太郎</dd>
      </div>
      <div class="col-6 bill-box_cell">
        <dt><label for="billDate">請求日</label></dt>
        <dd>2020/12/10(木)</dd>
      </div>
      <div class="col-6 bill-box_cell">
        <dt><label for="billDue">支払期日</label></dt>
        <dd>2020/12/10(木)</dd>
      </div>
      <div class="col-12 bill-box_cell">
        <dt><label for="billNote">備考</label></dt>
        <dd>テキストテキストテキストテキストテキストテキスト</dd>
      </div>
    </dl>
  </div>
  <div class="bill-box">
    <h3 class="row">入金確認</h3>
    <dl class="row bill-box_wrap">
      <div class="col-4 bill-box_cell">
        <dt><label for="payDate">入金日</label></dt>
        <dd>2020/12/21(月)</dd>
      </div>
      <div class="col-4 bill-box_cell">
        <dt><label for="payType">支払タイプ</label></dt>
        <dd>振込</dd>
      </div>
      <div class="col-4 bill-box_cell">
        <dt><label for="payStatus">入金状況</label></dt>
        <dd>入金済</dd>
      </div>
      <div class="col-12 bill-box_cell">
        <dt><label for="billNote">振込名</label></dt>
        <dd>テキストテキストテキストテキストテキストテキスト</dd>
      </div>
    </dl>
  </div>
</section>
@if ($other_bill->double_check_status==0)
<div class="checkbox section-wrap">
  <dl class="d-flex col-12 justify-content-end align-items-center">
    <dt><label for="checkname">一人目チェック者</label></dt>
    <dd>
      {{ Form::open(['url' => 'admin/bills/other_doublecheck', 'method'=>'POST', 'class'=>'']) }}
      @csrf
      {{Form::select('double_check1_name', [
        '名前test1' => '名前test1', 
        '名前test2' => '名前test2',
        '名前test3' => '名前test3',
        '名前test4' => '名前test4',], 
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
<div class="checkbox section-wrap">
  <dl class="d-flex col-12 justify-content-end align-items-center">
    <dt><label for="checkname">二人目チェック者</label></dt>
    <dd>
      {{ Form::open(['url' => 'admin/bills/other_doublecheck', 'method'=>'POST', 'class'=>'']) }}
      @csrf
      {{Form::select('double_check2_name', [
        '名前test1' => '名前test1', 
        '名前test2' => '名前test2',
        '名前test3' => '名前test3',
        '名前test4' => '名前test4',], 
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
</div>
@endforeach  -->












  <!-- 合計請求額------------------------------------------------------------------- -->
  <!-- <div class="total-sum section-wrap">
  <table class="table table-bordered">
    <thead>
      <tr class="bg-green">
        <td colspan="2">
          合計請求額
        </td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="table-active"><label for="venueFee">会場料</label></td>
        <td class="text-right">
          ※後ほど修正　5,300円
        </td>
      </tr>
      <tr>
        <td class="table-active"><label for="serviceFee">備品その他</label></td>
        <td class="text-right">
          ※後ほど修正　5,300円
        </td>
      </tr>
      <tr>
        <td class="table-active"><label for="layoutFee">レイアウト変更</label></td>
        <td class="text-right">
          ※後ほど修正　5,300円
        </td>
      </tr>
      <tr>
        <td class="table-active"><label for="layoutFee">キャンセル料</label></td>
        <td class="text-right">
          ※後ほど修正　5,300円
        </td>
      </tr>
      <tr>
        <td colspan="2" class="text-right">
          <p><span class="font-weight-bold">小計</span>7,200円</p>
          <p><span>消費税</span>720円</p>
        </td>
      </tr>
      <tr>
        <td colspan="2" class="text-right"><span class="font-weight-bold">請求総額</span>※後ほど修正　7,200円</td>
      </tr>
    </tbody>
  </table>
</div> -->


  <!-- チェックボックス ----------------------------------------------------------------------------->
  <!-- @if ($reservation->bills()->first()->double_check_status==0)
<div class="checkbox section-wrap">
  <dl class="d-flex col-12 justify-content-end align-items-center">
    <dt><label for="checkname">一人目チェック者</label></dt>
    <dd>
      {{ Form::model($reservation->id, ['route'=> ['admin.reservations.double_check',$reservation->id]]) }}
  @csrf
  {{Form::select('double_check1_name', [
        '名前test1' => '名前test1', 
        '名前test2' => '名前test2',
        '名前test3' => '名前test3',
        '名前test4' => '名前test4',], 
        null, ['placeholder' => '選択してください', 'class'=>'form-control double_check1_name'])}}
  {{ Form::hidden('double_check_status', $reservation->bills()->first()->double_check_status ) }}
  </dd>
  <dd>
    <p class="text-right">
      {{Form::submit('チェック完了', ['class'=>'btn more_btn', 'id'=>'double_check1_submit'])}}
      {{ Form::close() }}

    </p>
  </dd>
  </dl>
</div>
@elseif($reservation->bills()->first()->double_check_status==1)
<div class="checkbox section-wrap">
  <dl class="d-flex col-12 justify-content-end align-items-center">
    <dt><label for="checkname">二人目チェック者</label></dt>
    <dd>
      {{ Form::model($reservation->id, ['route'=> ['admin.reservations.double_check',$reservation->id]]) }}
      @csrf
      {{Form::select('double_check2_name', [
        '名前test1' => '名前test1', 
        '名前test2' => '名前test2',
        '名前test3' => '名前test3',
        '名前test4' => '名前test4',], 
        null, ['placeholder' => '選択してください', 'class'=>'form-control double_check2_name'])}}
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
@endif -->












  @endsection