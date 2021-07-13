<?php
Route::namespace('Home')->prefix('/')->name('home.')->group(function () {
  Route::middleware('basic_auth')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('slct_date', 'HomeController@slct_date');
    Route::get('slct_venue', 'HomeController@slct_venue');
    Route::get('email_reset_done', 'HomeController@email_reset_done');
    // 予約時の時間制御用ajax
    Route::post('control_time', 'HomeController@control_time');
    Route::get('cxl_member_ship_done', 'HomeController@cxl_member_ship_done');
  });
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
  Route::middleware('auth')->group(function () {
    Route::post('home/invoice', 'HomeController@invoice');
    Route::post('home/receipt', 'HomeController@receipt');
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
    Route::resource('home', 'ReservationsController', ['only' => 'index']); // TOPページ
    Route::resource('venues', 'VenuesController'); // 会場登録
    Route::post('venues/{venue}/restore', 'VenuesController@restore')->name('venues.restore');
    Route::resource('equipments', 'EquipmentsController'); // 備品登録
    Route::resource('services', 'ServicesController')->except(['show']); // サービス登録
    Route::resource('dates', 'DatesController'); // 営業日登録
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

    // 予約
    Route::resource('reservations', 'ReservationsController', ['except' => ['show']]);
    Route::group(['prefix' => 'reservations', 'as' => 'reservations.'], function () {
      Route::post('store_session', 'ReservationsController@storeSession')->name('storeSession');
      Route::get('calculate', 'ReservationsController@calculate')->name('calculate');
      Route::post('check_session', 'ReservationsController@checkSession')->name('checkSession');
      Route::get('check', 'ReservationsController@check')->name('check');
      Route::post('session_for_edit_calculate', 'ReservationsController@sessionForEditCalculate');
      Route::get('edit_calculate', 'ReservationsController@edit_calculate')->name('edit_calculate');
      Route::post('session_for_edit_check', 'ReservationsController@sessionForEditCheck');
      Route::get('edit_check', 'ReservationsController@edit_check')->name('edit_check');
      Route::post('edit_without_calc', 'ReservationsController@editWithoutCalc');
      Route::get('{reservation}', 'ReservationsController@show')->name('show');
      Route::post('{reservation}/double_check', 'ReservationsController@double_check')->name('double_check');
      Route::get('generate_pdf/{reservation}', 'ReservationsController@generate_pdf')->name('generate_pdf');
      Route::post('{reservation}/send_email_and_approve', 'ReservationsController@send_email_and_approve')->name('send_email_and_approve');
      Route::post('{reservation}/confirm_reservation', 'ReservationsController@confirm_reservation')->name('confirm_reservation');
    });

    // Breakdown　Billに紐づく
    Route::resource('breakdowns', 'BreakdownsController');

    // ajax ▼
    Route::post('ajax/reservation/get_item', 'Ajax\AjaxReservationsController@get_items');
    Route::post('ajax/reservation/get_price_system', 'Ajax\AjaxReservationsController@get_price_system');
    Route::post('ajax/reservation/get_price_details', 'Ajax\AjaxReservationsController@get_price_details');
    Route::post('ajax/reservation/get_layout', 'Ajax\AjaxReservationsController@get_layout');
    Route::post('ajax/reservation/get_luggage', 'Ajax\AjaxReservationsController@get_luggage');
    Route::post('ajax/reservation/get_eat_in', 'Ajax\AjaxReservationsController@get_eat_in');
    Route::post('ajax/reservation/get_operation_system', 'Ajax\AjaxReservationsController@get_operation_system');
    Route::post('ajax/clients/get_clients', 'Ajax\AjaxClientsController@get_clients');

    // 管理者用カレンダーページ会場別
    Route::get('calendar/venue_calendar', 'CalendarsController@venue_calendar')->name('calendar.venue_calendar');
    // 管理者用カレンダーページ日時別
    Route::get('calendar/date_calendar', 'CalendarsController@date_calendar')->name('calendar.date_calendar');

    // bills
    Route::resource('bills', 'BillsController');
    Route::group(['prefix' => 'bills', 'as' => 'bills.'], function () {
      Route::get('create', 'BillsController@create');
      Route::post('create_session', 'BillsController@createSession');
      Route::post('ajaxaddbillsequipments', 'BillsController@ajaxaddbillsequipments');
      Route::post('ajaxaddbillslaytout', 'BillsController@ajaxaddbillslaytout');
      Route::get('check', 'BillsController@check')->name('check');
      Route::post('other_doublecheck', 'BillsController@OtherDoubleCheck');
      Route::post('other_send_approve', 'BillsController@other_send_approve');
      Route::get('{bill}/agent_edit', 'BillsController@agentEdit')->name('agent_edit');
      Route::post('{bill}/agent_edit_update', 'BillsController@agentEditUpdate');
      Route::post('update_bill_info', 'BillsController@updateBillInfo');
      Route::post('update_paid_info', 'BillsController@updatePaidInfo');
    });

    // agents_reservations
    Route::group(['prefix' => 'agents_reservations', 'as' => 'agents_reservations.'], function () {
      Route::get('create', 'AgentsReservationsController@create')->name("create");
      Route::post('store_session', 'AgentsReservationsController@storeSession');
      Route::get('calculate', 'AgentsReservationsController@calculate')->name('calculate');
      Route::post('check_session', 'AgentsReservationsController@checkSession');
      Route::get('check', 'AgentsReservationsController@check')->name('check');
      Route::post('agents_reservations', 'AgentsReservationsController@store');
      Route::get('add_bills', 'AgentsReservationsController@add_bills')->name('add_bills');
      Route::post('create_session', 'AgentsReservationsController@createSession');
      Route::get('add_bills/check', 'AgentsReservationsController@add_check')->name('add_check');
      Route::post('add_bills/store', 'AgentsReservationsController@add_store')->name('add_store');
      Route::post('confirm', 'AgentsReservationsController@add_confirm')->name('add_confirm');
      Route::post('edit', 'AgentsReservationsController@edit');
      Route::get('edit_show', 'AgentsReservationsController@editShow')->name('edit_show');
      Route::post('session_input', 'AgentsReservationsController@addSessionInput');
      Route::get('show_input', 'AgentsReservationsController@showInput')->name('show_input');
      Route::post('session_check', 'AgentsReservationsController@editCheckSession');
      Route::get('edit_check', 'AgentsReservationsController@editCheck')->name('edit_check');
      Route::post('update', 'AgentsReservationsController@update');
    });

    // pre_reservations
    Route::resource('pre_reservations', 'PreReservationsController')->except(['destroy']);
    Route::group(['prefix' => 'pre_reservations', 'as' => 'pre_reservations.'], function () {
      Route::post('getuser', 'PreReservationsController@getuser');
      Route::post('check', 'PreReservationsController@check')->name('check');
      Route::post('calculate', 'PreReservationsController@calculate')->name('calculate');
      Route::post('{pre_reservation}/re_calculate', 'PreReservationsController@re_calculate')->name('re_calculate');
      Route::put('{pre_reservation}/edit_update', 'PreReservationsController@edit_update');
      Route::post('destroy', 'PreReservationsController@destroy');
      Route::post('switch_status', 'PreReservationsController@switchStatus')->name('switch_status');
      Route::post('reject_same_time', 'PreReservationsController@rejectSameTime')->name('rejectSameTime');
      Route::post('get_user', 'PreReservationsController@get_user');
    });

    // multiples
    Route::group(['prefix' => 'multiples', 'as' => 'multiples.'], function () {
      Route::get('/', 'MultiplesController@index')->name('index');
      Route::get('{multiples}', 'MultiplesController@show')->name('show');
      Route::get('{multiples}/edit/{venues}', 'MultiplesController@edit')->name('edit');
      Route::post('{multiples}/edit/{venues}/calculate', 'MultiplesController@calculate')->name('edit_calculate');
      Route::post('{multiples}/edit/{venues}/calculate/{pre_reservations}/specific_update', 'MultiplesController@specificUpdate');
      Route::post('{multiples}/all_updates/{venues}', 'MultiplesController@allUpdates');
      Route::get('switch/{multiple}', 'MultiplesController@switch')->name('switch');
      Route::post('switch_cfm/{multiple}', 'MultiplesController@switch_cfm');
      Route::get('{multiples}/add_date/{venues}/', 'MultiplesController@add_date');
      Route::post('{multiples}/add_date_store/{venues}/', 'MultiplesController@add_date_store');
      Route::get('{multiples}/add_venue', 'MultiplesController@add_venue')->name('add_venue');
      Route::post('{multiples}/add_venue_store', 'MultiplesController@add_venue_store');
      Route::get('agent/{multiples}', 'MultiplesController@agent_show')->name('agent_show');
      Route::get('agent/{multiples}/edit/{venues}', 'MultiplesController@agent_edit')->name('agent_edit');
      Route::post('agent/{multiples}/edit/{venues}/calculate', 'MultiplesController@agent_calculate');
      Route::post('agent/{multiples}/edit/{venues}/calculate/{pre_reservations}/specific_update', 'MultiplesController@agent_specificUpdate');
      Route::get('agent/{multiples}/add_venue', 'MultiplesController@agent_add_venue')->name("agent_add_venue");
      Route::post('agent/{multiples}/add_venue_store', 'MultiplesController@agent_add_venue_store');
      Route::post('switch_status', 'MultiplesController@switchStatus');
      Route::delete('destroy', 'MultiplesController@destroy');
      Route::post('{multiple}/sp_destroy/{venue}', 'MultiplesController@SPDestroy');
      Route::get('agent_switch/{multiple}', 'MultiplesController@switchAgent')->name("agent_switch");
      Route::post('agent_switch_cfm/{multiple}', 'MultiplesController@switchAgent_cfm');
      Route::post('agent/agentMoveToReservation', 'MultiplesController@agentMoveToReservation');
    });

    // pre_agent_reservations
    Route::group(['prefix' => 'pre_agent_reservations', 'as' => 'pre_agent_reservations.'], function () {
      Route::get('create', 'PreAgentReservationsController@create')->name('create');
      Route::post('check', 'PreAgentReservationsController@check')->name('check');
      Route::post('calculate', 'PreAgentReservationsController@calculate')->name('calculate');
      Route::post('store', 'PreAgentReservationsController@store');
      Route::get('{pre_reservation}/edit', 'PreAgentReservationsController@edit')->name('edit');
      Route::post('get_agent', 'PreAgentReservationsController@get_agent');
      Route::post('{pre_reservation}/edit_calculate', 'PreAgentReservationsController@edit_calculate');
      Route::put('{pre_reservation}/update', 'PreAgentReservationsController@update');
    });












    Route::post('cxl/multi_calc', 'CxlController@multiCalc');
    Route::get('cxl/multi_calc', 'CxlController@multiCalcShow')->name('cxl.multi_calc');
    Route::get('cxl/multi_create', 'CxlController@multiCreate')->name('cxl.multi_create');
    Route::post('cxl/multi_check', 'CxlController@multiCheck')->name('cxl.multi_check');
    Route::post('cxl/store', 'CxlController@store');
    Route::post('cxl/double_check', 'CxlController@doubleCheck');
    Route::post('cxl/send_email_and_approve', 'CxlController@send_email_and_approve');
    Route::post('cxl/confirm', 'CxlController@confirm_cxl');

    Route::get('cxl/edit/{cxl}', 'CxlController@edit')->name('cxl.edit');
    Route::post('cxl/edit_calc', 'CxlController@editCalc');
    Route::get('cxl/edit_calc', 'CxlController@editCalcShow')->name('cxl.edit_calc');
    Route::post('cxl/edit_check', 'CxlController@editCheck');
    Route::post('cxl/update', 'CxlController@update');
    Route::post('cxl/update_cxl_bill_info', 'CxlController@updateCxlBillInfo');
    Route::post('cxl/update_cxl_paid_info', 'CxlController@updateCxlPaidInfo');


    // メールてんぷれ
    Route::get('mail_templates', 'MailTemplatesController@index');
    Route::get('cron_templates', 'MailTemplatesController@cron');

    Route::post('invoice', 'InvoiceController@show');
    Route::post('board', 'BoardController@show');
    // note
    Route::get('note', 'NoteController@index')->name('note');
    Route::get('note/create', 'NoteController@create');
    Route::post('note/store', 'NoteController@store');
    Route::get('note/edit/{date}/{note}', 'NoteController@edit');
    Route::get('note/delete/{note}/{date}', 'NoteController@destroy');
    Route::post('note/update', 'NoteController@update');
    Route::post('note/sort_no_update', 'NoteController@sortNoUpdate');

    Route::post('csv', 'SalesController@download_csv');

    Route::get('sales', 'SalesController@index');

    Route::post('receipts', 'ReceiptsController@show');

    Route::post('control_time', 'ControltimeController@getInformation');

    Route::post('change_log', 'ChangeLogsController@update');

    // FAKE TEST
    Route::get('fake_test', 'FakeTestController@index');

    Route::resource('administer', 'AdminsController');
  });
});
