<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToBillsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('bills', function (Blueprint $table) {
      // $table->index('venue_price');
      // $table->index('equipment_price');
      // $table->index('layout_price');
      // $table->index('others_price');
      // $table->index('master_subtotal');
      // $table->index('master_tax');
      // $table->index('master_total');
      // $table->index('payment_limit');
      // $table->index('bill_company');
      // $table->index('bill_person');
      // $table->index('bill_created_at');
      // $table->index('paid');
      // $table->index('pay_day');
      // $table->index('pay_person');
      // $table->index('payment');
      // $table->index('reservation_status');
      // $table->index('double_check_status');
      // $table->index('double_check1_name');
      // $table->index('double_check2_name');
      // $table->index('approve_send_at');
      // $table->index('category');
      // $table->index('admin_judge');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('bills', function (Blueprint $table) {
      // $table->dropIndex('bills_venue_price_index');
      // $table->dropIndex('bills_equipment_price_index');
      // $table->dropIndex('bills_layout_price_index');
      // $table->dropIndex('bills_others_price_index');
      // $table->dropIndex('bills_master_subtotal_index');
      // $table->dropIndex('bills_master_tax_index');
      // $table->dropIndex('bills_master_total_index');
      // $table->dropIndex('bills_payment_limit_index');
      // $table->dropIndex('bills_bill_company_index');
      // $table->dropIndex('bills_bill_person_index');
      // $table->dropIndex('bills_bill_created_at_index');
      // $table->dropIndex('bills_paid_index');
      // $table->dropIndex('bills_pay_day_index');
      // $table->dropIndex('bills_pay_person_index');
      // $table->dropIndex('bills_payment_index');
      // $table->dropIndex('bills_reservation_status_index');
      // $table->dropIndex('bills_double_check_status_index');
      // $table->dropIndex('bills_double_check1_name_index');
      // $table->dropIndex('bills_double_check2_name_index');
      // $table->dropIndex('bills_approve_send_at_index');
      // $table->dropIndex('bills_category_index');
      // $table->dropIndex('bills_admin_judge_index');
    });
  }
}
