<?php

Route::get('/', function () {
  return view('index');
});

// 一般ユーザー用カレンダー
Route::get('calender/date_calendar', 'CalendarsController@index');
Route::get('calender/venue_calendar', 'CalendarsController@venue_calendar');

/*
|--------------------------------------------------------------------------
| ユーザー用ルート
|--------------------------------------------------------------------------|
*/
Route::namespace('User')->prefix('user')->name('user.')->group(function () {

  // ログイン認証後
  Route::middleware('verified')->group(function () {
    // TOPページ
    Route::resource('home', 'HomeController');
    Route::put('home/{home}/update_status', 'HomeController@updateStatus')->name('home.updatestatus');
    Route::get('home/generate_invoice/{home}', 'HomeController@generate_invoice')->name('home.generate_invoice');
    Route::put('home/{home}/update_other_bills', 'HomeController@updateOtherBillsStatus');
  });

  // メール入力フォーム
  Route::get('preusers', 'PreusersController@index')->name('preusers');
  // メール作成
  Route::post('preusers/create', 'PreusersController@create')->name('preusers.create');
  // メール送信
  Route::get('preusers/sendmail', 'PreusersController@sendmail')->name('preusers.sendmail');
  // メール認証
  Route::get('preusers/{id}/{token}', 'PreusersController@show');
  // メール送信完了画面
  Route::get('preusers/complete', 'PreusersController@complete')->name('preusers.complete');

  Auth::routes(['register' => false, 'confirm'  => true, 'reset'    => true,]);
  Route::get('preusers/register', 'Auth\RegisterController@showRegistrationForm')->name('register')->middleware('check_status');
  Route::post('preusers/register', 'Auth\RegisterController@register')->name('preusers.show');
  // Route::get('/home', 'HomeController@index')->name('home');
  // Route::resource('home', 'HomeController');
  // Route::put('home/{home}/update_status', 'HomeController@updateReservationStatus')->name('home.updatestatus');
});


/*
|--------------------------------------------------------------------------
| 管理者用ルート
|--------------------------------------------------------------------------|
*/
Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {
  // ログイン認証関連
  Auth::routes([
    'register' => true,
    'confirm'  => false,
    'reset'    => false
  ]);
  // ログイン認証後
  Route::middleware('auth:admin')->group(function () {
    // TOPページ
    Route::resource('home', 'HomeController', ['only' => 'index']);
    // 会場登録
    Route::resource('venues', 'VenuesController');
    // 備品登録
    Route::resource('equipments', 'EquipmentsController');
    // サービス登録
    Route::resource('services', 'ServicesController');
    // 営業日登録
    Route::resource('dates', 'DatesController');
    // 枠貸し料金登録
    Route::resource('frame_prices', 'Freme_pricesController')->except(['create']);
    Route::get('frame_prices/create/{frame_price}', 'Freme_pricesController@create')->name('frame_prices.create');
    // 時間貸し料金登録
    Route::resource('time_prices', 'Time_pricesController')->except(['create']);
    Route::get('time_prices/create/{time_price}', 'Time_pricesController@create')->name('time_prices.create');
    // 紹介会社
    Route::resource('agents', 'AgentsController');
    // 管理者側からUser登録
    Route::resource('clients', 'ClientsController');
    // 予約
    Route::resource('reservations', 'ReservationsController');
    // 予約　計算
    Route::post('reservations/calculate', 'ReservationsController@calculate')->name('reservations.calculate');
    // 予約再計算
    Route::post('reservations/recalculate', 'ReservationsController@recalculate')->name('reservations.recalculate');


    // 予約　（確認）
    Route::post('reservations/check', 'ReservationsController@check')->name('reservations.check');
    // ajax アイテム
    Route::post('reservations/geteitems', 'ReservationsController@geteitems');
    // ajax 料金体系
    Route::post('reservations/getpricesystem', 'ReservationsController@getpricesystem');
    // ajax 営業時間
    Route::post('reservations/getsaleshours', 'ReservationsController@getsaleshours');
    // ajax 料金詳細所得
    Route::post('reservations/getpricedetails', 'ReservationsController@getpricedetails');
    // ajax 備品＆サービス　料金取得
    Route::post('reservations/geteitemsprices', 'ReservationsController@geteitemsprices');
    // ajax レイアウト取得
    Route::post('reservations/getlayout', 'ReservationsController@getlayout');
    // ajax レイアウト金額取得
    Route::post('reservations/getlayoutprice', 'ReservationsController@getlayoutprice');
    // ajax 荷物有り、無し　判別
    Route::post('reservations/getluggage', 'ReservationsController@getluggage');
    // ajax 会場　直営 or 提携　判別
    Route::post('reservations/getoperation', 'ReservationsController@getoperation');
    // ajax 会場　直営 or 提携　判別
    Route::post('clients/getclients', 'ClientsController@getclients');
    //予約に対するダブルチェック
    Route::post('reservations/{reservation}/double_check', 'ReservationsController@double_check')->name('reservations.double_check');

    Route::get('reservations/generate_pdf/{reservation}', 'ReservationsController@generate_pdf')->name('reservations.generate_pdf');
    // Bill　予約に紐づく
    Route::resource('bills', 'BillsController');
    // Breakdown　Billに紐づく
    Route::resource('breakdowns', 'BreakdownsController');

    Route::post('reservations/{reservation}/send_email_and_approve', 'ReservationsController@send_email_and_approve')->name('reservations.send_email_and_approve');

    Route::post('reservations/{reservation}/confirm_reservation', 'ReservationsController@confirm_reservation')->name('reservations.confirm_reservation');

    // 管理者用カレンダーページ
    // 会場別
    Route::get('calendar/venue_calendar', 'CalendarsController@venue_calendar');
    Route::post('calendar/venue_calendar', 'CalendarsController@venue_calendargetData');
    // 日時別
    Route::get('calendar/date_calendar', 'CalendarsController@date_calendar');

    // 請求書追加
    // Route::post('reservations/{reservation}/add_bill', 'ReservationsController@add_bill')->name('reservations.add_bill');

    // 追加請求書新規作成
    Route::post('bills/create/{reservation}', 'BillsController@create');
    // // ajax 予約　請求書　追加
    Route::post('bills/ajaxaddbillsequipments', 'BillsController@ajaxaddbillsequipments');
    // // ajax 予約　請求書　追加　レイアウト取得
    Route::post('bills/ajaxaddbillslaytout', 'BillsController@ajaxaddbillslaytout');
    // // 管理者請求書作成　確認画面
    Route::post('bills/check/{reservation}', 'BillsController@check');
    // // 管理者請求書作成　保存
    // Route::post('bills/store', 'BillsController@store');

    Route::post('bills/other_doublecheck', 'BillsController@OtherDoubleCheck');

    Route::post('bills/other_send_approve', 'BillsController@other_send_approve');
    // 仲介会社経由予約
    Route::get('agents_reservations/create', 'AgentsReservationsController@create');
    // 仲介会社経由　計算
    Route::post('agents_reservations/calculate', 'AgentsReservationsController@calculate');
    // 仲介会社経由　確認
    Route::post('agents_reservations/check', 'AgentsReservationsController@check');
    // 仲介会社経由　保存
    Route::post('agents_reservations', 'AgentsReservationsController@store');
    // 仲介会社経由　再計算
    Route::post('agents_reservations/recalculate', 'AgentsReservationsController@recalculate')->name('agents_reservations.recalculate');
    // 仲介会社　請求　追加
    Route::post('agents_reservations/add_bills/{reservation}', 'AgentsReservationsController@add_bills')->name('agents_reservations.add_bills');
    // 仲介会社　追加請求　確認
    Route::post('agents_reservations/add_bills/check/{reservation}', 'AgentsReservationsController@add_check')->name('agents_reservations.add_check');
    // 仲介会社　追加請求　保存
    Route::post('agents_reservations/add_bills/store/{reservation}', 'AgentsReservationsController@add_store')->name('agents_reservations.add_store');
    // 仲介会社　メールなしで予約確定ボタン
    Route::post('agents_reservations/confirm', 'AgentsReservationsController@add_confirm')->name('agents_reservations.add_confirm');
    // 仮抑え
    Route::resource('pre_reservations', 'PreReservationsController');
    // 仮押さえ ajax 顧客情報取得
    Route::post('pre_reservations/getuser', 'PreReservationsController@getuser');
    // 仮抑え　新規登録　確認
    Route::post('pre_reservations/check', 'PreReservationsController@check');
  });
});
