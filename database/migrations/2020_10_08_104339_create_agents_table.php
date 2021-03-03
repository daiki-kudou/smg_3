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
      $table->string('company')->nullable();
      $table->string('post_code');
      $table->string('address1');
      $table->string('address2');
      $table->string('address3');
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

      $table->string('site');
      $table->string('site_url');
      $table->string('login');
      $table->string('site_id');
      $table->string('site_pass');
      $table->text('agent_remark');
      $table->text('site_remark');
      $table->text('deal_remark');

      $table->integer('cxl');
      $table->string('cxl_url');
      $table->text('cxl_remark');
      $table->text('last_remark');


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
