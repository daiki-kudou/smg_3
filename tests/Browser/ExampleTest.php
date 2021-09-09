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
  public function testAdminLogin()
  {
    $admin = Admin::find(1);
    $this->browse(function (Browser $browser) use ($admin) {
      $browser->visit('/admin/login')
        ->type('email', $admin->email)
        ->type('password', 'REGUUilg0aQt')
        ->press('Login')
        ->assertPathIs('/admin/home');

      $browser->visit('/admin/reservations/create')
        ->assertPathIs('/admin/reservations/create')
        ->type('reserve_date', '2021-09-09')
        ->click('.table')
        ->select('venue_id', 15)
        ->post('/admin/reservations/getpricesystem', ['venue_id' => 15])
        ->seeJsonEquals([
          'created' => true,
        ])
        ->screenshot("error");


      // ->click('.table')
      // ->select('enter_time', '10:00:00')
      // ->click('.table')
      // ->radio('price_system', 1)
      // ->select('leave_time', '18:00:00')
      // ->select('user_id', 2)
      // ->type('in_charge', "工藤大揮")
      // ->type('tel', "12345678910")
      // ->scrollIntoView(" .more_btn_lg")
      // ->click('@equipemnts')
      // ->pause(1000)
      // ->screenshot("error");
      // ->press('submit')
      // ->assertPathIs('/admin/reservations/create');
    });
  }
}
