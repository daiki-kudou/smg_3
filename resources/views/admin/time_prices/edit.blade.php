@extends('layouts.admin.app')

@section('content')
{{-- @include('layouts.admin.side') --}}
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/validation.js') }}"></script>
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/ctrl_form.js') }}"></script>

<!-- フォーム追加 -->


<div class="float-right">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active"><a href="https://staging-smg2.herokuapp.com/admin/home">ホーム</a> &gt;
        <a href="https://staging-smg2.herokuapp.com/admin/frame_prices">料金管理</a> &gt;
        料金管理　編集（時間貸し）
      </li>
    </ol>
  </nav>
</div>

<h2 class="mt-3 mb-3">料金管理　編集（時間貸し）</h2>
<hr>

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
      {{ Form::model($venue, ['route' => ['admin.time_prices.update', $venue->id], 'method' => 'put',
      'id'=>'timeEditForm']) }}
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
        <tbody class="main_tbody">
          @foreach ($time_prices as $num=>$time_price)
          <tr>
            <td>
              <div class="d-flex align-items-end">
                {{ Form::text('time'.$num, old('time', $time_price->time), ['class' => 'form-control']) }}
                <span class="ml-1">H</span>
              </div>
              <p class="{{'is-error-time'.$num}}" style="color: red"></p>
            </td>
            <td>
              <div class="d-flex align-items-end">
                {{ Form::text('price'.$num, old('price', $time_price->price), ['class' => 'form-control']) }}
                <span class="ml-1">円</span>
              </div>
              <p class="{{'is-error-price'.$num}}" style="color: red"></p>
            </td>
            <td>
              <div class="d-flex align-items-end">
                {{ Form::text('extend'.$num, old('extend', $time_price->extend), ['class' => 'form-control']) }}
                <span class="ml-1">円</span>
              </div>
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
      <div class="d-flex">
        <button type="button" class="btn more_btn4_lg d-block btn-lg mx-auto my-5"
          onclick="$('#delete').submit()">すべて削除する</button>
        {{ Form::submit('保存する', ['class' => 'btn more_btn_lg d-block btn-lg mx-auto my-5 price_confirm',
        'id'=>'submit']) }}
      </div>


      {{ Form::close() }}
    </div>

    {{Form::open(['url' => 'admin/time_prices/'.$venue->id, 'method' => 'delete', 'id'=>'delete'])}}
    @csrf
    {{ Form::close() }}
  </div>
</div>


<script>
  $(function() {
    // プラスボタンクリック
    $(document).on("click", ".add", function() {
      $(this).parent().parent().clone().insertAfter($(this).parent().parent());
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

        $('.table tbody tr').eq(index).find('td').eq(0).find('p').remove();
        $('.table tbody tr').eq(index).find('td').eq(0).append("<p class='is-error-time"+index+"' style='color: red'></p>");
        $('.table tbody tr').eq(index).find('td').eq(1).find('p').remove();
        $('.table tbody tr').eq(index).find('td').eq(1).append("<p class='is-error-price"+index+"' style='color: red'></p>");
        $('.table tbody tr').eq(index).find('td').eq(2).find('p').remove();
        $('.table tbody tr').eq(index).find('td').eq(2).append("<p class='is-error-extend"+index+"' style='color: red'></p>");

      };
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
        var time = "time" + (index);
        var price = "price" + (index);
        var extend = "extend" + (index);
        $('.table tbody tr').eq(index).find('td').find('input, select').eq(0).attr('name', time);
        $('.table tbody tr').eq(index).find('td').find('input, select').eq(1).attr('name', price);
        $('.table tbody tr').eq(index).find('td').find('input, select').eq(2).attr('name', extend);
      }
      validationThis(count);
    });
  });

  var trLength=$(".main_tbody").find("tr").length;
    var rules = {};
    var messages = {};
    for (var i = 0; i < trLength; i++) {
        rules["time"+i] = {
            required: true
        };
        rules["price"+i] = {
            required: true,
            number:true,
            digits:true,
            min:1,
        };
        rules["extend"+i] = {
            required: true,
            number:true,
            digits:true,
            min:1,
        };
        messages["time"+i] = {
            required: "※必須項目です"
        };
        messages["price"+i] = {
          required: "※必須項目です",
          number:"※半角英数字で入力してください",
          min:"1以上を入力してください",
          digits: "※整数で入力してください",
        };
        messages["extend"+i] = {
          required: "※必須項目です",
          number:"※半角英数字で入力してください",
          min:"1以上を入力してください",
          digits: "※整数で入力してください",
        };
    }
      $("#timeEditForm").validate({
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
        $("input[name='time"+index2+"']").rules("add", {
        required: true,
        messages: { required: "※必須項目です" },
        });
        $("input[name='price"+index2+"']").rules("add", {
        required: true,
        number:true,
        min:1,
        digits:true,
        messages: { required: "※必須項目です", number:"※半角英数字で入力してください",min:'※1以上を入力してください', digits: "※整数で入力してください"},
        });
        $("input[name='extend"+index2+"']").rules("add", {
        required: true,
        number:true,
        min:1,
        digits:true,
        messages: { required: "※必須項目です", number:"※半角英数字で入力してください",min:'※1以上を入力してください',digits: "※整数で入力してください"},
        });
      }
    }





  // $(function() {
  //   $(".del").on("click", function() {
  //     if (!confirm('本当に削除しますか？\n削除した時点で会場情報・顧客側予約フォームからも削除されます')) {
  //       return false;
  //     }
  //   })
  // })

</script>

@endsection