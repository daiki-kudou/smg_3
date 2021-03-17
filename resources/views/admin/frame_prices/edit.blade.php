@extends('layouts.admin.app')

@section('content')
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/validation.js') }}"></script>
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/ctrl_form.js') }}"></script>

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
  <h3 class="d-block mt-3 mb-5 price_ttl"><span class="mr-3">ID:{{ ReservationHelper::IdFormat($venue->id)}}</span>
    {{ $venue->name_area }}・{{ $venue->name_bldg }}{{ $venue->name_venue }}
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
      {{ Form::model($venue, ['route' => ['admin.frame_prices.update', $venue->id], 'method' => 'put', 'id'=>'dateCreateForm']) }}
      @csrf

      <p class="mb-2 text-right">※枠は「午前」「午後」「夜間」「午前＆午後」「午後＆夜間」「終日」です。</p>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>枠</th>
            <td>時間（開始）</td>
            <td>時間（終了）</td>
            <td>料金<span class="ml-1 annotation">※税抜</span></td>
            <td>追加・削除</td>
          </tr>
        </thead>
        <tbody>
          @foreach ($frame_prices as $num=>$frame_price)
          <tr>
            <td>
              {{ Form::text('frame'.$num, old('frame', $frame_price->frame), ['class' => 'form-control']) }}
              <p class="{{'is-error-frame'.$num}}" style="color: red"></p>
            </td>
            <td>{{Form::select('start'.$num, [
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
                ],old('start', $frame_price->start),['class'=>'form-control col-sm-12'])}}
            </td>
            <td>{{Form::select('finish'.$num, [
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
                ],old('finish', $frame_price->finish),['class'=>'form-control col-sm-12'])}}</td>
            <td>
              {{ Form::text('price'.$num, old('price', $frame_price->price), ['class' => 'form-control']) }}
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
      <div>
        延長料金(1H)<span class="ml-1 annotation">※税抜</span>
      </div>
      <div>
        {{ Form::text('extend', $frame_price->extend,['class'=>'form-control w-25 mb-2'])}}
        <p class="{{'is-error-extend'}}" style="color: red"></p>
      </div>
      {{Form::hidden('venue_id', $venue->id)}}
      {{ Form::submit('保存する', ['class' => 'btn more_btn_lg mx-auto d-block my-5']) }}
      {{ Form::close() }}
    </div>
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
      $(this).parent().parent().next().find('td').find('input, select').eq(1).val('');
      $(this).parent().parent().next().find('td').find('input, select').eq(2).val('');
      $(this).parent().parent().next().find('td').find('input, select').eq(3).val('');


      for (let index = 0; index < count; index++) {
        var frame = "frame" + (index);
        var start = "start" + (index);
        var finish = "finish" + (index);
        var price = "price" + (index);
        $('.table tbody tr').eq(index).find('td').find('input, select').eq(0).attr('name', frame);
        $('.table tbody tr').eq(index).find('td').find('input, select').eq(1).attr('name', start);
        $('.table tbody tr').eq(index).find('td').find('input, select').eq(2).attr('name', finish);
        $('.table tbody tr').eq(index).find('td').find('input, select').eq(3).attr('name', price);
      }
    });
    //   マイナスボタンクリック
    $(document).on("click", ".del", function() {
      var target = $(this).parent().parent();

      if (target.parent().children().length > 1) {
        target.remove();
      }
      var count = $('.table tbody tr').length;

      for (let index = 0; index < count; index++) {
        var frame = "frame" + (index);
        var start = "start" + (index);
        var finish = "finish" + (index);
        var price = "price" + (index);
        $('.table tbody tr').eq(index).find('td').find('input, select').eq(0).attr('name', frame);
        $('.table tbody tr').eq(index).find('td').find('input, select').eq(1).attr('name', start);
        $('.table tbody tr').eq(index).find('td').find('input, select').eq(2).attr('name', finish);
        $('.table tbody tr').eq(index).find('td').find('input, select').eq(3).attr('name', price);
      }
    });
  });

  $(function(){
    $(".del").on("click",function(){
      if(!confirm('本当に削除しますか？\n削除した時点で会場情報・顧客側予約フォームからも削除されます')){
        return false;
    }
    })
  })
</script>
@endsection