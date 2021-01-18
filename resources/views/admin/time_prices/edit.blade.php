@extends('layouts.admin.app')

@section('content')
{{-- @include('layouts.admin.side') --}}
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/validation.js') }}"></script>
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">


<!-- フォーム追加 -->
<script>
  $(function() {
        // プラスボタンクリック
      $(document).on("click", ".add", function() {
        $(this).parent().parent().clone(true).insertAfter($(this).parent().parent());
        var count = $('.table tbody tr').length;

                // プラス選択時にクローンtrの文字クリア
      $(this).parent().parent().next().find('td').find('input, select').eq(0).val('');
      $(this).parent().parent().next().find('td').find('input, select').eq(1).val('');
      $(this).parent().parent().next().find('td').find('input, select').eq(2).val('');

  
        for (let index = 0; index < count; index++) {
          var time = "time" + (index);
          var price = "price" + (index);
          var extend = "extend" + (index);
          $('.table tbody tr').eq(index).find('td').find('input, select').eq(0).attr('name', time);
          $('.table tbody tr').eq(index).find('td').find('input, select').eq(1).attr('name', price);
          $('.table tbody tr').eq(index).find('td').find('input, select').eq(2).attr('name', extend);
        }
      });
    //   マイナスボタンクリック
      $(document).on("click", ".del", function() {
        var target = $(this).parent().parent();
  
        if (target.parent().children().length > 1) {
          target.remove();
        }
        var count = $('.table tbody tr').length;
        console.log(count);
  
        for (let index = 0; index < count; index++) {
          var time = "time" + (index);
          var price = "price" + (index);
          var extend = "extend" + (index);
          $('.table tbody tr').eq(index).find('td').find('input, select').eq(0).attr('name', time);
          $('.table tbody tr').eq(index).find('td').find('input, select').eq(1).attr('name', price);
          $('.table tbody tr').eq(index).find('td').find('input, select').eq(2).attr('name', extend);
        }
      });
    });
</script>

<div class="container-field mt-3">
  <div class="float-right">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">{{ Breadcrumbs::render(Route::currentRouteName(),$venue->id) }}</li>
      </ol>
    </nav>
  </div>
  <h1 class="mt-3 mb-5">料金管理　編集（枠貸し）</h1>
  <hr>
  <div class="d-flex justify-content-between mt-3 mb-5">
  </div>
</div>
















<div class="p-3 mb-2 bg-white text-dark">
  <div>料金管理　新規作成</div>
  <hr>
  <div class="w-100 mb-3">
    <span class="d-block mb-2">会場</span>
    <strong class="border border-light d-block"
      style="width:100%;">{{$venue->name_area}}{{$venue->name_bldg}}{{$venue->name_venue}}</strong>
  </div>
  <div class="new_price">
    @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    <div>
      @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
      {{ Form::model($venue, ['route' => ['admin.time_prices.update', $venue->id], 'method' => 'put', 'id'=>'timeEditForm']) }}
      @csrf
      <table class="table">
        <thead>
          <tr>
            <th>時間</th>
            <td>料金</td>
            <td>延長料金（1H）</td>
            <td>追加・削除</td>
          </tr>
        </thead>
        <tbody>
          @foreach ($time_prices as $num=>$time_price)
          <tr>
            <td>
              <p class="{{'is-error-time'.$num}}" style="color: white"></p>
              {{ Form::text('time'.$num, old('time', $time_price->time), ['class' => 'form-control']) }}
              <p class="{{'is-error-time'.$num}}" style="color: red"></p>
            </td>
            <td>
              <p class="{{'is-error-price'.$num}}" style="color: white"></p>
              {{ Form::text('price'.$num, old('price', $time_price->price), ['class' => 'form-control']) }}
              <p class="{{'is-error-price'.$num}}" style="color: red"></p>
            </td>
            <td>
              <p class="{{'is-error-extend'.$num}}" style="color: white"></p>
              {{ Form::text('extend'.$num, old('extend', $time_price->extend), ['class' => 'form-control']) }}
              <p class="{{'is-error-extend'.$num}}" style="color: red"></p>
            </td>
            <td>
              <input type="button" value="＋" class="add pluralBtn">
              <input type="button" value="ー" class="del pluralBtn">
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      {{Form::hidden('venue_id', $venue->id)}}
      {{ Form::submit('更新', ['class' => 'btn btn-primary']) }}
      {{ Form::close() }}
    </div>
  </div>
</div>



@endsection