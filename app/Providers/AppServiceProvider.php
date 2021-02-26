<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    // 追加
    \Schema::defaultStringLength(191);
    // herokuにあげるときはhtppsにし、ローカルの場合はhttpにしないといけない。
    // 現時点で毎回切り替えないといけない
    // \URL::forceScheme('https');
    if (request()->isSecure()) {
      \URL::forceScheme('https');
    }
  }
}
