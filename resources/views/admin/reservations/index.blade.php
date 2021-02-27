@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>

<script>
  $(function(){
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
            <li class="breadcrumb-item active"><a href="http://staging-smg2.herokuapp.com/admin/home">ホーム</a> >
              予約一覧
            </li>
          </ol>
        </nav>
      </div>
      <h1 class="mt-3 mb-5">予約一覧</h1>
      <hr>
    </div>

    <!-- 検索--------------------------------------- -->
    {{ Form::open(['url' => 'admin/reservations', 'method'=>'get'])}}
    @csrf
    <div class="container-field">
      <div class="row search_box">
        <div class="col-md-10 offset-md-1">
          <div class="d-flex col-12 pd0">
            <dl class="form-group flex-fill">
              <dt>
                <label class="search_item_name" for="bulkid">予約一括ID</label>
              </dt>
              <dd>
                {{ Form::text('multiple_id', '', ['class' => 'form-control', 'id'=>'multiple_id']) }}
              </dd>
            </dl>
            <dl class="form-group flex-fill">
              <dt>
                <label class="search_item_name" for="id">予約ID</label>
              </dt>
              <dd>
                {{ Form::text('id', '', ['class' => 'form-control', 'id'=>'']) }}
              </dd>
            </dl>
          </div>
          <div class="row">
            <div class="col-12">
              <!-- Date range -->
              <dl class="form-group">
                <dt>
                  <label class="search_item_name">利用日</label>
                </dt>
                <dd>
                  <div class="input-group">
                    {{ Form::text('reserve_date', '', ['class' => 'form-control', 'id'=>'datepicker1']) }}
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                    </div>
                  </div>
                </dd>
                <!-- /.input group -->
              </dl>
              <!-- /.form group -->
              <dl class="form-group">
                <dt>
                  <label class="search_item_name">入室・退室</label>
                </dt>
                <dd class="d-flex align-items-center">
                  <div class="flex-fill">
                    <select class="form-control" id="eventStart" name="enter_time">
                      <option value="01:00:00">01:00</option>
                      <option value="01:30:00">01:30</option>
                      <option value="02:00:00">02:00</option>
                      <option value="02:30:00">02:30</option>
                      <option value="03:00:00">03:00</option>
                      <option value="03:30:00">03:30</option>
                      <option value="04:00:00">04:00</option>
                      <option value="04:30:00">04:30</option>
                      <option value="05:00:00">05:00</option>
                      <option value="05:30:00">05:30</option>
                      <option value="06:00:00">06:00</option>
                      <option value="06:30:00">06:30</option>
                      <option value="07:00:00">07:00</option>
                      <option value="07:30:00">07:30</option>
                      <option value="08:00:00" selected="selected">08:00</option>
                      <option value="08:30:00">08:30</option>
                      <option value="09:00:00">09:00</option>
                      <option value="09:30:00">09:30</option>
                      <option value="10:00:00">10:00</option>
                      <option value="10:30:00">10:30</option>
                      <option value="11:00:00">11:00</option>
                      <option value="11:30:00">11:30</option>
                      <option value="12:00:00">12:00</option>
                      <option value="12:30:00">12:30</option>
                      <option value="13:00:00">13:00</option>
                      <option value="13:30:00">13:30</option>
                      <option value="14:00:00">14:00</option>
                      <option value="14:30:00">14:30</option>
                      <option value="15:00:00">15:00</option>
                      <option value="15:30:00">15:30</option>
                      <option value="16:00:00">16:00</option>
                      <option value="16:30:00">16:30</option>
                      <option value="17:00:00">17:00</option>
                      <option value="17:30:00">17:30</option>
                      <option value="18:00:00">18:00</option>
                      <option value="18:30:00">18:30</option>
                      <option value="19:00:00">19:00</option>
                      <option value="19:30:00">19:30</option>
                      <option value="20:00:00">20:00</option>
                      <option value="20:30:00">20:30</option>
                      <option value="21:00:00">21:00</option>
                      <option value="21:30:00">21:30</option>
                      <option value="22:00:00">22:00</option>
                      <option value="22:30:00">22:30</option>
                      <option value="23:00:00">23:00</option>
                      <option value="23:30:00">23:30</option>
                      <option value="24:00:00">24:00</option>
                      <option value="24:30:00">24:30</option>
                    </select>
                  </div>
                  <p style="margin: 0 20px;">～</p>
                  <div class="flex-fill">
                    <select class="form-control" id="eventFinish" name="leave_time">
                      <option value="01:00:00">01:00</option>
                      <option value="01:30:00">01:30</option>
                      <option value="02:00:00">02:00</option>
                      <option value="02:30:00">02:30</option>
                      <option value="03:00:00">03:00</option>
                      <option value="03:30:00">03:30</option>
                      <option value="04:00:00">04:00</option>
                      <option value="04:30:00">04:30</option>
                      <option value="05:00:00">05:00</option>
                      <option value="05:30:00">05:30</option>
                      <option value="06:00:00">06:00</option>
                      <option value="06:30:00">06:30</option>
                      <option value="07:00:00">07:00</option>
                      <option value="07:30:00">07:30</option>
                      <option value="08:00:00" selected="selected">08:00</option>
                      <option value="08:30:00">08:30</option>
                      <option value="09:00:00">09:00</option>
                      <option value="09:30:00">09:30</option>
                      <option value="10:00:00">10:00</option>
                      <option value="10:30:00">10:30</option>
                      <option value="11:00:00">11:00</option>
                      <option value="11:30:00">11:30</option>
                      <option value="12:00:00">12:00</option>
                      <option value="12:30:00">12:30</option>
                      <option value="13:00:00">13:00</option>
                      <option value="13:30:00">13:30</option>
                      <option value="14:00:00">14:00</option>
                      <option value="14:30:00">14:30</option>
                      <option value="15:00:00">15:00</option>
                      <option value="15:30:00">15:30</option>
                      <option value="16:00:00">16:00</option>
                      <option value="16:30:00">16:30</option>
                      <option value="17:00:00">17:00</option>
                      <option value="17:30:00">17:30</option>
                      <option value="18:00:00">18:00</option>
                      <option value="18:30:00">18:30</option>
                      <option value="19:00:00">19:00</option>
                      <option value="19:30:00">19:30</option>
                      <option value="20:00:00">20:00</option>
                      <option value="20:30:00">20:30</option>
                      <option value="21:00:00">21:00</option>
                      <option value="21:30:00">21:30</option>
                      <option value="22:00:00">22:00</option>
                      <option value="22:30:00">22:30</option>
                      <option value="23:00:00">23:00</option>
                      <option value="23:30:00">23:30</option>
                      <option value="24:00:00">24:00</option>
                      <option value="24:30:00">24:30</option>
                    </select>
                  </div>
                </dd>
              </dl>

              <dl class="form-group">
                <dt>
                  <label class="search_item_name" for="venue">利用会場</label>
                </dt>
                <dd>
                  <select class="form-control select2" style="width: 100%;" name="venue_id">
                    @foreach ($venue as $venues)
                    <option value="{{$venues->id}}">
                      {{ReservationHelper::getVenue($venues->id)}}
                    </option>
                    @endforeach
                  </select>
                </dd>
              </dl>
              <dl class="form-group">
                <dt>
                  <label class="search_item_name" for="company">会社名・団体名</label>
                </dt>
                <dd>
                  <select class="form-control select2" style="width: 100%;" name="user_id">
                    @foreach ($user as $users)
                    <option value="{{$users->id}}">{{ReservationHelper::getCompany($users->id)}}</option>
                    @endforeach
                  </select>
                </dd>
              </dl>
              <dl class="form-group">
                <dt>
                  <label class="search_item_name" for="name">担当者氏名</label>
                </dt>
                <dd>
                  <select class="form-control select2" style="width: 100%;" name="user_id">
                    @foreach ($user as $users)
                    <option value="{{$users->id}}">{{ReservationHelper::getPersonName($users->id)}}</option>
                    @endforeach
                  </select>
                </dd>
              </dl>
              <dl class="form-group">
                <dt>
                  <label class="search_item_name" for="category">カテゴリー</label>
                </dt>
                <dd>
                  <ul class="form-control icheck-primary d-flex d-flex justify-content-around">
                    <li>
                      <input type="checkbox" id="checkboxPrimary1" checked name="category1" value="1">
                      <label for="checkboxPrimary1">会場</label>
                    </li>
                    <li>
                      <input type="checkbox" id="checkboxPrimary2" checked name="category2" value="1">
                      <label for="checkboxPrimary2">キャンセル</label>
                    </li>
                    <li>
                      <input type="checkbox" id="checkboxPrimary3" checked name="category3" value="1">
                      <label for="checkboxPrimary3">追加請求</label>
                    </li>
                  </ul>
                </dd>
              </dl>
              <dl class="form-group">
                <dt>
                  <label class="search_item_name" for="status">予約状況</label>
                </dt>
                <dd>
                  <select class="form-control select2" style="width: 100%;" name="status">
                    <option value="1">予約確認中</option>
                    <option value="2">予約承認待ち</option>
                    <option value="3">予約完了</option>
                  </select>
                </dd>
              </dl>
              <dl class="form-group">
                <dt>
                  <label class="search_item_name" for="freeword">フリーワード検索</label>
                </dt>
                <dd>
                  {{ Form::text('freeword', '', ['class' => 'form-control', 'id'=>'']) }}
                </dd>
              </dl>

            </div>
          </div>
          <p class="text-right">※フリーワード検索は本画面表記の項目のみ対象となります</p>
        </div>


        <div class="btn_box d-flex justify-content-center">
          <input type="reset" value="リセット" class="btn reset_btn">
          {{-- <input type="submit" value="検索" class="btn search_btn"> --}}
          {{ Form::submit('検索', ['class' => 'btn btn-primary']) }}
        </div>
      </div>
    </div>
    {{ Form::close() }}


    <!-- 検索　終わり------------------------------------------------ -->

    <ul class="d-flex reservation_list">
      <li><a class="more_btn" href="">前日予約</a></li>
      <li><a class="more_btn" href="">当日予約</a></li>
      <li><a class="more_btn" href="">翌日予約</a></li>
      <li><a class="more_btn bg-red" href="">予約確認中</a></li>
      <li><a class="more_btn bg-red" href="">予約承認待ち</a></li>
      <li><a class="more_btn bg-green" href="">キャンセル申請中</a></li>
      <li><a class="more_btn bg-black" href="">予約完了</a></li>
    </ul>
    <div class="col-12">
      <p class="text-right font-weight-bold"><span>10</span>件</p>
    </div>


    <div class="container-field">
      <table class="table table-striped table-bordered table-box">
        <thead>
          <tr>
            <th>予約一括<br>ID</th>
            <th>ID</th>
            <th>利用日</th>
            <th>入室</th>
            <th>退室</th>
            <th>利用会場</th>
            <th>会社名<br>団体名</th>
            <th>担当者氏名</th>
            <th>携帯電話</th>
            <th>固定電話</th>
            <th>仲介会社</th>
            <th width="120">カテゴリー</th>
            <th width="120">予約状況</th>
            <th class="btn-cell">予約<br>詳細</th>
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
              {{ReservationHelper::getVenue($reservation->venue->id)}}</td>
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
            <td rowspan="{{count($reservation->bills()->get())}}">{{$user->find($reservation->venue_id)->mobile}}</td>
            <td rowspan="{{count($reservation->bills()->get())}}">{{$user->find($reservation->venue_id)->tel}}</td>
            <td rowspan="{{count($reservation->bills()->get())}}">
              @if ($reservation->agent_id>0)
              {{ReservationHelper::getAgentCompany($reservation->agent_id)}}
              @endif
            </td>
            <td>会場予約</td>　{{--重要。固定最初は必ず　会場予約　のカテゴリ--}}
            <td>
              {{ReservationHelper::judgeStatus($reservation->bills()->first()->reservation_status)}}
            </td>
            <td rowspan="{{count($reservation->bills()->get())}}"><a
                href="{{ url('admin/reservations', $reservation->id) }}" class="more_btn">詳細</a></td>
            <td rowspan="{{count($reservation->bills()->get())}}"><a
                href="{{ url('admin/reservations/generate_pdf/'.$reservation->id) }}" class="more_btn">詳細</a></td>
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

  <ul class="pagination justify-content-center">
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