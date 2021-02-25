<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Venue;
use App\Models\Reservation;
use App\Models\Bill;

use Illuminate\Support\Facades\Auth;

use PDF;

use Illuminate\Support\Facades\DB; //トランザクション用

use App\Mail\ConfirmReservationByUser;
use App\Mail\ConfirmToAdmin;
use Illuminate\Support\Facades\Mail;




class HomeController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth']);
  }

  public function index()
  {
    $user_id = auth()->user()->id;
    $user = User::find($user_id);
    $reservation = Reservation::where('user_id', $user_id)->get();
    return view('user.home.index', [
      'user' => $user,
      'reservation' => $reservation
    ]);
  }

  public function show($id)
  {
    $reservation = Reservation::find($id);
    if (Auth::id() == $reservation->user_id) {
      $venue = Venue::find($reservation->venue_id);
      $other_bills = [];
      for ($i = 0; $i < count($reservation->bills()->get()) - 1; $i++) {
        $other_bills[] = $reservation->bills()->skip($i + 1)->first();
      }

      return view('user.home.show', [
        'reservation' => $reservation,
        'venue' => $venue,
        'other_bills' => $other_bills,
      ]);
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
}
