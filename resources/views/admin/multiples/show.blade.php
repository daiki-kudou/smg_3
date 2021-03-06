@extends('layouts.admin.app')

@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>


@if (session('flash_message'))
<div class="flash_message bg-success text-center py-3 my-0">
  {{ session('flash_message') }}
</div>
@elseif (session('flash_message_error'))
<div class="flash_message bg-danger text-center py-3 my-0">
  {{ session('flash_message_error') }}
</div>
@endif


<div class="container-field mt-3">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">
          {{ Breadcrumbs::render(Route::currentRouteName(),$multiple->id) }}
        </li>
      </ol>
    </nav>
  </div>
  <h2 class="mt-3 mb-3">一括仮押え　詳細</h2>
  <hr>
</div>

<section class="mt-5">
  <div class="mb-2">
    {{Form::open(['url' => 'admin/multiples/destroy', 'method' => 'delete', 'id'=>'for_destroy'])}}
    @csrf
    {{Form::hidden('destroy'.$multiple->id, $multiple->id)}}
    {{ Form::submit('削除', ['class' => 'btn more_btn4','id'=>'confirm_destroy']) }}
    {{ Form::close() }}
  </div>

  <table class="table ttl_head mb-0">
    <tbody>
      <tr>
        <td>
          <h3 class="text-white py-2">
            一括仮押えID：{{ReservationHelper::fixId($multiple->id)}}
          </h3>
        </td>


        <td class="text-right">
          {{ Form::open(['url' => 'admin/multiples/switch_status', 'method'=>'POST','id'=>'']) }}
          @csrf
          {{ Form::hidden('multiple_id', $multiple->id)}}
          @if ($checkEachStatus)
          {{ Form::submit('予約の編集・承認権限を顧客に移行', ['class' => 'btn more_btn4',$checkVenuePrice?'disabled':'']) }}
          @endif
          {{ Form::close() }}
          <span class="text-white">{{$checkVenuePrice?'※会場料金未設定が一つでもあれば、選択できません':''}}</span>
        </td>
    </tbody>
  </table>


  <div class="border-wrap2 p-4">
    <table class="table table-bordered customer-table mb-5" style="table-layout: fixed;">
      <tbody>
        <tr>
          <td colspan="4">
            <div class="d-flex align-items-center justify-content-between">
              <p class="title-icon">
                <i class="far fa-address-card icon-size" aria-hidden="true"></i>
                顧客情報
              </p>
              <p>
                <a href="{{url('admin/multiples/switch/'.$multiple->id)}}" class="more_btn">顧客情報を変更する</a>
              </p>
            </div>
          </td>
        </tr>
        <tr>
          <th class="table-active" width="25%">
            <label for="company">会社名・団体名</label>
            <a href="{{route('admin.clients.show',$multiple->pre_reservations->first()->user_id)}}"
              class="more_btn ml-2">顧客詳細</a>
          </th>
          <td>
            {{ReservationHelper::getCompany($multiple->pre_reservations->first()->user_id)}}
          </td>
          <td class="table-active"><label for="name">担当者氏名</label></td>
          <td>
            {{ReservationHelper::getPersonName($multiple->pre_reservations->first()->user_id)}}
          </td>
        </tr>
        <tr>
          <td class="table-active" scope="row"><label for="email">担当者メールアドレス</label></td>
          <td>
            {{ReservationHelper::getPersonEmail($multiple->pre_reservations->first()->user_id)}}
          </td>
          <td class="table-active" scope="row"><label for="mobile">携帯番号</label></td>
          <td>
            {{ReservationHelper::getPersonMobile($multiple->pre_reservations->first()->user_id)}}
          </td>
        </tr>
        <tr>
          <td class="table-active" scope="row"><label for="tel">固定電話</label></td>
          <td>
            {{ReservationHelper::getPersonTel($multiple->pre_reservations->first()->user_id)}}
          </td>
          <td class="table-active" scope="row"><label for="">割引条件</label></td>
          <td>
            {!!nl2br(e($multiple->pre_reservations->first()->user->condition))!!}
          </td>
        </tr>
        <tr>
          <td class="table-active caution" scope="row"><label for="">注意事項</label></td>
          <td class="caution" colspan="3">
            {!!nl2br(e($multiple->pre_reservations->first()->user->attention))!!}
          </td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered oneday-customer-table" style="table-layout: fixed;">
      <tbody>
        <tr>
          <td colspan="4">
            <p class="title-icon">
              <i class="fas fa-user icon-size" aria-hidden="true"></i>
              仮で入力する顧客情報
            </p>
          </td>
        </tr>
        <tr>
          <td class="table-active" width="25%"><label for="onedayCompany">会社・団体名(仮)</label></td>
          <td>
            {{$multiple->pre_reservations->first()->unknown_user->unknown_user_company}}
          </td>
          <td class="table-active"><label for="onedayName">担当者名(仮)</label></td>
          <td>
            {{$multiple->pre_reservations->first()->unknown_user->unknown_user_name}}
          </td>
        </tr>
        <tr>
          <td class="table-active" scope="row"><label for="onedayTel">固定電話</label></td>
          <td>
            {{$multiple->pre_reservations->first()->unknown_user->unknown_user_tel}}
          </td>
          <td class="table-active" scope="row"><label for="onedayMobile">携帯番号</label></td>
          <td>
            {{$multiple->pre_reservations->first()->unknown_user->unknown_user_mobile}}
          </td>
        </tr>
        <tr>
          <td class="table-active" scope="row"><label for="onedayEmail">メールアドレス</label></td>
          <td>
            {{$multiple->pre_reservations->first()->unknown_user->unknown_user_email}}
          </td>
        </tr>
      </tbody>
    </table>
    <hr class="my-5 border_color">
    <div class="mt-5">
      <p class="text-right"><a href="{{url('admin/multiples/'.$multiple->id."/add_venue")}}"
          class="more_btn3">日程を追加する</a></p>
      <p class="mb-2">詳細を入力する場合は、会場ごとに編集をしてください。</p>
    </div>
    <table class="table table-bordered table-scroll">
      <thead>
        <tr class="table_row">
          <th>一括仮押えID</th>
          <th>作成日</th>
          <th>利用会場</th>
          <th>総件数</th>
          <th>件数</th>
          <th>編集</th>
        </tr>
      </thead>
      <tbody>
        @for ($i = 0; $i < $venue_count; $i++) @if ($i==0) <tr>
          <td class="text-center" rowspan="{{$venue_count}}">{{$multiple->id}}</td>
          <td rowspan="{{$venue_count}}">{{ReservationHelper::formatDate($multiple->created_at)}}</td>
          <td>{{ReservationHelper::getVenue($venues[$i]->venue_id)}}</td>
          <td class="text-center" rowspan="{{$venue_count}}">
            {{$multiple->pre_reservations()->get()->count()}}
          </td>
          <td class="text-center">
            {{$multiple->pre_reservations()->where('venue_id',$venues[$i]->venue_id)->get()->count()}}
          </td>
          <td class="text-center"><a class="more_btn"
              href="{{url('admin/multiples/'.$multiple->id.'/edit'.'/'.$venues[$i]->venue_id)}}">編集</a></td>
          </tr>
          @else
          <tr>
            <td>{{ReservationHelper::getVenue($venues[$i]->venue_id)}}</td>
            <td class="text-center">
              {{$multiple->pre_reservations()->where('venue_id',$venues[$i]->venue_id)->get()->count()}}
            </td>
            <td class="text-center">
              <a class="more_btn"
                href="{{url('admin/multiples/'.$multiple->id.'/edit'.'/'.$venues[$i]->venue_id)}}">編集</a>
            </td>
          </tr>
          @endif
          @endfor
      </tbody>
    </table>
  </div>

</section>
<div class="btn_wrapper">
  <p class="text-center"><a class="more_btn_lg" href="{{url('admin/multiples')}}">一覧にもどる</a></p>
</div>


<script>
  $(function() {
    $(".confirm_prereserve").on('click', function() {
      if (!confirm('確定しますか？')) {
        return false;
      }
    })
    $("#for_destroy").on('click', function() {
      if (!confirm('削除しますか？')) {
        return false;
      }
    })
  })
</script>


@endsection