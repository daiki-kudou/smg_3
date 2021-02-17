@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>



<h1>一括　仮押さえ一覧</h1>



{{-- <script>
  $(function(){
    $('.flash_message').fadeOut(3000);
  })
</script> --}}

{{-- @if (session('flash_message'))
<div class="flash_message bg-success text-center py-3 my-0">
  {{ session('flash_message') }}
</div>
@endif
@if (session('flash_message_error'))
<div class="flash_message bg-danger text-center py-3 my-0">
  {{ session('flash_message_error') }}
</div>
@endif --}}


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
              予約一覧
            </li>
          </ol>
        </nav>
      </div>
      <h1 class="mt-3 mb-5">予約一覧</h1>
      <hr>
    </div>

    <!-- 検索--------------------------------------- -->

    <div class="container-field">
      <div class="row search_box">
        <div class="col-md-10 offset-md-1">
          <div class="d-flex col-12 pd0">
            <dl class="form-group flex-fill">
              <dt>
                <label class="search_item_name" for="bulkid">予約一括ID</label>
              </dt>
              <dd>
                <input type="text" name="bulkid" class="form-control" id="bulkid">
              </dd>
            </dl>
            <dl class="form-group flex-fill">
              <dt>
                <label class="search_item_name" for="id">予約ID</label>
              </dt>
              <dd>
                <input type="text" name="id" class="form-control" id="id">
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
                    <input type="text" class="form-control float-right" id="reservation">
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
                    <select class="form-control" id="eventStart" name="eventStart">
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
                    <select class="form-control" id="eventFinish" name="eventFinish">
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
                  <select class="form-control select2" style="width: 100%;" name="venue">
                    <option>テスト会場A</option>
                    <option>テスト会場B</option>
                    <option>テスト会場C</option>
                  </select>
                </dd>
              </dl>
              <dl class="form-group">
                <dt>
                  <label class="search_item_name" for="company">会社名・団体名</label>
                </dt>
                <dd>
                  <select class="form-control select2" style="width: 100%;" name="company">
                    <option>テスト会場A</option>
                    <option>テスト会場B</option>
                    <option>テスト会場C</option>
                  </select>
                </dd>
              </dl>
              <dl class="form-group">
                <dt>
                  <label class="search_item_name" for="name">担当者氏名</label>
                </dt>
                <dd>
                  <input type="text" name="name" class="form-control" id="name">
                </dd>
              </dl>
              <dl class="form-group">
                <dt>
                  <label class="search_item_name" for="category">カテゴリー</label>
                </dt>
                <dd>
                  <ul class="form-control icheck-primary d-flex d-flex justify-content-around">
                    <li>
                      <input type="checkbox" id="checkboxPrimary1" checked>
                      <label for="checkboxPrimary1">会場</label>
                    </li>
                    <li>
                      <input type="checkbox" id="checkboxPrimary1" checked>
                      <label for="checkboxPrimary1">キャンセル</label>
                    </li>
                    <li>
                      <input type="checkbox" id="checkboxPrimary1" checked>
                      <label for="checkboxPrimary1">追加請求</label>
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
                    <option>予約確認中</option>
                    <option>予約承認待ち</option>
                    <option>予約完了</option>
                  </select>
                </dd>
              </dl>
              <dl class="form-group">
                <dt>
                  <label class="search_item_name" for="freeword">フリーワード検索</label>
                </dt>
                <dd>
                  <input type="text" name="freeword" class="form-control" id="freeword">
                </dd>
              </dl>

            </div>
          </div>
          <p class="text-right">※フリーワード検索は本画面表記の項目のみ対象となります</p>


        </div>


        <div class="btn_box d-flex justify-content-center">
          <input type="reset" value="リセット" class="btn reset_btn">
          <input type="submit" value="検索" class="btn search_btn">
        </div>
      </div>

    </div>

    <!-- 検索　終わり------------------------------------------------ -->

    {{-- <ul class="d-flex reservation_list">
      <li><a class="more_btn" href="">前日予約</a></li>
      <li><a class="more_btn" href="">当日予約</a></li>
      <li><a class="more_btn" href="">翌日予約</a></li>
      <li><a class="more_btn bg-red" href="">予約確認中</a></li>
      <li><a class="more_btn bg-red" href="">予約承認待ち</a></li>
      <li><a class="more_btn bg-green" href="">キャンセル申請中</a></li>
      <li><a class="more_btn bg-black" href="">予約完了</a></li>
    </ul> --}}
    <div class="col-12">
      <p class="text-right font-weight-bold"><span>10</span>件</p>
    </div>
    {{-- 削除ボタン --}}
    {{Form::open(['url' => 'admin/pre_reservations/destroy', 'method' => 'POST', 'id'=>'for_destroy'])}}
    @csrf
    {{ Form::submit('削除', ['class' => 'btn btn-danger','id'=>'confirm_destroy']) }}
    {{ Form::close() }}


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

    <div class="container-field">
      <table class="table table-striped table-bordered table-box">
        <thead>
          <tr>
            <th><input type="checkbox" name="all_check" id="all_check" /></th>
            <th>一括仮抑えID</th>
            <th>作成日</th>
            <th>件数</th>
            <th>会社名・団体名</th>
            <th>担当者氏名</th>
            <th>携帯</th>
            <th>電話</th>
            <th>会社名・団体名(顧客未登録)</th>
            <th>仲介会社</th>
            <th>仲介当日利用者</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($multiples as $multiple)
          <tr>
            <td>
              <input type="checkbox" name="{{'delete_check'.$multiple->id}}" value="{{$multiple->id}}"
                class="checkbox" />
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
            <td><a href="" class="btn btn-primary">詳細</a></td>
          </tr>
          @endforeach
          {{-- @foreach ($pre_reservations as $pre_reservation)
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
          <td>{{$pre_reservation->user_id==999?"未登録ユーザー":ReservationHelper::getCompany($pre_reservation->user_id)}}
          <td>{{$pre_reservation->user_id==999?"":ReservationHelper::getPersonName($pre_reservation->user_id)}}
          <td>{{$pre_reservation->user_id==999?"":ReservationHelper::getPersonMobile($pre_reservation->user_id)}}</td>
          <td>{{$pre_reservation->user_id==999?"":ReservationHelper::getPersonTel($pre_reservation->user_id)}}</td>
          <td>{{$pre_reservation->agent_id==0?"":$pre_reservation->agent_id}}</td>
          <td>{{$pre_reservation->agent_id==0?"":$pre_reservation->agent_id}}</td>
          <td>{{$pre_reservation->agent_id==0?"":$pre_reservation->agent_id}}</td>
          <td><a href="{{url('admin/pre_reservations/'.$pre_reservation->id)}}">詳細</a></td>
          </tr>
          @endforeach --}}
        </tbody>
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