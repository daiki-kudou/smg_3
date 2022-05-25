@extends('layouts.reservation.app')
@section('content')

@include('layouts.user.overlay')

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
  <div class="section-wrap">
    <h2>予約</h2>
    {{ Form::open(['url' => '/user/reservations/check', 'method'=>'POST', 'id'=>'user_reservation_create']) }}
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
                <span>入室時間より以前に入室はできません。</span>
              </p>
              <p class="checkbox-txt">
                {{Form::checkbox('q1', 1, true, ['class'=>'custom-control-input','id'=>'checkbox', 'disabled'])}}
                <input type="hidden" name="q1" value="1" />
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
          <th>当日連絡できる担当者名 <span class="txtRed c-block">＊</span></th>
          <td>
            {{ Form::text('in_charge', old('in_charge'),['class'=>'form-input text2', 'placeholder'=>'入力してください'] ) }}
            <br class="spOnlyunder">
            <p class="is-error-in_charge" style="color: red"></p>
          </td>
        </tr>
        <tr>
          <th>当日連絡できる担当者携帯 <span class="txtRed c-block">＊</span></th>
          <td>
            {{ Form::text('tel', old('tel'),['class'=>'form-input text2', 'placeholder'=>'入力してください'] ) }}
            <br class="spOnlyunder">
            <p class="is-error-tel" style="color: red"></p>
            <p>
              <span class="txt-indent">※必ず当日連絡が付く担当者の連絡番号を記載下さい。</span>
              <span class="txt-indent">※半角数字、ハイフンなしで入力下さい。</span>
            </p>
          </td>
        </tr>
        @if ($venue->frame_prices->count()!=0&&$venue->time_prices->count()!=0)
        @if (Carbon\Carbon::parse($request->enter_time)->diffInMinutes(Carbon\Carbon::parse($request->leave_time))>=180)
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
              <li><a target="_blank" rel="noopener noreferrer"
                  href="https://system.osaka-conference.com/characteristic/high-grade/"><i
                    class="fas fa-question-circle form-icon"></i>音響ハイグレードとは？</a></li>
            </ul>
            <a name="a-selectTime1" class="error-r"></a>
          </td>
        </tr>
        @else
        {{Form::hidden('price_system',1)}}
        @endif
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
                  {{Form::label('board_flag','あり')}}
                  {{ Form::radio('board_flag', 0, true, ['class'=>'radio-input', 'id'=>'no_board_flag']) }}
                  {{Form::label('no_board_flag','なし')}}
                </div>
              </li>
              <li>
                <a target="_blank" rel="noopener noreferrer" href="https://system.osaka-conference.com/welcomboard/">
                  <i class="fas fa-external-link-alt form-icon"></i>
                  案内板サンプルはこちら
                </a>
              </li>
              <li class="cell-margin board_info">
                <div class="m-b10">
                  <p>
                    <span class="txtRed c-block">＊</span>イベント名称1行目
                  </p>
                  <div class="form-counter">
                    {{ Form::text('event_name1','',['class'=>'form-input text2', 'placeholder'=>'入力してください',
                    'id'=>'eventname1Count'] ) }}
                    <span class="count_num1"></span>
                  </div>
                  <p class="is-error-event_name1" style="color: red"></p>
                </div>
                <div class="m-b10">
                  <p>イベント名称2行目</p>
                  <div class="form-counter">
                    {{ Form::text('event_name2','',['class'=>'form-input text2', 'placeholder'=>'入力してください',
                    'id'=>'eventname2Count'] ) }}
                    <span class="count_num2"></span>
                  </div>
                  <p class="is-error-event_name2" style="color: red"></p>
                </div>
                <div class="m-b10">
                  <p>主催者名</p>
                  <div class="form-counter">
                    {{ Form::text('event_owner','',['class'=>'form-input text2', 'placeholder'=>'入力してください',
                    'id'=>'eventownerCount'] ) }}
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
                        {!!ReservationHelper::timeOptionsWithRequestAndLimit($request->enter_time,$request->enter_time,$request->leave_time)!!}
                      </select>
                    </div>
                  </li>
                  <li>
                    <p>イベント終了時間</p>
                    <div class="selectWrap">
                      <select name="event_finish" id="event_finish" class="timeScale">
                        <option disabled>選択してください</option>
                        {!!ReservationHelper::timeOptionsWithRequestAndLimit($request->leave_time,$request->enter_time,$request->leave_time)!!}
                      </select>
                    </div>
                  </li>
                </ul>
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
            {{Form::radio('eat_in_prepare', 1, true
            ,['class'=>old('eat_in')?((int)old('eat_in')===1?'radio-input':''):'',
            'id'=>'eat_in_prepare',old('eat_in')?('test'):'disabled'])}}
            {{Form::label('eat_in_prepare',"手配済み",['style'=>'margin-right: 20px;'])}}
            /
            {{Form::radio('eat_in_prepare', 2, false
            ,['class'=>old('eat_in')?((int)old('eat_in')===1?'radio-input':''):'',
            'id'=>'eat_in_consider',old('eat_in')?('test'):'disabled'])}}
            {{Form::label('eat_in_consider',"検討中",['style'=>'margin-right: 20px;'])}}
            )
            <br>
            {{Form::radio('eat_in', 0, old('eat_in')==0?true:false , ['id' => 'no_eat_in','class'=>'radio-input'])}}
            {{Form::label('no_eat_in',"なし")}}
            <a name="a-cataring01" class="error-r"></a>
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
                <p class="text6"><span class="f-wb m-r10">{{$eqpt->item}}</span>{{$eqpt->price}}円<span
                    class="annotation">(税抜)</span></p>
                <p class="m-l20">
                  {{ Form::number('equipment_breakdown'.$e_key, '',['class'=>'text4 mL0
                  number_validation','autocomplete="off"'] ) }}個
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
              <li>
                <p>{{$serv->item}} {{$serv->price}}円<span class="annotation">(税抜)</span></p>
                <div class="selectTime">
                  {{Form::radio('services_breakdown'.$s_key, 1, old('services_breakdown'.$s_key)==1?true:false, ['id' =>
                  'services_breakdown_on'.$s_key, 'class' => 'radio-input'])}}
                  {{Form::label('services_breakdown_on'.$s_key,'あり')}}
                  {{Form::radio('services_breakdown'.$s_key, 0, old('services_breakdown'.$s_key)==0?true:false, ['id' =>
                  'services_breakdown_off'.$s_key, 'class' => 'radio-input'])}}
                  {{Form::label('services_breakdown_off'.$s_key, 'なし')}}
                </div>
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
          <th>荷物預かり<span class="txtRed c-block">＊</span></th>
          <td class="spec-space">
            <div class="selectTime m-b10">
              <input class="radio-input" id="luggage_flag" name="luggage_flag" type="radio" value="1">
              <label for="luggage_flag">あり</label>
              <input class="radio-input" id="no_luggage_flag" name="luggage_flag" type="radio" value="0" checked>
              <label for="no_luggage_flag">なし</label>
            </div>
            <div class="luggage-exp">
              <p>
              【事前・事後】預かりの荷物について<br>
                事前預かり/事後返送ともに<span class="f-s20">5個</span>まで。<br>
                6個以上は要相談。その際は事前に必ずお問い合わせ下さい。<br>
                荷物外寸合計(縦・横・奥行)120cm以下/個
              </p>
            </div>
            <ul class="luggage_info">
              <li class="m-b10">
                <div class="luggage-cell">
                  <p>事前に預かる荷物<br>(目安)</p>
                  {{ Form::number('luggage_count', '',['class'=>'text6 ', 'style'=>'width:20%;','autocomplete="off"','min'=>0] )
                  }}
                  <p class="">個</p>
                </div>
                <p class="is-error-luggage_count" style="color: red"></p>
              </li>
              <li class="m-b10">
                <div class="luggage-cell">
                  <p>事前荷物の到着日(午前指定)</p>
                  {{ Form::text('luggage_arrive', '',['class'=>'','id'=>'datepicker2','autocomplete="off"'] ) }}
                </div>
              </li>
              <li class="m-b30">
                <p><span class="txt-indent">※利用日3日前～前日（平日のみ）を到着日に指定下さい</span></p>
                <p><span class="txt-indent">※送付詳細 / 伝票記載方法は該当会場詳細ページ「備品 / サービス」タブの「荷物預り / 返送
                    PDF」をご確認下さい。</span>
                  <span class="txt-indent">※発送伝票（元払）/ 返送伝票（着払）は各自ご用意下さい。</span>
                  <span class="txt-indent">※貴重品等のお預りはできかねます。</span>
                  <span class="txt-indent">※事前荷物は入室時間迄に弊社が会場搬入します。</span>
                </p>
              </li>
              <li class="m-b10">
                <div class="luggage-cell">
                  <p>事後返送する荷物</p>
                  {{ Form::number('luggage_return', '',['class'=>'text6 ', 'style'=>'width: 20%;','autocomplete="off"','min'=>0]
                  ) }}
                  <p class="">個</p>
                </div>
              </li>
              <p class="is-error-luggage_return" style="color: red"></p>
              <li class="m-b30">
                  <span class="txt-indent">
                  ※返送時の「発送伝票（元払）/返送伝票（着払）」は会場内に用意しているものを必ず使用して下さい。
                  </span>
                </p>
              </li>
            </ul>
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
    <div class="btn-center">
      <p>
        {{Form::hidden('venue_id',$request->venue_id)}}
        {{Form::hidden('date',$request->date)}}
        {{Form::hidden('enter_time',$request->enter_time)}}
        {{Form::hidden('leave_time',$request->leave_time)}}
        {{Form::hidden('cost',$venue->cost??0)}}
        {{Form::submit('入力内容を確認する',['class'=>'confirm-btn','style'=>'width:100%;'])}}
      </p>
    </div>
    {{Form::close()}}
  </div>

</section>

<div class="top contents">
  <a href="#top">
    <img src="https://system.osaka-conference.com/img/pagetop.png" alt="上に戻る">
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
    
    var s_board_flag = Number($('input[name=board_flag]:checked').val());
    if (s_board_flag === 0) {
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

  // 荷物預かりのラジオボタン選択の表示、非表示
  $(function() {
    var no_luggage_flag = $('#no_luggage_flag').val();
    if (no_luggage_flag == 0) {
          $(".luggage_info").addClass("d-none");
        } else {
          $(".luggage_info").removeClass("d-none");
         }
    });

    $(function() {
     $("input[name='luggage_flag']").change(function() {
       var no_luggage_flag = $('#no_luggage_flag').prop('checked');
        if (no_luggage_flag) {
          $(".luggage_info").addClass("d-none");
        } else {
          $(".luggage_info").removeClass("d-none");
         }
      });
    });




</script>
<script type="text/javascript">
  $(function () {
        var holidays = ['20210722', '20210723', '20210808', '20210809', '20210920', '20210923', '20211103', '20211123', '20220101', '20220110', '20220211', '20220223', '20220321', '20220429', '20220503', '20220504', '20220505', '20220718', '20220811', '20220919', '20220923', '20221010', '20221103', '20221123', '20230101', '20230102', '20230109', '20230211', '20230223', '20230321', '20230429', '20230503', '20230504', '20230505', '20230717', '20230811', '20230918', '20230923', '20231009', '20231103', '20231123', '20240101', '20240108', '20240211', '20240212', '20240223', '20240320', '20240429', '20240503', '20240504', '20240505', '20240506', '20240715', '20240811', '20240812', '20240916', '20240922', '20240923', '20241014', '20241103', '20241104', '20241123', '20250101', '20250113', '20250211', '20250223', '20250224', '20250320', '20250429', '20250503', '20250504', '20250505', '20250506', '20250721', '20250811', '20250915', '20250923', '20251013', '20251103', '20251123', '20251124', '20260101', '20260112', '20260211', '20260223', '20260320', '20260429', '20260503', '20260504', '20260505', '20260506', '20260720', '20260811', '20260921', '20260922', '20260923', '20261012', '20261103', '20261123', '20270101', '20270111', '20270211', '20270223', '20270321', '20270322', '20270429', '20270503', '20270504', '20270505', '20270719', '20270811', '20270920', '20270923', '20271011', '20271103', '20271123', '20280101', '20280110', '20280211', '20280223', '20280320', '20280429', '20280503', '20280504', '20280505', '20280717', '20280811', '20280918', '20280922', '20281009', '20281103', '20281123', '20290101', '20290108', '20290211', '20290212', '20290223', '20290320', '20290429', '20290430', '20290503', '20290504', '20290505', '20290716', '20290811', '20290917', '20290923', '20290924', '20291008', '20291103', '20291123', '20300101', '20300114', '20300211', '20300223', '20300320', '20300429', '20300503', '20300504', '20300505', '20300506', '20300715', '20300811', '20300812', '20300916', '20300923', '20301014', '20301103', '20301104', '20301123', '20310101', '20310113', '20310211', '20310223', '20310224', '20310321', '20310429', '20310503', '20310504', '20310505', '20310506', '20310721', '20310811', '20310915', '20310923', '20311013', '20311103', '20311123', '20311124', '20320101', '20320112', '20320211', '20320223', '20320320', '20320429', '20320503', '20320504', '20320505', '20320719', '20320811', '20320920', '20320921', '20320922', '20321011', '20321103', '20321123', '20330101', '20330110', '20330211', '20330223', '20330320', '20330321', '20330429', '20330503', '20330504', '20330505', '20330718', '20330811', '20330919', '20330923', '20331010', '20331103', '20331123', '20340101', '20340102', '20340109', '20340211', '20340223', '20340320', '20340429', '20340503', '20340504', '20340505', '20340717', '20340811', '20340918', '20340923', '20341009', '20341103', '20341123', '20350101', '20350108', '20350211', '20350212', '20350223', '20350321', '20350429', '20350430', '20350503', '20350504', '20350505', '20350716', '20350811', '20350917', '20350923', '20350924', '20351008', '20351103', '20351123', '20360101', '20360114', '20360211', '20360223', '20360320', '20360429', '20360503', '20360504', '20360505', '20360506', '20360721', '20360811', '20360915', '20360922', '20361013', '20361103', '20361123', '20361124',];
        var target_day=$('input[name="date"]').val();
        var today = new Date();
        var dd = today.getDate();
        var dt = new Date(target_day);
        dt.setDate(dt.getDate() - 1);
        var max_date = dt.getFullYear() + '-' + (dt.getMonth() + 1) + '-' + dt.getDate();
        $("#datepicker2").datepicker({
          dateFormat: 'yy-mm-dd',
            showOn: "both",
            buttonImage: "https://system.osaka-conference.com/img/icon_calender.png",
            buttonImageOnly: true,
            minDate: 0,
            maxDate: max_date,
            beforeShow: function (input, inst, date) { 
              // カレンダーを必ず下側へ表示させるための表示位置計算function
                var top = $(this).offset().top + $(this).outerHeight();
                var left = $(this).offset().left;
                setTimeout(function () {
                    inst.dpDiv.css({
                        'top': top,
                        'left': left
                    });
                }, 10) // 10msec
            },
            beforeShowDay: function (date) {
            var ymd = date.getFullYear() + ('0' + (date.getMonth() + 1)).slice(-2) + ('0' + date.getDate()).slice(-2);
            if (holidays.indexOf(ymd) != -1) {
              // 祝日
              return [false, 'ui-state-disabled'];
            } else if (date.getDay() == 0) {
              // 日曜日
              return [false, 'ui-state-disabled'];
            } else if (date.getDay() == 6) {
              // 土曜日
              return [false, 'ui-state-disabled'];
            } else {
              // 平日
              return [true, ''];
            }
          },


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