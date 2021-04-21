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

  <section class="invoice-box print_pages">
    <!-- <div class="cancel_line">打消し</div> -->
    <table cellpadding="0" cellspacing="0">
      <tr class="top">
        <td colspan="4">
          <h1 class="top-title">請求書</h1>
        </td>
      </tr>
      <tr class="information">
        <td>
          <dl>
            <dd>{{$reservation->user->company}}御中</dd>
            <dd>{{$reservation->user->first_name}}{{$reservation->user->last_name}}様</dd>
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
          <p>ご利用いただきありがとうございます。</p>
          <p>下記の通りご請求申し上げます。</p>
        </td>
      </tr>
      <tr>
        <td>
          <dl class="total-billing">
            <dt>ご請求金額</dt>
            <dd>{{$bill->master_total}}<span>円</span><span class="tax">(税込)</span></dd>
          </dl>
        </td>
        <td>
          <p><span>請求書No：</span>{{$bill->id}}</p>
          <p><span>請求日：</span>{{$bill->bill_created_at}}</p>
          <p><span>支払期日：</span>{{$bill->bill_pay_limit}}</p>
        </td>
      </tr>
    </table>

    <table cellpadding="0" cellspacing="0" class="bill-detail-table">
      <thead>
        <tr class="heading">
          <td colspan="4">
            <dl class="bill-heading">
              <dd>{{$reservation->reserve_date}}<span>ご利用料金</span></dd>
              <dd>{{$reservation->venue_id}}</dd>
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
          {{$item->unit_cost}}
          </td>
          <td>
          {{$item->unit_count}}
          </td>
          <td>
          {{$item->unit_subtotal}}<span>円</span>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="pagebreak"></div>
    <table cellpadding="0" cellspacing="0" class="total-table">
      <tr class="total">
        <td>
          <p class="sub-total"><span>小計：</span>{{$bill->master_subtotal}}円</p>
          <p class="sub-tax"><span>消費税：</span>{{$bill->master_tax}}円</p>
        </td>
      </tr>
      <tr class="total-amount">
        <td>
          <span>請求総額：</span>{{$bill->master_total}}<span>円</span>
        </td>
      </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="bill-note-wrap">
      <tr>
        <td class="bank-info">
          <p>お振込み先：みずほ銀行　四ツ橋支店　普通 1113739　ｶ)ｴｽｴﾑｼﾞｰ</p>
      </tr>
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

// $(function () {
//   var len = $(".bill-details").length;
//   console.log(len);

//   if( len > 16) {
// $(".pagebreak").addClass("break");
// // $(".total-table").css('margin-top','20mm');
//   } else {
//     $(".pagebreak").removeClass("break");
//   }
//   });
</script>

</html>





<!-- <p style="font-size: 26px;">丸岡さん、以下が予約関連情報です</p>
↓　↓　↓　↓　↓　↓　↓　↓　↓　↓　<br>
<pre>{{var_dump($reservation)}}</pre><br>

<br>

<p style="font-size: 26px;">
  変数の取得に関して、
  予約日がほしい場合</p>
↓　↓　↓　↓　↓　↓　↓　↓　↓　↓　<br>
{{$reservation->reserve_date}}

<p style="font-size: 26px;">
  変数の取得に関して、
  予約に紐づくユーザー情報がほしい場合</p>
↓　↓　↓　↓　↓　↓　↓　↓　↓　↓　<br>
{{$reservation->user->company}}

<p style="font-size: 26px;">
  変数の取得に関して、
  予約に紐づく請求書(bills)情報がほしい場合</p>
↓　↓　↓　↓　↓　↓　↓　↓　↓　↓　<br>
{{$bill->master_subtotal}}

<p style="font-size: 26px;">
  変数の取得に関して、
  予約に紐づく内訳(breakdowns)情報がほしい場合</p>
<p style="color: red;">内訳は必ずforeachで回すこと</p>
↓　↓　↓　↓　↓　↓　↓　↓　↓　↓　<br>
<table>
  @foreach ($bill->breakdowns as $item)
  <tr>
    <td>{{$item->unit_item}}
      {{$item->unit_cost}}
      {{$item->unit_count}}
      {{$item->unit_subtotal}}</td>
  </tr>
  @endforeach
</table> -->