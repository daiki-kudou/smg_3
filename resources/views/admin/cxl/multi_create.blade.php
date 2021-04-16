@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>

<h2 class="mt-3 mb-3">一括キャンセル請求書 作成</h2>
<hr>

{{ Form::open(['url' => 'admin/cxl/multi_calc', 'method'=>'POST', 'class'=>'','id'=>'cxlcalc']) }}
@csrf
{{Form::hidden('reservation_id',$reservation->id)}}
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
            @if ($price_result[0]!=0)
            <tbody class="venue_main_cancel">
              <tr>
                <td>会場料</td>
                <td>{{number_format($price_result[0])}}円</td>
                <td class="multiple">×</td>
                <td class="d-flex align-items-center">
                  {{Form::text('cxl_venue_PC',!empty(session('cxlCalcInfo')['cxl_venue_PC'])?session('cxlCalcInfo')['cxl_venue_PC']:"",['class'=>'form-control'])}}
                  <span class="ml-1">%</span>
                </td>
              </tr>
            </tbody>
            @endif
            @if ($price_result[1]!=0)
            <tbody class="equipment_cancel">
              <tr>
                <td>有料備品・有料サービス料</td>
                <td>{{number_format($price_result[1])}}円</td>
                <td class="multiple">×</td>
                <td class="d-flex align-items-center">
                  {{Form::text('cxl_equipment_PC',!empty(session('cxlCalcInfo')['cxl_equipment_PC'])?session('cxlCalcInfo')['cxl_equipment_PC']:"",['class'=>'form-control'])}}
                  <span class="ml-1">%</span></td>
              </tr>
            </tbody>
            @endif
            @if ($price_result[2]!=0)
            <tbody class="layout_cancel">
              <tr>
                <td>レイアウト変更料</td>
                <td>{{number_format($price_result[2])}}円</td>
                <td class="multiple">×</td>
                <td class="d-flex align-items-center">
                  {{Form::text('cxl_layout_PC',!empty(session('cxlCalcInfo')['cxl_layout_PC'])?session('cxlCalcInfo')['cxl_layout_PC']:"",['class'=>'form-control'])}}
                  <span class="ml-1">%</span></td>
              </tr>
            </tbody>
            @endif
            @if ($price_result[3]!=0)
            <tbody class="others_cancel">
              <tr>
                <td>その他</td>
                <td>{{number_format($price_result[3])}}円</td>
                <td class="multiple">×</td>
                <td class="d-flex align-items-center">
                  {{Form::text('cxl_other_PC',!empty(session('cxlCalcInfo')['cxl_other_PC'])?session('cxlCalcInfo')['cxl_other_PC']:"",['class'=>'form-control'])}}
                  <span class="ml-1">%</span></td>
              </tr>
            </tbody>
            @endif
          </table>
          {{ Form::submit('計算する', ['class' => 'btn more_btn_lg mx-auto d-block my-5']) }}
        </div>
      </div>
    </div>
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