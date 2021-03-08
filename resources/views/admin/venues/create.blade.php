@extends('layouts.admin.app')
@section('content')
<script src="{{ asset('/js/admin/validation.js') }}"></script>
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/admin/reservation.js') }}"></script>

<style>
  .hide {
    display: none !important;
  }
</style>
<div class="errors">
  @if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif
</div>



{{ Form::open(['url' => 'admin/venues', 'method'=>'POST', 'id'=>'VenuesCreateForm']) }}
@csrf

<div class="container-field">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">
          {{ Breadcrumbs::render(Route::currentRouteName()) }}
        </li>
      </ol>
    </nav>
  </div>

  <h2 class="mt-3 mb-3">会場 新規登録</h2>
  <hr>

  <div class="errors">
  </div>

  <section class="section-wrap">

    <!-- 会場URL ---------------------------------------------------->
    <p class="text-right">※金額は税抜で入力してください。</p>
    <div class="row">
      <div class="col">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td class="table-active"><label for="smg_url" class="form_required">会場SMG URL</label></td>
              <td>
                {{ Form::text('smg_url', old('smg_url'), ['class' => 'form-control', 'placeholder'=>"https://osaka-conference.com/rental/t6-maronie/hall/"]) }}
                <p class="is-error-smg_url" style="color: red"></p>
              </td>
            </tr>
          </tbody>
        </table>
        </form>
      </div>
    </div>

    <div class="row">
      <div class="col">
        <table class="table table-bordered venue_table">
          <thead>
            <tr>
              <td colspan="2">
                <p class="title-icon">
                  <i class="fas fa-exclamation-circle icon-size fa-fw" aria-hidden="true"></i>基本情報
                </p>
              </td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th class="table-active form_required" id="alliance_flag">ビル情報</th>
              <td class="d-flex">
                <p class="mr-3">
                  {{ Form::label('alliance_flag', '直営') }}
                  {{Form::radio('alliance_flag', '0',true)}}
                </p>
                <p>
                  {{ Form::label('alliance_flag', '提携')}}
                  {{Form::radio('alliance_flag', '1')}}
                </p>
                <p class="is-error-alliance_flag" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="name_area" class="form_required">エリア名</label></td>
              <td>
                {{ Form::text('name_area', old('name_area'), ['class' => 'form-control','required', 'placeholder'=>'四ツ橋']) }}
                <p class="is-error-name_area" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="name_bldg" class="form_required">ビル名</label></td>
              <td>
                {{ Form::text('name_bldg', old('name_bldg'), ['class' => 'form-control', 'placeholder'=>'サンワールドビル']) }}
                <p class="is-error-name_bldg" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="name_venue" class="form_required">会場名</label></td>
              <td>
                {{ Form::text('name_venue', old('name_venue'), ['class' => 'form-control', 'placeholder'=>'１号室']) }}
                <p class="is-error-name_venue" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="size1" class="form_required">会場広さ（坪）</label></td>
              <td>
                {{ Form::text('size1', old('size1'), ['placeholder' => '半角英数字で入力してください','class' => 'form-control']) }}
                <p class="is-error-size1" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="size2" class="form_required">会場広さ（㎡）</label></td>
              <td>
                {{ Form::text('size2', old('size2'), ['placeholder' => '半角英数字で入力してください','class' => 'form-control']) }}
                <p class="is-error-size2" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="capacity" class="form_required">収容人数</label></td>
              <td>
                {{ Form::text('capacity', old('capacity'), ['placeholder' => '半角英数字で入力してください','class' => 'form-control']) }}
                <p class="is-error-capacity" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="post_code" class="form_required">郵便番号</label></td>
              <td>
                {{ Form::text('post_code', old('post_code'), [
                  'class' => 'form-control',
                  'onKeyUp'=>"AjaxZip3.zip2addr(this,'','address1','address2');",
                  'autocomplete'=>'off',
                  'placeholder' => '半角英数字で入力してください'
                  ]) }}
                <p class="is-error-post_code" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="address1" class="form_required">住所（都道府県）</label></td>
              <td>
                {{ Form::text('address1', old('address1'), ['placeholder' => '大阪府','class' => 'form-control search_address2']) }}

                <p class="is-error-address1" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="address2" class="form_required">住所（市町村番地）</label></td>
              <td>
                {{ Form::text('address2', old('address2'), ['placeholder' => '大阪市北堀江1-23-1','class' => 'form-control search_address3']) }}
                <p class="is-error-address2" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="address3" class="form_required">住所（建物名）</label></td>
              <td>
                {{ Form::text('address3', old('address3'), ['placeholder' => '四ツ橋サンワールドビル','class' => 'form-control']) }}
                <p class="is-error-address3" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="entrance_open_time">正面入口の開閉時間</label></td>
              <td>
                {{ Form::text('entrance_open_time', old('entrance_open_time'), ['class' => 'form-control']) }}
                <p class="is-error-backyard_open_time" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="backyard_open_time">通用口の開閉時間</label></td>
              <td>
                {{ Form::text('backyard_open_time', old('backyard_open_time'), ['class' => 'form-control']) }}
                <p class="is-error-entrance_open_time" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="remark">備考</label></td>
              <td>
                {{ Form::textarea('remark', old('remark'), ['class' => 'form-control']) }}
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
                  <i class="fas fa-suitcase-rolling icon-size fa-fw" aria-hidden="true"></i>荷物預かり
                </p>
              </td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="table-active"><label for="luggage_flag" class="form_required">荷物預かり　有・無</label></td>
              <td>
                {{Form::select('luggage_flag', ['無し', '有り'],0,['placeholder' => '選択してください','class'=>'custom-select mr-sm-2'])}}
                <p class="is-error-luggage_flag" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="luggage_post_code">送付先郵便番号</label></td>
              <td>
                {{ Form::text('luggage_post_code', old('luggage_post_code'), [
                  'class' => 'form-control',
                  'onKeyUp'=>"AjaxZip3.zip2addr(this,'','luggage_address1','luggage_address2');",
                  'autocomplete'=>'off',
                  'placeholder' => '半角英数字で入力してください'
                  ]) }}
                <p class="is-error-luggage_post_code" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="luggage_address1">住所（都道府県）</label></td>
              <td>
                {{ Form::text('luggage_address1', old('luggage_address1'), ['class' => 'form-control','placeholder' => '大阪府']) }}
                <p class="is-error-luggage_address2" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="luggage_address2">住所（市町村番地）</label></td>
              <td>
                {{ Form::text('luggage_address2', old('luggage_address2'), ['class' => 'form-control','placeholder' => '大阪市北堀江1-23-1']) }}
                <p class="is-error-luggage_address2" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="luggage_address3">住所（建物名）</label></td>
              <td>
                {{ Form::text('luggage_address3', old('luggage_address3'), ['class' => 'form-control','placeholder' => '四ツ橋サンワールドビル']) }}
                <p class="is-error-luggage_address3" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="luggage_name">送付先名</label></td>
              <td>
                {{ Form::text('luggage_name', old('luggage_name'), ['class' => 'form-control','placeholder' => '入力してください']) }}
                <p class="is-error-luggage_name" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="luggage_tel">電話番号</label></td>
              <td>
                {{ Form::text('luggage_tel', old('luggage_tel'), ['class' => 'form-control','placeholder' => '半角英数字で入力してください', 'maxlength'=>'13']) }}
                <p class="is-error-capacity" style="color: red"></p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="col">
        <table class="table table-bordered table_fixed">
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
            <tr>
              <td class="table-active"><label for="first_name">担当者氏名</label></td>
              <td>姓：
                {{ Form::text('first_name', old('first_name'), ['class' => 'form-control']) }}
              </td>
              <td>名：
                {{ Form::text('last_name', old('last_name'), ['class' => 'form-control']) }}
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="first_name_kana">担当者氏名（フリガナ）</label></td>
              <td>セイ：
                {{ Form::text('first_name_kana', old('first_name_kana'), ['class' => 'form-control']) }}
                <!-- <p class="is-error-first_name_kana" style="color: red"></p> -->
              </td>
              <td>メイ：
                {{ Form::text('last_name_kana', old('last_name_kana'), ['class' => 'form-control']) }}
                <!-- <p class="is-error-last_name_kana" style="color: red"></p> -->
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="person_tel">担当者電話番号</label></td>
              <td colspan="2">
                {{ Form::text('person_tel', old('person_tel'), ['class' => 'form-control', 'maxlength'=>'13']) }}
                <p class="is-error-person_tel" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="person_email">担当者メールアドレス</label></td>
              <td colspan="2">
                {{ Form::text('person_email', old('person_email'), ['class' => 'form-control']) }}
                <p class="is-error-person_email" style="color: red"></p>
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
                  <i class="fas fa-building icon-size fa-fw" aria-hidden="true"></i>ビル管理会社
                </p>
              </td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="table-active"><label for="mgmt_company">会社名</label></td>
              <td colspan="2">
                {{ Form::text('mgmt_company', old('mgmt_company'), ['class' => 'form-control']) }}
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="mgmt_tel">電話番号</label></td>
              <td colspan="2">
                {{ Form::text('mgmt_tel', old('mgmt_tel'), ['class' => 'form-control', 'maxlength'=>'13']) }}
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="mgmt_emer_tel">夜間緊急連絡先</label></td>
              <td colspan="2">
                {{ Form::text('mgmt_emer_tel', old('mgmt_emer_tel'), ['class' => 'form-control', 'maxlength'=>'13']) }}
              </td>
            </tr>

            <!-- 工藤さんに確認　顧客の新規登録のデータをピックアップ問題ないか -->
            <tr>
              <td class="table-active"><label for="mgmt_first_name">担当者氏名</label></td>
              <td>姓：
                {{ Form::text('mgmt_first_name', old('mgmt_first_name'), ['class' => 'form-control']) }}
              </td>
              <td>名：
                {{ Form::text('mgmt_last_name', old('mgmt_last_name'), ['class' => 'form-control']) }}
              </td>
            </tr>
            <!-- 工藤さんに確認　顧客の新規登録のデータをピックアップ問題ないか -->

            <tr>
              <td class="table-active"><label for="mgmt_email">担当者メール</label></td>
              <td colspan="2">
                {{ Form::text('mgmt_email', old('mgmt_email'), ['class' => 'form-control']) }}
                <p class="is-error-mgmt_email" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="mgmt_sec_company">警備会社名</label></td>
              <td colspan="2">
                {{ Form::text('mgmt_sec_company', old('mgmt_sec_company'), ['class' => 'form-control']) }}
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="mgmt_sec_tel">警備会社電話番号</label></td>
              <td colspan="2">
                {{ Form::text('mgmt_sec_company', old('mgmt_sec_company'), ['class' => 'form-control', 'maxlength'=>'13']) }}
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="mgmt_remark">備考</label></td>
              <td colspan="2">
                {{ Form::textarea('mgmt_remark', old('mgmt_remark'), ['class' => 'form-control']) }}
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
              <td class="table-active"><label for="eat_in_flag" class="form_required">室内飲食</label></td>
              <td>
                {{{Form::select('eat_in_flag', ['無し', '有り'],0,['placeholder' => '選択してください', 'class'=>'custom-select mr-sm-2'])}}}
                <p class="is-error-eat_in_flag" style="color: red"></p>
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
              <td class="table-active"><label for="layout" class="form_required">レイアウト変更</label></td>
              <td>
                {{{Form::select('layout', ['無し', '有り'],0,['placeholder' => '選択してください', 'class'=>'custom-select mr-sm-2'])}}}
                <p class="is-error-layout" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="layout_prepare" class="">レイアウト準備料金</label></td>
              <td>
                {{ Form::text('layout_prepare', old('layout_prepare'), ['class' => 'form-control']) }}
                <p class="is-error-layout" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="layout_clean" class="">レイアウト片付料金</label></td>
              <td>
                {{ Form::text('layout_clean', old('layout_clean'), ['class' => 'form-control']) }}
                <p class="is-error-layout" style="color: red"></p>
              </td>
            </tr>
          </tbody>
        </table>

        <!-- 支払データ ------------------------------------------------------------------------>
        <table class="table table-bordered cost_data hide">
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
                <div class="d-flex align-items-center">
                  {{ Form::text('cost', old('cost'), ['class' => 'form-control']) }}
                  <span class="ml-1">%</span>
                </div>
                <p class="is-error-cost" style="color: red"></p>
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
    <div class="mb-5">
      <p class="title-icon table-active fw-bolder p-2 mb-2">
        <i class="fas fa-wrench icon-size fa-fw" aria-hidden="true"></i>有料備品
      </p>
      <div>
        <p>※左部リストよりクリックで選択し右部リストに移動させてください</p>
      </div>
      <select id='equipment_id' multiple='multiple' name="equipment_id[]">
        @for ($i = 0; $i < $equipments->count(); $i++)
          <option value={{$i_equipments[$i]}}>{{$s_equipments[$i]}}</option>
          @endfor
      </select>
    </div>

    <!-- 有料サービス ------------------------------------------------------------------------>
    <div>
      <p class="title-icon table-active fw-bolder p-2 mb-2">
        <i class="fas fa-hand-holding-heart icon-size fa-fw" aria-hidden="true"></i>有料サービス
      </p>
      <div>
        <span>※左部リストよりクリックで選択し右部リストに移動させてください</span>
      </div>
      <select id='service_id' multiple='multiple' name="service_id[]">
        @for ($i = 0; $i < $services->count(); $i++)
          <option value={{$i_services[$i]}}>{{$s_services[$i]}}</option>
          @endfor
      </select>
    </div>
  </section>
  <div class="mx-auto">
    {{ Form::submit('登録する', ['class' => 'mx-auto btn more_btn_lg d-block approval']) }}
    @include('layouts.admin.loading')
  </div>
</div>
{{ Form::close() }}
@endsection