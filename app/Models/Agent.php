<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use App\Presenters\AgentPresenter; //個別作成したプレゼンターの追加
use Robbo\Presenter\PresentableInterface; //プレゼンターの追加

use Illuminate\Support\Facades\DB;

class Agent extends Model implements PresentableInterface
{
  protected $fillable = [
    "name",
    "company",
    "post_code",
    "address1",
    "address2",
    "address3",
    "address_remark",
    "url",
    "attr",
    "remark",
    "person_firstname",
    "person_lastname",
    "firstname_kana",
    "lastname_kana",
    "person_mobile",
    "person_tel",
    "fax",
    "email",
    "cost",
    "payment_limit",
    "payment_day",
    "payment_remark",
    "site",
    "site_url",
    "login",
    "site_id",
    "site_pass",
    "agent_remark",
    "site_remark",
    "deal_remark",
    "cxl",
    "cxl_url",
    "cxl_remark",
    "last_remark",
  ];


  // プレゼンター連携
  /**
   * @var mixed
   */
  private $payment_limit;

  /**
   * Return a created presenter.
   *
   * @return Robbo\Presenter\Presenter|AgentPresenter
   */
  public function getPresenter()
  {
    return new AgentPresenter($this);
  }

  public function StoreAgent($request)
  {
    DB::transaction(function () use ($request) {
      $this->create([
        "name" => $request->name,
        "company" => $request->company,
        "post_code" => $request->post_code,
        "address1" => $request->address1,
        "address2" => $request->address2,
        "address3" => $request->address3,
        "person_firstname" => $request->person_firstname,
        "person_lastname" => $request->person_lastname,
        "firstname_kana" => $request->firstname_kana,
        "lastname_kana" => $request->lastname_kana,
        "person_mobile" => $request->person_mobile,
        "person_tel" => $request->person_tel,
        "fax" => $request->fax,
        "email" => $request->email,
        "cost" => $request->cost,
        "payment_limit" => $request->payment_limit,
        "payment_day" => $request->payment_day,
        "payment_remark" => $request->payment_remark,
        "site" => $request->site,
        "site_url" => $request->site_url,
        "login" => $request->login,
        "site_id" => $request->site_id,
        "site_pass" => $request->site_pass,
        "agent_remark" => $request->agent_remark,
        "site_remark" => $request->site_remark,
        "deal_remark" => $request->deal_remark,
        "cxl" => $request->cxl,
        "cxl_url" => $request->cxl_url,
        "cxl_remark" => $request->cxl_remark,
        "last_remark" => $request->last_remark,
      ]);
    });
  }

  public function updateAgent($request)
  {
    DB::transaction(function () use ($request) {
      $this->update([
        "name" => $request->name,
        "company" => $request->company,
        "post_code" => $request->post_code,
        "address1" => $request->address1,
        "address2" => $request->address2,
        "address3" => $request->address3,
        "person_firstname" => $request->person_firstname,
        "person_lastname" => $request->person_lastname,
        "firstname_kana" => $request->firstname_kana,
        "lastname_kana" => $request->lastname_kana,
        "person_mobile" => $request->person_mobile,
        "person_tel" => $request->person_tel,
        "fax" => $request->fax,
        "email" => $request->email,
        "cost" => $request->cost,
        "payment_limit" => $request->payment_limit,
        "payment_day" => $request->payment_day,
        "payment_remark" => $request->payment_remark,
        "site" => $request->site,
        "site_url" => $request->site_url,
        "login" => $request->login,
        "site_id" => $request->site_id,
        "site_pass" => $request->site_pass,
        "agent_remark" => $request->agent_remark,
        "site_remark" => $request->site_remark,
        "deal_remark" => $request->deal_remark,
        "cxl" => $request->cxl,
        "cxl_url" => $request->cxl_url,
        "cxl_remark" => $request->cxl_remark,
        "last_remark" => $request->last_remark,
      ]);
    });
  }



  /*
|--------------------------------------------------------------------------
| 会場と予約の一対多
|--------------------------------------------------------------------------|
*/
  public function reservations(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany(Reservation::class);
  }

  public function pre_reservations(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany(PreReservation::class);
  }


  public function getPayDetails($date)
  {
    $date = Carbon::parse($date);
    $limit = "";
    // 1:当月末　2:翌月末　3:翌々月末
    if ($this->payment_limit == 1) {
      $limit = $date->endOfMonth();
    } elseif ($this->payment_limit == 2) {
      $limit = $date->addMonthsNoOverflow(1);
    } elseif ($this->payment_limit == 3) {
      $limit = $date->addMonthsNoOverflow(2);
    } elseif ($this->payment_limit == 4) {
      $limit = $date->addMonthsNoOverflow(3);
    }
    $result = new Carbon($limit);
    return date("Y-m-d", strtotime($result));
  }

  public function agentPriceCalculate($end_user_charge)
  {
    $percent = $this->cost;
    $percent = $percent / 100;
    return $end_user_charge - ($end_user_charge * $percent);
  }

  public function getAgentPayLimit($reserve_date)
  {
    $date = Carbon::parse($reserve_date);

    $payment_limit = (int)$this['payment_limit'];

    switch ($payment_limit) {
      case 1:
        return date('Y-m-d', strtotime($date->endOfMonth()));
        break;
      case 2:
        $months = 1; // 追加する月数
        $result = $date->day(1)->addMonths($months)->endOfMonth();
        return date('Y-m-d', strtotime($result));
        break;
      case 3:
        $months = 2; // 追加する月数
        $result = $date->day(1)->addMonths($months)->endOfMonth();
        return date('Y-m-d', strtotime($result));
        break;
      case 4:
        $months = 3; // 追加する月数
        $result = $date->day(1)->addMonths($months)->endOfMonth();
        return date('Y-m-d', strtotime($result));
        break;
      default:
        return NULL;
        break;
    }
  }
}
