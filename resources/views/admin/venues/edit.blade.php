@extends('layouts.admin.app')

@section('content')
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/admin/venues/validation.js') }}"></script>
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/admin/reservation.js') }}"></script>
<script src="{{ asset('/js/ctrl_form.js') }}"></script>


<style>
  .hide {
    display: none !important;
  }
</style>


{{ Form::model($venue, ['route' => ['admin.venues.update', $venue->id], 'method' => 'put','id'=>'VenuesEditForm']) }}
@csrf
<div class="container-field">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">
          {{ Breadcrumbs::render(Route::currentRouteName(),$venue->id) }}
        </li>
      </ol>
    </nav>
  </div>
  <h2 class="mt-3 mb-3">会場　詳細情報(編集)</h2>
  <p>ID:{{ ReservationHelper::fixId($venue->id) }}<span class="ml-2">{{ $venue->name_bldg }}{{ $venue->name_venue
      }}</span></p>
  <hr>
</div>

<div class="errors">
  @if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
      <li>
        {{ $error }}
      </li>
      @endforeach
    </ul>
  </div>
  @endif
</div>

<section class="mt-5">
  <p class="text-right">※金額は税抜で入力してください。</p>
  <!-- 会場URL ---------------------------------------------------->
  <div class="row">
    <div class="col">
      <table class="table table-bordered">
        <tbody>
          <tr>
            <td class="table-active w-25"><label for="smg_url" class="">会場SMG URL</label></td>
            <td>

              {{ Form::text('smg_url', $venue->smg_url, ['class' => 'form-control']) }}
              <p class="is-error-smg_url" style="color: red"></p>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="row">
    <!-- 左側の項目 -------------------------------------------------------------------------->

    <div class="col">

      <!-- 基本情報 ------------------------------------------------------------------------>
      <table class="table table-bordered venue_table">
        <thead>
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-exclamation-circle icon-size" aria-hidden="true"></i>ビル情報
              </p>
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th class="table-active form_required" id="alliance_flag">直/提</th>
            <td class="d-flex">
              <p class="mr-3">
                <label for="alliance_flag">直営</label>
                {{Form::radio('alliance_flag', '0')}}
              </p>
              <p class="alliance_color">
                <label for="alliance_flag">提携</label>
                {{Form::radio('alliance_flag', '1')}}
              </p>
              <p class="is-error-alliance_flag" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="name_area" class="form_required">エリア名</label></td>
            <td>
              {{ Form::text('name_area', $venue->name_area, ['class' => 'form-control']) }}
              <p class="is-error-name_area" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="name_bldg" class="form_required">ビル名</label></td>
            <td>
              {{ Form::text('name_bldg', $venue->name_bldg, ['class' => 'form-control']) }}
              <p class="is-error-name_bldg" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="name_venue" class="form_required">会場名</label></td>
            <td>
              {{ Form::text('name_venue', $venue->name_venue, ['class' => 'form-control']) }}
              <p class="is-error-name_venue" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="size1" class="form_required">会場広さ（坪）</label></td>
            <td>
              {{ Form::text('size1', $venue->size1, ['class' => 'form-control']) }}
              <p class="is-error-size1" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="size2" class="form_required">会場広さ（㎡）</label></td>
            <td>
              {{ Form::text('size2', $venue->size2, ['class' => 'form-control']) }}
              <p class="is-error-size2" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="capacity" class="form_required">収容人数</label></td>
            <td>
              {{ Form::textarea('capacity', $venue->capacity, ['placeholder' => '15','class' =>
              'form-control','rows'=>"2"]) }}
              <p class="is-error-capacity" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active">
              <label for="post_code" class="form_required">
                郵便番号
              </label>
            </td>
            <td>
              <div class="d-flex">
                <p>{{ Form::text('post_code',$venue->post_code,['class'=>'form-control']) }}</p>
                <button class="btn more_btn ml-1" type="button" id="post_code_search">住所検索</button>
              </div>

              <p class="is-error-post_code" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="address1" class="form_required">住所（都道府県）</label></td>
            <td>
              {{ Form::text('address1', $venue->address1, ['placeholder' => '大阪府','class' => 'form-control
              search_address2']) }}
              <p class="is-error-address1" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="address2" class="form_required">住所（市町村番地）</label></td>
            <td>
              {{ Form::text('address2', $venue->address2, ['placeholder' => '大阪市北堀江1-23-1','class' => 'form-control
              search_address3']) }}
              <p class="is-error-address2" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="address3" class="form_required">住所（建物名）</label></td>
            <td>
              {{ Form::text('address3', $venue->address3, ['placeholder' => '四ツ橋サンワールドビル1号室','class' => 'form-control'])
              }}
              <p class="is-error-address3" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="entrance_open_time">正面入口の開閉時間</label></td>
            <td>
              {{ Form::textarea('entrance_open_time', $venue->entrance_open_time, ['class' =>
              'form-control','rows'=>"2"]) }}
              <p class="is-error-backyard_open_time" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="backyard_open_time">通用口の開閉時間</label></td>
            <td>
              {{ Form::textarea('backyard_open_time', $venue->backyard_open_time, ['class' =>
              'form-control','rows'=>"2"]) }}
              <p class="is-error-entrance_open_time" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="remark">備考</label></td>
            <td>
              {{ Form::textarea('remark', $venue->remark, ['class' => 'form-control']) }}
              <p class="is-error-remark" style="color: red"></p>
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
                <i class="fas fa-suitcase-rolling icon-size" aria-hidden="true"></i>荷物預かり
              </p>
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="table-active"><label for="luggage_flag" class="form_required">荷物預かり</label></td>
            <td>
              {{Form::select('luggage_flag', ['不可', '可'],$venue->luggage_flag,['placeholder' =>
              '選択してください','class'=>'custom-select mr-sm-2'])}}
              <p class="is-error-luggage_flag" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="luggage_post_code">送付先郵便番号</label></td>
            <td>
              <div class="d-flex">
                <p>{{
                  Form::text('luggage_post_code',$venue->luggage_post_code,['class'=>'form-control'])
                  }}</p>
                <button class="btn more_btn ml-1" type="button" id="luggage_post_code">住所検索</button>
              </div>
              <p class="is-error-luggage_post_code" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="luggage_address1">住所（都道府県）</label></td>
            <td>
              {{ Form::text('luggage_address1', $venue->luggage_address1, ['class' => 'form-control']) }}
              <p class="is-error-luggage_address2" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="luggage_address2">住所（市町村番地）</label></td>
            <td>
              {{ Form::text('luggage_address2', $venue->luggage_address2, ['class' => 'form-control']) }}
              <p class="is-error-luggage_address2" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="luggage_address3">住所（建物名）</label></td>
            <td>
              {{ Form::text('luggage_address3', $venue->luggage_address3, ['class' => 'form-control']) }}
              <p class="is-error-luggage_address3" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="luggage_name">送付先名</label></td>
            <td>
              {{ Form::text('luggage_name', $venue->luggage_name, ['class' => 'form-control']) }}
              <p class="is-error-luggage_name" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="luggage_tel">電話番号</label></td>
            <td>
              {{ Form::textarea('luggage_tel', $venue->luggage_tel, ['class' => 'form-control' ]) }}
              <p class="is-error-luggage_tel" style="color: red"></p>
            </td>
          </tr>
        </tbody>
      </table>

    </div>
    <!-- 左側の項目 終わり -------------------------------------------------------------------------->


    <!-- 右側の項目 -------------------------------------------------------------------------->
    <div class="col">

      <!-- 担当者情報 ------------------------------------------------------------------------>
      <table class="table table-bordered table_fixed">
        <thead>
          <tr>
            <td colspan="3">
              <p class="title-icon">
                <i class="fas fa-user-check icon-size" aria-hidden="true"></i>予約担当者情報
              </p>
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="table-active"><label for="">会社名</label></td>
            <td colspan="2">
              {{ Form::text('reserver_company', $venue->reserver_company, ['class' => 'form-control']) }}
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="">TEL </label></td>
            <td colspan="2">
              {{ Form::text('reserver_tel', $venue->reserver_tel, ['class' => 'form-control']) }}
              <p class="is-error-reserver_tel" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="">FAX</label></td>
            <td colspan="2">
              {{ Form::text('reserver_fax', $venue->reserver_fax, ['class' => 'form-control']) }}
              <p class="is-error-reserver_fax" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="first_name">担当者氏名</label></td>
            <td>姓：
              {{ Form::text('first_name', $venue->first_name, ['class' => 'form-control']) }}
            </td>
            <td>名：
              {{ Form::text('last_name', $venue->last_name, ['class' => 'form-control']) }}
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="first_name_kana">担当者氏名（フリガナ）</label></td>
            <td>セイ：
              {{ Form::text('first_name_kana', $venue->first_name_kana, ['class' => 'form-control']) }}
              <p class="is-error-first_name_kana" style="color: red"></p>
            </td>
            <td>メイ：
              {{ Form::text('last_name_kana', $venue->last_name_kana, ['class' => 'form-control']) }}
              <p class="is-error-last_name_kana" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="person_tel">担当者電話番号</label></td>
            <td colspan="2">
              {{ Form::text('person_tel', $venue->person_tel, ['class' => 'form-control','placeholder' =>
              '半角数字、ハイフンなしで入力してください']) }}
              <p class="is-error-person_tel" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="person_email">担当者メールアドレス</label></td>
            <td colspan="2">
              {{ Form::text('person_email', $venue->person_email, ['class' => 'form-control']) }}
              <p class="is-error-person_email" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="">備考</label></td>
            <td colspan="2">
              {{ Form::textarea('reserver_remark', $venue->reserver_remark, ['class' => 'form-control']) }}
            </td>
          </tr>
        </tbody>
      </table>

      <!-- ビル管理会社情報 ------------------------------------------------------------------------>
      <table class="table table-bordered table_fixed">
        <thead>
          <tr>
            <td colspan="3">
              <p class="title-icon">
                <i class="fas fa-building icon-size" aria-hidden="true"></i>ビル管理会社
              </p>
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="table-active"><label for="mgmt_company">会社名</label></td>
            <td colspan="2">
              {{ Form::text('mgmt_company', $venue->mgmt_company, ['class' => 'form-control']) }}
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="mgmt_tel">電話番号</label></td>
            <td colspan="2">
              {{ Form::text('mgmt_tel', $venue->mgmt_tel, ['class' => 'form-control','placeholder' =>
              '半角数字、ハイフンなしで入力してください']) }}
              <p class="is-error-mgmt_tel" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="mgmt_emer_tel">夜間緊急連絡先</label></td>
            <td colspan="2">
              {{ Form::text('mgmt_emer_tel', $venue->mgmt_emer_tel, ['class' => 'form-control','placeholder' =>
              '半角数字、ハイフンなしで入力してください']) }}
              <p class="is-error-mgmt_emer_tel" style="color: red"></p>
            </td>
          </tr>

          <tr>
            <td class="table-active"><label for="mgmt_first_name">担当者氏名</label></td>
            <td>姓：
              {{ Form::text('mgmt_first_name', $venue->mgmt_first_name, ['class' => 'form-control']) }}
            </td>
            <td>名：
              {{ Form::text('mgmt_last_name', $venue->mgmt_last_name, ['class' => 'form-control']) }}
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="mgmt_person_tel">担当者電話番号</label></td>
            <td colspan="2">
              {{ Form::text('mgmt_person_tel', $venue->mgmt_person_tel, ['class' => 'form-control']) }}
              <p class="is-error-mgmt_person_tel" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="mgmt_email">担当者メール</label></td>
            <td colspan="2">
              {{ Form::text('mgmt_email', $venue->mgmt_email, ['class' => 'form-control']) }}
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="mgmt_sec_company">警備会社名</label></td>
            <td colspan="2">
              {{ Form::text('mgmt_sec_company', $venue->mgmt_sec_company, ['class' => 'form-control']) }}
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="mgmt_sec_tel">警備会社電話番号</label></td>
            <td colspan="2">
              {{ Form::text('mgmt_sec_tel', $venue->mgmt_sec_tel, ['class' => 'form-control','placeholder' =>
              '半角数字、ハイフンなしで入力してください']) }}
              <p class="is-error-mgmt_sec_tel" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="mgmt_remark">備考</label></td>
            <td colspan="2">
              {{ Form::textarea('mgmt_remark', $venue->mgmt_remark, ['class' => 'form-control']) }}
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
                <i class="fas fa-utensils icon-size" aria-hidden="true"></i>室内飲食
              </p>
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="table-active"><label for="eat_in_flag" class="form_required">室内飲食</label></td>
            <td>
              {{{Form::select('eat_in_flag', ['不可', '可'],$venue->eat_in_flag,['placeholder' => '選択してください',
              'class'=>'custom-select mr-sm-2'])}}}

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
                <i class="fas fa-th icon-size" aria-hidden="true"></i>レイアウト
              </p>
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="table-active"><label for="layout" class="form_required">レイアウト変更</label></td>
            <td>
              {{{Form::select('layout', ['不可', '可'],null,['placeholder' => '選択してください', 'class'=>'custom-select
              mr-sm-2',"id"=>"layout"])}}}
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="layout_prepare" class="">レイアウト準備料金</label><span
                class="ml-1 annotation">※税抜</span></td>
            <td>
              <div class="d-flex align-items-center">
                {{ Form::text('layout_prepare', $venue->layout_prepare, ['class' =>
                'form-control',$venue->layout_prepare==""?"readonly":""]) }}
                <span class="ml-1">円</span>
              </div>
              <p class="is-error-layout_prepare" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="layout_clean" class="">レイアウト片付料金</label><span
                class="ml-1 annotation">※税抜</span></td>
            <td>
              <div class="d-flex align-items-center">
                {{ Form::text('layout_clean', $venue->layout_clean, ['class' =>
                'form-control',$venue->layout_clean==""?"readonly":""]) }}
                <span class="ml-1">円</span>
              </div>
              <p class="is-error-layout_clean" style="color: red"></p>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- 支払データ ------------------------------------------------------------------------>
      <table class="table table-bordered cost_data {{$venue->alliance_flag==0?" hide":""}}">
        <thead>
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-yen-sign icon-size" aria-hidden="true"></i>支払データ
              </p>
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="table-active form_required"><label for="cost">支払割合（原価）</label></td>
            <td>
              <div class="d-flex align-items-center">
                {{ Form::text('cost', $venue->cost, ['class' => 'form-control']) }}
                <span class="ml-1">%</span>
              </div>
              <p class="is-error-cost" style="color: red"></p>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- 右側の項目 終わり-------------------------------------------------------------------------->
  </div>
</section>

<section class="mt-5">
  <!-- 有料備品 ------------------------------------------------------------------------>
  <div class="mb-5 border-wrap2 wrap_shadow">
    <p class="title-icon table-active fw-bolder p-2 w-100">
      <i class="fas fa-wrench icon-size" aria-hidden="true"></i>有料備品
    </p>
    <div class="p-4 bg-white">
      <ul class="option_list_ttl">
        <li>
          <h5>・選択可能一覧</h5>
          <p class="mt-2">※下部リストより該当情報をクリックすると右の「選択後画面」に反映します。</p>
        </li>
        <li>
          <h5>・選択後画面</h5>
          <p class="mt-2"><span class="caution_color">下部リストの順番通りに会場予約フォームに反映します。</span>
            <br>※削除する場合は該当情報をクリック
          </p>
        </li>
      </ul>
      <select id='equipment_id' multiple='multiple' name="equipment_id[]">
        @for ($i = 0; $i < $m_equipments->count(); $i++)
          <option value={{$m_equipments[$i]->id}} @foreach ($r_emptys as $r_empty)
            {{$m_equipments[$i]->id==$r_empty->id?"selected":""}} @endforeach>
            {{$m_equipments[$i]->id}}/{{$m_equipments[$i]->item}}/{{number_format($m_equipments[$i]->price)}}円
          </option>
          @endfor
      </select>
    </div>
  </div>

  <!-- 有料サービス ------------------------------------------------------------------------>
  <div class="mb-5 border-wrap2 wrap_shadow">
    <p class="title-icon table-active fw-bolder p-2 w-100">
      <i class="fas fa-hand-holding-heart icon-size" aria-hidden="true"></i>有料サービス
    </p>
    <div class="p-4 bg-white">
      <ul class="option_list_ttl">
        <li>
          <h5>・選択可能一覧</h5>
          <p class="mt-2">※下部リストより該当情報をクリックすると右の「選択後画面」に反映します。</p>
        </li>
        <li>
          <h5>・選択後画面</h5>
          <p class="mt-2"><span class="caution_color">下部リストの順番通りに会場予約フォームに反映します。</span>
            <br>※削除する場合は該当情報をクリック
          </p>
        </li>
      </ul>
      <select id='service_id' multiple='multiple' name="service_id[]">
        @for ($s = 0; $s < $m_services->count(); $s++)
          <option value={{$m_services[$s]->id}} @foreach ($s_emptys as $s_empty)
            {{$m_services[$s]->id==$s_empty->id?"selected":""}} @endforeach>
            {{$m_services[$s]->id}}/{{$m_services[$s]->item}}/{{number_format($m_services[$s]->price)}}円
          </option>
          @endfor
      </select>
    </div>
  </div>
</section>
<div class="mx-auto">
  {{ Form::submit('保存する', ['class' => 'mx-auto btn more_btn_lg d-block approval']) }}
  @include('layouts.admin.loading')
</div>

{{ Form::close() }}

<script>
  $('#post_code_search').on('click', function(){
    AjaxZip3.zip2addr('post_code','','address1','address2');
    
    //成功時に実行する処理
    AjaxZip3.onSuccess = function() {
      $('input[name="address1"]').click();
      $('input[name="address2"]').click();
    };
    
    //失敗時に実行する処理
    AjaxZip3.onFailure = function() {
    $('input[name="address1"]').val('');
    $('input[name="address2"]').val('');
    alert('郵便番号に該当する住所が見つかりません');
    };
    
    return false;
    });
</script>

<script>
  $('#luggage_post_code').on('click', function(){
      AjaxZip3.zip2addr('luggage_post_code','','luggage_address1','luggage_address2');
      
      //成功時に実行する処理
      AjaxZip3.onSuccess = function() {
        $('input[name="luggage_address1"]').click();
        $('input[name="luggage_address2"]').click();
      };
      
      //失敗時に実行する処理
      AjaxZip3.onFailure = function() {
      $('input[name="luggage_address1"]').val('');
      $('input[name="luggage_address2"]').val('');
      alert('郵便番号に該当する住所が見つかりません');
      };
      
      return false;
      });
</script>

@endsection