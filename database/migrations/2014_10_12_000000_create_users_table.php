<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('users', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('email')->unique();
      // $table->timestamp('email_verified_at')->nullable();
      $table->string('password');
      $table->string('company')->comment('会社名');
      $table->string('post_code')->nullable();
      $table->string('address1')->nullable();
      $table->string('address2')->nullable();
      $table->string('address3')->nullable();
      $table->string('address_remark')->nullable()->comment('住所備考');
      $table->string('url')->nullable()->comment('会社URL');
      $table->integer('attr')->nullable()->comment('顧客属性');
      $table->text('condition')->nullable()->comment('割引条件');
      $table->string('first_name');
      $table->string('last_name');
      $table->string('first_name_kana');
      $table->string('last_name_kana');
      $table->string('mobile');
      $table->string('tel')->nullable();
      $table->string('fax')->nullable();
      $table->integer('pay_method')->comment('支払方法');
      $table->integer('pay_limit')->comment('支払い期限');
      $table->string('pay_post_code')->nullable();
      $table->string('pay_address1')->nullable();
      $table->string('pay_address2')->nullable();
      $table->string('pay_address3')->nullable();
      $table->string('pay_remark')->nullable()->comment('請求備考');
      $table->string('attention')->nullable()->comment('注意事項');
      $table->string('remark')->nullable()->comment('備考');
      $table->integer('status')->comment('会員なのか、退会したのか？');
      $table->integer('admin_or_user'); //1なら管理者 2ならユーザー

      $table->rememberToken();
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
    Schema::dropIfExists('users');
  }
}
