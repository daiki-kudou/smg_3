@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>

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
            <li class="breadcrumb-item active">
              ダミーテキスト
            </li>
          </ol>
        </nav>
      </div>

      <h2 class="mt-3 mb-3">一括仮押え 一覧</h2>
      <hr>
    </div>

      <!-- 検索--------------------------------------- -->
      <div class="search-wrap">
      <table class="table table-bordered mb-0">
        <tbody>
          <tr>
            <th class="search_item_name"><label for="id">一括仮押えID</label>
            <td class="text-right">
              <input type="text" name="id" class="form-control" id="id">
            </td>
            <th class="search_item_name"><label for="">作成日</label></th>
            <td class="text-right form-group">
              <input type="date" name="" class="form-control float-right" id="">
            </td>
          </tr>
          <tr>
            <th class="search_item_name"><label for="company">会社・団体名</label></th>
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
            <th class="search_item_name"><label for="temp_company">会社・団体名(仮)</label></th>
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
    <div class="section-wrap">

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
            <a class="more_btn bg-red" href="">仮押え期間超過</a>
            <p class="ml-3 font-weight-bold"><span class="count-color">ダミー</span>件</p>
          </div>
        </li>
      </ul>

      <div class="table-wrap">
        <table class="table table-bordered table-scroll">
          <thead>
            <tr class="table_row">
              <th><input type="checkbox" name="all_check" id="all_check" /></th>
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
              <td>
                <input type="checkbox" name="{{'delete_check'.$multiple->id}}" value="{{$multiple->id}}" class="checkbox" />
              </td>
              <td>{{$multiple->id}}</td>
              <td>{{$multiple->created_at}}</td>
              <td>{{$multiple->pre_reservations_count}}</td>
              <td>
                {{(ReservationHelper::getCompany($multiple->pre_reservations->first()->user_id))}}
              </td>
              <td>
                @if ($multiple->pre_reservations->first()->user_id!=999)
                {{(ReservationHelper::getPersonName($multiple->pre_reservations->first()->user_id))}}
                @endif
              </td>
              <td>
                @if ($multiple->pre_reservations->first()->user_id!=999)
                {{(ReservationHelper::getPersonMobile($multiple->pre_reservations->first()->user_id))}}
                @endif
              </td>
              <td>
                @if ($multiple->pre_reservations->first()->user_id!=999)
                {{(ReservationHelper::getPersonTel($multiple->pre_reservations->first()->user_id))}}
                @endif
              </td>
              <td>
                @if ($multiple->pre_reservations->first()->user_id==999)
                {{$multiple->pre_reservations->first()->unknown_user->unknown_user_company}}
                @endif
              </td>
              <td>
                ※後ほど着手予定
              </td>
              <td>※後ほど着手予定</td>
              <td class="text-center"><a href="{{url('admin/multiples/'.$multiple->id)}}" class="btn more_btn">詳細</a></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>


    <script>
      $(function() {
        // 全選択アクション
        $('#all_check').on('change', function() {
          $('.checkbox').prop('checked', $(this).is(':checked'));
        })

        // 削除確認コンファーム
        $('#confirm_destroy').on('click', function() {
          if (!confirm('削除してもよろしいですか？')) {
            return false;
          }
        })
      })

      $(function() {
        $("input[type='checkbox']").on('change', function() {
          checked = $('[class="checkbox"]:checked').map(function() {
            return $(this).val();
          }).get();
          console.log(checked.length);
          for (let index = 0; index < checked.length; index++) {
            var ap_data = "<input type='hidden' name='destroy" + checked[index] + "' value='" + checked[index] + "'>"
            $('#for_destroy').append(ap_data);
          }
        })
      })
    </script>

    <div class="container-field">

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
      <a class="page-link" href="http://staging-smg2.herokuapp.com/admin/clients?page=2" rel="next" aria-label="次 &raquo">&rsaquo;</a>
    </li>
  </ul>


</div>


@endsection