<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>請求書</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link href="{{ asset('/css/invoice.css') }}" rel="stylesheet" media="screen">
    <link href="{{ asset('/css/print.css') }}" rel="stylesheet" media="print">

</head>

<body>
    <div class="button-wrap">
        <p><input class="print-btn" type="button" value="このページを印刷する" onclick="window.print();" /></p>
    </div>

    <section class="invoice-box print_pages "> {{-- 打消しのときにクラスcancel_lineを付与する --}}
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="4">
                    <h1 class="top-title">請求書</h1>
                </td>
            </tr>
            <tr class="information">
                <td>
                    <dl>
                        <dd>
                            {{-- @if ($reservation->user_id > 0)
                                {{ $reservation->user->company }}御中
                            @else
                                {{ ReservationHelper::getAgentCompany($reservation->agent_id) }}御中
                            @endif --}}
                            @if ($cxl)
                                {{ $cxl->bill_company }}御中
                            @else
                                {{ $bill->bill_company }}御中
                            @endif
                        </dd>
                        <dd>
                            @if ($cxl)
                                {{ $cxl->bill_person }}様
                            @else
                                {{ $bill->bill_person }}様
                            @endif
                        </dd>
                    </dl>
                </td>
                <td>
                    <dl>
                        <dd>SMGアクセア貸し会議室</dd>
                        <dd>〒550-0014</dd>
                        <dd>大阪市西区北堀江1丁目6番2号</dd>
                        <dd>サンワールドビル11階</dd>
                        <dd>TEL：06-6556-6462</dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td colspan="4" class="title">
                    <p>ご利用いただきありがとうございます。</p>
                    <p>下記の通りご請求申し上げます。</p>
                </td>
            </tr>
            <tr>
                <td>
                    <dl class="total-billing">
                        <dt>ご請求金額</dt>
                        <dd>
                            @if ($cxl)
                                {{number_format($cxl->master_total)}}
                            @else
                                {{ number_format($bill->master_total) }}
                            @endif
                            <span>円</span><span class="tax">(税込)</span>
                        </dd>
                    </dl>
                </td>
                <td>
                    <p><span>請求書No：</span>
                        @if ($cxl)
                            {{ $cxl->id }}
                        @else
                            {{ $bill->id }}
                        @endif

                    </p>
                    <p><span>請求日：</span>
                        @if ($cxl)
                            {{ ReservationHelper::formatDate($cxl->bill_created_at) }}
                        @else
                            {{ ReservationHelper::formatDate($bill->bill_created_at) }}
                        @endif
                    </p>
                    <p><span>支払期日：</span>
                        @if ($cxl)
                            {{ ReservationHelper::formatDate($cxl->payment_limit) }}
                        @else
                            {{ ReservationHelper::formatDate($bill->payment_limit) }}
                        @endif
                    </p>
                </td>
            </tr>
        </table>

        <table cellpadding="0" cellspacing="0" class="bill-detail-table">
            <thead>
                <tr class="heading">
                    <td colspan="4">
                        <dl class="bill-heading">
                            <dd>{{ ReservationHelper::formatDate($reservation->reserve_date) }}<span>ご利用料金</span>
                            </dd>
                            <dd>{{ ReservationHelper::getVenueForUser($reservation->venue_id) }}</dd>
                        </dl>
                    </td>
                </tr>
            </thead>
            <tbody class="bill-wrap">
                @if ($cxl)
                    <tr class="bill-details">
                        <td>
                            内容
                        </td>
                        <td>
                            単価
                        </td>
                        <td>
                            数量
                        </td>
                        <td>
                            金額
                        </td>
                    </tr>
                    @foreach ($cxl->cxl_breakdowns->where('unit_type',1) as $cxl_breakdowns)
                        <tr class="bill-details">
                            <td>{{$cxl_breakdowns->unit_item}}</td>
                            <td>{{number_format($cxl_breakdowns->unit_cost)}}</td>
                            <td>{{$cxl_breakdowns->unit_count}}</td>
                            <td>{{number_format($cxl_breakdowns->unit_subtotal)}}<span>円</span></td>
                        </tr>
                    @endforeach
                @else
                    @if ($reservation->user_id > 0)
                        <tr class="bill-details">
                            <td>
                                内容
                            </td>
                            <td>
                                単価
                            </td>
                            <td>
                                数量
                            </td>
                            <td>
                                金額
                            </td>
                        </tr>
                        @foreach ($bill->breakdowns as $item)
                            <tr class="bill-details">
                                <td>
                                    {{ $item->unit_item }}
                                </td>
                                <td>
                                    {{ number_format($item->unit_cost) }}
                                </td>
                                <td>
                                    {{ $item->unit_count }}
                                </td>
                                <td>
                                    {{ number_format($item->unit_subtotal) }}<span>円</span>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="bill-details">
                            <td>
                                内容
                            </td>
                            {{-- <td>金額</td> --}}
                        </tr>
                        @foreach ($bill->breakdowns as $item)
                            <tr class="bill-details">
                                <td>{{ $item->unit_item }}</td>
                                {{-- <td>
                                    {{ number_format($bill->master_subtotal) }}<span>円</span>
                                </td> --}}
                            </tr>
                        @endforeach
                    @endif
                @endif
            </tbody>
        </table>
        <div class="pagebreak"></div>
        <table cellpadding="0" cellspacing="0" class="total-table">
            <tr class="total">
                <td>
                    <p class="sub-total"><span>小計：</span>
                      @if ($cxl)
                      {{ number_format($cxl->master_subtotal) }}円
                      @else
                      {{ number_format($bill->master_subtotal) }}円
                        @endif
                    </p>
                    <p class="sub-tax"><span>消費税：</span>
                      @if ($cxl)
                      {{ number_format($cxl->master_tax) }}円
                      @else
                      {{ number_format($bill->master_tax) }}円
                        @endif
                    </p>
                </td>
            </tr>
            <tr class="total-amount">
                <td>
                    <span>請求総額：</span>
                    @if ($cxl)
                    {{ number_format($cxl->master_total) }}
                    @else
                    {{ number_format($bill->master_total) }}
                      @endif
                    <span>円</span>
                </td>
            </tr>
        </table>
        <table cellpadding="0" cellspacing="0" class="bill-note-wrap">
            <tr>
                <td class="bank-info">
                    <p>※申込時の「会社名・団体名」名義でお振込み下さい。別名義でのお振込みの場合は必ず事前にSMGまでご連絡下さい。
                        お振込み手数料は御社ご負担にてお願い致します。
                    </p>
                    <p>お振込み先：みずほ銀行　四ツ橋支店　普通 1113739　ｶ)ｴｽｴﾑｼﾞｰ</p>
            </tr>
            <tr>
                <td class="bill-note">
                    <p>備考</p>
                    <p>
                      @if ($cxl)
                      {{ $cxl->bill_remark }}
                      @else
                      {{ $bill->bill_remark }}
                        @endif
                    </p>
                </td>
            </tr>
        </table>
    </section>
</body>

<script>
    $(function() {
        var len = $(".bill-details").length;
        console.log(len);

        if (len > 17) {
            $(".bill-note-wrap").addClass("break");
            // $(".total-table").css('margin-top','20mm');
        } else {
            $(".bill-note-wrap").removeClass("break");
        }
    });

</script>

</html>



