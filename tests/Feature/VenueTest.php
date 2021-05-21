<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Venue;
use App\Models\Equipment;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;


class VenueTest extends TestCase
{
  /**
   * A basic feature test example.
   *
   * @return void
   */



  use RefreshDatabase;

  public function test_add()
  {
    $venue = Venue::find(1);
    $test = $venue->calculate_price(1, "08:00:00", "12:00:00");
    $this->assertEquals(25000, $test);
  }
}
