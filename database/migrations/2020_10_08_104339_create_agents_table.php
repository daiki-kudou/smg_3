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
      $table->string('post_code')->nullable();
      $table->string('address1')->nullable();
      $table->string('address2')->nullable();
      $table->string('address3')->nullable();
      $table->string('person_firstname')->nullable();
      $table->string('person_lastname')->nullable();
      $table->string('firstname_kana')->nullable();
      $table->string('lastname_kana')->nullable();
      $table->string('person_mobile')->nullable();
      $table->string('person_tel')->nullable();
      $table->string('fax')->nullable();
      $table->string('email')->nullable();
      $table->integer('cost');
      $table->integer('payment_limit');
      $table->text('payment_day')->nullable();
      $table->text('payment_remark')->nullable();
      $table->string('site')->nullable();
      $table->string('site_url')->nullable();
      $table->string('login')->nullable();
      $table->string('site_id')->nullable();
      $table->string('site_pass')->nullable();
      $table->text('agent_remark')->nullable();
      $table->text('site_remark')->nullable();
      $table->text('deal_remark')->nullable();
      $table->integer('cxl')->nullable();
      $table->string('cxl_url')->nullable();
      $table->text('cxl_remark')->nullable();
      $table->text('last_remark')->nullable();


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
