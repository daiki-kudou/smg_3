<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Venue;
use App\Models\Reservation;

use Illuminate\Support\Facades\Auth;

use PDF;

use Illuminate\Support\Facades\DB; //トランザクション用




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

      return view('user.home.show', [
        'reservation' => $reservation,
        'venue' => $venue,
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
