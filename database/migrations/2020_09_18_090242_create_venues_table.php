<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVenuesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('venues', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->integer('alliance_flag');
      $table->string('name_area');
      $table->string('name_bldg');
      $table->string('name_venue');
      $table->double('size1', 3, 1); //上限3桁、小数点1
      $table->double('size2', 3, 1); //上限3桁、小数点1
      $table->integer('capacity');
      $table->integer('eat_in_flag');
      $table->string('post_code');
      $table->string('address1');
      $table->string('address2');
      $table->string('address3');
      $table->text('remark')->nullable();
      $table->string('first_name')->nullable();
      $table->string('last_name')->nullable();
      $table->string('first_name_kana')->nullable();
      $table->string('last_name_kana')->nullable();
      $table->string('person_tel')->nullable();
      $table->string('person_email')->nullable();
      $table->integer('luggage_flag');
      $table->string('luggage_post_code')->nullable();
      $table->string('luggage_address1')->nullable();
      $table->string('luggage_address2')->nullable();
      $table->string('luggage_address3')->nullable();
      $table->string('luggage_name')->nullable();
      $table->string('luggage_tel')->nullable();
      $table->integer('cost')->nullable();
      // 以下、追加
      $table->string('mgmt_company')->nullable();
      $table->string('mgmt_tel')->nullable();
      $table->string('mgmt_emer_tel')->nullable();
      $table->string('mgmt_first_name')->nullable();
      $table->string('mgmt_last_name')->nullable();
      $table->string('mgmt_person_tel')->nullable();
      $table->string('mgmt_email')->nullable();
      $table->string('mgmt_sec_company')->nullable();
      $table->string('mgmt_sec_tel')->nullable();
      $table->string('mgmt_remark')->nullable();
      $table->string('smg_url');
      $table->string('entrance_open_time')->nullable();
      $table->string('backyard_open_time')->nullable();
      // 2020/12/9 追加
      $table->string('layout');
      // 12/15追加
      $table->integer('layout_prepare')->nullable();
      $table->integer('layout_clean')->nullable();
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
    // 無効化
    // Schema::disableForeignKeyConstraints();

    Schema::dropIfExists('venues');
    // 有効化
    // Schema::enableForeignKeyConstraints();
  }
}
