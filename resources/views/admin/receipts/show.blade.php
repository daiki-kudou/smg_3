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

  @if ($bill)
  @include('admin.receipts.receipt.bill.detail')
  @else
  @include('admin.receipts.receipt.cxl.detail')
  @endif

</body>

<script>
  $(function() {
        var len = $(".bill-details").length;
        if (len > 17) {
            $(".bill-note-wrap").addClass("break");
        } else {
            $(".bill-note-wrap").removeClass("break");
        }
    });

    // マイナスの場合の色変更
    $(function(){
      $('.master-total, .master-subtotal, .bill-detail-table td').each(function(index, value){
        var target=$(value).text();
        if (target.match(/-/)) {
          $(value).css('color','red');
        }
      });
    });

    $(function(){
      $('.bill-detail-table td:nth-child(2n)').each(function(index, value){
        var target=$(value).text();
        if (target.match(/-/)) {
          var result =target.replace('-','▲');
          $(value).text(result);
        }
      });
    });

</script>

</html>