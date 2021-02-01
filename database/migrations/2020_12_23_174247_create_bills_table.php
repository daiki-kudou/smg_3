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

      $table->integer('venue_price');

      $table->integer('equipment_price');

      $table->integer('layout_price');

      $table->integer('others_price');

      $table->integer('master_subtotal');
      $table->integer('master_tax');
      $table->integer('master_total');


      $table->date('payment_limit'); //該当予約の支払い期日
      $table->string('bill_company'); //請求書の会社名　デフォルトは顧客名
      $table->string('bill_person'); //請求書の担当者名　デフォルトは顧客の担当者
      $table->date('bill_created_at'); //請求書作成日　デフォルトはtimestamp
      $table->string('bill_remark')->nullable(); //請求書備考　デフォルト空白

      $table->integer('paid'); //支払い状況、未入金か？入金済みか？　デフォルトは0で未入金
      $table->date('pay_day')->nullable();
      $table->string('pay_person')->nullable();
      $table->integer('payment')->nullable();


      $table->integer('reservation_status'); //予約状況　0:仮抑え　1:予約確認中　2予約承認待ち　3:予約完了　4:キャンセル申請中　5:キャンセル承認待ち　6:キャンセル
      $table->integer('double_check_status'); //ダブルチェックのフラグ 0:未　1:一人済　2:二人済
      $table->string('double_check1_name')->nullable(); //ダブルチェック一人目
      $table->string('double_check2_name')->nullable(); //ダブルチェック一人目
      $table->datetime('approve_send_at')->nullable(); //ダブルチェック後の承認メールにてユーザーにメールが送付される

      $table->string('category');

      $table->string('admin_judge'); //1なら管理者が予約　2ならユーザーが予約

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
