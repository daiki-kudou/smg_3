<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEatinToReservationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('reservations', function (Blueprint $table) {
      $table->integer('eat_in');
      $table->integer('eat_in_prepare');
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
      $table->dropColumn('eat_in');
      $table->dropColumn('eat_in_prepare');
    });
  }
}
