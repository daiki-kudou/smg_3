<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Venue;
use App\Models\Reservation;
use App\Models\Bill;
use App\Models\Cxl;
use App\Models\EmailReset;

use Illuminate\Support\Facades\Auth;

use PDF;

use Illuminate\Support\Facades\DB; //トランザクション用

use App\Mail\ConfirmReservationByUser;
use App\Mail\ConfirmToAdmin;
use App\Mail\AdminFinAddRes;
use App\Mail\UserFinAddRes;
use App\Mail\ResetEmail;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Str;

use Carbon\Carbon;

use App\Traits\PaginatorTrait;


class HomeController extends Controller
{
  use PaginatorTrait;
  public function __construct()
  {
    $this->middleware(['auth']);
  }

  public function index(Request $request)
  {
    $today = Carbon::now();
    $user_id = auth()->user()->id;
    $user = User::with("reservations.bills")->find($user_id);

    if ($request->past) {
      if ($request->paid) {
        $bill = Bill::where('paid', $request->paid)->pluck('reservation_id')->toArray();
        $reservations = $user->reservations->where('reserve_date', '<', $today)->whereIn('id', $bill)->sortByDesc('reserve_date');
      } else {
        $reservations = $user->reservations->where('reserve_date', '<', $today)->sortByDesc('reserve_date');
      }
      $counter = count($reservations);
    } else {
      if ($request->paid) {
        $bill = Bill::where('paid', $request->paid)->pluck('reservation_id')->toArray();
        $reservations = $user->reservations->where('reserve_date', '>=', $today)->whereIn('id', $bill)->sortBy('reserve_date');
      } else {
        $reservations = $user->reservations->where('reserve_date', '>=', $today)->sortBy('reserve_date');
      }

      $counter = count($reservations);
    }
    $reservations = $this->customPaginate($reservations, 2, $request);
    return view('user.home.index', compact('user', 'reservations', 'request', 'counter'));
  }

  public function show($id)
  {
    $reservation = Reservation::with(["bills.breakdowns", "cxls"])->find($id);
    if (Auth::id() == $reservation->user_id) {
      $venue = Venue::find($reservation->venue_id);
      $other_bills = [];
      for ($i = 0; $i < count($reservation->bills) - 1; $i++) {
        $other_bills[] = $reservation->bills->skip($i + 1)->first();
      }
      return view('user.home.show', compact("reservation", "venue", "other_bills"));
    } else {
      return redirect('user/login');
    }
  }

  public function updateStatus(Request $request, $id)
  {
    return DB::transaction(function () use ($request, $id) {
      $reservation = Reservation::find($id);
      $reservation->bills()->first()->update([
        'reservation_status' => $request->update_status
      ]);
      // ユーザーに予約完了メール送信
      $email = $reservation->user->email;
      Mail::to($email)->send(new ConfirmReservationByUser($reservation));
      // 管理者に予約完了メール送信
      $admins = ['kudou@web-trickster.com', 'maruoka@web-trickster.com'];
      Mail::to($admins)->send(new ConfirmToAdmin($reservation));

      $request->session()->regenerate();
      return redirect()->route('user.home.index');
    });
  }

  public function updateOtherBillsStatus(Request $request)
  {
    return DB::transaction(function () use ($request) {
      $bill = Bill::find($request->bill_id);
      $bill->update([
        'reservation_status' => $request->update_status
      ]);

      $request->session()->regenerate();
      return redirect()->route('user.home.index');
    });
  }

  public function generate_invoice($id)
  {
    $reservation = Reservation::find($id);
    if (Auth::id() == $reservation->user_id) {
      $user = User::find($reservation->user_id);
      $pdf = PDF::loadView('admin/reservations/generate_invoice', [
        'reservation' => $reservation,
        'user' => $user
      ])->setPaper('a4');
      return $pdf->stream();
    } else {
      return redirect('user/login');
    }
  }

  public function user_info()
  {
    $user_id = auth()->user()->id;
    $user = User::find($user_id);
    return view('user.home.user_info', compact('user'));
  }

  public function user_edit(Request $request)
  {
    $user_id = auth()->user()->id;
    if ($request->user_id == $user_id) {
      $user = User::find($user_id);
      return view('user.home.user_edit', compact('user'));
    } else {
      return redirect('user/login');
    }
  }

  public function user_update(Request $request)
  {
    $user_id = auth()->user()->id;
    if ($request->user_id == $user_id) {
      $user = User::find($user_id);
      try {
        $user->update([
          'company' => $request->company,
          'first_name' => $request->first_name,
          'last_name' => $request->last_name,
          'first_name_kana' => $request->first_name_kana,
          'last_name_kana' => $request->last_name_kana,
          'post_code' => $request->post_code,
          'address1' => $request->address1,
          'address2' => $request->address2,
          'address3' => $request->address3,
          'tel' => $request->tel,
          'mobile' => $request->mobile,
          'fax' => $request->fax,
          // 'email' => $request->email,
        ]);
      } catch (\Exception $e) {
        report($e);
        session()->flash('flash_message', '更新に失敗しました。再度確認し更新してください');
        return redirect(route('user.home.user_info'));
      }
      $request->session()->regenerate();
      return redirect()->route('user.home.user_info');
    } else {
      return redirect('user/login');
    }
  }

  public function cxl_cfm_by_user(Request $request)
  {
    $cxl = Cxl::with("reservation")->find($request->cxl_id);
    $cxl->update(["cxl_status" => 2]);
    if ($cxl->bill_id == 0) {
      $cxl->reservation->bills->map(function ($item, $key) {
        $item->update(["reservation_status" => 6]);
      });
    } else {
      $bill = Bill::find($cxl->bill_id);
      $bill->update(["reservation_status" => 6]);
    }
    return redirect('user/home');
  }

  public function approve_user_additional_cfm(Request $request)
  {
    $bill = Bill::with('reservation')->find($request->bill_id);
    $bill->update(['reservation_status' => 3,]);

    $email = $bill->reservation->user->email;
    Mail::to($email)->send(new UserFinAddRes()); // ユーザーに予約完了メール送信

    $admin = explode(',', config('app.admin_email'));
    Mail::to($admin)->send(new AdminFinAddRes()); // 管理者に予約完了メール送信

    return redirect('user/home/' . $bill->reservation->id);
  }

  public function email_reset()
  {
    $user_email = auth()->user()->email;
    return view('user.home.email_reset', compact('user_email'));
  }

  public function email_reset_create(Request $request)
  {
    $request->validate([
      'new_email' => 'required|unique:users,email|email',
    ]);
    $token = hash_hmac('sha256', Str::random(40) . $request->new_email, config('app.key'));
    DB::transaction(function () use ($request, $token) {
      $param = [];
      $param['user_id'] = Auth::id();
      $param['new_email'] = $request->new_email;
      $param['token'] = $token;
      $email_reset = EmailReset::create($param);
      Mail::to($request->new_email)->send(new ResetEmail($token));
    });
    return redirect(url('user/home/email_reset_send'));
  }

  public function email_reset_send()
  {
    return view('user.home.email_reset_send');
  }

  public function email_reset_confirm($token)
  {
    $new_email = EmailReset::where('token', $token)->first();

    if ($new_email && !$this->tokenExpired($new_email->created_at)) {
      // ユーザーのメールアドレスを更新
      $user = User::find($new_email->user_id);
      $user->email = $new_email->new_email;
      $user->save();
      // レコードを削除
      EmailReset::where('token', $token)->delete();
      // return redirect('/user/login')->with('flash_message', 'メールアドレスを更新しました！');
      Auth::logout();
      return redirect(url('email_reset_done'));
    } else {
      // レコードが存在していた場合削除
      if ($new_email) {
        EmailReset::where('token', $token)->delete();
      }
      return redirect(url('user/email_reset_failed'));
    }
  }

  public function email_reset_failed()
  {
    return view('user.home.email_reset_failed');
  }

  protected function tokenExpired($createdAt)
  {
    $expires = 1 * 60;    // トークンの有効期限は60分に設定
    return Carbon::parse($createdAt)->addSeconds($expires)->isPast(); //isPastは過去かどうか
  }

  public function cxlMemberShipIndex()
  {
    $user_id = auth()->user()->id;
    $user = User::with(["reservations.bills", "reservations.cxls"])->find($user_id);
    $check_cxl_member_ship = $this->checkCxlMemberShip($user_id);
    // 0=退会許可、1=退会不可
    if ($check_cxl_member_ship === 0) {
      return view('user.home.cxl_membership.index', compact('user'));
    } else {
      return view('user.home.cxl_membership.reject', compact('user'));
    }
  }

  public function destroy($id)
  {
    $user_id = auth()->user()->id;
    if ($id != $user_id) {
      return redirect(url('user/home'));
    }
    $user = User::with(["reservations.bills", "pre_reservations"])->find($id);
    $user->delete();
    return redirect(url('/'));
  }

  public function checkCxlMemberShip($user_id)
  {
    // ★★★★★★★★★★★★★★★退会できる人★★★★★★★★★★★★★★★
    //予約がない
    //仮抑えがない
    //予約完了＆＆入金済み＆＆利用日が今日以前
    //キャンセル完了＆＆入金済み
    // 0=退会許可、1=退会不可
    $today = date('Y-m-d', strtotime(Carbon::now()));
    $user = User::with(['reservations.bills', 'reservations.cxls'])->find($user_id);

    if ($user->reservations->count() == 0 && $user->pre_reservations->count() == 0) {
      return 0;
    }

    $this->haveReservation($user);
    $this->haveCxl($user);
  }

  public function haveReservation($user)
  {
    $finish_reservation_or_not = $this->finishReservationOrNot($user);
    $paid_or_not = $this->paidOrNot($user);
    $future_reservations = $this->haveFutureReservationOrNot($user);
  }

  public function finishReservationOrNot($user)
  {
    foreach ($user->reservations as $key => $reservation) {
      foreach ($reservation->bills as $key => $bill) {
        if ($bill->reservation_status == 1 || $bill->reservation_status == 2) {
          return FALSE;
          break;
        } else {
          continue;
        }
      }
    }
    return TRUE;
  }

  public function paidOrNot($user)
  {
    foreach ($user->reservations as $key => $reservation) {
      foreach ($reservation->bills->where("reservation_status", "<=", 3) as $key => $bill) {
        if ($bill->paid == 1) {
          continue;
        } else {
          return FALSE;
          break;
        }
      }
    }
    return TRUE;
  }

  public function haveFutureReservationOrNot($user)
  {
    $today = date('Y-m-d', strtotime(Carbon::now()));
    $counter = $user->reservations->where("reserve_date", ">=", $today)->count();
    if ($counter == 0) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  public function haveCxl($user)
  {
    $finish_cxl_or_not = $this->finishCxlOrNot($user);
    $cxl_paid_or_not = $this->cxlPaidOrNot($user);
    if ($finish_cxl_or_not && $cxl_paid_or_not) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  public function finishCxlOrNot($user)
  {
    foreach ($user->reservations as $key => $reservation) {
      foreach ($reservation->bills as $key => $bill) {
        if ($bill->reservation_status == 4 || $bill->reservation_status == 5) {
          return FALSE;
          break;
        } else {
          continue;
        }
      }
    }
    return TRUE;
  }

  public function cxlPaidOrNot($user)
  {
    foreach ($user->reservations as $key => $reservation) {
      foreach ($reservation->cxls as $key => $cxl) {
        if ($cxl->paid == 1) {
          continue;
        } else {
          return FALSE;
          break;
        }
      }
    }
    return TRUE;
  }
}
