<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;

use Closure;

class CheckUserOrAdmin
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    $user_auth = Auth::guard('user')->check();
    if ($user_auth) {
      Auth::guard('admin')->logout();
      return redirect(url('/'));
    }


    return $next($request);
  }
}
