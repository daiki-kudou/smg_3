<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\Models\Admin;

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
        ->assertPathIs('/admin/home');
    });
  }
}
