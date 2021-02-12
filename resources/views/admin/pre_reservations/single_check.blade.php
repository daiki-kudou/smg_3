@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>

<h1>単発　仮抑え　詳細入力画面</h1>

<div class="selected_user mt-5">
  <table class="table table-bordered" style="table-layout: fixed;">
    <thead>
      <tr>
        <th>顧客情報</th>
        <th colspan="3">顧客ID：<p class="user_id d-inline">{{$request->user_id}}</p>
        </th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="table-active">会社名・団体名</td>
        <td colspan="3">
          <p class="company">{{$request->user_id==999?"":ReservationHelper::getCompany($request->user_id)}}</p>
        </td>
      </tr>
      <tr>
        <td class="table-active">担当者指名</td>
        <td>
          <p class="person">{{$request->user_id==999?"":ReservationHelper::getPersonName($request->user_id)}}</p>
        </td>
        <td class="table-active">メールアドレス</td>
        <td>
          <p class="email">{{$request->user_id==999?"":ReservationHelper::getPersonEmail($request->user_id)}}</p>
        </td>
      </tr>
      <tr>
        <td class="table-active">携帯番号</td>
        <td>
          <p class="mobile">{{$request->user_id==999?"":ReservationHelper::getPersonMobile($request->user_id)}}</p>
        </td>
        <td class="table-active">固定電話</td>
        <td>
          <p class="tel">{{$request->user_id==999?"":ReservationHelper::getPersonTel($request->user_id)}}</p>
        </td>
      </tr>
    </tbody>
  </table>
</div>

<div class="unknown_user mt-5">
  <table class="table table-bordered" style="table-layout: fixed;">
    <thead>
      <tr>
        <th colspan="4">顧客情報（顧客登録がされていない場合）</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="table-active">会社名・団体名</td>
        <td>
          {{ Form::text('', ($request->unknown_user_company),['class'=>'form-control', 'readonly'] ) }}
        </td>
        <td colspan="2"></td>
      </tr>
      <tr>
        <td class="table-active">担当者指名</td>
        <td>
          {{ Form::text('', ($request->unknown_user_name),['class'=>'form-control', 'readonly'] ) }}
        </td>
        <td class="table-active">メールアドレス</td>
        <td>
          {{ Form::text('', ($request->unknown_user_email),['class'=>'form-control', 'readonly'] ) }}
        </td>
      </tr>
      <tr>
        <td class="table-active">携帯番号</td>
        <td>
          {{ Form::text('', ($request->unknown_user_mobile),['class'=>'form-control', 'readonly'] ) }}
        </td>
        <td class="table-active">固定電話</td>
        <td>
          {{ Form::text('', ($request->unknown_user_tel),['class'=>'form-control', 'readonly'] ) }}
        </td>
      </tr>
    </tbody>
  </table>
</div>


{{-- 以下、詳細入力 --}}
<div class="container-field bg-white text-dark mt-5 mb-5">
  <div class="row">
    <div class="col">
      <table class="table table-bordered">
        <tbody>
          <tr>
            <td colspan="2">仮抑え情報</td>
          </tr>
          <tr>
            <td class="table-active form_required">利用日</td>
            <td>
              {{ Form::text('reserve_date', $request->pre_date0,['class'=>'form-control', 'readonly'] ) }}
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">会場</td>
            <td>
              {{ Form::text('', ReservationHelper::getVenue($request->pre_venue0),['class'=>'form-control', 'readonly'] ) }}
              {{ Form::hidden('venue_id', $request->pre_venue0,['class'=>'form-control', 'readonly'] ) }}
              <div class="price_selector">
                <div>
                  <small>※料金体系を選択してください</small>
                </div>
                <div class="price_radio_selector">
                  <div class="d-flex justfy-content-start align-items-center">
                    <input class="mr-2" id="price_system_radio1" name="price_system" type="radio" value="1">
                    <label for="price_system_radio1">通常（枠貸）</label>
                  </div>
                  <div class="d-flex justfy-content-start align-items-center">
                    <input class="mr-2" id="price_system_radio2" name="price_system" type="radio" value="2">
                    <label for="price_system_radio2">アクセア（時間貸）</label>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">入室時間</td>
            <td>
              <div>
                {{ Form::text('', date('H:i',strtotime($request->pre_enter0)),['class'=>'form-control', 'readonly'] ) }}
                {{ Form::hidden('enter_time', $request->pre_enter0,['class'=>'form-control', 'readonly'] ) }}
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">退室時間</td>
            <td>
              <div>
                {{ Form::text('', date('H:i',strtotime($request->pre_leave0)),['class'=>'form-control', 'readonly'] ) }}
                {{ Form::hidden('leave_time', $request->pre_leave0,['class'=>'form-control', 'readonly'] ) }}
              </div>
            </td>
          </tr>
          <tr>
            <td>案内板</td>
            <td>
              <input type="radio" name="board_flag" value="0" checked="">無し
              <input type="radio" name="board_flag" value="1">有り
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント開始時間</td>
            <td>
              <div>
                <select name="event_start" id="event_start" class="form-control select2-hidden-accessible"
                  data-select2-id="select2-data-event_start" tabindex="-1" aria-hidden="true">
                  <option disabled="">選択してください</option>
                  <option value="00:00:00" data-select2-id="select2-data-6-eknz">
                    00時00分</option>
                  <option value="00:30:00">
                    00時30分</option>
                  <option value="01:00:00">
                    01時00分</option>
                  <option value="01:30:00">
                    01時30分</option>
                  <option value="02:00:00">
                    02時00分</option>
                  <option value="02:30:00">
                    02時30分</option>
                  <option value="03:00:00">
                    03時00分</option>
                  <option value="03:30:00">
                    03時30分</option>
                  <option value="04:00:00">
                    04時00分</option>
                  <option value="04:30:00">
                    04時30分</option>
                  <option value="05:00:00">
                    05時00分</option>
                  <option value="05:30:00">
                    05時30分</option>
                  <option value="06:00:00">
                    06時00分</option>
                  <option value="06:30:00">
                    06時30分</option>
                  <option value="07:00:00">
                    07時00分</option>
                  <option value="07:30:00">
                    07時30分</option>
                  <option value="08:00:00">
                    08時00分</option>
                  <option value="08:30:00">
                    08時30分</option>
                  <option value="09:00:00">
                    09時00分</option>
                  <option value="09:30:00">
                    09時30分</option>
                  <option value="10:00:00">
                    10時00分</option>
                  <option value="10:30:00">
                    10時30分</option>
                  <option value="11:00:00">
                    11時00分</option>
                  <option value="11:30:00">
                    11時30分</option>
                  <option value="12:00:00">
                    12時00分</option>
                  <option value="12:30:00">
                    12時30分</option>
                  <option value="13:00:00">
                    13時00分</option>
                  <option value="13:30:00">
                    13時30分</option>
                  <option value="14:00:00">
                    14時00分</option>
                  <option value="14:30:00">
                    14時30分</option>
                  <option value="15:00:00">
                    15時00分</option>
                  <option value="15:30:00">
                    15時30分</option>
                  <option value="16:00:00">
                    16時00分</option>
                  <option value="16:30:00">
                    16時30分</option>
                  <option value="17:00:00">
                    17時00分</option>
                  <option value="17:30:00">
                    17時30分</option>
                  <option value="18:00:00">
                    18時00分</option>
                  <option value="18:30:00">
                    18時30分</option>
                  <option value="19:00:00">
                    19時00分</option>
                  <option value="19:30:00">
                    19時30分</option>
                  <option value="20:00:00">
                    20時00分</option>
                  <option value="20:30:00">
                    20時30分</option>
                  <option value="21:00:00">
                    21時00分</option>
                  <option value="21:30:00">
                    21時30分</option>
                  <option value="22:00:00">
                    22時00分</option>
                  <option value="22:30:00">
                    22時30分</option>
                  <option value="23:00:00">
                    23時00分</option>
                </select>
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント終了時間</td>
            <td>
              <div>
                <select name="event_finish" id="event_finish" class="form-control select2-hidden-accessible"
                  data-select2-id="select2-data-event_finish" tabindex="-1" aria-hidden="true">
                  <option disabled="">選択してください</option>
                  <option value="00:00:00" data-select2-id="select2-data-8-f5p6">
                    00時00分</option>
                  <option value="00:30:00">
                    00時30分</option>
                  <option value="01:00:00">
                    01時00分</option>
                  <option value="01:30:00">
                    01時30分</option>
                  <option value="02:00:00">
                    02時00分</option>
                  <option value="02:30:00">
                    02時30分</option>
                  <option value="03:00:00">
                    03時00分</option>
                  <option value="03:30:00">
                    03時30分</option>
                  <option value="04:00:00">
                    04時00分</option>
                  <option value="04:30:00">
                    04時30分</option>
                  <option value="05:00:00">
                    05時00分</option>
                  <option value="05:30:00">
                    05時30分</option>
                  <option value="06:00:00">
                    06時00分</option>
                  <option value="06:30:00">
                    06時30分</option>
                  <option value="07:00:00">
                    07時00分</option>
                  <option value="07:30:00">
                    07時30分</option>
                  <option value="08:00:00">
                    08時00分</option>
                  <option value="08:30:00">
                    08時30分</option>
                  <option value="09:00:00">
                    09時00分</option>
                  <option value="09:30:00">
                    09時30分</option>
                  <option value="10:00:00">
                    10時00分</option>
                  <option value="10:30:00">
                    10時30分</option>
                  <option value="11:00:00">
                    11時00分</option>
                  <option value="11:30:00">
                    11時30分</option>
                  <option value="12:00:00">
                    12時00分</option>
                  <option value="12:30:00">
                    12時30分</option>
                  <option value="13:00:00">
                    13時00分</option>
                  <option value="13:30:00">
                    13時30分</option>
                  <option value="14:00:00">
                    14時00分</option>
                  <option value="14:30:00">
                    14時30分</option>
                  <option value="15:00:00">
                    15時00分</option>
                  <option value="15:30:00">
                    15時30分</option>
                  <option value="16:00:00">
                    16時00分</option>
                  <option value="16:30:00">
                    16時30分</option>
                  <option value="17:00:00">
                    17時00分</option>
                  <option value="17:30:00">
                    17時30分</option>
                  <option value="18:00:00">
                    18時00分</option>
                  <option value="18:30:00">
                    18時30分</option>
                  <option value="19:00:00">
                    19時00分</option>
                  <option value="19:30:00">
                    19時30分</option>
                  <option value="20:00:00">
                    20時00分</option>
                  <option value="20:30:00">
                    20時30分</option>
                  <option value="21:00:00">
                    21時00分</option>
                  <option value="21:30:00">
                    21時30分</option>
                  <option value="22:00:00">
                    22時00分</option>
                  <option value="22:30:00">
                    22時30分</option>
                  <option value="23:00:00">
                    23時00分</option>
                </select>
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント名称1</td>
            <td>
              <input class="form-control" placeholder="入力してください" name="event_name1" type="text" value="">

            </td>
          </tr>
          <tr>
            <td class="table-active">イベント名称2</td>
            <td>
              <input class="form-control" placeholder="入力してください" name="event_name2" type="text" value="">

            </td>
          </tr>
          <tr>
            <td class="table-active">主催者名</td>
            <td>
              <input class="form-control" placeholder="入力してください" name="event_owner" type="text" value="">
            </td>
          </tr>
        </tbody>
      </table>
      <div class="equipemnts">
        <table class="table table-bordered" style="table-layout: fixed;">
          <thead>
            <tr>
              <th colspan="2">
                <div class="d-flex justify-content-between align-items-center">
                  有料備品
                  <i class="fas fa-plus icon_plus hide" aria-hidden="true"></i>
                  <i class="fas fa-minus icon_minus" aria-hidden="true"></i>
                </div>
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach ($equipments as $key=>$equipment)
            <tr>
              <td class="table-active">
                {{$equipment->item}}
              </td>
              <td>
                {{ Form::text('equipment_breakdown'.$key, '',['class'=>'form-control'] ) }}
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="services">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th colspan="2">
                <div class="d-flex justify-content-between align-items-center">
                  有料サービス
                  <i class="fas fa-plus icon_plus hide" aria-hidden="true"></i>
                  <i class="fas fa-minus icon_minus" aria-hidden="true"></i>
                </div>
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach ($services as $key=>$service)
            <tr>
              <td class="table-active">
                {{$service->item}}
              </td>
              <td>
                <div class="form-check form-check-inline">
                  {{Form::radio('services_breakdown'.$key, 1, false , ['id' => 'service'.$key.'on', 'class' => 'form-check-input'])}}
                  <label for="{{'service'.$key.'on'}}" class="form-check-label">有り</label>
                  {{Form::radio('services_breakdown'.$key, 0, true, ['id' => 'services_breakdown'.$key.'off', 'class' => 'form-check-input'])}}
                  <label for="{{'services_breakdown'.$key.'off'}}" class="form-check-label">無し</label>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="layouts">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th colspan="2">レイアウト</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <div class="luggage">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th colspan="2">荷物預かり</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <div class="price_details">
      </div>
    </div>

    <div class="col">
      <div class="client_mater">　
        <table class="table table-bordered name-table">
          <tbody>
            <tr>
              <td colspan="2">
                <div class="d-flex align-items-center justify-content-between">
                  <p class="title-icon">
                    <i class="far fa-id-card fa-2x fa-fw" aria-hidden="true"></i>顧客情報
                  </p>
                  <p><a class="more_btn bg-green" href="">顧客詳細</a></p>
                </div>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="user_id" class=" form_required">会社名/団体名</label></td>
              <td>
                <select class="form-control" name="user_id" id="user_select">
                  <option disabled="" selected="">選択してください</option>
                  <option value="1">トリックスター |
                    丸岡麻衣 | maruoka@web-trickster.com
                  </option>
                  <option value="2">トリックスター |
                    大山紘一郎 | ooyama@web-trickster.com
                  </option>
                  <option value="3">トリックスター |
                    工藤大揮 | kudou@web-trickster.com
                  </option>
                  <option value="999">（未登録ユーザー） |
                    （未登録ユーザー）（未登録ユーザー） | sample@sample.com
                  </option>
                </select>
                <p class="is-error-user_id" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="name" class=" form_required">担当者氏名<br></label></td>
              <td>
                <p class="selected_person"></p>
              </td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered oneday-table">
          <tbody>
            <tr>
              <td colspan="2">
                <p class="title-icon">
                  <i class="fas fa-user-check fa-2x fa-fw" aria-hidden="true"></i>当日の連絡できる担当者
                </p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="ondayName" class=" form_required">氏名</label></td>
              <td>
                <input class="form-control" placeholder="入力してください" name="in_charge" type="text">
                <p class="is-error-in_charge" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="mobilePhone" class=" form_required">携帯番号</label></td>
              <td>
                <input class="form-control" placeholder="入力してください" maxlength="13" name="tel" type="text">
                <p class="is-error-tel" style="color: red"></p>

              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <table class="table table-bordered mail-table">
        <tbody>
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-envelope fa-2x fa-fw" aria-hidden="true"></i>利用後の送信メール
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="email_flag">送信メール</label></td>
            <td>
              <div class="radio-box">
                <input type="radio" name="email_flag" value="0" checked="checked">無し
                <input type="radio" name="email_flag" value="1">有り
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <table class="table table-bordered sale-table">
        <tbody>
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-yen-sign fa-2x fa-fw" aria-hidden="true"></i>売上原価（提携会場を選択した場合、提携会場で設定した原価率が適応されます）
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="cost">原価率</label></td>
            <td class="d-flex align-items-center">
              <input class="form-control sales_percentage" placeholder="入力してください" name="cost" type="number">%
            </td>
          </tr>
        </tbody>
      </table>
      <table class="table table-bordered note-table">
        <tbody>
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-envelope fa-2x fa-fw" aria-hidden="true"></i>備考
              </p>
            </td>
          </tr>
          <tr>
            <td>
              <p>
                <input type="checkbox" id="discount" checked="">
                <label for="discount">割引条件</label>
              </p>
              <textarea class="form-control" placeholder="入力してください" name="discount_condition" cols="50"
                rows="10"></textarea>
            </td>
          </tr>
          <tr class="caution">
            <td>
              <label for="caution">注意事項</label>
              <textarea class="form-control" placeholder="入力してください" name="attention" cols="50" rows="10"></textarea>
            </td>
          </tr>
          <tr>
            <td>
              <label for="userNote">顧客情報の備考</label>
              <textarea class="form-control" placeholder="入力してください" name="user_details" cols="50" rows="10"></textarea>
            </td>
          </tr>
          <tr>
            <td>
              <label for="adminNote">管理者備考</label>
              <textarea class="form-control" placeholder="入力してください" name="admin_details" cols="50" rows="10"></textarea>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection