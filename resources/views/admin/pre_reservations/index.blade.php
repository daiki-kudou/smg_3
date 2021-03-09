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
@if (session('flash_message_error'))
<div class="flash_message bg-danger text-center py-3 my-0">
  {{ session('flash_message_error') }}
</div>
@endif


<style>
  .checkbox,
  #all_check {
    width: 14px;
    height: 14px;
    -moz-transform: scale(1.4);
    -webkit-transform: scale(1.4);
    transform: scale(1.4);
  }
</style>

<div class="content">
  <div class="container-fluid">

  <div class="container-field mt-3">
      <div class="float-right">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="http://staging-smg2.herokuapp.com/admin/home">ホーム</a> >
            ダミーダミーダミー
            </li>
          </ol>
        </nav>
      </div>
      <h2 class="mt-3 mb-3">仮押さえ一覧</h2>
      <hr>
    </div>

    <!-- 検索--------------------------------------- -->
    <div class="section-wrap">
      <table class="table table-bordered search_box">
        <tbody>
          <tr>
            <th class="search_item_name"><label for="id">仮押さえID</label>
            <td class="text-right">
              <input type="text" name="id" class="form-control" id="id">
            </td>
            <th class="search_item_name"><label for="">作成日</label></th>
            <td class="text-right form-group">
              <input type="date" name="" class="form-control float-right" id="">
            </td>
          </tr>
          <tr>
          <th class="search_item_name"><label for="date">利用日</label></th>
            <td class="text-right form-group">
              <input type="date" name="date" class="form-control float-right" id="date">
            </td>

            <th class="search_item_name"><label for="venue">利用会場</label></th>
            <td class="text-right">
              <dd>
                <select class="form-control" name="venue">
                  <option>テスト会場A</option>
                  <option>テスト会場B</option>
                  <option>テスト会場C</option>
                </select>
            </td>
          </tr>
          <tr>
            <th class="search_item_name"><label for="company">会社名・団体名</label></th>
            <td class="text-right">
              <input type="text" name="company" class="form-control" id="company">
            </td>
            <th class="search_item_name"><label for="person_name">担当者氏名</label></th>
            <td class="text-right">
              <dd>
                <input type="text" name="person_name" class="form-control" id="person_name">
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
            <th class="search_item_name"><label for="temp_company">会社名・団体名(仮)</label></th>
            <td>
              <input type="text" name="temp_company" class="form-control" id="temp_company">
            </td>
            <th class="search_item_name"><label for="agent">仲介会社</label></th>
            <td>
              <input type="text" name="agent" class="form-control" id="agent">
            </td>
          </tr>

          <tr>
            <th class="search_item_name"><label for="freeword">フリーワード検索</label></th>
            <td colspan="3">
              <input type="text" name="freeword" class="form-control" id="freeword">
            </td>
          </tr>
        </tbody>
      </table>
      <p class="text-right">※フリーワード検索は本画面表記の項目のみ対象となります</p>

      <div class="btn_box d-flex justify-content-center">
        <input type="reset" value="リセット" class="btn reset_btn">
        <input type="submit" value="検索" class="btn search_btn">
      </div>

    </div>
    <!-- 検索　終わり------------------------------------------------ -->
    <ul class="d-flex reservation_list mb-2 justify-content-between">
        <li>
        {{-- 削除ボタン --}}
    {{Form::open(['url' => 'admin/pre_reservations/destroy', 'method' => 'POST', 'id'=>'for_destroy'])}}
    @csrf
    {{ Form::submit('削除', ['class' => 'btn more_btn4','id'=>'confirm_destroy']) }}
    {{ Form::close() }}
        </li>
        <li>
        <div class="d-flex">
          <a class="more_btn bg-red" href="">仮押さえ期間超過</a>
          <p class="ml-3 font-weight-bold"><span class="count-color">ダミーダミー</span>件</p>
        </div>
      </li>
      </ul>


    <script>
      $(function(){
        // 全選択アクション
        $('#all_check').on('change',function(){
          $('.checkbox').prop('checked', $(this).is(':checked'));
        })

        // 削除確認コンファーム
        $('#confirm_destroy').on('click',function(){
          if(!confirm('削除してもよろしいですか？')){
              return false;
          }
        })
      })

      $(function(){
        $("input[type='checkbox']").on('change', function() {
          checked = $('[class="checkbox"]:checked').map(function(){
              return $(this).val();
            }).get();
            console.log(checked.length);
            for (let index = 0; index < checked.length; index++) {
              var ap_data="<input type='hidden' name='destroy"+checked[index]+"' value='"+checked[index]+"'>"
              $('#for_destroy').append(ap_data);
            }
        })
      })
    </script>

    <div class="table-wrap">
      <table class="table table-bordered table-scroll">
        <thead>
          <tr class="table_row">
            <th><input type="checkbox" name="all_check" id="all_check" /></th>
            <th>仮押さえID</th>
            <th>作成日</th>
            <th>利用日</th>
            <th>入室</th>
            <th>退室</th>
            <th>利用会場</th>
            <th>会社名・団体名</th>
            <th>担当者</th>
            <th>携帯</th>
            <th>電話</th>
            <th>会社名・団体名<br>(顧客未登録)</th>
            <th>仲介会社</th>
            <th>エンドユーザー</th>
            <th>詳細</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($pre_reservations as $pre_reservation)
          <tr>
            <td><input type="checkbox" name="{{'delete_check'.$pre_reservation->id}}" value="{{$pre_reservation->id}}"
                class="checkbox" />
            </td>
            <td>{{$pre_reservation->id}}</td>
            <td>{{$pre_reservation->created_at}}</td>
            <td>{{$pre_reservation->reserve_date}}</td>
            <td>{{$pre_reservation->enter_time}}</td>
            <td>{{$pre_reservation->leave_time}}</td>
            <td>{{ReservationHelper::getVenue($pre_reservation->venue_id)}}</td>
            {{-- <td>{{$pre_reservation->user_id==999?"未登録ユーザー":ReservationHelper::getCompany($pre_reservation->user_id)}}
            <td>{{$pre_reservation->user_id==999?"":ReservationHelper::getPersonName($pre_reservation->user_id)}}
            <td>{{$pre_reservation->user_id==999?"":ReservationHelper::getPersonMobile($pre_reservation->user_id)}}</td>
            <td>{{$pre_reservation->user_id==999?"":ReservationHelper::getPersonTel($pre_reservation->user_id)}}</td>
            --}}
            <td>{{ReservationHelper::checkAgentOrUserCompany($pre_reservation->user_id, $pre_reservation->agent_id)}}
            </td>
            <td>{{ReservationHelper::checkAgentOrUserName($pre_reservation->user_id, $pre_reservation->agent_id)}}</td>
            <td>{{ReservationHelper::checkAgentOrUserMobile($pre_reservation->user_id, $pre_reservation->agent_id)}}
            </td>
            <td>{{ReservationHelper::checkAgentOrUserTel($pre_reservation->user_id, $pre_reservation->agent_id)}}</td>


            <td>{{$pre_reservation->agent_id==0?"":$pre_reservation->agent_id}}</td>
            <td>{{$pre_reservation->agent_id==0?"":$pre_reservation->agent_id}}</td>
            <td>{{$pre_reservation->agent_id==0?"":$pre_reservation->agent_id}}</td>
            <td><a class="more_btn" href="{{url('admin/pre_reservations/'.$pre_reservation->id)}}">詳細</a></td>
          </tr>
          @endforeach
        </tbody>

        {{-- @foreach ($reservations as $reservation) --}}
        {{-- <tbody>
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
        <td>会場予約</td>
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
          </tbody> --}}
          {{-- @endforeach --}}
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