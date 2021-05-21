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



  // public function testVenueCreate()
  // {
  //   $response = $this->from("/")
  //     ->post('/admin/login', ['email' => 'admin@example.com', 'password' => 'REGUUilg0aQt']);

  //   $response->assertRedirect('http://127.0.0.1:8000/admin/home');
  // }
}
