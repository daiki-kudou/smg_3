@extends('layouts.admin.app')
@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/ctrl_form.js') }}"></script>

<!-- フォーム追加 -->



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
  <h2 class="mt-3 mb-3">料金管理　新規登録（枠貸し）</h2>
  <hr>

</div>

<div class="section-wrap bg-white wrap_shadow">
  <h3 class="d-block mt-3 mb-5"><span class="mr-3">ID:{{ ReservationHelper::IdFormat($venue->id)}}</span>
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
      {{ Form:: open( ['route' => 'admin.frame_prices.store']) }}
      @csrf
      <p class="mb-2 text-right">※枠は「午前」「午後」「夜間」「午前＆午後」「午後＆夜間」「終日」です。</p>
      <table class="table table-bordered">
        <thead>
          <tr>
            <td>枠</td>
            <td>時間（開始）</td>
            <td>時間（終了）</td>
            <td>料金<span class="ml-1 annotation">※税抜</span></td>
            <td>追加・削除</td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ Form::text('frame', old('frame'), ['class' => 'form-control']) }}
            </td>
            <td>
              <select name="start" id="start" class="form-control col-sm-12">
                @for ($start = 8*2; $start <=23*2; $start++) <option
                  value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}">
                  {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}
                  </option>
                  @endfor
              </select>
            </td>
            <td>
              <select name="finish" id="finish" class="form-control col-sm-12">
                @for ($start = 8*2; $start <=23*2; $start++) <option
                  value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if (date("H:i:s",
                  strtotime("00:00 +". $start * 30 ." minute"))=="12:00:00" ) selected @endif>
                  {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}
                  </option>
                  @endfor
              </select>
            </td>
            <td>{{ Form::text('price', "", ['class' => 'form-control']) }}</td>
            <td>
              <input type="button" value="＋" class="add pluralBtn">
              <input type="button" value="－" class="del pluralBtn">
            </td>
          </tr>
        </tbody>
      </table>
      <div>
        <p>
          延長料金(1H)<span class="ml-1 annotation">※税抜</span>
        </p>
      </div>
      {{ Form::number('extend', old('extend'),['class'=>'form-control w-25']) }}
      {{Form::hidden('venue_id', $venue->id)}}
      <div class="mt-5 mx-auto">
        {{ Form::submit('登録する', ['class' => 'btn more_btn_lg d-block btn-lg mx-auto my-5']) }}</div>
      {{ Form::close() }}
    </div>
  </div>
</div>


<script>
  $(function() {
    $(document).on("click", ".add", function() {
      $(this).parent().parent().clone(true).insertAfter($(this).parent().parent());
      var count = $('.table tbody tr').length;

      // プラス選択時にクローンtrの文字クリア
      $(this).parent().parent().next().find('td').find('input, select').eq(0).val('');
      $(this).parent().parent().next().find('td').find('input, select').eq(1).val('');
      $(this).parent().parent().next().find('td').find('input, select').eq(2).val('');
      $(this).parent().parent().next().find('td').find('input, select').eq(3).val('');

      for (let index = 0; index < count; index++) {
        var frame = "frame" + (index);
        var start = "start" + (index);
        var finish = "finish" + (index);
        var price = "price" + (index);
        $('.new_price tbody tr').eq(index).find('td').find('input, select').eq(0).attr('name', frame);
        $('.new_price tbody tr').eq(index).find('td').find('input, select').eq(1).attr('name', start);
        $('.new_price tbody tr').eq(index).find('td').find('input, select').eq(2).attr('name', finish);
        $('.new_price tbody tr').eq(index).find('td').find('input, select').eq(3).attr('name', price);
      }
    });
    $(document).on("click", ".del", function() {
      var target = $(this).parent().parent();

      if (target.parent().children().length > 1) {
        target.remove();
      }
      var count = $('.new_price tbody tr').length;

      for (let index = 0; index < count; index++) {
        var frame = "frame" + (index);
        var start = "start" + (index);
        var finish = "finish" + (index);
        var price = "price" + (index);
        $('.new_price tbody tr').eq(index).find('td').find('input, select').eq(0).attr('name', frame);
        $('.new_price tbody tr').eq(index).find('td').find('input, select').eq(1).attr('name', start);
        $('.new_price tbody tr').eq(index).find('td').find('input, select').eq(2).attr('name', finish);
        $('.new_price tbody tr').eq(index).find('td').find('input, select').eq(3).attr('name', price);
      }
    });

    $('#start').on('change', function() {
      var start = $('#start').val();
      var finish = $('#finish').val();
      if (start > finish) {
        swal('営業開始時間は営業終了時間より前に設定してください');
        $('#start').val('');
      }
    });

    $('#finish').on('change', function() {
      var start = $('#start').val();
      var finish = $('#finish').val();
      if (start > finish) {
        swal('営業終了時間は営業開始時間より後に設定してください');
        $('#finish').val('');
      }
    });

  });
</script>
@endsection