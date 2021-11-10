@extends('layouts.admin.app')

@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/ctrl_form.js') }}"></script>


<!-- フォーム追加 -->


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
    {{ $venue->name_bldg }}{{ $venue->name_venue }}
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
      {{ Form::model($time_price, ['route' => 'admin.time_prices.store','id'=>'CreateTimePriceForm']) }}
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
          <td>
            {{ Form::number('time0', old('time'), ['class' => 'form-control']) }}
            <p class="is-error-time0" style="color: red"></p>
          </td>
          <td>
            {{ Form::number('price0', old('price0'), ['class' => 'form-control']) }}
            <p class="is-error-price0" style="color: red"></p>
          </td>
          <td>
            <div class="d-flex align-items-end">
              {{ Form::number('extend0', old('extend'), ['class' => 'form-control']) }}
              <span class="ml-1">円</span>
            </div>
            <p class="is-error-extend0" style="color: red"></p>
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


<script>
  $(function() {
    $(document).on("click", ".add", function() {
      $("input").attr('aria-describedby','');
      var validator = $( "#CreateTimePriceForm" ).validate();
      validator.resetForm();
      validator.destroy();

      $(this).parent().parent().clone().insertAfter($(this).parent().parent());
      var count = $('.new_price tbody tr').length;

      // プラス選択時にクローンtrの文字クリア
      $(this).parent().parent().next().find('td').find('input, select').eq(0).val('');
      $(this).parent().parent().next().find('td').find('input, select').eq(1).val('');
      $(this).parent().parent().next().find('td').find('input, select').eq(2).val('');

      for (let index = 0; index < count; index++) {
        $('.new_price tbody tr').eq(index).find('td').find('input, select').eq(0).attr('name', 'time'+index);
        $('.new_price tbody tr').eq(index).find('td').find('input, select').eq(1).attr('name', 'price'+index);
        $('.new_price tbody tr').eq(index).find('td').find('input, select').eq(2).attr('name', 'extend'+index);

        $('.new_price tbody tr').eq(index).find('td').eq(0).find('p').remove();
        $('.new_price tbody tr').eq(index).find('td').eq(0).append("<p class='is-error-time"+index+"' style='color: red'></p>");
        $('.new_price tbody tr').eq(index).find('td').eq(1).find('p').remove();
        $('.new_price tbody tr').eq(index).find('td').eq(1).append("<p class='is-error-price"+index+"' style='color: red'></p>");
        $('.new_price tbody tr').eq(index).find('td').eq(2).find('p').remove();
        $('.new_price tbody tr').eq(index).find('td').eq(2).append("<p class='is-error-extend"+index+"' style='color: red'></p>");

      }
      validationThis(count);

    });

    $(document).on("click", ".del", function() {
      $("input").attr('aria-describedby','');
      var validator = $( "#CreateTimePriceForm" ).validate();
      validator.resetForm();
      validator.destroy();

      var target = $(this).parent().parent();

      if (target.parent().children().length > 1) {
        target.remove();
      }
      var count = $('.new_price tbody tr').length;
      console.log(count);

      for (let index = 0; index < count; index++) {
        $('.new_price tbody tr').eq(index).find('td').find('input, select').eq(0).attr('name', 'time'+index);
        $('.new_price tbody tr').eq(index).find('td').find('input, select').eq(1).attr('name', 'price'+index);
        $('.new_price tbody tr').eq(index).find('td').find('input, select').eq(2).attr('name', 'extend'+index);
      }
      validationThis(count);

    });


    validationThis();


    function validationThis($index=1){
        $("#CreateTimePriceForm").validate({
          rules: {
            time0: {
              required: true,
              number: true,
              min:1,
            },
            price0: {
              required: true,
              number: true,
              digits: true,
              min:1,
            },
            extend0: {
              required: true,
              number: true,
              digits: true,
              min:1,
            },
          },
          messages: {
            time0: {
              required: "※必須項目です",
              number: "※半角英数字で入力してください",
              min:'※1以上を入力してください'
            },
            price0: {
              required: "※必須項目です",
              number: "※半角英数字で入力してください",
              digits: "※整数で入力してください",
              min:'※1以上を入力してください'
            },
            extend0: {
              required: "※必須項目です",
              number: "※半角英数字で入力してください",
              digits: "※整数で入力してください",
              min:'※1以上を入力してください'
            },
          },
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
      for (let index2 = 1; index2 < $index; index2++) {
        $("input[name='time"+index2+"']").rules("add", {
        required: true,
        messages: { required: "※必須項目です" },
        });
        $("input[name='price"+index2+"']").rules("add", {
        required: true,
        digits: true,
        messages: { required: "※必須項目です", digits: "※整数で入力してください"},
        });
        $("input[name='extend"+index2+"']").rules("add", {
        required: true,
        digits: true,
        messages: { required: "※必須項目です", digits: "※整数で入力してください"},
        });
      }
    }
  });
</script>


@endsection