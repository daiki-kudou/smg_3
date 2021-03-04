@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
{{-- <script src="{{ asset('/js/template.js') }}"></script> --}}
{{-- <script src="{{ asset('/js/admin/template.js') }}"></script> --}}
<script src="{{ asset('/js/admin/reservation.js') }}"></script>






<div class="container-fluid">

  <h1>追加請求書　編集画面</h1>

  <form method="POST" action="http://127.0.0.1:8000/admin/bills" accept-charset="UTF-8"><input name="_token"
      type="hidden" value="c1GH2AUHa1ptq3O6IVEQil7MMXWlNgmIeduTnpmP">
    <input type="hidden" name="_token" value="c1GH2AUHa1ptq3O6IVEQil7MMXWlNgmIeduTnpmP"><input class="form-control"
      name="reservation_id" type="hidden" value="1">

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
                    <td>追加/削除</td>
                  </tr>
                </tbody>
                <tbody class="venue_main ">
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
                      {{Form::text('venue_breakdown_count'.$key,$venue->unit_count,['class'=>'form-control'])}}
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
                      {{Form::text('venue_breakdown_count0','',['class'=>'form-control'])}}
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
                <tbody class="venue_result ">
                  <tr>
                    <td colspan="2"></td>
                    <td colspan="2">合計
                      {{Form::text('venue_price',$bill->venue_price,['class'=>'form-control','readonly'])}}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

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
                    <td>追加/削除</td>
                  </tr>
                </tbody>
                <tbody class="equipment_main ">
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
                      {{Form::text('equipment_breakdown_count'.$key,$equ->unit_count,['class'=>'form-control'])}}
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
                      {{Form::text('equipment_breakdown_count0','',['class'=>'form-control'])}}
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
                <tbody class="equipment_result ">
                  <tr>
                    <td colspan="2"></td>
                    <td colspan="2">合計
                      {{Form::text('equipment_price',$bill->equipment_price,['class'=>'form-control','readonly'])}}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

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
                      {{Form::text('layout_breakdown_count'.$key,$lay->unit_count,['class'=>'form-control'])}}
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
                      {{Form::text('layout_breakdown_count0','',['class'=>'form-control'])}}
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
                <tbody class="layout_result ">
                  <tr>
                    <td colspan="2"></td>
                    <td colspan="2">合計
                      {{Form::text('layout_price',$bill->layout_price,['class'=>'form-control','readonly'])}}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>


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
                    <td>追加/削除</td>
                  </tr>
                </tbody>
                <tbody class="others_main ">
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
                      {{Form::text('others_breakdown_count'.$key,$other->unit_count,['class'=>'form-control'])}}
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
                      {{Form::text('others_breakdown_count0', '',['class'=>'form-control'])}}
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
                <tbody class="others_result ">
                  <tr>
                    <td colspan="2"></td>
                    <td colspan="3">合計
                      {{Form::text('others_price',$bill->others_price,['class'=>'form-control','readonly'])}}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>


            <div class="bill_total d-flex justify-content-end"
              style="padding: 80px 0px 80px 0px; width:90%; margin:0 auto;">
              <div style="width: 60%;">
                <table class="table text-right" style="table-layout: fixed; font-size:16px;">
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
                    </td>
                    <td>入金額
                      {{Form::text('payment', $bill->payment,['class'=>'form-control'])}}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <input class="btn btn-primary btn-block" type="submit" value="作成する">
  </form>


















</div>








@endsection