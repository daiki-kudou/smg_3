<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameCxlsIdToCxlIdOnCxlBreakdownsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('cxl_breakdowns', function (Blueprint $table) {
      $table->renameColumn('cxls_id', 'cxl_id');
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
      $table->renameColumn('cxl_id', 'cxls_id');
    });
  }
}
