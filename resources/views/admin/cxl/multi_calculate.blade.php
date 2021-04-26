@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/admin/validation.js') }}"></script>

<div class="">
  <h2 class="mt-3 mb-3">一括キャンセル請求書 作成</h2>
  <hr>
</div>

@if (session('flash_message'))
<div class="alert alert-danger">
  <ul>
    <li> {!! session('flash_message') !!} </li>
  </ul>
</div>
@endif

{{ Form::open(['url' => 'admin/cxl/multi_check', 'method'=>'POST', 'class'=>'' ,'id'=>'cxl_multicalc']) }}
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
                <td>会場料
                  {{Form::hidden('cxl_target_item[]',"会場料")}}
                </td>
                <td>{{number_format($info[0])}}円
                  {{Form::hidden('cxl_target_cost[]',$info[0])}}
                </td>
                <td class="multiple">×</td>
                <td class="">
                  {{$data['cxl_venue_PC']}}
                  {{Form::hidden('cxl_target_percent[]',$data['cxl_venue_PC'])}}
                  <span>%</span>
                </td>
              </tr>
            </tbody>
            @endif


            @if (!empty($info[1]))
            <tbody class="equipment_cancel">
              <tr>
                <td>有料備品・有料サービス料
                  {{Form::hidden('cxl_target_item[]',"有料備品・有料サービス料")}}
                </td>
                <td>{{number_format($info[1])}}円
                  {{Form::hidden('cxl_target_cost[]',$info[1])}}
                </td>
                <td class="multiple">×</td>
                <td class="">
                  {{$data['cxl_equipment_PC']}}
                  {{Form::hidden('cxl_target_percent[]',$data['cxl_equipment_PC'])}}
                  <span>%</span></td>
              </tr>
            </tbody>
            @endif

            @if (!empty($info[2]))
            <tbody class="layout_cancel">
              <tr>
                <td>レイアウト変更料
                  {{Form::hidden('cxl_target_item[]',"レイアウト変更料")}}
                </td>
                <td>{{number_format($info[2])}}円
                  {{Form::hidden('cxl_target_cost[]',$info[2])}}
                </td>
                <td class="multiple">×</td>
                <td class="">
                  {{$data['cxl_layout_PC']}}
                  {{Form::hidden('cxl_target_percent[]',$data['cxl_layout_PC'])}}
                  <span>%</span></td>
              </tr>
            </tbody>
            @endif

            @if (!empty($info[3]))
            <tbody class="others_cancel">
              <tr>
                <td>その他
                  {{Form::hidden('cxl_target_item[]',"その他")}}
                </td>
                <td>{{number_format($info[3])}}円
                  {{Form::hidden('cxl_target_cost[]',$info[3])}}
                </td>
                <td class="multiple">×</td>
                <td class="">
                  {{$data['cxl_other_PC']}}
                  {{Form::hidden('cxl_target_percent[]',$data['cxl_other_PC'])}}
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
                <td>キャンセル料 (<span>会場料</span>・<span>{{$data['cxl_venue_PC']}}%</span>)
                  {{Form::hidden('cxl_unit_item[]',"キャンセル料(会場料・".$data['cxl_venue_PC']."%)")}}
                </td>
                <td>{{number_format(round($result[0]))}}
                  {{Form::hidden('cxl_unit_cost[]',round($result[0]))}}
                </td>
                <td>1
                  {{Form::hidden('cxl_unit_count[]',1)}}
                </td>
                <td>{{number_format(round($result[0]))}}円
                  {{Form::hidden('cxl_unit_subtotal[]',round($result[0]))}}
                </td>
              </tr>
              @endif
              @if (!empty($info[1]))
              <tr>
                <td>キャンセル料 (<span>有料備品・サービス料</span>・<span>{{$data['cxl_equipment_PC']}}%</span>)
                  {{Form::hidden('cxl_unit_item[]',"キャンセル料(有料備品・サービス料・".$data['cxl_equipment_PC']."%)")}}
                </td>
                <td>{{number_format(round($result[1]))}}
                  {{Form::hidden('cxl_unit_cost[]',round($result[1]))}}
                </td>
                <td>1
                  {{Form::hidden('cxl_unit_count[]',1)}}
                </td>
                <td>{{number_format(round($result[1]))}}円
                  {{Form::hidden('cxl_unit_subtotal[]',round($result[1]))}}
                </td>
              </tr>
              @endif
              @if (!empty($info[2]))
              <tr>
                <td>キャンセル料 (<span>レイアウト変更料</span>・<span>{{$data['cxl_layout_PC']}}%</span>)
                  {{Form::hidden('cxl_unit_item[]',"キャンセル料(レイアウト変更料・".$data['cxl_layout_PC']."%)")}}
                </td>
                <td>{{number_format(round($result[2]))}}
                  {{Form::hidden('cxl_unit_cost[]',round($result[2]))}}
                </td>
                <td>1
                  {{Form::hidden('cxl_unit_count[]',1)}}
                </td>
                <td>{{number_format(round($result[2]))}}円
                  {{Form::hidden('cxl_unit_subtotal[]',round($result[2]))}}
                </td>
              </tr>
              @endif
              @if (!empty($info[3]))
              <tr>
                <td>キャンセル料 (<span>その他</span>・<span>{{$data['cxl_other_PC']}}%</span>)
                  {{Form::hidden('cxl_unit_item[]',"キャンセル料(その他・".$data['cxl_other_PC']."%)")}}
                </td>
                <td>{{number_format(round($result[3]))}}
                  {{Form::hidden('cxl_unit_cost[]',round($result[3]))}}
                </td>
                <td>1
                  {{Form::hidden('cxl_unit_count[]',1)}}
                </td>
                <td>{{number_format(round($result[3]))}}円
                  {{Form::hidden('cxl_unit_subtotal[]',round($result[3]))}}
                </td>
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
                  {{Form::text('',number_format(round($result[4])),['class'=>'form-control','readonly'])}}
                  {{Form::hidden('master_subtotal',round($result[4]),['class'=>'form-control','readonly'])}}
                </td>
              </tr>
              <tr>
                <td>消費税：</td>
                <td>
                  {{Form::text('',number_format(round(ReservationHelper::getTax($result[4]))),['class'=>'form-control','readonly'])}}
                  {{Form::hidden('master_tax',round(ReservationHelper::getTax($result[4])),['class'=>'form-control','readonly'])}}
                </td>
              </tr>
              <tr>
                <td class="font-weight-bold">合計金額</td>
                <td>
                  {{Form::text('',number_format(round(ReservationHelper::taxAndPrice($result[4]))),['class'=>'form-control','readonly'])}}
                  {{Form::hidden('master_total',round(ReservationHelper::taxAndPrice($result[4])),['class'=>'form-control','readonly'])}}
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
                  {{Form::text('bill_created_at', date('Y-m-d',strtotime(\Carbon\Carbon::now())) ,['class'=>'form-control', 'id'=>'datepicker1'])}}
                </td>
                <td>支払期日
                  {{Form::text('payment_limit',$pay_limit,['class'=>'form-control datepicker', 'id'=>''])}}
                </td>
              </tr>
              <tr>
                <td>請求書宛名
                  {{Form::text('bill_company',$user->company,['class'=>'form-control'])}}
                </td>
                <td>
                  担当者
                  {{Form::text('bill_person',ReservationHelper::getPersonName($user->id),['class'=>'form-control'])}}
                </td>
              </tr>
              <tr>
                <td colspan="2">請求書備考
                  {{Form::textarea('bill_remark','',['class'=>'form-control'])}}
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
                  {{Form::select('paid', ['未入金','入金済み'], '0',['class'=>'form-control'])}}
                </td>
                <td>
                  入金日
                  {{Form::text('pay_day','',['class'=>'form-control datepicker','id'=>''])}}
                </td>
              </tr>
              <tr>
                <td>振込人名
                  {{Form::text('pay_person','',['class'=>'form-control'])}}
                  <p class="is-error-pay_person" style="color: red"></p>
                </td>
                <td>入金額
                  {{Form::text('payment','',['class'=>'form-control'])}}
                  <p class="is-error-payment" style="color: red"></p>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="container-field d-flex justify-content-center mt-5">
    {{ Form::submit('修正する', ['class' => 'btn more_btn4_lg d-block mr-5','name'=>'back']) }}
    {{ Form::submit('確認する', ['class' => 'btn more_btn_lg d-block']) }}
  </div>
  {{ Form::close() }}
</section>


<script>
  $(function () {
    // チェックボックス開閉
    checkToggle('.venue_chkbox #venue', ['.venue_head', '.venue_main', '.venue_result']);
    checkToggle('.equipment_chkbox #equipment', ['.equipment_head', '.equipment_main',
      '.equipment_result'
    ]);
    checkToggle('.layout_chkbox #layout', ['.layout_head', '.layout_main', '.layout_result']);
    checkToggle('.others_chkbox #others', ['.others_head', '.others_main', '.others_result']);

    function checkToggle($target, $items) {
      $($target).on('click', function () {
        $.each($items, function (index, value) {
          $(value).toggleClass('hide');
        });
      });
    }

  })
</script>
</section>





@endsection