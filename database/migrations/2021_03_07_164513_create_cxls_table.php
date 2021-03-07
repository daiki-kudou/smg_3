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
      $table->integer('subtotal');
      $table->integer('tax');
      $table->integer('total');

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
