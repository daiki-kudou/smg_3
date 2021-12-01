@extends('layouts.admin.app')

@section('content')
<script src="{{ asset('/js/admin/search/validation.js') }}"></script>
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">


<style>
  .form-inline {
    display: block;
  }
</style>


<div class="container-field">
  <div class="float-right">
    @include('layouts.admin.breadcrumbs')
  </div>
  <h2 class="mt-3 mb-3">顧客管理　一覧</h2>
  <hr>

  <!-- 検索-------------------------------------------------------- -->
  {{Form::open(['url' => '/admin/clients', 'method' => 'GET', 'id'=>'clients_search'])}}
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
                {{Form::radio('attention', 1, (int)$request->attention===1?true:false,['id'=>'chk_atten'])}}
                {{Form::label("chk_atten","あり")}}
              </li>
              <li>
                {{Form::radio('attention', 2,
                (int)$request->attention===2?true:($request->attention===1?false:true),['id'=>'chk_atten_no'])}}
                {{Form::label("chk_atten_no","なし")}}
              </li>
            </ul>
          </td>
          <th class="search_item_name"><label for="id">フリーワード検索</label></th>
          <td>
            {{Form::text("freeword",$request->freeword?:'', ['class'=>'form-control','id'=>''])}}
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
    <p class="text-right">
      ※フリーワード検索は本画面表記の項目のみ対象となります<br>
      ※担当者氏名の検索時は、フルネーム時はスペース禁止
    </p>

    <div class="btn_box d-flex justify-content-center">
      <a href="{{url("admin/clients")}}" class="btn reset_btn">リセット</a>

      {{Form::submit('検索', ['class'=>'btn btn-info search_btn', 'id'=>'m_submit'])}}
    </div>
  </div>
  {{Form::close()}}
  <!-- 検索　終わり------------------------------------------------ -->


  {{-- 件数表示 --}}
  @if ($counter!=0)
  <div class="d-flex w-100">
    <p class="font-weight-bold d-block w-100 text-right">
      <span class="count-color">
        {{$counter}}
      </span>件
    </p>
  </div>
  @endif



  <div class="table-wrap">
    <table class="table table-bordered table-scroll" id="client_sort">
      <thead>
        <tr class="table_row">
          <th>注意事項</th>
          <th>顧客ID </th>
          <th>会社名・団体名 </th>
          <th>顧客属性 </th>
          <th>担当者 </th>
          <th>携帯電話 </th>
          <th>固定電話 </th>
          <th>担当者メールアドレス </th>
          <th>詳細</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($users as $user)
        <tr>
          <td>{{ $user->attention }}</td>
          <td>{{ $user->fix_id }}</td>
          <td>{{ $user->company }}</td>
          <td>{{ $user->attr }}</td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->mobile }}</td>
          <td>{{ $user->tel }}</td>
          <td>{{ $user->email }}</td>
          <td><a href="{{ route('admin.clients.show',$user->id) }}" class="btn more_btn">詳細</a></td>
        </tr>
        {{-- <tr>
          <td class="text-center">{{$user->attention!=null?'●':''}}</td>
          <td>{{ReservationHelper::fixId($user->id)}}</td>
          <td>{{$user->company}}</td>
          <td>
            @if ($user->attr==1)
            一般企業
            @elseif($user->attr==2)
            上場企業
            @elseif($user->attr==3)
            近隣利用
            @elseif($user->attr==4)
            個人講師
            @elseif($user->attr==5)
            MLM
            @elseif($user->attr==6)
            仲介会社
            @elseif($user->attr==7)
            その他
            @endif
          </td>
          <td>{{$user->first_name}}{{$user->last_name}}</td>
          <td>{{$user->mobile}}</td>
          <td>{{$user->tel}}</td>
          <td>{{$user->email}}</td>
          <td class="text-center">
            {{ Form::open(['url' => '/admin/clients/'.$user->id, 'method'=>'get']) }}
            @csrf
            {{ Form::submit('詳細', ['class' => 'btn more_btn']) }}
            {{ Form::close() }}
          </td>
        </tr> --}}
        @endforeach
      </tbody>
    </table>
  </div>


</div>

<script>
  $(document).ready(function(){
    $.extend($.fn.dataTable.defaults, {
        language: {
            url: "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Japanese.json"
        }
    });
    $('#client_sort').DataTable({
      searching: false,
      info: false,
      autowidth: false,
      "order": [[ 1, "desc" ]], //初期ソートソート条件
      "columnDefs": [
        {
          "orderable": false, 
          "targets": [8] 
        },
        {
          "className": "text-center",
          "targets": [0,1,2,3,5,6,7,8],
        }
           ],
      "stripeClasses": [],
     });
    });
</script>

@endsection