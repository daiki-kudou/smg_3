@if ($reservation->bills->sortBy("id")->first()->double_check_status==2)
<!-- 利用者に承認メールを送る確認ボタン-ダブルチェック後に表示------ -->
{{-- 予約完了後、非表示 --}}
@if ($reservation->bills->sortBy("id")->first()->reservation_status<=2) <div
  class="d-flex justify-content-end mt-2 mb-2">
  {{-- 予約ステータスを2にして、ユーザーにメール送付 --}}
  {{-- <a class="more_btn" href="">利用者に承認メールを送る</a> --}}
  {{ Form::open(['url' => '/admin/reservations/'.$reservation->id.'/send_email_and_approve', 'method'=>'POST','class'=>'','autocomplete'=>'off',]) }}
  @csrf
  {{ Form::hidden('reservation_id', $reservation->id ) }}
  {{ Form::hidden('user_id', $reservation->user_id ) }}
  <p class="mr-2">
    {{ Form::submit('利用者に承認メールを送る',['class' => 'btn more_btn','id'=>'send_confirm']) }}
  </p>
  {{ Form::close() }}
  {{ Form::open(['url' => '/admin/reservations/'.$reservation->id.'/confirm_reservation', 'method'=>'POST','class'=>'','autocomplete'=>'off',])
  }}
  @csrf
  {{ Form::hidden('reservation_id', $reservation->id ) }}
  {{ Form::hidden('user_id', $reservation->user_id ) }}
  <p>
    {{ Form::submit('予約を確定する',['class' => 'btn more_btn4','id'=>'reservation_confirm']) }}
  </p>
  {{ Form::close() }}
  </div>
  @endif
  @endif