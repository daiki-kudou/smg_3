@extends('layouts.admin.app')

@section('content')
<script src="https://cdn.datatables.net/t/bs-3.3.6/jqc-1.12.0,dt-1.10.11/datatables.min.js"></script>
<script>
  $(function() {
    $(".table").DataTable({
      lengthChange: false, // 件数切替機能 無効
      searching: false, // 検索機能 無効
      ordering: true, // ソート機能 無効
      info: false, // 情報表示 無効
      paging: false, // ページング機能 無効
    });
  })
</script>
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
  <h2>顧客管理　一覧</h2>
  <div class="container-field">
    <div class="row ">
      <div class="col">
        <div>検索</div>
        <div class="col-sm-4" style="padding:20px 0; padding-left:0px;">
          <form class="form-inline" action="{{url('/admin/clients')}}">
            @csrf
            <div class="form-group">
              <label for="freeword">フリーワード検索</label>
              <input type="text" name="freeword" class="form-control" id="freeword">
            </div>
            <div class="form-group">
              <label for="id">顧客ID</label>
              <input type="text" name="id" class="form-control" id="id">
            </div>
            <div class="form-group">
              <label for="status">顧客状況</label>
              <input type="text" name="status" class="form-control" id="status">
            </div>
            <div class="form-group">
              <label for="company">会社名＿団体名</label>
              <input type="text" name="company" class="form-control" id="company">
            </div>
            <div class="form-group">
              <label for="attr">顧客属性</label>
              <input type="text" name="attr" class="form-control" id="attr">
            </div>
            <div class="form-group">
              <label for="person_name">担当者</label>
              <input type="text" name="person_name" class="form-control" id="person_name">
            </div>
            <div class="form-group">
              <label for="mobile">携帯番号</label>
              <input type="text" name="mobile" class="form-control" id="mobile">
            </div>
            <div class="form-group">
              <label for="tel">固定番号</label>
              <input type="text" name="tel" class="form-control" id="tel">
            </div>
            <div class="form-group">
              <label for="email">メール</label>
              <input type="text" name="email" class="form-control" id="email">
            </div>
            <div class="form-group">
              <label for="attention">注意事項</label>
              <input type="text" name="attention" class="form-control" id="attention">
            </div>
            <input type="submit" value="検索" class="btn btn-info">
          </form>
        </div>
      </div>
      <div class="col"></div>
    </div>
  </div>
  <table class="table">
    <thead>
      <tr>
        <th>注意事項</th>
        <th>顧客ID</th>
        <td>顧客状況</td>
        <td>会社名・団体名</td>
        <td>顧客属性</td>
        <td>担当者</td>
        <td>携帯電話</td>
        <td>固定電話</td>
        <td>担当者メールアドレス</td>
        <td>詳細</td>
      </tr>
    </thead>
    <tbody>
      @foreach ($querys as $query)
      <tr>
        <td>{{$query->attention!=null?'●':''}}</td>
        <td>{{$query->id}}</td>
        <td>{{$query->status==1?'会員':'退会'}}</td>
        <td>{{$query->company}}</td>
        <td>
          @if ($query->attr==1)
          一般企業
          @elseif($query->attr==2)
          上場企業
          @elseif($query->attr==3)
          近隣利用
          @elseif($query->attr==4)
          講師・セミナー
          @elseif($query->attr==5)
          ネットワーク
          @elseif($query->attr==6)
          その他
          @endif
        </td>
        <td>{{$query->first_name}} {{$query->last_name}}</td>
        <td>{{$query->mobile}}</td>
        <td>{{$query->tel}}</td>
        <td>{{$query->email}}</td>
        <td><a href="{{ url('/admin/clients/'. $query->id) }}">詳細</a></td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
{{ $querys->links() }}
@endsection