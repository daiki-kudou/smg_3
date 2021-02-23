@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>

<h1>仲介会社　単発　計算</h1>





<div class="container-field bg-white text-dark">
  <div class="row">
    <div class="col">
      <table class="table table-bordered">
        <tbody>
          <tr>
            <td colspan="2">予約情報</td>
          </tr>
          <tr>
            <td class="table-active form_required">利用日</td>
            <td>
              <input class="form-control" id="datepicker1" placeholder="入力してください" name="reserve_date" type="text"
                value="2021-02-25">
              <p class="is-error-reserve_date" style="color: red"></p>
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">会場</td>
            <td>
              <select id="venues_selector" class=" form-control" name="venue_id">
                <option value="#" disabled="" selected="">選択してください</option>
                <option value="1" selected="">
                  四ツ橋サンワールドビル1号室</option>
                <option value="2">
                  四ツ橋サンワールドビル2号室(音響HG)</option>
              </select>
              <p class="is-error-venue_id" style="color: red"></p>
              <div class="price_selector">
                <div>
                  <small>※料金体系を選択してください</small>
                </div>
                <div class="price_radio_selector">
                  <div class="d-flex justfy-content-start align-items-center">
                    <input class="mr-2" id="price_system_radio1" checked="checked" name="price_system" type="radio"
                      value="1">
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
                <select name="enter_time" id="sales_start" class="form-control">
                  <option disabled="" selected=""></option>
                  <option value="00:00:00">
                    00時00分
                  </option>
                  <option value="00:30:00">
                    00時30分
                  </option>
                  <option value="01:00:00">
                    01時00分
                  </option>
                  <option value="01:30:00">
                    01時30分
                  </option>
                  <option value="02:00:00">
                    02時00分
                  </option>
                  <option value="02:30:00">
                    02時30分
                  </option>
                  <option value="03:00:00" selected="">
                    03時00分
                  </option>
                  <option value="03:30:00">
                    03時30分
                  </option>
                  <option value="04:00:00">
                    04時00分
                  </option>
                  <option value="04:30:00">
                    04時30分
                  </option>
                  <option value="05:00:00">
                    05時00分
                  </option>
                  <option value="05:30:00">
                    05時30分
                  </option>
                  <option value="06:00:00">
                    06時00分
                  </option>
                  <option value="06:30:00">
                    06時30分
                  </option>
                  <option value="07:00:00">
                    07時00分
                  </option>
                  <option value="07:30:00">
                    07時30分
                  </option>
                  <option value="08:00:00">
                    08時00分
                  </option>
                  <option value="08:30:00">
                    08時30分
                  </option>
                  <option value="09:00:00">
                    09時00分
                  </option>
                  <option value="09:30:00">
                    09時30分
                  </option>
                  <option value="10:00:00">
                    10時00分
                  </option>
                  <option value="10:30:00">
                    10時30分
                  </option>
                  <option value="11:00:00">
                    11時00分
                  </option>
                  <option value="11:30:00">
                    11時30分
                  </option>
                  <option value="12:00:00">
                    12時00分
                  </option>
                  <option value="12:30:00">
                    12時30分
                  </option>
                  <option value="13:00:00">
                    13時00分
                  </option>
                  <option value="13:30:00">
                    13時30分
                  </option>
                  <option value="14:00:00">
                    14時00分
                  </option>
                  <option value="14:30:00">
                    14時30分
                  </option>
                  <option value="15:00:00">
                    15時00分
                  </option>
                  <option value="15:30:00">
                    15時30分
                  </option>
                  <option value="16:00:00">
                    16時00分
                  </option>
                  <option value="16:30:00">
                    16時30分
                  </option>
                  <option value="17:00:00">
                    17時00分
                  </option>
                  <option value="17:30:00">
                    17時30分
                  </option>
                  <option value="18:00:00">
                    18時00分
                  </option>
                  <option value="18:30:00">
                    18時30分
                  </option>
                  <option value="19:00:00">
                    19時00分
                  </option>
                  <option value="19:30:00">
                    19時30分
                  </option>
                  <option value="20:00:00">
                    20時00分
                  </option>
                  <option value="20:30:00">
                    20時30分
                  </option>
                  <option value="21:00:00">
                    21時00分
                  </option>
                  <option value="21:30:00">
                    21時30分
                  </option>
                  <option value="22:00:00">
                    22時00分
                  </option>
                  <option value="22:30:00">
                    22時30分
                  </option>
                  <option value="23:00:00">
                    23時00分
                  </option>
                </select>
                <p class="is-error-enter_time" style="color: red"></p>
              </div>
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">退室時間</td>
            <td>
              <div>
                <select name="leave_time" id="sales_finish" class="form-control">
                  <option disabled="" selected=""></option>
                  <option value="00:00:00">
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
                  <option value="14:00:00" selected="">
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
                <p class="is-error-leave_time" style="color: red"></p>
              </div>
            </td>
          </tr>
          <tr>
            <td>案内板</td>
            <td>
              <input class="mr-2" id="board_flag1" checked="checked" name="board_flag" type="radio" value="0">
              <label for="board_flag1">無し</label>
              <input class="mr-2" id="board_flag2" name="board_flag" type="radio" value="1">
              <label for="board_flag2">有り</label>
            </td>
          </tr>
          <tr>
            <td class="table-active">イベント開始時間</td>
            <td>
              <div>
                <select name="event_start" id="event_start" class="form-control">
                  <option disabled="">選択してください</option>
                  <option value="00:00:00">
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
                <select name="event_finish" id="event_finish" class="form-control">
                  <option disabled="">選択してください</option>
                  <option value="00:00:00" selected="">
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
              <input class="form-control" placeholder="入力してください" name="event_name1" type="text">

            </td>
          </tr>
          <tr>
            <td class="table-active">イベント名称2</td>
            <td>
              <input class="form-control" placeholder="入力してください" name="event_name2" type="text">
            </td>
          </tr>
          <tr>
            <td class="table-active">主催者名</td>
            <td>
              <input class="form-control" placeholder="入力してください" name="event_owner" type="text">
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
            <tr>
              <td>有線マイク</td>
              <td>
                <input class="form-control" placeholder="入力してください" name="equipment_breakdown0" type="text" value="1">
              </td>
            </tr>
            <tr>
              <td>無線マイク</td>
              <td>
                <input class="form-control" placeholder="入力してください" name="equipment_breakdown1" type="text" value="0">
              </td>
            </tr>
            <tr>
              <td>次亜塩素酸水専用・超音波加湿器＋スプレーボトル</td>
              <td>
                <input class="form-control" placeholder="入力してください" name="equipment_breakdown2" type="text" value="0">
              </td>
            </tr>
            <tr>
              <td>【追加】次亜塩素酸水専用・超音波加湿器</td>
              <td>
                <input class="form-control" placeholder="入力してください" name="equipment_breakdown3" type="text" value="0">
              </td>
            </tr>
            <tr>
              <td>赤外線温度計（非接触型体温計）＋スプレーボトル</td>
              <td>
                <input class="form-control" placeholder="入力してください" name="equipment_breakdown4" type="text" value="0">
              </td>
            </tr>
            <tr>
              <td>レーザーポインター</td>
              <td>
                <input class="form-control" placeholder="入力してください" name="equipment_breakdown5" type="text" value="0">
              </td>
            </tr>
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
            <tr>
              <td>鍵レンタル</td>
              <td>
                <div class="form-check form-check-inline">
                  <input id="service0on" class="form-check-input" name="services_breakdown0" type="radio" value="1">
                  <label for="service0on" class="form-check-label">有り</label>
                  <input id="service0off" class="form-check-input" checked="checked" name="services_breakdown0"
                    type="radio" value="0">
                  <label for="service0off" class="form-check-label">無し</label>
                </div>
              </td>
            </tr>
            <tr>
              <td>プロジェクター設置</td>
              <td>
                <div class="form-check form-check-inline">
                  <input id="service1on" class="form-check-input" name="services_breakdown1" type="radio" value="1">
                  <label for="service1on" class="form-check-label">有り</label>
                  <input id="service1off" class="form-check-input" checked="checked" name="services_breakdown1"
                    type="radio" value="0">
                  <label for="service1off" class="form-check-label">無し</label>
                </div>
              </td>
            </tr>
            <tr>
              <td>DVDプレイヤー設置</td>
              <td>
                <div class="form-check form-check-inline">
                  <input id="service2on" class="form-check-input" checked="checked" name="services_breakdown2"
                    type="radio" value="1">
                  <label for="service2on" class="form-check-label">有り</label>
                  <input id="service2off" class="form-check-input" name="services_breakdown2" type="radio" value="0">
                  <label for="service2off" class="form-check-label">無し</label>
                </div>
              </td>
            </tr>
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

            <tr>
              <td>レイアウト準備</td>
              <td>
                <div class="form-check form-check-inline">
                  <input id="layout_prepare" class="form-check-input" checked="checked" name="layout_prepare"
                    type="radio" value="1">
                  <label for="layout_prepare" class="form-check-label">有り</label>
                  <input id="no_layout_prepare" class="form-check-input" name="layout_prepare" type="radio" value="0">
                  <label for="no_layout_prepare" class="form-check-label">無し</label>
                </div>
              </td>
            </tr>
            <tr>
              <td>レイアウト片付け</td>
              <td>
                <div class="form-check form-check-inline">
                  <input id="layout_clean" class="form-check-input" name="layout_clean" type="radio" value="1">
                  <label for="layout_clean" class="form-check-label">有り</label>
                  <input id="no_layout_clean" class="form-check-input" checked="checked" name="layout_clean"
                    type="radio" value="0">
                  <label for="no_layout_clean" class="form-check-label">無し</label>
                </div>
              </td>
            </tr>
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
            <tr>
              <td>事前に預かる荷物<br>（個数）</td>
              <td>
                <input class="form-control" name="luggage_count" type="text" value="0">
              </td>
            </tr>
            <tr>
              <td>事前荷物の到着日<br>午前指定のみ</td>
              <td>
                <input class="form-control" name="luggage_arrive" type="text" value="0">
              </td>
            </tr>

            <tr>
              <td>事後返送する荷物</td>
              <td>
                <input class="form-control" name="luggage_return" type="text" value="0">
              </td>
            </tr>
            <tr>
              <td>荷物預かり/返送<br>料金</td>
              <td>
                <input class="form-control" name="luggage_price" type="text" value="12">
              </td>
            </tr>
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
                    <i class="far fa-id-card fa-2x fa-fw" aria-hidden="true"></i>仲介会社情報
                  </p>
                  <p><a class="more_btn bg-green" href="">仲介会社詳細</a></p>
                </div>
              </td>
            </tr>
            <tr>
              <td class="table-active">
                <label for="agent_id" class=" form_required">サービス名称</label></td>
              <td>
                <select class="form-control" name="agent_id" id="agent_select">
                  <option disabled="" selected="">選択してください</option>
                  <option value="1" selected="">株式会社 小林 |加奈佐々木
                    | mai.nagisa@hotmail.co.jp
                  </option>
                  <option value="2">有限会社 佐藤 |花子三宅
                    | mikako92@nakamura.info
                  </option>
                  <option value="3">株式会社 大垣 |智也青山
                    | naoki.kudo@gmail.com
                  </option>
                  <option value="4">株式会社 村山 |舞青山
                    | yosuke.uno@gmail.com
                  </option>
                  <option value="5">有限会社 加藤 |篤司小林
                    | pwakamatsu@yamagishi.org
                  </option>
                  <option value="6">株式会社 桐山 |健一村山
                    | pwatanabe@suzuki.com
                  </option>
                  <option value="7">有限会社 石田 |明美青山
                    | rhamada@takahashi.jp
                  </option>
                  <option value="8">株式会社 山田 |和也喜嶋
                    | nanami.ogaki@mail.goo.ne.jp
                  </option>
                  <option value="9">有限会社 山本 |舞宇野
                    | osamu.kato@yahoo.co.jp
                  </option>
                  <option value="10">有限会社 井高 |修平渚
                    | hiroshi.suzuki@nomura.com
                  </option>
                  <option value="11">test |testtes
                    | kudou@web-trickster.com
                  </option>
                </select>
                <p class="is-error-user_id" style="color: red"></p>
              </td>
            </tr>
            <tr>
              <td class="table-active"><label for="name" class=" form_required">担当者氏名<br></label></td>
              <td>
                <p class="selected_person">加奈佐々木</p>
              </td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered oneday-table">
          <tbody>
            <tr>
              <td colspan="2">
                <p class="title-icon">
                  <i class="fas fa-user-check fa-2x fa-fw" aria-hidden="true"></i>仲介会社の顧客
                </p>
              </td>
            </tr>
            <tr>
              <td class="table-active">
                <label for="enduser_company" class="">会社名・団体名</label>
              </td>
              <td>
                <input class="form-control" placeholder="入力してください" id="enduser_company" name="enduser_company"
                  type="text">
              </td>
            </tr>
            <tr>
              <td class="table-active">
                <label for="enduser_incharge" class="">担当者氏名</label>
              </td>
              <td>
                <input class="form-control" placeholder="入力してください" id="enduser_incharge" name="enduser_incharge"
                  type="text">
              </td>
            </tr>
            <tr>
              <td class="table-active">
                <label for="enduser_address" class=" ">住所</label>
              </td>
              <td>
                <input class="form-control" placeholder="入力してください" id="enduser_address" name="enduser_address"
                  type="text">
              </td>
            </tr>
            <tr>
              <td class="table-active">
                <label for="enduser_tel" class="">電話番号</label>
              </td>
              <td>
                <input class="form-control" placeholder="入力してください" maxlength="13" id="enduser_tel" name="enduser_tel"
                  type="text">
              </td>
            </tr>
            <tr>
              <td class="table-active">
                <label for="enduser_mail" class=" ">メールアドレス</label>
              </td>
              <td>
                <input class="form-control" placeholder="入力してください" maxlength="13" id="enduser_mail" name="enduser_mail"
                  type="text">
              </td>
            </tr>
            <tr>
              <td class="table-active">
                <label for="enduser_attr" class="">利用者属性</label>
              </td>
              <td>
                <input class="form-control" placeholder="入力してください" maxlength="13" id="enduser_attr" name="enduser_attr"
                  type="text">
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <table class="table table-bordered sale-table">
        <tbody>
          <tr>
            <td colspan="2">
              <p class="title-icon">
                <i class="fas fa-yen-sign fa-2x fa-fw" aria-hidden="true"></i>仲介会社の顧客への支払い料
              </p>
            </td>
          </tr>
          <tr>
            <td class="table-active form_required">
              <label for="enduser_charge ">支払い料</label>
            </td>
            <td class="d-flex align-items-center">
              <input class="form-control sales_percentage" placeholder="入力してください" name="enduser_charge" type="text"
                value="50000">円
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