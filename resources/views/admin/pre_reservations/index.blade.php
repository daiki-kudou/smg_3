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
    <div class="search-wrap">
      <table class="table table-bordered">
        <tbody>
          <tr>
            <th class="search_item_name"><label for="id">仮押さえID</label>
            <td class="text-right">
              {{Form::text("search_id",'', ['class'=>'form-control'])}}
            </td>
            <th class="search_item_name"><label for="">作成日</label></th>
            <td class="text-right form-group">
              {{Form::text("search_created_at",'', ['class'=>'form-control','id'=>'datepicker1'])}}
            </td>
          </tr>
          <tr>
            <th class="search_item_name"><label for="date">利用日</label></th>
            <td class="text-right form-group">
              {{Form::text("search_date",'', ['class'=>'form-control','id'=>'datepicker2'])}}
            </td>

            <th class="search_item_name"><label for="venue">利用会場</label></th>
            <td class="text-right">
              <dd>
                <select name="search_venue" id="search_venue" class="form-control">
                  @foreach ($venues as $s_v)
                  <option value="{{$s_v->id}}">{{ReservationHelper::getVenue($s_v->id)}}</option>
                  @endforeach
                </select>
            </td>
          </tr>
          <tr>
            <th class="search_item_name"><label for="company">会社・団体名</label></th>
            <td class="text-right">
              {{Form::text("search_user",'', ['class'=>'form-control','id'=>''])}}
            </td>
            <th class="search_item_name"><label for="person_name">担当者氏名</label></th>
            <td class="text-right">
              <dd>
                {{Form::text("search_person",'', ['class'=>'form-control','id'=>''])}}
            </td>
          </tr>
          <tr>
            <th class="search_item_name"><label for="mobile">携帯電話</label></th>
            <td>
              {{Form::text("search_mobile",'', ['class'=>'form-control','id'=>''])}}
            </td>
            <th class="search_item_name"><label for="tel">固定電話</label></th>
            <td>
              {{Form::text("search_tel",'', ['class'=>'form-control','id'=>''])}}
            </td>
          </tr>
          <tr>
            <th class="search_item_name"><label for="temp_company">会社・団体名(仮)</label></th>
            <td>
              {{Form::text("search_end_user",'', ['class'=>'form-control','id'=>''])}}
            </td>
            <th class="search_item_name"><label for="agent">仲介会社</label></th>
            <td>
              {{Form::text("search_agent",'', ['class'=>'form-control','id'=>''])}}
            </td>
          </tr>
          <tr>
            <th class="search_item_name"><label for="freeword">フリーワード検索</label></th>
            <td colspan="3">
              {{Form::text("search_free",'', ['class'=>'form-control','id'=>''])}}
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
            <th>会社・団体名</th>
            <th>担当者</th>
            <th>携帯</th>
            <th>電話</th>
            <th>会社・団体名(仮)</th>
            <th>仲介会社</th>
            <th>エンドユーザー</th>
            <th>仮押さえ詳細</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($pre_reservations as $pre_reservation)
          <tr>
            <td>
              <input type="checkbox" name="{{'delete_check'.$pre_reservation->id}}" value="{{$pre_reservation->id}}"
                class="checkbox" />
            </td>
            <td>{{$pre_reservation->id}}</td>
            <td>{{$pre_reservation->created_at}}</td>
            <td>{{$pre_reservation->reserve_date}}</td>
            <td>{{$pre_reservation->enter_time}}</td>
            <td>{{$pre_reservation->leave_time}}</td>
            <td>{{ReservationHelper::getVenue($pre_reservation->venue_id)}}</td>
            <td>{{ReservationHelper::checkAgentOrUserCompany($pre_reservation->user_id, $pre_reservation->agent_id)}}
            </td>
            <td>{{ReservationHelper::checkAgentOrUserName($pre_reservation->user_id, $pre_reservation->agent_id)}}</td>
            <td>{{ReservationHelper::checkAgentOrUserMobile($pre_reservation->user_id, $pre_reservation->agent_id)}}
            </td>
            <td>{{ReservationHelper::checkAgentOrUserTel($pre_reservation->user_id, $pre_reservation->agent_id)}}</td>


            <td>{{$pre_reservation->agent_id==0?"":$pre_reservation->agent_id}}</td>
            <td>{{$pre_reservation->agent_id==0?"":$pre_reservation->agent_id}}</td>
            <td>{{$pre_reservation->agent_id==0?"":$pre_reservation->agent_id}}</td>
            <td class="text-center"><a class="more_btn"
                href="{{url('admin/pre_reservations/'.$pre_reservation->id)}}">詳細</a></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  {{ $pre_reservations->links() }}



</div>



<script>
  $(function(){

    function ActiveDateRangePicker($target){
            $("input[name='"+$target+"']").daterangepicker({
            "locale": {
            "format": "YYYY/MM/DD",
            "separator": " ~ ",
            "applyLabel": "反映",
            "cancelLabel": "初期化",
            "weekLabel": "W",
            "daysOfWeek": ["Su","Mo","Tu","We","Th","Fr","Sa"],
            "monthNames": ["1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月"],
            "firstDay": 1,
            },
            autoUpdateInput: false
            });

            $("input[name='"+$target+"']").on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
            });

            $("input[name='"+$target+"']").on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            });
    }

    ActiveDateRangePicker('search_created_at');
    ActiveDateRangePicker('search_date');
  })
</script>




<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />



@endsection