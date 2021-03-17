@extends('layouts.admin.app')
@section('content')

<script src="{{ asset('/js/tablesorter/jquery.tablesorter.js') }}"></script>
<link href="{{ asset('/css/tablesorter/theme.default.min.css') }}" rel="stylesheet">
{{-- <script src="{{ asset('/js/admin/venue.js') }}"></script> --}}
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">

    <div class="container-field mt-3">
      <div class="float-right">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active">
              {{ Breadcrumbs::render(Route::currentRouteName()) }}
            </li>
          </ol>
        </nav>
      </div>


      <h2 class="mt-3 mb-3">有料備品管理</h2>
      <hr>
      <div class="text-right">
        <a href="/admin/equipments/create" class="btn more_btn3">新規登録</a>
      </div>
    </div>

    <p class="text-right mt-4">※金額は税抜表記になります。</p>
    <div class="">
      <table class="table table-bordered" id="equipments_sort">
        <thead>
          <tr class="table_row">
            <th>ID</th>
            <th>登録日</th>
            <th>有料備品名</th>
            <th>料金</th>
            <th>数量</th>
            <th>備考</th>
            <th class="btn-cell">編集</th>
            <th class="btn-cell">削除</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($equipments as $query)
          <tr role="row" class="even">
            <td>{{ ReservationHelper::IdFormat($query->id) }}</td>
            <td>{{ ReservationHelper::formatDate($query->created_at) }}</td>
            <td>{{ $query->item }}</td>
            <td class="text-right">{{ number_format($query->price )}}</td>
            <td class="text-right">{{ $query->stock }}</td>
            <td>
              <p class="remark_limit">
                {!!nl2br(e($query->remark))!!}
              </p>
            </td>
            <td class="text-center">
              {{ Form::open(['url' => 'admin/equipments/'.$query->id."/edit", 'method'=>'GET', 'id'=>'']) }}
              @csrf
              {{Form::hidden('current_p',$equipments->currentPage() )}}
              {{ Form::submit('編集', ['class' => 'btn more_btn']) }}
              {{ Form::close() }}
            </td>
            <td class="text-center">
              {{ Form::model($query, ['route' => ['admin.equipments.destroy', $query->id], 'method' => 'delete']) }}
              @csrf
              {{Form::hidden("page",$equipments->currentPage())}}
              {{ Form::submit('削除', ['class' => 'btn more_btn4 del_btn']) }}
              {{ Form::close() }}
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
{{ $equipments->links() }}


<script>
  $(function(){
    $("#equipments_sort").tablesorter();
  })

  $(function () {
  $('.del_btn').on('click', function () {
    var target = $(this).parent().parent().parent().find('td').eq(2).text();
    console.log(target);
    if (!confirm(target+'を本当に削除しますか？\n削除した時点で会場情報・顧客側予約フォームからも削除されます')) {
      return false;
    } else {
    }
  })
})

</script>

@endsection