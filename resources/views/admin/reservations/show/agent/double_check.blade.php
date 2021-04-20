@if ($reservation->bills()->first()->double_check_status==2)
<!-- 利用者に承認メールを送る確認ボタン-ダブルチェック後に表示------ -->
{{-- 予約完了後、非表示 --}}
@if ($reservation->bills()->first()->reservation_status<=2) <div class="d-flex justify-content-end mt-2 mb-2">
  {{-- <a class="more_btn4" href="">予約を確定する</a> --}}
  {{ Form::open(['url' => 'admin/reservations/'.$reservation->id.'/confirm_reservation', 'method'=>'POST', 'class'=>'']) }}
  @csrf
  {{ Form::hidden('reservation_id', $reservation->id ) }}
  {{ Form::hidden('user_id', $reservation->user_id ) }}
  <p>{{ Form::submit('予約を確定する',['class' => 'btn more_btn4']) }}</p>
  <span>※仲介会社経由の予約は予約を確定するのみ。メール送信は不要</span>
  {{ Form::close() }}
  </div>
  @endif
  @endif