@extends('layouts.admin.app')

@section('content')
{{-- @include('layouts.admin.side') --}}
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/ctrl_form.js') }}"></script>


<!-- フォーム追加 -->
<script>
  $(function() {
    $(document).on("click", ".add", function() {
      $(this).parent().parent().clone(true).insertAfter($(this).parent().parent());
      var count = $('.new_price tbody tr').length;

      // プラス選択時にクローンtrの文字クリア
      $(this).parent().parent().next().find('td').find('input, select').eq(0).val('');
      $(this).parent().parent().next().find('td').find('input, select').eq(1).val('');
      $(this).parent().parent().next().find('td').find('input, select').eq(2).val('');

      for (let index = 0; index < count; index++) {
        var time = "time" + (index);
        var price = "price" + (index);
        var extend = "extend" + (index);
        $('.new_price tbody tr').eq(index).find('td').find('input, select').eq(0).attr('name', time);
        $('.new_price tbody tr').eq(index).find('td').find('input, select').eq(1).attr('name', price);
        $('.new_price tbody tr').eq(index).find('td').find('input, select').eq(2).attr('name', extend);
      }
    });
    $(document).on("click", ".del", function() {
      var target = $(this).parent().parent();

      if (target.parent().children().length > 1) {
        target.remove();
      }
      var count = $('.new_price tbody tr').length;
      console.log(count);

      for (let index = 0; index < count; index++) {
        var time = "time" + (index);
        var price = "price" + (index);
        var extend = "extend" + (index);
        $('.new_price tbody tr').eq(index).find('td').find('input, select').eq(0).attr('name', time);
        $('.new_price tbody tr').eq(index).find('td').find('input, select').eq(1).attr('name', price);
        $('.new_price tbody tr').eq(index).find('td').find('input, select').eq(2).attr('name', extend);
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

  <h2 class="mt-3 mb-3">料金管理　新規登録（時間貸し）</h2>
  <hr>
</div>

<div class="section-wrap bg-white wrap_shadow">

  <h3 class="d-block mt-3 mb-5 price_ttl"><span class="mr-3">ID:{{ ReservationHelper::fixId($venue->id)}}</span>
    {{ $venue->name_area }}・{{ $venue->name_bldg }}{{ $venue->name_venue }}
  </h3>
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
      {{ Form::model($time_price, ['route' => 'admin.time_prices.store']) }}
      @csrf
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>時間</th>
            <th>料金<span class="ml-1 annotation">※税抜</span></th>
            <th>延長料金(1H)<span class="ml-1 annotation">※税抜</span></th>
            <th>追加・削除</th>
          </tr>
        </thead>
        <tr>
          <td>{{ Form::number('time', old('time'), ['class' => 'form-control']) }}</td>
          <td>{{ Form::number('price', old('price'), ['class' => 'form-control']) }}</td>
          <td>
            <div class="d-flex align-items-end">
              {{ Form::number('extend', old('extend'), ['class' => 'form-control']) }}
              <span class="ml-1">円</span>
            </div>
          </td>
          <td>
            <input type="button" value="＋" class="add pluralBtn">
            <input type="button" value="－" class="del pluralBtn">
          </td>
        </tr>
      </table>
      {{Form::hidden('venue_id', $venue->id)}}
      <div>{{ Form::submit('登録する', ['class' => 'btn more_btn_lg d-block btn-lg mx-auto mt-5']) }}</div>
      {{ Form::close() }}
    </div>
  </div>
</div>





@endsection