@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>

<div class="container-fluid">
  <h2 class="mt-3 mb-3">キャンセル請求書 作成</h2>
  <hr>
</div>

{{ Form::open(['url' => 'admin/cxl/calculate', 'method'=>'POST', 'class'=>'']) }}
@csrf
{{Form::hidden('bills_id',$bill->id)}}
{{Form::hidden('reservation_id',$request->reservation_id)}}

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
    // プラス・マイナス押下アクション
    // $(document).on("click", ".add", function () {
    //   var target = $(this).parent().parent();
    //   target.clone(true).insertAfter(target);
    //   AddTr(target, 'venue_main', 'venue_breakdown');
    //   AddTr(target, 'equipment_main', 'equipment_breakdown');
    //   AddTr(target, 'layout_main', 'layout_breakdown');
    //   AddTr(target, 'others_main', 'others_breakdown');
    //   target.parent().find('tr').last().find('td').eq(0).find('input').val('');
    //   target.parent().find('tr').last().find('td').eq(1).find('input').val('');
    //   target.parent().find('tr').last().find('td').eq(2).find('input').val('');
    //   target.parent().find('tr').last().find('td').eq(3).find('input').val('');
    // })

    // function AddTr($target, $targetClass, $targetName) {
    //   if ($target.parent().hasClass($targetClass)) {
    //     var target_length = $target.parent().find('tr').length;
    //     for (let index = 0; index < target_length; index++) {
    //       $target.parent().find('tr').eq(index).find('td').eq(0).find('input').attr('name', $targetName +
    //         '_item' + index)
    //       $target.parent().find('tr').eq(index).find('td').eq(1).find('input').attr('name', $targetName +
    //         '_cost' + index)
    //       $target.parent().find('tr').eq(index).find('td').eq(2).find('input').attr('name', $targetName +
    //         '_count' + index)
    //       $target.parent().find('tr').eq(index).find('td').eq(3).find('input').attr('name', $targetName +
    //         '_subtotal' + index)
    //     }
    //   }
    // }
    // マイナス押下
    // $(document).on("click", ".del", function () {
    //   var master = $(this).parent().parent().parent().find('tr').length;
    //   var target = $(this).parent().parent();
    //   var re_target = target.parent();
    //   if (master > 1) {
    //     target.remove();
    //   }
    //   DelTr(re_target, 'venue_main', 'venue_breakdown');
    //   DelTr(re_target, 'equipment_main', 'equipment_breakdown');
    //   DelTr(re_target, 'layout_main', 'layout_breakdown');
    //   DelTr(re_target, 'others_main', 'others_breakdown');
    //   DelCalc('.venues input', '.venue_main tr', 'input[name="venue_price"]');
    //   DelCalc('.equipment input', '.equipment_main tr', 'input[name="equipment_price"]');
    //   DelCalc('.layout input', '.layout_main tr', 'input[name="layout_price"]');
    //   DelCalc('.others input', '.others_main tr', 'input[name="others_price"]');

    //   MaterCalc();

    // })

    // function DelTr($target, $targetClass, $targetName) {
    //   if ($target.hasClass($targetClass)) {
    //     for (let num = 0; num < $target.find('tr').length; num++) {
    //       $target.find('tr').eq(num).find('td').eq(0).find('input').attr('name', $targetName + '_item' +
    //         num)
    //       $target.find('tr').eq(num).find('td').eq(1).find('input').attr('name', $targetName + '_cost' +
    //         num)
    //       $target.find('tr').eq(num).find('td').eq(2).find('input').attr('name', $targetName + '_count' +
    //         num)
    //       $target.find('tr').eq(num).find('td').eq(3).find('input').attr('name', $targetName +
    //         '_subtotal' + num)
    //     }
    //   }
    // }

    // function DelCalc($targetClass, $targetTr, $targetSum) {
    //   var trTarget = $($targetTr).length;
    //   var result_add = 0;
    //   for (let calc = 0; calc < trTarget; calc++) {
    //     var multiple1 = Number($($targetTr).eq(calc).find('td').eq(1).find('input').val());
    //     var multiple2 = Number($($targetTr).eq(calc).find('td').eq(2).find('input').val());
    //     var result = $($targetTr).eq(calc).find('td').eq(3).find('input').val(multiple1 * multiple2);
    //     result_add = result_add + (multiple1 * multiple2);
    //   }
    //   $($targetSum).val(result_add);
    // };



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

    // 各input からの計算
    // calc('.venues input', '.venue_main tr', 'input[name="venue_price"]');
    // calc('.equipment input', '.equipment_main tr', 'input[name="equipment_price"]');
    // calc('.layout input', '.layout_main tr', 'input[name="layout_price"]');
    // calc('.others input', '.others_main tr', 'input[name="others_price"]');

    // function calc($targetClass, $targetTr, $targetSum) {
    //   $($targetClass).on('input', function () {
    //     var trTarget = $($targetTr).length;
    //     var result_add = 0;
    //     for (let calc = 0; calc < trTarget; calc++) {
    //       var multiple1 = Number($($targetTr).eq(calc).find('td').eq(1).find('input').val());
    //       var multiple2 = Number($($targetTr).eq(calc).find('td').eq(2).find('input').val());
    //       var result = $($targetTr).eq(calc).find('td').eq(3).find('input').val(multiple1 *
    //         multiple2);
    //       result_add = result_add + (multiple1 * multiple2);
    //     }
    //     $($targetSum).val(result_add);
    //   })
    // };

    // 総合計額抽出
    // $('input').on('input', function () {
    //   MaterCalc();
    // })

    // function MaterCalc() {
    //   var tar1 = Number($('input[name="venue_price"]').val());
    //   var tar2 = Number($('input[name="equipment_price"]').val());
    //   var tar3 = Number($('input[name="layout_price"]').val());
    //   var tar4 = Number($('input[name="others_price"]').val());
    //   var master_sub = tar1 + tar2 + tar3 + tar4;
    //   var master_tax = Math.floor(Number((tar1 + tar2 + tar3 + tar4) * 0.1));

    //   $('input[name="master_subtotal"]').val(master_sub);
    //   $('input[name="master_tax"]').val(master_tax);
    //   $('input[name="master_total"]').val(master_sub + master_tax);

    // }
  })
</script>
</section>
</form>





@endsection