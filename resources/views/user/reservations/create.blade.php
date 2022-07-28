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
    {{ Form::open(['url' => '/user/reservations/check', 'method'=>'POST', 'id'=>'user_reservation_create','autocomplete'=>'off',]) }}
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
            <div class="btn-center">
                <p>
                    {{ Form::hidden('venue_id', $request->venue_id) }}
                    {{ Form::hidden('date', $request->date) }}
                    {{ Form::hidden('enter_time', $request->enter_time) }}
                    {{ Form::hidden('leave_time', $request->leave_time) }}
                    {{ Form::hidden('cost', $venue->cost ?? 0) }}
                    {{ Form::submit('入力内容を確認する', ['class' => 'confirm-btn', 'style' => 'width:100%;']) }}
                </p>
            </div>
            {{ Form::close() }}
        </div>

    </section>

    <div class="top contents">
        <a href="#top">
            <img src="https://system.osaka-conference.com/img/pagetop.png" alt="上に戻る">
        </a>
    </div>

    <style>
        input:disabled {
            background-color: #ccc;
        }
    </style>

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
                // $("input[name='luggage_count']").prop('disabled', true);
                // $("input[name='luggage_arrive']").prop('disabled', true);
                // $("input[name='luggage_return']").prop('disabled', true);
            } else {
                $(".luggage_info").removeClass("d-none");
                // $("input[name='luggage_count']").prop('disabled', false);
                // $("input[name='luggage_arrive']").prop('disabled', false);
                // $("input[name='luggage_return']").prop('disabled', false);
            }
        });

        $(function() {
            $("input[name='luggage_flag']").change(function() {
                var no_luggage_flag = $('#no_luggage_flag').prop('checked');
                if (no_luggage_flag) {
                    $(".luggage_info").addClass("d-none");
                    // $("input[name='luggage_count']").prop('disabled', true);
                    // $("input[name='luggage_arrive']").prop('disabled', true);
                    // $("input[name='luggage_return']").prop('disabled', true);

                } else {
                    $(".luggage_info").removeClass("d-none");
                    // $("input[name='luggage_count']").prop('disabled', false);
                    // $("input[name='luggage_arrive']").prop('disabled', false);
                    // $("input[name='luggage_return']").prop('disabled', false);
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(function() {
            var holidays = ['20210722', '20210723', '20210808', '20210809', '20210920', '20210923', '20211103', '20211123', '20220101', '20220110', '20220211', '20220223', '20220321', '20220429', '20220503', '20220504', '20220505', '20220718', '20220811', '20220919', '20220923', '20221010', '20221103', '20221123', '20230101', '20230102', '20230109', '20230211', '20230223', '20230321', '20230429', '20230503', '20230504', '20230505', '20230717', '20230811', '20230918', '20230923', '20231009',
                '20231103', '20231123', '20240101', '20240108', '20240211', '20240212', '20240223', '20240320', '20240429', '20240503', '20240504', '20240505', '20240506', '20240715', '20240811', '20240812', '20240916', '20240922', '20240923', '20241014', '20241103', '20241104', '20241123', '20250101', '20250113', '20250211', '20250223', '20250224', '20250320', '20250429', '20250503', '20250504', '20250505', '20250506', '20250721', '20250811', '20250915', '20250923', '20251013',
                '20251103', '20251123', '20251124', '20260101', '20260112', '20260211', '20260223', '20260320', '20260429', '20260503', '20260504', '20260505', '20260506', '20260720', '20260811', '20260921', '20260922', '20260923', '20261012', '20261103', '20261123', '20270101', '20270111', '20270211', '20270223', '20270321', '20270322', '20270429', '20270503', '20270504', '20270505', '20270719', '20270811', '20270920', '20270923', '20271011', '20271103', '20271123', '20280101',
                '20280110', '20280211', '20280223', '20280320', '20280429', '20280503', '20280504', '20280505', '20280717', '20280811', '20280918', '20280922', '20281009', '20281103', '20281123', '20290101', '20290108', '20290211', '20290212', '20290223', '20290320', '20290429', '20290430', '20290503', '20290504', '20290505', '20290716', '20290811', '20290917', '20290923', '20290924', '20291008', '20291103', '20291123', '20300101', '20300114', '20300211', '20300223', '20300320',
                '20300429', '20300503', '20300504', '20300505', '20300506', '20300715', '20300811', '20300812', '20300916', '20300923', '20301014', '20301103', '20301104', '20301123', '20310101', '20310113', '20310211', '20310223', '20310224', '20310321', '20310429', '20310503', '20310504', '20310505', '20310506', '20310721', '20310811', '20310915', '20310923', '20311013', '20311103', '20311123', '20311124', '20320101', '20320112', '20320211', '20320223', '20320320', '20320429',
                '20320503', '20320504', '20320505', '20320719', '20320811', '20320920', '20320921', '20320922', '20321011', '20321103', '20321123', '20330101', '20330110', '20330211', '20330223', '20330320', '20330321', '20330429', '20330503', '20330504', '20330505', '20330718', '20330811', '20330919', '20330923', '20331010', '20331103', '20331123', '20340101', '20340102', '20340109', '20340211', '20340223', '20340320', '20340429', '20340503', '20340504', '20340505', '20340717',
                '20340811', '20340918', '20340923', '20341009', '20341103', '20341123', '20350101', '20350108', '20350211', '20350212', '20350223', '20350321', '20350429', '20350430', '20350503', '20350504', '20350505', '20350716', '20350811', '20350917', '20350923', '20350924', '20351008', '20351103', '20351123', '20360101', '20360114', '20360211', '20360223', '20360320', '20360429', '20360503', '20360504', '20360505', '20360506', '20360721', '20360811', '20360915', '20360922',
                '20361013', '20361103', '20361123', '20361124',
            ];
            var target_day = $('input[name="date"]').val();
            var today = new Date();
            var dd = today.getDate();
            var dt = new Date(target_day);
            dt.setDate(dt.getDate() - 1);
            var max_date = dt.getFullYear() + '-' + (dt.getMonth() + 1) + '-' + dt.getDate();
            $("#datepicker2").datepicker({
                showButtonPanel: true,
                dateFormat: 'yy-mm-dd',
                showOn: "both",
                buttonImage: "https://system.osaka-conference.com/img/icon_calender.png",
                buttonImageOnly: true,
                minDate: 0,
                maxDate: max_date,
                beforeShow: function(input, inst, date) {
                    // カレンダーを必ず下側へ表示させるための表示位置計算function
                    var top = $(this).offset().top + $(this).outerHeight();
                    var left = $(this).offset().left;
                    setTimeout(function() {
                        inst.dpDiv.css({
                            'top': top,
                            'left': left
                        });
                        var buttonPane = $(input)
                            .datepicker("widget")
                            .find(".ui-datepicker-buttonpane");

                        var btn = $('<button type="button">クリア</button>');
                        btn
                            .addClass("clear-btn")
                            .unbind("click")
                            .bind("click", function() {
                                $.datepicker._clearDate(input);
                            });

                        btn.appendTo(buttonPane);
                    }, 10) // 10msec
                },
                beforeShowDay: function(date) {
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

                // 月を変更してもクリアボタンを表示させる
                onChangeMonthYear: function(year, month, instance) {
                    setTimeout(function() {
                        var buttonPane = $(instance).datepicker('widget').find('.ui-datepicker-buttonpane');
                        $('<button>', {
                            text: 'クリア',
                            click: function() {
                                $.datepicker._clearDate(instance.input);
                            }
                        }).appendTo(buttonPane).addClass('clear-btn');
                    }, 1);
                },

            });


            $("ul.tabBtn li").mouseover(function() {
                if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator
                        .userAgent)) {
                    $(this).click();
                }
            });
            $(".hasDatepicker, .ui-datepicker, .ui-datepicker-trigger").click(function(event) {
                event.stopPropagation();
            });
            $(".contents").bind("click touchstart, touchmove", function(event) {
                $('.ui-datepicker').hide();
                $('.hasDatepicker').blur();
            });

        });
    </script>

@endsection
