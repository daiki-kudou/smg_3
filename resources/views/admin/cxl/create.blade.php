@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>

  <h2 class="mt-3 mb-3">キャンセル請求書 作成</h2>
  <hr>

{{ Form::open(['url' => 'admin/cxl/calculate', 'method'=>'POST', 'class'=>'']) }}
@csrf
{{Form::hidden('bills_id',$bill->id)}}
{{Form::hidden('reservation_id',$request->reservation_id)}}

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
      <div class="main" style="">
        <div class="cancel_content cancel_border">
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
            @if ($bill->venue_price>0)
            <tbody class="venue_main_cancel">
              <tr>
                <td>会場料</td>
                <td>{{number_format($bill->venue_price)}}円</td>
                <td class="multiple">×</td>
                <td class="d-flex align-items-center">
                  {{Form::text('cxl_venue_PC','',['class'=>'form-control'])}}
                  <span class="ml-1">%</span>
                </td>
              </tr>
            </tbody>
            @endif

            @if ($bill->equipment_price>0)
            <tbody class="equipment_cancel">
              <tr>
                <td>有料備品・有料サービス料</td>
                <td>{{number_format($bill->equipment_price)}}円</td>
                <td class="multiple">×</td>
                <td class="d-flex align-items-center">
                  {{Form::text('cxl_equipment_PC','',['class'=>'form-control'])}}
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
                  {{Form::text('cxl_layout_PC','',['class'=>'form-control'])}}
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
                  {{Form::text('cxl_other_PC','',['class'=>'form-control'])}}
                  <span class="ml-1">%</span></td>
              </tr>
            </tbody>
            @endif
          </table>
          {{ Form::submit('計算する', ['class' => 'btn more_btn_lg mx-auto d-block my-5']) }}

        </div>

        {{-- <div class="cancel_content">
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
              <tr>
                <td>キャンセル料(<span>会場料</span>・<span>70%</span>)</td>
                <td>36,351</td>
                <td>1</td>
                <td>36,351円</td>
              </tr>
            </tbody>
            <tbody class="">
              <tr>
                <td>キャンセル料(<span>有料備品・サービス料</span>・<span>70%</span>)</td>
                <td>36,351</td>
                <td>1</td>
                <td>36,351円</td>
              </tr>
            </tbody>
            <tbody class="">
              <tr>
                <td>キャンセル料(<span>レイアウト変更料</span>・<span>70%</span>)</td>
                <td>36,351</td>
                <td>1</td>
                <td>36,351円</td>
              </tr>
            </tbody>
            <tbody class="">
              <tr>
                <td>キャンセル料(<span>その他</span>・<span>70%</span>)</td>
                <td>36,351</td>
                <td>1</td>
                <td>36,351円</td>
              </tr>
            </tbody>
          </table>
        </div> --}}

        {{-- <div class="bill_total">
          <table class="table text-right">
            <tbody>
              <tr>
                <td>小計：</td>
                <td>
                  <input class="form-control" readonly="" name="master_subtotal" type="text" value="">
                </td>
              </tr>
              <tr>
                <td>消費税：</td>
                <td>
                  <input class="form-control" readonly="" name="master_tax" type="text" value="">
                </td>
              </tr>
              <tr>
                <td class="font-weight-bold">合計金額</td>
                <td>
                  <input class="form-control" readonly="" name="master_total" type="text" value="">
                </td>
              </tr>
            </tbody>
          </table>
        </div> --}}
      </div>

    </div>
  </div>


  {{-- <div class="information">
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
                  <input class="form-control hasDatepicker" id="datepicker6" name="pay_limit" type="text"
                    value="2021-03-14">
                </td>
              </tr>
              <tr>
                <td>請求書宛名
                  <input class="form-control" name="pay_company" type="text" value="トリックスター">
                </td>
                <td>
                  担当者
                  <input class="form-control" name="bill_person" type="text" value="大山紘一郎">
                </td>
              </tr>
              <tr>
                <td colspan="2">請求書備考
                  <textarea class="form-control" name="bill_remark" cols="50" rows="10"></textarea>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div> --}}


  {{-- <div class="paid">
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
                <td>入金状況<select class="form-control" name="paid">
                    <option value="0">未入金</option>
                    <option value="1">入金済み</option>
                  </select></td>
                <td>
                  入金日<input class="form-control hasDatepicker" id="datepicker7" name="pay_day" type="text">
                </td>
              </tr>
              <tr>
                <td>振込人名<input class="form-control" name="pay_person" type="text"></td>
                <td>入金額<input class="form-control" name="payment" type="text"></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div> --}}
  {{-- <input class="btn more_btn_lg mx-auto d-block my-5" type="submit" value="確認する"> --}}

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