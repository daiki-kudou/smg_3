<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEndusersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('endusers', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->integer('reservation_id')->unsigned()->index();
      $table->string('company')->nullable();
      $table->string('person')->nullable();
      $table->string('address')->nullable();
      $table->string('tel')->nullable();
      $table->string('email')->nullable();
      $table->string('attr')->nullable();
      $table->string('charge')->nullable();

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
    Schema::dropIfExists('endusers');
  }
}
