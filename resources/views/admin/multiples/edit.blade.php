@extends('layouts.admin.app')
@section('content')
    <link href="{{ asset('/css/template.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/template.js') }}"></script>
    <script src="{{ asset('/js/lettercounter.js') }}"></script>
    <script src="{{ asset('/js/admin/multiples/validation.js') }}"></script>
    <script src="{{ asset('/js/multiples/calculate.js') }}"></script>
    <script src="{{ asset('/js/holidays.js') }}"></script>


    <div class="container-field mt-3">
        <div class="float-right">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">
                        {{ Breadcrumbs::render(Route::currentRouteName(), $multiple->id, $venue->id) }}
                    </li>
                </ol>
            </nav>
        </div>
        <h2 class="mt-3 mb-3">一括仮押え　編集</h2>
        <hr>
    </div>

    <div class="alert-box d-flex align-items-center">
        <span class="mr-3"><i class="fas alert-icon fa-exclamation-triangle" aria-hidden="true"></i></span>
        <p>
            変更がある場合は、必ず更新するボタンを押してください。<br>
            更新しないまま画面遷移をすると、データが反映されません。
        </p>
    </div>

    @include('layouts.admin.errors')
    @if (session('flash_message'))
        <div class="flash_message bg-success text-center py-3 my-0">
            {{ session('flash_message') }}
        </div>
    @endif
    @if (session('flash_message_error'))
        <div class="flash_message bg-danger text-center py-3 my-0">
            {{ session('flash_message_error') }}
        </div>
    @endif

    <!-- 詳細選択画面--------------------------------------------------　 -->
    <p class="font-weight-bold">日程ごとに、詳細を編集できます。</p>

    <section class="border-wrap2 pb-5">
        <table class="table ttl_head">
            <tbody>
                <tr>
                    <td class="text-white d-flex align-items-center p-3">
                        <h3>
                            仮押え一括ID:<span class="mr-3">{{ ReservationHelper::fixId($multiple->id) }}</span>
                        </h3>
                        <h4 class="ml-2">{{ ReservationHelper::getVenue($venue->id) }}</h4>
                    </td>
                </tr>
            </tbody>
        </table>
        <section class="mx-5 mt-5">
            <table class="table table-bordered customer-table mb-5" style="table-layout: fixed;">
                <tbody>
                    <tr>
                        <td colspan="4">
                            <div class="d-flex align-items-center justify-content-between">
                                <p class="title-icon">
                                    <i class="far fa-address-card icon-size" aria-hidden="true"></i>
                                    顧客情報
                                </p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="table-active" width="25%"><label for="company">会社名・団体名</label><a href="" class="more_btn ml-2">顧客詳細</a></th>
                        <td>
                            {{ ReservationHelper::getCompany($multiple->pre_reservations->first()->user_id) }}
                        </td>
                        <td class="table-active"><label for="name">担当者氏名</label></td>
                        <td>
                            {{ ReservationHelper::getPersonName($multiple->pre_reservations->first()->user_id) }}
                        </td>
                    </tr>
                    <tr>
                        <td class="table-active" scope="row"><label for="email">担当者メールアドレス</label></td>
                        <td>
                            {{ ReservationHelper::getPersonEmail($multiple->pre_reservations->first()->user_id) }}
                        </td>
                        <td class="table-active" scope="row"><label for="mobile">携帯番号</label></td>
                        <td>
                            {{ ReservationHelper::getPersonMobile($multiple->pre_reservations->first()->user_id) }}
                        </td>
                    </tr>
                    <tr>
                        <td class="table-active" scope="row"><label for="tel">固定電話</label></td>
                        <td>
                            {{ ReservationHelper::getPersonTel($multiple->pre_reservations->first()->user_id) }}
                        </td>
                        <td class="table-active" scope="row"><label for="">割引条件</label></td>
                        <td>
                            {!! nl2br(e(optional($multiple->pre_reservations->first()->user)->condition)) !!}
                        </td>
                    </tr>
                    <tr>
                        <td class="table-active caution" scope="row"><label for="">注意事項</label></td>
                        <td class="caution" colspan="3">
                            {!! nl2br(e(optional($multiple->pre_reservations->first()->user)->attention)) !!}
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>

        {{ Form::open(['url' => '/admin/multiples/' . $multiple->id . '/edit/' . $venue->id . '/calculate', 'method' => 'POST', 'id' => 'multipleEditForm', 'autocomplete' => 'off']) }}
        @csrf
        <section class="m-5 border-inwrap">
            <div class="mb-2">
            </div>
            <dl class="card">
                <dt class="card-header accordion-ttl">
                    <ul class="title-icon d-flex">
                        <li>
                            <p>すべての日程に反映したい場合はこちらから選択ください</p>
                        </li>
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
                                                仮押え情報
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-active"><label for="direction">料金体系</label></td>
                                        <td>
                                            <div>
                                                @if ($venue->time_prices->count() != 0 && $venue->frame_prices->count() != 0)
                                                    <p>
                                                        {{ Form::radio('cp_master_price_system', 1, true, ['id' => 'cp_master_price_system_radio1']) }}
                                                        {{ Form::label('cp_master_price_system_radio1', '通常（枠貸）') }}
                                                    </p>
                                                    <p>
                                                        {{ Form::radio('cp_master_price_system', 2, false, ['id' => 'cp_master_price_system_radio2']) }}
                                                        {{ Form::label('cp_master_price_system_radio2', '音響HG') }}
                                                    </p>
                                                @elseif($venue->frame_prices->count() != 0 && $venue->time_prices->count() == 0)
                                                    <p>
                                                        {{ Form::radio('cp_master_price_system', 1, true, ['id' => 'cp_master_price_system_radio1']) }}
                                                        {{ Form::label('cp_master_price_system_radio1', '通常（枠貸）') }}
                                                    </p>
                                                @elseif($venue->frame_prices->count() == 0 && $venue->time_prices->count() != 0)
                                                    <p>
                                                        {{ Form::radio('cp_master_price_system', 2, true, ['id' => 'cp_master_price_system_radio2']) }}
                                                        {{ Form::label('cp_master_price_system_radio2', '音響HG') }}
                                                    </p>
                                                @endif
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
                                    <td class="table-active form_required"><label for="direction">案内板</label></td>
                                    <td>
                                        <div class="radio-box">
                                            <p>
                                                {{ Form::radio('cp_master_board_flag', 1, false, ['id' => 'cp_master_board_flag1']) }}
                                                {{ Form::label('cp_master_board_flag1', 'あり') }}
                                            </p>
                                            <p>
                                                {{ Form::radio('cp_master_board_flag', 0, true, ['id' => 'cp_master_board_no_board_flag']) }}
                                                {{ Form::label('cp_master_board_no_board_flag', 'なし') }}
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="table-active" id="eventRequired"><label for="eventName1">イベント名称1</label></td>
                                    <td>
                                        <div class="align-items-end d-flex">
                                            {{ Form::text('cp_master_event_name1', '', ['class' => 'form-control', 'placeholder' => '入力してください', 'id' => 'eventname1Count']) }}
                                            <span class="ml-1 annotation count_num1"></span>
                                        </div>
                                        <p class="is-error-cp_master_event_name1" style="color: red"></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="table-active"><label for="eventName2">イベント名称2</label></td>
                                    <td>
                                        <div class="align-items-end d-flex">
                                            {{ Form::text('cp_master_event_name2', '', ['class' => 'form-control', 'placeholder' => '入力してください', 'id' => 'eventname2Count']) }}
                                            <span class="ml-1 annotation count_num2"></span>
                                        </div>
                                        <p class="is-error-cp_master_event_name2" style="color: red"></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="table-active"><label for="organizer">主催者名</label></td>
                                    <td>
                                        <div class="align-items-end d-flex">
                                            {{ Form::text('cp_master_event_owner', '', ['class' => 'form-control', 'placeholder' => '入力してください', 'id' => 'eventownerCount']) }}
                                            <span class="ml-1 annotation count_num3"></span>
                                        </div>
                                        <p class="is-error-cp_master_event_owner" style="color: red"></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="table-active"><label for="eventStart">イベント開始時間</label></td>
                                    <td>
                                        <select name="cp_master_event_start" id="cp_master_event_start" class="form-control">
                                            {!! ReservationHelper::timeOptions() !!}
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="table-active"><label for="eventFinish">イベント終了時間</label></td>
                                    <td>
                                        <select name="cp_master_event_finish" id="cp_master_event_finish" class="form-control">
                                            {!! ReservationHelper::timeOptions() !!}
                                        </select>
                                    </td>
                                </tr>
                            </table>
                            <p class="warning-text mb-3 mt-1">※イベント時間を非表示にする場合は、イベント開始・終了時間ともに「00時00分」を選択して下さい。</p>

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
                                    @foreach ($venue->getEquipments() as $key => $equipment)
                                        <tr>
                                            <td class="table-active">{{ $equipment->item }}</td>
                                            <td>
                                                {{ Form::number('cp_master_equipment_breakdown' . $key, '', [
                                                    'class' => 'form-control
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    equipment_validation',
                                                ]) }}
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
                                    @foreach ($venue->getServices() as $key => $service)
                                        <tr>
                                            <td class="table-active">{{ $service->item }}</td>
                                            <td>
                                                <div class="radio-box">
                                                    <p>
                                                        {{ Form::radio('cp_master_services_breakdown' . $key, 1, false, ['id' => 'cp_master_service' . $key . 'on']) }}
                                                        {{ Form::label('cp_master_service' . $key . 'on', 'あり') }}
                                                    </p>
                                                    <p>
                                                        {{ Form::radio('cp_master_services_breakdown' . $key, 0, true, ['id' => 'cp_master_service' . $key . 'off']) }}
                                                        {{ Form::label('cp_master_service' . $key . 'on', 'なし') }}
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>


                            @if ($venue->layout == 1)
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
                                                    <div class="radio-box">
                                                        <p>
                                                            {{ Form::radio('cp_master_layout_prepare', 1, false, ['id' => 'cp_master_layout_prepare']) }}
                                                            {{ Form::label('cp_master_layout_prepare', 'あり') }}
                                                        </p>
                                                        <p>
                                                            {{ Form::radio('cp_master_layout_prepare', 0, true, ['id' => 'cp_master_no_layout_prepare']) }}
                                                            {{ Form::label('cp_master_no_layout_prepare', 'なし') }}
                                                        </p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                        @if ($venue->getLayouts()[1])
                                            <tr>
                                                <td class="table-active">片付</td>
                                                <td>
                                                    <div class="radio-box">
                                                        <p>
                                                            {{ Form::radio('cp_master_layout_clean', 1, false, ['id' => 'cp_master_layout_clean']) }}
                                                            {{ Form::label('cp_master_layout_clean', 'あり') }}
                                                        </p>
                                                        <p>
                                                            {{ Form::radio('cp_master_layout_clean', 0, true, ['id' => 'cp_master_no_layout_clean']) }}
                                                            {{ Form::label('cp_master_no_layout_clean', 'なし') }}
                                                        </p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            @endif


                            @if ($venue->luggage_flag == 1)
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
                                        @if ($venue->getLuggage() === 1)
                                            <tr>
                                                <td class="table-active">荷物預かり</td>
                                                <td>
                                                    <div class="radio-box">
                                                        <p>
                                                            {{ Form::radio('cp_master_luggage_flag', 1, false, ['id' => 'cp_master_luggage_flag']) }}
                                                            {{ Form::label('cp_master_luggage_flag', 'あり') }}
                                                        </p>
                                                        <p>
                                                            {{ Form::radio('cp_master_luggage_flag', 0, true, ['id' => 'cp_master_no_luggage_flag']) }}
                                                            {{ Form::label('cp_master_no_luggage_flag', 'なし') }}
                                                        </p>
                                                    </div>
                                                    <div class="mt-2 luggage-border">
                                                    【事前・事後】預かりの荷物について<br>
                                                    事前預かり/事後返送ともに<span class="f-s20">5個</span>まで。<br>
                                                    6個以上は要相談。その際は事前に必ずお問い合わせ下さい。<br>
                                                    荷物外寸合計(縦・横・奥行)120cm以下/個
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="table-active">事前に預かる荷物<br>(目安)</td>
                                                <td>
                                                    {{ Form::number('cp_master_luggage_count', '', ['class' => 'form-control', 'id' => 'cp_master_luggage_count', 'min' => 0]) }}
                                                    <p class="is-error-cp_master_luggage_count" style="color: red"></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="table-active">事前荷物の到着日<br>(平日午前指定)</td>
                                                <td>
                                                    {{ Form::text('cp_master_luggage_arrive', '', [
                                                        'class' => 'form-control
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            datepicker9',
                                                        'id' => 'cp_master_luggage_arrive',
                                                    ]) }}
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
                                                <td class="table-active">事後返送する荷物</td>
                                                <td>
                                                    {{ Form::number('cp_master_luggage_return', '', ['class' => 'form-control', 'id' => 'cp_master_luggage_return', 'min' => 0]) }}
                                                    <p class="is-error-cp_master_luggage_return" style="color: red"></p>
                                                    <div class="mt-1 luggage_info">
                                                        ※返送時の「発送伝票（元払）/返送伝票（着払）」は会場内に用意しているものを必ず使用して下さい。
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="table-active">荷物預り料金(税抜)</td>
                                                <td>
                                                    <p class="annotation">※仮押え時点では、料金の設定ができません。<br>予約へ切り替え後に料金の設定が可能です。</p>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            @endif


                            @if ($venue->eat_in_flag == 1)
                                <table class="table table-bordered eating-table">
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
                                                {{ Form::radio('cp_master_eat_in', 1, false, ['id' => 'eat_in']) }}
                                                {{ Form::label('eat_in', 'あり') }}
                                            </td>
                                            <td>
                                                {{ Form::radio('cp_master_eat_in_prepare', 1, true, ['id' => 'eat_in_prepare', 'disabled']) }}
                                                {{ Form::label('eat_in_prepare', '手配済み') }}
                                                {{ Form::radio('cp_master_eat_in_prepare', 2, false, ['id' => 'eat_in_consider', 'disabled']) }}
                                                {{ Form::label('eat_in_consider', '検討中') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                {{ Form::radio('cp_master_eat_in', 0, true, ['id' => 'no_eat_in']) }}
                                                {{ Form::label('no_eat_in', 'なし') }}
                                            </td>
                                            <td></td>
                                        </tr>
                                </table>
                            @endif
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
                                                {{ Form::text('cp_master_in_charge', '', ['class' => 'form-control']) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="table-active"><label for="mobilePhone">携帯番号</label></td>
                                            <td>
                                                {{ Form::text('cp_master_tel', '', ['class' => 'form-control', 'placeholder' => '半角数字、ハイフンなしで入力してください']) }}
                                                <p class="is-error-cp_master_tel" style="color: red"></p>
                                                <p class="annotation mt-1">※半角数字、ハイフンなしで入力下さい。</p>
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
                                            <div class="radio-box">
                                                <p>
                                                    {{ Form::radio('cp_master_email_flag', 1, true, ['id' => 'cp_master_email_flag']) }}
                                                    {{ Form::label('cp_master_email_flag', 'あり') }}
                                                </p>
                                                <p>
                                                    {{ Form::radio('cp_master_email_flag', 0, false, ['id' => 'cp_master_no_email_flag']) }}
                                                    {{ Form::label('cp_master_no_email_flag', 'なし') }}
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>


                            @if ($venue->alliance_flag == 1)
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
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    {{ Form::text('cp_master_cost', $venue->cost, ['class' => 'form-control']) }}
                                                    <span class="ml-2">%</span>
                                                </div>
                                                <p class="is-error-cp_master_cost" style="color: red"></p>
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
                                                <i class="fas fa-file-alt icon-size" aria-hidden="true"></i>
                                                備考
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="adminNote">管理者備考</label>
                                            {{ Form::textarea('cp_master_admin_details', '', ['class' => 'form-control']) }}
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
                @if (count($venue->frame_prices) == 0 && count($venue->time_prices) == 0)
                    <div class="d-flex justify-content-center">
                        <div class="">
                            <p class="d-block">※選択された会場は料金が設定されていません。会場管理/料金管理に戻り設定してください</p>
                            <a href="{{ url('/admin/frame_prices') }}" class="btn more_btn_lg mt-5 d-flex justify-content-center">料金管理画面へ</a>
                        </div>
                    </div>
                @else
                    {{ Form::submit('すべての日程に反映して保存', ['class' => 'btn more_btn_lg mt-3']) }}
                @endif
                {{ Form::close() }}
            </p>
        </section>

        <div class="pt-5 mx-5">
            <p>※一日程ごとに入力する場合は、下記タブより、それぞれ選択してください。</p>
            <p class="caution_color">※一日程ごとに入力後、すべての日程に反映して保存ボタンをクリックすると、一日程ごとの内容が上書きされてしまうので、
                ご注意ください。
            </p>
            <hr>
        </div>


        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <ul class="register-list-header">
            <li class="from-group">
                <div class="form-check">
                    <input class="mr-1" type="checkbox" name="all_check" id="all_check" />
                    <label class="form-check-label">すべてチェックする</label>
                </div>
            </li>
            <li>
                {{ Form::open(['url' => '/admin/multiples/' . $multiple->id . '/sp_destroy/' . $venue->id, 'method' => 'post', 'id' => '', 'autocomplete' => 'off']) }}
                @csrf
                {{ Form::hidden('delete_target', '') }}
                {{ Form::submit('削除', ['class' => 'btn more_btn4 confirm_delete', 'id' => 'confirm_destroy']) }}
                {{ Form::close() }}
            </li>
        </ul>
        @if (session('error'))
            <div class="alert alert-danger">
                <ul>
                    <li>{{ session('error') }}
                    </li>
                </ul>
            </div>
        @endif

        {{-- jsで仮押えの件数判別のためのhidden --}}
        {{ Form::hidden('', $multiple->pre_reservations->where('venue_id', $venue->id)->count(), ['id' => 'counts_reserve']) }}
        {{-- 以下、pre_reservationの数分　ループ --}}
        @foreach ($multiple->pre_reservations->where('venue_id', $venue->id) as $key => $pre_reservation)
            {{ Form::open(['url' => 'admin/multiples/' . $multiple->id . '/edit/' . $venue->id . '/calculate/' . $pre_reservation->id . '/specific_update', 'method' => 'POST', 'id' => 'multipleSpecificUpdateForm' . $key, 'autocomplete' => 'off']) }}
            @csrf
            {{ Form::hidden('split_keys', $key) }}

            <section class="register-list col">
                <!-- 仮押え一括 タブ-->
                <div class="register-list-item">
                    <div class="from-group list_checkbox">
                        <div class="form-check">
                            {{ Form::checkbox('delete_check' . $pre_reservation->id, $pre_reservation->id, false, [
                                'class' => 'checkbox mr-1',
                            ]) }}
                        </div>
                    </div>
                    <dl class="card">
                        <dt class="card-header accordion-ttl">
                            <ul class="title-icon d-flex">
                                <li class="col-1">
                                    {{ $pre_reservation->id }}
                                </li>
                                <li class="col-2">
                                    <div class="input-group">
                                        <label for="date"></label>
                                        {{ Form::text('', ReservationHelper::formatDate($pre_reservation->reserve_date), ['class' => 'form-control', 'readonly']) }}
                                        {{ Form::hidden('reserve_date' . $key, $pre_reservation->reserve_date, ['class' => 'form-control', 'readonly']) }}
                                    </div>
                                </li>
                                <li class="col-5">
                                    <div class="input-group">
                                        <label for=""></label>
                                        {{ Form::text('', ReservationHelper::getVenue($pre_reservation->venue_id), ['class' => 'form-control', 'readonly']) }}
                                    </div>
                                </li>
                                <li class="col-3 d-flex align-items-center">
                                    <div class="input-group">
                                        <label for="start"></label>
                                        {{ Form::text('', ReservationHelper::formatTime($pre_reservation->enter_time), ['class' => 'form-control', 'readonly']) }}
                                        {{ Form::hidden('enter_time' . $key, $pre_reservation->enter_time, ['class' => 'form-control', 'readonly']) }}
                                    </div>
                                    <p class="mx-1">～</p>
                                    <div class="input-group">
                                        <label for="finish"></label>
                                        {{ Form::text('', ReservationHelper::formatTime($pre_reservation->leave_time), ['class' => 'form-control', 'readonly']) }}
                                        {{ Form::hidden('leave_time' . $key, $pre_reservation->leave_time, ['class' => 'form-control', 'readonly']) }}
                                    </div>
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
                                                        仮押え情報
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="table-active">
                                                    <label for="direction">料金体系</label>
                                                </td>
                                                <td>
                                                    <div>
                                                        @if ($venue->time_prices->count() != 0 && $venue->frame_prices->count() != 0)
                                                            <div>
                                                                {{ Form::radio('price_system_copied' . $key, 1, $pre_reservation->price_system ? ($pre_reservation->price_system == 1 ? true : false) : true, ['id' => 'price_system_copied' . $key]) }}
                                                                {{ Form::label('price_system_copied' . $key, '通常（枠貸）') }}
                                                            </div>
                                                            <div>
                                                                {{ Form::radio('price_system_copied' . $key, 2, $pre_reservation->price_system ? ($pre_reservation->price_system == 2 ? true : false) : false, ['id' => 'price_system_copied_off' . $key]) }}
                                                                {{ Form::label('price_system_copied_off' . $key, '音響HG') }}
                                                            </div>
                                                        @elseif($venue->frame_prices->count() != 0 && $venue->time_prices->count() == 0)
                                                            <div>
                                                                {{ Form::radio('price_system_copied' . $key, 1, true, ['id' => 'price_system_copied' . $key]) }}
                                                                {{ Form::label('price_system_copied' . $key, '通常（枠貸）') }}
                                                            </div>
                                                        @elseif($venue->frame_prices->count() == 0 && $venue->time_prices->count() != 0)
                                                            <div>
                                                                {{ Form::radio('price_system_copied' . $key, 2, true, ['id' => 'price_system_copied_off' . $key]) }}
                                                                {{ Form::label('price_system_copied_off' . $key, '音響HG') }}
                                                            </div>
                                                        @endif
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
                                            <td class="table-active form_required"><label for="direction">案内板</label></td>
                                            <td>
                                                <div class="radio-box">
                                                    <p>
                                                        {{ Form::radio('board_flag_copied' . $key, 1, $pre_reservation->board_flag == 1 ? true : false, ['id' => 'board_flag_copied' . $key]) }}
                                                        {{ Form::label('board_flag_copied' . $key, 'あり') }}
                                                    </p>
                                                    <p>
                                                        {{ Form::radio('board_flag_copied' . $key, 0, $pre_reservation->board_flag == 0 ? true : false, ['id' => 'board_flag_copied_off' . $key]) }}
                                                        {{ Form::label('board_flag_copied_off' . $key, 'なし') }}
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="table-active"><label for="eventName1">イベント名称1</label></td>
                                            <td>
                                                <div class="align-items-end d-flex">
                                                    {{ Form::text('event_name1_copied' . $key, $pre_reservation->event_name1, ['class' => 'form-control', 'placeholder' => '入力してください', 'id' => 'copiedeventname1Count' . $key]) }}
                                                    <span class="ml-1 annotation {{ 'count_num1_copied' . $key }}"></span>
                                                </div>
                                                <p class="{{ ' is-error-event_name1_copied' . $key }}" style="color: red"></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="table-active"><label for="eventName2">イベント名称2</label></td>
                                            <td>
                                                <div class="align-items-end d-flex">
                                                    {{ Form::text('event_name2_copied' . $key, $pre_reservation->event_name2, ['class' => 'form-control', 'placeholder' => '入力してください', 'id' => 'copiedeventname2Count' . $key]) }}
                                                    <span class="ml-1 annotation {{ 'count_num2_copied' . $key }}"></span>
                                                </div>
                                                <p class="{{ ' is-error-event_name2_copied' . $key }}" style="color: red"></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="table-active"><label for="organizer">主催者名</label></td>
                                            <td>
                                                <div class="align-items-end d-flex">
                                                    {{ Form::text('event_owner' . $key, $pre_reservation->event_owner, ['class' => 'form-control', 'placeholder' => '入力してください', 'id' => 'copiedeventOwnerCount' . $key]) }}
                                                    <span class="ml-1 annotation {{ 'count_num3_copied' . $key }}"></span>
                                                </div>
                                                <p class="{{ ' is-error-event_owner' . $key }}" style="color: red"></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="table-active"><label for="eventStart">イベント開始時間</label></td>
                                            <td>
                                                <select name="{{ 'event_start_copied' . $key }}" id="{{ 'event_start_copied' . $key }}" class="form-control">
                                                    {!! ReservationHelper::timeOptionsWithRequest($pre_reservation->event_start) !!}
                                                </select>
                                                <p class="annotation caution_color mt-1">※利用時間内で入力してください。</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="table-active"><label for="eventFinish">イベント終了時間</label></td>
                                            <td>
                                                <select name="{{ 'event_finish_copied' . $key }}" id="{{ 'event_finish_copied' . $key }}" class="form-control">
                                                    {!! ReservationHelper::timeOptionsWithRequest($pre_reservation->event_finish) !!}
                                                </select>
                                                <p class="annotation caution_color mt-1">※利用時間内で入力してください。</p>
                                            </td>
                                        </tr>
                                    </table>
                                    <p class="warning-text mb-3 mt-1">※イベント時間を非表示にする場合は、イベント開始・終了時間ともに「00時00分」を選択して下さい。</p>

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
                                            @foreach ($venue->getEquipments() as $e_key => $equipment)
                                                <tr>
                                                    <td class="table-active">{{ $equipment->item }}</td>
                                                    <td>
                                                        @if ($pre_reservation->pre_bill)
                                                            @foreach ($pre_reservation->pre_bill->pre_breakdowns as $eq)
                                                                @if ($eq->unit_item == $equipment->item)
                                                                    {{ Form::number('equipment_breakdown' . $e_key . '_copied' . $key, $eq->unit_count, ['class' => 'form-control equipment_validation']) }}
                                                                @break

                                                            @elseif($loop->last)
                                                                {{ Form::number('equipment_breakdown' . $e_key . '_copied' . $key, '', ['class' => 'form-control equipment_validation']) }}
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        {{ Form::number('equipment_breakdown' . $e_key . '_copied' . $key, '', ['class' => 'form-control equipment_validation']) }}
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
                                        @foreach ($venue->getServices() as $s_key => $service)
                                            <tr>
                                                <td class="table-active">{{ $service->item }}</td>
                                                <td>
                                                    @if ($pre_reservation->pre_bill)
                                                        @foreach ($pre_reservation->pre_bill->pre_breakdowns as $se)
                                                            @if ($se->unit_item == $service->item)
                                                                {{ Form::radio('services_breakdown' . $s_key . '_copied' . $key, 1, true, ['id' => 'services_breakdown' . $s_key . '_copied' . $key]) }}
                                                                {{ Form::label('services_breakdown' . $s_key . '_copied' . $key, 'あり') }}
                                                                {{ Form::radio('services_breakdown' . $s_key . '_copied' . $key, 0, false, ['id' => 'services_breakdown' . $s_key . '_copied' . $key . 'off']) }}
                                                                {{ Form::label('services_breakdown' . $s_key . '_copied' . $key . 'off', 'なし') }}
                                                            @break

                                                        @elseif($loop->last)
                                                            {{ Form::radio('services_breakdown' . $s_key . '_copied' . $key, 1, false, ['id' => 'services_breakdown' . $s_key . '_copied' . $key]) }}
                                                            {{ Form::label('services_breakdown' . $s_key . '_copied' . $key, 'あり') }}
                                                            {{ Form::radio('services_breakdown' . $s_key . '_copied' . $key, 0, true, ['id' => 'services_breakdown' . $s_key . '_copied' . $key . 'off']) }}
                                                            {{ Form::label('services_breakdown' . $s_key . '_copied' . $key . 'off', 'なし') }}
                                                        @endif
                                                    @endforeach
                                                @else
                                                    {{ Form::radio('services_breakdown' . $s_key . '_copied' . $key, 1, false, ['id' => 'services_breakdown' . $s_key . '_copied' . $key]) }}
                                                    {{ Form::label('services_breakdown' . $s_key . '_copied' . $key, 'あり') }}
                                                    {{ Form::radio('services_breakdown' . $s_key . '_copied' . $key, 0, true, ['id' => 'services_breakdown' . $s_key . '_copied' . $key . 'off']) }}
                                                    {{ Form::label('services_breakdown' . $s_key . '_copied' . $key . 'off', 'なし') }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>


                            @if ($venue->layout == 1)
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
                                                <div class="radio-box">
                                                    @if ($pre_reservation->pre_bill)
                                                        @foreach ($pre_reservation->pre_bill->pre_breakdowns as $la)
                                                            @if ($la->unit_item == 'レイアウト準備料金')
                                                                <p>
                                                                    {{ Form::radio('layout_prepare_copied' . $key, 1, true, ['id' => 'layout_prepare_copied' . $key]) }}
                                                                    {{ Form::label('layout_prepare_copied' . $key, 'あり') }}
                                                                </p>
                                                                <p>
                                                                    {{ Form::radio('layout_prepare_copied' . $key, 0, false, ['id' => 'no_layout_prepare_copied' . $key]) }}
                                                                    {{ Form::label('no_layout_prepare_copied' . $key, 'なし') }}
                                                                </p>
                                                            @break

                                                        @elseif($loop->last)
                                                            <p>
                                                                {{ Form::radio('layout_prepare_copied' . $key, 1, false, ['id' => 'layout_prepare_copied' . $key]) }}
                                                                {{ Form::label('layout_prepare_copied' . $key, 'あり') }}
                                                            </p>
                                                            <p>
                                                                {{ Form::radio('layout_prepare_copied' . $key, 0, true, ['id' => 'no_layout_prepare_copied' . $key]) }}
                                                                {{ Form::label('no_layout_prepare_copied' . $key, 'なし') }}
                                                            </p>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <p>
                                                        {{ Form::radio('layout_prepare_copied' . $key, 1, false, ['id' => 'layout_prepare_copied' . $key]) }}
                                                        {{ Form::label('layout_prepare_copied' . $key, 'あり') }}
                                                    </p>
                                                    <p>
                                                        {{ Form::radio('layout_prepare_copied' . $key, 0, true, ['id' => 'no_layout_prepare_copied' . $key]) }}
                                                        {{ Form::label('no_layout_prepare_copied' . $key, 'なし') }}
                                                    </p>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-active">片付</td>
                                        <td>
                                            <div class="radio-box">
                                                @if ($pre_reservation->pre_bill)
                                                    @foreach ($pre_reservation->pre_bill->pre_breakdowns as $la2)
                                                        @if ($la2->unit_item == 'レイアウト片付料金')
                                                            <p>
                                                                {{ Form::radio('layout_clean_copied' . $key, 1, true, ['id' => 'layout_clean_copied' . $key]) }}
                                                                {{ Form::label('layout_clean_copied' . $key, 'あり') }}
                                                            </p>
                                                            <p>
                                                                {{ Form::radio('layout_clean_copied' . $key, 0, false, ['id' => 'no_layout_clean_copied' . $key]) }}
                                                                {{ Form::label('no_layout_clean_copied' . $key, 'なし') }}
                                                            </p>
                                                        @break

                                                    @elseif($loop->last)
                                                        <p>
                                                            {{ Form::radio('layout_clean_copied' . $key, 1, false, ['id' => 'layout_clean_copied' . $key]) }}
                                                            {{ Form::label('layout_clean_copied' . $key, 'あり') }}
                                                        </p>
                                                        <p>
                                                            {{ Form::radio('layout_clean_copied' . $key, 0, true, ['id' => 'no_layout_clean_copied' . $key]) }}
                                                            {{ Form::label('no_layout_clean_copied' . $key, 'なし') }}
                                                        </p>
                                                    @endif
                                                @endforeach
                                            @else
                                                <p>
                                                    {{ Form::radio('layout_clean_copied' . $key, 1, false, ['id' => 'layout_clean_copied' . $key]) }}
                                                    {{ Form::label('layout_clean_copied' . $key, 'あり') }}
                                                </p>
                                                <p>
                                                    {{ Form::radio('layout_clean_copied' . $key, 0, true, ['id' => 'no_layout_clean_copied' . $key]) }}
                                                    {{ Form::label('no_layout_clean_copied' . $key, 'なし') }}
                                                </p>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @endif

                    @if ($venue->luggage_flag == 1)
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
                                    <td class="table-active">荷物預かり</td>
                                    <td>
                                        <div class="radio-box">
                                            <p>
                                                {{ Form::radio('luggage_flag_copied' . $key, 1, (int) $pre_reservation->luggage_flag === 1 ? true : false, ['id' => 'luggage_flag' . $key]) }}
                                                {{ Form::label('luggage_flag' . $key, 'あり') }}
                                            </p>
                                            <p>
                                                {{ Form::radio('luggage_flag_copied' . $key, 0, (int) $pre_reservation->luggage_flag === 0 ? true : false, ['id' => 'no_luggage_flag' . $key]) }}
                                                {{ Form::label('no_luggage_flag' . $key, 'なし') }}
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="table-active">事前に預かる荷物<br>(目安)</td>
                                    <td>
                                        {{ Form::number('luggage_count_copied' . $key, $pre_reservation->luggage_count, ['class' => 'form-control', 'min' => 0]) }}
                                        <p class="{{ ' is-error-luggage_count_copied' . $key }}" style="color: red"></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="table-active">事前荷物の到着日<br>(平日午前指定)</td>
                                    <td>
                                        {{ Form::text('luggage_arrive_copied' . $key, !empty($pre_reservation->luggage_arrive) ? date('Y-m-d', strtotime($pre_reservation->luggage_arrive)) : '', ['class' => 'form-control datepicker9', 'id' => '']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="table-active">事後返送する荷物</td>
                                    <td>
                                        {{ Form::number('luggage_return_copied' . $key, $pre_reservation->luggage_return, ['class' => 'form-control', 'min' => 0]) }}
                                        <p class="{{ ' is-error-luggage_return_copied' . $key }}" style="color: red"></p>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="table-active">荷物預り料金(税抜)</td>
                                    <td>
                                        <p class="annotation">※仮押え時点では、料金の設定ができません。<br>予約へ切り替え後に料金の設定が可能です。</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @endif

                    @if ($venue->eat_in_flag == 1)
                        <table class="table table-bordered eating-table">
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
                                        {{ Form::radio('eat_in_copied' . $key, 1, $pre_reservation->eat_in ? ($pre_reservation->eat_in == 1 ? true : false) : false, ['id' => 'eat_in_copied' . $key]) }}
                                        {{ Form::label('eat_in_copied' . $key, 'あり') }}
                                    </td>
                                    <td>
                                        {{ Form::radio('eat_in_prepare_copied' . $key, 1, $pre_reservation->eat_in_prepare ? ($pre_reservation->eat_in_prepare == 1 ? true : false) : true, ['id' => 'eat_in_prepare_copied' . $key, $pre_reservation->eat_in != 1 ? 'disabled' : '']) }}
                                        {{ Form::label('eat_in_prepare_copied' . $key, '手配済み') }}
                                        {{ Form::radio('eat_in_prepare_copied' . $key, 2, $pre_reservation->eat_in_prepare ? ($pre_reservation->eat_in_prepare == 2 ? true : false) : false, ['id' => 'eat_in_concider_copied' . $key, $pre_reservation->eat_in != 1 ? 'disabled' : '']) }}
                                        {{ Form::label('eat_in_concider_copied' . $key, '検討中') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{ Form::radio('eat_in_copied' . $key, 0, $pre_reservation->eat_in ? ($pre_reservation->eat_in == 0 ? true : false) : true, ['id' => 'no_eat_in' . $key]) }}
                                        {{ Form::label('no_eat_in' . $key, 'なし') }}
                                    </td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    @endif


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
                                        {{ Form::text('in_charge_copied' . $key, $pre_reservation->in_charge, ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="table-active"><label for="mobilePhone">携帯番号</label></td>
                                    <td>
                                        {{ Form::text('tel_copied' . $key, $pre_reservation->tel, ['class' => 'form-control', 'placeholder' => '半角数字、ハイフンなしで入力してください']) }}
                                        <p class="{{ ' is-error-tel_copied' . $key }}" style="color: red"></p>
                                        <p class="annotation mt-1">※半角数字、ハイフンなしで入力下さい。</p>
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
                                        <div class="radio-box">
                                            <p>
                                                {{ Form::radio('email_flag_copied' . $key, 1, $pre_reservation->email_flag == 1 ? true : false, ['id' => 'email_flag_copied' . $key]) }}
                                                {{ Form::label('email_flag_copied' . $key, 'あり') }}
                                            </p>
                                            <p>
                                                {{ Form::radio('email_flag_copied' . $key, 0, $pre_reservation->email_flag == 0 ? true : false, ['id' => 'no_email_flag_copied' . $key]) }}
                                                {{ Form::label('no_email_flag_copied' . $key, 'なし') }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    @if ($venue->alliance_flag == 1)
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
                                    <td>
                                        <div class="d-flex align-items-center">
                                            {{ Form::text('cost_copied' . $key, $pre_reservation->cost ? $pre_reservation->cost : $venue->cost, ['class' => 'form-control']) }}
                                            <span class="ml-2">%</span>
                                        </div>
                                        <p class="{{ 'is-error-cost_copied' . $key }}" style="color: red"></p>
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
                                        <i class="fas fa-file-alt icon-size" aria-hidden="true"></i>
                                        備考
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="adminNote">管理者備考</label>
                                    {{ Form::textarea('admin_details_copied' . $key, $pre_reservation->admin_details, ['class' => 'form-control']) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- 右側の項目 終わり-------------------------------------------------- -->
            </div>
            <div class="btn_wrapper">
                <p class="text-center">
                    @if (count($venue->frame_prices) == 0 && count($venue->time_prices) == 0)
                        <div class="d-flex justify-content-center">
                            <div class="">
                                <p class="d-block">選択された会場は料金が設定されていません。会場管理/料金管理に戻り設定してください</p>
                                <a href="{{ url('/admin/frame_prices') }}" class="btn more_btn_lg mt-5 d-flex justify-content-center">料金管理画面へ</a>
                            </div>
                        </div>
                    @else
                        {{ Form::submit('個別日程に反映して保存', ['class' => 'btn more_btn_lg']) }}
                    @endif
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
                                            {{ number_format(empty($pre_reservation->pre_bill->master_total) ? 0 : $pre_reservation->pre_bill->master_total) }}
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
                                    @if (empty($pre_reservation->pre_bill))
                                        <p class="mb-2">※営業時間外の予約の為、管理者側にて料金設定を行います。</p>
                                        <tbody class="venue_head">
                                            <tr>
                                                <td>内容</td>
                                                <td>単価</td>
                                                <td>数量</td>
                                                <td>金額</td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                        <tbody class="{{ 'venue_main' . $key }}">
                                            <tr>
                                                <td>
                                                    {{ Form::text('venue_breakdown_item0_copied' . $key, '会場料金', ['class' => 'form-control']) }}
                                                </td>
                                                <td>
                                                    {{ Form::text('venue_breakdown_cost0_copied' . $key, 0, ['class' => 'form-control']) }}
                                                </td>
                                                <td>
                                                    {{ Form::text('venue_breakdown_count0_copied' . $key, 0, ['class' => 'form-control']) }}
                                                </td>
                                                <td>
                                                    {{ Form::text('venue_breakdown_subtotal0_copied' . $key, 0, ['class' => 'form-control']) }}
                                                </td>
                                                <td>
                                                    <input type="button" value="＋" class="add pluralBtn">
                                                    <input type="button" value="ー" class="del pluralBtn">
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody class="{{ 'venue_result' . $key }}">
                                            <tr>
                                                <td colspan="3"></td>
                                                <td colspan="1">
                                                    <p class="text-left">合計</p>
                                                    {{ Form::text('venue_price' . $key, '', ['class' => 'form-control col-xs-3', 'readonly']) }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    @else
                                        <tbody class="venue_head">
                                            <tr>
                                                <td>内容</td>
                                                <td>単価</td>
                                                <td>数量</td>
                                                <td>金額</td>
                                            </tr>
                                        </tbody>
                                        <tbody class="{{ 'venue_main' . $key }}">
                                            @foreach ($pre_reservation->pre_bill->pre_breakdowns->where('unit_type', 1) as $each_venue)
                                                <tr>
                                                    <td>
                                                        {{ Form::text('venue_breakdown_item0_copied' . $key, $each_venue->unit_item, ['class' => 'form-control', 'readonly']) }}
                                                    </td>
                                                    <td>
                                                        {{ Form::text('venue_breakdown_cost0_copied' . $key, $each_venue->unit_cost, ['class' => 'form-control', 'readonly']) }}
                                                    </td>
                                                    <td>
                                                        {{ Form::text('venue_breakdown_count0_copied' . $key, $each_venue->unit_count, ['class' => 'form-control', 'readonly']) }}
                                                    </td>
                                                    <td>
                                                        {{ Form::text('venue_breakdown_subtotal0_copied' . $key, $each_venue->unit_subtotal, ['class' => 'form-control', 'readonly']) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tbody class="{{ 'venue_result' . $key }}">
                                            <tr>
                                                <td colspan="3"></td>
                                                <td colspan="1">
                                                    <p class="text-left">合計</p>
                                                    {{ Form::text('venue_price' . $key, $pre_reservation->pre_bill->venue_price, ['class' => 'form-control col-xs-3', 'readonly']) }}
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
                                        <tbody class="{{ 'equipment_main' . $key }}">
                                            @foreach ($pre_reservation->pre_bill->pre_breakdowns->where('unit_type', 2) as $eb_key => $each_equ)
                                                <tr>
                                                    <td>
                                                        {{ Form::text('equipment_breakdown_item' . $eb_key . '_copied' . $key, $each_equ->unit_item, ['class' => 'form-control', 'readonly']) }}
                                                    </td>
                                                    <td>
                                                        {{ Form::text('equipment_breakdown_cost' . $eb_key . '_copied' . $key, $each_equ->unit_cost, ['class' => 'form-control', 'readonly']) }}
                                                    </td>
                                                    <td>
                                                        {{ Form::text('equipment_breakdown_count' . $eb_key . '_copied' . $key, $each_equ->unit_count, ['class' => 'form-control', 'readonly']) }}
                                                    </td>
                                                    <td>
                                                        {{ Form::text('equipment_breakdown_subtotal' . $eb_key . '_copied' . $key, $each_equ->unit_subtotal, ['class' => 'form-control', 'readonly']) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @foreach ($pre_reservation->pre_bill->pre_breakdowns->where('unit_type', 3) as $sb_key => $each_ser)
                                                <tr>
                                                    <td>
                                                        {{ Form::text('services_breakdown_item' . $sb_key . '_copied' . $key, $each_ser->unit_item, ['class' => 'form-control', 'readonly']) }}
                                                    </td>
                                                    <td>
                                                        {{ Form::text('services_breakdown_cost' . $sb_key . '_copied' . $key, $each_ser->unit_cost, ['class' => 'form-control', 'readonly']) }}
                                                    </td>
                                                    <td>
                                                        {{ Form::text('services_breakdown_count' . $sb_key . '_copied' . $key, $each_ser->unit_count, ['class' => 'form-control', 'readonly']) }}
                                                    </td>
                                                    <td>
                                                        {{ Form::text('services_breakdown_subtotal' . $sb_key . '_copied' . $key, $each_ser->unit_subtotal, ['class' => 'form-control', 'readonly']) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tbody class="{{ 'equipment_result' . $key }}">
                                            <tr>
                                                <td colspan="3"></td>
                                                <td colspan="1">
                                                    <p class="text-left">合計</p>
                                                    {{ Form::text('equipment_price' . $key, $pre_reservation->pre_bill->equipment_price, ['class' => 'form-control', 'readonly']) }}
                                                </td>
                                            </tr>
                                        </tbody>

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
                                        <tbody class="{{ 'layout_main' . $key }}">
                                            @foreach ($pre_reservation->pre_bill->pre_breakdowns->where('unit_type', 4) as $slp_key => $each_play)
                                                <tr>
                                                    <td>
                                                        {{ Form::text('layout_breakdown_item' . $slp_key . '_copied' . $key, $each_play->unit_item, ['class' => 'form-control', 'readonly']) }}
                                                    </td>
                                                    <td>
                                                        {{ Form::text('layout_breakdown_cost' . $slp_key . '_copied' . $key, $each_play->unit_cost, ['class' => 'form-control', 'readonly']) }}
                                                    </td>
                                                    <td>
                                                        {{ Form::text('layout_breakdown_count' . $slp_key . '_copied' . $key, $each_play->unit_count, ['class' => 'form-control', 'readonly']) }}
                                                    </td>
                                                    <td>
                                                        {{ Form::text('layout_breakdown_subtotal' . $slp_key . '_copied' . $key, $each_play->unit_subtotal, ['class' => 'form-control', 'readonly']) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tbody class="{{ 'layout_result' . $key }}">
                                            <tr>
                                                <td colspan="3"></td>
                                                <td colspan="1">
                                                    <p class="text-left">合計</p>
                                                    {{ Form::text('layout_price' . $key, $pre_reservation->pre_bill->layout_price, ['class' => 'form-control', 'readonly']) }}
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody class="{{ 'layout_discount' . $key }}">

                                    </table>
                                </div>
                            @endif

                            {{-- 以下、総合計 --}}
                            <div class="bill_total">
                                <table class="table">
                                    <tr>
                                        <td>小計：</td>
                                        <td>
                                            {{ Form::hidden('master_subtotal' . $key . 'fixed', empty($pre_reservation->pre_bill->master_subtotal) ? 0 : $pre_reservation->pre_bill->master_subtotal, ['class' => 'form-control text-right', 'readonly']) }}
                                            {{ Form::text('master_subtotal' . $key, empty($pre_reservation->pre_bill->master_subtotal) ? 0 : $pre_reservation->pre_bill->master_subtotal, ['class' => 'form-control text-right', 'readonly']) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>消費税：</td>
                                        <td>
                                            {{ Form::text('master_tax' . $key, empty($pre_reservation->pre_bill->master_tax) ? 0 : $pre_reservation->pre_bill->master_tax, ['class' => 'form-control text-right', 'readonly']) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">合計金額</td>
                                        <td>
                                            {{ Form::text('master_total' . $key, empty($pre_reservation->pre_bill->master_total) ? 0 : $pre_reservation->pre_bill->master_total, ['class' => 'form-control text-right', 'readonly']) }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <p class="more_btn_lg m-5 accordion-innbtn text-center">閉じる</p>
        </dt>
    </dl>
</div>
</section>
@endforeach

</section>

<section class="master_totals border-wrap">
<table class="table mb-0">
<tbody class="master_total_head">
<tr>
    <td colspan="2">
        <h3>
            合計請求額
            <span>({{ $multiple->pre_reservations->where('venue_id', $venue->id)->count() }}件分)</span>
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
    <td>{{ number_format($multiple->sumVenues($venue->id)) }}円</td>
</tr>
<tr>
    <td>・有料備品　サービス</td>
    <td>{{ number_format($multiple->sumEquips($venue->id)) }}円</td>
</tr>
<tr>
    <td>・レイアウト変更料</td>
    <td>{{ number_format($multiple->sumLayouts($venue->id)) }}円</td>
</tr>
</tbody>
<tbody class="master_total_bottom">
<tr>
    <td></td>
    <td class="d-flex justify-content-end" colspan="2">
        <p>小計：</p>
        <p>{{ number_format($multiple->sumMasterSubs($venue->id)) }}円</p>
    </td>
</tr>
<tr>
    <td></td>
    <td class="d-flex justify-content-end" colspan="2">
        <p>消費税：</p>
        <p>{{ number_format($multiple->sumMasterTax($venue->id)) }}円</p>
    </td>
</tr>
<tr>
    <td></td>
    <td class="d-flex justify-content-end" colspan="2">
        <p>合計金額：</p>
        <p>{{ number_format($multiple->sumMasterTotal($venue->id)) }}円</p>
    </td>
</tr>
</tbody>
</table>
</section>

<ul class="d-flex col-12 justify-content-around mt-5 align-items-center">
<li>
<p><a class="btn more_btn_lg" href="{{ url('/admin/multiples/' . $multiple->id) }}">詳細にもどる</a></p>
</li>
<li>
{{-- <a class="btn more_btn_lg" href="{{url('admin/multiples/'.$multiple->id)}}">保存する</a> --}}
@if (count($venue->frame_prices) === 0 && count($venue->time_prices) === 0)
<span>当該会場の料金体系が設定されていません。</span>
@else
<button id="master_submit" class="btn more_btn_lg">保存する</button>
@endif
</li>
</ul>

{{ Form::open(['url' => '/admin/multiples/' . $multiple->id . '/all_updates/' . $venue->id, 'method' => 'POST', 'id' => 'master_form', 'autocomplete' => 'off']) }}
@csrf
{{ Form::hidden('master_data', '', ['class' => 'btn btn-primary more_btn_lg', 'id' => 'master_data']) }}
{{ Form::close() }}



<script>
    // 室内飲食マスタ
    $(function() {
        $(document).on("click", "input:radio[name='cp_master_eat_in']", function() {
            var radioTarget = $('input:radio[name="cp_master_eat_in"]:checked').val();
            if (radioTarget == 1) {
                $('input:radio[name="cp_master_eat_in_prepare"]').prop('disabled', false);
            } else {
                $('input:radio[name="cp_master_eat_in_prepare"]').prop('disabled', true);
                $('input:radio[name="cp_master_eat_in_prepare"]').val("");
            }
        })
    })
    // 室内飲食個別
    $(function() {
        var target = $('input[name^="eat_in_copied"]').length / 2;
        for (let index = 0; index < target; index++) {
            $(document).on("click", 'input:radio[name="eat_in_copied' + index + '"]', function() {
                var radioTarget = $('input:radio[name="eat_in_copied' + index + '"]:checked').val();
                if (radioTarget == 1) {
                    $('input:radio[name="eat_in_prepare_copied' + index + '"]').prop('disabled', false);
                } else {
                    $('input:radio[name="eat_in_prepare_copied' + index + '"]').prop('disabled', true);
                    $('input:radio[name="eat_in_prepare_copied' + index + '"]').val("");
                }
            })
        }
    })

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
            var encodes = JSON.stringify(data);
            $('#master_data').val(encodes);
            $('#master_form').submit();
        })
    })

    $(function() {
        var maxTarget = $('input[name="reserve_date"]').val();
        $('.datepicker9').datepicker({
            dateFormat: 'yy-mm-dd',
            minDate: 0,
            maxDate: maxTarget,
            autoclose: true,
        });
    })



    $(document).on('click', '#all_check', function() {
        var parent_checked = $(this).prop('checked');
        var array = [];
        $('.checkbox').each(function(index, element) {
            $('.checkbox').eq(index).prop('checked', false);
            $('.checkbox').eq(index).prop('checked', parent_checked);
            if (parent_checked === true) {
                array.push($('.checkbox').eq(index).val());
            }
        })
        $('input[name="delete_target"]').val(JSON.stringify(array));
        console.log(array);
    });

    $(document).on('change', 'select[name="pre_reservation_sort_length"]', function() {
        var parent_checked = $("#all_check").prop('checked');
        var array = [];
        $('.checkbox').each(function(index, element) {
            $('.checkbox').eq(index).prop('checked', false);
            $('.checkbox').eq(index).prop('checked', parent_checked);
            if (parent_checked === true) {
                array.push($('.checkbox').eq(index).val());
            }
        })
        $('input[name="delete_target"]').val(JSON.stringify(array));
    });

    $(document).on('click', '.checkbox', function() {
        var parent_checked = $("#all_check").prop('checked');
        var array = [];
        $('.checkbox').each(function(index, element) {
            if ($('.checkbox').eq(index).prop('checked') === true) {
                array.push($('.checkbox').eq(index).val());
            }
        })
        $('input[name="delete_target"]').val(JSON.stringify(array));
    });

    $(document).on('click', '.sorting', function() {
        $('.checkbox').each(function(index, element) {
            $('.checkbox').eq(index).prop('checked', false);
        })
        $('input[name="delete_target"]').val("");
        $('#all_check').prop('checked', false);
    });

    $(function() {
        let dates = $('input[name^="reserve_date"]');
        let latestDate = new Date(-8640000000000000);
        let oldestDate = new Date(8640000000000000);
        let start_date;
        let end_date;

        for (let i = 0; i < dates.length; i++) {
            let target_date = $('input[name="reserve_date' + i + '"]');
            let target_elament = $('input[name="luggage_arrive_copied' + i + '"]');
            getHolidayCalendar(target_elament, target_date, 0);

            let date = new Date($(dates[i]).val().split(' ')[0]);
            if (date < oldestDate) {
                oldestDate = date;
                start_date = $('input[name="reserve_date' + i + '"]');
            }
            if (date > latestDate) {
                latestDate = date;
                end_date = $('input[name="reserve_date' + i + '"]');
            }
        }

        $('input[name^="luggage_arrive_copied"]').click(function() {
            let index = $('input[name^="luggage_arrive_copied"]').index(this);
            let target_date = $('input[name="reserve_date' + index + '"]')[0];
            let target_elament = $('input[name="luggage_arrive_copied' + index + '"]')[0];
            getHolidayCalendar(target_elament, target_date, 0);
        });
    });

</script>



@endsection
