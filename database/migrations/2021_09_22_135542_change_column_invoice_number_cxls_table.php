<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnInvoiceNumberCxlsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('cxls', function (Blueprint $table) {
      $table->bigInteger('invoice_number')->change();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('cxls', function (Blueprint $table) {
      $table->integer('invoice_number')->change();
    });
  }
}
