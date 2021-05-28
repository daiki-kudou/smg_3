@extends('layouts.reservation.app')
@section('content')
<main>
  <div class="contents">
    <div class="pagetop-text">
      <h1 class="page-title oddcolor"><span>会場予約 料金確認画面</span></h1>
    </div>
  </div>
  <section class="contents">
    <h2>予約1</h2>

    {{ Form::open(['url' => 'user/reservations/store_session', 'method'=>'POST', 'id'=>'']) }}
    <div class="bgColorGray first">
      <table>
        <tr>
          <th>利用日</th>
          <td>
            {{ReservationHelper::formatDate($request->date)}}
          </td>
        </tr>
        <tr>
          <th>利用時間</th>
          <td>
            <ul class="form-cell">
              <li class="form-cell">
                <p>入室</p>
                <p>{{ReservationHelper::formatTime($request->enter_time)}}</p>
              </li>
              <li>～</li>
              <li class="form-cell">
                <p>退室</p>
                <p>{{ReservationHelper::formatTime($request->leave_time)}}</p>
              </li>
            </ul>
          </td>
        </tr>
        <tr>
          <th>利用会場</th>
          <td>
            {{ReservationHelper::getVenueForUser($request->venue_id)}}
            {{Form::hidden('venue_id',$request->venue_id)}}
          </td>
        </tr>
        <tr>
          <th>当日の担当者</th>
          <td>
            {{$request->in_charge}}
            {{ Form::hidden('in_charge', $request->in_charge) }}
            <br class="spOnlyunder">
            <a name="a-nam" class="error-r"></a>
          </td>
        </tr>
        <tr>
          <th>当日の担当者連絡先</th>
          <td>
            {{$request->tel}}
            {{ Form::hidden('tel', $request->tel) }}
            <br class="spOnlyunder">
            <a name="a-nam" class="error-r"></a>
          </td>
        </tr>
        <tr>
          <th>音響ハイグレード</th>
          <td class="">
            <ul>
              <li>
                {{$request->price_system==1?'しない':'する'}}
                {{ Form::hidden('price_system', $request->price_system) }}
              </li>
            </ul>
            <a name="a-selectTime1" class="error-r"></a>
          </td>
        </tr>
        <tr>
          <th>案内板</th>
          <td class="">
            <ul>
              <li>
                {{$request->board_flag==1?'する':'しない'}}
                {{ Form::hidden('board_flag', $request->board_flag) }}
              </li>
              @if ($request->board_flag==1)
              <li class="cell-margin">
                <div class="m-b10">
                  <p>【イベント名称1行目】</p>
                  {{$request->event_name1}}
                  {{ Form::hidden('event_name1', $request->event_name1) }}
                </div>
                <div class="m-b10">
                  <p>【イベント名称2行目】</p>
                  {{$request->event_name2}}
                  {{ Form::hidden('event_name2', $request->event_name2) }}
                </div>
                <div class="m-b10">
                  <p>【主催者名】</p>
                  {{$request->event_owner}}
                  {{ Form::hidden('event_owner', $request->event_owner) }}
                </div>
                <ul class="">
                  <li class="m-b10">
                    <p>【イベント開始時間】</p>
                    {{$request->event_start}}
                    {{ Form::hidden('event_start', $request->event_start) }}
                  </li>
                  <li>
                    <p>【イベント終了時間】</p>
                    {{$request->event_finish}}
                    {{ Form::hidden('event_finish', $request->event_finish) }}
                  </li>
                </ul>
              </li>
              @endif

          </td>
          </li>
          </ul>
          </td>
        </tr>

        @if ($venue->eat_in_flag!=0)
        <tr>
          <th>室内飲食</th>
          <td>
            <p>
              {{$request->eat_in==1?"あり：":"なし"}}
              {{Form::hidden('eat_in',$request->eat_in)}}
              <span>
                @if ($request->eat_in==1)
                @if ($request->eat_in_prepare==1)
                手配済み
                {{Form::hidden('eat_in_prepare',$request->eat_in_prepare)}}
                @else
                検討中
                {{Form::hidden('eat_in_prepare',$request->eat_in_prepare)}}
                @endif
                @endif
              </span>
            </p>
          </td>
        </tr>
        @endif



        @if ($venue->getEquipments()->count()!=0)
        <tr>
          <th>有料備品</th>
          <td class="spec-space">
            <ul>
              @foreach ($venue->getEquipments() as $e_key=>$eqpt)
              @if ($request->{'equipment_breakdown'.$e_key}==0||$request->{'equipment_breakdown'.$e_key}=="")
              @continue
              @else
              <li class="form-cell2">
                <p class="text6">{{$eqpt->item}}</p>
                <p>
                  <p class="text4" style="margin-left: 20px;">{{($request->{'equipment_breakdown'.$e_key})}}個</p>
                  {{ Form::hidden('equipment_breakdown'.$e_key, ($request->{'equipment_breakdown'.$e_key}),['class'=>'text4 mL0'] ) }}
                </p>
              </li>
              @endif
              @endforeach
            </ul>
          </td>
        </tr>
        @endif

        @if ($venue->getServices()->count()!=0)
        <tr>
          <th>有料サービス</th>
          <td class="spec-space">
            <ul>
              @foreach ($venue->getServices() as $s_key=>$serv)
              @if ($request->{'services_breakdown'.$s_key}!=0)
              <li class="form-cell2">
                <span class="">{{$serv->item}} {{$serv->price}}円</span>
                {{ Form::hidden('services_breakdown'.$s_key, ($request->{'services_breakdown'.$e_key}) ) }}
              </li>
              @endif
              @endforeach
            </ul>
          </td>
        </tr>
        @endif


        <tr>
          @if ($request->layout_prepare==1)
          <th>レイアウト変更</th>
          <td class="spec-space">
            <div class="m-b10">
              <p>レイアウト準備</p>
              {{$request->layout_prepare==1?"あり":"なし"}}
              {{ Form::hidden('layout_prepare', $request->layout_prepare ) }}
              <a name="a-selectTime1" class="error-r"></a>
            </div>
            @endif
            @if ($request->layout_clean==1)
            <div class="m-b10">
              <p>片付</p>
              {{$request->layout_clean==1?"あり":"なし"}}
              {{ Form::hidden('layout_clean', $request->layout_clean ) }}
              <a name="a-selectTime1" class="error-r"></a>
            </div>
            @endif
          </td>
        </tr>

        @if ($venue->getLuggage()!=0)
        <tr>
          <th>荷物預り/返送</th>
          <td class="spec-space">
            <div class="m-b10">
              <p>事前に預かる荷物</p>
              <div class="selectTime">
                <p class="">目安</p>
                <p class="">{{$request->luggage_count}}</p>
                {{ Form::hidden('luggage_count', $request->luggage_count ) }}
                <p class="">個</p>
              </div>
            </div>
            <div class="m-b10">
              <p>【事前荷物の到着日</p>
              <p class="">{{$request->luggage_arrive}}</p>
              {{ Form::hidden('luggage_arrive', $request->luggage_arrive ) }}
            </div>
            <a name="a-baggagedate" class="error-r"></a>
            <div class="m-b10">
              <p>事後返送する荷物】</p>
              <div class="selectTime">
                <p class="">目安</p>
                <p class="">{{$request->luggage_return}}</p>
                {{ Form::hidden('luggage_return', $request->luggage_return ) }}
                <p class="">個</p>
              </div>
            </div>
            <a name="a-baggagedate" class="error-r"></a>
          </td>
        </tr>
        @endif


        <tr>
          <th>備考</th>
          <td>
            <p col='30' rows='10'>{{$request->remark}}</p>
            {{ Form::hidden('remark', $request->remark ) }}
            <a name="a-nam" class="error-r"></a>
          </td>
        </tr>
      </table>
    </div>

    <div class="section-wrap">
      <table class="table-sum">
        <thead>
          <tr>
            <th colspan="2">
              料金内訳
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th class=""><label for="date">利用日</label></th>
            <td>
              <ul class="sum-list">
                <li>
                  <p>{{ReservationHelper::formatDate($request->date)}}</p>
                  {{ Form::hidden('date', date('Y-m-d',strtotime($request->date)) ) }}
                </li>
              </ul>
            </td>
          </tr>
          <tr>
            <th class=""><label for="venueFee">会場料金</label></th>
            <td>
              <ul class="sum-list">
                <li>
                  <p>
                    {{ReservationHelper::formatTime($request->enter_time)}}
                    {{Form::hidden('enter_time',$request->enter_time)}}
                    ～
                    {{ReservationHelper::formatTime($request->leave_time)}}
                    {{Form::hidden('leave_time',$request->leave_time)}}
                  </p>
                  <p>{{number_format($price_result[0])}}<span>円</span></p>
                </li>
                @if ($price_result[1]!=0)
                <li>
                  <p>延長{{$price_result[4]}}h</p>
                  <p>{{number_format($price_result[1])}}<span>円</span></p>
                </li>
                @endif
              </ul>
            </td>
          </tr>



          @if (ReservationHelper::checkEquipmentBreakdowns($request->all())!=0)
          <tr>
            <th class=""><label for="equipment">有料備品</label></th>
            <td>
              <ul class="sum-list">
                @foreach ($items_results[1] as $i_key=>$item_result)
                <li>
                  <p>{{$item_result[0]}}<span>×</span><span>{{$item_result[2]}}</span></p>
                  <p>
                    {{number_format(ReservationHelper::numTimesNum($item_result[1], $item_result[2]))}}
                    <span>円</span>
                  </p>
                </li>
                @endforeach
              </ul>
            </td>
          </tr>
          @endif



          @if (ReservationHelper::checkServiceBreakdowns($request->all())!=0)
          <tr>
            <th class=""><label for="service">有料サービス</label></th>
            <td>
              <ul class="sum-list">
                @foreach ($items_results[2] as $s_key=>$service_result)
                <li>
                  <p>{{$service_result[0]}}</p>
                  <p>{{number_format($service_result[1])}}<span>円</span></p>
                </li>
                @endforeach
                @if ($request->luggage_count||$request->luggage_arrive||$request->luggage_return)
                <li>
                  <p>荷物預り/返送</p>
                  <p>500<span>円</span></p>
                </li>
                @endif
              </ul>
            </td>
          </tr>
          @endif


          @if ($request->layout_prepare!=0||$request->layout_clean!=0)
          <tr>
            <th class=""><label for="service">レイアウト変更</label></th>
            <td>
              <ul class="sum-list">
                @if ($request->layout_prepare==1)
                <li>
                  <p>レイアウト準備料金</p>
                  <p>{{number_format($venue->layout_prepare)}}<span>円</span></p>
                </li>
                @endif
                @if ($request->layout_clean==1)
                <li>
                  <p>レイアウト片付料金</p>
                  <p>{{number_format($venue->layout_clean)}}<span>円</span></p>
                </li>
                @endif
              </ul>
            </td>
          </tr>
          @endif

          <tr>
            <td colspan="2" class="text-right">
              <p class="checkbox-txt"><span>小計</span>{{number_format($master)}}円</p>
              <p class="checkbox-txt"><span>消費税</span>{{number_format(ReservationHelper::getTax($master))}}円</p>
            </td>
          </tr>
          <tr>
            <td colspan="2" class="text-right checkbox-txt"><span>合計金額</span>
              <span class="sumText">{{number_format(ReservationHelper::taxAndPrice($master))}}</span><span>円</span>
              <p class="txtRight">※上記合計金額にケータリングは入っておりません。<br>
                ※お申込み内容によっては、弊社からご連絡の上で、合計金額が変更となる場合がございます</p>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <ul class="btn-wrapper">
      <li>

        {{Form::submit('修正する',['class'=>'link-btn','style'=>'width:100%;', 'name'=>'back'])}}
      </li>
      <li>
        {{Form::hidden('price_result',json_encode($price_result))}}
        {{Form::hidden('items_results',json_encode($items_results))}}
        {{Form::hidden('master',$master)}}
        {{Form::hidden('select_id',$request->select_id)}}
        {{Form::submit('カートに追加する',['class'=>'confirm-btn','style'=>'width:100%;', 'name'=>'store'])}}
      </li>
    </ul>
    {{Form::close()}}

  </section>

  <div class="top contents"><a href="#top"><img src="https://osaka-conference.com/img/pagetop.png" alt="上に戻る"></a>
  </div>
</main>
@endsection