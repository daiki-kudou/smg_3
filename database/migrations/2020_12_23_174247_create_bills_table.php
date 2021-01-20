<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('bills', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->bigInteger('reservation_id')->unsigned()->index();

      $table->integer('venue_total');
      $table->integer('venue_discount_percent')->nullable();
      $table->integer('venue_dicsount_number')->nullable();
      $table->integer('discount_venue_total');

      $table->integer('equipment_total');
      $table->integer('service_total');
      $table->integer('luggage_total');
      $table->integer('equipment_service_total');
      $table->integer('discount_item')->nullable();
      $table->integer('discount_equipment_service_total');


      $table->integer('layout_total');
      $table->integer('layout_discount')->nullable();
      $table->integer('after_duscount_layouts');


      $table->integer('others_total');
      $table->integer('others_discount')->nullable();
      $table->integer('after_duscount_others');



      $table->integer('sub_total');
      $table->integer('tax');
      $table->integer('total');

      $table->integer('paid'); //支払い状況、未入金か？入金済みか？　デフォルトは0で未入金
      $table->integer('reservation_status'); //予約状況　0:仮抑え　1:予約確認中　2予約承認待ち　3:予約完了　4:キャンセル申請中　5:キャンセル承認待ち　6:キャンセル
      $table->integer('double_check_status'); //ダブルチェックのフラグ 0:未　1:一人済　2:二人済
      $table->string('double_check1_name')->nullable(); //ダブルチェック一人目
      $table->string('double_check2_name')->nullable(); //ダブルチェック一人目
      $table->datetime('approve_send_at')->nullable(); //ダブルチェック後の承認メールにてユーザーにメールが送付される

      $table->string('category');


      // ソフトデリート用
      $table->softDeletes();

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('bills');
  }
}
