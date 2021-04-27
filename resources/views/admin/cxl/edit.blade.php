@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/admin/validation.js') }}"></script>

<h2 class="mt-3 mb-3">キャンセル請求書 編集</h2>
<hr>

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
        {{ Form::open(['url' => 'admin/cxl/edit_calc', 'method'=>'POST', 'class'=>'','id'=>'cxl_edit']) }}
        @csrf
        {{Form::hidden('reservation_id',$cxl->reservation->id)}}
        {{Form::hidden('cxl_id',$cxl->id)}}
        @if (!empty($cxl->bill->id))
        {{Form::hidden('bill_id',$cxl->bill->id)}}
        @else
        {{Form::hidden('bill_id',0)}}
        @endif
        <div class="cancel_content cancel_border bg-white">
          <h4 class="cancel_ttl">キャンセル料計算</h4>
          <table class="table table-borderless">
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
                <td>
                  {{number_format($price_result[0])}}
                  円</td>
                <td class="multiple">×</td>
                <td>
                  <div class="d-flex align-items-center">
                    {{Form::text('cxl_venue_PC',$cxl->cxl_breakdowns->where('unit_percent_type',1)->first()->unit_percent,['class'=>'form-control'])}}
                    <span class="ml-1">%</span>
                  </div>
                  <p class="is-error-cxl_venue_PC" style="color: red"></p>
                </td>
              </tr>
            </tbody>
            @endif
            @if ($price_result[1]!=0)
            <tbody class="equipment_cancel">
              <tr>
                <td>有料備品・有料サービス料</td>
                <td>
                  {{number_format($price_result[1])}}
                  円</td>
                <td class="multiple">×</td>
                <td>
                  <div class="d-flex align-items-center">
                    {{Form::text('cxl_equipment_PC',$cxl->cxl_breakdowns->where('unit_percent_type',2)->first()->unit_percent,['class'=>'form-control'])}}
                    <span class="ml-1">%</span>
                  </div>
                  <p class="is-error-cxl_equipment_PC" style="color: red"></p>
                </td>
              </tr>
            </tbody>
            @endif
            @if ($price_result[2]!=0)
            <tbody class="layout_cancel">
              <tr>
                <td>レイアウト変更料</td>
                <td>
                  {{number_format($price_result[2])}}
                  円</td>
                <td class="multiple">×</td>
                <td>
                  <div class="d-flex align-items-center">
                    {{Form::text('cxl_layout_PC',$cxl->cxl_breakdowns->where('unit_percent_type',3)->first()->unit_percent,['class'=>'form-control'])}}

                    <span class="ml-1">%</span>
                  </div>
                  <p class="is-error-cxl_layout_PC" style="color: red"></p>
                </td>
              </tr>
            </tbody>
            @endif
            @if ($price_result[3]!=0)
            <tbody class="others_cancel">
              <tr>
                <td>その他</td>
                <td>
                  {{number_format($price_result[3])}}
                  円</td>
                <td class="multiple">×</td>
                <td>
                  <div class="d-flex align-items-center">
                    {{Form::text('cxl_other_PC',$cxl->cxl_breakdowns->where('unit_percent_type',4)->first()->unit_percent,['class'=>'form-control'])}}

                    <span class="ml-1">%</span>
                  </div>
                  <p class="is-error-cxl_other_PC" style="color: red"></p>
                </td>
              </tr>
            </tbody>
            @endif
          </table>
          {{ Form::submit('計算する', ['class' => 'btn more_btn_lg mx-auto d-block my-5']) }}
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
</section>



</section>





@endsection