@extends('layouts.reservation.app')
@section('content')

    <!-- ログイン、会員登録 -->
    <div class="contents mt-5">
        <div class="pagetop-text">
            <h1 class="page-title oddcolor"><span>会員登録フォーム送信</span></h1>
            <div class="text-box">
                <p>{{ $email }}へ会員登録フォームメールを送付しました。<br>
                    1時間以内に受信されてこない場合は、メールアドレスのお間違えの可能性がございますので、ご確認ください。</p>
                <p>会員登録メールに会員登録のためのURLが記載されております。
                    こちらのURLの有効期限は2時間となりますので、ご注意お願い致します。</p>
                <p>※弊社からの自動返信がお客様のメール利用環境により迷惑フォルダに受信される場合がございます。
                    お手数ですが迷惑フォルダもご確認いただけましたら幸いです。その場合は【@s-mg.co.jp】を
                    受信設定していただきますようお願いいたします。</p>
            </div>
        </div>
    </div>
@endsection
