<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\Admin;
use App\Models\Venue;
use App\Http\Controllers\Admin\ReservationsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Artisan;



class ExampleTest extends TestCase
{
  // db初期化
  public function setUp(): void
  {
    parent::setUp();
    Artisan::call('migrate:fresh');
    Artisan::call('db:seed');
  }

  /**
   * ログインテスト
   *
   * @test
   * @return void
   */
  public function testログイン()
  {
    // トップ
    $response = $this->get('/');
    $response->assertStatus(200);
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

  public function test会場新規登録()
  {
    $this->testログイン();
    // 会場新規作成画面
    $response = $this->get('/admin/venues/create');
    $response->assertStatus(200);

    $response = $this->post('/admin/venues', [
      'alliance_flag' => 1,
      'name_area' => "新今宮",
      'name_bldg' => "アサシンビル",
      'name_venue' => "A会場",
      'size1' => 1,
      'size2' => 1,
      'capacity' => 1,
      'eat_in_flag' => 1,
      'post_code' => 1,
      'address1' => 1,
      'address2' => 1,
      'address3' => 1,
      'remark' => 1,
      'first_name' => 1,
      'last_name' => 1,
      'first_name_kana' => 1,
      'last_name_kana' => 1,
      'person_tel' => 1,
      'person_email' => 1,
      'luggage_flag' => 1,
      'luggage_post_code' => 1,
      'luggage_address1' => "test",
      'luggage_address2' => "test",
      'luggage_address3' => "test",
      'luggage_name' => 1,
      'luggage_tel' => 1,
      'cost' => 1,
      'mgmt_company' => 1,
      'mgmt_tel' => 1,
      'mgmt_emer_tel' => 1,
      'mgmt_first_name' => 1,
      'mgmt_last_name' => 1,
      'mgmt_person_tel' => 1,
      'mgmt_email' => 1,
      'mgmt_sec_company' => 1,
      'mgmt_sec_tel' => 1,
      'mgmt_remark' => 1,
      'smg_url' => "sample.sample.com",
      'entrance_open_time' => "sample.sample.com",
      'backyard_open_time' => "sample.sample.com",
      'layout' => 1,
      'layout_prepare' => 9000,
      'layout_clean' => 8000,
      'reserver_company' => "test",
      'reserver_tel' => 12345678910,
      'reserver_fax' => 12345678910,
      'reserver_remark' => "test",
    ]);
    // ログイン後リダイレクトのHome画面
    $response->assertLocation('/admin/venues');
  }
}
