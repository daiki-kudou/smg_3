@extends('layouts.admin.app')

@section('content')
<script src="{{ asset('/js/tablesorter/jquery.tablesorter.js') }}"></script>
<link href="{{ asset('/css/tablesorter/theme.default.min.css') }}" rel="stylesheet">

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
          ダミーダミーダミーダミー
        </li>
      </ol>
    </nav>
  </div>
  <h2 class="mt-3 mb-3">顧客管理　一覧</h2>
  <hr>

  <!-- 検索-------------------------------------------------------- -->
  <form class="" action="{{url('/admin/clients')}}">
    <div class="search-wrap">
      @csrf
      <table class="table table-bordered">
        <tbody>
          <tr>
            <th class="search_item_name"><label for="id">顧客ID</label></th>
            <td class="text-right form-group">
              <input type="text" class="form-control float-right" id="id">
            </td>
            <th class="search_item_name"><label for="company">会社名　団体名</label></th>
            <td class="text-right form-group">
              <input type="text" name="company" class="form-control float-right" id="company">
            </td>
          </tr>
          <tr>
            <th class="search_item_name"><label for="person_name">担当者</label></th>
            <td class="text-right">
              <dd>
                <input type="text" name="person_name" class="form-control" id="person_name">
            </td>
            <th class="search_item_name"><label for="mobile">携帯電話</label></th>
            <td class="text-right">
              <dd>
                <input type="text" name="mobile" class="form-control" id="mobile">
            </td>
          </tr>
          <tr>
            <th class="search_item_name"><label for="tel">固定電話</label></th>
            <td class="text-right">
              <dd>
                <input type="text" name="tel" class="form-control" id="tel">
            </td>
            <th class="search_item_name"><label for="email">担当者メールアドレス</label></th>
            <td class="text-right">
              <dd>
                <input type="text" name="email" class="form-control" id="email">
            </td>
          </tr>
          <tr>
            <th class="search_item_name"><label for="attention">注意事項</label></th>
            <td class="text-left">
              <ul class="search_category">
                <li>
                  <input type="checkbox" id="attention" name="attention">
                  <label for="">あり</label>
                </li>
                <li>
                  <input type="checkbox" id="attention" name="attention">
                  <label for="">なし</label>
                </li>
              </ul>
            </td>
            <th class="search_item_name"><label for="id">フリーワード検索</label></th>
            <td>
              <input type="text" name="id" class="form-control" id="id">
            </td>
          </tr>
          <tr>
            <th class="search_item_name"><label for="personStatus">顧客属性</label></th>
            <td colspan="3">
              <ul class="search_category">
                <li>
                  <input type="checkbox" checked>
                  <label for="personStatus">一般企業</label>
                </li>
                <li>
                  <input type="checkbox" checked>
                  <label for="personStatus">上場企業</label>
                </li>
                <li>
                  <input type="checkbox" checked>
                  <label for="personStatus">近隣利用</label>
                </li>
                <li>
                  <input type="checkbox" checked>
                  <label for="personStatus">個人講師</label>
                </li>
                <li>
                  <input type="checkbox" checked>
                  <label for="personStatus">MLM</label>
                </li>
                <li>
                  <input type="checkbox" checked>
                  <label for="personStatus">仲介会社</label>
                </li>
                <li>
                  <input type="checkbox" checked>
                  <label for="personStatus">その他</label>
                </li>
              </ul>
            </td>
          </tr>
        </tbody>
      </table>
      <p class="text-right">※フリーワード検索は本画面表記の項目のみ対象となります</p>

      <div class="btn_box d-flex justify-content-center">
        <input type="reset" value="リセット" class="btn reset_btn">
        <input type="submit" value="検索" class="btn btn-info search_btn">
      </div>
    </div>
  </form>
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
          <td>{{$query->attention!=null?'●':''}}</td>
          <td>{{$query->id}}</td>
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
          <td>{{$query->first_name}} {{$query->last_name}}</td>
          <td>{{$query->mobile}}</td>
          <td>{{$query->tel}}</td>
          <td>{{$query->email}}</td>
          <td class="text-center"><a class="more_btn" href="{{ url('/admin/clients/'. $query->id) }}">詳細</a></td>
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