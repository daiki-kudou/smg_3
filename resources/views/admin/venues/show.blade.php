@extends('layouts.admin.app')

@section('content')
<script src="{{ asset('/js/template.js') }}"></script>
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">


<div class="container-field mt-3">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">
          {{ Breadcrumbs::render(Route::currentRouteName(),$venue->id) }}
        </li>
      </ol>
    </nav>
  </div>
  <h1 class="mt-3 mb-5">会場　詳細情報</h1>
  <div class="d-flex justify-content-end ">
    {{ link_to_route('admin.venues.edit', '編集', $parameters = $venue->id, ['class' => 'btn btn-primary'])}}
  </div>
  <hr>
</div>

<div class="container-field">
  <div class="p-3 mb-2 bg-white text-dark">
    {{ Form::label('smg_url', '会場SMG Url') }}
    <div>{{$venue->smg_url}}</div>
  </div>

  <div class="row">
    <div class="col">
      <div class="p-3 mb-2 bg-white text-dark">
        <span><i class="fas fa-info-circle"></i>ビル情報</span>
        <div class="mt-2 mb-2">
          <div>{{$venue->alliance_flag==0?"直営":'提携'}}</div>
        </div>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('name_area', 'エリア名') }}</div>
          <div class="col-sm-8">{{ $venue->name_area }}</div>
        </div>

        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('name_bldg', 'ビル名') }}</div>
          <div class="col-sm-8">{{ $venue->name_bldg }}</div>
        </div>

        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('name_venue', '会場名') }}</div>
          <div class="col-sm-8">{{ $venue->name_venue }}</div>
        </div>

        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('size1', '会場広さ（坪）') }}</div>
          <div class="col-sm-8">{{ $venue->size1 }}</div>
        </div>

        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('size2', '会場広さ（㎡）') }}</div>
          <div class="col-sm-8">{{ $venue->size2 }}</div>
        </div>

        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('capacity', '収容人数') }}</div>
          <div class="col-sm-8">{{ $venue->capacity }}</div>
        </div>

        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('post_code', '郵便番号') }}</div>
          <div class="col-sm-8">{{ $venue->post_code }}</div>
        </div>

        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('address1', '住所（都道府県）') }}</div>
          <div class="col-sm-8">{{ $venue->address1 }}</div>
        </div>

        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('address2', '住所（市町村番地）') }}</div>
          <div class="col-sm-8">{{ $venue->address2 }}</div>
        </div>

        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('address3', '住所（建物名）') }}</div>
          <div class="col-sm-8">{{ $venue->address3 }}</div>
        </div>

        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('entrance_open_time', '正面入口の開閉時間') }}</div>
          <div class="col-sm-8">{{ $venue->entrance_open_time }}</div>
        </div>

        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('backyard_open_time', '通用口の開閉時間') }}</div>
          <div class="col-sm-8">{{ $venue->backyard_open_time }}</div>
        </div>

        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('remark', '備考') }}</div>
          <div class="col-sm-8">{{ $venue->remark }}</div>
        </div>
      </div>

      <div class="p-3 mb-2 bg-white text-dark">
        <span><i class="fas fa-suitcase-rolling"></i>荷物預かり</span>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('luggage_flag', '荷物預かり　有・無') }}</div>
          <div class="col-sm-8">{{ $venue->luggage_flag==1?"有り":"無し" }}</div>
        </div>
        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('luggage_post_code', '送付先郵便番号') }}</div>
          <div class="col-sm-8">{{ $venue->luggage_post_code }}</div>
        </div>
        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('luggage_address1', '住所（都道府県）') }}</div>
          <div class="col-sm-8">{{ $venue->luggage_address1 }}</div>
        </div>
        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('luggage_address2', '住所（市町村番地）') }}</div>
          <div class="col-sm-8">{{ $venue->luggage_address2 }}</div>
        </div>
        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('luggage_address3', '住所（建物名）') }}</div>
          <div class="col-sm-8">{{ $venue->luggage_address3 }}</div>
        </div>
        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('luggage_name', '送付先名') }}</div>
          <div class="col-sm-8">{{ $venue->luggage_name }}</div>
        </div>
        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('luggage_tel', '電話番号') }}</div>
          <div class="col-sm-8">{{ $venue->luggage_tel }}</div>
        </div>

      </div>

    </div>
    <div class="col">
      <div class="p-3 mb-2 bg-white text-dark">
        <span><i class="fas fa-user-check"></i>担当者情報</span>

        <div class="row">
          <div class="col-sm-2">{{ Form::label('first_name', '氏名(姓)') }}</div>
          <div class="col-sm-4">
            {{ $venue->first_name}}
          </div>
          <div class="col-sm-2">{{ Form::label('last_name', '氏名(名)') }}</div>
          <div class="col-sm-4">
            {{ $venue->last_name}}
          </div>
        </div>
        <hr>

        <div class="row">
          <div class="col-sm-2">{{ Form::label('first_name', '氏名(セイ)') }}</div>
          <div class="col-sm-4">
            {{ $venue->first_name}}
          </div>
          <div class="col-sm-2">{{ Form::label('last_name', '氏名(メイ)') }}</div>
          <div class="col-sm-4">
            {{ $venue->last_name}}
          </div>
        </div>
        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('person_tel', '担当者電話番号') }}</div>
          <div class="col-sm-8">{{ $venue->person_tel}}</div>
        </div>
        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('person_email', '担当者メール') }}</div>
          <div class="col-sm-8">{{ $venue->person_email}}</div>
        </div>
      </div>

      <div class="p-3 mb-2 bg-white text-dark">
        <span><i class="fas fa-building"></i>ビル管理会社</span>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('mgmt_company', '会社名') }}</div>
          <div class="col-sm-8">{{ $venue->mgmt_company}}</div>
        </div>
        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('mgmt_tel', '電話番号') }}</div>
          <div class="col-sm-8">{{ $venue->mgmt_tel}}</div>
        </div>
        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('mgmt_emer_tel', '夜間緊急連絡先') }}</div>
          <div class="col-sm-8">{{ $venue->mgmt_emer_tel}}</div>
        </div>
        <hr>

        <div class="row">
          <div class="col-sm-2">{{ Form::label('mgmt_first_name', '氏名(姓)') }}</div>
          <div class="col-sm-4">
            {{ $venue-> mgmt_first_name}}
          </div>
          <div class="col-sm-2">{{ Form::label('mgmt_last_name', '氏名(名)') }}</div>
          <div class="col-sm-4">
            {{ $venue-> mgmt_last_name}}
          </div>
        </div>
        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('mgmt_email', '担当者メール') }}</div>
          <div class="col-sm-8">{{ $venue->mgmt_email}}</div>
        </div>
        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('mgmt_sec_company', '警備会社名') }}</div>
          <div class="col-sm-8">{{ $venue->mgmt_sec_company}}</div>
        </div>
        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('mgmt_sec_tel', '警備会社電話番号') }}</div>
          <div class="col-sm-8">{{ $venue->mgmt_sec_tel}}</div>
        </div>
        <hr>

        <div class="row">
          <div class="col-sm-4">{{ Form::label('mgmt_remark', '備考') }}</div>
          <div class="col-sm-8">{{ $venue->mgmt_remark}}</div>
        </div>
        <hr>
      </div>




      <div class="p-3 mb-2 bg-white text-dark">
        <span><i class="fas fa-utensils"></i>室内飲食</span>
        <div class="row">
          <div class="col-sm-4">{{ Form::label('eat_in_flag', '室内飲食') }}</div>
          <div class="col-sm-8">{{ $venue->eat_in_flag==1?"有り":"無し"}}</div>
        </div>
        <hr>
      </div>

      <div class="p-3 mb-2 bg-white text-dark">
        <span><i class="fas fa-utensils"></i>レイアウト</span>
        <div class="row">
          <div class="col-sm-4">{{ Form::label('layout', 'レイアウト変更') }}</div>
          <div class="col-sm-8">{{ $venue->layout==1?"有り":"無し"}}</div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-4">{{ Form::label('layout', 'レイアウト準備料金') }}</div>
          <div class="col-sm-8">{{ $venue->layout_prepare}}</div>
        </div>
        <div class="row">
          <div class="col-sm-4">{{ Form::label('layout', 'レイアウト変更料金') }}</div>
          <div class="col-sm-8">{{ $venue->layout_clean}}</div>
        </div>
      </div>


      <div class="p-3 mb-2 bg-white text-dark">
        <span><i class="fas fa-utensils"></i>支払データ</span>
        <div class="row">
          <div class="col-sm-4">{{ Form::label('cost', '支払割合（原価）') }}</div>
          <div class="col-sm-8">{{ $venue->cost}}%</div>
        </div>
      </div>
      <hr>
    </div>
  </div>
</div>



<div class="p-3 mb-2 bg-white text-dark">
  <span>有料備品</span>
  <div>
    <ul>
      @foreach ($equipments as $equipment)
      <li>{{$equipment->item}}</li>
      @endforeach
    </ul>
  </div>
</div>

<div class="p-3 mb-2 bg-white text-dark">
  <span>有料サービス</span>
  <div>
    <ul>
      @foreach ($services as $service)
      <li>{{$service->item}}</li>
      @endforeach
    </ul>
  </div>
</div>
</div>


<div class="p-3 mb-2 bg-white text-dark">
  <span>営業時間</span>
  <div>
    <table class="table table-bordered">
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
          <td>{{$date_venue->start}}</td>
          <td>{{$date_venue->finish}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>

  </div>
</div>


<div class="p-3 mb-2 bg-white text-dark">
  <span>料金管理</span>
  <div>
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
          <td>{{$frame_price->frame}}</td>
          <td>{{$frame_price->start}} ~ {{$date_venue->finish}}</td>
          <td>{{$frame_price->price}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div>
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
          <td>{{$time_price->time}}</td>
          <td>{{$time_price->price}} ~ {{$date_venue->finish}}</td>
          <td>{{$time_price->extend}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>









{{--


{{ Breadcrumbs::render(Route::currentRouteName(),$venue->id) }}
<h1><span class="badge badge-secondary">会場管理 詳細</span></h1>
<div class="d-inline-flex p-2 bd-highlight">
  {{ link_to_route('admin.venues.edit', '編集する', $parameters = $venue->id, ['class' => 'btn btn-primary']) }}
  {{ Form::model($venue, ['route' => ['admin.venues.destroy', $venue->id], 'method' => 'delete']) }}
  @csrf
  {{ Form::submit('削除', ['class' => 'btn btn-danger']) }}
  {{ Form::close() }}
</div>
<div class="border-bottom border-danger" style="padding:10px; margin-bottom:20px;">基本情報</div>
<div class="container">
  <div class="row">
    <div class="col-sm">
      <div class="form-group">
        <h4>SMG Url</h4>
        {{ $venue->smg_url}}
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm">
      <h3> <span class="badge badge-info">ビル情報</span></h3>
      <div class="form-group">
        <h4>直営・提携</h4>
        {{ $venue->alliance_flag==0?"直営":"提携"}}
      </div>
      <div class="form-group">
        <h4>エリア名</h4>
        {{ $venue->name_area}}
      </div>

      <div class="form-group">
        <h4>ビル名</h4>
        {{ $venue->name_bldg}}
      </div>

      <div class="form-group">
        <h4>会場名</h4>
        {{ $venue->name_venue}}
      </div>

      <div class="form-group">
        <h4>会場広さ（坪）</h4>
        {{ $venue->size1}}

      </div>

      <div class="form-group">
        <h4>会場広さ（㎡）</h4>
        {{ $venue->size2}}
      </div>

      <div class="form-group">
        <h4>収容人数</h4>
        {{ $venue->capacity}}
      </div>

      <div class="form-group">
        <h4>郵便番号</h4>
        {{ $venue->post_code}}

      </div>

      <div class="form-group">
        <h4>住所（都道府県）</h4>
        {{ $venue->address1}}
      </div>

      <div class="form-group">
        <h4>住所（市町村番地）</h4>
        {{ $venue->address2}}

      </div>

      <div class="form-group">
        <h4>住所（建物名）</h4>
        {{ $venue->address3}}
      </div>

      <div class="form-group">
        <h4>正面入口の開閉時間</h4>
        {{ $venue->entrance_open_time}}
      </div>

      <div class="form-group">
        <h4>通用口の開閉時間</h4>
        {{ $venue->backyard_open_time}}
      </div>

      <div class="form-group">
        <h4>備考</h4>
        {{ $venue->remark}}
      </div>

      <h3> <span class="badge badge-info">荷物預かり</span></h3>
      <div class="form-group">
        <h4>荷物預かり　有・無</h4>
        {{ $venue->luggage_flag}}
      </div>

      <div class="form-group">
        <h4>送付先郵便番号</h4>
        {{ $venue->luggage_post_code}}
      </div>

      <div class="form-group">
        <h4>住所（都道府県）</h4>
        {{ $venue->luggage_address1}}
      </div>

      <div class="form-group">
        <h4>住所（市町村番地）</h4>
        {{ $venue->luggage_address2}}
      </div>

      <div class="form-group">
        <h4>住所（建物名）</h4>
        {{ $venue->luggage_address3}}
      </div>

      <div class="form-group">
        <h4>送付先TEL</h4>
        {{ $venue->luggage_tel}}
      </div>

      <div class="form-group">
        <h4>送付先名</h4>
        {{ $venue->luggage_name}}
      </div>

      <h3> <span class="badge badge-info">有料備品</span></h3>
      @foreach ($r_emptys as $r_empty)
      <p> {{ $r_empty->item }} </p>
      @endforeach

      <h3> <span class="badge badge-info">有料サービス</span></h3>
      @foreach ($s_emptys as $s_empty)
      <p> {{ $s_empty->item }} </p>
      @endforeach

      <h3> <span class="badge badge-info">営業時間</span></h3>
      <table class="table">
        <tbody>
          <tr>
            <td>曜日</td>
            <td>営業時間</td>
          </tr>
          @for ($i = 1; $i <= 7; $i++) <tr>
            <td>
              {{$i==1?'月':''}}{{$i==2?'火':''}}{{$i==3?'水':''}}{{$i==4?'木':''}}{{$i==5?'金':''}}{{$i==6?'土':''}}{{$i==7?'日':''}}
            </td>
            <td>
              {{$date_venues->where('week_day',$i)->first()->start}}
              ~
              {{$date_venues->where('week_day',$i)->first()->finish}}
            </td>
            <td>
            </td>
            </tr>
            @endfor
        </tbody>
      </table>

      <h3> <span class="badge badge-info">料金体系</span></h3>
      <div>
        <h4>料金体系：枠貸し</h4>
        <p></p>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">枠</th>
              <th scope="col">時間（開始）</th>
              <th scope="col">時間（終了）</th>
              <th scope="col">料金</th>
              <th scope="col">登録日</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($frame_prices as $frame_price)
            <tr>
              <th>{{ $frame_price->frame}}</th>
              <td>{{ $frame_price->start}}</td>
              <td>{{ $frame_price->finish}}</td>
              <td>{{ $frame_price->price}}</td>
              <td>{{ $frame_price->created_at}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div>
        <h4>料金体系：時間貸</h4>
        <p></p>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">時間</th>
              <th scope="col">料金</th>
              <th scope="col">延長料金</th>
              <th scope="col">登録日</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($time_prices as $time_price)
            <tr>
              <th>{{ $time_price->time}}</th>
              <td>{{ $time_price->price}}</td>
              <td>{{ $time_price->extend}}</td>
              <td>{{ $time_price->created_at}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="col-sm">
      <h3> <span class="badge badge-info">担当者情報</span></h3>
      <div class="form-group">
        <h4>担当者氏名（姓）</h4>
        {{ $venue->first_name}}
      </div>

      <div class="form-group">
        <h4>担当者氏名（名）</h4>
        {{ $venue->last_name}}
      </div>

      <div class="form-group">
        <h4>担当者氏名カナ（姓）</h4>
        {{ $venue->first_name_kana}}
      </div>

      <div class="form-group">
        <h4>担当者氏名カナ（名）</h4>
        {{ $venue->last_name_kana}}
      </div>

      <div class="form-group">
        <h4>担当者TEL</h4>
        {{ $venue->person_tel}}
      </div>

      <div class="form-group">
        <h4>EMAIL</h4>
        {{ $venue->person_email}}
      </div>

      <h3> <span class="badge badge-info">ビル管理会社</span></h3>
      <div class="form-group">
        <h4>会社名</h4>
        {{ $venue->mgmt_company}}
      </div>

      <div class="form-group">
        <h4>電話番号</h4>
        {{ $venue->mgmt_tel}}
      </div>

      <div class="form-group">
        <h4>夜間緊急連絡先</h4>
        {{ $venue->mgmt_emer_tel}}
      </div>

      <div class="form-group">
        <h4>担当者氏名（姓）</h4>
        {{ $venue->mgmt_first_name}}
      </div>

      <div class="form-group">
        <h4>担当者氏名（名）</h4>
        {{ $venue->mgmt_last_name}}
      </div>

      <div class="form-group">
        <h4>担当者電話番号</h4>
        {{ $venue->mgmt_person_tel}}
      </div>

      <div class="form-group">
        <h4>担当者メール</h4>
        {{ $venue->mgmt_email}}
      </div>

      <div class="form-group">
        <h4>警備会社名</h4>
        {{ $venue->mgmt_sec_company}}
      </div>

      <div class="form-group">
        <h4>警備会社電話番号</h4>
        {{ $venue->mgmt_sec_tel}}
      </div>

      <div class="form-group">
        <h4>備考</h4>
        {{ $venue->mgmt_remark}}
      </div>

      <h3> <span class="badge badge-info">室内飲食</span></h3>
      <div class="form-group">
        <h4>室内飲食</h4>
        {{ $venue->eat_in_flag}}
      </div>

      <h3> <span class="badge badge-info">支払データ</span></h3>
      <div class="form-group">
        <h4>支払割合（原価）</h4>
        {{ $venue->cost}}
      </div>
    </div>
  </div>
</div> --}}
@endsection