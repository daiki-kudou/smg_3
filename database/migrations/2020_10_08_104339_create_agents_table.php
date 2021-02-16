<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('agents', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('name');
      $table->string('post_code');
      $table->string('address1');
      $table->string('address2');
      $table->string('address3');
      $table->text('address_remark');
      $table->string('url');
      $table->string('attr');
      $table->text('remark');
      $table->string('person_firstname');
      $table->string('person_lastname');
      $table->string('firstname_kana');
      $table->string('lastname_kana');
      $table->string('person_mobile');
      $table->string('person_tel');
      $table->string('fax');
      $table->string('email');
      $table->integer('cost');
      $table->integer('payment_limit');
      $table->text('payment_day');
      $table->text('payment_remark');

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
    Schema::dropIfExists('agents');
  }
}
