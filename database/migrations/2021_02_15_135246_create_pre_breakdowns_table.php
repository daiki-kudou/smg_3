<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreBreakdownsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('pre_breakdowns', function (Blueprint $table) {
      $table->bigIncrements('id');

      $table->bigInteger('pre_bill_id')->unsigned()->index();
      $table->string('unit_item');
      $table->integer('unit_cost');
      $table->string('unit_count');
      $table->integer('unit_subtotal');
      $table->integer('unit_type');


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
    Schema::dropIfExists('pre_breakdowns');
  }
}
