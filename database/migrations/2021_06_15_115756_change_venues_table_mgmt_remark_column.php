<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeVenuesTableMgmtRemarkColumn extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('venues', function (Blueprint $table) {
      $table->text('mgmt_remark')->change();
      $table->text('reserver_remark')->change();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('venues', function (Blueprint $table) {
      $table->string('mgmt_remark')->change();
      $table->string('reserver_remark')->change();
    });
  }
}
