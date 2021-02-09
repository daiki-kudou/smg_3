@extends('layouts.admin.app')

@section('content')



<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>

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

  /* ラベルのスタイル　*/
  .venue_chkbox label,
  .equipment_chkbox label,
  .layout_chkbox label,
  .others_chkbox label {
    padding-left: 38px;
    font-size: 32px;
    line-height: 32px;
    display: inline-block;
    cursor: pointer;
    position: relative;
  }


  .venue_chkbox input[type=checkbox],
  .equipment_chkbox input[type=checkbox],
  .layout_chkbox input[type=checkbox],
  .others_chkbox input[type=checkbox] {
    display: none;
  }

  .venue_chkbox input[type=checkbox]:checked+label:before,
  .equipment_chkbox input[type=checkbox]:checked+label:before,
  .layout_chkbox input[type=checkbox]:checked+label:before,
  .others_chkbox input[type=checkbox]:checked+label:before {
    content: '\2713';
    font-size: 34px;
    color: #fff;
    background-color: #06f;
  }
</style>

<h1>仲介会社　追加請求書</h1>

{{ Form::open(['url' => 'admin/agents_reservations/add_bills/store/'.$request->reservation_id, 'method'=>'POST']) }}
@csrf
{{ Form::hidden('reservation_id', $request->reservation_id, ['class' => 'form-control'])}}

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

        @if (!empty($request->venue_breakdown_item0))
        <div class="venues" style="padding-top: 80px; width:90%; margin:0 auto;">
          <table class="table table-borderless">
            <tbody>
              <tr>
                <td colspan="4">
                  <div class="venue_chkbox">
                    <label for="venue">■会場料</label>
                  </div>
                </td>
              </tr>
            </tbody>
            <tbody class="venue_head ">
              <tr>
                <td colspan="2">内容</td>
                <td colspan="2">数量</td>
              </tr>
            </tbody>
            <tbody class="venue_main ">
              @for ($i = 0; $i < (count($s_venues)/4); $i++) <tr>
                <td>
                  {{ Form::text('venue_breakdown_item'.$i, $s_venues[($i*4)], ['class' => 'form-control','readonly'])}}
                </td>
                <td>
                  {{ Form::hidden('venue_breakdown_cost'.$i, $s_venues[($i*4)+1], ['class' => 'form-control','readonly'])}}
                </td>
                <td>
                  {{ Form::text('venue_breakdown_count'.$i, $s_venues[($i*4)+2], ['class' => 'form-control','readonly'])}}
                </td>
                <td>
                  {{ Form::hidden('venue_breakdown_subtotal'.$i, $s_venues[($i*4)+3], ['class' => 'form-control','readonly'])}}
                </td>
                </tr>
                @endfor
            </tbody>
          </table>
        </div>
        @endif

        @if (!empty($request->equipment_breakdown_item0))
        <div class="equipment" style="padding-top: 80px; width:90%; margin:0 auto;">
          <table class="table table-borderless">
            <tbody>
              <tr>
                <td colspan="4">
                  <div class="equipment_chkbox">
                    <input type="checkbox" id="equipment" name="equipment" value="1" />
                    <label for="equipment">■有料備品・サービス料</label>
                  </div>
                </td>
              </tr>
            </tbody>
            <tbody class="equipment_head ">
              <tr>
                <td colspan="2">内容</td>
                <td colspan="2">数量</td>
              </tr>
            </tbody>
            <tbody class="equipment_main ">
              @for ($i = 0; $i < (count($s_equipments)/4); $i++) <tr>
                <td>
                  {{ Form::text('equipment_breakdown_item'.$i, $s_equipments[($i*4)], ['class' => 'form-control','readonly'])}}
                </td>
                <td>
                  {{ Form::hidden('equipment_breakdown_cost'.$i, $s_equipments[($i*4)+1], ['class' => 'form-control','readonly'])}}
                </td>
                <td>
                  {{ Form::text('equipment_breakdown_count'.$i, $s_equipments[($i*4)+2], ['class' => 'form-control','readonly'])}}
                </td>
                <td>
                  {{ Form::hidden('equipment_breakdown_subtotal'.$i, $s_equipments[($i*4)+3], ['class' => 'form-control','readonly'])}}
                </td>
                </tr>
                @endfor
            </tbody>
          </table>
        </div>
        @endif

        @if (!empty($request->layout_breakdown_cost0))
        <div class="layout" style="padding-top: 80px; width:90%; margin:0 auto;">
          <table class="table table-borderless">
            <tbody>
              <tr>
                <td colspan="4">
                  <div class="layout_chkbox ">
                    <input type="checkbox" id="layout" name="layout" value="1" />
                    <label for="layout">■レイアウト変更料</label>
                  </div>
                </td>
              </tr>
            </tbody>
            <tbody class="layout_head ">
              <tr>
                <td>内容</td>
                <td>単価</td>
                <td>数量</td>
                <td>金額</td>
              </tr>
            </tbody>
            <tbody class="layout_main ">
              @for ($i = 0; $i < count($s_layouts)/4; $i++) <tr>
                <td>
                  {{ Form::text('layout_breakdown_item'.$i, $s_layouts[$i*4], ['class' => 'form-control','readonly'])}}
                </td>
                <td>
                  {{ Form::text('layout_breakdown_cost'.$i, $s_layouts[$i*4+1], ['class' => 'form-control','readonly'])}}
                </td>
                <td>
                  {{ Form::text('layout_breakdown_count'.$i, $s_layouts[$i*4+2], ['class' => 'form-control','readonly'])}}
                </td>
                <td>
                  {{ Form::text('layout_breakdown_subtotal'.$i, $s_layouts[$i*4+3], ['class' => 'form-control','readonly'])}}
                </td>
                </tr>
                @endfor
            </tbody>
            <tbody class="layout_result ">
              <tr>
                <td colspan="2"></td>
                <td colspan="2">合計
                  {{ Form::text('layout_price', $request->layout_price, ['class' => 'form-control' , 'readonly'])}}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        @endif


        @if (!empty($request->others_breakdown_item0))
        <div class="others" style="padding: 80px 0px 80px 0px; width:90%; margin:0 auto;">
          <table class="table table-borderless">
            <tbody>
              <tr>
                <td colspan="4">
                  <div class="others_chkbox">
                    <input type="checkbox" id="others" name="others" value="1" />
                    <label for="others">■その他</label>
                  </div>
                </td>
              </tr>
            </tbody>
            <tbody class="others_head ">
              <tr>
                <td colspan="2">内容</td>
                <td colspan="2">数量</td>
              </tr>
            </tbody>
            <tbody class="others_main ">
              @for ($i = 0; $i < (count($s_others)/4); $i++) <tr>
                <td>
                  {{ Form::text('others_breakdown_item'.$i, $s_others[($i*4)], ['class' => 'form-control','readonly'])}}
                </td>
                <td>
                  {{ Form::hidden('others_breakdown_cost'.$i, $s_others[($i*4)+1], ['class' => 'form-control','readonly'])}}
                </td>
                <td>
                  {{ Form::text('others_breakdown_count'.$i, $s_others[($i*4)+2], ['class' => 'form-control','readonly'])}}
                </td>
                <td>
                  {{ Form::hidden('others_breakdown_subtotal'.$i, $s_others[($i*4)+3], ['class' => 'form-control','readonly'])}}
                </td>
                </tr>
                @endfor
            </tbody>
          </table>
        </div>
        @endif


        <div class="bill_total d-flex justify-content-end"
          style="padding: 80px 0px 80px 0px; width:90%; margin:0 auto;">
          <div style="width: 60%;">
            <table class="table text-right" style="table-layout: fixed; font-size:16px;">
              <tbody>
                <tr>
                  <td class="font-weight-bold">エンドクライアントへの
                    <br>
                    支払い料（支払割合
                    %）
                  </td>
                  <td>
                    {{ Form::text('enduser_charge', $request->enduser_charge, ['class' => 'form-control',"readonly" ])}}
                  </td>
                </tr>
                <tr>
                  <td>小計：</td>
                  <td>
                    {{ Form::text('master_subtotal', $request->master_subtotal, ['class' => 'form-control' , 'readonly'])}}
                  </td>
                </tr>
                <tr>
                  <td>消費税：</td>
                  <td>
                    {{ Form::text('master_tax', $request->master_tax, ['class' => 'form-control' , 'readonly'])}}
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold">合計金額</td>
                  <td>
                    {{ Form::text('master_total', $request->master_total, ['class' => 'form-control' , 'readonly'])}}
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
          <table class="table">
            <tbody>
              <tr>
                <td>請求日：</td>
                <td>支払期日
                  {{ Form::text('pay_limit', $request->pay_limit, ['class' => 'form-control' ,"readonly"])}}
                </td>
              </tr>
              <tr>
                <td>請求書宛名
                  {{ Form::text('pay_company', $request->pay_company, ['class' => 'form-control',"readonly"])}}
                </td>
                <td>
                  担当者
                  {{ Form::text('bill_person', $request->bill_person, ['class' => 'form-control',"readonly" ])}}
                </td>
              </tr>
              <tr>
                <td colspan="2">請求書備考
                  {{ Form::textarea('bill_remark', $request->bill_remark, ['class' => 'form-control',"readonly"])}}
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
                  {{Form::text('', $request->paid==0?"未入金":"入金済",['class'=>'form-control', 'readonly'])}}
                  {{Form::hidden('paid', $request->paid,['class'=>'form-control'])}}
                </td>
                <td>
                  入金日
                  {{ Form::text('', $request->pay_day,['class'=>'form-control',"readonly"] ) }}
                  {{ Form::hidden('pay_day', $request->pay_day) }}
                </td>
              </tr>
              <tr>
                <td>振込人名
                  {{ Form::text('pay_person', $request->pay_person,['class'=>'form-control',"readonly"] ) }}
                </td>
                <td>入金額
                  {{ Form::text('payment', $request->payment,['class'=>'form-control',"readonly"] ) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="mt-5 d-flex justify-content-center">
  {{ Form::submit('作成する', ['class' => 'btn btn-primary d-block btn-lg']) }}</div>

{{ Form::close() }}


{{-- <script>
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
      $($targetSum).val(result_add);
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
    // calc('.venues input', '.venue_main tr', 'input[name="venue_price"]');
    // calc('.equipment input', '.equipment_main tr', 'input[name="equipment_price"]');
    calc('.layout input', '.layout_main tr', 'input[name="layout_price"]');
    // calc('.others input', '.others_main tr', 'input[name="others_price"]');

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
        $($targetSum).val(result_add);
      })
    };

    $('input[name="enduser_charge"]').on('input',function(){
      
      var val=Number($(this).val());
      var target_percent=Number($('#percent').text())/100;
      var result = Math.floor(val-(val*target_percent));
      $('input[name="enduser_charge_result"]').val(result);
    })

    // 総合計額抽出
    $('input').on('input', function() {
      MaterCalc();
    })

    function MaterCalc() {
      var tar3 = Number($('input[name="layout_price"]').val());
      var tar5 = Number($('input[name="enduser_charge_result"]').val());
      var master_sub = tar3+tar5;
      var master_tax = Math.floor(Number(( master_sub ) * 0.1));

      $('input[name="master_subtotal"]').val(master_sub);
      $('input[name="master_tax"]').val(master_tax);
      $('input[name="master_total"]').val(master_sub + master_tax);
      console.log(tar5);
    }






  })
</script> --}}





@endsection