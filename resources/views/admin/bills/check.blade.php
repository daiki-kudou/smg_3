@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/add_bill_ajax.js') }}"></script>
<script src="{{ asset('/js/template.js') }}"></script>

<h2 class="mt-3 mb-3">追加請求書　確認画面</h2>
<hr>

@if (session('flash_message'))
<div class="alert alert-danger">
  <ul>
    <li> {!! session('flash_message') !!} </li>
  </ul>
</div>
@endif


{{ Form::open(['route' => 'admin.bills.store', 'method'=>'POST']) }}
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
        @if (!empty($data['venue_price']))
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
                  {{ Form::text('venue_breakdown_item'.$i, $data['venue_breakdown_item'.$i],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_cost'.$i, $data['venue_breakdown_cost'.$i],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_count'.$i, $data['venue_breakdown_count'.$i],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_subtotal'.$i, $data['venue_breakdown_subtotal'.$i],['class'=>'form-control', 'readonly'] ) }}
                </td>
                </tr>
                @endfor
            </tbody>
            <tbody class="venue_result">
              <tr>
                <td colspan="3"></td>
                <td colspan="1">
                  <p class="text-left">合計</p>
                  {{ Form::text('venue_price',$data['venue_price'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        @endif


        @if (!empty($data['equipment_price']))
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
                  {{ Form::text('equipment_breakdown_item'.$i,$data['equipment_breakdown_item'.$i] ,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_cost'.$i,$data['equipment_breakdown_cost'.$i] ,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_count'.$i,$data['equipment_breakdown_count'.$i] ,['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_subtotal'.$i,$data['equipment_breakdown_subtotal'.$i] ,['class'=>'form-control', 'readonly'] ) }}
                </td>
                </tr>
                @endfor
            </tbody>
            <tbody class="equipment_result">
              <tr>
                <td colspan="3"></td>
                <td colspan="1">
                  <p class="text-left">合計</p>
                  {{ Form::text('equipment_price',$data['equipment_price'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        @endif

        @if (!empty($data['layout_price']))
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
                  {{ Form::text('layout_breakdown_item'.$i,$data['layout_breakdown_item'.$i],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_breakdown_cost'.$i,$data['layout_breakdown_cost'.$i],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_breakdown_count'.$i,$data['layout_breakdown_count'.$i],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('layout_breakdown_subtotal'.$i,$data['layout_breakdown_subtotal'.$i],['class'=>'form-control', 'readonly'] ) }}
                </td>
                </tr>
                @endfor
            </tbody>
            <tbody class="layout_result">
              <tr>
                <td colspan="3"></td>
                <td colspan="1">
                  <p class="text-left">合計</p>
                  {{ Form::text('layout_price',$data['layout_price'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        @endif

        @if (!empty($data['others_price']))
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
                  {{ Form::text('others_breakdown_item'.$i,$data['others_breakdown_item'.$i],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('others_breakdown_cost'.$i,$data['others_breakdown_cost'.$i],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('others_breakdown_count'.$i,$data['others_breakdown_count'.$i],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  {{ Form::text('others_breakdown_subtotal'.$i,$data['others_breakdown_subtotal'.$i],['class'=>'form-control', 'readonly'] ) }}
                </td>
                </tr>
                @endfor
            </tbody>
            <tbody class="others_result">
              <tr>
                <td colspan="3"></td>
                <td colspan="1">
                  <p class="text-left">合計</p>
                  {{ Form::text('others_price',$data['others_price'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        @endif



        <div class="bill_total">
          <table class="table text-right">
            <tbody>
              <tr>
                <td>小計：</td>
                <td>
                  {{ Form::text('master_subtotal',$data['master_subtotal'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td>消費税：</td>
                <td>
                  {{ Form::text('master_tax',$data['master_tax'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td class="font-weight-bold">合計金額</td>
                <td>
                  {{ Form::text('master_total',$data['master_total'],['class'=>'form-control', 'readonly'] ) }}
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
                  {{ Form::text('payment_limit',$data['pay_limit'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td>請求書宛名
                  {{ Form::text('bill_company',$data['pay_company'],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  担当者
                  {{ Form::text('bill_person',$data['bill_person'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td colspan="2">請求書備考
                  {{ Form::textarea('bill_remark',$data['bill_remark'],['class'=>'form-control', 'readonly'] ) }}
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
                  {{ Form::text('',$data['paid']==0?"未入金":"支払済",['class'=>'form-control', 'readonly'] ) }}
                  {{ Form::hidden('paid',$data['paid'],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>
                  入金日
                  {{ Form::text('pay_day',$data['pay_day'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
              <tr>
                <td>振込人名
                  {{ Form::text('pay_person',$data['pay_person'],['class'=>'form-control', 'readonly'] ) }}
                </td>
                <td>入金額
                  {{ Form::text('payment',$data['payment'],['class'=>'form-control', 'readonly'] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="container-field d-flex justify-content-center mt-5">
{{ Form::submit('請求内容を修正する', ['class' => 'btn more_btn4_lg d-block mr-5','name'=>'back']) }}
{{ Form::submit('追加請求書を確定する', ['class' => 'd-block btn more_btn_lg']) }}
</div>

{{ Form::close() }}














@endsection