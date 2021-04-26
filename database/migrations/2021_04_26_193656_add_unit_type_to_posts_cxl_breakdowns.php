<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnitTypeToPostsCxlBreakdowns extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('cxl_breakdowns', function (Blueprint $table) {
      $table->integer('unit_percent_type');  //カラム追加
      //1: 会場　2:備品 3: レイアウト 4:その他
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
      $table->dropColumn('unit_percent_type');  //カラムの削除
    });
  }
}
