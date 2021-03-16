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
  <div class="d-flex justify-content-between mt-3 mb-5">
  </div>
</div>

<div class="p-3 mb-2 bg-white text-dark">
  <div>料金管理　新規登録</div>
  <hr>
  <div class="w-100 mb-3">
    <span class="d-block mb-2">会場</span>
    <strong class="border border-light d-block" style="width:100%;">{{ReservationHelper::getVenue($venue->id)}}</strong>
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
      {{ Form:: open( ['route' => 'admin.frame_prices.store']) }}
      @csrf
      <p class="text-right">※金額は税抜で入力してください。</p>
      <table class="table table-bordered">
        <thead>
          <tr>
            <td>枠</td>
            <td>時間（開始）</td>
            <td>時間（終了）</td>
            <td>料金</td>
            <td>追加・削除</td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ Form::text('frame', old('frame'), ['class' => 'form-control', 'placeholder'=>'例：午前 or 午後 or 夜間']) }}
            </td>
            <td>{{Form::select('start', [
                '00:00:00'=>'00:00',
                '00:30:00'=>'00:30',
                '01:00:00'=>'01:00',
                '01:30:00'=>'01:30',
                '02:00:00'=>'02:00',
                '02:30:00'=>'02:30',
                '03:00:00'=>'03:00',
                '03:30:00'=>'03:30',
                '04:00:00'=>'04:00',
                '04:30:00'=>'04:30',
                '05:00:00'=>'05:00',
                '05:30:00'=>'05:30',
                '06:00:00'=>'06:00',
                '06:30:00'=>'06:30',
                '07:00:00'=>'07:00',
                '07:30:00'=>'07:30',
                '08:00:00'=>'08:00',
                '08:30:00'=>'08:30',
                '09:00:00'=>'09:00',
                '09:30:00'=>'09:30',
                '10:00:00'=>'10:00',
                '10:30:00'=>'10:30',
                '11:00:00'=>'11:00',
                '11:30:00'=>'11:30',
                '12:00:00'=>'12:00',
                '12:30:00'=>'12:30',
                '13:00:00'=>'13:00',
                '13:30:00'=>'13:30',
                '14:00:00'=>'14:00',
                '14:30:00'=>'14:30',
                '15:00:00'=>'15:00',
                '15:30:00'=>'15:30',
                '16:00:00'=>'16:00',
                '16:30:00'=>'16:30',
                '17:00:00'=>'17:00',
                '17:30:00'=>'17:30',
                '18:00:00'=>'18:00',
                '18:30:00'=>'18:30',
                '19:00:00'=>'19:00',
                '19:30:00'=>'19:30',
                '20:00:00'=>'20:00',
                '20:30:00'=>'20:30',
                '21:00:00'=>'21:00',
                '21:30:00'=>'21:30',
                '22:00:00'=>'22:00',
                '22:30:00'=>'22:30',
                '23:00:00'=>'23:00',
                '23:30:00'=>'23:30',
            ], '08:00:00',['class'=>'form-control col-sm-12', 'id'=>'start'])}}
            </td>
            <td>{{Form::select('finish', [
                '00:00:00'=>'00:00',
                '00:30:00'=>'00:30',
                '01:00:00'=>'01:00',
                '01:30:00'=>'01:30',
                '02:00:00'=>'02:00',
                '02:30:00'=>'02:30',
                '03:00:00'=>'03:00',
                '03:30:00'=>'03:30',
                '04:00:00'=>'04:00',
                '04:30:00'=>'04:30',
                '05:00:00'=>'05:00',
                '05:30:00'=>'05:30',
                '06:00:00'=>'06:00',
                '06:30:00'=>'06:30',
                '07:00:00'=>'07:00',
                '07:30:00'=>'07:30',
                '08:00:00'=>'08:00',
                '08:30:00'=>'08:30',
                '09:00:00'=>'09:00',
                '09:30:00'=>'09:30',
                '10:00:00'=>'10:00',
                '10:30:00'=>'10:30',
                '11:00:00'=>'11:00',
                '11:30:00'=>'11:30',
                '12:00:00'=>'12:00',
                '12:30:00'=>'12:30',
                '13:00:00'=>'13:00',
                '13:30:00'=>'13:30',
                '14:00:00'=>'14:00',
                '14:30:00'=>'14:30',
                '15:00:00'=>'15:00',
                '15:30:00'=>'15:30',
                '16:00:00'=>'16:00',
                '16:30:00'=>'16:30',
                '17:00:00'=>'17:00',
                '17:30:00'=>'17:30',
                '18:00:00'=>'18:00',
                '18:30:00'=>'18:30',
                '19:00:00'=>'19:00',
                '19:30:00'=>'19:30',
                '20:00:00'=>'20:00',
                '20:30:00'=>'20:30',
                '21:00:00'=>'21:00',
                '21:30:00'=>'21:30',
                '22:00:00'=>'22:00',
                '22:30:00'=>'22:30',
                '23:00:00'=>'23:00',
                '23:30:00'=>'23:30',      
                ], '12:00:00',['class'=>'form-control col-sm-12','id'=>'finish'])}}
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
          延長料金（1H）
        </p>
      </div>
      {{ Form::number('extend', old('extend'),['class'=>'form-control w-25']) }}
      {{Form::hidden('venue_id', $venue->id)}}
      <div class="mt-5 mx-auto" style="width: 50px;">
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