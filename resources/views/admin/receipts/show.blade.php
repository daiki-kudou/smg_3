{{-- 請求書情報 --}}
{{var_dump($bill)}}

{{-- ユーザー情報 --}}
{{var_dump($bill->reservation->user)}}

{{-- 仲介会社情報 --}}
{{var_dump($bill->reservation->agent)}}


{{-- 請求書内訳 --}}
{{var_dump($bill->breakdowns)}}