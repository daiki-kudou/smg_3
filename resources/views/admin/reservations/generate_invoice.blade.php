<!doctype html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>PDF</title>
    <style>
        @font-face {
            font-family: migmix-1p-regular;
            font-style: normal;
            font-weight: normal;
            src: url('{{ storage_path('fonts/migmix-1p-regular.ttf') }}') format('truetype');
        }

        @font-face {
            font-family: migmix-1p-regular;
            font-style: bold;
            font-weight: bold;
            src: url('{{ storage_path('fonts/migmix-1p-regular.ttf') }}') format('truetype');
        }

        body {
            font-family: migmix-1p-regular;
        }

    </style>
</head>

<body>
    <div class="wrapper">
        <p>ご請求書</p>
        {{ $user->company }}　御中<br>
        {{ $user->first_name }}{{ $user->last_name }}　様
        <div>
            <p>下記の通りご請求申し上げます</p>
        </div>
        <p>
            ご請求額<br>{{ number_format($reservation->bills()->first()->total) }}
        </p>
        <table class="">
            @foreach ($reservation->breakdowns as $item)
                <tr>
                    <td>{{ $item->unit_item }}</td>
                    <td>{{ $item->unit_count }}</td>
                    <td>{{ $item->unit_cost }}</td>
                    <td>{{ $item->unit_subtotal }}</td>
                </tr>
            @endforeach
        </table>
        <div>
            小計： {{ $reservation->bills()->first()->sub_total }}<br>
            消費税： {{ $reservation->bills()->first()->tax }}<br>
            総請求額： {{ $reservation->bills()->first()->total }}<br>
            <p>ご利用いただき有難うございます。</p>
            <p>お振込先：関西みらい銀行　堀江支店　普通　0088187　ｶ)ｴｽｴﾑｼﾞｰ</p>
            <p>お振込手数料は御社ご負担にてお願い致します</p>
        </div>
    </div>
</body>

</html>
