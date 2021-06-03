@extends('layouts.reservation.app')
@section('content')

<script src="{{ asset('/js/user_reservation/validation.js') }}"></script>
<script src="{{ asset('/js/lettercounter.js') }}"></script>


<div class="contents">
  <div class="pagetop-text">
    <h1 class="page-title oddcolor"><span>会場予約 入力画面</span></h1>
    <p>下記フォームに必要事項を入力してください。(＊は必須項目です)</p>
    <p class="txtRed">複数日程を希望の場合は予約日毎に予約入力してください。</p>
  </div>
</div>
<section class="contents">
  <h2>予約1</h2>

  {{ Form::open(['url' => 'user/reservations/check', 'method'=>'POST', 'id'=>'user_reservation_create']) }}
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
          <div class="borderAttention">
            <p>
              <span>入室時間より以前に入室はできません。<br>確認の上、チェックボックスをクリックしてください。</span></p>
            <p class="checkbox-txt">
              <span class="txtRed">＊</span>
              {{Form::checkbox('q1', 1, false, ['class'=>'custom-control-input','id'=>'checkbox'])}}
              <label for="checkbox">確認しました</label>
              <p class="is-error-q1" style="color: red"></p>
            </p>
          </div>
        </td>
      </tr>
      <tr>
        <th>利用会場</th>
        <td>
          {{ReservationHelper::getVenueForUser($request->venue_id)}}
        </td>
      </tr>
      <tr>
        <th>当日の担当者 <span class="txtRed c-block">＊</span></th>
        <td>
          {{ Form::text('in_charge', old('in_charge'),['class'=>'form-input text2', 'placeholder'=>'入力してください'] ) }}
          <br class="spOnlyunder">
          <p class="is-error-in_charge" style="color: red"></p>
        </td>
      </tr>
      <tr>
        <th>当日の担当者連絡先 <span class="txtRed c-block">＊</span></th>
        <td>
          {{ Form::text('tel', old('tel'),['class'=>'form-input text2', 'placeholder'=>'入力してください'] ) }}
          <br class="spOnlyunder">
          <p class="is-error-tel" style="color: red"></p>
        </td>
      </tr>

      @if ($venue->frame_prices->count()!=0&&$venue->time_prices->count()!=0)
      <tr>
        <th>音響ハイグレード<span class="txtRed c-block">＊</span></th>
        <td class="">
          <ul>
            <li>
              <div class="selectTime">
                {{ Form::radio('price_system', 2, false, ['class'=>'radio-input','id'=>'price_system_radio2']) }}
                {{Form::label('price_system_radio2','する')}}
                {{ Form::radio('price_system', 1, true, ['class'=>'radio-input', 'id'=>'price_system_radio1']) }}
                {{Form::label('price_system_radio1','しない')}}
              </div>
            </li>
            <li><a target="_blank" rel="noopener noreferrer" href="https://osaka-conference.com/characteristic/high-grade/"><i class="fas fa-question-circle form-icon"></i>音響ハイグレードとは？</a></li>
          </ul>
          <a name="a-selectTime1" class="error-r"></a>
        </td>
      </tr>
      @else
      @if ($venue->frame_prices->count()!=0)
      {{Form::hidden('price_system',1)}}
      @else
      {{Form::hidden('price_system',2)}}
      @endif
      @endif


      <tr>
        <th>案内板の作成<span class="txtRed c-block">＊</span></th>
        <td class="">
          <ul>
            <li>
              <div class="selectTime">
                {{ Form::radio('board_flag', 1, false, ['class'=>'radio-input','id'=>'board_flag']) }}
                {{Form::label('board_flag','する')}}
                {{ Form::radio('board_flag', 0, true, ['class'=>'radio-input', 'id'=>'no_board_flag']) }}
                {{Form::label('no_board_flag','しない')}}
              </div>
            </li>
            <li><a target="_blank"  rel="noopener noreferrer" href="https://osaka-conference.com/welcomboard/"><i class="fas fa-external-link-alt form-icon"></i>案内板サンプルはこちら</a></li>
            <li class="cell-margin board_info">
              <div class="m-b10">
                <p><span class="txtRed c-block">＊</span>イベント名称1行目</p>
                <div class="form-counter">
                  {{ Form::text('event_name1','',['class'=>'form-input text2', 'placeholder'=>'入力してください', 'id'=>'eventname1Count'] ) }}
                  <span class="count_num1"></span>
                </div>
                <p class="is-error-event_name1" style="color: red"></p>
              </div>
              <div class="m-b10">
                <p>イベント名称2行目</p>
                <div class="form-counter">
                  {{ Form::text('event_name2','',['class'=>'form-input text2', 'placeholder'=>'入力してください', 'id'=>'eventname2Count'] ) }}
                  <span class="count_num2"></span>
                </div>
                <p class="is-error-event_name2" style="color: red"></p>
              </div>
              <div class="m-b10">
                <p>主催者名</p>
                <div class="form-counter">
                  {{ Form::text('event_owner','',['class'=>'form-input text2', 'placeholder'=>'入力してください', 'id'=>'eventownerCount'] ) }}
                  <span class="count_num3"></span>
                </div>
                <p class="is-error-event_owner" style="color: red"></p>
              </div>
              <ul class="form-cell">
                <li>
                  <p>イベント開始時間</p>
                  <div class="selectWrap">
                    <select name="event_start" id="event_start" class="timeScale">
                      <option disabled>選択してください</option>
                      @for ($start = 8*2; $start <=23*2; $start++) <option
                        value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if(($request->
                        enter_time==date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))))
                        selected
                        @elseif($request->enter_time>date("H:i:s", strtotime("00:00 +". $start * 30 ." minute")))
                        disabled
                        @elseif($request->leave_time<date("H:i:s", strtotime("00:00 +". $start * 30 ." minute")))
                          disabled @endif>
                          {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}}</option>
                          @endfor
                    </select>
                  </div>
                </li>
                <li>
                  <p>イベント終了時間</p>
                  <div class="selectWrap">
                    <select name="event_finish" id="event_finish" class="timeScale">
                      <option disabled>選択してください</option>
                      @for ($start = 8*2; $start <=23*2; $start++) <option
                        value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}" @if(($request->
                        leave_time==date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))))
                        selected
                        @elseif($request->enter_time>date("H:i:s", strtotime("00:00 +". $start * 30 ." minute")))
                        disabled
                        @elseif($request->leave_time<date("H:i:s", strtotime("00:00 +". $start * 30 ." minute")))
                          disabled @endif>
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

      @if ($venue->eat_in_flag!=0)
      <tr>
        <th>室内飲食 <span class="txtRed c-block">＊</span></th>
        <td>
          {{Form::radio('eat_in', 1, old('eat_in')==1?true:false , ['id' => 'eat_in','class'=>'radio-input'])}}
          {{Form::label('eat_in',"あり")}}
          (
          {{Form::radio('eat_in_prepare', 1, false , ['class'=>'radio-input','id' => 'eat_in_prepare',old('eat_in')==0?'disabled':''])}}
          {{Form::label('eat_in_prepare',"手配済み",['style'=>'margin-right: 20px;'])}}
          /
          {{Form::radio('eat_in_prepare', 2, false , ['class'=>'radio-input','id' => 'eat_in_consider', old('eat_in')==0?'disabled':''])}}
          {{Form::label('eat_in_consider',"検討中",['style'=>'margin-right: 20px;'])}}
          )
          <br>
          {{Form::radio('eat_in', 0, old('eat_in')==0?true:false , ['id' => 'no_eat_in','class'=>'radio-input'])}}
          {{Form::label('no_eat_in',"なし")}}
          <a name="a-cataring01" class="error-r"></a>
          <p><span class="txt-indent">※ケータリングは弊社にてご予算に合ったものをご提供可能です。 お気軽に問い合わせ下さい。</span></p>
        </td>
      </tr>
      @endif


      @if ($venue->getEquipments()->count()!=0)
      <tr>
        <th>有料備品</th>
        <td class="spec-space">
          <ul>
            @foreach ($venue->getEquipments() as $e_key=>$eqpt)
            <li class="form-cell2">
              <p class="text6">{{$eqpt->item}} {{$eqpt->price}}円<span class="annotation">(税抜)</span></p>
              <p>
                {{ Form::text('equipment_breakdown'.$e_key, '',['class'=>'text4 mL0 number_validation'] ) }}個
              </p>
            </li>
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
            <li class="form-cell2">
              <label>
                {{ Form::hidden('services_breakdown'.$s_key, 0 ) }}
                <input type="checkbox" id="" name="{{'services_breakdown'.$s_key}}" value="1" class="checkbox-input">
                <span class="checkbox-parts">{{$serv->item}} {{$serv->price}}円<span class="annotation">(税抜)</span></span>
              </label>
            </li>
            @endforeach
          </ul>
        </td>
      </tr>
      @endif


      @if ($venue->getLayouts()!=0)
      <tr>
        @if ($venue->getLayouts()[0])
        <th>レイアウト変更</th>
        <td class="spec-space">
          <div class="m-b10">
            <p>レイアウト準備</p>
            <div class="selectTime">
              {{Form::radio('layout_prepare', 1, false, ['id' => 'layout_prepare', 'class' => 'radio-input'])}}
              {{Form::label('layout_prepare','あり')}}
              {{Form::radio('layout_prepare', 0, true, ['id' => 'no_layout_prepare', 'class' => 'radio-input'])}}
              {{Form::label('no_layout_prepare', 'なし')}}
            </div>
            <a name="a-selectTime1" class="error-r"></a>
          </div>
          @endif
          @if ($venue->getLayouts()[1])
          <div class="m-b10">
            <p>レイアウト片付</p>
            <div class="selectTime">
              {{Form::radio('layout_clean', 1, false, ['id' => 'layout_clean', 'class' => 'radio-input'])}}
              {{Form::label('layout_clean','あり')}}
              {{Form::radio('layout_clean', 0, true, ['id' => 'no_layout_clean', 'class' => 'radio-input'])}}
              {{Form::label('no_layout_clean', 'なし')}}
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
            <p class="m-b10">【事前に預かる荷物】</p>
            <div class="luggage-cell">
              <p class="">目安</p>
              {{ Form::text('luggage_count', '',['class'=>'text6 ', 'style'=>'width:20%;'] ) }}
              <p class="">個</p>
            </div>
            <p class="is-error-luggage_count" style="color: red"></p>
          </div>
          <div class="m-b10">
            <p>事前荷物の到着日(午前指定)</p>
            <div class="luggage-cell">
              {{ Form::text('luggage_arrive', '',['class'=>'text6','id'=>'datepicker2'] ) }}
            </div>
          </div>

          <div class="m-b30">
            <p>利用日3日前～前日（平日のみ）を到着日に指定下さい</p>
            <p><span class="txt-indent">※送付詳細 / 伝票記載方法は該当会場詳細ページ「備品 / サービス」タブの「荷物預り / 返送
                PDF」をご確認下さい。</span>
              <span class="txt-indent">※発送伝票（元払）/ 返送伝票（着払）は各自ご用意下さい。</span>
              <span class="txt-indent">※貴重品等のお預りはできかねます。</span>
              <span class="txt-indent">※事前荷物は入室時間迄に弊社が会場搬入します。</span></p>
          </div>
          <div class="m-b10">
            <p>【事後返送する荷物】</p>
            <div class="luggage-cell">
              <p class="">目安</p>
              {{ Form::text('luggage_return', '',['class'=>'text6 ', 'style'=>'width: 20%;'] ) }}
              <p class="">個</p>
            </div>
          </div>
          <p class="is-error-luggage_return" style="color: red"></p>

          <div class="m-b30">
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
          {{ Form::textarea('remark', '',['cols'=>'30','rows'=>'10'] ) }}
          <p>
            <span class="txt-indent">
              ※入力に際し旧漢字・機種依存文字などはご使用になれません。
            </span>
          </p>
        </td>
      </tr>
    </table>
  </div>
  <ul class="btn-wrapper">
    <li>
      <a class="link-btn" href="{{url('/')}}">会場・日程選択に戻る</a>
    </li>
    <li>
      {{Form::submit('料金を確認する',['class'=>'confirm-btn','style'=>'width:100%;'])}}
    </li>
  </ul>
  {{Form::hidden('venue_id',$request->venue_id)}}
  {{Form::hidden('date',$request->date)}}
  {{Form::hidden('enter_time',$request->enter_time)}}
  {{Form::hidden('leave_time',$request->leave_time)}}
  {{Form::close()}}

</section>

<div class="top contents">
  <a href="#top">
    <img src="https://osaka-conference.com/img/pagetop.png" alt="上に戻る">
  </a>
</div>

<script>
  $(function() {
    $(document).on("click", "input:radio[name='eat_in']", function() {
      var radioTarget = $('input:radio[name="eat_in"]:checked').val();
      if (radioTarget == 1) {
        $('input:radio[name="eat_in_prepare"]').prop('disabled', false);
        $('input:radio[name="eat_in_prepare"]').addClass("radio-input");
      } else {
        $('input:radio[name="eat_in_prepare"]').prop('disabled', true);
        $('input:radio[name="eat_in_prepare"]').removeClass("radio-input");
        $('input:radio[name="eat_in_prepare"]').val("");
      }
    })
  })

  // 案内板のラジオボタン選択の表示、非表示
  $(function() {
    var no_board_flag = $('#no_board_flag').val();
    if (no_board_flag == 0) {
          $(".board_info").addClass("d-none");
        } else {
          $(".board_info").removeClass("d-none");
         }
    });

    $(function() {
     $("input[name='board_flag']").change(function() {
       var no_board_flag = $('#no_board_flag').prop('checked');
        if (no_board_flag) {
          $(".board_info").addClass("d-none");
        } else {
          $(".board_info").removeClass("d-none");
         }
      });
    });
</script>
<script type="text/javascript">
  $(function () {
        var today = new Date();
        var dd = today.getDate();
        $("#datepicker2").datepicker({
            showOn: "both",
            buttonImage: "https://osaka-conference.com/img/icon_calender.png",
            buttonImageOnly: true,
            minDate: "+3",
            maxDate: "+3M -" + dd,
            beforeShow: function (input, inst) { // カレンダーを必ず下側へ表示させるための表示位置計算function
                var top = $(this).offset().top + $(this).outerHeight();
                var left = $(this).offset().left;
                setTimeout(function () {
                    inst.dpDiv.css({
                        'top': top,
                        'left': left
                    });
                }, 10) // 10msec
            }
        });
        $("ul.tabBtn li").mouseover(function () {
            if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator
                    .userAgent)) {
                $(this).click();
            }
        });
        $(".hasDatepicker, .ui-datepicker, .ui-datepicker-trigger").click(function (event) {
            event.stopPropagation();
        });
        $(".contents").bind("click touchstart, touchmove", function (event) {
            $('.ui-datepicker').hide();
            $('.hasDatepicker').blur();
        });
    });
</script>

@endsection