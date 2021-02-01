@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/add_bill_ajax.js') }}"></script>
<script src="{{ asset('/js/template.js') }}"></script>

<h1>追加請求書　確認画面</h1>

{{ Form::open(['route' => 'admin.bills.store', 'method'=>'POST']) }}
@csrf
{{ Form::hidden('reservation_id', $requests['reservation_id'], ['class' => 'form-control'])}}

<div class="container-fluid">
  <div class="bill">
    <div class="bill_details">
      <div class="head d-flex">
        <div style="width: 80px; background:gray;" class="d-flex justify-content-center align-items-center">
          <i class="fas fa-plus fa-3x hide" style="color: white;" aria-hidden="true"></i>
          <i class="fas fa-minus fa-3x" style="color: white;" aria-hidden="true"></i>
        </div>
        <div style="font-size: 30px; width:200px;" class="d-flex justify-content-center align-items-center">
          <p>
            請求内訳
          </p>
        </div>
      </div>
      <div class="main">
        @if ($requests['venue_price'])
        <div class="venues" style="padding-top: 80px; width:90%; margin:0 auto;">
          <table class="table table-borderless">
            <tbody>
              <tr>
                <td colspan="4">
                  <h1>
                    ■会場料
                  </h1>
                </td>
              </tr>
            </tbody>
            <tbody class="venue_head ">
              <tr>
                <td>内容</td>
                <td>単価</td>
                <td>数量</td>
                <td>金額</td>
              </tr>
            </tbody>
            <tbody class="venue_main ">
              @for ($i = 0; $i < (count($s_venues)/4); $i++)
                @if($s_venues[$i*4]&&$s_venues[($i*4)+1]&&$s_venues[($i*4)+2]&&$s_venues[($i*4)+3]) <tr>
                <td>
                  {{ Form::text('venue_breakdown_item'.$i, $s_venues[$i*4],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_cost'.$i, $s_venues[($i*4)+1],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_count'.$i, $s_venues[($i*4)+2],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_subtotal'.$i, $s_venues[($i*4)+3],['class'=>'form-control', 'readonly'] ) }}
                </td>
                </tr>
                @endif
                @endfor
            </tbody>
            <tbody class="venue_result ">
              <tr>
                <td colspan="2"></td>
                <td colspan="2">合計
                  {{ Form::text('venue_price',$requests['venue_price'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        @endif

        @if ($requests['equipment_price'])
        <div class="equipment" style="padding-top: 80px; width:90%; margin:0 auto;">
          <table class="table table-borderless">
            <tbody>
              <tr>
                <td colspan="4">
                  <h1>
                    ■有料備品・サービス料
                  </h1>
                </td>
              </tr>
            </tbody>
            <tbody class="equipment_head ">
              <tr>
                <td>内容</td>
                <td>単価</td>
                <td>数量</td>
                <td>金額</td>
              </tr>
            </tbody>
            <tbody class="equipment_main ">
              @for ($i = 0; $i < (count($s_equipments)/4); $i++)
                @if($s_equipments[$i*4]&&$s_equipments[($i*4)+1]&&$s_equipments[($i*4)+2]&&$s_equipments[($i*4)+3]) <tr>
                <td>
                  {{ Form::text('equipment_breakdown_item'.$i, $s_equipments[$i*4],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_cost'.$i, $s_equipments[($i*4)+1],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_count'.$i, $s_equipments[($i*4)+2],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_subtotal'.$i, $s_equipments[($i*4)+3],['class'=>'form-control', 'readonly'] ) }}
                </td>
                </tr>
                @endif
                @endfor
            </tbody>
            <tbody class="equipment_result ">
              <tr>
                <td colspan="2"></td>
                <td colspan="2">合計
                  {{ Form::text('equipment_price',$requests['equipment_price'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        @endif

        @if ($requests['layout_price'])
        <div class="layout" style="padding-top: 80px; width:90%; margin:0 auto;">
          <table class="table table-borderless">
            <tbody>
              <tr>
                <td colspan="4">
                  <h1>
                    ■ レイアウト変更料
                  </h1>
                </td>
              </tr>
            </tbody>
            <tbody class="layout_head ">
              <tr>
                <td>内容</td>
                <td>単価</td>
                <td>数量</td>
                <td>金額</td>
              </tr>
            </tbody>
            <tbody class="layout_main ">
              @for ($i = 0; $i < (count($s_layouts)/4); $i++)
                @if($s_layouts[$i*4]&&$s_layouts[($i*4)+1]&&$s_layouts[($i*4)+2]&&$s_layouts[($i*4)+3]) <tr>
                <td>
                  {{ Form::text('layout_breakdown_item'.$i, $s_layouts[$i*4],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_breakdown_cost'.$i, $s_layouts[($i*4)+1],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_breakdown_count'.$i, $s_layouts[($i*4)+2],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_breakdown_subtotal'.$i, $s_layouts[($i*4)+3],['class'=>'form-control', 'readonly'] ) }}
                </td>
                </tr>
                @endif
                @endfor
            </tbody>
            <tbody class="layout_result ">
              <tr>
                <td colspan="2"></td>
                <td colspan="2">合計
                  {{ Form::text('layout_price',$requests['layout_price'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        @endif


        @if ($requests['others_price'])
        <div class="others" style="padding: 80px 0px 80px 0px; width:90%; margin:0 auto;">
          <table class="table table-borderless">
            <tbody>
              <tr>
                <td colspan="4">
                  <h1>
                    ■その他
                  </h1>
                </td>
              </tr>
            </tbody>
            <tbody class="others_head ">
              <tr>
                <td>内容</td>
                <td>単価</td>
                <td>数量</td>
                <td>金額</td>
              </tr>
            </tbody>
            <tbody class="others_main ">
              @for ($i = 0; $i < (count($s_others)/4); $i++)
                @if($s_others[$i*4]&&$s_others[($i*4)+1]&&$s_others[($i*4)+2]&&$s_others[($i*4)+3]) <tr>
                <td>
                  {{ Form::text('others_breakdown_item'.$i, $s_others[$i*4],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('others_breakdown_cost'.$i, $s_others[($i*4)+1],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('others_breakdown_count'.$i, $s_others[($i*4)+2],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('others_breakdown_subtotal'.$i, $s_others[($i*4)+3],['class'=>'form-control', 'readonly'] ) }}
                </td>
                </tr>
                @endif
                @endfo
            </tbody>
            <tbody class="others_result ">
              <tr>
                <td colspan="2"></td>
                <td colspan="3">合計
                  {{ Form::text('others_price',$requests['others_price'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        @endif


        <div class="bill_total d-flex justify-content-end"
          style="padding: 80px 0px 80px 0px; width:90%; margin:0 auto; background:">
          <div style="width: 60%;">
            <table class="table text-right" style="table-layout: fixed; font-size:16px;">
              <tbody>
                <tr>
                  <td>小計：</td>
                  <td>
                    {{ Form::text('master_subtotal',$requests['master_subtotal'],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                </tr>
                <tr>
                  <td>消費税：</td>
                  <td>
                    {{ Form::text('master_tax',$requests['master_tax'],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold">合計金額</td>
                  <td>
                    {{ Form::text('master_total',$requests['master_total'],['class'=>'form-control', 'readonly'] ) }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="information">
    <div class="information_details">
      <div class="head d-flex">
        <div style="width: 80px; background:gray;" class="d-flex justify-content-center align-items-center">
          <i class="fas fa-plus fa-3x hide" style="color: white;" aria-hidden="true"></i>
          <i class="fas fa-minus fa-3x" style="color: white;" aria-hidden="true"></i>
        </div>
        <div style="font-size: 30px; width:200px;" class="d-flex justify-content-center align-items-center">
          <p>
            請求書情報
          </p>
        </div>
      </div>
      <div class="main">
        <div class="informations" style="padding-top: 20px; width:90%; margin:0 auto;">
          <table class="table" style="table-layout: fixed;">
            <tbody>
              <tr>
                <td>請求日：</td>
                <td>支払期日：
                  {{ Form::text('pay_limit',$requests['pay_limit'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td>請求書宛名
                  {{ Form::text('pay_company',$requests['pay_company'],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  担当者
                  {{ Form::text('bill_person',$requests['bill_person'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td colspan="2">請求書備考
                  {{ Form::textarea('bill_remark',$requests['bill_remark'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>


  <div class="paid">
    <div class="paid_details">
      <div class="head d-flex">
        <div style="width: 80px; background:#ff782d;" class="d-flex justify-content-center align-items-center">
        </div>
        <div style="font-size: 30px; width:200px;" class="d-flex justify-content-center align-items-center">
          <p>
            入金情報
          </p>
        </div>
      </div>
      <div class="main">
        <div class="paids" style="padding-top: 20px; width:90%; margin:0 auto;">
          <table class="table" style="table-layout: fixed;">
            <tbody>
              <tr>
                <td>入金状況
                  {{ Form::text('',$requests['paid']==0?"未入金":"支払済",['class'=>'form-control', 'readonly'] ) }}
                  {{ Form::hidden('paid',$requests['paid'],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  入金日
                  {{ Form::text('pay_day',$requests['pay_day'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td>振込人名
                  {{ Form::text('pay_person',$requests['pay_person'],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>入金額
                  {{ Form::text('payment',$requests['payment'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

{{ Form::submit('作成する', ['class' => 'btn btn-primary btn-block']) }}

{{ Form::close() }}


{{-- {{ Form::model($request->reservation, ['route' => 'admin.bills.store']) }}
@csrf
{{ Form::hidden('reservation_id', $request->reservation, ['class' => 'form-control', 'readonly']) }}

<table class="table table-borderd">
  <thead>
    <tr>
      <th colspan='4'>結果</th>
    </tr>
    <tr>
      <th colspan="2">割引料金 <p>
          {{ Form::text('name', $request->discount_input, ['class' => 'form-control', 'readonly']) }}
        </p>
      </th>
      <th colspan="2">割引率</th>
    </tr>
    <tr>
      <th>内容</th>
      <th>単価</th>
      <th>個数</th>
      <th>合計</th>
    </tr>
  </thead>
  <tbody>
    @for ($i = 0; $i < $counter; $i++) <tr>
      <td>
        {{ Form::text('master_arrays['.$i.'][unit_item]', $master_arrays[$i*4],['class'=>'form-control', 'readonly'] ) }}
      </td>
      <td>
        {{ Form::text('master_arrays['.$i.'][unit_cost]', $master_arrays[($i*4)+1],['class'=>'form-control', 'readonly'] ) }}
      </td>
      <td>
        {{ Form::text('master_arrays['.$i.'][unit_count]', $master_arrays[($i*4+2)],['class'=>'form-control', 'readonly'] ) }}
      </td>
      <td>
        {{ Form::text('master_arrays['.$i.'][unit_subtotal]', $master_arrays[($i*4+3)],['class'=>'form-control', 'readonly'] ) }}
      </td>
      @if ($request->billcategory==1)
      {{ Form::hidden('unit_type', 2 )}}
      @elseif ($request->billcategory==2)
      {{ Form::hidden('unit_type', 3 )}}
      @elseif ($request->billcategory==3)
      {{ Form::hidden('unit_type', 4 )}}
      @endif
      </tr>
      @endfor
      @if ($request->discount_input)
      <tr>
        <td>
          {{ Form::text('discount_item', '割引料金',['class'=>'form-control', 'readonly'] ) }}
        </td>
        <td>
          {{ Form::text('discount_input', $request->discount_input,['class'=>'form-control', 'readonly'] ) }}
        </td>
        <td>
          {{ Form::text('discount_count', 1,['class'=>'form-control', 'readonly'] ) }}
        </td>
        <td>
          {{ Form::text('discount_total', $request->discount_input,['class'=>'form-control', 'readonly'] ) }}
        </td>
      </tr>
      @endif
  </tbody>
</table>

<div>
  割引前： {{ Form::text('sub_total',$request->sub_total    ,['class'=>'form-control', 'readonly'] ) }}
  割引料金：{{ Form::text('discount_input',  $request->discount_input  ,['class'=>'form-control', 'readonly'] ) }}
  小計：{{ Form::text('after_dicsount',  $request->after_dicsount  ,['class'=>'form-control', 'readonly'] ) }}
  消費税：{{ Form::text('tax',   $request->tax ,['class'=>'form-control', 'readonly'] ) }}
  合計：{{ Form::text('total', $request->total   ,['class'=>'form-control', 'readonly'] ) }}

</div>




{{ Form::submit('更新', ['class' => 'btn btn-primary btn-block']) }}
{{ Form::close() }} --}}















@endsection