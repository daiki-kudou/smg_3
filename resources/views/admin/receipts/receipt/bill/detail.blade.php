<section class="invoice-box print_pages">
  <table cellpadding="0" cellspacing="0">
    <tr class="top">
      <td colspan="4">
        <h1 class="top-title">領収書</h1>
      </td>
    </tr>
    <tr class="information">
      <td>
        <dl class="company-name">
          <dd>{{$bill->bill_company}} 御中</dd>
        </dl>
      </td>
      <td>
        <dl class="stamp-area">
          <dd>株式会社SMG</dd>
          <dd>〒550-0014</dd>
          <dd>大阪市西区北堀江1丁目6番2号</dd>
          <dd>サンワールドビル11階</dd>
          <dd>TEL：06-6556-6462</dd>
        </dl>
      </td>
    </tr>
    <tr>
      <td colspan="4" class="title">
        <p>但し、<span>{{ReservationHelper::formatDate($bill->reservation->reserve_date)}}</span>の会場利用料として</p>
        <p>{{ReservationHelper::formatDate($bill->pay_day)}}、下記の通り、領収いたしました。</p>
      </td>
    </tr>
    <tr>
      <td>
        <dl class="total-billing">
          <dt>金額</dt>
          <dd>{{number_format($bill->payment)}}<span>円</span><span class="tax">(税込)</span></dd>
        </dl>
      </td>
      <td>
        <p><span>領収書No：</span>{{ $bill->invoice_number }}</p>
      </td>
    </tr>
  </table>

  <table cellpadding="0" cellspacing="0" class="bill-detail-table">
    <thead>
      <tr class="heading">
        <td colspan="4">
          <dl class="bill-heading">
            <dd>{{ReservationHelper::formatDate($bill->reservation->reserve_date)}}<span>ご利用料金</span></dd>
            <dd>{{ReservationHelper::getVenueForUser($bill->reservation->venue_id)}}{{ (int) $bill->reservation->price_system === 2 ? '(音響HG)' : '' }}</dd>
          </dl>
        </td>
      </tr>
    </thead>
    <tbody class="bill-wrap">
      @if ($bill->reservation->user_id > 0)
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
      </tr>
      @foreach ($bill->breakdowns as $item)
      <tr class="bill-details">
        <td>{{ $item->unit_item }}</td>
      </tr>
      @endforeach
      @endif
    </tbody>
  </table>
  <div class="pagebreak"></div>
  <table cellpadding="0" cellspacing="0" class="total-table">
    <tr class="total">
      <td>
        <p class="sub-total"><span>小計：</span>{{number_format($bill->master_subtotal)}}円</p>
        <p class="sub-tax"><span>消費税：</span>{{number_format($bill->master_tax)}}円</p>
      </td>
    </tr>
    <tr class="total-amount">
      <td>
        <span>合計：</span>{{number_format($bill->master_total)}}<span>円</span>
      </td>
    </tr>
  </table>
</section>