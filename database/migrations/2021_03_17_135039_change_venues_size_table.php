<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeVenuesSizeTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('venues', function (Blueprint $table) {
      $table->string('size1')->change();
      $table->string('size2')->change();
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
      $table->integer('size1')->change();
      $table->integer('size2')->change();
    });
  }
}
