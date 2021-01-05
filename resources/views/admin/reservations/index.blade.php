@extends('layouts.admin.app')

@section('content')


<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>


<div class="content">
  <div class="container-fluid">

    <script src="http://staging-smg2.herokuapp.com/js/template.js"></script>
    <link href="http://staging-smg2.herokuapp.com/css/template.css" rel="stylesheet">


    <div class="container-field mt-3">
      <div class="float-right">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="http://staging-smg2.herokuapp.com/admin/home">ホーム</a> >
              予約一覧
            </li>
          </ol>
        </nav>
      </div>
      <h1 class="mt-3 mb-5">予約一覧</h1>
      <hr>
    </div>

    <!-- 検索--------------------------------------- -->

    <div class="container-field">
      <div class="row search_box">
        <div class="col-md-10 offset-md-1">
          <div class="d-flex col-12 pd0">
            <dl class="form-group flex-fill">
              <dt>
                <label class="search_item_name" for="bulkid">予約一括ID</label>
              </dt>
              <dd>
                <input type="text" name="bulkid" class="form-control" id="bulkid">
              </dd>
            </dl>

            <dl class="form-group flex-fill">
              <dt>
                <label class="search_item_name" for="id">予約ID</label>
              </dt>
              <dd>
                <input type="text" name="id" class="form-control" id="id">
              </dd>
            </dl>
          </div>

          <div class="row">
            <div class="col-12">

              <!-- Date range -->
              <dl class="form-group">
                <dt>
                  <label class="search_item_name">利用日</label>
                </dt>
                <dd>
                  <div class="input-group">
                    <input type="text" class="form-control float-right" id="reservation">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                    </div>
                  </div>
                </dd>
                <!-- /.input group -->
              </dl>
              <!-- /.form group -->

              <dl class="form-group">
                <dt>
                  <label class="search_item_name">入室・退室</label>
                </dt>
                <dd class="d-flex align-items-center">
                  <div class="flex-fill">
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
                  </div>
                  <p style="margin: 0 20px;">～</p>
                  <div class="flex-fill">
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
                  </div>
                </dd>
              </dl>

              <dl class="form-group">
                <dt>
                  <label class="search_item_name" for="venue">利用会場</label>
                </dt>
                <dd>
                  <select class="form-control select2" style="width: 100%;" name="venue">
                    <option>テスト会場A</option>
                    <option>テスト会場B</option>
                    <option>テスト会場C</option>
                  </select>
                </dd>
              </dl>
              <dl class="form-group">
                <dt>
                  <label class="search_item_name" for="company">会社名・団体名</label>
                </dt>
                <dd>
                  <select class="form-control select2" style="width: 100%;" name="company">
                    <option>テスト会場A</option>
                    <option>テスト会場B</option>
                    <option>テスト会場C</option>
                  </select>
                </dd>
              </dl>
              <dl class="form-group">
                <dt>
                  <label class="search_item_name" for="name">担当者氏名</label>
                </dt>
                <dd>
                  <input type="text" name="name" class="form-control" id="name">
                </dd>
              </dl>
              <dl class="form-group">
                <dt>
                  <label class="search_item_name" for="category">カテゴリー</label>
                </dt>
                <dd>
                  <ul class="form-control icheck-primary d-flex d-flex justify-content-around">
                    <li>
                      <input type="checkbox" id="checkboxPrimary1" checked>
                      <label for="checkboxPrimary1">会場</label>
                    </li>
                    <li>
                      <input type="checkbox" id="checkboxPrimary1" checked>
                      <label for="checkboxPrimary1">キャンセル</label>
                    </li>
                    <!-- <li>
                    <input type="checkbox" id="checkboxPrimary1" checked>
                    <label for="checkboxPrimary1">追加請求</label>
                  </li> -->
                    <li>
                      <input type="checkbox" id="checkboxPrimary1" checked>
                      <label for="checkboxPrimary1">追加請求</label>
                    </li>
                  </ul>
                </dd>
              </dl>
              <dl class="form-group">
                <dt>
                  <label class="search_item_name" for="status">予約状況</label>
                </dt>
                <dd>
                  <select class="form-control select2" style="width: 100%;" name="status">
                    <option>予約確認中</option>
                    <option>予約承認待ち</option>
                    <option>予約完了</option>
                  </select>
                </dd>
              </dl>
              <dl class="form-group">
                <dt>
                  <label class="search_item_name" for="freeword">フリーワード検索</label>
                </dt>
                <dd>
                  <input type="text" name="freeword" class="form-control" id="freeword">
                </dd>
              </dl>

            </div>
          </div>
          <p class="text-right">※フリーワード検索は本画面表記の項目のみ対象となります</p>


        </div>


        <div class="btn_box d-flex justify-content-center">
          <input type="reset" value="リセット" class="btn reset_btn">
          <input type="submit" value="検索" class="btn search_btn">
        </div>
      </div>

    </div>

    <!-- 検索　終わり------------------------------------------------ -->

    <ul class="d-flex reservation_list">
      <li><a class="more_btn" href="">前日予約</a></li>
      <li><a class="more_btn" href="">当日予約</a></li>
      <li><a class="more_btn" href="">翌日予約</a></li>
      <li><a class="more_btn bg-red" href="">予約確認中</a></li>
      <li><a class="more_btn bg-red" href="">予約承認待ち</a></li>
      <li><a class="more_btn bg-green" href="">キャンセル申請中</a></li>
      <li><a class="more_btn bg-black" href="">予約完了</a></li>
    </ul>
    <div class="col-12">
      <p class="text-right font-weight-bold"><span>10</span>件</p>
    </div>


    <div class="container-field">
      <table class="table table-striped table-bordered table-box">
        <thead>
          <tr>
            <th>予約一括<br>ID</th>
            <th>ID</th>
            <th>利用日</th>
            <th>入室</th>
            <th>退室</th>
            <th>利用会場</th>
            <th>会社名<br>団体名</th>
            <th>担当者氏名</th>
            <th>携帯電話</th>
            <th>固定電話</th>
            <th>仲介会社</th>
            <th width="120">カテゴリー</th>
            <th width="120">予約状況</th>
            <th class="btn-cell">予約<br>詳細</th>
            <th class="btn-cell">案内板</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>00000</td>
            <td>00000</td>
            <td>2020/12/07(月)</td>
            <td>9:00</td>
            <td>18:00</td>
            <td>四ツ橋・サンワールドビル22号室</td>
            <td>株式会社テスト</td>
            <td>山田元気</td>
            <td>08012345678</td>
            <td>0612345678</td>
            <td>-</td>
            <td class="table_column1">
              <p>会場</p>
            </td>
            <td class="table_column1">
              <p>予約確認中</p>
            </td>
            <td><a class="more_btn" href="http://staging-smg2.herokuapp.com/admin/venues/1">詳細</a></td>
            <td><a class="more_btn" href="http://staging-smg2.herokuapp.com/admin/venues/1">詳細</a></td>
          </tr>
          <tr>
            <td>1</td>
            <td>1</td>
            <td>2020/12/07(月)</td>
            <td>9:00</td>
            <td>18:00</td>
            <td>四ツ橋・サンワールドビル22号室</td>
            <td>株式会社テスト</td>
            <td>山田元気</td>
            <td>08012345678</td>
            <td>0612345678</td>
            <td>-</td>
            <td class="table_column">
              <p>会場</p>
              <p>追加請求</p>
            </td>
            <td class="table_column">
              <p>予約確認中</p>
              <p>予約確認中</p>
            </td>
            <td><a class="more_btn" href="http://staging-smg2.herokuapp.com/admin/venues/1">詳細</a></td>
            <td><a class="more_btn" href="http://staging-smg2.herokuapp.com/admin/venues/1">詳細</a></td>
          </tr>
          <tr>
            <td>1</td>
            <td>1</td>
            <td>2020/12/07(月)</td>
            <td>9:00</td>
            <td>18:00</td>
            <td>四ツ橋・サンワールドビル22号室</td>
            <td>株式会社テスト</td>
            <td>山田元気</td>
            <td>08012345678</td>
            <td>0612345678</td>
            <td>-</td>
            <td class="table_column">
              <p>会場</p>
              <p>追加請求</p>
              <p>キャンセル</p>
            </td>
            <td class="table_column">
              <p>予約確認中</p>
              <p>予約確認中</p>
              <p>予約確認中</p>
            </td>
            <td><a class="more_btn" href="http://staging-smg2.herokuapp.com/admin/venues/1">詳細</a></td>
            <td><a class="more_btn" href="http://staging-smg2.herokuapp.com/admin/venues/1">詳細</a></td>
          </tr>
          <tr class="bg-alert">
            <td>1</td>
            <td>1</td>
            <td>2020/12/07(月)</td>
            <td>9:00</td>
            <td>18:00</td>
            <td>四ツ橋・サンワールドビル22号室</td>
            <td>株式会社テスト</td>
            <td>山田元気</td>
            <td>08012345678</td>
            <td>0612345678</td>
            <td>-</td>
            <td class="table_column">
              <p>会場</p>
              <p>追加請求</p>
              <p>追加請求請求</p>
              <p>キャンセル</p>
            </td>
            <td class="table_column">
              <p>予約確認中</p>
              <p>予約確認中</p>
              <p>予約確認中</p>
              <p>予約確認中</p>
            </td>
            <td><a class="more_btn" href="http://staging-smg2.herokuapp.com/admin/venues/1">詳細</a></td>
            <td><a class="more_btn" href="http://staging-smg2.herokuapp.com/admin/venues/1">詳細</a></td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>

  <ul class="pagination justify-content-center">
    <li class="page-item disabled" aria-disabled="true" aria-label="&laquo; 前">
      <span class="page-link" aria-hidden="true">&lsaquo;</span>
    </li>
    <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
    <li class="page-item"><a class="page-link" href="">2</a>
    </li>
    <li class="page-item"><a class="page-link" href="">3</a>
    </li>
    <li class="page-item">
      <a class="page-link" href="http://staging-smg2.herokuapp.com/admin/clients?page=2" rel="next"
        aria-label="次 &raquo">&rsaquo;</a>
    </li>
  </ul>


</div>









@endsection