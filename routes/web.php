<?php


Route::get('/', 'Home\HomeController@index')->name('home');
Route::namespace('Home')->prefix('/')->name('home.')->group(function () {
  Route::post('slct_date', 'HomeController@slct_date')->name('home.slct_date');
  Route::post('slct_venue', 'HomeController@slct_venue')->name('home.slct_venue');
});



// 一般ユーザー用カレンダー
// Route::get('calender/date_calendar', 'CalendarsController@date_calendar');
Route::get('calender/venue_calendar', 'CalendarsController@venue_calendar');

/*
|--------------------------------------------------------------------------
| ユーザー用ルート
|--------------------------------------------------------------------------|
*/
Route::namespace('User')->prefix('user')->name('user.')->group(function () {

  Auth::routes(['register' => true, 'confirm' => true, 'reset' => true,]);

  // Route::middleware('verified')->group(function () {  
  //verfified一旦停止
  Route::middleware('auth')->group(function () {
    Route::resource('home', 'HomeController');
    Route::put('home/{home}/update_status', 'HomeController@updateStatus')->name('home.updatestatus');
    Route::get('home/generate_invoice/{home}', 'HomeController@generate_invoice')->name('home.generate_invoice');
    Route::put('home/{home}/update_other_bills', 'HomeController@updateOtherBillsStatus');
    Route::get('pre_reservations', 'PreReservationsController@index')->name('per_reservations.index');

    // 以下、ユーザーからの予約経路
    // 例外でgetリクエスト
    Route::get('reservations/create', 'ReservationsController@create');
    Route::post('reservations/check', 'ReservationsController@check');
    Route::post('reservations/store_session', 'ReservationsController@storeSession');

    // 以下、テスト
    Route::post('reservations/test', 'ReservationsController@test');
    Route::get('reservations/test2', 'ReservationsController@test2');
  });


  // メール入力フォーム
  Route::get('preusers', 'PreusersController@index')->name('preusers');
  // メール作成
  Route::post('preusers/create', 'PreusersController@create')->name('preusers.create');
  // メール送信
  Route::get('preusers/sendmail', 'PreusersController@sendmail')->name('preusers.sendmail');
  // メール認証
  Route::get('preusers/{id}/{token}/{email}', 'PreusersController@show')->name('preusers.show');
  // メール送信完了画面
  Route::get('preusers/complete', 'PreusersController@complete')->name('preusers.complete');

  Route::get('preusers/register', 'Auth\RegisterController@showRegistrationForm')->name('preusers.register')->middleware('check_status');

  Route::post('preusers/register_check', 'Auth\RegisterController@checkRegistrationForm')->name('preusers.registercheck');

  Route::post('preusers/register', 'Auth\RegisterController@register')->name('preusers.store');
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
    // 仮抑え（削除は別で作成予定）
    Route::resource('pre_reservations', 'PreReservationsController')->except(['destroy']);
    // 仮押さえ ajax 顧客情報取得
    Route::post('pre_reservations/getuser', 'PreReservationsController@getuser');
    // 仮抑え　新規登録　確認
    Route::post('pre_reservations/check', 'PreReservationsController@check');
    // 仮抑え　新規登録　計算
    Route::post('pre_reservations/calculate', 'PreReservationsController@calculate');
    // 仮抑え　新規登録　再計算
    Route::post('pre_reservations/{pre_reservation}/re_calculate', 'PreReservationsController@re_calculate');
    // 仮抑え　再計算後、中身が変更する場合の保存
    Route::put('pre_reservations/{pre_reservation}/edit_update', 'PreReservationsController@edit_update');
    // 仮抑え　削除
    Route::post('pre_reservations/destroy', 'PreReservationsController@destroy');
    // 一括仮抑え index
    Route::get('multiples', 'MultiplesController@index');
    // 一括仮抑え show
    Route::get('multiples/{multiples}', 'MultiplesController@show');
    // 一括　個別　edit
    Route::get('multiples/{multiples}/edit/{venues}', 'MultiplesController@edit');
    // 一括　計算
    Route::post('multiples/{multiples}/edit/{venues}/calculate', 'MultiplesController@calculate');
    // 一括　個別　計算
    Route::post('multiples/{multiples}/edit/{venues}/calculate/{pre_reservations}/specific_update', 'MultiplesController@specificUpdate');
    // 一括　保存
    Route::post('multiples/{multiples}/all_updates/{venues}', 'MultiplesController@allUpdates');

    // 仲介会社　仮抑え 作成
    Route::get('pre_agent_reservations/create', 'PreAgentReservationsController@create');
    // 仲介会社　仮抑え 確認
    Route::post('pre_agent_reservations/check', 'PreAgentReservationsController@check');
    // 仲介会社　仮抑え 計算
    Route::post('pre_agent_reservations/calculate', 'PreAgentReservationsController@calculate');
    // 仲介会社　仮抑え 単発　保存
    Route::post('pre_agent_reservations/store', 'PreAgentReservationsController@store');
  });
});
