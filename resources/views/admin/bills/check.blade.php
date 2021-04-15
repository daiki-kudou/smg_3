@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/add_bill_ajax.js') }}"></script>
<script src="{{ asset('/js/template.js') }}"></script>

<h2 class="mt-3 mb-3">追加請求書　確認画面</h2>
<hr>

{{ Form::open(['route' => 'admin.bills.store', 'method'=>'POST']) }}
@csrf
{{ Form::hidden('reservation_id', $request->reservation_id, ['class' => 'form-control'])}}

<section class="mt-5">
  <div class="bill">
    <div class="bill_details">
      <div class="head d-flex">
        <div class="accordion_btn">
          <i class="fas fa-plus bill_icon_size hide" aria-hidden="true"></i>
          <i class="fas fa-minus bill_icon_size" aria-hidden="true"></i>
        </div>
        <div class="billdetails_ttl">
          <h3>
            請求内訳
          </h3>
        </div>
      </div>
      <div class="main">
        <div class="venues billdetails_content">
          <table class="table table-borderless">
            <tbody>
              <tr>
                <td>
                  <h4 class="billdetails_content_ttl">
                    会場料
                  </h4>
                </td>
              </tr>
            </tbody>
            <tbody class="venue_head">
              <tr>
                <td>内容</td>
                <td>単価</td>
                <td>数量</td>
                <td>金額</td>
              </tr>
            </tbody>
            <tbody class="venue_main">
              @for ($i = 0; $i < $venues; $i++) <tr>
                <td>
                  {{ Form::text('venue_breakdown_item'.$i, $request->{'venue_breakdown_item'.$i},['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_cost'.$i, $request->{'venue_breakdown_cost'.$i},['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_count'.$i, $request->{'venue_breakdown_count'.$i},['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_subtotal'.$i, $request->{'venue_breakdown_subtotal'.$i},['class'=>'form-control', 'readonly'] ) }}
                </td>
                </tr>
                @endfor
            </tbody>
            <tbody class="venue_result">
              <tr>
                <td colspan="3"></td>
                <td colspan="1">
                <p class="text-left">合計</p>
                  {{ Form::text('venue_price',$request->venue_price,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="equipment billdetails_content">
          <table class="table table-borderless">
            <tbody>
              <tr>
                <td colspan="4">
                  <h4 class="billdetails_content_ttl">
                    有料備品・サービス
                  </h4>
                </td>
              </tr>
            </tbody>
            <tbody class="equipment_head">
              <tr>
                <td>内容</td>
                <td>単価</td>
                <td>数量</td>
                <td>金額</td>
              </tr>
            </tbody>
            <tbody class="equipment_main">
              @for ($i = 0; $i < $equipments; $i++) <tr>
                <td>
                  {{ Form::text('equipment_breakdown_item'.$i,$request->{'equipment_breakdown_item'.$i} ,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_cost'.$i,$request->{'equipment_breakdown_cost'.$i} ,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_count'.$i,$request->{'equipment_breakdown_count'.$i} ,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_subtotal'.$i,$request->{'equipment_breakdown_subtotal'.$i} ,['class'=>'form-control', 'readonly'] ) }}
                </td>
                </tr>
                @endfor
            </tbody>
            <tbody class="equipment_result">
              <tr>
                <td colspan="3"></td>
                <td colspan="1">
                <p class="text-left">合計</p>
                  {{ Form::text('equipment_price',$request->equipment_price,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="layout billdetails_content">
          <table class="table table-borderless">
            <tbody>
              <tr>
                <td>
                  <h4 class="billdetails_content_ttl">
                    レイアウト
                  </h4>
                </td>
              </tr>
            </tbody>
            <tbody class="layout_head">
              <tr>
                <td>内容</td>
                <td>単価</td>
                <td>数量</td>
                <td>金額</td>
              </tr>
            </tbody>
            <tbody class="layout_main">
              @for ($i = 0; $i < $layouts; $i++) <tr>
                <td>
                  {{ Form::text('layout_breakdown_item'.$i,$request->{'layout_breakdown_item'.$i} ,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_breakdown_cost'.$i,$request->{'layout_breakdown_cost'.$i} ,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_breakdown_count'.$i,$request->{'layout_breakdown_count'.$i} ,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_breakdown_subtotal'.$i,$request->{'layout_breakdown_subtotal'.$i} ,['class'=>'form-control', 'readonly'] ) }}
                </td>
                </tr>
                @endfor
            </tbody>
            <tbody class="layout_result">
              <tr>
                <td colspan="3"></td>
                <td colspan="1">
                <p class="text-left">合計</p>
                  {{ Form::text('layout_price',$request->layout_price,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>


        <div class="others billdetails_content">
          <table class="table table-borderless">
            <tbody>
              <tr>
                <td colspan="4">
                  　<h4 class="billdetails_content_ttl">
                    その他
                  </h4>
                </td>
              </tr>
            </tbody>
            <tbody class="others_head">
              <tr>
                <td>内容</td>
                <td>単価</td>
                <td>数量</td>
                <td>金額</td>
              </tr>
            </tbody>
            <tbody class="others_main">
              @for ($i = 0; $i < $others; $i++) <tr>
                <td>
                  {{ Form::text('others_breakdown_item'.$i,$request->{'others_breakdown_item'.$i} ,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('others_breakdown_cost'.$i,$request->{'others_breakdown_cost'.$i} ,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('others_breakdown_count'.$i,$request->{'others_breakdown_count'.$i} ,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('others_breakdown_subtotal'.$i,$request->{'others_breakdown_subtotal'.$i} ,['class'=>'form-control', 'readonly'] ) }}
                </td>
                </tr>
                @endfor
            </tbody>
            <tbody class="others_result">
              <tr>
                <td colspan="3"></td>
                <td colspan="1">
                <p class="text-left">合計</p>
                  {{ Form::text('others_price',$request->others_price,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>


        <div class="bill_total">
          <table class="table text-right">
            <tbody>
              <tr>
                <td>小計：</td>
                <td>
                  {{ Form::text('master_subtotal',$request->master_subtotal,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td>消費税：</td>
                <td>
                  {{ Form::text('master_tax',$request->master_tax,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td class="font-weight-bold">合計金額</td>
                <td>
                  {{ Form::text('master_total',$request->master_total,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>


  <div class="information">
    <div class="information_details">
      <div class="head d-flex">
        <div class="accordion_btn">
          <i class="fas fa-plus bill_icon_size hide" aria-hidden="true"></i>
          <i class="fas fa-minus bill_icon_size" aria-hidden="true"></i>
        </div>
        <div class="billdetails_ttl">
          <h3>
            請求書情報
          </h3>
        </div>
      </div>
      <div class="main">
        <div class="informations billdetails_content">
          <table class="table">
            <tbody>
              <tr>
                <td>請求日：</td>
                <td>支払期日：
                  {{ Form::text('payment_limit',$request->pay_limit,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td>請求書宛名
                  {{ Form::text('bill_company',$request->pay_company,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  担当者
                  {{ Form::text('bill_person',$request->bill_person,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td colspan="2">請求書備考
                  {{ Form::textarea('bill_remark',$request->bill_remark,['class'=>'form-control', 'readonly'] ) }}
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
        <div class="d-flex align-items-center">
          <h3 class="pl-3">
            入金情報
          </h3>
        </div>
      </div>
      <div class="main">
        <div class="paids billdetails_content">
          <table class="table">
            <tbody>
              <tr>
                <td>入金状況
                  {{ Form::text('',$request->paid==0?"未入金":"支払済",['class'=>'form-control', 'readonly'] ) }}
                  {{ Form::hidden('paid',$request->paid,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  入金日
                  {{ Form::text('pay_day',$request->pay_day,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td>振込人名
                  {{ Form::text('pay_person',$request->pay_person,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>入金額
                  {{ Form::text('payment',$request->payment,['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

{{ Form::submit('追加請求書を確定する', ['class' => 'btn more_btn_lg mx-auto d-block mt-5']) }}

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