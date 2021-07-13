<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\Admin;
use App\Models\Venue;
use App\Http\Controllers\Admin\ReservationsController;
use Illuminate\Http\Request;


class ExampleTest extends TestCase
{

  public function test_管理者としてログイン後、一旦予約一覧のページにリダイレクトに()
  {
    $admin = factory(\App\Models\Admin::class)->create();
    $this->actingAs($admin, 'admin');
    // 一覧へ移動
    $response = $this->get(action('Admin\ReservationsController@index'));
    $response->assertStatus(200);
    // 予約新作成へ移動
    $response = $this->get(action('Admin\ReservationsController@create'));
    $response->assertStatus(200);

    // $data = [ # 登録用のデータ
    //   'reserve_date' => '2021-12-01',
    //   'venue_id' => '1',
    //   'price_system' => '1',
    //   'enter_time' => '08:00:00',
    //   'leave_time' => '23:00:00',
    //   'in_charge' => '工藤大輝',
    //   'tel' => '09075142676',
    // ];

    // // POST リクエスト
    // $response = $this->post('/admin/reservations/store_session', $data);
    // $response->assertViewHas('reserve_date', '2021-12-01');
  }

  public function test_予約作成()
  {
    // $request = [ # 登録用のデータ
    //   'reserve_date' => '2021-12-01',
    //   'venue_id' => '1',
    //   'price_system' => '1',
    //   'enter_time' => '08:00:00',
    //   'leave_time' => '23:00:00',
    //   'in_charge' => '工藤大輝',
    //   'tel' => '09075142676',
    // ];

    // $BookController = new ReservationsController;
    // $books = $BookController->storeSession($request);

    // $this->post('/admin/reservations/calculate', $books)->assertOk();

  }
}
