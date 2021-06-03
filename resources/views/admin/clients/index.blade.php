@extends('layouts.admin.app')

@section('content')
<script src="{{ asset('/js/tablesorter/jquery.tablesorter.js') }}"></script>
<link href="{{ asset('/css/tablesorter/theme.default.min.css') }}" rel="stylesheet">
<script src="{{ asset('/js/admin/validation.js') }}"></script>

{{-- <script src="{{ asset('/js/admin/venue.js') }}"></script> --}}
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">


<style>
  .form-inline {
    display: block;
  }

  .row {
    display: block;
    display: -ms-flexbox;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: 0px;
    margin-left: 0px;
  }

  table.dataTable thead .sorting:after,
  table.dataTable thead .sorting_asc:after,
  table.dataTable thead .sorting_desc:after {
    opacity: 0.2;
    content: "↑↓";
  }
</style>


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
  <h2 class="mt-3 mb-3">顧客管理　一覧</h2>
  <hr>

  <!-- 検索-------------------------------------------------------- -->
  {{Form::open(['url' => 'admin/clients', 'method' => 'GET', 'id'=>'clients_search'])}}
  @csrf

  <div class="search-wrap">
    <table class="table table-bordered">
      <tbody>
        <tr>
          <th class="search_item_name"><label for="id">顧客ID</label></th>
          <td class="text-right form-group">
            {{Form::text("search_id", $request->search_id?:'', ['class'=>'form-control'])}}
            <p class="is-error-id" style="color: red"></p>
          </td>
          <th class="search_item_name"><label for="company">会社名　団体名</label></th>
          <td class="text-right form-group">
            {{Form::text("search_company", $request->search_company?:'', ['class'=>'form-control'])}}
          </td>
        </tr>
        <tr>
          <th class="search_item_name"><label for="person_name">担当者</label></th>
          <td class="text-right">
            <dd>
              {{Form::text('search_person',$request->search_person?:'',['class'=>'form-control'])}}
          </td>
          <th class="search_item_name"><label for="mobile">携帯電話</label></th>
          <td class="text-right">
            {{Form::text("search_mobile",$request->search_mobile?:'', ['class'=>'form-control','id'=>''])}}
            <p class="is-error-search_mobile" style="color: red"></p>
          </td>
        </tr>
        <tr>
          <th class="search_item_name"><label for="tel">固定電話</label></th>
          <td class="text-right">
            {{Form::text("search_tel",$request->search_tel?:'', ['class'=>'form-control','id'=>''])}}
            <p class="is-error-search_tel" style="color: red"></p>
          </td>
          <th class="search_item_name"><label for="email">担当者メールアドレス</label></th>
          <td class="text-right">
            <dd>
              {{Form::text("search_email",$request->search_email?:'', ['class'=>'form-control','id'=>''])}}
              <p class="is-error-search_email" style="color: red"></p>
          </td>
        </tr>
        <tr>
          <th class="search_item_name"><label for="attention">注意事項</label></th>
          <td class="text-left">
            <ul class="search_category">
              <li>
                {{Form::radio('attention', 1, $request->attention==1?true:false,['id'=>'chk_atten'])}}
                {{Form::label("chk_atten","あり")}}
              </li>
              <li>
                {{Form::radio('attention', 2, $request->attention==2?true:false,['id'=>'chk_atten_no'])}}
                {{Form::label("chk_atten_no","なし")}}
              </li>
            </ul>
          </td>
          <th class="search_item_name"><label for="id">フリーワード検索</label></th>
          <td>
            <input type="text" name="freeword" class="form-control" id="freeword">
          </td>
        </tr>
        <tr>
          <th class="search_item_name"><label for="personStatus">顧客属性</label></th>
          <td colspan="3">
            <ul class="search_category">
              <li>
                {{Form::checkbox('attr1', 1, !empty($request->attr1)?true:false,['id'=>'attr1'])}}
                {{Form::label("attr1","一般企業")}}
              </li>
              <li>
                {{Form::checkbox('attr2', 2, !empty($request->attr2)?true:false,['id'=>'attr2'])}}
                {{Form::label("attr2","上場企業")}}
              </li>
              <li>
                {{Form::checkbox('attr3', 3, !empty($request->attr3)?true:false,['id'=>'attr3'])}}
                {{Form::label("attr3","近隣利用")}}
              </li>
              <li>
                {{Form::checkbox('attr4', 4, !empty($request->attr4)?true:false,['id'=>'attr4'])}}
                {{Form::label("attr4","個人講師")}}
              </li>
              <li>
                {{Form::checkbox('attr5', 5, !empty($request->attr5)?true:false,['id'=>'attr5'])}}
                {{Form::label("attr5","MLM")}}
              </li>
              <li>
                {{Form::checkbox('attr6', 6, !empty($request->attr6)?true:false,['id'=>'attr6'])}}
                {{Form::label("attr6","仲介会社")}}
              </li>
              <li>
                {{Form::checkbox('attr7', 7, !empty($request->attr7)?true:false,['id'=>'attr7'])}}
                {{Form::label("attr7","その他")}}
              </li>
            </ul>
          </td>
        </tr>
      </tbody>
    </table>
    <p class="text-left">
      ※フリーワード検索は本画面表記の項目のみ対象となります<br>
      ※担当者氏名の検索時は、フルネーム時はスペース禁止
    </p>

    <div class="btn_box d-flex justify-content-center">
      <a href="{{url("admin/clients")}}" class="btn reset_btn">リセット</a>
      {{Form::submit('検索', ['class'=>'btn btn-info search_btn', 'id'=>''])}}
    </div>
  </div>
  {{Form::close()}}

  <!-- 検索　終わり------------------------------------------------ -->

  <div class="table-wrap">
    <table class="table table-bordered table-scroll" id="client_sort">
      <thead>
        <tr class="table_row">
          <th>注意事項</th>
          <th>顧客ID</th>
          <th>会社名・団体名</th>
          <th>顧客属性</th>
          <th>担当者</th>
          <th>携帯電話</th>
          <th>固定電話</th>
          <th>担当者メールアドレス</th>
          <th>詳細</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($querys as $query)
        <tr role="row" class="even">
          <td class="text-center">{{$query->attention!=null?'●':''}}</td>
          <td>{{ReservationHelper::fixId($query->id)}}</td>
          <td>{{$query->company}}</td>
          <td>
            @if ($query->attr==1)
            一般企業
            @elseif($query->attr==2)
            上場企業
            @elseif($query->attr==3)
            近隣利用
            @elseif($query->attr==4)
            個人講師
            @elseif($query->attr==5)
            MLM
            @elseif($query->attr==6)
            仲介会社
            @elseif($query->attr==7)
            その他
            @endif
          </td>
          <td>{{$query->first_name}}{{$query->last_name}}</td>
          <td>{{$query->mobile}}</td>
          <td>{{$query->tel}}</td>
          <td>{{$query->email}}</td>
          <td class="text-center">
            {{-- <a class="more_btn" href="{{ url('/admin/clients/'. $query->id) }}">詳細</a> --}}
            {{ Form::open(['url' => 'admin/clients/'.$query->id, 'method'=>'get']) }}
            @csrf
            {{Form::hidden("page",$querys->currentPage())}}
            {{ Form::submit('詳細', ['class' => 'btn more_btn']) }}
            {{ Form::close() }}
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>


</div>
{{ $querys->links() }}


<script>
  $(function(){
    $("#client_sort").tablesorter();
  })
</script>
@endsection