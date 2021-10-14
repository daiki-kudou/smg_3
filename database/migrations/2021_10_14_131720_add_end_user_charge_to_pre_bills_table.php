<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEndUserChargeToPreBillsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('pre_bills', function (Blueprint $table) {
      $table->integer('end_user_charge');  //カラム追加

    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('pre_bills', function (Blueprint $table) {
      $table->dropColumn('end_user_charge');  //カラムの削除
    });
  }
}
