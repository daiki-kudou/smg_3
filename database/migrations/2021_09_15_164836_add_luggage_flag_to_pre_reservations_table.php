<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLuggageFlagToPreReservationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('pre_reservations', function (Blueprint $table) {
      $table->integer('luggage_flag');  //カラム追加
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('pre_reservations', function (Blueprint $table) {
      $table->dropColumn('luggage_flag');  //カラムの削除
    });
  }
}
