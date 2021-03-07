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
      $table->bigInteger('bill_id')->unsigned()->index();
      $table->integer('master_subtotal');
      $table->integer('master_tax');
      $table->integer('master_total');
      $table->date('payment_limit');
      $table->string('bill_company');
      $table->string('bill_person');
      $table->date('bill_created_at');
      $table->string('bill_remark')->nullable();
      $table->integer('paid')->nullable();
      $table->date('pay_day')->nullable();
      $table->string('pay_person')->nullable();
      $table->string('payment')->nullable();
      $table->integer('cxl_status');
      $table->integer('double_check_status')->nullable();
      $table->string('double_check1_name')->nullable();
      $table->string('double_check2_name')->nullable();
      $table->datetime('approve_send_at')->nullable();
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
