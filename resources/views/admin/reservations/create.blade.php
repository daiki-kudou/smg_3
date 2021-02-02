@extends('layouts.admin.app')
@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/ajax.js') }}"></script>
<script src="{{ asset('/js/validation.js') }}"></script>


{{-- ajax画面変遷時の待機画面 --}}
<style>
  #fullOverlay {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(100, 100, 100, .5);
    z-index: 2147483647;
    display: none;
  }

  .frame_spinner {
    max-width: 100%;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .hide {
    display: none;
  }
</style>

<div id="fullOverlay">
  <div class="frame_spinner">
    <div class="spinner-border text-primary " role="status">
      <span class="sr-only hide">Loading...</span>
    </div>
  </div>
</div>

<div class="container-field mt-3">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">{{ Breadcrumbs::render(Route::currentRouteName()) }}</li>
      </ol>
    </nav>
  </div>
  <h1 class="mt-3 mb-5">予約　新規登録</h1>
  <hr>
</div>

@if ($target)
<pre>{{var_dump($target)}}</pre>
{{-- reservation checkから戻ってきた場合 --}}
{{Form::open(['url' => 'admin/reservations/calculate', 'method' => 'POST', 'id'=>'reservationCreateForm'])}}
@csrf
<div class="container-field bg-white text-dark">
  <div class="row">
    <div class="col">
      <table class="table table-bordered">
        <tr>
          <td colspan="2">予約情報</td>
        </tr>
        <tr>
          <td class="table-active form_required">利用日</td>
          <td>
            {{ Form::text('reserve_date', $target->reserve_date,['class'=>'form-control', 'id'=>'datepicker1', 'placeholder'=>'入力してください'] ) }}

            <p class="is-error-reserve_date" style="color: red"></p>
          </td>
        </tr>
        <tr>
          <td class="table-active form_required">会場</td>
          <td>
            <select id="venues_selector" class=" form-control" name='venue_id'>
              <option value='#' disabled selected>選択してください</option>
              @foreach ($venues as $venue)
              <option value="{{$venue->id}}" {{$venue->id==$target->venue_id?'selected':''}}>
                {{ReservationHelper::getVenue($venue->id)}}
              </option>
              @endforeach
            </select>
            <p class="is-error-venue_id" style="color: red"></p>
            <div class="price_selector">
              <div>
                <small>※料金体系を選択してください</small>
              </div>
              <div class='price_radio_selector'>
                <div class="d-flex justfy-content-start align-items-center">
                  {{ Form::radio('price_system', 1, $target->price_system==1?true:false, ['class'=>'mr-2', 'id'=>'price_system_radio1']) }}
                  {{Form::label('price_system_radio1','通常（枠貸）')}}
                </div>
                <div class="d-flex justfy-content-start align-items-center">
                  {{ Form::radio('price_system', 2, $target->price_system==2?true:false, ['class'=>'mr-2','id'=>'price_system_radio2']) }}
                  {{Form::label('price_system_radio2','アクセア（時間貸）')}}
                </div>
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <td class="table-active form_required">入室時間</td>
          <td>
            <div>
              <select name="enter_time" id="sales_start" class="form-control">
                <option disabled selected></option>
                @for ($start = 0*2; $start <=23*2; $start++) <option
                  value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (date("H:i:s",
                  strtotime("00:00 +". $start * 30 ." minute"))==$target->enter_time)
                  selected
                  @endif
                  >
                  {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}
                  </option>
                  @endfor
              </select>
              <p class="is-error-enter_time" style="color: red"></p>
            </div>
          </td>
        </tr>
        <tr>
          <td class="table-active form_required">退室時間</td>
          <td>
            <div>
              <select name="leave_time" id="sales_finish" class="form-control">
                <option disabled selected></option>
                @for ($start = 0*2; $start <=23*2; $start++) <option
                  value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (date("H:i:s",
                  strtotime("00:00 +". $start * 30 ." minute"))==$target->leave_time)
                  selected
                  @endif
                  >
                  {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}</option>
                  @endfor
              </select>
              <p class="is-error-leave_time" style="color: red"></p>
            </div>
          </td>
        </tr>
        <tr>
          <td>案内板</td>
          <td>
            <input type="radio" name="board_flag" value="1" {{$target->board_flag==1?"checked":""}}>有り
            <input type="radio" name="board_flag" value="0" {{$target->board_flag==0?"checked":""}}>無し
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント開始時間</td>
          <td>
            <div>
              <select name="event_start" id="event_start" class="form-control">
                <option disabled>選択してください</option>
                @if (!empty($target->event_start))
                @for ($start = 0*2; $start <=23*2; $start++) 
                <option value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" 
                @if (date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))==$target->event_start)
                  selected
                @endif
                >
                {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}
              </option>
              @endfor    
              @else
              @for ($start = 0*2; $start <=23*2; $start++) 
              <option value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" >
              {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}
            </option>
            @endfor
                @endif
              </select>
            </div>
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント終了時間</td>
          <td>
            <div>
              <select name="event_finish" id="event_finish" class="form-control">
                <option disabled>選択してください</option>
                @for ($start = 0*2; $start <=23*2; $start++) <option
                  value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (date("H:i:s",
                  strtotime("00:00 +". $start * 30 ." minute"))==$target->event_finish)
                  selected
                  @endif
                  >
                  {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}</option>
                  @endfor
              </select>
            </div>
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント名称1</td>
          <td>
            {{ Form::text('event_name1',$target->event_name1,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}

          </td>
        </tr>
        <tr>
          <td class="table-active">イベント名称2</td>
          <td>
            {{ Form::text('event_name2', $target->event_name2,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}


          </td>
        </tr>
        <tr>
          <td class="table-active">主催者名</td>
          <td>
            {{ Form::text('event_owner', $target->event_owner,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}


          </td>
        </tr>
      </table>
      <div class="equipemnts">
        <table class="table table-bordered" style="table-layout: fixed;">
          <thead>
            <tr>
              <th colspan="2">
                <div class="d-flex justify-content-between align-items-center">
                  有料備品
                  <i class="fas fa-plus icon_plus hide"></i>
                  <i class="fas fa-minus icon_minus"></i>
                </div>
              </th>
            </tr>
          </thead>
          <tbody>
         
            {{-- @foreach ($venues->find($target->venue_id)->equipments()->get() as $key=>$item)
            <tr>
              <td>{{$item->item}}</td>
              <td>
                <input type="text" name={{'equipment_breakdown'.$key}} class="form-control"
                @foreach ((json_decode($target->item_details))[1] as $equipment)
                @if ($equipment[0]==$item->item)
                value={{$equipment[2]}}
                @endif
                @endforeach
                >
              </td>
            </tr>
            @endforeach --}}

</tbody>
</table>
</div>
<div class="services">
  <table class="table table-bordered" style="table-layout: fixed;">
    <thead>
      <tr>
        <th colspan="2">
          <div class="d-flex justify-content-between align-items-center">
            有料サービス
            <i class="fas fa-plus icon_plus hide"></i>
            <i class="fas fa-minus icon_minus"></i>
          </div>
        </th>
      </tr>
    </thead>
    <tbody>
      {{-- @if (!empty(json_decode($target->item_details)[2]))
      @foreach ($venues->find($target->venue_id)->services()->get() as $key=>$item)
      @foreach ((json_decode($target->item_details))[2] as $service)
      <tr>
        <td>{{$item->item}}</td>
        <td>
          <div class="form-check form-check-inline">
            {{Form::radio('services_breakdown'.$key, 1,$item->item==$service[0]?true:false , ['id' => 'service'.$key.'on', 'class' => 'form-check-input'])}}
            <label for="{{'service'.$key.'on'}}" class="form-check-label">有り</label>
            {{Form::radio('services_breakdown'.$key, 0, $item->item!=$service[0]?true:false, ['id' => 'service'.$key.'off', 'class' => 'form-check-input'])}}
            <label for="{{'service'.$key.'off'}}" class="form-check-label">無し</label>
          </div>
        </td>
      </tr>
      @endforeach
      @endforeach
      @else
      @foreach ($venues->find($target->venue_id)->services()->get() as $key=>$service)
      <tr>
        <td>{{$service->item}}</td>
        <td>
          <div class="form-check form-check-inline">
            {{Form::radio('services_breakdown'.$key, 1, false, ['id' => 'service'.$key.'on', 'class' => 'form-check-input'])}}
            <label for="{{'service'.$key.'on'}}" class="form-check-label">有り</label>
            {{Form::radio('services_breakdown'.$key, 0, true, ['id' => 'service'.$key.'off', 'class' => 'form-check-input'])}}
            <label for="{{'service'.$key.'off'}}" class="form-check-label">無し</label>
          </div>
        </td>
      </tr>
      @endforeach
      @endif --}}
    </tbody>
  </table>
</div>
<div class='layouts'>
  <table class='table table-bordered'>
    <thead>
      <tr>
        <th colspan='2'>レイアウト</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>レイアウト準備</td>
        <td>
          <div class="form-check form-check-inline">
            {{-- @if (json_decode($target->layouts_details)[0]==0)
            {{Form::radio('layout_prepare', 1, false, ['id' => 'layout_prepare', 'class' => 'form-check-input'])}}
            <label for='layout_prepare' class="form-check-label">有り</label>
            {{Form::radio('layout_prepare', 0, true, ['id' => 'no_layout_prepare', 'class' => 'form-check-input'])}}
            <label for='no_layout_prepare' class="form-check-label">無し</label>
            @else
            {{Form::radio('layout_prepare', 1, true, ['id' => 'layout_prepare', 'class' => 'form-check-input'])}}
            <label for='layout_prepare' class="form-check-label">有り</label>
            {{Form::radio('layout_prepare', 0, false, ['id' => 'no_layout_prepare', 'class' => 'form-check-input'])}}
            <label for='no_layout_prepare' class="form-check-label">無し</label>
            @endif
          </div>
        </td>
      </tr>
      <tr>
        <td>レイアウト片付</td>
        <td>
          <div class="form-check form-check-inline">
            @if (json_decode($target->layouts_details)[1]==0)
            {{Form::radio('layout_clean', 1, false, ['id' => 'layout_clean', 'class' => 'form-check-input'])}}
            <label for='layout_clean' class="form-check-label">有り</label>
            {{Form::radio('layout_clean', 0, true, ['id' => 'no_layout_clean', 'class' => 'form-check-input'])}}
            <label for='no_layout_clean' class="form-check-label">無し</label>
            @else
            {{Form::radio('layout_clean', 1, true, ['id' => 'layout_clean', 'class' => 'form-check-input'])}}
            <label for='layout_clean' class="form-check-label">有り</label>
            {{Form::radio('layout_clean', 0, false, ['id' => 'no_layout_clean', 'class' => 'form-check-input'])}}
            <label for='no_layout_clean' class="form-check-label">無し</label>
            @endif --}}
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</div>
<div class='luggage'>
  <table class='table table-bordered' style="table-layout: fixed;">
    <thead>
      <tr>
        <th colspan='2'>荷物預かり</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>事前に預かる荷物<br>（個数）</td>
        <td class=''>
          {{-- {{ Form::text('luggage_count',$target->luggage_count,['class'=>'form-control'] ) }} --}}
        </td>
      </tr>
      <tr>
        <td>事前荷物の到着日<br>午前指定のみ</td>
        <td class=''>
          {{-- {{ Form::text('luggage_arrive',$target->luggage_arrive,['class'=>'form-control', 'id'=>'datepicker3'] ) }}
          --}}
        </td>
      </tr>
      <tr>
        <td>事後返送する荷物</td>
        <td class=''>
          {{-- {{ Form::text('luggage_return',$target->luggage_return,['class'=>'form-control luggage_return'] ) }}
          --}}
        </td>
      </tr>
      <tr>
        <td>荷物預かり/返送　料金</td>
        <td class=''>
          {{-- {{ Form::text('luggage_price',$target->luggage_price,['class'=>'form-control luggage_price'] ) }}
          --}}
        </td>
      </tr>
      <script>
        $('#datepicker3').datepicker({
                dateFormat: 'yy-mm-dd',
                minDate: 0,
              });
      </script>
    </tbody>
  </table>
</div>
<div class="price_details">
</div>
</div>
{{-- 右側 --}}
<div class="col">
  <div class="client_mater">　
    <table class="table table-bordered name-table">
      <tr>
        <td colspan="2">
          <div class="d-flex align-items-center justify-content-between">
            <p class="title-icon">
              <i class="far fa-id-card fa-2x fa-fw"></i>顧客情報
            </p>
            <p><a class="more_btn bg-green" href="">顧客詳細</a></p>
          </div>
        </td>
      </tr>
      <tr>
        <td class="table-active"><label for="user_id" class=" form_required">会社名/団体名</label></td>
        <td>
          <select class="form-control" name="user_id" id="user_select">
            <option disabled selected>選択してください</option>
            @foreach ($users as $user)
            <option value="{{$user->id}}" @if ($target->user_id==$user->id)
              selected
              @endif
              >
              {{$user->company}} ・ {{ReservationHelper::getPersonName($user->id)}} ・ {{$user->email}}
            </option>
            @endforeach
          </select>
          <p class="is-error-user_id" style="color: red"></p>
        </td>
      </tr>
      <tr>
        <td class="table-active"><label for="name" class=" form_required">担当者氏名<br></label></td>
        <td>
          <p class="selected_person">{{ReservationHelper::getPersonName($user->id)}}</p>
        </td>
      </tr>
    </table>
    <table class="table table-bordered oneday-table">
      <tr>
        <td colspan="2">
          <p class="title-icon">
            <i class="fas fa-user-check fa-2x fa-fw"></i>当日の連絡できる担当者
          </p>
        </td>
      </tr>
      <tr>
        <td class="table-active"><label for="ondayName" class=" form_required">氏名</label></td>
        <td>
          {{ Form::text('in_charge', $target->in_charge,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
          <p class="is-error-in_charge" style="color: red"></p>
        </td>
      </tr>
      <tr>
        <td class="table-active"><label for="mobilePhone" class=" form_required">携帯番号</label></td>
        <td>
          {{ Form::text('tel', $target->tel,['class'=>'form-control', 'placeholder'=>'入力してください', 'maxlength'=>13] ) }}
          <p class="is-error-tel" style="color: red"></p>
        </td>
      </tr>
    </table>
  </div>
  <table class="table table-bordered mail-table">
    <tr>
      <td colspan="2">
        <p class="title-icon">
          <i class="fas fa-envelope fa-2x fa-fw"></i>利用後の送信メール
        </p>
      </td>
    </tr>
    <tr>
      <td class="table-active"><label for="email_flag">送信メール</label></td>
      <td>
        <div class="form-check form-check-inline">
          {{Form::radio('email_flag', 1, $target->email_flag==1?true:false, ['id' => 'email_flagon', 'class' => 'form-check-input'])}}
          <label for='email_flagon' class="form-check-label">有り</label>
          {{Form::radio('email_flag', 0, $target->email_flag==0?true:false, ['id' => 'email_flagonoff', 'class' => 'form-check-input'])}}
          <label for='email_flagonoff' class="form-check-label">無し</label>
        </div>
      </td>
    </tr>
  </table>
  <table class="table table-bordered sale-table">
    <tr>
      <td colspan="2">
        <p class="title-icon">
          <i class="fas fa-yen-sign fa-2x fa-fw"></i>売上原価（提携会場を選択した場合、提携会場で設定した原価率が適応されます）
        </p>
      </td>
    </tr>
    <tr>
      <td class="table-active"><label for="cost">原価率</label></td>
      <td class="d-flex align-items-center">
        {{ Form::number('cost', $target->cost,['class'=>'form-control sales_percentage', 'placeholder'=>'入力してください'] ) }}%
    </tr>
  </table>
  <table class="table table-bordered note-table">
    <tr>
      <td colspan="2">
        <p class="title-icon">
          <i class="fas fa-envelope fa-2x fa-fw"></i>備考
        </p>
      </td>
    </tr>
    <tr>
      <td>
        <p>
          <input type="checkbox" id="discount" checked>
          <label for="discount">割引条件</label>
        </p>
        {{ Form::textarea('discount_condition', $target->discount_condition,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
      </td>
    </tr>
    <tr class="caution">
      <td>
        <label for="caution">注意事項</label>
        {{ Form::textarea('attention', $target->attention,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
      </td>
    </tr>
    <tr>
      <td>
        <label for="userNote">顧客情報の備考</label>
        {{ Form::textarea('user_details', $target->user_details,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
      </td>
    </tr>
    <tr>
      <td>
        <label for="adminNote">管理者備考</label>
        {{ Form::textarea('admin_details', $target->admin_details,['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
      </td>
    </tr>
  </table>
</div>
</div>
</div>
{{Form::submit('計算に反映する', ['class'=>'btn btn-primary mx-auto', 'id'=>'check_submit'])}}
{{Form::close()}}
@else
{{-- 新規作成の場合 --}}
{{Form::open(['url' => 'admin/reservations/calculate', 'method' => 'POST', 'id'=>'reservationCreateForm'])}}
@csrf
<div class="container-field bg-white text-dark">
  <div class="row">
    <div class="col">
      <table class="table table-bordered">
        <tr>
          <td colspan="2">予約情報</td>
        </tr>
        <tr>
          <td class="table-active form_required">利用日</td>
          <td>
            {{ Form::text('reserve_date', '' ,['class'=>'form-control', 'id'=>'datepicker1', 'placeholder'=>'入力してください'] ) }}
            <p class="is-error-reserve_date" style="color: red"></p>
          </td>
        </tr>
        <tr>
          <td class="table-active form_required">会場</td>
          <td>
            <select id="venues_selector" class=" form-control" name='venue_id'>
              <option value='#' disabled selected>選択してください</option>
              @foreach ($venues as $venue)
              <option value="{{$venue->id}}" @if (isset($request->venue_id))
                @endif
                >{{$venue->name_area}}{{$venue->name_bldg}}{{$venue->name_venue}}</option>
              @endforeach
            </select>
            <p class="is-error-venue_id" style="color: red"></p>
            <div class="price_selector">
              <div>
                <small>※料金体系を選択してください</small>
              </div>
              <div class='price_radio_selector'>
                <div class="d-flex justfy-content-start align-items-center">
                  {{ Form::radio('price_system', 1, isset($request->price_system)?$request->price_system==1?true:false:'', ['class'=>'mr-2', 'id'=>'price_system_radio1']) }}
                  {{Form::label('price_system_radio1','通常（枠貸）')}}
                </div>
                <div class="d-flex justfy-content-start align-items-center">
                  {{ Form::radio('price_system', 2, isset($request->price_system)?$request->price_system==2?true:false:'', ['class'=>'mr-2','id'=>'price_system_radio2']) }}
                  {{Form::label('price_system_radio2','アクセア（時間貸）')}}
                </div>
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <td class="table-active form_required">入室時間</td>
          <td>
            <div>
              <select name="enter_time" id="sales_start" class="form-control">
                <option disabled selected></option>
                @for ($start = 0*2; $start <=23*2; $start++) <option
                  value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (isset($request)) @endif>
                  {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}
                  </option>
                  @endfor
              </select>
              <p class="is-error-enter_time" style="color: red"></p>
            </div>
          </td>
        </tr>
        <tr>
          <td class="table-active form_required">退室時間</td>
          <td>
            <div>
              <select name="leave_time" id="sales_finish" class="form-control">
                <option disabled selected></option>
                @for ($start = 0*2; $start <=23*2; $start++) <option
                  value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (isset($request)) @endif>
                  {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}</option>
                  @endfor
              </select>
              <p class="is-error-leave_time" style="color: red"></p>
            </div>
          </td>
        </tr>
        <tr>
          <td>案内板</td>
          <td>
            <input type="radio" name="board_flag" value="0"
              {{isset($request->board_flag)?$request->board_flag==0?'checked':'':'checked',}}>無し
            <input type="radio" name="board_flag" value="1"
              {{isset($request->board_flag)?$request->board_flag==1?'checked':'':'',}}>有り
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント開始時間</td>
          <td>
            <div>
              <select name="event_start" id="event_start" class="form-control">
                <option disabled>選択してください</option>
                @for ($start = 0*2; $start <=23*2; $start++) <option
                  value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (isset($request)) @endif>
                  {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}</option>
                  @endfor
              </select>
            </div>
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント終了時間</td>
          <td>
            <div>
              <select name="event_finish" id="event_finish" class="form-control">
                <option disabled>選択してください</option>
                @for ($start = 0*2; $start <=23*2; $start++) <option
                  value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (isset($request)) @endif>
                  {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}</option>
                  @endfor
              </select>
            </div>
          </td>
        </tr>
        <tr>
          <td class="table-active">イベント名称1</td>
          <td>
            {{ Form::text('event_name1','',['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}

          </td>
        </tr>
        <tr>
          <td class="table-active">イベント名称2</td>
          <td>
            {{ Form::text('event_name2', '',['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}

          </td>
        </tr>
        <tr>
          <td class="table-active">主催者名</td>
          <td>
            {{ Form::text('event_owner', '',['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}

          </td>
        </tr>
      </table>
      <div class="equipemnts">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th colspan="2">
                <div class="d-flex justify-content-between align-items-center">
                  有料備品
                  <i class="fas fa-plus icon_plus hide"></i>
                  <i class="fas fa-minus icon_minus"></i>
                </div>
              </th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
      <div class="services">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th colspan="2">
                <div class="d-flex justify-content-between align-items-center">
                  有料サービス
                  <i class="fas fa-plus icon_plus hide"></i>
                  <i class="fas fa-minus icon_minus"></i>
                </div>
              </th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
      <div class='layouts'>
        <table class='table table-bordered'>
          <thead>
            <tr>
              <th colspan='2'>レイアウト</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <div class='luggage'>
        <table class='table table-bordered'>
          <thead>
            <tr>
              <th colspan='2'>荷物預かり</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <div class="price_details">
      </div>
    </div>
    {{-- 右側 --}}
    <div class="col">
      <div class="client_mater">　
        <table class="table table-bordered name-table">
          <tr>
            <td colspan="2">
              <div class="d-flex align-items-center justify-content-between">
                <p class="title-icon">
                  <i class="far fa-id-card fa-2x fa-fw"></i>顧客情報
                </p>
                <p><a class="more_btn bg-green" href="">顧客詳細</a></p>
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="user_id" class=" form_required">会社名/団体名</label></td>
            <td>
              <select class="form-control" name="user_id" id="user_select">
                <option disabled selected>選択してください</option>
                @foreach ($users as $user)
                <option value="{{$user->id}}" @if (isset($request)) @endif>{{$user->company}} |
                  {{$user->first_name}}{{$user->last_name}} | {{$user->email}}
                </option>
                @endforeach
              </select>
              <p class="is-error-user_id" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="name" class=" form_required">担当者氏名<br></label></td>
            <td>
              <p class="selected_person"></p>
            </td>
          </tr>
        </table>
        <table class="table table-bordered oneday-table">
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-user-check fa-2x fa-fw"></i>当日の連絡できる担当者
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="ondayName" class=" form_required">氏名</label></td>
            <td>
              {{ Form::text('in_charge', old('in_charge'),['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
              <p class="is-error-in_charge" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="mobilePhone" class=" form_required">携帯番号</label></td>
            <td>
              {{ Form::text('tel', old('tel'),['class'=>'form-control', 'placeholder'=>'入力してください', 'maxlength'=>13] ) }}
              <p class="is-error-tel" style="color: red"></p>

            </td>
          </tr>
        </table>
      </div>
      <table class="table table-bordered mail-table">
        <tr>
          <td colspan="2">
            <p class="title-icon">
              <i class="fas fa-envelope fa-2x fa-fw"></i>利用後の送信メール
            </p>
          </td>
        </tr>
        <tr>
          <td class="table-active"><label for="email_flag">送信メール</label></td>
          <td>
            <div class="radio-box">
              <input type="radio" name="email_flag" value="0" checked="checked">無し
              <input type="radio" name="email_flag" value="1">有り
            </div>
          </td>
        </tr>
      </table>
      <table class="table table-bordered sale-table">
        <tr>
          <td colspan="2">
            <p class="title-icon">
              <i class="fas fa-yen-sign fa-2x fa-fw"></i>売上原価（提携会場を選択した場合、提携会場で設定した原価率が適応されます）
            </p>
          </td>
        </tr>
        <tr>
          <td class="table-active"><label for="cost">原価率</label></td>
          <td class="d-flex align-items-center">
            {{ Form::number('cost', old('cost'),['class'=>'form-control sales_percentage', 'placeholder'=>'入力してください'] ) }}%
        </tr>
      </table>
      <table class="table table-bordered note-table">
        <tr>
          <td colspan="2">
            <p class="title-icon">
              <i class="fas fa-envelope fa-2x fa-fw"></i>備考
            </p>
          </td>
        </tr>
        <tr>
          <td>
            <p>
              <input type="checkbox" id="discount" checked>
              <label for="discount">割引条件</label>
            </p>
            {{ Form::textarea('discount_condition', old('discount_condition'),['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
          </td>
        </tr>
        <tr class="caution">
          <td>
            <label for="caution">注意事項</label>
            {{ Form::textarea('attention', old('attention'),['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
          </td>
        </tr>
        <tr>
          <td>
            <label for="userNote">顧客情報の備考</label>
            {{ Form::textarea('user_details', old('user_details'),['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
          </td>
        </tr>
        <tr>
          <td>
            <label for="adminNote">管理者備考</label>
            {{ Form::textarea('admin_details', old('admin_details'),['class'=>'form-control', 'placeholder'=>'入力してください'] ) }}
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>

{{Form::submit('計算する', ['class'=>'btn btn-primary mx-auto d-block btn-lg', 'id'=>'check_submit'])}}

{{Form::close()}}


@endif


@endsection