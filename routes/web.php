<?php
Route::namespace('Home')->prefix('/')->name('home.')->group(function () {
  Route::get('/', 'HomeController@index')->name('home');
  Route::get('slct_date', 'HomeController@slct_date');
  Route::get('slct_venue', 'HomeController@slct_venue');
  Route::get('email_reset_done', 'HomeController@email_reset_done');
  // 予約時の時間制御用ajax
  Route::post('control_time', 'HomeController@control_time');
  Route::post('getpricesystem', 'HomeController@getpricesystem');
  Route::get('cxl_member_ship_done', 'HomeController@cxl_member_ship_done');
  Route::get('timeout', 'HomeController@timeout')->name('timeout');
});



// 一般ユーザー用カレンダー
Route::get('calendar/venue_calendar', 'CalendarsController@venue_calendar');
Route::get('calendar/date_calendar', 'CalendarsController@date_calendar');

/*
|--------------------------------------------------------------------------
| ユーザー用ルート
|--------------------------------------------------------------------------|
*/
Route::namespace('User')->prefix('user')->name('user.')->group(function () {

  Auth::routes(['register' => true, 'confirm' => true, 'reset' => true,]);

  Route::middleware(['auth','verified'])->group(function () {
    Route::get('home/invoice/{reservation_id}/{bill_id}/{cxl_id}', 'HomeController@invoice');
    Route::get('home/receipt/{bill_id}/{cxl_id}', 'HomeController@receipt');
    Route::get('home/user_info', 'HomeController@user_info')->name('home.user_info');
    Route::post('home/user_edit', 'HomeController@user_edit');
    Route::post('home/user_update', 'HomeController@user_update');
    // メール再設定　認証
    Route::get('home/email_reset', 'HomeController@email_reset');
    Route::post('home/email_reset_create', 'HomeController@email_reset_create');
    Route::get('home/email_reset_send', 'HomeController@email_reset_send');
    // 退会
    Route::get('home/cxl_membership', 'HomeController@cxlMemberShipIndex');
    // リソース
    Route::resource('home', 'HomeController');
    Route::put('home/{home}/update_status', 'HomeController@updateStatus')->name('home.updatestatus');
    Route::get('home/generate_invoice/{home}', 'HomeController@generate_invoice')->name('home.generate_invoice');
    Route::put('home/{home}/update_other_bills', 'HomeController@updateOtherBillsStatus');
    Route::post('home/cfm_cxl', 'HomeController@cxl_cfm_by_user');
    Route::post('home/approve_user_additional_cfm', 'HomeController@approve_user_additional_cfm');

    Route::post('pre_reservations/{pre_reservation}/calculate', 'PreReservationsController@calculate')->name('pre_reservations.show_calc');
    Route::post('pre_reservations/{pre_reservation}/cfm', 'PreReservationsController@cfm');
    Route::get('pre_reservations', 'PreReservationsController@index')->name('pre_reservations.index');
    Route::get('pre_reservations/cfm', 'PreReservationsController@showCfm')->name('pre_reservations.show_cfm');
    Route::get('pre_reservations/{pre_reservation}', 'PreReservationsController@show')->name('pre_reservations.show');
    // Route::resource('pre_reservations', 'PreReservationsController')->except('show');

    // 以下、ユーザーからの予約経路
    // 例外でgetリクエスト
    Route::get('reservations/create', 'ReservationsController@create')->name('reservations.create');
	Route::post('reservations/create', 'ReservationsController@reenter')->name('reservations.reenter');
    Route::post('reservations/check', 'ReservationsController@check');
    Route::post('reservations/store_session', 'ReservationsController@storeSession');
    Route::get('reservations/cart', 'ReservationsController@cart');
    Route::post('reservations/destroy_check', 'ReservationsController@destroy_check');
    Route::post('reservations/session_destroy', 'ReservationsController@session_destroy');
    Route::post('reservations/re_create', 'ReservationsController@re_create');
    Route::post('reservations/store', 'ReservationsController@storeReservation');
    Route::get('reservations/complete', 'ReservationsController@complete');
  });

  Route::get('email_reset_confirm/{token}', 'HomeController@email_reset_confirm');
  Route::get('email_reset_failed', 'HomeController@email_reset_failed');



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
  Route::post('preusers/register', 'Auth\RegisterController@register')->name('preusers.store')->middleware('check_status');

  // ログイン
  Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
  Route::post('login', 'Auth\LoginController@login');
  Route::post('logout', 'Auth\LoginController@logout')->name('logout');


  // パスワードリセット
  Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
  Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
  Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
  Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

  Route::get('datatable', 'ReservationsController@datatable');
  Route::get('pre_datatable', 'PreReservationsController@datatable');
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
  Route::middleware(
    'auth:admin',
    // ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    // 'check_user_or_admin'　// middlewareの check_user_or_adminは本番運用開始後にUP予定
    // ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
  )->group(function () {
    // TOPページ
    Route::resource('home', 'ReservationsController', ['only' => 'index']);
    // 会場登録
    Route::resource('venues', 'VenuesController');
    Route::post('venues/{venue}/restore', 'VenuesController@restore')->name('venues.restore');

    // 備品登録
    Route::resource('equipments', 'EquipmentsController');
    // サービス登録
    Route::resource('services', 'ServicesController')->except(['show']);
    // 営業日登録
    Route::resource('dates', 'DatesController');
    // 枠貸し料金登録
    Route::resource('frame_prices', 'FramePricesController')->except(['create']);
    Route::get('frame_prices/create/{frame_price}', 'FramePricesController@create')->name('frame_prices.create');
    // 時間貸し料金登録
    Route::resource('time_prices', 'TimePricesController')->except(['create']);
    Route::get('time_prices/create/{time_price}', 'TimePricesController@create')->name('time_prices.create');
    // 紹介会社
    Route::resource('agents', 'AgentsController');
    Route::post('agents/get_agent', 'AgentsController@getAgent');
    Route::post('agents/get_agent_person_name', 'AgentsController@getAgentPersonName');
    // 管理者側からUser登録
    Route::resource('clients', 'ClientsController');
    // 予約　session
    Route::post('reservations/store_session', 'ReservationsController@storeSession')->name('reservations.storeSession');
    // 予約　計算
    Route::get('reservations/calculate', 'ReservationsController@calculate')->name('reservations.calculate');
    // 予約　check session
    Route::post('reservations/check_session', 'ReservationsController@checkSession')->name('reservations.checkSession');
    // 予約
    Route::resource('reservations', 'ReservationsController', ['except' => ['show']]);
    Route::get('reservations/datatable', 'ReservationsController@datatable');
    // 予約　（確認）
    Route::get('reservations/check', 'ReservationsController@check')->name('reservations.check');
    // 予約　編集確認
    Route::post('reservations/edit_check', 'ReservationsController@edit_check')->name('reservations.edit_check');
    // 予約　show
    Route::get('reservations/{reservation}', 'ReservationsController@show')->name('reservations.show');
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
    // ajax 荷物あり、なし　判別
    Route::post('reservations/getluggage', 'ReservationsController@getluggage');
    // ajax 会場　直営 or 提携　判別
    Route::post('reservations/getoperation', 'ReservationsController@getoperation');
    // ajax 会場　直営 or 提携　判別
    Route::post('clients/getclients', 'ClientsController@getclients');
    // ajax ケータリング
    Route::post('reservations/get_eat_in', 'ReservationsController@getEatIn');
    //予約に対するダブルチェック
    Route::post('reservations/{reservation}/double_check', 'ReservationsController@double_check')->name('reservations.double_check');

    Route::get('reservations/generate_pdf/{reservation}', 'ReservationsController@generate_pdf')->name('reservations.generate_pdf');

    Route::post('reservations/{reservation}/send_email_and_approve', 'ReservationsController@send_email_and_approve')->name('reservations.send_email_and_approve');

    Route::post('reservations/{reservation}/confirm_reservation', 'ReservationsController@confirm_reservation')->name('reservations.confirm_reservation');

    // Breakdown　Billに紐づく
    Route::resource('breakdowns', 'BreakdownsController');

    // 管理者用カレンダーページ
    // 会場別
    Route::get('calendar/venue_calendar', 'CalendarsController@venue_calendar')->name('calendar.venue_calendar');
    // 日時別
    Route::get('calendar/date_calendar', 'CalendarsController@date_calendar')->name('calendar.date_calendar');
    // ミニカレンダー
    Route::get('calendar/mini_calendar', 'CalendarsController@mini_calendar')->name('calendar.mini_calendar');

    // 追加請求書新規登録
    Route::get('bills/create', 'BillsController@create');
    // session 追加請求書
    // Route::post('bills/create_session', 'BillsController@createSession');
    // // ajax 予約　請求書　追加
    Route::post('bills/ajaxaddbillsequipments', 'BillsController@ajaxaddbillsequipments');
    // // ajax 予約　請求書　追加　レイアウト取得
    Route::post('bills/ajaxaddbillslaytout', 'BillsController@ajaxaddbillslaytout');
    // // 管理者請求書作成　確認画面
    Route::get('bills/check', 'BillsController@check')->name('bills.check');

    Route::post('bills/other_doublecheck', 'BillsController@OtherDoubleCheck');

    Route::post('bills/other_send_approve', 'BillsController@other_send_approve');

    Route::get('bills/{bill}/agent_edit', 'BillsController@agentEdit')->name('bills.agent_edit');

    Route::post('bills/{bill}/agent_edit_update', 'BillsController@agentEditUpdate');

    Route::post('bills/update_bill_info', 'BillsController@updateBillInfo');

    Route::post('bills/update_paid_info', 'BillsController@updatePaidInfo');

    // Bill　予約に紐づく
    Route::resource('bills', 'BillsController');
    //********************** */
    //***仲介会社　予約 */
    //********************** */
    // 仲介会社経由予約
    Route::get('agents_reservations/create', 'AgentsReservationsController@create')->name("agents_reservations.create");
    // 仲介　予約　計算　SESSION
    Route::post('agents_reservations/store_session', 'AgentsReservationsController@storeSession');
    // 仲介会社経由　計算
    Route::get('agents_reservations/calculate', 'AgentsReservationsController@calculate')->name('agents_reservations.calculate');
    // 仲介　予約　check　SESSION
    Route::post('agents_reservations/check_session', 'AgentsReservationsController@checkSession');
    // 仲介会社経由　確認
    Route::get('agents_reservations/check', 'AgentsReservationsController@check')->name('agents_reservations.check');
    // 仲介会社経由　保存
    Route::post('agents_reservations', 'AgentsReservationsController@store');
    // 仲介会社　請求　追加
    Route::get('agents_reservations/add_bills', 'AgentsReservationsController@add_bills')->name('agents_reservations.add_bills');
    // 仲介会社　追加請求　確認
    Route::get('agents_reservations/add_bills/check', 'AgentsReservationsController@add_check')->name('agents_reservations.add_check');
    // 仲介会社　追加請求　保存
    Route::post('agents_reservations/add_bills/store', 'AgentsReservationsController@add_store')->name('agents_reservations.add_store');
    // 仲介会社　メールなしで予約確定ボタン
    Route::post('agents_reservations/confirm', 'AgentsReservationsController@add_confirm')->name('agents_reservations.add_confirm');
    // 仲介会社予約編集
    // Route::post('agents_reservations/edit', 'AgentsReservationsController@edit')->name('agents_reservations.edit');
    Route::get('agents_reservations/{agents_reservations}/edit', 'AgentsReservationsController@edit')->name('agents_reservations.edit');
    Route::post('agents_reservations/edit_check', 'AgentsReservationsController@editCheck')->name('agents_reservations.edit_check');
    Route::PUT('agents_reservations/{agents_reservations}', 'AgentsReservationsController@update');

    //********************** */
    //***仮抑え */
    //********************** */
    // 仮押え（削除は別で作成予定）
    Route::get('pre_reservations', 'PreReservationsController@index')->name('pre_reservations.index');
    Route::get('pre_reservations/create', 'PreReservationsController@create')->name('pre_reservations.create');
    Route::post('pre_reservations', 'PreReservationsController@store')->name('pre_reservations.store');
    Route::PUT('pre_reservations/{pre_reservations}', 'PreReservationsController@update')->name('pre_reservations.update');
    Route::get('pre_reservations/{pre_reservations}/edit', 'PreReservationsController@edit')->name('pre_reservations.edit');

    // 仮押え ajax 顧客情報取得
    Route::post('pre_reservations/getuser', 'PreReservationsController@getuser');
    // 仮押え　新規登録　確認
    Route::get('pre_reservations/check', 'PreReservationsController@check')->name('pre_reservations.check');
    // 仮押え　新規登録　計算
    Route::get('pre_reservations/calculate', 'PreReservationsController@calculate')->name('pre_reservations.calculate');
    // 仮押え　新規登録　再計算
    Route::post('pre_reservations/{pre_reservation}/re_calculate', 'PreReservationsController@re_calculate')->name('pre_reservations.re_calculate');
    // 仮押え　再計算後、中身が変更する場合の保存
    Route::put('pre_reservations/{pre_reservation}/edit_update', 'PreReservationsController@edit_update');
    // 仮押え　削除
    Route::post('pre_reservations/destroy', 'PreReservationsController@destroy');
    // 仮押え　ステータス変更。管理者は編集不可に。ユーザーからの編集受付開始
    Route::post('pre_reservations/switch_status', 'PreReservationsController@switchStatus')->name('pre_reservations.switch_status');
    //時間制御
    Route::post('pre_reservations/reject_same_time', 'PreReservationsController@rejectSameTime')->name('pre_reservations.rejectSameTime');
    // 仮押え編集時にユーザー変更
    Route::post('pre_reservations/get_user', 'PreReservationsController@get_user');

    Route::get('pre_reservations/{pre_reservations}', 'PreReservationsController@show')->name('pre_reservations.show');


    // 一括仮押え index
    Route::get('multiples', 'MultiplesController@index')->name('multiples.index');
    // 一括仮押え show
    Route::get('multiples/{multiples}', 'MultiplesController@show')->name('multiples.show');
    // 一括　個別　edit
    Route::get('multiples/{multiples}/edit/{venues}', 'MultiplesController@edit')->name('multiples.edit');
    // 一括　計算
    Route::post('multiples/{multiples}/edit/{venues}/calculate', 'MultiplesController@calculate')->name('multiples.edit_calculate');
    // 一括　個別　計算
    Route::post('multiples/{multiples}/edit/{venues}/calculate/{pre_reservations}/specific_update', 'MultiplesController@specificUpdate');
    // 一括　保存
    Route::post('multiples/{multiples}/all_updates/{venues}', 'MultiplesController@allUpdates');
    // 一括ユーザー切り替え
    Route::get('multiples/switch/{multiple}', 'MultiplesController@switch')->name('multiples.switch');
    // 一括ユーザー切り替え確定
    Route::post('multiples/switch_cfm/{multiple}', 'MultiplesController@switch_cfm');
    // 一括仮押さえ、日付の追加
    Route::get('multiples/{multiples}/add_date/{venues}/', 'MultiplesController@add_date');
    // 一括仮押さえ、日付の追加保存
    Route::post('multiples/{multiples}/add_date_store/{venues}/', 'MultiplesController@add_date_store');
    // 一括仮押さえ、会場の追加
    Route::get('multiples/{multiples}/add_venue', 'MultiplesController@add_venue')->name('multiples.add_venue');
    // 一括仮押さえ、会場の追加保存
    Route::post('multiples/{multiples}/add_venue_store', 'MultiplesController@add_venue_store');
    // 一括仮押さえ、詳細。仲介会社用
    Route::get('multiples/agent/{multiples}', 'MultiplesController@agent_show')->name('multiples.agent_show');
    // 仲介会社一括編集
    Route::get('multiples/agent/{multiples}/edit/{venues}', 'MultiplesController@agent_edit')->name('multiples.agent_edit');
    // 仲介会社　一括　計算
    Route::post('multiples/agent/{multiples}/edit/{venues}/calculate', 'MultiplesController@agent_calculate');
    // 仲介会社　一括　個別　計算
    Route::post('multiples/agent/{multiples}/edit/{venues}/calculate/{pre_reservations}/specific_update', 'MultiplesController@agent_specificUpdate');
    // 仲介会社　一括仮押さえ、会場の追加
    Route::get('multiples/agent/{multiples}/add_venue', 'MultiplesController@agent_add_venue')->name("multiples.agent_add_venue");
    // 仲介会社　一括仮押さえ、会場の追加
    Route::post('multiples/agent/{multiples}/add_venue_store', 'MultiplesController@agent_add_venue_store');
    // 一括仮押さえ、ユーザーに編集権限譲渡
    Route::post('multiples/switch_status', 'MultiplesController@switchStatus');
    // 一括仮押さえ、indexページ内。削除
    Route::delete('multiples/destroy', 'MultiplesController@destroy');
    // 一括仮押さえ、edit内、個別削除
    Route::post('multiples/{multiple}/sp_destroy/{venue}', 'MultiplesController@SPDestroy');
    // 一括仮押さえ（仲介会社経由）仲介会社変更
    Route::get('multiples/agent_switch/{multiple}', 'MultiplesController@switchAgent')->name("multiples.agent_switch");
    // 一括　仲介会社　更新
    Route::post('multiples/agent_switch_cfm/{multiple}', 'MultiplesController@switchAgent_cfm');
    // 一括仮押さえ、仲介会社から予約へ移行
    Route::post('multiples/agent/agentMoveToReservation', 'MultiplesController@agentMoveToReservation');

    //********************** */
    //***仲介会社　仮抑え */
    //********************** */
    // 仲介会社　仮押え 作成
    Route::get('pre_agent_reservations/create', 'PreAgentReservationsController@create')->name('pre_agent_reservations.create');
    // 仲介会社　仮押え 確認
    Route::post('pre_agent_reservations/check', 'PreAgentReservationsController@check')->name('pre_agent_reservations.check');
    // 仲介会社　仮押え 計算
    Route::post('pre_agent_reservations/calculate', 'PreAgentReservationsController@calculate')->name('pre_agent_reservations.calculate');
    // 仲介会社　仮押え 単発　保存
    Route::post('pre_agent_reservations/store', 'PreAgentReservationsController@store');
    // 仲介会社　仮押さえ edit
    Route::get('pre_agent_reservations/{pre_reservation}/edit', 'PreAgentReservationsController@edit')->name('pre_agent_reservations.edit');
    // 仲介会社ajax
    Route::post('pre_agent_reservations/get_agent', 'PreAgentReservationsController@get_agent');
    // 仲介会社　編集　計算
    Route::post('pre_agent_reservations/{pre_reservation}/edit_calculate', 'PreAgentReservationsController@edit_calculate')->name('pre_agent_reservations.edit_calculate');

    Route::put('pre_agent_reservations/{pre_reservation}/update', 'PreAgentReservationsController@update');

    // 仲介会社の仮抑えを予約へ移行
    Route::post('pre_agent_reservations/switch_status', 'PreAgentReservationsController@switch_status');


    Route::get('cxl/multi_create', 'CxlController@multiCreate')->name('cxl.multi_create');
    Route::get('cxl/multi_calc', 'CxlController@multiCalc')->name('cxl.multi_calc');
    Route::get('cxl/multi_check', 'CxlController@multiCheck')->name('cxl.multi_check');
    Route::post('cxl/store', 'CxlController@store');
    Route::post('cxl/double_check', 'CxlController@doubleCheck');
    Route::post('cxl/send_email_and_approve', 'CxlController@send_email_and_approve');
    Route::post('cxl/confirm', 'CxlController@confirm_cxl');

    Route::get('cxl/edit/{cxl}', 'CxlController@edit')->name('cxl.edit');
    Route::get('cxl/edit_calc', 'CxlController@editCalc')->name('cxl.edit_calc');
    Route::post('cxl/update', 'CxlController@update');
    Route::post('cxl/update_cxl_bill_info', 'CxlController@updateCxlBillInfo');
    Route::post('cxl/update_cxl_paid_info', 'CxlController@updateCxlPaidInfo');


    // メールてんぷれ
    Route::get('mail_templates', 'MailTemplatesController@index')->name('mail_templates.mail_templates');
	Route::get('mail_templates/{id}', 'MailTemplatesController@show')->name('mail_templates.show');
	Route::post('mail_templates/update','MailTemplatesController@update')->name('mail_templates.update');
    Route::get('cron_templates', 'MailTemplatesController@cron')->name('mail_templates.cron_templates');

    Route::post('invoice', 'InvoiceController@show');
    Route::get('board/{reservation_id}', 'BoardController@show');
    // note
    Route::get('note', 'NoteController@index')->name('note');
    Route::get('note/create', 'NoteController@create');
    Route::post('note/store', 'NoteController@store');
    Route::get('note/edit/{date}/{note}', 'NoteController@edit');
    Route::get('note/delete/{note}/{date}', 'NoteController@destroy');
    Route::post('note/update', 'NoteController@update');
    Route::post('note/sort_no_update', 'NoteController@sortNoUpdate');

    Route::post('csv', 'SalesController@download_csv');

    Route::get('sales', 'SalesController@index')->name('sales.sales');

    Route::post('receipts', 'ReceiptsController@show');

    Route::post('control_time', 'ControltimeController@getInformation');

    Route::post('control_time_reject_self', 'ControltimeController@getInformationWithoutSelf');

    Route::post('change_log', 'ChangeLogsController@update');

    // FAKE TEST
    // Route::get('fake_test', 'FakeTestController@index');

    Route::resource('administer', 'AdminsController');

    Route::post('sync', 'SyncController@sync');

    Route::get('reservations/datatable', 'DataTableController@reservation');
    Route::get('sales/datatable', 'DataTableController@sales');
  });
});
