<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>領収書</title>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link href="{{ asset('/css/invoice.css') }}" rel="stylesheet" media="screen">
  <link href="{{ asset('/css/print.css') }}" rel="stylesheet" media="print">

</head>

<body>
  <div class="button-wrap">
    <p><input class="print-btn" type="button" value="このページを印刷する" onclick="window.print();" /></p>
  </div>

  <section class="invoice-box print_pages">
    <!-- <div class="cancel_line">打消し</div> -->
    <table cellpadding="0" cellspacing="0" >
      <tr class="top">
        <td colspan="4">
          <h1 class="top-title">領収書</h1>
        </td>
      </tr>
      <tr class="information">
        <td>
          <dl>
            <dd>{{$bill->bill_company}}御中</dd>
            <dd>{{$bill->bill_person}}</dd>
          </dl>
        </td>
        <td>
          <dl>
            <dd>SMGアクセア貸し会議室</dd>
            <dd>〒550-0014</dd>
            <dd>大阪市西区北堀江1丁目6番2号</dd>
            <dd>サンワールドビル11階</dd>
            <dd>TEL：06-6538-4329</dd>
          </dl>
        </td>
      </tr>
      <tr>
        <td colspan="4" class="title">
          <p>但し、<span>{{ReservationHelper::formatDate($bill->pay_day)}}</span>の会場利用料として</p>
          <p>下記の通り、領収いたしました。</p>
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
          <p><span>領収書No：</span>あとで変数化！！2020092225</p>
          <p><span>発行日：</span>{{ReservationHelper::formatDate($bill->pay_day)}}</p>
        </td>
      </tr>
    </table>

    <table cellpadding="0" cellspacing="0" class="bill-detail-table" >
      <thead>
        <tr class="heading">
          <td colspan="4">
            <dl class="bill-heading">
              <dd>{{ReservationHelper::formatDate($bill->reservation->reserve_date)}}<span>ご利用料金</span></dd>
              <dd>{{ReservationHelper::getVenueForUser($bill->reservation->venue_id)}}</dd>
            </dl>
          </td>
        </tr>
      </thead>
      <tbody class="bill-wrap">
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
          {{$item->unit_item}}
          </td>
          <td>
          {{number_format($item->unit_cost)}}
          </td>
          <td>
          {{$item->unit_count}}
          </td>
          <td>
          {{number_format($item->unit_subtotal)}}<span>円</span>
          </td>
        </tr>
        @endforeach
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
          <span>請求総額：</span>{{number_format($bill->master_total)}}<span>円</span>
        </td>
      </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="bill-note-wrap">
      <tr>
        <td class="bill-note">
          <p>備考</p>
          <p>{{$bill->bill_remark}}</p>
        </td>
      </tr>
    </table>
  </section>
</body>

<script>

$(function () {
  var len = $(".bill-details").length;
  console.log(len);

  if( len > 17) {
$(".bill-note-wrap").addClass("break");
// $(".total-table").css('margin-top','20mm');
  } else {
    $(".bill-note-wrap").removeClass("break");
  }
  });
</script>

</html>






<!-- 
{{-- 請求書情報 --}}
<pre>{{var_dump($bill)}}</pre>

{{-- ユーザー情報 --}}
<pre>{{var_dump($bill->reservation->user)}}</pre>

{{-- 仲介会社情報 --}}
<pre>{{var_dump($bill->reservation->agent)}}</pre>


{{-- 請求書内訳 --}}
<pre>{{var_dump($bill->breakdowns)}}</pre> -->
