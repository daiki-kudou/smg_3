@extends('layouts.admin.app')
@section('content')
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/validation.js') }}"></script>
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">

<div class="container-field mt-3">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">{{ Breadcrumbs::render(Route::currentRouteName()) }}</li>
      </ol>
    </nav>
  </div>
  <h1 class="mt-3 mb-5">会場　新規登録</h1>
  <hr>
</div>
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
<div class="container-field">
  {{ Form::open(['url' => 'admin/venues', 'method'=>'POST', 'id'=>'VenuesCreateForm']) }}
  @csrf
  <div class="p-3 mb-2 bg-white text-dark">
    {{ Form::label('smg_url', '会場SMG URL',['class' => 'form_required']) }}
    {{ Form::text('smg_url', old('smg_url'), ['class' => 'form-control', 'required', 'placeholder'=>"https://osaka-conference.com/rental/t6-maronie/hall/"]) }}
    <p class="is-error-smg_url" style="color: red"></p>
  </div>
  <div class="row">
    <div class="col">
      <div class="p-3 mb-2 bg-white text-dark">
        <div class="row">
          <span class="form_required col-sm-4" id="alliance_flag"><i class="fas fa-info-circle"></i>ビル情報</span>
          <div class="mt-2 mb-2 col-sm-8">
            {{ Form::label('alliance_flag', '直営') }}
            {{Form::radio('alliance_flag', '0',true)}}
            <br>
            {{ Form::label('alliance_flag', '提携')}}
            {{Form::radio('alliance_flag', '1')}}
            <p class="is-error-alliance_flag" style="color: red"></p>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-4">{{ Form::label('name_area', 'エリア名',['class' => 'form_required']) }}
          </div>
          <div class="col-sm-8">
            {{ Form::text('name_area', old('name_area'), ['class' => 'form-control','required', 'placeholder'=>'四ツ橋']) }}
            <p class="is-error-name_area" style="color: red"></p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-4">{{ Form::label('name_bldg', 'ビル名',['class' => 'form_required']) }}
          </div>
          <div class="col-sm-8">
            {{ Form::text('name_bldg', old('name_bldg'), ['class' => 'form-control', 'placeholder'=>'サンワールドビル']) }}
            <p class="is-error-name_bldg" style="color: red"></p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-4">{{ Form::label('name_venue', '会場名',['class' => 'form_required']) }}
          </div>
          <div class="col-sm-8">
            {{ Form::text('name_venue', old('name_venue'), ['class' => 'form-control', 'placeholder'=>'１号室']) }}
            <p class="is-error-name_venue" style="color: red"></p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-4">{{ Form::label('size1', '会場広さ（坪）',['class' => 'form_required']) }}</div>
          <div class="col-sm-8">
            {{ Form::text('size1', old('size1'), ['placeholder' => '半角英数字で入力してください','class' => 'form-control']) }}
            <p class="is-error-size1" style="color: red"></p>
          </div>

        </div>
        <hr>
        <div class="row">
          <div class="col-sm-4">{{ Form::label('size2', '会場広さ（㎡）',['class' => 'form_required']) }}</div>
          <div class="col-sm-8">
            {{ Form::text('size2', old('size2'), ['placeholder' => '半角英数字で入力してください','class' => 'form-control']) }}
            <p class="is-error-size2" style="color: red"></p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-4">{{ Form::label('capacity', '収容人数',['class' => 'form_required']) }}</div>
          <div class="col-sm-8">
            {{ Form::text('capacity', old('capacity'), ['placeholder' => '半角英数字で入力してください','class' => 'form-control']) }}
            <p class="is-error-capacity" style="color: red"></p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-4">{{ Form::label('post_code', '郵便番号',['class' => 'form_required']) }}</div>
          <div class="col-sm-8"> {{ Form::text('post_code', old('post_code'), [
            'class' => 'form-control',
            'onKeyUp'=>"AjaxZip3.zip2addr(this,'','address1','address2');",
            'autocomplete'=>'off',
            'placeholder' => '半角英数字で入力してください'
            ]) }}
            <p class="is-error-post_code" style="color: red"></p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-4">{{ Form::label('address1', '住所（都道府県）',['class' => 'form_required']) }}</div>
          <div class="col-sm-8">
            {{ Form::text('address1', old('address1'), ['placeholder' => '大阪府','class' => 'form-control search_address2']) }}
            <p class="is-error-address1" style="color: red"></p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-4">{{ Form::label('address2', '住所（市町村番地）',['class' => 'form_required'])}}</div>
          <div class="col-sm-8">
            {{ Form::text('address2', old('address2'), ['placeholder' => '大阪市北堀江1-23-1','class' => 'form-control search_address3']) }}
            <p class="is-error-address2" style="color: red"></p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-4">{{ Form::label('address3', '住所（建物名）',['class' => 'form_required']) }}</div>
          <div class="col-sm-8">
            {{ Form::text('address3', old('address3'), ['placeholder' => 'プレサンスビル703号室','class' => 'form-control']) }}
            <p class="is-error-address3" style="color: red"></p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-4">{{ Form::label('entrance_open_time', '正面入口の開閉時間') }}</div>
          <div class="col-sm-8">
            {{ Form::text('entrance_open_time', old('entrance_open_time'), ['class' => 'form-control']) }}
            <p class="is-error-entrance_open_time" style="color: red"></p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-4">{{ Form::label('backyard_open_time', '通用口の開閉時間') }}</div>
          <div class="col-sm-8">
            {{ Form::text('backyard_open_time', old('backyard_open_time'), ['class' => 'form-control']) }}
            <p class="is-error-backyard_open_time" style="color: red"></p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-4">{{ Form::label('remark', '備考') }}</div>
          <div class="col-sm-8">
            {{ Form::textarea('remark', old('remark'), ['class' => 'form-control']) }}
            <p class="is-error-remark" style="color: red"></p>
          </div>
        </div>
      </div>
      <div class="p-3 mb-2 bg-white text-dark">
        <span><i class="fas fa-suitcase-rolling"></i>荷物預かり</span>
        <div class="row">
          <div class="col-sm-4">{{ Form::label('luggage_flag', '荷物預かり　有・無',['class' => 'form_required']) }}</div>
          <div class="col-sm-8">
            {{Form::select('luggage_flag', ['無し', '有り'],0,['placeholder' => '選択してください','class'=>'custom-select mr-sm-2'])}}
            <p class="is-error-luggage_flag" style="color: red"></p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-4">{{ Form::label('luggage_post_code', '送付先郵便番号',['class' => 'form_required']) }}</div>
          <div class="col-sm-8"> {{ Form::text('luggage_post_code', old('luggage_post_code'), [
            'class' => 'form-control',
            'onKeyUp'=>"AjaxZip3.zip2addr(this,'','luggage_address1','luggage_address2');",
            'autocomplete'=>'off',
            'placeholder' => '半角英数字で入力してください'
            ]) }}
            <p class="is-error-luggage_post_code" style="color: red"></p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-4">{{ Form::label('luggage_address1', '住所（都道府県）',['class' => 'form_required']) }}</div>
          <div class="col-sm-8">
            {{ Form::text('luggage_address1', old('luggage_address1'), ['class' => 'form-control','placeholder' => '大阪府']) }}
            <p class="is-error-luggage_address1" style="color: red"></p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-4">{{ Form::label('luggage_address2', '住所（市町村番地）',['class' => 'form_required']) }}</div>
          <div class="col-sm-8">
            {{ Form::text('luggage_address2', old('luggage_address2'), ['class' => 'form-control','placeholder' => '大阪市北堀江1-23-1']) }}
            <p class="is-error-luggage_address2" style="color: red"></p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-4">{{ Form::label('luggage_address3', '住所（建物名）',['class' => 'form_required']) }}</div>
          <div class="col-sm-8">
            {{ Form::text('luggage_address3', old('luggage_address3'), ['class' => 'form-control','placeholder' => 'プレサンスビル703号室']) }}
            <p class="is-error-luggage_address3" style="color: red"></p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-4">{{ Form::label('luggage_name', '送付先名',['class' => 'form_required']) }}</div>
          <div class="col-sm-8">
            {{ Form::text('luggage_name', old('luggage_name'), ['class' => 'form-control','placeholder' => '入力してください']) }}
            <p class="is-error-luggage_name" style="color: red"></p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-4">{{ Form::label('luggage_tel', '電話番号',['class' => 'form_required']) }}</div>
          <div class="col-sm-8">
            {{ Form::text('luggage_tel', old('luggage_tel'), ['class' => 'form-control','placeholder' => '半角英数字で入力してください', 'maxlength'=>'13']) }}
            <p class="is-error-luggage_tel" style="color: red"></p>
          </div>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="p-3 mb-2 bg-white text-dark">
        <span><i class="fas fa-user-check"></i>担当者情報</span>
        <div class="row">
          <div class="col-sm-2">{{ Form::label('first_name', '氏名(姓)') }}</div>
          <div class="col-sm-4">
            {{ Form::text('first_name', old('first_name'), ['class' => 'form-control']) }}
          </div>
          <div class="col-sm-2">{{ Form::label('last_name', '氏名(名)') }}</div>
          <div class="col-sm-4">
            {{ Form::text('last_name', old('last_name'), ['class' => 'form-control']) }}
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-2">{{ Form::label('first_name', '氏名(セイ)') }}</div>
          <div class="col-sm-4">
            {{ Form::text('first_name_kana', old('first_name_kana'), ['class' => 'form-control']) }}
            <p class="is-error-first_name_kana" style="color: red"></p>
          </div>
          <div class="col-sm-2">{{ Form::label('last_name', '氏名(メイ)') }}</div>
          <div class="col-sm-4">
            {{ Form::text('last_name_kana', old('last_name_kana'), ['class' => 'form-control']) }}
            <p class="is-error-last_name_kana" style="color: red"></p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-4">{{ Form::label('person_tel', '担当者電話番号') }}</div>
          <div class="col-sm-8">
            {{ Form::text('person_tel', old('person_tel'), ['class' => 'form-control', 'maxlength'=>'13']) }}
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-4">{{ Form::label('person_email', '担当者メール') }}</div>
          <div class="col-sm-8">
            {{ Form::text('person_email', old('person_email'), ['class' => 'form-control']) }}
            <p class="is-error-person_email" style="color: red"></p>
          </div>
        </div>
      </div>
      <div class="p-3 mb-2 bg-white text-dark">
        <span><i class="fas fa-building"></i>ビル管理会社</span>
        <div class="row">
          <div class="col-sm-4">{{ Form::label('mgmt_company', '会社名') }}</div>
          <div class="col-sm-8">
            {{ Form::text('mgmt_company', old('mgmt_company'), ['class' => 'form-control']) }}
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-4">{{ Form::label('mgmt_tel', '電話番号') }}</div>
          <div class="col-sm-8">
            {{ Form::text('mgmt_tel', old('mgmt_tel'), ['class' => 'form-control', 'maxlength'=>'13']) }}
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-4">{{ Form::label('mgmt_emer_tel', '夜間緊急連絡先') }}</div>
          <div class="col-sm-8">
            {{ Form::text('mgmt_emer_tel', old('mgmt_emer_tel'), ['class' => 'form-control', 'maxlength'=>'13']) }}
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-2">{{ Form::label('mgmt_first_name', '氏名(姓)') }}</div>
          <div class="col-sm-4">
            {{ Form::text('mgmt_first_name', old('mgmt_first_name'), ['class' => 'form-control']) }}
          </div>
          <div class="col-sm-2">{{ Form::label('mgmt_last_name', '氏名(名)') }}</div>
          <div class="col-sm-4">
            {{ Form::text('mgmt_last_name', old('mgmt_last_name'), ['class' => 'form-control']) }}
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-4">{{ Form::label('mgmt_email', '担当者メール') }}</div>
          <div class="col-sm-8">
            {{ Form::text('mgmt_email', old('mgmt_email'), ['class' => 'form-control']) }}
            <p class="is-error-mgmt_email" style="color: red"></p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-4">{{ Form::label('mgmt_sec_company', '警備会社名') }}</div>
          <div class="col-sm-8">
            {{ Form::text('mgmt_sec_company', old('mgmt_sec_company'), ['class' => 'form-control']) }}
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-4">{{ Form::label('mgmt_sec_tel', '警備会社電話番号') }}</div>
          <div class="col-sm-8">
            {{ Form::text('mgmt_sec_company', old('mgmt_sec_company'), ['class' => 'form-control', 'maxlength'=>'13']) }}
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-4">{{ Form::label('mgmt_remark', '備考') }}</div>
          <div class="col-sm-8">
            {{ Form::textarea('mgmt_remark', old('mgmt_remark'), ['class' => 'form-control']) }}
          </div>
        </div>
        <hr>
      </div>
      <div class="p-3 mb-2 bg-white text-dark">
        <span><i class="fas fa-utensils"></i>室内飲食</span>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('eat_in_flag', '室内飲食',['class' => 'form_required']) }}</div>
          <div class="col-sm-8">
            {{{Form::select('eat_in_flag', ['無し', '有り'],0,['placeholder' => '選択してください', 'class'=>'custom-select mr-sm-2'])}}}
            <p class="is-error-eat_in_flag" style="color: red"></p>
          </div>
        </div>
        <hr>
      </div>
      <div class="p-3 mb-2 bg-white text-dark">
        <span>レイアウト</span>
        <div class="row">
          <div class="col-sm-4">{{ Form::label('layout', 'レイアウト変更',['class' => 'form_required']) }}</div>
          <div class="col-sm-8">
            {{{Form::select('layout', ['無し', '有り'],0,['placeholder' => '選択してください', 'class'=>'custom-select mr-sm-2'])}}}
            <p class="is-error-layout" style="color: red"></p>

          </div>
        </div>
        <hr>
        <div class="p-3 mb-2 bg-white text-dark">
          <div class="row">
            <div class="col-sm-4">{{ Form::label('layout_prepare', 'レイアウト準備料金',['class' => '']) }}</div>
            <div class="col-sm-8">
              {{ Form::text('layout_prepare', old('layout_prepare'), ['class' => 'form-control']) }}
            </div>
          </div>
        </div>
        <div class="p-3 mb-2 bg-white text-dark">
          <div class="row">
            <div class="col-sm-4">{{ Form::label('layout_clean', 'レイアウト変更料金',['class' => '']) }}</div>
            <div class="col-sm-8">
              {{ Form::text('layout_clean', old('layout_clean'), ['class' => 'form-control']) }}
            </div>
          </div>
        </div>
      </div>
      <div class="p-3 mb-2 bg-white text-dark">
        <span><i class="fas fa-utensils"></i>支払データ</span>
        <div class="row">
          <div class="col-sm-4">{{ Form::label('cost', '支払割合（原価）') }}</div>
          <div class="col-sm-8">
            {{ Form::text('cost', old('cost'), ['class' => 'form-control']) }}
          </div>
        </div>
        <hr>
      </div>
    </div>
  </div>
</div>
</div>
</div>
<div class="p-3 mb-2 bg-white text-dark">
  <span>有料備品</span>
  <div>
    <span>※左部リストよりクリックで選択し右部リストに移動させてください</span>
  </div>
  <select id='equipment_id' multiple='multiple' name="equipment_id[]">
    @for ($i = 0; $i < $equipments->count(); $i++)
      <option value={{$i_equipments[$i]}}>{{$s_equipments[$i]}}</option>
      @endfor
  </select>
</div>
<div class="p-3 mb-2 bg-white text-dark">
  <span>有料サービス</span>
  <div>
    <span>※左部リストよりクリックで選択し右部リストに移動させてください</span>
  </div>
  <select id='service_id' multiple='multiple' name="service_id[]">
    @for ($i = 0; $i < $services->count(); $i++)
      <option value={{$i_services[$i]}}>{{$s_services[$i]}}</option>
      @endfor
  </select>
</div>
<div class="mx-auto" style="width: 100px;">
  {{ Form::submit('登録', ['class' => 'btn btn-primary mb-5 mt-5']) }}
</div>
{{ Form::close() }}
</div>




@endsection