<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLuggagePriceIdToReservationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('reservations', function (Blueprint $table) {
      $table->integer('luggage_price');  //カラム追加
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('reservations', function (Blueprint $table) {
      $table->dropColumn('luggage_price');  //カラムの削除
    });
  }
}
