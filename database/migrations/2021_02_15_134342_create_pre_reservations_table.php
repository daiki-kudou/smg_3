<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreReservationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('pre_reservations', function (Blueprint $table) {
      $table->bigIncrements('id');

      $table->bigInteger('venue_id')->unsigned()->index();
      $table->bigInteger('user_id')->unsigned()->index();
      $table->bigInteger('agent_id')->unsigned()->index();
      $table->date('reserve_date');
      $table->integer('price_system');
      $table->time('enter_time');
      $table->time('leave_time');
      $table->integer('board_flag');
      $table->time('event_start')->nullable();
      $table->time('event_finish')->nullable();
      $table->string('event_name1')->nullable();
      $table->string('event_name2')->nullable();
      $table->string('event_owner')->nullable();
      $table->string('luggage_count')->nullable();
      $table->string('luggage_arrive')->nullable();
      $table->string('luggage_return')->nullable();
      $table->integer('email_flag'); //あるかないかだけ保持
      $table->string('in_charge');
      $table->string('tel');
      $table->text('discount_condition')->nullable();
      $table->text('attention')->nullable();
      $table->text('user_details')->nullable();
      $table->text('admin_details')->nullable();




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
    Schema::dropIfExists('pre_reservations');
  }
}
