<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCxlsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('cxls', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->bigInteger('bills_id')->unsigned()->index();
      $table->integer('master_subtotal');
      $table->integer('master_tax');
      $table->integer('master_total');
      $table->date('payment_limit');
      $table->string('bill_company');
      $table->string('bill_person');
      $table->date('bill_created_at');
      $table->string('bill_remark');
      $table->integer('paid');
      $table->date('pay_day');
      $table->string('pay_person');
      $table->integer('cxl_status');
      $table->integer('double_check_status');
      $table->string('double_check1_name');
      $table->string('double_check2_name');
      $table->datetime('approve_send_at');
      $table->integer('category');

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
    Schema::dropIfExists('cxls');
  }
}
