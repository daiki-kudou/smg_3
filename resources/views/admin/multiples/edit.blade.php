@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/multiples/script.js') }}"></script>





























<div class="content">
  <div class="container-fluid">
    <div class="container-field mt-3">
      <div class="float-right">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="http://staging-smg2.herokuapp.com/admin/home">ホーム</a> &gt;
              一括仮押さえ 編集
            </li>
          </ol>
        </nav>
      </div>
      <h1 class="mt-3 mb-5">一括仮押さえ　編集</h1>
    </div>
    <!-- 仮押さえ登録--------------------------------------------------------　 -->
    <div class="alert-box d-flex align-items-center">
      <span class="mr-3"><i class="fas alert-icon fa-exclamation-triangle" aria-hidden="true"></i></span>
      <p>
        変更がある場合は、必ず更新するボタンを押してください。<br>
        更新しないまま画面遷移をすると、データが反映されません。
      </p>
    </div>　

    <!-- 詳細選択画面--------------------------------------------------　 -->
    <div class="col">
      <p class="font-weight-bold">日程ごとに、詳細を編集できます。</p>
    </div>



    <div class="col">
      <h3 class="bg-green py-2 px-1">仮押さえ一括ID:<span>{{$multiple->id}}</span><span
          class="ml-4">{{ReservationHelper::getVenue($venue->id)}}</span>
      </h3>
      <section class="col mt-4">
        <div class="register-wrap">
          <div class="mb-2">
            <p>同じ内容をすべての日程に反映することができます。</p>
          </div>

          <dl class="card">
            <dt class="card-header accordion-ttl2">
              <ul class="title-icon active d-flex">
                <li class="col-3">
                  <p>コピー作成用選択欄</p>
                </li>

                <li class="plus_icon">
                </li>
              </ul>
            </dt>

            <dt class="accordion-wrap p-3" style="display: none;">
              <div class="row">
                <!-- 左側の項目------------------------------------------------------------------------ -->
                <div class="col">
                  <table class="table table-bordered">
                    <tbody>
                      <tr>
                        <td colspan="2">
                          <p class="title-icon">
                            <i class="fas fa-info-circle icon-size" aria-hidden="true"></i>
                            予約情報</p>
                        </td>
                      </tr>

                      <tr>
                        <td class="table-active"><label for="direction">案内板</label></td>
                        <td>
                          <div class="radio-box">
                            <div class="icheck-primary">
                              <input type="radio" id="direction_flag" name="direction_flag" checked="">
                              <label for="direction_flag">要作成</label>
                            </div>
                            <div class="icheck-primary">
                              <input type="radio" id="direction_flag" name="direction_flag" checked="">
                              <label for="direction_flag">不要</label>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td class="table-active"><label for="eventTime">イベント時間記載</label></td>
                        <td>
                          <div class="radio-box">
                            <div class="icheck-primary">
                              <input type="radio" id="eventTime" name="eventTime" checked="">
                              <label for="eventTime">あり</label>
                            </div>
                            <div class="icheck-primary">
                              <input type="radio" id="eventTime" name="eventTime" checked="">
                              <label for="eventTime">なし</label>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td class="table-active"><label for="eventStart">イベント開始時間</label></td>
                        <td>
                          <select class="form-control" id="eventStart" name="eventStart">
                            <option value="01:00:00">01:00</option>
                            <option value="01:30:00">01:30</option>
                            <option value="02:00:00">02:00</option>
                            <option value="02:30:00">02:30</option>
                            <option value="03:00:00">03:00</option>
                            <option value="03:30:00">03:30</option>
                            <option value="04:00:00">04:00</option>
                            <option value="04:30:00">04:30</option>
                            <option value="05:00:00">05:00</option>
                            <option value="05:30:00">05:30</option>
                            <option value="06:00:00">06:00</option>
                            <option value="06:30:00">06:30</option>
                            <option value="07:00:00">07:00</option>
                            <option value="07:30:00">07:30</option>
                            <option value="08:00:00" selected="selected">08:00</option>
                            <option value="08:30:00">08:30</option>
                            <option value="09:00:00">09:00</option>
                            <option value="09:30:00">09:30</option>
                            <option value="10:00:00">10:00</option>
                            <option value="10:30:00">10:30</option>
                            <option value="11:00:00">11:00</option>
                            <option value="11:30:00">11:30</option>
                            <option value="12:00:00">12:00</option>
                            <option value="12:30:00">12:30</option>
                            <option value="13:00:00">13:00</option>
                            <option value="13:30:00">13:30</option>
                            <option value="14:00:00">14:00</option>
                            <option value="14:30:00">14:30</option>
                            <option value="15:00:00">15:00</option>
                            <option value="15:30:00">15:30</option>
                            <option value="16:00:00">16:00</option>
                            <option value="16:30:00">16:30</option>
                            <option value="17:00:00">17:00</option>
                            <option value="17:30:00">17:30</option>
                            <option value="18:00:00">18:00</option>
                            <option value="18:30:00">18:30</option>
                            <option value="19:00:00">19:00</option>
                            <option value="19:30:00">19:30</option>
                            <option value="20:00:00">20:00</option>
                            <option value="20:30:00">20:30</option>
                            <option value="21:00:00">21:00</option>
                            <option value="21:30:00">21:30</option>
                            <option value="22:00:00">22:00</option>
                            <option value="22:30:00">22:30</option>
                            <option value="23:00:00">23:00</option>
                            <option value="23:30:00">23:30</option>
                            <option value="24:00:00">24:00</option>
                            <option value="24:30:00">24:30</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td class="table-active"><label for="eventFinish">イベント終了時間</label></td>
                        <td>
                          <select class="form-control" id="eventFinish" name="eventFinish">
                            <option value="01:00:00">01:00</option>
                            <option value="01:30:00">01:30</option>
                            <option value="02:00:00">02:00</option>
                            <option value="02:30:00">02:30</option>
                            <option value="03:00:00">03:00</option>
                            <option value="03:30:00">03:30</option>
                            <option value="04:00:00">04:00</option>
                            <option value="04:30:00">04:30</option>
                            <option value="05:00:00">05:00</option>
                            <option value="05:30:00">05:30</option>
                            <option value="06:00:00">06:00</option>
                            <option value="06:30:00">06:30</option>
                            <option value="07:00:00">07:00</option>
                            <option value="07:30:00">07:30</option>
                            <option value="08:00:00" selected="selected">08:00</option>
                            <option value="08:30:00">08:30</option>
                            <option value="09:00:00">09:00</option>
                            <option value="09:30:00">09:30</option>
                            <option value="10:00:00">10:00</option>
                            <option value="10:30:00">10:30</option>
                            <option value="11:00:00">11:00</option>
                            <option value="11:30:00">11:30</option>
                            <option value="12:00:00">12:00</option>
                            <option value="12:30:00">12:30</option>
                            <option value="13:00:00">13:00</option>
                            <option value="13:30:00">13:30</option>
                            <option value="14:00:00">14:00</option>
                            <option value="14:30:00">14:30</option>
                            <option value="15:00:00">15:00</option>
                            <option value="15:30:00">15:30</option>
                            <option value="16:00:00">16:00</option>
                            <option value="16:30:00">16:30</option>
                            <option value="17:00:00">17:00</option>
                            <option value="17:30:00">17:30</option>
                            <option value="18:00:00">18:00</option>
                            <option value="18:30:00">18:30</option>
                            <option value="19:00:00">19:00</option>
                            <option value="19:30:00">19:30</option>
                            <option value="20:00:00">20:00</option>
                            <option value="20:30:00">20:30</option>
                            <option value="21:00:00">21:00</option>
                            <option value="21:30:00">21:30</option>
                            <option value="22:00:00">22:00</option>
                            <option value="22:30:00">22:30</option>
                            <option value="23:00:00">23:00</option>
                            <option value="23:30:00">23:30</option>
                            <option value="24:00:00">24:00</option>
                            <option value="24:30:00">24:30</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td class="table-active"><label for="eventName1">イベント名称1</label></td>
                        <td><input class="form-control" name="eventName1" type="text" id="eventName1"></td>
                      </tr>
                      <tr>
                        <td class="table-active"><label for="eventName2">イベント名称2</label></td>
                        <td><input class="form-control" name="eventName2" type="text" id="eventName2"></td>
                      </tr>
                      <tr>
                        <td class="table-active"><label for="organizer">主催者名</label></td>
                        <td><input class="form-control" name="organizer" type="text" id="organizer"></td>
                      </tr>
                    </tbody>
                  </table>

                  <table class="table table-bordered equipment-table">
                    <thead class="accordion-ttl">
                      <tr>
                        <td colspan="2">
                          <p class="title-icon active">有料備品</p>
                        </td>
                      </tr>
                    </thead>
                    <tbody class="accordion-wrap" style="display: none;">
                      <tr>
                        <td class="justify-content-between d-flex">
                          <label for="equipment">ホワイトボード</label>
                          <input type="number" id="equipment" name="equipment" min="0" max="100">
                        </td>
                      </tr>
                      <tr>
                        <td class="justify-content-between d-flex">
                          <label for="equipment">ホワイトボード</label>
                          <input type="number" id="equipment" name="equipment" min="0" max="100">
                        </td>
                      </tr>
                      <tr>
                        <td class="justify-content-between d-flex">
                          <label for="equipment">ホワイトボード</label>
                          <input type="number" id="equipment" name="equipment" min="0" max="100">
                        </td>
                      </tr>
                    </tbody>
                  </table>

                  <table class="table table-bordered service-table">
                    <thead class="accordion-ttl">
                      <tr>
                        <td colspan="2">
                          <p class="title-icon active">有料サービス<span class="open_toggle"></span></p>
                        </td>
                      </tr>
                    </thead>
                    <tbody class="accordion-wrap" style="display: none;">
                      <tr>
                        <td colspan="2">
                          <ul class="icheck-primary">
                            <li>
                              <input type="checkbox" id="checkboxPrimary1" checked="">
                              <label for="checkboxPrimary1">プロジェクター設置 2000円</label>
                            </li>
                            <li>
                              <input type="checkbox" id="checkboxPrimary1" checked="">
                              <label for="checkboxPrimary1">鍵レンタル 500円</label>
                            </li>
                            <li>
                              <input type="checkbox" id="checkboxPrimary1" checked="">
                              <label for="checkboxPrimary1">領収書発行 500円</label>
                            </li>
                            <li>
                              <input type="checkbox" id="checkboxPrimary1" checked="">
                              <label for="checkboxPrimary1">DVDプレイヤー設置 2000円</label>
                            </li>
                          </ul>
                        </td>
                      </tr>
                      <tr>
                        <td class="table-active"><label for="layout">レイアウト変更</label></td>
                        <td>
                          <div class="radio-box">
                            <div class="icheck-primary">
                              <input type="radio" id="layoutChange" name="layoutChange" checked="">
                              <label for="layoutChange">あり</label>
                            </div>
                            <div class="icheck-primary">
                              <input type="radio" id="layoutChange" name="layoutChange" checked="">
                              <label for="layoutChange">なし</label>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td class="table-active"><label for="prelayout">レイアウト準備</label></td>
                        <td>
                          <div class="radio-box">
                            <div class="icheck-primary">
                              <input type="radio" id="prelayout" name="prelayout" checked="">
                              <label for="prelayout">あり</label>
                            </div>
                            <div class="icheck-primary">
                              <input type="radio" id="prelayout" name="prelayout" checked="">
                              <label for="prelayout">なし</label>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td class="table-active"><label for="postlayout">レイアウト片付</label></td>
                        <td>
                          <div class="radio-box">
                            <div class="icheck-primary">
                              <input type="radio" id="postlayout" name="postlayout" checked="">
                              <label for="postlayout">あり</label>
                            </div>
                            <div class="icheck-primary">
                              <input type="radio" id="postlayout" name="postlayout" checked="">
                              <label for="postlayout">なし</label>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td class="table-active"><label for="Delivery">荷物預かり/返送</label></td>
                        <td>
                          <div class="radio-box">
                            <div class="icheck-primary">
                              <input type="radio" id="Delivery" name="Delivery" checked="">
                              <label for="Delivery">あり</label>
                            </div>
                            <div class="icheck-primary">
                              <input type="radio" id="Delivery" name="Delivery" checked="">
                              <label for="Delivery">なし</label>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td class="table-active"><label for="preDelivery">事前に預かる荷物</label></td>
                        <td>
                          <div class="radio-box">
                            <div class="icheck-primary">
                              <input type="radio" id="preDelivery" name="preDelivery" checked="">
                              <label for="preDelivery">あり</label>
                            </div>
                            <div class="icheck-primary">
                              <input type="radio" id="preDelivery" name="preDelivery" checked="">
                              <label for="preDelivery">なし</label>
                            </div>
                          </div>
                          <div class="package-box">
                            <p>
                              <label for="packageNumber">荷物個数</label>
                            </p>
                            <div class="align-items-center d-flex"><input class="form-control" name="packageNumber"
                                type="text" id="packageNumber">個</div>
                            <p></p>
                            <p>
                              <label for="packageDate">事前荷物の到着日 午前指定のみ</label>
                              <input class="form-control" name="packageDate" type="date" id="packageDate">
                            </p>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td class="table-active"><label for="postDelivery">事後返送する荷物</label></td>
                        <td>
                          <div class="radio-box">
                            <div class="icheck-primary">
                              <input type="radio" id="postDelivery" name="postDelivery" checked="">
                              <label for="postDelivery">あり</label>
                            </div>
                            <div class="icheck-primary">
                              <input type="radio" id="postDelivery" name="postDelivery" checked="">
                              <label for="postDelivery">なし</label>
                            </div>
                          </div>
                          <div class="package-box">
                            <p>
                              <label for="packageNumber">荷物個数</label>
                            </p>
                            <div class="align-items-center d-flex"><input class="form-control" name="packageNumber"
                                type="text" id="packageNumber">個</div>
                            <p></p>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>

                  <table class="table table-bordered eating-table">
                    <tbody>
                      <tr>
                        <td>
                          <p class="title-icon">室内飲食</p>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="radio-box">
                            <div class="icheck-primary">
                              <input type="radio" id="eatin" name="eatin" checked="">
                              <label for="eatin">あり</label>
                            </div>
                            <div class="icheck-primary">
                              <input type="radio" id="eatin" name="eatin" checked="">
                              <label for="eatin">手配済</label>
                            </div>
                            <div class="icheck-primary">
                              <input type="radio" id="eatin" name="eatin" checked="">
                              <label for="eatin">検討中</label>
                            </div>
                            <div class="icheck-primary">
                              <input type="radio" id="eatin" name="eatin" checked="">
                              <label for="eatin">なし</label>
                            </div>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <!-- 左側の項目 終わり-------------------------------------------------- -->


                <!-- 右側の項目-------------------------------------------------- -->
                <div class="col">

                  <div class="customer-table">
                    <table class="table table-bordered oneday-table">
                      <tbody>
                        <tr>
                          <td colspan="2">
                            <p class="title-icon">
                              <i class="fas fa-user icon-size" aria-hidden="true"></i>
                              当日の連絡できる担当者
                            </p>
                          </td>
                        </tr>
                        <tr>
                          <td class="table-active"><label for="ondayName">氏名</label></td>
                          <td><input class="form-control" name="ondayName" type="text" id="ondayName"></td>
                        </tr>
                        <tr>
                          <td class="table-active"><label for="mobilePhone">携帯番号</label></td>
                          <td><input class="form-control" name="mobilePhone" type="text" id="mobilePhone"></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>

                  <table class="table table-bordered mail-table">
                    <tbody>
                      <tr>
                        <td colspan="2">
                          <p class="title-icon">
                            <i class="fas fa-envelope icon-size" aria-hidden="true"></i>
                            利用後の送信メール
                          </p>
                        </td>
                      </tr>
                      <tr>
                        <td class="table-active"><label for="sendMail">送信メール</label></td>
                        <td>
                          <div class="radio-box">
                            <div class="icheck-primary">
                              <input type="radio" id="sendMail" name="sendMail" checked="">
                              <label for="sendMail">あり</label>
                            </div>
                            <div class="icheck-primary">
                              <input type="radio" id="sendMail" name="sendMail" checked="">
                              <label for="sendMail">なし</label>
                            </div>
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
                            <i class="fas fa-yen-sign icon-size" aria-hidden="true"></i>
                            売上原価
                          </p>
                        </td>
                      </tr>
                      <tr>
                        <td class="table-active"><label for="sale">原価率</label></td>
                        <td class="d-flex align-items-center"><input class="form-control" name="sale" type="text"
                            id="sale">%
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <table class="table table-bordered note-table">
                    <tbody>
                      <tr>
                        <td colspan="2">
                          <p class="title-icon">
                            <i class="fas fa-file-alt icon-size" aria-hidden="true"></i>
                            備考
                          </p>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <p>
                            <input type="checkbox" id="discount" checked="">
                            <label for="discount">割引条件</label>
                          </p>
                          <textarea name="discount" rows="5"></textarea>
                        </td>
                      </tr>
                      <tr class="caution">
                        <td>
                          <label for="caution">注意事項</label>
                          <textarea name="caution" rows="10"></textarea>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <label for="adminNote">管理者備考</label>
                          <textarea name="adminNote" rows="10"></textarea>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <!-- 右側の項目 終わり-------------------------------------------------- -->
              </div>

              <!-- 請求書内容----------- -->
              <div class="bill-box">
                <h3 class="row">請求書内容</h3>
                <dl class="row bill-box_wrap">
                  <div class="col-6 bill-box_cell">
                    <dt><label for="billCompany">請求書の会社名</label></dt>
                    <dd><input class="form-control" name="billCompany" type="text" id="billCompany"></dd>
                  </div>
                  <div class="col-6 bill-box_cell">
                    <dt><label for="billCustomer">請求書の担当者名</label></dt>
                    <dd><input class="form-control" name="billCustomer" type="text" id="billCustomer"></dd>
                  </div>
                  <div class="col-6 bill-box_cell">
                    <dt><label for="billDate">請求日</label></dt>
                    <dd><input class="form-control" name="billDate" type="date" id="billDate"></dd>
                  </div>
                  <div class="col-6 bill-box_cell">
                    <dt><label for="billDue">支払期日</label></dt>
                    <dd><input class="form-control" name="billDue" type="date" id="billDue"></dd>
                  </div>
                  <div class="col-12 bill-box_cell">
                    <dt><label for="billNote">備考</label></dt>
                    <dd><input class="form-control" name="billNote" type="text" id="billNote"></dd>
                  </div>
                </dl>
              </div>
              <!-- 請求書内容 終わり---------------------------- -->
            </dt>
            <!-- /.card-body -->
          </dl>
          <!-- コピー作成用フィールド   終わり--------------------------------------------------　 -->
          <div class="btn_wrapper">
            <p class="text-center"><a class="more_btn_lg" href="">すべての日程に反映する</a></p>
          </div>
        </div>
      </section>
      <ul class="register-list-header">
        <li class="from-group">
          <div class="form-check">
            <input class="form-check-input" type="checkbox">
            <label class="form-check-label">すべてチェックする</label>
          </div>
        </li>
        <li>
          <p><a class="more_btn4" href="">削除</a></p>
        </li>
      </ul>
    </div>
    <!-- 仮押さえ一括 -->
    <section class="register-list col">
      <!-- 仮押さえ一括 タブ-->
      <div class="register-list-item">
        <div class="from-group">
          <div class="form-check">
            <input class="form-check-input" type="checkbox">
            <label class="form-check-label"></label>
          </div>
        </div>
        <dl class="card">
          <dt class="card-header accordion-ttl2">
            <ul class="title-icon active d-flex">
              <li class="col-1">
                0001（これなに？）
              </li>
              <li class="col-2">
                <div class="input-group">
                  <label for="date"></label>
                  <input class="form-control" name="date" type="date" id="date">
                </div>
              </li>
              <li class="col-3 d-flex align-items-center">
                <p>
                </p>
                <div class="input-group">
                  <label for="start"></label>
                  <select class="form-control" id="start" name="start">
                    {!!ReservationHelper::timeOptions()!!}
                  </select>
                </div>
                <p></p>
                <p class="mx-1">～</p>
                <p>
                </p>
                <div class="input-group">
                  <label for="finish"></label>
                  <select class="form-control" id="finish" name="finish">
                    {!!ReservationHelper::timeOptions()!!}
                  </select>
                </div>
                <p></p>
              </li>
              <li class="plus_icon">
              </li>
            </ul>
          </dt>
          <dt class="accordion-wrap" style="display: none;">
            <div class="row">
              <!-- 左側の項目------------------------------------------------------------------------ -->
              <div class="col">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td colspan="2">
                        <p class="title-icon">
                          <i class="fas fa-info-circle icon-size" aria-hidden="true"></i>
                          予約情報</p>
                      </td>
                    </tr>

                    <tr>
                      <td class="table-active"><label for="direction">案内板</label></td>
                      <td>
                        <div class="radio-box">
                          <div class="icheck-primary">
                            <input type="radio" id="direction_flag" name="direction_flag" checked="">
                            <label for="direction_flag">要作成</label>
                          </div>
                          <div class="icheck-primary">
                            <input type="radio" id="direction_flag" name="direction_flag" checked="">
                            <label for="direction_flag">不要</label>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="table-active"><label for="eventTime">イベント時間記載</label></td>
                      <td>
                        <div class="radio-box">
                          <div class="icheck-primary">
                            <input type="radio" id="eventTime" name="eventTime" checked="">
                            <label for="eventTime">あり</label>
                          </div>
                          <div class="icheck-primary">
                            <input type="radio" id="eventTime" name="eventTime" checked="">
                            <label for="eventTime">なし</label>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="table-active"><label for="eventStart">イベント開始時間</label></td>
                      <td>
                        <select class="form-control" id="eventStart" name="eventStart">
                          <option value="01:00:00">01:00</option>
                          <option value="01:30:00">01:30</option>
                          <option value="02:00:00">02:00</option>
                          <option value="02:30:00">02:30</option>
                          <option value="03:00:00">03:00</option>
                          <option value="03:30:00">03:30</option>
                          <option value="04:00:00">04:00</option>
                          <option value="04:30:00">04:30</option>
                          <option value="05:00:00">05:00</option>
                          <option value="05:30:00">05:30</option>
                          <option value="06:00:00">06:00</option>
                          <option value="06:30:00">06:30</option>
                          <option value="07:00:00">07:00</option>
                          <option value="07:30:00">07:30</option>
                          <option value="08:00:00" selected="selected">08:00</option>
                          <option value="08:30:00">08:30</option>
                          <option value="09:00:00">09:00</option>
                          <option value="09:30:00">09:30</option>
                          <option value="10:00:00">10:00</option>
                          <option value="10:30:00">10:30</option>
                          <option value="11:00:00">11:00</option>
                          <option value="11:30:00">11:30</option>
                          <option value="12:00:00">12:00</option>
                          <option value="12:30:00">12:30</option>
                          <option value="13:00:00">13:00</option>
                          <option value="13:30:00">13:30</option>
                          <option value="14:00:00">14:00</option>
                          <option value="14:30:00">14:30</option>
                          <option value="15:00:00">15:00</option>
                          <option value="15:30:00">15:30</option>
                          <option value="16:00:00">16:00</option>
                          <option value="16:30:00">16:30</option>
                          <option value="17:00:00">17:00</option>
                          <option value="17:30:00">17:30</option>
                          <option value="18:00:00">18:00</option>
                          <option value="18:30:00">18:30</option>
                          <option value="19:00:00">19:00</option>
                          <option value="19:30:00">19:30</option>
                          <option value="20:00:00">20:00</option>
                          <option value="20:30:00">20:30</option>
                          <option value="21:00:00">21:00</option>
                          <option value="21:30:00">21:30</option>
                          <option value="22:00:00">22:00</option>
                          <option value="22:30:00">22:30</option>
                          <option value="23:00:00">23:00</option>
                          <option value="23:30:00">23:30</option>
                          <option value="24:00:00">24:00</option>
                          <option value="24:30:00">24:30</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td class="table-active"><label for="eventFinish">イベント終了時間</label></td>
                      <td>
                        <select class="form-control" id="eventFinish" name="eventFinish">
                          <option value="01:00:00">01:00</option>
                          <option value="01:30:00">01:30</option>
                          <option value="02:00:00">02:00</option>
                          <option value="02:30:00">02:30</option>
                          <option value="03:00:00">03:00</option>
                          <option value="03:30:00">03:30</option>
                          <option value="04:00:00">04:00</option>
                          <option value="04:30:00">04:30</option>
                          <option value="05:00:00">05:00</option>
                          <option value="05:30:00">05:30</option>
                          <option value="06:00:00">06:00</option>
                          <option value="06:30:00">06:30</option>
                          <option value="07:00:00">07:00</option>
                          <option value="07:30:00">07:30</option>
                          <option value="08:00:00" selected="selected">08:00</option>
                          <option value="08:30:00">08:30</option>
                          <option value="09:00:00">09:00</option>
                          <option value="09:30:00">09:30</option>
                          <option value="10:00:00">10:00</option>
                          <option value="10:30:00">10:30</option>
                          <option value="11:00:00">11:00</option>
                          <option value="11:30:00">11:30</option>
                          <option value="12:00:00">12:00</option>
                          <option value="12:30:00">12:30</option>
                          <option value="13:00:00">13:00</option>
                          <option value="13:30:00">13:30</option>
                          <option value="14:00:00">14:00</option>
                          <option value="14:30:00">14:30</option>
                          <option value="15:00:00">15:00</option>
                          <option value="15:30:00">15:30</option>
                          <option value="16:00:00">16:00</option>
                          <option value="16:30:00">16:30</option>
                          <option value="17:00:00">17:00</option>
                          <option value="17:30:00">17:30</option>
                          <option value="18:00:00">18:00</option>
                          <option value="18:30:00">18:30</option>
                          <option value="19:00:00">19:00</option>
                          <option value="19:30:00">19:30</option>
                          <option value="20:00:00">20:00</option>
                          <option value="20:30:00">20:30</option>
                          <option value="21:00:00">21:00</option>
                          <option value="21:30:00">21:30</option>
                          <option value="22:00:00">22:00</option>
                          <option value="22:30:00">22:30</option>
                          <option value="23:00:00">23:00</option>
                          <option value="23:30:00">23:30</option>
                          <option value="24:00:00">24:00</option>
                          <option value="24:30:00">24:30</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td class="table-active"><label for="eventName1">イベント名称1</label></td>
                      <td><input class="form-control" name="eventName1" type="text" id="eventName1"></td>
                    </tr>
                    <tr>
                      <td class="table-active"><label for="eventName2">イベント名称2</label></td>
                      <td><input class="form-control" name="eventName2" type="text" id="eventName2"></td>
                    </tr>
                    <tr>
                      <td class="table-active"><label for="organizer">主催者名</label></td>
                      <td><input class="form-control" name="organizer" type="text" id="organizer"></td>
                    </tr>
                  </tbody>
                </table>
                <table class="table table-bordered equipment-table">
                  <thead class="accordion-ttl">
                    <tr>
                      <td colspan="2">
                        <p class="title-icon active">有料備品</p>
                      </td>
                    </tr>
                  </thead>
                  <tbody class="accordion-wrap" style="display: none;">
                    <tr>
                      <td class="justify-content-between d-flex">
                        <label for="equipment">ホワイトボード</label>
                        <input type="number" id="equipment" name="equipment" min="0" max="100">
                      </td>
                    </tr>
                    <tr>
                      <td class="justify-content-between d-flex">
                        <label for="equipment">ホワイトボード</label>
                        <input type="number" id="equipment" name="equipment" min="0" max="100">
                      </td>
                    </tr>
                    <tr>
                      <td class="justify-content-between d-flex">
                        <label for="equipment">ホワイトボード</label>
                        <input type="number" id="equipment" name="equipment" min="0" max="100">
                      </td>
                    </tr>
                  </tbody>
                </table>
                <table class="table table-bordered service-table">
                  <thead class="accordion-ttl">
                    <tr>
                      <td colspan="2">
                        <p class="title-icon active">有料サービス<span class="open_toggle"></span></p>
                      </td>
                    </tr>
                  </thead>
                  <tbody class="accordion-wrap" style="display: none;">
                    <tr>
                      <td colspan="2">
                        <ul class="icheck-primary">
                          <li>
                            <input type="checkbox" id="checkboxPrimary1" checked="">
                            <label for="checkboxPrimary1">プロジェクター設置 2000円</label>
                          </li>
                          <li>
                            <input type="checkbox" id="checkboxPrimary1" checked="">
                            <label for="checkboxPrimary1">鍵レンタル 500円</label>
                          </li>
                          <li>
                            <input type="checkbox" id="checkboxPrimary1" checked="">
                            <label for="checkboxPrimary1">領収書発行 500円</label>
                          </li>
                          <li>
                            <input type="checkbox" id="checkboxPrimary1" checked="">
                            <label for="checkboxPrimary1">DVDプレイヤー設置 2000円</label>
                          </li>
                        </ul>
                      </td>
                    </tr>
                    <tr>
                      <td class="table-active"><label for="layout">レイアウト変更</label></td>
                      <td>
                        <div class="radio-box">
                          <div class="icheck-primary">
                            <input type="radio" id="layoutChange" name="layoutChange" checked="">
                            <label for="layoutChange">あり</label>
                          </div>
                          <div class="icheck-primary">
                            <input type="radio" id="layoutChange" name="layoutChange" checked="">
                            <label for="layoutChange">なし</label>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="table-active"><label for="prelayout">レイアウト準備</label></td>
                      <td>
                        <div class="radio-box">
                          <div class="icheck-primary">
                            <input type="radio" id="prelayout" name="prelayout" checked="">
                            <label for="prelayout">あり</label>
                          </div>
                          <div class="icheck-primary">
                            <input type="radio" id="prelayout" name="prelayout" checked="">
                            <label for="prelayout">なし</label>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="table-active"><label for="postlayout">レイアウト片付</label></td>
                      <td>
                        <div class="radio-box">
                          <div class="icheck-primary">
                            <input type="radio" id="postlayout" name="postlayout" checked="">
                            <label for="postlayout">あり</label>
                          </div>
                          <div class="icheck-primary">
                            <input type="radio" id="postlayout" name="postlayout" checked="">
                            <label for="postlayout">なし</label>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="table-active"><label for="Delivery">荷物預かり/返送</label></td>
                      <td>
                        <div class="radio-box">
                          <div class="icheck-primary">
                            <input type="radio" id="Delivery" name="Delivery" checked="">
                            <label for="Delivery">あり</label>
                          </div>
                          <div class="icheck-primary">
                            <input type="radio" id="Delivery" name="Delivery" checked="">
                            <label for="Delivery">なし</label>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="table-active"><label for="preDelivery">事前に預かる荷物</label></td>
                      <td>
                        <div class="radio-box">
                          <div class="icheck-primary">
                            <input type="radio" id="preDelivery" name="preDelivery" checked="">
                            <label for="preDelivery">あり</label>
                          </div>
                          <div class="icheck-primary">
                            <input type="radio" id="preDelivery" name="preDelivery" checked="">
                            <label for="preDelivery">なし</label>
                          </div>
                        </div>
                        <div class="package-box">
                          <p>
                            <label for="packageNumber">荷物個数</label>
                          </p>
                          <div class="align-items-center d-flex"><input class="form-control" name="packageNumber"
                              type="text" id="packageNumber">個</div>
                          <p></p>
                          <p>
                            <label for="packageDate">事前荷物の到着日 午前指定のみ</label>
                            <input class="form-control" name="packageDate" type="date" id="packageDate">
                          </p>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="table-active"><label for="postDelivery">事後返送する荷物</label></td>
                      <td>
                        <div class="radio-box">
                          <div class="icheck-primary">
                            <input type="radio" id="postDelivery" name="postDelivery" checked="">
                            <label for="postDelivery">あり</label>
                          </div>
                          <div class="icheck-primary">
                            <input type="radio" id="postDelivery" name="postDelivery" checked="">
                            <label for="postDelivery">なし</label>
                          </div>
                        </div>
                        <div class="package-box">
                          <p>
                            <label for="packageNumber">荷物個数</label>
                          </p>
                          <div class="align-items-center d-flex"><input class="form-control" name="packageNumber"
                              type="text" id="packageNumber">個</div>
                          <p></p>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <table class="table table-bordered eating-table">
                  <tbody>
                    <tr>
                      <td>
                        <p class="title-icon">室内飲食</p>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="radio-box">
                          <div class="icheck-primary">
                            <input type="radio" id="eatin" name="eatin" checked="">
                            <label for="eatin">あり</label>
                          </div>
                          <div class="icheck-primary">
                            <input type="radio" id="eatin" name="eatin" checked="">
                            <label for="eatin">手配済</label>
                          </div>
                          <div class="icheck-primary">
                            <input type="radio" id="eatin" name="eatin" checked="">
                            <label for="eatin">検討中</label>
                          </div>
                          <div class="icheck-primary">
                            <input type="radio" id="eatin" name="eatin" checked="">
                            <label for="eatin">なし</label>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- 左側の項目 終わり-------------------------------------------------- -->
              <!-- 右側の項目-------------------------------------------------- -->
              <div class="col">
                <div class="customer-table">
                  <table class="table table-bordered oneday-table">
                    <tbody>
                      <tr>
                        <td colspan="2">
                          <p class="title-icon">
                            <i class="fas fa-user icon-size" aria-hidden="true"></i>
                            当日の連絡できる担当者
                          </p>
                        </td>
                      </tr>
                      <tr>
                        <td class="table-active"><label for="ondayName">氏名</label></td>
                        <td><input class="form-control" name="ondayName" type="text" id="ondayName"></td>
                      </tr>
                      <tr>
                        <td class="table-active"><label for="mobilePhone">携帯番号</label></td>
                        <td><input class="form-control" name="mobilePhone" type="text" id="mobilePhone"></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <table class="table table-bordered mail-table">
                  <tbody>
                    <tr>
                      <td colspan="2">
                        <p class="title-icon">
                          <i class="fas fa-envelope icon-size" aria-hidden="true"></i>
                          利用後の送信メール
                        </p>
                      </td>
                    </tr>
                    <tr>
                      <td class="table-active"><label for="sendMail">送信メール</label></td>
                      <td>
                        <div class="radio-box">
                          <div class="icheck-primary">
                            <input type="radio" id="sendMail" name="sendMail" checked="">
                            <label for="sendMail">あり</label>
                          </div>
                          <div class="icheck-primary">
                            <input type="radio" id="sendMail" name="sendMail" checked="">
                            <label for="sendMail">なし</label>
                          </div>
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
                          <i class="fas fa-yen-sign icon-size" aria-hidden="true"></i>
                          売上原価
                        </p>
                      </td>
                    </tr>
                    <tr>
                      <td class="table-active"><label for="sale">原価率</label></td>
                      <td class="d-flex align-items-center"><input class="form-control" name="sale" type="text"
                          id="sale">%</td>
                    </tr>
                  </tbody>
                </table>
                <table class="table table-bordered note-table">
                  <tbody>
                    <tr>
                      <td colspan="2">
                        <p class="title-icon">
                          <i class="fas fa-file-alt icon-size" aria-hidden="true"></i>
                          備考
                        </p>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <p>
                          <input type="checkbox" id="discount" checked="">
                          <label for="discount">割引条件</label>
                        </p>
                        <textarea name="discount" rows="5"></textarea>
                      </td>
                    </tr>
                    <tr class="caution">
                      <td>
                        <label for="caution">注意事項</label>
                        <textarea name="caution" rows="10"></textarea>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label for="adminNote">管理者備考</label>
                        <textarea name="adminNote" rows="10"></textarea>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- 右側の項目 終わり-------------------------------------------------- -->
            </div>
            <div class="btn_wrapper">
              <p class="text-center"><a class="more_btn_lg" href="">請求に反映する</a></p>
            </div>
            <!-- 請求セクション------------------------------------------------------------------- -->
            <section class="bill-wrap section-wrap">
              <div class="bill-bg">
                <!-- 会場料請求内容----------- -->
                <div class="bill-box">
                  <h3 class="row">会場料</h3>
                  <dl class="row bill-box_wrap">
                    <div class="col-3 bill-box_cell">
                      <dt>会場料金</dt>
                      <dd>52,400円</dd>
                    </div>
                    <div class="col-3 bill-box_cell">
                      <dt>延長料金</dt>
                      <dd>5,300円</dd>
                    </div>
                    <div class="col-6 bill-box_cell">
                      <dt>会場料金合計</dt>
                      <dd class="text-right">57,700円</dd>
                    </div>
                    <div class="col-6">
                      <div class="row">
                        <div class="col-4 bill-box_cell cell-gray">
                          <p>割引率</p>
                        </div>
                        <div class="col-5 bill-box_cell">
                          <p class="text-right"><input type="text" class=""></p>
                        </div>
                        <div class="col-3 bill-box_cell text-right">
                          <p>割引金額</p>
                          <p class=""><span>円</span></p>
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="row">
                        <div class="col-4 bill-box_cell cell-gray">
                          <p>割引料金</p>
                        </div>
                        <div class="col-5 bill-box_cell">
                          <p class="text-right"><input type="text" class=""></p>
                        </div>
                        <div class="col-3 bill-box_cell text-right">
                          <p>割引率</p>
                          <p class=""><span>%</span></p>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 bill-box_cell text-right">
                      <p class="font-weight-bold">割引後会場料金合計</p>
                      <p class=""></p>
                    </div>
                  </dl>
                  <!-- 料金内訳-------------------------------------------------------------- -->
                  <div class="bill-list">
                    <h3 class="row">料金内訳</h3>
                    <div class="col-12 venue_price_details">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <td>内容</td>
                            <td>単価</td>
                            <td>数量</td>
                            <td>金額</td>
                          </tr>
                        </thead>
                        <tbody></tbody>
                      </table>
                    </div>
                    <div class="row bill-box_wrap price-sum bill-box_cell flex-column">
                      <p class="text-right"><span class="font-weight-bold">小計</span>7,200円</p>
                      <p class="text-right"><span>消費税</span>720円</p>
                      <p class="text-right"><span class="font-weight-bold">合計金額</span>7,200円</p>
                    </div>
                  </div>
                  <!-- 料金内訳 終わり---------------------------- -->
                </div>
                <!-- 請求内容 終わり---------------------------- -->
                <!-- 備品その他　請求内容----------- -->
                <div class="bill-box">
                  <h3 class="row">備品その他</h3>
                  <dl class="row bill-box_wrap">
                    <div class="col-3 bill-box_cell">
                      <dt>有料備品料金</dt>
                      <dd>52,400円</dd>
                    </div>
                    <div class="col-3 bill-box_cell">
                      <dt>有料サービス料金</dt>
                      <dd>5,300円</dd>
                    </div>
                    <div class="col-3 bill-box_cell">
                      <dt>荷物預かり/返送</dt>
                      <dd class="d-flex align-items-center"><input class="form-control mr-3" name="package"
                          type="text">円
                      </dd>
                    </div>
                    <div class="col-3 bill-box_cell">
                      <dt>備品その他合計</dt>
                      <dd class="text-right">57,700円</dd>
                    </div>
                    <div class="col-6">
                      <div class="row">
                        <div class="col-4 bill-box_cell cell-gray">
                          <p>割引料金</p>
                        </div>
                        <div class="col-5 bill-box_cell">
                          <p class="text-right"><input type="text" name="price" class="form-control" id="price">
                          </p>
                        </div>
                        <div class="col-3 bill-box_cell text-right">
                          <p>割引率</p>
                          <p class=""><span>%</span></p>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 bill-box_cell text-right">
                      <p class="font-weight-bold">割引後備品その他合計</p>
                      <p class=""></p>
                    </div>
                  </dl>
                  <!-- 料金内訳-------------------------------------------------------------- -->
                  <div class="bill-list">
                    <h3 class="row">料金内訳</h3>
                    <div class="col-12 items_equipments">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <td>内容</td>
                            <td>単価</td>
                            <td>数量</td>
                            <td>金額</td>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                    <div class="row bill-box_wrap price-sum bill-box_cell flex-column">
                      <p class="text-right"><span class="font-weight-bold">小計</span>7,200円</p>
                      <p class="text-right"><span>消費税</span>720円</p>
                      <p class="text-right"><span class="font-weight-bold">合計金額</span>7,200円</p>
                    </div>
                  </div>
                  <!-- 料金内訳 終わり---------------------------- -->
                </div>
                <!-- 請求内容 終わり---------------------------- -->
                <!-- レイアウト変更 請求内容----------- -->
                <div class="bill-box layout_price_list">
                  <h3 class="row">レイアウト変更</h3>
                  <dl class="row bill-box_wrap">
                    <div class="col-4 bill-box_cell">
                      <dt>レイアウト準備料金</dt>
                      <dd>
                        <p class="layout_prepare_result"></p>
                      </dd>
                    </div>
                    <div class="col-4 bill-box_cell">
                      <dt>レイアウト片付料金</dt>
                      <dd>
                        <p class="layout_clean_result"></p>
                      </dd>
                    </div>
                    <div class="col-4 bill-box_cell">
                      <dt>レイアウト変更合計</dt>
                      <dd class="text-right">
                        <p class="layout_total"></p>
                      </dd>
                    </div>
                    <div class="col-6">
                      <div class="row">
                        <div class="col-4 bill-box_cell cell-gray">
                          <p>割引料金</p>
                        </div>
                        <div class="col-5 bill-box_cell">
                          <p class="text-right"><input type="text" class="layout_discount d-block"></p>
                        </div>
                        <div class="col-3 bill-box_cell text-right">
                          <p>割引率</p>
                          <p class="layout_discount_percent"><span>%</span></p>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 bill-box_cell text-right">
                      <p class="font-weight-bold">割引後レイアウト変更合計</p>
                      <p class="after_duscount_layouts"></p>
                    </div>
                  </dl>
                  <!-- 料金内訳-------------------------------------------------------------- -->
                  <div class="bill-list">
                    <h3 class="row">料金内訳</h3>
                    <div class="col-12 items_equipments">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <td>内容</td>
                            <td>単価</td>
                            <td>数量</td>
                            <td>金額</td>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                    <div class="row bill-box_wrap price-sum bill-box_cell flex-column">
                      <p class="text-right"><span class="font-weight-bold">小計</span>7,200円</p>
                      <p class="text-right"><span>消費税</span>720円</p>
                      <p class="text-right"><span class="font-weight-bold">合計金額</span>7,200円</p>
                    </div>
                  </div>
                  <!-- 料金内訳 終わり---------------------------- -->
                </div>
                <!-- 請求内容 終わり---------------------------- -->
              </div>
            </section>
            <div class="section-wrap">
              <table class="table table-bordered">
                <thead>
                  <tr class="bg-green">
                    <td colspan="2">
                      <p>合計請求額</p>
                    </td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="table-active"><label for="venueFee">会場料</label></td>
                    <td class="text-right">
                      5,300円
                    </td>
                  </tr>
                  <tr>
                    <td class="table-active"><label for="serviceFee">備品その他</label></td>
                    <td class="text-right">
                      5,300円
                    </td>
                  </tr>
                  <tr>
                    <td class="table-active"><label for="layoutFee">レイアウト変更</label></td>
                    <td class="text-right">
                      5,300円
                    </td>
                  </tr>
                  <tr>
                    <td class="table-active"><label for="layoutFee">キャンセル料</label></td>
                    <td class="text-right">
                      5,300円
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2" class="text-right">
                      <p><span class="font-weight-bold">小計</span>7,200円</p>
                      <p><span>消費税</span>720円</p>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2" class="text-right"><span class="font-weight-bold">請求総額</span>7,200円</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </dt>
          <!-- /.card-body -->
        </dl>
        <!-- /.card -->
      </div>
      <!-- 仮押さえ一括 タブ終わり-->
    </section>

    <!-- コピー作成用フィールド ------------------------------------------------------------->

    <!-- 詳細選択画面--終わり------------------------------------------------　 -->

    <div class="col-12 mt-5">
      <div class="d-flex bg-green py-2 px-1">
        <h4>合計請求額</h4>
        <p class="ml-2">(<span>3</span>件分)</p>
      </div>
      <table class="table table-bordered">
        <tbody>
          <tr>
            <td class="table-active"><label for="venueFee">会場料</label></td>
            <td class="text-right">
              5,300円
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="serviceFee">備品その他</label></td>
            <td class="text-right">
              5,300円
            </td>
          </tr>
          <tr>
            <td class="table-active"><label for="layoutFee">レイアウト変更</label></td>
            <td class="text-right">
              5,300円
            </td>
          </tr>
          <tr>
            <td colspan="2" class="text-right">
              <p><span class="font-weight-bold">小計</span>7,200円</p>
              <p><span>消費税</span>720円</p>
            </td>
          </tr>
          <tr>
            <td colspan="2" class="text-right"><span class="font-weight-bold">請求総額</span>7,200円</td>
          </tr>
        </tbody>
      </table>
    </div>

    <ul class="d-flex col-12 justify-content-around mt-5">
      <li>
        <p><a class="more_btn_lg" href="">詳細にもどる</a></p>
      </li>
      <li>
        <p><a class="more_btn_lg" href="">更新する</a></p>
      </li>
    </ul>
  </div>
</div>


@endsection