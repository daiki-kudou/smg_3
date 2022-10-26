<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\DB; //トランザクション用

use App\Models\Venue;
use App\Models\User;
use App\Models\Cxl;
use App\Models\Enduser;
use Illuminate\Support\Collection;

use Carbon\Carbon;

use App\Presenters\ReservationPresenter;
use Robbo\Presenter\PresentableInterface; //プレゼンターの追加

use App\Traits\InvoiceTrait;
use App\Traits\SearchTrait;
use App\Traits\TransactionTrait;


class Reservation extends Model implements PresentableInterface
{
	use InvoiceTrait;
	use SearchTrait;
	use TransactionTrait;


	public function getPresenter() //実装したプレゼンタを利用
	{
		return new ReservationPresenter($this);
	}

	use SoftDeletes; //reservation大事なのでソフトデリートする

	protected $fillable = [
		'venue_id',
		'user_id',
		'agent_id',
		'reserve_date',
		'price_system',
		'enter_time',
		'leave_time',
		'event_start',
		'event_finish',
		'board_flag',
		'event_name1',
		'event_name2',
		'event_owner',
		'luggage_flag',
		'luggage_count',
		'luggage_arrive',
		'luggage_return',
		'luggage_price',
		'email_flag',
		'in_charge',
		'tel',
		'email_send',
		'cost',
		'discount_condition',
		'attention',
		'user_details',
		'admin_details',
		'payment_limit',
		'reservation_status',
		'double_check_status',
		'double_check1_name',
		'double_check2_name',
		'bill_company',
		'bill_person',
		'bill_created_at',
		'bill_pay_limit',
		'bill_remark',
		'eat_in',
		'eat_in_prepare',
		'multiple_reserve_id',
	];
	protected $dates = [
		'reserve_date',
		'payment_limit',
		'bill_created_at',
		'bill_pay_limit',
		'luggage_arrive'
	];
	//formatで使用できるようにするため 参考https://readouble.com/laravel/6.x/ja/eloquent-mutators.html


	// | 顧客との一対多
	public function user()
	{
		return $this->belongsTo(User::class)->withTrashed();
	}

	// | 会場との一対多
	public function venue()
	{
		return $this->belongsTo(Venue::class);
	}

	// | Billsとの一対多
	public function bills()
	{
		return $this->hasMany(Bill::class);
	}
	// | Billsを経由してbreakdowns
	public function breakdowns()
	{
		return $this->hasManyThrough(
			'App\Models\Breakdown',
			'App\Models\Bill',
		);
	}

	// | 仲介会社との一対多
	public function agent()
	{
		return $this->belongsTo(Agent::class);
	}

	// cxl一対多
	public function cxls()
	{
		return $this->hasMany(Cxl::Class);
	}

	public function endusers()
	{
		return $this->hasOne(Enduser::Class);
	}

	public function change_log()
	{
		return $this->hasOne('App\Models\ChangeLog');
	}

	// bills 削除用
	protected static function boot()
	{
		parent::boot();
		static::deleting(function ($model) {
			foreach ($model->bills()->get() as $child) {
				$child->delete();
			}
			foreach ($model->endusers()->get() as $child2) {
				$child2->delete();
			}
		});
	}

	public function addAllBills()
	{
		$bills = $this->bills()->get();
		$result_subtotal = 0;
		foreach ($$bills as $key => $value) {
			$result_subtotal += $value->sub_total;
		}
		return $result_subtotal;
	}

	public function getFormatReserveDateAttribute()
	{
		$weekday = date('w', strtotime($this->reserve_date));
		if ($weekday == 0) {
			$weekday = "日";
		} elseif ($weekday == 1) {
			$weekday = "月";
		} elseif ($weekday == 2) {
			$weekday = "火";
		} elseif ($weekday == 3) {
			$weekday = "水";
		} elseif ($weekday == 4) {
			$weekday = "木";
		} elseif ($weekday == 5) {
			$weekday = "金";
		} elseif ($weekday == 6) {
			$weekday = "土";
		}
		return date('Y/m/d', strtotime($this->reserve_date)) . '(' . $weekday . ')';
	}


	//  管理者予約保存
	public function ReservationStore($data)
	{
		$chkReservation = ($this->checkReservationsTransaction($data['reserve_date'], $data['enter_time'], $data['leave_time'], $data['venue_id']));
		$chkPreReservation = ($this->checkPreReservationsTransaction($data['reserve_date'], $data['enter_time'], $data['leave_time'], $data['venue_id']));
		if (!$chkReservation || !$chkPreReservation) {
			return "重複";
		}
		$result = $this->create([
			'venue_id' => $data['venue_id'],
			'user_id' => !empty($data['user_id']) ? $data['user_id'] : 0,
			'agent_id' => !empty($data['agent_id']) ? $data['agent_id'] : 0,
			'reserve_date' => $data['reserve_date'],
			'price_system' => $data['price_system'],
			'enter_time' => $data['enter_time'],
			'leave_time' => $data['leave_time'],
			'board_flag' => $data['board_flag'],
			'event_start' => $data['event_start'] ?? "",
			'event_finish' => $data['event_finish'] ?? "",
			'event_name1' => !empty($data['event_name1'])&&!empty($data['board_flag'])?$data['event_name1']: NULL,
			'event_name2' => !empty($data['event_name2'])&&!empty($data['board_flag'])?$data['event_name2']: NULL,
			'event_owner' => !empty($data['event_owner'])&&!empty($data['board_flag'])?$data['event_owner']: NULL,
			'luggage_flag' => !empty($data['luggage_flag']) ? $data['luggage_flag'] : 0,
			'luggage_price' => !empty($data['luggage_price']) ? $data['luggage_price'] : 0,
			'luggage_count' => !empty($data['luggage_count']) ? $data['luggage_count'] : 0,
			'luggage_arrive' => !empty($data['luggage_arrive']) ? $data['luggage_arrive'] : NULL,
			'luggage_return' => !empty($data['luggage_return']) ? $data['luggage_return'] : NULL,
			'email_flag' => $data['email_flag'],
			'in_charge' => $data['in_charge'],
			'tel' => !empty($data['tel']) ? $data['tel'] : "",
			'cost' => !empty($data['cost']) ? $data['cost'] : 0,
			'discount_condition' => !empty($data['discount_condition']) ? $data['discount_condition'] : NULL,
			'attention' => !empty($data['attention']) ? $data['attention'] : NULL,
			'user_details' => !empty($data['user_details']) ? $data['user_details'] : NULL,
			'admin_details' => !empty($data['admin_details']) ? $data['admin_details'] : NULL,
			'eat_in' => !empty($data['eat_in']) ? $data['eat_in'] : 0,
			'eat_in_prepare' => !empty($data['eat_in_prepare']) ? $data['eat_in_prepare'] : 0,
			'multiple_reserve_id' => !empty($data['multiple_reserve_id']) ? $data['multiple_reserve_id'] : 0,
		]);
		return $result;
	}

	public function ReservationUpdate($data)
	{
		$chkReservation = ($this->checkReservationsTransaction($data['reserve_date'], $data['enter_time'], $data['leave_time'], $data['venue_id'], $data['reservation_id']));
		$chkPreReservation = ($this->checkPreReservationsTransaction($data['reserve_date'], $data['enter_time'], $data['leave_time'], $data['venue_id']));
		if (!$chkReservation || !$chkPreReservation) {
			return "重複";
		}
		$this->update([
			'venue_id' => $data['venue_id'],
			'user_id' => !empty($data['user_id']) ? $data['user_id'] : 0,
			'agent_id' => !empty($data['agent_id']) ? $data['agent_id'] : 0,
			'reserve_date' => $data['reserve_date'],
			'price_system' => $data['price_system'],
			'enter_time' => $data['enter_time'],
			'leave_time' => $data['leave_time'],
			'board_flag' => $data['board_flag'],
			'event_start' => !empty($data['event_start']) ? $data['event_start'] : "",
			'event_finish' => !empty($data['event_finish']) ? $data['event_finish'] : "",
			'event_name1' => !empty($data['event_name1'])&&!empty($data['board_flag']) ? $data['event_name1'] : "",
			'event_name2' => !empty($data['event_name2'])&&!empty($data['board_flag']) ? $data['event_name2'] : "",
			'event_owner' => !empty($data['event_owner'])&&!empty($data['board_flag']) ? $data['event_owner'] : "",
			'luggage_flag' => !empty($data['luggage_flag']) ? $data['luggage_flag'] : 0,
			'luggage_price' => !empty($data['luggage_price']) ? $data['luggage_price'] : 0,
			'luggage_count' => !empty($data['luggage_count']) ? $data['luggage_count'] : 0,
			'luggage_arrive' => !empty($data['luggage_arrive']) ? $data['luggage_arrive'] : NULL,
			'luggage_return' => !empty($data['luggage_return']) ? $data['luggage_return'] : NULL,
			'email_flag' => !empty($data['email_flag']) ? $data['email_flag'] : 1,
			'in_charge' => !empty($data['in_charge']) ? $data['in_charge'] : "",
			'tel' => !empty($data['tel']) ? $data['tel'] : "",
			'cost' => !empty($data['cost']) ? $data['cost'] : 0,
			'discount_condition' => !empty($data['discount_condition']) ? $data['discount_condition'] : NULL,
			'attention' => !empty($data['attention']) ? $data['attention'] : NULL,
			'admin_details' => !empty($data['admin_details']) ? $data['admin_details'] : NULL,      'eat_in' => !empty($data['eat_in']) ? $data['eat_in'] : 0,
			'eat_in_prepare' => !empty($data['eat_in_prepare']) ? $data['eat_in_prepare'] :  0,
			'multiple_reserve_id' => !empty($data['multiple_reserve_id']) ? $data['multiple_reserve_id'] : 0,
		]);
		return $this;
	}

	public function CreateEndUser($request)
	{
		if (
			!empty($request->enduser_company) ||
			!empty($request->enduser_incharge) ||
			!empty($request->enduser_address) ||
			!empty($request->enduser_tel) ||
			!empty($request->enduser_mail) ||
			!empty($request->enduser_attr) ||
			!empty($request->end_user_charge) ||
			!empty($request->enduser_mobile)
		) {
			DB::transaction(function () use ($request) {
				$this->enduser()->create([
					'reservation_id' => $this->id,
					'company' => $request->enduser_company,
					'person' => $request->enduser_incharge,
					'address' => $request->enduser_address,
					'tel' => $request->enduser_tel,
					'email' => $request->enduser_mail,
					'attr' => $request->enduser_attr,
					'charge' => $request->end_user_charge,
					'mobile' => $request->enduser_mobile,
				]);
			});
		}
	}

	// 仲介会社選択の場合のみ、エンドユーザーとの一対一

	public function enduser()
	{
		return $this->hasOne(Enduser::class);
	}

	public function SearchReservation($data)
	{
		$id = null;
		$searchTarget = $this->ReservationSearchTarget();

		if (!empty($data['multiple_id']) ) 
		{		
			$id = abs($data['multiple_id']);
			// $searchTarget->whereRaw('reservations.multiple_reserve_id LIKE ? ', ['%' . $id . '%']);
			$searchTarget->whereRaw('reservations.multiple_reserve_id LIKE ? ',  ['%' . $id . '%']);
		}

		if (!empty($data['search_id']) && (int)$data['search_id'] > 0) {
			for ($i = 0; $i < strlen($data['search_id']); $i++) {
				if ((int)$data['search_id'][$i] !== 0) {
					$id = substr($data['search_id'], $i, strlen($data['search_id']));
					break;
				}
			}
			$searchTarget->whereRaw('reservations.id LIKE ? ',  ['%' . $id . '%']);
		}

		if (!empty($data['user_id']) && (int)$data['user_id'] > 0) {
			for ($i = 0; $i < strlen($data['user_id']); $i++) {
				if ((int)$data['user_id'][$i] !== 0) {
					$id = strstr($data['user_id'], $data['user_id'][$i]);
					break;
				}
			}
			$searchTarget->whereRaw('users.id = ?', [$id]);
		}

		if (!empty($data['reserve_date'])) {
			$targetData = explode(" ~ ", $data['reserve_date']);
			$searchTarget->whereRaw('reservations.reserve_date between ? AND ? ',  $targetData);
		}

		if (!empty($data['enter_time'])) {
			$searchTarget->whereRaw('reservations.enter_time >= ? ',  $data['enter_time']);
		}

		if (!empty($data['leave_time'])) {
			$searchTarget->whereRaw('reservations.leave_time <= ? ',  $data['leave_time']);
		}

		if (!empty($data['venue_id'])) {
			$searchTarget->whereRaw('reservations.venue_id = ? ',  [$data['venue_id']]);
		}

		if (!empty($data['company'])) {
			$searchTarget->whereRaw('users.company LIKE ? ',  ['%' . $data['company'] . '%']);
		}

		if (!empty($data['person_name'])) {
			$searchTarget->whereRaw('concat(users.first_name,users.last_name) LIKE ? ',  ['%' . $data['person_name'] . '%']);
		}

		if (!empty($data['search_mobile'])) {
			$searchTarget->whereRaw('users.mobile LIKE ? ',  ['%' . $data['search_mobile'] . '%']);
		}

		if (!empty($data['search_tel'])) {
			$searchTarget->whereRaw('users.tel LIKE ? ',  ['%' . $data['search_tel'] . '%']);
		}

		if (!empty($data['agent'])) {
			$searchTarget->whereRaw('agents.id = ? ',  [$data['agent']]);
		}

		if (!empty($data['enduser_person'])) {
			$searchTarget->whereRaw('endusers.company LIKE ? ',  ['%' . $data['enduser_person'] . '%']);
		}

		if (!empty($data['sogaku'])) {
			$searchTarget->whereRaw('sogaku = ?', [$data['sogaku']]);
		}

		if (!empty($data['payment_limit'])) {
			$date = explode(' ~ ', $data['payment_limit']);
			$searchTarget = $searchTarget->where(function ($query) use ($date) {
				$query->orWhereIn('reservations.id', DB::table('bills')->select(DB::raw('reservation_id'))->whereRaw('payment_limit between ? and ?', $date)->groupBy('reservation_id'))
					->orWhereIn('reservations.id', DB::table('cxls')->select(DB::raw('reservation_id'))->whereRaw('payment_limit between ? and ?', $date)->groupBy('reservation_id'));
			});
		}

		if (!empty($data['pay_day'])) {
			$date = explode(' ~ ', $data['pay_day']);
			$searchTarget = $searchTarget->where(function ($query) use ($date) {
				$query->orWhereIn('reservations.id', DB::table('bills')->select(DB::raw('reservation_id'))->whereRaw('pay_day between ? and ?', $date)->groupBy('reservation_id'))
					->orWhereIn('reservations.id', DB::table('cxls')->select(DB::raw('reservation_id'))->whereRaw('pay_day between ? and ?', $date)->groupBy('reservation_id'));
			});
		}

		if (!empty($data['pay_person'])) {
			$searchTarget = $searchTarget->where(function ($query) use ($data) {
				$query->orWhereIn('reservations.id', DB::table('bills')->select(DB::raw('reservation_id'))->whereRaw('pay_person LIKE ?', '%' . $data['pay_person'] . '%')->groupBy('reservation_id'))
					->orWhereIn('reservations.id', DB::table('cxls')->select(DB::raw('reservation_id'))->whereRaw('pay_person LIKE ?', '%' . $data['pay_person'] . '%')->groupBy('reservation_id'));
			});
		}

		if (!empty($data['attr'])) {
			$searchTarget->whereRaw('users.attr = ?', [$data['attr']]);
		}

		if (!empty($data['day_before'])) {
			$yesterday = new Carbon('yesterday');
			$searchTarget->whereRaw('reservations.reserve_date = ?', [date('Y-m-d', strtotime($yesterday))]);
		}
		if (!empty($data['today'])) {
			$yesterday = new Carbon('today');
			$searchTarget->whereRaw('reservations.reserve_date = ?', [date('Y-m-d', strtotime($yesterday))]);
		}
		if (!empty($data['day_after'])) {
			$yesterday = new Carbon('tomorrow');
			$searchTarget->whereRaw('reservations.reserve_date = ?', [date('Y-m-d', strtotime($yesterday))]);
		}


		// チェックボックス
		$searchTarget = $searchTarget->where(function ($query) use ($data) {
			if (!empty($data['alliance0'])) {
				$query->orWhereRaw('alliance_flag = ? ', [0]);
			}
			if (!empty($data['alliance1'])) {
				$query->orWhereRaw('alliance_flag = ? ', [1]);
			}
		});

		// アイコン
		if (!empty($data['check_icon1']) && (int)$data['check_icon1'] === 1) {
			$searchTarget->havingRaw('check_unit_2.master_unit_2 >= ? ', [1]);
		}
		if (!empty($data['check_icon2']) && (int)$data['check_icon2'] === 1) {
			$searchTarget->havingRaw('check_unit_3.master_unit_3 >= ? ', [1]);
		}
		if (!empty($data['check_icon3']) && (int)$data['check_icon3'] === 1) {
			$searchTarget->havingRaw('check_unit_4.master_unit_4 >= ? ', [1]);
		}
		if (!empty($data['check_icon4']) && (int)$data['check_icon4'] === 1) {
			$searchTarget->havingRaw('reservations.eat_in = ? ',  [1]);
		}

		// チェックボックス
		$searchTarget = $searchTarget->where(function ($query) use ($data) {
			if (!empty($data['check_status1'])) {
				$query->orWhereRaw('check_status1.status1 >= ? ', [1]);
			}
			if (!empty($data['check_status2'])) {
				$query->orWhereRaw('check_status2.status2 >= ? ', [1]);
			}
			if (!empty($data['check_status3'])) {
				$query->orWhereRaw('check_status3.status3 >= ? ', [1]);
			}
			if (!empty($data['check_status4'])) {
				$query->orWhereRaw('check_status4.status4 >= ? ', [1]);
			}
			if (!empty($data['check_status5'])) {
				$query->orWhereRaw('check_status5.status5 >= ? ', [1]);
			}
			if (!empty($data['check_status6'])) {
				$query->orWhereRaw('check_status6.status6 >= ? ', [1]);
			}
		});

		// チェックボックス 売上区分
		$searchTarget = $searchTarget->where(function ($query) use ($data) {
			if (!empty($data['sales1'])) {
				$query->orWhereIn('reservations.id', DB::table('bills')->select(DB::raw('reservation_id'))->whereRaw('category = ?', [1])->groupBy('reservation_id'));
			}
			if (!empty($data['sales2'])) {
				$query->orWhereIn('reservations.id', DB::table('cxls')->select(DB::raw('reservation_id'))->groupBy('reservation_id'));
			}
			if (!empty($data['sales3'])) {
				$query->orWhereIn('reservations.id', DB::table('bills')->select(DB::raw('reservation_id'))->whereRaw('category = ?', [2])->groupBy('reservation_id'));
			}
		});

		// チェックボックス 入金状況
		$searchTarget = $searchTarget->where(function ($query) use ($data) {
			if (!empty($data['payment_status0'])) {
				$query->orWhereIn('reservations.id', DB::table('bills')->select(DB::raw('reservation_id'))->whereRaw('paid = ?',  [0])->groupBy('reservation_id'))
					->orWhereIn('reservations.id', DB::table('cxls')->select(DB::raw('reservation_id'))->whereRaw('paid = ?', [0])->groupBy('reservation_id'));
			}
			if (!empty($data['payment_status1'])) {
				$query->orWhereIn('reservations.id', DB::table('bills')->select(DB::raw('reservation_id'))->whereRaw('paid = ?',  [1])->groupBy('reservation_id'))
					->orWhereIn('reservations.id', DB::table('cxls')->select(DB::raw('reservation_id'))->whereRaw('paid = ?', [1])->groupBy('reservation_id'));
			}
			if (!empty($data['payment_status2'])) {
				$query->orWhereIn('reservations.id', DB::table('bills')->select(DB::raw('reservation_id'))->whereRaw('paid = ?',  [2])->groupBy('reservation_id'))
					->orWhereIn('reservations.id', DB::table('cxls')->select(DB::raw('reservation_id'))->whereRaw('paid = ?', [2])->groupBy('reservation_id'));
			}
			if (!empty($data['payment_status3'])) {
				$query->orWhereIn('reservations.id', DB::table('bills')->select(DB::raw('reservation_id'))->whereRaw('paid = ?',  [3])->groupBy('reservation_id'))
					->orWhereIn('reservations.id', DB::table('cxls')->select(DB::raw('reservation_id'))->whereRaw('paid = ?', [3])->groupBy('reservation_id'));
			}
			if (!empty($data['payment_status4'])) {
				$query->orWhereIn('reservations.id', DB::table('bills')->select(DB::raw('reservation_id'))->whereRaw('paid = ?',  [4])->groupBy('reservation_id'))
					->orWhereIn('reservations.id', DB::table('cxls')->select(DB::raw('reservation_id'))->whereRaw('paid = ?', [4])->groupBy('reservation_id'));
			}
			if (!empty($data['payment_status5'])) {
				$query->orWhereIn('reservations.id', DB::table('bills')->select(DB::raw('reservation_id'))->whereRaw('paid = ?',  [5])->groupBy('reservation_id'))
					->orWhereIn('reservations.id', DB::table('cxls')->select(DB::raw('reservation_id'))->whereRaw('paid = ?', [5])->groupBy('reservation_id'));
			}
		});

		// 売上請求一覧用のフリーワード検索
		if (!empty($data['sales_search_box'])) {
			if (!empty($data['free_word'])) {
				if (preg_match('/^[0-9!,]+$/', $data['free_word'])) {
					//数字の場合検索
					if ((int)$data['free_word'] !== 0) {
						$searchTarget = $searchTarget->where(function ($query) use ($data) {
							if (!empty($data['free_word'])) {
								$id = null;
								for ($i = 0; $i < strlen($data['free_word']); $i++) {
									if ((int)$data['free_word'][$i] !== 0) {
										$id = substr($data['free_word'], $i, strlen($data['free_word']));
										break;
									}
								}
								$sogaku = str_replace(',', '', $data['free_word']);
								$query->whereRaw('reservations.id LIKE ? ', ['%' . $id . '%']) //予約ID
									->orWhereRaw('reservations.multiple_reserve_id LIKE ? ', ['%' . $id . '%']) //一括ID
									->orWhereRaw('users.id LIKE ? ', ['%' . $id . '%'])
									->orWhereRaw('sogaku_master.sogaku = ? ', $sogaku);
							}
						});
					}
				} elseif (preg_match('/^[0-9!-]+$/', $data['free_word'])) {
					$searchTarget = $searchTarget->where(function ($query) use ($data) {
						if (!empty($data['free_word'])) {
							$query->whereRaw('reservations.reserve_date = ? ', [$data['free_word']])
								->orWhereIn('reservations.id', DB::table('bills')->select(DB::raw('reservation_id'))->whereRaw('payment_limit = ?', $data['free_word'])->groupBy('reservation_id'))
								->orWhereIn('reservations.id', DB::table('cxls')->select(DB::raw('reservation_id'))->whereRaw('payment_limit = ?', $data['free_word'])->groupBy('reservation_id'))
								->orWhereIn('reservations.id', DB::table('bills')->select(DB::raw('reservation_id'))->whereRaw('pay_day = ? ', $data['free_word'])->groupBy('reservation_id'))
								->orWhereIn('reservations.id', DB::table('cxls')->select(DB::raw('reservation_id'))->whereRaw('pay_day = ? ', $data['free_word'])->groupBy('reservation_id'));
						}
					});
				} elseif (preg_match('/^[一般企業]+$/', $data['free_word'])) {
					$searchTarget = $searchTarget->where(function ($query) use ($data) {
						$query->whereRaw('users.attr = ? ', [1]);
					});
				} elseif (preg_match('/^[上場企業]+$/', $data['free_word'])) {
					$searchTarget = $searchTarget->where(function ($query) use ($data) {
						$query->whereRaw('users.attr = ? ', [2]);
					});
				} elseif (preg_match('/^[近隣利用]+$/', $data['free_word'])) {
					$searchTarget = $searchTarget->where(function ($query) use ($data) {
						$query->whereRaw('users.attr = ? ', [3]);
					});
				} elseif (preg_match('/^[個人講師]+$/', $data['free_word'])) {
					$searchTarget = $searchTarget->where(function ($query) use ($data) {
						$query->whereRaw('users.attr = ? ', [4]);
					});
				} elseif (preg_match('/^[MLM]+$/', $data['free_word'])) {
					$searchTarget = $searchTarget->where(function ($query) use ($data) {
						$query->whereRaw('users.attr = ? ', [5]);
					});
				} elseif (preg_match('/^[その他]+$/', $data['free_word'])) {
					$searchTarget = $searchTarget->where(function ($query) use ($data) {
						$query->whereRaw('users.attr = ? ', [6]);
					});
				} else {
					//文字列の場合
					$searchTarget = $searchTarget->where(function ($query) use ($data) {
						if (!empty($data['free_word'])) {
							$query->whereRaw('concat(venues.name_area,venues.name_bldg,venues.name_venue) LIKE ? ', ['%' . $data['free_word'] . '%'])
								->orWhereRaw('users.company LIKE ?', ['%' . $data['free_word'] . '%'])
								->orWhereRaw('concat(users.first_name, users.last_name) LIKE ?', ['%' . $data['free_word'] . '%'])
								->orWhereRaw('agents.name LIKE ?', ['%' . $data['free_word'] . '%'])
								->orWhereRaw('endusers.company LIKE ?', ['%' . $data['free_word'] . '%'])
								->orWhereIn('reservations.id', DB::table('bills')->select(DB::raw('reservation_id'))->whereRaw('pay_person LIKE ?', '%' . $data['free_word'] . '%')->groupBy('reservation_id'))
								->orWhereIn('reservations.id', DB::table('cxls')->select(DB::raw('reservation_id'))->whereRaw('pay_person LIKE ?', '%' . $data['free_word'] . '%')->groupBy('reservation_id'));
						}
					});
				}
			}
		} else {
			// 予約一覧用フリーワード検索
			if (!empty($data['free_word'])) {
				if (preg_match('/^[0-9!,]+$/', $data['free_word'])) {
					//数字の場合検索
					if ((int)$data['free_word'] !== 0) {
						
						$searchTarget = $searchTarget->where(function ($query) use ($data) {
							if (!empty($data['free_word'])) {
								$id=null;
								for ($i = 0; $i < strlen($data['free_word']); $i++) {
									if ((int)$data['free_word'][$i] !== 0) {
										$id = substr($data['free_word'], $i, strlen($data['free_word']));
										break;
									}
								}
								$query->whereRaw('reservations.id LIKE ? ', ['%' . $id . '%']) //予約ID
									->orWhereRaw('reservations.multiple_reserve_id LIKE ? ', ['%' . $id . '%']) //一括ID
									->orWhereRaw('users.mobile LIKE ? ', ['%' . $data['free_word'] . '%'])
									->orWhereRaw('users.tel LIKE ? ', ['%' . $data['free_word'] . '%']);
							}
						});
					}
				} elseif (preg_match('/^[0-9!-]+$/', $data['free_word'])) {
					$searchTarget = $searchTarget->where(function ($query) use ($data) {
						if (!empty($data['free_word'])) {
							$query->whereRaw('reservations.reserve_date = ? ', [$data['free_word']]);
						}
					});
				} elseif (preg_match('/^[0-9!:]+$/', $data['free_word'])) {
					// 時間がきた際
					$searchTarget = $searchTarget->where(function ($query) use ($data) {
						if (!empty($data['free_word'])) {
							$query->whereRaw('reservations.enter_time = ? ', [$data['free_word'] . ':00'])
								->orWhereRaw('reservations.leave_time = ? ', [$data['free_word'] . ':00']);
						}
					});
				} else {
					//文字列の場合
					$searchTarget = $searchTarget->where(function ($query) use ($data) {
						if (!empty($data['free_word'])) {
							$query->whereRaw('users.company LIKE ? ', ['%' . $data['free_word'] . '%']) //会社名・団体名
								->orWhereRaw('concat(users.first_name,users.last_name) LIKE ? ',  ['%' . $data['free_word'] . '%']) //担当者氏名
								->orWhereRaw('agents.name LIKE ? ', ['%' . $data['free_word'] . '%']) //仲介会社名
								->orWhereRaw('concat(venues.name_area,venues.name_bldg,venues.name_venue) LIKE ? ', ['%' . $data['free_word'] . '%'])
								->orWhereRaw('endusers.company LIKE ? ',  ['%' . $data['free_word'] . '%']); //エンドユーザー
						}
					});
				}
			}
		}
		return $searchTarget;
	}

	/**   
	 * 予約一覧の検索対象マスタ
	 * @return object collectionで返る
	 */
	public function ReservationSearchTarget()
	{
		$searchTarget = DB::table('reservations')
			->select(DB::raw(
				'
        distinct reservations.id as reservation_id,
      reservations.multiple_reserve_id as multiple_reserve_id,
      reservations.reserve_date as reserve_date,
      reservations.enter_time as enter_time,
      reservations.leave_time as leave_time,
      reservations.board_flag as board_flag,
      reservations.venue_id as venue_id,
      reservations.eat_in as eat_in,
      concat(venues.name_area,"・",venues.name_bldg,venues.name_venue) as venue_name, 
      venues.alliance_flag as alliance_flag,
      users.company as company_name,
      concat(users.first_name, users.last_name) as user_name, 
      users.mobile as mobile,
      users.tel as tel,
      users.attr as attr,
      users.attention as attention,
      users.id as user_id,
      agents.name as agent_name,
      agents.id as agent_id,
      endusers.company as enduser_company,
      case when bills.reservation_status <= 3 then 0 else 1 end as 予約中かキャンセルか,
      case when reservations.reserve_date >= CURRENT_DATE then 0 else 1 end as 今日以降かどうか,
      case when reservations.reserve_date >= CURRENT_DATE then reserve_date end as 今日以降日付,
      case when reservations.reserve_date < CURRENT_DATE then reserve_date end as 今日未満日付,
      check_unit_2.master_unit_2 as unit_type2,
      check_unit_3.master_unit_3 as unit_type3,
      check_unit_4.master_unit_4 as unit_type4,
      check_status1.status1 as reservation_status1,
      check_status2.status2 as reservation_status2,
      check_status3.status3 as reservation_status3,
      check_status4.status4 as reservation_status4,
      check_status5.status5 as reservation_status5,
      check_status6.status6 as reservation_status6,
      case when cxls.id > 0 then cxls.master_total when cxls.id is null then sogaku_master.sogaku end as sogaku,
      cxls.id
      '
			))
			->leftJoin('bills', 'reservations.id', '=', 'bills.reservation_id')
			->leftJoin('users', 'reservations.user_id', '=', 'users.id')
			->leftJoin('agents', 'reservations.agent_id', '=', 'agents.id')
			->leftJoin('endusers', 'reservations.id', '=', 'endusers.reservation_id')
			->leftJoin('venues', 'reservations.venue_id', '=', 'venues.id')
			->leftJoin('cxls', 'reservations.id', '=', 'cxls.reservation_id')
			->leftJoin(DB::raw('(select reservation_id , count(breakdowns.count_unit) as master_unit_2  from bills left join (select bill_id, count(unit_type) as count_unit from breakdowns where unit_type=2 group by bill_id) as breakdowns on bills.id=breakdowns.bill_id group by reservation_id) as check_unit_2'), 'reservations.id', '=', 'check_unit_2.reservation_id')
			->leftJoin(DB::raw('(select reservation_id , count(breakdowns.count_unit) as master_unit_3  from bills left join (select bill_id, count(unit_type) as count_unit from breakdowns where unit_type=3 group by bill_id) as breakdowns on bills.id=breakdowns.bill_id group by reservation_id) as check_unit_3'), 'reservations.id', '=', 'check_unit_3.reservation_id')
			->leftJoin(DB::raw('(select reservation_id , count(breakdowns.count_unit) as master_unit_4  from bills left join (select bill_id, count(unit_type) as count_unit from breakdowns where unit_type=4 group by bill_id) as breakdowns on bills.id=breakdowns.bill_id group by reservation_id) as check_unit_4'), 'reservations.id', '=', 'check_unit_4.reservation_id')
			->leftJoin(DB::raw('(select reservation_id, count(reservation_status) as status1 from bills where reservation_status = 1  group by reservation_id) as check_status1'), 'reservations.id', '=', 'check_status1.reservation_id')
			->leftJoin(DB::raw('(select reservation_id, count(reservation_status) as status2 from bills where reservation_status = 2  group by reservation_id) as check_status2'), 'reservations.id', '=', 'check_status2.reservation_id')
			->leftJoin(DB::raw('(select reservation_id, count(reservation_status) as status3 from bills where reservation_status = 3  group by reservation_id) as check_status3'), 'reservations.id', '=', 'check_status3.reservation_id')
			->leftJoin(DB::raw('(select reservation_id, count(reservation_status) as status4 from bills where reservation_status = 4  group by reservation_id) as check_status4'), 'reservations.id', '=', 'check_status4.reservation_id')
			->leftJoin(DB::raw('(select reservation_id, count(reservation_status) as status5 from bills where reservation_status = 5  group by reservation_id) as check_status5'), 'reservations.id', '=', 'check_status5.reservation_id')
			->leftJoin(DB::raw('(select reservation_id, count(reservation_status) as status6 from bills where reservation_status = 6  group by reservation_id) as check_status6'), 'reservations.id', '=', 'check_status6.reservation_id')
			->leftJoin(DB::raw('(select reservation_id, sum(master_total) as sogaku from bills group by reservation_id) as sogaku_master'), 'reservations.id', '=', 'sogaku_master.reservation_id')
			->whereRaw('reservations.deleted_at is null');

		return $searchTarget;
	}

	// reservations show 各請求書合計額
	public function TotalAmount()
	{
		$venues_master = 0;
		$items_master = 0;
		$layouts_master = 0;
		$others_master = 0;
		$master_subtotals = 0;
		$master_taxs = 0;
		$master_totals = 0;
		foreach ($this->bills->where('reservation_status', '<', 4) as $key => $value) {
			$venues_master += $value->venue_price;
			$items_master += $value->equipment_price;
			$layouts_master += $value->layout_price;
			$others_master += $value->others_price;
			$master_subtotals += $value->master_subtotal;
			$master_taxs += $value->master_tax;
			$master_totals += $value->master_total;
		}
		$all_master_subtotal = $venues_master + $items_master + $layouts_master + $others_master;
		return [
			$venues_master,
			$items_master,
			$layouts_master,
			$others_master,
			$all_master_subtotal
		];
	}

	public function checkBillsStatus()
	{
		$collection = $this->bills->pluck('reservation_status');
		foreach ($collection as $key => $value) {
			if ($value < 3) {
				//ステータスが予約完了もしくはキャンセル完了していないキャンセルプロセスがあれば
				return 0;
				break;
			} elseif ($value > 3 && $value < 6) {
				return 0;
				break;
			}
		}
		return 1;
	}
	public function checkSingleBillsStatus()
	{
		$collection = $this->bills->pluck('reservation_status');
		foreach ($collection as $key => $value) {
			if ($value > 3 && $value != 6) {
				//ステータスが予約完了もしくはキャンセル完了していないキャンセルプロセスがあれば
				return 0;
				break;
			}
		}
		return 1;
	}

	public function pluckSum($array, $targetStatus)
	{
		$result = [];
		foreach ($array as $key => $value) {
			$result[] = $this->bills->where("reservation_status", $targetStatus)->pluck($value)->sum(); //予約ステータス3（予約完了）のみが対象
		}
		return $result;
	}

	public function UpdateAgentEndUser($inputs)
	{
		$this->enduser()->delete();
		if (
			!empty($inputs['enduser_company']) ||
			!empty($inputs['enduser_incharge']) ||
			!empty($inputs['enduser_address']) ||
			!empty($inputs['enduser_tel']) ||
			!empty($inputs['enduser_mail']) ||
			!empty($inputs['enduser_attr']) ||
			!empty($inputs['end_user_charge']) ||
			!empty($inputs['enduser_mobile'])
		) {
			DB::transaction(function () use ($inputs) {
				$this->enduser()->create([
					'reservation_id' => $this->id,
					'company' => $inputs['enduser_company'],
					'person' => $inputs['enduser_incharge'],
					'address' => $inputs['enduser_address'],
					'tel' => $inputs['enduser_tel'],
					'email' => $inputs['enduser_mail'],
					'attr' => $inputs['enduser_attr'],
					'charge' => $inputs['end_user_charge'],
					'mobile' => $inputs['enduser_mobile'],
				]);
			});
		}
	}

	public function totalAmountWithCxl()
	{
		$subtotal = $this->bills->where('reservation_status', '<=', 3)->pluck('master_total')->sum();
		$cxl = $this->cxls->pluck('master_total')->sum();
		return $subtotal + $cxl;
	}

	public function ReservationEmailTemplate($id)
	{
		$result = DB::table('reservations')
			->select(DB::raw(
				"
        LPAD(reservations.id,6,0) as reservation_id,
        users.company as company,
        users.email as user_email,
        LPAD(reservations.user_id,6,0) as user_id,
        reservations.id as reservation_id_original,
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
        concat(users.first_name, users.last_name) as person_name,
        venues.smg_url as smg_url,
        reservations.in_charge as in_charge,
        reservations.tel as tel,
        reservations.price_system as price_system,
        reservations.board_flag as board_flag,
        time_format(reservations.event_start, '%H:%i') as event_start,
        time_format(reservations.event_finish, '%H:%i') as event_finish,
        reservations.event_name1 as event_name1,
        reservations.event_name2 as event_name2,
        reservations.event_owner as event_owner,
        reservations.eat_in as eat_in,
        reservations.eat_in_prepare as eat_in_prepare,
        reservations.luggage_flag as luggage_flag,
        reservations.luggage_price as luggage_price,
        reservations.luggage_count as luggage_count,
        concat(date_format(reservations.luggage_arrive, '%Y/%m/%d'),
        case 
        when DAYOFWEEK(reservations.luggage_arrive) = 1 then '(日)' 
        when DAYOFWEEK(reservations.luggage_arrive) = 2 then '(月)'
        when DAYOFWEEK(reservations.luggage_arrive) = 3 then '(火)'
        when DAYOFWEEK(reservations.luggage_arrive) = 4 then '(水)'
        when DAYOFWEEK(reservations.luggage_arrive) = 5 then '(木)'
        when DAYOFWEEK(reservations.luggage_arrive) = 6 then '(金)'
        when DAYOFWEEK(reservations.luggage_arrive) = 7 then '(土)'
        end
        ) as luggage_arrive,
        reservations.luggage_return as luggage_return,
        reservations.user_details as user_details,
		reservations.admin_details as admin_details
        "
			))
			->leftJoin('venues', 'reservations.venue_id', '=', 'venues.id')
			->leftJoin('users', 'reservations.user_id', '=', 'users.id')
			->whereRaw('reservations.deleted_at is NULL')
			->whereRaw('reservations.id = ?', [$id]);

		return $result->first();
	}
}
