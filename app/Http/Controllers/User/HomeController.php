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
use App\Mail\UserFinAddRes;
use App\Mail\ResetEmail;
use App\Mail\AdminUnSub;
use App\Mail\UserUnSub;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Traits\PaginatorTrait;
use Session;
use Artisan;

use App\Service\SendSMGEmail;



class HomeController extends Controller
{
  use PaginatorTrait;
  public function __construct()
  {
    $this->middleware(['auth']);
  }

  public function index(Request $request)
  {
    $today = date('Y-m-d', strtotime(Carbon::now()));
    $user_id = auth()->user()->id;
    $user = User::with(["reservations.bills.cxl", "reservations.cxls"])->find($user_id);


    return view('user.home.index', compact('user', 'request'));
  }

  public function show($id)
  {
    $reservation = Reservation::with(["bills.breakdowns", "cxls"])->find($id);
    if (Auth::id() == $reservation->user_id) {
      $venue = Venue::find($reservation->venue_id);
      $other_bills = $reservation->bills->sortBy("id")->skip(1);

      return view('user.home.show', compact("reservation", "venue", "other_bills"));
    } else {
      return redirect('user/login');
    }
  }

  public function updateStatus(Request $request, $id)
  {
    return DB::transaction(function () use ($request, $id) {
      $reservation = Reservation::with(['user', 'venue', 'bills'])->find($id);
      $reservation->bills->first()->update([
        'reservation_status' => $request->update_status,
        'cfm_at' => date('Y-m-d H:i:s'),
      ]);
      // // ユーザーに予約完了メール送信
      $SendSMGEmail = new SendSMGEmail();
      $SendSMGEmail->send("予約完了", ['reservation_id' => $reservation->id, 'bill_id' => $reservation->bills->first()->id]);

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
    $cxl = Cxl::with(["reservation.user", "reservation.venue"])->find($request->cxl_id);
    $cxl->update(["cxl_status" => 2]);
    if ($cxl->bill_id == 0) {
      $cxl->reservation->bills->map(function ($item, $key) {
        $item->update(["reservation_status" => 6]);
      });
      $SendSMGEmail = new SendSMGEmail();
      $SendSMGEmail->send("ユーザーがキャンセルを承認", $cxl->id);
    } else {
      $bill = Bill::find($cxl->bill_id);
      $bill->update(["reservation_status" => 6]);
    }
    return redirect('user/home');
  }

  public function approve_user_additional_cfm(Request $request)
  {
    $bill = Bill::with('reservation.user')->find($request->bill_id);
    $bill->update([
      'reservation_status' => 3,
      'cfm_at' => date('Y-m-d H:i:s'),
    ]);

    $SendSMGEmail = new SendSMGEmail();
    $SendSMGEmail->send("ユーザーが追加予約の承認完了後、メール送信", ['reservation_id' => $bill->reservation->id, 'bill_id' => $bill->id]);

    $flash_message = "追加予約を受け付けました";
    $request->session()->regenerate();
    return redirect(url('/user/home/' . $bill->reservation->id))->with('flash_message', $flash_message);
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
    $result = DB::transaction(function () use ($request, $token) {
      $param = [];
      $param['user_id'] = Auth::id();
      $param['new_email'] = $request->new_email;
      $param['token'] = $token;
      $email_reset = EmailReset::create($param);
      return $email_reset;
    });
    $old_user_info = User::find($result->user_id);
    $SendSMGEmail = new SendSMGEmail();
    $SendSMGEmail->AuthSend("ユーザーメール更新", ['result' => $result, 'user' => $old_user_info]);

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
      $SendSMGEmail = new SendSMGEmail();
      $SendSMGEmail->AuthSend("ユーザーメール更新完了",  $user);
      // レコードを削除
      EmailReset::where('token', $token)->delete();
      Auth::logout();
      return redirect(url('email_reset_done'));
    } else {
      // レコードが存在していた場合削除
      EmailReset::where('token', $token)->delete();

      return redirect(url('user/email_reset_failed'));
    }
  }

  public function email_reset_failed()
  {
    return view('user.home.email_reset_failed');
  }

  protected function tokenExpired($createdAt)
  {
    $expires = 2 * 60;    // トークンの有効期限は120分に設定
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
      return redirect(url('/user/home'));
    }
    $user = User::with(["reservations.bills", "pre_reservations"])->find($id);
    $user->delete();

    $SendSMGEmail = new SendSMGEmail($user, "", "");
    $SendSMGEmail->AuthSend("退会");

    return redirect(url('/cxl_member_ship_done'));
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

    $have_reservation = $this->haveReservation($user);
    $have_cxl = $this->haveCxl($user);
    if ($have_reservation && $have_cxl) {
      return 0;
    } else {
      return 1;
    }
  }

  public function haveReservation($user)
  {
    $finish_reservation_or_not = $this->finishReservationOrNot($user);
    $paid_or_not = $this->paidOrNot($user);
    $future_reservations = $this->haveFutureReservationOrNot($user);

    if ($finish_reservation_or_not && $paid_or_not && $future_reservations) {
      return TRUE;
    } else {
      return FALSE;
    }
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
    $reservations = $user->reservations->where("reserve_date", ">=", $today);
    $counter = 0;
    foreach ($reservations as $key => $reservation) {
      foreach ($reservation->bills as $key => $bill) {
        if ($bill->reservation_status <= 3) {
          $counter++;
        }
      }
    }
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

  public function  invoice($reservation_id, $bill_id, $cxl_id)
  {
    $reservation = Reservation::with(['user', 'bills.breakdowns', 'agent', 'cxls'])->find($reservation_id);
    $bill = $reservation->bills->find($bill_id);
    if ((int)$cxl_id === 0) {
      $cxl = "";
    } else {
      $cxl = $reservation->cxls->find($cxl_id);
    }
    return view('admin.invoice.show', compact('reservation', 'bill', 'cxl'));
  }

  public function receipt($bill_id, $cxl_id)
  {
    if ((int)$cxl_id === 0) {
      $bill = Bill::with(['reservation.user', 'reservation.agent', 'breakdowns'])->find($bill_id);
      $cxl = "";
      return view('admin.receipts.show', compact('bill', 'cxl'));
    } else {
      $bill = "";
      $cxl = Cxl::with('cxl_breakdowns')->find($cxl_id);
      return view('admin.receipts.show', compact('cxl', 'bill'));
    }
  }
}
