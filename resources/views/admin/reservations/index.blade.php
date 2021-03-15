@extends('layouts.admin.app')

@section('content')

<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>

<script>
  $(function() {
    $('.flash_message').fadeOut(3000);
  })
</script>
@if (session('flash_message'))
<div class="flash_message bg-success text-center py-3 my-0">
  {{ session('flash_message') }}
</div>
@endif

<div class="content">
  <div class="container-fluid">

    <div class="container-field mt-3">
      <div class="float-right">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active">
              ダミーダミーダミーダミー
            </li>
          </ol>
        </nav>
      </div>

      <h2 class="mt-3 mb-3">予約一覧</h2>
      <hr>
    </div>

    {{ Form::open(['url' => 'admin/reservations', 'method'=>'get'])}}
    @csrf

    <div class="search-wrap">
      <table class="table table-bordered">
        <tbody>
          <tr>
            <th class="search_item_name"><label for="bulkid">予約一括ID</label>
            <td class="text-right">
              {{ Form::text('multiple_id', '', ['class' => 'form-control', 'id'=>'multiple_id']) }}
            </td>
            <th class="search_item_name"><label for="id">予約ID</label></th>
            <td>
              {{ Form::text('id', '', ['class' => 'form-control', 'id'=>'']) }}
            </td>
          </tr>
          <tr>
            <th class="search_item_name"><label for="date">利用日</label></th>
            <td class="text-right form-group">
              {{ Form::text('reserve_date', '', ['class' => 'form-control', 'id'=>'datepicker1']) }}
            </td>
            <th class="search_item_name"><label for="venue">利用会場</label></th>
            <td class="text-right">
              <select class="form-control select2" name="venue_id">
                @foreach ($venue as $venues)
                <option value="{{$venues->id}}">
                  {{ReservationHelper::getVenue($venues->id)}}
                </option>
                @endforeach
              </select>
            </td>
          </tr>
          <tr>
            <th class="search_item_name"><label for="company">会社名・団体名</label></th>
            <td class="text-right">
              <select class="form-control select2" style="width: 100%;" name="user_id">
                @foreach ($user as $users)
                <option value="{{$users->id}}">{{ReservationHelper::getCompany($users->id)}}</option>
                @endforeach
              </select>
            </td>
            <th class="search_item_name"><label for="person_name">担当者氏名</label></th>
            <td class="text-right">
              <select class="form-control select2" style="width: 100%;" name="user_id">
                @foreach ($user as $users)
                <option value="{{$users->id}}">{{ReservationHelper::getPersonName($users->id)}}</option>
                @endforeach
              </select>
            </td>
          </tr>
          <tr>
            <th class="search_item_name"><label for="mobile">携帯電話</label></th>
            <td>
              <input type="text" name="mobile" class="form-control" id="mobile">
            </td>
            <th class="search_item_name"><label for="tel">固定電話</label></th>
            <td>
              <input type="text" name="tel" class="form-control" id="tel">
            </td>
          </tr>
          <tr>
            <th class="search_item_name"><label for="enduser_person">エンドユーザー</label></th>
            <td class="text-right">
              <input type="text" name="enduser_person" class="form-control" id="enduser_person">
            </td>
            <th class="search_item_name"><label for="category">売上区分</label></th>
            <td class="text-right">
              <ul class="search_category">
                <li>
                  <input type="checkbox" id="checkboxPrimary1" checked name="category1" value="1">
                  <label for="checkboxPrimary1">会場</label>
                </li>
                <li>
                  <input type="checkbox" id="checkboxPrimary3" checked name="category3" value="1">
                  <label for="checkboxPrimary3">追加請求</label>
                </li>
                <li>
                  <input type="checkbox" id="checkboxPrimary2" checked name="category2" value="1">
                  <label for="checkboxPrimary2">キャンセル</label>
                </li>
              </ul>
            </td>
          </tr>
          <tr>
            <th class="search_item_name"><label for="Status">予約状況</label></th>
            <td colspan="3">
              <ul class="search_category">
                <li>
                  <input type="checkbox">
                  <label for="Status">予約確認中</label>
                </li>
                <li>
                  <input type="checkbox">
                  <label for="Status">予約完了</label>
                </li>
                <li>
                  <input type="checkbox">
                  <label for="Status">キャンセル申請中</label>
                </li>
                <li>
                  <input type="checkbox">
                  <label for="Status">キャンセル承認待ち</label>
                </li>
                <li>
                  <input type="checkbox">
                  <label for="Status">キャンセル</label>
                </li>
              </ul>
            </td>
          </tr>
          <tr>
            <th class="search_item_name"><label for="freeword">フリーワード検索</label></th>
            <td colspan="3">
              {{ Form::text('freeword', '', ['class' => 'form-control', 'id'=>'']) }}
            </td>
          </tr>
        </tbody>
      </table>
      <p class="text-right">※フリーワード検索は本画面表記の項目のみ対象となります</p>

      <div class="btn_box d-flex justify-content-center">
        <input type="reset" value="リセット" class="btn reset_btn">
        <!-- <input type="submit" value="検索" class="btn search_btn"> -->
        {{ Form::submit('検索', ['class' => 'btn search_btn']) }}
      </div>

    </div>
    <!-- 検索　終わり------------------------------------------------ -->
    {{ Form::close() }}


    <div class="d-flex justify-content-between">
      <ul class="d-flex reservation_list">
        <li><a class="more_btn" href="">前日予約</a></li>
        <li><a class="more_btn" href="">当日予約</a></li>
        <li><a class="more_btn" href="">翌日予約</a></li>
        <li><a class="more_btn bg-red" href="">予約確認中</a></li>
        <li><a class="more_btn bg-red" href="">予約承認待ち</a></li>
        <li><a class="more_btn bg-green" href="">キャンセル申請中</a></li>
        <li><a class="more_btn bg-black" href="">予約完了</a></li>
      </ul>
      <p class="font-weight-bold"><span class="count-color">ダミーダミー</span>件</p>
    </div>


    <div class="table-wrap">
      <table class="table table-bordered table-scroll">
        <thead>
          <tr class="table_row">
            <th>予約一括ID</th>
            <th>予約ID</th>
            <th>利用日</th>
            <th>入室</th>
            <th>退室</th>
            <th>利用会場</th>
            <th>会社名団体名</th>
            <th>担当者氏名</th>
            <th>携帯電話</th>
            <th>固定電話</th>
            <th>仲介会社</th>
            <th>エンドユーザー</th>
            <th width="120">売上区分</th>
            <th width="120">予約状況</th>
            <th class="btn-cell">予約詳細</th>
            <th class="btn-cell">案内板</th>
          </tr>
        </thead>

        @foreach ($reservations as $reservation)
        <tbody>
          <tr>
            <td rowspan="{{count($reservation->bills()->get())}}">※後ほど修正</td>
            <td rowspan="{{count($reservation->bills()->get())}}">{{$reservation->id}}</td>
            <td rowspan="{{count($reservation->bills()->get())}}">
              {{ReservationHelper::formatDate($reservation->reserve_date)}}
            </td>
            <td rowspan="{{count($reservation->bills()->get())}}">{{$reservation->enter_time}}</td>
            <td rowspan="{{count($reservation->bills()->get())}}">{{$reservation->leave_time}}</td>
            <td rowspan="{{count($reservation->bills()->get())}}">
              {{ReservationHelper::getVenue($reservation->venue->id)}}
            </td>
            <td rowspan="{{count($reservation->bills()->get())}}">
              @if ($reservation->user_id>0)
              {{$reservation->user->company}}
              @elseif($reservation->user_id==0)
              {{ReservationHelper::getAgentCompany($reservation->agent_id)}}
              @endif
            </td>
            <td rowspan="{{count($reservation->bills()->get())}}">
              @if ($reservation->user_id>0)
              {{ReservationHelper::getPersonName($reservation->user_id)}}
              @elseif($reservation->user_id==0)
              {{ReservationHelper::getAgentPerson($reservation->agent_id)}}
              @endif
            </td>
            <td rowspan="{{count($reservation->bills()->get())}}">
              @if ($reservation->user_id>0)
              {{$reservation->user->mobile}}
              @else
              {{$reservation->agent->mobile}}
              @endif
            </td>
            <td rowspan="{{count($reservation->bills()->get())}}">
              @if ($reservation->user_id>0)
              {{$reservation->user->tel}}
              @else
              {{$reservation->agent->person_tel}}
              @endif
            </td>
            <td rowspan="{{count($reservation->bills()->get())}}">
              @if ($reservation->agent_id>0)
              {{ReservationHelper::getAgentCompany($reservation->agent_id)}}
              @endif
            </td>
            <td>ダミーダミーダミー</td>
            <td>会場予約</td>　
            <td>
              {{ReservationHelper::judgeStatus($reservation->bills()->first()->reservation_status)}}
            </td>
            <td rowspan="{{count($reservation->bills()->get())}}"><a
                href="{{ url('admin/reservations', $reservation->id) }}" class="more_btn">詳細</a></td>
            <td rowspan="{{count($reservation->bills()->get())}}"><a
                href="{{ url('admin/reservations/generate_pdf/'.$reservation->id) }}" class="more_btn">表示</a></td>
          </tr>
          @for ($i = 0; $i < count($reservation->bills()->get())-1; $i++)
            <tr>
              <td>
                @if ($reservation->bills()->skip($i+1)->first()->category==2)
                追加請求
                @endif
              </td>
              <td>{{ReservationHelper::judgeStatus($reservation->bills()->skip($i+1)->first()->reservation_status)}}
              </td>
            </tr>
            @endfor
        </tbody>
        @endforeach
      </table>
    </div>

  </div>

  <ul class="pagination justify-content-center mt-5">
    <li class="page-item disabled" aria-disabled="true" aria-label="&laquo; 前">
      <span class="page-link" aria-hidden="true">&lsaquo;</span>
    </li>
    <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
    <li class="page-item"><a class="page-link" href="">2</a>
    </li>
    <li class="page-item"><a class="page-link" href="">3</a>
    </li>
    <li class="page-item">
      <a class="page-link" href="http://staging-smg2.herokuapp.com/admin/clients?page=2" rel="next"
        aria-label="次 &raquo">&rsaquo;</a>
    </li>
  </ul>


</div>









@endsection