<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnitPercentToPostsCxlBreakdowns extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('cxl_breakdowns', function (Blueprint $table) {
      $table->integer('unit_percent');  //カラム追加
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('cxl_breakdowns', function (Blueprint $table) {
      $table->dropColumn('unit_percent');  //カラムの削除
    });
  }
}
