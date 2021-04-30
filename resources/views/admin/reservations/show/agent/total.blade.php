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
        <td>
          {{$agentPriceWithoutLayout}}
          円</td>
      </tr>
      <tr>
        <td>・レイアウト変更料</td>
        <td>
          {{$agentLayoutPrice}}
          円</td>
      </tr>
    </tbody>
    <tbody class="master_total_bottom mb-0">
      <tr>
        <td></td>
        <td>
          <div class="d-flex justify-content-end">
            <p>小計：</p>
            <p>{{$agentPrice}}円</p>
          </div>
        </td>
      </tr>
      <tr>
        <td></td>
        <td>
          <div class="d-flex justify-content-end">
            <p>消費税：</p>
            <p>{{ReservationHelper::getTax($agentPrice)}}円</p>
          </div>
        </td>
      </tr>
      <tr>
        <td></td>
        <td>
          <div class="d-flex justify-content-end">
            <p>合計金額：</p>
            <p>{{ReservationHelper::taxAndPrice($agentPrice)}}円</p>
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