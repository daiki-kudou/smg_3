<p style="font-size: 26px;">丸岡さん、以下が予約関連情報です</p>
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
</table>