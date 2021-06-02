@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/admin/validation.js') }}"></script>

<script src="{{ asset('/js/tablesorter/jquery.tablesorter.js') }}"></script>
<link href="{{ asset('/css/tablesorter/theme.default.min.css') }}" rel="stylesheet">


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

<div class="content">
  <div class="container-fluid">
    <div class="container-field mt-3">
      <div class="float-right">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active">
              {{ Breadcrumbs::render(Route::currentRouteName(),$request->id) }}
            </li>
          </ol>
        </nav>
      </div>
      <h2 class="mt-3 mb-3">一括仮押え 一覧</h2>
      <hr>
    </div>

    <!-- 検索--------------------------------------- -->
    {{Form::open(['url' => 'admin/multiples', 'method' => 'GET', 'id'=>'searchMultiple'])}}
    @csrf
    <div class="search-wrap">
      <table class="table table-bordered mb-0">
        <tbody>
          <tr>
            <th class="search_item_name"><label for="id">一括仮押えID</label>
            <td class="text-right">
              {{Form::text("search_id",$request->search_id, ['class'=>'form-control'])}}
              <p class="is-error-search_id text-left" style="color: red"></p>
            </td>
            <th class="search_item_name"><label for="">作成日</label></th>
            <td class="text-right form-group">
              {{Form::text("search_created_at",$request->search_created_at, ['class'=>'form-control','id'=>''])}}
            </td>
          </tr>
          <tr>
            <th class="search_item_name"><label for="company">会社・団体名</label></th>
            <td class="text-right">
              {{Form::text("search_company",$request->search_company, ['class'=>'form-control'])}}
            </td>
            <th class="search_item_name"><label for="person_name">担当者氏名</label></th>
            <td class="text-right">
              <dd>
                {{Form::text('search_person',$request->search_person,['class'=>'form-control'])}}
            </td>
          </tr>
          <tr>
            <th class="search_item_name"><label for="mobile">携帯電話</label></th>
            <td>
              {{Form::text("search_mobile",$request->search_mobile, ['class'=>'form-control','id'=>''])}}
              <p class="is-error-search_mobile text-left" style="color: red"></p>
            </td>
            <th class="search_item_name"><label for="tel">固定電話</label></th>
            <td>
              {{Form::text("search_tel",$request->search_tel, ['class'=>'form-control','id'=>''])}}
              <p class="is-error-search_tel text-left" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <th class="search_item_name"><label for="temp_company">会社・団体名(仮)</label></th>
            <td>
              {{Form::text("search_unkown_user",$request->search_unkown_user, ['class'=>'form-control','id'=>''])}}
            </td>
            <th class="search_item_name"><label for="agent">仲介会社</label></th>
            <td>
              <select name="search_agent" id="search_agent" class="form-control">
                <option value=""></option>
                @foreach ($agents as $s_a)
                <option value="{{$s_a->id}}" @if ($s_a->id==$request->search_agent)
                  selected
                  @endif
                  >{{ReservationHelper::getAgentCompanyName($s_a->id)}}</option>
                @endforeach
              </select>
            </td>
          </tr>

          <tr>
            <th class="search_item_name"><label for="search_end_user">エンドユーザー</label></th>
            <td>
              {{Form::text("search_end_user",$request->search_end_user, ['class'=>'form-control','id'=>''])}}
            </td>
            <th class="search_item_name"><label for="freeword">フリーワード検索</label></th>
            <td>
              {{Form::text("search_free",$request->search_free, ['class'=>'form-control','id'=>''])}}
            </td>
          </tr>
        </tbody>
      </table>
      <p class="text-right">※フリーワード検索は本画面表記の項目のみ対象となります</p>

      <div class="btn_box d-flex justify-content-center">
        <a href="{{url('admin/multiples')}}" class="btn reset_btn">リセット</a>
        {{Form::submit('検索', ['class'=>'btn search_btn', 'id'=>''])}}
      </div>
    </div>
    {{Form::close()}}






    <!-- 検索　終わり------------------------------------------------ -->
    <div class="section-wrap">

      <ul class="d-flex reservation_list mb-2 justify-content-between">
        <li>
          {{-- 削除ボタン --}}
          {{Form::open(['url' => 'admin/multiples/destroy', 'method' => 'delete', 'id'=>'for_destroy'])}}
          @csrf
          {{ Form::submit('削除', ['class' => 'btn more_btn4','id'=>'confirm_destroy']) }}
          {{ Form::close() }}
        </li>
        <li>
          <div class="d-flex align-items-center">
            <p><a class="more_btn bg-red" href="">仮押え期間超過</a></p>
            <p class="ml-3 font-weight-bold"><span class="count-color">{{$counter}}</span>件</p>
          </div>
        </li>
      </ul>

      <div class="table-wrap">
        <table class="table table-bordered table-scroll sort_table">
          <thead>
            <tr class="table_row">
              <th>
                <p class="annotation">すべて</p>
                <input type="checkbox" name="all_check" id="all_check" />
              </th>
              <th>一括仮押えID</th>
              <th>作成日</th>
              <th>件数</th>
              <th>会社・団体名</th>
              <th>担当者氏名</th>
              <th>携帯電話</th>
              <th>固定電話</th>
              <th>会社・団体名(仮)</th>
              <th>仲介会社</th>
              <th>エンドユーザー</th>
              <th>仮押え詳細</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($multiples as $multiple)
            <tr>
              <td class="text-center">
                <input type="checkbox" name="{{'delete_check'.$multiple->id}}" value="{{$multiple->id}}"
                  class="checkbox" />
              </td>

              <td>{{ReservationHelper::fixId($multiple->id)}}</td>
              <td>{{ReservationHelper::formatDate($multiple->created_at)}}</td>
              <td>{{$multiple->pre_reservations->count()}}</td>
              <td>
                @if (!empty($multiple->pre_reservations->first()->user))
                {{(ReservationHelper::getCompany($multiple->pre_reservations->first()->user->id))}}
                @endif
              </td>
              <td>
                @if (!empty($multiple->pre_reservations->first()->user))
                {{ReservationHelper::getPersonName($multiple->pre_reservations->first()->user->id)}}
                @else
                {{ReservationHelper::getAgentPerson($multiple->pre_reservations->first()->agent->id)}}
                @endif
              </td>
              <td>
                @if (!empty($multiple->pre_reservations->first()->user))
                {{ReservationHelper::getPersonMobile($multiple->pre_reservations->first()->user->id)}}
                @else
                {{ReservationHelper::getAgentMobile($multiple->pre_reservations->first()->agent->id)}}
                @endif
              </td>
              <td>
                @if (!empty($multiple->pre_reservations->first()->user))
                {{ReservationHelper::getPersonTel($multiple->pre_reservations->first()->user->id)}}
                @else
                {{ReservationHelper::getAgentTel($multiple->pre_reservations->first()->agent->id)}}
                @endif
              </td>
              <td>
                @if (!empty($multiple->pre_reservations->first()->user))
                {{($multiple->pre_reservations->first()->unknown_user->unknown_user_company)}}
                @endif
              </td>
              <td>
                @if (empty($multiple->pre_reservations->first()->user))
                {{$multiple->pre_reservations->first()->agent->company}}
                @endif
              </td>
              <td>
                @if (empty($multiple->pre_reservations->first()->user))
                {{$multiple->pre_reservations->first()->pre_enduser->company}}
                @endif
              </td>
              <td class="text-center">
                @if (!empty($multiple->pre_reservations->first()->user))
                <a href="{{url('admin/multiples/'.$multiple->id)}}" class="btn more_btn">詳細</a>
                @else
                <a href="{{url('admin/multiples/agent/'.$multiple->id)}}" class="btn more_btn">詳細</a>
                @endif
              </td>
            </tr>

            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{ $multiples->appends(request()->input())->links() }}
</div>



<script>
  $(function() {
    $('.flash_message').fadeOut(3000);
  })

  $(function() {
    // 全選択アクション
    $('#all_check').on('change', function() {
      $('.checkbox').prop('checked', $(this).is(':checked'));
    })
    // 削除確認コンファーム
    $('#confirm_destroy').on('click', function() {
      if (!confirm('削除してもよろしいですか？\n一括仮押さえに関連する仮押さえの内容がすべて削除されます')) {
        return false;
      }
    })
  })
  $(function() {
    $("input[type='checkbox']").on('change', function() {
      checked = $('[class="checkbox"]:checked').map(function() {
        return $(this).val();
      }).get();
      for (let index = 0; index < checked.length; index++) {
        var ap_data = "<input type='hidden' name='destroy" + checked[index] + "' value='" + checked[index] + "'>"
        $('#for_destroy').append(ap_data);
      }
    })
  })
  $(function() {
    function ActiveDateRangePicker($target) {
      $("input[name='" + $target + "']").daterangepicker({
        "locale": {
          "format": "YYYY/MM/DD",
          "separator": " ~ ",
          "applyLabel": "反映",
          "cancelLabel": "初期化",
          "weekLabel": "W",
          "daysOfWeek": ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
          "monthNames": ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"],
          "firstDay": 1,
        },
        autoUpdateInput: false
      });
      $("input[name='" + $target + "']").on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
      });
      $("input[name='" + $target + "']").on('cancel.daterangepicker', function(ev, picker) {
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