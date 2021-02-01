@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/add_bill_ajax.js') }}"></script>
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

  .venue_chkbox label:before,
  .equipment_chkbox label:before,
  .layout_chkbox label:before,
  .others_chkbox label:before {
    content: '';
    width: 32px;
    height: 32px;
    display: inline-block;
    position: absolute;
    left: 0;
    background-color: #fff;
    box-shadow: inset 1px 2px 3px 0px #000;
    border-radius: 6px 6px 6px 6px;
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

<div id="fullOverlay">
  <div class="frame_spinner">
    <div class="spinner-border text-primary " role="status">
      <span class="sr-only hide">Loading...</span>
    </div>
  </div>
</div>

<div class="container-fluid">
  <h3>追加請求書</h3>
</div>
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
                  <div class="venue_chkbox">
                    <input type="checkbox" id="venue" name="venue" value="1" />
                    <label for="venue">会場料</label>
                  </div>
                </td>
              </tr>
            </tbody>
            <tbody class="venue_head hide">
              <tr>
                <td>内容</td>
                <td>単価</td>
                <td>数量</td>
                <td>金額</td>
                <td>追加/削除</td>
              </tr>
            </tbody>
            <tbody class="venue_main hide">
              <tr>
                <td>{{ Form::text('venue_breakdown_item0', '', ['class' => 'form-control'])}}</td>
                <td>{{ Form::text('venue_breakdown_cost0', '', ['class' => 'form-control'])}}</td>
                <td>{{ Form::text('venue_breakdown_count0', '', ['class' => 'form-control'])}}</td>
                <td>{{ Form::text('venue_breakdown_subtotal0', '', ['class' => 'form-control', 'readonly'])}}</td>
                <td>
                  <input type="button" value="＋" class="add pluralBtn">
                  <input type="button" value="ー" class="del pluralBtn">
                </td>
              </tr>
            </tbody>
            <tbody class="venue_result hide">
              <tr>
                <td colspan="2"></td>
                <td colspan="2">合計
                  {{ Form::text('venue_price', '', ['class' => 'form-control' , 'readonly'])}}
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
                  <div class="equipment_chkbox">
                    <input type="checkbox" id="equipment" name="equipment" value="1" />
                    <label for="equipment">有料備品・サービス料</label>
                  </div>
                </td>
              </tr>
            </tbody>
            <tbody class="equipment_head hide">
              <tr>
                <td>内容</td>
                <td>単価</td>
                <td>数量</td>
                <td>金額</td>
                <td>追加/削除</td>
              </tr>
            </tbody>
            <tbody class="equipment_main hide">
              <tr>
                <td>{{ Form::text('equipment_breakdown_item0', '', ['class' => 'form-control'])}}</td>
                <td>{{ Form::text('equipment_breakdown_cost0', '', ['class' => 'form-control'])}}</td>
                <td>{{ Form::text('equipment_breakdown_count0', '', ['class' => 'form-control'])}}</td>
                <td>{{ Form::text('equipment_breakdown_subtotal0', '', ['class' => 'form-control', 'readonly'])}}</td>
                <td>
                  <input type="button" value="＋" class="add pluralBtn">
                  <input type="button" value="ー" class="del pluralBtn">
                </td>
              </tr>
            </tbody>
            <tbody class="equipment_result hide">
              <tr>
                <td colspan="2"></td>
                <td colspan="2">合計
                  {{ Form::text('equipment_price', '', ['class' => 'form-control' , 'readonly'])}}
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
                  <div class="layout_chkbox ">
                    <input type="checkbox" id="layout" name="layout" value="1" />
                    <label for="layout">レイアウト変更料</label>
                  </div>
                </td>
              </tr>
            </tbody>
            <tbody class="layout_head hide">
              <tr>
                <td>内容</td>
                <td>単価</td>
                <td>数量</td>
                <td>金額</td>
                <td>追加/削除</td>
              </tr>
            </tbody>
            <tbody class="layout_main hide">
              <tr>
                <td>{{ Form::text('layout_breakdown_item0', '', ['class' => 'form-control'])}}</td>
                <td>{{ Form::text('layout_breakdown_cost0', '', ['class' => 'form-control'])}}</td>
                <td>{{ Form::text('layout_breakdown_count0', '', ['class' => 'form-control'])}}</td>
                <td>{{ Form::text('layout_breakdown_subtotal0', '', ['class' => 'form-control', 'readonly'])}}</td>
                <td>
                  <input type="button" value="＋" class="add pluralBtn">
                  <input type="button" value="ー" class="del pluralBtn">
                </td>
              </tr>
            </tbody>
            <tbody class="layout_result hide">
              <tr>
                <td colspan="2"></td>
                <td colspan="2">合計
                  {{ Form::text('layout_price', '', ['class' => 'form-control' , 'readonly'])}}
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
                  <div class="others_chkbox">
                    <input type="checkbox" id="others" name="others" value="1" />
                    <label for="others">その他</label>
                  </div>
                </td>
              </tr>
            </tbody>
            <tbody class="others_head hide">
              <tr>
                <td>内容</td>
                <td>単価</td>
                <td>数量</td>
                <td>金額</td>
                <td>追加/削除</td>
              </tr>
            </tbody>
            <tbody class="others_main hide">
              <tr>
                <td>{{ Form::text('others_breakdown_item0', '', ['class' => 'form-control'])}}</td>
                <td>{{ Form::text('others_breakdown_cost0', '', ['class' => 'form-control'])}}</td>
                <td>{{ Form::text('others_breakdown_count0', '', ['class' => 'form-control'])}}</td>
                <td>{{ Form::text('others_breakdown_subtotal0', '', ['class' => 'form-control', 'readonly'])}}</td>
                <td>
                  <input type="button" value="＋" class="add pluralBtn">
                  <input type="button" value="ー" class="del pluralBtn">
                </td>
              </tr>
            </tbody>
            <tbody class="others_result hide">
              <tr>
                <td colspan="2"></td>
                <td colspan="3">合計
                  {{ Form::text('others_price', '', ['class' => 'form-control' , 'readonly'])}}
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="bill_total d-flex justify-content-end"
          style="padding: 80px 0px 80px 0px; width:90%; margin:0 auto; background:">
          <div style="width: 60%;">
            <table class="table text-right" style="table-layout: fixed; font-size:16px;">
              <tbody>
                <tr>
                  <td>小計：</td>
                  <td>
                    <input class="form-control text-right" readonly="" name="master_subtotal" type="text" value="67975">
                  </td>
                </tr>
                <tr>
                  <td>消費税：</td>
                  <td>
                    <input class="form-control text-right" readonly="" name="master_tax" type="text" value="6797">
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold">合計金額</td>
                  <td>
                    <input class="form-control text-right" readonly="" name="master_total" type="text" value="74772">
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
                <td>支払期日 <input class="form-control hasDatepicker" id="datepicker6" name="pay_limit" type="text"
                    value="2021-02-01"> </td>
              </tr>
              <tr>
                <td>請求書宛名<input class="form-control" name="pay_company" type="text" value="test"></td>
                <td>
                  担当者<input class="form-control" name="bill_person" type="text" value="testtest">
                </td>
              </tr>
              <tr>
                <td colspan="2">請求書備考<textarea class="form-control" name="bill_remark" cols="50" rows="10"></textarea>
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
  </div>

























</div>
{{-- {{ Form::open(['url' => 'admin/bills/check/'.$reservation->id, 'method'=>'POST','id'=>'testid']) }}
@csrf

{{ Form::hidden('reservation', $reservation->id, ['class' => 'form-control', 'id'=>'reservation']) }}


<div class="content">
  <div class="container-fluid">
    <div class="container-field mt-3">
      <div class="float-right">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="http://staging-smg2.herokuapp.com/admin/home">ホーム</a> &gt;
              追加請求書作成
            </li>
          </ol>
        </nav>
      </div>
      <h1 class="mt-3 mb-5">追加請求書作成</h1>
    </div>

    <div class="categorybox d-flex justify-content-around">
      <p class="radio">
        <label>
          <input type="radio" name="billcategory" id="optionsRadios" value="1">その他の有料備品、サービス
        </label>
      </p>
      <p class="radio">
        <label>
          <input type="radio" name="billcategory" id="optionsRadios" value="2">レイアウト変更
        </label>
      </p>
      <p class="radio d-flex">
        <label style="width: 90px;">
          <input type="radio" name="billcategory" id="optionsRadios" value="3">その他
        </label>
        <label for="other"></label>
      </p>
    </div>

    <table class="table table-bordered extra-bill-table">
      <thead>
        <tr>
          <td class="table-active"><label for="billcontent">内容</label></td>
          <td class="table-active"><label for="billfee">単価</label></td>
          <td class="table-active"><label for="billquantity">個数</label></td>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>

    <div class="btn_wrapper">
      <p class=" btn text-center more_btn_lg add_bill_calculate">計算する</p>
    </div>

    <table class="result_table table table-bordered">
      <thead>
        <tr>
          <td colspan="4" style="background: gray">結果</td>
        </tr>
        <tr>
          <td>割引料金<input type="text" class="discount_input" name="discount_input"></td>
          <td>割引率　<input class="percentage" type="text" readonly disabled name="percentage">%</td>
          <td colspan="2"> </td>
        </tr>
        <tr>
          <td>内容</td>
          <td>単価</td>
          <td>個数</td>
          <td>合計</td>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
    <div>
      <p>小計</p>
      <input type="text" class="sub_total" readonly name="sub_total">
      <p>割引後　備品その他合計</p>
      <input class="after_dicsount" type="text" readonly name="after_dicsount">
      <p>消費税</p>
      <input class="tax" type="text" readonly name="tax">
      <p>請求総額</p>
      <input class="total" type="text" readonly name="total">
    </div>


  </div>
</div>
</div>

<input type="submit" value="確認する">
{{ Form::close() }} --}}



<script>
  $(function () {
  // プラス・マイナス押下アクション
  $(document).on("click", ".add", function () {
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
  $(document).on("click", ".del", function () {
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
  function DelCalc($targetClass, $targetTr, $targetSum){
    var trTarget=$($targetTr).length;
    var result_add=0;
    for (let calc = 0; calc < trTarget; calc++) {
      var multiple1=Number($($targetTr).eq(calc).find('td').eq(1).find('input').val());
      var multiple2=Number($($targetTr).eq(calc).find('td').eq(2).find('input').val());
      var result=$($targetTr).eq(calc).find('td').eq(3).find('input').val(multiple1*multiple2);
      result_add=result_add+(multiple1*multiple2);
    }
    $($targetSum).val(result_add);
};

  

// チェックボックス開閉
  checkToggle('.venue_chkbox #venue', ['.venue_head', '.venue_main', '.venue_result']);
  checkToggle('.equipment_chkbox #equipment', ['.equipment_head', '.equipment_main', '.equipment_result']);
  checkToggle('.layout_chkbox #layout', ['.layout_head', '.layout_main', '.layout_result']);
  checkToggle('.others_chkbox #others', ['.others_head', '.others_main', '.others_result']);
  function checkToggle($target, $items){
  $($target).on('click', function () {
    $.each($items, function (index, value) {
      $(value).toggleClass('hide');
    });
  });
}

// 各input からの計算
calc('.venues input', '.venue_main tr', 'input[name="venue_price"]');
calc('.equipment input', '.equipment_main tr', 'input[name="equipment_price"]');
calc('.layout input', '.layout_main tr', 'input[name="layout_price"]');
calc('.others input', '.others_main tr', 'input[name="others_price"]');
function calc($targetClass, $targetTr, $targetSum){
    $($targetClass).on('input',function(){
    var trTarget=$($targetTr).length;
    var result_add=0;
    for (let calc = 0; calc < trTarget; calc++) {
      var multiple1=Number($($targetTr).eq(calc).find('td').eq(1).find('input').val());
      var multiple2=Number($($targetTr).eq(calc).find('td').eq(2).find('input').val());
      var result=$($targetTr).eq(calc).find('td').eq(3).find('input').val(multiple1*multiple2);
      result_add=result_add+(multiple1*multiple2);
    }
    $($targetSum).val(result_add);
  })
};








})
</script>



@endsection