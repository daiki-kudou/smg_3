<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Venue;
use App\Models\Reservation;
use App\Models\Bill;
use App\Models\Breakdown;
use Illuminate\Support\Facades\DB; //トランザクション用
use Illuminate\Support\Facades\Auth;
use Session;

use Illuminate\Support\Facades\Mail;
use App\Mail\UserReqRes;
use Carbon\Carbon;
use App\Service\SendSMGEmail;
use App\Http\Helpers\ReservationHelper;


class ReservationsController extends Controller
{
	public function create(Request $request)
	{
		$oldSession = $request->session()->get('_old_input');
		if ($oldSession) {
			$request = (object)$oldSession;
			$venue = Venue::with(["frame_prices", "time_prices"])->find($oldSession['venue_id']);
			return view('user.reservations.create', compact('request', 'venue'));
		} else {
			$venue = Venue::with(["frame_prices", "time_prices"])->find($request->venue_id);
			return view('user.reservations.create', compact(
				'request',
				'venue',
			));
		}
	}

	public function check(Request $request)
	{
		$venue = Venue::with('frame_prices')->find($request->venue_id);
		$price_result = $venue->calculate_price($request->price_system, $request->enter_time, $request->leave_time);
		$s_equipment = [];
		foreach ($request->all() as $key => $value) {
			if (preg_match('/equipment_breakdown/', $key)) {
				$s_equipment[] = $value;
			}
		}

		$s_service = [];
		foreach ($request->all() as $key => $value) {
			if (preg_match('/services_breakdown/', $key)) {
				$s_service[] = $value;
			}
		}

		$items_results = $venue->calculate_items_price($s_equipment, $s_service);

		$layout_price = 0;
		if ($request->layout_prepare != 0 || $request->layout_clean != 0) {
			if ($request->layout_prepare) {
				$layout_price += $venue->layout_prepare;
			}
			if ($request->layout_clean) {
				$layout_price += $venue->layout_clean;
			}
		}

		// 荷物はユーザーから依頼があったタイミングでは0円の固定 ← 変更:デフォルト500円
		$luggage_price = 0;
		if ($request->luggage_flag) {
			$luggage_price += 500;
		}

		$master =
			$price_result[0]
			+ $items_results[0]
			+ $layout_price
			+ $luggage_price;

		return view(
			'user.reservations.check',
			compact(
				'request',
				'venue',
				'price_result',
				'items_results',
				'master',
			)
		);
	}

	public function storeSession(Request $request)
	{
		if ($request->back) {
			$arrays = (array)$request->all();
			return redirect()
				->action("User\ReservationsController@create")
				->withInput($arrays);
		} else {
			if ($request->select_id != "") {
				$data = $request->all();
				$user = auth()->user()->id;
				$all_data = [$data, $user];
				$request->session()->put('session_reservations.' . $request->select_id, $all_data);
				return redirect('/user/reservations/cart');
			}
			$data = $request->all();
			$user = auth()->user()->id;
			$all_data = [$data, $user];
			$request->session()->push('session_reservations', $all_data);
			$request->session()->regenerateToken();
			return redirect('user/reservations/cart');
		}
	}

	public function cart(Request $request)
	{
		$sessions = $request->session()->get('session_reservations');
		return view('user.reservations.cart', compact('sessions'));
	}

	public function destroy_check(Request $request)
	{
		$sessions = $request->session()->get('session_reservations');
		$session_id = $request->session_reservation_id;
		$slctSession = $sessions[$session_id];
		$venue = Venue::find($slctSession[0]['venue_id']);
		return view('user.reservations.destroy_check', compact('slctSession', 'venue', 'session_id'));
	}

	public function session_destroy(Request $request)
	{
		$session_reservation_id = $request->session_reservation_id;
		Session::forget('session_reservations.' . $session_reservation_id);
		Session::get('session_reservations');
		return redirect('user/reservations/cart');
	}

	/**     
	 *  
	 *@var int $request->session_reservation_id
	 */
	public function re_create(Request $request)
	{
		if (!empty($request->form_back)) {
			$fix = (object)$request->all();
			$select_id = $request->session_reservation_id;
			$venue = Venue::with(['frame_prices', 'time_prices'])->find($fix->venue_id);
		} else {
			$sessions = $request->session()->get('session_reservations');
			$select_id = $request->session_reservation_id;
			$slctSession = $sessions[$select_id];
			$fix = (object)$slctSession[0];
			$venue = Venue::with(['frame_prices', 'time_prices'])->find($fix->venue_id);
		}
		return view('user.reservations.re_create', compact('fix', 'venue', 'select_id'));
	}

	public function storeReservation(Request $request)
	{
		$sessions = $request->session()->get('session_reservations');
		$user = Auth::user();

		$reservation = new Reservation;
		$bill = new Bill;
		$breakdowns = new Breakdown;

		DB::beginTransaction();
		try {
			foreach ($sessions as $key => $value) {
				$venue = Venue::find($value[0]['venue_id']);
				// データ加工▼
				$value[0]['user_id'] = $user->id;
				$value[0]['agent_id'] = 0;
				$value[0]['reserve_date'] = $value[0]['date'];
				$value[0]['email_flag'] = 1;
				$value[0]['admin_details'] = "";
				$value[0]['venue_price'] = json_decode($value[0]['price_result'])[0];
				$value[0]['equipment_price'] = json_decode($value[0]['items_results'])[0];
				$layout_prepare = !empty($value[0]['layout_prepare']) ? (int)$venue->layout_prepare : 0;
				$layout_clean = !empty($value[0]['layout_clean']) ? (int)$venue->layout_clean : 0;
				$value[0]['layout_price'] = $layout_prepare + $layout_clean;
				$value[0]['others_price'] = 0;
				$value[0]['master_subtotal'] = $value[0]['master'];
				$value[0]['master_tax'] = floor((int)$value[0]['master'] * 0.1);
				$value[0]['master_total'] = floor(((int)$value[0]['master'] * 0.1) + ((int)$value[0]['master']));
				$value[0]['payment_limit'] = $user->getUserPayLimit($value[0]['date']);
				$value[0]['bill_company'] = $user->getCompany();
				$value[0]['bill_person'] = $user->getPerson();
				$value[0]['bill_created_at'] = Carbon::now();
				$value[0]['bill_remark'] = "";
				$value[0]['paid'] = 0;
				$value[0]['reservation_status'] = 1;
				$value[0]['double_check_status'] = 0;
				$value[0]['category'] = 1;
				$value[0]['admin_judge'] = 2;
				$value[0]['pay_day'] = NULL;
				$value[0]['pay_person'] = $user->payer ?? '';
				$value[0]['payment'] = 0;
				$value[0]['user_details'] = $value[0]['remark'];
				// データ加工▲
				$result_reservation = $reservation->ReservationStore($value[0]);
				$result_bill = $bill->BillStore($result_reservation->id, $value[0], $reservation_status = 1, $double_check_status = 0, $category = 1, $admin_judge = 2);
				$result_breakdowns = $breakdowns->BreakdownStore($result_bill->id, $value[0]);
				// メール送付
				$venue = Venue::find($reservation->venue_id);
				$SendSMGEmail = new SendSMGEmail();
				$SendSMGEmail->send("ユーザーからの予約依頼受付", ['reservation_id' => $result_reservation->id, 'bill_id' => $result_bill->id]);
			}
			DB::commit();
		} catch (\Exception $e) {
			DB::rollback();
			return back()->withInput()->withErrors($e->getMessage());
		}
		$request->session()->forget('session_reservations');
		$request->session()->regenerate();

		return redirect('user/reservations/complete');
	}

	public function complete()
	{
		return view('user.reservations.complete');
	}

	public function datatable(Request $request)
	{
		$data = $request->all();
		$user = auth()->user()->id;

		$draw = $request->get('draw');
		$start = $request->get("start");
		$rowperpage = $request->get("length"); // Rows display per page 


		if (!empty($request->get('order'))) {
			$columnIndex_arr = $request->get('order');
			$columnIndex = $columnIndex_arr[0]['column']; // Column index 
		}

		if (!empty($request->get('order'))) {
			$columnName_arr = $request->get('columns');
			$columnName = $columnName_arr[$columnIndex]['data']; // Column name 
		}

		if (!empty($request->get('order'))) {
			$order_arr = $request->get('order');
			$columnSortOrder = $order_arr[0]['dir']; // asc or desc 
		}

		if (!empty($request->get('order'))) {
			$search_arr = $request->get('search');
			$searchValue = $search_arr['value']; // Search value 
		}

		$future_past = (int)$request->future_past;
		if ($future_past === 0) {
			$judge_reserve_date = " reservations.reserve_date >= CURRENT_DATE()";
		} elseif ($future_past === 1) {
			// 最大2年前
			$judge_reserve_date = " reservations.reserve_date between DATE_SUB(CURRENT_DATE(),INTERVAL 2 YEAR) and CURRENT_DATE()";
		} else {
			$judge_reserve_date = " reservations.reserve_date >= CURRENT_DATE()";
		}

		if (!empty($data['paid'])) {
			switch ((int)$data['paid']) {
				case 1:
					$data['payment_status0'] = 1;
					break;
				case 2:
					$data['payment_status1'] = 1;
					break;
				case 3:
					$data['payment_status2'] = 1;
					break;
				case 4:
					$data['payment_status3'] = 1;
					break;
				case 5:
					$data['payment_status4'] = 1;
					break;
				case 6:
					$data['payment_status5'] = 1;
					break;

				default:
					break;
			}
		}


		// Total records 
		$_reservatioin = new Reservation;
		// 全データの総数
		$totalRecords = $_reservatioin->ReservationSearchTarget()->where('user_id', $user)->whereRaw($judge_reserve_date);

		// 検索があった場合の検索結果の件数
		$totalRecordswithFilter = $_reservatioin->SearchReservation($data)->where('user_id', $user)->whereRaw($judge_reserve_date)->get()->count();

		// orderリクエストがあれば、orderに沿い、なければ初期並び順指定
		$fix_order_col_name = !empty($request->get('order')) ? $columnName : "予約中かキャンセルか,今日以降かどうか,今日以降日付,今日未満日付";
		$fix_order_sort_order = !empty($request->get('order')) ? $columnSortOrder : "desc";

		// 検索があった場合の検索結果のcollection
		$records = $_reservatioin
			->SearchReservation($data)->where('user_id', $user)->whereRaw($judge_reserve_date)
			->offset($start)
			->limit($rowperpage)
			->orderByRaw("$fix_order_col_name $fix_order_sort_order")
			->get();

		$data_arr = [];
		foreach ($records as $record) {
			$data_arr[] =
				[
					'reservation_id' => ReservationHelper::fixId($record->reservation_id),
					'reserve_date' => ReservationHelper::formatDate($record->reserve_date),
					'enter_time' => ReservationHelper::formatTime($record->enter_time),
					'leave_time' => ReservationHelper::formatTime($record->leave_time),
					'venue_name' => $record->venue_name_user . ($record->price_system === 2 ? '(音響HG)' : ''),
					'reservation_status' => $this->getSalesStatus($record->reservation_id),
					'category' => $this->getSalesCategory($record->reservation_id),
					'sogaku' => (int)$record->sogaku < 0 ? "<p style='color:red;'>" . number_format($record->sogaku) . "</p>" : number_format($record->sogaku),
					'sales' => $this->getSales($record->reservation_id, $record->sogaku),
					'payment_limit' => $this->getPaymentLimit($record->reservation_id),
					'paid' => $this->getPaid($record->reservation_id),
					'details' => "<a href=" . route('user.home.show', $record->reservation_id) . " class='more_btn btn'>詳細</a>",
					'invoice' => $this->getInvoice($record->reservation_id),
					'receipt' => $this->getReceipt($record->reservation_id),
				];
		}

		$response = array(
			"draw" => intval($draw),
			"iTotalRecords" => $totalRecords,
			"iTotalDisplayRecords" => $totalRecordswithFilter,
			"aaData" => $data_arr
		);

		echo json_encode($response);
		exit;
	}

	public function getSales($id, $sogaku = 0)
	{
		$r = DB::table("bills")->whereRaw('reservation_id = ?', [$id])->get();
		$result = "";
		foreach ($r as $key => $b) {
			$result .=
				"<li>" .
				"<div class='multi-column__item'>" .
				"<span class='payment-status' style='" . ((int)$b->master_total < 0 ? "color:red" : "") . "'>" .
				number_format(((int)$b->master_total)) .
				"</span>" .
				"</div>" .
				"</li>";
		}
		$reservation = Reservation::with(['cxls', 'bills'])->find($id);
		if ($reservation->cxls->count() > 0) {
			// 打ち消し表示
			$result .=
				"<li>" .
				"<div class='multi-column__item'>" .
				"<span class='payment-status text-danger'>" .
				number_format(-$reservation->bills->pluck('master_total')->sum()) .
				"</span>" .
				"</div>" .
				"</li>";
			// キャンセル料表示
			$result .=
				"<li>" .
				"<div class='multi-column__item'>" .
				"<span class='payment-status' style='" . ((int)$reservation->cxls->first()->master_total < 0 ? "color:red;" : "") . "'>" .
				number_format((int)$reservation->cxls->first()->master_total) .
				"</span>" .
				"</div>" .
				"</li>";
		}

		return "<ul class='multi-column__list'>" . $result . "</ul>";
	}




	public function getSalesCategory($id)
	{
		$r = DB::table("bills")->whereRaw('reservation_id = ?', [$id])->get();
		$result = "";
		foreach ($r as $key => $b) {
			$result .=
				"<li>" .
				"<div class='multi-column__item'>" .
				"<span class='payment-status'>" .
				((int)$b->category === 1 ? "会場予約" : "追加請求" . $key) .
				"</span>" .
				"</div>" .
				"</li>";
		}
		$reservation = Reservation::with('cxls')->find($id);
		if ($reservation->cxls->count() > 0) {
			// 打ち消し表示
			$result .=
				"<li>" .
				"<div class='multi-column__item'>" .
				"<span class='payment-status text-danger'>" .
				"打消" .
				"</span>" .
				"</div>" .
				"</li>";

			// キャンセル料表示
			$result .=
				"<li>" .
				"<div class='multi-column__item'>" .
				"<span class='payment-status'>" .
				"キャンセル料" .
				"</span>" .
				"</div>" .
				"</li>";
		}
		return "<ul class='multi-column__list'>" . $result . "</ul>";
	}

	public function getSalesStatus($id)
	{
		$r = DB::table("bills")->whereRaw('reservation_id = ?', [$id])->get();
		$result = "";
		foreach ($r as $key => $b) {
			$result .=
				"<li>" .
				"<div class='multi-column__item'>" .
				"<span class='payment-status'>" .
				ReservationHelper::judgeStatus($b->reservation_status) .
				"</span>" .
				"</div>" .
				"</li>";
		}
		$reservation = Reservation::with('cxls')->find($id);
		if ($reservation->cxls->count() > 0) {
			// 打ち消し表示
			$result .=
				"<li>" .
				"<div class='multi-column__item'>" .
				"<span class='payment-status text-danger'>" .
				"-" .
				"</span>" .
				"</div>" .
				"</li>";
			// キャンセル料表示
			$result .=
				"<li>" .
				"<div class='multi-column__item'>" .
				"<span class='payment-status'>" .
				(ReservationHelper::cxlStatus($reservation->cxls->first()->cxl_status)) .
				"</span>" .
				"</div>" .
				"</li>";
		}
		return "<ul class='multi-column__list'>" . $result . "</ul>";
	}

	public function getPaid($id)
	{
		$r = DB::table("bills")->whereRaw('reservation_id = ?', [$id])->get();
		$result = "";
		foreach ($r as $key => $b) {
			$bold = (int)$b->paid === 0 ? "f-bold" : "";
			$result .=
				"<li>" .
				"<div class='multi-column__item'>" .
				"<span class='payment-status $bold'>" .
				ReservationHelper::paidStatus($b->paid) .
				"</span>" .
				"</div>" .
				"</li>";
		}
		$reservation = Reservation::with('cxls')->find($id);
		if ($reservation->cxls->count() > 0) {
			// 打ち消し表示
			$result .=
				"<li>" .
				"<div class='multi-column__item'>" .
				"<span class='payment-status text-danger'>" .
				"-" .
				"</span>" .
				"</div>" .
				"</li>";
			// キャンセル料表示
			$bold = $reservation->cxls->first()->paid === 0 ? "f-bold" : "";
			$result .=
				"<li>" .
				"<div class='multi-column__item'>" .
				"<span class='payment-status $bold'>" .
				(ReservationHelper::paidStatus($reservation->cxls->first()->paid)) .
				"</span>" .
				"</div>" .
				"</li>";
		}
		return "<ul class='multi-column__list'>" . $result . "</ul>";
	}


	public function getPaymentLimit($id)
	{
		$r = DB::table("bills")->whereRaw('reservation_id = ?', [$id])->get();
		$result = "";
		foreach ($r as $key => $b) {
			$result .=
				"<li>" .
				"<div class='multi-column__item'>" .
				"<span class='payment-status'>" .
				ReservationHelper::formatDate($b->payment_limit) .
				"</span>" .
				"</div>" .
				"</li>";
		}
		$reservation = Reservation::with('cxls')->find($id);
		if ($reservation->cxls->count() > 0) {
			// 打ち消し表示
			$result .=
				"<li>" .
				"<div class='multi-column__item'>" .
				"<span class='payment-status text-danger'>" .
				"-" .
				"</span>" .
				"</div>" .
				"</li>";
			// キャンセル料表示
			$result .=
				"<li>" .
				"<div class='multi-column__item'>" .
				"<span class='payment-status'>" .
				ReservationHelper::formatDate($reservation->cxls->first()->payment_limit) .
				"</span>" .
				"</div>" .
				"</li>";
		}
		return "<ul class='multi-column__list'>" . $result . "</ul>";
	}

	public function getInvoice($id)
	{
		$r = DB::table("bills")->whereRaw('reservation_id = ?', [$id])->get();
		$result = "";
		foreach ($r as $key => $b) {
			if ($b->reservation_status === 3) {
				$result .=
					"<li>" .
					"<div class='multi-column__item'>" .
					"<span class='payment-status'>" .
					"<a target='_blank' href=" . url('/user/home/invoice/' . $id . '/' . $b->id . '/' . 0)  . " class='more_btn btn'>請求書</a>" .
					"</span>" .
					"</div>" .
					"</li>";
			} else {
				$result .=
					"<li>" .
					"<div class='multi-column__item'>" .
					"<span class='payment-status'>" .
					"" .
					"</span>" .
					"</div>" .
					"</li>";
			}
		}
		$reservation = Reservation::with('cxls')->find($id);
		if ($reservation->cxls->count() > 0) {
			// 打ち消し表示
			$result .=
				"<li>" .
				"<div class='multi-column__item'>" .
				"<span class='payment-status text-danger'>" .
				"-" .
				"</span>" .
				"</div>" .
				"</li>";
			// キャンセル料表示
			if ((int)$reservation->cxls->first()->cxl_status === 2) {
				$result .=
					"<li>" .
					"<div class='multi-column__item'>" .
					"<span class='payment-status'>" .
					"<a target='_blank' href=" . url('/user/home/invoice/' . $id . '/' . $b->id . '/' . $reservation->cxls->first()->id)  . " class='more_btn btn'>請求書</a>" .
					"</span>" .
					"</div>" .
					"</li>";
			} else {
				$result .=
					"<li>" .
					"<div class='multi-column__item'>" .
					"<span class='payment-status'>" .
					"" .
					"</span>" .
					"</div>" .
					"</li>";
			}
		}
		return "<ul class='multi-column__list'>" . $result . "</ul>";
	}

	public function getReceipt($id)
	{
		$r = DB::table("bills")->whereRaw('reservation_id = ?', [$id])->get();
		$result = "";
		foreach ($r as $key => $b) {
			if ($b->paid === 1||$b->paid == 5) {
				$result .=
					"<li>" .
					"<div class='multi-column__item'>" .
					"<span class='payment-status'>" .
					"<a target='_blank' href=" . url('/user/home/receipt/' . $b->id . '/' . 0)  . " class='more_btn btn'>領収書</a>" .
					"</span>" .
					"</div>" .
					"</li>";
			} else {
				$result .=
					"<li>" .
					"<div class='multi-column__item'>" .
					"<span class='payment-status'>" .
					"" .
					"</span>" .
					"</div>" .
					"</li>";
			}
		}
		$reservation = Reservation::with('cxls')->find($id);
		if ($reservation->cxls->count() > 0) {
			// 打ち消し表示
			$result .=
				"<li>" .
				"<div class='multi-column__item'>" .
				"<span class='payment-status text-danger'>" .
				"-" .
				"</span>" .
				"</div>" .
				"</li>";
			// キャンセル料表示
			if ((int)$reservation->cxls->first()->paid === 1||(int)$reservation->cxls->first()->paid === 5) {
				$result .=
					"<li>" .
					"<div class='multi-column__item'>" .
					"<span class='payment-status'>" .
					"<a target='_blank' href=" . url('/user/home/receipt/' . $b->id . '/' . $reservation->cxls->first()->id)  . " class='more_btn btn'>領収書</a>" .
					"</span>" .
					"</div>" .
					"</li>";
			} else {
				$result .=
					"<li>" .
					"<div class='multi-column__item'>" .
					"<span class='payment-status'>" .
					"" .
					"</span>" .
					"</div>" .
					"</li>";
			}
		}
		return "<ul class='multi-column__list'>" . $result . "</ul>";
	}

	public function reenter(Request $request)
	{
		// dd($request->all());
		$venue = Venue::with(["frame_prices", "time_prices"])->find($request->venue_id);
		return view('user.reservations.create', compact(
			'request',
			'venue',
		));
	}
}
