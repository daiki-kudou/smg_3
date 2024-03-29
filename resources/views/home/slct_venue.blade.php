@extends('layouts.reservation.app')
@section('content')

<script src="{{ asset('/js/user_reservation/validation.js') }}"></script>
<script src="{{ asset('/js/user_reservation/control_time.js') }}"></script>

<div id="fullOverlay">
  <div class="spinner">
    <div class="loader">Loading...</div>
  </div>
</div>

<!-- 会場予約 -->
<div class="contents">
  <div class="pagetop-text">
    <h1 class="page-title oddcolor"><span>会場予約</span></h1>
    <p>希望日時に空きがあることをご確認の上、お申込み下さい。</p>
  </div>
</div>
<section class="contents">
  <div class="borderBox">
    <article>
      <ul class="sp tabBtn clearfix">
        <li>利用日から選ぶ</li>
        <li class="trigger">会場から選ぶ</li>
      </ul>
      <div class="flexBetween">
        <div class="grayBox spmt20">
          <p class="txtCenter"><em>利用日から選ぶ</em></p>
          {{Form::open(['url' => '/slct_date', 'method' => 'get', 'id'=>'form01', 'class'=>'search','autocomplete'=>'off',])}}
          @csrf
          <dl>
            <dt><label>利用日</label></dt>
            <dd>
              <div class="riyoubi">
                {{ Form::text('date', HomeHelper::now(),['class'=>'form-control text6', 'readonly', 'id'=>'datepicker']
                ) }}
              </div>
              <span class="txt-indent f-s90">※複数日程検索は出来ません。</span>
              <span class="txt-indent f-s90">※選択不可の日程につきましては、直接お問い合わせ下さい。</span>
              <span class="txt-indent f-s90">※一部検索対応をしていない会場があります。</span></p>
            </dd>
          </dl>
          <div class="btnOrange">
            <button type="submit" class="smit">会場検索
              <img src="https://system.osaka-conference.com/img/icon_serch.png" alt="検索">
            </button>
          </div>
          {{Form::close()}}
        </div>
        <div class="grayBox btn-row">
          <p class="txtCenter"><em>会場から選ぶ</em></p>
          {{Form::open(['url' => '/slct_venue', 'method' => 'get', 'id'=>'form02', 'class'=>'search','autocomplete'=>'off',])}}
          @csrf
          <dl class="m-b20">
            <dt><label>会場</label></dt>
            <dd>
              <div class="selectWrap">
                <select name="room04" id="changeSelect">
                  @foreach ($venues as $venue)
                  @if ($selected_venue==$venue->id)
                  <option value="{{$venue->id}}" selected>{{ReservationHelper::getVenueForUser($venue->id)}}
                  </option>
                  @else
                  <option value="{{$venue->id}}">{{ReservationHelper::getVenueForUser($venue->id)}}</option>
                  @endif
                  @endforeach
                </select>
              </div>
              <p><span class="txt-indent f-s90">※検索対応をしていない会場や、利用月プルダウン外の日程に関しましては直接お問い合わせ下さい。</span>
              </p>
            </dd>
          </dl>
          <dl>
            <dt><label>利用月</label></dt>
            <dd class="">
              <div class="selectWrap">
                {{ Form::select('mon',HomeHelper::getMonths(),old('mon',$request->mon),['id'=>'changeSelectpoint']) }}
              </div>
            </dd>
          </dl>
          <dl class="m-b20">
            <dt></dt>
            <dd>
              <p><span class="txt-indent f-s90">※選択不可の日程につきましては、直接お問い合わせ下さい。</span></p>
            </dd>
          </dl>
          <p class="txtCenter">
            <button type="submit" class="smit search_btn">空室状況検索<img
                src="https://system.osaka-conference.com/img/icon_serch.png" alt="検索"></button>
          </p>
          {{Form::close()}}
        </div>
      </div>
    </article>
    @if((int)$request->room04===10||(int)$request->room04===11||(int)$request->room04===12||(int)$request->room04===13||(int)$request->room04===16||(int)$request->room04===17||(int)$request->room04===19||(int)$request->room04===20)
    <div class="caution-area m-t20">
      <p class="text-center caution-text">当会場の空き状況についてはお電話にてお問い合わせ下さい。</p>
    </div>
    @else
    <div class="calenderframe">
      <iframe src="{{url('/calendar/venue_calendar')}}" width="100%"></iframe>
    </div>
    @endif

    {{Form::open(['url' => '/user/reservations/create', 'method' => 'get', 'class'=>'search','id'=>'slct_venue_form','autocomplete'=>'off',])}}
    <h2 class="sub-ttl">申込み内容</h2>
    <div class="bgColorGray first">
      <table class="">
        <tr>
          <th>利用会場</th>
          <td>
            <p>{{ReservationHelper::getVenueForUser($selected_venue)}}</p>
            {{Form::hidden('venue_id',$selected_venue,['id'=>'venue_id'])}}
          </td>
        </tr>
        <tr>
          <th>年月日<span class="txtRed">＊</span></th>
          <td>
            <p>
            <div class="riyoubi">
              <input type="text" name="" id="datepicker2" class="form-input date_input" autocomplete="off" readonly>
              {{Form::hidden('date',"")}}
            </div>
            <p class="is-error-date" style="color: red"></p>
            <p><span class="txt-indent">翌々日以降の利用日から受付可能です。</span></p>
            <p><span>直近の日程は選択できません。お電話にて問い合わせ下さい。</span></p>
            </p>
          </td>
        </tr>
        <tr>
          <th>入室時間
            <span class="txtRed">＊</span>
          </th>
          <td class="form-cell3">
            <div class="m-r10">
              <div class="selectWrap">
                <select name="enter_time" class="timeScale" id="enter_time">
                </select>
              </div>
              <p class="is-error-enter_time" style="color: red"></p>
            </div>
            <div>
              <p class="txtRed">
                <span>入室時間より以前に入室はできません。</span>
              </p>
              <p class="checkbox-txt txtRed">
                <span class="txtRed">＊</span>
                {{Form::checkbox('q1', 1, false, ['class'=>'','id'=>'checkbox'])}}
                <label for="checkbox">確認しました</label>
              </p>
              <p class="is-error-q1" style="color: red"></p>
            </div>
          </td>
        </tr>
        <tr>
          <th>退室時間 <span class="txtRed">＊</span></th>
          <td>
            <div class="selectWrap">
              <select name="leave_time" class="timeScale" id="leave_time">
              </select>
            </div>
            <p class="is-error-leave_time" style="color: red"></p>
          </td>
        </tr>
      </table>
    </div>
    <p class="m-t10">
      {{ Form::submit('詳細情報の入力', ['class' => 'btn confirm-btn margin-auto']) }}
    </p>
    {{Form::close()}}
  </div>

</section>

<article class="contents">
  <div class="page-text">
    <p class="caution-text">カレンダーにない日程の予約に関してはお電話にてお問合せください。</p>
  </div>
  <div class="contactinfo">
    <div class="info">
      <p class="title">問い合わせの前に</p>
      <p>お客様よりいただく<span class="faq"><a href="../faq/">よくある質問</a></span>をご参考下さい。</p>
    </div>
    <div class="telInfo">
      <p class="title">電話での問い合わせ（10時～18時）</p>
      <div class="telNo pc">06-6556-6462</div>
      <div class="telNo sp"><a href="tel:06-6556-6462"
          onclick="gtag('event','tel-tap',{'event_category':'click'});">06-6556-6462</a></div>
      <p>ご予約、お問い合わせ専用番号となります。<br class="sp">会場アクセスやイベント内容についてのお問い合わせはお控え下さい。</p>
    </div>
  </div>
</article>


<script>
  $("form[name='calendar02'] select[name='room04']").val($("form[name='calendar02'] select[name='room04'] option").first().val());
    $(function () {
        $("form#form02 select[name='room04'] option").filter(function () {
            return $(this).attr("disabled");
        }).remove();
    });

    $(window).on('load', function() {
    var origin_date=$('select[name="mon"] option:selected').val();
    var origin_venue=$('select[name="room04"] option:selected').val();
    var origin_yer=origin_date.substr(0,4);
    var origin_mon=origin_date.substr(4,2);

    const iframe = $('iframe').contents();
    iframe.find('input[name="venue_id"]').val(origin_venue);
    iframe.find('input[name="selected_year"]').val(origin_yer);
    iframe.find('input[name="selected_month"]').val(origin_mon);
    iframe.find('#v_calendar').submit();
    });

    $(function(){
      $('.date_input').on('change',function(){
        $input=$(this).val();
        $fix_input=$input.replace(/\//g,'-');
        $('input[name="date"]').val($fix_input);
      })
    })

</script>

<script type="text/javascript">
  $(function () {
          var today = new Date();
          var dd = today.getDate();
          $("#datepicker2").datepicker({
              showOn: "both",
              buttonImage: "https://system.osaka-conference.com/img/icon_calender.png",
              buttonImageOnly: true,
              minDate: "+3",
              maxDate: "+6M -" + dd,
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
<div class="top contents"><a href="#top"><img src="https://system.osaka-conference.com/img/pagetop.png" alt="上に戻る"></a>
</div>


@endsection