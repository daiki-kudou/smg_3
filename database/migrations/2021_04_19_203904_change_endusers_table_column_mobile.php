<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeEndusersTableColumnMobile extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('endusers', function (Blueprint $table) {
      $table->string('mobile')->nullable()->change();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('endusers', function (Blueprint $table) {
      $table->string('mobile')->nullable(false)->change();
    });
  }
}
