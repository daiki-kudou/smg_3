<?php

namespace App\Jobs\Reservation;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Reservation;
use App\Models\Bill;
use App\Models\Breakdown;
use App\Mail\UserDelRes;
use App\Mail\FailedMail;
use Carbon\Carbon;
use Mail;

class MailForDeleteReservation implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public $data;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct($data)
  {
    $this->data = $data;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $admin = config('app.admin_email');
    $reservation_data = $this->adjustReservationData();
    $subject = "【会議室｜[予約情報：会場予約]：" . $reservation_data->reservation_id . "】予約申込み取消しのお知らせ（SMG貸し会議室）";
    $bill_data = $this->adjustBillData();
    $equipment_data = $this->equipmentsData();
    $service_data = $this->servicesData();
    $layout_data = $this->layoutsData();
    Mail::to($reservation_data->user_email)
      ->cc($admin)
      ->send(new UserDelRes(
        $reservation_data,
        $subject,
        $bill_data,
        $equipment_data,
        $service_data,
        $layout_data,
      ));

    // メール送付完了後に削除処理
    Reservation::find($this->data['reservation_id'])->delete();
  }

  public function adjustReservationData()
  {
    $reservation = new Reservation();
    return $reservation->ReservationEmailTemplate($this->data['reservation_id']);
  }

  public function adjustBillData()
  {
    $bill = new Bill;
    return $bill->BillEmailTemplate($this->data['bill_id']);
  }

  public function equipmentsData()
  {
    return Breakdown::where('bill_id', $this->data['bill_id'])->where('unit_type', 2)->get()->toArray();
  }

  public function servicesData()
  {
    return Breakdown::where('bill_id', $this->data['bill_id'])->where('unit_type', 3)->get()->toArray();
  }

  public function layoutsData()
  {
    $ary = [];
    foreach (Breakdown::where('bill_id', $this->data['bill_id'])->where('unit_type', 4)->get() as $key => $value) {
      if ((string)$value->unit_item === "レイアウト準備料金") {
        $ary[] = "レイアウト準備：あり";
      } elseif ((string)$value->unit_item === "レイアウト片付料金") {
        $ary[] = "レイアウト片付け：あり";
      }
    }
    return $ary;
  }

  /**
   * 失敗したジョブの処理
   *
   * @param  Exception  $exception
   * @return void
   */
  public function failed($exception)
  {
    $admin = config('app.admin_email');
    $class_name = get_class($this);
    $time = Carbon::now();
    Mail::to($admin)
      ->send(new FailedMail($exception, $class_name, $time));
  }
}
