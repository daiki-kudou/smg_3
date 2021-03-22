<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\Models\Admin;

class MakePreReservationTest extends DuskTestCase
{
  /**
   * A Dusk test example.
   *
   * @return void
   */
  public function testLogin()
  {
    $admin = Admin::find(1);
    $this->browse(function (Browser $browser) use ($admin) {
      $browser->visit('/admin/login')
        ->type('email', $admin->email)
        ->type('password', 'REGUUilg0aQt')
        ->press('Login')
        ->assertPathIs('/admin/home');
    });
  }

  public function testCreatePreReservation()
  {
    $createForm = $this->browse(function (Browser $browser) {
      $browser->visit('/admin/pre_reservations/create')
        ->assertSee('仮押え 新規登録')
        ->select("user_id", 2)
        ->type('pre_date0', '2021-03-24')
        ->select("pre_venue0", 1)
        ->select("pre_enter0", '08:00:00')
        ->select("pre_leave0", '12:00:00')
        ->select("pre_leave0", '')
        ->click('#check_submit')
        ->assertPathIs('/admin/pre_reservations/create') //画面変遷しない
        ->select("pre_leave0", '12:00:00')
        ->click('#check_submit')
        ->assertPathIs('/admin/pre_reservations/check');
      // ->assertSee('仮押え　詳細入力画面');
    });
    return $createForm;
  }

  public function testCheckPreReservation()
  {
    $getCreateForm = $this->testCreatePreReservation();
    $this->browse(function ($getCreateForm) {
      $getCreateForm->assertSee('仮押え　詳細入力画面')
        ->radio('price_system', 1);
    });
  }
}
