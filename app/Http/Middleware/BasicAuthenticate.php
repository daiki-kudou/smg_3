<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Response;


class BasicAuthenticate
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
    $user = $request->getUser();
    $pass = $request->getPassword();

    if ($user == 'user' && $pass = 'qniImZrAwGIj') {
      return $next($request);
    }

    $headers = ['WWW-Authenticate' => 'Basic'];
    return new Response('Invalid credentials.', 401, $headers);
  }
}
