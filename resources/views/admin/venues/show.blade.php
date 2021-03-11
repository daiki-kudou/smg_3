@extends('layouts.admin.app')

@section('content')
<script src="{{ asset('/js/template.js') }}"></script>
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">




<div class="container-fluid">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">
          {{ Breadcrumbs::render(Route::currentRouteName(),$venue->id) }}
        </li>
      </ol>
    </nav>
  </div>

  <h2 class="mt-3 mb-3">会場　詳細情報</h2>
  <hr>

  <section class="section-wrap">
    <div class="d-flex mb-2 justify-content-between align-items-end">
      <p class="text-left">※金額は税抜表記になります。</p>

      {{ link_to_route('admin.venues.edit', '編集', $parameters = $venue->id, ['class' => 'btn more_btn'])}}

      {{-- 大山さんが確認後実装予定 3/5 --}}
      {{-- 会場の表示・非表示　（soft delete）機能 --}}
      {{-- <select name="delete_venue" id="delete_venue" class="">
        <option value="0" {{!empty($venue->deleted_at)?"":"selected"}}>表示</option>
      <option value="1" {{empty($venue->deleted_at)?"":"selected"}}>非表示</option>
      </select> --}}
      {{-- {{ Form::open(['url' => 'admin/venues/'.$venue->id, 'method'=>'delete', 'id'=>'venueDeleteForm']) }}
      @csrf
      {{Form::close()}}
      {{ Form::open(['url' => 'admin/venues/'.$venue->id.'/restore', 'method'=>'post', 'id'=>'venueRestoreForm']) }}
      @csrf
      {{Form::close()}} --}}

    </div>

    <!-- 会場URL ---------------------------------------------------->
    <div class="row">
      <div class="col">
        <form method="POST" action="https://staging-smg2.herokuapp.com/admin/venues" accept-charset="UTF-8"
          id="VenuesCreateForm">
          <input name="_token" type="hidden" value="7YnZpH69frvKkgAQxFwljXRjXXjvobnDxuSeERdf">
          <input type="hidden" name="_token" value="7YnZpH69frvKkgAQxFwljXRjXXjvobnDxuSeERdf">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <td class="table-active"> <label for="smg_url">会場SMG URL</label></td>
                <td>{{$venue->smg_url}}
                </td>
              </tr>
            </tbody>
          </table>
        </form>
      </div>
    </div>

    <div class="row">
      <!-- 左側の項目 -------------------------------------------------------------------------->
      <div class="col">

        <!-- 基本情報 ------------------------------------------------------------------------>
        <table class="table table-bordered">
          <thead>
            <tr>
              <td colspan="2">
                <p class="title-icon">
                  <i class="fas fa-exclamation-circle icon-size fa-fw" aria-hidden="true"></i>ビル情報
                </p>
              </td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th class="table-active" id="alliance_flag">直/提</th>
              <td class="d-flex">
                <p>{{$venue->alliance_flag==0?"直営":'提携'}}</p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="name_area">エリア名</label></td>
              <td> {{ $venue->name_area }} </td>
            </tr>
            <tr>
              <td class="table-active"><label for="name_bldg">ビル名</label></td>
              <td>
                {{ $venue->name_bldg }}
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="name_venue">会場名</label></td>
              <td>
                {{ $venue->name_venue }}
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="size1">会場広さ（坪）</label></td>
              <td>
                {{ $venue->size1 }}
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="size2">会場広さ（㎡）</label></td>
              <td> {{ $venue->size2 }} </td>
            </tr>
            <tr>
              <td class="table-active"><label for="capacity">収容人数</label></td>
              <td> {{ $venue->capacity }} </td>
            </tr>
            <tr>
              <td class="table-active"><label for="post_code">郵便番号</label></td>
              <td>
                {{ $venue->post_code }}
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="address1">住所（都道府県）</label></td>
              <td> {{ $venue->address1 }}
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="address2">住所（市町村番地）</label></td>
              <td> {{ $venue->address2 }}
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="address3">住所（建物名）</label></td>
              <td> {{ $venue->address3 }}
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="entrance_open_time">正面入口の開閉時間</label></td>
              <td> {{ $venue->entrance_open_time }}
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="backyard_open_time">通用口の開閉時間</label></td>
              <td> {{ $venue->backyard_open_time }}
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="remark">備考</label></td>
              <td> {{ $venue->remark }}
              </td>
            </tr>


          </tbody>
        </table>

        <!-- 荷物預かり ------------------------------------------------------------------------->
        <table class="table table-bordered">
          <thead>
            <tr>
              <td colspan="2">
                <p class="title-icon">
                  <i class="fas fa-suitcase-rolling icon-size fa-fw" aria-hidden="true"></i>荷物預かり
                </p>
              </td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="table-active"><label for="luggage_flag">荷物預かり　有・無</label></td>
              <td> {{ $venue->luggage_flag==1?"有り":"無し" }}
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="luggage_post_code">送付先郵便番号</label></td>
              <td>
                {{ $venue->luggage_post_code }}
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="luggage_address1">住所（都道府県）</label></td>
              <td> {{ $venue->luggage_address1 }}
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="luggage_address2">住所（市町村番地）</label></td>
              <td> {{ $venue->luggage_address2 }}
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="luggage_address3">住所（建物名）</label></td>
              <td> {{ $venue->luggage_address3 }}
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="luggage_name">送付先名</label></td>
              <td> {{ $venue->luggage_name }}
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="luggage_tel">電話番号</label></td>
              <td> {{ $venue->luggage_tel }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- 左側の項目　終わり ---------------------------------------------------------------------->

      <!-- 右側の項目 -------------------------------------------------------------------------->
      <div class="col">
        <!-- 担当者情報 ------------------------------------------------------------------------>
        <table class="table table-bordered">
          <thead>
            <tr>
              <td colspan="3">
                <p class="title-icon">
                  <i class="fas fa-user-check icon-size fa-fw" aria-hidden="true"></i>担当者情報
                </p>
              </td>
            </tr>
          </thead>
          <tbody>
            <!-- 工藤さんに確認　顧客の新規登録のデータをピックアップ問題ないか -->
            <tr>
              <td class="table-active"><label for="first_name">担当者氏名</label></td>
              <td colspan="2"> {{ $venue->first_name}} {{ $venue->last_name}}
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="first_name_kana">担当者氏名（フリガナ）</label></td>
              <td colspan="2">
                {{ $venue->first_name_kana}}
                {{ $venue->last_name_kana}}
              </td>
            </tr>
            <!-- 工藤さんに確認　顧客の新規登録のデータをピックアップ問題ないか -->

            <tr>
              <td class="table-active"><label for="person_tel">担当者電話番号</label></td>
              <td colspan="2">
                {{ $venue->person_tel}}
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="person_email">担当者メールアドレス</label></td>
              <td colspan="2"> {{ $venue->person_email}}
              </td>
            </tr>
          </tbody>
        </table>

        <!-- ビル管理会社情報 ------------------------------------------------------------------------>
        <table class="table table-bordered">
          <thead>
            <tr>
              <td colspan="3">
                <p class="title-icon">
                  <i class="fas fa-building icon-size fa-fw" aria-hidden="true"></i>ビル管理会社
                </p>
              </td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="table-active"><label for="mgmt_company">会社名</label></td>
              <td colspan="2">
                {{ $venue->mgmt_company}}
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="mgmt_tel">電話番号</label></td>
              <td colspan="2"> {{ $venue->mgmt_tel}}
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="mgmt_emer_tel">夜間緊急連絡先</label></td>
              <td colspan="2"> {{ $venue->mgmt_emer_tel}}
              </td>
            </tr>

            <!-- 工藤さんに確認　顧客の新規登録のデータをピックアップ問題ないか -->
            <tr>
              <td class="table-active"><label for="mgmt_first_name">担当者氏名</label></td>
              <td colspan="2">
                {{ $venue->mgmt_first_name}} {{ $venue->mgmt_last_name}}
              </td>
            </tr>
            <!-- 工藤さんに確認　顧客の新規登録のデータをピックアップ問題ないか -->

            <tr>
              <td class="table-active"><label for="mgmt_email">担当者メール</label></td>
              <td colspan="2"> {{ $venue->mgmt_email}}
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="mgmt_sec_company">警備会社名</label></td>
              <td colspan="2"> {{ $venue->mgmt_sec_company}}
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="mgmt_sec_tel">警備会社電話番号</label></td>
              <td colspan="2"> {{ $venue->mgmt_sec_tel}}
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="mgmt_remark">備考</label></td>
              <td colspan="2"> {{ $venue->mgmt_remark}}
              </td>
            </tr>
          </tbody>
        </table>

        <!-- 室内飲食 ------------------------------------------------------------------------>
        <table class="table table-bordered">
          <thead>
            <tr>
              <td colspan="2">
                <p class="title-icon">
                  <i class="fas fa-utensils icon-size fa-fw" aria-hidden="true"></i>室内飲食
                </p>
              </td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="table-active"><label for="eat_in_flag">室内飲食</label></td>
              <td>
                {{ $venue->eat_in_flag==1?"有り":"無し"}}
              </td>
            </tr>
          </tbody>
        </table>

        <!-- レイアウト変更 ------------------------------------------------------------------------>
        <table class="table table-bordered">
          <thead>
            <tr>
              <td colspan="2">
                <p class="title-icon">
                  <i class="fas fa-th icon-size fa-fw" aria-hidden="true"></i>レイアウト
                </p>
              </td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="table-active"><label for="layout">レイアウト変更</label></td>
              <td>
                {{ $venue->layout==1?"有り":"無し"}}
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="layout">レイアウト準備料金</label></td>
              <td>
                {{ $venue->layout_prepare}}
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="layout">レイアウト片付料金</label></td>
              <td>
                {{ $venue->layout_clean}}
              </td>
            </tr>
          </tbody>
        </table>

        <!-- 支払データ ------------------------------------------------------------------------>
        <table class="table table-bordered">
          <thead>
            <tr>
              <td colspan="2">
                <p class="title-icon">
                  <i class="fas fa-yen-sign icon-size fa-fw" aria-hidden="true"></i>支払データ
                </p>
              </td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="table-active"><label for="cost">支払割合（原価）</label></td>
              <td>
                {{ $venue->cost}}%
              </td>
            </tr>
          </tbody>
        </table>

      </div>
      <!-- 右側の項目　終わり ---------------------------------------------------------------------->
    </div>

  </section>

  <section class="section-wrap">
    <!-- 有料備品 ------------------------------------------------------------------------>
    <div class="mb-5 border-wrap2">
      <p class="title-icon table-active fw-bolder p-2 mb-2">
        <i class="fas fa-wrench icon-size fa-fw" aria-hidden="true"></i>有料備品
      </p>
      <div>
        <ul class="p-3">
          @foreach ($equipments as $equipment)
          <li>{{$equipment->item}}</li>
          @endforeach
        </ul>
      </div>
    </div>

    <!-- 有料サービス ------------------------------------------------------------------------>
    <div class="mb-5 border-wrap2">
      <p class="title-icon table-active fw-bolder p-2 mb-2">
        <i class="fas fa-hand-holding-heart icon-size fa-fw" aria-hidden="true"></i>有料サービス
      </p>
      <div>
        <ul class="p-3">
          @foreach ($services as $service)
          <li>{{$service->item}}
          </li>
          @endforeach
        </ul>
      </div>
    </div>

    <!-- 営業時間 ------------------------------------------------------------------------>
    <div class="mb-5 border-wrap2">
      <p class="title-icon table-active fw-bolder p-2">
        <i class="fas fa-clock icon-size fa-fw" aria-hidden="true"></i>営業時間
      </p>
      <div>
        <table class="table table-bordered　mb-0">
          <thead>
            <tr>
              <th scope="col">曜日</th>
              <th colspan="2">営業時間</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($date_venues as $date_venue)
            <tr>
              <td>
                @if ($date_venue->week_day==1)
                月曜
                @elseif($date_venue->week_day==2)
                火曜
                @elseif($date_venue->week_day==3)
                水曜
                @elseif($date_venue->week_day==4)
                木曜
                @elseif($date_venue->week_day==5)
                金曜
                @elseif($date_venue->week_day==6)
                土曜
                @elseif($date_venue->week_day==7)
                日曜
                @endif
              </td>
              <td>{{ReservationHelper::formatTime($date_venue->start)}}
              </td>
              <td>{{ReservationHelper::formatTime($date_venue->finish)}}
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <div class="mb-5 border-wrap2">
      <p class="title-icon table-active fw-bolder p-2">
        <i class="fas fa-yen-sign icon-size fa-fw" aria-hidden="true"></i>料金管理
      </p>
      <div class="p-3">
        <div class="mb-2">
          <strong>料金体系</strong>
          <p>通常料金（枠貸し）</p>
        </div>
        <div>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">枠</th>
                <th>時間</th>
                <th>料金</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($frame_prices as $frame_price)
              <tr>
                <td>{{$frame_price->frame}}
                </td>
                <td>{{ReservationHelper::formatTime($frame_price->start)}}
                  ~
                  {{ReservationHelper::formatTime($date_venue->finish)}}
                </td>
                <td>{{number_format($frame_price->price)}}
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <div class="mb-2">
          <strong>料金体系</strong>
          <p>アクセア料金（時間貸し）</p>
        </div>
        <div>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">時間</th>
                <th>料金</th>
                <th>延長料金</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($time_prices as $time_price)
              <tr>
                <td>{{$time_price->time}}
                </td>
                <td>{{number_format($time_price->price)}} </td>
                <td>{{number_format($time_price->extend)}}
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
  <div class="text-center mt-5">
    <p><a class="more_btn_lg" href="{{url('admin/venues')}}">一覧にもどる</a>
    </p>
  </div>
</div>






{{-- 大山さんが確認後実装予定 3/5 --}}
{{-- 会場の表示・非表示　（soft delete）機能 --}}
{{-- <script>
  $(function(){
  $('#delete_venue').on('change',function(){
    var result = $('#delete_venue').val($(this).val());
    if (result.val()==1) {
      if(!confirm('会場を非表示にしますか？')){
        return false;
      }else{
        $('#venueDeleteForm').submit();
      }
    }else{
      if(!confirm('会場を再度表示にしますか？')){
        return false;
      }else{
        $('#venueRestoreForm').submit();
      }
    }
  });
  });
</script> --}}








@endsection