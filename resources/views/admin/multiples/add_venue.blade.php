@extends('layouts.admin.app')

@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>
<script src="{{ asset('/js/multiples/calculate.js') }}"></script>
<div class="content">
            <div class="container-fluid">
              <div class="container-field mt-3">
                <div class="float-right">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item active">ダミーダミーダミー
                      </li>
                    </ol>
                  </nav>
                </div>
                <h2 class="mt-3 mb-3">一括仮押さえ　新しい会場の追加</h2>
                <hr>
              </div>

              <!-- 工藤さん！！！！ここから追加分コーディングデータです。 ----------------------------------->
              <section class="section-wrap">
                <table class="table ttl_head mb-0">
                    <tbody>
                      <tr>
                        <td>
                          <h2 class="text-white">
                            仮押さえ概要
                          </h2>
                        </td>
                        <td>
                          <dl class="ttl_box">
                            <dt>仮押さえ一括ID:</dt>
                            <dd class="total_result">2</dd>
                          </dl>
                        </td>
                    </tbody>
                  </table>
                <div class="border-inwrap">
                      <table class="table table-bordered customer-table mb-3" style="table-layout: fixed;">
                        <tbody>
                          <tr>
                            <td colspan="4">
                              <div class="d-flex align-items-center justify-content-between">
                                <p class="title-icon">
                                  <i class="far fa-address-card icon-size" aria-hidden="true"></i>
                                  顧客情報
                                </p>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <th class="table-active" width="25%"><label for="company">会社名・団体名</label></th>
                            <td>
                              トリックスター
                            </td>
                            <td class="table-active"><label for="name">担当者氏名</label></td>
                            <td>
                              大山紘一郎
                            </td>
                          </tr>
                          <tr>
                            <td class="table-active" scope="row"><label for="email">担当者メールアドレス</label></td>
                            <td>
                              ooyama@web-trickster.com
                            </td>
                            <td class="table-active" scope="row"><label for="mobile">携帯番号</label></td>
                            <td>
  
                            </td>
                          </tr>
                          <tr>
                            <td class="table-active" scope="row"><label for="tel">固定電話</label>
                            </td>
                            <td>
  
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <table class="table table-bordered oneday-customer-table" style="table-layout: fixed;">
                        <tbody>
                          <tr>
                            <td colspan="4">
                              <p class="title-icon">
                                <i class="fas fa-user icon-size" aria-hidden="true"></i>
                                顧客情報(顧客登録がされていない場合)
                              </p>
                            </td>
                          </tr>
                          <tr>
                            <td class="table-active" width="25%"><label for="onedayCompany">会社名・団体名</label></td>
                            <td>
                            </td>
                            <td class="table-active"><label for="onedayName">担当者氏名</label></td>
                            <td>
                            </td>
                          </tr>
                          <tr>
                            <td class="table-active" scope="row"><label for="onedayEmail">担当者メールアドレス</label></td>
                            <td>
                            </td>
                            <td class="table-active" scope="row"><label for="onedayMobile">携帯番号</label></td>
                            <td>
                            </td>
                          </tr>
                          <tr>
                            <td class="table-active" scope="row"><label for="onedayTel">固定電話</label></td>
                            <td>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <table class="table table-bordered mt-5">
                        <thead>
                          <tr class="table_row">
                            <th>一括仮押さえID</th>
                            <th>作成日</th>
                            <th>利用会場</th>
                            <th>総件数</th>
                            <th>件数</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td rowspan="1">1</td>
                            <td rowspan="1">2021/03/05(金)</td>
                            <td>四ツ橋サンワールドビル1号室</td>
                            <td rowspan="1">
                              2
                            </td>
                            <td>
                              2
                            </td>
                          </tr>
                        </tbody>
  
                      </table>
  
                  </div>


                <div class="calendar mt-5">
                  <iframe src="{{url('admin/calendar/date_calendar')}}" width="100%" height="500">Your browser isn't
                    compatible</iframe>
                </div>
                <div class="date_selector mt-5">
                  <h3 class="mb-2 pt-3">日程選択</h3>
                  <table class="table table-bordered" style="table-layout: fixed;">
                    <thead>
                      <tr>
                        <td>日付</td>
                        <td>会場名</td>
                        <td>入室時間</td>
                        <td>退室時間</td>
                        <td>追加・削除</td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><input class="form-control" id="pre_datepicker" name="pre_date0" type="text" value=""></td>
                        <td>
                            <select name="pre_venue0" id="pre_venue" class="form-control">
                                <option value="1">登録済みの会場以外</option>
                                <option value="2">四ツ橋サンワールドビル2号室(音響HG)</option>
                                <option value="3">トリックスターWe Work執務室</option>
                              </select>
                        </td>
                        <td>
                          <select name="pre_enter0" id="pre_enter0" class="form-control">
                            <option value="">08:00</option>
                            <!-- @for ($start = 0*2; $start <=23*2; $start++) <option value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}">
                            {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}} -->
                            </option>
                            <!-- @endfor -->
                          </select>
                        </td>
                        <td>
                          <select name="pre_leave0" id="pre_leave0" class="form-control">
                            <option value="">08:00</option>
                            <!-- @for ($start = 0*2; $start <=23*2; $start++) <option value="{{date("H:i:s", strtotime("00:00 +". $start * 30 ." minute"))}}">
                            {{date("H時i分", strtotime("00:00 +". $start * 30 ." minute"))}} -->
                            </option>
                            <!-- @endfor -->
                          </select>
                        </td>
                        <td>
                          <input type="button" value="＋" class="add pluralBtn">
                          <input type="button" value="ー" class="del pluralBtn">
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <div class="submit_btn mt-5">
                  <input class="btn more_btn_lg mx-auto d-block" id="check_submit" type="submit" value="会場を追加する">
                </div>

                <div class="spin_btn hide">
                  <div class="d-flex justify-content-center">
                    <button class="btn btn-primary btn-lg" type="button" disabled>
                      <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                      Loading...
                    </button>
                  </div>
                </div>
              </section>
            </div>
          </div>




@endsection