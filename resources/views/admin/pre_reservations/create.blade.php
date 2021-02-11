@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>

<div id="fullOverlay">
  <div class="frame_spinner">
    <div class="spinner-border text-primary " role="status">
      <span class="sr-only hide">Loading...</span>
    </div>
  </div>
</div>



<h1>仮押さえ 新規作成</h1>

<div class="calendar">
    <iframe src="{{url('admin/calendar/date_calendar')}}" width="100%" height="500">Your browser isn't compatible</iframe>
</div>

<div class="user_selector mt-5">
    <h1>顧客検索</h1>
    <select name="pre_reservation_selector" id="pre_reservation_selector">
        <option value="#">選択してください</option>
        @foreach ($users as $user)
        <option value="{{$user->id}}">
            {{$user->id}} | {{ReservationHelper::getCompany($user->id)}} | {{ReservationHelper::getPersonName($user->id)}} | {{$user->email}} | {{$user->tel}} | {{$user->mobile}}
        </option>
        @endforeach
    </select>
</div>

<div class="selected_user mt-5">
    <table class="table table-bordered" style="table-layout: fixed;">
        <thead>
            <tr>
                <th>顧客情報</th>
                <th colspan="3">顧客ID：<p class="user_id d-inline"></p></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="table-active">会社名・団体名</td>
                <td colspan="3"><p class="company"></p></td>
            </tr>
            <tr>
                <td class="table-active">担当者指名</td>
                <td><p class="person"></p></td>
                <td class="table-active">メールアドレス</td>
                <td><p class="email"></p></td>
            </tr>
            <tr>
                <td class="table-active">携帯番号</td>
                <td><p class="mobile"></p></td>
                <td class="table-active">固定電話</td>
                <td><p class="tel"></p></td>
            </tr>
        </tbody>
    </table>
</div>

<div class="unknown_user mt-5">
    <table class="table table-bordered" style="table-layout: fixed;">
        <thead>
            <tr>
                <th colspan="4">顧客情報（顧客登録がされていない場合）</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="table-active">会社名・団体名</td>
                <td>
                  {{ Form::text('unknown_user_company', '',['class'=>'form-control'] ) }}
                </td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td class="table-active">担当者指名</td>
                <td>
                  {{ Form::text('unknown_user_name', '',['class'=>'form-control'] ) }}
                </td>
                <td class="table-active">メールアドレス</td>
                <td>
                  {{ Form::text('unknown_user_email', '',['class'=>'form-control'] ) }}
                </td>
            </tr>
            <tr>
                <td class="table-active">携帯番号</td>
                <td>
                  {{ Form::text('unknown_user_mobile', '',['class'=>'form-control'] ) }}
                </td>
                <td class="table-active">固定電話</td>
                <td>
                  {{ Form::text('unknown_user_tel', '',['class'=>'form-control'] ) }}
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="date_selector">
  <h1>日程選択</h1>
  <table class="table table-bordered" style="table-layout: fixed;">
    <thead>
      <tr>
        <td>日付</td>
        <td>会場名</td>
        <td>入室時間</td>
        <td>体質時間</td>
        <td>追加・削除</td>
      </tr>
    </thead>
    <tbody>
        <tr>
        </tr>
    </tbody>
</table>
</div>




<script defer="defer">
    // 初期カレンダーのside var 非表示
    $(function(){
        $("iframe").on("load",function(){
        $("iframe").contents().find('.main-sidebar').css("display","none");
        $("iframe").contents().find('.content-wrapper').css("margin-left","0px");
        $("iframe").contents().find('.main-header').css("margin-top","-48px");
        });
    })

    $(function(){
      $('.unknown_user input').attr('readonly',true);
    })

    // 顧客検索
    $(function(){
      $('#pre_reservation_selector').on('input',function(){
          var user_id = $(this).val();
          // ajax
          $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: '/admin/pre_reservations/getuser',
          type: 'POST',
          data: {
            'user_id': user_id
          },
          dataType: 'json',
          beforeSend: function () {
            $('#fullOverlay').css('display', 'block');
          },
        })
          .done(function ($user) {
            $('#fullOverlay').css('display', 'none');
            if ($user['id']!=999) {
            $('.user_id').text($user['id']);
            $('.company').text($user['company'])
            $('.person').text($user['first_name']+$user['last_name'])
            $('.email').text($user['email']);
            $('.mobile').text($user['mobile']);
            $('.tel').text($user['tel']);
            $('.unknown_user input').attr('readonly',true);
            }else{
              $('p').text('');
              $('.unknown_user input').attr('readonly',false);
            }
          })
          .fail(function ($user) {
            $('#fullOverlay').css('display', 'none');
            console.log("失敗");
            $('p').text('');
            swal('顧客情報取得に失敗しました。リロードして再度取得してください');
          });
      })
    })

</script>
@endsection