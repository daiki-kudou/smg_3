<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Service\SendSMGEmail;
use Carbon\Carbon;
use DB;


class CommandCronPayDayTwoDaysLeft extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'command:cron_pay_day_two_days_left';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = '送信用コマンド：入金期日2営業日前(催促)';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct(Reservation $reservation)
  {
    parent::__construct();
    $this->reservation = $reservation;
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {

    //キャンセルしていない予約の２営業日前抽出
    $targetPaymentLimit = $this->getSalesDate('ADD'); //addDays
    $bills = $this->masterQuery('cxls.id is null', $targetPaymentLimit);
    foreach ($bills as $b) {
      $SendSMGEmail = new SendSMGEmail();
      $SendSMGEmail->CronSend("入金期日2営業日前(催促)", ['data' => $b, 'title' => "期日のお知らせ"]);
    }

    //キャンセルしていない予約の1営業日後抽出
    $targetPaymentLimit = $this->getSalesDate('SUB'); //subDays
    $bills = $this->masterQuery('cxls.id is null', $targetPaymentLimit);
    foreach ($bills as $b) {
      $SendSMGEmail = new SendSMGEmail();
      $SendSMGEmail->CronSend("入金期日2営業日前(催促)", ['data' => $b, 'title' => "期日超過のお知らせ"]);
    }

    //キャンセルの２営業日前抽出
    $targetPaymentLimit = $this->getSalesDate('SUB'); //addDays
    $bills = $this->masterQuery('cxls.id is not null', $targetPaymentLimit);
    foreach ($bills as $b) {
      $SendSMGEmail = new SendSMGEmail();
      $SendSMGEmail->CronSend("入金期日2営業日前(催促)", ['data' => $b, 'title' => "期日のお知らせ"]);
    }

    //キャンセルの1営業日後抽出
    $targetPaymentLimit = $this->getSalesDate('SUB'); //subDays
    $bills = $this->masterQuery('cxls.id is not null', $targetPaymentLimit);
    foreach ($bills as $b) {
      $SendSMGEmail = new SendSMGEmail();
      $SendSMGEmail->CronSend("入金期日2営業日前(催促)", ['data' => $b, 'title' => "期日超過のお知らせ"]);
    }
  }

  /**
   * 営業日取得
   * @param string $add_or_sub (ADD もしくは SUB の文字列でくる)
   * @return string
   */
  public function getSalesDate($add_or_sub)
  {
    $holidays = ['20210722', '20210723', '20210808', '20210809', '20210920', '20210923', '20211103', '20211123', '20220101', '20220110', '20220211', '20220223', '20220321', '20220429', '20220503', '20220504', '20220505', '20220718', '20220811', '20220919', '20220923', '20221010', '20221103', '20221123', '20230101', '20230102', '20230109', '20230211', '20230223', '20230321', '20230429', '20230503', '20230504', '20230505', '20230717', '20230811', '20230918', '20230923', '20231009', '20231103', '20231123', '20240101', '20240108', '20240211', '20240212', '20240223', '20240320', '20240429', '20240503', '20240504', '20240505', '20240506', '20240715', '20240811', '20240812', '20240916', '20240922', '20240923', '20241014', '20241103', '20241104', '20241123', '20250101', '20250113', '20250211', '20250223', '20250224', '20250320', '20250429', '20250503', '20250504', '20250505', '20250506', '20250721', '20250811', '20250915', '20250923', '20251013', '20251103', '20251123', '20251124', '20260101', '20260112', '20260211', '20260223', '20260320', '20260429', '20260503', '20260504', '20260505', '20260506', '20260720', '20260811', '20260921', '20260922', '20260923', '20261012', '20261103', '20261123', '20270101', '20270111', '20270211', '20270223', '20270321', '20270322', '20270429', '20270503', '20270504', '20270505', '20270719', '20270811', '20270920', '20270923', '20271011', '20271103', '20271123', '20280101', '20280110', '20280211', '20280223', '20280320', '20280429', '20280503', '20280504', '20280505', '20280717', '20280811', '20280918', '20280922', '20281009', '20281103', '20281123', '20290101', '20290108', '20290211', '20290212', '20290223', '20290320', '20290429', '20290430', '20290503', '20290504', '20290505', '20290716', '20290811', '20290917', '20290923', '20290924', '20291008', '20291103', '20291123', '20300101', '20300114', '20300211', '20300223', '20300320', '20300429', '20300503', '20300504', '20300505', '20300506', '20300715', '20300811', '20300812', '20300916', '20300923', '20301014', '20301103', '20301104', '20301123', '20310101', '20310113', '20310211', '20310223', '20310224', '20310321', '20310429', '20310503', '20310504', '20310505', '20310506', '20310721', '20310811', '20310915', '20310923', '20311013', '20311103', '20311123', '20311124', '20320101', '20320112', '20320211', '20320223', '20320320', '20320429', '20320503', '20320504', '20320505', '20320719', '20320811', '20320920', '20320921', '20320922', '20321011', '20321103', '20321123', '20330101', '20330110', '20330211', '20330223', '20330320', '20330321', '20330429', '20330503', '20330504', '20330505', '20330718', '20330811', '20330919', '20330923', '20331010', '20331103', '20331123', '20340101', '20340102', '20340109', '20340211', '20340223', '20340320', '20340429', '20340503', '20340504', '20340505', '20340717', '20340811', '20340918', '20340923', '20341009', '20341103', '20341123', '20350101', '20350108', '20350211', '20350212', '20350223', '20350321', '20350429', '20350430', '20350503', '20350504', '20350505', '20350716', '20350811', '20350917', '20350923', '20350924', '20351008', '20351103', '20351123', '20360101', '20360114', '20360211', '20360223', '20360320', '20360429', '20360503', '20360504', '20360505', '20360506', '20360721', '20360811', '20360915', '20360922', '20361013', '20361103', '20361123', '20361124',];
    $tarAry = [];
    for ($i = 1; $i <= 14; $i++) {
      $today = Carbon::today();
      $add_or_sub_day = ($add_or_sub === "ADD" ? $today->addDays($i) : $today->subDays($i));
      if (!$add_or_sub_day->isSaturday() && !$add_or_sub_day->isSunday() && !in_array(date('Ymd', strtotime($add_or_sub_day)), $holidays)) {
        $tarAry[] = date('Y-m-d', strtotime($add_or_sub_day));
      }
    }
    if ($add_or_sub === "ADD") {
      $targetPaymentLimit = $tarAry[1]; //配列のindex1番目が2営業日後の日付
    } else {
      $targetPaymentLimit = $tarAry[0]; //配列のindex0番目が1営業日前の日付
    }
    return $targetPaymentLimit;
  }

  /**
   * Undocumented function
   *
   * @param string $include_cxl_or_not (cxls.id is null もしくは　cxls.id is not null がくる)
   * @param string $target_payment_limit 特定の支払い期日の日付が ○○○-○○-○○で来る
   * @return object HITした collection が返る
   */
  public function masterQuery($include_cxl_or_not, $target_payment_limit)
  {
    $bills = DB::table('bills')
      ->select(DB::raw(
        "
        LPAD(reservations.id,6,0) as reservation_id,
        bills.id as bill_id,
        cxls.id as cxl_id,
        users.email as user_email,
        users.company as company,
        case when cxls.id is null then (case when bills.category = 1 then '会場予約' when bills.category = 2 then '追加請求' end) when cxls.id is not null then 'キャンセル' end as category,
        LPAD(users.id,6,0) as user_id,
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
        concat(venues.name_area, venues.name_bldg, venues.name_venue) as venue_name,
        bills.invoice_number as invoice_number,
        format(bills.master_total,0) as master_total,
        case when cxls.payment_limit is null then bills.payment_limit else cxls.payment_limit end as payment_limit,
        venues.smg_url as smg_url
        "
      ))
      ->leftJoin('reservations', 'reservations.id', '=', 'bills.reservation_id')
      ->leftJoin('cxls', 'cxls.reservation_id', '=', 'reservations.id')
      ->leftJoin('users', 'reservations.user_id', '=', 'users.id')
      ->leftJoin('venues', 'venues.id', '=', 'reservations.venue_id')
      ->whereRaw('reservations.deleted_at is null and bills.deleted_at is null')
      ->whereRaw($include_cxl_or_not)
      ->havingRaw('payment_limit =?', [$target_payment_limit])
      ->get();

    return $bills;
  }
}
