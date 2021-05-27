@extends('layouts.reservation.app')
@section('content')

<script src="{{ asset('/js/user_reservation/validation.js') }}"></script>
<script src="{{ asset('/js/lettercounter.js') }}"></script>


<div class="contents">
  <div class="pagetop-text">
    <h1 class="page-title oddcolor"><span>会場予約 変更画面</span></h1>
    <p>下記フォームに必要事項を入力してください。(＊は必須項目です)</p>
    <p class="txtRed">複数日程を希望の場合は予約日毎に予約入力してください。</p>
  </div>
</div>
<section class="contents">
  <h2>予約1</h2>

  {{ Form::open(['url' => 'user/reservations/check', 'method'=>'POST', 'id'=>'user_reservation_re_calculate']) }}
  <div class="bgColorGray first">
    <table>
      <tr>
        <th>利用日</th>
        <td>
          {{ReservationHelper::formatDate($fix->date)}}
        </td>
      </tr>
      <tr>
        <th>利用時間</th>
        <td>
          <ul class="form-cell">
            <li class="form-cell">
              <p>入室</p>
              <p>{{ReservationHelper::formatTime($fix->enter_time)}}</p>
            </li>
            <li>～</li>
            <li class="form-cell">
              <p>退室</p>
              <p>{{ReservationHelper::formatTime($fix->leave_time)}}</p>
            </li>
          </ul>
          <div class="borderAttention">
            <p><span>入室時間より以前に入室はできません。<br>確認の上、チェックボックスをクリックしてください。</span></p>
            <p class="checkbox-txt">
              <span class="txtRed">＊</span>
              {{Form::checkbox('q1', 1, false, ['class'=>'custom-control-input','id'=>'checkbox'])}}
              <label for="checkbox">確認しました</label>
              <p class="is-error-q1" style="color: red"></p>

          </div>
          <p><a class="link-btn2" href="/">日程を変更する</a></p>
        </td>
      </tr>
      <tr>
        <th>利用会場</th>
        <td>
          {{ReservationHelper::getVenueForUser($fix->venue_id)}}
        </td>
      </tr>
      <tr>
        <th>当日の担当者 <span class="txtRed c-block">＊</span></th>
        <td>
          {{ Form::text('in_charge', $fix->in_charge,['class'=>'form-control text2', 'placeholder'=>'入力してください'] ) }}
          <br class="spOnlyunder">
          <p class="is-error-in_charge" style="color: red"></p>
        </td>
      </tr>
      <tr>
        <th>当日の担当者連絡先 <span class="txtRed c-block">＊</span></th>
        <td>
          {{ Form::text('tel', $fix->tel,['class'=>'form-control text2', 'placeholder'=>'入力してください'] ) }}
          <br class="spOnlyunder">
          <p class="is-error-tel" style="color: red"></p>
        </td>
      </tr>
      <tr>
        <th>音響ハイグレード<span class="txtRed c-block">＊</span></th>
        <td class="">
          <ul>
            <li>
              <div class="selectTime">
                {{ Form::radio('price_system', 2, $fix->price_system==2?true:false, ['class'=>'radio-input','id'=>'price_system_radio2']) }}
                {{Form::label('price_system_radio2','する')}}
                {{ Form::radio('price_system', 1, $fix->price_system==1?true:false, ['class'=>'radio-input', 'id'=>'price_system_radio1']) }}
                {{Form::label('price_system_radio1','しない')}}
              </div>
            </li>
            <li><a href=""><i class="fas fa-question-circle form-icon"></i>音響ハイグレードとは？</a></li>
          </ul>
          <a name="a-selectTime1" class="error-r"></a>
        </td>
      </tr>
      <tr>
        <th>案内板<span class="txtRed c-block">＊</span></th>
        <td class="">
          <ul>
            <li>
              <div class="selectTime">
                {{ Form::radio('board_flag', 1, $fix->board_flag==1?true:false, ['class'=>'radio-input','id'=>'board_flag']) }}
                {{Form::label('board_flag','する')}}
                {{ Form::radio('board_flag', 0, $fix->board_flag==0?true:false, ['class'=>'radio-input', 'id'=>'no_board_flag']) }}
                {{Form::label('no_board_flag','しない')}}
              </div>
            </li>
            <li><a href=""><i class="fas fa-external-link-alt form-icon"></i>案内板サンプルはこちら</a></li>
            <li class="cell-margin">
              <div class="m-b10">
                <p><span class="txtRed c-block">＊</span>イベント名称1行目</p>
                <div class="form-counter">
                  {{ Form::text('event_name1',$fix->event_name1,['class'=>'form-control text2', 'placeholder'=>'入力してください', 'id'=>'eventname1Count'] ) }}
                  <span class="count_num1"></span>
                </div>
                <p class="is-error-event_name1" style="color: red"></p>
              </div>
              <div class="m-b10">
                <p>イベント名称2行目</p>
                <div class="form-counter">
                  {{ Form::text('event_name2',$fix->event_name2,['class'=>'form-control text2', 'placeholder'=>'入力してください', 'id'=>'eventname2Count'] ) }}
                  <span class="count_num2"></span>
                </div>
                <p class="is-error-event_name2" style="color: red"></p>
              </div>
              <div class="m-b10">
                <p>主催者名</p>
                <div class="form-counter">
                  {{ Form::text('event_owner',$fix->event_owner,['class'=>'form-control text2', 'placeholder'=>'入力してください', 'id'=>'eventownerCount'] ) }}
                  <span class="count_num3"></span>
                </div>
                <p class="is-error-event_owner" style="color: red"></p>
              </div>
              {{-- <div class="m-b10">
                <p><span class="txtRed c-block">＊</span>イベント時間の記載</p>
                <div class="selectTime">
                  <input type="radio" id="eventTime" name="eventTime" value="あり" class="radio-input">
                  <label for="eventTime"><span>あり</span></label>
                  <input type="radio" id="eventTimeNone" name="eventTime" value="なし" class="radio-input">
                  <label for="eventTimeNone"><span>なし</span></label>
                </div>
              </div> --}}
              <ul class="form-cell">
                <li>
                  <p>イベント開始時間</p>
                  <div class="selectWrap">
                    <select name="event_start" id="event_start" class="form-control timeScale">
                      <option disabled>選択してください</option>
                      @for ($start = 0*2; $start <=23*2; $start++) <option
                        value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if(($fix->
                        enter_time==date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))))
                        selected
                        @endif>
                        {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}</option>
                        @endfor
                    </select>
                  </div>
                </li>
                <li>
                  <p>イベント終了時間</p>
                  <div class="selectWrap">
                    <select name="event_finish" id="event_finish" class="form-control timeScale">
                      <option disabled>選択してください</option>
                      @for ($start = 0*2; $start <=23*2; $start++) <option
                        value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if(($fix->
                        leave_time==date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))))
                        selected
                        @endif>
                        {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}</option>
                        @endfor
                    </select>
                  </div>
                </li>
              </ul>
              <p class="txtRed">※入力した時間より前に会場に入ることはできません。</p>
            </li>
        </td>

        </li>
        </ul>
        <a name="a-selectTime1" class="error-r"></a>
        </td>
      </tr>

      <tr>
        <th>室内飲食 <span class="txtRed c-block">＊</span></th>
        <td>
          <input type="radio" id="cataring1" class="radio-input" name="cataring" value="1">
          <label for="cataring1"><span>あり</span></label>
          (
          <input type="radio" id="cataring_prepare1" class="radio-input" name="cataring_prepare" value="1">
          <label for="cataring_prepare1"><span>手配済み</span></label>
          /
          <input type="radio" id="cataring_prepare2" class="radio-input" name="cataring_prepare" value="0">
          <label for="cataring_prepare2"><span>検討中</span></label>
          )
          <br>
          <input type="radio" id="cataring2" class="radio-input" name="cataring" value="0" checked>
          <label for="cataring2"><span>なし</span></label>
          <a name="a-cataring01" class="error-r"></a>
          <p><span class="txt-indent">※ケータリングは弊社にてご予算に合ったものをご提供可能です。 お気軽に問い合わせ下さい。</span></p>
        </td>
      </tr>

      <tr>
        <th>有料備品</th>
        <td class="spec-space">
          <ul>
            @foreach ($venue->getEquipments() as $e_key=>$eqpt)
            <li class="form-cell2">
              <p class="text6">{{$eqpt->item}}</p>
              @if (empty(json_decode($fix->items_results)[1]))
              <p>{{ Form::text('equipment_breakdown'.$e_key, "",['class'=>'text4 mL0'] ) }}個</p>
              @else
              @foreach (json_decode($fix->items_results)[1] as $b_equ)
              @if ($b_equ[0]==$eqpt->item)
              <p>{{ Form::text('equipment_breakdown'.$e_key, $b_equ[2],['class'=>'text4 mL0'] ) }}個</p>
              @break
              @elseif($loop->last)
              <p>{{ Form::text('equipment_breakdown'.$e_key, "",['class'=>'text4 mL0'] ) }}個</p>
              @endif
              @endforeach
              @endif
            </li>
            @endforeach
          </ul>
        </td>
      </tr>

      <tr>
        <th>有料サービス</th>
        <td class="spec-space">
          <ul>
            @foreach ($venue->getServices() as $s_key=>$serv)
            <li class="form-cell2">
              @if (empty(json_decode($fix->items_results)[2]))
              <label>
                {{ Form::hidden('services_breakdown'.$s_key, 0 ) }}
                <input type="checkbox" id="" name="{{'services_breakdown'.$s_key}}" value="1" class="checkbox-input">
                <span class="checkbox-parts">{{$serv->item}} {{$serv->price}}円</span>
              </label>
              @else
              @foreach (json_decode($fix->items_results)[2] as $b_ser)
              @if ($serv->item==$b_ser[0])
              <label>
                {{ Form::hidden('services_breakdown'.$s_key, 0 ) }}
                <input type="checkbox" id="" name="{{'services_breakdown'.$s_key}}" value="1" class="checkbox-input"
                  checked>
                <span class="checkbox-parts">{{$serv->item}} {{$serv->price}}円</span>
              </label>
              @break
              @elseif($loop->last)
              <label>
                {{ Form::hidden('services_breakdown'.$s_key, 0 ) }}
                <input type="checkbox" id="" name="{{'services_breakdown'.$s_key}}" value="1" class="checkbox-input">
                <span class="checkbox-parts">{{$serv->item}} {{$serv->price}}円</span>
              </label>
              @endif
              @endforeach
              @endif
            </li>
            @endforeach
          </ul>
        </td>
      </tr>


      @if ($venue->getLayouts()!=0)
      <tr>
        <th>レイアウト変更</th>
        <td class="spec-space">
          <div class="m-b10">
            <p>レイアウト準備</p>
            <div class="selectTime">
              @if (!empty($fix->layout_prepare))
              {{Form::radio('layout_prepare', 1,true, ['id' => 'layout_prepare', 'class' => 'radio-input'])}}
              {{Form::label('layout_prepare','あり')}}
              {{Form::radio('layout_prepare', 0, false, ['id' => 'no_layout_prepare', 'class' => 'radio-input'])}}
              {{Form::label('no_layout_prepare', 'なし')}}
              @else
              {{Form::radio('layout_prepare', 1,false, ['id' => 'layout_prepare', 'class' => 'radio-input'])}}
              {{Form::label('layout_prepare','あり')}}
              {{Form::radio('layout_prepare', 0, true, ['id' => 'no_layout_prepare', 'class' => 'radio-input'])}}
              {{Form::label('no_layout_prepare', 'なし')}}
              @endif

            </div>
            <a name="a-selectTime1" class="error-r"></a>
          </div>
          @if ($venue->getLayouts()[1])
          <div class="m-b10">
            <p>レイアウト片付</p>
            <div class="selectTime">
              @if (!empty($fix->layout_clean))
              {{Form::radio('layout_clean', 1, true, ['id' => 'layout_clean', 'class' => 'radio-input'])}}
              {{Form::label('layout_clean','あり')}}
              {{Form::radio('layout_clean', 0, false, ['id' => 'no_layout_clean', 'class' => 'radio-input'])}}
              {{Form::label('no_layout_clean', 'なし')}}
              @else
              {{Form::radio('layout_clean', 1, false, ['id' => 'layout_clean', 'class' => 'radio-input'])}}
              {{Form::label('layout_clean','あり')}}
              {{Form::radio('layout_clean', 0, true, ['id' => 'no_layout_clean', 'class' => 'radio-input'])}}
              {{Form::label('no_layout_clean', 'なし')}}
              @endif
            </div>
            <a name="a-selectTime1" class="error-r"></a>
          </div>
          @endif
        </td>
      </tr>
      @endif

      @if ($venue->getLuggage()!=0)
      <tr>
        <th>荷物預り/返送</th>
        <td class="spec-space">
          <div class="m-b10">
            <p>【事前に預かる荷物】</p>
            <div class="selectTime">
              <p class="baggage_bn">目安</p>
              {{ Form::text('luggage_count', $fix->luggage_count,['class'=>'text6 baggage_bn', 'style'=>'width:20%;'] ) }}
              <p class="baggage_bn">個</p>
            </div>
          </div>
          <div class="m-b10">
            <p>事前荷物の到着日</p>
            <div class="selectTime">
              {{ Form::date('luggage_arrive', $fix->luggage_arrive,['class'=>'text6'] ) }}
              <p>午前指定</p>
            </div>
          </div>
          <a name="a-baggagedate" class="error-r"></a>
          <div class="m-b10">
            <p>利用日3日前～前日（平日のみ）を到着日に指定下さい</p>
            <p><span class="txt-indent">※送付詳細 / 伝票記載方法は該当会場詳細ページ「備品 / サービス」タブの「荷物預り / 返送
                PDF」をご確認下さい。</span>
              <span class="txt-indent">※発送伝票（元払）/ 返送伝票（着払）は各自ご用意下さい。</span>
              <span class="txt-indent">※貴重品等のお預りはできかねます。</span>
              <span class="txt-indent">※事前荷物は入室時間迄に弊社が会場搬入します。</span></p>
          </div>
          <div class="m-b10">
            <p>【事後返送する荷物】</p>
            <div class="selectTime">
              <p class="baggage_an">目安</p>
              {{ Form::text('luggage_return', $fix->luggage_return,['class'=>'text6 baggage_an', 'style'=>'width: 20%;'] ) }}
              <p class="baggage_an">個</p>
            </div>
          </div>
          <a name="a-baggagedate" class="error-r"></a>
          <div class="m-b10">
            <p>6個以上は要相談。まずは事前にお問合わせ下さい。<br>
              [荷物外寸合計(縦・横・奥行)120cm以下/個]</p>
            <p>
              <span class="txt-indent">
                ※返送に関して、発送伝票（元払）、返送伝票（着払）は会場内に用意しているものを必ず使用して下さい。
              </span>
            </p>
          </div>
        </td>
      </tr>
      @endif
      <tr>
        <th>備考</th>
        <td>
          {{ Form::textarea('remark', $fix->remark,['cols'=>'30','rows'=>'10'] ) }}
          <p>
            <span class="txt-indent">
              ※入力に際し旧漢字・機種依存文字などはご使用になれません。
            </span>
          </p>
          <a name="a-nam" class="error-r"></a>
        </td>
      </tr>
    </table>
  </div>
  <style>
    .btn-wrapper {
      display: flex;
      justify-content: center;
      margin-bottom: 80px;
    }
  </style>
  <ul class="btn-wrapper">
    <li>
      {{Form::submit('料金を確認する',['class'=>'confirm-btn','style'=>'width:100%;'])}}
    </li>
  </ul>
  {{Form::hidden('venue_id',$fix->venue_id)}}
  {{Form::hidden('date',$fix->date)}}
  {{Form::hidden('enter_time',$fix->enter_time)}}
  {{Form::hidden('leave_time',$fix->leave_time)}}
  {{Form::hidden('select_id',$select_id)}}
  {{Form::close()}}

</section>

<div class="top contents"><a href="#top"><img src="https://osaka-conference.com/img/pagetop.png" alt="上に戻る"></a>
</div>

@endsection