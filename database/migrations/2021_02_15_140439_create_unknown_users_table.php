<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnknownUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('unknown_users', function (Blueprint $table) {
      $table->bigIncrements('id');

      $table->bigInteger('pre_reservation_id')->unsigned()->index();

      $table->string('unknown_user_company');
      $table->string('unknown_user_name');
      $table->string('unknown_user_email');
      $table->string('unknown_user_mobile');
      $table->string('unknown_user_tel');

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('unknown_users');
  }
}
