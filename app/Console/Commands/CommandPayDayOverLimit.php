<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Service\SendSMGEmail;
use Carbon\Carbon;
use DB;


class CommandPayDayOverLimit extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'command:cron_pay_day_over_limit';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = '送信用コマンド：支払い期日超過';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {

    $targetPaymentLimit = $this->getSalesDate();
    if ($targetPaymentLimit) {
      // キャンセルしていない予約の1営業日後抽出
      $bills = $this->BillQuey($targetPaymentLimit);
      foreach ($bills as $b) {
        $SendSMGEmail = new SendSMGEmail();
        $SendSMGEmail->CronSend("入金期日超過(督促)", $b);
      }

      //キャンセルの1営業日後抽出
      $cxls = $this->CxlQuey($targetPaymentLimit);
      foreach ($cxls as $c) {
        $SendSMGEmail = new SendSMGEmail();
        $SendSMGEmail->CronSend("入金期日超過(督促)", $c);
      }
    }
  }

  /**
   * 営業日取得
   * @return string
   */
  public function getSalesDate()
  {
    $holidays = ['20210722', '20210723', '20210808', '20210809', '20210920', '20210923', '20211103', '20211123', '20220101', '20220110', '20220211', '20220223', '20220321', '20220429', '20220503', '20220504', '20220505', '20220718', '20220811', '20220919', '20220923', '20221010', '20221103', '20221123', '20230101', '20230102', '20230109', '20230211', '20230223', '20230321', '20230429', '20230503', '20230504', '20230505', '20230717', '20230811', '20230918', '20230923', '20231009', '20231103', '20231123', '20240101', '20240108', '20240211', '20240212', '20240223', '20240320', '20240429', '20240503', '20240504', '20240505', '20240506', '20240715', '20240811', '20240812', '20240916', '20240922', '20240923', '20241014', '20241103', '20241104', '20241123', '20250101', '20250113', '20250211', '20250223', '20250224', '20250320', '20250429', '20250503', '20250504', '20250505', '20250506', '20250721', '20250811', '20250915', '20250923', '20251013', '20251103', '20251123', '20251124', '20260101', '20260112', '20260211', '20260223', '20260320', '20260429', '20260503', '20260504', '20260505', '20260506', '20260720', '20260811', '20260921', '20260922', '20260923', '20261012', '20261103', '20261123', '20270101', '20270111', '20270211', '20270223', '20270321', '20270322', '20270429', '20270503', '20270504', '20270505', '20270719', '20270811', '20270920', '20270923', '20271011', '20271103', '20271123', '20280101', '20280110', '20280211', '20280223', '20280320', '20280429', '20280503', '20280504', '20280505', '20280717', '20280811', '20280918', '20280922', '20281009', '20281103', '20281123', '20290101', '20290108', '20290211', '20290212', '20290223', '20290320', '20290429', '20290430', '20290503', '20290504', '20290505', '20290716', '20290811', '20290917', '20290923', '20290924', '20291008', '20291103', '20291123', '20300101', '20300114', '20300211', '20300223', '20300320', '20300429', '20300503', '20300504', '20300505', '20300506', '20300715', '20300811', '20300812', '20300916', '20300923', '20301014', '20301103', '20301104', '20301123', '20310101', '20310113', '20310211', '20310223', '20310224', '20310321', '20310429', '20310503', '20310504', '20310505', '20310506', '20310721', '20310811', '20310915', '20310923', '20311013', '20311103', '20311123', '20311124', '20320101', '20320112', '20320211', '20320223', '20320320', '20320429', '20320503', '20320504', '20320505', '20320719', '20320811', '20320920', '20320921', '20320922', '20321011', '20321103', '20321123', '20330101', '20330110', '20330211', '20330223', '20330320', '20330321', '20330429', '20330503', '20330504', '20330505', '20330718', '20330811', '20330919', '20330923', '20331010', '20331103', '20331123', '20340101', '20340102', '20340109', '20340211', '20340223', '20340320', '20340429', '20340503', '20340504', '20340505', '20340717', '20340811', '20340918', '20340923', '20341009', '20341103', '20341123', '20350101', '20350108', '20350211', '20350212', '20350223', '20350321', '20350429', '20350430', '20350503', '20350504', '20350505', '20350716', '20350811', '20350917', '20350923', '20350924', '20351008', '20351103', '20351123', '20360101', '20360114', '20360211', '20360223', '20360320', '20360429', '20360503', '20360504', '20360505', '20360506', '20360721', '20360811', '20360915', '20360922', '20361013', '20361103', '20361123', '20361124',];
    $tarAry = [];

    for ($i = 1; $i <= 14; $i++) {
      $today = Carbon::today();

      // 実行日が土日祝の場合、実行しない
      if ($today->isSaturday() || $today->isSunday() || in_array(date('Ymd', strtotime($today)), $holidays)) {
        return false;
      }

      $add_or_sub_day = $today->subDays($i);

      if (!$add_or_sub_day->isSaturday() && !$add_or_sub_day->isSunday() && !in_array(date('Ymd', strtotime($add_or_sub_day)), $holidays)) {
        $tarAry[] = date('Y-m-d', strtotime($add_or_sub_day));
        break;
      } else {
        $tarAry[] = date('Y-m-d', strtotime($add_or_sub_day));
      }
    }

    $targetPaymentLimit = '';
    foreach ($tarAry as $index => $date) {
      if ($index === 0) {
        $targetPaymentLimit = "'" . $date . "'";
      } else {
        $targetPaymentLimit = $targetPaymentLimit . ", '" . $date . "'";
      }
    }

    return $targetPaymentLimit;
  }

  public function BillQuey($targetPaymentLimit)
  {
    $bills = DB::table('bills')
      ->select(DB::raw(
        "
        lpad(bills.reservation_id,6,0) as reservation_id,
        bills.id as bill_id,
        bills.reservation_status as status,
        format(bills.master_total,0) as master_total,
        case when bills.category = 1 then '会場予約' else '追加請求' end as category,
        cxls_list.cxl_reservation_id as cxl_reservation_id,
        lpad(users.id,6,0) as user_id,
        users.email as user_email,
        users.company as company,
        concat(date_format(reservations.reserve_date, '%Y/%m/%d'),
        case 
        when DAYOFWEEK(reservations.reserve_date) = 1 then '(日)' 
        when DAYOFWEEK(reservations.reserve_date) = 2 then '(月)'
        when DAYOFWEEK(reservations.reserve_date) = 3 then '(火)'
        when DAYOFWEEK(reservations.reserve_date) = 4 then '(水)'
        when DAYOFWEEK(reservations.reserve_date) = 5 then '(木)'
        when DAYOFWEEK(reservations.reserve_date) = 6 then '(金)'
        when DAYOFWEEK(reservations.reserve_date) = 7 then '(土)'
        end
        ) as reserve_date,
        time_format(reservations.enter_time, '%H:%i') as enter_time,
        time_format(reservations.leave_time, '%H:%i') as leave_time,
        concat(venues.name_area,venues.name_bldg,venues.name_venue) as venue_name,
        case when cxls_list.cxl_reservation_id is null then bills.invoice_number else null end as invoice_number,
        concat(date_format(bills.payment_limit, '%Y/%m/%d'),
        case 
        when DAYOFWEEK(bills.payment_limit) = 1 then '(日)' 
        when DAYOFWEEK(bills.payment_limit) = 2 then '(月)'
        when DAYOFWEEK(bills.payment_limit) = 3 then '(火)'
        when DAYOFWEEK(bills.payment_limit) = 4 then '(水)'
        when DAYOFWEEK(bills.payment_limit) = 5 then '(木)'
        when DAYOFWEEK(bills.payment_limit) = 6 then '(金)'
        when DAYOFWEEK(bills.payment_limit) = 7 then '(土)'
        end
        ) as payment_limit,
        venues.smg_url as smg_url,
        bills.paid as paid
        "
      ))
      ->leftJoin(DB::raw('(select cxls.reservation_id as cxl_reservation_id, cxls.master_total as master_total, cxls.invoice_number as invoice_number, cxls.payment_limit as payment_limit from cxls ) as cxls_list'), 'bills.reservation_id', '=', 'cxls_list.cxl_reservation_id')
      ->leftJoin('reservations', 'reservations.id', '=', 'bills.reservation_id')
      ->leftJoin('users', 'reservations.user_id', '=', 'users.id')
      ->leftJoin('venues', 'venues.id', '=', 'reservations.venue_id')
      ->whereRaw('reservations.deleted_at is null and bills.deleted_at is null and bills.reservation_status = 3 and users.id > 0')
      ->whereRaw('bills.paid in (0, 2)')
      ->whereRaw('bills.payment_limit in (' . $targetPaymentLimit . ')')->get();
    return $bills;
  }

  public function CxlQuey($targetPaymentLimit)
  {
    $cxls = DB::table('cxls')
      ->select(DB::raw(
        "
        lpad(cxls.reservation_id,6,0) as reservation_id,
        cxls.id,
        cxls.cxl_status,
        format(cxls.master_total,0) as master_total,
        'キャンセル' as category,
        lpad(users.id,6,0) as user_id,
        users.email as user_email,
        users.company as company,
        concat(date_format(reservations.reserve_date, '%Y/%m/%d'),
        case 
        when DAYOFWEEK(reservations.reserve_date) = 1 then '(日)' 
        when DAYOFWEEK(reservations.reserve_date) = 2 then '(月)'
        when DAYOFWEEK(reservations.reserve_date) = 3 then '(火)'
        when DAYOFWEEK(reservations.reserve_date) = 4 then '(水)'
        when DAYOFWEEK(reservations.reserve_date) = 5 then '(木)'
        when DAYOFWEEK(reservations.reserve_date) = 6 then '(金)'
        when DAYOFWEEK(reservations.reserve_date) = 7 then '(土)'
        end
        ) as reserve_date,
        time_format(reservations.enter_time, '%H:%i') as enter_time,
        time_format(reservations.leave_time, '%H:%i') as leave_time,
        concat(venues.name_area,venues.name_bldg,venues.name_venue) as venue_name,
        cxls.invoice_number as invoice_number,
        concat(date_format(cxls.payment_limit, '%Y/%m/%d'),
        case 
        when DAYOFWEEK(cxls.payment_limit) = 1 then '(日)' 
        when DAYOFWEEK(cxls.payment_limit) = 2 then '(月)'
        when DAYOFWEEK(cxls.payment_limit) = 3 then '(火)'
        when DAYOFWEEK(cxls.payment_limit) = 4 then '(水)'
        when DAYOFWEEK(cxls.payment_limit) = 5 then '(木)'
        when DAYOFWEEK(cxls.payment_limit) = 6 then '(金)'
        when DAYOFWEEK(cxls.payment_limit) = 7 then '(土)'
        end
        ) as payment_limit,
        venues.smg_url as smg_url,
        cxls.paid as paid
        "
      ))
      ->leftJoin('reservations', 'reservations.id', '=', 'cxls.reservation_id')
      ->leftJoin('users', 'reservations.user_id', '=', 'users.id')
      ->leftJoin('venues', 'venues.id', '=', 'reservations.venue_id')
      ->whereRaw('reservations.deleted_at is null and users.id > 0')
      ->whereRaw('cxls.paid in (0, 2)')
      ->whereRaw('cxls.cxl_status = 2')
      ->whereRaw('cxls.payment_limit in (' . $targetPaymentLimit . ')')->get();

    return $cxls;
  }
}
