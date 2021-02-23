<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreEndusersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('pre_endusers', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->integer('pre_reservations_id')->unsigned()->index();
      $table->string('company')->nullable();
      $table->string('person')->nullable();
      $table->string('email')->nullable();
      $table->string('mobile')->nullable();
      $table->string('tel')->nullable();

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
    Schema::dropIfExists('pre_endusers');
  }
}
