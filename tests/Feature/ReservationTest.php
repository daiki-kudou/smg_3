<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Artisan;


class ReservationTest extends TestCase
{
  // db初期化
  public function setUp(): void
  {
    parent::setUp();
    Artisan::call('migrate:fresh');
    Artisan::call('db:seed');
  }

  public function testログイン()
  {
    // adminログイン画面
    $response = $this->get('/admin/login');
    $response->assertStatus(200);
    //パスワードを入力
    $response = $this->post('admin/login', [
      'email'    => 'admin@example.com',
      'password' => 'REGUUilg0aQt'
    ]);
    // ログイン後リダイレクトのHome画面
    $response->assertLocation('/admin/home');
  }

  public function test_store_session()
  {
    $this->testログイン();
    $response = $this->post('/admin/reservations/store_session', [
      'reserve_date'    => '2021-12-31',
      'venue_id' => '1',
      'price_system' => '1',
      'enter_time' => '12:00:00',
      'leave_time' => '18:00:00',
      'user_id' => '2',
      'in_charge' => '工藤',
      'tel' => '123456789',
    ]);

    $response->assertLocation('/admin/reservations/create');
  }
}
