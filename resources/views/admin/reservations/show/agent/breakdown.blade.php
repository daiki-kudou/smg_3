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
      @foreach ($reservation->bills()->first()->breakdowns()->get() as $venue_breakdown)
      @if ($venue_breakdown->unit_type==1)
      <tr>
        <td>{{$venue_breakdown->unit_item}}</td>
        <td></td>
        <td>{{$venue_breakdown->unit_count}}</td>
        <td></td>
      </tr>
      @endif
      @endforeach
    </tbody>
  </table>
</div>

<div class="equipment billdetails_content">
  <table class="table table-borderless">
    <tbody>
      <tr>
        <td>
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
      @foreach ($reservation->bills()->first()->breakdowns()->get() as $equipment_breakdown)
      @if ($equipment_breakdown->unit_type==2)
      <tr>
        <td>{{$equipment_breakdown->unit_item}}</td>
        <td></td>
        <td>{{$equipment_breakdown->unit_count}}</td>
        <td></td>
      </tr>
      @endif
      @endforeach
      @foreach ($reservation->bills()->first()->breakdowns()->get() as $service_breakdown)
      @if ($service_breakdown->unit_type==3)
      <tr>
        <td>{{$service_breakdown->unit_item}}</td>
        <td></td>
        <td>{{$service_breakdown->unit_count}}</td>
        <td></td>
      </tr>
      @endif
      @endforeach
    </tbody>
  </table>
</div>

<div class="layout billdetails_content">
  <table class="table table-borderless">
    <tbody>
      <tr>
        <td colspan="2">
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
      @foreach ($reservation->bills()->first()->breakdowns()->get() as $layout_breakdown)
      @if ($layout_breakdown->unit_type==4)
      <tr>
        <td>{{$layout_breakdown->unit_item}}</td>
        <td>{{$layout_breakdown->unit_cost}}</td>
        <td>{{$layout_breakdown->unit_count}}</td>
        <td>{{$layout_breakdown->unit_subtotal}}</td>
      </tr>
      @endif
      @endforeach
    </tbody>
    <tbody class="layout_result">
      <tr>
        <td colspan="3"></td>
        <td colspan="1">合計：{{number_format($reservation->bills()->first()->layout_price)}}
        </td>
      </tr>
    </tbody>
  </table>
</div>

<div class="others billdetails_content">
  <table class="table table-borderless">
    <tbody>
      <tr>
        <td>
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
      @foreach ($reservation->bills()->first()->breakdowns()->get() as $others_breakdown)
      @if ($others_breakdown->unit_type==5)
      <tr>
        <td>{{$others_breakdown->unit_item}}</td>
        <td></td>
        <td>{{$others_breakdown->unit_count}}</td>
        <td></td>
      </tr>
      @endif
      @endforeach
    </tbody>
  </table>
</div>