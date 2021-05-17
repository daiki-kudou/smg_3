@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/add_bill_ajax.js') }}"></script>
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/admin/validation.js') }}"></script>

<style>
  #fullOverlay {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(100, 100, 100, .5);
    z-index: 2147483647;
    display: none;
  }

  .frame_spinner {
    max-width: 100%;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .hide {
    display: none;
  }
</style>

<div id="fullOverlay">
  <div class="frame_spinner">
    <div class="spinner-border text-primary " role="status">
      <span class="sr-only hide">Loading...</span>
    </div>
  </div>
</div>

<div class="container-fluid">
  <h2 class="mt-3 mb-3">追加請求書</h2>
  <hr>
  {{ Form::open(['url' => 'admin/bills/create_session', 'method'=>'POST','id'=>'billsCreateForm']) }}
  @csrf
  {{ Form::hidden('reservation_id', $reservation->id, ['class' => 'form-control'])}}


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
                      <input type="checkbox" id="venue" name="venue" value="1" {{ !empty(session('add_bill')['venue_price'])?"checked":"" }}>
                      <label for="venue">会場料</label>
                    </div>
                  </td>
                </tr>
              </tbody>
              <tbody class="venue_head {{ empty(session('add_bill')['venue_price'])?"hide":"" }}">
                <tr>
                  <td>内容</td>
                  <td>単価</td>
                  <td>数量</td>
                  <td>金額</td>
                  <td>追加/削除</td>
                </tr>
              </tbody>
              <tbody class="venue_main {{ empty(session('add_bill')['venue_price'])?"hide":"" }}">
                @if (empty(session('add_bill')['venue_price']))
                <tr>
                  <td>{{ Form::text('venue_breakdown_item0', '', ['class' => 'form-control'])}}</td>
                  <td>{{ Form::text('venue_breakdown_cost0', '', ['class' => 'form-control'])}}</td>
                  <td>{{ Form::text('venue_breakdown_count0', '', ['class' => 'form-control number_validation'])}}</td>
                  <td>{{ Form::text('venue_breakdown_subtotal0', '', ['class' => 'form-control', 'readonly'])}}</td>
                  <td>
                    <input type="button" value="＋" class="add pluralBtn">
                    <input type="button" value="ー" class="del pluralBtn">
                  </td>
                </tr>
                @else
                @for ($i = 0; $i < $venues; $i++) <tr>
                  <td>
                    {{ Form::text('venue_breakdown_item'.$i, $data['venue_breakdown_item'.$i], ['class' => 'form-control'])}}
                  </td>
                  <td>
                    {{ Form::text('venue_breakdown_cost'.$i, $data['venue_breakdown_cost'.$i], ['class' => 'form-control'])}}
                  </td>
                  <td>
                    {{ Form::text('venue_breakdown_count'.$i, $data['venue_breakdown_count'.$i], ['class' => 'form-control number_validation'])}}
                  </td>
                  <td>
                    {{ Form::text('venue_breakdown_subtotal'.$i, $data['venue_breakdown_subtotal'.$i], ['class' => 'form-control', 'readonly'])}}
                  </td>
                  <td>
                    <input type="button" value="＋" class="add pluralBtn">
                    <input type="button" value="ー" class="del pluralBtn">
                  </td>
                  </tr>
                  @endfor
                  @endif
              </tbody>
              <tbody class="venue_result {{ empty(session('add_bill')['venue_price'])?"hide":"" }}">
                <tr>
                  <td colspan="4"></td>
                  <td colspan="1">
                    <p class="text-left">合計</p>
                    {{ Form::text('venue_price', !empty(session('add_bill')['venue_price'])?session('add_bill')['venue_price']:"", ['class' => 'form-control' , 'readonly'])}}
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
                      <input type="checkbox" id="equipment" name="equipment" value="1" {{ !empty(session('add_bill')['equipment_price'])?"checked":"" }}>
                      <label for="equipment">有料備品・サービス料</label>
                    </div>
                  </td>
                </tr>
              </tbody>
              <tbody class="equipment_head {{ empty(session('add_bill')['equipment_price'])?"hide":"" }}">
                <tr>
                  <td>内容</td>
                  <td>単価</td>
                  <td>数量</td>
                  <td>金額</td>
                  <td>追加/削除</td>
                </tr>
              </tbody>
              <tbody class="equipment_main {{ empty(session('add_bill')['equipment_price'])?"hide":"" }}">
                @if (empty(session('add_bill')['equipment_price']))
                <tr>
                  <td>{{ Form::text('equipment_breakdown_item0', '', ['class' => 'form-control'])}}</td>
                  <td>{{ Form::text('equipment_breakdown_cost0', '', ['class' => 'form-control'])}}</td>
                  <td>{{ Form::text('equipment_breakdown_count0', '', ['class' => 'form-control number_validation'])}}</td>
                  <td>{{ Form::text('equipment_breakdown_subtotal0', '', ['class' => 'form-control', 'readonly'])}}</td>
                  <td>
                    <input type="button" value="＋" class="add pluralBtn">
                    <input type="button" value="ー" class="del pluralBtn">
                  </td>
                </tr>
                @else
                @for ($i = 0; $i < $equipments; $i++) <tr>
                  <td>
                    {{ Form::text('equipment_breakdown_item'.$i, $data['equipment_breakdown_item'.$i], ['class' => 'form-control'])}}
                  </td>
                  <td>
                    {{ Form::text('equipment_breakdown_cost'.$i, $data['equipment_breakdown_cost'.$i], ['class' => 'form-control'])}}
                  </td>
                  <td>
                    {{ Form::text('equipment_breakdown_count'.$i, $data['equipment_breakdown_count'.$i], ['class' => 'form-control number_validation'])}}
                  </td>
                  <td>
                    {{ Form::text('equipment_breakdown_subtotal'.$i, $data['equipment_breakdown_subtotal'.$i], ['class' => 'form-control', 'readonly'])}}
                  </td>
                  <td>
                    <input type="button" value="＋" class="add pluralBtn">
                    <input type="button" value="ー" class="del pluralBtn">
                  </td>
                  </tr>
                  @endfor
                  @endif
              </tbody>
              <tbody class="equipment_result {{ empty(session('add_bill')['equipment_price'])?"hide":"" }}">
                <tr>
                  <td colspan="4"></td>
                  <td colspan="1">
                    <p class="text-left">合計</p>
                    {{ Form::text('equipment_price', !empty(session('add_bill')['equipment_price'])?session('add_bill')['equipment_price']:"", ['class' => 'form-control' , 'readonly'])}}
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
              <tbody class="layout_head {{ empty(session('add_bill')['layout_price'])?"hide":"" }}">
                <tr>
                  <td>内容</td>
                  <td>単価</td>
                  <td>数量</td>
                  <td>金額</td>
                  <td>追加/削除</td>
                </tr>
              </tbody>
              <tbody class="layout_main {{ empty(session('add_bill')['layout_price'])?"hide":"" }}">
                @if (empty(session('add_bill')['layout_price']))
                <tr>
                  <td>{{ Form::text('layout_breakdown_item0', '', ['class' => 'form-control'])}}</td>
                  <td>{{ Form::text('layout_breakdown_cost0', '', ['class' => 'form-control'])}}</td>
                  <td>{{ Form::text('layout_breakdown_count0', '', ['class' => 'form-control number_validation'])}}</td>
                  <td>{{ Form::text('layout_breakdown_subtotal0', '', ['class' => 'form-control', 'readonly'])}}</td>
                  <td>
                    <input type="button" value="＋" class="add pluralBtn">
                    <input type="button" value="ー" class="del pluralBtn">
                  </td>
                </tr>
                @else
                @for ($i = 0; $i < $layouts; $i++) <tr>
                  <td>
                    {{ Form::text('layout_breakdown_item'.$i, $data['layout_breakdown_item'.$i], ['class' => 'form-control'])}}
                  </td>
                  <td>
                    {{ Form::text('layout_breakdown_cost'.$i, $data['layout_breakdown_cost'.$i], ['class' => 'form-control'])}}
                  </td>
                  <td>
                    {{ Form::text('layout_breakdown_count'.$i, $data['layout_breakdown_count'.$i], ['class' => 'form-control number_validation'])}}
                  </td>
                  <td>
                    {{ Form::text('layout_breakdown_subtotal'.$i, $data['layout_breakdown_subtotal'.$i], ['class' => 'form-control', 'readonly'])}}
                  </td>
                  <td>
                    <input type="button" value="＋" class="add pluralBtn">
                    <input type="button" value="ー" class="del pluralBtn">
                  </td>
                  </tr>
                  @endfor
                  @endif
              </tbody>
              <tbody class="layout_result {{ empty(session('add_bill')['layout_price'])?"hide":"" }}">
                <tr>
                  <td colspan="4"></td>
                  <td colspan="1">
                    <p class="text-left">合計</p>
                    {{ Form::text('layout_price', !empty(session('add_bill')['layout_price'])?session('add_bill')['layout_price']:"", ['class' => 'form-control' , 'readonly'])}}
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
              <tbody class="others_head {{ empty(session('add_bill')['others_price'])?"hide":"" }}">
                <tr>
                  <td>内容</td>
                  <td>単価</td>
                  <td>数量</td>
                  <td>金額</td>
                  <td>追加/削除</td>
                </tr>
              </tbody>
              <tbody class="others_main {{ empty(session('add_bill')['others_price'])?"hide":"" }}">
                @if (empty(session('add_bill')['others_price']))
                <tr>
                  <td>{{ Form::text('others_breakdown_item0', '', ['class' => 'form-control'])}}</td>
                  <td>{{ Form::text('others_breakdown_cost0', '', ['class' => 'form-control'])}}</td>
                  <td>{{ Form::text('others_breakdown_count0', '', ['class' => 'form-control number_validation'])}}</td>
                  <td>{{ Form::text('others_breakdown_subtotal0', '', ['class' => 'form-control', 'readonly'])}}</td>
                  <td>
                    <input type="button" value="＋" class="add pluralBtn">
                    <input type="button" value="ー" class="del pluralBtn">
                  </td>
                </tr>
                @else
                @for ($i = 0; $i < $others; $i++) <tr>
                  <td>
                    {{ Form::text('others_breakdown_item'.$i, $data['others_breakdown_item'.$i], ['class' => 'form-control'])}}
                  </td>
                  <td>
                    {{ Form::text('others_breakdown_cost'.$i, $data['others_breakdown_cost'.$i], ['class' => 'form-control'])}}
                  </td>
                  <td>
                    {{ Form::text('others_breakdown_count'.$i, $data['others_breakdown_count'.$i], ['class' => 'form-control number_validation'])}}
                  </td>
                  <td>
                    {{ Form::text('others_breakdown_subtotal'.$i, $data['others_breakdown_subtotal'.$i], ['class' => 'form-control', 'readonly'])}}
                  </td>
                  <td>
                    <input type="button" value="＋" class="add pluralBtn">
                    <input type="button" value="ー" class="del pluralBtn">
                  </td>
                  </tr>
                  @endfor
                  @endif
              </tbody>
              <tbody class="others_result {{ empty(session('add_bill')['others_price'])?"hide":"" }}">
                <tr>
                  <td colspan="4"></td>
                  <td colspan="1">
                    <p class="text-left">合計</p>
                    {{ Form::text('others_price', !empty(session('add_bill')['others_price'])?session('add_bill')['others_price']:"", ['class' => 'form-control' , 'readonly'])}}
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
                    {{ Form::text('master_subtotal', !empty(session('add_bill')['master_subtotal'])?session('add_bill')['master_subtotal']:"", ['class' => 'form-control' , 'readonly'])}}
                    <p class="is-error-master_subtotal" style="color: red"></p>
                  </td>
                </tr>
                <tr>
                  <td>消費税：</td>
                  <td>
                    {{ Form::text('master_tax', !empty(session('add_bill')['master_tax'])?session('add_bill')['master_tax']:"", ['class' => 'form-control' , 'readonly'])}}
                    <p class="is-error-master_tax" style="color: red"></p>
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold">合計金額</td>
                  <td>
                    {{ Form::text('master_total', !empty(session('add_bill')['master_total'])?session('add_bill')['master_total']:"", ['class' => 'form-control' , 'readonly'])}}
                    <p class="is-error-master_total" style="color: red"></p>
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
                    {{ Form::text('bill_created_at', date('Y-m-d',strtotime(Carbon\Carbon::now())), ['class' => 'form-control' ,'id'=>'datepicker6'])}}

                  </td>
                  <td>支払期日
                    {{ Form::text('pay_limit', $pay_limit, ['class' => 'form-control datepicker' ,'id'=>''])}}
                  </td>
                </tr>
                <tr>
                  <td>請求書宛名
                    {{ Form::text('pay_company', $reservation->user->company, ['class' => 'form-control'])}}
                  </td>
                  <td>
                    担当者
                    {{ Form::text('bill_person', ReservationHelper::getPersonName($reservation->user->id), ['class' => 'form-control' ])}}
                  </td>
                </tr>
                <tr>
                  <td colspan="2">請求書備考
                    {{ Form::textarea('bill_remark', '', ['class' => 'form-control'])}}
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
                  <td>
                    入金状況{{Form::select('paid', ['未入金', '入金済み','遅延','入金不足','入金過多','次回繰越'],null,['class'=>'form-control'])}}
                  </td>
                  <td>
                    入金日{{ Form::text('pay_day', null,['class'=>'form-control', 'id'=>'datepicker7'] ) }}
                  </td>
                </tr>
                <tr>
                  <td>振込人名{{ Form::text('pay_person', null,['class'=>'form-control'] ) }}
                    <p class="is-error-pay_person" style="color: red"></p>
                  </td>
                  <td>入金額{{ Form::text('payment', null,['class'=>'form-control'] ) }}
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

  {{ Form::submit('確認する', ['class' => 'btn more_btn_lg mx-auto d-block mt-5 submit_btn']) }}

  {{ Form::close() }}

  <script>
$(function() {
  // チェックをされたら、ボタンのdisabledを解除
  if ($("input[type='checkbox']").prop('checked') == false ) {
      $('.submit_btn').prop('disabled', true);
    } else {
      $('.submit_btn').prop('disabled', false);
    }

  $("input[type='checkbox']").on('click', function() {
    if ( $(this).prop('checked') == false ) {
      $('.submit_btn').prop('disabled', true);
    } else {
      $('.submit_btn').prop('disabled', false);
    }
  });
});


    $(function() {
      // プラス・マイナス押下アクション
      $(document).on("click", ".add", function() {
        var target = $(this).parent().parent();
        target.clone(true).insertAfter(target);
        AddTr(target, 'venue_main', 'venue_breakdown');
        AddTr(target, 'equipment_main', 'equipment_breakdown');
        AddTr(target, 'layout_main', 'layout_breakdown');
        AddTr(target, 'others_main', 'others_breakdown');
        target.parent().find('tr').last().find('td').eq(0).find('input').val('');
        target.parent().find('tr').last().find('td').eq(1).find('input').val('');
        target.parent().find('tr').last().find('td').eq(2).find('input').val('');
        target.parent().find('tr').last().find('td').eq(3).find('input').val('');
      })

      function AddTr($target, $targetClass, $targetName) {
        if ($target.parent().hasClass($targetClass)) {
          var target_length = $target.parent().find('tr').length;
          for (let index = 0; index < target_length; index++) {
            $target.parent().find('tr').eq(index).find('td').eq(0).find('input').attr('name', $targetName + '_item' + index)
            $target.parent().find('tr').eq(index).find('td').eq(1).find('input').attr('name', $targetName + '_cost' + index)
            $target.parent().find('tr').eq(index).find('td').eq(2).find('input').attr('name', $targetName + '_count' + index)
            $target.parent().find('tr').eq(index).find('td').eq(3).find('input').attr('name', $targetName + '_subtotal' + index)
          }
        }
      }
      // マイナス押下
      $(document).on("click", ".del", function() {
        var master = $(this).parent().parent().parent().find('tr').length;
        var target = $(this).parent().parent();
        var re_target = target.parent();
        if (master > 1) {
          target.remove();
        } else {
          for (let index = 0; index < 3; index++) {
            target.find('input').eq(index).val('');
          }
        }
        DelTr(re_target, 'venue_main', 'venue_breakdown');
        DelTr(re_target, 'equipment_main', 'equipment_breakdown');
        DelTr(re_target, 'layout_main', 'layout_breakdown');
        DelTr(re_target, 'others_main', 'others_breakdown');
        DelCalc('.venues input', '.venue_main tr', 'input[name="venue_price"]');
        DelCalc('.equipment input', '.equipment_main tr', 'input[name="equipment_price"]');
        DelCalc('.layout input', '.layout_main tr', 'input[name="layout_price"]');
        DelCalc('.others input', '.others_main tr', 'input[name="others_price"]');

        MaterCalc();

      })

      function DelTr($target, $targetClass, $targetName) {
        if ($target.hasClass($targetClass)) {
          for (let num = 0; num < $target.find('tr').length; num++) {
            $target.find('tr').eq(num).find('td').eq(0).find('input').attr('name', $targetName + '_item' + num)
            $target.find('tr').eq(num).find('td').eq(1).find('input').attr('name', $targetName + '_cost' + num)
            $target.find('tr').eq(num).find('td').eq(2).find('input').attr('name', $targetName + '_count' + num)
            $target.find('tr').eq(num).find('td').eq(3).find('input').attr('name', $targetName + '_subtotal' + num)
          }
        }
      }

      function DelCalc($targetClass, $targetTr, $targetSum) {
        var trTarget = $($targetTr).length;
        var result_add = 0;
        for (let calc = 0; calc < trTarget; calc++) {
          var multiple1 = Number($($targetTr).eq(calc).find('td').eq(1).find('input').val());
          var multiple2 = Number($($targetTr).eq(calc).find('td').eq(2).find('input').val());
          var result = $($targetTr).eq(calc).find('td').eq(3).find('input').val(multiple1 * multiple2);
          result_add = result_add + (multiple1 * multiple2);
        }
        if (result_add != 0) {
          $($targetSum).val(result_add);
        } else {
          $($targetSum).val("");
        }
      };



      // チェックボックス開閉
      checkToggle('.venue_chkbox #venue', ['.venue_head', '.venue_main', '.venue_result']);
      checkToggle('.equipment_chkbox #equipment', ['.equipment_head', '.equipment_main', '.equipment_result']);
      checkToggle('.layout_chkbox #layout', ['.layout_head', '.layout_main', '.layout_result']);
      checkToggle('.others_chkbox #others', ['.others_head', '.others_main', '.others_result']);

      function checkToggle($target, $items) {
        $($target).on('click', function() {
          $.each($items, function(index, value) {
            $(value).toggleClass('hide');
          });
        });
      }

      // 各input からの計算
      calc('.venues input', '.venue_main tr', 'input[name="venue_price"]');
      calc('.equipment input', '.equipment_main tr', 'input[name="equipment_price"]');
      calc('.layout input', '.layout_main tr', 'input[name="layout_price"]');
      calc('.others input', '.others_main tr', 'input[name="others_price"]');

      function calc($targetClass, $targetTr, $targetSum) {
        $($targetClass).on('input', function() {
          var trTarget = $($targetTr).length;
          var result_add = 0;
          for (let calc = 0; calc < trTarget; calc++) {
            var multiple1 = Number($($targetTr).eq(calc).find('td').eq(1).find('input').val());
            var multiple2 = Number($($targetTr).eq(calc).find('td').eq(2).find('input').val());
            var result = $($targetTr).eq(calc).find('td').eq(3).find('input').val(multiple1 * multiple2);
            result_add = result_add + (multiple1 * multiple2);
          }
          if (result_add != 0) {
            $($targetSum).val(result_add);
          } else {
            $($targetSum).val("");
          }
        })
      };

      // 総合計額抽出
      $('input').on('input', function() {
        MaterCalc();
      })

      function MaterCalc() {
        var tar1 = Number($('input[name="venue_price"]').val());
        var tar2 = Number($('input[name="equipment_price"]').val());
        var tar3 = Number($('input[name="layout_price"]').val());
        var tar4 = Number($('input[name="others_price"]').val());
        var master_sub = tar1 + tar2 + tar3 + tar4;
        var master_tax = Math.floor(Number((tar1 + tar2 + tar3 + tar4) * 0.1));

        $('input[name="master_subtotal"]').val(master_sub);
        $('input[name="master_tax"]').val(master_tax);
        $('input[name="master_total"]').val(master_sub + master_tax);

      }
    })
  </script>



  @endsection