@extends('layouts.admin.app')

@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">

<div class="float-right">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">
        {{ Breadcrumbs::render(Route::currentRouteName(),$venue->id) }}
      </li>
    </ol>
  </nav>
</div>

<h2 class="mt-3 mb-3">料金管理　編集(枠貸し)</h2>
<hr>

<div class="section-wrap bg-white wrap_shadow">
  <h3 class="d-block mt-3 mb-5 price_ttl"><span class="mr-3">ID:{{ ReservationHelper::fixId($venue->id)}}</span>
    {{ $venue->name_bldg }}{{ $venue->name_venue }}
  </h3>
  @if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif
  <div class="new_price">
    <div>
      {{ Form::model($venue, ['route' => ['admin.frame_prices.update', $venue->id], 'method' => 'put', 'id'=>'EditFramePrice']) }}
      @csrf

      <p class="mb-2 text-right">※枠は「午前」「午後」「夜間」「午前＆午後」「午後＆夜間」「終日」です。</p>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>枠</th>
            <th>時間（開始）</th>
            <th>時間（終了）</th>
            <th>料金<span class="ml-1 annotation">※税抜</span></th>
            <th>追加・削除</th>
          </tr>
        </thead>
        <tbody class="main_tbody">
          @foreach ($frame_prices as $num=>$frame_price)
          <tr>
            <td>
              {{ Form::text('frame'.$num, old('frame', $frame_price->frame), ['class' => 'form-control', '']) }}
              <p class="{{'is-error-frame'.$num}}" style="color: red"></p>
            </td>
            <td>{{Form::select('start'.$num, [
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
                ],old('start', $frame_price->start),['class'=>'form-control col-sm-12'])}}
            </td>
            <td>{{Form::select('finish'.$num, [

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
                ],old('finish', $frame_price->finish),['class'=>'form-control col-sm-12'])}}</td>
            <td>
              <div class="d-flex align-items-end">
                {{ Form::text('price'.$num, old('price', $frame_price->price), ['class' => 'form-control', '']) }}
                <span class="ml-1">円</span>
              </div>
              <p class="{{'is-error-price'.$num}}" style="color: red"></p>
            </td>
            <td>
              <input type="button" value="＋" class="add pluralBtn">
              <input type="button" value="ー" class="del pluralBtn">
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div class="fw-bold">
        延長料金(1H)<span class="ml-1 annotation">※税抜</span>
      </div>
      <div>
        <div class="d-flex align-items-end">
          {{ Form::text('extend', $frame_price->extend,['class'=>'form-control w-25 mb-2'])}}
        </div>
        <p class="{{'is-error-extend'}}" style="color: red"></p>
      </div>
      {{Form::hidden('venue_id', $venue->id)}}
      <div class="d-flex">
        <button type="button" class="btn more_btn4_lg d-block btn-lg mx-auto my-5"
          onclick="$('#delete').submit()">すべて削除する</button>
        {{ Form::submit('保存する', ['class' => 'btn more_btn_lg mx-auto d-block my-5 price_confirm']) }}
      </div>
      {{ Form::close() }}
    </div>
    {{Form::open(['url' => '/admin/frame_prices/'.$venue->id, 'method' => 'delete', 'id'=>'delete'])}}
    @csrf
    {{ Form::close() }}
  </div>
</div>
<script>
  $(function() {
    // プラスボタンクリック
    $(document).on("click", ".add", function() {
      $(this).parent().parent().clone(true).insertAfter($(this).parent().parent());
      var count = $('.table tbody tr').length;
      // 追加時内容クリア
      $(this).parent().parent().next().find('td').find('input, select').eq(0).val('');
      $(this).parent().parent().next().find('td').find('input, select').eq(3).val('');
      for (let index = 0; index < count; index++) {
        $('.table tbody tr').eq(index).find('td').find('input, select').eq(0).attr('name', "frame" + index);
        $('.table tbody tr').eq(index).find('td').find('input, select').eq(1).attr('name', "start" + index);
        $('.table tbody tr').eq(index).find('td').find('input, select').eq(2).attr('name', "finish" + index);
        $('.table tbody tr').eq(index).find('td').find('input, select').eq(3).attr('name', "price" + index);

        $('.table tbody tr').eq(index).find('td').eq(0).find('p').remove();
        $('.table tbody tr').eq(index).find('td').eq(0).append("<p class='is-error-frame"+index+"' style='color: red'></p>");
        $('.table tbody tr').eq(index).find('td').eq(3).find('p').remove();
        $('.table tbody tr').eq(index).find('td').eq(3).append("<p class='is-error-price"+index+"' style='color: red'></p>");
      }
      validationThis(count);
    });

    //   マイナスボタンクリック
    $(document).on("click", ".del", function() {
      var target = $(this).parent().parent();
      if (target.parent().children().length > 1) {
        target.remove();
      }
      var count = $('.table tbody tr').length;
      for (let index = 0; index < count; index++) {
        $('.table tbody tr').eq(index).find('td').find('input, select').eq(0).attr('name', "frame" + index);
        $('.table tbody tr').eq(index).find('td').find('input, select').eq(1).attr('name', "start" + index);
        $('.table tbody tr').eq(index).find('td').find('input, select').eq(2).attr('name', "finish" + index);
        $('.table tbody tr').eq(index).find('td').find('input, select').eq(3).attr('name', "price" + index);

        $('.table tbody tr').eq(index).find('td').eq(0).find('p').remove();
        $('.table tbody tr').eq(index).find('td').eq(0).append("<p class='is-error-frame"+index+"' style='color: red'></p>");
        $('.table tbody tr').eq(index).find('td').eq(3).find('p').remove();
        $('.table tbody tr').eq(index).find('td').eq(3).append("<p class='is-error-price"+index+"' style='color: red'></p>");

      }
      validationThis(count);
    });

    var trLength=$(".main_tbody").find("tr").length;
    var rules = {};
    var messages = {};
    for (var i = 0; i < trLength; i++) {
        rules["frame"+i] = {
            required: true
        };
        rules["price"+i] = {
            required: true,
            number:true,
            min:1,
        };
        messages["frame"+i] = {
            required: "※必須項目です"
        };
        messages["price"+i] = {
          required: "※必須項目です",
          number:"※半角英数字で入力してください",
          min:"1以上を入力してください",
        };
    }
      $("#EditFramePrice").validate({
          rules: rules,
          messages:messages,
          errorPlacement: function (error, element) {
            var name = element.attr('name');
            if (element.attr('name') === 'category[]') {
              error.appendTo($('.is-error-category'));
            } else if (element.attr('name') === name) {
              error.appendTo($('.is-error-' + name));
            }
          },
          errorElement: "span",
          errorClass: "is-error",
          //送信前にLoadingを表示
          submitHandler: function (form) {
            $('.approval').addClass('hide');
            $('.loading').removeClass('hide');
            form.submit();
          }
        });
        $('input').on('blur', function () {
          $(this).valid();
      });

      function validationThis($index=1){
      for (let index2 = 1; index2 < $index; index2++) {
        console.log(index2);
        $("input[name='frame"+index2+"']").rules("add", {
        required: true,
        messages: { required: "※必須項目です" },
        });
        $("input[name='price"+index2+"']").rules("add", {
        required: true,
        number:true,
        min:1,
        messages: { required: "※必須項目です", number:"※半角英数字で入力してください",min:'※1以上を入力してください' },
        });
      }
    }
  });


</script>
@endsection