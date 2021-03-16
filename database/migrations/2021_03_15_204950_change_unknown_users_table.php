<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeUnknownUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('unknown_users', function (Blueprint $table) {
      $table->string('unknown_user_company')->nullable()->change();
      $table->string('unknown_user_name')->nullable()->change();
      $table->string('unknown_user_email')->nullable()->change();
      $table->string('unknown_user_mobile')->nullable()->change();
      $table->string('unknown_user_tel')->nullable()->change();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('unknown_users', function (Blueprint $table) {
      $table->string('unknown_user_company')->nullable(false)->change();
      $table->string('unknown_user_name')->nullable(false)->change();
      $table->string('unknown_user_email')->nullable(false)->change();
      $table->string('unknown_user_mobile')->nullable(false)->change();
      $table->string('unknown_user_tel')->nullable(false)->change();
    });
  }
}
