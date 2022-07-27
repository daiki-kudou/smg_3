<pre>
----------------------------------------------------------------------------------
当メールは自動送信メールです。
----------------------------------------------------------------------------------

{{ $company }} 様

株式会社SMGです。
いつも「SMG貸し会議室」をご利用頂き、
誠にありがとうございます。

本メールをもちまして
下記の通り、予約が完了しました。
ご確認の上、支払期日までに利用料金をお振込下さいますよう
よろしくお願いいたします。

▼マイページログイン
マイページ
────────────────
【予約内容】
────────────────
・会員ID：{{ $user_id }}
・カテゴリ：会場予約
・予約ID：{{ $reservation_id }}
・ご利用日：{{ $reserve_date }}
・ご利用時間：{{ $enter_time }}～{{ $leave_time }}
・会場：{{ $venue_name }}
・当日の担当者：{{ $in_charge }}
・当日の担当者連絡先：{{ $tel }}{{ $price_system }}{{ $board_flag }}

@if ((int) $eat_in === 1)
・室内飲食：室内飲食　あり
@if ((int) $eat_in_prepare === 1)
手配済み
@elseif((int) $eat_in_prepare === 2)
検討中
@endif
@endif 
@if (count($equipment_data) !== 0)
・有料備品：
@foreach ($equipment_data as $e)
{{ $e['unit_item'] }}+{{ number_format($e['unit_cost']) }}円+{{ $e['unit_count'] }}個
@endforeach
@endif
@if (count($service_data) !== 0)
・有料サービス：
@foreach ($service_data as $s)
{{ $s['unit_item'] }}+{{ number_format($s['unit_cost']) }}円
@endforeach
@endif
@if (count($layout_data) !== 0)
・レイアウト変更：
@foreach ($layout_data as $l)
{{ $l }}
@endforeach
@endif
@if ((int) $luggage_flag === 1)
・荷物預かり：荷物預かり あり
事前に預かる荷物（目安）：{{ $luggage_count }}個
事前荷物の到着日（午前指定）：{{ $luggage_arrive }}
事後返送する荷物：{{ $luggage_return }}個
@endif
@if (!empty($admin_details))
・備考：{{ $admin_details }}
@endif

・ご利用料金：{{ $bill_data->master_total }}円

・支払期日：{{ $bill_data->payment_limit }}

・会場URL：{{ $smg_url }}
────────────────
【料金のお支払いについて】
────────────────
支払期日をご確認の上、銀行振込みにてお支払い下さい。
・請求書No：{{ $bill_data->invoice_number }}
・利用料金：{{ $bill_data->master_total }}
・支払期日：{{ $bill_data->payment_limit }}
▼SMG銀行口座情報
銀行名：みずほ銀行　四ツ橋支店
口座番号：普通　1113739
口座名義：ｶ)ｴｽｴﾑｼﾞｰ
※お支払いについて
https://osaka-conference.com/flow/#step3
────────────────
【予約キャンセル・変更について】
────────────────
本メールをもって「予約完了」しております。
これより予約変更・キャンセルをされる場合は、
原則、キャンセル料金が発生致しますのでご了承下さい。
キャンセルポリシー
https://osaka-conference.com/cancelpolicy/
────────────────
▼マイページログイン
マイページ貸し会議室の予約申込み、予約内容の確認、
会員情報変更などが可能です。
────────────────

ご不明な点がございましたら気軽にお問合せ下さい。
どうぞよろしくお願い致します。
----------------------------------------------------------------------------------
※万一、本メールにお心当たりがない場合は、　大変お手数ですが下記署名欄の連絡先までお知らせ下さい。
----------------------------------------------------------------------------------
SMG貸し会議室（株式会社SMG）
〒550-0014
大阪市西区北堀江1-6-2 サンワールドビル11F
TEL: 0665566462
FAX: 0665384315（受付時間：平日10時～18時）
E-mail: kaigi@s-mg.co.jpHP: {{ url('/') }}
----------------------------------------------------------------------------------
</pre>
