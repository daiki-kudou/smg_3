@extends('layouts.admin.app')

@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script> 
{{-- <script src="{{ asset('/js/admin/template.js') }}"></script> --}}
<script src="{{ asset('/js/admin/reservation.js') }}"></script>
<script src="{{ asset('/js/admin/validation.js') }}"></script>

<style>
  .hide {
    display: none;
  }
</style>

<div class="container-fluid">

  <h2 class="mt-3 mb-3">追加請求書　編集</h2>
  <hr>

  {{ Form::open(['url' => 'admin/bills/'.$bill->id, 'method'=>'PUT', 'id'=>'billsEditForm']) }}
  @csrf

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
                  <td colspan="5">
                    <div class="venue_chkbox">
                      <input type="checkbox" id="venue" name="venue" value="1">
                      <label for="venue">会場料</label>
                    </div>
                  </td>
                </tr>
              </tbody>
              <tbody class="venue_head">
                <tr>
                  <td>内容</td>
                  <td>単価</td>
                  <td>数量</td>
                  <td>金額</td>
                  <td>追加/削除</td>
                </tr>
              </tbody>
              <tbody class="venue_main">
                @if (count($bill->breakdowns()->where('unit_type',1)->get())!=0)
                @foreach ($bill->breakdowns()->where('unit_type',1)->get() as $key=>$venue)
                <tr>
                  <td>
                    {{Form::text('venue_breakdown_item'.$key,$venue->unit_item,['class'=>'form-control'])}}
                  </td>
                  <td>
                    {{Form::text('venue_breakdown_cost'.$key,$venue->unit_cost,['class'=>'form-control'])}}
                  </td>
                  <td>
                    {{Form::text('venue_breakdown_count'.$key,$venue->unit_count,['class'=>'form-control number_validation'])}}
                  </td>
                  <td>
                    {{Form::text('venue_breakdown_subtotal'.$key,$venue->unit_subtotal,['class'=>'form-control','readonly'])}}
                  </td>
                  <td>
                    <input type="button" value="＋" class="add pluralBtn bg-blue">
                    <input type="button" value="ー" class="del pluralBtn bg-red">
                  </td>
                </tr>
                @endforeach
                @else
                <tr>
                  <td>
                    {{Form::text('venue_breakdown_item0','',['class'=>'form-control'])}}
                  </td>
                  <td>
                    {{Form::text('venue_breakdown_cost0','',['class'=>'form-control'])}}
                  </td>
                  <td>
                    {{Form::text('venue_breakdown_count0','',['class'=>'form-control number_validation'])}}
                  </td>
                  <td>
                    {{Form::text('venue_breakdown_subtotal0','',['class'=>'form-control','readonly'])}}
                  </td>
                  <td>
                    <input type="button" value="＋" class="add pluralBtn bg-blue">
                    <input type="button" value="ー" class="del pluralBtn bg-red">
                  </td>
                </tr>
                @endif
              </tbody>
              <tbody class="venue_result">
                <tr>
                  <td colspan="4"></td>
                  <td colspan="1">
                    <p class="text-left">合計</p>
                    {{Form::text('venue_price',$bill->venue_price,['class'=>'form-control','readonly'])}}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="equipment billdetails_content">
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td colspan="5">
                    <div class="equipment_chkbox">
                      <input type="checkbox" id="equipment" name="equipment" value="1">
                      <label for="equipment">有料備品・サービス料</label>
                    </div>
                  </td>
                </tr>
              </tbody>
              <tbody class="equipment_head">
                <tr>
                  <td>内容</td>
                  <td>単価</td>
                  <td>数量</td>
                  <td>金額</td>
                  <td>追加/削除</td>
                </tr>
              </tbody>
              <tbody class="equipment_main">
                @if (count($bill->breakdowns()->where('unit_type',2)->get())!=0)
                @foreach ($bill->breakdowns()->where('unit_type',2)->get() as $key=>$equ)
                <tr>
                  <td>
                    {{Form::text('equipment_breakdown_item'.$key,$equ->unit_item,['class'=>'form-control'])}}
                  </td>
                  <td>
                    {{Form::text('equipment_breakdown_cost'.$key,$equ->unit_cost,['class'=>'form-control'])}}
                  </td>
                  <td>
                    {{Form::text('equipment_breakdown_count'.$key,$equ->unit_count,['class'=>'form-control number_validation'])}}
                  </td>
                  <td>
                    {{Form::text('equipment_breakdown_subtotal'.$key,$equ->unit_subtotal,['class'=>'form-control','readonly'])}}
                  </td>
                  <td>
                    <input type="button" value="＋" class="add pluralBtn bg-blue">
                    <input type="button" value="ー" class="del pluralBtn bg-red">
                  </td>
                </tr>
                @endforeach
                @else
                <tr>
                  <td>
                    {{Form::text('equipment_breakdown_item0','',['class'=>'form-control'])}}
                  </td>
                  <td>
                    {{Form::text('equipment_breakdown_cost0','',['class'=>'form-control'])}}
                  </td>
                  <td>
                    {{Form::text('equipment_breakdown_count0','',['class'=>'form-control number_validation'])}}
                  </td>
                  <td>
                    {{Form::text('equipment_breakdown_subtotal0','',['class'=>'form-control','readonly'])}}
                  </td>
                  <td>
                    <input type="button" value="＋" class="add pluralBtn bg-blue">
                    <input type="button" value="ー" class="del pluralBtn bg-red">
                  </td>
                </tr>
                @endif

              </tbody>
              <tbody class="equipment_result">
                <tr>
                  <td colspan="4"></td>
                  <td colspan="1">
                    <p class="text-left">合計</p>
                    {{Form::text('equipment_price',$bill->equipment_price,['class'=>'form-control','readonly'])}}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="layout billdetails_content">
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td colspan="5">
                    <div class="layout_chkbox">
                      <input type="checkbox" id="layout" name="layout" value="1" {{ !empty(session('add_bill')['layout_price'])?"checked":"" }}>
                      <label for="layout">レイアウト変更料</label>
                    </div>
                  </td>
                </tr>
              </tbody>
              <tbody class="layout_head">
                <tr>
                  <td>内容</td>
                  <td>単価</td>
                  <td>数量</td>
                  <td>金額</td>
                  <td>追加/削除</td>
                </tr>
              </tbody>
              <tbody class="layout_main">
                @if (count($bill->breakdowns()->where('unit_type',4)->get())!=0)
                @foreach ($bill->breakdowns()->where('unit_type',4)->get() as $key=>$lay)
                <tr>
                  <td>
                    {{Form::text('layout_breakdown_item'.$key,$lay->unit_item,['class'=>'form-control'])}}
                  </td>
                  <td>
                    {{Form::text('layout_breakdown_cost'.$key,$lay->unit_cost,['class'=>'form-control'])}}
                  </td>
                  <td>
                    {{Form::text('layout_breakdown_count'.$key,$lay->unit_count,['class'=>'form-control number_validation'])}}
                  </td>
                  <td>
                    {{Form::text('layout_breakdown_subtotal'.$key,$lay->unit_subtotal,['class'=>'form-control','readonly'])}}
                  </td>
                  <td>
                    <input type="button" value="＋" class="add pluralBtn bg-blue">
                    <input type="button" value="ー" class="del pluralBtn bg-red">
                  </td>
                </tr>
                @endforeach
                @else
                <tr>
                  <td>
                    {{Form::text('layout_breakdown_item0','',['class'=>'form-control'])}}
                  </td>
                  <td>
                    {{Form::text('layout_breakdown_cost0','',['class'=>'form-control'])}}
                  </td>
                  <td>
                    {{Form::text('layout_breakdown_count0','',['class'=>'form-control number_validation'])}}
                  </td>
                  <td>
                    {{Form::text('layout_breakdown_subtotal0','',['class'=>'form-control','readonly'])}}
                  </td>
                  <td>
                    <input type="button" value="＋" class="add pluralBtn bg-blue">
                    <input type="button" value="ー" class="del pluralBtn bg-red">
                  </td>
                </tr>
                @endif


              </tbody>
              <tbody class="layout_result">
                <tr>
                  <td colspan="4"></td>
                  <td colspan="1">
                    <p class="text-left">合計</p>
                    {{Form::text('layout_price',$bill->layout_price,['class'=>'form-control','readonly'])}}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>


          <div class="others billdetails_content">
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td colspan="5">
                    <div class="others_chkbox">
                      <input type="checkbox" id="others" name="others" value="1" {{ !empty(session('add_bill')['others_price'])?"checked":"" }}>
                      <label for="others">その他</label>
                    </div>
                  </td>
                </tr>
              </tbody>
              <tbody class="others_head">
                <tr>
                  <td>内容</td>
                  <td>単価</td>
                  <td>数量</td>
                  <td>金額</td>
                  <td>追加/削除</td>
                </tr>
              </tbody>
              <tbody class="others_main">
                @if (count($bill->breakdowns()->where('unit_type',5)->get())!=0)
                @foreach ($bill->breakdowns()->where('unit_type',5)->get() as $key=>$other)
                <tr>
                  <td>
                    {{Form::text('others_breakdown_item'.$key,$other->unit_item,['class'=>'form-control'])}}
                  </td>
                  <td>
                    {{Form::text('others_breakdown_cost'.$key,$other->unit_cost,['class'=>'form-control'])}}
                  </td>
                  <td>
                    {{Form::text('others_breakdown_count'.$key,$other->unit_count,['class'=>'form-control number_validation'])}}
                  </td>
                  <td>
                    {{Form::text('others_breakdown_subtotal'.$key,$other->unit_subtotal,['class'=>'form-control','readonly'])}}
                  </td>
                  <td>
                    <input type="button" value="＋" class="add pluralBtn bg-blue">
                    <input type="button" value="ー" class="del pluralBtn bg-red">
                  </td>
                </tr>
                @endforeach
                @else
                <tr>
                  <td>
                    {{Form::text('others_breakdown_item0', '',['class'=>'form-control'])}}
                  </td>
                  <td>
                    {{Form::text('others_breakdown_cost0', '',['class'=>'form-control'])}}
                  </td>
                  <td>
                    {{Form::text('others_breakdown_count0', '',['class'=>'form-control number_validation'])}}
                  </td>
                  <td>
                    {{Form::text('others_breakdown_subtotal0', '',['class'=>'form-control','readonly'])}}
                  </td>
                  <td>
                    <input type="button" value="＋" class="add pluralBtn bg-blue">
                    <input type="button" value="ー" class="del pluralBtn bg-red">
                  </td>
                </tr>
                @endif
              </tbody>
              <tbody class="others_result">
                <tr>
                  <td colspan="4"></td>
                  <td colspan="1">
                    <p class="text-left">合計</p>
                    {{Form::text('others_price',$bill->others_price,['class'=>'form-control','readonly'])}}
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
                    {{Form::text('master_subtotal', $bill->master_subtotal,['class'=>'form-control','readonly'])}}
                  </td>
                </tr>
                <tr>
                  <td>消費税：</td>
                  <td>
                    {{Form::text('master_tax', $bill->master_tax,['class'=>'form-control','readonly'])}}
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold">合計金額</td>
                  <td>
                    {{Form::text('master_total', $bill->master_total,['class'=>'form-control','readonly'])}}
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
                  <td>請求日：
                    {{Form::text('bill_created_at', $bill->bill_created_at,['class'=>'form-control', 'datepicker1'])}}

                  </td>
                  <td>支払期日
                    {{Form::text('payment_limit', $bill->payment_limit,['class'=>'form-control', 'datepicker1'])}}
                  </td>
                </tr>
                <tr>
                  <td>請求書宛名
                    {{Form::text('bill_company', $bill->bill_company,['class'=>'form-control', 'datepicker1'])}}
                  </td>
                  <td>
                    担当者
                    {{Form::text('bill_person', $bill->bill_person,['class'=>'form-control', 'datepicker1'])}}
                  </td>
                </tr>
                <tr>
                  <td colspan="2">請求書備考
                    {{Form::textarea('bill_remark', $bill->bill_remark,['class'=>'form-control', 'datepicker1'])}}
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
                    {{Form::select('paid', ['未入金', '入金済み'],$bill->paid,['class'=>'form-control'])}}
                  </td>
                  <td>
                    入金日
                    {{Form::text('pay_day', $bill->pay_day,['class'=>'form-control'])}}
                  </td>
                </tr>
                <tr>
                  <td>振込人名
                    {{Form::text('pay_person', $bill->pay_person,['class'=>'form-control'])}}
                    <p class="is-error-pay_person" style="color: red"></p>
                  </td>
                  <td>入金額
                    {{Form::text('payment', $bill->payment,['class'=>'form-control'])}}
                    <p class="is-error-payment" style="color: red"></p>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
  {{Form::submit('保存する', ['class'=>'btn d-block more_btn_lg mx-auto my-5', 'id'=>''])}}
  {{Form::close()}}
</div>
@endsection