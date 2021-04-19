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
    {{ Form::open(['url' => 'admin/agents_reservations/add_bills/'.$reservation->id, 'method'=>'POST', 'class'=>'']) }}
    @csrf
    {{ Form::hidden('reservation_id', $reservation->id ) }}
    {{ Form::submit('追加の請求書を作成する',['class' => 'btn more_btn3']) }}
    {{ Form::close() }}
  </p>
  @endif
  @endif

</div>
<div class="alert-box d-flex align-items-center mb-0">
  <!-- <span class="mr-3"><i class="fas alert-icon fa-exclamation-triangle" aria-hidden="true"></i></span> -->
  <p>
    一人目のチェックが終了しています。ダブルチェックを行ってください。
    工藤さん！！一人目チェックが完了時に、表示をお願いします。
  </p>
</div>　

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
            <p>
              {{($reservation->price_system==1?'通常（枠貸）':"アクセア（時間貸）")}}
            </p>
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
              <p class="title-icon fw-bolder">
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
            <!-- <tr>
              <td class="table-active"><label for="Delivery">荷物預り/返送</label></td>
              <td>
                @foreach ($reservation->breakdowns()->get() as $breakdown)
                {{$breakdown->unit_item=='荷物預り/返送'?'あり':''}}
                @endforeach
              </td>
            </tr> -->
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
    <div class="col">
      <div class="customer-table">
        <table class="table table-bordered name-table">
          <tr>
            <td colspan="2">
              <div class="d-flex align-items-center justify-content-between">
                <p class="title-icon">
                  <i class="far fa-address-card icon-size"></i>
                  顧客情報
                </p>
                <p><a class="more_btn" href="{{url('admin/clients/'.$reservation->user_id)}}">顧客詳細</a></p>
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
              {{ReservationHelper::getPersonName($user->id)}}
            </td>
          </tr>
          <tr>
            <td class="table-active">メールアドレス</td>
            <td>
              {{$user->email}}
            </td>
          </tr>
          <tr>
            <td class="table-active">携帯番号 </td>
            <td>
              <p class="mobile"> {{$user->mobile}} </p>
            </td>
          </tr>
          <tr>
            <td class="table-active">固定電話 </td>
            <td>
              <p class="tel">{{$user->tel}}</p>
            </td>
          </tr>
          <tr class="caution">
            <td colspan="2">
              <p>注意事項</p>
              <p>
                {{$user->attention}}
              </p>
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

      @if ($venue->alliance_flag!=0)

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
      @endif

      <table class="table table-bordered note-table">
        <tr>
          <td colspan="2">
            <p class="title-icon">
              <i class="fas fa-file-alt icon-size"></i>
              備考
            </p>
          </td>
        </tr>
        <!-- <tr>
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
            </tr> -->
        <tr>
          <td>
            <p>申し込みフォーム備考</p>
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
    @else
    <div class="col">
      <div class="client_mater">
        <table class="table table-bordered name-table">
          <tr>
            <td colspan="2">
              <div class="d-flex align-items-center justify-content-between">
                <p class="title-icon">
                  <i class="far fa-id-card icon-size"></i>仲介会社情報
                </p>
                <p><a class="more_btn" href="">仲介会社詳細工藤さん！リンク</a></p>
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="agent_id">サービス名称</label>
            </td>
            <td>
              {{ReservationHelper::getAgentCompany($reservation->agent_id)}}
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
              {{$reservation->enduser->company}}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_address" class=" ">住所</label>
            </td>
            <td>
              {{$reservation->enduser->address}}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_tel" class="">連絡先</label>
            </td>
            <td>
              {{$reservation->enduser->tel}}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_mail" class=" ">メールアドレス</label>
            </td>
            <td>
              {{$reservation->enduser->email}}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_incharge" class="">当日担当者</label>
            </td>
            <td>
              {{$reservation->enduser->person}}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="" class="">当日連絡先</label>
            </td>
            <td>
              {{$reservation->enduser->mobile}}
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="enduser_attr" class="">利用者属性</label>
            </td>
            <td>
              {{$reservation->enduser->attr}}
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
          <td class="table-active">
            <label for="enduser_charge ">支払い料</label>
          </td>
          <td class="d-flex align-items-center">
            {{number_format($reservation->enduser->charge)}}円
          </td>
        </tr>
      </table>
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
            <label for="userNote">申し込みフォーム備考</label>
            <div>{{$reservation->user_details}}</div>
          </td>
        </tr>
        <tr>
          <td>
            <label for="adminNote">管理者備考</label>
            <div>{{$reservation->admin_details}}</div>
          </td>
        </tr>
      </table>
    </div>
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
                <!-- </td> -->
                <!-- <td> -->
                <dl class="ttl_box">
                  <dt>支払い期日：</dt>
                  <dd class="total_result">
                    {{ReservationHelper::formatDate($reservation->bills()->first()->payment_limit)}}
                  </dd>
                </dl>
                <!-- </td> -->
                <!-- <td> -->
                @if ($reservation->bills()->first()->reservation_status<3) <p>
                  <a href="{{url('admin/reservations/'.$reservation->bills()->first()->id.'/edit')}}"
                    class="btn more_btn">編集</a>
                  </p>
                  @endif
              </div>
            </td>
          </tr>
          <!-- <tr>
              <td></td>
              <td>
                <div class="bg-white d-flex justify-content-around align-items-center">
                  <div>支払い期日</div>
                  <div>{{ReservationHelper::formatDate($reservation->bills()->first()->payment_limit)}}</div>
                </div>
              </td>
            </tr> -->
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
            <!-- @if ($reservation->bills()->first()->reservation_status==3)
            <td>
              <div>
                {{ Form::open(['url' => 'admin/cxl/create', 'method'=>'POST', 'class'=>'']) }}
                @csrf
                {{ Form::hidden('reservation_id', $reservation->id ) }}
                {{ Form::hidden('bills_id', $reservation->bills()->first()->id ) }}
                {{ Form::submit('キャンセル',['class' => 'btn more_btn4']) }}
                {{ Form::close() }}
              </div>
            </td>
            @endif -->
          </tr>
        </tbody>
      </table>
      <div class="approve_or_confirm">
        @if ($reservation->user_id>0)
        @if ($reservation->bills()->first()->double_check_status==2)
        <!-- 利用者に承認メールを送る確認ボタン-ダブルチェック後に表示------ -->
        {{-- 予約完了後、非表示 --}}
        @if ($reservation->bills()->first()->reservation_status<=2) <div class="d-flex justify-content-end mt-2 mb-2">
          {{-- 予約ステータスを2にして、ユーザーにメール送付 --}}
          {{-- <a class="more_btn" href="">利用者に承認メールを送る</a> --}}
          {{ Form::open(['url' => 'admin/reservations/'.$reservation->id.'/send_email_and_approve', 'method'=>'POST', 'class'=>'']) }}
          @csrf
          {{ Form::hidden('reservation_id', $reservation->id ) }}
          {{ Form::hidden('user_id', $reservation->user_id ) }}
          <p class="mr-2">{{ Form::submit('利用者に承認メールを送る',['class' => 'btn more_btn','id'=>'send_confirm']) }}</p>
          {{ Form::close() }}
          {{ Form::open(['url' => 'admin/reservations/'.$reservation->id.'/confirm_reservation', 'method'=>'POST', 'class'=>'']) }}
          @csrf
          {{ Form::hidden('reservation_id', $reservation->id ) }}
          {{ Form::hidden('user_id', $reservation->user_id ) }}
          <p>{{ Form::submit('予約を確定する',['class' => 'btn more_btn4','id'=>'reservation_confirm']) }}</p>
          {{ Form::close() }}
      </div>
      @endif
      @endif
      @else
      @if ($reservation->bills()->first()->double_check_status==2)
      <!-- 利用者に承認メールを送る確認ボタン-ダブルチェック後に表示------ -->
      {{-- 予約完了後、非表示 --}}
      @if ($reservation->bills()->first()->reservation_status<=2) <div class="d-flex justify-content-end mt-2 mb-2">
        {{-- <a class="more_btn4" href="">予約を確定する</a> --}}
        {{ Form::open(['url' => 'admin/reservations/'.$reservation->id.'/confirm_reservation', 'method'=>'POST', 'class'=>'']) }}
        @csrf
        {{ Form::hidden('reservation_id', $reservation->id ) }}
        {{ Form::hidden('user_id', $reservation->user_id ) }}
        <p>{{ Form::submit('予約を確定する',['class' => 'btn more_btn4']) }}</p>
        <span>※仲介会社経由の予約は予約を確定するのみ。メール送信は扶養</span>
        {{ Form::close() }}
    </div>
    @endif
    @endif
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
              <td colspan="3"></td>
              <td colspan="1" class="">合計：{{number_format($reservation->bills()->first()->venue_price)}}</td>
            </tr>
          </tbody>
        </table>
      </div>
      @else
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
            @foreach ($reservation->bills()->first()->breakdowns()->get() as $venue_breakdown)
            @if ($venue_breakdown->unit_type==1)
            <tr>
              <td>{{$venue_breakdown->unit_item}}</td>
              <td></td>
              <td>{{$venue_breakdown->unit_count}}</td>
              <td></td>
            </tr>
            @endif
            @endforeach
          </tbody>
        </table>
      </div>
      @endif

      @if ($reservation->user_id>0)
      @if ($reservation->bills()->first()->equipment_price!=0||$reservation->bills()->first()->equipment_price)
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
              <td colspan="3"></td>
              <td colspan="1" class="">合計：{{number_format($reservation->bills()->first()->equipment_price)}}</td>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      @endif
      @else
      <div class="equipment billdetails_content">
        <table class="table table-borderless">
          <tbody>
            <tr>
              <td>
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
            @foreach ($reservation->bills()->first()->breakdowns()->get() as $equipment_breakdown)
            @if ($equipment_breakdown->unit_type==2)
            <tr>
              <td>{{$equipment_breakdown->unit_item}}</td>
              <td></td>
              <td>{{$equipment_breakdown->unit_count}}</td>
              <td></td>
            </tr>
            @endif
            @endforeach
            @foreach ($reservation->bills()->first()->breakdowns()->get() as $service_breakdown)
            @if ($service_breakdown->unit_type==3)
            <tr>
              <td>{{$service_breakdown->unit_item}}</td>
              <td></td>
              <td>{{$service_breakdown->unit_count}}</td>
              <td></td>
            </tr>
            @endif
            @endforeach
          </tbody>
        </table>
      </div>
      @endif



      @if ($reservation->user_id>0)
      @if ($reservation->bills()->first()->layout_price!=0||$reservation->bills()->first()->layout_price)
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
              <td colspan="3"></td>
              <td colspan="1">合計：{{number_format($reservation->bills()->first()->layout_price)}}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      @endif
      @else
      <div class="layout billdetails_content">
        <table class="table table-borderless">
          <tbody>
            <tr>
              <td colspan="2">
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
            @foreach ($reservation->bills()->first()->breakdowns()->get() as $layout_breakdown)
            @if ($layout_breakdown->unit_type==4)
            <tr>
              <td>{{$layout_breakdown->unit_item}}</td>
              <td></td>
              <td>{{$layout_breakdown->unit_count}}</td>
              <td></td>
            </tr>
            @endif
            @endforeach
          </tbody>
        </table>
      </div>
      @endif

      @if ($reservation->user_id>0)
      @if ($reservation->bills()->first()->others_price!=0||$reservation->bills()->first()->others_price)
      <div class="others billdetails_content">
        <table class="table table-borderless">
          <tbody>
            <tr>
              <td colspan="4">
                　<h4 class="billdetails_content_ttl">
                  その他
                </h4>
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
              <td colspan="3"></td>
              <td colspan="1">合計：{{$reservation->bills()->first()->others_price}}
            </tr>
          </tbody>
        </table>
      </div>
      @endif
      @else
      <div class="others billdetails_content">
        <table class="table table-borderless">
          <tbody>
            <tr>
              <td>
                　<h4 class="billdetails_content_ttl">
                  その他
                </h4>
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
              <td></td>
              <td>{{$others_breakdown->unit_count}}</td>
              <td></td>
            </tr>
            @endif
            @endforeach
          </tbody>
        </table>
      </div>
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
  {{-- test --}}
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
                <!-- </td> -->
                <!-- <td> -->
                <dl class="ttl_box">
                  <dt>支払い期日：</dt>
                  <dd class="total_result">{{ReservationHelper::formatDate($other_bill->payment_limit)}}</dd>
                </dl>
                <!-- </td> -->
                <!-- <td> -->
                <p><a href="{{url('admin/bills/'.$other_bill->id.'/edit')}}" class="btn more_btn">編集</a></p>
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

          <p class="mr-2">{{ Form::submit('利用者に承認メールを送る',['class' => 'btn more_btn']) }}</p>
          {{ Form::close() }}
          {{ Form::open(['url' => 'admin/agents_reservations/confirm', 'method'=>'POST', 'class'=>'']) }}
          @csrf
          {{ Form::hidden('bill_id', $other_bill->id ) }}
          <p>{{ Form::submit('予約を確定する',['class' => 'btn more_btn4']) }}</p>
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
        @if ($other_bill->venue_price!=0||$other_bill->venue_price)
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
              @foreach ($other_bill->breakdowns()->get() as $venue_breakdown)
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
                <td colspan="3"></td>
                <td colspan="1" class="">合計：{{number_format($other_bill->venue_price)}}</td>
              </tr>
            </tbody>
          </table>
        </div>
        @endif


        @if ($other_bill->equipment_price!=0||$other_bill->equipment_price)
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
              @foreach ($other_bill->breakdowns()->get() as $equipment_breakdown)
              @if ($equipment_breakdown->unit_type==2)
              <tr>
                <td>{{$equipment_breakdown->unit_item}}</td>
                <td>{{number_format($equipment_breakdown->unit_cost)}}</td>
                <td>{{$equipment_breakdown->unit_count}}</td>
                <td>{{number_format($equipment_breakdown->unit_subtotal)}}</td>
              </tr>
              @endif
              @endforeach
              @foreach ($other_bill->breakdowns()->get() as $service_breakdown)
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
                <td colspan="3"></td>
                <td colspan="1" class="">合計：{{number_format($other_bill->equipment_price)}}</td>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        @endif

        @if ($other_bill->layout_price!=0||$other_bill->layout_price)
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
              @foreach ($other_bill->breakdowns()->get() as $layout_breakdown)
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
                <td colspan="3"></td>
                <td colspan="1">合計：{{number_format($other_bill->layout_price)}}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        @endif


        @if ($other_bill->others_price!=0||$other_bill->others_price)
        <div class="others billdetails_content">
          <table class="table table-borderless">
            <tbody>
              <tr>
                <td colspan="4">
                  　<h4 class="billdetails_content_ttl">
                    その他
                  </h4>
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
              @foreach ($other_bill->breakdowns()->get() as $others_breakdown)
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
                <td colspan="3"></td>
                <td colspan="1">合計：{{$other_bill->others_price}}
              </tr>
            </tbody>
          </table>
        </div>
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
    <div class="bill_head2">
      <table class="table bill_table pt-2">
        <tbody>
          <tr>
            <td>
              <h2 class="text-white">
                丸岡さん!! ここピンク色にしてください　　　
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
            {{ Form::submit('利用者にキャンセル承認メールを送る',['class' => 'btn more_btn']) }}
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
        <div class="venues billdetails_content">
          <div>
            丸岡さん!!! ここにキャンセル料計算のデザイン（中務さんからいただいた）お願いします
            <table class="table">
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

<div class="master_totals border-wrap">
  <table class="table">
    <tbody class="master_total_head">
      <tr>
        <td colspan="2">
          <h3>
            キャンセル料　合計請求額
            丸岡さん!!! ここの色も変更必要かと思います
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
  $(function(){
  $('#double_check1_submit,#double_check2_submit').on('click',function(){
      if(!confirm('チェック完了しますか？')){
        return false;
      }
  });
  $('#send_confirm').on('click',function(){
      if(!confirm('利用者に承認メールを送付しますか？')){
        return false;
      }
  });
  $('#reservation_confirm').on('click',function(){
      if(!confirm('予約を確定しますか？')){
        return false;
      }
  });
  });
</script>






@endsection