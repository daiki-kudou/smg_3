@if ($other_bill->venue_price!=0||$other_bill->venue_price)
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
      @foreach ($other_bill->breakdowns()->get() as $venue_breakdown)
      @if ($venue_breakdown->unit_type==1)
      <tr>
        <td>{{$venue_breakdown->unit_item}}</td>
        <td>{{number_format($venue_breakdown->unit_cost)}}</td>
        <td>{{$venue_breakdown->unit_count}}</td>
        <td>{{number_format($venue_breakdown->unit_subtotal)}}</td>
      </tr>
      @endif
      @endforeach
    </tbody>
    <tbody class="venue_result">
      <tr>
        <td colspan="3"></td>
        <td colspan="1" class="">合計：{{number_format($other_bill->venue_price)}}</td>
      </tr>
    </tbody>
  </table>
</div>
@endif

@if ($other_bill->equipment_price!=0||$other_bill->equipment_price)
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
      @foreach ($other_bill->breakdowns()->get() as $equipment_breakdown)
      @if ($equipment_breakdown->unit_type==2)
      <tr>
        <td>{{$equipment_breakdown->unit_item}}</td>
        <td>{{number_format($equipment_breakdown->unit_cost)}}</td>
        <td>{{$equipment_breakdown->unit_count}}</td>
        <td>{{number_format($equipment_breakdown->unit_subtotal)}}</td>
      </tr>
      @endif
      @endforeach
      @foreach ($other_bill->breakdowns()->get() as $service_breakdown)
      @if ($service_breakdown->unit_type==3)
      <tr>
        <td>{{$service_breakdown->unit_item}}</td>
        <td>{{number_format($service_breakdown->unit_cost)}}</td>
        <td>{{$service_breakdown->unit_count}}</td>
        <td>{{number_format($service_breakdown->unit_subtotal)}}</td>
      </tr>
      @endif
      @endforeach
    </tbody>
    <tbody class="equipment_result">
      <tr>
        <td colspan="3"></td>
        <td colspan="1" class="">合計：{{number_format($other_bill->equipment_price)}}</td>
        </td>
      </tr>
    </tbody>
  </table>
</div>
@endif

@if ($other_bill->layout_price!=0||$other_bill->layout_price)
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
      @foreach ($other_bill->breakdowns()->get() as $layout_breakdown)
      @if ($layout_breakdown->unit_type==4)
      <tr>
        <td>{{$layout_breakdown->unit_item}}</td>
        <td>{{number_format($layout_breakdown->unit_cost)}}</td>
        <td>{{$layout_breakdown->unit_count}}</td>
        <td>{{number_format($layout_breakdown->unit_subtotal)}}</td>
      </tr>
      @endif
      @endforeach
    </tbody>
    <tbody class="layout_result">
      <tr>
        <td colspan="3"></td>
        <td colspan="1">合計：{{number_format($other_bill->layout_price)}}
        </td>
      </tr>
    </tbody>
  </table>
</div>
@endif

@if ($other_bill->others_price!=0||$other_bill->others_price)
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
      @foreach ($other_bill->breakdowns()->get() as $others_breakdown)
      @if ($others_breakdown->unit_type==5)
      <tr>
        <td>{{$others_breakdown->unit_item}}</td>
        <td>{{number_format($others_breakdown->unit_cost)}}</td>
        <td>{{$others_breakdown->unit_count}}</td>
        <td>{{number_format($others_breakdown->unit_subtotal)}}</td>
      </tr>
      @endif
      @endforeach
    </tbody>
    <tbody class="others_result">
      <tr>
        <td colspan="3"></td>
        <td colspan="1">合計：{{$other_bill->others_price}}
      </tr>
    </tbody>
  </table>
</div>
@endif