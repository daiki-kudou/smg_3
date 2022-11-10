@extends('layouts.user.app')
@section('content')
    <link href="{{ asset('/css/template.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/template.js') }}"></script>
    <script src="{{ asset('/js/lettercounter.js') }}"></script>
    <script src="{{ asset('/js/user/validation.js') }}"></script>
    <script src="{{ asset('/js/holidays.js') }}"></script>
    <script src="{{ asset('/js/edit_luggage_date.js') }}"></script>

    <div class="container-field mt-3 d-md-flex justify-content-md-between">
        <h2 class="mt-3 mb-md-5">仮押え 申込み</h2>
        <div class="">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">
                        {{ Breadcrumbs::render(Route::currentRouteName(), $pre_reservation->id) }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <hr>

    @if ($pre_reservation->status == 1)
        <div class="confirm-box text-md-center mt-5">
            <p class="f-wb">
                内容と金額をご確認下さい。<br>
                問題なければ下部「予約を申し込む」ボタンをクリックして下さい。<br>
                ※内容を変更したい場合は「仮押え内容」を変更後、改めて「再計算する」ボタンをクリックして下さい。
            </p>
        </div>
    @endif

    {{ Form::open(['url' => '/user/pre_reservations/' . $pre_reservation->id . '/calculate', 'method' => 'POST', 'id' => 'mypageDone', 'autocomplete' => 'off']) }}
    @csrf
    {{ Form::hidden('venue_id', $pre_reservation->venue_id) }}
    {{ Form::hidden('user_id', $pre_reservation->user_id) }}
    {{ Form::hidden('agent_id', $pre_reservation->agent_id) }}
    {{ Form::hidden('price_system', $pre_reservation->price_system) }}
    {{ Form::hidden('enter_time', $pre_reservation->enter_time) }}
    {{ Form::hidden('leave_time', $pre_reservation->leave_time) }}
    {{ Form::hidden('luggage_price', 0) }}
    {{ Form::hidden('email_flag', $pre_reservation->email_flag) }}
    {{ Form::hidden('cost', $pre_reservation->cost) }}
    {{ Form::hidden('discount_condition', $pre_reservation->discount_condition) }}
    {{ Form::hidden('attention', $pre_reservation->attention) }}
    {{ Form::hidden('multiple_reserve_id', $pre_reservation->multiple_reserve_id) }}
    {{ Form::hidden('admin_details', $pre_reservation->admin_details) }}

    {{ Form::hidden('bill_company', $user->company) }}
    {{ Form::hidden('bill_person', ReservationHelper::getPersonName($user->id)) }}
    {{ Form::hidden('bill_person', ReservationHelper::getPersonName($user->id)) }}
    {{ Form::hidden('bill_created_at', date('Y-m-d', strtotime(Carbon\Carbon::now()))) }}
    {{ Form::hidden('paid', 0) }}
    {{ Form::hidden('pay_day', '') }}
    {{ Form::hidden('pay_person', '') }}
    {{ Form::hidden('payment', 0) }}
    {{ Form::hidden('admin_judge', 2) }}

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
        <div class="border-wrap2 p-4">
            <div class="row user_wrap">
                <div class="col-md-6 col-12">
                    <table class="table table-bordered mb-0">
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <p class="title-icon">
                                        <i class="fas fa-info-circle icon-size" aria-hidden="true"></i>
                                        仮押え情報
                                        <span class="ml-3">仮押えID：{{ ReservationHelper::fixId($pre_reservation->id) }}</span>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td class="table-active">利用日</td>
                                <td>
                                    {{ ReservationHelper::formatDate($pre_reservation->reserve_date) }}
                                    {{ Form::hidden('reserve_date', $pre_reservation->reserve_date) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="table-active">会場</td>
                                <td>
                                    {{ ReservationHelper::getVenueForUser($venue->id) }}
                                    <div>{{ $pre_reservation->price_system == 1 ? '通常（枠貸）' : '(音響HG)' }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td class="table-active">入室時間</td>
                                <td>
                                    {{ ReservationHelper::formatTime($pre_reservation->enter_time) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="table-active">退室時間</td>
                                <td>
                                    {{ ReservationHelper::formatTime($pre_reservation->leave_time) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="warning-text mb-3 mt-1">※入室時間より以前に入室はできません。</p>

                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <p class="title-icon">
                                        <i class="fas fa-user-check icon-size" aria-hidden="true"></i>
                                        当日連絡できる担当者名
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td class="table-active">
                                    <label for="ondayName" class="form_required">氏名</label>
                                </td>
                                <td>
                                    {{ Form::text('in_charge', $request->in_charge, ['class' => 'form-control']) }}
                                    <p class="is-error-in_charge" style="color: red"></p>
                                </td>
                            </tr>
                            <tr>
                                <td class="table-active"><label for="mobilePhone" class=" form_required">携帯番号</label></td>
                                <td>
                                    {{ Form::text('tel', $request->tel, ['class' => 'form-control']) }}
                                    <p class="is-error-tel" style="color: red"></p>
                                    <p class="annotation mt-1">※必ず当日連絡が付く担当者の連絡番号を記載下さい。<br>
                                        ※半角数字、ハイフンなしで入力下さい。</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered board-table mb-0">
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <p class="title-icon">
                                            <i class="fas fa-clipboard icon-size" aria-hidden="true"></i>案内版
                                        </p>
                                        <p>
                                            <a target="_blank" rel="noopener noreferrer" href="https://system.osaka-conference.com/welcomboard/">
                                                <i class="fas fa-external-link-alt form-icon"></i>
                                                案内板サンプルはこちら
                                            </a>
                                        </p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="table-active form_required">案内板</td>
                                <td>
                                    <div class="radio-box">
                                        <p>
                                            {{ Form::radio('board_flag', 1, $request->board_flag == 1 ? true : false, ['class' => '', 'id' => 'board_flag']) }}
                                            {{ Form::label('board_flag', 'あり') }}
                                        </p>
                                        <p>
                                            {{ Form::radio('board_flag', 0, $request->board_flag == 0 ? true : false, ['class' => '', 'id' => 'no_board_flag']) }}
                                            {{ Form::label('no_board_flag', 'なし') }}
                                        </p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="table-active" id="eventRequired">イベント名称1</td>
                                <td>
                                    <div class="align-items-end d-flex">
                                        {{ Form::text('event_name1', $request->event_name1, ['class' => 'form-control', 'id' => 'eventname1Count']) }}
                                        <span class="ml-1 annotation count_num1"></span>
                                    </div>
                                    <p class="is-error-event_name1" style="color: red"></p>
                                </td>
                            </tr>
                            <tr>
                                <td class="table-active">イベント名称2</td>
                                <td>
                                    <div class="align-items-end d-flex">
                                        {{ Form::text('event_name2', $request->event_name2, ['class' => 'form-control', 'id' => 'eventname2Count']) }}
                                        <span class="ml-1 annotation count_num2"></span>
                                    </div>
                                    <p class="is-error-event_name2" style="color: red"></p>
                                </td>
                            </tr>
                            <tr>
                                <td class="table-active">主催者名</td>
                                <td>
                                    <div class="align-items-end d-flex">
                                        {{ Form::text('event_owner', $request->event_owner, ['class' => 'form-control', 'id' => 'eventownerCount']) }}
                                        <span class="ml-1 annotation count_num3"></span>
                                    </div>
                                    <p class="is-error-event_owner" style="color: red"></p>
                                </td>
                            </tr>
                            <tr>
                                <td class="table-active">イベント開始時間</td>
                                <td>
                                    <select name="event_start" id="event_start" class="form-control">
                                        <option disabled>選択してください</option>
                                        {!! ReservationHelper::timeOptionsWithRequestAndLimit($request->event_start, $pre_reservation->enter_time, $pre_reservation->leave_time) !!}
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="table-active">イベント終了時間</td>
                                <td>
                                    <select name="event_finish" id="event_finish" class="form-control">
                                        <option disabled>選択してください</option>
                                        {!! ReservationHelper::timeOptionsWithRequestAndLimit($request->event_finish, $pre_reservation->enter_time, $pre_reservation->leave_time) !!}
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="warning-text mb-3 mt-1">※イベント時間を非表示にする場合は、イベント開始・終了時間ともに「00時00分」を選択して下さい。</p>
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
                            <tbody class="accordion-wrap" style="display: none;">
                                @foreach ($venue->getEquipments() as $key => $equ)
                                    <tr>
                                        <td class="table-active">
                                            {{ $equ->item }}
                                            ({{ number_format($equ->price) . '円' }})
                                        </td>
                                        <td>
                                            {{ Form::number('equipment_breakdown[]', $request->equipment_breakdown[$key], [
                                                'class' => 'form-control
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          equipment_validation',
                                                'autocomplete="off"',
                                            ]) }}
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
                                @foreach ($venue->getServices() as $key => $ser)
                                    <tr>
                                        <td class="table-active">
                                            {{ $ser->item }}
                                            ({{ number_format($ser->price) . '円' }})
                                        </td>
                                        <td>
                                            <div class="radio-box">
                                                <p>
                                                    {{ Form::radio("services_breakdown[$key]", 1, (int) $request->services_breakdown[$key] === 1 ? true : false, [
                                                        'id' => 'service' . $key . 'on',
                                                        'class' => '',
                                                    ]) }}
                                                    {{ Form::label('service' . $key . 'on', 'あり') }}
                                                </p>
                                                <p>
                                                    {{ Form::radio("services_breakdown[$key]", 0, (int) $request->services_breakdown[$key] == 0 ? true : false, [
                                                        'id' => 'services_breakdown' . $key . 'off',
                                                        'class' => '',
                                                    ]) }}
                                                    {{ Form::label('services_breakdown' . $key . 'off', 'なし') }}
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($pre_reservation->venue->layout == 1)
                        <div class="layouts">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th colspan="2">
                                            <p class="title-icon py-1">
                                                <i class="fas fa-th icon-size" aria-hidden="true"></i>レイアウト変更
                                            </p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="table-active">レイアウト準備
                                            (
                                            {{ !empty($pre_reservation->venue->layout_prepare) ? number_format($pre_reservation->venue->layout_prepare) . '円' : null }}
                                            )
                                        </td>
                                        <td>
                                            <div class="radio-box">
                                                <p>
                                                    {{ Form::radio('layout_prepare', 1, $request->layout_prepare == 1 ? true : false, [
                                                        'id' => 'layout_prepare',
                                                        'class' => '',
                                                    ]) }}
                                                    {{ Form::label('layout_prepare', 'あり') }}
                                                </p>
                                                <p>
                                                    {{ Form::radio('layout_prepare', 0, $request->layout_prepare == 0 ? true : false, [
                                                        'id' => 'no_layout_prepare',
                                                        'class' => '',
                                                    ]) }}
                                                    {{ Form::label('no_layout_prepare', 'なし') }}
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-active">レイアウト片付
                                            (
                                            {{ !empty($pre_reservation->venue->layout_clean) ? number_format($pre_reservation->venue->layout_clean) . '円' : null }}
                                            )
                                        </td>
                                        <td>
                                            <div class="radio-box">
                                                <p>
                                                    {{ Form::radio('layout_clean', 1, $request->layout_clean == 1 ? true : false, [
                                                        'id' => 'layout_clean',
                                                        'class' => '',
                                                    ]) }}
                                                    {{ Form::label('layout_clean', 'あり') }}
                                                </p>
                                                <p>
                                                    {{ Form::radio('layout_clean', 0, $request->layout_clean == 0 ? true : false, [
                                                        'id' => 'no_layout_clean',
                                                        'class' => '',
                                                    ]) }}
                                                    {{ Form::label('no_layout_clean', 'なし') }}
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if ((int) $venue->luggage_flag === 1)
                        <div class="luggage">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th colspan="2">
                                            <p class="title-icon">
                                                <i class="fas fa-suitcase-rolling icon-size" aria-hidden="true"></i>荷物預かり
                                            </p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="table-active form_required">荷物預かり</td>
                                        <td>
                                            <div class="radio-box">
                                                <p>
                                                    {{ Form::radio('luggage_flag', 1, (int) $request->luggage_flag === 1 ? true : false, ['id' => 'luggage_flag']) }}
                                                    {{ Form::label('luggage_flag', 'あり') }} </p>
                                                <p>
                                                    {{ Form::radio('luggage_flag', 0, (int) $request->luggage_flag === 0 ? true : false, [
                                                        'id' => 'no_luggage_flag',
                                                    ]) }}
                                                    {{ Form::label('no_luggage_flag', 'なし') }}
                                                </p>
                                                <div>500円(税抜)</div>
                                            </div>
                                            <p class="is-error-luggage_flag" style="color: red"></p>
                                            <div class="mt-2 luggage-border">
                                            【事前・事後】預かりの荷物について<br>
                                            事前預かり/事後返送ともに<span class="f-s20">5個</span>まで。<br>
                                            6個以上は要相談。その際は事前に必ずお問い合わせ下さい。<br>
                                            荷物外寸合計(縦・横・奥行)120cm以下/個
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-active">事前に預かる荷物(目安)</td>
                                        <td>
                                            @if ($request->luggage_flag == 1)
                                                {{ Form::number('luggage_count', $request->luggage_count??null, [
                                                    'class' => 'form-control',
                                                    'id' => 'luggage_count',
                                                    'autocomplete="off"',
                                                ]) }}
                                            @else
                                                {{ Form::number('luggage_count', '', [
                                                    'class' => 'form-control',
                                                    'id' => 'luggage_count',
                                                    'autocomplete="off"',
                                                ]) }}
                                            @endif
                                            <p class="is-error-luggage_count" style="color: red"></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-active">事前荷物の到着日<br>(平日午前指定)</td>
                                        <td>
                                        <div id="luggage-arrive-main">
                                            @if ($request->luggage_flag == 1)
                                                {{ Form::text('luggage_arrive', !empty($request->luggage_arrive)?date('Y-m-d', strtotime($request->luggage_arrive)):null, [
                                                    'class' => 'form-control luggage_arrive holidays',
                                                    'id' => 'luggage_arrive',
                                                ]) }}
                                            @else
                                                {{ Form::text('luggage_arrive', '', [
                                                    'class' => 'form-control luggage_arrive holidays',
                                                    'id' => 'luggage_arrive',
                                                ]) }}
                                            @endif
                                            <span id="changeLuggageArriveDate" class="luggage-arrive-day-of-week-2"></span>
                                            </div>
                                            <div class="mt-1 luggage_info">
                                                ※利用日3日前～前日（平日のみ）を到着日に指定下さい<br>
                                                ※送付詳細 / 伝票記載方法は該当会場詳細ページ「備品 / サービス」タブの「荷物預かり / 返送 PDF」をご確認下さい。<br>
                                                ※発送伝票（元払）/ 返送伝票（着払）は各自ご用意下さい。<br>
                                                ※貴重品等のお預りはできかねます。<br>
                                                ※事前荷物は入室時間迄に弊社が会場搬入します。
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-active">事後返送するお荷物</td>
                                        <td>
                                            @if ($request->luggage_flag == 1)
                                                {{ Form::number('luggage_return', $request->luggage_return, [
                                                    'class' => 'form-control',
                                                    'id' => 'luggage_return',
                                                    'autocomplete="off"',
                                                ]) }}
                                            @else
                                                {{ Form::number('luggage_return', '', [
                                                    'class' => 'form-control',
                                                    'id' => 'luggage_return',
                                                    'autocomplete="off"',
                                                ]) }}
                                            @endif
                                            <p class="is-error-luggage_return" style="color: red"></p>
                                            <div class="mt-1 luggage_info">
                                                ※返送時の「発送伝票（元払）/返送伝票（着払）」は会場内に用意しているものを必ず使用して下さい。
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if ((int) $venue->eat_in_flag === 1)
                        <div class="eat_in">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th colspan='2'>
                                            <p class="title-icon form_required">
                                                <i class="fas fa-utensils icon-size fa-fw"></i>室内飲食
                                            </p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            {{ Form::radio('eat_in', 1, (int) $request->eat_in === 1 ? true : false, ['id' => 'eat_in']) }}
                                            {{ Form::label('eat_in', 'あり') }} </td>
                                        <td>
                                            {{ Form::radio('eat_in_prepare', 1, (int) $request->eat_in === 1 ? ((int) $request->eat_in_prepare === 1 ? true : false) : true, ['id' => 'eat_in_prepare', (int) $request->eat_in === 1 ? '' : 'disabled']) }}
                                            {{ Form::label('eat_in_prepare', '手配済み') }}
                                            {{ Form::radio('eat_in_prepare', 2, (int) $request->eat_in === 1 ? ((int) $request->eat_in_prepare === 2 ? true : false) : false, ['id' => 'eat_in_consider', (int) $request->eat_in === 1 ? '' : 'disabled']) }}
                                            {{ Form::label('eat_in_consider', '検討中') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ Form::radio('eat_in', 0, (int) $request->eat_in === 0 ? true : false, ['id' => 'no_eat_in']) }}
                                            {{ Form::label('no_eat_in', 'なし') }} </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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
                                    <label for="userNote">備考</label>
                                    {{ Form::textarea('user_details', $request->user_details, ['class' => 'form-control']) }}
                                    <div class="annotation mt-2">※入力に際し旧漢字・機種依存文字などはご使用になれません。</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="btn_wrapper">
            {{ Form::submit('再計算する', ['class' => 'btn more_btn_lg mx-auto d-block mt-5 mb-2', 'name' => 're_calculate']) }}
            <p class="text-center warning-text">※予約内容に変更・修正を加えた場合は「再計算する」ボタンを押して下さい。</p>
        </div>

        <div class="bill mt-5">
            <div class="bill_head">
                <table class="table" style="table-layout: fixed">
                    <tbody>
                        <tr>
                            <td>
                                <ul class="bill_header">
                                    <li>
                                        <h2 class="text-white">
                                            ご利用料金
                                        </h2>
                                    </li>
                                    <li>
                                        <dl class="ttl_box">
                                            <dd class="total_result">
                                                合計金額：{{ number_format(ReservationHelper::taxAndPrice($master)) }}円</dd>
                                        </dl>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="bill_details user_preservation">
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
                                    <td colspan="4">
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
                                @foreach ($pre_reservation->pre_breakdowns()->where('unit_type', 1)->get() as $key => $price_details)
                                    <tr>
                                        <td>
                                            {{ Form::text('venue_breakdown_item[]', $price_details->unit_item, ['class' => 'form-control', 'readonly']) }}
                                        </td>
                                        <td>
                                            {{ Form::text('venue_breakdown_cost[]', $price_details->unit_cost, ['class' => 'form-control', 'readonly']) }}
                                        </td>
                                        <td>
                                            {{ Form::text('venue_breakdown_count[]', $price_details->unit_count, ['class' => 'form-control', 'readonly']) }}
                                        </td>
                                        <td>
                                            {{ Form::text('venue_breakdown_subtotal[]', $price_details->unit_subtotal, [
                                                'class' => 'form-control',
                                                'readonly',
                                            ]) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tbody class="venue_result">
                                <tr>
                                    <td colspan="4">
                                        <div class="result_sum">
                                            <p class="text-left">合計</p>
                                            {{ Form::text('venue_price', $venue_price, ['class' => 'form-control col-xs-3', 'readonly']) }}
                                        </div>
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
                                @foreach ($item_details[1] as $key => $item)
                                    <tr>
                                        <td>
                                            {{ Form::text('equipment_breakdown_item[]', $item[0], ['class' => 'form-control', 'readonly']) }}
                                        </td>
                                        <td>
                                            {{ Form::text('equipment_breakdown_cost[]', $item[1], ['class' => 'form-control', 'readonly']) }}
                                        </td>
                                        <td>
                                            {{ Form::text('equipment_breakdown_count[]', $item[2], ['class' => 'form-control', 'readonly']) }}
                                        </td>
                                        <td>
                                            {{ Form::text('equipment_breakdown_subtotal[]', $item[1] * $item[2], ['class' => 'form-control', 'readonly']) }}
                                        </td>
                                    </tr>
                                @endforeach
                                @foreach ($item_details[2] as $key => $item)
                                    <tr>
                                        <td>
                                            {{ Form::text('service_breakdown_item[]', $item[0], ['class' => 'form-control', 'readonly']) }}
                                        </td>
                                        <td>
                                            {{ Form::text('service_breakdown_cost[]', $item[1], ['class' => 'form-control', 'readonly']) }}
                                        </td>
                                        <td>
                                            {{ Form::text('service_breakdown_count[]', $item[2], ['class' => 'form-control', 'readonly']) }}
                                        </td>
                                        <td>
                                            {{ Form::text('service_breakdown_subtotal[]', $item[1] * $item[2], ['class' => 'form-control', 'readonly']) }}
                                        </td>
                                    </tr>
                                @endforeach
                                @if (!empty($luggage_price))
                                    <tr>
                                        <td>
                                            {{ Form::text('service_breakdown_item[]', '荷物預かり', ['class' => 'form-control', 'readonly']) }}
                                        </td>
                                        <td>
                                            {{ Form::text('service_breakdown_cost[]', $luggage_price->unit_cost, ['class' => 'form-control', 'readonly']) }}
                                        </td>
                                        <td>
                                            {{ Form::text('service_breakdown_count[]', $luggage_price->unit_count, ['class' => 'form-control', 'readonly']) }}
                                        </td>
                                        <td>
                                            {{ Form::text('service_breakdown_subtotal[]', $luggage_price->unit_subtotal, [
                                                'class' => 'form-control',
                                                'readonly',
                                            ]) }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                            <tbody class="equipment_result">
                                <tr>
                                    <td colspan="4">
                                        <div class="result_sum">
                                            <p class="text-left">合計</p>
                                            {{ Form::text('equipment_price', $item_details[0], ['class' => 'form-control', 'readonly']) }}
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="layout billdetails_content">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td colspan="4">
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
                                @if ($request->layout_prepare == 1)
                                    <tr>
                                        <td>{{ Form::text('layout_breakdown_item[]', 'レイアウト準備料金', ['class' => 'form-control', 'readonly']) }}
                                        </td>
                                        <td>
                                            {{ Form::text('layout_breakdown_cost[]', $venue->layout_prepare, ['class' => 'form-control', 'readonly']) }}
                                        </td>
                                        <td>{{ Form::text('layout_breakdown_count[]', 1, ['class' => 'form-control', 'readonly']) }}
                                        </td>
                                        <td>
                                            {{ Form::text('layout_breakdown_subtotal[]', $venue->layout_prepare, ['class' => 'form-control', 'readonly']) }}
                                        </td>
                                    </tr>
                                @endif
                                @if ($request->layout_clean == 1)
                                    <tr>
                                        <td>{{ Form::text('layout_breakdown_item[]', 'レイアウト片付料金', ['class' => 'form-control', 'readonly']) }}
                                        </td>
                                        <td>
                                            {{ Form::text('layout_breakdown_cost[]', $venue->layout_clean, ['class' => 'form-control', 'readonly']) }}
                                        </td>
                                        <td>{{ Form::text('layout_breakdown_count[]', 1, ['class' => 'form-control', 'readonly']) }}
                                        </td>
                                        <td>
                                            {{ Form::text('layout_breakdown_subtotal[]', $venue->layout_clean, ['class' => 'form-control', 'readonly']) }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                            <tbody class="layouts_result">
                                <tr>
                                    <td colspan="4">
                                        <div class="result_sum">
                                            <p class="text-left">合計</p>
                                            {{ Form::text('layout_price', $layout_details, ['class' => 'form-control', 'readonly']) }}
                                        </div>
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
                                        {{ Form::text('master_subtotal', $master, ['class' => 'form-control', 'readonly']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>消費税：</td>
                                    <td>
                                        {{ Form::text('master_tax', ReservationHelper::getTax($master), ['class' => 'form-control', 'readonly']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">合計金額</td>
                                    <td>
                                        {{ Form::text('master_total', ReservationHelper::taxAndPrice($master), ['class' => 'form-control', 'readonly']) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>





    <div class="confirm-box mt-5">
        <h5 class="mb-2 caution_color">【今後の流れ】</h5>
        <p>・本ページの「予約申込をする」ボタンをクリック後に自動メールが送信されます。
            メールが到着しない場合は再度お申し込みをいただくか、弊社までご連絡下さい。
        </p>
        <p>・ 弊社で受付が完了しましたら「予約完了連絡」をお送りします。<br>
            <span class="caution_color">弊社からの予約完了連絡が到着した時点で「予約完了(予約確定)となります。」</span>
        </p>
        <p>・原則として予約完了後の「キャンセル」「変更」にはキャンセル料金が発生います。申込前に「<a target="_blank" rel="noopener noreferrer" href="https://system.osaka-conference.com/cancelpolicy/">キャンセルポリシー</a>」
            をご確認下さい。
        </p>

        <div class="caution py-3 mt-3">
            <p class="text-center">
                <a target="_blank" rel="noopener noreferrer" href="{{ asset('/img/terms_of_service.pdf') }}">利用規約</a>と利用の流れについての同意
            </p>
            <div class="d-flex justify-content-center">
                <p class="checkbox-txt">
                    <label><input id="" name="policy" type="checkbox" value="" class="mr-1">同意する</label>
                </p>
            </div>
            <p class="is-error-policy text-center" style="color: red"></p>
        </div>
    </div>

    <div class="confirm-box mt-3">
        <h5 class="mb-2 caution_color">【個人情報の取り扱いについて】</h5>
        <p>当フォームにご入力いただく内容は、弊社が責任を持って保管し、その他の目的に使用いたしません。また、許可なく第三者に提供することはございません。個人情報の取り扱いに関しては、<a href="https://system.osaka-conference.com/privacypolicy/" target="_blank" rel="noopener noreferrer">プライバシーポリシー</a>をご確認下さい。</p>
    </div>



    <p class="text-center mb-5 mt-5">
        {{ Form::submit('予約申込をする', ['class' => 'btn more_btn4_lg confirm', 'name' => 'cfm', 'id' => 'confirmBtn']) }}
    </p>



    {{ Form::close() }}

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
            // $('.confirm').on('click', function() {
            //   if (!confirm('予約を申し込みますか？')) {
            //     return false;
            //   }
            // })
        })
        // ロード時の、案内板入力制御
        // $(document).ready(function() {
        //     $("#no_board_flag:checked").each(function() {
        //         var flag = $(this);
        //         if ($(flag).is(":checked") != null) {
        //             $("#event_start").prop("disabled", true);
        //             $("#event_finish").prop("disabled", true);
        //             $("#eventname1Count").prop("disabled", true);
        //             $("#eventname2Count").prop("disabled", true);
        //             $("#eventownerCount").prop("disabled", true);
        //             // $(".board-table input[type='text']").val("");
        //             $(".board-table option:selected").val("");
        //         }
        //     });
        // });

        // // ラジオボタンクリック時の案内板入力制御
        // $(function() {
        //     $('input[name="board_flag"]').change(function() {
        //         var prop = $("#no_board_flag").prop("checked");
        //         if (prop) {
        //             $("#event_start").prop("disabled", true);
        //             $("#event_finish").prop("disabled", true);
        //             $("#eventname1Count").prop("disabled", true);
        //             $("#eventname2Count").prop("disabled", true);
        //             $("#eventownerCount").prop("disabled", true);
        //             // $(".board-table input[type='text']").val("");
        //         } else {
        //             $("#event_start").prop("disabled", false);
        //             $("#event_finish").prop("disabled", false);
        //             $("#eventname1Count").prop("disabled", false);
        //             $("#eventname2Count").prop("disabled", false);
        //             $("#eventownerCount").prop("disabled", false);
        //         }
        //     });
        // });

        // 荷物預かりのラジオボタン選択の表示、非表示
        // $(function() {
        //     var no_luggage_flag = $('#no_luggage_flag').val();
        //     if (no_luggage_flag == 0) {
        //         $(".luggage_info").addClass("d-none");
        //     } else {
        //         $(".luggage_info").removeClass("d-none");
        //     }
        // });

        // $(function() {
        //     $("input[name='luggage_flag']").change(function() {
        //         var no_luggage_flag = $('#no_luggage_flag').prop('checked');
        //         if (no_luggage_flag) {
        //             $(".luggage_info").addClass("d-none");
        //         } else {
        //             $(".luggage_info").removeClass("d-none");
        //         }
        //     });
        // });


        $(document).on("click", "input:radio[name='eat_in']", function() {
            var radioTarget = $('input:radio[name="eat_in"]:checked').val();
            if (radioTarget == 1) {
                $('input:radio[name="eat_in_prepare"]').prop('disabled', false);
                $('input[name=eat_in_prepare]:eq(0)').prop('checked', true);
            } else {
                $('input:radio[name="eat_in_prepare"]').prop('disabled', true);
                $('input:radio[name="eat_in_prepare"]').val("");
            }
        })

        $(document).on(' click', '.holidays', function() {
            console.log($('input[name="reserve_date"]').val());
            getHolidayCalendar($('.holidays'), $('input[name="reserve_date"]'));
        });
    </script>
@endsection
