@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>

<div class="container-fluid">
  <h2 class="mt-3 mb-3">キャンセル請求書 作成　確認</h2>
  <hr>
</div>


<section class="section-wrap">
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
          {{ Form::open(['url' => 'admin/cxl/calculate', 'method'=>'POST', 'class'=>'']) }}
          @csrf
          {{Form::hidden('bills_id',$bill->id)}}
          {{Form::hidden('reservation_id',$request->reservation_id)}}
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
            <tbody class="venue_main_cancel">
              <tr>
                <td>会場料</td>
                <td>{{number_format($bill->venue_price)}}円</td>
                <td class="multiple">×</td>
                <td class="d-flex align-items-center">
                  {{Form::text('cxl_venue_PC',$request->cxl_venue_PC,['class'=>'form-control'])}}
                  <span class="ml-1">%</span>
                </td>
              </tr>
            </tbody>

            @if ($bill->equipment_price>0)
            <tbody class="equipment_cancel">
              <tr>
                <td>有料備品・有料サービス料</td>
                <td>{{number_format($bill->equipment_price)}}円</td>
                <td class="multiple">×</td>
                <td class="d-flex align-items-center">
                  {{Form::text('cxl_equipment_PC',$request->cxl_equipment_PC,['class'=>'form-control'])}}
                  <span class="ml-1">%</span></td>
              </tr>
            </tbody>
            @endif

            @if ($bill->layout_price>0)
            <tbody class="layout_cancel">
              <tr>
                <td>レイアウト変更料</td>
                <td>{{number_format($bill->layout_price)}}円</td>
                <td class="multiple">×</td>
                <td class="d-flex align-items-center">
                  {{Form::text('cxl_layout_PC',$request->cxl_layout_PC,['class'=>'form-control'])}}
                  <span class="ml-1">%</span></td>
              </tr>
            </tbody>
            @endif

            @if ($bill->others_price>0)
            <tbody class="others_cancel">
              <tr>
                <td>その他</td>
                <td>{{number_format($bill->others_price)}}円</td>
                <td class="multiple">×</td>
                <td class="d-flex align-items-center">
                  {{Form::text('cxl_other_PC',$request->cxl_other_PC,['class'=>'form-control'])}}
                  <span class="ml-1">%</span></td>
              </tr>
            </tbody>
            @endif
          </table>
          {{ Form::submit('再計算する', ['class' => 'btn more_btn_lg mx-auto d-block my-5']) }}
          {{ Form::close() }}

        </div>

        {{ Form::open(['url' => 'admin/cxl', 'method'=>'POST', 'class'=>'']) }}
        @csrf
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
              @if ($bill->venue_price>0)
              <tr>
                <td>キャンセル料(<span>会場料</span>・<span>{{$request->cxl_venue_PC}}%</span>)</td>
                <td>{{number_format($result[0])}}</td>
                <td>1</td>
                <td>{{number_format($result[0])}}円</td>
              </tr>
              @endif
              @if ($bill->equipment_price>0)
              <tr>
                <td>キャンセル料(<span>有料備品・サービス料</span>・<span>{{$request->cxl_equipment_PC}}%</span>)</td>
                <td>{{number_format($result[1])}}</td>
                <td>1</td>
                <td>{{number_format($result[1])}}円</td>
              </tr>
              @endif
              @if ($bill->layout_price>0)
              <tr>
                <td>キャンセル料(<span>レイアウト変更料</span>・<span>{{$request->cxl_layout_PC}}%</span>)</td>
                <td>{{number_format($result[2])}}</td>
                <td>1</td>
                <td>{{number_format($result[2])}}円</td>
              </tr>
              @endif
              @if ($bill->others_price>0)
              <tr>
                <td>キャンセル料(<span>その他</span>・<span>{{$request->cxl_other_PC}}%</span>)</td>
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
                  {{Form::text('master_subtotal',$result[4],['class'=>'form-control','readonly'])}}
                </td>
              </tr>
              <tr>
                <td>消費税：</td>
                <td>
                  {{Form::text('master_tax',ReservationHelper::getTax($result[4]),['class'=>'form-control','readonly'])}}
                </td>
              </tr>
              <tr>
                <td class="font-weight-bold">合計金額</td>
                <td>
                  {{Form::text('master_total',ReservationHelper::taxAndPrice($result[4]),['class'=>'form-control','readonly'])}}
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
                <td>支払期日
                  {{Form::text('payment_limit',$payment_limit,['class'=>'form-control', 'id'=>'datepicker1'])}}
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
                  {{Form::text('pay_day','',['class'=>'form-control','id'=>'datepicker2'])}}
                </td>
              </tr>
              <tr>
                <td>振込人名
                  {{Form::text('pay_person','',['class'=>'form-control'])}}
                </td>
                <td>入金額
                  {{Form::text('payment','',['class'=>'form-control'])}}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  {{Form::hidden('reservation_id',$request->reservation_id)}}
  {{Form::hidden('cxl_venue_PC',$request->cxl_venue_PC,['class'=>'form-control'])}}
  @if ($bill->equipment_price>0)
  {{Form::hidden('cxl_equipment_PC',$request->cxl_equipment_PC,['class'=>'form-control'])}}
  @endif
  @if ($bill->layout_price>0)
  {{Form::hidden('cxl_layout_PC',$request->cxl_layout_PC,['class'=>'form-control'])}}
  @endif
  @if ($bill->others_price>0)
  {{Form::hidden('cxl_other_PC',$request->cxl_other_PC,['class'=>'form-control'])}}
  @endif
  {{Form::hidden('bill_id',$bill->id)}}
  {{Form::hidden('reservation_id',$request->reservation_id)}}

  {{ Form::submit('キャンセルを確定する', ['class' => 'btn more_btn_lg mx-auto d-block my-5']) }}
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
</form>





@endsection