@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/admin/cxl/validation.js') }}"></script>

<h2 class="mt-3 mb-3">キャンセル請求書 作成</h2>
<hr>

@include('layouts.admin.errors')




<section class="mt-5">
  <div class="bill">
    <div class="bill_details">
      <div class="head d-flex">
        <div class="accordion_btn">
          <i class="fas fa-plus bill_icon_size hide" aria-text="true"></i>
          <i class="fas fa-minus bill_icon_size" aria-text="true"></i>
        </div>
        <div class="billdetails_ttl">
          <h3>
            請求内訳
          </h3>
        </div>
      </div>
      <div class="main">
        {{ Form::open(['url' => '/admin/cxl/multi_calc', 'method'=>'get','id'=>'cxlcalc']) }}
        @csrf
        {{Form::hidden('reservation_id',old('reservation_id',$reservation->id))}}
        {{Form::hidden('user_id',old('user_id',!empty($reservation->user_id)?$reservation->user_id:0))}}
        {{Form::hidden('agent_id',old('agent_id',!empty($reservation->agent_id)?$reservation->agent_id:0))}}
        @if (!empty($bill->id))
        {{Form::hidden('bill_id',old('bill_id',$bill->id))}}
        @else
        {{Form::hidden('bill_id',old('bill_id',0))}}
        @endif
        <div class="cancel_content cancel_border bg-white">
          <h4 class="cancel_ttl">キャンセル料計算</h4>
          <table class="table table-borderless cxl_master">
            <thead class="head_cancel">
              <tr>
                <td>内容</td>
                <td>申込み金額</td>
                <td></td>
                <td>キャンセル料率</td>
              </tr>
            </thead>
            @if ($price_result[0]!=0)
            <tbody class="venue_main_cancel">
              <tr>
                <td>会場料</td>
                <td>{{number_format($price_result[0])}}円
                  {{Form::hidden('venue_price',old('venue_price',$price_result[0]))}}
                </td>
                <td class="multiple">×</td>
                <td>
                  <div class="d-flex align-items-center">
                    {{Form::text('cxl_venue_PC',old('cxl_venue_PC',''),['class'=>'form-control'])}}
                    <span class="ml-1">%</span>
                  </div>
                  <p class="is-error-cxl_venue_PC" style="color: red"></p>
                  {{Form::hidden('cxl_venue',old('cxl_venue',0))}}
                </td>
              </tr>
            </tbody>
            @endif
            @if ($price_result[1]!=0)
            <tbody class="equipment_cancel">
              <tr>
                <td>有料備品・有料サービス料</td>
                <td>{{number_format($price_result[1])}}円
                  {{Form::hidden('equipment_price',old('equipment_price',$price_result[1]))}}
                </td>
                <td class="multiple">×</td>
                <td>
                  <div class="d-flex align-items-center">
                    {{Form::text('cxl_equipment_PC',old('cxl_equipment_PC',""),['class'=>'form-control'])}}
                    <span class="ml-1">%</span>
                  </div>
                  <p class="is-error-cxl_equipment_PC" style="color: red"></p>
                  {{Form::hidden('cxl_equipment',old('cxl_equipment',0))}}
                </td>
              </tr>
            </tbody>
            @endif
            @if ($price_result[2]!=0)
            <tbody class="layout_cancel">
              <tr>
                <td>レイアウト変更料</td>
                <td>{{number_format($price_result[2])}}円
                  {{Form::hidden('layout_price',old('layout_price',$price_result[2]))}}
                </td>
                <td class="multiple">×</td>
                <td>
                  <div class="d-flex align-items-center">
                    {{Form::text('cxl_layout_PC',old('cxl_layout_PC',""),['class'=>'form-control'])}}
                    <span class="ml-1">%</span>
                  </div>
                  <p class="is-error-cxl_layout_PC" style="color: red"></p>
                  {{Form::hidden('cxl_layout',old('cxl_layout',0))}}
                </td>
              </tr>
            </tbody>
            @endif
            @if ($price_result[3]!=0)
            <tbody class="others_cancel">
              <tr>
                <td>その他</td>
                <td>{{number_format($price_result[3])}}円
                  {{Form::hidden('other_price',old('other_price',$price_result[3]))}}
                </td>
                <td class="multiple">×</td>
                <td>
                  <div class="d-flex align-items-center">
                    {{Form::text('cxl_other_PC',old('cxl_other_PC',""),['class'=>'form-control'])}}
                    <span class="ml-1">%</span>
                  </div>
                  <p class="is-error-cxl_other_PC" style="color: red"></p>
                  {{Form::hidden('cxl_other',old('cxl_other',0))}}
                </td>
              </tr>
            </tbody>
            @endif
          </table>
          <div class="w-50 text-right mr-0 ml-auto">
            <div>概算キャンセル料{{Form::text('temp_cxl_price',old('temp_cxl_price',0),['class'=>'form-control','readonly'])}}
            </div>
            <div>調整費{{Form::text('adjust',old('adjust',0),['class'=>'form-control'])}}</div>
            <div>概算キャンセル料調整結果{{Form::text('adjust_result',old('adjust_result',0),['class'=>'form-control','readonly'])}}
            </div>
          </div>
          {{ Form::submit('計算する', ['class' => 'btn more_btn_lg mx-auto d-block my-5']) }}
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  $(function(){
    var result = 0;
    var tr_length=$('.cxl_master tbody tr').length;
    for (let index = 0; index < tr_length; index++) {
    var cost =$('.cxl_master tbody tr').eq(index).find('td').eq(1).find('input').val();
    var percent = $('.cxl_master tbody tr').eq(index).find('td').eq(3).find('input').eq(0).val();
    var calc = Math.floor(Number(cost)*Number((percent/100)));
    $('.cxl_master tbody tr').eq(index).find('td').eq(3).find('input').eq(1).val(calc);
    result+=calc;
    }
    result=Math.floor(result);
    $('input[name="temp_cxl_price"]').val(result);
    $('input[name="adjust_result"]').val(result);

    var target_cxl=Number($('input[name="temp_cxl_price"]').val());
    var this_val=$('input[name="adjust"]').val();
    var result = Number(target_cxl)+Number(this_val);
    var calc =Math.floor(result);
    result=calc;
    $('input[name="adjust_result"]').val(result);
})
</script>
<script>
  $(function(){
  $('.cxl_master input').on('input',function(){
    var result = 0;
    var tr_length=$('.cxl_master tbody tr').length;
    for (let index = 0; index < tr_length; index++) {
    var cost =$('.cxl_master tbody tr').eq(index).find('td').eq(1).find('input').val();
    var percent = $('.cxl_master tbody tr').eq(index).find('td').eq(3).find('input').eq(0).val();
    var calc = Math.floor(Number(cost)*Number((percent/100)));
    $('.cxl_master tbody tr').eq(index).find('td').eq(3).find('input').eq(1).val(calc);
    result+=calc;
    }
    result=Math.floor(result);
    $('input[name="temp_cxl_price"]').val(result);
    $('input[name="adjust_result"]').val(result);
  })

  $('input[name="adjust"]').on('input',function(){
    var target_cxl=Number($('input[name="temp_cxl_price"]').val());
    var this_val=Number($(this).val());
    var result = Number(target_cxl)+Number(this_val);
    var calc =Math.floor(result);
    result=calc;
    $('input[name="adjust_result"]').val(result);
  })
})
</script>
</section>





@endsection