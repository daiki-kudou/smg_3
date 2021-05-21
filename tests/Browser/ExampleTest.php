<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\Models\Admin;
use Carbon\Carbon;

class ExampleTest extends DuskTestCase
{
  /**
   * A basic browser test example.
   *
   * @return void
   */
  public function testBasicExample()
  {
    $admin = Admin::find(1);
    $this->browse(function (Browser $browser) use ($admin) {
      $browser->visit('/admin/login')
        ->type('email', $admin->email)
        ->type('password', 'REGUUilg0aQt')
        ->press('Login')
        ->screenshot('home')
        ->assertPathIs('/admin/home')
        ->visit('/admin/reservations/create')
        ->type("reserve_date", $this->randomDate())
        ->select("enter_time", "08:00:00")
        ->select("leave_time", "12:00:00")
        ->select("user_id", 2)
        ->type("in_charge", "duskテスト")
        ->type("tel", "12345678910")
        ->select("venue_id", 1)
        ->screenshot('予約作成画面')
        ->pause(5000)
        ->scrollIntoView('input[name="submit"]')
        ->pressAndWaitFor("submit", 10)
        ->screenshot('予約確認画面')
        ->assertPathIs('/admin/reservations/calculate');
    });
  }

  public function randomDate()
  {
    $start = Carbon::create("1998", "1", "1");
    $end = Carbon::create("2020", "12", "31");
    // タイムスタンプに変換
    $min = strtotime($start);
    $max = strtotime($end);
    // タイムスタンプにした2つの日付の中からランダムに1つタイムスタンプを取得
    $date = rand($min, $max);
    // タイムスタンプ => Y-m-d に変換    
    return $date = date('Y-m-d', $date);
  }

  // public function moveToReservation()
  // {
  //   $start = Carbon::create("1998", "1", "1");
  //   $end = Carbon::create("2020", "12", "31");
  //   // タイムスタンプに変換
  //   $min = strtotime($start);
  //   $max = strtotime($end);
  //   // タイムスタンプにした2つの日付の中からランダムに1つタイムスタンプを取得
  //   $date = rand($min, $max);
  //   // タイムスタンプ => Y-m-d に変換    
  //   $date = date('Y-m-d', $date);

  //   // $login = $this->testBasicExample();
  //   $this->browse(function (Browser $browser) use ($date) {
  //     $browser->visit('/admin/reservations/create')
  //       ->type("reserve_date", $date)
  //       ->press('submit')
  //       ->screenshot("test")
  //       ->assertPathIs('/admin/reservations/calculate');
  //   });
  // }
}
