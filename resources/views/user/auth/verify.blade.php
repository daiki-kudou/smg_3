仮
@if (session('resent'))
    <div class="alert is-success">
          新しい本登録メールが送信されました。
      </div>
@endif
<p>
      ご入力頂いたメールアドレスに本登録メールをお送りしました。<br>
      記載されたURLをクリックして登録を完了してください。
</p>
<p>メールが届いていない場合下記ボタンをクリックしてください。</p>
<a href="{{ route('user.verification.resend') }}" class="btn is-primary">確認メールを再発行</a>