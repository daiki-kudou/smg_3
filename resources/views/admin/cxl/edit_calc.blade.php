@extends('layouts.admin.app')

@section('content')
    <link href="{{ asset('/css/template.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/template.js') }}"></script>
    <script src="{{ asset('/js/admin/cxl/validation.js') }}"></script>

    @include('layouts.admin.breadcrumbs', ['cxl_id' => $reservation->cxls->first()->id, 'reservation_id' => $data['reservation_id']])
    @include('layouts.admin.errors')


    <div class="">
        <h2 class="mt-3 mb-3">一括キャンセル請求書 作成</h2>
        <hr>
    </div>

    @if (session('flash_message'))
        <div class="alert alert-danger">
            <ul>
                <li> {!! session('flash_message') !!} </li>
            </ul>
        </div>
    @endif

    {{ Form::open(['url' => '/admin/cxl/update', 'method' => 'post', 'class' => '', 'id' => 'cxl_multicalc', 'autocomplete' => 'off']) }}
    @csrf
    {{ Form::hidden('reservation_id', !empty($data['reservation_id']) ? $data['reservation_id'] : 0) }}
    {{ Form::hidden('user_id', !empty($data['user_id']) ? $data['user_id'] : 0) }}
    {{ Form::hidden('agent_id', !empty($data['agent_id']) ? $data['agent_id'] : 0) }}
    <section class="mt-5">
        <div class="bill">
            <div class="bill_details">
                <div class="head d-flex">
                    <div class="accordion_btn">
                        <i class="fas fa-plus bill_icon_size hide" aria-text="true"></i>
                        <i class="fas fa-minus bill_icon_size" aria-text="true"></i>
                    </div>
                    <div class="billdetails_ttl">
                        <h3>
                            請求内訳
                        </h3>
                    </div>
                </div>
                <div class="main">
                    <div class="cancel_content cancel_border bg-white">
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

                            @if (!empty($data['venue_price']))
                                <tbody class="venue_main_cancel">
                                    <tr>
                                        <td>会場料
                                            {{ Form::hidden('cxl_target_item[]', '会場料') }}
                                        </td>
                                        <td>{{ number_format($data['venue_price']) }}円
                                            {{ Form::hidden('cxl_target_cost[]', $data['venue_price']) }}
                                        </td>
                                        <td class="multiple">×</td>
                                        <td class="">
                                            <div class="d-flex align-items-center">
                                                {{ $data['cxl_venue_PC'] }}
                                                {{ Form::hidden('cxl_target_percent[]', $data['cxl_venue_PC']) }}
                                                {{ Form::hidden('cxl_venue_PC', $data['cxl_venue_PC']) }}
                                                {{ Form::hidden('cxl_target_type[]', 1) }}
                                                <span>%</span>
                                            </div>
                                            <p class="is-error-cxl_venue_PC" style="color: red"></p>
                                        </td>
                                    </tr>
                                </tbody>
                            @endif


                            @if (!empty($data['equipment_price']))
                                <tbody class="equipment_cancel">
                                    <tr>
                                        <td>有料備品・有料サービス料
                                            {{ Form::hidden('cxl_target_item[]', '有料備品・有料サービス料') }}
                                        </td>
                                        <td>{{ number_format($data['equipment_price']) }}円
                                            {{ Form::hidden('cxl_target_cost[]', $data['equipment_price']) }}
                                        </td>
                                        <td class="multiple">×</td>
                                        <td class="">
                                            <div class="d-flex align-items-center">
                                                {{ $data['cxl_equipment_PC'] }}
                                                {{ Form::hidden('cxl_target_percent[]', $data['cxl_equipment_PC']) }}
                                                {{ Form::hidden('cxl_equipment_PC', $data['cxl_equipment_PC']) }}
                                                {{ Form::hidden('cxl_target_type[]', 2) }}
                                                <span>%</span>
                                            </div>
                                            <p class="is-error-cxl_equipment_PC" style="color: red"></p>
                                    </tr>
                                </tbody>
                            @endif

                            @if (!empty($data['layout_price']))
                                <tbody class="layout_cancel">
                                    <tr>
                                        <td>レイアウト変更料
                                            {{ Form::hidden('cxl_target_item[]', 'レイアウト変更料') }}
                                        </td>
                                        <td>{{ number_format($data['layout_price']) }}円
                                            {{ Form::hidden('cxl_target_cost[]', $data['layout_price']) }}
                                        </td>
                                        <td class="multiple">×</td>
                                        <td class="">
                                            <div class="d-flex align-items-center">
                                                {{ $data['cxl_layout_PC'] }}
                                                {{ Form::hidden('cxl_target_percent[]', $data['cxl_layout_PC']) }}
                                                {{ Form::hidden('cxl_layout_PC', $data['cxl_layout_PC']) }}
                                                {{ Form::hidden('cxl_target_type[]', 4) }}
                                                <span>%</span>
                                        </td>
                                        <p class="is-error-cxl_layout_PC" style="color: red"></p>
                                    </tr>
                                </tbody>
                            @endif

                            @if (!empty($data['other_price']))
                                <tbody class="others_cancel">
                                    <tr>
                                        <td>その他
                                            {{ Form::hidden('cxl_target_item[]', 'その他') }}
                                        </td>
                                        <td>{{ number_format($data['other_price']) }}円
                                            {{ Form::hidden('cxl_target_cost[]', $data['other_price']) }}
                                        </td>
                                        <td class="multiple">×</td>
                                        <td class="">
                                            <div class="d-flex align-items-center">
                                                {{ $data['cxl_other_PC'] }}
                                                {{ Form::hidden('cxl_target_percent[]', $data['cxl_other_PC']) }}
                                                {{ Form::hidden('cxl_other_PC', $data['cxl_other_PC']) }}
                                                {{ Form::hidden('cxl_target_type[]', 5) }}
                                                <span>%</span>
                                        </td>
                                        <p class="is-error-cxl_layout_PC" style="color: red"></p>
                                    </tr>
                                </tbody>
                            @endif

                            @if (!empty($data['adjust']) && $data['adjust'] !== 0)
                                <tbody class="others_cancel">
                                    <tr>
                                        <td>調整費
                                            {{ Form::hidden('cxl_target_item[]', '調整費') }}
                                        </td>
                                        <td>{{ number_format($data['adjust']) }}円
                                            {{ Form::hidden('cxl_target_cost[]', $data['adjust']) }}
                                        </td>
                                        <td class="multiple">×</td>
                                        <td class="">
                                            <div class="d-flex align-items-center">
                                                100
                                                {{ Form::hidden('cxl_target_percent[]', 100) }}
                                                {{ Form::hidden('cxl_target_type[]', 5) }}
                                                {{ Form::hidden('adjust', $data['adjust']) }}
                                                <span>%</span>
                                        </td>
                                        <p class="is-error-cxl_layout_PC" style="color: red"></p>
                                    </tr>
                                </tbody>
                            @endif
                        </table>
                    </div>

                    <div class="cancel_content">
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
                            <tbody class="head_cancel">
                                <tr>
                                    <td>内容</td>
                                    <td>単価</td>
                                    <td>数量</td>
                                    <td>金額</td>
                                </tr>
                            </tbody>
                            <tbody class="">
                                @if (!empty($data['venue_price']))
                                    <tr>
                                        <td>キャンセル料 (<span>会場料</span>・<span>{{ $data['cxl_venue_PC'] }}%</span>)
                                            {{ Form::hidden('cxl_unit_item[]', 'キャンセル料(会場料・' . $data['cxl_venue_PC'] . '%)') }}
                                        </td>
                                        <td>{{ number_format(round($data['cxl_venue'])) }}
                                            {{ Form::hidden('cxl_unit_cost[]', round($data['cxl_venue'])) }}
                                        </td>
                                        <td>1
                                            {{ Form::hidden('cxl_unit_count[]', 1) }}
                                        </td>
                                        <td>
                                            {{ number_format(round($data['cxl_venue'])) }}円
                                            {{ Form::hidden('cxl_unit_subtotal[]', round($data['cxl_venue'])) }}
                                            {{ Form::hidden('cxl_unit_percent[]', $data['cxl_venue_PC']) }}
                                        </td>
                                    </tr>
                                @endif
                                @if (!empty($data['equipment_price']))
                                    <tr>
                                        <td>キャンセル料 (<span>有料備品・サービス料</span>・<span>{{ $data['cxl_equipment_PC'] }}%</span>)
                                            {{ Form::hidden('cxl_unit_item[]', 'キャンセル料(有料備品・サービス料・' . $data['cxl_equipment_PC'] . '%)') }}
                                        </td>
                                        <td>{{ number_format(round($data['cxl_equipment'])) }}
                                            {{ Form::hidden('cxl_unit_cost[]', round($data['cxl_equipment'])) }}
                                        </td>
                                        <td>1
                                            {{ Form::hidden('cxl_unit_count[]', 1) }}
                                        </td>
                                        <td>{{ number_format(round($data['cxl_equipment'])) }}円
                                            {{ Form::hidden('cxl_unit_subtotal[]', round($data['cxl_equipment'])) }}
                                            {{ Form::hidden('cxl_unit_percent[]', $data['cxl_equipment_PC']) }}
                                        </td>
                                    </tr>
                                @endif
                                @if (!empty($data['layout_price']))
                                    <tr>
                                        <td>キャンセル料 (<span>レイアウト変更料</span>・<span>{{ $data['cxl_layout_PC'] }}%</span>)
                                            {{ Form::hidden('cxl_unit_item[]', 'キャンセル料(レイアウト変更料・' . $data['cxl_layout_PC'] . '%)') }}
                                        </td>
                                        <td>{{ number_format(round($data['cxl_layout'])) }}
                                            {{ Form::hidden('cxl_unit_cost[]', round($data['cxl_layout'])) }}
                                        </td>
                                        <td>1
                                            {{ Form::hidden('cxl_unit_count[]', 1) }}
                                        </td>
                                        <td>{{ number_format(round($data['cxl_layout'])) }}円
                                            {{ Form::hidden('cxl_unit_subtotal[]', round($data['cxl_layout'])) }}
                                            {{ Form::hidden('cxl_unit_percent[]', $data['cxl_layout_PC']) }}
                                        </td>
                                    </tr>
                                @endif
                                @if (!empty($data['other_price']))
                                    <tr>
                                        <td>キャンセル料 (<span>その他</span>・<span>{{ $data['cxl_other_PC'] }}%</span>)
                                            {{ Form::hidden('cxl_unit_item[]', 'キャンセル料(その他・' . $data['cxl_other_PC'] . '%)') }}
                                        </td>
                                        <td>{{ number_format(round($data['cxl_other'])) }}
                                            {{ Form::hidden('cxl_unit_cost[]', round($data['cxl_other'])) }}
                                        </td>
                                        <td>1
                                            {{ Form::hidden('cxl_unit_count[]', 1) }}
                                        </td>
                                        <td>{{ number_format(round($data['cxl_other'])) }}円
                                            {{ Form::hidden('cxl_unit_subtotal[]', round($data['cxl_other'])) }}
                                            {{ Form::hidden('cxl_unit_percent[]', $data['cxl_other_PC']) }}
                                        </td>
                                    </tr>
                                @endif
                                @if (!empty($data['adjust']) && $data['adjust'] !== 0)
                                    <tr>
                                        <td>調整費
                                            {{ Form::hidden('cxl_unit_item[]', '調整費') }}
                                        </td>
                                        <td>{{ number_format(round($data['adjust'])) }}
                                            {{ Form::hidden('cxl_unit_cost[]', round($data['adjust'])) }}
                                        </td>
                                        <td>1
                                            {{ Form::hidden('cxl_unit_count[]', 1) }}
                                        </td>
                                        <td>{{ number_format(round($data['adjust'])) }}円
                                            {{ Form::hidden('cxl_unit_subtotal[]', round($data['adjust'])) }}
                                            {{ Form::hidden('cxl_unit_percent[]', 100) }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="bill_total">
                        <table class="table text-right">
                            <tbody>
                                <tr>
                                    <td>小計：</td>
                                    <td>
                                        {{ Form::text('', number_format(round($data['adjust_result'])), ['class' => 'form-control', 'readonly']) }}
                                        {{ Form::hidden('master_subtotal', round($data['adjust_result']), ['class' => 'form-control', 'readonly']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>消費税：</td>
                                    <td>
                                        {{ Form::text('', number_format(round(ReservationHelper::getTax($data['adjust_result']))), ['class' => 'form-control', 'readonly']) }}
                                        {{ Form::hidden('master_tax', round(ReservationHelper::getTax($data['adjust_result'])), ['class' => 'form-control', 'readonly']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">合計金額</td>
                                    <td>
                                        {{ Form::text('', number_format(round(ReservationHelper::taxAndPrice($data['adjust_result']))), ['class' => 'form-control', 'readonly']) }}
                                        {{ Form::hidden('master_total', round(ReservationHelper::taxAndPrice($data['adjust_result'])), ['class' => 'form-control', 'readonly']) }}
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
                        <i class="fas fa-plus bill_icon_size hide" aria-text="true"></i>
                        <i class="fas fa-minus bill_icon_size" aria-text="true"></i>
                    </div>
                    <div class="billdetails_ttl">
                        <h3>
                            請求書情報
                        </h3>
                    </div>
                </div>
                <div class="main">
                    <div class="informations billdetails_content">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>請求日：
                                        {{ Form::text('bill_created_at', date('Y-m-d', strtotime($cxl->bill_created_at)), ['class' => 'form-control', 'id' => 'datepicker1']) }}
                                    </td>
                                    <td>支払期日
                                        {{ Form::text('payment_limit', $cxl->payment_limit, ['class' => 'form-control datepicker', 'id' => '']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        請求書宛名
                                        {{ Form::text('bill_company', $cxl->bill_company, ['class' => 'form-control']) }}
                                    </td>
                                    <td>
                                        担当者
                                        {{ Form::text('bill_person', $cxl->bill_person, ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">請求書備考
                                        {{ Form::textarea('bill_remark', $cxl->bill_remark, ['class' => 'form-control']) }}
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
                                    <td>入金状況
                                        {{ Form::select('paid', ['未入金', '入金済み', '遅延', '入金不足', '入金過多', '次回繰越'], $cxl->paid, ['class' => 'form-control']) }}
                                    </td>
                                    <td>
                                        入金日
                                        {{ Form::text('pay_day', $cxl->pay_day, ['class' => 'form-control datepicker', 'id' => '']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>振込名
                                        {{ Form::text('pay_person', $cxl->pay_person, ['class' => 'form-control']) }}
                                        <p class="is-error-pay_person" style="color: red"></p>
                                    </td>
                                    <td>入金額
                                        {{ Form::text('payment', $cxl->payment, ['class' => 'form-control']) }}
                                        <p class="is-error-payment" style="color: red"></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-field d-flex justify-content-center mt-5">
            {{ Form::hidden('multi', 1) }}
            {{ Form::submit('修正する', ['class' => 'btn more_btn4_lg d-block mr-5', 'name' => 'back']) }}
            {{ Form::submit('保存する', ['class' => 'btn more_btn_lg d-block']) }}
        </div>
        {{ Form::close() }}
    </section>


    <script>
        $(function() {
            // チェックボックス開閉
            checkToggle('.venue_chkbox #venue', ['.venue_head', '.venue_main', '.venue_result']);
            checkToggle('.equipment_chkbox #equipment', ['.equipment_head', '.equipment_main',
                '.equipment_result'
            ]);
            checkToggle('.layout_chkbox #layout', ['.layout_head', '.layout_main', '.layout_result']);
            checkToggle('.others_chkbox #others', ['.others_head', '.others_main', '.others_result']);

            function checkToggle($target, $items) {
                $($target).on('click', function() {
                    $.each($items, function(index, value) {
                        $(value).toggleClass('hide');
                    });
                });
            }

        })
    </script>
    </section>
@endsection
