@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>

<div class="container-fluid">
  <h2 class="mt-3 mb-3">キャンセル請求書 作成　確認</h2>
  <hr>
</div>


<section class="section-wrap">
  {{ Form::open(['url' => 'admin/cxl/update', 'method'=>'POST', 'class'=>'']) }}
  @csrf
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
            @if (!empty($info[0]))
            <tbody class="venue_main_cancel">
              <tr>
                <td>会場料</td>
                <td>
                  {{number_format($info[0])}}
                  円</td>
                <td class="multiple">×</td>
                <td class="">
                  {{number_format($data['cxl_venue_PC'])}}
                  <span>%</span>
                </td>
              </tr>
            </tbody>
            @endif

            @if (!empty($info[1]))
            <tbody class="equipment_cancel">
              <tr>
                <td>有料備品・有料サービス料</td>
                <td>
                  {{number_format($info[1])}}円
                </td>
                <td class="multiple">×</td>
                <td class="">
                  {{number_format($data['cxl_equipment_PC'])}}
                  <span>%</span></td>
              </tr>
            </tbody>
            @endif

            @if (!empty($info[2]))
            <tbody class="layout_cancel">
              <tr>
                <td>レイアウト変更料</td>
                <td>
                  {{number_format($info[2])}}円
                </td>
                <td class="multiple">×</td>
                <td class="">
                  {{number_format($data['cxl_layout_PC'])}}
                  <span>%</span></td>
              </tr>
            </tbody>
            @endif

            @if (!empty($info[3]))
            <tbody class="others_cancel">
              <tr>
                <td>その他</td>
                <td>
                  {{number_format($info[3])}}
                  円</td>
                <td class="multiple">×</td>
                <td class="">
                  {{number_format($data['cxl_other_PC'])}}
                  <span>%</span></td>
              </tr>
            </tbody>
            @endif
          </table>
        </div>

        <div class="cancel_content">
          <table class="table table-borderless">
            <tbody>
              <tr>
                <td>
                  <h4 class="billdetails_content_ttl">
                    キャンセル料
                  </h4>
                </td>
              </tr>
            </tbody>
            <tbody class="head_cancel">
              <tr>
                <td>内容</td>
                <td>単価</td>
                <td>数量</td>
                <td>金額</td>
              </tr>
            </tbody>
            <tbody class="">
              @if (!empty($info[0]))
              <tr>
                <td>キャンセル料(<span>会場料</span>・<span>{{$data['cxl_venue_PC']}}%</span>)</td>
                <td>{{number_format($result[0])}}</td>
                <td>1</td>
                <td>{{number_format($result[0])}}円</td>
              </tr>
              @endif
              @if (!empty($info[1]))
              <tr>
                <td>キャンセル料(<span>有料備品・サービス料</span>・<span>{{$data['cxl_equipment_PC']}}%</span>)</td>
                <td>{{number_format($result[1])}}</td>
                <td>1</td>
                <td>{{number_format($result[1])}}円</td>
              </tr>
              @endif
              @if (!empty($info[2]))
              <tr>
                <td>キャンセル料(<span>レイアウト変更料</span>・<span>{{$data['cxl_layout_PC']}}%</span>)</td>
                <td>{{number_format($result[2])}}</td>
                <td>1</td>
                <td>{{number_format($result[2])}}円</td>
              </tr>
              @endif
              @if (!empty($info[3]))
              <tr>
                <td>キャンセル料(<span>その他</span>・<span>{{$data['cxl_other_PC']}}%</span>)</td>
                <td>{{number_format($result[3])}}</td>
                <td>1</td>
                <td>{{number_format($result[3])}}円</td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>

        <div class="bill_total">
          <table class="table text-right">
            <tbody>
              <tr>
                <td>小計：</td>
                <td>
                  {{Form::text('master_subtotal',$invoice['master_subtotal'],['class'=>'form-control','readonly'])}}
                </td>
              </tr>
              <tr>
                <td>消費税：</td>
                <td>
                  {{Form::text('master_tax',$invoice['master_tax'],['class'=>'form-control','readonly'])}}
                </td>
              </tr>
              <tr>
                <td class="font-weight-bold">合計金額</td>
                <td>
                  {{Form::text('master_total',$invoice['master_total'],['class'=>'form-control','readonly'])}}
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
                  {{Form::text('bill_created_at',$invoice['bill_created_at'],['class'=>'form-control', 'readonly'])}}
                </td>
                <td>支払期日
                  {{Form::text('payment_limit',$invoice['payment_limit'],['class'=>'form-control', 'readonly'])}}
                </td>
              </tr>
              <tr>
                <td>請求書宛名
                  {{Form::text('bill_company',$invoice['bill_company'],['class'=>'form-control', 'readonly'])}}
                </td>
                <td>
                  担当者
                  {{Form::text('bill_person',$invoice['bill_person'],['class'=>'form-control', 'readonly'])}}
                </td>
              </tr>
              <tr>
                <td colspan="2">請求書備考
                  {{Form::textarea('bill_remark',$invoice['bill_remark'],['class'=>'form-control', 'readonly'])}}
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
                  {{Form::text('paid',$invoice['paid']==1?"入金済":"未入金",['class'=>'form-control', 'readonly'])}}
                </td>
                <td>
                  入金日
                  {{Form::text('pay_day',$invoice['pay_day'],['class'=>'form-control', 'readonly'])}}
                </td>
              </tr>
              <tr>
                <td>振込人名
                  {{Form::text('pay_person',$invoice['pay_person'],['class'=>'form-control', 'readonly'])}}
                </td>
                <td>入金額
                  {{Form::text('payment',$invoice['payment'],['class'=>'form-control', 'readonly'])}}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="d-flex justify-content-center mt-5">
    {{ Form::submit('内容を修正する', ['class' => 'btn more_btn4_lg d-block mr-5','name'=>'back']) }}
    {{ Form::submit('内容を保存する', ['class' => 'btn more_btn_lg d-block']) }}
  </div>

  {{ Form::close() }}
</section>



</section>





@endsection