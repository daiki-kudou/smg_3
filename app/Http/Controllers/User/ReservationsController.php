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
use App\Mail\AdminReqRes;
use App\Mail\UserReqRes;
use Carbon\Carbon;
use App\Service\SendSMGEmail;



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
      // SMGから依頼があれば、以下で対応利用時間3時間以下は音響ハイグレードさせない
      // $diffMinutes = (Carbon::parse($request->enter_time)->diffInMinutes(Carbon::parse($request->leave_time)));
      return view('user.reservations.create', compact(
        'request',
        'venue',
        // 'diffMinutes'
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

    // 荷物はユーザーから依頼があったタイミングでは0円の固定
    $luggage_price = 0;
    // if ($request->luggage_count || $request->luggage_arrive || $request->luggage_return) {
    //   $luggage_price += 500;
    // }

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
        // Session::forget('session_reservations.' . $request->select_id);
        // Session::get('session_reservations');
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
    $sessions = $request->session()->get('session_reservations');
    $select_id = $request->session_reservation_id;
    $slctSession = $sessions[$select_id];
    $fix = (object)$slctSession[0];
    $venue = Venue::with(['frame_prices', 'time_prices'])->find($fix->venue_id);
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
        $value[0]['pay_person'] = "";
        $value[0]['payment'] = 0;
        // データ加工▲
        $result_reservation = $reservation->ReservationStore($value[0]);
        $result_bill = $bill->BillStore($result_reservation->id, $value[0], $reservation_status = 1, $double_check_status = 0, $category = 1, $admin_judge = 2);
        $result_breakdowns = $breakdowns->BreakdownStore($result_bill->id, $value[0]);
        // メール送付
        // $admin = explode(',', config('app.admin_email'));
        // $user = $user->email;
        // Mail::to($admin)->send(new AdminReqRes($result_reservation));
        // Mail::to($user)->send(new UserReqRes($result_reservation));
        $reservation = $result_reservation;
        $venue = Venue::find($reservation->venue_id);
        $SendSMGEmail = new SendSMGEmail($user, $reservation, $venue);
        $SendSMGEmail->send("ユーザーからの予約依頼受付");
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
}
