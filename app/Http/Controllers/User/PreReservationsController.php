<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PreReservation;
use App\Models\PreBill;
use App\Models\PreBreakdown;
use App\Models\Venue;
use App\Models\User;
use App\Models\Equipment;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Traits\PaginatorTrait;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminPreResToRes;
use App\Mail\UserPreResToRes;


class PreReservationsController extends Controller
{

  use PaginatorTrait;

  public function __construct()
  {
    $this->middleware(['auth']);
  }


  public function index(Request $request)
  {
    $user_id = auth()->user()->id;
    // $pre_reservations = PreReservation::where('user_id', $user_id)->where('status', 1)->get();

    $today = Carbon::today();
    $after = PreReservation::where('reserve_date', '>=', $today)->where('user_id', $user_id)->where("status", 1)->get()->sortBy('reserve_date');
    $before = PreReservation::where('reserve_date', '<', $today)->where('user_id', $user_id)->where("status", 1)->get()->sortByDesc('reserve_date');
    $merge = $after->concat($before);
    $pre_reservations = $this->customPaginate($merge, 30, $request);
    $counter = count($pre_reservations);

    return view('user.pre_reservations.index', compact('pre_reservations', 'counter'));
  }

  public function show($id)
  {
    $user_id = auth()->user()->id;
    $pre_reservation = PreReservation::find($id);
    if ($pre_reservation->user_id != $user_id) { //別ユーザーのページ制限
      return redirect(route('user.pre_reservations.index'));
    }
    if ($pre_reservation->status != 1) { //ステータスが管理者編集権限の場合の制限
      return redirect(route('user.pre_reservations.index'));
    }
    $venue = $pre_reservation->venue;
    return view('user.pre_reservations.show', compact('pre_reservation', 'venue'));
  }

  public function calculate(Request $request, $id)
  {
    if ($request->cfm) {
      return $this->cfm($request, $id);
    } else {
      $user_id = auth()->user()->id;
      $pre_reservation = PreReservation::find($id);
      $venue = Venue::find($pre_reservation->venue_id);
      if ($pre_reservation->user_id != $user_id) { //別ユーザーのページ制限
        return redirect(route('user.pre_reservations.index'));
      }
      if ($pre_reservation->status != 1) { //ステータスが管理者編集権限の場合の制限
        return redirect(route('user.pre_reservations.index'));
      }
      $venue_price = $pre_reservation->pre_bill->venue_price;
      $equ_details = Equipment::getArrays($request);
      $ser_details = Service::getArrays($request);
      $item_details = $venue->calculate_items_price($equ_details, $ser_details);
      $layout_details = $venue->getLayoutPrice($request->layout_prepare, $request->layout_clean)[2];
      $master = $venue_price + $item_details[0] + $layout_details;
      return view(
        'user.pre_reservations.calculate',
        compact('pre_reservation', 'venue', 'request', 'item_details', 'layout_details', 'venue_price', 'master', 'id')
      );
    }
  }

  public function cfm(Request $request, $id)
  {
    $user_id = auth()->user()->id;
    $pre_reservation = PreReservation::with('pre_bill.pre_breakdowns')->find($id);
    if ($pre_reservation->user_id != $user_id) { //別ユーザーのページ制限
      return redirect(route('user.pre_reservations.index'));
    }
    if ($pre_reservation->status != 1) { //ステータスが管理者編集権限の場合の制限
      return redirect(route('user.pre_reservations.index'));
    }

    $request = $request->merge([
      'user_id' => $user_id,
      'enter_time' => $pre_reservation->enter_time,
      'leave_time' => $pre_reservation->leave_time,
      'status' => 2,
      'price_system' => $pre_reservation->price_system,
      'multiple_reserve_id' => $pre_reservation->multiple_reserve_id,
    ]);

    // 一旦、最新情報でpre reservation を保存。その後予約へ移動
    DB::transaction(function () use ($id, $request) {
      $pre_reservation = PreReservation::find($id);
      $pre_reservation->Updates($request);
      $pre_bill = new PreBill;
      $pre_bill->PreBillCreate($request, $pre_reservation);
      $pre_breakdowns = new PreBreakdown;
      $pre_breakdowns->PreBreakdownCreate($request, $pre_reservation);
      $pre_reservation->MoveToReservation($request);

      $admin = explode(',', config('app.admin_email'));
      Mail::to($admin) //管理者
        ->send(new AdminPreResToRes($pre_reservation));
      Mail::to($pre_reservation->user->email) //ユーザー
        ->send(new UserPreResToRes($pre_reservation));
    });
    return redirect(route('user.pre_reservations.show_cfm'));
  }

  public function showCfm()
  {
    return view('user.pre_reservations.cfm');
  }
}
